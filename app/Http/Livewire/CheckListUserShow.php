<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class CheckListUserShow extends Component
{
    public $checkList;
    public $completed_tasks = [];
    
    public function mount()
    {
        // get completed parent tasks of current task
        $this->completed_tasks = Task::where('check_list_id', $this->checkList->id)
            ->where('user_id', auth()->id())
            ->whereNotNull('completed_at')
            ->pluck('task_id')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.check-list-user-show');
    }

    public function complete_task($task_id)
    {
        $task = Task::find($task_id);
        if ($task) {
            $user_task = Task::where('task_id', $task_id)->first();
            if ($user_task) {
                if (is_null($user_task['completed_at'])) {
                    $user_task->update(['completed_at' => now()]);
                    $this->completed_tasks[] = $task_id;
                    $this->emit('task_complete_event', $task->check_list_id);
                } else {
                    $user_task->delete();
                    $this->emit('task_complete_event', $task->check_list_id, -1);
                }
            } else {
                $user_task = $task->replicate();
                $user_task['user_id'] = auth()->id();
                $user_task['task_id'] = $task_id;
                $user_task['completed_at'] = now();
                $user_task->save();
                $this->completed_tasks[] = $task_id;
                $this->emit('task_complete_event', $task->check_list_id);
            }
        }
    }
}
