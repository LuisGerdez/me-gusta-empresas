<?php

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/add', [App\Http\Controllers\CompanyController::class, 'add'])->name('add_company');
Route::post('/add', [App\Http\Controllers\CompanyController::class, 'save'])->name('save_company');
Route::get('/view/{id}', [App\Http\Controllers\CompanyController::class, 'view'])->name('view_company');

Route::get('/api/companies/{page}', [App\Http\Controllers\ApiController::class, 'companies'])->name('api_companies');
Route::post('/api/like', [App\Http\Controllers\ApiController::class, 'like'])->name('api_like');