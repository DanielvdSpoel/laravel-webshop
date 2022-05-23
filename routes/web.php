<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ShowAuthViewsController;
use App\Http\Controllers\UpdateLanguageController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::patch('/update-language', UpdateLanguageController::class)->name('update-language');

Route::middleware('guest')->group(function() {
    Route::get('/login', [ShowAuthViewsController::class, 'login'])->name('login');
    Route::get('/register', [ShowAuthViewsController::class, 'register'])->name('register');
    Route::get('/password/forgot', [ShowAuthViewsController::class, 'forgotPassword'])->name('password.forgot');
    Route::get('/password/reset', [ShowAuthViewsController::class, 'resetPassword'])->name('password.reset');

});
