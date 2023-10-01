<?php

use App\Http\Controllers\API\ElasticSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\TaskController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routs : crud
Route::controller(AuthController::class)->group(function(){
    Route::post('login','login')->name('login');
    Route::post('register','register')->name('register');
    Route::post('register_by','usercreate')->name('register.by');
});





// for Task : crud
Route::middleware('auth:sanctum')->controller(TaskController::class)->group(function (){
    Route::get('all_task', 'alltask')->name('all.task');
    Route::post('add_task', 'addtask')->name('add.task');
    Route::post('edit_task', 'edittask')->name('edit.task');
    Route::delete('delete_task', 'deletetask')->name('delete.task'); 
});





Route::middleware('auth:sanctum')->controller(UsersController::class)->group(function (){
    Route::get('admin_profile', 'adminprofile')->name('admin.profile'); 
    Route::post('admin_edit_profile', 'adminprofileupdate')->name('admin.profile.update');
    Route::post('admin_edit_user', 'adminuserupdate')->name('admin.user.update');
    Route::post('admin_update_password', 'adminpasswordupdate')->name('admin.password.update');
});




// Route::prefix('elasticsearch')->controller(ElasticSearchController::class)->group(function (){
//     Route::get('books','getBooks')->name('elasticsearch.books');
// });
