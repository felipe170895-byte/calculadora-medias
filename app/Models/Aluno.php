<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'turma_id',
        'nome',
        'ra',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function nota()
    {
        return $this->hasOne(Nota::class);
    }
}