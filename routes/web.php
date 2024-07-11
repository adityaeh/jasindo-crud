<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
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
    return view('auth.login');
});
Route::prefix('dashboard')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/index', [DashboardController::class, 'showIndex'])->name('index');
    Route::post('/save-table', [DashboardController::class, 'saveTable'])->name('save.table');
    Route::post('/edit-table', [DashboardController::class, 'editTable'])->name('edit.table');
    Route::post('/delete-table', [DashboardController::class, 'deleteTable'])->name('delete.table');
});
