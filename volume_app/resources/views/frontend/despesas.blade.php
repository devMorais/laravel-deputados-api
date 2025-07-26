@extends('frontend.layouts.layout') {{-- Ajuste o layout conforme a sua estrutura --}}

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <h1 class="card-title text-center mb-4 text-primary">
                    <i class="bi bi-person-fill me-2"></i>Despesas do Deputado: {{ $deputado->nome }}
                </h1>
                <hr class="mb-4">
                <div class="row mb-4">
                    <div class="col-12 col-md-8 mx-auto">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="flex-shrink-0 me-3">
                                @if ($deputado->url_foto)
                                    {{-- Adicionando atributos para o modal --}}
                                    <img src="{{ $deputado->url_foto }}" alt="Foto de {{ $deputado->nome }}"
                                        class="img-thumbnail rounded-circle shadow-sm clickable-image"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #007bff; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-bs-src="{{ $deputado->url_foto }}">
                                @else
                                    <img src="https://placehold.co/120x120/cccccc/333333?text=N/A" alt="Sem Foto"
                                        class="img-thumbnail rounded-circle shadow-sm"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #007bff;">
                                @endif
                            </div>
                            <div>
                                <p class="lead mb-1"><strong><i class="bi bi-building me-2"></i>Partido:</strong> <span
                                        class="badge bg-info text-dark">{{ $deputado->sigla_partido ?? 'N/A' }}</span></p>
                                <p class="lead mb-0"><strong><i class="bi bi-geo-alt-fill me-2"></i>UF:</strong> <span
                                        class="badge bg-secondary">{{ $deputado->sigla_uf ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="mt-5 mb-3 text-primary"><i class="bi bi-cash-stack me-2"></i>Detalhamento das Despesas</h2>

                @if ($despesas->isEmpty())
                    <div class="alert alert-info text-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>Nenhuma despesa encontrada para este deputado.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered shadow-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Tipo de Despesa</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col" class="text-center">Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($despesas as $despesa)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($despesa->data_documento)->format('d/m/Y') }}</td>
                                        <td>{{ $despesa->tipo_despesa }}</td>
                                        <td>R$ {{ number_format($despesa->valor_documento, 2, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if ($despesa->url_documento)
                                                <a href="{{ $despesa->url_documento }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-text me-1"></i>Ver Documento
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left-circle-fill me-2"></i>Voltar para a lista de Deputados
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> {{-- modal-lg para modal maior --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto do Deputado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid" alt="Foto Ampliada">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Adiciona um script na seção 'scripts' do seu layout --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Botão que acionou o modal
                const imageUrl = button.getAttribute(
                    'data-bs-src'); // Pega a URL da imagem do atributo data-bs-src
                const modalImage = imageModal.querySelector('#modalImage');
                modalImage.src = imageUrl; // Define a imagem no modal
            });
        });
    </script>
@endpush
