@extends('backend.layouts.form')
@section('title', __('Custom CSS'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.additional.css.update') }}" method="POST">
        @csrf
        <textarea name="cssContent" id="cssContent" class="form-control" rows="20">{{ $cssFile }}</textarea>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('/public/assets/vendor/libs/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/libs/codemirror/css.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/libs/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection