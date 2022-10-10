<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_tasks()
    {
        $user = $this->user();
        $this->actingAs($user);
        
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        $task = $this->createDummyTask();
        $task->check_list_id = $list->id;
        $task->save();
        // assert
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task ipsum.',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);
    }

    public function test_store_valid()
    {
        $user = $this->user();
        $this->actingAs($user);
        
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();
        // Arange
        $params = [
            'id' => 1,
            'check_list_id' => $list->id,
            'name' => 'Task ipsum.',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ];
        $this->post("/admin/check_lists/{$list->id}/tasks", $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-success')
            ->assertRedirect("/admin/check_lists/{$list->id}/tasks/{$params['id']}/edit");
        $this->assertEquals(session('alert-success'), 'Task Created');
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task ipsum.',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);
    }
}
