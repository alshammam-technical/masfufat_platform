@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\Helpers::translate('Order Details'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{\App\CPU\Helpers::translate('Orders')}}
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{\App\CPU\Helpers::translate('order_details')}}
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <div class="row gy-3 gx-2" id="printableArea">
            <div class="col-lg-8 col-xl-9">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-10 justify-content-between mb-4">
                            <div class="d-flex flex-column gap-10">
                                <h4 class="text-capitalize">{{\App\CPU\Helpers::translate('Order_ID')}} #{{$order['id']}}</h4>
                                <div class="">
                                    <i class="tio-date-range"></i> {{date('d M Y H:i:s',strtotime($order['created_at']))}}
                                </div>
                            </div>
                            <div class="text-sm-right">
                                <div class="d-flex flex-wrap gap-10 justify-content-sm-end">
                                    <a class="btn btn--primary btn-primary px-4" target="_blank"
                                    href="{{route('seller.orders.generate-invoice',[$order['id']])}}">
                                        <i class="tio-print mr-1"></i> {{\App\CPU\Helpers::translate('Print invoice')}}
                                    </a>
                                </div>
                                <div class="d-flex flex-column gap-2 mt-3">
                                    <!-- Order status -->
                                    <div class="order-status d-flex justify-content-sm-end gap-10 text-capitalize">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Status')}}: </span>
                                        @if($order['order_status']=='pending')
                                            <span class="badge badge-soft-info font-weight-bold radius-50 d-flex align-items-center py-1 px-2">{{\App\CPU\Helpers::translate(str_replace('_',' ',$order['order_status']))}}
                                            </span>
                                        @elseif($order['order_status']=='failed')
                                            <span class="badge badge-danger font-weight-bold radius-50 d-flex align-items-center py-1 px-2">{{\App\CPU\Helpers::translate(str_replace('_',' ',$order['order_status']))}}
                                            </span>
                                        @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
                                            <span class="badge badge-soft-warning font-weight-bold radius-50 d-flex align-items-center py-1 px-2">{{\App\CPU\Helpers::translate(str_replace('_',' ',$order['order_status']))}}
                                            </span>
                                        @elseif($order['order_status']=='delivered' || $order['order_status']=='confirmed')
                                            <span class="badge badge-soft-success font-weight-bold radius-50 d-flex align-items-center py-1 px-2">{{\App\CPU\Helpers::translate(str_replace('_',' ',$order['order_status']))}}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger font-weight-bold radius-50 d-flex align-items-center py-1 px-2">{{\App\CPU\Helpers::translate(str_replace('_',' ',$order['order_status']))}}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="payment-method d-flex justify-content-sm-end gap-10 text-capitalize">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Payment Method')}} :</span>
                                        <strong> {{str_replace('_',' ',$order['payment_method'])}}</strong>
                                    </div>

                                    <!-- reference-code -->
                                    <div class="reference-code d-flex justify-content-sm-end gap-10 text-capitalize">
                                        <span class="title-color">{{\App\CPU\Helpers::translate('Reference Code')}} :</span>
                                        <strong>{{str_replace('_',' ',$order['transaction_ref'])}}</strong>
                                    </div>

                                    <!-- Payment Status -->
                                    <div class="payment-status d-flex justify-content-sm-end gap-10">
                                        <span class="title-color">Payment Status:</span>
                                        @if($order['payment_status']=='paid')
                                            <span class="text-success font-weight-bold">
                                                {{\App\CPU\Helpers::translate('Paid')}}
                                            </span>
                                        @else
                                            <span class="text-danger font-weight-bold">
                                                {{\App\CPU\Helpers::translate('Unpaid')}}
                                            </span>
                                        @endif
                                    </div>

                                    @if(\App\CPU\Helpers::get_business_settings('order_verification'))
                                        <span class="ml-2 ml-sm-3">
                                            <b>
                                                {{\App\CPU\Helpers::translate('order_verification_code')}} : {{$order['verification_code']}}
                                            </b>
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="table-responsive datatable-custom">
                            <table class="table fz-12 table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Item Details')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Variations')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Tax')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Discount')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Price')}}</th>
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

                                @foreach($order->details as $key=>$detail)
                                    @if($detail->product)
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <div class="media align-items-center gap-10">
                                                    <div class="d-flex flex-column gap-2">
                                                        @php($current_lang = session()->get('local'))
                                                        <img src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($detail->product['images'])->$current_lang)) ? json_decode($detail->product['images'])->$current_lang[0] ?? '' : ''}}" onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'" class="avatar avatar-60 rounded" alt="">
                                                        @if($detail->product->product_type == 'digital')
                                                            <button type="button" class="btn btn-sm btn--primary" title="File Upload" data-toggle="modal" data-target="#fileUploadModal-{{ $detail->id }}" onclick="modalFocus('fileUploadModal-{{ $detail->id }}')">
                                                                <i class="tio-file-outlined"></i> {{\App\CPU\Helpers::translate('File')}}
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a href="#" class="title-color hover-c1"><h6>{{substr($detail->product['name'],0,30)}}{{strlen($detail->product['name'])>10?'...':''}}</h6></a>
                                                        <div><strong>{{\App\CPU\Helpers::translate('Price')}} :</strong> {{\App\CPU\BackEndHelper::set_symbol(($detail['price']))}}</div>
                                                        <div><strong>{{\App\CPU\Helpers::translate('Qty')}} :</strong> {{ $detail['qty'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$detail['variant']}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(($detail['tax']))}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(($detail['discount']))}}</td>

                                            @php($subtotal=$detail['price']*$detail->qty+$detail['tax']-$detail['discount'])
                                            @php($product_price = $detail['price']*$detail['qty'])
                                            @php($total_product_price+=$product_price)
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(($subtotal))}}</td>
                                            @if($detail->product->product_type == 'digital')
                                                <div class="modal fade" id="fileUploadModal-{{ $detail->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="{{ route('seller.pos.digital-file-upload-after-sell') }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    @if($detail->product->digital_product_type == 'ready_after_sell' && $detail->digital_file_after_sell)
                                                                        <div class="mb-4">
                                                                            {{\App\CPU\Helpers::translate('uploaded_file')}} :
                                                                            <a href="{{ asset('storage/app/public/product/digital-product/'.$detail->digital_file_after_sell) }}"
                                                                               class="btn btn-success btn-sm" title="Download" download><i class="tio-download"></i> Download</a>
                                                                        </div>
                                                                    @elseif($detail->product->digital_product_type == 'ready_product' && $detail->product->digital_file_ready)
                                                                        <div class="mb-4">
                                                                            {{\App\CPU\Helpers::translate('uploaded_file')}} :
                                                                            <a href="{{ asset('storage/app/public/product/digital-product/'.$detail->product->digital_file_ready) }}"
                                                                               class="btn btn-success btn-sm" title="Download" download><i class="tio-download"></i> Download</a>
                                                                        </div>
                                                                    @endif

                                                                    @if($detail->product->digital_product_type == 'ready_after_sell')
                                                                        <input type="file" name="digital_file_after_sell" class="form-control">
                                                                        <div class="mt-1 text-info">{{\App\CPU\Helpers::translate('File type: jpg, jpeg, png, gif, zip, pdf')}}</div>
                                                                        <input type="hidden" value="{{ $detail->id }}" name="order_id">
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}</button>
                                                                    @if($detail->product->digital_product_type == 'ready_after_sell')
                                                                        <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Upload')}}</button>
                                                                    @endif
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </tr>
                                        @php($discount+=$detail['discount'])
                                        @php($tax+=$detail['tax'])
                                        @php($total+=$subtotal)
                                    @endif
                                    @php($sellerId=$detail->seller_id)
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @php($shipping=$order['shipping_cost'])
                        <?php
                            if ($order['extra_discount_type'] == 'percent') {
                                $extra_discount = ($total_product_price / 100) * $order['extra_discount'];
                            } else {
                                $extra_discount = $order['extra_discount'];
                            }
                            if(isset($order['discount_amount'])){
                                $coupon_discount =$order['discount_amount'];
                            }
                        ?>
                        <hr>

                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row gy-1 text-sm-right">
                                    <dt class="col-sm-6">{{\App\CPU\Helpers::translate('extra_discount')}}</dt>
                                    <dd class="col-sm-6 btitle-color">
                                        <strong>- {{\App\CPU\BackEndHelper::set_symbol(($extra_discount))}}</strong>
                                    </dd>
                                    <dt class="col-sm-6">{{\App\CPU\Helpers::translate('coupon_discount')}}</dt>
                                    <dd class="col-sm-6 btitle-color">
                                        <strong>- {{\App\CPU\BackEndHelper::set_symbol(($coupon_discount))}}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{\App\CPU\Helpers::translate('Total')}}</dt>
                                    <dd class="col-sm-6 title-color">
                                        <strong>{{\App\CPU\BackEndHelper::set_symbol(($total+$shipping-$extra_discount - $coupon_discount))}}</strong>
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4 col-xl-3 d-flex flex-column gap-3">
                <!-- Card -->
                <div class="card">
                    <!-- Body -->
                    @if($order->customer)
                        <div class="card-body">
                            <h4 class="mb-4 d-flex gap-2">
                                <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                {{\App\CPU\Helpers::translate('Customer_information')}}
                            </h4>


                            <div class="media flex-wrap gap-3">
                                <div>
                                    <img class="avatar rounded-circle avatar-70"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/profile/'.$order->customer->image)}}"
                                        alt="Image">
                                </div>
                                <div class="media-body d-flex flex-column gap-1">
                                    <span class="title-color"><strong>{{$order->customer['f_name'].' '.$order->customer['l_name']}} </strong></span>
                                    <span class="title-color"><strong>{{\App\Model\Order::where('order_type','POS')->where('customer_id',$order['customer_id'])->count()}} </strong>{{\App\CPU\Helpers::translate('orders')}}</span>
                                    <span class="title-color"><strong>{{$order->customer['phone']}}</strong></span>
                                    <span class="title-color">{{$order->customer['email']}}</span>
                                </div>
                            </div>
                        </div>
                @endif
                <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>

@endsection

@push('script_2')


@endpush
