<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\CheckListGroup;

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

        $groups = [];
        foreach ($menu->toArray() as $group) {
            $group['is_new'] = FALSE;
            $group['is_updated'] = FALSE;
            foreach ($group['checklists'] as &$check_list) {
                $check_list['is_new'] = FALSE;
                $check_list['is_updated'] = FALSE;
            }
            $groups[] = $group;
        }
        $view->with('user_menu', $groups);
    }
}
