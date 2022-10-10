<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CheckListUserShow extends Component
{
    public $checkList;
    
    public function render()
    {
        return view('livewire.check-list-user-show');
    }
}
