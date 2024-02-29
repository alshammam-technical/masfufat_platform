@extends('layouts.front-end.app')

@if($order->payment_status == 'unpaid')
@section('title',\App\CPU\Helpers::translate('Complete Order'))
@endif
@if($order->payment_status == 'paid')
@section('title',\App\CPU\Helpers::translate('Payment successfully'))
@endif
@push('css_or_js')
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="{{ asset('public/assets/front-end/css/bootstrap-select.min.css') }}">

    @if(env('APP_DEBUG'))
    <script src="https://demo.myfatoorah.com/cardview/v1/session.js"></script>
    @elseif (($country_code ?? 'SA') == 'SA')
        <script src="https://portal.myfatoorah.com/cardview/v1/session.js"></script>
    @else
        <script src="https://sa.myfatoorah.com/cardview/v1/session.js"></script>
    @endif

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
        .footer ,header, .anouncementDiv{
            display:none;
          }

        .btn-outline {
            border-color: {{$web_config['primary_color']}} ;
        }

        .btn-outline {
            color: #020512;
            border-color: {{$web_config['primary_color']}}    !important;
        }

        .btn-outline:hover {
            color: white;
            background: {{$web_config['primary_color']}};

        }

        .btn-outline:focus {
            border-color: {{$web_config['primary_color']}}    !important;
        }

        #location_map_canvas,.location_map_canvas {
            height: 100%;
        }

        .filter-option{
            display: block;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
            padding: 0.625rem 1rem;
            font-size: .9375rem;
            font-weight: 400;
            line-height: 1.5;
            color: #4b566b;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #dae1e7;
            border-radius: 0.3125rem;
            box-shadow: 0 0 0 0 transparent;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .btn-light + .dropdown-menu{
            transform: none !important;
            top: 41px !important;
        }

        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            #location_map_canvas,.location_map_canvas {
                height: 200px;
            }
        }

        .address-item.selected .card{
            border: solid thin {{ Helpers::get_business_settings('colors')['primary'] }};
        }

        .d-none, .d-none *{
            display: none !important;
        }
    </style>
@endpush

@if($order->payment_status == 'unpaid')
@section('content')
@if(($order->show_shippingmethod_for_customer == 1 || $order->ext_order_id != '') && (App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id == $order->id))



    {{--  shippingMethod  --}}
    <div class="container pb-5 mb-2 mb-md-4 rtl"
    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
    <div class="row">
        <section class="col-lg-12 col-md-12">
            <div class="card box-shadow-sm">
            <div class="card-body bg-light">
                <div class="col-sm-4">
                            <h1 class="h3  mb-0 folot-left headerTitle">
                                {{\App\CPU\Helpers::translate('Select shipping Method')}}</h1>
                        </div>
            <div class="row mt-6 col-12 mb-6" style="display: block;">
                @if($shippingMethod=='inhouse_shipping')
                        <?php
                        $admin_shipping = \App\Model\ShippingType::where('seller_id', 0)->first();
                        $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                        ?>
                        @php($shippings=\App\CPU\Helpers::get_shipping_methods(1,'admin'))

                        @if(isset($choosen_shipping)==false)
                            @php($choosen_shipping['shipping_method_id']=0)
                        @endif
                        @php($order_id =$order->id)
                        <div class="row">
                            <div class="col-12">
                                <select class="form-control" onchange="set_shipping_id(this.value,'{{$order_id}}')">
                                    <option disabled selected>{{\App\CPU\Helpers::translate('choose_shipping_method')}}</option>
                                    @foreach($shippings as $shipping)
                                        <option
                                            value="{{$shipping['id']}}" {{$order->shipping_method_id==$shipping['id']?'selected':''}}>
                                            {{$shipping['title'].' ( '.$shipping['duration'].' ) '.\App\CPU\Helpers::currency_converter($shipping['cost'])}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                @endif
            </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endif

<div class="container pb-5 rtl" style="text-align: right;">
<section class="col-lg-12 col-md-12">

    <div class="cart_total bg-light border-light rounded-11" style="line-height: 40px; padding: 30px 30px;">
        <div class="col-sm-4 mb-5">
            <h1 class="h3  mb-0 folot-left headerTitle">
                {{\App\CPU\Helpers::translate('Bill')}}</h1>
        </div>

        @if(session()->has('coupon_discount'))
            @php($coupon = \App\Model\Coupon::where('code',session('coupon_code'))->first())
        @endif

        @php($total_shipping_cost=$order->shipping_cost)
        @php($tax = $order->shipping_tax)
        @php($sub_total=$order->order_amount - $total_shipping_cost)
        @php($total_tax=0)
        @php($total_discount_on_product=0)
        @php($admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first())
        @php($shippingType =isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise')

        @php($shipping_cost=\App\CPU\CartManager::get_shipping_cost())
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
                    <div class="input-group bg-transparent ps-1 pe-0 py-0 w-full bg-white">
                        <input class="border-0 input_code rounded-11" type="text" name="code" style="width:auto;margin-left: auto;"
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
        @php($ot = Helpers::get_order_totals($order))
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('The total does not include tax')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($ot['total_without_tax'])}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('Shipping')}}</span>
            <span class="cart_value">
                {{ \App\CPU\BackEndHelper::set_symbol($order['shipping_cost']) }}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('product discount')}}</span>
            <span class="cart_value">
                {{ \App\CPU\BackEndHelper::set_symbol(($ot['coupon_discount'])) }}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('products tax')}}</span>
            <span class="cart_value">
                {{ \App\CPU\BackEndHelper::set_symbol($ot['products_tax']) }}
            </span>
        </div>


        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('shipping tax')}}</span>
            <span class="cart_value">
                @isset($coupon)
                    @if($coupon->coupon_type == "free_delivery")
                        {{\App\CPU\Helpers::currency_converter(0)}}
                    @else
                    {{ \App\CPU\Helpers::currency_converter(($order['shipping_cost'] ?? 0) * (($order['shipping_tax'] ?? 0)/100)) }}
                    @endif
                @else
                {{ \App\CPU\Helpers::currency_converter(($order['shipping_cost'] ?? 0) * (($order['shipping_tax'] ?? 0)/100)) }}
                @endisset
            </span>
        </div>

        @php($total=$sub_total-$coupon_dis-$total_discount_on_product+$total_tax+$total_shipping_cost+$tax)
        <hr class="mt-2 mb-2">
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\Helpers::translate('total')}}</span>
            <span class="cart_value">
                {{\App\CPU\BackEndHelper::set_symbol(Helpers::get_order_totals($order)['total'])}}
            </span>
        </div>

    </div>
</section>
</div>

@php($billing_input_by_customer=\App\CPU\Helpers::get_business_settings('billing_input_by_customer'))
    @if($order->shipping_method_id || App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id !== $order->id)
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};@if($order->external_order) @else {{$order->shipping_method_id == 0 ? '' : '' }} @endif">
        <div class="row">
            <div class="row mt-6">

            </div>

            <section class="col-lg-12 mt-5">
                <div class="checkout_details mt-3 card bg-light border-11">
                    <!-- Payment methods accordion-->
                    <div class="row p-4">
                        <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                            <div class="col-sm-4">
                                <h1 class="h3  mb-0 folot-left headerTitle">
                                    {{\App\CPU\Helpers::translate('choose_payment')}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row w-full mx-0">
                        @php($digital_payment=\App\CPU\Helpers::get_user_paymment_methods($user->id,'digital_payment'))
                        @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
                        @php($myfatoorahS=\App\CPU\Helpers::get_user_paymment_methods($user->id,'myfatoorah'))
                        @if (($digital_payment['status'] ?? null)==1)
                        @if(($myfatoorahS['status'] ?? null) == "1" || 1 == 1)
                        @foreach ($payment_gateways_list as $payment_gateway)
                            <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body min-h-40" onclick="$(this).closest('.card').find('.ok-b').slideToggle()">
                                        <form id="{{($payment_gateway->key_name)}}_form" action="{{ route('customer.web-payment-request',['order_id' => $order->id]) }}" method="post" class="needs-validation d-grid text-center" onsubmit="ajsub(event)">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ (auth('customer')->check() || auth('delegatestore')->check()) ? $storeId : session('guest_id') }}">
                                            <input type="hidden" name="customer_id" value="{{ (auth('customer')->check() || auth('delegatestore')->check()) ? $storeId : session('guest_id') }}">
                                            <input type="hidden" name="payment_method" value="{{ $payment_gateway->key_name }}">
                                            <input type="hidden" name="payment_platform" value="web">

                                            @if ($payment_gateway->mode == 'live' && isset($payment_gateway->live_values['callback_url']))
                                                <input type="hidden" name="callback" value="{{ $payment_gateway->live_values['callback_url'] }}">
                                            @elseif ($payment_gateway->mode == 'test' && isset($payment_gateway->test_values['callback_url']))
                                                <input type="hidden" name="callback" value="{{ $payment_gateway->test_values['callback_url'] }}">
                                            @else
                                                <input type="hidden" name="callback" value="">
                                            @endif

                                            <input type="hidden" name="external_redirect_link" value="{{ url('/').'/web-payment' }}">

                                            <div class="btn btn-block click-if-alone grid justify-content-center pb-3" style="place-items: center">
                                                <img width="120" src="{{asset('storage/app/public/payment_modules/gateway_image')}}/{{(json_decode($payment_gateway->additional_data)->gateway_image) != null ? (json_decode($payment_gateway->additional_data)->gateway_image) : ''}}">
                                                <p>
                                                    <strong>
                                                        {{ json_decode($payment_gateway->additional_data)->gateway_title }}
                                                    </strong>
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="p-0 m-0 w-full ok-b card-footer" style="display: none">
                                        <button class="btn btn-primary bg-primaryColor w-full" type="submit" onclick="$('#{{($payment_gateway->key_name)}}_form').submit()">
                                            {{ Helpers::translate('Pay Now') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'bank_transfer'))
                        @php($banks=\App\CPU\Helpers::get_user_paymment_methods($user->id,'bank_transfer'))
                        @php($banks_=\App\CPU\Helpers::get_user_paymment_methods($user->id,'bank_transfer'))
                        @php($banksCnt = 0)
                        @foreach ($banks as $index=>$bank)
                            @if(($bank['status'] ?? null) && ($banks_[$index]['status']))
                            @php($banksCnt = $banksCnt + 1)
                            @endif
                        @endforeach
                        @if(!$cod_not_show && count($config) && $banksCnt)
                        <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body p-0" style="height: max-content;">
                                    <form action="{{route('checkout-complete-by-customer')}}" method="post"
                                        class="needs-validation d-grid text-center" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="bank_transfer">
                                        <div class="btn btn-block click-if-alone grid justify-content-center py-5" onclick="$(this).next().slideToggle()">
                                            <img width="66.3"
                                                src="{{asset('public/assets/front-end/img/bank-transfer-icon.png')}}" />
                                            <p>
                                                <strong>
                                                    {{ Helpers::translate('bank_transfer') }}
                                                </strong>
                                            </p>
                                        </div>
                                        <div style="display: none">
                                            <div class="h-100 p-2">
                                                @php($banks=\App\CPU\Helpers::get_user_paymment_methods($user->id,'bank_transfer'))
                                                @php($banks_=\App\CPU\Helpers::get_user_paymment_methods($user->id,'bank_transfer'))
                                                @php($item_index = 0)
                                                @php($conf['environment'] = $conf['environment']??'sandbox')
                                                <div class="w-full text-center p-3 rounded"
                                                    style="background-color: #f2f2f2;">
                                                    <div class="form-group">
                                                        <select name="bank" id="bank" class="form-control"
                                                            onchange="$('._banks').hide();$('.'+$(this).val()+'_bank').show();">
                                                            @foreach ($banks as $index=>$bank)
                                                            @if(($bank['status'] ?? null)  && ($banks_[$index]['status']))
                                                            <option value="{{$index}}">{{$bank['name']}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @foreach ($banks as $index=>$conf)
                                                    @if(($conf['status'] ?? null))
                                                    <div class="_banks {{$index}}_bank" @if($index)
                                                        style="display: none" @endif>
                                                        <div class="form-group">
                                                            <label class="d-flex title-color h6">
                                                                {{\App\CPU\Helpers::translate('Account owner name')}} :
                                                                <br />
                                                                {{$conf['owner_name'] ?? ''}}
                                                            </label>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="d-flex title-color h6">
                                                                {{\App\CPU\Helpers::translate('Account number')}} :
                                                                {{$conf['account_number'] ?? ''}}
                                                            </label>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="d-flex title-color h6">
                                                                {{\App\CPU\Helpers::translate('IBAN number')}} :
                                                                {{$conf['iban'] ?? ''}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </div>

                                                <div class="form-group">
                                                    <label for="attachment">
                                                        {{ Helpers::translate('Please attach the receipt image') }}
                                                    </label>
                                                    <input class="form-control mx-0 w-full" type="file" required
                                                        accept=".docx,.pdf,.png,.jpg" name="attachment" placeholder="">
                                                </div>

                                                <div class="form-group">
                                                    <label for="holder_name">
                                                        {{ Helpers::translate('Account Holder Name') }}
                                                    </label>
                                                    <input class="form-control mx-0 w-full" type="text"
                                                        name="holder_name" placeholder="">
                                                </div>
                                                @php($item_index++)
                                                @php($config['environment'] = $config['environment']??'sandbox')
                                                <div class="p-0 m-0 w-full">
                                                    <input type="hidden" name="id" value="{{$order->id}}" />
                                                    <input type="hidden" name="payment_method" value="bank_transfer">
                                                    <button class="btn btn-primary bg-primaryColor w-full" type="submit">Ok</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif




                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'stripe'))
                        @if(($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="button"
                                        id="checkout-button">
                                        {{-- <i class="czi-card"></i> {{\App\CPU\Helpers::translate('Credit / Debit card ( Stripe )')}}
                                        --}}
                                        <img width="150" src="{{asset('public/assets/front-end/img/stripe.png')}}" />
                                        <p>
                                            <strong>
                                                {{ Helpers::translate('stripe') }}
                                            </strong>
                                        </p>
                                    </button>
                                    <script type="text/javascript">
                                        // Create an instance of the Stripe object with your publishable API key
                                        var stripe = Stripe('{{$config['
                                            published_key ']}}');
                                        var checkoutButton = document.getElementById("checkout-button");
                                        checkoutButton.addEventListener("click", function () {
                                            fetch("{{route('pay-stripe')}}", {
                                                method: "GET",
                                            }).then(function (response) {
                                                console.log(response)
                                                return response.text();
                                            }).then(function (session) {
                                                /*console.log(JSON.parse(session).id)*/
                                                return stripe.redirectToCheckout({
                                                    sessionId: JSON.parse(session).id
                                                });
                                            }).then(function (result) {
                                                if (result.error) {
                                                    alert(result.error.message);
                                                }
                                            }).catch(function (error) {
                                                console.error(
                                                    "{{\App\CPU\Helpers::translate('Error')}}:",
                                                    error);
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'razor_pay'))
                        @php($inr=\App\Model\Currency::where(['symbol'=>'₹'])->first())
                        @php($usd=\App\Model\Currency::where(['code'=>'USD'])->first())
                        @if(isset($inr) && isset($usd) && ($config['status'] ?? null))

                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <form action="{!!route('payment-razor')!!}" method="POST">
                                        @csrf
                                        <!-- Note that the amount is in paise = 50 INR -->
                                        <!--amount need to be in paisa-->
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ \Illuminate\Support\Facades\Config::get('razor.razor_key') }}"
                                            data-amount="{{(round(\App\CPU\Convert::usdToinr($amount)))*100}}"
                                            data-buttontext="Pay {{(\App\CPU\Convert::usdToinr($amount))*100}} INR"
                                            data-name="{{\App\Model\BusinessSetting::where(['type'=>'company_name'])->first()->value}}"
                                            data-description=""
                                            data-image="{{asset('storage/app/public/company/'.\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)}}"
                                            data-prefill.name="{{$user->f_name}}"
                                            data-prefill.email="{{$user->email}}"
                                            data-theme.color="#ff7529">
                                        </script>
                                    </form>
                                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="button"
                                        onclick="$('.razorpay-payment-button').click()">
                                        <img width="150" src="{{asset('public/assets/front-end/img/razor.png')}}" />
                                        <p>
                                            <strong>
                                                {{ Helpers::translate('razor') }}
                                            </strong>
                                        </p>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'paystack'))
                        @if(($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'paystack'))
                                    @php($order=\App\Model\Order::find(session('order_id')))
                                    <form method="POST" action="{{ route('paystack-pay') }}" accept-charset="UTF-8"
                                        class="form-horizontal" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <input type="hidden" name="email"
                                                    value="{{$user->email}}"> {{-- required --}}
                                                <input type="hidden" name="orderID"
                                                    value="{{session('cart_group_id')}}">
                                                <input type="hidden" name="amount"
                                                    value="{{\App\CPU\Convert::usdTozar($amount*100)}}">
                                                {{-- required in kobo --}}

                                                <input type="hidden" name="currency"
                                                    value="{{\App\CPU\Helpers::currency_code()}}">
                                                <input type="hidden" name="metadata"
                                                    value="{{ json_encode($array = ['key_name' => 'value',]) }}">
                                                {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                                <input type="hidden" name="reference"
                                                    value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                                                <p>
                                                    <button class="paystack-payment-button" style="display: none"
                                                        type="submit" value="Pay Now!"></button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="button"
                                        onclick="$('.paystack-payment-button').click()">
                                        <img width="100" src="{{asset('public/assets/front-end/img/paystack.png')}}" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($myr=\App\Model\Currency::where(['code'=>'MYR'])->first())
                        @php($usd=\App\Model\Currency::where(['code'=>'usd'])->first())
                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'senang_pay'))
                        @if(isset($myr) && isset($usd) && ($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'senang_pay'))
                                    @php($user=$user)
                                    @php($secretkey = $config['secret_key'])
                                    @php($data = new \stdClass())
                                    @php($data->merchantId = $config['merchant_id'])
                                    @php($data->detail = 'payment')
                                    @php($data->order_id = session('cart_group_id'))
                                    @php($data->amount = \App\CPU\Convert::usdTomyr($amount))
                                    @php($data->name = $user->f_name.' '.$user->l_name)
                                    @php($data->email = $user->email)
                                    @php($data->phone = $user->phone)
                                    @php($data->hashed_string = md5($secretkey . urldecode($data->detail) .
                                    urldecode($data->amount) . urldecode($data->order_id)))

                                    <form name="order" method="post"
                                        action="https://{{env('APP_MODE')=='live'?'app.senangpay.my':'sandbox.senangpay.my'}}/payment/{{$config['merchant_id']}}">
                                        <input type="hidden" name="detail" value="{{$data->detail}}">
                                        <input type="hidden" name="amount" value="{{ Helpers::get_order_totals($order)['total'] }}">
                                        <input type="hidden" name="order_id" value="{{$data->order_id}}">
                                        <input type="hidden" name="name" value="{{$data->name}}">
                                        <input type="hidden" name="email" value="{{$data->email}}">
                                        <input type="hidden" name="phone" class="phoneInput" value="{{$data->phone}}">
                                        <input type="hidden" name="hash" value="{{$data->hashed_string}}">
                                    </form>

                                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="button"
                                        onclick="document.order.submit()">
                                        <img width="100" src="{{asset('public/assets/front-end/img/senangpay.png')}}" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'paymob_accept'))
                        @if(($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <form class="needs-validation d-grid text-center" method="POST"
                                        id="payment-form-paymob" action="{{route('paymob-credit')}}">
                                        {{ csrf_field() }}
                                        <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="submit">
                                            <img width="150"
                                                src="{{asset('public/assets/front-end/img/paymob.png')}}" />
                                            <p>
                                                <strong>
                                                    {{ Helpers::translate('paymob') }}
                                                </strong>
                                            </p>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'bkash'))
                        @if(isset($config) && ($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0" id="bKash_button"
                                        onclick="BkashPayment()">
                                        <img width="100" src="{{asset('public/assets/front-end/img/bkash.png')}}" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'paytabs'))
                        @if(isset($config) && ($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0"
                                        onclick="location.href='{{route('paytabs-payment')}}'"
                                        style="margin-top: -11px">
                                        <img width="150" src="{{asset('public/assets/front-end/img/paytabs.png')}}" />
                                        <p>
                                            <strong>
                                                {{ Helpers::translate('paytabs') }}
                                            </strong>
                                        </p>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{--@php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'fawry_pay'))
                            @if(isset($config)  && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 175px">
                                            <button class="btn btn-block" onclick="location.href='{{route('fawry')}}'"
                        style="margin-top: -11px">
                        <img width="150" src="{{asset('public/assets/front-end/img/fawry.svg')}}" />
                        </button>
                    </div>
                </div>
        </div>
        @endif--}}

        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'mercadopago'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <a class="btn btn-block click-if-alone grid justify-content-center pb-0" href="{{route('mercadopago.index')}}">
                        <img width="150" src="{{asset('public/assets/front-end/img/MercadoPago_(Horizontal).svg')}}" />
                        <p>
                            <strong>
                                {{ Helpers::translate('mercadopago') }}
                            </strong>
                        </p>
                    </a>
                </div>
            </div>
        </div>
        @endif

        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'flutterwave'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body pt-2" style="height: 175px">
                    <form method="POST" action="{{ route('flutterwave_pay') }}">
                        {{ csrf_field() }}

                        <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="submit">
                            <img width="200" src="{{asset('public/assets/front-end/img/fluterwave.png')}}" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'paytm'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <a class="btn btn-block click-if-alone grid justify-content-center pb-0" href="{{route('paytm-payment')}}">
                        <img style="max-width: 175px; margin-top: -10px"
                            src="{{asset('public/assets/front-end/img/paytm.png')}}" />
                    </a>
                </div>
            </div>
        </div>
        @endif

        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'liqpay'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <a class="btn btn-block click-if-alone grid justify-content-center pb-0" href="{{route('liqpay-payment')}}">
                        <img style="max-width: 175px; margin-top: 0px"
                            src="{{asset('public/assets/front-end/img/liqpay4.png')}}" />
                    </a>
                </div>
            </div>
        </div>
        @endif
        {{--  </div>  --}}
        @endif

        {{--  <div class="row w-full mx-0">  --}}
        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'cash_on_delivery'))
        @if(!$cod_not_show && ($config['status'] ?? null))
        <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer" onclick="$(this).find('.ok-b').slideToggle()">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <form action="{{route('checkout-complete-by-customer')}}" method="post"
                        class="needs-validation d-grid text-center">
                        @csrf
                        <input type="hidden" name="payment_method" value="cash_on_delivery">
                        <div class="btn btn-block click-if-alone grid justify-content-center pb-0">
                            <img width="120" style="margin-top: -10px"
                                src="{{asset('public/assets/front-end/img/cod.png')}}" />
                            <p>
                                <strong>
                                    {{ Helpers::translate('cash_on_delivery') }}
                                </strong>
                            </p>
                        </div>
                        <input type="hidden" name="id" value="{{$order->id}}" />
                        <input type="hidden" name="payment_method" value="cash_on_delivery">
                        <div class="p-0 m-0 w-full ok-b" style="display: none">
                            <button class="btn btn-primary bg-primaryColor w-full" type="submit">Ok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'delayed'))
        @if(!$cod_not_show && ($config['status'] ?? null))
        <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer" onclick="$(this).find('.ok-b').slideToggle()">
            <form action="{{route('checkout-complete-by-customer')}}" method="post" class="needs-validation d-grid text-center">
                    <div class="card">
                        <div class="card-body pb-3">
                        @csrf
                        <input type="hidden" name="payment_method" value="delayed">
                        <div class="btn btn-block click-if-alone grid justify-content-center pb-0">
                            <img width="70" src="{{asset('public/assets/front-end/img/delayed.jpg')}}" />
                            <p>
                                <strong>
                                    {{ Helpers::translate('delayed payment') }}
                                </strong>
                            </p>
                        </div>
                        <input type="hidden" name="id" value="{{$order->id}}" />
                    </div>
                    <div class="card-footer p-0">
                        <div class="p-0 m-0 w-full ok-b" style="display: none">
                            <button class="btn btn-primary bg-primaryColor w-full" type="submit">{{ Helpers::translate('Pay Now') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif


        @if (($digital_payment['status'] ?? null)==1)
        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'customer_wallet')['wallet_status'])
        @if($config==1)
        <div class="col-md-4 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body d-grid text-center" style="height: 126px">
                    <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="submit" data-toggle="modal"
                        data-target="#wallet_submit_button">

                        <img width="50" style="margin-top: -10px"
                            src="{{asset('public/assets/front-end/img/wallet.jpg')}}" />
                        <p>
                            <strong>
                                {{ Helpers::translate('wallet') }}
                            </strong>
                        </p>
                    </button>
                </div>
            </div>
        </div>
        @endif
        @endif

        @php($config=\App\CPU\Helpers::get_business_settings('offline_payment'))
        @if(isset($config) && $config['status'])
        <div class="col-sm-4" id="cod-for-cart">
            <div class="card cursor-pointer">
                <div class="card-body __h-100px">
                    <form action="{{route('offline-payment-checkout-complete')}}" method="get"
                        class="needs-validation d-grid text-center">
                        <span class="btn btn-block click-if-alone grid justify-content-center pb-0" data-toggle="modal"
                            data-target="#offline_payment_submit_button">
                            <img width="150" class="__mt-n-10"
                                src="{{asset('public/assets/front-end/img/pay-offline.png')}}" />
                        </span>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
        {{--  @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount)  --}}
        @php($amount = Helpers::get_order_totals($order)['total'])



        @if (($digital_payment['status'] ?? null)==1)

        @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'ssl_commerz_payment'))
        @if(($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <form action="{{ url('/pay-ssl') }}" method="POST" class="needs-validation d-grid text-center">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="submit">
                            <img width="150" src="{{asset('public/assets/front-end/img/sslcomz.png')}}" />
                            <p>
                                <strong>
                                    {{ Helpers::translate('sslcomz') }}
                                </strong>
                            </p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        </div>
        <div class="row">
            @php($config=\App\CPU\Helpers::get_user_paymment_methods($user->id,'paypal'))
            @if(($config['status'] ?? null))
            <div class="col-md-6 mb-4" style="cursor: pointer">
                <div class="card">
                    <div class="card-body" style="height: 175px">
                        <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                            action="{{route('pay-paypal')}}">
                            {{ csrf_field() }}
                            <button class="btn btn-block click-if-alone grid justify-content-center pb-0" type="submit">
                                <img width="150" src="{{asset('public/assets/front-end/img/paypal.png')}}" />
                                <p>
                                    <strong>
                                        {{ Helpers::translate('paypal') }}
                                    </strong>
                                </p>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @endif

        </div>
        <!-- Navigation (desktop)-->
        </div>
        </section>


        </div>
    </div>

    <div class="modal fade" id="wallet_submit_button" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{\App\CPU\Helpers::translate('wallet_payment')}}</h5>
            </div>
            @php($customer_balance = $user->wallet_balance)
            @php($remain_balance = $customer_balance - $amount)
            <form action="{{route('checkout-complete-by-customer-wallet')}}" method="post" class="needs-validation d-grid text-center">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="">{{\App\CPU\Helpers::translate('your_current_balance')}}</label>
                            <input class="form-control" type="text" value="{{\App\CPU\Helpers::currency_converter($customer_balance)}}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="">{{\App\CPU\Helpers::translate('order_amount')}}</label>
                            <input class="form-control" type="text" value="{{\App\CPU\Helpers::currency_converter($amount)}}" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="">{{\App\CPU\Helpers::translate('remaining_balance')}}</label>
                            <input class="form-control" type="text" value="{{\App\CPU\Helpers::currency_converter($remain_balance)}}" readonly>
                            @if ($remain_balance<0)
                            <label style="color: crimson">{{\App\CPU\Helpers::translate('you do not have sufficient balance for pay this order!!')}}</label>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="{{$order->id}}" />
                    <input type="hidden" name="payment_method" value="pay_by_wallet">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                <button type="submit" onclick="alert_wait()" class="btn bg-primaryColor btn-primary bg-primaryColor" {{$remain_balance>0? '':'disabled'}}>{{\App\CPU\Helpers::translate('submit')}}</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    @endif
@endsection

@endif

@if($order->payment_status == 'paid')
@section('content')

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
    }
    .container {
        width: 1400px;
        margin: 100px auto;
        background-color: #fff;
        padding: 120px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        align-content: center;
    }
    h1 {
        text-align: center;
    }
    p {
        text-align: center;
    }
    .button {
        text-align: center;
        margin-top: 20px;
    }
    .button a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .button a:hover {
        background-color: #45a049;
    }
</style>
<div class="vh-100 d-flex justify-content-center align-items-center">
    <div>
        <div class="mb-4 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16" style="display: inline-table;">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg>
        </div>
        <div class="text-center">
            <h1>{{\App\CPU\Helpers::translate('Thank You !')}}</h1>
            <p>{{\App\CPU\Helpers::translate('Payment Successful')}}</p>
            <a href="{{ $order->ext_order_id == null ? route('account-order-details', ['id' => $order->id]) : route('orders.show', ['id' => $order->id]) }}" class="btn btn-primary">{{\App\CPU\Helpers::translate('Order details')}}</a>
        </div>
    </div>

<style>
    #content {
        margin-top: 0px !important;
    }
</style>
@endsection
@endif




@push('script')
    <script>
        function anotherAddress() {
            $('#sh-0').prop('checked', true);
            //$("#collapseThree").collapse();
        }

        function billingAddress() {
            $('#bh-0').prop('checked', true);
            //$("#billing_model").collapse();
        }

    </script>
    <script>
        function hide_billingAddress() {
            let check_same_as_shippping = $('#same_as_shipping_address').is(":checked");
            console.log(check_same_as_shippping);
            if (check_same_as_shippping) {
                $('#hide_billing_address').hide();
            } else {
                $('#hide_billing_address').show();
            }
        }
    </script>

    <script>
        function proceed_to_next() {
            let physical_product = $('#physical_product').val();

            if(physical_product === 'yes') {
                var billing_addresss_same_shipping = $('#same_as_shipping_address').is(":checked");

                let allAreFilled = true;
                document.getElementById("address-form").querySelectorAll("[required]").forEach(function (i) {
                    if (!allAreFilled) return;
                    if (!i.value) allAreFilled = false;
                    if (i.type === "radio") {
                        let radioValueCheck = false;
                        document.getElementById("address-form").querySelectorAll(`[name=${i.name}]`).forEach(function (r) {
                            if (r.checked) radioValueCheck = true;
                        });
                        allAreFilled = radioValueCheck;
                    }
                });

                //billing address saved
                let allAreFilled_shipping = true;
                billing_addresss_same_shipping = true
                if (billing_addresss_same_shipping != true) {

                    document.getElementById("billing-address-form").querySelectorAll("[required]").forEach(function (i) {
                        if (!allAreFilled_shipping) return;
                        if (!i.value) allAreFilled_shipping = false;
                        if (i.type === "radio") {
                            let radioValueCheck = false;
                            document.getElementById("billing-address-form").querySelectorAll(`[name=${i.name}]`).forEach(function (r) {
                                if (r.checked) radioValueCheck = true;
                            });
                            allAreFilled_shipping = radioValueCheck;
                        }
                    });
                }
            }else {
                var billing_addresss_same_shipping = false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('customer.choose-shipping-address')}}',
                data: {
                    physical_product: physical_product,
                    shipping: physical_product === 'yes' ? $('#address-form').serialize() : null,
                    billing: $('#billing-address-form').serialize(),
                    billing_addresss_same_shipping: billing_addresss_same_shipping
                },

                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        location.href = '{{route('checkout-payment')}}';
                    }
                },
                complete: function () {
                    $('#loading').hide();
                },
                error: function (data) {
                    let error_msg = data.responseJSON.errors;
                    toastr.error(error_msg, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });


        }

        function getShippingAreas(value){
            $('#area_id').attr('disabled',1);$('#area_id_loading').show();$.get('{{route('get-shipping-areas')}}?code='+value).then(d=>{$('#area_id').html(d);$('#area_id').removeAttr('disabled');$('#area_id_loading').hide();$('#area_id').find('option[value='+$('#area_id_hidden').val()+']').attr('selected','selected');$('#area_id').SumoSelect().sumo.reload()})
        }
        getShippingAreas($("#country_select").val());
    </script>
    <script>
        cartQuantityInitialize();

        function set_shipping_id(id, order_id) {
            $.post({
                url: '{{url('/')}}/set-shipping-method',
                dataType: 'json',
                data: {
                    id: id,
                    order_id: order_id,
                    _token:"{{ csrf_token() }}"
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

        function ajsub(e)
        {
            alert_wait()
            e.preventDefault()
            var ths = $(e.target)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('customer.web-payment-request',['order_id' => $order->id]) }}",
                data: ths.serialize(),
                success: function (response){
                    //location.replace(response)
                    ths.closest('.card').find('.ok-b').html(response);
                    Swal.close()
                }
            })
        }
    </script>
@endpush
