@extends('admin-views.education.frontend.user.layouts.auth')
@section('title', \App\CPU\Helpers::translate(Sign Up', 'user'))
@section('content')
    <div class="vr__sign__form vr__register">
        <div class="vr__sign__header">
            <p class="h3 mb-1">{{ \App\CPU\Helpers::translate(Create account', 'user') }}</p>
            <p class="mb-0">{{ \App\CPU\Helpers::translate(Fill this form to create a new account.', 'user') }}</p>
        </div>
        <div class="sign-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input id="firstname" type="firstname" name="firstname" class="form-control"
                                placeholder="{{ \App\CPU\Helpers::translate(First Name', 'forms') }}" maxlength="50"
                                value="{{ old('firstname') }}" required>
                            <label>{{ \App\CPU\Helpers::translate(First Name', 'forms') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input id="lastname" type="lastname" name="lastname" class="form-control"
                                placeholder="{{ \App\CPU\Helpers::translate(Last Name', 'forms') }}" maxlength="50"
                                value="{{ old('lastname') }}" required>
                            <label>{{ \App\CPU\Helpers::translate(Last Name', 'forms') }}</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input id="username" type="username" name="username" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Username', 'forms') }}" minlength="6" maxlength="50"
                        value="{{ old('username') }}" required>
                    <label>{{ \App\CPU\Helpers::translate(Username', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <select id="country" name="country" class="form-select" required>
                        @foreach ($countries as $country)
                            <option data-code="{{ $country->code }}" data-id="{{ $country->id }}"
                                value="{{ $country->id }}" @if ($country->id == old('country')) selected @endif>{{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    <label>{{ \App\CPU\Helpers::translate(Country', 'forms') }}</label>
                </div>
                <div class="form-number mb-3">
                    <select id="mobile_code" name="mobile_code" class="form-select flex-shrink-0 w-auto">
                        @foreach ($countries as $country)
                            <option data-code="{{ $country->code }}" data-id="{{ $country->id }}"
                                value="{{ $country->id }}" @if ($country->id == old('mobile_code')) selected @endif>{{ $country->code }}
                                ({{ $country->phone }})</option>
                        @endforeach
                    </select>
                    <div class="form-floating w-full">
                        <input id="mobile" type="tel" name="mobile" class="form-control"
                            placeholder="{{ \App\CPU\Helpers::translate(Phone Number', 'forms') }}" value="{{ old('mobile') }}" required>
                        <label>{{ \App\CPU\Helpers::translate(Phone Number', 'forms') }}</label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input id="email" type="email" name="email" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Email address', 'forms') }}" value="{{ old('email') }}" required>
                    <label>{{ \App\CPU\Helpers::translate(Email address', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input id="password" type="password" name="password" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Password', 'forms') }}" minlength="8" required>
                    <label>{{ \App\CPU\Helpers::translate(Password', 'forms') }}</label>
                </div>
                <div class="form-floating mb-3">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                        placeholder="{{ \App\CPU\Helpers::translate(Confirm password', 'forms') }}" minlength="8" required>
                    <label>{{ \App\CPU\Helpers::translate(Confirm password', 'forms') }}</label>
                </div>
                @if ($settings['terms_of_service_link'])
                    <div class="form-check mb-3">
                        <input id="terms" name="terms" class="form-check-input" type="checkbox" @if (old('terms')) checked @endif
                            required>
                        <label class="form-check-label">
                            {{ \App\CPU\Helpers::translate(I agree to the', 'user') }} <a href="{{ $settings['terms_of_service_link'] }}"
                                class="vr__link__color">{{ \App\CPU\Helpers::translate(terms of service', 'user') }}</a>
                        </label>
                    </div>
                @endif
                {!! app('captcha')->display() !!}
                <div class="d-flex">
                    <button class="btn btn-primary btn-lg w-full">{{ \App\CPU\Helpers::translate(Continue', 'user') }}</button>
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
