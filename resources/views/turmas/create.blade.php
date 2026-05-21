@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Cadastrar Nova Turma</h5>
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

                <form action="{{ route('turmas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Turma</label>
                        <input type="text" name="nome" id="nome" class="form-control"
                               value="{{ old('nome') }}" placeholder="Ex: ADS 4º Período">
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="4" class="form-control"
                                  placeholder="Descrição opcional da turma">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('turmas.index') }}" class="btn btn-outline-secondary">
                            Voltar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Salvar Turma
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection