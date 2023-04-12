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

// Hanya bisa diakses oleh Owner
Route::middleware(['isOwner', 'isLogin'])->group(function () {
    Route::get('/userCreate', [LeadsController::class, 'userCreate'])->name('user.create');
    Route::post('/userCreate', [LeadsController::class, 'userPost'])->name('user.post');
    Route::get('/userEdit{id}', [LeadsController::class, 'userEdit'])->name('user.edit');
    Route::patch('/userUpdate/{id}', [LeadsController::class, 'userUpdate'])->name('user.update');    
    Route::delete('/user/{id}', [LeadsController::class, 'userDelete'])->name('user.delete');
});

// Hanya bisa diakses oleh admin
Route::middleware(['cekRole', 'isLogin'])->group(function () {
    Route::get('/leadsCreate', [LeadsController::class, 'leadsCreate'])->name('leadsCreate');
    Route::post('/leadsCreate', [LeadsController::class, 'leadsPost'])->name('leadsPost');
    Route::get('/leadsEdit{id}', [LeadsController::class, 'leadsEdit'])->name('leadsEdit');
    Route::patch('/leadsUpdate/{id}', [LeadsController::class, 'leadsUpdate'])->name('leadsUpdate');
    Route::delete('/leadsDelete/{id}', [LeadsController::class, 'leadsDelete'])->name('leadsDelete');
    
    Route::get('/leadsHistories', [LeadsController::class, 'leadsHistories'])->name('leadsHistories');
    Route::delete('/historiesDelete/{id}', [LeadsController::class, 'historiesDelete'])->name('historiesDelete');
});

// bisa diakses oleh admin dan user
Route::middleware('isLogin')->group(function () {
    Route::get('/user', [LeadsController::class, 'user'])->name('user.index');
    Route::get('/leads', [LeadsController::class, 'leads'])->name('leads');
    Route::get('/dashboard', [LeadsController::class, 'dashboard'])->name('dashboard');
});

Route::get('/logout', [LeadsController::class, 'logout'])->name('logout');

Route::middleware('isGuest')->group(function () {
    Route::get('/', [LeadsController::class, 'index'])->name('login');
    Route::post('/', [LeadsController::class, 'Auth'])->name('login.auth');
});


Route::get('/404', function () {
    return view('404');
});