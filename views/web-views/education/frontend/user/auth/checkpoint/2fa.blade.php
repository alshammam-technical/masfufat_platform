@extends('admin-views.education.frontend.user.layouts.auth')
@section('title', \App\CPU\Helpers::translate(2Fa Verification', 'user'))
@section('content')
    <div class="vr__sign__form vr__reset">
        <div class="vr__sign__header">
            <p class="h3 mb-1">{{ \App\CPU\Helpers::translate(2Fa Verification', 'user') }}</p>
            <p class="mb-0">{{ \App\CPU\Helpers::translate(Please enter the OTP code to continue', 'user') }}</p>
        </div>
        <div class="sign-body vr__checkpoint">
            <form action="{{ route('2fa.verify') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input id="vr__otp__code" type="text" name="otp_code" class="form-control" placeholder="••• •••"
                        maxlength="6" required>
                </div>
                <button class="btn btn-primary btn-lg w-full">{{ \App\CPU\Helpers::translate(Continue', 'user') }}</button>
            </form>
            <div class="vr__login__with mt-3">
                <div class="divider">
                    <span>{{ \App\CPU\Helpers::translate(Or', 'user') }}</span>
                </div>
                <div class="mt-3">
                    <form class="d-inline" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-dark btn-lg w-full">
                            {{ \App\CPU\Helpers::translate(Logout', 'user') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
