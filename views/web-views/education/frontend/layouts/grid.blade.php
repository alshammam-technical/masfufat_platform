<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{session()->get('direction') ?? 'rtl'}}">

<head>
    @include('web-views.education.frontend.includes.head')
    @include('web-views.education.frontend.includes.styles')
</head>
<style>
    .toast-top-right {
        top: 90px;
    }

</style>

<body class="page bg-white">
    @include('web-views.education.frontend.configurations.config')
    <header class="header">
        <nav class="nav-bar article-style">
            <div class="container-fluid d-flex align-items-center h-100">
                <div class="sidebar-toggle me-3 d-lg-none">
                    <i class="fa fa-bars"></i>
                </div>
                <a class="logo w-auto" href="{{route('education.home')}}" style="height: 111px;">
                    <img src="{{asset('storage/app/public/company/2023-08-06-64cfe1f554695.png')}}" alt="Masfufat" />
                </a>
                <div class="search search-v2 me-4">
                    <div class="search-input">
                        <form action="{{ route('education.home') }}" method="GET">
                            <input type="text" name="q" placeholder="{{ \App\CPU\Helpers::translate('Search') }}..."
                                value="{{ request()->input('q') ?? '' }}" autocomplete="off" required style="direction: rtl;"/>
                            <div class="search-icon">
                                <i class="fa fa-search d-none d-lg-block"></i>
                                <div class="search-close d-lg-none">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="search-results" data-simplebar>
                        <div class="ajax-search-results"></div>
                    </div>
                </div>

            </div>
        </nav>
    </header>
    @yield('content')
    @include('admin-views.education.frontend.includes.footer')
    @include('admin-views.education.frontend.configurations.widgets')
    @include('admin-views.education.frontend.includes.scripts')
</body>

</html>
