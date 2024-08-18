<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedidaController;

Route::get('/pesquisar', [MedidaController::class, 'pesquisar']);
