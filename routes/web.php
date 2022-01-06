<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'tasks', 'use' ], function(){
    Route::post('/create', ['uses' => 'App\Http\Controllers\TaskController@create'])->name('createtask');
    Route::post('/delete', ['uses' => 'App\Http\Controllers\TaskController@delete'])->name('deletetask');
    Route::post('/edit', ['uses' => 'App\Http\Controllers\TaskController@edit'])->name('edittask');
});
