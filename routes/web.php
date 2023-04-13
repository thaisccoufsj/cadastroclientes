<?php

use App\Http\Controllers\CustomerController;
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

Route::get('/', [CustomerController::class, 'list'])->name('list-customer');
Route::get('/', [CustomerController::class, 'search'])->name('search-customer');
Route::get('/new', [CustomerController::class, 'create'])->name('create-customer');
Route::post('/new', [CustomerController::class, 'store'])->name('store-customer');
Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('delete-customer');
Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit-customer');
Route::post('/edit', [CustomerController::class, 'save'])->name('change-customer');
