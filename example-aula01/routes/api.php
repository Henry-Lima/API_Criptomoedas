<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCriptoController;

//rotas para visualizar os registros
Route::get('/', function(){return response()->json(['Sucesso'=>true]);});
Route::get('/cripto',[ApiCriptoController::class,'index']);
Route::get('/cripto/{codigo}', [ApiCriptoController::class, 'show']);

//rotas para inserir os registros
Route::post('/cripto',[ApiCriptoController::class,'store']);

//rotas para alterar os registros
Route::put('/cripto/{codigo}', [ApiCriptoController::class, 'update']);

//rotas para excluir os registros por id/codigo
Route::delete('/cripto/{id}', [ApiCriptoController::class, 'destroy']);
