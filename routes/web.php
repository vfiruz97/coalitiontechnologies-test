<?php

use App\Http\Controllers\Clients\Products\IndexController;
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

Route::get('/', [IndexController::class, 'index']);
Route::post('/product', [IndexController::class, 'saveProduct']);
Route::put('/product/{productId}', [IndexController::class, 'updateProduct']);
