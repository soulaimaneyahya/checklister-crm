<?php

namespace App\Http\Controllers\User;

use App\Models\CheckList;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\CheckListService;

class CheckListController extends Controller
{
    public function show(CheckList $checkList): View
    {
        // Sync checklist from admin
        // => create new child record
        (new CheckListService())->sync_checklists($checkList, auth()->id());
        return view('users.checklists.show', compact('checkList'));
    }
}
