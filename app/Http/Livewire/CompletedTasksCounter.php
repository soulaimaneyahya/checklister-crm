<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompletedTasksCounter extends Component
{
    public $tasks_count;
    public $user_completed_tasks;
    public $check_list_id;

    protected $listeners = ['task_complete_event' => 'recalculate_tasks'];

    public function render()
    {
        return view('livewire.completed-tasks-counter');
    }

    public function recalculate_tasks($check_list_id, $i=1)
    {
        if ($check_list_id === $this->check_list_id) {
            $this->user_completed_tasks+=$i;
        }
    }
}
