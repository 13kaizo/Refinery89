<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
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
    return view('users');
})->name('index');


Route::get('list_users',[UserController::class,'list_users'])->name('list_users');
Route::post('store_user',[UserController::class,'store_user'])->name('store_user');
Route::post('update_user/{id}',[UserController::class,'update_user'])->name('update_user');
Route::get('delete_user/{id}',[UserController::class,'delete_user'])->name('delete_user');
Route::get('manage_departments/{id}',[UserController::class,'manage_departments'])->name('manage_departments');
Route::get('list_departments_user/{id}',[UserController::class,'list_departments_user'])->name('list_departments_user');
Route::get('add_department/{id_department}/{id_user}',[UserController::class,'add_department'])->name('add_department');
Route::get('drop_department/{id_department}/{id_user}',[UserController::class,'drop_department'])->name('drop_department');


Route::get('departments',[DepartmentController::class,'index'])->name('departments');
Route::get('list_departments',[DepartmentController::class,'list_departments'])->name('list_departments');
Route::get('delete_department/{id}',[DepartmentController::class,'delete_department'])->name('delete_department');
Route::post('update_department/{id}',[DepartmentController::class,'update_department'])->name('update_department');
Route::post('store_department',[DepartmentController::class,'store_department'])->name('store_department');

