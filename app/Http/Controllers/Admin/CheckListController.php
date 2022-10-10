<?php

namespace App\Http\Controllers\Admin;

use App\Models\CheckList;
use App\Models\CheckListGroup;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCheckListRequest;
use App\Http\Requests\UpdateCheckListRequest;

class CheckListController extends Controller
{
    public function create(CheckListGroup $checkListGroup): View
    {
        return view('admin.checklists.create', compact('checkListGroup'));
    }

    public function store(StoreCheckListRequest $request, CheckListGroup $checkListGroup): RedirectResponse
    {
        $checkList = $checkListGroup->checklists()->create($request->validated());
        return redirect()->route('admin.check_list_groups.check_lists.edit', [$checkListGroup, $checkList])->with('alert-success', 'CheckList Created');
    }

    public function edit(CheckListGroup $checkListGroup, CheckList $checkList)
    {
        $tasks = $checkList->tasks()->paginate(5);
        return view('admin.checklists.edit', compact('checkList', 'checkListGroup', 'tasks'));
    }

    public function update(UpdateCheckListRequest $request, CheckListGroup $checkListGroup, CheckList $checkList): RedirectResponse
    {
        $checkList->update($request->validated());
        return redirect()->route('admin.check_list_groups.check_lists.edit', [$checkListGroup, $checkList])->with('alert-warning', 'CheckList Updated');
    }

    public function destroy(CheckListGroup $checkListGroup, CheckList $checkList): RedirectResponse
    {
        $checkList->delete();
        return redirect()->route('admin.check_list_groups.edit', $checkListGroup)->with('alert-info', 'CheckList Deleted');
    }
}
