<?php

namespace Tests;

use App\Models\Page;
use App\Models\Task;
use App\Models\User;
use App\Models\CheckList;
use App\Models\CheckListGroup;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
        
    protected function user() : User
    {
        $this->seed(PageSeeder::class);
        return User::factory()->admin()->create();
    }

    protected function createDummyCheckListGroup(): CheckListGroup
    {
        return CheckListGroup::factory()->lorem_ipsum()->create();
    }

    protected function createDummyCheckList(): CheckList
    {
        return CheckList::factory()->lorem_ipsum()->make();
    }

    protected function createDummyPage(): Page
    {
        return Page::factory()->lorem_ipsum()->create();
    }

    protected function createDummyTask(): Task
    {
        return Task::factory()->lorem_ipsum()->make();
    }
}
