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

@php($summary = Helpers::order_summary_user_auth())
@php($shippong_cost = $summary['total_shipping_cost'])
@php($shippong_tax = $summary['shipping_tax'])

<aside class="col-lg-4 pt-4 pt-lg-0">
    <div class="cart_total bg-light border-light rounded-11 font-wight-bold" style="line-height: 40px">
        <p class="text-2xl font-weight-bold">
            {{ Helpers::translate('Bill') }}
        </p>
        @php($shipping_cost=\App\CPU\CartManager::get_shipping_cost())
        @if($cart->count() > 0)
        @else
            <span>{{\App\CPU\Helpers::translate('empty_cart')}}</span>
        @endif
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('sub_total')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($summary['sub_total'])}}
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
                    - {{\App\CPU\Helpers::currency_converter($summary['total_shipping_cost'])}}
                </span>
                @else
                <span class="cart_value" id="coupon-discount-amount">
                    - {{session()->has('coupon_discount')?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}}
                </span>
                @endif
            </div>
        @else
            <div class="mt-2">
                <form class="needs-validation rounded-11 border bg-white" action="javascript:" method="post" novalidate id="coupon-code-ajax">
                    <div class="row">
                        <input class="col-8 border-0 input_code rounded-11" type="text" name="code"
                            placeholder="{{\App\CPU\Helpers::translate('Coupon code')}}" required>
                        <button class="col-4 btn btn-primary text-light py-1 d-block rounded-md" type="button"
                            onclick="couponCode()">{{\App\CPU\Helpers::translate('apply_code')}}
                        </button>
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
                {{\App\CPU\Helpers::currency_converter($summary['total_shipping_cost'])}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('discount_on_product')}}</span>
            <span class="cart_value">
                - {{\App\CPU\Helpers::currency_converter($summary['total_discount_on_product'])}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('products tax')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($summary['total_tax_products'])}}
                @isset($total_taxz)
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
               {{ $summary['total'] }}
            </span>
        </div>

        {{-- <div class="d-flex justify-content-center">
            <span class="cart_total_value mt-2">
                {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)}}
            </span>
        </div> --}}

    </div>
    <a onclick="checkout()"
       class="btn bg-primaryColor mt-4 text-light w-full pull-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}">
        {{\App\CPU\Helpers::translate('checkout')}}
    </a>
</aside>
