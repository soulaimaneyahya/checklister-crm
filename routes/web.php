<?php

use App\Http\Controllers\Admin\CheckListController;
use App\Http\Controllers\Admin\CheckListGroupController;
use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::permanentRedirect('/amazon', 'home');
Route::get('/', function () {
    return view('index');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function(){
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], function(){
        Route::resource('pages', PageController::class);
        Route::resource('check_list_groups', CheckListGroupController::class);
        Route::resource('check_list_groups.check_lists', CheckListController::class);
    });
});
