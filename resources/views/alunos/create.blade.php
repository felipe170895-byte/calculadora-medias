@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Cadastrar Aluno</h5>
            </div>

            <div class="card-body">

                <p class="text-muted">
                    Turma: <strong>{{ $turma->nome }}</strong>
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

                <form action="{{ route('alunos.store', $turma->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Aluno</label>
                        <input type="text" name="nome" id="nome" class="form-control"
                               value="{{ old('nome') }}" placeholder="Ex: Felipe Motta">
                    </div>

                    <div class="mb-3">
                        <label for="ra" class="form-label">RA</label>
                        <input type="text" name="ra" id="ra" class="form-control"
                               value="{{ old('ra') }}" placeholder="Ex: 12345">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('alunos.index', $turma->id) }}" class="btn btn-outline-secondary">
                            Voltar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Salvar Aluno
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection