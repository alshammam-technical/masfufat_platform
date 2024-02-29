<!DOCTYPE html>
<html lang="sa" dir="{{session()->get('direction') ?? 'rtl'}}">

<head>
    @include('web-views.education.frontend.includes.head')
    @include('web-views.education.frontend.includes.styles')
</head>

<body @if (isset($hideSearch))class="page"@endif>
    @include('web-views.education.frontend.configurations.config')
    @if (!isset($hideSearch))
        <header class="header">
            <nav class="nav-bar">
                <div class="container-lg d-flex align-items-center justify-content-between h-100" style="min-width: -webkit-fill-available;margin-right: 5rem;">
                    <a class="logo" href="{{ url('/') }}" style="height: 230px;">
                        <img src="{{asset('storage/app/public/company/2-01.png')}}"
                            alt="{{ config('app.name', 'Laravel') }}" />
                    </a>
                    <div class="nav-bar-actions">
                        <div class="nav-bar-actions-menu">
                            <div class="nav-bar-actions-close">
                                <i class="fa fa-times fa-lg"></i>
                            </div>

                        </div>
                        <div class="actions-menu-btn">
                            <i class="fa fa-bars fa-lg"></i>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="wrapper">
                <div class="container-lg d-flex align-items-center h-100">
                    <div class="wrapper-content">
                        <h1 class="wrapper-content-title text-center mb-3">
                            {{ \App\CPU\Helpers::translate('Welcome to the training package for the masfufat platform') }}</h1>
                        <p class="wrapper-content-text text-center mb-4">
                            {{ \App\CPU\Helpers::translate("Start search to find what you are looking for") }}
                        </p>
                        <div class="search">
                            <div class="search-input">
                                <form action="{{ route('education.home') }}" method="GET">
                                    <input type="text" name="q" placeholder="{{ \App\CPU\Helpers::translate('Search') }}..."
                                        autocomplete="off" required />
                                    <button class="btn btn-primary btn-lg">
                                        <i class="fa fa-search me-1"></i>
                                        {{ \App\CPU\Helpers::translate('Search') }}
                                    </button>
                                </form>
                            </div>
                            <div class="search-results" data-simplebar>
                                <div class="ajax-search-results"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper-wave"></div>
            </div>
        </header>
    @else
        <header class="header header-title">
            <nav class="nav-bar">
                <div class="container-lg d-flex align-items-center justify-content-between h-100">
                    <a class="logo" href="{{ url('/') }}">
                        <img src="{{ asset($settings['website_light_logo']) }}"
                            alt="{{ $settings['website_name'] }}" />
                    </a>
                    <div class="nav-bar-actions">
                        <div class="nav-bar-actions-menu">
                            <div class="nav-bar-actions-close">
                                <i class="fa fa-times fa-lg"></i>
                            </div>
                            <div class="dropdown language language-light">
                                <button data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="language-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    {{ getLangName() }}
                                    <div class="language-arrow">
                                        <i class="fas fa-chevron-down fa-xs"></i>
                                    </div>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    @foreach ($languages as $language)
                                        <li><a class="dropdown-item @if (app()->getLocale() == $language->code) active @endif"
                                                href="{{ langURL($language->code) }}">{{ $language->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @guest
                                <a href="{{ route('login') }}"
                                    class="btn btn-light btn-lg">{{ \App\CPU\Helpers::translate('Sign In', 'user') }}</a>
                                @if ($settings['website_registration_status'])
                                    <a href="{{ route('register') }}"
                                        class="btn btn-outline-light btn-lg">{{ \App\CPU\Helpers::translate('Sign Up', 'user') }}</a>
                                @endif
                            @endguest
                        </div>
                        @auth
                            <div class="user-menu ms-3" data-dropdown>
                                <div class="user-avatar">
                                    <img src="{{ asset(userAuthInfo()->avatar) }}" alt="{{ userAuthInfo()->name }}">
                                </div>
                                <p class="user-name text-white mb-0 ms-2 d-none d-sm-block">{{ userAuthInfo()->name }}
                                </p>
                                <div class="nav-bar-user-dropdown-icon ms-2 d-none text-white d-sm-block">
                                    <i class="fas fa-chevron-down fa-xs"></i>
                                </div>
                                <div class="user-menu-dropdown">
                                    <a class="user-menu-link" href="{{ route('user.tickets') }}">
                                        <i class="far fa-life-ring"></i> {{ \App\CPU\Helpers::translate('My Tickets', 'user') }}
                                    </a>
                                    <a class="user-menu-link" href="{{ route('user.settings') }}">
                                        <i class="fa fa-cog"></i> {{ \App\CPU\Helpers::translate('settings', 'user') }}
                                    </a>
                                    <form class="d-inline" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="user-menu-link text-danger">
                                            <i class="fa fa-power-off"></i> {{ \App\CPU\Helpers::translate('Logout', 'user') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                        <div class="actions-menu-btn light">
                            <i class="fa fa-bars fa-lg"></i>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="header-page-title">
                <h2>{{ $page->title }}</h2>
            </div>
        </header>
    @endif
    @yield('content')
    @include('admin-views.education.frontend.includes.footer')
    @include('admin-views.education.frontend.configurations.widgets')
    @include('admin-views.education.frontend.includes.scripts')
</body>

</html>
