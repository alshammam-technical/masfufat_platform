@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('SMS Module Setup'))

@push('css_or_js')

@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{\App\CPU\Helpers::translate('3rd_party')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->

        <!-- End Inlile Menu -->

        <div class="row gy-3">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('releans_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('releans_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['releans_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\Helpers::translate('releans_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('inactive')}} </label>

                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('sender name')}}</label>
                                <input type="text" class="form-control" name="from"
                                       value="{{env('APP_MODE')!='demo'?$config['from']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('twilio_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('twilio_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['twilio_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf
                            <label class="mb-3 d-block title-color">{{\App\CPU\Helpers::translate('twilio_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('sid')}}</label>
                                <input type="text" class="form-control" name="sid"
                                       value="{{env('APP_MODE')!='demo'?$config['sid']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('messaging_service_sid')}}</label>
                                <input type="text" class="form-control" name="messaging_service_sid"
                                       value="{{env('APP_MODE')!='demo'?$config['messaging_service_sid']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('token')}}</label>
                                <input type="text" class="form-control" name="token"
                                       value="{{env('APP_MODE')!='demo'?$config['token']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('sender name')}}</label>
                                <input type="text" class="form-control" name="from"
                                       value="{{env('APP_MODE')!='demo'?$config['from']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('nexmo_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">NB : #OTP# will be replace with otp</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('nexmo_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['nexmo_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\Helpers::translate('nexmo_sms')}}</label>


                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('active')}}</label>

                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize"
                                       class="title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('api_secret')}}</label>
                                <input type="text" class="form-control" name="api_secret"
                                       value="{{env('APP_MODE')!='demo'?$config['api_secret']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('sender name')}}</label>
                                <input type="text" class="form-control" name="from"
                                       value="{{env('APP_MODE')!='demo'?$config['from']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('otp_template')}}</label>
                                <input type="text" class="form-control" name="otp_template"
                                       value="{{env('APP_MODE')!='demo'?$config['otp_template']??"":''}}">
                            </div>
                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('2factor_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <div class="mb-3 d-flex flex-wrap gap-10">
                            <span class="badge text-wrap badge-soft-info">{{\App\CPU\Helpers::translate("EX of SMS provider's template : your OTP is XXXX here, please check")}}.</span>
                            <span class="badge text-wrap badge-soft-info">{{\App\CPU\Helpers::translate('NB : XXXX will be replace with otp')}}</span>
                        </div>

                        @php($config=\App\CPU\Helpers::get_business_settings('2factor_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['2factor_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\Helpers::translate('2factor_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('msg91_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <span class="badge text-wrap badge-soft-info mb-3">{{\App\CPU\Helpers::translate('NB : Keep an OTP variable in your SMS providers OTP Template')}}.</span>
                        @php($config=\App\CPU\Helpers::get_business_settings('msg91_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['msg91_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\Helpers::translate('msg91_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('active')}}</label>

                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('inactive')}} </label>

                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('template_id')}}</label>
                                <input type="text" class="form-control" name="template_id"
                                       value="{{env('APP_MODE')!='demo'?$config['template_id']??"":''}}">
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('authkey')}}</label>
                                <input type="text" class="form-control" name="authkey"
                                       value="{{env('APP_MODE')!='demo'?$config['authkey']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('msegat_sms')}}</h5>
                    </div>
                    <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <div class="mb-3 d-flex flex-wrap gap-10">
                        </div>

                        @php($config=\App\CPU\Helpers::get_business_settings('msegat_sms'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.sms-module-update',['msegat_sms']):'javascript:'}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{\App\CPU\Helpers::translate('msegat_sms')}}</label>

                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1" {{isset($config) && $config['status']==1?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('active')}}</label>
                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0" {{isset($config) && $config['status']==0?'checked':''}}>
                                <label class="title-color mb-0">{{\App\CPU\Helpers::translate('inactive')}} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')!='demo'?$config['api_key']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('username')}} ({{\App\CPU\Helpers::translate('the username you use to login to Msegat')}})</label>
                                <input type="text" class="form-control" name="username"
                                       value="{{env('APP_MODE')!='demo'?$config['username']??"":''}}">
                            </div>

                            <div class="form-group">
                                <label class="text-capitalize title-color">{{\App\CPU\Helpers::translate('sender name')}}</label>
                                <input type="text" class="form-control" name="sender_name"
                                       value="{{env('APP_MODE')!='demo'?$config['sender_name']??"":''}}">
                            </div>

                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script_2')

@endpush
