@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('setup'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')

@endsection

@push('script')

@endpush
