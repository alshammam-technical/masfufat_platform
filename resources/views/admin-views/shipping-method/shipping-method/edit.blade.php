@extends('layouts.back-end.app')

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <div style="display: flex; align-items: center; width: 100%;">
        <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Shipping Method Update')}}</li>
            </ol>
        </nav>
        <button id="help-center-button" class=" my-2 btn-icon-text m-2 btnn" style="border-radius: 10px;" target="_blank">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
            width="16.000000pt" height="16.000000pt" viewBox="0 0 48.000000 48.000000"
            preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,48.000000) scale(0.100000,-0.100000)"
            fill="#000000" stroke="none">
            <path d="M20 460 c-15 -15 -20 -33 -20 -70 l0 -50 180 0 180 0 0 50 c0 84 -13
            90 -180 90 -127 0 -142 -2 -160 -20z m75 -50 c0 -18 -6 -26 -23 -28 -13 -2
            -25 3 -28 12 -10 26 4 48 28 44 17 -2 23 -10 23 -28z m100 0 c0 -18 -6 -26
            -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z m100 0 c0
            -18 -6 -26 -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z"/>
            <path d="M0 240 l0 -60 93 0 92 0 20 37 c11 21 37 47 60 60 l40 23 -152 0
            -153 0 0 -60z"/>
            <path d="M291 242 c-38 -20 -71 -73 -71 -112 0 -62 68 -130 130 -130 62 0 130
            68 130 130 0 62 -68 130 -130 130 -14 0 -41 -8 -59 -18z m93 -38 c18 -18 21
            -60 5 -69 -5 -4 -14 -18 -20 -32 -5 -13 -15 -23 -22 -20 -16 6 -11 46 10 69
            13 15 14 21 4 31 -9 9 -16 7 -29 -11 -18 -23 -32 -21 -32 4 0 19 29 44 50 44
            10 0 26 -7 34 -16z m-19 -143 c7 -12 -12 -24 -25 -16 -11 7 -4 25 10 25 5 0
            11 -4 15 -9z"/>
            <path d="M0 90 c0 -78 18 -90 134 -90 l95 0 -24 43 c-14 23 -25 54 -25 70 l0
            27 -90 0 -90 0 0 -50z"/>
            </g>
            </svg>
        </button>
    </div>


    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Shipping_Method_Update')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Page Heading -->
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{\App\CPU\Helpers::translate('shipping_method update')}}</h1>
    </div> -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    {{\App\CPU\Helpers::translate('shipping_method form')}}
                </div> -->
                <div class="card-body">
                    <form action="{{route('admin.business-settings.shipping-method.update',[$method['id']])}}"
                          style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                          method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="title-color" for="title">{{\App\CPU\Helpers::translate('title')}}</label>
                                    <input type="text" name="title" value="{{$method['title']}}" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="title-color" for="duration">{{\App\CPU\Helpers::translate('duration')}}</label>
                                    <input type="text" name="duration" value="{{$method['duration']}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('4 to 6 days')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="title-color" for="cost">{{\App\CPU\Helpers::translate('cost')}}</label>
                                    <input type="text" t="number" min="0" max="1000000" name="cost" value="{{($method['cost'])}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10 $')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <label class="title-color" for="tax">{{\App\CPU\Helpers::translate('Value tax')}}</label>
                                    <input type="text" t="number" min="0" max="100" name="tax" class="form-control" value="{{($method['tax'])}}"
                                        placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10')}} ">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-10 flex-wrap justify-content-end">
                            <button type="submit" class="btn bg-primaryColor btn-primary px-4 bg-primaryColor"">{{\App\CPU\Helpers::translate('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
