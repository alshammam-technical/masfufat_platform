@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Shipping Address Choose'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ asset('public/assets/front-end/css/bootstrap-select.min.css') }}">
    {{--  <script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>  --}}


    <style>
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

        #location_map_canvas {
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
            #location_map_canvas {
                height: 200px;
            }
        }

        .address-item.selected .card{
            border: solid thin {{ Helpers::get_business_settings('colors')['primary'] }};
        }
    </style>
@endpush

@section('content')
@php($billing_input_by_customer=\App\CPU\Helpers::get_business_settings('billing_input_by_customer'))
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <section class="col-lg-12 col-md-12">
                <div class="card box-shadow-sm">
                    <div class="card-body bg-light">
                        <div class="row">
                            <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                                <div class="col-sm-4">
                                    <h1 class="h3  mb-0 folot-left headerTitle">
                                        {{\App\CPU\Helpers::translate('choose_shipping_address')}}</h1>
                                </div>
                                <div class="mt-2 col-sm-4" style="text-align: end">
                                    <button type="submit" class="btn btn--primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        id="add_new_address">{{\App\CPU\Helpers::translate('add_new_address')}}
                                    </button>
                                </div>
                            </div>
                            @if(request('shipping_method_id'))
                            @php(session()->put('address_id',request('shipping_method_id')))
                            @php(session()->put('billing_address_id',request('shipping_method_id')))
                            @endif
                            @php($default_location=\App\CPU\Helpers::get_business_settings('default_location'))
                            @if($physical_product_view)
                            @php($shipping_addresses=\App\Model\ShippingAddress::where('customer_id',auth('customer')->id())->where('is_billing',0)->get())
                            <form method="get" action="" id="address-form" class="row">
                                @php($permanented = 0)
                                @foreach($shipping_addresses as $shippingAddress)
                                    @if($shippingAddress['address_type'] !== 'permanent' && !$permanented)
                                        @php($shipping_addresses[0]['address_type'] = 'permanent')
                                    @else
                                        @php($permanented = 1)
                                    @endif
                                @endforeach
                                @foreach($shipping_addresses as $shippingAddress)
                                @php($address = $shippingAddress)
                                <section
                                    class="col-lg-6 col-md-6 mb-4 mt-5 address-item @if(request('shipping_method_id')) {{session('address_id') == $address['id'] ? 'selected' : ''}} @else {{$address['address_type']=='permanent'?'selected':''}} @endif"
                                    onclick="$('.address-item').removeClass('selected');$(this).addClass('selected');$(this).find('.shipping_method_id').prop('checked', true);$(this).find('.shipping_method_id').change();$(this).closest('form').submit()">
                                    <div class="card" style="text-transform: capitalize;">
                                        <input type="radio" name="shipping_method_id" id="sh-{{$address['id']}}"
                                            value="{{$address['id']}}" @if(request('shipping_method_id'))
                                            {{($address['address_type']=='permanent'?'checked':'')}} @else
                                            {{session('address_id') == $address['id'] ? 'checked' : ''}} @endif
                                            class="shipping_method_id" />
                                        <span class="checkmark d-none" style="margin-left: 10px"></span>


                                        <div class="card-body mt-3"
                                            style="padding: {{Session::get('direction') === "rtl" ? '0 13px 15px 15px' : '0 15px 15px 13px'}};">

                                            <div class="d-flex justify-content-between" style="padding: 5px;">
                                                <div>
                                                    <span class="fw-bold">
                                                        {{$shippingAddress->title ?? $shippingAddress->address_type }}
                                                    </span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <a class="bg-black ps-1 rounded wd-25 ht-25" title="Edit Address"
                                                        id="edit" href="{{route('address-edit',$shippingAddress->id)}}">
                                                        <i class="ri-pencil-fill text-white fa-md"></i>
                                                    </a>

                                                    <a class="ps-1 pt-1 rounded wd-25 ht-25" title="Delete Address"
                                                        href="{{ route('address-delete',['id'=>$shippingAddress->id])}}"
                                                        onclick="return confirm('{{\App\CPU\Helpers::translate('Are you sure you want to Delete')}}?');"
                                                        id="delete">
                                                        <i class="ri-delete-bin-5-fill text-danger fa-lg"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <label for="person_name" class="col-6">
                                                    <strong>
                                                        {{\App\CPU\Helpers::translate('contact_person_name')}}:
                                                    </strong>
                                                </label>
                                                <div class="col-6 text-end form-control border-0 py-0">
                                                    {{$shippingAddress->contact_person_name}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <label for="person_name" class="col-6">
                                                    <strong>
                                                        {{ \App\CPU\Helpers::translate('The receiving person mobile number')}}:
                                                    </strong>
                                                </label>
                                                <div class="col-6 text-end form-control border-0 py-0" dir="ltr">
                                                    {{$shippingAddress->phone}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Country')}}:
                                                </strong>
                                                <div class="col-6 text-end form-control border-0 py-0">
                                                    <select name="country" disabled id="" data-bs-live-search="true"
                                                        required
                                                        style="color: black;border: none;text-align-last: end;border: none;background-blend-mode: hue;width: 95px;float: left;text-align-last:end;height:32px;margin-top:-10px" class="p-0 form-control bg-white">
                                                        <option></option>
                                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                                        <option @if($country->code == $shippingAddress->country)
                                                            selected @endif value="{{ $country->code }}"
                                                            icon="{{ $country->photo }}">
                                                            {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Governorate')}}:
                                                </strong>
                                                <div class="col-6 text-end form-control border-0 py-0">
                                                    <select disabled name="area_id" id="area_id{{$shippingAddress->id}}"
                                                        data-bs-live-search="true" required
                                                        style="color: black;border: none;text-align-last: end;border: none;background-blend-mode: hue;width: 95px;float: left;text-align-last:end;height:32px;margin-top:-10px" class="p-0 form-control bg-white"></select>
                                                    <span class="text-warning area_id"
                                                        id="area_id_loading{{$shippingAddress->id}}">{{ Helpers::translate('Please wait') }}</span>
                                                    <input type="hidden" id="area_id_hidden"
                                                        value="{{$shippingAddress->area_id ?? '0'}}">
                                                </div>
                                            </div>
                                            <script>
                                                $('#area_id{{$shippingAddress->id}}').attr('disabled',1);$('#area_id{{$shippingAddress->id}}_loading').show();$.get('{{route('get-shipping-areas')}}?code={{$shippingAddress->country}}').then(d=>{$('#area_id{{$shippingAddress->id}}').html(d);$('#area_id{{$shippingAddress->id}}_loading').hide();$('#area_id{{$shippingAddress->id}}').find('option[value={{$shippingAddress->area_id}}]').attr("selected","selected");$("#area_id_loading{{$shippingAddress->id}}").hide()})
                                            </script>


                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{\App\CPU\Helpers::translate('zip_code')}}:
                                                </strong>
                                                <div class="col-6 text-end form-control border-0 py-0">
                                                    {{$shippingAddress->zip}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Street - neighborhood')}}:
                                                </strong>
                                                <div class="col-6 text-end form-control border-0 py-0">
                                                    {{$shippingAddress->address}}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </section>
                                @endforeach
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

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
                    <div class="row w-100 mx-0">
                        @php($digital_payment=\App\CPU\Helpers::get_user_paymment_methods(null,'digital_payment'))
                        @php($myfatoorahS=\App\CPU\Helpers::get_user_paymment_methods(null,'myfatoorah'))
                        @if (($digital_payment['status'] ?? null)==1)
                        @if(($myfatoorahS['status'] ?? null) == "1")
                        @foreach ($myFatoorahMethods as $pm)
                        @if($pm->ImageUrl == "https://sa.myfatoorah.com/imgs/payment-methods/ap.png" && !$mac_device)
                        @else
                        <div class="col-md-4 mb-4" style="cursor: pointer">
                            <div class="card">
                                <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                                    action="{{route('pay-myfatoorah',['paymentMethodId' => $pm->PaymentMethodId])}}">
                                    <div class="card-body" style="height: auto">
                                        {{ csrf_field() }}
                                        <div class="btn btn-block click-if-alone d-block"
                                            onclick="$(this).next().slideToggle()">
                                            <img width="80" src="{{ $pm->ImageUrl }}" />
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
                                                        <input class="form-control mx-0 w-100" type="text"
                                                            name="cardNumber" placeholder="">
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
                                                        <strong
                                                            title="{{ Helpers::translate('(last two numbers, ex: 23 instead of 2023)') }}">
                                                            <i class="fa fa-info" style="font-size: 14px"></i>
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div class="col-4 pt-1 text-center">
                                                    <div class="form-group">
                                                        <label for="securityCode" style="font-size: 12px">
                                                            {{ Helpers::translate('securityCode') }}
                                                        </label>
                                                        <strong
                                                            title="{{ Helpers::translate('((It consists of 3 numbers))') }}">
                                                            <i class="fa fa-info" style="font-size: 14px"></i>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group pt-1 text-center">
                                                        <input class="form-control mx-0 w-100" type="number" max="12"
                                                            autocomplete="off" name="expiryMonth" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-4 border-right border-left pt-1 text-center">
                                                    <div class="form-group">
                                                        <input class="form-control mx-0 w-100" max="99" type="number"
                                                            autocomplete="off" name="expiryYear" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group pt-1 text-center">
                                                        <input class="form-control mx-0 w-100" type="text"
                                                            autocomplete="off" name="securityCode" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-0 m-0 w-100">
                                                <button class="btn btn-success w-100"
                                                    type="submit">{{ Helpers::translate('ok') }}</button>
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
                        @php($banks=\App\CPU\Helpers::get_user_paymment_methods(null,'bank_transfer'))
                        @php($banks_=\App\CPU\Helpers::get_user_paymment_methods(auth('customer')->id(),'bank_transfer'))
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
                                    <form action="{{route('checkout-complete')}}" method="post"
                                        class="needs-validation d-grid text-center" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="bank_transfer">
                                        <div class="text-center py-5" onclick="$(this).next().slideToggle()">
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
                                                @php($banks=\App\CPU\Helpers::get_user_paymment_methods(null,'bank_transfer'))
                                                @php($banks_=\App\CPU\Helpers::get_user_paymment_methods(auth('customer')->id(),'bank_transfer'))
                                                @php($item_index = 0)
                                                @php($conf['environment'] = $conf['environment']??'sandbox')
                                                <div class="w-100 text-center p-3 rounded"
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
                                                    <input class="form-control mx-0 w-100" type="file"
                                                        accept=".docx,.pdf,.png,.jpg" name="attachment" placeholder="">
                                                </div>

                                                <div class="form-group">
                                                    <label for="holder_name">
                                                        {{ Helpers::translate('Account Holder Name') }}
                                                    </label>
                                                    <input class="form-control mx-0 w-100" type="text"
                                                        name="holder_name" placeholder="">
                                                </div>
                                                @php($item_index++)
                                                @php($config['environment'] = $config['environment']??'sandbox')
                                                <div class="p-0 m-0 w-100">
                                                    <button class="btn btn-success w-100" type="submit">Ok</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif




                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'stripe'))
                        @if(($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block click-if-alone d-block" type="button"
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

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'razor_pay'))
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

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paystack'))
                        @if(($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paystack'))
                                    @php($order=\App\Model\Order::find(session('order_id')))
                                    <form method="POST" action="{{ route('paystack-pay') }}" accept-charset="UTF-8"
                                        class="form-horizontal" role="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2">
                                                <input type="hidden" name="email"
                                                    value="{{auth('customer')->user()->email}}"> {{-- required --}}
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
                                    <button class="btn btn-block click-if-alone d-block" type="button"
                                        onclick="$('.paystack-payment-button').click()">
                                        <img width="100" src="{{asset('public/assets/front-end/img/paystack.png')}}" />
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
                                <div class="card-body" style="height: 175px">
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
                                    @php($data->hashed_string = md5($secretkey . urldecode($data->detail) .
                                    urldecode($data->amount) . urldecode($data->order_id)))

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
                                        <img width="100" src="{{asset('public/assets/front-end/img/senangpay.png')}}" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paymob_accept'))
                        @if(($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <form class="needs-validation d-grid text-center" method="POST"
                                        id="payment-form-paymob" action="{{route('paymob-credit')}}">
                                        {{ csrf_field() }}
                                        <button class="btn btn-block click-if-alone d-block" type="submit">
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

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'bkash'))
                        @if(isset($config) && ($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block click-if-alone d-block" id="bKash_button"
                                        onclick="BkashPayment()">
                                        <img width="100" src="{{asset('public/assets/front-end/img/bkash.png')}}" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paytabs'))
                        @if(isset($config) && ($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block click-if-alone d-block"
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

                        {{--@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'fawry_pay'))
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

        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'mercadopago'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <a class="btn btn-block click-if-alone d-block" href="{{route('mercadopago.index')}}">
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

        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'flutterwave'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body pt-2" style="height: 175px">
                    <form method="POST" action="{{ route('flutterwave_pay') }}">
                        {{ csrf_field() }}

                        <button class="btn btn-block click-if-alone d-block" type="submit">
                            <img width="200" src="{{asset('public/assets/front-end/img/fluterwave.png')}}" />
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
                <div class="card-body" style="height: 175px">
                    <a class="btn btn-block click-if-alone d-block" href="{{route('paytm-payment')}}">
                        <img style="max-width: 175px; margin-top: -10px"
                            src="{{asset('public/assets/front-end/img/paytm.png')}}" />
                    </a>
                </div>
            </div>
        </div>
        @endif

        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'liqpay'))
        @if(isset($config) && ($config['status'] ?? null))
        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <a class="btn btn-block click-if-alone d-block" href="{{route('liqpay-payment')}}">
                        <img style="max-width: 175px; margin-top: 0px"
                            src="{{asset('public/assets/front-end/img/liqpay4.png')}}" />
                    </a>
                </div>
            </div>
        </div>
        @endif
        {{--  </div>  --}}
        @endif

        {{--  <div class="row w-100 mx-0">  --}}
        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'cash_on_delivery'))
        @if(!$cod_not_show && ($config['status'] ?? null))
        <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer" onclick="$(this).find('.ok-b').slideToggle()">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <form action="{{route('checkout-complete')}}" method="get"
                        class="needs-validation d-grid text-center">
                        <input type="hidden" name="payment_method" value="cash_on_delivery">
                        <div class="btn btn-block click-if-alone d-block">
                            <img width="120" style="margin-top: -10px"
                                src="{{asset('public/assets/front-end/img/cod.png')}}" />
                            <p>
                                <strong>
                                    {{ Helpers::translate('cash_on_delivery') }}
                                </strong>
                            </p>
                        </div>
                        <div class="p-0 m-0 w-100 ok-b" style="display: none">
                            <button class="btn btn-success w-100" type="submit">Ok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'delayed'))
        @if(!$cod_not_show && ($config['status'] ?? null))
        <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer" onclick="$(this).find('.ok-b').slideToggle()">
            <div class="card">
                <div class="card-body" style="height: 175px">
                    <form action="{{route('checkout-complete')}}" method="get"
                        class="needs-validation d-grid text-center">
                        <input type="hidden" name="payment_method" value="delayed">
                        <div class="btn btn-block click-if-alone d-block">
                            <img width="70" src="{{asset('public/assets/front-end/img/delayed.jpg')}}" />
                            <p>
                                <strong>
                                    {{ Helpers::translate('delayed payment') }}
                                </strong>
                            </p>
                        </div>
                        <div class="p-0 m-0 w-100 ok-b" style="display: none">
                            <button class="btn btn-success w-100" type="submit">Ok</button>
                        </div>
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
                <div class="card-body d-grid text-center" style="height: 175px">
                    <button class="btn btn-block click-if-alone d-block" type="submit" data-bs-toggle="modal"
                        data-bs-target="#wallet_submit_button">

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
                        <span class="btn btn-block click-if-alone d-block" data-bs-toggle="modal"
                            data-bs-target="#offline_payment_submit_button">
                            <img width="150" class="__mt-n-10"
                                src="{{asset('public/assets/front-end/img/pay-offline.png')}}" />
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
                <div class="card-body" style="height: 175px">
                    <form action="{{ url('/pay-ssl') }}" method="POST" class="needs-validation d-grid text-center">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <button class="btn btn-block click-if-alone d-block" type="submit">
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
            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paypal'))
            @if(($config['status'] ?? null))
            <div class="col-md-6 mb-4" style="cursor: pointer">
                <div class="card">
                    <div class="card-body" style="height: 175px">
                        <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                            action="{{route('pay-paypal')}}">
                            {{ csrf_field() }}
                            <button class="btn btn-block click-if-alone d-block" type="submit">
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

    <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document" style="margin-top: 100px">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12"><h5 class="modal-title font-name ">{{\App\CPU\Helpers::translate('add_new_address')}}</h5></div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{route('address-store')}}" method="post">
                        @csrf
                        @php($store = auth('customer')->user()->store_informations)
                        <!-- Tab panes -->
                        <div class="form-row mb-1">
                            <div class="form-group col-md-6">
                                <label for="person_name">{{\App\CPU\Helpers::translate('address name')}}</label>
                                <input class="form-control" type="text" id="title"
                                    name="title"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="person_name">{{\App\CPU\Helpers::translate('contact_person_name')}}</label>
                                <input class="form-control" type="text" id="person_name"
                                    value="{{ $store['company_name'] }}"
                                    name="name"
                                    required>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('The receiving person mobile number')}}
                                <span
                                style="color: red">*</span></label>
                                <div class="form-group  w-100 col-lg-12">
                                    <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{ $store['phone'] ?? '+966'}}" />
                                </div>
                            </div>
                            <div class="col-mh-6"></div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Country')}}
                                        <span
                                            style="color: red">*</span></label>
                                    <select name="country" id="" class="form-control SumoSelect-custom" data-bs-live-search="true" required
                                    onchange="$('#area_id').attr('disabled',1);$('#area_id_loading').show();$.get('{{route('get-shipping-areas')}}?code='+$(this).val()).then(d=>{$('#area_id,.area_id').html(d);$('#area_id,.area_id').removeAttr('disabled');$('#area_id_loading').hide();$('#area_id').SumoSelect().sumo.reload()})">
                                        <option></option>
                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                            <option @if($store['country'] == $country['id']) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Governorate')}}
                                        <span style="color: red">*</span></label>
                                    <select name="area_id" id="area_id" class="form-control SumoSelect-custom" data-bs-live-search="true" required></select>
                                    <span class="text-warning" id="area_id_loading" style="display: none;">{{ Helpers::translate('Please wait') }}</span>
                                    <input type="hidden" id="area_id_hidden" >
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="zip_code">{{\App\CPU\Helpers::translate('zip_code')}}</label>
                                @if($zip_restrict_status)
                                    <select name="zip" class="form-control selectpicker" data-bs-live-search="true" id="" required>
                                        @foreach($delivery_zipcodes ?? [] as $zip)
                                            <option value="{{ $zip->zipcode }}" >{{ $zip->zipcode }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input class="form-control" type="number" id="zip_code" name="zip" required>
                                @endif
                            </div>
                            <div class="col-md-6">

                            </div>

                            <div class="form-group col-lg-6">
                                <label
                                    for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Street - neighborhood')}}<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="address"
                                          type="text"
                                          name="address" required></textarea>
                            </div>

                        </div>
                        @if(1==2)
                        <div class="form-row mb-1">
                            <div class="form-group col-md-12">
                                <label for="own_address">{{\App\CPU\Helpers::translate('address')}}</label>
                                <textarea class="form-control" id="address"
                                    type="text"  name="address" required>{{$shippingAddress->address}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input id="pac-input" class="controls rounded" style="height: 3em;width:fit-content;" title="{{\App\CPU\Helpers::translate('search_your_location_here')}}" type="text" placeholder="{{\App\CPU\Helpers::translate('search_here')}}"/>
                                <div style="height: 200px;" id="location_map_canvas"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                            <button type="submit" class="btn btn--primary text-light">{{\App\CPU\Helpers::translate('Add')}}</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="wallet_submit_button" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{\App\CPU\Helpers::translate('wallet_payment')}}</h5>
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
@endsection

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
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
    <script>
        function initAutocomplete() {
            var myLatLng = {
                lat: {{$default_location?$default_location['lat']:'-33.8688'}},
                lng: {{$default_location?$default_location['lng']:'151.2195'}}
            };

            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: {
                    lat: {{$default_location?$default_location['lat']:'-33.8688'}},
                    lng: {{$default_location?$default_location['lng']:'151.2195'}}
                },
                zoom: 13,
                mapTypeId: "roadmap",
                streetViewControl:false,
            });

            //
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });
            addYourLocationButton(map, marker);
            //

            marker.setMap(map);
            var geocoder = geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                var coordinates = JSON.parse(coordinates);
                var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                marker.setPosition(latlng);
                map.panTo(latlng);

                document.getElementById('latitude').value = coordinates['lat'];
                document.getElementById('longitude').value = coordinates['lng'];

                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById('address').value = results[1].formatted_address;
                            console.log(results[1].formatted_address);
                        }
                    }
                });
            });

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var mrkr = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    google.maps.event.addListener(mrkr, "click", function (event) {
                        document.getElementById('latitude').value = this.position.lat();
                        document.getElementById('longitude').value = this.position.lng();

                    });

                    markers.push(mrkr);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        };
        $(document).on('ready', function () {
            initAutocomplete();

        });

        $(document).on("keydown", "input", function (e) {
            if (e.which == 13) e.preventDefault();
        });
    </script>

    <script>
        function initAutocompleteBilling() {
            var myLatLng = {
                lat: {{$default_location?$default_location['lat']:'-33.8688'}},
                lng: {{$default_location?$default_location['lng']:'151.2195'}}
            };

            const map = new google.maps.Map(document.getElementById("location_map_canvas_billing"), {
                center: {
                    lat: {{$default_location?$default_location['lat']:'-33.8688'}},
                    lng: {{$default_location?$default_location['lng']:'151.2195'}}
                },
                zoom: 13,
                mapTypeId: "roadmap",
                streetViewControl:false,
            });

            //
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });
            addYourLocationButton(map, marker);
            //

            marker.setMap(map);
            var geocoder = geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                var coordinates = JSON.parse(coordinates);
                var latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);
                marker.setPosition(latlng);
                map.panTo(latlng);

                document.getElementById('billing_latitude').value = coordinates['lat'];
                document.getElementById('billing_longitude').value = coordinates['lng'];

                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById('billing_address').value = results[1].formatted_address;
                            console.log(results[1].formatted_address);
                        }
                    }
                });
            });

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input-billing");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var mrkr = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    google.maps.event.addListener(mrkr, "click", function (event) {
                        document.getElementById('billing_latitude').value = this.position.lat();
                        document.getElementById('billing_longitude').value = this.position.lng();

                    });

                    markers.push(mrkr);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        };
        $(document).on('ready', function () {
            initAutocompleteBilling();

        });

        $(document).on("keydown", "input", function (e) {
            if (e.which == 13) e.preventDefault();
        });
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
@endpush
