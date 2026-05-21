@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Editar Turma</h5>
            </div>

            <div class="card-body">

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

                <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Turma</label>
                        <input type="text" name="nome" id="nome" class="form-control"
                               value="{{ old('nome', $turma->nome) }}">
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="4" class="form-control">{{ old('descricao', $turma->descricao) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary">
                            Voltar
                        </a>

                        <button type="submit" class="btn btn-warning">
                            Atualizar Turma
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection