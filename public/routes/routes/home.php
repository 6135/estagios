<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\Authentication;


Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/cursos',[HomeController::class, 'cursos'])->name('cursos');
Route::get('/cursos/{titulo}',[HomeController::class, 'curso'])->name('curso');
