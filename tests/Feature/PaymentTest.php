<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_payment()
    {
        // creating list
        $admin = $this->user();
        $this->actingAs($admin);
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();
        $user = $this->john();
        $this->actingAs($user);
        $tasks = Task::factory(10)->create([
            'check_List_id' => $list->id
        ]);
        $response = $this->get("/check_lists/{$list->id}");
        $response->assertStatus(200);
        $response->assertSeeText("CheckList: {$list->name}");
        $response->assertSeeText("You are limited at 5 tasks per checklist");
        $task = Task::find($tasks[0]->id);
        if ($task) {
            $user_task = $task->replicate();
            $user_task['user_id'] = $user->id;
            $user_task['task_id'] = $task->id;
            $user_task['completed_at'] = now();
            $user_task->save();
        }
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'user_id' => $task->user_id,
            'task_id' => $task->task_id
        ]);

        // checkout payment
        $response = $this->get("/checkout");
        $response->assertStatus(200);

        $payment = $this->createDummyPayment();
        $payment->payment_status= "approved";
        // $user->payment()->save($payment);
        $payment->user()->associate($user)->save();

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'approved' => "approved"
        ]);

        $register_user = User::factory()->create(); 
        $payment = Payment::factory()->create(['user_id' => $register_user->id, 'payment_status' => 'approved']); 

        // Method 1:
        $this->assertInstanceOf(Payment::class, $register_user->payment); 
        
        // Method 2:
        $this->assertEquals(2, $register_user->payment->count()); 

        if ($register_user->payment->payment_status == "approved") {
            // dump($register_user->payment->payment_status);
            $this->get("/checkout")
            ->assertStatus(200);
        } else {
            $response = $this->get("/checkout");
            // dump($register_user->payment->payment_status);
            $response->assertStatus(200);
        }
    }
}
