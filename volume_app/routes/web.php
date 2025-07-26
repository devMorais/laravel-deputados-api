<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // Importar o HomeController
use App\Models\Deputado; // Manter importação caso outras rotas ainda usem
use App\Models\Despesa;
use App\Models\Evento;

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

// Rota principal que agora usa o HomeController para exibir a lista de deputados
Route::get('/', [HomeController::class, 'index'])->name('home');

// // Rotas para despesas e eventos (mantidas como estavam, mas você pode movê-las para um controller DeputadoController se quiser mais organização)
// Route::get('/deputados/{deputado}/despesas', function (Deputado $deputado) {
//     $despesas = $deputado->despesas()->orderBy('data_documento', 'desc')->get();
//     return view('deputados.despesas', compact('deputado', 'despesas'));
// })->name('deputados.despesas');

// Route::get('/deputados/{deputado}/eventos', function (Deputado $deputado) {
//     $eventos = $deputado->eventos()->orderBy('data_hora_inicio', 'desc')->get();
//     return view('deputados.eventos', compact('deputado', 'eventos'));
// })->name('deputados.eventos');

// Se a rota /deputados não for mais necessária diretamente, você pode removê-la ou redirecioná-la para a home
// Route::get('/deputados', function () { return redirect()->route('home'); });
