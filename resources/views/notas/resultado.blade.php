@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-9">

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Resultado do Aluno</h5>

                @if($turma->fechada)
                    <span class="badge bg-danger">Turma Fechada</span>
                @else
                    <span class="badge bg-success">Turma Aberta</span>
                @endif
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <p class="mb-1"><strong>Aluno:</strong> {{ $aluno->nome }}</p>
                    <p class="mb-1"><strong>RA:</strong> {{ $aluno->ra ?? 'Não informado' }}</p>
                    <p class="mb-0"><strong>Turma:</strong> {{ $turma->nome }}</p>
                </div>

                <hr>

                <div class="row text-center mb-4">
                    <div class="col-md-3 mb-2">
                        <div class="border rounded p-3 bg-light">
                            <strong>Nota 1</strong>
                            <h4>{{ number_format($nota->nota1, 2, ',', '.') }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        <div class="border rounded p-3 bg-light">
                            <strong>Nota 2</strong>
                            <h4>{{ number_format($nota->nota2, 2, ',', '.') }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        <div class="border rounded p-3 bg-light">
                            <strong>Nota 3</strong>
                            <h4>{{ number_format($nota->nota3, 2, ',', '.') }}</h4>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        <div class="border rounded p-3 bg-light">
                            <strong>Nota 4</strong>
                            <h4>{{ number_format($nota->nota4, 2, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body text-center">

                        <h5>Média Final</h5>

                        <h1 class="fw-bold">
                            {{ number_format($nota->media, 2, ',', '.') }}
                        </h1>

                        @if($nota->conceito == 'A')
                            <div class="alert alert-success mb-0 mt-3">
                                {{ $nota->mensagem }}
                            </div>
                        @elseif($nota->conceito == 'B')
                            <div class="alert alert-primary mb-0 mt-3">
                                {{ $nota->mensagem }}
                            </div>
                        @elseif($nota->conceito == 'C')
                            <div class="alert alert-warning mb-0 mt-3">
                                {{ $nota->mensagem }}
                            </div>
                        @else
                            <div class="alert alert-danger mb-0 mt-3">
                                {{ $nota->mensagem }}
                            </div>
                        @endif

                    </div>
                </div>

                @if($nota->conceito == 'C')
                    <div class="card border-warning mb-4">
                        <div class="card-header bg-warning">
                            <strong>Recuperação</strong>
                        </div>

                        <div class="card-body">

                            @if(!$turma->fechada)
                                <form action="{{ route('notas.recuperacao', $aluno->id) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nota_recuperacao" class="form-label">
                                            Nota da Recuperação
                                        </label>

                                        <input type="number" step="0.01" min="0" max="10"
                                               name="nota_recuperacao" id="nota_recuperacao"
                                               class="form-control"
                                               value="{{ old('nota_recuperacao', $nota->nota_recuperacao ?? '') }}"
                                               placeholder="Ex: 7.5">
                                    </div>

                                    <button type="submit" class="btn btn-warning">
                                        Verificar Recuperação
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-secondary mb-0">
                                    A turma está fechada. Não é possível lançar ou alterar recuperação.
                                </div>
                            @endif

                            @if($nota->nota_recuperacao !== null)
                                <hr>

                                <p class="mb-1">
                                    <strong>Nota da recuperação:</strong>
                                    {{ number_format($nota->nota_recuperacao, 2, ',', '.') }}
                                </p>

                                <p class="mb-1">
                                    <strong>Soma média + recuperação:</strong>
                                    {{ number_format($nota->media + $nota->nota_recuperacao, 2, ',', '.') }}
                                </p>

                                @if($nota->resultado_recuperacao == 'Aluno aprovado na recuperação')
                                    <div class="alert alert-success mb-0">
                                        {{ $nota->resultado_recuperacao }}
                                    </div>
                                @else
                                    <div class="alert alert-danger mb-0">
                                        {{ $nota->resultado_recuperacao }}
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-between">
                    <a href="{{ route('alunos.index', $turma->id) }}" class="btn btn-outline-secondary">
                        Voltar para Alunos
                    </a>

                    @if(!$turma->fechada)
                        <a href="{{ route('notas.form', $aluno->id) }}" class="btn btn-warning">
                            Editar Notas
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>

@endsection