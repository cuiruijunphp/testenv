<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send','App\Http\Controllers\UserController@insertUser');
Route::get('/test','App\Http\Controllers\UserController@test');
Route::get('/notify','App\Http\Controllers\UserController@notify_con');
Route::get('/show','App\Http\Controllers\UserController@show_con');
Route::get('/getUserInfo','App\Http\Controllers\UserController@get_user_info');
Route::get('/getRedisList','App\Http\Controllers\UserController@redis_test');
