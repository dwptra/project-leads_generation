<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OwnerController;


use App\Http\Middleware\cekRole;

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

// Route::get('/', function () {
//     return view('push');
// });

// Hanya bisa diakses oleh admin
Route::middleware(['cekRole', 'isLogin'])->group(function () {
    // User
    Route::prefix('user')->group(function () {
        Route::get('/create', [UserController::class, 'userCreate'])->name('user.create');
        Route::post('/create', [UserController::class, 'userPost'])->name('user.post');
        Route::get('/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');
        Route::patch('/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');    
        Route::delete('/delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');
    });

    // Owner
    Route::prefix('owner')->group(function () {
        Route::post('/create', [OwnerController::class, 'ownerPost'])->name('owner.post');
        Route::patch('/update/{id}', [OwnerController::class, 'ownerUpdate'])->name('owner.update');  
        Route::delete('/delete/{id}', [OwnerController::class, 'ownerDelete'])->name('owner.delete');
    });

    // Leads
    Route::prefix('leads')->group(function () {
        Route::get('/create', [LeadsController::class, 'leadsCreate'])->name('leads.create');
        Route::post('/create', [LeadsController::class, 'leadsPost'])->name('leads.post');
        Route::get('/edit/{id}', [LeadsController::class, 'leadsEdit'])->name('leads.edit');
        Route::patch('/update/{id}', [LeadsController::class, 'leadsUpdate'])->name('leads.update');
        Route::delete('/delete/{id}', [LeadsController::class, 'leadsDelete'])->name('leads.delete');
        Route::get('/export', [LeadsController::class, 'exportLeadsToExcel'])->name('exportLeadsToExcel');
    });
    
    // Histories
    Route::prefix('leads_histories')->group(function () {
        Route::get('/', [LeadsController::class, 'leadsHistories'])->name('leads.histories');
        Route::get('/leads/{id}/histories', [LeadsController::class, 'showHistories'])->name('show.histories');
        Route::delete('/delete/{id}', [LeadsController::class, 'historiesDelete'])->name('histories.delete');
    });
});

// Bisa diakses oleh admin dan user
Route::middleware('isLogin')->group(function () {
    // Page User, Leads dan Dashboard
    Route::get('/user', [UserController::class, 'user'])->name('user.index');
    Route::get('/owner', [OwnerController::class, 'owner'])->name('owner');
    Route::get('/leads', [LeadsController::class, 'leads'])->name('leads');
    Route::get('/leads_report', [LeadsController::class, 'leadsReport'])->name('leads.report');
    Route::get('/report', [LeadsController::class, 'generateReport'])->name('generate.report');
    Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
});

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('isGuest')->group(function () {
    // Login
    Route::get('/', [AuthCotroller::class, 'index'])->name('login');
    Route::post('/', [AuthController::class, 'Auth'])->name('login.auth');
});

// 404 Error 
Route::get('/404', function () {
    return view('404');
});