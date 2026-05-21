<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Aluno;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::withCount('alunos')
            ->orderBy('id', 'desc')
            ->get();

        $totalTurmas = Turma::count();
        $turmasAbertas = Turma::where('fechada', false)->count();
        $turmasFechadas = Turma::where('fechada', true)->count();
        $totalAlunos = Aluno::count();

        return view('turmas.index', compact(
            'turmas',
            'totalTurmas',
            'turmasAbertas',
            'turmasFechadas',
            'totalAlunos'
        ));
    }

    public function create()
    {
        return view('turmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Turma::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'fechada' => false,
        ]);

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma cadastrada com sucesso!');
    }

    public function show(Turma $turma)
    {
        return redirect()->route('alunos.index', $turma->id);
    }

    public function edit(Turma $turma)
    {
        if ($turma->fechada) {
            return redirect()
                ->route('turmas.index')
                ->with('error', 'Essa turma está fechada e não pode ser editada.');
        }

        return view('turmas.edit', compact('turma'));
    }

    public function update(Request $request, Turma $turma)
    {
        if ($turma->fechada) {
            return redirect()
                ->route('turmas.index')
                ->with('error', 'Essa turma está fechada e não pode ser alterada.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $turma->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma atualizada com sucesso!');
    }

    public function destroy(Turma $turma)
    {
        if ($turma->fechada) {
            return redirect()
                ->route('turmas.index')
                ->with('error', 'Essa turma está fechada e não pode ser excluída.');
        }

        if ($turma->alunos()->count() > 0) {
            return redirect()
                ->route('turmas.index')
                ->with('error', 'Não é possível excluir uma turma que possui alunos cadastrados.');
        }

        $turma->delete();

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma excluída com sucesso!');
    }

    public function fechar(Turma $turma)
    {
        if ($turma->fechada) {
            return redirect()
                ->route('turmas.index')
                ->with('error', 'Essa turma já está fechada.');
        }

        $turma->update([
            'fechada' => true,
        ]);

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma fechada com sucesso! Agora ela ficará apenas para consulta.');
    }

    public function reabrir(Turma $turma)
    {
        if (!$turma->fechada) {
            return redirect()
                ->route('turmas.index')
                ->with('error', 'Essa turma já está aberta.');
        }

        $turma->update([
            'fechada' => false,
        ]);

        return redirect()
            ->route('turmas.index')
            ->with('success', 'Turma reaberta com sucesso! Agora é possível fazer alterações novamente.');
    }
}