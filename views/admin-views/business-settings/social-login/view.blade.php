@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Login setup'))

@push('css_or_js')

@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Login setup')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->

        <!-- End Inlile Menu -->

        <?php
        $data = App\Model\BusinessSetting::where(['type' => 'social_login'])->first();
        $socialLoginServices = json_decode($data['value'], true);
        ?>
        <div class="row gy-3">
            @if (isset($socialLoginServices))
            @foreach ($socialLoginServices as $socialLoginService)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <form
                            action="{{route('admin.social-login.update',[$socialLoginService['login_medium']])}}"
                            method="post">
                            @csrf
                            <label class="switcher position-absolute right-3 top-3">
                                <input class="switcher_input" type="checkbox" {{$socialLoginService['status']==1?'checked':''}} value="1" name="status">
                                <span class="switcher_control"></span>
                            </label>

                            <div class="d-flex flex-column align-items-center gap-2 mb-3">
                                <h4 class="text-center">
                                    @if($socialLoginService['login_medium'] == "phone")
                                    {{Helpers::translate('Login with a text message')}}
                                    @else
                                    {{\App\CPU\Helpers::translate(''.$socialLoginService['login_medium'])}}
                                    @endif
                                </h4>
                            </div>

                            @if(($socialLoginService['login_medium'] == "facebook") || ($socialLoginService['login_medium'] == "google"))
                            <div class="form-group">
                                <label class="title-color font-weight-bold text-capitalize">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>
                                <div class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                    <span class="form-ellipsis" id="id_{{$socialLoginService['login_medium']}}">{{ url('/') }}/customer/auth/login/{{$socialLoginService['login_medium']}}/callback</span>
                                    <span class="btn btn--primary btn-primary text-nowrap btn-xs" onclick="copyToClipboard('#id_{{$socialLoginService['login_medium']}}')">
                                        <i class="tio-copy"></i>
                                        {{\App\CPU\Helpers::translate('Copy URI')}}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="title-color font-weight-bold text-capitalize">{{\App\CPU\Helpers::translate('Store_Client_ID')}}</label><br>
                                <input type="text" class="form-control form-ellipsis" name="client_id"
                                value="{{ $socialLoginService['client_id'] }}">
                            </div>
                            <div class="form-group">
                                <label class="title-color font-weight-bold text-capitalize">{{\App\CPU\Helpers::translate('Store_Client_Secret_Key')}}</label>
                                <input type="text" class="form-control form-ellipsis" name="client_secret"
                                value="{{ $socialLoginService['client_secret'] }}">
                            </div>
                            @endif

                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                @if(($socialLoginService['login_medium'] == "facebook") || ($socialLoginService['login_medium'] == "google"))
                                <button class="btn btn-outline--primary" type="button" data-toggle="modal" data-target="#{{$socialLoginService['login_medium']}}-modal">
                                    {{\App\CPU\Helpers::translate('See_Credential_Setup_Instructions')}}
                                </button>
                                @endif
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        {{-- Modal Starts--}}
        <!-- Google -->
        <div class="modal fade" id="google-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{\App\CPU\Helpers::translate('Google API Set up Instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ol>
                            <li>{{\App\CPU\Helpers::translate('Go to the Credentials page')}} ({{\App\CPU\Helpers::translate('Click')}} <a href="https://console.cloud.google.com/apis/credentials" target="_blank">{{\App\CPU\Helpers::translate('here')}}</a>)</li>
                            <li>{{\App\CPU\Helpers::translate('Click')}} <b>{{\App\CPU\Helpers::translate('Create credentials')}}</b> > <b>{{\App\CPU\Helpers::translate('OAuth client ID')}}</b>.</li>
                            <li>{{\App\CPU\Helpers::translate('Select the')}} <b>{{\App\CPU\Helpers::translate('Web application')}}</b> {{\App\CPU\Helpers::translate('type')}}.</li>
                            <li>{{\App\CPU\Helpers::translate('Name your OAuth 2.0 client')}}</li>
                            <li>{{\App\CPU\Helpers::translate('Click')}} <b>{{\App\CPU\Helpers::translate('ADD URI')}}</b> {{\App\CPU\Helpers::translate('from')}} <b>{{\App\CPU\Helpers::translate('Authorized redirect URIs')}}</b> , {{\App\CPU\Helpers::translate('provide the')}} <code>{{\App\CPU\Helpers::translate('Callback URI')}}</code> {{\App\CPU\Helpers::translate('from below and click')}} <b>{{\App\CPU\Helpers::translate('Create')}}</b></li>
                            <li>{{\App\CPU\Helpers::translate('Copy')}} <b>{{\App\CPU\Helpers::translate('Client ID')}}</b> {{\App\CPU\Helpers::translate('and')}} <b>{{\App\CPU\Helpers::translate('Client Secret')}}</b>, {{\App\CPU\Helpers::translate('paste in the input filed below and')}} <b>{{\App\CPU\Helpers::translate('Save')}}</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary btn-primary" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facebook -->
        <div class="modal fade" id="facebook-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{\App\CPU\Helpers::translate('Facebook API Set up Instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        <ol>
                            <li>{{\App\CPU\Helpers::translate('Go to the facebook developer page')}} (<a href="https://developers.facebook.com/apps/" target="_blank">{{\App\CPU\Helpers::translate('Click Here')}}</a>)</li>
                            <li>{{\App\CPU\Helpers::translate('Go to')}} <b>{{\App\CPU\Helpers::translate('Get Started')}}</b> {{\App\CPU\Helpers::translate('from Navbar')}}</li>
                            <li>{{\App\CPU\Helpers::translate('From Register tab press')}} <b>{{\App\CPU\Helpers::translate('Continue')}}</b> <small>({{\App\CPU\Helpers::translate('If needed')}})</small></li>
                            <li>{{\App\CPU\Helpers::translate('Provide Primary Email and press')}} <b>{{\App\CPU\Helpers::translate('Confirm Email')}}</b> <small>({{\App\CPU\Helpers::translate('If needed')}})</small></li>
                            <li>{{\App\CPU\Helpers::translate('In about section select')}} <b>{{\App\CPU\Helpers::translate('Other')}}</b> {{\App\CPU\Helpers::translate('and press')}} <b>{{\App\CPU\Helpers::translate('Complete Registration')}}</b></li>

                            <li><b>{{\App\CPU\Helpers::translate('Create App')}}</b> > {{\App\CPU\Helpers::translate('Select an app type and press')}} <b>{{\App\CPU\Helpers::translate('Next')}}</b></li>
                            <li>{{\App\CPU\Helpers::translate('Complete the add details form and press')}} <b>{{\App\CPU\Helpers::translate('Create App')}}</b></li><br/>

                            <li>{{\App\CPU\Helpers::translate('From')}} <b>{{\App\CPU\Helpers::translate('Facebook Login')}}</b> {{\App\CPU\Helpers::translate('press')}} <b>{{\App\CPU\Helpers::translate('Set Up')}}</b></li>
                            <li>{{\App\CPU\Helpers::translate('Select')}} <b>{{\App\CPU\Helpers::translate('Web')}}</b></li>
                            <li>{{\App\CPU\Helpers::translate('Provide')}} <b>{{\App\CPU\Helpers::translate('Site URL')}}</b> <small>({{\App\CPU\Helpers::translate('Base URL of the site ex:')}} https://example.com)</small> > <b>{{\App\CPU\Helpers::translate('Save')}}</b></li><br/>
                            <li>{{\App\CPU\Helpers::translate('Now go to')}} <b>{{\App\CPU\Helpers::translate('Setting')}}</b> {{\App\CPU\Helpers::translate('from')}} <b>{{\App\CPU\Helpers::translate('Facebook Login')}}</b> ({{\App\CPU\Helpers::translate('left sidebar')}})</li>
                            <li>{{\App\CPU\Helpers::translate('Make sure to check')}} <b>{{\App\CPU\Helpers::translate('Client OAuth Login')}}</b> <small>({{\App\CPU\Helpers::translate('must on')}})</small></li>
                            <li>{{\App\CPU\Helpers::translate('Provide')}} <code>{{\App\CPU\Helpers::translate('Valid OAuth Redirect URIs')}}</code> {{\App\CPU\Helpers::translate('from below and click')}} <b>{{\App\CPU\Helpers::translate('Save Changes')}}</b></li>

                            <li>{{\App\CPU\Helpers::translate('Now go to')}} <b>{{\App\CPU\Helpers::translate('Setting')}}</b> ({{\App\CPU\Helpers::translate('from left sidebar')}}) > <b>{{\App\CPU\Helpers::translate('Basic')}}</b></li>
                            <li>{{\App\CPU\Helpers::translate('Fill the form and press')}} <b>{{\App\CPU\Helpers::translate('Save Changes')}}</b></li>
                            <li>{{\App\CPU\Helpers::translate('Now, copy')}} <b>{{\App\CPU\Helpers::translate('Client ID')}}</b> & <b>{{\App\CPU\Helpers::translate('Client Secret')}}</b>, {{\App\CPU\Helpers::translate('paste in the input filed below and')}} <b>{{\App\CPU\Helpers::translate('Save')}}</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary btn-primary float-right" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Twitter -->
        <div class="modal fade" id="twitter-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{\App\CPU\Helpers::translate('Twitter API Set up Instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        {{\App\CPU\Helpers::translate('Instruction will be available very soon')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary btn-primary float-right" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Ends--}}
    </div>
@endsection

@push('script')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();

            toastr.success("{{\App\CPU\Helpers::translate('Copied to the clipboard')}}");
        }
    </script>

@endpush
