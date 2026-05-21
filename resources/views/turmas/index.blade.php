@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Turmas</h2>
        <p class="text-muted mb-0">
            Painel geral das turmas cadastradas no sistema.
        </p>
    </div>

    <a href="{{ route('turmas.create') }}" class="btn btn-primary">
        + Nova Turma
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Total de Turmas</p>
                <h3 class="fw-bold mb-0">{{ $totalTurmas }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Turmas Abertas</p>
                <h3 class="fw-bold text-success mb-0">{{ $turmasAbertas }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Turmas Fechadas</p>
                <h3 class="fw-bold text-danger mb-0">{{ $turmasFechadas }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Total de Alunos</p>
                <h3 class="fw-bold text-primary mb-0">{{ $totalAlunos }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <strong>Lista de Turmas</strong>
    </div>

    <div class="card-body">

        @if($turmas->count() > 0)

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Alunos</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($turmas as $turma)
                            <tr>
                                <td>{{ $turma->id }}</td>

                                <td class="fw-semibold">
                                    {{ $turma->nome }}
                                </td>

                                <td>
                                    {{ $turma->descricao ?? 'Sem descrição' }}
                                </td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $turma->alunos_count }} aluno(s)
                                    </span>
                                </td>

                                <td>
                                    @if($turma->fechada)
                                        <span class="badge bg-danger">Fechada</span>
                                    @else
                                        <span class="badge bg-success">Aberta</span>
                                    @endif
                                </td>

                                <td class="text-end">

                                    <a href="{{ route('alunos.index', $turma->id) }}" class="btn btn-sm btn-info text-white">
                                        Ver Alunos
                                    </a>

                                    @if(!$turma->fechada)

                                        <a href="{{ route('turmas.edit', $turma->id) }}" class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form action="{{ route('turmas.fechar', $turma->id) }}" method="POST" class="d-inline">
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-secondary"
                                                onclick="return confirm('Tem certeza que deseja fechar esta turma? Depois disso ela ficará apenas para consulta.')">
                                                Fechar Turma
                                            </button>
                                        </form>

                                        <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir esta turma?')">
                                                Excluir
                                            </button>
                                        </form>

                                    @else

                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            Somente consulta
                                        </button>

                                        <form action="{{ route('turmas.reabrir', $turma->id) }}" method="POST" class="d-inline">
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-success"
                                                onclick="return confirm('Tem certeza que deseja reabrir esta turma? As alterações voltarão a ser permitidas.')">
                                                Reabrir Turma
                                            </button>
                                        </form>

                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="alert alert-info mb-0">
                Nenhuma turma cadastrada ainda.
            </div>

        @endif

    </div>
</div>

@endsection