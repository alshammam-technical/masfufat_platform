@extends('admin-views.education.frontend.user.layouts.auth')
@section('title', \App\CPU\Helpers::translate(Confirm Password', 'user'))
@section('content')
    <div class="vr__sign__form vr__login">
        <div class="vr__sign__header">
            <p class="h3 mb-1">{{ \App\CPU\Helpers::translate(Confirm Password', 'user') }}</p>
            <p class="mb-0">{{ \App\CPU\Helpers::translate(Please confirm your password before continuing.', 'user') }}</p>
        </div>
        <div class="sign-body">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Password', 'forms') }}">
                    <label>{{ \App\CPU\Helpers::translate(Password', 'forms') }}</label>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <a class="vr__link__color" href="{{ route('user.password.request') }}">
                        {{ \App\CPU\Helpers::translate(Forgot Your Password?', 'user') }}
                    </a>
                </div>
                <div class="d-flex">
                    <button type="submit"
                        class="btn btn-primary btn-lg w-full">{{ \App\CPU\Helpers::translate(Confirm Password', 'user') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
