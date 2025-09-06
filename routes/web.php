<?php

use App\Http\Controllers\CandidaturaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('candidaturas.create'));
Route::get('/candidaturas', [CandidaturaController::class, 'create'])->name('candidaturas.create');
Route::post('/candidaturas', [CandidaturaController::class, 'store'])->name('candidaturas.store');
