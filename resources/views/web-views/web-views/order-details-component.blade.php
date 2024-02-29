@php($subtotal=0)
@php($total=0)
@php($total_without_tax=0)
@php($total_qty=0)
@php($shipping=0)
@php($discount=0)
@php($tax=0)
@php($row=0)
@php($products_tax=0)
@php($order_totals = Helpers::get_order_totals($order))
@isset($small_table)
<table class="table table-bordered mt-3 text-left bg-white" style="width: 100%!important">
    <thead class="bg-light">
    <tr>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('The item')}}</th>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('QTY')}}</th>
        <th class="border border-dark text-center">ك.م</th>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Price')}}</th>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Total')}}</th>
    </tr>
    </thead>

    <tbody>
    @php($sub_total=0)
    @php($total_tax=0)
    @php($total_dis_on_pro=0)
    @php($product_price=0)
    @php($total_product_price=0)
    @php($ext_discount=0)
    @php($coupon_discount=0)
    @php($local = session()->get('local'))

    @php($subtotal=0)
    @php($total=0)
    @php($total_without_tax=0)
    @php($qty_total=0)
    @php($shipping=0)
    @php($discount=0)
    @php($tax=0)
    @php($row=0)
    @php($products_tax=0)
    @foreach($order->details as $key=>$detail)
        @if($detail->product)
            <tr>
                <td class="text-center">{{ $detail->product['id'] }}</td>

                <td class="text-center" style="width: 80px">
                    @php($total_qty += $detail['qty'])
                    {{$detail['qty']}}
                </td>
                <td class="text-center"></td>

                <td class="text-center">
                    @php($amount=($detail['price']*$detail['qty'])-($detail['discount'] / $detail->qty))
                    @php($product_price = $detail['price']*$detail['qty'])
                    {{ $product_price }}
                </td>


                <td class="text-center">
                    {{$product_price + $total_tax}}
                </td>
            </tr>
            <tr style="border-bottom: black thin solid !important">
                <td colspan="4">
                    <div class="text-start justify-content-start">
                        {{ $detail->product['code'] }}

                        {{--  {!! DNS1D::getBarcodeHTML($detail->product['code'], 'CODABAR') !!}  --}}
                    </div>
                    <div class="text-start">
                        {{ \App\CPU\Helpers::getItemName('products','name',$detail->product['id'] )}}
                    </div>
                </td>
                <td>
                    <div class="text-start">
                        <img class="rounded productImg" width="64"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($detail->product['images'])->$local)) ? json_decode($detail->product['images'])->$local[0] ?? '' : ''}}">
                    </div>
                </td>
            </tr>
            @php($sub_total+=$amount)
        @endif
    @endforeach
    </tbody>
</table>

@else
<table class="hidden sm:table table fz-12 table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-full">
    <thead class="thead-light thead-50 text-capitalize">
    <tr>
        <th>{{\App\CPU\Helpers::translate('SL')}}</th>
        <th>{{\App\CPU\Helpers::translate('Item Details')}}</th>
        <th>{{\App\CPU\Helpers::translate('Qty')}}</th>
        <th>{{\App\CPU\Helpers::translate('free quantity')}}</th>
        <th>{{\App\CPU\Helpers::translate('Unit price')}}</th>
        <th>{{\App\CPU\Helpers::translate('Discount (percent)')}}</th>
        <th>{{\App\CPU\Helpers::translate('Discount (amount)')}}</th>
        <th>{{\App\CPU\Helpers::translate('Tax (%)')}}</th>
        <th>{{\App\CPU\Helpers::translate('Tax (amount)')}}</th>
        <th>{{\App\CPU\Helpers::translate('Total')}}</th>
        @isset($admin)
        @else
        @if ((auth('customer')->check() || auth('delegatestore')->check()) && $order['order_status'] == 'delivered' && (!isset($colf) && !isset($small_table)))
        <th>{{\App\CPU\Helpers::translate('Actions')}}</th>
        @endif
        @endisset
    </tr>
    </thead>

    <tbody>

    @php($seller = (isset($order->details[0]->seller) ? $order->details[0]->seller : null))
    @foreach($order->details as $key=>$detail)
        @if($detail->product || $detail->product_details)
        @php($product = $detail->product ?? json_decode($detail->product_details))
            <tr>
                <td>{{ ++$row }}</td>
                <td class="p-details">
                    <div class="media align-items-center gap-10">
                        @php($current_lang = session()->get('local'))
                        <img class="avatar avatar-60 rounded"
                             onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                             src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product->images)->$current_lang)) ? json_decode($product->images)->$current_lang[0] ?? '' : ''}}"
                             alt="Image Description">
                        <div>
                            @php($product_name = \App\CPU\Helpers::get_prop('App\Model\Product',$product->id,'name') ?? $product->name)
                            <a style="text-wrap: wrap;" href="{{ isset($admin) ? route('admin.product.edit', [$product->id]) : route('product',['slug'=>$product->slug]) }}" title="{{$product_name}}">
                                <h6 class="title-color">
                                    {{ $product_name }}
                                </h6>
                            </a>
                            <div><strong>{{\App\CPU\Helpers::translate('Item Number')}} :</strong> {{$product->item_number ?? null}}</div>
                            <div class="d-flex">
                                <div><strong>{{\App\CPU\Helpers::translate('product_code_sku')}} : </strong></div>
                                <div>
                                    {{$product->code}}
                                </div>
                            </div>
                            @isset($admin)
                            @else
                            @if($order->order_status == 'delivered' && (!isset($colf) && !isset($small_table) && $order->payment_status == 'paid'))
                            @if (\App\CPU\Helpers::store_module_permission_check('order.details.review'))
                            <a role="button" class="btn btn-secondary mt-1" href="{{ route('submit-review', ['id' => $detail->id]) }}?order_id={{ $order->id }}">
                                {{ Helpers::translate('review') }}
                                <i class="fa fa-star mx-1"></i>
                            </a>
                            @endif
                            @endif
                            @endisset
                        </div>
                    </div>
                    @if(($product->digital_product_type ?? null) == 'ready_after_sell')
                        <button type="button" class="btn btn-sm bg-primaryColor mt-2" title="File Upload" data-toggle="modal" data-target="#fileUploadModal-{{ $detail->id }}" onclick="modalFocus('fileUploadModal-{{ $detail->id }}')">
                            <i class="tio-file-outlined"></i> {{\App\CPU\Helpers::translate('File')}}
                        </button>
                    @endif
                    @isset($colf)
                        {{--  {!! DNS1D::getBarcodeHTML($product->code, 'CODABAR') !!}  --}}
                    @endisset
                </td>
                <td>
                    {{$detail->qty}}
                </td>
                <td>
                    0
                </td>
                <td>
                    {{Helpers::currency_converter(($detail['price']))}}
                </td>
                <td>{{ ($detail['discount'] >= 1) ? number_format((($detail['discount'] / $detail->qty) * 100) / $detail['price'], 2) : $detail['price'] }}%</td>
                <td>{{ $detail['discount'] ? $detail['discount'] / $detail->qty : 0 }}</td>
                <td>
                    {{ (json_decode($detail->product_details)->tax ?? null) . '%' }}
                </td>
                @php($amount = ($detail['price'] - $order['discount_amount'] - (($detail['discount']) ? (($detail['discount'] / $detail->qty)*$detail->qty) : 0)))
                @php($tax = ((json_decode($detail->product_details)->tax ?? 1)/100) * $amount)
                <td>{{Helpers::currency_converter($tax)}}</td>
                @if($order->external_order)
                @php($subtotal=$detail['price']*$detail->qty + ($tax))
                @else
                @php($subtotal=$amount + ($tax))
                @endif
                <td>{{Helpers::currency_converter(($subtotal))}}</td>
                @isset($admin)
                @else
                @if ((auth('customer')->check() || auth('delegatestore')->check()) && $order['order_status'] == 'delivered' && (!isset($colf) && !isset($small_table)))
                @if(Helpers::refundCheck($detail['product_id']))
                <td>
                    @if (\App\CPU\Helpers::store_module_permission_check('order.details.refund_details'))
                    <a class="btn btn-primary"
                        href="{{ route('refund-details',['id'=>$detail['id']]) }}"
                        >
                        {{\App\CPU\Helpers::translate('Refund Details')}}
                    </a>
                    @endif
                </td>
                @else
                <td>
                    @if (\App\CPU\Helpers::store_module_permission_check('order.details.refund_request'))
                    <a class="btn btn-danger"
                        onclick="route_alert('{{ route('refund-request',['id'=>$detail['id']]) }}','{{ Helpers::translate('Are you sure') }}','order-cancel')"
                        href="javascript:"
                        >
                        {{\App\CPU\Helpers::translate('Refund request')}}
                    </a>
                    @endif
                </td>
                @endif
                @endif
                @endisset
            </tr>
            @php($discount+=$detail['discount'] ? $detail['discount'] / $detail->qty : 0)
            @php($products_tax+=$tax)
            @php($tax+=$detail['tax'] ?? ($d ? $d->data->items[$key]->amounts->tax->amount->amount : 0))
            @php($total+=$subtotal)
            @php($total_without_tax+=$detail['price'] * $detail['qty'])
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
                                    <button type="submit" class="btn bg-primaryColor btn-primary bg-primaryColor">{{\App\CPU\Helpers::translate('Upload')}}</button>
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

<table class="table sm:hidden table-bordered mt-3 text-left bg-white" style="width: 100%!important">
    <thead class="bg-light">
    <tr>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('The item')}}</th>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('QTY')}}</th>
        <th class="border border-dark text-center">ك.م</th>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Price')}}</th>
        <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Total')}}</th>
    </tr>
    </thead>

    <tbody>
    @php($sub_total=0)
    @php($total_tax=0)
    @php($total_dis_on_pro=0)
    @php($product_price=0)
    @php($total_product_price=0)
    @php($ext_discount=0)
    @php($coupon_discount=$order['discount_amount'])
    @php($local = session()->get('local'))

    @php($subtotal=0)
    @php($total=0)
    @php($qty_total=0)
    @php($shipping=0)
    @php($discount=0)
    @php($tax=0)
    @php($row=0)
    @foreach($order->details as $key=>$detail)
        @if($detail->product)
            <tr>
                <td class="text-center">{{ $detail->product['id'] }}</td>

                <td class="text-center" style="width: 80px">
                    @php($total_qty += $detail['qty'])
                    {{$detail['qty']}}
                </td>
                <td class="text-center"></td>

                <td class="text-center">
                    @php($amount=($detail['price']*$detail['qty'])-($detail['discount'] ? $detail['discount'] / $detail->qty : 0))
                    @php($product_price = $detail['price']*$detail['qty'])
                    {{ $product_price }}
                </td>


                <td class="text-center">
                    {{$product_price + $total_tax}}
                </td>
            </tr>
            <tr class="sm:hidden table-row" style="border-bottom: black thin solid !important">
                <td colspan="5">
                    <div class="text-center justify-content-start">

                        <img class="avatar avatar-60 rounded"
                        onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product->images)->$current_lang)) ? json_decode($product->images)->$current_lang[0] ?? '' : ''}}"
                        alt="Image Description">
                    </div>
                    {{ $detail->product['code'] }}
                    <div class="text-start">
                        {{ \App\CPU\Helpers::getItemName('products','name',$detail->product['id'] )}}
                    </div>
                </td>
            </tr>
            <tr class="sm:table-row hidden" style="border-bottom: black thin solid !important">
                <td colspan="4">
                    <div class="text-start justify-content-start">
                        {{ $detail->product['code'] }}

                        {{--  {!! DNS1D::getBarcodeHTML($detail->product['code'], 'CODABAR') !!}  --}}
                    </div>
                    <div class="text-start">
                        {{ \App\CPU\Helpers::getItemName('products','name',$detail->product['id'] )}}
                    </div>
                </td>
                <td>
                    <div class="text-start">
                        <img class="rounded productImg" width="64"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($detail->product['images'])->$local)) ? json_decode($detail->product['images'])->$local[0] ?? '' : ''}}">
                    </div>
                </td>
            </tr>
            @php($sub_total+=$amount)
        @endif
        @php($coupon_discount+= $detail->discount)
    @endforeach
    </tbody>
</table>
@endisset
@php($extra_discount=0)
<?php
if ($order['extra_discount_type'] == 'percent') {
    $extra_discount = ($summary['subtotal'] / 100) * $order['extra_discount'];
} else {
    $extra_discount = $order['extra_discount'];
}
?>

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
@if(App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id !== $order->id)
    @php($shipping=0)
@else
    @php($shipping=$order['shipping_cost'])
@endif
@php($total_amount=0)
<hr />
<div class="row justify-start sm:text-end sm:justify-end mb-3 mx-1">
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            <strong class="float-end">{{\App\CPU\Helpers::translate('quantity total')}} : {{ $total_qty }}</strong>
        </dd>
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color"><strong class="float-end">{{\App\CPU\Helpers::translate('The total does not include tax')}} : {{Helpers::currency_converter(($total_without_tax))}}</strong></dd>
        @php($total_amount += $total_without_tax)
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            <strong class="float-end">{{\App\CPU\Helpers::translate('free quantity total')}} : </strong>
        </dd>


        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            @if(App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id == $order->id || ($order->external_order && $order['shipping_tax']))
            <strong class="float-end">{{\App\CPU\Helpers::translate('Shipping')}} : {{ Helpers::currency_converter($order['shipping_cost']) }}</strong>
            @php($total_amount += $order['shipping_cost'])
            @endif
        </dd>

        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color"></dd>
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            <strong class="float-end">
                {{\App\CPU\Helpers::translate('product discount')}} : {{Helpers::currency_converter(($coupon_discount - $order['discount_amount']))}}
                @php($total_amount = $total_amount - $coupon_discount)
            </strong>
        </dd>

        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color"></dd>
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            <strong class="float-end">
                {{\App\CPU\Helpers::translate('cart discount')}} : {{Helpers::currency_converter(($order['discount_amount']))}}
            </strong>
        </dd>

        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color"></dd>
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            <strong class="float-end">
                @php($products_tax = Helpers::get_order_totals($order)['products_tax'])
                {{\App\CPU\Helpers::translate('products tax')}} : {{ \App\CPU\Helpers::currency_converter($products_tax) }}
                @php($total_amount += $products_tax)
            </strong>
        </dd>

        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color"></dd>
        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            @if(App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id == $order->id || ($order->external_order && $order['shipping_tax']))
            <strong class="float-end">
                @if(!is_float($order['shipping_tax']))
                {{\App\CPU\Helpers::translate('shipping tax')}} : {{ Helpers::currency_converter($order['shipping_cost'] * ($order['shipping_tax'] / 100)) }}
                @php($total_amount += $order['shipping_cost'] * ($order['shipping_tax'] / 100))
                @else
                {{\App\CPU\Helpers::translate('shipping tax')}} : {{ Helpers::currency_converter($order['shipping_tax']) }}
                @php($total_amount += $order['shipping_tax'])
                @endif
            </strong>
            @endif
        </dd>

        <dd class="@isset($colf) col-lg-4 @else col-lg-6 @endif @isset($small_table) m-0 @endisset col-12 title-color">
            @if($order->external_order)
            <strong class="float-end">{{\App\CPU\Helpers::translate('Total')}} : {{Helpers::currency_converter(($total_amount))}}</strong>
            @else
            <strong class="float-end">{{\App\CPU\Helpers::translate('Total')}} : {{Helpers::currency_converter(($total_amount))}}</strong>
            @endif
        </dd>
    </dl>
    <!-- End Row -->
