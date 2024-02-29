@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Notifications'))

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
    <div class="container rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-12 sidebar_heading">
                <h1 class="h3  mb-0 float-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\Helpers::translate('Notifications')}}</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->

        <!-- Content  -->
            <section class="col-lg-12 col-md-12 mt-2" id="set-wish-list">
                <!-- Item-->

                @include('web-views.partials._notification-data',['notifications'=>$notifications])
            </section>
        </div>
    </div>
@endsection

@push('script')

@endpush
