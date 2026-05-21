<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function form(Aluno $aluno)
    {
        $turma = $aluno->turma;
        $nota = $aluno->nota;

        if ($turma->fechada) {
            return redirect()
                ->route('notas.resultado', $aluno->id)
                ->with('error', 'Essa turma está fechada. As notas podem ser visualizadas, mas não alteradas.');
        }

        return view('notas.form', compact('aluno', 'turma', 'nota'));
    }

    public function salvar(Request $request, Aluno $aluno)
    {
        $turma = $aluno->turma;

        if ($turma->fechada) {
            return redirect()
                ->route('notas.resultado', $aluno->id)
                ->with('error', 'Essa turma está fechada. Não é possível alterar notas.');
        }

        $request->validate([
            'nota1' => 'required|numeric|min:0|max:10',
            'nota2' => 'required|numeric|min:0|max:10',
            'nota3' => 'required|numeric|min:0|max:10',
            'nota4' => 'required|numeric|min:0|max:10',
        ]);

        $nota1 = (float) $request->nota1;
        $nota2 = (float) $request->nota2;
        $nota3 = (float) $request->nota3;
        $nota4 = (float) $request->nota4;

        $media = ($nota1 + $nota2 + $nota3 + $nota4) / 4;

        if ($media > 8.9) {
            $conceito = 'A';
            $mensagem = 'Aprovado com Louvor';
        } elseif ($media > 6.9) {
            $conceito = 'B';
            $mensagem = 'Aluno Aprovado';
        } elseif ($media > 3.9) {
            $conceito = 'C';
            $mensagem = 'Recuperação, sua chance de passar';
        } else {
            $conceito = 'D';
            $mensagem = 'Poxa vida, vamos tentar novamente ano que vem';
        }

        Nota::updateOrCreate(
            ['aluno_id' => $aluno->id],
            [
                'nota1' => $nota1,
                'nota2' => $nota2,
                'nota3' => $nota3,
                'nota4' => $nota4,
                'media' => $media,
                'conceito' => $conceito,
                'mensagem' => $mensagem,

                // Se recalcular a média e deixar de ser C, limpa recuperação antiga
                'nota_recuperacao' => $conceito === 'C' ? optional($aluno->nota)->nota_recuperacao : null,
                'resultado_recuperacao' => $conceito === 'C' ? optional($aluno->nota)->resultado_recuperacao : null,
            ]
        );

        return redirect()
            ->route('notas.resultado', $aluno->id)
            ->with('success', 'Notas salvas e média calculada com sucesso!');
    }

    public function resultado(Aluno $aluno)
    {
        $turma = $aluno->turma;
        $nota = $aluno->nota;

        if (!$nota) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Esse aluno ainda não possui notas cadastradas.');
        }

        return view('notas.resultado', compact('aluno', 'turma', 'nota'));
    }

    public function recuperacao(Request $request, Aluno $aluno)
    {
        $turma = $aluno->turma;
        $nota = $aluno->nota;

        if ($turma->fechada) {
            return redirect()
                ->route('notas.resultado', $aluno->id)
                ->with('error', 'Essa turma está fechada. Não é possível lançar recuperação.');
        }

        if (!$nota) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Esse aluno ainda não possui notas cadastradas.');
        }

        if ($nota->conceito !== 'C') {
            return redirect()
                ->route('notas.resultado', $aluno->id)
                ->with('error', 'A recuperação só é permitida para alunos com conceito C.');
        }

        $request->validate([
            'nota_recuperacao' => 'required|numeric|min:0|max:10',
        ]);

        $notaRecuperacao = (float) $request->nota_recuperacao;
        $soma = (float) $nota->media + $notaRecuperacao;

        if ($soma >= 10) {
            $resultado = 'Aluno aprovado na recuperação';
        } else {
            $resultado = 'Aluno reprovado na recuperação';
        }

        $nota->update([
            'nota_recuperacao' => $notaRecuperacao,
            'resultado_recuperacao' => $resultado,
        ]);

        return redirect()
            ->route('notas.resultado', $aluno->id)
            ->with('success', 'Resultado da recuperação salvo com sucesso!');
    }
}