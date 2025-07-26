<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/deputados/{deputado}/despesas', [HomeController::class, 'despesas'])->name('despesas');
