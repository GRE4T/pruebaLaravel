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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/api/types','App\Http\Controllers\ControllerTypes');
Route::resource('/api/childrens','App\Http\Controllers\ControllerChildrens');
Route::resource('/api/contracts','App\Http\Controllers\ControllerContracts');
Route::resource('/api/employees','App\Http\Controllers\ControllerEmployees');