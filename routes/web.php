<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadsController;

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


Route::middleware('isLogin')->group(function () {
    Route::get('/dashboard', [LeadsController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('isGuest')->group(function () {
    Route::get('/', [LeadsController::class, 'index'])->name('login');
    Route::post('/', [LeadsController::class, 'Auth'])->name('login.auth');
});