<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Importar o HomeController
use App\Models\Deputado; // Manter importação caso outras rotas ainda usem
use App\Models\Despesa;
use App\Models\Evento;


// Rota principal que agora usa o HomeController para exibir a lista de deputados
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/deputados/{deputado}/despesas', [HomeController::class, 'despesas'])->name('despesas');
