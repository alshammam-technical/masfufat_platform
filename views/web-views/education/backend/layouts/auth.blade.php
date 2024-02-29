<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('backend.includes.head')
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/fontawesome/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/css/extra/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/admin/css/application.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/toastr/toastr.min.css') }}">
</head>

<body>
    <div class="vironeer-sign-container">
        <div class="vironeer-sign-form">
            <div class="card">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('/public/assets/vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/admin/js/application.js') }}"></script>
    @if (env('NOCAPTCHA_SITEKEY') && env('NOCAPTCHA_SECRET'))
        {!! NoCaptcha::renderJs() !!}
    @endif
    @toastr_render
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @elseif(session('status'))
        <script>
            toastr.success('{{ session('status') }}')
        </script>
    @endif
</body>

</html>
