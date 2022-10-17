<?php

namespace Tests\Feature;

use App\Http\Livewire\CheckListUserShow;
use Tests\TestCase;
use App\Models\CheckList;
use App\Models\CheckListGroup;
use App\Services\MenuService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class UserTest extends TestCase
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

    public function test_home()
    {
        // creating list
        $this->actingAs($this->admin);
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        $task = $this->createDummyTask();
        $task->check_list_id = $list->id;
        $task->save();

        $this->actingAs($this->user);
        $user_task = $task->replicate();
        $user_task['user_id'] = $this->user->id;
        $user_task['task_id'] = $task->id;
        $user_task['completed_at'] = now();
        $user_task->save();

        $this->assertDatabaseHas('tasks', [
            'id' => $user_task->id,
            'user_id' => $user_task->user_id,
            'task_id' => $user_task->task_id
        ]);
    }

    public function test_cant_see_empty_checklist_group()
    {
        $this->actingAs($this->admin);
        $group = $this->createDummyCheckListGroup();
        $menu = (new MenuService())->get_menu();
        $this->assertCount(0, $menu['user_menu']);
    }

    public function test_can_see_group_with_checklists()
    {
        $this->actingAs($this->admin);
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        $this->actingAs($this->user);
        $menu = (new MenuService())->get_menu();
        $this->assertCount(1, $menu['user_menu']);
        $this->assertCount(1, $menu['user_menu'][0]['checklists']);
        $this->assertEquals('Lorem ipsum.', $menu['user_menu'][0]['checklists'][0]['name']);
        
        $list = CheckList::where('name', 'Lorem ipsum.')->first();
        $this->actingAs($this->admin);
        $group = CheckListGroup::first();
        $this->delete("/admin/check_list_groups/{$group->id}");

        $this->actingAs($this->user);
        $menu = (new MenuService())->get_menu();
        $this->assertCount(0, $menu['user_menu']);
    }

    public function test_checklist_task_number_are_correct()
    {
        $this->actingAs($this->admin);
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        $task1 = $this->createDummyTask();
        $task1->check_list_id = $list->id;
        $task1->position = 1;
        $task1->save();

        $task2 = $this->createDummyTask();
        $task2->check_list_id = $list->id;
        $task1->position = 2;
        $task2->save();

        $this->actingAs($this->user);
        $menu = (new MenuService())->get_menu();
        $this->assertEquals(2, $menu['user_menu'][0]['checklists'][0]['tasks_count']);
        $this->assertEquals(0, $menu['user_menu'][0]['checklists'][0]['user_completed_tasks']);

        Livewire::test(CheckListUserShow::class, [
            'checkList' => $list
        ])->call('complete_task', $task1->id);
        $menu = (new MenuService())->get_menu();
        $this->assertEquals(2, $menu['user_menu'][0]['checklists'][0]['tasks_count']);
        $this->assertEquals(1, $menu['user_menu'][0]['checklists'][0]['user_completed_tasks']);
    }

    public function test_see_new_upt_icons()
    {
        $this->actingAs($this->admin);
        $group = $this->createDummyCheckListGroup();
        $list = $this->createDummyCheckList();
        $list->check_list_group_id = $group->id;
        $list->save();

        $task1 = $this->createDummyTask();
        $task1->check_list_id = $list->id;
        $task1->position = 1;
        $task1->save();

        $this->actingAs($this->user);
        $menu = (new MenuService())->get_menu();
        $this->assertTrue($menu['user_menu'][0]['checklists'][0]['is_new']);

        $this->actingAs($this->admin);
        $this->put("/admin/check_list_groups/{$group->id}/check_lists/{$list->id}", [
            'name' => 'lorem ipsum dolor',
            'description' => 'lorem ipsum dolor sit ament diam',
        ])
        ->assertStatus(302)
        ->assertSessionHas('alert-warning')
        ->assertRedirect("/admin/check_list_groups/{$group->id}/check_lists/{$list->id}/edit");

        $this->assertEquals(session('alert-warning'), 'CheckList Updated');
        // dd($menu['user_menu'][0]);
    }
}
