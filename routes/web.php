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

/**
 * Rotas de exibição
 */
Route::get('/', [CustomerController::class, 'list'])->name('list-customer');
Route::get('/customer/new', [CustomerController::class, 'create'])->name('create-customer');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('edit-customer');

/**
 * Rotas de ação
 */
Route::post('/customer/save', [CustomerController::class, 'save'])->name('save-customer');
Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('delete-customer');