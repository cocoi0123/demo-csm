<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionBackupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/create_permission', [PermissionBackupController::class, 'create']);
Route::post('/get_permission', [PermissionBackupController::class, 'get']);

Route::get('/get_permission_by_id/{id}', [PermissionBackupController::class, 'getById']);
Route::put('/update_permission/{id}', [PermissionBackupController::class, 'update']);
Route::delete('/delete_permission/{id}', [PermissionBackupController::class, 'delete']);



Route::resource('user', UserController::class);
Route::post('/login', [UserController::class, 'login']);
Route::post('/import', [UserController::class, 'import']);
Route::get('/export', [UserController::class, 'export']);


Route::group(['middleware' => 'checkjwt'], function () {
    Route::resource('permission', PermissionController::class);
    Route::get('/get_user_permission', [PermissionController::class, 'getUserPermission']);
});

Route::resource('product_type', ProductTypeController::class);

Route::resource('product', ProductController::class);
Route::post('/update_product', [ProductController::class, 'update']);


Route::resource('order', OrderController::class);
Route::put('/approved_order/{id}', [OrderController::class, 'approvedOrder']);

