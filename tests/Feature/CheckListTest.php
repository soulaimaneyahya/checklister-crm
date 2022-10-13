<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test home.
     *
     * @return void
     */
    public function test_home()
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        
        $response = $this->get('/welcome');
        $response->assertStatus(200);
    }
    public function test_delete()
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        
        $group = $this->createDummyCheckListGroup();

        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        // assert
        $this->assertDatabaseHas('check_lists', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet.'
        ]);
        $this->delete("/admin/check_list_groups/{$group->id}/check_lists/{$list->id}")
            ->assertStatus(302)
            ->assertSessionHas('alert-info')
            ->assertRedirect("/admin/check_list_groups/{$group->id}/edit");
        $this->assertEquals(session('alert-info'), 'CheckList Deleted');
        // physique delete
        // $this->assertDatabaseMissing('check_lists', [
            // 'name' => 'Lorem ipsum.',
            // 'description' => 'Lorem ipsum dolor sit amet.'
        // ]);

        // soft delete
        $this->assertSoftDeleted('check_lists', [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet.'
        ]);
    }
}
