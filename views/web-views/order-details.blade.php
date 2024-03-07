@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Orders List'))

@push('css_or_js')
    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border- {{Session::get('direction') === "rtl" ? 'left' : 'right'}} : 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
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
    @php($current_lang = session()->get('local'))
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-6 mt-2 sidebar_heading">
                <h1 class="h3  mb-0 p-3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\Helpers::translate('Orders')}}</h1>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn--primary btn-primary mt-3" target="_blank"
                href="{{route('generate-invoice',[$order_local_id])}}">
                    <i class="tio-print mr-1"></i> {{\App\CPU\Helpers::translate('Print invoice')}}
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
         <div class="row gx-2 gy-3" id="printableArea">
            <div class="col-lg-12 col-xl-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-10 justify-content-between mb-4">
                            <div class="d-flex flex-column gap-10">
                                <h4 class="text-capitalize">{{\App\CPU\Helpers::translate('Order_ID')}} {{ Helpers::get_local_orders_ids($order['id']) }}</h4>
                                <div class="d-flex">
                                    <span class="title-color">{{\App\CPU\Helpers::translate('Order date and time')}} : </span>
                                    <span class="mx-2">
                                        <i class="tio-date-range"></i> {{date('Y/m/d H:i:s',strtotime($order['created_at']))}}
                                    </span>
                                </div>
                                <div class="d-flex flex-column gap-2 mt-3" dir="rtl">
                                    <!-- Order status -->
                                    <div class="d-flex">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('order status')}} : </span>
                                        <span class="badge badge-soft-info font-weight-bold radius-50 d-flex align-items-center py-1 mx-2">
                                            {{ $d['data']['status']['name'] }}
                                        </span>
                                    </div>

                                    {{--  customer  --}}
                                    <div class="">
                                        <span class="mt-2 d-inline-block">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('end customer name')}} :</span>
                                            <strong> {{ $d['data']['customer']['first_name'] }} {{ $d['data']['customer']['last_name'] }}</strong>
                                        </span>
                                        <a class="btn btn-primary mx-2 float-{{((session()->get('direction') ?? 'rtl') == 'ltr') ? 'right' : 'left'}}" onclick="copyToClipboard('{{ $d['data']['customer']['first_name'] }} {{ $d['data']['customer']['last_name'] }}')"> <i class="fa fa-copy"></i> </a>
                                    </div>
                                    <div class="">
                                        <span class="mt-2 d-inline-block">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('Mobile number')}} :</span>
                                            <strong> {{ $d['data']['customer']['mobile_code'].$d['data']['customer']['mobile'] }}</strong>
                                        </span>
                                        <a class="btn btn-primary mx-2 float-{{((session()->get('direction') ?? 'rtl') == 'ltr') ? 'right' : 'left'}}" onclick="copyToClipboard('{{$d['data']['customer']['mobile_code'].$d['data']['customer']['mobile']}}')"> <i class="fa fa-copy"></i> </a>
                                    </div>
                                    <div class="">
                                        <span class="mt-2 d-inline-block">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('end customer email')}} :</span>
                                            <strong> {{ $d['data']['customer']['email'] }}</strong>
                                        </span>
                                        <a class="btn btn-primary mx-2 float-{{((session()->get('direction') ?? 'rtl') == 'ltr') ? 'right' : 'left'}}" onclick="copyToClipboard('{{ $d['data']['customer']['email'] }}')"> <i class="fa fa-copy"></i> </a>
                                    </div>

                                    <!-- reference-code -->
                                    <div class="">
                                        <span class="mt-2 d-inline-block">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('The order number in the online store platform')}} :</span>
                                            <strong>{{str_replace('_',' ',$d['data']['reference_id'])}}</strong>
                                        </span>
                                        <a class="btn btn-primary mx-2 float-{{((session()->get('direction') ?? 'rtl') == 'ltr') ? 'right' : 'left'}}" onclick="copyToClipboard({{$d['data']['reference_id']}})"> <i class="fa fa-copy"></i> </a>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment method')}} :</span>
                                        <strong> {{str_replace('_',' ',$d['data']['payment_method'])}}</strong>
                                    </div>



                                    <!-- Payment Status -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment Status')}} :</span>
                                        @if(!$d['data']['is_pending_payment'])
                                            <span class="text-success font-weight-bold">
                                                {{\App\CPU\Helpers::translate('Paid')}}
                                            </span>
                                        @else
                                            <span class="text-danger font-weight-bold">
                                                {{\App\CPU\Helpers::translate('Unpaid')}}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex flex-column gap-10">

                                <!-- Body -->
                                @if($order->customer)
                                    <div class="card-body">
                                        <h4 class="mb-4 d-flex align-items-center gap-2">
                                            <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                            {{\App\CPU\Helpers::translate('Customer_information')}}
                                        </h4>

                                        <div class="media flex-wrap gap-3">
                                            <div class="">
                                                <img
                                                    class="avatar rounded-circle avatar-70" style="width: 75px;height: 42px"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset('storage/app/public/profile/'.App\User::find($order->seller_id)->image)}}"
                                                    alt="Image">
                                            </div>
                                            <div class="media-body d-flex flex-column gap-1">
                                                <span class="title-color hover-c1"><strong>{{App\User::find($order->seller_id)->name}}</strong></span>
                                                <span class="title-color break-all"><strong>{{App\User::find($order->seller_id)->phone}}</strong></span>
                                                <span class="title-color break-all" style="white-space: nowrap">{{App\User::find($order->seller_id)->email}}</span>
                                            </div>
                                            <div class="media-body text-right">
                                                {{--<i class="tio-chevron-right text-body"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div class="media align-items-center">
                                            <span>{{\App\CPU\Helpers::translate('no_customer_found')}}</span>
                                        </div>
                                    </div>
                            @endif
                            <!-- End Body -->
                            </div>


                        </div>

                        <div class="table-responsive datatable-custom">
                            <table class="table fz-12 table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Item_Details')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Quantity')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Price')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Discount')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Tax')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Total')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @php($subtotal=0)
                                @php($total=0)
                                @php($shipping=0)
                                @php($discount=0)
                                @php($tax=0)
                                @php($extra_discount=0)
                                @php($product_price=0)
                                @php($total_product_price=0)
                                @php($coupon_discount=0)
                                @php($i = 0)
                                @foreach($products as $key=>$product)
                                @php($local_product = $product['product'])
                                    @if($product)
                                    @php($i = $i + 1)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <div class="media align-items-center gap-10">
                                                    <img src="{{$product['product']['thumbnail']}}"  class="avatar avatar-60 rounded" alt="">
                                                    <div>
                                                        <a href="#" class="title-color hover-c1"><h6>{{$product['product']['name']}}</h6></a>
                                                        <div><strong>{{\App\CPU\Helpers::translate('Item Number')}} :</strong> {{Helpers::get_local_product($local_product['id'],auth()->id())->item_number ?? null}}</div>
                                                        <div class="d-flex">
                                                            <div><strong>{{\App\CPU\Helpers::translate('product_code_sku')}} : </strong></div>
                                                            <div>
                                                                {{$local_product['sku']}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ ($product['quantity'] ?? 1) }}
                                            </td>
                                            <td>
                                                {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['amounts']['price_without_tax']['amount']))}}
                                            </td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['amounts']['total_discount']['amount']))}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['amounts']['tax']['amount']['amount']))}}</td>

                                            @php($subtotal=$product['amounts']['price_without_tax']['amount']*$product['quantity']+$product['amounts']['tax']['amount']['amount']-$product['amounts']['total_discount']['amount'])
                                            @php($product_price = $product['amounts']['price_without_tax']['amount']*($product['quantity'] ?? 1))
                                            @php($total_product_price+=$product_price)
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</td>
                                        </tr>
                                        @php($discount+=$product['amounts']['total_discount']['amount'])
                                        @php($tax+=$product['amounts']['tax']['amount']['amount'])
                                        @php($total+=$subtotal)
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function cancel_message() {
            toastr.info('{{\App\CPU\Helpers::translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush
