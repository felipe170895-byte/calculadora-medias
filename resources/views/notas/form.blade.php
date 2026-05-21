@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    {{ $nota ? 'Editar Notas' : 'Lançar Notas' }}
                </h5>
            </div>

            <div class="card-body">

                <p class="mb-1">
                    <strong>Aluno:</strong> {{ $aluno->nome }}
                </p>

                <p class="text-muted">
                    <strong>Turma:</strong> {{ $turma->nome }}
                </p>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Verifique os campos abaixo:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('notas.salvar', $aluno->id) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nota1" class="form-label">Nota 1</label>
                            <input type="number" step="0.01" min="0" max="10" name="nota1" id="nota1"
                                   class="form-control"
                                   value="{{ old('nota1', $nota->nota1 ?? '') }}"
                                   placeholder="Ex: 8.5">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nota2" class="form-label">Nota 2</label>
                            <input type="number" step="0.01" min="0" max="10" name="nota2" id="nota2"
                                   class="form-control"
                                   value="{{ old('nota2', $nota->nota2 ?? '') }}"
                                   placeholder="Ex: 7.0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nota3" class="form-label">Nota 3</label>
                            <input type="number" step="0.01" min="0" max="10" name="nota3" id="nota3"
                                   class="form-control"
                                   value="{{ old('nota3', $nota->nota3 ?? '') }}"
                                   placeholder="Ex: 9.0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nota4" class="form-label">Nota 4</label>
                            <input type="number" step="0.01" min="0" max="10" name="nota4" id="nota4"
                                   class="form-control"
                                   value="{{ old('nota4', $nota->nota4 ?? '') }}"
                                   placeholder="Ex: 6.5">
                        </div>
                    </div>

                    <div class="alert alert-info">
                        O sistema calculará automaticamente a média, o conceito e a mensagem do aluno.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('alunos.index', $turma->id) }}" class="btn btn-outline-secondary">
                            Voltar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Salvar e Calcular Média
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection