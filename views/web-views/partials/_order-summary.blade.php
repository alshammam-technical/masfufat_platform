<style>
    .cart_title {
        font-weight: bold !important;
        font-size: 19px;
    }

    .cart_value {
        font-weight: bold !important;
        font-size: 19px;
    }

    .cart_total_value {
        font-weight: bolder !important;
        color: black !important;
        font-size: 25px !important;
        color: {{$web_config['primary_color']}}     !important;
    }
</style>

<aside class="col-lg-4 pt-4 pt-lg-0">
    <div class="cart_total bg-light border-light rounded-11" style="line-height: 40px">
        <h4>
            {{ Helpers::translate('Bill') }}
        </h4>

        @if(session()->has('coupon_discount'))
            @php($coupon = \App\Model\Coupon::where('code',session('coupon_code'))->first())
        @endif

        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_shipping_cost=0)
        @php($total_discount_on_product=0)
        @php($admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first())
        @php($shippingType =isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise')
        @php($cart=\App\CPU\CartManager::get_cart())

        @php($shipping_cost=\App\CPU\CartManager::get_shipping_cost())
        @if($cart->count() > 0)
            @foreach($cart as $key => $cartItem)
                @php($product = \App\Model\Product::find($cartItem['product_id']))
                @php($coupon_discount = session()->has('coupon_discount')? (session('coupon_discount')) : 0)
                @php($sub_total+=($cartItem['price'])*$cartItem['quantity'])
                @if(Helpers::getProductPrice_pl($product->id)['discount_type'] == "percent")
                    @php($total_discount_on_product+=($cartItem['discount']*$cartItem['quantity']))
                @else
                    @php($total_discount_on_product=Helpers::getProductPrice_pl($product->id)['discount']*$cartItem['quantity'])
                @endif
                @php($d_price = $cartItem['price'] - $coupon_discount - $total_discount_on_product)
                @php($cartItemTax=$d_price*($product['tax']/100))
                @php($total_tax+=$cartItemTax*$cartItem['quantity'])
                @php($total_taxz=$total_tax)

                @isset($coupon)
                    @if($coupon->coupon_type == "free_delivery")
                        @php($free_delivery = 1)
                        {{\App\CPU\Helpers::currency_converter(0)}}
                    @else
                        @php($free_delivery = 0)
                        {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
                    @endif
                @else
                    @php($free_delivery = 0)
                @endisset





                @if($free_delivery==0)
                    @if($shippingType=='order_wise')
                        @php($total_shipping_cost = $choosen_shipping['shipping_cost'] ?? 0)

                        @isset($coupon)
                        @if($coupon->coupon_type !== "free_delivery")
                            @php($total_tax+=($choosen_shipping['shipping_cost'] ?? 0) * (($choosen_shipping['tax'] ?? 0)/100))
                        @endif
                        @else
                        @php($total_tax+=($choosen_shipping['shipping_cost'] ?? 0) * (($choosen_shipping['tax'] ?? 0)/100))
                        @endisset

                    @elseif($shippingType=='product_wise')
                        @if($product->multiply_qty)
                            @php($total_shipping_cost += $cartItem['shipping_cost']*$cartItem['quantity'])
                        @else
                            @php($total_shipping_cost += $cartItem['shipping_cost'])
                        @endif
                    @else
                        {{--    --}}
                    @endif
                @endif

            @endforeach
        @else
            <span>{{\App\CPU\Helpers::translate('empty_cart')}}</span>
        @endif
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('sub_total')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($sub_total)}}
            </span>
        </div>
        @if(session()->has('coupon_discount'))
            @php($coupon = \App\Model\Coupon::where('code',session('coupon_code'))->first())
            <div class="d-flex justify-content-between">
                <span class="cart_title">
                    <a class="btn btn-white" href="{{route('coupon.remove')}}">
                        <i class="ri ri-delete-bin-2-fill"></i>
                    </a>
                    {{\App\CPU\Helpers::translate('coupon_discount')}} <span style="font-size: 12px">{{ Helpers::translate($coupon->coupon_type) }}</span>
                </span>
                @if($coupon->coupon_type == "free_delivery")
                <span class="cart_value" id="coupon-discount-amount">
                    - {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
                </span>
                @else
                <span class="cart_value" id="coupon-discount-amount">
                    - {{session()->has('coupon_discount')?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}}
                </span>
                @endif
            </div>
            @php($coupon_dis=session('coupon_discount'))
        @else
            <div class="mt-2">
                <form class="needs-validation rounded-11 border bg-white" action="javascript:" method="post" novalidate id="coupon-code-ajax">
                    <div class="input-group bg-transparent ps-1 pe-0 py-0 w-100 bg-white">
                        <input class="border-0 input_code rounded-11" type="text" name="code" style="width: 282.6px"
                            placeholder="{{\App\CPU\Helpers::translate('Coupon code')}}" required>
                        <div class="">
                            <button class="btn btn-primary text-light py-1 h-100 d-block" type="button"
                                onclick="couponCode()">{{\App\CPU\Helpers::translate('apply_code')}}
                            </button>
                        </div>
                        <div class="invalid-feedback">{{\App\CPU\Helpers::translate('please_provide_coupon_code')}}
                        </div>
                    </div>
                </form>
            </div>
            @php($coupon_dis=0)
        @endif
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('shipping')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('discount_on_product')}}</span>
            <span class="cart_value">
                - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('products tax')}}</span>
            <span class="cart_value">
                @isset($total_taxz)
                {{\App\CPU\Helpers::currency_converter($total_taxz)}}
                @endisset
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('shipping tax')}}</span>
            <span class="cart_value">
                @isset($coupon)
                    @if($coupon->coupon_type == "free_delivery")
                        {{\App\CPU\Helpers::currency_converter(0)}}
                    @else
                        {{ \App\CPU\Helpers::currency_converter(($choosen_shipping['shipping_cost'] ?? 0) * (($choosen_shipping['tax'] ?? 0)/100)) }}
                    @endif
                @else
                {{ \App\CPU\Helpers::currency_converter(($choosen_shipping['shipping_cost'] ?? 0) * (($choosen_shipping['tax'] ?? 0)/100)) }}
                @endisset
            </span>
        </div>


        <hr class="mt-2 mb-2">
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('total')}}</span>
            <span class="cart_value">
               {{\App\CPU\Helpers::currency_converter($sub_total-$coupon_dis-$total_discount_on_product+$total_tax+$total_shipping_cost)}}
            </span>
        </div>

        {{-- <div class="d-flex justify-content-center">
            <span class="cart_total_value mt-2">
                {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)}}
            </span>
        </div> --}}

    </div>
    <a onclick="checkout()"
       class="btn btn--primary mt-4 text-light w-100 pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
        {{\App\CPU\Helpers::translate('checkout')}}
    </a>
</aside>
