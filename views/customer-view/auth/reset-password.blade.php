@extends('layouts.front-end.app')

@section('title', \App\CPU\Helpers::translate('Reset Password'))

@push('css_or_js')
    <style>
        .text-primary{
            color: {{$web_config['primary_color']}} !important;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4 py-lg-5 my-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h2 class="h3 mb-4">{{\App\CPU\Helpers::translate('Reset your password')}}</h2>
                <p class="font-size-md">{{\App\CPU\Helpers::translate('Change your password in two easy steps. This helps to keep your new password secure')}}.</p>
                <ol class="list-unstyled font-size-md">
                    <li><span class="text-primary mr-2">{{\App\CPU\Helpers::translate('1')}}.</span>{{\App\CPU\Helpers::translate('New Password')}}.</li>
                    <li><span class="text-primary mr-2">{{\App\CPU\Helpers::translate('2')}}.</span>{{\App\CPU\Helpers::translate('Confirm Password')}}.</li>
                </ol>
                <div class="card py-2 mt-4">
                    <form class="card-body needs-validation" novalidate method="POST"
                          action="{{request('customer.auth.password-recovery')}}">
                        @csrf
                        <div class="form-group" style="display: none">
                            <input type="text" name="reset_token" value="{{$token}}" required>
                        </div>

                        <div class="form-group">
                                <label for="si-password">{{\App\CPU\Helpers::translate('New')}}{{\App\CPU\Helpers::translate('password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" name="password" type="password" id="si-password"
                                           required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i
                                            class="czi-eye password-toggle-indicator"></i><span
                                            class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                    </label>
                                    <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide valid password')}}.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="si-password">{{\App\CPU\Helpers::translate('confirm_password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" name="confirm_password" type="password" id="si-password"
                                           required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i
                                            class="czi-eye password-toggle-indicator"></i><span
                                            class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                    </label>
                                    <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide valid password')}}.</div>
                                </div>
                            </div>

                        <button class="btn btn--primary btn-primary" type="submit">{{\App\CPU\Helpers::translate('Reset password')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
