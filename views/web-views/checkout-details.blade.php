@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Checkout Process Start'))

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/checkout-details.css"/>
    <style>
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            background: {{$web_config['primary_color']}};
            border-radius: 6px;
            color: white !important;
            border-color: {{$web_config['primary_color']}};
        }

        .nav-tabs .nav-link {
            background: {{$web_config['secondary_color']}};
            border: 1px solid{{$web_config['secondary_color']}};
            border-radius: 6px;
            color: #f2f3ff !important;
            font-weight: 600 !important;
            font-size: 18px !important;
        }
    </style>
@endpush

@section('content')
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@php($user = \App\User::find($storeId))
    <div class="container pb-5 mb-2 mb-md-4 rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header" style="background: #dcdcdc;line-height: 1px">
                    <span>{{ \App\CPU\Helpers::translate('sign_in')}}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                @include('web-views.partials._checkout-steps',['step'=>1])
                <!-- Shipping methods table-->
                    <h2 class="h4 pb-3 mb-2 mt-5">{{\App\CPU\Helpers::translate('Authentication')}}</h2>
                    <!-- Autor info-->
                    @if((auth('customer')->check() || auth('delegatestore')->check()))
                        <div class="card">
                            <div class="card-body">
                                <h4>{{$user->f_name}}, {{\App\CPU\Helpers::translate('HI')}}!</h4>
                                <small>{{\App\CPU\Helpers::translate('you_are_already_login_proceed')}}.</small>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs lightSlider mt-2 d-flex justify-content-between" role="tablist">
                                    <li class="nav-item d-inline-block">
                                        <a class="nav-link active" href="#signin" data-bs-toggle="tab" role="tab">
                                            {{\App\CPU\Helpers::translate('Sign In')}}
                                        </a>
                                    </li>
                                    <li class="nav-item d-inline-block">
                                        <a class="nav-link" href="#signup" data-bs-toggle="tab" role="tab">
                                            {{\App\CPU\Helpers::translate('Sign Up')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <div class="tab-content">
                                    <!-- Tech specs tab-->
                                    <div class="tab-pane fade show active" id="signin" role="tabpanel">
                                        <form class="needs-validation" autocomplete="off" id="login-form"
                                              action="{{route('customer.auth.login')}}" method="post" novalidate>
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="si-email">{{\App\CPU\Helpers::translate('email_address')}}</label>
                                                        <input class="form-control" type="email" name="email"
                                                               id="si-email" value="{{old('email')}}"
                                                               placeholder="johndoe@example.com"
                                                               required>
                                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide a valid email address')}}.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="si-password">{{\App\CPU\Helpers::translate('Password')}}</label>
                                                        <div class="password-toggle">
                                                            <input class="form-control" name="password" type="password"
                                                                   id="si-password" required>
                                                            <label class="password-toggle-btn">
                                                                <input class="custom-control-input" type="checkbox"><i
                                                                    class="czi-eye password-toggle-indicator"></i><span
                                                                    class="sr-only">{{\App\CPU\Helpers::translate('Show password')}}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <div class="form-group d-flex flex-wrap justify-content-between mb-0">
                                                        <div class="mb-2">
                                                            <input type="checkbox" name="remember"
                                                                   {{ old('remember') ? 'checked' : '' }}
                                                                   id="remember_me">
                                                            <label for="remember_me" style="cursor: pointer">
                                                                {{\App\CPU\Helpers::translate('remember_me')}}
                                                            </label>

                                                            <a class="font-size-sm {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-5' : 'ml-5'}}"
                                                               href="{{route('customer.auth.recover-password')}}">
                                                                {{\App\CPU\Helpers::translate('forgot_password')}}?
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <button class="btn bg-primaryColor btn-block text-light"
                                                            type="submit">{{\App\CPU\Helpers::translate('sing_in')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="signup" role="tabpanel">
                                        <form class="needs-validation_" autocomplete="off" novalidate id="sign-up-form"
                                              action="{{route('customer.auth.register')}}" method="post">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="su-name">{{\App\CPU\Helpers::translate('first_name')}}</label>
                                                        <input class="form-control" type="text" name="f_name"
                                                               placeholder="John" required>
                                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please fill in your name')}}.</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="su-name">{{\App\CPU\Helpers::translate('last_name')}} </label>
                                                        <input class="form-control" type="text" name="l_name"
                                                               placeholder="Doe" required>
                                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please fill in your name')}}.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="su-email">{{\App\CPU\Helpers::translate('email_address')}}</label>
                                                        <input class="form-control" name="email" type="email"
                                                               id="su-email"
                                                               placeholder="johndoe@example.com"
                                                               required>
                                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide a valid email address')}}.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="su-email">{{\App\CPU\Helpers::translate('Phone')}}</label>
                                                        <input class="form-control phoneInput" name="phone" type="text" pattern="\d*" t="number"
                                                               id="su-phone" placeholder="{{\App\CPU\Helpers::translate('01700000000')}}"
                                                               required>
                                                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('Please provide a valid phone number')}}.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="su-password">{{\App\CPU\Helpers::translate('Password')}}</label>
                                                        <div class="password-toggle">
                                                            <input class="form-control" name="password" type="password"
                                                                   id="su-password" required>
                                                            <label class="password-toggle-btn">
                                                                <input class="custom-control-input" type="checkbox"><i
                                                                    class="czi-eye password-toggle-indicator"></i><span
                                                                    class="sr-only">{{\App\CPU\Helpers::translate('Show password')}}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="su-password-confirm">{{\App\CPU\Helpers::translate('confirm_password')}}</label>
                                                        <div class="password-toggle">
                                                            <input class="form-control" name="con_password"
                                                                   type="password" id="su-password-confirm"
                                                                   required>
                                                            <label class="password-toggle-btn">
                                                                <input class="custom-control-input" type="checkbox"><i
                                                                    class="czi-eye password-toggle-indicator"></i><span
                                                                    class="sr-only">{{\App\CPU\Helpers::translate('Show password')}}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <button class="btn bg-primaryColor btn-block text-light" type="submit">
                                                        {{\App\CPU\Helpers::translate('sign-up')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <br>
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-secondary btn-block" href="{{route('shop-cart')}}">
                            <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}} mt-sm-0 mx-1"></i>
                            <span
                                class="d-none d-sm-inline">{{\App\CPU\Helpers::translate('Back to')}}  {{\App\CPU\Helpers::translate('Cart')}} </span>
                            <span class="d-inline d-sm-none">{{\App\CPU\Helpers::translate('Back')}}</span>
                        </a>
                    </div>
                    <div class="col-6 text-end">
                        @if((auth('customer')->check() || auth('delegatestore')->check()))
                            <a class="btn bg-primaryColor btn-block text-light" href="{{route('shop-cart')}}">
                                <span class="d-none d-sm-inline">{{\App\CPU\Helpers::translate('shop_cart')}}</span>
                                <span class="d-inline d-sm-none">{{\App\CPU\Helpers::translate('Next')}}</span>
                                <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}} mt-sm-0 mx-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </section>
            <!-- Sidebar-->
            @include('web-views.partials._order-summary')
        </div>
    </div>
@endsection

@push('script')

    <script>
        $('#login-form').submit(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.auth.login')}}',
                dataType: 'json',
                data: $('#login-form').serialize(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    toastr.success(data.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    location.reload();
                },
                complete: function () {
                    $('#loading').hide();
                },
                error: function () {
                    toastr.error('{{\App\CPU\Helpers::translate('Credential not matched')}}!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('#sign-up-form').submit(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.auth.register')}}',
                dataType: 'json',
                data: $('#sign-up-form').serialize(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setInterval(function () {
                            location.href = data.url;
                        }, 2000);
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
                error: function () {
                    toastr.error('{{\App\CPU\Helpers::translate('something went wrong')}}!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

@endpush
