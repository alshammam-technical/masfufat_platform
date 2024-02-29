@extends('admin-views.education.frontend.user.layouts.auth')
@section('title', \App\CPU\Helpers::translate(Reset Password', 'user'))
@section('content')
    <div class="vr__sign__form vr__reset">
        <div class="vr__sign__header">
            <p class="h3 mb-1">{{ \App\CPU\Helpers::translate(Reset Password', 'user') }}</p>
            <p class="mb-0">
                {{ \App\CPU\Helpers::translate(Enter a new password to continue.', 'user') }}
            </p>
        </div>
        <div class="sign-body">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Email address', 'forms') }}" value="{{ $email }}" required readonly>
                    <label>{{ \App\CPU\Helpers::translate(Email address', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Password', 'forms') }}" required autofocus>
                    <label>{{ \App\CPU\Helpers::translate(Password', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Confirm password', 'forms') }}" required>
                    <label>{{ \App\CPU\Helpers::translate(Confirm password', 'forms') }}</label>
                </div>
                {!! app('captcha')->display() !!}
                <div class="d-flex">
                    <button class="btn btn-primary btn-lg w-full">{{ \App\CPU\Helpers::translate(Reset', 'user') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
