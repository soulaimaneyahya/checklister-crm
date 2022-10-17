<?php

namespace Tests\Feature;

use App\Http\Livewire\CheckListUserShow;
use App\Models\CheckList;
use App\Models\CheckListGroup;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserChecklistsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_can_load_checklist_page()
    {
        $checklist_group = CheckListGroup::factory()->create();
        $checklist = CheckList::factory()->create(['check_list_group_id' => $checklist_group->id]);
        Task::factory()->create(['check_list_id' => $checklist->id, 'position' => 1]);

        $response = $this->get('check_lists/' . $checklist->id);
        $response->assertStatus(200);

        // Test that checklist is "cloned" to user's checklists
        $user_checklist = CheckList::where('check_list_id', $checklist->id)->where('user_id', auth()->id())->first();
        $this->assertNotNull($user_checklist);

        // Test that the task is seen on the page
        Livewire::test(CheckListUserShow::class, ['checkList' => $checklist])
            ->assertCount('checkList.tasks', 1);
    }

    public function test_can_complete_task() {
        $checklist_group = CheckListGroup::factory()->create();
        $checklist = CheckList::factory()->create(['check_list_group_id' => $checklist_group->id]);
        $task = Task::factory()->create(['check_list_id' => $checklist->id, 'position' => 1]);
    
        Livewire::test(CheckListUserShow::class, ['checkList' => $checklist])
            ->call('complete_task', $task->id);
    
        $user_task = Task::where('task_id', $task->id)
            ->where('user_id', auth()->id())
            ->whereNotNull('completed_at');
        $this->assertNotNull($user_task);
    }
}
