<?php

use App\Http\Controllers\Admin\CheckListController;
use App\Http\Controllers\Admin\CheckListGroupController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController as HomePage;
use App\Http\Controllers\User\CheckListController as CheckListUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::permanentRedirect('/amazon', '/welcome'); // with status 301
Route::redirect('/', '/welcome');
Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('welcome', [HomePage::class, 'welcome'])->name('welcome');
    Route::get('consultation', [HomePage::class, 'consultation'])->name('consultation');
    Route::get('check_lists/{check_list}', [CheckListUserController::class, 'show'])->name('users.check_lists.show');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function(){
        Route::resource('pages', PageController::class)->only(['edit', 'update']);
        Route::resource('check_list_groups', CheckListGroupController::class)->except(['index', 'show']);
        Route::resource('check_list_groups.check_lists', CheckListController::class)->except(['index', 'show']);
        Route::resource('check_lists.tasks', TaskController::class)->except(['index', 'show']);
        Route::get('users', [UserController::class, 'index'])->name('users.index');
    });
});
