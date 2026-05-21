<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlunoController extends Controller
{
    public function index(Turma $turma)
    {
        $alunos = $turma->alunos()
            ->with('nota')
            ->orderBy('nome')
            ->get();

        return view('alunos.index', compact('turma', 'alunos'));
    }

    public function create(Turma $turma)
    {
        if ($turma->fechada) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Essa turma está fechada. Não é possível cadastrar alunos.');
        }

        return view('alunos.create', compact('turma'));
    }

    public function store(Request $request, Turma $turma)
    {
        if ($turma->fechada) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Essa turma está fechada. Não é possível cadastrar alunos.');
        }

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'ra' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('alunos', 'ra')->where('turma_id', $turma->id),
            ],
        ]);

        Aluno::create([
            'turma_id' => $turma->id,
            'nome' => $request->nome,
            'ra' => $request->ra,
        ]);

        return redirect()
            ->route('alunos.index', $turma->id)
            ->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        $turma = $aluno->turma;

        if ($turma->fechada) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Essa turma está fechada. Não é possível editar alunos.');
        }

        return view('alunos.edit', compact('aluno', 'turma'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $turma = $aluno->turma;

        if ($turma->fechada) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Essa turma está fechada. Não é possível alterar alunos.');
        }

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'ra' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('alunos', 'ra')
                    ->where('turma_id', $turma->id)
                    ->ignore($aluno->id),
            ],
        ]);

        $aluno->update([
            'nome' => $request->nome,
            'ra' => $request->ra,
        ]);

        return redirect()
            ->route('alunos.index', $turma->id)
            ->with('success', 'Aluno atualizado com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        $turma = $aluno->turma;

        if ($turma->fechada) {
            return redirect()
                ->route('alunos.index', $turma->id)
                ->with('error', 'Essa turma está fechada. Não é possível excluir alunos.');
        }

        $aluno->delete();

        return redirect()
            ->route('alunos.index', $turma->id)
            ->with('success', 'Aluno excluído com sucesso!');
    }
}