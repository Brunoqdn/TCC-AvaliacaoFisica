<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedidaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PesquisaController;

// Rota inicial
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/chart', function () {
    return view('chart');
});

// // Rota para a view de medidas
// Route::get('/medidas', function () {
//     return view('medidas');
// });

// Rota para salvar as medidas via POST
Route::post('/medidas', [MedidaController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('/medidas', function () {
        return view('medidas');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pesquisar', function () {
        return view('pesquisar');
    });
});

// // Rota para a view de pesquisa
// Route::get('/pesquisar', function () {
//     return view('pesquisar');
// });

// Rota para API de pesquisa
Route::get('/api/pesquisar', [PesquisaController::class, 'pesquisar']);

// Rota para calcular percentis
Route::get('/percentis/{id}', [PesquisaController::class, 'percentis']);

// Rotas de autenticação
Auth::routes();

// Sobrescrevendo o redirecionamento padrão após o login
Route::get('/home', function () {
    return redirect('/medidas'); 
})->name('home');

// Rota de logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
