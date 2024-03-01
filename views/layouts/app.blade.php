<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- intlTelInput -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var inputs = $(".phoneInput");
        $(".phoneInput,input[type='number']").attr('inputmode','numeric')
        var iti = [];
        var phoneCountryCode;
        inputs.each(function(index){
            iti[index] = intlTelInput(this);
                phoneCountryCode = iti[index].getSelectedCountryData().dialCode;
            $(document).on("focus",".phoneInput",function(){
                phoneCountryCode = iti[index].getSelectedCountryData().dialCode;
            })
        })

        $(document).on("keydown",".phoneInput",function(){
            if($(this).val().length == ('+'+phoneCountryCode).length){
                $(this).val('+'+phoneCountryCode)
            }
        })

        $(document).on("keyup change",".phoneInput",function(e){
            var countryCode = '+'+phoneCountryCode;
            var value = $(this).val();
            var codeWithZero = countryCode + '0';
            if(value.startsWith(codeWithZero)){
                $(this).val(value.replace(codeWithZero,countryCode));
            }
            if(!value.startsWith(countryCode)){
                $(this).val(countryCode);
            }
            var isnum = /^\d+$/.test(value.replace('+',''))
            if(!isnum){
                $(this).val('+'+value.replace(/[^\d]/g, ""))
            }
        })
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- intlTelInput -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ \App\CPU\Helpers::translate('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ \App\CPU\Helpers::translate('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ \App\CPU\Helpers::translate('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ \App\CPU\Helpers::translate('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script id="respondio__widget" src="https://cdn.respond.io/webchat/widget/widget.js?cId=6fbe80a90fa9dde3a56998e3e891764"></script>
    <a href="#" id="scrollToTopButton" style="display: none; position: fixed; bottom: 20px; {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left: 20px;' : 'right: 20px;'}} z-index: 1000; transition: opacity 0.3s ease, visibility 0.3s ease;" onclick="scrollToTop();return false;">
        <i class="fa fa-chevron-up" style="display: inline-block; padding: 10px; background: #673ab7; color: white; border-radius: 50%;"></i>
    </a>
    <script>
        // الدالة للتمرير لأعلى الصفحة
        function scrollToTop() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        }

        // الدالة لإظهار أو إخفاء زر التمرير لأعلى
        function toggleScrollToTopButton() {
            var scrollToTopButton = document.getElementById('scrollToTopButton');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollToTopButton.style.display = 'block';
            } else {
                scrollToTopButton.style.display = 'none';
            }
        }

        // إضافة معالج لحدث التمرير
        window.onscroll = function() {
            toggleScrollToTopButton();
        };
        </script>
</body>


</html>
