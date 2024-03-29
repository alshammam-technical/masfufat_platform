@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('reCaptcha Setup'))

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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    @php($config=\App\CPU\Helpers::get_business_settings('recaptcha'))
                    <form
                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.recaptcha_update',['recaptcha']):'javascript:'}}"
                        method="post">
                        @csrf
                        <div class="card-header flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <h5 class="mb-0">{{\App\CPU\Helpers::translate('Google_Recapcha_Information')}}</h5>
                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="status" {{isset($config) && $config['status']==1?'checked':''}} value="1">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                            <a href="https://www.google.com/recaptcha/admin/create" type="button"
                               class="btn btn-sm btn-outline--primary p-2">
                                <i class="tio-info-outined"></i> {{\App\CPU\Helpers::translate('Credentials_SetUp_page')}}
                            </a>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="title-color font-weight-bold d-flex">{{\App\CPU\Helpers::translate('Site Key')}}</label>
                                            <input type="text" class="form-control" name="site_key"
                                                   value="{{env('APP_MODE')!='demo'?$config['site_key']??"":''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="title-color font-weight-bold d-flex">{{\App\CPU\Helpers::translate('Secret Key')}}</label>
                                            <input type="text" class="form-control" name="secret_key"
                                                   value="{{env('APP_MODE')!='demo'?$config['secret_key']??"":''}}">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-3 d-flex">{{\App\CPU\Helpers::translate('Instructions')}}</h5>
                                <ol class="pl-3 instructions-list">
                                    <li>
                                        {{\App\CPU\Helpers::translate('To  get site key and secret keyGo to the Credentials page')}}
                                        (<a href="https://www.google.com/recaptcha/admin/create"
                                            target="_blank">{{\App\CPU\Helpers::translate('Click_here')}}</a>)
                                    </li>
                                    <li>{{\App\CPU\Helpers::translate('Add a Label (Ex: abc company)')}}</li>
                                    <li>{{\App\CPU\Helpers::translate('Select reCAPTCHA v2  as  ReCAPTCHA Type')}}</li>
                                    <li>{{\App\CPU\Helpers::translate('Select Sub type: Im not a robot Checkbox ')}}</li>
                                    <li>{{\App\CPU\Helpers::translate('Add Domain (For ex: demo.6amtech.com)')}}</li>
                                    <li>{{\App\CPU\Helpers::translate('Check in “Accept the reCAPTCHA Terms of Service”')}}</li>
                                    <li>{{\App\CPU\Helpers::translate('Press Submit')}}</li>
                                    <li>{{\App\CPU\Helpers::translate('Copy Site Key and Secret Key, Paste in the input filed below and Save.')}}</li>
                                </ol>

                                <div class="d-flex justify-content-end">
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                            class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('save')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush
