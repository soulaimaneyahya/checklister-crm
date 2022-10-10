<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListGroupRequest;
use App\Http\Requests\UpdateCheckListGroupRequest;
use App\Models\CheckListGroup;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CheckListGroupController extends Controller
{
    public function create(): View
    {
        return view('admin.checklistgroups.create');
    }

    public function store(StoreCheckListGroupRequest $request): RedirectResponse
    {
        $checkListGroup = CheckListGroup::create($request->validated());
        return redirect()->route('admin.check_list_groups.edit', $checkListGroup)->with('alert-success', 'CheckListGroup Created');
    }

    public function edit(CheckListGroup $checkListGroup): View
    {
        return view('admin.checklistgroups.edit', compact('checkListGroup'));
    }

    public function update(UpdateCheckListGroupRequest $request, CheckListGroup $checkListGroup): RedirectResponse
    {
        $checkListGroup->update($request->validated());
        return redirect()->route('admin.check_list_groups.edit', $checkListGroup)->with('alert-warning', 'CheckListGroup Updated');
    }

    public function destroy(CheckListGroup $checkListGroup): RedirectResponse
    {
        $checkListGroup->delete();
        return redirect()->route('admin.check_list_groups.create')->with('alert-info', 'CheckListGroup Deleted');
    }
}
