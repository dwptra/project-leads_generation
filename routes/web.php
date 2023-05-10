<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\UserController;
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
        Route::get('/formcreateuser', [UserController::class, 'userCreate'])->name('user.create');
        Route::post('/createuser', [UserController::class, 'userPost'])->name('user.post');
        Route::get('/formedituser/{id}', [UserController::class, 'userEdit'])->name('user.edit');
        Route::patch('/updateuser/{id}', [UserController::class, 'userUpdate'])->name('user.update');  
        Route::patch('/changepassword/{id}', [UserController::class, 'changePassword'])->name('change.password');  
        Route::delete('/deleteuser/{id}', [UserController::class, 'userDelete'])->name('user.delete');
    });

    // Owner
    Route::prefix('owner')->group(function () {
        Route::post('/formreateowner', [OwnerController::class, 'ownerPost'])->name('owner.post');
        Route::patch('/formupdateowner/{id}', [OwnerController::class, 'ownerUpdate'])->name('owner.update');  
        Route::delete('/formdeleteowner/{id}', [OwnerController::class, 'ownerDelete'])->name('owner.delete');
    });

    // Leads
    Route::prefix('leads')->group(function () {
        Route::get('/formcreateleads', [LeadsController::class, 'leadsCreate'])->name('leads.create');
        Route::post('/createleads', [LeadsController::class, 'leadsPost'])->name('leads.post');
        Route::get('/formeditleads/{id}', [LeadsController::class, 'leadsEdit'])->name('leads.edit');
        Route::patch('/updateleads/{id}', [LeadsController::class, 'leadsUpdate'])->name('leads.update');
        Route::delete('/deleteleads/{id}', [LeadsController::class, 'leadsDelete'])->name('leads.delete');
        Route::get('/exportleads', [LeadsController::class, 'exportLeadsToExcel'])->name('exportLeadsToExcel');
    });
    
    // Histories
    Route::prefix('leadshistories')->group(function () {
        Route::get('/', [LeadsController::class, 'leadsHistories'])->name('leads.histories');
        Route::delete('/deletehistories/{id}', [LeadsController::class, 'historiesDelete'])->name('histories.delete');
    });
});

// Bisa diakses oleh admin dan user
Route::middleware('isLogin')->group(function () {
    // Page User, Leads dan Dashboard
    Route::get('/user', [UserController::class, 'user'])->name('user.index');
    Route::get('/owner', [OwnerController::class, 'owner'])->name('owner');
    Route::get('/leads', [LeadsController::class, 'leads'])->name('leads');
    Route::get('/leadsreport', [LeadsController::class, 'leadsReport'])->name('leads.report');
    Route::get('/generatereport', [LeadsController::class, 'generateReport'])->name('generate.report');
    Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
});

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('isGuest')->group(function () {
    // Login
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/', [AuthController::class, 'Auth'])->name('login.auth');
});

// 404 Error 
Route::get('/404', function () {
    return view('404');
});