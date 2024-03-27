<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/developers')->group(function (){
    Route::get('/', [DeveloperController::class, 'index'])->name('developers.index');
    Route::get('/create', [DeveloperController::class, 'create'])->name('developers.create')->middleware('auth');
    Route::post('/', [DeveloperController::class, 'store'])->name('developers.store')->middleware('auth');
    Route::get('/{id}', [DeveloperController::class, 'show'])->name('developers.show');
    Route::get('/edit/{id}', [DeveloperController::class, 'edit'])->name('developers.edit')->middleware('auth');
    Route::put('/{id}', [DeveloperController::class, 'update'])->name('developers.update')->middleware('auth');
    Route::delete('/{id}', [DeveloperController::class, 'destroy'])->name('developers.destroy')->middleware('auth');
});
