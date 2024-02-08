<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ItemVendaController;
use App\Http\Controllers\CLienteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('prod', 			[ProdutoController::class, 	'index']);
Route::post('prod', 		[ProdutoController::class, 	'store']);
Route::get('prod/{id}', 	[ProdutoController::class, 	'show']);
Route::put('prod/{id}', 	[ProdutoController::class, 	'update']);
Route::put('prod', 			[ProdutoController::class, 	'index']);
Route::delete('prod', 		[ProdutoController::class, 	'index']);
Route::delete('prod/{id}', 	[ProdutoController::class, 	'destroy']);


Route::get('cat', 			[CategoriaController::class, 	'index']);
Route::post('cat', 			[CategoriaController::class, 	'store']);
Route::get('cat/{id}', 		[CategoriaController::class, 	'show']);
Route::put('cat/{id}', 		[CategoriaController::class, 	'update']);
Route::put('cat', 			[CategoriaController::class, 	'index']);
Route::delete('cat', 		[CategoriaController::class, 	'index']);
Route::delete('cat/{id}', 	[CategoriaController::class, 	'destroy']);


Route::get('vend', 			[VendaController::class, 	'index']);
Route::post('vend', 		[VendaController::class, 	'store']);
Route::get('vend/{id}', 	[VendaController::class, 	'show']);
Route::put('vend/{id}', 	[VendaController::class, 	'update']);
Route::put('vend', 			[VendaController::class, 	'index']);
Route::delete('vend', 		[VendaController::class, 	'index']);
Route::delete('vend/{id}', 	[VendaController::class, 	'destroy']);


Route::get('iven', 			[ItemVendaController::class, 	'index']);
Route::post('iven', 		[ItemVendaController::class, 	'store']);
// Route::post('iven/{id}', 	[ItemVendaController::class, 	'store']);


Route::get('clie', 			[ClienteController::class, 	'index']);
Route::post('clie', 		[ClienteController::class, 	'store']);
Route::get('clie/{id}', 	[ClienteController::class, 	'show']);
Route::put('clie/{id}', 	[ClienteController::class, 	'update']);
Route::delete('clie/{id}', 	[ClienteController::class, 	'destroy']);

