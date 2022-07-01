<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\BindingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\OptionController;

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
})->name('dashboard');

Route::prefix('dashboard')->middleware(['auth','permission:manage-option'])->group(function () {
    // 权限
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/info/{id}', [PermissionController::class, 'info'])->name('permission.info');
    Route::post('/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::post('/permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.delete');
    // 角色
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/info/{id}', [RoleController::class, 'info'])->name('role.info');
    Route::get('/role/rpinfo/{id}', [RoleController::class, 'rpinfo'])->name('role.rpinfo');
    Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::post('/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');
    // 授权
    Route::get('/permission/assign', [BindingController::class, 'assign'])->name('permission.assign');
    Route::post('/permission/sync', [BindingController::class, 'sync'])->name('permission.sync');
    // 用户
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/info/{id}', [UserController::class, 'info'])->name('user.info');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    //配置
    Route::get('/options', [OptionController::class, 'index'])->name('option.index');
    Route::post('/option/store', [OptionController::class, 'store'])->name('option.store');
    Route::get('/option/info/{id}', [OptionController::class, 'info'])->name('option.info');
    Route::post('/option/update/{id}', [OptionController::class, 'update'])->name('option.update');
    Route::post('/option/delete/{id}', [OptionController::class, 'destroy'])->name('option.delete');
});



require __DIR__ . '/auth.php';
