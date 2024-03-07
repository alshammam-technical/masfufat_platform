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
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 60px;

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
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
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
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
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
                text-align: {{Session::get('direction') === "rtl" ? 'left' : 'right'}}          !important;
            }

            .spandHeadO {
                font-size: 16px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 16px;
            }

            .spanTr {
                font-size: 16px;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 16px;
                margin-top: 10px;
            }

            .amount {
                font-size: 13px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0px;

            }

        }

        .table, .dataTables_scrollHead{
            background-color: #fff;
        }

        .in-header, .in-header *{
            font-size: 17px
        }
    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->


            {{-- Content --}}
            <section class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <a class="page-link" href="{{ route('account-oder') }}">
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>{{\App\CPU\Helpers::translate('back')}}
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
                        <table class="table table-borderless in-header">
                            <thead>
                            <tr class="order_table_tr">
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2 d-flex">
                                            <span class="d-block spandHeadO">{{\App\CPU\Helpers::translate('order_no')}}: </span>
                                            <span class="spanTr px-2"> {{$order->id}} </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2 d-flex">
                                            <span class="d-block spandHeadO">{{\App\CPU\Helpers::translate('order_date')}}: </span>
                                            <span class="spanTr px-2"> {{date('d M, Y',strtotime($order->created_at))}} </span>
                                        </div>

                                    </div>
                                </td>
                                @if( $order->order_type == 'default_type')
                                    <td class="order_table_td">
                                        <div class="order_table_info_div">
                                            <div class="order_table_info_div_1 py-2 d-flex">
                                                <span class="d-block spandHeadO">{{\App\CPU\Helpers::translate('shipping_address')}}: </span>
                                                @if($order->shippingAddress)
                                                    @php($shipping=$order->shippingAddress)
                                                @else
                                                    @php($shipping=json_decode($order['shipping_address_data']))
                                                @endif

                                                <span class="spanTr px-2">
                                                    @if($shipping)
                                                        {{$shipping->address ?? null}},
                                                        {{$shipping->city ?? null}}
                                                        , {{$shipping->zip ?? null}}

                                                    @endif
                                                </span>
                                            </div>

                                        </div>
                                    </td>
                                @endif
                            </tr>
                            </thead>
                        </table>
                        <table class="table table-borderless p-3 m-0">
                            <thead>
                                <tr class="">
                                    <th class="fw-bold"> {{ Helpers::translate('number_') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('product image') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('product details') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('quantity') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('unit price') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('tax') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('discount') }} </th>
                                    <th class="fw-bold"> {{ Helpers::translate('price') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($current_lang = session()->get('local'))
                            @foreach ($order->details as $key=>$detail)
                                @php($product=json_decode($detail->product,true))
                                @if($product)
                                    <tr>
                                        <td class="pt-5">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="col-2 for-tab-img">
                                            <img class="d-block"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                                                alt="VR Collection" width="60">
                                        </td>
                                        <td class="pt-5">
                                            {{ Helpers::get_prop('App\Model\Product',$product['id'],'name') }}
                                        </td>
                                        <td class="pt-5">
                                            {{$detail->qty}}
                                        </td>
                                        <td class="pt-5">
                                            {{ Helpers::getProductPrice_pl($product['id'])['value'] }}
                                        </td>
                                        <td class="pt-5">
                                            {{ $detail['tax'] }}
                                        </td>
                                        <td class="pt-5">
                                            {{ $detail['discount'] }}
                                        </td>
                                        <td class="pt-5">
                                            {{\App\CPU\Helpers::currency_converter($detail->price)}}
                                        </td>
                                        <?php
                                            $refund_day_limit = \App\CPU\Helpers::get_business_settings('refund_day_limit');
                                            $order_details_date = $detail->created_at;
                                            $current = \Carbon\Carbon::now();
                                            $length = $order_details_date->diffInDays($current);
                                        ?>
                                        <td class="text-center">
                                            @if($order->order_type == 'default_type')
                                                @if($order->order_status=='delivered')
                                                    <a href="{{route('submit-review',[$detail->id])}}"
                                                       class="btn btn--primary btn-sm d-inline-block mb-2" style="width: 100px">{{\App\CPU\Helpers::translate('review')}}</a>

                                                    @if($detail->refund_request !=0)
                                                        <a href="{{route('refund-details',[$detail->id])}}"
                                                           class="btn btn--primary btn-sm d-inline-block mb-2" style="width: 100px">
                                                            {{\App\CPU\Helpers::translate('refund_details')}}
                                                        </a>
                                                    @endif
                                                    @if( $length <= $refund_day_limit && $detail->refund_request == 0)
                                                        <a href="{{route('refund-request',[$detail->id])}}"
                                                           class="btn btn--primary btn-sm d-inline-block" style="width: 100px">{{\App\CPU\Helpers::translate('refund_request')}}</a>
                                                    @endif
                                                    {{--@else
                                                        <a href="javascript:" onclick="review_message()"
                                                        class="btn btn--primary btn-sm d-inline-block mb-2">{{\App\CPU\Helpers::translate('review')}}</a>

                                                        @if($length <= $refund_day_limit)
                                                            <a href="javascript:" onclick="refund_message()"
                                                                class="btn btn--primary btn-sm d-inline-block">{{\App\CPU\Helpers::translate('refund_request')}}</a>
                                                        @endif --}}
                                                @endif
                                            @else
                                                <label class="badge badge-secondary">
                                                    <a
                                                        class="btn btn--primary btn-sm text-light">{{\App\CPU\Helpers::translate('pos_order')}}</a>
                                                </label>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @php($summary=\App\CPU\OrderManager::order_summary($order))
                            </tbody>
                        </table>
                        @php($extra_discount=0)
                        <?php
                        if ($order['extra_discount_type'] == 'percent') {
                            $extra_discount = ($summary['subtotal'] / 100) * $order['extra_discount'];
                        } else {
                            $extra_discount = $order['extra_discount'];
                        }
                        ?>
                        @if($order->delivery_type !=null)

                            <div class="p-2">
                                <h4 style="color: #130505 !important; margin:0px;text-transform: capitalize;">{{\App\CPU\Helpers::translate('delivery_info')}} </h4>
                                <hr>
                            </div>
                            <div class="row m-2">
                                <div class="col-md-8">
                                    @if ($order->delivery_type == 'self_delivery'  && $order->delivery_man_id)
                                        <p style="color: #414141 !important ; padding-top:5px;">

                                        <span style="text-transform: capitalize">
                                            {{\App\CPU\Helpers::translate('delivery_man_name')}} : {{$order->delivery_man['f_name'].' '.$order->delivery_man['l_name']}}
                                        </span>
                                        </p>
                                        @if($order->order_type == 'default_type')
                                            <button class="btn btn-outline--info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="fa fa-envelope"></i>
                                                {{\App\CPU\Helpers::translate('Chat_with_deliveryman')}}
                                            </button>
                                        @endif
                                    @else
                                        <p style="color: #414141 !important ; padding-top:5px;">
                                    <span>
                                        {{\App\CPU\Helpers::translate('delivery_service_name')}} : {{$order->delivery_service_name}}
                                    </span>
                                            <br>
                                            <span>
                                        {{\App\CPU\Helpers::translate('tracking_id')}} : {{$order->third_party_delivery_tracking_id}}
                                    </span>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-4 text-right">
                                    @if($order->order_type == 'default_type' && $order->order_status=='delivered' && $order->delivery_man_id)
                                        <a href="{{route('deliveryman-review',[$order->id])}}"
                                           class="btn btn-outline--info btn-sm">
                                            <i class="czi-star mr-1 font-size-md"></i>
                                            {{ $order->delivery_man_review ? \App\CPU\Helpers::translate('update') : '' }}
                                            {{\App\CPU\Helpers::translate('Deliveryman_Review')}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($order->order_note !=null)
                            <div class="p-2">

                                <h4>{{\App\CPU\Helpers::translate('order_note')}}</h4>
                                <hr>
                                <div class="m-2">
                                    <p>
                                        {{$order->order_note}}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{--Calculation--}}
                    <div class="row d-flex justify-content-end border-top">
                        <div class="col-md-12 col-lg-12">
                            <table class="table table-borderless">
                                <tbody class="totals">


                                <tr>
                                    <td style="width: 75%">
                                        <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                                class="product-qty ">{{\App\CPU\Helpers::translate('Discount on_product')}}</span>
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                            <span>- {{\App\CPU\Helpers::currency_converter($summary['total_discount_on_product'])}}</span>
                                        </div>
                                    </td>
                                </tr>

                                @if($order->order_type == 'default_type')
                                    <tr>
                                        <td style="width: 75%">
                                            <div
                                                class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                                    class="product-qty ">{{\App\CPU\Helpers::translate('Shipping Fee')}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                                <span>{{\App\CPU\Helpers::currency_converter($summary['total_shipping_cost'])}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                                @if($order->order_type != 'default_type')
                                    <tr>
                                        <td style="width: 75%">
                                            <div
                                                class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                                    class="product-qty ">{{\App\CPU\Helpers::translate('extra Discount')}}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                                <span>- {{\App\CPU\Helpers::currency_converter($extra_discount)}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td style="width: 75%">
                                        <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                                class="font-weight-bold">{{\App\CPU\Helpers::translate('Total')}}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                                class="font-weight-bold amount ">{{\App\CPU\Helpers::currency_converter($order->order_amount)}}</span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                    <button class="btn btn--primary text-light" style="color: white;">{{\App\CPU\Helpers::translate('send')}}</button>
                                </form>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('chat', ['type' => 'delivery-man'])}}" class="btn btn--primary mx-1">
                                    {{\App\CPU\Helpers::translate('go_to chatbox')}}
                                </a>
                                <button type="button" class="btn btn-secondary pull-right" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="justify-content mt-4 for-mobile-glaxy row">
                    <div class="col-1"></div>
                    <a  class="col-5 py-3 h1 btn btn--primary for-glaxy-mobile text-white mx-2"
                        href="{{route('generate-invoice',[$order->id])}}">
                        {{\App\CPU\Helpers::translate('generate_invoice')}}
                    </a>
                    <a class="col-5 py-3 h1 btn btn-secondary text-white mx-2"
                       href="{{route('track-order.result',['order_id'=>$order['id'],'from_order_details'=>1])}}"
                       style="color: white">
                        {{\App\CPU\Helpers::translate('Track Order')}}
                    </a>
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

