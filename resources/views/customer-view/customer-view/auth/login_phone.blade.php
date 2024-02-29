@extends('layouts.front-end.app')
@section('title', \App\CPU\Helpers::translate('Login'))
@push('css_or_js')
    <style>
        .password-toggle-btn .custom-control-input:checked ~ .password-toggle-indicator {
            color: {{$web_config['primary_color']}};
        }

        .for-no-account {
            margin: auto;
            text-align: center;
        }
    </style>

    <style>
        .input-icons i {
            /* position: absolute; */
            cursor: pointer;
        }

        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }

        .icon {
            padding: 9% 0 0 0;
            min-width: 40px;
        }

        .input-field {
            width: 94%;
            padding: 10px 0 10px 10px;
            text-align: center;
            border-right-style: none;
        }
    </style>
@endpush
@section('content')
    <div class="container py-4 py-lg-5 my-4"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-1 box-shadow-0">
                    <div class="card-body">
                        <h2 class="h4 mb-5">{{\App\CPU\Helpers::translate('sign_in')}}</h2>
                        @include('sellerCustomerLoginTabs')
                        <div class="row mt-0 mb-8 ps-1 pe-4" style="flex-direction: row-reverse">
                            @foreach (\App\CPU\Helpers::get_business_settings('social_login') as $socialLoginService)
                                @if (isset($socialLoginService) && $socialLoginService['status']==true)
                                    <div class="col-sm-6 text-center mb-1">
                                        <a class="whitespace-normal btn @if($socialLoginService['login_medium'] == 'phone') border-b-solid border-b-2 border-b-[#FDCD05] @else btn-white border-0 @endif"
                                           href="{{route('customer.auth.service-login', $socialLoginService['login_medium'])}}"
                                           style="width: 100%">
                                            {{\App\CPU\Helpers::translate('sign_in_with_'.$socialLoginService['login_medium'])}}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        {{-- <h3 class="font-size-base pt-4 pb-2">{{\App\CPU\Helpers::translate('or_using_form_below')}}</h3> --}}
                        <form class="needs-validation mt-2" autocomplete="off" action="{{route('customer.auth.phone')}}"
                              method="post" id="form-id">
                            @csrf
                            <div class="form-group">
                                <label for="si-email" class="font-weight-bold">
                                    {{\App\CPU\Helpers::translate('phone')}}</label>
                                    <div class="form-control " dir="ltr">
                                        <input class="phoneInput text-left border-0 w-full" dir="ltr" type="text" name="phone" id="si-email"
                                        style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                        value="{{old('phone') ?? '+966'}}"
                                        placeholder="{{\App\CPU\Helpers::translate('Please enter your phone number')}}"
                                        required>
                                    </div>
                                <div
                                    class="invalid-feedback">{{\App\CPU\Helpers::translate('please_provide_valid_email_or_phone_number')}}
                                    .
                                </div>
                            </div>
                            <button class="btn bg-primaryColor btn-primary btn-block w-full"
                                    type="submit">{{\App\CPU\Helpers::translate('login')}}</button>
                        </form>
                    </div>
                    <div class="col-12 flex-between justify-content-center row p-0 text-center" style="direction: {{ Session::get('direction') }}">
                        <div class="mb-3 {{(Session::get('direction') ?? 'rtl') === "rtl" ? '' : 'ml-2'}}">
                            <h6>
                                {{ \App\CPU\Helpers::translate('dont have an account?') }}
                                <a href="{{route('customer.auth.register')}}">
                                    <strong class="text-primary">
                                        {{ Helpers::translate('Sign up now!') }}
                                    </strong>
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    {{-- recaptcha scripts start --}}
    @if(1 == 1)
        <script type="text/javascript">
            var onloadCallback = function () {
                grecaptcha.render('recaptcha_element', {
                    'sitekey': '{{ \App\CPU\Helpers::get_business_settings('recaptcha')['site_key'] }}'
                });
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async
                defer></script>
        <script>
            $("#form-id").on('submit', function (e) {
                var response = grecaptcha.getResponse();

                if (response.length === 0) {
                    e.preventDefault();
                    toastr.error("{{\App\CPU\Helpers::translate('Please check the recaptcha')}}");
                }
            });
        </script>
    @else
        <script type="text/javascript">
            function re_captcha() {
                $url = "{{ URL('/customer/auth/code/captcha') }}";
                $url = $url + "/" + Math.random();
                document.getElementById('default_recaptcha_id').src = $url;
                console.log('url: '+ $url);
            }
        </script>
    @endif
    {{-- recaptcha scripts end --}}
@endpush
