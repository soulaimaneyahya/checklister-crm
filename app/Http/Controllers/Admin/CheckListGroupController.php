<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckListGroup;
use Illuminate\Http\Request;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CheckListGroupController extends Controller
{
    public function index(): View
    {
        $checkListGroups = CheckListGroup::all();
        return view('admin.checkListGroups.index', compact('checkListGroups'));
    }

    public function create(): View
    {
        return view('admin.checkListGroups.create');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('checkListGroups.index');
    }

    public function show(CheckListGroup $checkListGroup): View
    {
        return view('admin.checkListGroups.show', compact('checkListGroup'));
    }

    public function edit(CheckListGroup $checkListGroup): View
    {
        return view('admin.checkListGroups.edit', compact('checkListGroup'));
    }

    public function update(Request $request, CheckListGroup $checkListGroup): RedirectResponse
    {
        return redirect()->route('checkListGroups.index');
    }

    public function destroy(CheckListGroup $checkListGroup): RedirectResponse
    {
        $checkListGroup->delete();
        return redirect()->route('checkListGroups.index');
    }
}
