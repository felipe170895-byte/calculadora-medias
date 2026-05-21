@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Alunos da Turma</h2>

        <p class="text-muted mb-0">
            Turma: <strong>{{ $turma->nome }}</strong>
        </p>

        @if($turma->fechada)
            <span class="badge bg-danger mt-2">
                Turma Fechada - Somente Consulta
            </span>
        @else
            <span class="badge bg-success mt-2">
                Turma Aberta
            </span>
        @endif
    </div>

    <div>
        <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary">
            Voltar
        </a>

        @if(!$turma->fechada)
            <a href="{{ route('alunos.create', $turma->id) }}" class="btn btn-primary">
                + Novo Aluno
            </a>
        @endif
    </div>
</div>

@if($turma->fechada)
    <div class="alert alert-warning">
        Esta turma está fechada. Os dados podem ser visualizados, mas não podem ser alterados.
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <strong>Lista de Alunos</strong>
    </div>

    <div class="card-body">

        @if($alunos->count() > 0)

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>RA</th>
                            <th>Notas</th>
                            <th>Situação do Aluno</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($alunos as $aluno)
                            <tr>
                                <td>{{ $aluno->id }}</td>

                                <td class="fw-semibold">
                                    {{ $aluno->nome }}
                                </td>

                                <td>
                                    {{ $aluno->ra ?? 'Não informado' }}
                                </td>

                                <td>
                                    @if($aluno->nota)
                                        <span class="badge bg-success">
                                            Notas lançadas
                                        </span>

                                        <br>

                                        <small class="text-muted">
                                            Média:
                                            {{ number_format($aluno->nota->media, 2, ',', '.') }}
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">
                                            Sem notas
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if(!$aluno->nota)

                                        <div class="alert alert-secondary py-2 px-3 mb-0">
                                            <strong>Sem notas</strong>
                                            <br>
                                            <small>Aguardando lançamento.</small>
                                        </div>

                                    @elseif($aluno->nota->conceito == 'A')

                                        <div class="alert alert-success py-2 px-3 mb-0">
                                            <strong>Aprovado com Louvor</strong>
                                            <br>
                                            <small>Excelente desempenho</small>
                                        </div>

                                    @elseif($aluno->nota->conceito == 'B')

                                        <div class="alert alert-primary py-2 px-3 mb-0">
                                            <strong>Aluno Aprovado</strong>
                                            <br>
                                            <small>Média aprovada</small>
                                        </div>

                                    @elseif($aluno->nota->conceito == 'C')

                                        @if($aluno->nota->resultado_recuperacao == 'Aluno aprovado na recuperação')

                                            <div class="alert alert-success py-2 px-3 mb-0">
                                                <strong>Aprovado na Recuperação</strong>
                                                <br>
                                                <small>
                                                    Recuperação:
                                                    {{ number_format($aluno->nota->nota_recuperacao, 2, ',', '.') }}
                                                </small>
                                            </div>

                                        @elseif($aluno->nota->resultado_recuperacao == 'Aluno reprovado na recuperação')

                                            <div class="alert alert-danger py-2 px-3 mb-0">
                                                <strong>Reprovado na Recuperação</strong>
                                                <br>
                                                <small>
                                                    Recuperação:
                                                    {{ number_format($aluno->nota->nota_recuperacao, 2, ',', '.') }}
                                                </small>
                                            </div>

                                        @else

                                            <div class="alert alert-warning py-2 px-3 mb-0">
                                                <strong>Em Recuperação</strong>
                                                <br>
                                                <small>Precisa lançar nota de recuperação.</small>
                                            </div>

                                        @endif

                                    @else

                                        <div class="alert alert-danger py-2 px-3 mb-0">
                                            <strong>Reprovado</strong>
                                            <br>
                                            <small>Média insuficiente</small>
                                        </div>

                                    @endif
                                </td>

                                <td class="text-end">

                                    @if($aluno->nota)
                                        <a href="{{ route('notas.resultado', $aluno->id) }}" class="btn btn-sm btn-success">
                                            Resultado
                                        </a>
                                    @else
                                        @if(!$turma->fechada)
                                            <a href="{{ route('notas.form', $aluno->id) }}" class="btn btn-sm btn-primary">
                                                Lançar Notas
                                            </a>
                                        @endif
                                    @endif

                                    @if(!$turma->fechada)

                                        @if($aluno->nota)
                                            <a href="{{ route('notas.form', $aluno->id) }}" class="btn btn-sm btn-outline-primary">
                                                Editar Notas
                                            </a>
                                        @endif

                                        <a href="{{ route('alunos.edit', $aluno->id) }}" class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir este aluno?')">
                                                Excluir
                                            </button>
                                        </form>

                                    @else

                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            Somente consulta
                                        </button>

                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="alert alert-info mb-0">
                Nenhum aluno cadastrado nesta turma.
            </div>

        @endif

    </div>
</div>

@endsection