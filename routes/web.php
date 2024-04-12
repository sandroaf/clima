<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClimaController;

/*////
Route::get('/', function () {
    return view('clima');
});
*/
Route::get('/',[ClimaController::class, 'index']);
Route::get('/buscaclima',[ClimaController::class, 'busca_clima']);
Route::get('/buscacidade/{uf}',[ClimaController::class, 'busca_cidade']);
