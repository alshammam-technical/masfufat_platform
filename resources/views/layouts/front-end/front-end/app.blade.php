<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ session()->get('direction') ?? 'rtl' }}">
    <head>
        <meta charset="utf-8">
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PZ11VQNTWS"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-PZ11VQNTWS');
        </script>
            @if($_SERVER['SERVER_NAME'] !== "platform.masfufat.com")
            @if($_SERVER['SERVER_NAME'] == "masfufat.com")
            <script>
                window['_fs_host'] = 'fullstory.com';
                window['_fs_script'] = 'edge.fullstory.com/s/fs.js';
                window['_fs_org'] = 'o-1RV6VB-na1';
                window['_fs_namespace'] = 'FS';
                (function(m,n,e,t,l,o,g,y){
                    if (e in m) {if(m.console && m.console.log) { m.console.log('FullStory namespace conflict. Please set window["_fs_namespace"].');} return;}
                    g=m[e]=function(a,b,s){g.q?g.q.push([a,b,s]):g._api(a,b,s);};g.q=[];
                    o=n.createElement(t);o.async=1;o.crossOrigin='anonymous';o.src='https://'+_fs_script;
                    y=n.getElementsByTagName(t)[0];y.parentNode.insertBefore(o,y);
                    g.identify=function(i,v,s){g(l,{uid:i},s);if(v)g(l,v,s)};g.setUserVars=function(v,s){g(l,v,s)};g.event=function(i,v,s){g('event',{n:i,p:v},s)};
                    g.anonymize=function(){g.identify(!!0)};
                    g.shutdown=function(){g("rec",!1)};g.restart=function(){g("rec",!0)};
                    g.log = function(a,b){g("log",[a,b])};
                    g.consent=function(a){g("consent",!arguments.length||a)};
                    g.identifyAccount=function(i,v){o='account';v=v||{};v.acctId=i;g(o,v)};
                    g.clearUserCookie=function(){};
                    g.setVars=function(n, p){g('setVars',[n,p]);};
                    g._w={};y='XMLHttpRequest';g._w[y]=m[y];y='fetch';g._w[y]=m[y];
                    if(m[y])m[y]=function(){return g._w[y].apply(this,arguments)};
                    g._v="1.3.0";
                })(window,document,window['_fs_namespace'],'script','user');
            </script>
            @endif
            @endif
            <title>
                @yield('title')
            </title>
            <meta name="viewport" content="width=device-width, initial-scale=1">

            {{--  tailwind  --}}
            @php
            $cssDirectory = public_path('masfufat_style/dist/assets');
            @endphp
            @foreach (scandir($cssDirectory) as $file)
                @if (pathinfo($file, PATHINFO_EXTENSION) === 'css')
                    <link rel="stylesheet" href="{{ asset('/public/masfufat_style/dist/assets/' . $file) }}">
                @endif
            @endforeach

            <!-- Favicon -->
            <link rel="shortcut icon" href="{{asset('/storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'shop_fav_icon'])->pluck('value')[0]}}">
            <link rel="apple-touch-icon" sizes="180x180"
                href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">
            <link rel="icon" type="image/png" sizes="32x32"
                href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">

            <link rel="stylesheet" media="screen"
                href="{{asset('public/assets/front-end')}}/vendor/simplebar/dist/simplebar.min.css"/>
            <link rel="stylesheet" media="screen"
                href="{{asset('public/assets/front-end')}}/vendor/tiny-slider/dist/tiny-slider.css"/>
            <link rel="stylesheet" media="screen"
                href="{{asset('public/assets/front-end')}}/vendor/drift-zoom/dist/drift-basic.min.css"/>
            <link rel="stylesheet" media="screen"
                href="{{asset('public/assets/front-end')}}/vendor/lightgallery.js/dist/css/lightgallery.min.css"/>
            <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css"/>
            <!-- Main Theme Styles + Bootstrap-->
            <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/theme.min.css?v=1">
            <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/slick.css">
            {{--  <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/font-awesome.min.css">  --}}
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
            <link rel="stylesheet" href="{{asset('/public/assets/front-end/js/leaflet/leaflet.css')}}">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

            @if((session('direction') ?? "rtl") == "ltr")
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/bootstrap.min.css" />
            @else
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/bootstrap.rtl.min.css" />
            @endif


            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">



            {{--  remixicon  --}}
            <link href="https://cdn.jsdelivr.net/npm/remixicon@3.3.0/fonts/remixicon.css" rel="stylesheet">

            <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css"/>
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/master.css"/>
            <link
                href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Titillium+Web:wght@400;600;700&display=swap"
                rel="stylesheet">
            {{-- light box --}}
            <link rel="stylesheet" href="{{asset('public/css/lightbox.css')}}">
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/style.css">
            @stack('css_or_js')


            <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/menu.css">

            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/home.css"/>
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/responsive1.css"/>

            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/owl.carousel.min.css"/>
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/owl.theme.default.min.css"/>

            <!-- intlTelInput -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/custom.css?v=3">

            {{--dont touch this--}}
            <meta name="_token" content="{{csrf_token()}}">
            {{--dont touch this--}}
            <!--to make http ajax request to https-->
            <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->

            <style>
                .rotate {
                    transform: rotate(180deg);
                    transition: transform 0.5s ease; /* Smooth transition for the rotation */
                }
                .rounded-11{
                    border-radius: 12px;
                }

                .bg-secondary{
                    background-color: {{ Helpers::get_business_settings('colors')['secondary'] }} !important;
                }

                .nav-link{
                    color: black !important;
                }

                .bg-primary, .nav-link.active{
                    color: white !important;
                    background-color: {{ Helpers::get_business_settings('colors')['primary'] }} !important;
                }

                .text-secondary{
                    color: {{ Helpers::get_business_settings('colors')['secondary'] }} !important;
                }
                .text-primary{
                    color: {{ Helpers::get_business_settings('colors')['primary'] }} !important;
                }
                body {
                    background-color: #f7f8fa94;
                }

                .rtl {
                    direction: {{ Session::get('direction') }};
                }

                .password-toggle-btn .password-toggle-indicator:hover {
                    color: {{$web_config['primary_color']}};
                }

                .password-toggle-btn .custom-control-input:checked ~ .password-toggle-indicator {
                    color: {{$web_config['secondary_color']}};
                }

                .dropdown-item:hover, .dropdown-item:focus {
                    color: {{$web_config['primary_color']}};
                    text-decoration: none;
                    background-color: rgba(0, 0, 0, 0)
                }

                .dropdown-item.active, .dropdown-item:active {
                    color: {{$web_config['secondary_color']}};
                    text-decoration: none;
                    background-color: rgba(0, 0, 0, 0)
                }

                .topbar a {
                    color: dark !important;
                }

                .navbar-light .navbar-tool-icon-box {
                    color: {{$web_config['primary_color']}};
                }

                .search_button {
                    background-color: {{$web_config['primary_color']}};
                    border: none;
                }

                .navbar-stuck-menu {
                    background-color: {{$web_config['primary_color']}};
                    min-height: 0;
                    padding-top: 0;
                    padding-bottom: 0;
                }

                .mega-nav {
                    background: white;
                    position: relative;
                    margin-top: 6px;
                    line-height: 17px;
                    width: 304px;
                    border-radius: 3px;
                }

                .bg-primary {
                    background-color: #673ab7 !important;;
                }

                .error_required{
                    border: red solid !important;
                }

                .mega-nav .nav-item .nav-link {
                    padding-top: 11px !important;
                    color: {{$web_config['primary_color']}} !important;
                    font-size: 20px;
                    font-weight: 600;
                    padding-left: 20px !important;
                }

                .nav-item .dropdown-toggle::after {
                    margin-left: 20px !important;
                }

                .navbar-tool-text {
                    padding-left: 5px !important;
                    font-size: 16px;
                }

                .modal-header .nav-tabs .nav-item .nav-link {
                    color: black !important;
                    /*border: 1px solid #E2F0FF;*/
                }

                .checkbox-alphanumeric::after,
                .checkbox-alphanumeric::before {
                    content: '';
                    display: table;
                }

                .checkbox-alphanumeric::after {
                    clear: both;
                }

                .checkbox-alphanumeric input {
                    left: -9999px;
                    position: absolute;
                }

                .checkbox-alphanumeric label {
                    width: 2.25rem;
                    height: 2.25rem;
                    float: left;
                    padding: 0.375rem 0;
                    margin-right: 0.375rem;
                    display: block;
                    color: #818a91;
                    font-size: 0.875rem;
                    font-weight: 400;
                    text-align: center;
                    background: transparent;
                    text-transform: uppercase;
                    border: 1px solid #e6e6e6;
                    border-radius: 2px;
                    -webkit-transition: all 0.3s ease;
                    -moz-transition: all 0.3s ease;
                    -o-transition: all 0.3s ease;
                    -ms-transition: all 0.3s ease;
                    transition: all 0.3s ease;
                    transform: scale(0.95);
                }

                .checkbox-alphanumeric-circle label {
                    border-radius: 100%;
                }

                .checkbox-alphanumeric label > img {
                    max-width: 100%;
                }

                .checkbox-alphanumeric label:hover {
                    cursor: pointer;
                    border-color: {{$web_config['primary_color']}};
                }

                .checkbox-alphanumeric input:checked ~ label {
                    transform: scale(1.1);
                    border-color: red !important;
                }

                .checkbox-alphanumeric--style-1 label {
                    width: auto;
                    padding-left: 1rem;
                    padding-right: 1rem;
                    border-radius: 2px;
                }

                .d-table.checkbox-alphanumeric--style-1 {
                    width: 100%;
                }

                .d-table.checkbox-alphanumeric--style-1 label {
                    width: 100%;
                }

                /* CUSTOM COLOR INPUT */
                .checkbox-color::after,
                .checkbox-color::before {
                    content: '';
                    display: table;
                }

                .checkbox-color::after {
                    clear: both;
                }

                .checkbox-color input {
                    left: -9999px;
                    position: absolute;
                }

                .checkbox-color label {
                    width: 2.25rem;
                    height: 2.25rem;
                    float: left;
                    padding: 0.375rem;
                    margin-right: 0.375rem;
                    display: block;
                    font-size: 0.875rem;
                    text-align: center;
                    opacity: 0.7;
                    border: 2px solid #d3d3d3;
                    border-radius: 50%;
                    -webkit-transition: all 0.3s ease;
                    -moz-transition: all 0.3s ease;
                    -o-transition: all 0.3s ease;
                    -ms-transition: all 0.3s ease;
                    transition: all 0.3s ease;
                    transform: scale(0.95);
                }

                .checkbox-color-circle label {
                    border-radius: 100%;
                }
                #toast-container {
                    z-index: 100000000000000 !important;
                }

                .checkbox-color label:hover {
                    cursor: pointer;
                    opacity: 1;
                }

                .checkbox-color input:checked ~ label {
                    transform: scale(1.1);
                    opacity: 1;
                    border-color: red !important;
                }

                .checkbox-color input:checked ~ label:after {
                    content: "\f121";
                    font-family: "Ionicons";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    color: rgba(255, 255, 255, 0.7);
                    font-size: 14px;
                }

                .card-img-top img, figure {
                    max-width: 200px;
                    max-height: 200px !important;
                    vertical-align: middle;
                }

                .product-card {
                    box-shadow: 1px 1px 6px #00000014;
                    border-radius: 5px;
                }

                .product-card .card-header {
                    text-align: center;
                    background: white 0% 0% no-repeat padding-box;
                    border-radius: 5px 5px 0px 0px;
                    border-bottom: white !important;
                }

                .product-title {
                    font-family: 'Roboto', sans-serif !important;
                    font-weight: 400 !important;
                    font-size: 22px !important;
                    color: #000000 !important;
                }

                .bg-color-changed {
                    background-color: #8471a6 !important;
                }

                .feature_header span {
                    font-weight: 700;
                    font-size: 25px;
                    text-transform: uppercase;
                }

                html[dir="ltr"] .feature_header span {
                    padding-right: 15px;
                }

                html[dir="rtl"] .feature_header span {
                    padding-left: 15px;
                }

                @media (max-width: 768px ) {
                    .feature_header {
                        margin-top: 0;
                        display: flex;
                        justify-content: flex-start !important;

                    }

                    .store-contents {
                        justify-content: center;
                    }

                    .feature_header span {
                        padding-right: 0;
                        padding-left: 0;
                        font-weight: 700;
                        font-size: 25px;
                        text-transform: uppercase;
                    }

                    .view_border {
                        margin: 16px 0px;
                        border-top: 2px solid #E2F0FF !important;
                    }

                }

                .scroll-bar {
                    max-height: calc(100vh - 100px);
                    overflow-y: auto !important;
                }

                ::-webkit-scrollbar-track {
                    box-shadow: inset 0 0 5px white;
                    border-radius: 5px;
                }

                ::-webkit-scrollbar {
                    width: 3px;
                }

                ::-webkit-scrollbar-thumb {
                    background: rgba(194, 194, 194, 0.38) !important;
                    border-radius: 5px;
                }

                ::-webkit-scrollbar-thumb:hover {
                    background: {{$web_config['secondary_color']}}        !important;
                }

                .mobileshow {
                    display: none;
                }

                @media screen and (max-width: 500px) {
                    .mobileshow {
                        display: block;
                    }
                }

                [type="radio"] {
                    border: 0;
                    clip: rect(0 0 0 0);
                    height: 1px;
                    margin: -1px;
                    overflow: hidden;
                    padding: 0;
                    position: absolute;
                    width: 1px;
                }

                [type="radio"] + span:after {
                    content: '';
                    display: inline-block;
                    width: 1.1em;
                    height: 1.1em;
                    vertical-align: -0.10em;
                    border-radius: 1em;
                    border: 0.35em solid #fff;
                    box-shadow: 0 0 0 0.10em{{$web_config['secondary_color']}};
                    margin-left: 0.75em;
                    transition: 0.5s ease all;
                }

                [type="radio"]:checked + span:after {
                    background: {{$web_config['secondary_color']}};
                    box-shadow: 0 0 0 0.10em{{$web_config['secondary_color']}};
                }

                [type="radio"]:focus + span::before {
                    font-size: 1.2em;
                    line-height: 1;
                    vertical-align: -0.125em;
                }


                .checkbox-color label {
                    box-shadow: 0px 3px 6px #0000000D;
                    border: none;
                    border-radius: 3px !important;
                    max-height: 35px;
                }

                .checkbox-color input:checked ~ label {
                    transform: scale(1.1);
                    opacity: 1;
                    border: 1px solid #ffb943 !important;
                }

                .checkbox-color input:checked ~ label:after {
                    font-family: "Ionicons", serif;
                    position: absolute;
                    content: "\2713" !important;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    color: rgba(255, 255, 255, 0.7);
                    font-size: 14px;
                }

                .navbar-tool .navbar-tool-label {
                    position: absolute;
                    top: -.3125rem;
                    right: -.3125rem;
                    width: 1.25rem;
                    height: 1.25rem;
                    border-radius: 50%;
                    background-color: {{$web_config['secondary_color']}}!important;
                    color: #fff;
                    font-size: .75rem;
                    font-weight: 500;
                    text-align: center;
                    line-height: 1.25rem;
                }

                .bg-primaryColor {
                    color: #fff;
                    background-color: {{$web_config['primary_color']}}!important;
                    border-color: {{$web_config['primary_color']}}!important;
                }

                .bg-primaryColor:hover {
                    color: #fff;
                    background-color: {{$web_config['primary_color']}}!important;
                    border-color: {{$web_config['primary_color']}}!important;
                }

                .btn-secondary {
                    background-color: {{$web_config['secondary_color']}}!important;
                    border-color: {{$web_config['secondary_color']}}!important;
                }

                .text-secondary {
                    color: {{$web_config['secondary_color']}}!important;
                }

                .btn-outline-accent:hover {
                    color: #fff;
                    background-color: {{$web_config['primary_color']}};
                    border-color: {{$web_config['primary_color']}};
                }

                .btn-outline-accent {
                    color: {{$web_config['primary_color']}};
                    border-color: {{$web_config['primary_color']}};
                }

                .text-accent {
                    font-family: 'Roboto', sans-serif;
                    font-weight: 700;
                    font-size: 18px;
                    color: {{$web_config['primary_color']}};
                }

                a:hover {
                    color: {{$web_config['secondary_color']}};
                    text-decoration: none
                }

                .active-menu {
                    color: {{$web_config['secondary_color']}}!important;
                }

                .page-item.active > .page-link {
                    box-shadow: 0 0.5rem 1.125rem -0.425rem{{$web_config['primary_color']}}


                }

                .page-item.active .page-link {
                    z-index: 3;
                    color: #fff;
                    background-color: {{$web_config['primary_color']}};
                    border-color: rgba(0, 0, 0, 0)
                }

                .btn-outline-accent:not(:disabled):not(.disabled):active, .btn-outline-accent:not(:disabled):not(.disabled).active, .show > .btn-outline-accent.dropdown-toggle {
                    color: #fff;
                    background-color: {{$web_config['secondary_color']}};
                    border-color: {{$web_config['secondary_color']}};
                }

                .btn-outline-primary {
                    color: {{$web_config['primary_color']}};
                    border-color: {{$web_config['primary_color']}};
                }

                .btn-outline-primary:hover {
                    color: #fff;
                    background-color: {{$web_config['secondary_color']}};
                    border-color: {{$web_config['secondary_color']}};
                }

                .btn-outline-primary:focus, .btn-outline-primary.focus {
                    box-shadow: 0 0 0 0{{$web_config['secondary_color']}};
                }

                .btn-outline-primary.disabled, .btn-outline-primary:disabled {
                    color: #6f6f6f;
                    background-color: transparent
                }

                .btn-outline-primary:not(:disabled):not(.disabled):active, .btn-outline-primary:not(:disabled):not(.disabled).active, .show > .btn-outline-primary.dropdown-toggle {
                    color: #fff;
                    background-color: {{$web_config['primary_color']}};
                    border-color: {{$web_config['primary_color']}};
                }

                .btn-outline-primary:not(:disabled):not(.disabled):active:focus, .btn-outline-primary:not(:disabled):not(.disabled).active:focus, .show > .btn-outline-primary.dropdown-toggle:focus {
                    box-shadow: 0 0 0 0{{$web_config['primary_color']}};
                }

                .feature_header span {
                    background-color: #fafafc !important
                }

                .discount-top-f {
                    position: absolute;
                }

                html[dir="ltr"] .discount-top-f {
                    left: 0;
                }

                html[dir="rtl"] .discount-top-f {
                    right: 0;
                }

                .for-discoutn-value {
                    background: {{$web_config['primary_color']}};

                }

                .czi-star-filled {
                    color: #fea569 !important;
                }

                .flex-start {
                    display: flex;
                    justify-content: flex-start;
                }

                .flex-center {
                    display: flex;
                    justify-content: center;
                }

                .flex-around {
                    display: flex;
                    justify-content: space-around;
                }

                .flex-between {
                    display: flex;
                    justify-content: space-between;
                }

                .row-reverse {
                    display: flex;
                    flex-direction: row-reverse;
                }

                .count-value {
                    width: 1.25rem;
                    height: 1.25rem;
                    border-radius: 50%;
                    color: #fff;
                    font-size: 0.75rem;
                    font-weight: 500;
                    text-align: center;
                    line-height: 1.25rem;
                }

                .cz-image-zoom-pane{
                    direction: ltr;
                }

                .pagination{
                    overflow: scroll;
                }
            </style>

            <!--for product-->
            <style>
                .stock-out {
                    position: absolute;
                    top: 40% !important;
                    color: white !important;
                    font-weight: 900;
                    font-size: 15px;
                }

                html[dir="ltr"] .stock-out {
                    left: 35% !important;
                }

                html[dir="rtl"] .stock-out {
                    right: 35% !important;
                }

                .product-card {
                    height: 100%;
                }

                .badge-style {
                    left: 75% !important;
                    margin-top: -2px !important;
                    background: transparent !important;
                    color: black !important;
                }

                html[dir="ltr"] .badge-style {
                    right: 0 !important;
                }

                html[dir="rtl"] .badge-style {
                    left: 0 !important;
                }
            </style>

            <style>
                .dropdown-menu {
                    min-width: 304px !important;
                    margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: -8px !important;
                    border-top-left-radius: 0px;
                    border-top-right-radius: 0px;
                }

                .intl-tel-input, .iti{
                    width: 100%;
                }

                .iti__selected-flag{
                    padding: 0px !important;
                    margin: 0 6px 0 8px;
                }

                .iti__country-list{
                    left: 30% !important;
                }

                html[dir="ltr"] * .navbar-vertical-container{
                    left: 100%;
                }
            </style>
            <script src="//code.jquery.com/jquery-1.12.4.js"></script>
            <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            {{--    --}}
                <!-- Varioqub experiments -->
                <script type="text/javascript">
                (function(e, x, pe, r, i, me, nt){
                e[i]=e[i]||function(){(e[i].a=e[i].a||[]).push(arguments)},
                me=x.createElement(pe),me.async=1,me.src=r,nt=x.getElementsByTagName(pe)[0],nt.parentNode.insertBefore(me,nt)})
                (window, document, 'script', 'https://abt.s3.yandex.net/expjs/latest/exp.js', 'ymab');
                ymab('metrika.94550812', 'init'/*, {clientFeatures}, {callback}*/);
                </script>

                <!-- Yandex.Metrika counter -->
                <script type="text/javascript" >
                (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                ym(94549275, "init", {
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true,
                        ecommerce:"dataLayer"
                });
                </script>
                <noscript><div><img src="https://mc.yandex.ru/watch/94549275" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!-- /Yandex.Metrika counter -->
            {{--    --}}

            @php($google_tag_manager_id = \App\CPU\Helpers::get_business_settings('google_tag_manager_id'))
            @if($google_tag_manager_id )
            <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{$google_tag_manager_id}}');</script>
            <!-- End Google Tag Manager -->

            @endif

            @php($pixel_analytices_user_code =\App\CPU\Helpers::get_business_settings('pixel_analytics'))
            @if($pixel_analytices_user_code)
                <!-- Facebook Pixel Code -->
                    <script>
                    !function(f,b,e,v,n,t,s)
                    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                    n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s)}(window, document,'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                    fbq('init', '{your-pixel-id-goes-here}');
                    fbq('track', 'PageView');
                    </script>
                    <noscript>
                    <img height="1" width="1" style="display:none"
                        src="https://www.facebook.com/tr?id={your-pixel-id-goes-here}&ev=PageView&noscript=1"/>
                    </noscript>
                <!-- End Facebook Pixel Code -->
            @endif
    </head>
<!-- Body-->
    <body class="toolbar-enabled navbar-vertical-aside-closed-mode mb-0">

        @php($ST = session('user_type'))
        @if($ST == 'delegate')
        @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
        @php($store = App\User::where('id',$storeId)->first())
        @php($delegateStore = App\Model\DelegatedStore::where('id',session('my_id'))->first())
        @include('layouts.front-end.partials._tob-bar_delegate')
        @endif
        @php($announcement=\App\CPU\Helpers::get_business_settings('announcement'))
        @if (isset($announcement) && $announcement['status']==1)
            <div class="hidden sm:flex justify-content-between align-items-center anouncementDiv" id="anouncement" style="background-color: #fdcd05;color:#000000;top: 0;position: fixed;z-index: 1034;">
                <span></span>
                <span class="anouncementDiv" style="text-align:center; font-size: 15px;">{{ $announcement['announcement'] }} </span>
                <span class="ml-3 mr-3 anouncementDiv" style="font-size: 12px;cursor: pointer;color: darkred"  onclick="myFunction()">X</span>
            </div>
        @endif
        <div id="main" class="sm:ms-20">
            @if($google_tag_manager_id)

            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{$google_tag_manager_id}}" height="0"
                    width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
            @endif
            <!-- Sign in / sign up modal-->
            @include('layouts.front-end.partials._modals')
            <!-- Navbar-->
            <!-- Quick View Modal-->
            @include('layouts.front-end.partials._quick-view-modal')

            @isset($hide_all)
            @else
            <!-- Navbar Electronics Store-->
            @include('layouts.front-end.partials._header')
            <!-- Page title-->

            {{--loader--}}
            <div class="row">
                <div class="col-12" style="margin-top:10rem;position: fixed;z-index: 9999;">
                    <div id="loading" style="display: none;">
                        <center>
                            <img width="200"
                                src="{{asset('storage/app/public/company')}}/{{\App\CPU\Helpers::get_business_settings('loader_gif')}}"
                                onerror="this.src='{{asset('public/assets/front-end/img/loader.gif')}}'">
                        </center>
                    </div>
                </div>
            </div>
            {{--loader--}}
            @endisset

            <!-- Page Content-->
            <div @isset($hide_all) @else id="content" class="pt-0 sm:pt-6" @endisset>
                @yield('content')
            </div>

            @isset($hide_all)
            @else
            <!-- Footer-->
            @include('layouts.landing.partials._footer')
        </div>

        <!-- Back To Top Button-->
        <a class="btn-scroll-top" href="#top" data-scroll>
            <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">Top</span><i
                class="btn-scroll-top-icon czi-arrow-up"> </i>
        </a>
        @endisset
        <!-- Vendor scrits: js libraries and plugins-->
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
        {{-- Owl Carousel --}}
        <script src="{{asset('public/assets/front-end')}}/js/owl.carousel.min.js"></script>
        {{-- Owl Carousel --}}
        <script>
            $('#flash-deal-slider').owlCarousel({
                loop: false,
                autoplay: false,
                margin: 5,
                nav: true,
                navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
                dots: false,
                autoplayHoverPause: true,
                '{{session('direction')}}': false,
                // center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 1
                    },
                    360: {
                        items: 1
                    },
                    375: {
                        items: 1
                    },
                    540: {
                        items: 2
                    },
                    //Small
                    576: {
                        items: 2
                    },
                    //Medium
                    768: {
                        items: 2
                    },
                    //Large
                    992: {
                        items: 2
                    },
                    //Extra large
                    1200: {
                        items: 2
                    },
                    //Extra extra large
                    1400: {
                        items: 3
                    }
                }
            })

            $('#web-feature-deal-slider').owlCarousel({
                loop: false,
                autoplay: true,
                margin: 5,
                nav: false,
                //navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
                dots: false,
                autoplayHoverPause: true,
                '{{session('direction')}}': true,
                // center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 1
                    },
                    360: {
                        items: 1
                    },
                    375: {
                        items: 1
                    },
                    540: {
                        items: 2
                    },
                    //Small
                    576: {
                        items: 2
                    },
                    //Medium
                    768: {
                        items: 2
                    },
                    //Large
                    992: {
                        items: 2
                    },
                    //Extra large
                    1200: {
                        items: 2
                    },
                    //Extra extra large
                    1400: {
                        items: 2
                    }
                }
            })

            $('#new-arrivals-product').owlCarousel({
                loop: true,
                autoplay: false,
                margin: 22,
                nav: true,
                navText: ["<i class='czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}'></i>", "<i class='czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}'></i>"],
                dots: false,
                autoplayHoverPause: true,
                '{{session('direction')}}': true,
                // center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 2
                    },
                    360: {
                        items: 2
                    },
                    375: {
                        items: 2
                    },
                    540: {
                        items: 2
                    },
                    //Small
                    576: {
                        items: 2
                    },
                    //Medium
                    768: {
                        items: 2
                    },
                    //Large
                    992: {
                        items: 2
                    },
                    //Extra large
                    1200: {
                        items: 4
                    },
                    //Extra extra large
                    1400: {
                        items: 4
                    }
                }
            })


            $("#cz-thumblist").owlCarousel({
                autoplay: true,
                nav: true,
                dots:true,
                @if(session('direction') == 'rtl')
                navText: ["<i style='font-size:14px !important' class='czi-arrow-right btn btn-light text-dark rounded-circle wd-1 ht-1'></i>","<i style='font-size:14px !important' class='czi-arrow-left btn btn-light text-dark rounded-circle wd-1 ht-1'></i>"],
                @else
                navText: ["<i style='font-size:14px !important' class='czi-arrow-left btn btn-light text-dark rounded-circle wd-1 ht-1'></i>","<i style='font-size:14px !important' class='czi-arrow-right btn btn-light text-dark rounded-circle wd-1 ht-1'></i>"],
                @endif
                '{{session('direction')}}': true,
            })

            $("#our-partners").owlCarousel({
                loop: true,
                autoplay: true,
                nav: true,
                @if(session('direction') == 'rtl')
                navText: ["<i class='czi-arrow-right text-white'></i>","<i class='czi-arrow-left text-white'></i>"],
                @else
                navText: ["<i class='czi-arrow-left text-white'></i>","<i class='czi-arrow-right text-white'></i>"],
                @endif
                dots: false,
                autoplayHoverPause: true,
                '{{session('direction')}}': true,
                center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 3
                    },
                    360: {
                        items: 3
                    },
                    375: {
                        items: 3
                    },
                    540: {
                        items: 2
                    },
                    //Small
                    576: {
                        items: 2
                    },
                    //Medium
                    768: {
                        items: 4
                    },
                    //Large
                    992: {
                        items: 4
                    },
                    //Extra large
                    1200: {
                        items: 10
                    },
                    //Extra extra large
                    1400: {
                        items: 10
                    }
                }
            })

            $('#featured_products_list,#latest_products_list').owlCarousel({
                loop: true,
                    autoplay: false,
                    margin: 5,
                    nav: true,
                    navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
                    dots: false,
                    autoplayHoverPause: true,
                    '{{session('direction')}}': false,
                    // center: true,
                    responsive: {
                        //X-Small
                        0: {
                            items: 1
                        },
                        360: {
                            items: 1
                        },
                        375: {
                            items: 1
                        },
                        540: {
                            items: 2
                        },
                        //Small
                        576: {
                            items: 2
                        },
                        //Medium
                        768: {
                            items: 3
                        },
                        //Large
                        992: {
                            items: 4
                        },
                        //Extra large
                        1200: {
                            items: 5
                        },
                        //Extra extra large
                        1400: {
                            items: 5
                        }
                    }
            });
            $('#brands-slider').owlCarousel({
                loop: false,
                autoplay: false,
                margin: 10,
                nav: false,
                '{{session()->get('direction')}}': true,
                //navText: ["<i class='czi-arrow-left'></i>","<i class='czi-arrow-right'></i>"],
                dots: true,
                autoplayHoverPause: true,
                // center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 2
                    },
                    360: {
                        items: 3
                    },
                    375: {
                        items: 3
                    },
                    540: {
                        items: 4
                    },
                    //Small
                    576: {
                        items: 5
                    },
                    //Medium
                    768: {
                        items: 7
                    },
                    //Large
                    992: {
                        items: 9
                    },
                    //Extra large
                    1200: {
                        items: 11
                    },
                    //Extra extra large
                    1400: {
                        items: 12
                    }
                }
            })
            $('#category-slider, #top-seller-slider').owlCarousel({
                loop: false,
                autoplay: false,
                margin: 5,
                nav: false,
                // navText: ["<i class='czi-arrow-left'></i>","<i class='czi-arrow-right'></i>"],
                dots: true,
                autoplayHoverPause: true,
                '{{session('direction')}}': true,
                // center: true,
                responsive: {
                    //X-Small
                    0: {
                        items: 2
                    },
                    360: {
                        items: 3
                    },
                    375: {
                        items: 3
                    },
                    540: {
                        items: 4
                    },
                    //Small
                    576: {
                        items: 5
                    },
                    //Medium
                    768: {
                        items: 6
                    },
                    //Large
                    992: {
                        items: 8
                    },
                    //Extra large
                    1200: {
                        items: 10
                    },
                    //Extra extra large
                    1400: {
                        items: 11
                    }
                }
            })
        </script>

        {{--<script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery.slim.min.js"></script>--}}
        <script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery-2.2.4.min.js"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('/public/assets/front-end/js/leaflet/leaflet.js')}}"></script>
        <script
            src="{{asset('public/assets/front-end')}}/vendor/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/simplebar/dist/simplebar.min.js"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/tiny-slider/dist/min/tiny-slider.js"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

        {{-- light box --}}
        <script src="{{asset('public/js/lightbox.min.js')}}"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/drift-zoom/dist/Drift.min.js"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/lightgallery.js/dist/js/lightgallery.min.js"></script>
        <script src="{{asset('public/assets/front-end')}}/vendor/lg-video.js/dist/lg-video.min.js"></script>
        {{--Toastr--}}
        <script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
        <!-- Main theme script-->
        <script src="{{asset('public/assets/front-end')}}/js/theme.min.js"></script>
        <script src="{{asset('public/assets/front-end')}}/js/slick.min.js"></script>

        <script src="{{asset('public/assets/front-end')}}/js/sweet_alert.js"></script>
        {{--Toastr--}}
        <script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
        {!! Toastr::message() !!}

        <!-- intlTelInput -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).on("click",'.fa.fa-info', function(e) {
                Swal.fire($(this).parent().attr('title'))
            });

            $(document).on("keypress",'input[t="number"]', function(e) {
                if (!/^\d*\.?\d*$/.test(String.fromCharCode(e.which))) {
                    e.preventDefault();
                }
            });

            // To handle copy-paste cases
            $(document).on("input",'input[t="number"]', function(e) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            });

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

        <!-- SumoSelect -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/sumoselect.min.css" integrity="sha512-vU7JgiHMfDcQR9wyT/Ye0EAAPJDHchJrouBpS9gfnq3vs4UGGE++HNL3laUYQCoxGLboeFD+EwbZafw7tbsLvg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/jquery.sumoselect.min.js" integrity="sha512-Ut8/+LO2wW6HfMEz1vxHpiwMMQfw7Yf/0PdpTERAbK2VJQt4eVDsmFL269zUCkeG/QcEcc/tcORSrGHlP89nBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>

                function addYourLocationButton(map, marker)
                {
                    var controlDiv = document.createElement('div');

                    var firstChild = document.createElement('div');
                    firstChild.style.backgroundColor = '#fff';
                    firstChild.style.border = 'none';
                    firstChild.style.outline = 'none';
                    firstChild.style.width = '40px';
                    firstChild.style.height = '40px';
                    firstChild.style.borderRadius = '2px';
                    firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
                    firstChild.style.cursor = 'pointer';
                    firstChild.style.marginRight = '10px';
                    firstChild.style.padding = '0px';
                    firstChild.title = 'Your Location';
                    controlDiv.appendChild(firstChild);

                    var secondChild = document.createElement('div');
                    secondChild.style.margin = '11px';
                    secondChild.style.width = '18px';
                    secondChild.style.height = '30px';
                    secondChild.style.backgroundImage = 'url({{ asset('/public/assets/admin/img/icons/my-location-svgrepo-com.png') }})';
                    secondChild.style.backgroundSize = '25px';
                    secondChild.style.backgroundPosition = 'center';
                    secondChild.style.backgroundRepeat = 'no-repeat';
                    secondChild.style.paddingTop = '40px';
                    secondChild.id = 'you_location_img';
                    firstChild.appendChild(secondChild);

                    google.maps.event.addListener(map, 'dragend', function() {
                        $('#you_location_img').css('background-position', 'center');
                    });

                    firstChild.addEventListener('click', function() {
                        var imgX = '0';
                        var animationInterval = setInterval(function(){
                            if(imgX == '-18000000px') imgX = 'center';
                            else imgX = '-18000000px';
                            $('#you_location_img').css('background-position', imgX);
                        }, 500);
                        if(navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                                marker.setPosition(latlng);
                                map.setCenter(latlng);
                                clearInterval(animationInterval);
                                $('#you_location_img').css('background-position', '-14444px 0px');
                            });
                        }
                        else{
                            clearInterval(animationInterval);
                            $('#you_location_img').css('background-position', '0px 0px');
                        }
                    });

                    controlDiv.index = 1;
                    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
                }

                function form_alert(id, message) {
                    Swal.fire({
                        title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
                        text: message,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'No',
                        confirmButtonText: 'Yes',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.value) {
                            $('#' + id).submit()
                        }
                    })
                }

                function convertArabicToEnglish(input) {
                    const arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                    const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

                    for (let i = 0; i < arabicNumbers.length; i++) {
                        const regex = new RegExp(arabicNumbers[i], 'g');
                        input = input.replace(regex, englishNumbers[i]);
                    }

                    return input;
                }

                function iformat(li,originalOption) {
                    console.log(originalOption.text())
                    if(!originalOption.index()){
                        return li;
                    }
                    if(!originalOption.attr('icon')){
                        return li;
                    }
                    $('<img class="brFlag ml-1 mr-1" onerror="this.src=\'{{asset("public/assets/front-end/img/image-place-holder.png")}}\'" src="' + originalOption.attr('icon') + '" style="width: 35px" />').insertBefore(li.find("label"));
                    li.addClass('opt d-flex')
                    return li;
                    return $('<li class="opt d-flex"><span><i></i></span><img class="brFlag ml-1 mr-1" onerror="this.src=\'{{asset("public/assets/front-end/img/image-place-holder.png")}}\'" src="' + originalOption.attr('icon') + '" style="width: 25%" /><label>'+originalOption.text()+'</label></li>');
                }
                if($('.SumoSelect-custom,.testselect2-custom').length){
                    $('.SumoSelect-custom,.testselect2-custom').SumoSelect({
                        search:true,
                        placeholder: '{{\App\CPU\Helpers::translate('Select')}}',
                        searchText: "...",
                        selectAll: true,
                        locale: ['{{\App\CPU\Helpers::translate('Ok')}}', '{{\App\CPU\Helpers::translate('Cancel')}}', '{{\App\CPU\Helpers::translate('Select All')}}'],
                        captionFormatAllSelected: '{{\App\CPU\Helpers::translate('All Selected')}}! ( {0} )',
                        captionFormat: '{0} {{\App\CPU\Helpers::translate('Selected')}}',
                        okCancelInMulti:true,
                        renderLi: (li, originalOption) => iformat(li,originalOption),
                    });
                    $('.options li.group').each(function(){
                        $(this).find('label:first').html($(this).find('label:first').text())
                        $("<i class='fa fa-angle-down absolute angle mt-2' style='{{ ((session('direction') ?? 'rtl') == 'rtl') ? 'left:5%' : 'right: 5%' }}'></i>").appendTo($(this).find('label:first').find('div'))
                        $(this).find('label:first').find('.brFlag').attr('onerror',"this.src='{{asset("public/assets/front-end/img/image-place-holder.png")}}'")
                        $(this).find('ul').hide()
                    })
                    $(document).on('click','.options li.group label',function(){
                        $(this).next('ul').slideToggle()
                        $(this).find('.angle').toggleClass('rotate')

                    })

                    $(document).on("change",".SumoSelect-custom,.multiselect,.testselect2-custom",function(){
                        $(this).closest('.form-control').next('input').val($(this).val())
                    })
                }
            </script>

        <script>

            function getChildren(objectt, selector, value){
                if(value){
                    $(ths).closest('.input-group').next('input').val(value.toString())
                    var selected = $(selector).find('option:selected').val();
                    alert_wait()
                    $.ajax({
                        url:'{{route("home")}}/getChildren/'+objectt+'/'+value,
                        success: function(data){
                            $(selector).html(data);
                            $(selector).find("option[value='"+selected+"']").attr('selected','selected');
                            if(selected){
                                $(selector).change();
                            }
                            $(selector)[0].sumo.reload();
                            Swal.close()
                        }
                    })
                }else{
                    //Swal.close()
                }
            }

            function alert_wait(){
                var timerInterval;
                    Swal.fire({
                        title: `{{ \App\CPU\Helpers::translate('Please wait')}}...`,
                        timerProgressBar: false,
                        allowOutsideClick: false,
                        showConfirmButton:false,
                        didOpen: () => {
                        Swal.showLoading();
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        },
                    }).then((result) => {
                    });
            }

            function addWishlist(product_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('store-wishlist')}}",
                    method: 'POST',
                    data: {
                        product_id: product_id
                    },
                    success: function (data) {
                        if (data.value == 1) {
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('.ri-heart-fill').css('color', '#b70101');
                            $('.countWishlist').html(data.count);
                            $('.countWishlist-' + product_id).text(data.product_count);
                            $('.tooltip').html('');
                            $('.heart').off('click').on('click', function() {
                                removeWishlistbutton(product_id);
                            });

                        } else if (data.value == 2) {
                            Swal.fire({
                                type: 'info',
                                title: 'WishList',
                                text: data.error
                            });
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'WishList',
                                text: data.error
                            });
                        }
                    }
                });
            }

            function removeWishlistbutton(product_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('delete-wishlist')}}",
                    method: 'POST',
                    data: {
                        id: product_id
                    },
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: data.success,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.ri-heart-fill').css('color', '#969696');
                        $('.countWishlist-' + product_id).text(data.product_count);
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            }

            function removeWishlist(product_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('delete-wishlist')}}",
                    method: 'POST',
                    data: {
                        id: product_id
                    },
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        Swal.fire({
                            type: 'success',
                            title: 'WishList',
                            text: data.success
                        });
                        $('.countWishlist').html(data.count);
                        $('#set-wish-list').html(data.wishlist);
                        $('.tooltip').html('');
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            }


            function quickView(product_id) {
                $.get({
                    url: '{{route('quick-view')}}',
                    dataType: 'json',
                    data: {
                        product_id: product_id
                    },
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        console.log("success...")
                        $('#quick-view').modal('show');
                        $('#quick-view-modal').empty().html(data.view);
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            }

            function addToCart(el,form_id = 'add-to-cart-form', redirect_to_checkout=false) {
                if (checkAddToCartValidity()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.post({
                        url: '{{ route('cart.add') }}',
                        data: $('#' + form_id).serializeArray(),
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.status == 1) {
                                updateNavCart();
                                toastr.success(response.message, {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                                    $(el).attr('disabled', '');
                                    $(el).removeClass("bg-primary");
                                    $(el).addClass("bg-color-changed");
                                    var addToListText = '{{ Helpers::translate("Added_to_cart") }}';
                                    $(el).find("p").last().text(addToListText);
                                $('.call-when-done').click();
                                if(redirect_to_checkout)
                                {
                                    location.href = "{{route('checkout-details')}}";
                                }
                                return false;
                            } else if (response.status == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Cart',
                                    text: response.message
                                });
                                return false;
                            }
                        },
                        complete: function () {
                            $('#loading').hide();

                        }
                    });
                } else {
                    Swal.fire({
                        type: 'info',
                        title: 'Cart',
                        text: '{{\App\CPU\Helpers::translate('please_choose_all_the_options')}}'
                    });
                }
            }
            function updateSelectedCount() {
                // حساب عدد الcheckboxes المحددة
                var selectedCount = $("input.product-checkbox:checked").length;
                // تحديث النص داخل الزر
                $("#selectedCount").text(selectedCount);
            }
            function updateButtonWithSelectedCount() {
                var selectedCount = $('input.product-checkbox:checked').length;
                var buttonText = '{{\App\CPU\Helpers::translate('Add to my products list')}}';
                if (selectedCount > 0) {
                    buttonText += ' (' + selectedCount + ')';
                }
                $('.addto-list').text(buttonText);
            }

            $(document).on('change', 'input.product-checkbox', function() {
                updateSelectedCount();
            });

            $(document).ready(function() {
                $(document).on('change', 'input.product-checkbox', function() {
                    var selectedCount = $('input.product-checkbox:checked').length;

                    if (selectedCount > 0) {
                        $('#selectAllButton').show();
                        $('#selection-buttons-container').css('display', 'inline-grid');
                    } else {
                        $('#selectAllButton').hide();
                        $('#selection-buttons-container').hide();
                    }
                });
            });
            $('#selectAllButton').click(function() {
                $('input.product-checkbox').prop('checked', true).change();

                // إضافة الفئات إلى كل العناصر التي لها class `product-single-hover`
                $('.product-single-hover').each(function() {
                    var stock = $(this).find('.current-stock').text();
                    if (parseInt(stock) === 0) {
                        $(this).find('.product-checkbox').prop('disabled', true);
                    }
                });
            });
            $(document).ready(function() {
                $('#selectAllButton').click(function() {
                    // تحديد جميع مربعات الاختيار
                    $('input.product-checkbox').prop('checked', true).change();

                    // إضافة الفئات إلى كل العناصر التي لها class `product-single-hover`
                    $('.product-single-hover').each(function() {
                        var stock = $(this).find('.current-stock').text();
                        if (parseInt(stock) === 0) {
                            $(this).find('.product-checkbox').prop('disabled', true);
                        }
                    });
                });

                // إضافة المعالج لحدث تغيير حالة مربعات الاختيار
                $('input.product-checkbox').change(function() {
                    // تحديث عرض أو إخفاء الزر بناءً على الحالة الجديدة
                    var checkedNum = $('input.product-checkbox:checked').length;
                    if (checkedNum > 0) {
                        $('#selectAllButton').show();
                    } else {
                        $('#selectAllButton').hide();
                        $('.product-single-hover').removeClass("checked-product border border-primary border-xl");
                    }
                });
            });

            $(document).ready(function() {
                // عند النقر على زر إلغاء تحديد الكل
                $('#deselectAllButton').click(function() {
                    // إلغاء تحديد جميع مربعات الاختيار
                    $('input.product-checkbox').prop('checked', false).change();

                    // إزالة الفئات من العناصر التي لها class `product-single-hover`
                    $('.product-single-hover').removeClass("checked-product border border-primary border-xl");

                    // أخفي زر إلغاء التحديد
                    $(this).hide();
                });

                // إضافة المعالج لحدث تغيير حالة مربعات الاختيار
                $('input.product-checkbox').change(function() {
                    var checkedNum = $('input.product-checkbox:checked').length;
                    // عرض زر إلغاء التحديد إذا كان هناك عناصر محددة
                    if (checkedNum > 0) {
                        $('#selectAllButton').show();
                        $('#deselectAllButton').show();
                    } else {
                        $('#selectAllButton').hide();
                        $('#deselectAllButton').hide();
                    }
                });
            });



            function addToLinked(e,el,product_id){
                $.ajax({
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: product_id,
                    },
                    url:"{{ route('linked-products.add') }}",
                    success:function(data){
                        if(data == "out"){
                            toastr.error('{{\App\CPU\Helpers::translate("out_of_stock")}}');
                        }else{
                            $(".product-single-hover.checked-product").each(function(){
                                $(this).find("._add-linked").attr('disabled', 'disabled');
                                $(this).find("._add-linked").removeClass("bg-primary");
                                $(this).find("._add-linked").addClass("bg-color-changed");
                                var addToListText = '{{ Helpers::translate("Added_to_list") }}';
                                $(this).find("._add-linked p").last().text(addToListText);
                            });
                            $(el).addClass('disabled');
                            $(el).removeClass("bg-primary");
                            $(el).addClass("bg-color-changed");
                            $(el).attr('onclick','');
                            $(el).attr('disabled','disabled');
                            $(el).closest('.product-single-hover').prev('.form-group').find('.product-checkbox').attr('checked','checked');
                            $(el).closest('.product-single-hover').prev('.form-group').hide();
                            var addToListText = '{{ Helpers::translate("Added_to_list") }}';
                            $(el).find("p").last().text(addToListText);
                            toastr.success('{{\App\CPU\Helpers::translate('Product added to your list')}}');
                        }
                    }
                })
            }

            function restoreToLinked(e,el,product_id){
                alert_wait();
                $.ajax({
                    url:"{{ route('linked-products.add') }}?product_id="+product_id,
                    success:function(data){
                        $(el).addClass('disabled');
                        $(el).attr('onclick','');
                        $(el).attr('disabled','disabled');
                        $(el).closest('.product-single-hover').prev('.form-group').find('.product-checkbox').attr('checked','checked');
                        $(el).closest('.product-single-hover').prev('.form-group').hide();
                        toastr.success('{{\App\CPU\Helpers::translate('Product added to your list')}}');
                        location.reload();
                    }
                })
            }


            function addAllToLinked(e, el) {
                // جمع معرفات المنتجات من مربعات الاختيار المحددة
                var products_id = $('input.product-checkbox:checked').map(function() {
                    return this.value;
                }).get(); // تأكد من استخدام .get() لتحويل النتيجة إلى مصفوفة

                // التحقق من أن products_id هي مصفوفة
                if (Array.isArray(products_id)) {
                    var product_ids_string = products_id.join(',');
                    // الآن يمكنك استخدام product_ids_string في الطلب الأجاكس
                    $.ajax({
                        url: "{{ route('linked-products.addall') }}",
                        data: {
                            product_id: product_ids_string,
                            _token: '{{ csrf_token() }}'
                        },
                        success:function(data){
                            $(".product-single-hover.checked-product").each(function(){
                                $(this).find("._add-linked").attr('disabled', 'disabled');
                                $(this).find("._add-linked").removeClass("bg-primary");
                                $(this).find("._add-linked").addClass("bg-color-changed");
                                var addToListText = '{{ Helpers::translate("Added_to_list") }}';
                                $(this).find("._add-linked p").last().text(addToListText);
                            });
                            $(el).attr('disabled','disabled');
                            $("#linkedProducts").val('');
                            $(".product-single-hover.checked-product").each(function(){
                                $(this).removeClass("border border-primary border-xl");
                                $(this).removeClass("bg-primary");
                                $(this).addClass("bg-color-changed");
                                $(this).prev(".form-group").hide();
                                $(this).css('background-color', '#8471a6');
                                $(this).find("._add-linked").attr('disabled', 'disabled');

                                var addToListText = '{{ Helpers::translate("Added_to_list") }}';
                                $(this).find("._add-linked p").last().text(addToListText);
                            });

                            // إزالة التحديد من جميع مربعات الاختيار
                            $('input.product-checkbox').prop('checked', false).change();
                            toastr.success('{{\App\CPU\Helpers::translate('Products added to your list')}}');
                        }            });
                } else {
                    console.error('products_id is not an array');
                }
            }


            function buy_now() {
                addToCart('add-to-cart-form',true);
                /* location.href = "{{route('checkout-details')}}"; */
            }

            function currency_change(currency_code) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('currency.change')}}',
                    data: {
                        currency_code: currency_code
                    },
                    success: function (data) {
                        toastr.success('{{\App\CPU\Helpers::translate('Currency changed to')}}' + data.name);
                        location.reload();
                    }
                });
            }

            function removeFromCart(key) {
                $.post('{{ route('cart.remove') }}', {_token: '{{ csrf_token() }}', key: key}, function (response) {
                    $('#cod-for-cart').hide();
                    updateNavCart();
                    $('#cart-summary').empty().html(response.data);
                    toastr.info('{{\App\CPU\Helpers::translate('Item has been removed from cart')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    let segment_array = window.location.pathname.split('/');
                    let segment = segment_array[segment_array.length - 1];
                    if(segment === 'checkout-payment' || segment === 'checkout-details'){
                        location.reload();
                    }
                    setTimeout(function(){
                        $(".dropdown-menu.dropdown-menu-left").show();
                    },500)
                });
            }

            function updateNavCart() {
                $.post('{{route('cart.nav-cart')}}', {_token: '{{csrf_token()}}'}, function (response) {
                    $('#cart_items').html(response.data);
                });
            }

            function cartQuantityInitialize() {
                $('.btn-number').click(function (e) {
                    e.preventDefault();

                    fieldName = $(this).attr('data-field');
                    type = $(this).attr('data-type');
                    productType = $(this).attr('product-type');
                    var input = $(".quantity-input,input[name='"+fieldName+"']");
                    var currentVal = parseInt(input.val());
                    if (!isNaN(currentVal)) {
                        console.log(productType)
                        if (type == 'minus') {
                            if (currentVal > $(this).attr('mn-field')) {
                                input.val(currentVal - 1).change();
                                $(".btn-plus").removeAttr("disabled")
                            }
                            if (parseInt(input.val()) == $(this).attr('mn-field')) {
                                $(this).attr('disabled', true);
                            }

                        } else if (type == 'plus') {
                            if (currentVal < $(this).attr('mx-field') || (productType === 'digital' || currentVal < $(this).attr('mx-field'))) {
                                input.val(currentVal + 1).change();
                                $(".btn-minus").removeAttr("disabled")
                            }else{
                            }

                            if ((parseInt(input.val()) == $(this).attr('mx-field')) && (productType === 'physical')) {
                                $(this).attr('disabled', true);
                            }

                        }
                        getVariantPrice()
                    } else {
                        input.val(0);
                    }
                });

                $('.input-number').focusin(function () {
                    $(this).data('oldValue', $(this).val());
                });

                $('.input-number').change(function () {
                    productType = $(this).attr('product-type');
                    minValue = parseInt($(this).attr('min'));
                    maxValue = parseInt($(this).attr('max'));
                    valueCurrent = parseInt($(this).val());

                    var name = $(this).attr('name');
                    if (valueCurrent >= minValue) {
                        $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: '{{\App\CPU\Helpers::translate("Sorry, the minimum order quantity does not match")}}'
                        });
                        $(this).val($(this).data('oldValue'));
                    }
                    if (productType === 'digital' || valueCurrent <= maxValue) {
                        $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: '{{\App\CPU\Helpers::translate('Sorry, stock limit exceeded')}}.'
                        });
                        $(this).val($(this).data('oldValue'));
                    }


                });
                $(".input-number").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                        // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
            }

            function updateQuantity(key, element) {
                $.post('<?php echo e(route('cart.updateQuantity')); ?>', {
                    _token: '<?php echo e(csrf_token()); ?>',
                    key: key,
                    quantity: element.value
                }, function (data) {
                    updateNavCart();
                    $('#cart-summary').empty().html(data);
                });
            }

            function updateCartQuantity(minimum_order_qty, key, maximum_order_qty) {
                /* var quantity = $("#cartQuantity" + key).children("option:selected").val(); */
                var quantity = $("#cartQuantity" + key).val();
                if(parseInt(minimum_order_qty) > parseInt(quantity) ) {
                    toastr.error('{{\App\CPU\Helpers::translate("minimum_order_quantity_cannot_be_less_than_")}}' + minimum_order_qty);
                    $("#cartQuantity" + key).val(minimum_order_qty);
                    return false;
                }
                if(parseInt(maximum_order_qty) < parseInt(quantity) ) {
                    toastr.error('{{\App\CPU\Helpers::translate("maximum_order_quantity_cannot_be_more_than_")}}' + maximum_order_qty);
                    $("#cartQuantity" + key).val(maximum_order_qty);
                    return false;
                }
                $.post('{{route('cart.updateQuantity')}}', {
                    _token: '{{csrf_token()}}',
                    key: key,
                    quantity: quantity
                }, function (response) {
                    if (response.status == 0) {
                        toastr.error(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $("#cartQuantity" + key).val(response['qty']);
                    } else {
                        updateNavCart();
                        $('#cart-summary').empty().html(response);
                    }
                });
            }

            $('#add-to-cart-form input').on('change', function () {
                getVariantPrice();
            });

            function getVariantPrice() {
                if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{ route('cart.variant_price') }}',
                        data: $('#add-to-cart-form').serializeArray(),
                        success: function (data) {
                            console.log(data)
                            $('#chosen_price_div').removeClass('d-none');
                            $('#chosen_price').html(data.price);
                            //$('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                            //$('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                            $('#set-tax-amount').html(data.tax);
                            $('#set-discount-amount').html(data.discount);
                            $('#available-quantity').html(data.quantity);
                            $('.cart-qty-field').attr('max', data.quantity);
                        }
                    });
                }
            }

            function checkAddToCartValidity() {
                var names = {};
                $('#add-to-cart-form input:radio').each(function () { // find unique names
                    names[$(this).attr('name')] = true;
                });
                var count = 0;
                $.each(names, function () { // then count them
                    count++;
                });
                if ($('input:radio:checked').length == count) {
                    return true;
                }
                return false;
            }

            $(document).ready(function () {

                $(".footer").insertAfter("#content");
            });

            $(document).ready(function () {
                setTimeout(function(){
                        //sidebar
                    if($("#mySidebar").length){
                        if($('body').width() >= 640){
                            document.getElementById("mySidebar").classList.add('sm:w-20');
                            document.getElementById("mySidebar").classList.add('w-0')
                            document.getElementById("mySidebar").style.zIndex = "1034";
                            document.getElementById("mySidebar").classList.remove('expanded');
                            if($('body').width() >= 640){
                                @if((session('direction') ?? 'rtl') == 'ltr')
                                //document.getElementById("main").style.marginLeft = "85px";
                                @else
                                //document.getElementById("main").style.marginRight = "85px";
                                @endif
                            }
                        }else{
                            document.getElementById("mySidebar").classList.remove('w-full')
                            document.getElementById("mySidebar").classList.add('w-0')
                            $("#mySidebar").show();
                        }
                        $("#mySidebar").show();
                        this.mini = true;
                        //sidebar end
                        @if(Request::is('/') &&  \Illuminate\Support\Facades\Cookie::has('popup_banner')==false)
                        $('#popup-modal').appendTo("body").modal('show');
                        @php(\Illuminate\Support\Facades\Cookie::queue('popup_banner', 'off', 1))
                        @endif
                    }
                },1000)



            });

            $(document).on('click','.add-to-store',function(){

            })

            $(document).on('change','.product-checkbox',function(){
                if($(this).is(":checked")){
                    $(this).closest('.form-group').next(".product-single-hover").addClass("checked-product border border-primary border-xl")
                }else{
                    $(this).closest('.form-group').next(".product-single-hover").removeClass("checked-product border border-primary border-xl")
                }
                var selectedProducts = [];
                var i = 0;
                $(".product-checkbox:checked").each(function(){
                    var val = $(this).val();
                    selectedProducts.push(val)
                    i++;
                })
                if(i){
                    $(".addto-list").show();
                    $(".addto-list").addClass('sm:block');
                }else{
                    $(".addto-list").hide();
                    $(".addto-list").removeClass('sm:block');
                }
                $("#linkedProducts").val(selectedProducts.toString());
            })

            $(".clickable").click(function () {
                window.location = $(this).find("a").attr("href");
                return false;
            });
        </script>

        @if ($errors->any())
            <script>
                @foreach($errors->all() as $error)
                toastr.error('{{$error}}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
                @endforeach
            </script>
        @endif

        @if (request()->errors)
            <script>
                @foreach($errors->errors as $error)
                toastr.error('{{$error}}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
                @endforeach
            </script>
        @endif

        @if (request()->error)
            <script>
                toastr.error('{{ request()->error }}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
            </script>
        @endif

        <script>
            function couponCode() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{ route('coupon.apply') }}',
                    data: $('#coupon-code-ajax').serializeArray(),
                    success: function (data) {
                        /* console.log(data);
                        return false; */
                        if (data.status == 1) {
                            let ms = data.messages;
                            ms.forEach(
                                function (m, index) {
                                    toastr.success(m, index, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            );
                        } else {
                            let ms = data.messages;
                            ms.forEach(
                                function (m, index) {
                                    toastr.error(m, index, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            );
                        }
                        setInterval(function () {
                            location.reload();
                        }, 2000);
                    }
                });
            }

            @auth('customer')
            setInterval(function () {
                $.get("{{route('notifications.get')}}").then(d => {$(".countNotifications").text(d)})
            }, 10000);
            @endauth

            jQuery(".search-bar-input").keyup(function () {
                $(".search-card").css("display", "block");
                let name = $(".search-bar-input").val();
                if (name.length > 2) {
                    $.get({
                        url: '{{url('/')}}/searched-products',
                        dataType: 'json',
                        data: {
                            name: name
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            $('.search-result-box').empty().html(data.result)
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    $('.search-result-box').empty();
                }
            });

            jQuery(".search-bar-input-mobile").keyup(function () {
                $(".search-card").css("display", "block");
                let name = $(".search-bar-input-mobile").val();
                if (name.length > 0) {
                    $.get({
                        url: '{{url('/')}}/searched-products',
                        dataType: 'json',
                        data: {
                            name: name
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            $('.search-result-box').empty().html(data.result)
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    $('.search-result-box').empty();
                }
            });

            jQuery(document).mouseup(function (e) {
                var container = $(".search-card");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.hide();
                }
            });



            function route_alert(route, message) {
                Swal.fire({
                    title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '{{$web_config['primary_color']}}',
                    cancelButtonText: '{{\App\CPU\Helpers::translate('No')}}',
                    confirmButtonText: '{{\App\CPU\Helpers::translate('Yes')}}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        location.href = route;
                    }
                })
            }

            function copyToClipboard(v) {
                var $temp = $("<input>");
                $("html").append($temp);
                $temp.val(v).select();
                document.execCommand("copy");
                $temp.remove();
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const footer = document.querySelector('.footer'); // حدد الـfooter بواسطة الكلاس

                function checkFooterPosition() {
                    // حساب ارتفاع النافذة
                    const windowHeight = window.innerHeight;

                    // حساب ارتفاع المحتوى الكلي للصفحة
                    const bodyHeight = document.body.scrollHeight;

                    // إذا كان ارتفاع المحتوى أقل من ارتفاع النافذة
                    if (bodyHeight < windowHeight) {
                        footer.style.position = 'static'; // أو 'absolute' حسب تصميمك الأصلي
                        //footer.style.position = 'fixed';
                        //footer.style.bottom = '0';
                        //footer.style.width = '100%';
                    } else {
                        footer.style.position = 'static'; // أو 'absolute' حسب تصميمك الأصلي
                    }
                }

                // تحقق من موضع الـfooter عند تحميل الصفحة
                checkFooterPosition();

                // أعد التحقق عند تغيير حجم النافذة
                window.addEventListener('resize', checkFooterPosition);
            });
            </script>

        <script>
            $(document).ready(function() {
                // تكرار على جميع العناصر بفئة .navbar-tool-label
                $(".navbar-tool-label").each(function() {
                    // تحقق من محتوى العنصر الحالي
                    var content = $(this).text().trim();

                    // إذا كان المحتوى يساوي '0'
                    if (content === '0') {
                        // اخفِ هذا العنصر
                        $(this).hide();
                    }
                });
            });
        </script>



        <script>
            $(document).on('click','#help-center-button', function() {
                let currentPath = window.location.pathname.substring(1);

                if (currentPath === '') {
                    // إذا كان المسار فارغًا، توجيه المستخدم إلى '/education'
                    window.location.href = `${window.location.origin}/education`;
                } else {
                    // إلا ذلك، استبدل الشرطات المائلة وانتقل إلى الرابط المحدد
                    currentPath = currentPath.replace(/\//g, '-');
                    const eduPath = `${window.location.origin}/education/article/${currentPath}`;
                    window.open(eduPath, '_blank');
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                var slug = window.location.pathname.substring(1); // إزالة الشرطة المائلة الأولى
                slug = slug.replace(/\//g, '-'); // استبدال الشرط المائلة الباقية إذا وجدت

                $.get(`/education/back-end/check-url/${slug}`, function(response) {
                    if(response === '1') {
                        console.log('1');
                        console.log(slug);
                        $("#help-center-button").prop('disabled', false).css('background-color', '#FDCD05');
                    } else {
                        console.log(slug);
                        $("#help-center-button").prop('disabled', true).css('background-color', '#e6e6e6');
                    }
                });
            });
        </script>





        @stack('script')


        <script>
            $(window).on('load' , function() {
                if($(".navbar-vertical-content li.active").length) {
                    $('.navbar-vertical-content').animate({
                        scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                    }, 10);
                }
            });
        </script>


        <!-- JS Implementing Plugins -->
        @if($_SERVER['SERVER_NAME'] !== "platform.masfufat.com")
        @if($_SERVER['SERVER_NAME'] == "masfufat.com")
        <script id="respondio__widget" src="https://cdn.respond.io/webchat/widget/widget.js?cId=6fbe80a90fa9dde3a56998e3e891764"></>
        @endif
        @endif
    </body>
</html>
