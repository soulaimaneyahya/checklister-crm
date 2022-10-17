<?php

namespace Tests\Feature;

use App\Models\CheckList;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public $user;
    public $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->john();
        $this->admin = $this->admin();
    }

    public function test_valid_payment()
    {
        $this->actingAs($this->admin);
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();
        $tasks = Task::factory(10)->create([
            'check_List_id' => $list->id
        ]);
        $task = Task::where('check_List_id', $list->id)->first();
        $this->assertNotNull($task);
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

        $this->actingAs($this->user);
        $list = CheckList::find($list->id);
        $response = $this->get("/check_lists/{$list->id}");
        $response->assertStatus(200);
        $response->assertSeeText("CheckList: {$list->name}");
        $response->assertSeeText("You are limited at 5 tasks per checklist");

        $payment = $this->createDummyPayment($this->user->id);
        $payment->user()->associate($this->user->id)->save();

        $this->assertDatabaseHas('payments', [
            'user_id' => $this->user->id,
            'payment_status' => $payment->payment_status
        ]);

        // standalone/show payment
        if ($this->user && $this->user->payment && $this->user->payment->payment_status == "approved") {
            $response = $this->get("/standalone/show");
            // $response->assertStatus(403);
        } else {
            $response = $this->get("/standalone/show");
            // $response->assertStatus(200);
        }
    }
}
