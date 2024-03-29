@extends('layouts.front-end.app')
@section('title', \App\CPU\Helpers::translate('Forgot Password'))
@push('css_or_js')
    <style>
        .text-primary {
            color: {{$web_config['primary_color']}}  !important;
        }
    </style>
@endpush

@section('content')
    @php($verification_by=\App\CPU\Helpers::get_business_settings('forgot_password_verification'))
    <!-- Page Content-->
    <div class="container py-4 py-lg-5 my-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h2 class="h3 mb-4">{{\App\CPU\Helpers::translate('Forgot your password')}}?</h2>
                <p class="font-size-md">{{\App\CPU\Helpers::translate('Change your password in three easy steps. This helps to keep your new password secure')}}
                    .</p>
                    <ol class="list-unstyled font-size-md">
                        <li><span
                                class="text-primary mr-2">{{\App\CPU\Helpers::translate('1')}}.</span>{{\App\CPU\Helpers::translate('Fill in your email address below')}}
                            .
                        </li>
                        <li><span
                                class="text-primary mr-2">{{\App\CPU\Helpers::translate('2')}}.</span>{{\App\CPU\Helpers::translate('We will email you a temporary code')}}
                            .
                        </li>
                        <li><span
                                class="text-primary mr-2">{{\App\CPU\Helpers::translate('3')}}.</span>{{\App\CPU\Helpers::translate('Use the code to change your password on our secure website')}}
                            .
                        </li>
                    </ol>
                @if($verification_by=='email')

                    <div class="card py-2 mt-4">
                        <form class="card-body needs-validation" action="{{route('customer.auth.forgot-password')}}"
                              method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recover-email">{{\App\CPU\Helpers::translate('Enter your email address')}}</label>
                                <input class="form-control" type="email" name="identity" id="recover-email" required>
                                <div
                                    class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide valid email address')}}
                                    .
                                </div>
                            </div>
                            <button class="btn btn--primary btn-primary"
                                    type="submit">{{\App\CPU\Helpers::translate('Get new password')}}</button>
                        </form>
                    </div>
                @else
                    <div class="card py-2 mt-4">
                        <form class="card-body needs-validation" action="{{route('customer.auth.forgot-password')}}"
                              method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recover-email">{{\App\CPU\Helpers::translate('Enter your phone number')}}</label>
                                <input value="+966" class="form-control phoneInput text-left" dir="ltr" type="text" name="identity" required>
                                <div
                                    class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide valid phone number')}}
                                </div>
                            </div>
                            <button class="btn btn--primary btn-primary"
                                    type="submit">{{\App\CPU\Helpers::translate('proceed')}}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
