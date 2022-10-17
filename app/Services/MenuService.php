<?php

namespace App\Services;

use App\Models\CheckList;
use App\Models\CheckListGroup;
use Carbon\Carbon;

class MenuService
{
    public function get_menu(): array
    {
        $pages = \App\Models\Page::all();
        
        $menu = CheckListGroup::with([
            'checklists' => function($query) {
                $query->whereNull('user_id');
            },
            'checklists.tasks' => function($query) {
                $query->whereNull('user_id');
            },
            'checklists.user_completed_tasks'
        ])->get();

        // compared to user last action
        $last_action_at = auth()->user()->last_action_at;
        if (is_null($last_action_at)) {
            // all of them are new
            $last_action_at = now()->subYear(10);
        }
        // compare to each list last action
        $user_lists = CheckList::where('user_id', auth()->id())->get();

        // it's now array not collection
        $groups = [];
        foreach ($menu->toArray() as $group) {
            // avoid empty groups
            if (count($group['checklists']) > 0) {
                // my current onclick any list belongs to this group
                $onclick_group = $user_lists->where('check_list_group_id', $group['id'])->max('updated_at');
                $group['is_new'] = Carbon::create($group['created_at'])->greaterThan($onclick_group);
                $group['is_updated'] = 
                !($group['is_new']) &&
                Carbon::create($group['updated_at'])->greaterThan($onclick_group);;
                foreach ($group['checklists'] as &$check_list) {
                    // my current onclick list
                    $onclick_list = $user_lists->where('check_list_group_id', $group['id'])->where('check_list_id', $check_list['id'])->max('updated_at');
                    if (is_null($onclick_list)) {
                        // all of them are new
                        $onclick_list = now()->subYear(10);
                    }
                    $check_list['is_new'] = 
                    !($group['is_new']) &&
                    !($group['is_updated']) &&
                    Carbon::create($check_list['created_at'])->greaterThan($onclick_list);
                    $check_list['is_updated'] = 
                    !($group['is_new']) &&
                    !($group['is_updated']) &&
                    !($check_list['is_new']) &&
                    Carbon::create($check_list['updated_at'])->greaterThan($onclick_list);
                    $check_list['tasks_count'] = count($check_list['tasks']);
                    $check_list['user_completed_tasks'] = count($check_list['user_completed_tasks']);
                }
                $groups[] = $group;
            }
        }

        return [
            'pages' => $pages,
            'admin_menu' => $menu,
            'user_menu' => $groups
        ];
    }
}
