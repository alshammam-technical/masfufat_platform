@extends('backend.layouts.grid')
@section('title', __('Settings'))
@section('container', 'container-max-xl')
@section('content')
    <div class="row g-3 g-xl-3">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.general') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('General') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Manage your website general settings') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.smtp') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('SMTP') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Edit and update your smtp information') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('pages.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Pages') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Create and update your website pages') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admins.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Admins') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Add and update your webiste admins') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('admin.settings.extensions') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Extensions') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Enable or disbale your website extensions') }}
                    </p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('languages.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-globe-asia"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('Languages') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Add and update your website languages') }}</p>
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card p-1 text-center">
                <a class="setting-item p-4" href="{{ route('seo.index') }}">
                    <div class="text-muted mb-3">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2 class="h6 mb-2">{{ __('SEO Configurations') }}</h2>
                    <p class="setting-item-text text-muted mb-0">{{ __('Create and mange your seo configurations') }}</p>
                </a>
            </div>
        </div>
    </div>
@endsection
