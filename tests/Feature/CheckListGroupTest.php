<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckListGroupTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        $admin = $this->admin();
        $this->actingAs($admin);
    }
    
    public function test_create()
    {
        $response = $this->get("/admin/check_list_groups/create");
        $response->assertSeeText("Create Check List Group");
        $response->assertSeeText("Name");
        $response->assertSeeText("Description");
        $response->assertSeeText("Save");
    }

    public function test_store_valid()
    {
        // Arange
        $params = [
            'id' => 1,
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ];
        $this->post('/admin/check_list_groups', $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-success')
            ->assertRedirect("/admin/check_list_groups/{$params['id']}/edit");
        $this->assertEquals(session('alert-success'), 'CheckListGroup Created');
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);
    }

    public function test_store_fail()
    {
        $params = [
            'name' => '',
            'description' => ''
        ];
        $this->post('/admin/check_list_groups', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['name'][0], 'The name field is required.');
        $this->assertEquals($messages['description'][0], 'The description field is required.');
    }

    public function test_edit()
    {
        $group = $this->createDummyCheckListGroup();
        // assert
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
        $response = $this->get("/admin/check_list_groups/{$group->id}/edit");
        $response->assertSeeText('Edit Check List Group');
        $response->assertSeeText('Name');
        $response->assertSeeText('Check List Group Description');
        $response->assertSeeText('Update');
        $response->assertSeeText('Lorem ipsum.');
        $response->assertSeeText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.');
        $response->assertSeeText('Delete This Checklist Group');
    }

    public function test_update_valid()
    {
        $group = $this->createDummyCheckListGroup();
        // assert
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
        $params = [
            'name' => 'Update Lorem ipsum.',
            'description' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ];
        $this->put("/admin/check_list_groups/{$group->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-warning')
            ->assertRedirect("/admin/check_list_groups/{$group->id}/edit");

        $this->assertEquals(session('alert-warning'), 'CheckListGroup Updated');
        $this->assertDatabaseMissing('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Update Lorem ipsum.',
            'description' => 'Update Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
    }

    public function test_delete()
    {
        $group = $this->createDummyCheckListGroup();
        // assert
        $this->assertDatabaseHas('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
        $this->delete("/admin/check_list_groups/{$group->id}")
            ->assertStatus(302)
            ->assertSessionHas('alert-info')
            ->assertRedirect("/admin/check_list_groups/create");
        $this->assertEquals(session('alert-info'), 'CheckListGroup Deleted');
        // physique delete
        // $this->assertDatabaseMissing('check_list_groups', [
            // 'name' => 'Lorem ipsum.',
            // 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        // ]);

        // soft delete
        $this->assertSoftDeleted('check_list_groups', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
    }
}
