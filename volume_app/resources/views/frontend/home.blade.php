@extends('frontend.layouts.layout')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <h1 class="card-title text-center mb-4 text-primary">
                    <i class="bi bi-people-fill me-2"></i>Deputados Federais
                </h1>
                <hr class="mb-4">

                <form action="{{ route('home') }}" method="GET" class="mb-4 p-3 border rounded shadow-sm bg-light">
                    <div class="row g-3 align-items-end justify-content-center">
                        <div class="col-md-4">
                            <label for="search_nome" class="form-label text-dark">Nome do Deputado:</label>
                            <input type="text" class="form-control" id="search_nome" name="nome"
                                placeholder="Pesquisar por nome" value="{{ request('nome') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="search_partido" class="form-label text-dark">Partido:</label>
                            <input type="text" class="form-control" id="search_partido" name="partido"
                                placeholder="Pesquisar por partido" value="{{ request('partido') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="search_uf" class="form-label text-dark">UF:</label>
                            <input type="text" class="form-control" id="search_uf" name="uf"
                                placeholder="Pesquisar por UF" value="{{ request('uf') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i> Pesquisar
                            </button>
                        </div>
                    </div>
                </form>

                @if ($deputados->isEmpty())
                    <div class="alert alert-info text-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>Nenhum deputado encontrado. Execute o comando 'php
                        artisan sync:deputies' para sincronizar os dados
                        ou ajuste os filtros de pesquisa.
                    </div>
                @else
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered table-hover shadow-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Partido</th>
                                    <th scope="col">UF</th>
                                    <th scope="col" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deputados as $deputado)
                                    <tr>
                                        <td class="align-middle">
                                            @if ($deputado->url_foto)
                                                <img src="{{ $deputado->url_foto }}" alt="Foto de {{ $deputado->nome }}"
                                                    class="img-thumbnail rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <img src="https://placehold.co/50x50/cccccc/333333?text=N/A" alt="Sem Foto"
                                                    class="img-thumbnail rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $deputado->nome }}</td>
                                        <td class="align-middle">{{ $deputado->sigla_partido ?? 'N/A' }}</td>
                                        <td class="align-middle">{{ $deputado->sigla_uf ?? 'N/A' }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('despesas', $deputado->id) }}"
                                                class="btn btn-sm btn-primary mt-1">
                                                <i class="bi bi-cash-stack me-1"></i> Ver Despesas
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
