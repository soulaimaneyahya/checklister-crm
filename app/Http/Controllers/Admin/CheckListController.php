<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckList;
use Illuminate\Http\Request;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CheckListController extends Controller
{
    public function index(): View
    {
        $checkLists = CheckList::all();
        return view('admin.checkLists.index', compact('checkLists'));
    }

    public function create(): View
    {
        return view('admin.checkLists.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('checkLists.index');
    }

    public function show(CheckList $checkList): View
    {
        return view('admin.checkLists.show', compact('checkList'));
    }

    public function edit(CheckList $checkList): View
    {
        return view('admin.checkLists.edit', compact('checkList'));
    }

    public function update(Request $request, CheckList $checkList): RedirectResponse
    {
        return redirect()->route('checkLists.index');
    }

    public function destroy(CheckList $checkList): RedirectResponse
    {
        $checkList->delete();
        return redirect()->route('checkLists.index');
    }
}
