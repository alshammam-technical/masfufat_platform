@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Choose Payment Method'))

@push('css_or_js')
    <style>
        .stripe-button-el {
            display: none !important;
        }

        .razorpay-payment-button {
            display: none !important;
        }
    </style>

    {{--stripe--}}
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
    {{--stripe--}}
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header" style="background: #dcdcdc;line-height: 1px">
                    <span>{{ \App\CPU\Helpers::translate('payment_method')}}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                @include('web-views.partials._checkout-steps',['step'=>3])
                <!-- Payment methods accordion-->
                    <h2 class="h6 pb-3 mb-2 mt-5">{{\App\CPU\Helpers::translate('choose_payment')}}</h2>
                    @php($digital_payment=\App\CPU\Helpers::get_user_paymment_methods(null,'digital_payment'))
                    @php($myfatoorahS=\App\CPU\Helpers::get_user_paymment_methods(null,'myfatoorah'))
                    @if (($digital_payment['status'] ?? null)==1)
                        <div class="row">
                            @if($myfatoorahS['subs_status'] ?? null)
                            @foreach ($myFatoorahMethods as $pm)
                            @if($pm->ImageUrl == "https://sa.myfatoorah.com/imgs/payment-methods/ap.png" && !$mac_device)
                            @else
                                <div class="col-md-4 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                                            action="{{route('pay-myfatoorah',['paymentMethodId' => $pm->PaymentMethodId])}}">
                                            <div class="card-body" style="height: auto">
                                                {{ csrf_field() }}
                                                <div class="btn btn-block click-if-alone d-block" onclick="$(this).next().slideToggle()">
                                                    <img width="80" src="{{ $pm->ImageUrl }}"/>
                                                    <p>
                                                        <strong>
                                                            {{ session()->get('local') == 'sa' ? $pm->PaymentMethodAr : $pm->PaymentMethodEn }}
                                                        </strong>
                                                    </p>
                                                </div>
                                                @if($pm->ImageUrl !== "https://sa.myfatoorah.com/imgs/payment-methods/ap.png")
                                                <div style="display: none">
                                                    <div class="row">
                                                        <div class="col-12 pt-1">
                                                            <div class="form-group">
                                                                <label for="cardNumber">
                                                                    {{ Helpers::translate('cardNumber') }}
                                                                </label>
                                                                <input class="form-control mx-0 w-100" type="text" name="cardNumber" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 pt-1 text-center">
                                                            <div class="form-group">
                                                                <label for="expiryMonth">
                                                                    {{ Helpers::translate('expiryMonth') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 border-right border-left pt-1 text-center">
                                                            <div class="form-group">
                                                                <label for="expiryYear">
                                                                    {{ Helpers::translate('expiryYear') }}
                                                                </label>
                                                                <strong title="{{ Helpers::translate('(last two numbers, ex: 23 instead of 2023)') }}">
                                                                    <i class="fa fa-info" style="font-size: 14px"></i>
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 pt-1 text-center">
                                                            <div class="form-group">
                                                                <label for="securityCode" style="font-size: 12px">
                                                                    {{ Helpers::translate('securityCode') }}
                                                                </label>
                                                                <strong title="{{ Helpers::translate('((It consists of 3 numbers))') }}">
                                                                    <i class="fa fa-info" style="font-size: 14px"></i>
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group pt-1 text-center">
                                                                <input class="form-control mx-0 w-100" type="number" max="12" autocomplete="off" name="expiryMonth" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-4 border-right border-left pt-1 text-center">
                                                            <div class="form-group">
                                                                <input class="form-control mx-0 w-100" max="99" type="number" autocomplete="off" name="expiryYear" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group pt-1 text-center">
                                                                <input class="form-control mx-0 w-100" type="text" autocomplete="off" name="securityCode" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-0 m-0 w-100">
                                                        <button class="btn btn-success w-100" type="submit">{{ Helpers::translate('ok') }}</button>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                            @endif
                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'bank_transfer'))
                        @if(!$cod_not_show && count($config))
                        @foreach ($banks as $index=>$bank)
                            @if(($bank['status'] ?? null) && ($banks_[$index]['status']))
                            @php($banksCnt = $banksCnt + 1)
                            @endif
                        @endforeach
                        @if($banksCnt)
                            <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body p-0" style="height: max-content;">
                                        <form action="{{route('checkout-complete')}}" method="post" class="needs-validation d-grid text-center" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="bank_transfer">
                                            <div class="text-center py-5" onclick="$(this).next().slideToggle()">
                                                <img width="66.3"
                                                src="{{asset('public/assets/front-end/img/bank-transfer-icon.png')}}"/>
                                                <p>
                                                    <strong>
                                                        {{ Helpers::translate('bank_transfer') }}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div style="display: none">
                                                <div class="h-100 p-2">
                                                    @php($banks=\App\CPU\Helpers::get_user_paymment_methods(null,'bank_transfer'))
                                                    @php($item_index = 0)
                                                    @php($conf['environment'] = $conf['environment']??'sandbox')
                                                    @php($banks_=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'bank_transfer'))
                                                    @php($banksCnt = 0)
                                                        <div class="w-100 text-center p-3 rounded" style="background-color: #f2f2f2;">
                                                            <div class="form-group">
                                                                <select name="bank" id="bank" class="form-control"
                                                                onchange="$('._banks').hide();$('.'+$(this).val()+'_bank').show();"
                                                                >
                                                                @foreach ($banks as $index=>$bank)
                                                                        @if(($bank['status'] ?? null) && ($banks_[$index]['status']))
                                                                            <option value="{{$index}}">{{$bank['name']}}</option>
                                                                        @endif
                                                                @endforeach
                                                                </select>
                                                            </div>

                                                            @foreach ($banks as $index=>$conf)
                                                            @if(($conf['status'] ?? null) && ($banks_[$index]['status']))
                                                            <div class="_banks {{$index}}_bank" @if($index) style="display: none" @endif>
                                                                <div class="form-group">
                                                                    <label class="d-flex title-color h6">
                                                                        {{\App\CPU\Helpers::translate('Account owner name')}} :
                                                                        <br/>
                                                                        {{$conf['owner_name'] ?? ''}}
                                                                    </label>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="d-flex title-color h6">
                                                                        {{\App\CPU\Helpers::translate('Account number')}} : {{$conf['account_number'] ?? ''}}
                                                                    </label>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="d-flex title-color h6">
                                                                        {{\App\CPU\Helpers::translate('IBAN number')}} : {{$conf['iban'] ?? ''}}
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
                                                            <input class="form-control mx-0 w-100" type="file" accept=".docx,.pdf,.png,.jpg" name="attachment" placeholder="">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="holder_name">
                                                                {{ Helpers::translate('Account Holder Name') }}
                                                            </label>
                                                            <input class="form-control mx-0 w-100" type="text" name="holder_name" placeholder="">
                                                        </div>

                                                    @php($item_index++)
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                </div>
                                                <div class="p-0 m-0 w-100">
                                                    <button class="btn btn-success w-100" type="submit">Ok</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endif




                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'stripe'))
                            @if(($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <button class="btn btn-block click-if-alone d-block" type="button" id="checkout-button">
                                                {{-- <i class="czi-card"></i> {{\App\CPU\Helpers::translate('Credit / Debit card ( Stripe )')}} --}}
                                                <img width="150"
                                                src="{{asset('public/assets/front-end/img/stripe.png')}}"/>
                                                <p>
                                                    <strong>
                                                        {{ Helpers::translate('stripe') }}
                                                    </strong>
                                                 </p>
                                            </button>
                                            <script type="text/javascript">
                                                // Create an instance of the Stripe object with your publishable API key
                                                var stripe = Stripe('{{$config['published_key']}}');
                                                var checkoutButton = document.getElementById("checkout-button");
                                                checkoutButton.addEventListener("click", function () {
                                                    fetch("{{route('pay-stripe')}}", {
                                                        method: "GET",
                                                    }).then(function (response) {
                                                        console.log(response)
                                                        return response.text();
                                                    }).then(function (session) {
                                                        /*console.log(JSON.parse(session).id)*/
                                                        return stripe.redirectToCheckout({sessionId: JSON.parse(session).id});
                                                    }).then(function (result) {
                                                        if (result.error) {
                                                            alert(result.error.message);
                                                        }
                                                    }).catch(function (error) {
                                                        console.error("{{\App\CPU\Helpers::translate('Error')}}:", error);
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'razor_pay'))
                            @php($inr=\App\Model\Currency::where(['symbol'=>'₹'])->first())
                            @php($usd=\App\Model\Currency::where(['code'=>'USD'])->first())
                            @if(isset($inr) && isset($usd) && ($config['status'] ?? null))

                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <form action="{!!route('payment-razor')!!}" method="POST">
                                            @csrf
                                            <!-- Note that the amount is in paise = 50 INR -->
                                                <!--amount need to be in paisa-->
                                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                        data-bs-key="{{ \Illuminate\Support\Facades\Config::get('razor.razor_key') }}"
                                                        data-bs-amount="{{(round(\App\CPU\Convert::usdToinr($amount)))*100}}"
                                                        data-bs-buttontext="Pay {{(\App\CPU\Convert::usdToinr($amount))*100}} INR"
                                                        data-bs-name="{{\App\Model\BusinessSetting::where(['type'=>'company_name'])->first()->value}}"
                                                        data-bs-description=""
                                                        data-bs-image="{{asset('storage/app/public/company/'.\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)}}"
                                                        data-bs-prefill.name="{{auth('customer')->user()->f_name}}"
                                                        data-bs-prefill.email="{{auth('customer')->user()->email}}"
                                                        data-bs-theme.color="#ff7529">
                                                </script>
                                            </form>
                                            <button class="btn btn-block click-if-alone d-block" type="button"
                                                    onclick="$('.razorpay-payment-button').click()">
                                                <img width="150"
                                                src="{{asset('public/assets/front-end/img/razor.png')}}"/>
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

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paystack'))
                            @if(($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paystack'))
                                            @php($order=\App\Model\Order::find(session('order_id')))
                                            <form method="POST" action="{{ route('paystack-pay') }}" accept-charset="UTF-8"
                                                class="form-horizontal"
                                                role="form">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <input type="hidden" name="email"
                                                            value="{{auth('customer')->user()->email}}"> {{-- required --}}
                                                        <input type="hidden" name="orderID"
                                                            value="{{session('cart_group_id')}}">
                                                        <input type="hidden" name="amount"
                                                            value="{{\App\CPU\Convert::usdTozar($amount*100)}}"> {{-- required in kobo --}}

                                                        <input type="hidden" name="currency"
                                                            value="{{\App\CPU\Helpers::currency_code()}}">
                                                        <input type="hidden" name="metadata"
                                                            value="{{ json_encode($array = ['key_name' => 'value',]) }}"> {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                                        <input type="hidden" name="reference"
                                                            value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                                                        <p>
                                                            <button class="paystack-payment-button" style="display: none"
                                                                    type="submit"
                                                                    value="Pay Now!"></button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </form>
                                            <button class="btn btn-block click-if-alone d-block" type="button"
                                                    onclick="$('.paystack-payment-button').click()">
                                                <img width="100"
                                                    src="{{asset('public/assets/front-end/img/paystack.png')}}"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @php($myr=\App\Model\Currency::where(['code'=>'MYR'])->first())
                            @php($usd=\App\Model\Currency::where(['code'=>'usd'])->first())
                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'senang_pay'))
                            @if(isset($myr) && isset($usd) && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'senang_pay'))
                                            @php($user=auth('customer')->user())
                                            @php($secretkey = $config['secret_key'])
                                            @php($data = new \stdClass())
                                            @php($data->merchantId = $config['merchant_id'])
                                            @php($data->detail = 'payment')
                                            @php($data->order_id = session('cart_group_id'))
                                            @php($data->amount = \App\CPU\Convert::usdTomyr($amount))
                                            @php($data->name = $user->f_name.' '.$user->l_name)
                                            @php($data->email = $user->email)
                                            @php($data->phone = $user->phone)
                                            @php($data->hashed_string = md5($secretkey . urldecode($data->detail) . urldecode($data->amount) . urldecode($data->order_id)))

                                            <form name="order" method="post"
                                                action="https://{{env('APP_MODE')=='live'?'app.senangpay.my':'sandbox.senangpay.my'}}/payment/{{$config['merchant_id']}}">
                                                <input type="hidden" name="detail" value="{{$data->detail}}">
                                                <input type="hidden" name="amount" value="{{$data->amount}}">
                                                <input type="hidden" name="order_id" value="{{$data->order_id}}">
                                                <input type="hidden" name="name" value="{{$data->name}}">
                                                <input type="hidden" name="email" value="{{$data->email}}">
                                                <input type="hidden" name="phone" class="phoneInput" value="{{$data->phone}}">
                                                <input type="hidden" name="hash" value="{{$data->hashed_string}}">
                                            </form>

                                            <button class="btn btn-block click-if-alone d-block" type="button"
                                                    onclick="document.order.submit()">
                                                <img width="100"
                                                    src="{{asset('public/assets/front-end/img/senangpay.png')}}"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paymob_accept'))
                            @if(($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <form class="needs-validation d-grid text-center" method="POST" id="payment-form-paymob"
                                                action="{{route('paymob-credit')}}">
                                                {{ csrf_field() }}
                                                <button class="btn btn-block click-if-alone d-block" type="submit">
                                                    <img width="150"
                                                    src="{{asset('public/assets/front-end/img/paymob.png')}}"/>
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

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'bkash'))
                            @if(isset($config)  && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <button class="btn btn-block click-if-alone d-block" id="bKash_button"
                                                    onclick="BkashPayment()">
                                                <img width="100" src="{{asset('public/assets/front-end/img/bkash.png')}}"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paytabs'))
                            @if(isset($config)  && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <button class="btn btn-block click-if-alone d-block"
                                                    onclick="location.href='{{route('paytabs-payment')}}'"
                                                    style="margin-top: -11px">
                                                <img width="150"
                                                src="{{asset('public/assets/front-end/img/paytabs.png')}}"/>
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

                            {{--@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'fawry_pay'))
                            @if(isset($config)  && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <button class="btn btn-block" onclick="location.href='{{route('fawry')}}'" style="margin-top: -11px">
                                                <img width="150" src="{{asset('public/assets/front-end/img/fawry.svg')}}"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif--}}

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'mercadopago'))
                            @if(isset($config) && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <a class="btn btn-block click-if-alone d-block" href="{{route('mercadopago.index')}}">
                                                <img width="150"
                                                src="{{asset('public/assets/front-end/img/MercadoPago_(Horizontal).svg')}}"/>
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

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'flutterwave'))
                            @if(isset($config) && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body pt-2" style="height: 150px">
                                            <form method="POST" action="{{ route('flutterwave_pay') }}">
                                                {{ csrf_field() }}

                                                <button class="btn btn-block click-if-alone d-block" type="submit">
                                                    <img width="200"
                                                        src="{{asset('public/assets/front-end/img/fluterwave.png')}}"/>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paytm'))
                            @if(isset($config) && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <a class="btn btn-block click-if-alone d-block" href="{{route('paytm-payment')}}">
                                                <img style="max-width: 150px; margin-top: -10px"
                                                    src="{{asset('public/assets/front-end/img/paytm.png')}}"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'liqpay'))
                            @if(isset($config) && ($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <a class="btn btn-block click-if-alone d-block" href="{{route('liqpay-payment')}}">
                                                <img style="max-width: 150px; margin-top: 0px"
                                                    src="{{asset('public/assets/front-end/img/liqpay4.png')}}"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @endif

                    <div class="row">
                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'cash_on_delivery'))
                        @if(!$cod_not_show && ($config['status'] ?? null))
                            <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body" style="height: 150px">
                                        <form action="{{route('checkout-complete')}}" method="get" class="needs-validation d-grid text-center">
                                            <input type="hidden" name="payment_method" value="cash_on_delivery">
                                            <button class="btn btn-block click-if-alone d-block" type="submit">
                                                <img width="120" style="margin-top: -10px"
                                                     src="{{asset('public/assets/front-end/img/cod.png')}}"/>
                                                     <p>
                                                        <strong>
                                                            {{ Helpers::translate('cash_on_delivery') }}
                                                        </strong>
                                                     </p>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'delayed'))
                        @if(!$cod_not_show && ($config['status'] ?? null))
                            <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body" style="height: 150px">
                                        <form action="{{route('checkout-complete')}}" method="get" class="needs-validation d-grid text-center">
                                            <input type="hidden" name="payment_method" value="delayed">
                                            <button class="btn btn-block click-if-alone d-block" type="submit">
                                                <img width="70"
                                                src="{{asset('public/assets/front-end/img/delayed.jpg')}}"/>
                                                <p>
                                                    <strong>
                                                        {{ Helpers::translate('delayed payment') }}
                                                    </strong>
                                                </p>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if (($digital_payment['status'] ?? null)==1)
                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'customer_wallet')['wallet_status'])
                            @if($config==1)
                                <div class="col-md-4 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body d-grid text-center" style="height: 150px">
                                            <button class="btn btn-block click-if-alone d-block" type="submit" data-bs-toggle="modal" data-bs-target="#wallet_submit_button">

                                                <img width="50" style="margin-top: -10px" src="{{asset('public/assets/front-end/img/wallet.jpg')}}"/>
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
                                        <form action="{{route('offline-payment-checkout-complete')}}" method="get" class="needs-validation d-grid text-center">
                                            <span class="btn btn-block click-if-alone d-block"
                                                    data-bs-toggle="modal" data-bs-target="#offline_payment_submit_button">
                                                <img width="150" class="__mt-n-10" src="{{asset('public/assets/front-end/img/pay-offline.png')}}"/>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                        @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount)



                        @if (($digital_payment['status'] ?? null)==1)

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'ssl_commerz_payment'))
                            @if(($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <form action="{{ url('/pay-ssl') }}" method="POST" class="needs-validation d-grid text-center">
                                                <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                                                <button class="btn btn-block click-if-alone d-block" type="submit">
                                                    <img width="150" src="{{asset('public/assets/front-end/img/sslcomz.png')}}"/>
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
                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paypal'))
                            @if(($config['status'] ?? null))
                                <div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 150px">
                                            <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                                                action="{{route('pay-paypal')}}">
                                                {{ csrf_field() }}
                                                <button class="btn btn-block click-if-alone d-block" type="submit">
                                                    <img width="150"
                                                    src="{{asset('public/assets/front-end/img/paypal.png')}}"/>
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

                    <!-- Navigation (desktop)-->
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a class="btn btn-secondary btn-block" href="{{route('checkout-details')}}">
                                <span class="d-none d-sm-inline">{{\App\CPU\Helpers::translate('Back to Shipping')}}</span>
                                <span class="d-inline d-sm-none">{{\App\CPU\Helpers::translate('Back')}}</span>
                            </a>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
            </section>
            <!-- Sidebar-->
            @include('web-views.partials._order-summary')
        </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="wallet_submit_button" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{\App\CPU\Helpers::translate('wallet_payment')}}</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @php($customer_balance = auth('customer')->user()->wallet_balance)
        @php($remain_balance = $customer_balance - $amount)
        <form action="{{route('checkout-complete-wallet')}}" method="get" class="needs-validation d-grid text-center">
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
            <button type="submit" onclick="alert_wait()" class="btn btn--primary btn-primary" {{$remain_balance>0? '':'disabled'}}>{{\App\CPU\Helpers::translate('submit')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- offline payment modal -->
  <div class="modal fade" id="offline_payment_submit_button" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{Helpers::translate('offline_payment')}}</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('offline-payment-checkout-complete')}}" method="post" class="needs-validation d-grid text-center">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">{{Helpers::translate('payment_by')}}</label>
                        <input class="form-control" type="text" name="payment_by" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">{{Helpers::translate('transaction_ID')}}</label>
                        <input class="form-control" type="text" name="transaction_ref" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="">{{Helpers::translate('payment_note')}}</label>
                        <textarea name="payment_note" id="" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="offline_payment" name="payment_method">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{Helpers::translate('close')}}</button>
            <button type="submit" class="btn btn--primary">{{Helpers::translate('submit')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('script')

  @php($mode = App\CPU\Helpers::get_user_paymment_methods(null,'bkash')['environment']??'sandbox')
    @if($mode=='live')
        <script id="myScript"
                src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    @else
        <script id="myScript"
                src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    @endif

    <script>
        setTimeout(function () {
            $('.stripe-button-el').hide();
            $('.razorpay-payment-button').hide();
        }, 10)
    </script>

    <script type="text/javascript">
        function BkashPayment() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#loading').show();
            // get token
            $.ajax({
                url: "{{ route('bkash-get-token') }}",
                type: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    $('#loading').hide();
                    $('pay-with-bkash-button').trigger('click');
                    if (data.hasOwnProperty('msg')) {
                        showErrorMessage(data) // unknown error
                    }
                },
                error: function (err) {
                    $('#loading').hide();
                    showErrorMessage(err);
                }
            });
        }

        let paymentID = '';
        bKash.init({
            paymentMode: 'checkout',
            paymentRequest: {},
            createRequest: function (request) {
                setTimeout(function () {
                    createPayment(request);
                }, 2000)
            },
            executeRequestOnAuthorization: function (request) {
                $.ajax({
                    url: '{{ route('bkash-execute-payment') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "paymentID": paymentID
                    }),
                    success: function (data) {
                        if (data) {
                            if (data.paymentID != null) {
                                BkashSuccess(data);
                            } else {
                                showErrorMessage(data);
                                bKash.execute().onError();
                            }
                        } else {
                            $.get('{{ route('bkash-query-payment') }}', {
                                payment_info: {
                                    payment_id: paymentID
                                }
                            }, function (data) {
                                if (data.transactionStatus === 'Completed') {
                                    BkashSuccess(data);
                                } else {
                                    createPayment(request);
                                }
                            });
                        }
                    },
                    error: function (err) {
                        bKash.execute().onError();
                    }
                });
            },
            onClose: function () {
                // for error handle after close bKash Popup
            }
        });

        function createPayment(request) {
            // because of createRequest function finds amount from this request
            request['amount'] = "{{round(\App\CPU\Convert::usdTobdt($amount),2)}}"; // max two decimal points allowed
            $.ajax({
                url: '{{ route('bkash-create-payment') }}',
                data: JSON.stringify(request),
                type: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    $('#loading').hide();
                    if (data && data.paymentID != null) {
                        paymentID = data.paymentID;
                        bKash.create().onSuccess(data);
                    } else {
                        bKash.create().onError();
                    }
                },
                error: function (err) {
                    $('#loading').hide();
                    showErrorMessage(err.responseJSON);
                    bKash.create().onError();
                }
            });
        }

        function BkashSuccess(data) {
            $.post('{{ route('bkash-success') }}', {
                payment_info: data
            }, function (res) {
                @if(session()->has('payment_mode') && session('payment_mode') == 'app')
                    location.href = '{{ route('payment-success')}}';
                @else
                    location.href = '{{route('order-placed')}}';
                @endif
            });
        }

        function showErrorMessage(response) {
            let message = 'Unknown Error';
            if (response.hasOwnProperty('errorMessage')) {
                let errorCode = parseInt(response.errorCode);
                let bkashErrorCode = [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
                    2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
                    2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
                    2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
                    2063, 2064, 2065, 2066, 2067, 2068, 2069, 503,
                ];
                if (bkashErrorCode.includes(errorCode)) {
                    message = response.errorMessage
                }
            }
            Swal.fire("Payment Failed!", message, "error");
        }

        function click_if_alone() {
            let total = $('.checkout_details .click-if-alone').length;
            if (Number.parseInt(total) < 2) {
                $('.click-if-alone').click()
                $('.checkout_details').html('<h1>{{\App\CPU\Helpers::translate('Redirecting_to_the_payment')}}......</h1>');
            }
        }
        click_if_alone();

    </script>
@endpush
