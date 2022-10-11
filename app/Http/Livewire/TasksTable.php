<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TasksTable extends Component
{
    public $checkList;
    
    public function render()
    {
        $tasks = $this->checkList->tasks()->whereNull('user_id')->orderBy('position')->paginate(10);
        return view('livewire.tasks-table', compact('tasks'));
    }

    public function task_up($task_id)
    {
        $task = Task::find($task_id);
        if ($task) {
            Task::whereNull('user_id')->where('position', $task->position -1)->update([
                'position' => $task->position
            ]);
            $task->update([
                'position' => $task->position -1
            ]);
        }
    }

    public function task_down($task_id)
    {
        $task = Task::find($task_id);
        if ($task) {
            Task::whereNull('user_id')->where('position', $task->position +1)->update([
                'position' => $task->position
            ]);
            $task->update([
                'position' => $task->position +1
            ]);
        }
    }
}
