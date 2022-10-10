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
        $tasksCount = max((int)$this->command->ask("How many tasks would you like ?", 50), 1);
        $lists = CheckList::all();
        Task::factory($tasksCount)->make()->each(function($task) use($lists) {
            $task->check_list_id = $lists->random()->id;
            $task->save();
        });
    }
}
