<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="theme-color" content="{{ $settings['website_primary_color'] }}">
@include('admin-views.education.frontend.configurations.metaTags')
<title>{{ $settings['website_name'] }} — @auth {{ \App\CPU\Helpers::translate(User', 'user') }} -@endauth @yield('title')</title>
<link rel="shortcut icon" href="{{ asset($settings['website_favicon']) }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700&display=swap">
