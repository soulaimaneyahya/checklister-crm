<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;
use App\Models\CheckList;
use App\Models\CheckListGroup;
use App\Http\Livewire\TasksTable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        $admin = $this->admin();
        $this->actingAs($admin);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_tasks()
    {
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
        $task_url = "/admin/check_lists/{$list->id}/tasks";

        $this->post($task_url, $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-success')
            ->assertRedirect($task_url . "/{$params['id']}/edit");
        $this->assertEquals(session('alert-success'), 'Task Created');
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task ipsum.',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);

        $task = Task::where('check_list_id', $list->id)->whereKey($params['id'])->first();
        $this->assertNotNull($task);
        $this->assertEquals(1, $task->position);

        $this->put($task_url . "/{$params['id']}", [
            'name' => 'Updated-task',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ])
            ->assertStatus(302)
            ->assertSessionHas('alert-warning')
            ->assertRedirect($task_url . "/{$params['id']}/edit");
        $this->assertEquals(session('alert-warning'), 'Task Updated');
        $this->assertDatabaseHas('tasks', [
            'name' => 'Updated-task',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);
    }

    public function test_task_delete()
    {   
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();
        // Arange
        $task1 = $this->createDummyTask();
        $task1->check_list_id = $list->id;
        $task1->position = 1;
        $task1->save();

        $task2 = $this->createDummyTask();
        $task2->check_list_id = $list->id;
        $task2->position = 2;
        $task2->save();

        $this->delete("/admin/check_lists/{$list->id}/tasks/{$task1->id}")
            ->assertStatus(302)
            ->assertSessionHas('alert-info')
            ->assertRedirect("/admin/check_list_groups/{$group->id}/check_lists/{$list->id}/edit");

        $this->assertEquals(session('alert-info'), 'Task Deleted');
        
        $this->assertSoftDeleted('tasks', [
            'name' => 'Task ipsum.',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);
        $task = Task::withTrashed()->find($task1->id);
        $this->assertNotNull($task);
        $this->assertEquals(1, $task->position);
        
        // separate
        $task = Task::find($task2->id);
        $this->assertNotNull($task);
        $this->assertEquals(1, $task->position);
    }

    public function test_reordering_tasks()
    {
        $checklist_group = CheckListGroup::factory()->create();
        $checklist = CheckList::factory()->create(['check_list_group_id' => $checklist_group->id]);

        $task1 = Task::factory()->create(['check_list_id' => $checklist->id, 'position' => 1]);
        $task2 = Task::factory()->create(['check_list_id' => $checklist->id, 'position' => 2]);

        Livewire::test(TasksTable::class, ['checkList' => $checklist])
            ->call('task_up', $task2->id);

        $task = Task::find($task2->id);
        $this->assertEquals(1, $task->position);

        Livewire::test(TasksTable::class, ['checkList' => $checklist])
            ->call('task_down', $task2->id);

        $task = Task::find($task2->id);
        $this->assertEquals(2, $task->position);
    }
}
