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

    public function test_admin_store_check_list_group()
    {
        $admin = $this->admin();
        $this->actingAs($admin);
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
        $admin = $this->admin();
        $this->actingAs($admin);
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
        $admin = $this->admin();
        $this->actingAs($admin);
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
    }
}
