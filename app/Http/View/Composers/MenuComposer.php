<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\MenuService;

class MenuComposer
{
    public function compose(View $view)
    {
        $menu = (new MenuService())->get_menu();

        $view->with('user_menu', $menu['user_menu']);
        $view->with('admin_menu', $menu['admin_menu']);
        $view->with('pages', $menu['pages']);
    }
}
