<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'aluno_id',
        'nota1',
        'nota2',
        'nota3',
        'nota4',
        'media',
        'conceito',
        'mensagem',
        'nota_recuperacao',
        'resultado_recuperacao',
    ];

    protected $casts = [
        'nota1' => 'decimal:2',
        'nota2' => 'decimal:2',
        'nota3' => 'decimal:2',
        'nota4' => 'decimal:2',
        'media' => 'decimal:2',
        'nota_recuperacao' => 'decimal:2',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}