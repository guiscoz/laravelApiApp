<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/list_users', [AuthController::class, 'list_users'])->name('list_users');

Route::prefix('current_user')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/', [AuthController::class, 'get_user'])->name('get_user');
    Route::put('/update_data', [AuthController::class, 'update_data'])->name('update_data');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/remove_account', [AuthController::class, 'remove_account'])->name('remove_account');
});
