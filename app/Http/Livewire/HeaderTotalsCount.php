<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CheckList;

class HeaderTotalsCount extends Component
{
    public $check_list_group_id;
    public $check_list_id;

    protected $listeners = ['task_complete_event' => 'render'];

    public function render()
    {
        $checklists = CheckList::where('check_list_group_id', $this->check_list_group_id)
            ->whereNull('user_id')
            ->withCount(['tasks' => function($query) {
                $query->whereNull('user_id');
            }])
            ->withCount('user_completed_tasks')
            ->get();
        return view('livewire.header-totals-count', compact('checklists'));
    }
}
