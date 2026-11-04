<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\NoticiaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::resource('noticia', NoticiaController::class)
    ->parameters(['noticia' => 'noticia'])
    ->except('show');

Route::resource('noticia.comentario', ComentarioController::class)
    ->parameters(['noticia' => 'noticia'])
    ->shallow()
    ->only(['create', 'store', 'edit', 'update', 'destroy']);