<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadsController;


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
    Route::get('/userCreate', [LeadsController::class, 'userCreate'])->name('user.create');
    Route::post('/userCreate', [LeadsController::class, 'userPost'])->name('user.post');
    Route::get('/userEdit{id}', [LeadsController::class, 'userEdit'])->name('user.edit');
    Route::patch('/userUpdate/{id}', [LeadsController::class, 'userUpdate'])->name('user.update');    
    Route::delete('/user/{id}', [LeadsController::class, 'userDelete'])->name('user.delete');

    // Owner
    Route::post('/ownerCreate', [LeadsController::class, 'ownerPost'])->name('owner.post');
    Route::patch('/ownerUpdate/{id}', [LeadsController::class, 'ownerUpdate'])->name('owner.update');  
    Route::delete('/owner/{id}', [LeadsController::class, 'ownerDelete'])->name('owner.delete');

    // Leads
    Route::get('/leadsCreate', [LeadsController::class, 'leadsCreate'])->name('leadsCreate');
    Route::post('/leadsCreate', [LeadsController::class, 'leadsPost'])->name('leadsPost');
    Route::get('/leadsEdit{id}', [LeadsController::class, 'leadsEdit'])->name('leadsEdit');
    Route::patch('/leadsUpdate/{id}', [LeadsController::class, 'leadsUpdate'])->name('leadsUpdate');
    Route::delete('/leadsDelete/{id}', [LeadsController::class, 'leadsDelete'])->name('leadsDelete');
    Route::get('/leads/export', [LeadsController::class, 'exportLeadsToExcel'])->name('exportLeadsToExcel');
    
    // Histories
    Route::get('/leadsHistories', [LeadsController::class, 'leadsHistories'])->name('leadsHistories');
    Route::get('/leads/{id}/histories', [LeadsController::class, 'showHistories'])->name('leadsHistories');
    Route::delete('/historiesDelete/{id}', [LeadsController::class, 'historiesDelete'])->name('historiesDelete');
});

// Bisa diakses oleh admin dan user
Route::middleware('isLogin')->group(function () {
    // Page User, Leads dan Dashboard
    Route::get('/user', [LeadsController::class, 'user'])->name('user.index');
    Route::get('/owner', [LeadsController::class, 'owner'])->name('owner');
    Route::get('/leads', [LeadsController::class, 'leads'])->name('leads');
    Route::get('/leadsReport', [LeadsController::class, 'leadsReport'])->name('leads.report');
    Route::get('/report', [LeadsController::class, 'generateReport'])->name('generate.report');
    Route::get('/dashboard', [LeadsController::class, 'dashboard'])->name('dashboard');
});

// Logout
Route::get('/logout', [LeadsController::class, 'logout'])->name('logout');

Route::middleware('isGuest')->group(function () {
    // Login
    Route::get('/', [LeadsController::class, 'index'])->name('login');
    Route::post('/', [LeadsController::class, 'Auth'])->name('login.auth');
});

// 404 Error 
Route::get('/404', function () {
    return view('404');
});