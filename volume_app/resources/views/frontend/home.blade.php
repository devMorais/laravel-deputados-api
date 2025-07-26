@extends('frontend.layouts.layout')

@section('content')
    <div class="flex-shrink-0">
        <div class="container mt-5">
            <div class="content-wrapper">
                <h1 class="mb-4 text-center">Deputados Federais</h1>
                <form action="{{ route('home') }}" method="GET" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="search_nome" class="form-label">Nome do Deputado:</label>
                            <input type="text" class="form-control" id="search_nome" name="nome"
                                placeholder="Pesquisar por nome" value="{{ request('nome') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="search_partido" class="form-label">Partido:</label>
                            <input type="text" class="form-control" id="search_partido" name="partido"
                                placeholder="Pesquisar por partido" value="{{ request('partido') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="search_uf" class="form-label">UF:</label>
                            <input type="text" class="form-control" id="search_uf" name="uf"
                                placeholder="Pesquisar por UF" value="{{ request('uf') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
                        </div>
                    </div>
                </form>
                @if ($deputados->isEmpty())
                    <div class="alert alert-info" role="alert">
                        Nenhum deputado encontrado. Execute o comando 'php artisan sync:deputies' para sincronizar os dados
                        ou
                        ajuste os filtros de pesquisa.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover shadow-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Partido</th>
                                    <th>UF</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deputados as $deputado)
                                    <tr>
                                        <td>
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
                                        <td>{{ $deputado->nome }}</td>
                                        <td>{{ $deputado->sigla_partido ?? 'N/A' }}</td>
                                        <td>{{ $deputado->sigla_uf ?? 'N/A' }}</td>
                                        {{-- {{ route('deputados.despesas', $deputado->id) }} --}}
                                        {{-- {{ route('deputados.eventos', $deputado->id) }} --}}
                                        <td class="text-center">
                                            <a href="" class="btn btn-sm btn-primary mt-1">Ver Despesas</a>
                                            <a href="" class="btn btn-sm btn-info mt-1 text-white">Ver Eventos</a>
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
