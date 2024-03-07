@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Order Details'))

@push('css_or_js')
    <style>
        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}              !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .card {
            border: none
        }


        .totals tr td {
            font-size: 13px
        }

        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: black;
            font-weight: 900;
            font-size: 13px;

        }

        .spandHeadO {
            color: black !important;
            font-weight: 400;
            font-size: 13px;

        }

        .font-name {
            font-weight: 600;
            font-size: 12px;
            color: #030303;
        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;
            margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 60px;

        }

        a {
            color: {{$web_config['primary_color']}};
            cursor: pointer;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: #1B7FED;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }

        @media (max-width: 768px) {
            .for-tab-img {
                width: 100% !important;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 360px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }

            .order_table_tr {
                display: grid;
            }

            .order_table_td {
                border-bottom: 1px solid #fff !important;
            }

            .order_table_info_div {
                width: 100%;
                display: flex;
            }

            .order_table_info_div_1 {
                width: 50%;
            }

            .order_table_info_div_2 {
                width: 49%;
                text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}          !important;
            }

            .spandHeadO {
                font-size: 16px;
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 16px;
            }

            .spanTr {
                font-size: 16px;
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 16px;
                margin-top: 10px;
            }

            .amount {
                font-size: 13px;
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 0px;

            }

        }

        .table, .dataTables_scrollHead{
            background-color: #fff;
        }

        .in-header, .in-header *{
            font-size: 17px
        }

        .title-color{
            text-align-last: start;
        }
    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->


            {{-- Content --}}
            <section class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <a class="page-link" href="{{ route('orders') }}">
                            <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>{{\App\CPU\Helpers::translate('back')}}
                        </a>
                    </div>
                </div>


                <div class="card box-shadow-sm p-4">
                    @if(\App\CPU\Helpers::get_business_settings('order_verification'))
                        <div class="card-header">
                            <h4>{{\App\CPU\Helpers::translate('order_verification_code')}} : {{$order['verification_code']}}</h4>
                        </div>
                    @endif
                    <div class="payment table-responsive">
                        @if(isset($order['seller_id']) != 0)
                            @php($shopName=\App\Model\Shop::where('seller_id', $order['seller_id'])->first())
                        @endif
                        {{--  ext info  --}}
                        <div class="d-flex flex-wrap gap-10 justify-content-between mb-4">
                            <div class="d-flex flex-column gap-10">
                                <div class="d-flex mb-2">
                                @if($previousOrder)
                                <a title="{{Helpers::translate('Previous')}}" class="btn ml-2 pr-0 btn-icon-text p-0 pl-1" href="{{ route('orders.show', ['id'=>$previousOrder->id]) }}">
                                    <i class="czi-arrow-right text-black text-lg  mx-1"></i>{{Helpers::translate('Previous')}}
                                </a>
                                @endif
                                <h4 class="text-capitalize">{{\App\CPU\Helpers::translate('Order_ID')}} {{ $order['id'] }}</h4>

                                @if($nextOrder)
                                <a title="{{Helpers::translate('Next')}}" class="btn mx-2 btn-icon-text p-0 pr-1" href="{{ route('orders.show', ['id'=>$nextOrder->id]) }}">
                                    {{Helpers::translate('Next')}}<i class="czi-arrow-left  text-black text-lg  mx-1"></i>
                                </a>
                                @endif
                                </div>
                                <div class="d-flex">
                                    <span class="title-color">{{\App\CPU\Helpers::translate('Order date and time')}} : </span>
                                    <span class="mx-2">
                                        <i class="tio-date-range"></i> {{date('Y/m/d H:i:s',strtotime($e_order['created_at']))}}
                                    </span>
                                </div>
                                <div class="d-flex flex-column gap-2 mt-3" dir="rtl">
                                    <!-- Order status -->
                                    <div class="d-flex">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('order status in Masfufat platform')}} : </span>

                                        @if(in_array($order['order_status'],['pending','new']))
                                        <span class="badge badge-soft-info fz-12">
                                            {{Helpers::translate($order['order_status'])}}
                                        </span>

                                        @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
                                            <span class="badge badge-soft-warning fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @elseif($order['order_status']=='confirmed')
                                            <span class="badge badge-soft-success fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @elseif($order['order_status']=='failed')
                                            <span class="badge badge-danger fz-12">
                                                {{$order['order_status'] == 'failed' ? Helpers::translate('Failed To Deliver') : ''}}
                                            </span>
                                        @elseif($order['order_status']=='delivered')
                                            <span class="badge badge-soft-success fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @endif

                                    </div>
                                    <div>
                                    @if($d['data']['status']['name'] == "ملغي")
                                    <div class="d-flex">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Reason for cancellation')}} : </span>
                                        <strong>
                                            {{ $order['admin_note'] }}
                                        </strong>
                                    </div>
                                    @endif
                                    @if (in_array($order['order_status'],['pending','new']))
                                    <div class="d-flex">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Reason for suspending the order')}} : </span>
                                        <strong>
                                            {{ $order['admin_note'] }}
                                        </strong>
                                    </div>
                                    @endif
                                    </div>
                                    <!-- Payment Status -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment Status of the local order')}} :</span>
                                        <span class="text-primary font-weight-bold">
                                            {{\App\CPU\Helpers::translate($order->payment_status)}}
                                        </span>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment methodd')}} :</span>
                                        <strong> {{ $order->payment_method }}</strong>
                                    </div>

                                    <!-- Shipping Company -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Shipping and delivering Company')}} :</span>
                                        @isset($order->shipping_info['shipment_data'])
                                            <strong>
                                                {{ Helpers::translate("Bettween Company") }}
                                            </strong>
                                            @else
                                            <strong>
                                                {{ Helpers::translate($order->shipping_info['order']['courier'] ?? null) }}
                                            </strong>
                                            @endisset
                                    </div>

                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('tracking number of shipping and delivering Company')}} :</span>
                                        @isset($order->shipping_info['shipment_data'])
                                            <a target="_blank" href="{{ $order->shipping_info['shipment_data']['shipping_tracking_url'] ?? null }}">
                                                <strong>
                                                    {{ ($order->shipping_info['shipment_data']['shipping_tracking_no'] ?? null) !== "" ? $order->shipping_info['shipment_data']['shipping_tracking_no'] : 'none' }}
                                                </strong>
                                            </a>
                                        @else
                                            <strong>
                                                {{ ($order->shipping_info['order']['shipmentCode'] ?? null) }}
                                            </strong>
                                        @endisset
                                    </div>

                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('shipment status on shipping and delivering Company')}} :</span>
                                        @isset($order->shipping_info['shipment_data'])
                                            <strong>
                                                {{ Helpers::translate($order->shipping_info['shipment_data']['status'] ?? null) }}
                                            </strong>
                                        @else
                                            <strong>
                                                {{ Helpers::translate($order->shipping_info['order']['status'] ?? null) }}
                                            </strong>
                                        @endisset
                                    </div>


                                </div>
                            </div>

                            <div class="d-flex flex-column gap-9">
                                <!-- Body -->
                                @if($e_order->customer)
                                    <div class="card-body pb-0">
                                        <h4 class="mb-4 d-flex align-items-center gap-2">
                                        </h4>

                                        <div class="media flex-wrap gap-3">
                                            <div class="">
                                            </div>
                                            <div class="media-body d-flex flex-column gap-1">
                                            </div>
                                            <div class="media-body text-right">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- End Body -->
                                <div class="d-flex flex-column gap-2 mt-0" dir="rtl">
                                    <!-- Order status -->
                                    <div class="d-flex">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('order status in market platform')}} : </span>

                                        @if($d['data']['status']['name'] == "ملغي")
                                        <span class="badge badge-soft-danger font-weight-bold radius-50 d-flex align-items-center py-1 mx-2">
                                            {{ $d['data']['status']['name'] }}
                                        </span>
                                        @else
                                        <span class="badge badge-soft-info font-weight-bold radius-50 d-flex align-items-center py-1 mx-2">
                                            {{ $d['data']['status']['name'] }}
                                        </span>
                                        @endif

                                    </div>
                                    <!-- Payment Status -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment Status of the synced order')}} :</span>
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
                                    <!-- Payment Method -->
                                    <div class="">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment method')}} :</span>
                                        <strong> {{str_replace('_',' ',$d['data']['payment_method'])}}</strong>
                                    </div>
                                    <!-- reference-code -->
                                    <div class="">
                                        <span class="mt-2 d-inline-block">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('The order number in the online store platform')}} :</span>
                                            <strong>{{str_replace('_',' ',$d['data']['reference_id'])}}</strong>
                                        </span>
                                        <a class="btn btn-primary mx-2 float-{{((session()->get('direction') ?? 'rtl') == 'ltr') ? 'right' : 'left'}}" onclick="copyToClipboard({{$d['data']['reference_id']}})"> <i class="fa fa-copy"></i> </a>
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









                                </div>
                            </div>
                        </div>
                        {{--  ext info  --}}
                        @include('web-views.order-details-component')
                        @php($ps = $order->payment_status ?? null)
                        @if($ps !== "paid" && in_array($order->order_status , ['pending','new']))
                        @if (\App\CPU\Helpers::store_module_permission_check('order.sync.payment_completion'))
                        <a role="button" href="{{ route('home') }}/checkout-complete-by-customer/{{ $order['id'] }}" class="btn btn-primary w-full">
                            {{ Helpers::translate('Payment completion') }}
                        </a>
                        @endif
                        @endif
                </div>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="card-header">
                                {{\App\CPU\Helpers::translate('write_something')}}
                            </div>
                            <div class="modal-body">
                                <form action="{{route('messages_store')}}" method="post" id="chat-form">
                                    @csrf
                                    <input value="{{$order->delivery_man_id}}" name="delivery_man_id" hidden>

                                    <textarea name="message" class="form-control" required></textarea>
                                    <br>
                                    <button class="btn bg-primaryColor text-light" style="color: white;">{{\App\CPU\Helpers::translate('send')}}</button>
                                </form>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('chat', ['type' => 'delivery-man'])}}" class="btn bg-primaryColor mx-1">
                                    {{\App\CPU\Helpers::translate('go_to chatbox')}}
                                </a>
                                <button type="button" class="btn btn-secondary pull-right" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection


@push('script')
    <script>
        function review_message() {
            toastr.info('{{\App\CPU\Helpers::translate('you_can_review_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        function refund_message() {
            toastr.info('{{\App\CPU\Helpers::translate('you_can_refund_request_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
    <script>
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{route('messages_store')}}',
                data: $('#chat-form').serialize(),
                success: function (respons) {

                    toastr.success('{{\App\CPU\Helpers::translate('send successfully')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#chat-form').trigger('reset');
                }
            });

        });
    </script>
@endpush

