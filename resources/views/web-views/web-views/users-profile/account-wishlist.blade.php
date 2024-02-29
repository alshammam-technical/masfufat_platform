@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My Wishlists'))

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: sans-serif !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Title-->
    <div class="container rtl min-h-[500px]" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-12 sidebar_heading">
                <h1 class="h3  mb-0 float-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\Helpers::translate('WISHLIST')}}</h1>
            </div>
        </div>
        <div class="col-md-12 col-12" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
            @include('web-views.partials._wish-list-data',['wishlists'=>$wishlists, 'brand_setting'=>$brand_setting])
        </div>
    </div>
    <!-- Page Content-->
@endsection

@push('script')

@endpush
