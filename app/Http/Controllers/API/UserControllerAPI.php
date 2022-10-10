<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserControllerAPI extends Controller
{
    public function users()
    {
        // yajra/laravel-datatables-oracle
        return datatables(User::where('is_admin', 0)->select('id', 'created_at', 'name', 'email', 'website'))->toJson();
    }
}
