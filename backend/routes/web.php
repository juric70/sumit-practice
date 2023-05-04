<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::apiResource('states', StateController::class);
//Route::get('states', [StateController::class, 'index']);
//Route::get('states/{state_id}', [StateController::class, 'show']);
//Route::get('cities', [CityController::class, 'index']);
//Route::get('city/{city_id}', [CityController::class, 'show']);



Route::get('cities', [CityController::class, 'index']);
Route::group(['prefix' => 'city'], function (){
    Route::post('create', [CityController::class, 'create']);
    Route::get('edit/{id}', [CityController::class, 'edit']);
    Route::post('update/{id}', [CityController::class, 'update']);
    Route::delete('delete/{id}', [CityController::class, 'destroy']);
});

Route::get('states', [StateController::class, 'index']);
Route::group(['prefix' => 'state'], function (){
    Route::post('create', [StateController::class, 'create']);
    Route::get('edit/{id}', [StateController::class, 'edit']);
    Route::post('update/{id}', [StateController::class, 'update']);
    Route::delete('delete/{id}', [StateController::class, 'destroy']);
});

Route::get('roles', [RoleController::class, 'index']);
Route::group(['prefix' => 'role'], function (){
    Route::post('create', [RoleController::class, 'create']);
    Route::get('edit/{id}', [RoleController::class, 'edit']);
    Route::post('update/{id}', [RoleController::class, 'update']);
    Route::delete('delete/{id}', [RoleController::class, 'destroy']);
});
