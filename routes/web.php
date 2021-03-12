<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;

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
    return view('home');
});

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [AuthController::class, 'login'])->name('auth.login');
        Route::get('register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('create', [AuthController::class, 'create'])->name('auth.create');
        Route::post('check', [AuthController::class, 'check'])->name('auth.check');
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['middleware' => 'protection'], function () {
            Route::prefix('repair-requests')->group(function () {
                Route::get('/add', [RepairRequestController::class, 'add'])->name('add.repair.request');
                Route::post('/add/save', [RepairRequestController::class, 'addRepairRequest'])->name('add.repair.request.save');
                Route::post('/update/status', [RepairRequestController::class, 'changeStatus'])->name('repair.request.update.status');
                Route::get('/edit/{id}', [RepairRequestController::class, 'edit'])->name('edit.repair.request');
                Route::post('/edit/save', [RepairRequestController::class, 'editSave'])->name('edit.repair.request.save');
                Route::post('/delete', [RepairRequestController::class, 'delete'])->name('delete.repair.request');
            });

            Route::prefix('status')->group(function () {
                Route::post('/get', [StatusController::class, 'get'])->name('get.statuses');
            });

            Route::prefix('user')->group(function () {
                Route::post('/get', [UserController::class, 'get'])->name('get.user');
                Route::post('/search', [UserController::class, 'search'])->name('search.users');
            });
        });
        Route::get('/detail/{id}', [RepairRequestController::class, 'detail'])->name('detail.repair.request');

    });
});
