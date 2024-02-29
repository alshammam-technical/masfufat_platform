@extends('layouts.back-end.app')

@section('content')

<div class="content container-fluid" >
    <!-- Page Title -->
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Shipping_Method')}}
        </h2>
    </div>
    <!-- End Page Title -->
    <!-- Page Title -->
    <div class="col-lg-6 pt-0">
        <div style="display: flex; align-items: center; width: 100%;">
            <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.settings')}}">{{\App\CPU\Helpers::translate('settings')}}</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.business-settings.shipping-method.setting')}}">
                        {{\App\CPU\Helpers::translate('Shipping_Method')}}</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page"><a href="#" style="color: #1e2022">
                        {{\App\CPU\Helpers::translate('Shipping_Method edit')}}</a>
                    </li>
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
    </div>
    <!-- End Page Title -->
        <div class="col-12" id="order_wise_shipping">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 text-capitalize">{{\App\CPU\Helpers::translate('Adjust the shipping cost for')}} {{\App\CPU\Helpers::translate($shipping_company->name)}}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.business-settings.shipping-method.editcostadjustment')}}"
                                style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-3 col-12">
                                    @php($sh = Helpers::get_business_settings('shipping_company_img')[$shipping_company->name] ?? null)
                                    <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:auto;border-radius:11px">
                                </div>
                                <div class="col-lg-3 col-12">
                                    <input type="file" class="form-control" onchange="readURL(this)" name="shipping_company_img[{{ $shipping_company->name }}]" />
                                </div>
                                <input type="hidden" name="id" value="{{ $shipping_company->id }}" />
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="title">{{\App\CPU\Helpers::translate('name')}}</label>
                                            <input type="text" name="name" value="{{ $shipping_company->name }}" class="form-control" placeholder="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="duration">{{\App\CPU\Helpers::translate('Shipping charges')}}</label>
                                            <input type="text" pattern="\d*" t="number" name="shipping_charges" class="form-control" value="{{ $shipping_company->shipping_charges }}" placeholder="4">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="duration">{{\App\CPU\Helpers::translate('TAX')}} %</label>
                                            <input type="text" name="tax" class="form-control" value="{{ $shipping_company->tax }}" placeholder="15">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="cost">{{\App\CPU\Helpers::translate('Maximum shipment weight limit')}}</label>
                                            <input type="text" pattern="\d*" t="number" min="0" max="1000000" name="maximum_weight_limit" class="form-control" value="{{ $shipping_company->maximum_weight_limit }}" placeholder="5">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="tax">{{\App\CPU\Helpers::translate('The price of the extra kilogram after the maximum weight')}}</label>
                                            <input type="text" pattern="\d*" t="number" min="0" max="1000000" name="price_per_kilo_extra" class="form-control" value="{{ $shipping_company->price_per_kilo_extra }}" placeholder="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="tax">{{\App\CPU\Helpers::translate('The cost of returning the shipment')}}</label>
                                            <input type="text" pattern="\d*" t="number" min="0" max="10000000" name="price_shipment_recovery" class="form-control" value="{{ $shipping_company->price_shipment_recovery }}" placeholder="11">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="tax">{{\App\CPU\Helpers::translate('total')}}</label>
                                            <input type="text" pattern="\d*" t="number" min="0" max="10000000" name="total" class="form-control" value="{{ $shipping_company->total }}" placeholder="150">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-end gap-10">
                                    <button type="submit" class="btn bg-primaryColor btn-primary px-4 bg-primaryColor"">{{\App\CPU\Helpers::translate('edit')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).closest('.row').find('img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
