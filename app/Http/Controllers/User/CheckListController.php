<?php

namespace App\Http\Controllers\User;

use App\Models\CheckList;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class CheckListController extends Controller
{
    public function show(CheckList $checkList): View
    {
        return view('users.checklists.show', compact('checkList'));
    }
}
