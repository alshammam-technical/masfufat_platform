@extends('web-views.education.frontend.layouts.front')
@section('title', $page->title)
@section('description', $page->short_description)
@section('footer', 'normal')
@section('content')
    <div class="container">
        <div class="page-card">
            <div class="page-card-header">
                <h4 class="mb-0">{{ $page->title }}</h4>
            </div>
            <div class="page-card-body fw-light pt-0">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection
