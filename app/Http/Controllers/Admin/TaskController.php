<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\CheckList;
use Illuminate\Contracts\View\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function create(CheckList $checkList): View
    {
        return view('admin.tasks.create', compact('checkList'));
    }

    public function store(StoreTaskRequest $request, CheckList $checkList): RedirectResponse
    {
        $task = $checkList->tasks()->create($request->validated());
        return redirect()
            ->route('admin.check_lists.tasks.edit', [
                $checkList, $task
            ])->with('alert-success', 'Task Created');
    }

    public function edit(CheckList $checkList, Task $task): View
    {
        return view('admin.tasks.edit', compact('checkList', 'task'));
    }

    public function update(UpdateTaskRequest $request, CheckList $checkList, Task $task): RedirectResponse
    {
        $task->update($request->validated());
        return redirect()
            ->route('admin.check_lists.tasks.edit', [
                $checkList, $task
            ])->with('alert-warning', 'Task Updated');
    }

    public function destroy(CheckList $checkList, Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
