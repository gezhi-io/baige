<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RoleController;

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

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');

Route::get('/permission', [PermissionController::class,'index'])->middleware(['auth'])->name('permission');
Route::post('/permission/store', [PermissionController::class,'store'])->middleware(['auth'])->name('permission.store');
Route::get('/permission/info/{id}', [PermissionController::class,'info'])->middleware(['auth'])->name('permission.info');
Route::post('/permission/update/{id}', [PermissionController::class,'update'])->middleware(['auth'])->name('permission.update');
Route::post('/permission/delete/{id}', [PermissionController::class,'destroy'])->middleware(['auth'])->name('permission.delete');

Route::get('/role', [RoleController::class,'index'])->middleware(['auth'])->name('role');
Route::post('/role/store', [RoleController::class,'store'])->middleware(['auth'])->name('role.store');
Route::get('/role/info/{id}', [RoleController::class,'info'])->middleware(['auth'])->name('role.info');
Route::post('/role/update/{id}', [RoleController::class,'update'])->middleware(['auth'])->name('role.update');
Route::post('/role/delete/{id}', [RoleController::class,'destroy'])->middleware(['auth'])->name('role.delete');

require __DIR__.'/auth.php';
