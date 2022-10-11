<?php

namespace App\Http\View\Composers;

use App\Models\CheckList;
use Illuminate\View\View;
use App\Models\CheckListGroup;
use Carbon\Carbon;

class MenuComposer
{

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {        
        $pages = \App\Models\Page::all();
        $view->with('pages', $pages);
        
        $menu = CheckListGroup::with([
            'checklists' => function($query) {
                $query->whereNull('user_id');
            }
        ])->get();
        $view->with('admin_menu', $menu);

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
                    $onclick_list = $user_lists->where('check_list_id', $check_list['id'])->max('updated_at');
                    $check_list['is_new'] = 
                    !($group['is_new']) &&
                    Carbon::create($check_list['created_at'])->greaterThan($onclick_list);
                    $check_list['is_updated'] = 
                    !($group['is_new']) &&
                    !($group['is_updated']) &&
                    !($check_list['is_new']) &&
                    Carbon::create($check_list['updated_at'])->greaterThan($onclick_list);
                }
                $groups[] = $group;
            }
        }
        $view->with('user_menu', $groups);
    }
}
