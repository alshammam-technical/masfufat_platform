@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Order Details'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .order-status, .payment-status{
            align-self: start;
        }

        .table * th, .table * td{
            border: grey solid thin !important;
            text-align: center;
            *{
                text-align: center;
            }
        }

        .seller_info{
            max-width: 110px;
            white-space: pre-wrap !important;
        }

        .no-arrow {
            /* for Firefox */
            -moz-appearance: none;
            /* for Chrome */
            -webkit-appearance: none;
          }

          /* For IE10 */
          .no-arrow::-ms-expand {
            display: none;
          }
    </style>
@endpush

@section('content')
    @php($d = null)
    @if($order->external_order_id)
    @php($d = Helpers::get_external_order_details($order->external_order->external_order_id))
    @endif
    <div class="content container-fluid">
        <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{\App\CPU\Helpers::translate('Orders')}}
                            (
                            @if($status =='processing')
                                {{ ucwords(str_replace('_',' ',Helpers::translate('Packaging') )) }}
                            @elseif($status =='failed')
                                {{ ucwords(str_replace('_',' ',Helpers::translate('Failed to Deliver') )) }}
                            @else
                                {{ ucwords(str_replace('_',' ',Helpers::translate($status) )) }}
                            @endif
                            )
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{\App\CPU\Helpers::translate('order_details')}}
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

        <div class="row gy-3" id="printableArea">
            <div class="col-lg-8 col-xl-9">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-10 justify-content-between mb-4">
                            <div class="d-flex flex-column gap-10">
                                <h4 class="text-capitalize">{{\App\CPU\Helpers::translate('Order_ID')}} #{{$order['id']}}</h4>
                                <div class="">
                                    <i class="tio-date-range"></i> {{date('H:i:s Y/m/d',strtotime($order['created_at']))}}
                                </div>

                                <div class="d-flex flex-wrap gap-10">
                                    @foreach($linked_orders as $linked)
                                        <a href="{{route('admin.orders.details',[$linked['id']])}}"
                                           class="btn btn-info rounded py-1 px-2">{{$linked['id']}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-sm-right">
                                <div class="d-flex flex-wrap gap-10">
                                    <div class="">
                                        @if (isset($shipping_address['latitude']) && isset($shipping_address['longitude']))
                                            <button class="btn btn--primary btn-primary px-4" data-toggle="modal" data-target="#locationModal"><i
                                                    class="tio-map"></i> {{\App\CPU\Helpers::translate('show_locations_on_map')}}</button>
                                        @else
                                            <button class="btn btn-warning px-4">
                                                <i class="tio-map"></i> {{\App\CPU\Helpers::translate('shipping_address_has_been_given_below')}}
                                            </button>
                                        @endif
                                    </div>
                                    <a class="btn btn--primary btn-primary px-4" target="_blank"
                                       href={{route('admin.orders.generate-invoice',[$order['id']])}}>
                                        <i class="tio-print mr-1"></i> {{\App\CPU\Helpers::translate('Print invoice')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column gap-2 mt-3 mb-2" style="float: {{ session()->get('dir') == 'ltr' ? 'left' : 'right' }}">

                                <div class="payment-method d-flex justify-content-sm-end gap-10 text-capitalize" style="align-self: start">
                                    <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('order source')}} </span>:
                                    <strong>
                                        @switch($order->ordered_using)
                                            @case("Windows")
                                                {{ Helpers::translate('Computer browser') }} -
                                                @break
                                            @case("PostmanRuntime")
                                                {{ Helpers::translate('Computer browser') }} -
                                                @break
                                            @case("Dart")
                                                {{ Helpers::translate('Mobile application') }} -
                                                @break
                                            @case("Android")
                                                {{ Helpers::translate('Mobile browser') }} -
                                                @break
                                            @case("Mac")
                                                {{ Helpers::translate('Mobile browser') }} -
                                                @break
                                            @default
                                        @endswitch
                                        {!! $order->ext_order_id >= 1 ? Helpers::translate('synchronous') : Helpers::translate('direct') !!}
                                    </strong>
                                </div>

                                <!-- Order status -->
                                <div class="order-status d-flex justify-content-sm-end gap-10 text-capitalize" style="align-self: start">
                                    <span class="title-color" style="width:155px">{{\App\CPU\Helpers::translate('Status')}} </span>:
                                    @if($order['order_status']=='pending')
                                        <span class="badge badge-soft-info font-weight-bold radius-50 d-flex align-items-center py-1 px-2">
                                            {{ Helpers::translate($order['order_status']) }}
                                        </span>
                                    @elseif($order['order_status']=='failed')
                                        <span class="badge badge-danger font-weight-bold radius-50 d-flex align-items-center py-1 px-2">
                                            {{ Helpers::translate($order['order_status']) }}
                                        </span>
                                    @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
                                        <span class="badge badge-soft-warning font-weight-bold radius-50 d-flex align-items-center py-1 px-2">
                                            {{ Helpers::translate($order['order_status']) }}
                                        </span>
                                    @elseif($order['order_status']=='delivered' || $order['order_status']=='confirmed')
                                        <span class="badge badge-soft-success font-weight-bold radius-50 d-flex align-items-center py-1 px-2">
                                            {{ Helpers::translate($order['order_status']) }}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger font-weight-bold radius-50 d-flex align-items-center py-1 px-2">
                                            {{str_replace('_',' ',$order['order_status'])}}
                                        </span>
                                    @endif
                                </div>


                                <!-- Payment Method -->
                                <div class="payment-method d-flex justify-content-sm-end gap-10 text-capitalize" style="align-self: start">
                                    <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('Payment Method')}} </span>:
                                    <strong> {{ Helpers::translate($order['payment_method']) }} </strong>
                                </div>

                                <!-- reference-code -->
                                @if($order->payment_method != 'cash_on_delivery' && $order->payment_method != 'pay_by_wallet')
                                    <div class="reference-code d-flex justify-content-sm-end gap-10 text-capitalize" style="align-self: start">
                                        <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('reference number')}} </span>:
                                        <strong>{{str_replace('_',' ',$order['transaction_ref'])}}</strong>
                                    </div>
                                @endif
                                @if($order->payment_method == 'bank_transfer')
                                    <div class="reference-code d-flex justify-content-sm-end gap-10 text-capitalize" style="align-self: start">
                                        <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('Account Holder Name')}} </span>:
                                        <strong>{{str_replace('_',' ',$order->bank_info->holder_name)}}</strong>
                                    </div>
                                    <div class="reference-code d-flex justify-content-sm-end gap-10 text-capitalize" style="align-self: start">
                                        <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('Attachment')}} </span>:
                                        <strong>
                                            <a target="_blank" href="{{asset('storage/app/public/user')}}/{{ $order->bank_info->attachment }}">
                                                {{ Helpers::translate('Click to download') }}
                                            </a>
                                        </strong>
                                    </div>
                                @endif

                                <!-- Payment Status -->
                                <div class="payment-status d-flex justify-content-sm-end gap-10">
                                    <span class="title-color" style="width:155px">{{\App\CPU\Helpers::translate('Payment Status')}}</span>:
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
                            <div class="col-2"></div>
                            <div class="col-4 d-flex flex-column gap-2 mt-3 mb-2" style="float: {{ session()->get('dir') == 'ltr' ? 'right' : 'left' }}">
                                @if(1==2)
                                <span class="title-color">{{\App\CPU\Helpers::translate('shipping info')}}: </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Note -->
                        <div class="mb-5">
                            @if ($order->order_note !=null)
                                <div class="d-flex align-items-center gap-10">
                                    <strong class="c1 bg-soft--primary text-capitalize py-1 px-2">
                                        # {{\App\CPU\Helpers::translate('note')}} :
                                    </strong>
                                    <div>{{$order->order_note}}</div>
                                </div>
                            @endif
                        </div>

                        <div class="table-responsive datatable-custom">
                            <table class="table fz-12 table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Item Details')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Qty')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Unit price')}}</th>
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
                                @php($row=0)

                                @php($seller = (isset($order->details[0]->seller) ? $order->details[0]->seller : null))
                                @foreach($order->details as $key=>$detail)
                                    @if($detail->product || $detail->product_details)
                                    @php($product = $detail->product ?? json_decode($detail->product_details))
                                        <tr>
                                            <td>{{ ++$row }}</td>
                                            <td>
                                                <div class="media align-items-center gap-10">
                                                    @php($current_lang = session()->get('local'))
                                                    <img class="avatar avatar-60 rounded"
                                                         onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                                                         src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product->images)->$current_lang)) ? json_decode($product->images)->$current_lang[0] ?? '' : ''}}"
                                                         alt="Image Description">
                                                    <div>
                                                        @php($product_name = \App\CPU\Helpers::get_prop('App\Model\Product',$product->id,'name') ?? $product->name)
                                                        <a href="{{route('admin.product.edit',['id'=>$product->id])}}" title="{{$product_name}}">
                                                            <h6 class="title-color">
                                                                {{$product_name}}
                                                            </h6>
                                                        </a>
                                                        <div><strong>{{\App\CPU\Helpers::translate('Item Number')}} :</strong> {{$product->item_number ?? null}}</div>
                                                        <div class="d-flex">
                                                            <div><strong>{{\App\CPU\Helpers::translate('product_code_sku')}} : </strong></div>
                                                            <div>
                                                                {{$product->code}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(($product->digital_product_type ?? null) == 'ready_after_sell')
                                                    <button type="button" class="btn btn-sm btn--primary mt-2" title="File Upload" data-toggle="modal" data-target="#fileUploadModal-{{ $detail->id }}" onclick="modalFocus('fileUploadModal-{{ $detail->id }}')">
                                                        <i class="tio-file-outlined"></i> {{\App\CPU\Helpers::translate('File')}}
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                {{$detail->qty}}
                                            </td>
                                            <td>
                                                {{\App\CPU\BackEndHelper::set_symbol(($detail['price']))}}
                                            </td>
                                            <td>{{ \App\CPU\BackEndHelper::set_symbol(($detail['tax'] ?? ($d ? $d->data->items[$key]->amounts->tax->amount->amount : 0) ))}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(($detail['discount']))}}</td>
                                            @php($subtotal=$detail['price']*$detail->qty+($detail['tax'] ?? ($d ? $d->data->items[$key]->amounts->tax->amount->amount : 0))-$detail['discount'])
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(($subtotal))}}</td>
                                        </tr>
                                        @php($discount+=$detail['discount'])
                                        @php($tax+=$detail['tax'] ?? ($d ? $d->data->items[$key]->amounts->tax->amount->amount : 0))
                                        @php($total+=$subtotal)
                                        <!-- End Media -->
                                    @endif
                                    @php($sellerId=$detail->seller_id)

                                    @if(isset($detail->product->digital_product_type) && $detail->product->digital_product_type == 'ready_after_sell')
                                        <div class="modal fade" id="fileUploadModal-{{ $detail->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.orders.digital-file-upload-after-sell') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            @if($detail->digital_file_after_sell)
                                                                <div class="mb-4">
                                                                    {{\App\CPU\Helpers::translate('uploaded_file')}} :
                                                                    <a href="{{ asset('storage/app/public/product/digital-product/'.$detail->digital_file_after_sell) }}"
                                                                       class="btn btn-success btn-sm" title="Download" download><i class="tio-download"></i> {{\App\CPU\Helpers::translate('Download')}}</a>
                                                                </div>
                                                            @else
                                                                <h4 class="text-center">File not found!</h4>
                                                            @endif
                                                            @if($detail->seller_id == 1)
                                                                <input type="file" name="digital_file_after_sell" class="form-control">
                                                                <div class="mt-1 text-info">{{\App\CPU\Helpers::translate('File type: jpg, jpeg, png, gif, zip, pdf')}}</div>
                                                                <input type="hidden" value="{{ $detail->id }}" name="order_id">
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}</button>
                                                            @if($detail->seller_id == 1)
                                                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Upload')}}</button>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @php($shipping=$order['shipping_cost'])
                        @php($coupon_discount=$order['discount_amount'])
                        <hr />
                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-6">
                                <dl class="row gy-1" style="justify-content: end;">
                                    <dd class="col-6 title-color">
                                        <strong>{{\App\CPU\Helpers::translate('Shipping')}} : {{\App\CPU\BackEndHelper::set_symbol(($shipping))}}</strong>
                                    </dd>

                                    <dd class="col-6 title-color">
                                        <strong>
                                            {{\App\CPU\Helpers::translate('coupon_discount')}} : {{\App\CPU\BackEndHelper::set_symbol(($coupon_discount))}}
                                        </strong>
                                    </dd>

                                    <dd class="col-6 title-color">
                                        @if($order->external_order)
                                        <strong>{{\App\CPU\Helpers::translate('Total')}} : {{ $order->external_order['total'].' '.$order->external_order['currency']}}</strong>
                                        @else
                                        <strong>{{\App\CPU\Helpers::translate('Total')}} : {{\App\CPU\BackEndHelper::set_symbol(($total+$shipping-$coupon_discount))}}</strong>
                                        @endif
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
                @if(Helpers::module_permission_check('order.'.$order->order_status.'.order_status,order.'.$order->order_status.'.payment_status,order.'.$order->order_status.'.update_deliver_info'))
                <div class="card">
                    <div class="card-body text-capitalize d-flex flex-column gap-4">
                        <h4 class="mb-0 text-center">{{\App\CPU\Helpers::translate('Order_&_Shipping_Info ')}}</h4>

                        @if(Helpers::module_permission_check('order.'.$order->order_status.'.order_status'))
                        <div class="">
                            <label class="font-weight-bold title-color fz-14">{{\App\CPU\Helpers::translate('Order Status ')}}</label>
                            <select name="order_status" onchange="order_status(this.value)"
                                    class="status form-control" data-id="{{$order['id']}}">

                                <option value="pending" {{$order->order_status == 'pending'?'selected':''}} > {{\App\CPU\Helpers::translate('Pending')}}</option>
                                <option value="confirmed" {{$order->order_status == 'confirmed'?'selected':''}} > {{\App\CPU\Helpers::translate('Confirmed')}}</option>
                                <option value="processing" {{$order->order_status == 'processing'?'selected':''}} >{{\App\CPU\Helpers::translate('Packaging')}} </option>
                                <option class="text-capitalize" value="out_for_delivery" {{$order->order_status == 'out_for_delivery'?'selected':''}} >{{\App\CPU\Helpers::translate('out_for_delivery')}} </option>
                                <option value="delivered" {{$order->order_status == 'delivered'?'selected':''}} >{{\App\CPU\Helpers::translate('Delivered')}} </option>
                                <option value="failed" {{$order->order_status == 'failed'?'selected':''}} >{{\App\CPU\Helpers::translate('Failed_to_Deliver')}} </option>
                                <option value="returned" {{$order->order_status == 'returned'?'selected':''}} > {{\App\CPU\Helpers::translate('Returned')}}</option>
                                <option value="canceled" {{$order->order_status == 'canceled'?'selected':''}} >{{\App\CPU\Helpers::translate('Canceled')}} </option>
                            </select>
                        </div>
                        @endif

                        @if(Helpers::module_permission_check('order.'.$order->order_status.'.payment_status'))
                        <div class="">
                            <label class="font-weight-bold title-color fz-14">{{\App\CPU\Helpers::translate('Payment_Status')}}</label>
                            <select name="payment_status" class="payment_status form-control" data-id="{{$order['id']}}">
                                <option
                                    onclick="route_alert('{{route('admin.orders.payment-status',['id'=>$order['id'],'payment_status'=>'paid'])}}','Change status to paid ?')"
                                    href="javascript:"
                                    value="paid" {{$order->payment_status == 'paid'?'selected':''}} >
                                    {{\App\CPU\Helpers::translate('Paid')}}
                                </option>
                                <option value="unpaid" {{$order->payment_status == 'unpaid'?'selected':''}} >
                                    {{\App\CPU\Helpers::translate('Unpaid')}}
                                </option>
                            </select>
                        </div>
                        @endif

                        @if($physical_product)
                        @if(Helpers::module_permission_check('order.'.$order->order_status.'.update_deliver_info'))
                        <ul class="list-unstyled list-unstyled-py-4">
                            <li>
                                <label class="font-weight-bold title-color fz-14">
                                    {{\App\CPU\Helpers::translate('shipping_type')}}
                                    ({{str_replace('_',' ',$order->shipping_type)}})
                                </label>
                                @if ($order->shipping_type == 'order_wise')
                                    <label class="font-weight-bold title-color fz-14">
                                        {{\App\CPU\Helpers::translate('shipping method')}}
                                        ({{$order->shipping ? $order->shipping->title :'No shipping method selected'}})
                                    </label>
                                @endif

                                <select class="form-control text-capitalize" name="delivery_type" onchange="choose_delivery_type(this.value)">
                                    <option value="0">
                                        {{\App\CPU\Helpers::translate('choose_delivery_type')}}
                                    </option>

                                    <option value="self_delivery" {{$order->delivery_type=='self_delivery'?'selected':''}}>
                                        {{\App\CPU\Helpers::translate('by_self_delivery_man')}}
                                    </option>
                                    <option value="third_party_delivery" {{$order->delivery_type=='third_party_delivery'?'selected':''}} >
                                        {{\App\CPU\Helpers::translate('by_third_party_delivery_service')}}
                                    </option>
                                </select>
                            </li>
                            <li class="choose_delivery_man">
                                <label class="font-weight-bold title-color fz-14">
                                    {{\App\CPU\Helpers::translate('choose_delivery_man')}}
                                </label>
                                <select class="form-control text-capitalize js-select2-custom" name="delivery_man_id" onchange="addDeliveryMan(this.value)">
                                    <option
                                        value="0">{{\App\CPU\Helpers::translate('select')}}</option>
                                    @foreach($delivery_men as $deliveryMan)
                                        <option
                                            value="{{$deliveryMan['id']}}" {{$order['delivery_man_id']==$deliveryMan['id']?'selected':''}}>
                                            {{$deliveryMan['f_name'].' '.$deliveryMan['l_name'].' ('.$deliveryMan['phone'].' )'}}
                                        </option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="choose_delivery_man">
                                <label class="font-weight-bold title-color fz-14">
                                    {{\App\CPU\Helpers::translate('deliveryman_will_get')}} ({{ session('currency_symbol') }})
                                </label>
                                <input type="number" id="deliveryman_charge" onkeyup="amountDateUpdate(this, event)" value="{{ $order->deliveryman_charge }}" name="deliveryman_charge" class="form-control" placeholder="Ex: 20" required>
                            </li>
                            <li class="choose_delivery_man">
                                <label class="font-weight-bold title-color fz-14">
                                    {{\App\CPU\Helpers::translate('expected_delivery_date')}}
                                </label>
                                <input type="date" onchange="amountDateUpdate(this, event)" value="{{ $order->expected_delivery_date }}" name="expected_delivery_date" id="expected_delivery_date" class="form-control" required>
                            </li>
                            <li class=" mt-2" id="by_third_party_delivery_service_info">
                                @isset($order->shipping_info['order']['status'])
                                <div class="" style="align-self: start">
                                    <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('shipping company')}} </span>:
                                    <strong>
                                        {{ Helpers::translate($order->shipping_info['order']['courier']) }}
                                    </strong>
                                </div>
                                <div class="" style="align-self: start">
                                    <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('shipping status')}} </span>:
                                    <strong>
                                        {{ Helpers::translate($order->shipping_info['order']['status']) }}
                                    </strong>
                                </div>
                                <div class="" style="align-self: start">
                                    <span style="width:155px" class="title-color">{{\App\CPU\Helpers::translate('The reference number of the shipment')}} </span>:
                                    <strong style="display: inline-flex">
                                        {{ $order->shipping_info['order']['courierRefCode'] }}
                                        <form action="{{ route('admin.orders.printAWB') }}" method="post" target="_blank">
                                            @csrf
                                            <input type="hidden" name="ids" value="{{ $order['id'] }}">
                                            <button style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('bill of lading')}}">
                                                <i class="tio-print"></i>
                                            </button>
                                        </form>
                                    </strong>
                                </div>
                                @else
                                @php($def_sh = Helpers::get_business_settings('default_shipping_company'))
                                <label class="font-weight-bold title-color fz-14">
                                    {{ Helpers::translate('Generate bill of lading') }}
                                </label>
                                <form class="row px-3" method="post" action="{{route('admin.orders.genAWB')}}">
                                    <input type="hidden" name="ids" value="{{$order->id}}">
                                    @csrf
                                    <select name="courier" class="col-10" required>
                                        <option @if($def_sh == "None") selected @endif disabled></option>
                                        @foreach (Helpers::get_business_settings('shipping_companies') ?? [] as $sh)
                                        @if($sh !== "None")
                                        <option @if($def_sh == $sh) selected @endif value="{{$sh}}">{{ Helpers::translate($sh) }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary col-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endisset
                            </li>
                        </ul>
                        @endif
                        @endif
                    </div>
                </div>
                @endif

                <!-- Card -->
                <div class="card">
                    <!-- Body -->
                    @if($order->customer && $order->ext_order_id && isset($order->external_order->user))
                    @php($store_ = $order->external_order->user)
                        <div class="card-body">
                            <h4 class="mb-4 d-flex gap-2">
                                <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                {{\App\CPU\Helpers::translate('Customer_information')}}
                            </h4>
                            <div class="media flex-wrap gap-3">
                                <div class="">
                                    <img class="avatar rounded-circle avatar-70"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         @isset($store_->store_informations['image'])
                                         src="{{asset('storage/app/public/user/'.$store_->store_informations['image'])}}"
                                         @endisset
                                         alt="Image">
                                </div>
                                <div class="media-body d-flex flex-column gap-1">
                                    <span class="title-color"><strong>{{$store_->store_informations['company_name']}} </strong></span>

                                    <span class="title-color break-all"><strong>{{$store_['phone']}}</strong></span>
                                    <span class="title-color break-all">{{$store_['email']}}</span>
                                </div>
                            </div>
                        </div>
                    @elseif($order->customer && !$order->ext_order_id)
                        <div class="card-body">
                            <h4 class="mb-4 d-flex gap-2">
                                <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                {{\App\CPU\Helpers::translate('Customer_information')}}
                            </h4>

                            <div class="media flex-wrap gap-3">
                                <div class="">
                                    <img class="avatar rounded-circle avatar-70"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/user')}}/{{($order->customer->store_informations['image'] ?? '')}}"
                                        alt="Image">
                                </div>
                                <div class="media-body d-flex flex-column gap-1">
                                    <span class="title-color"><strong>{{$order->customer['name']}} </strong></span>
                                    <span class="title-color break-all"><strong>{{$order->customer['phone']}}</strong></span>
                                    <span class="title-color break-all">{{$order->customer['email']}}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="media">
                                <span>{{\App\CPU\Helpers::translate('no_customer_found')}}</span>
                            </div>
                        </div>
                    @endif
                    <!-- End Body -->
                </div>
                <!-- End Card -->

                <!-- Card -->
                @if($order->ext_order_id)
                <div class="card">
                    <!-- Body -->
                    <div class="card-body">
                        <h4 class="mb-4 d-flex gap-2">
                            <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                            {{\App\CPU\Helpers::translate('end Customer information')}}
                        </h4>
                        <div class="media flex-wrap gap-3">
                            <div class="">
                                <img class="avatar rounded-circle avatar-70"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/profile/'.$order->customer->image)}}"
                                        alt="Image">
                            </div>
                            <div class="media-body d-flex flex-column gap-1">
                                <span class="title-color"><strong>{{$order->customer['f_name'].' '.$order->customer['l_name']}} </strong></span>
                                <span class="title-color break-all"><strong>{{$order->customer['phone']}}</strong></span>
                                <span class="title-color break-all">{{$order->customer['email']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
                @endif

                <!-- Card -->
                @if($physical_product)
                <div class="card">
                    <!-- Body -->
                    @if($order->customer)
                        <div class="card-body">
                            <h4 class="mb-4 d-flex gap-2">
                                <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                {{\App\CPU\Helpers::translate('shipping_address')}}
                            </h4>

                            @if($order->shippingAddress)
                                @php($shipping_address=$order->shippingAddress)
                            @else
                                @php($shipping_address=json_decode($order['shipping_address_data']))
                            @endif

                            <div class="d-flex flex-column gap-2">
                                <div>
                                    <span>{{\App\CPU\Helpers::translate('contact_person_name')}} :</span>
                                    <strong>{{$shipping_address? $shipping_address->contact_person_name : ''}}</strong>
                                </div>

                                <div>
                                    <span>{{ \App\CPU\Helpers::translate('The receiving person mobile number')}} :</span>
                                    <strong dir="ltr">{{$shipping_address->phone}}</strong>
                                </div>

                                <div class="select_box">
                                    <span>{{ \App\CPU\Helpers::translate('Country')}} :</span>
                                    <strong>
                                        <select name="country" disabled id="" data-live-search="true" required>
                                            <option></option>
                                            @foreach (\App\CPU\Helpers::getCountries() as $country)
                                            <option @if($country->code == $shipping_address->country) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                    {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </strong>
                                </div>

                                <div>
                                    <span>{{ \App\CPU\Helpers::translate('Governorate')}} :</span>
                                    <strong class="select_box">
                                        <select style="background-color: white;border:0;color:black;font-weight: bold" disabled name="area_id" id="area_id" data-live-search="true" required>
                                        </select>
                                        <span class="text-warning" id="area_id_loading" style="display: none;">
                                            {{ Helpers::translate('Please wait') }}
                                        </span>
                                        <input type="hidden" id="area_id_hidden" value="{{$shipping_address->area_id ?? '0'}}">
                                    </strong>
                                </div>

                                <div class="d-flex align-items-start gap-2">
                                    <span>{{ \App\CPU\Helpers::translate('Street - neighborhood')}} :</span>
                                    {{$shipping_address->address}}
                                </div>

                                <div>
                                    <span>
                                        {{\App\CPU\Helpers::translate('zip_code')}} :
                                    </span>
                                    <strong>
                                        {{$shipping_address->zip}}
                                    </strong>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="media align-items-center">
                                <span>{{\App\CPU\Helpers::translate('no_shipping_address_found')}}</span>
                            </div>
                        </div>
                    @endif
                    <!-- End Body -->
                </div>
                @endif
                <!-- End Card -->


                <!-- Card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4 d-flex gap-2">
                            <img src="{{asset('/public/assets/back-end/img/shop-information.png')}}" alt="">
                            {{\App\CPU\Helpers::translate('Shop_Information')}}
                        </h4>


                        <div class="media flex-wrap gap-3">
                            @if($order->seller_is == 'admin')
                                <div class="">
                                    <img class="avatar avatar rounded-circle avatar-70 avatar-70" onerror="this.src='https://6valley.6amtech.com/public/assets/front-end/img/image-place-holder.png'"
                                         src="{{asset("storage/app/public/company/$company_web_logo")}}" alt="">
                                </div>

                                <div class="media-body d-flex flex-column gap-2">
                                    <h5>{{ $company_name }}</h5>
                                </div>
                            @else
                                @if($order->customer && $order->ext_order_id && isset($order->external_order->user))
                                    @if(!empty($seller->shop))
                                        <div class="">
                                            <img class="avatar avatar rounded-circle avatar-70 avatar-70" onerror="this.src='https://6valley.6amtech.com/public/assets/front-end/img/image-place-holder.png'"
                                                src="{{asset('storage/app/public/shop')}}/{{$seller->shop->image}}" alt="">
                                        </div>
                                        <div class="media-body d-flex flex-column gap-2">
                                            <h5>{{ $seller->shop->name }}</h5>
                                            <span class="title-color"> <strong>{{ $seller->shop->contact }}</strong></span>
                                            <div class="d-flex align-items-start gap-2">
                                                <img src="{{asset('/public/assets/back-end/img/location.png')}}" class="mt-1" alt="">
                                                {{ $seller->shop->address }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="">
                                            <img class="avatar avatar rounded-circle avatar-70 avatar-70" onerror="this.src='https://6valley.6amtech.com/public/assets/front-end/img/image-place-holder.png'"
                                                src="{{asset("storage/app/public/company/$company_web_logo")}}" alt="">
                                        </div>

                                        <div class="media-body d-flex flex-column gap-2">
                                            <h5>{{ $company_name }}</h5>
                                        </div>
                                    @endif
                                @else
                                    @if(!empty($order->seller->shop))
                                        <div class="">
                                            <img class="avatar avatar rounded-circle avatar-70 avatar-70" onerror="this.src='https://6valley.6amtech.com/public/assets/front-end/img/image-place-holder.png'"
                                                src="{{asset('storage/app/public/shop')}}/{{$order->seller->shop->image}}" alt="">
                                        </div>
                                        <div class="media-body d-flex flex-column gap-2">
                                            <h5>{{ $order->seller->shop->name }}</h5>
                                            <span class="title-color"> <strong>{{ $order->seller->shop->contact }}</strong></span>
                                            <div class="d-flex align-items-start gap-2">
                                                <img src="{{asset('/public/assets/back-end/img/location.png')}}" class="mt-1" alt="">
                                                {{ $order->seller->shop->address }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-body">
                                            <div class="media align-items-center">
                                                <span>{{\App\CPU\Helpers::translate('no_data_found')}}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            {{ Helpers::translate('order history') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> {{ Helpers::translate('edited by') }} </th>
                                    <th> {{ Helpers::translate('event date & time') }} </th>
                                    <th> {{ Helpers::translate('order status') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history ?? [] as $action)
                                <tr>
                                    <td>
                                        @switch($action['user_type'])
                                            @case("admin")
                                                {{ \App\Model\Admin::find($action['user_id'])->name ?? '' }}
                                            @break

                                            @case("customer")
                                                {{ \App\User::find($action['user_id'])->name ?? '' }}
                                            @break

                                            @case("seller")
                                                {{ \App\Model\Seller::find($action['user_id'])->name ?? '' }}
                                            @break

                                            @default
                                                {{ $action['cause'] ?? "SideUp" }}

                                        @endswitch
                                    </td>
                                    <td> {{ \Carbon\Carbon::parse($action['updated_at'] ?? $action['created_at'])->format('H:i   Y/m/d') }} </td>
                                    <td> {{ Helpers::translate($action['status']) }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--Show locations on map Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="locationModalLabel">{{\App\CPU\Helpers::translate('location data')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 modal_body_map">
                            <div class="location-map" id="location-map">
                                <div style="width: 100%; height: 400px;" id="location_map_canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Show delivery info Modal -->
    <div class="modal" id="shipping_chose" role="dialog" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('update_third_party_delivery_info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{route('admin.orders.update-deliver-info')}}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order['id']}}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">{{\App\CPU\Helpers::translate('delivery_service_name')}}</label>
                                        <input class="form-control" type="text" name="delivery_service_name" value="{{$order['delivery_service_name']}}" id="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{\App\CPU\Helpers::translate('tracking_id')}} ({{\App\CPU\Helpers::translate('optional')}})</label>
                                        <input class="form-control" type="text" name="third_party_delivery_tracking_id" value="{{$order['third_party_delivery_tracking_id']}}" id="">
                                    </div>
                                    <button class="btn btn--primary btn-primary" type="submit">{{\App\CPU\Helpers::translate('update')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@push('script_2')
    <script>

        $('#area_id').attr('disabled',1);$('#area_id_loading').show();$.get('{{route('get-shipping-areas')}}?code={{$shipping_address->country ?? ''}}').then(d=>{$('#area_id').html(d);$('#area_id').removeAttr('disabled');$('#area_id_loading').hide();$('#area_id').find('option[value='+$('#area_id_hidden').val()+']').attr("selected","selected");})

        $(document).on('change', '.payment_status', function () {
            var id = $(this).attr("data-id");
            var value = $(this).val();
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure Change this')}}?',
                text: "{{\App\CPU\Helpers::translate('You will not be able to revert this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, Change it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.orders.payment-status')}}",
                        method: 'POST',
                        data: {
                            "id": id,
                            "payment_status": value
                        },
                        success: function (data) {
                            if(data.customer_status==0)
                            {
                                toastr.warning('{{\App\CPU\Helpers::translate('Account has been deleted, you can not change the status!')}}!');
                                // location.reload();
                            }else
                            {
                                toastr.success('{{\App\CPU\Helpers::translate('Status Change successfully')}}');
                                // location.reload();
                            }
                        }
                    });
                }
            })
        });

        function order_status(status) {
            @if($order['order_status']=='delivered')
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Order is already delivered, and transaction amount has been disbursed, changing status can be the reason of miscalculation')}}!',
                text: "{{\App\CPU\Helpers::translate('Think before you proceed')}}.",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, Change it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.orders.status')}}",
                        method: 'POST',
                        data: {
                            "id": '{{$order['id']}}',
                            "order_status": status
                        },
                        success: function (data) {

                            if (data.success == 0) {
                                toastr.success('{{\App\CPU\Helpers::translate('Order is already delivered, You can not change it')}} !!');
                                // location.reload();
                            } else {

                                if(data.payment_status == 0){
                                    toastr.warning('{{\App\CPU\Helpers::translate('Before delivered you need to make payment status paid!')}}!');
                                    // location.reload();
                                }else if(data.customer_status==0)
                                {
                                    toastr.warning('{{\App\CPU\Helpers::translate('Account has been deleted, you can not change the status!')}}!');
                                    // location.reload();
                                }
                                else{
                                    toastr.success('{{\App\CPU\Helpers::translate('Status Change successfully')}}!');
                                    // location.reload();
                                }
                            }

                        }
                    });
                }
            })
            @else
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure Change this')}}?',
                text: "{{\App\CPU\Helpers::translate('You will not be able to revert this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, Change it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.orders.status')}}",
                        method: 'POST',
                        data: {
                            "id": '{{$order['id']}}',
                            "order_status": status
                        },
                        success: function (data) {
                            if (data.success == 0) {
                                toastr.success('{{\App\CPU\Helpers::translate('Order is already delivered, You can not change it')}} !!');
                                // location.reload();
                            } else {
                                if(data.payment_status == 0){
                                    toastr.warning('{{\App\CPU\Helpers::translate('Before delivered you need to make payment status paid!')}}!');
                                    // location.reload();
                                }else if(data.customer_status==0)
                                {
                                    toastr.warning('{{\App\CPU\Helpers::translate('Account has been deleted, you can not change the status!')}}!');
                                    // location.reload();
                                }else{
                                    toastr.success('{{\App\CPU\Helpers::translate('Status Change successfully')}}!');
                                    // location.reload();
                                }
                            }

                        }
                    });
                }
            })
            @endif
        }
    </script>
    <script>
        $( document ).ready(function() {
            let delivery_type = '{{$order->delivery_type}}';


            if(delivery_type === 'self_delivery'){
                $('.choose_delivery_man').show();
                $('#by_third_party_delivery_service_info').hide();
            }else if(delivery_type === 'third_party_delivery')
            {
                $('.choose_delivery_man').hide();
                $('#by_third_party_delivery_service_info').show();
            }else{
                $('.choose_delivery_man').hide();
                $('#by_third_party_delivery_service_info').hide();
            }
        });
    </script>
    <script>
        function choose_delivery_type(val)
        {

            if(val==='self_delivery')
            {
                $('.choose_delivery_man').show();
                $('#by_third_party_delivery_service_info').hide();
            }else if(val==='third_party_delivery'){
                $('.choose_delivery_man').hide();
                $('#deliveryman_charge').val(null);
                $('#expected_delivery_date').val(null);
                $('#by_third_party_delivery_service_info').show();
                $('#shipping_chose').modal("show");
            }else{
                $('.choose_delivery_man').hide();
                $('#by_third_party_delivery_service_info').hide();
            }

        }
    </script>
    <script>
        function addDeliveryMan(id) {
            $.ajax({
                type: "GET",
                url: '{{url('/')}}/admin/orders/add-delivery-man/{{$order['id']}}/' + id,
                data: {
                    'order_id': '{{$order['id']}}',
                    'delivery_man_id': id
                },
                success: function (data) {
                    if (data.status == true) {
                        toastr.success('Delivery man successfully assigned/changed', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        toastr.error('Deliveryman man can not assign/change in that status', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                error: function () {
                    toastr.error('Add valid data', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }

        function last_location_view() {
            toastr.warning('Only available when order is out for delivery!', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function waiting_for_location() {
            toastr.warning('{{\App\CPU\Helpers::translate('waiting_for_location')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        function amountDateUpdate(t, e){
            let field_name = $(t).attr('name');
            let field_val = $(t).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.orders.amount-date-update')}}",
                method: 'POST',
                data: {
                    'order_id': '{{$order['id']}}',
                    'field_name': field_name,
                    'field_val': field_val
                },
                success: function (data) {
                    if (data.status == true) {
                        toastr.success('Deliveryman charge add successfully', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        toastr.error('Failed to add deliveryman charge', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                error: function () {
                    toastr.error('Add valid data', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&v=3.49"></script>
    <script>

        function initializegLocationMap() {
            var map = null;
            var myLatlng = new google.maps.LatLng({{$shipping_address->latitude ?? null}}, {{$shipping_address->longitude ?? null}});
            var dmbounds = new google.maps.LatLngBounds(null);
            var locationbounds = new google.maps.LatLngBounds(null);
            var dmMarkers = [];
            dmbounds.extend(myLatlng);
            locationbounds.extend(myLatlng);

            var myOptions = {
                center: myLatlng,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,

                panControl: true,
                mapTypeControl: false,
                panControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                scaleControl: false,
                streetViewControl: false,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                }
            };
            map = new google.maps.Map(document.getElementById("location_map_canvas"), myOptions);
            console.log(map);
            var infowindow = new google.maps.InfoWindow();

            @if($shipping_address && isset($shipping_address))
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({{$shipping_address->latitude}}, {{$shipping_address->longitude}}),
                map: map,
                title: "{{$order->customer['f_name']??""}} {{$order->customer['l_name']??""}}",
                icon: "{{asset('public/assets/front-end/img/customer_location.png')}}"
            });

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/profile/')}}{{$order->customer->image??""}}'></div><div style='float:right; padding: 10px;'><b>{{$order->customer->f_name??""}} {{$order->customer->l_name??""}}</b><br/>{{$shipping_address->address??""}}</div>");
                    infowindow.open(map, marker);
                }
            })(marker));
            locationbounds.extend(marker.getPosition());
            @endif

            google.maps.event.addListenerOnce(map, 'idle', function () {
                map.fitBounds(locationbounds);
            });
        }

        // Re-init map before show modal
        $('#locationModal').on('shown.bs.modal', function (event) {
            initializegLocationMap();
        });
    </script>
@endpush
