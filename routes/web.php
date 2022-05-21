<?php

use App\Http\Controllers\PageController;
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
Route::inertia('/test', 'Test');
Route::patch('/update-language', UpdateLanguageController::class)->name('update-language');
