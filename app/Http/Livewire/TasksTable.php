<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TasksTable extends Component
{
    public $checkList;
    
    public function render()
    {
        $tasks = $this->checkList->tasks()->orderBy('position')->paginate(10);
        return view('livewire.tasks-table', compact('tasks'));
    }

    public function updateTaskOrder($tasks)
    {
        foreach ($tasks as $task) {
            Task::find($task['value'])->update(['position' => $task['order']]);
        }
    }
}
