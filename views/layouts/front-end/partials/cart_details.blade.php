

<!-- Grid-->
<hr class="view_border sm:block hidden">
@php($shippingMethod=\App\CPU\Helpers::get_business_settings('shipping_method'))
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@php($cart=\App\Model\Cart::where(['customer_id' =>$storeId])->whereNull('offer')->whereHas('product')->get()->groupBy('cart_group_id'))
<div class="row">
    <!-- List of items-->
    <section class="col-lg-8 border rounded-11" style="border-radius: 12px">
        <div class="feature_header row mb-2 bg-light p-3">
            <div class="col-md-8 col-lg-8 col-auto text-start mt-2">
                @php($crt=\App\CPU\CartManager::get_cart())
                <span>{{$crt->count()}} {{ \App\CPU\Helpers::translate('products_')}}</span>
            </div>
            <div class="col-md-4 col-md-4 col-auto text-end p-0">
                <button class="btn btn-white rounded-11" onclick="form_alert('delete-cart','Want to delete this item ?')">
                    <i class="me-2 ri-delete-bin-5-fill text-danger"></i>
                    {{ Helpers::translate('delete cart') }}
                </button>
            </div>
            <form action="{{route('cart.remove-all')}}" id="delete-cart" method="POST">
                @csrf
            </form>
        </div>

        @foreach($cart as $group_key=>$group)
            <div class="cart_information mb-3">
                @foreach($group as $cart_key=>$cartItem)
                    @if ($shippingMethod=='inhouse_shipping')
                            <?php

                            $admin_shipping = \App\Model\ShippingType::where('seller_id', 0)->first();
                            $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';

                            ?>
                    @else
                            <?php
                            if ($cartItem->seller_is == 'admin') {
                                $admin_shipping = \App\Model\ShippingType::where('seller_id', 0)->first();
                                $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                            } else {
                                $seller_shipping = \App\Model\ShippingType::where('seller_id', $cartItem->seller_id)->first();
                                $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                            }
                            ?>
                    @endif

                    @if($cart_key==0)
                        @if($cartItem->seller_is=='admin')
                            <b>
                                <span>{{ \App\CPU\Helpers::translate('shop_name')}} : </span>
                                <a href="{{route('shopView',['id'=>0])}}">{{\App\CPU\Helpers::get_business_settings('company_name')}}</a>
                            </b>
                        @else
                            @php($show_sellers_section = \App\Model\BusinessSetting::where('type','show_sellers_section')->first()->value ?? '')
                            @if($show_sellers_section)
                                <b>
                                    <span>{{ \App\CPU\Helpers::translate('shop_name')}}:</span>
                                    <a href="{{route('shopView',['id'=>$cartItem->seller_id])}}">
                                        {{\App\Model\Shop::where(['seller_id'=>$cartItem['seller_id']])->first()->name}}
                                    </a>
                                </b>
                            @endif
                        @endif
                    @endif
                @endforeach
                <div class="">
                    <table
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        style="width: 100%">
                            <?php
                                $physical_product = false;
                                foreach ($group as $row) {
                                    if ($row->product_type == 'physical') {
                                        $physical_product = true;
                                    }
                                }
                            ?>
                            @php($current_lang = session()->get('local'))
                        @foreach($group as $cart_key=>$cartItem)
                            @if($cartItem['slug'] !== null)
                            @php($product = \App\Model\Product::find($cartItem['product_id']))
                            <div class="sm:m-3 m-1 py-3 sm:flex">
                                <h2 class="col-lg-1 col-md-1 col-12 fw-bolder sm:pt-8">{{$cart_key+1}}</h2>
                                <div class="border rounded-11 row w-full">
                                    <div class="col-lg-9 col-md-9 col-7 ps-0 sm:me-2 pe-0">
                                        <div class="d-flex">
                                            <div class="min-w-[90px] w-[90px]">
                                                <a href="{{route('product',$cartItem['slug'])}}" class="bg-light d-block me-2">
                                                    <img style="height: auto"
                                                        class="w-full sm:hidden"
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                                                        alt="Product">
                                                    <img style="height: auto;width: 129px"
                                                        class="hidden sm:block"
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                                                        alt="Product">
                                                </a>
                                            </div>
                                            <div class="text-break pt-2 sm:w-8/12">

                                                <a class="text-md" href="{{route('product',$cartItem['slug'])}}">{{$cartItem['name']}}</a><br/>
                                                <span class="text-md">{{ Helpers::translate('product_code') }} : {{ $product->code }}</span><br/>
                                                <span class="text-md">{{ Helpers::translate('Item Number') }} : {{ $product->item_number }}</span>

                                                <div>
                                                    <div class="p-0">
                                                        @php($max_order_qty = Helpers::getProductPrice_pl($product['id'])['max_qty'] ??
                                                        $product['current_stock'])
                                                        @php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty']
                                                        ?? 1)
                                                        <div
                                                            class="mt-2 product-quantity d-flex justify-content-between align-items-center rounded-bottom-11 bg-white">
                                                            <div class="d-flex justify-content-center align-items-center border px-0 py-2 rounded-top-11 rounded-bottom-11 mb-3"
                                                                style="width: 110px;color: {{$web_config['primary_color']}}">
                                                                <span class="input-group-btn" style="">
                                                                    <button class="btn btn-number btn-minus bg-black w-5 h-5 rounded-md" type="button" data-field="quantity[{{ $cartItem['id'] }}]" data-type="minus"
                                                                        data-bs-type="minus" data-bs-field="quantity[{{ $cartItem['id'] }}]"
                                                                        mn-field="{{$minimum_order_qty}}" mx-field="{{$max_order_qty}}"
                                                                        @if($cartItem['quantity'] == 1)
                                                                        disabled="disabled"
                                                                        @endif
                                                                        style="padding: 10px;color: {{$web_config['primary_color']}}">
                                                                        <strong style="color: white;font-size: 24px" class="mb-0.5 me-[0.5px]">
                                                                            -
                                                                        </strong>
                                                                    </button>
                                                                </span>

                                                                <input style="padding: 0px !important;width: 40%;height: 35px;border:0px;font-size: 24px;font-weight: bold" type="text" pattern="\d*" t="number" name="quantity[{{ $cartItem['id'] }}]" class="form-control input-number text-center cart-qty-field"
                                                                id="cartQuantity{{$cartItem['id']}}"
                                                                onchange="updateCartQuantity('{{ $minimum_order_qty }}', '{{$cartItem['id']}}', '{{ $max_order_qty }}')"
                                                                min="{{ $minimum_order_qty ?? 1 }}" max="{{ $max_order_qty ?? 100 }}" value="{{$cartItem['quantity']}}">

                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-number btn-minus bg-black w-5 h-5 rounded-md" type="button" data-field="quantity[{{ $cartItem['id'] }}]" data-type="plus"
                                                                        product-type="{{ $product->product_type }}" data-bs-type="plus"
                                                                        data-bs-field="quantity[{{ $cartItem['id'] }}]" mn-field="{{$minimum_order_qty}}"
                                                                        mx-field="{{$max_order_qty}}"
                                                                        style="padding: 10px;color: {{$web_config['primary_color']}}">
                                                                        <strong style="color: white;font-size: 24px" class="mb-0.5 me-[-1px]">
                                                                            +
                                                                        </strong>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex">

                                            @foreach(json_decode($cartItem['variations'],true) ?? [] as $key1 =>$variation)
                                                <div class="text-muted mr-2">
                                                    <span class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"
                                                        style="font-size: 12px;">
                                                        {{$key1}} : {{$variation}}</span>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{--    --}}
                                    @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                    @if($productdiscount == 0 || $productdiscount == "")
                                    @php($productdiscount = $cartItem->discount ?? 0)
                                    @endif
                                    <div class="sm:ps-3 col-lg-2 col-md-2 col-5 mt-3 text-end">
                                        @isset($deal_of_the_day->product)
                                        @if($deal_of_the_day->product->discount > 0)
                                            <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                {{\App\CPU\Helpers::currency_converter(Helpers::getProductPrice_pl($product['id'])['value'])}}
                                            </strike>
                                        @endif
                                        <span class="text-accent text-success" style="font-size: 22px !important;">
                                            {{\App\CPU\Helpers::currency_converter(
                                                Helpers::getProductPrice_pl($product['id'])['value']-(Helpers::getProductPrice_pl($product['id'])['discount_price'])
                                            )}}
                                        </span>
                                        @else
                                        <span class="text-accent text-success" style="font-size: 19px !important;text-wrap: nowrap;">
                                            {{\App\CPU\Helpers::currency_converter(
                                                Helpers::getProductPrice_pl($product['id'])['value']-($productdiscount)
                                            )}}
                                        </span>
                                        @endisset

                                        <div>
                                            @if($productdiscount > 0)
                                                <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                    {{\App\CPU\Helpers::currency_converter(Helpers::getProductPrice_pl($product['id'])['value'])}}
                                                </strike>
                                                <span style="font-size: 12px!important;" class="text-success mx-2">
                                                    @if($productdiscount > 0)
                                                        @php($productdiscount_type = Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
                                                        @if ($productdiscount_type == 'percent')
                                                        {{round($productdiscount)}}%
                                                        @elseif($productdiscount_type =='flat')
                                                            {{\App\CPU\Helpers::currency_converter($productdiscount)}}
                                                        @endif {{\App\CPU\Helpers::translate('off_')}}
                                                    @endif
                                                </span>
                                            @endif
                                        </div>

                                        <button class="btn btn-white py-2 text-danger px-2 mt-3"
                                                onclick="removeFromCart({{ $cartItem['id'] }})" type="button">
                                                <i class="ri-delete-bin-5-fill text-danger {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}} mb-0"></i>
                                                <span class="text-black">
                                                    {{ Helpers::translate('Delete product') }}
                                                </span>
                                        </button>
                                    </div>
                                    {{--    --}}


                                    <div class="">
                                        <div class="row">

                                            <div class="col-6 pb-2 fw-bolder">
                                                {{ Helpers::translate('shipping cost') }}
                                                <br/>
                                                <br/>
                                                {{ Helpers::translate('Total Price') }}
                                            </div>
                                            <div class="relative col-md-2 col-lg-2 col-6 pb-2 text-success fw-bolder" style="text-align-last: end">
                                                <p class="absolute text-start {{ ((session('dir') ?? 'rtl') == 'rtl') ? 'left-2' : 'right-2' }}" style="text-align-last: start">
                                                    {{ \App\CPU\Helpers::currency_converter($cartItem['shipping_cost']) }}
                                                    <br/>
                                                    <br/>
                                                    {{ \App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity']) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @if($physical_product && $shippingMethod=='sellerwise_shipping' && $shipping_type == 'order_wise')
                                    @php($choosen_shipping=\App\Model\CartShipping::where(['cart_group_id'=>$cartItem['cart_group_id']])->first())

                                    @if(isset($choosen_shipping)==false)
                                        @php($choosen_shipping['shipping_method_id']=0)
                                    @endif

                                    @php($shippings=\App\CPU\Helpers::get_shipping_methods($cartItem['seller_id'],$cartItem['seller_is']))
                                    <tr>
                                        <td colspan="4">

                                            @if($cart_key==$group->count()-1)

                                                <!-- choosen shipping method-->

                                                <div class="row">

                                                    <div class="col-12">
                                                        <select class="form-control"
                                                                onchange="set_shipping_id(this.value,'{{$cartItem['cart_group_id']}}')">
                                                            <option>{{\App\CPU\Helpers::translate('choose_shipping_method')}}</option>
                                                            @foreach($shippings as $shipping)
                                                                <option
                                                                    value="{{$shipping['id']}}" {{$choosen_shipping['shipping_method_id']==$shipping['id']?'selected':''}}>
                                                                    {{$shipping['title'].' ( '.$shipping['duration'].' ) '.\App\CPU\Helpers::currency_converter($shipping['cost'])}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            @endif
                                        </td>
                                        <td colspan="3">
                                            @if($cart_key==$group->count()-1)
                                                <div class="row">
                                                    <div class="col-12">
                                                            <span>
                                                                <b>{{\App\CPU\Helpers::translate('shipping_cost')}} : </b>
                                                            </span>
                                                        {{\App\CPU\Helpers::currency_converter($choosen_shipping['shipping_method_id']!= 0?$choosen_shipping->shipping_cost:0)}}
                                                    </div>
                                                </div>
                                            @endif
                                        </td>

                                    </tr>
                            @endif
                            </div>
                            @endif
                                    @endforeach
                                    </table>
                                    <div class="mt-3"></div></div>
                </div>
                @endforeach

@if($shippingMethod=='inhouse_shipping')
        <?php
        $admin_shipping = \App\Model\ShippingType::where('seller_id', 0)->first();
        $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
        ?>
    @if ($shipping_type == 'order_wise' && isset($cartItem))
        @php($shippings=\App\CPU\Helpers::get_shipping_methods(1,'admin'))
        @php($choosen_shipping=\App\Model\CartShipping::where(['cart_group_id'=>$cartItem['cart_group_id']])->first())

        @if(isset($choosen_shipping)==false)
            @php($choosen_shipping['shipping_method_id']=0)
        @endif
        <div class="row">
            <div class="col-12">
                <select class="form-control" onchange="set_shipping_id(this.value,'all_cart_group')">
                    <option>{{\App\CPU\Helpers::translate('choose_shipping_method')}}</option>
                    @foreach($shippings as $shipping)
                        <option
                            value="{{$shipping['id']}}" {{$choosen_shipping['shipping_method_id']==$shipping['id']?'selected':''}}>
                            {{$shipping['title'].' ( '.$shipping['duration'].' ) '.\App\CPU\Helpers::currency_converter($shipping['cost'])}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
@endif

@if( $cart->count() == 0)
    <div class="d-flex justify-content-center align-items-center">
        <h4 class="text-danger text-capitalize">{{\App\CPU\Helpers::translate('cart_empty')}}</h4>
    </div>
@endif


<form method="get">
    <div class="form-group">
        <div class="row">
            <div class="col-12">
                <label for="phoneLabel" class="form-label input-label">{{\App\CPU\Helpers::translate('order_note')}} <span
                        class="input-label-secondary">({{\App\CPU\Helpers::translate('Optional')}})</span></label>
                <textarea class="form-control" id="order_note" name="order_note"
                          style="width:100%;">{{ session('order_note')}}</textarea>
            </div>
        </div>
    </div>
</form>


<div class="row pt-2 pb-2">
    <div class="col-6">
        <a href="{{route('products',['data_from' => 'latest'])}}" class="btn bg-primaryColor text-light">
            <i class="fa fa-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'forward' : 'backward'}} px-1"></i> {{\App\CPU\Helpers::translate('continue_shopping')}}
        </a>
    </div>

</div>
</section>
<!-- Sidebar-->
@include('web-views.partials._order-summary')
</div>


<script>
    cartQuantityInitialize();

    function set_shipping_id(id, cart_group_id) {
        $.get({
            url: '{{url('/')}}/customer/set-shipping-method',
            dataType: 'json',
            data: {
                id: id,
                cart_group_id: cart_group_id
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                location.reload();
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }
</script>
<script>
    function checkout() {
        let order_note = $('#order_note').val();
        //console.log(order_note);
        $.post({
            url: "{{route('order_note')}}",
            data: {
                _token: '{{csrf_token()}}',
                order_note: order_note,

            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                let url = "{{ route('checkout-details') }}";
                location.href = url;

            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

</script>
