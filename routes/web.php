<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\NotaController;

Route::get('/', [TurmaController::class, 'index'])->name('home');

Route::resource('turmas', TurmaController::class);

Route::post('/turmas/{turma}/fechar', [TurmaController::class, 'fechar'])->name('turmas.fechar');
Route::post('/turmas/{turma}/reabrir', [TurmaController::class, 'reabrir'])->name('turmas.reabrir');

// Rotas de alunos
Route::get('/turmas/{turma}/alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::get('/turmas/{turma}/alunos/create', [AlunoController::class, 'create'])->name('alunos.create');
Route::post('/turmas/{turma}/alunos', [AlunoController::class, 'store'])->name('alunos.store');

Route::get('/alunos/{aluno}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
Route::put('/alunos/{aluno}', [AlunoController::class, 'update'])->name('alunos.update');
Route::delete('/alunos/{aluno}', [AlunoController::class, 'destroy'])->name('alunos.destroy');

// Rotas de notas
Route::get('/alunos/{aluno}/notas', [NotaController::class, 'form'])->name('notas.form');
Route::post('/alunos/{aluno}/notas', [NotaController::class, 'salvar'])->name('notas.salvar');

Route::get('/alunos/{aluno}/resultado', [NotaController::class, 'resultado'])->name('notas.resultado');
Route::post('/alunos/{aluno}/recuperacao', [NotaController::class, 'recuperacao'])->name('notas.recuperacao');