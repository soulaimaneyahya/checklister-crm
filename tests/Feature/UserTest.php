<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $user = $this->john();
        $this->actingAs($user);
        $this->user = $user;
    }

    public function test_home()
    {
        // creating list
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        $task = $this->createDummyTask();
        $task->check_list_id = $list->id;
        $task->save();

        if ($task) {
            $user_task = $task->replicate();
            $user_task['user_id'] = $this->user->id;
            $user_task['task_id'] = $task->id;
            $user_task['completed_at'] = now();
            $user_task->save();
        }
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'user_id' => $task->user_id,
            'task_id' => $task->task_id
        ]);
    }
}
