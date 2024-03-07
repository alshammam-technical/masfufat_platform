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
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-1 box-shadow-0">
                    <div class="card-body pb-0">
                        <h3 class="h4 mb-1 font-weight-bold">{{\App\CPU\Helpers::translate('Login code')}}</h3>
                        {{-- <h3 class="font-size-base pt-4 pb-2">{{\App\CPU\Helpers::translate('or_using_form_below')}}</h3> --}}
                        <form class="needs-validation mt-2" autocomplete="off" action="{{route('customer.auth.code')}}"
                              method="post" id="form-id">
                            @csrf
                            <div class="form-group">
                                <p for="si-email" class="my-4 font-weight-bold text-grey">{{\App\CPU\Helpers::translate('Please enter the login code that sent to you')}}</p>
                                <p for="si-email" class="mt-4 font-weight-bold text-dark">{{\App\CPU\Helpers::translate('Login code')}}</p>
                                <div class="w-100 text-center justify-content-center d-flex">
                                    <input class="form-control w-75" type="text" name="login_code" id="si-email"
                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    value="{{old('user_id')}}"
                                    required>
                                </div>
                                <div
                                    class="invalid-feedback">{{\App\CPU\Helpers::translate('invalid login code')}}

                                </div>
                            </div>
                            <button class="btn btn--primary btn-primary btn-block w-100" type="submit">{{\App\CPU\Helpers::translate('sign_in')}}</button>
                        </form>
                    </div>
                    <form class="needs-validation mt-0" autocomplete="off" action="{{route('customer.auth.phone')}}" method="post" id="form-id">
                        @csrf
                        <input hidden class="d-none" dir="ltr" type="text" name="phone" id="si-email"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                        value="{{'+'.request()->get('phone')}}"
                        placeholder="{{\App\CPU\Helpers::translate('Please enter your phone number')}}"
                        required>
                        <button class="btn btn-white py-0 btn-block w-100 border-0 text-primary font-weight-bold" type="submit">{{\App\CPU\Helpers::translate('resend the code')}}</button>
                    </form>
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
