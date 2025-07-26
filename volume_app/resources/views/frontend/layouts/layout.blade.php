<!DOCTYPE html>
<html lang="pt-BR" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deputados</title>
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">
    @yield('content')
    @include('frontend.layouts.footer')
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
