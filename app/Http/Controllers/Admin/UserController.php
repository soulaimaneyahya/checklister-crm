<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(): View
    {
        // $users = User::where('is_admin', 0)->latest()->paginate(10);
        return view('admin.users.index');
    }
}
