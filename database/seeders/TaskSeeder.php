<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\CheckList;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasksCount = max((int)$this->command->ask("How many tasks would you like ?", 20), 1);
        $lists = CheckList::all();
        if ($lists->count() === 0) {
            $this->command->info('There are no checklists, so no tasks will be added');
            return;
        }
        Task::factory($tasksCount)->make()->each(function($task) use($lists) {
            $list = $lists->random();
            $position = $list->tasks()->max('position') + 1;
            $task->position = $position;
            $task->check_list_id = $list->id;
            $task->save();
        });
    }
}
