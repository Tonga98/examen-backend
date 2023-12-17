<?php


use Illuminate\Support\Facades\Route;

Route::prefix('entrenadores')->group(function () {
    Route::post('crear', 'EntrenadorController@crear');
    Route::get('{id_entrenador}', 'EntrenadorController@detalle')
        ->where('id_entrenador', '[0-9]+');
    Route::get('listar', 'EntrenadorController@listar');
});
Route::prefix('pokemones')->group(function () {
    Route::get('listar', 'PokemonController@listar');
    Route::get('{id}', 'PokemonController@detalle')
        ->where('id', '[0-9]+');
});
Route::prefix('equipos')->group(function () {
    Route::get('listar', 'EquipoController@listar');
    Route::post('crear', 'EquipoController@crear');
    Route::get('{id}', 'EquipoController@detalle')
        ->where('id', '[0-9]+');
});
Route::prefix('app')->group(function () {
    Route::get('get-pokemones', 'AppController@getPokemones');
});
