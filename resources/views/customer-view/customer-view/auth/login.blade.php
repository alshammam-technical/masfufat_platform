@extends('layouts.front-end.app')
@section('title', \App\CPU\Helpers::translate('Login'))
@push('css_or_js')
    <style>
        #footer1{
            position: absolute !important;
        }
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
            <div class="col-md-7 col-sm-12">
                <div class="card border-1 box-shadow-0">
                    <div class="card-body">
                        <strong class="mb-5 text-2xl text-black">{{\App\CPU\Helpers::translate('sign_in')}}</strong>
                        <div class="row mt-3 mb-3 ps-1 pe-4">
                            <div class="col-sm-6 text-center mb-1">
                                <a class="w-full whitespace-normal btn @if(Route::is('customer.auth.login')) btn-primary @else btn-white @endif"
                                   href="{{route('customer.auth.login')}}"
                                   style="width: auto">
                                    {{\App\CPU\Helpers::translate('sign in for markets')}}
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M29.8134 11.0266L29.4267 7.33329C28.8667 3.30663 27.04 1.66663 23.1334 1.66663H19.9867H18.0134H13.96H11.9867H8.78669C4.86669 1.66663 3.05335 3.30663 2.48002 7.37329L2.12002 11.04C1.98669 12.4666 2.37336 13.8533 3.21336 14.9333C4.22669 16.2533 5.78669 17 7.52002 17C9.20002 17 10.8134 16.16 11.8267 14.8133C12.7334 16.16 14.28 17 16 17C17.72 17 19.2267 16.2 20.1467 14.8666C21.1734 16.1866 22.76 17 24.4134 17C26.1867 17 27.7867 16.2133 28.7867 14.8266C29.5867 13.76 29.9467 12.4133 29.8134 11.0266Z" fill="#FDCD05"/>
                                        <path d="M15.1334 22.2134C13.44 22.3867 12.16 23.8267 12.16 25.5334V29.1867C12.16 29.5467 12.4534 29.84 12.8134 29.84H19.1734C19.5334 29.84 19.8267 29.5467 19.8267 29.1867V26C19.84 23.2134 18.2 21.8934 15.1334 22.2134Z" fill="#FDCD05"/>
                                        <path d="M28.4934 19.2V23.1733C28.4934 26.8533 25.5067 29.84 21.8267 29.84C21.4667 29.84 21.1734 29.5466 21.1734 29.1866V26C21.1734 24.2933 20.6534 22.96 19.64 22.0533C18.7467 21.24 17.5334 20.84 16.0267 20.84C15.6934 20.84 15.36 20.8533 15 20.8933C12.6267 21.1333 10.8267 23.1333 10.8267 25.5333V29.1866C10.8267 29.5466 10.5334 29.84 10.1734 29.84C6.49338 29.84 3.50671 26.8533 3.50671 23.1733V19.2266C3.50671 18.2933 4.42671 17.6666 5.29338 17.9733C5.65338 18.0933 6.01338 18.1866 6.38671 18.24C6.54671 18.2666 6.72005 18.2933 6.88005 18.2933C7.09338 18.32 7.30671 18.3333 7.52005 18.3333C9.06671 18.3333 10.5867 17.76 11.7867 16.7733C12.9334 17.76 14.4267 18.3333 16 18.3333C17.5867 18.3333 19.0534 17.7866 20.2 16.8C21.4 17.7733 22.8934 18.3333 24.4134 18.3333C24.6534 18.3333 24.8934 18.32 25.12 18.2933C25.28 18.28 25.4267 18.2666 25.5734 18.24C25.9867 18.1866 26.36 18.0666 26.7334 17.9466C27.6 17.6533 28.4934 18.2933 28.4934 19.2Z" fill="#FDCD05"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="col-sm-6 text-center mb-1">
                                <a class="w-full whitespace-normal btn @if(Route::is('seller.auth.login')) btn-primary @else btn-white @endif"
                                   href="{{route('seller.auth.login')}}"
                                   style="width: auto">
                                    {{\App\CPU\Helpers::translate('sign in for sellers')}}
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2.66663C8.50663 2.66663 5.66663 5.50663 5.66663 8.99996C5.66663 12.4266 8.34663 15.2 11.84 15.32C11.9466 15.3066 12.0533 15.3066 12.1333 15.32C12.16 15.32 12.1733 15.32 12.2 15.32C12.2133 15.32 12.2133 15.32 12.2266 15.32C15.64 15.2 18.32 12.4266 18.3333 8.99996C18.3333 5.50663 15.4933 2.66663 12 2.66663Z" fill="#FDCD05"/>
                                        <path d="M18.7733 18.8667C15.0533 16.3867 8.98661 16.3867 5.23995 18.8667C3.54661 20 2.61328 21.5334 2.61328 23.1734C2.61328 24.8134 3.54661 26.3334 5.22661 27.4534C7.09328 28.7067 9.54661 29.3334 11.9999 29.3334C14.4533 29.3334 16.9066 28.7067 18.7733 27.4534C20.4533 26.32 21.3866 24.8 21.3866 23.1467C21.3733 21.5067 20.4533 19.9867 18.7733 18.8667Z" fill="#FDCD05"/>
                                        <path d="M26.6534 9.78664C26.8667 12.3733 25.0267 14.64 22.48 14.9466C22.4667 14.9466 22.4667 14.9466 22.4534 14.9466H22.4134C22.3334 14.9466 22.2534 14.9466 22.1867 14.9733C20.8934 15.04 19.7067 14.6266 18.8134 13.8666C20.1867 12.64 20.9734 10.8 20.8134 8.79997C20.72 7.71997 20.3467 6.7333 19.7867 5.8933C20.2934 5.63997 20.88 5.47997 21.48 5.42664C24.0934 5.19997 26.4267 7.14664 26.6534 9.78664Z" fill="#FDCD05"/>
                                        <path d="M29.32 22.12C29.2133 23.4133 28.3867 24.5333 27 25.2933C25.6667 26.0267 23.9867 26.3733 22.32 26.3333C23.28 25.4667 23.84 24.3867 23.9467 23.24C24.08 21.5867 23.2933 20 21.72 18.7333C20.8267 18.0267 19.7867 17.4667 18.6533 17.0533C21.6 16.2 25.3067 16.7733 27.5867 18.6133C28.8133 19.6 29.44 20.84 29.32 22.12Z" fill="#FDCD05"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="row mt-0 mb-3 ps-1 pe-4" style="flex-direction: row-reverse">
                            @foreach (\App\CPU\Helpers::get_business_settings('social_login') as $socialLoginService)
                                @if (isset($socialLoginService) && $socialLoginService['status']==true)
                                    <div class="col-sm-6 text-center mb-1">
                                        <a class="whitespace-normal btn @if(Route::is('customer.auth.service-login', $socialLoginService['login_medium'])) border-b-solid border-b-2 border-b-[#FDCD05] @elseif($socialLoginService['login_medium'] == 'regular_login') border-b-solid border-b-2 border-b-[#FDCD05] @else btn-white border-0 @endif"
                                           href="{{route('customer.auth.service-login', $socialLoginService['login_medium'])}}"
                                           style="width: auto">
                                            {{\App\CPU\Helpers::translate('sign_in_with_'.$socialLoginService['login_medium'])}}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>


                        {{-- <h3 class="font-size-base pt-4 pb-2">{{\App\CPU\Helpers::translate('or_using_form_below')}}</h3> --}}
                        <form class="needs-validation mt-2" autocomplete="off" action="{{route('customer.auth.login')}}"
                              method="post" id="form-id">
                            @csrf
                            <div class="form-group">
                                <label for="si-email" class="font-weight-bold">{{\App\CPU\Helpers::translate('email_address')}}
                                    / {{\App\CPU\Helpers::translate('phone')}}</label>
                                <input class="form-control" type="text" name="user_id" id="si-email"
                                       style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                       value="{{old('user_id')}}"
                                       placeholder="{{\App\CPU\Helpers::translate('Enter_email_address_or_phone_number')}}"
                                       required>
                                <div
                                    class="invalid-feedback">{{\App\CPU\Helpers::translate('please_provide_valid_email_or_phone_number')}}
                                    .
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="si-password" class="font-weight-bold">{{\App\CPU\Helpers::translate('password')}}</label>
                                <div class="password-toggle">
                                    <input class="form-control" name="password" type="password" id="si-password"
                                           style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                           required>
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i
                                            class="czi-eye password-toggle-indicator"></i><span
                                            class="sr-only">{{\App\CPU\Helpers::translate('Show password')}} </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group d-flex flex-wrap justify-content-between mb-0 ps-1 pe-2">

                                <div class="form-group">
                                    <input type="checkbox"
                                           class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}"
                                           name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="" for="remember">{{\App\CPU\Helpers::translate('remember_me')}}</label>
                                </div>
                                <a class="font-size-sm text-primary" href="{{route('customer.auth.recover-password')}}" dir="{{ (session()->get('direction') == 'ltr') ? 'ltr' : 'rtl' }}">
                                    {{\App\CPU\Helpers::translate('forgot_password')}}
                                </a>
                            </div>
                            {{-- recaptcha --}}
                            @php($recaptcha = \App\CPU\Helpers::get_business_settings('recaptcha'))
                            @if(1 == 1)
                                <div id="recaptcha_element" style="width: 100%;" data-type="image"></div>
                            @else
                                <div class="row p-2">
                                    <div class="col-6 pr-0">
                                        <input type="text" class="form-control form-control-lg" name="default_captcha_value" value=""
                                            placeholder="{{\App\CPU\Helpers::translate('Enter captcha value')}}" style="border: none" autocomplete="off">
                                    </div>
                                    <div class="col-6 input-icons" style="background-color: #FFFFFF; border-radius: 5px;">
                                        <a onclick="javascript:re_captcha();">
                                            <img src="{{ URL('/customer/auth/code/captcha/1') }}" class="input-field" id="default_recaptcha_id" style="display: inline;width: 90%; height: 75%">
                                            <i class="tio-refresh icon"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <button class="btn btn-primary btn-block w-full"
                                    type="submit">{{\App\CPU\Helpers::translate('sign_in')}}</button>
                        </form>
                        <br/>

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
    </div>
@endsection

@push('script')

    {{-- recaptcha scripts start --}}
    @if(1 == 2)
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
    @elseif(1==2)
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
