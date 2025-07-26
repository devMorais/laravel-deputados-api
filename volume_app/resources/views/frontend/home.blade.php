@extends('frontend.layouts.layout')
@section('content')
    <div class="container mt-5 mb-5 my-4">
        <div class="card shadow-lg p-4">
            <div class="card-header bg-dark text-white text-center h4">
                <i class="bi bi-people-fill me-2"></i>Lista de Deputados Federais
            </div>
            <div class="card-body my-2">
                {{ $dataTable->table(['class' => 'table table-striped table-bordered table-hover']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
