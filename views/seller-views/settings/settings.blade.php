@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\Helpers::translate('environment_setup'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="col-lg-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('settings')}}</li>
            </ol>
        </nav>
    </div>

    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/public/assets/back-end/img/system-setting.png')}}" alt="">
            {{\App\CPU\Helpers::translate('settings')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Inlile Menu -->
    @include('seller-views.business-settings.settings-inline-menu')
    <!-- End Inlile Menu -->

    <div class="row">
        <div class="col-12">
            <div class="card">

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
