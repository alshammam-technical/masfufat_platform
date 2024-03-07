    <div class="table-responsive pos-cart-table border">
        <table class="table table-align-middle">
            <thead class="text-capitalize bg-light">
                <tr>
                    <th class="border-0 min-w-120">{{\App\CPU\Helpers::translate('item')}}</th>
                    <th class="border-0">{{\App\CPU\Helpers::translate('qty')}}</th>
                    <th class="border-0">{{\App\CPU\Helpers::translate('price')}}</th>
                    <th class="border-0 text-center">{{\App\CPU\Helpers::translate('delete')}}</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $subtotal = 0;
                $addon_price = 0;
                $tax = 0;
                $discount = 0;
                $discount_type = 'amount';
                $discount_on_product = 0;
                $total_tax = 0;
                $ext_discount = 0;
                $ext_discount_type = 'amount';
                $coupon_discount =0;
            ?>
            @if(session()->has($cart_id) && count( session()->get($cart_id)) > 0)
                <?php
                    $cart = session()->get($cart_id);
                    if(isset($cart['tax']))
                    {
                        $tax = $cart['tax'];
                    }
                    if(isset($cart['discount']))
                    {
                        $discount = $cart['discount'];
                        $discount_type = $cart['discount_type'];
                    }
                    if (isset($cart['ext_discount'])) {
                        $ext_discount = $cart['ext_discount'];
                        $ext_discount_type = $cart['ext_discount_type'];
                    }
                    if(isset($cart['coupon_discount']))
                    {
                        $coupon_discount = $cart['coupon_discount'];
                    }
                ?>
                @foreach(session()->get($cart_id) as $key => $cartItem)
                @if(is_array($cartItem))
                    <?php

                    $product_subtotal = ($cartItem['price'])*$cartItem['quantity'];
                    $discount_on_product += ($cartItem['discount']*$cartItem['quantity']);
                    $subtotal += $product_subtotal;

                    //tax calculation
                    $product = \App\Model\Product::find($cartItem['id']);
                    $total_tax += \App\CPU\Helpers::tax_calculation($cartItem['price'], $product['tax'], $product['tax_type'])*$cartItem['quantity'];
                    $current_lang = session()->get('local');
                    ?>

                <tr>
                    <td>
                        <div class="media align-items-center gap-10">
                            <img class="avatar avatar-sm" src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                                    onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'" alt="{{$cartItem['name']}} image">
                            <div class="media-body">
                                <h5 class="text-hover-primary mb-0">{{Str::limit($cartItem['name'], 12)}}</h5>
                                <small>{{Str::limit($cartItem['variant'], 20)}}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="number" data-key="{{$key}}" class="form-control qty" value="{{$cartItem['quantity']}}" min="1" onkeyup="updateQuantity('{{$cartItem['id']}}',this.value,event,'{{$cartItem['variant']}}')">
                    </td>
                    <td>
                        <div>
                            {{\App\CPU\BackEndHelper::set_symbol(($product_subtotal))}}
                        </div> <!-- price-wrap .// -->
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:removeFromCart({{$key}})" class="btn btn-sm btn-outline-danger square-btn"> <i class="tio-delete"></i></a>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <?php
        $total = $subtotal;
        $discount_amount = $discount_on_product;
        $total -= $discount_amount;

        $extra_discount = $ext_discount;
        $extra_discount_type = $ext_discount_type;
        if($extra_discount_type == 'percent' && $extra_discount > 0){
            $extra_discount =  (($subtotal)*$extra_discount) / 100;
        }
        if($extra_discount) {
            $total -= $extra_discount;
        }

        $total_tax_amount= $total_tax;
    ?>
    <div class="pt-4">
        <dl>
            <div class="d-flex gap-2 justify-content-between">
                <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\Helpers::translate('sub_total')}} : </dt>
                <dd>{{\App\CPU\BackEndHelper::set_symbol(($subtotal))}}</dd>
            </div>

            <div class="d-flex gap-2 justify-content-between">
                <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\Helpers::translate('product discount')}} :</dt>
                <dd>{{\App\CPU\BackEndHelper::set_symbol((round($discount_amount,2))) }}</dd>
            </div>

            <div class="d-flex gap-2 justify-content-between">
                <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\Helpers::translate('extra discount')}} :</dt>
                <dd>
                    <button id="extra_discount" class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-discount">
                        <i class="tio-edit"></i></button>
                    {{\App\CPU\BackEndHelper::set_symbol(($extra_discount))}}
                </dd>
            </div>

            <div class="d-flex justify-content-between">
                <dt class="title-color gap-2 text-capitalize font-weight-normal">{{\App\CPU\Helpers::translate('coupon discount')}} :</dt>
                <dd>
                    <button id="coupon_discount" class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-coupon-discount">
                        <i class="tio-edit"></i>
                    </button>
                    {{\App\CPU\BackEndHelper::set_symbol(($coupon_discount))}}
                </dd>
            </div>

            <div class="d-flex gap-2 justify-content-between">
                <dt class="title-color text-capitalize font-weight-normal">{{\App\CPU\Helpers::translate('tax')}} : </dt>
                <dd>{{\App\CPU\BackEndHelper::set_symbol((round($total_tax_amount,2)))}}</dd>
            </div>

            <div class="d-flex gap-2 border-top justify-content-between pt-2">
                <dt class="title-color text-capitalize font-weight-bold title-color">{{\App\CPU\Helpers::translate('total')}} : </dt>
                <dd class="font-weight-bold title-color">{{\App\CPU\BackEndHelper::set_symbol((round($total+$total_tax_amount-$coupon_discount, 2)))}}</dd>
            </div>
        </dl>
        <form action="{{route('admin.pos.order')}}" id='order_place' method="post" >
            @csrf
            <div class="form-group col-12">
                <input type="hidden" class="form-control" name="amount" min="0" step="0.01"
                       value="{{($total+$total_tax_amount-$coupon_discount)}}"
                       readonly>
            </div>
            <div class="pt-4 mb-4">
                <div class="title-color d-flex mb-2">{{\App\CPU\Helpers::translate('Paid By')}}:</div>
                <ul class="list-unstyled option-buttons">

                    @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                    @if($config['status'])
                        <li>
                            <input type="radio" id="cash_on_delivery" value="cash_on_delivery" name="type" hidden checked>
                            <label for="cash_on_delivery" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('cash_on_delivery')}}</label>
                        </li>
                    @endif

                    @php($config=\App\CPU\Helpers::get_business_settings('delayed'))
                    @if($config['status'])
                        <li>
                            <input type="radio" id="delayed" value="delayed" name="type" hidden checked>
                            <label for="delayed" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('delayed')}}</label>
                        </li>
                    @endif

                    @php($config=\App\CPU\Helpers::get_business_settings('bank_transfer'))
                    @if(count($config))
                        <li>
                            <input type="radio" id="bank_transfer" value="bank_transfer" name="type" hidden checked>
                            <label for="bank_transfer" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('bank_transfer')}}</label>
                        </li>
                    @endif

                    @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                    @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount)
                    @php($digital_payment=\App\CPU\Helpers::get_business_settings('digital_payment'))

                    @if ($digital_payment['status']==1)
                        @php($config=\App\CPU\Helpers::get_business_settings('wallet_status'))
                        @if($config==1)
                            <li>
                                <input type="radio" id="wallet_status" value="wallet_status" name="type" hidden checked>
                                <label for="wallet_status" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('wallet_status')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('ssl_commerz_payment'))
                        @if($config['status'])
                            <li>
                                <input type="radio" id="ssl_commerz_payment" value="ssl_commerz_payment" name="type" hidden checked>
                                <label for="ssl_commerz_payment" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('ssl_commerz_payment')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
                        @if($config['status'])
                            <div class="col-md-6 mb-4" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body" style="height: 100px">
                                        <form class="needs-validation" method="POST" id="payment-form"
                                            action="{{route('pay-paypal')}}">
                                            {{ csrf_field() }}
                                            <button class="btn btn-block click-if-alone" type="submit">
                                                <img width="150"
                                                    src="{{asset('public/assets/front-end/img/paypal.png')}}"/>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <li>
                                <input type="radio" id="paypal" value="paypal" name="type" hidden checked>
                                <label for="paypal" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('paypal')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('myfatoorah'))
                        @if($config['status'])
                            <li>
                                <input type="radio" id="myfatoorah" value="myfatoorah" name="type" hidden checked>
                                <label for="myfatoorah" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('myfatoorah')}}</label>
                            </li>
                        @endif



                        @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                        @if($config['status'])
                            <li>
                                <input type="radio" id="stripe" value="stripe" name="type" hidden checked>
                                <label for="stripe" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('stripe')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('razor_pay'))
                        @php($inr=\App\Model\Currency::where(['symbol'=>'₹'])->first())
                        @php($usd=\App\Model\Currency::where(['code'=>'USD'])->first())
                        @if(isset($inr) && isset($usd) && $config['status'])
                            <li>
                                <input type="radio" id="razor_pay" value="razor_pay" name="type" hidden checked>
                                <label for="razor_pay" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('razor_pay')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('paystack'))
                        @if($config['status'])
                            <li>
                                <input type="radio" id="paystack" value="paystack" name="type" hidden checked>
                                <label for="paystack" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('paystack')}}</label>
                            </li>
                        @endif

                        @php($myr=\App\Model\Currency::where(['code'=>'MYR'])->first())
                        @php($usd=\App\Model\Currency::where(['code'=>'usd'])->first())
                        @php($config=\App\CPU\Helpers::get_business_settings('senang_pay'))
                        @if(isset($myr) && isset($usd) && $config['status'])
                            <li>
                                <input type="radio" id="senang_pay" value="senang_pay" name="type" hidden checked>
                                <label for="senang_pay" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('senang_pay')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('paymob_accept'))
                        @if($config['status'])
                            <li>
                                <input type="radio" id="paymob_accept" value="paymob_accept" name="type" hidden checked>
                                <label for="paymob_accept" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('paymob_accept')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('bkash'))
                        @if(isset($config)  && $config['status'])
                        <li>
                            <input type="radio" id="bkash" value="bkash" name="type" hidden checked>
                            <label for="bkash" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('bkash')}}</label>
                        </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('paytabs'))
                        @if(isset($config)  && $config['status'])
                            <li>
                                <input type="radio" id="paytabs" value="paytabs" name="type" hidden checked>
                                <label for="paytabs" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('paytabs')}}</label>
                            </li>
                        @endif

                        {{--@php($config=\App\CPU\Helpers::get_business_settings('fawry_pay'))
                        @if(isset($config)  && $config['status'])
                            <li>
                                <input type="radio" id="fawry_pay" value="fawry_pay" name="type" hidden checked>
                                <label for="fawry_pay" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('fawry_pay')}}</label>
                            </li>
                        @endif--}}

                        @php($config=\App\CPU\Helpers::get_business_settings('mercadopago'))
                        @if(isset($config) && $config['status'])
                            <li>
                                <input type="radio" id="mercadopago" value="mercadopago" name="type" hidden checked>
                                <label for="mercadopago" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('mercadopago')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('flutterwave'))
                        @if(isset($config) && $config['status'])
                            <li>
                                <input type="radio" id="flutterwave" value="flutterwave" name="type" hidden checked>
                                <label for="flutterwave" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('flutterwave')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('paytm'))
                        @if(isset($config) && $config['status'])
                            <li>
                                <input type="radio" id="paytm" value="paytm" name="type" hidden checked>
                                <label for="paytm" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('paytm')}}</label>
                            </li>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('liqpay'))
                        @if(isset($config) && $config['status'])
                            <li>
                                <input type="radio" id="liqpay" value="liqpay" name="type" hidden checked>
                                <label for="liqpay" class="btn btn--bordered btn--bordered-black px-4 mb-0">{{\App\CPU\Helpers::translate('liqpay')}}</label>
                            </li>
                        @endif
                    @endif

                </ul>
            </div>
            <div class="d-flex gap-2 justify-content-between align-items-center pt-3">
                <a href="#" class="btn btn-danger btn-block" onclick="emptyCart()">
                    <i class="fa fa-times-circle"></i>
                    {{\App\CPU\Helpers::translate('Cancel_Order')}}
                </a>
                <button id="submit_order" type="button" onclick="form_submit()"  class="btn btn--primary btn-primary btn-block m-0" data-toggle="modal" data-target="#paymentModal">
                    <i class="fa fa-shopping-bag"></i>
                    {{\App\CPU\Helpers::translate('Place_Order')}}
                </button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="add-discount" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('update_discount')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="title-color">{{\App\CPU\Helpers::translate('type')}}</label>
                        <select name="type" id="type_ext_dis" class="form-control">
                            <option value="amount" {{$discount_type=='amount'?'selected':''}}>{{\App\CPU\Helpers::translate('amount')}}</option>
                            <option value="percent" {{$discount_type=='percent'?'selected':''}}>{{\App\CPU\Helpers::translate('percent')}}(%)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="title-color">{{\App\CPU\Helpers::translate('discount')}}</label>
                        <input type="number" id="dis_amount" class="form-control" name="discount" placeholder="Ex: 500">
                    </div>
                    <div class="form-group">
                        <button class="btn btn--primary btn-primary" onclick="extra_discount();" type="submit">{{\App\CPU\Helpers::translate('submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-coupon-discount" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('coupon_discount')}}</h5>
                    <button id="coupon_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="title-color">{{\App\CPU\Helpers::translate('coupon_code')}}</label>
                        <input type="text" id="coupon_code" class="form-control" name="coupon_code" placeholder="SULTAN200">
                        {{-- <input type="hidden" id="user_id" name="user_id" > --}}
                    </div>

                    <div class="form-group">
                        <button class="btn btn--primary btn-primary" type="submit" onclick="coupon_discount();">{{\App\CPU\Helpers::translate('submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-tax" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('update_tax')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.pos.tax')}}" method="POST" class="row">
                        @csrf
                        <div class="form-group col-12">
                            <label for="">{{\App\CPU\Helpers::translate('tax')}} (%)</label>
                            <input type="number" class="form-control" name="tax" min="0">
                        </div>

                        <div class="form-group col-sm-12">
                            <button class="btn btn--primary btn-primary" type="submit">{{\App\CPU\Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="short-cut-keys" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('short_cut_keys')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>{{\App\CPU\Helpers::translate('to_click_order')}} : alt + O</span><br>
                    <span>{{\App\CPU\Helpers::translate('to_click_payment_submit')}} : alt + S</span><br>
                    <span>{{\App\CPU\Helpers::translate('to_close_payment_submit')}} : alt + Z</span><br>
                    <span>{{\App\CPU\Helpers::translate('to_click_cancel_cart_item_all')}} : alt + C</span><br>
                    <span>{{\App\CPU\Helpers::translate('to_click_add_new_customer')}} : alt + A</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_submit_add_new_customer_form')}} : alt + N</span><br>
                    <span>{{\App\CPU\Helpers::translate('to_click_short_cut_keys')}} : alt + K</span><br>
                    <span>{{\App\CPU\Helpers::translate('to_print_invoice')}} : alt + P</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_cancel_invoice')}} : alt + B</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_focus_search_input')}} : alt + Q</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_click_extra_discount')}} : alt + E</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_click_coupon_discount')}} : alt + D</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_click_clear_cart')}} : alt + X</span> <br>
                    <span>{{\App\CPU\Helpers::translate('to_click_new_order')}} : alt + R</span> <br>
                </div>
            </div>
        </div>
    </div>
@push('script_2')
<script>
    $('#type_ext_dis').on('change', function (){
        let type = $('#type_ext_dis').val();
        if(type === 'amount'){
            $('#dis_amount').attr('placeholder', 'Ex: 500');
        }else if(type === 'percent'){
            $('#dis_amount').attr('placeholder', 'Ex: 10%');
        }
    });
</script>
@endpush
