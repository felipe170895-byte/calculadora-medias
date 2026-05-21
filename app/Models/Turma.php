<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'fechada',
    ];

    protected $casts = [
        'fechada' => 'boolean',
    ];

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}