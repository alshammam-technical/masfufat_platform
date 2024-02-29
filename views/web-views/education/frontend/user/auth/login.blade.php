@extends('admin-views.education.frontend.user.layouts.auth')
@section('title', \App\CPU\Helpers::translate(Sign In', 'user'))
@section('content')
    <div class="vr__sign__form vr__login">
        <div class="vr__sign__header">
            <p class="h3 mb-1">{{ \App\CPU\Helpers::translate(Welcome!', 'user') }}</p>
            <p class="mb-0">{{ \App\CPU\Helpers::translate(Login to your account', 'user') }}</p>
        </div>
        <div class="sign-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Email address', 'forms') }}" value="{{ old('email') }}" required>
                    <label>{{ \App\CPU\Helpers::translate(Email address', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Password', 'forms') }}" required>
                    <label>{{ \App\CPU\Helpers::translate(Password', 'forms') }}</label>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ \App\CPU\Helpers::translate(Remember Me', 'user') }}</label>
                    </div>
                    <a class="vr__link__color" href="{{ route('password.request') }}">
                        {{ \App\CPU\Helpers::translate(Forgot Your Password?', 'user') }}
                    </a>
                </div>
                {!! app('captcha')->display() !!}
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary btn-lg w-full">{{ \App\CPU\Helpers::translate(Sign In', 'user') }}</button>
                </div>
                @if (env('FACEBOOK_CLIENT_ID') && env('FACEBOOK_CLIENT_SECRET'))
                    <div class="vr__login__with mt-3">
                        <div class="divider">
                            <span>{{ \App\CPU\Helpers::translate(Or', 'user') }}</span>
                        </div>
                        <div class="login-links mt-3">
                            <a href="{{ route('provider.login', 'facebook') }}" class="btn btn-facebook btn-lg w-full">
                                <span class="icon">
                                    <i class="fab fa-facebook-square fa-2x"></i>
                                </span>
                                <span class="text">{{ \App\CPU\Helpers::translate(Sign in With Facebook', 'user') }}</span>
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
