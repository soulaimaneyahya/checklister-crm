<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CheckList;
use App\Services\MenuService;
use App\Models\CheckListGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCheckListTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        $admin = $this->admin();
        $this->actingAs($admin);
    }

    public function test_admin_store_check_list_group()
    {
        // Arange
        $params = [
            'id' => 1,
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ];
        $this->post('/admin/check_list_groups', $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-success')
            ->assertRedirect("/admin/check_list_groups/{$params['id']}/edit");
        $this->assertEquals(session('alert-success'), 'CheckListGroup Created');
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
    }

    public function test_admin_update_check_list_group()
    {
        // Arange
        $group = $this->createDummyCheckListGroup();
        $params = [
            'name' => 'Update Lorem ipsum.',
            'description' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ];
        $this->put("/admin/check_list_groups/{$group->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-warning')
            ->assertRedirect("/admin/check_list_groups/{$group->id}/edit");
        $this->assertEquals(session('alert-warning'), 'CheckListGroup Updated');
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Update Lorem ipsum.',
            'description' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
    }

    public function test_admin_generate_pages()
    {
        // Arange
        $group = $this->createDummyCheckListGroup();
        $CheckListGroup = CheckListGroup::where('name', $group->name)->first();
        $this->assertNotNull($CheckListGroup);
        //======
        $lists = CheckList::factory(5)->create([
            'check_list_group_id' => $group->id
        ]);
        $response = $this->get("/welcome");        
        $menu = (new MenuService())->get_menu();
        $this->assertEquals(1, $menu['admin_menu']->where('name', 'Lorem ipsum.')->count());

        foreach ($menu['admin_menu'] as $menu) {
            $this->assertEquals(5, $menu['checklists']->where('check_list_group_id', $group->id)->count());
            foreach ($menu['checklists'] as $value) {
                $response->assertSeeText($value['name']);
            }
        }

        // deleting checklist group
        $this->delete("/admin/check_list_groups/{$group->id}")
            ->assertStatus(302)
            ->assertSessionHas('alert-info')
            ->assertRedirect("/admin/check_list_groups/create");
        $this->assertEquals(session('alert-info'), 'CheckListGroup Deleted');

        $menu = (new MenuService())->get_menu();
        $this->assertEquals(0, $menu['admin_menu']->where('name', 'Lorem ipsum.')->count());
        $CheckListGroup = CheckListGroup::where('name', $group->name)->first();
        $this->assertNull($CheckListGroup);

        $this->assertSoftDeleted('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);

    }

    public function test_manage_checklists()
    {
        $group = $this->createDummyCheckListGroup();

        $checklist_url = "/admin/check_list_groups/{$group->id}/check_lists";

        // Test Creating the checklist
        $params = [
            'id' => 1,
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ];
        $this->get($checklist_url . "/create")
            ->assertStatus(200);
        $response = $this->post($checklist_url, $params);
        $response->assertRedirect("/admin/check_list_groups/{$group->id}/check_lists/{$params['id']}/edit");

        $list = CheckList::where('check_list_group_id', $group->id)->first();
        $this->assertNotNull($list);
        
        $menu = (new MenuService())->get_menu();
        // let's assert $list belongs to menu
        /* contains() method checks whether Laravel Collections contains certain given value or not */
        $this->assertTrue($menu['admin_menu']->first()->checklists->contains($list));
    }
}
