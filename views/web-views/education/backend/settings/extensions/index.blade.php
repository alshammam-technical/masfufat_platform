@extends('backend.layouts.form')
@section('title', __('Extensions'))
@section('section', __('Settings'))
@section('container', 'container-max-lg')
@section('back', route('admin.settings'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.extensions.update') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="col">
                            <img src="{{ asset('images/sections/ext-1.png') }}" class="vironeer-ext-icon">
                            <span class="ms-2">{{ __('Google Captcha 2') }}</span>
                        </div>
                        <div class="col-auto">
                            @if ($settings['ext_google_captcha_site_key'] != null && $settings['ext_google_captcha_secret_key'] != null)
                                <span class="badge bg-success">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('Disabled') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Site Key') }} :</label>
                            <input type="text" name="ext_google_captcha_site_key" class="remove-spaces form-control"
                                value="{{ $settings['ext_google_captcha_site_key'] }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ __('Secret Key') }} :</label>
                            <input type="text" name="ext_google_captcha_secret_key" class="remove-spaces form-control"
                                value="{{ $settings['ext_google_captcha_secret_key'] }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="col">
                            <img src="{{ asset('images/sections/ext-5.png') }}" class="vironeer-ext-icon">
                            <span class="ms-2">{{ __('Facebook login') }}</span>
                        </div>
                        <div class="col-auto">
                            @if ($settings['ext_facebook_client_id'] != null && $settings['ext_facebook_client_secret'] != null)
                                <span class="badge bg-success">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('Disabled') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Client ID') }} :</label>
                            <input type="text" name="ext_facebook_client_id" class="remove-spaces form-control"
                                value="{{ $settings['ext_facebook_client_id'] }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ __('Client Secret') }} :</label>
                            <input type="text" name="ext_facebook_client_secret" class="remove-spaces form-control"
                                value="{{ $settings['ext_facebook_client_secret'] }}">
                        </div>
                        <small class="text-muted"><strong>Redirect URL :</strong> {{ url('/') }}/login/facebook/callback</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="col">
                            <img src="{{ asset('images/sections/ext-2.png') }}" class="vironeer-ext-icon">
                            <span class="ms-2">{{ __('Google Analytics') }}</span>
                        </div>
                        <div class="col-auto">
                            {!! extensionsStatus($settings['ext_google_analytics_code']) !!}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label">{{ __('Code') }} :</label>
                            <input type="text" name="ext_google_analytics_code" class="remove-spaces form-control"
                                placeholder="UA-123456789-1" value="{{ $settings['ext_google_analytics_code'] }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div class="col">
                            <img src="{{ asset('images/sections/ext-3.png') }}" class="vironeer-ext-icon">
                            <span class="ms-2">{{ __('Tawk.to') }}</span>
                        </div>
                        <div class="col-auto">
                            {!! extensionsStatus($settings['ext_tawk_code']) !!}
                        </div>
                    </div>
                    <div class="card-body">
                        <label class="form-label">{{ __('Tawk details') }} :</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text">https://tawk.to/chat/</span>
                            <input type="text" name="ext_tawk_code" class="remove-spaces form-control"
                                placeholder="{property_key}/{widget_key}" value="{{ $settings['ext_tawk_code'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
