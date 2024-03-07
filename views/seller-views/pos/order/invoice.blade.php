<style>
    @media print {
        body{
            background-color: #fff !important;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #677788;
            border-collapse: collapse;
        }

        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: .0625rem solid rgba(231, 234, 243, .7)
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: .125rem solid rgba(231, 234, 243, .7)
        }

        .table tbody + tbody {
            border-top: .125rem solid rgba(231, 234, 243, .7)
        }

        .table-sm td, .table-sm th {
            padding: .3rem
        }

        .table-bordered {
            border: .0625rem solid rgba(231, 234, 243, .7)
        }

        .table-bordered td, .table-bordered th {
            border: .0625rem solid rgba(231, 234, 243, .7)
        }

        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: .125rem
        }
        .text-left {
            text-align: left !important;
        }
        .text-right {
            text-align: right !important;
        }
    }
</style>

@php($customer = \App\User::find($order['customer_id']))
{{--  <div style="width:410px;">  --}}
<div style="width:100%" class="bg-white" id="a-layout" style="display: none">
    <div class="mb-3 border border-dark p-2 bg-white" style="border-radius: 11px">
        <div class="row">
            <div class="col-4" dir="rtl">
                <div class="row">
                    <div class="col-12 cm-strong">
                        {{ \App\Model\BusinessSetting::where('type','company_name')->first()->value ?? '' }}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 cm-strong">
                        {{ \App\CPU\Helpers::get_business_settings('shop_address') ?? '' }}
                    </div>
                </div>
                <div class="row mt-2"><div class="col-12 cm-strong">الرقم الموحد: {{ \App\Model\BusinessSetting::where('type','company_phone')->first()->value ?? '' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">البريد الالكتروني: {{ \App\Model\BusinessSetting::where('type','company_email')->first()->value ?? '' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">رقم السجل التجاري: {{ \App\Model\BusinessSetting::where('type','company_commercial_register')->first()->value ?? '' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">الرقم الضريبي: {{ \App\Model\BusinessSetting::where('type','company_tax_no')->first()->value ?? '' }} </div></div>
            </div>

            <div class="col-4">
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        @php($shop=\App\Model\Shop::where(['seller_id'=>$order['sellder_id']])->first())
                        @if (isset($shop))
                            <img class="navbar-brand-logo"
                                onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                src="{{asset("storage/app/public/shop/$shop->image")}}" alt="Logo" height="40">
                            <img class="navbar-brand-logo-mini"
                                onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                src="{{asset("storage/app/public/shop/$shop->image")}}"
                                alt="Logo" height="40">

                        @else
                            <img class="navbar-brand-logo-mini"
                                src="{{asset('public/assets/back-end/img/160x160/img1.jpg')}}"
                                alt="Logo" height="40">
                        @endif
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <h2>
                            فاتورة ضريبية مبسطة
                        </h2>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <h2>
                            Simple Tax Invoice
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-4" dir="ltr">
                <div class="row">
                    <div class="col-12 cm-strong">
                        {{ \App\Model\BusinessSetting::where('type','company_name_en')->first()->value ?? '' }}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 cm-strong">
                        {{ \App\Model\BusinessSetting::where('type','shop_address_en')->first()->value ?? '' }}
                    </div>
                </div>
                <div class="row mt-2"><div class="col-12 cm-strong">Unified No: {{ \App\Model\BusinessSetting::where('type','company_phone')->first()->value ?? '' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">Email: {{ \App\Model\BusinessSetting::where('type','company_email')->first()->value ?? '' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">CRN: {{ \App\Model\BusinessSetting::where('type','company_commercial_register')->first()->value ?? '' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">Tax No. {{ \App\Model\BusinessSetting::where('type','company_tax_no')->first()->value ?? '' }} </div></div>
            </div>
        </div>
    </div>

    <div class="mb-3 border border-dark p-2 bg-white">
        <div class="row px-3">
            <div class="col-3">
                <div class="row mb-3 cm-strong">
                    رقم الفاتورة: {{$order['id']}}
                </div>
                <div class="row mb-3 cm-strong"> نوع الفاتورة: {{$order['payment_method']}} </div>
                <div class="row mb-3 cm-strong"> اسم العميل: {{$customer['name'] ?? ''}} </div>
                <div class="row mb-3 cm-strong"> رقم الجوال: <span dir="ltr">{{$customer->store_informations['phone'] ?? $customer->phone ?? ''}}</span> </div>
            </div>
            <div class="col-3">
                <div class="row cm-strong">
                    {!! DNS1D::getBarcodeHTML($order['id'], 'CODABAR') !!}
                </div>
            </div>
            <div class="col-3">
                <div class="row mb-3 cm-strong">
                    التاريخ: {{date('d/M/Y h:i a',strtotime($order['created_at']))}} ق.ظ
                </div>
                <div class="row mb-3 cm-strong">
                    المخزن: 2
                </div>
                <div class="row mb-3 cm-strong">
                    المندوب: 2
                </div>
                <div class="row mb-3 mt-6 cm-strong">
                    رقم بوليصة الشحن: 57500003
                </div>
                <div class="row mb-3 cm-strong">
                    {!! DNS1D::getBarcodeHTML(57500003, 'CODABAR') !!}
                </div>
            </div>
            <div class="col-3" dir="ltr">
                <div class="row mb-3 cm-strong">
                    {!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE') !!}
                </div>
            </div>
        </div>

    </div>

    <table class="table table-bordered mt-3 text-left bg-white" style="width: 100%!important">
        <thead class="bg-light">
        <tr>
            <th class="border border-dark text-center">م</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Product Image')}}</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Product number')}}</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Product name')}}</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('QTY')}}</th>
            <th class="border border-dark text-center">ك.المجانية</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Price')}}</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Value added tax')}}</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('The price includes tax')}}</th>
            <th class="border border-dark text-center">{{\App\CPU\Helpers::translate('Total inclusive of VAT')}}</th>
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
        @php($total_qty=0)
        @php($local = session()->get('local'))
        @foreach($order->details as $key=>$detail)
            @if($detail->product)

                <tr>
                    <td class="border border-dark text-center">{{ $key }}</td>
                    <td class="border border-dark text-center">
                        <img class="rounded productImg" width="64"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($detail->product['images'])->$local)) ? json_decode($detail->product['images'])->$local[0] ?? '' : ''}}">
                    </td>
                    <td class="border border-dark text-center justify-content-center">
                        {{ $detail->product['code'] }}
                        <center>
                            {!! DNS1D::getBarcodeHTML($detail->product['code'], 'CODABAR') !!}
                        </center>
                    </td>
                    <td class="border border-dark text-center">
                        {{ \App\CPU\Helpers::getItemName('products','name',$detail->product['id'] )}}
                    </td>
                    <td class="border border-dark text-center" style="width: 80px">
                        @php($total_qty += $detail['qty'])
                        {{$detail['qty']}}
                    </td>
                    <td class="border border-dark text-center"></td>

                    <td class="border border-dark text-center">
                        @php($amount=($detail['price']*$detail['qty'])-$detail['discount'])
                        @php($product_price = $detail['price']*$detail['qty'])
                        {{ $product_price }}
                    </td>
                    <td class="border border-dark text-center">
                        @php($total_tax+=$detail['tax'])
                        {{$total_tax}}
                    </td>
                    <td class="border border-dark text-center">
                        @php($total_product_price+=$product_price)
                        {{$product_price + $total_tax}}
                    </td>
                    <td class="border border-dark text-center">
                        {{$product_price + $total_tax}}
                    </td>
                </tr>
                @php($sub_total+=$amount)

                <tr>
                    <td class="text-center">
                    </td>
                    <td class="text-center">
                    </td>
                    <td class="text-center justify-content-center">

                    </td>
                    <td class="text-center">
                    </td>
                    <td class="border border-dark text-center" style="width: 80px">
                        {{$total_qty}}
                    </td>
                    <td class="border border-dark text-center"></td>

                    <td class="text-center">
                    </td>
                    <td class="text-center">
                    </td>
                    <td class="text-center">
                    </td>
                    <td class="text-center">
                    </td>
                </tr>

                @endif
                @endforeach
                <tr>
                    <td class="border-0 text-center"></td>
                    <td class="border-0 text-center"></td>
                    <td class="border-0 text-center justify-content-center"></td>
                    <td class="border-0 text-center"></td>
                    <td class="border-0 border border-dark text-center" colspan="2" style="width: 80px"></td>
                    <td class="border-0 text-center"></td>
                    <td class="border-0 text-center"></td>
                    <td class="border-0 text-center"></td>
                    <td class="border-0 text-center"></td>
                </tr>
        </tbody>
    </table>

    <div class="row border-bottom border-dark mb-5">
        <div class="col-4"></div>
        <div class="col-4"></div>

        <div class="col-4">
            <div class="row">
                الإجمالي قبل الخصم: {{ $order['order_amount'] }}
            </div>
            <div class="row">
                الخصم: {{ $order['discount_amount'] }}
            </div>
            <div class="row">الإجمالي غير شامل ضريبة القيمة المضافة: {{ '' }}</div>
            <div class="row">الاعباء: {{ '' }}</div>
            <div class="row">ضريبة القيمة المضافة 15%: {{ '' }}</div>
            <div class="row">المجموع شامل الضريبة المضافة: {{ '' }}</div>
            <div class="row"> {{ \App\CPU\Helpers::numberToWord(123.15) }} </div>
        </div>
    </div>

    @if(isset(\App\CPU\Helpers::get_business_settings('warranty_policy')['show_in_invoice']))
    <div class="mt-5 pt-3 px-3 border-bottom border-dark">
        {!! \App\CPU\Helpers::get_business_settings('warranty_policy')[session()->get('local')] ?? '' !!}
    </div>
    @endif

    <div class="row">
        <div class="col-4 text-start">تاريخ التقرير : {{date('d/M/Y h:i a',strtotime($order['created_at']))}} ب.ظ.</div>
        <div class="col-4 text-center"> 1 / 1 </div>
        <div class="col-4 text-end">طبع بواسطة : مدير النظام</div>
    </div>

</div>
<div style="width:410px" class="bg-white" id="roll-layout">
    <div class="mb-3 border border-dark p-2 bg-white" style="border-radius: 11px">
        <div class="row mb-5 mt-1">
            <div class="col-12 text-center">
                @php($shop=\App\Model\Shop::where(['seller_id'=>$order['sellder_id']])->first())
                @if (isset($shop))
                    <img class="rounded productImg" width="64"
                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset("storage/app/public/shop/$shop->image")}}" />
                @else
                    <img class="rounded productImg" width="64"
                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset('public/assets/back-end/img/160x160/img1.jpg')}}" />
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12" dir="rtl">
                <div class="row">
                    <div class="col-12 cm-strong">
                        شركة الشمم التجارية - {{ $customer->name ?? '' }}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 cm-strong">
                        المملكة العربية السعودية
                    </div>
                </div>
                <div class="row mt-2"><div class="col-12 cm-strong">المدينة المنورة</div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">الرقم الموحد: {{$customer->phone ?? ''}} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">البريد الالكتروني: {{$customer->email ?? ''}} </div></div>
                @isset($customer->store_informations['tax_no'])
                <div class="row mt-2"><div class="col-12 cm-strong">الرقم الضريبي: {{$customer->store_informations['tax_no'] ?? ''}} </div></div>
                @endisset
                <div class="row mt-2"><div class="col-12 cm-strong">رقم السجل التجاري: {{$customer->commercial_registration_no ?? ''}} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">رقم الفاتورة: {{$order['id']}} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">تاريخ الفاتورة: {{date('d/M/Y h:i a',strtotime($order['created_at']))}} ق.ظ </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">الموظف: {{ '10124' }} </div></div>
                <div class="row mt-2"><div class="col-12 cm-strong">المخزن: {{ '2' }} </div></div>
            </div>
        </div>
    </div>

    <div class="mb-3 border border-dark p-2 bg-white">
        <div class="row px-3">
            <div class="col-12">
                <div class="row mb-3 cm-strong">
                    <div class="col-6">
                        رقم العميل: {{$order->customer_id}}
                    </div>
                    <div class="col-6">
                        رقم الجوال: <span dir="ltr">{{$customer->store_informations['phone'] ?? $customer['phone'] ?? ''}}</span>
                    </div>
                </div>
                <div class="row mb-3 cm-strong">
                    <div class="col-12">
                        {{$customer['name'] ?? ''}}
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <h2>
                            فاتورة ضريبية مبسطة
                        </h2>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <h2>
                            Simple Tax Invoice
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row cm-strong" style="place-content: center">
                    {!! DNS1D::getBarcodeHTML($order['id'], 'CODABAR') !!}
                </div>
            </div>
            <div class="col-12">
                <div class="row cm-strong" style="place-content: center">
                    {{$order['id']}}
                </div>
            </div>
        </div>

    </div>

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
        @php($total_qty=0)
        @php($local = session()->get('local'))
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
                        @php($amount=($detail['price']*$detail['qty'])-$detail['discount'])
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

                            {!! DNS1D::getBarcodeHTML($detail->product['code'], 'CODABAR') !!}
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

    <div class="row mb-5 px-3" style="border-bottom: black dashed thin">
        <div class="col-4">
            <div class="row">الكمية: {{ $total_qty }}</div>
            <div class="row">ك مجانية: {{ '0' }}</div>
            <div class="row">إجمالي الكمية: {{ $total_qty }}</div>
        </div>
        <div class="col-8">
            <div class="row">الإجمالي قبل الضر يبة: {{ '' }}</div>
            <div class="row">
                الخصم: {{ $order['discount_amount'] }}
            </div>
            <div class="row">الاعباء: {{ '' }}</div>
            <div class="row">ضريبة القيمة المضافة 15%: {{ '' }}</div>
            <div class="row">المجموع شامل الضريبة المضافة: {{ '' }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <center>
                {!! DNS2D::getBarcodeHTML('4445645656', 'QRCODE') !!}
            </center>
        </div>
    </div>

    @if(isset(\App\CPU\Helpers::get_business_settings('warranty_policy')['show_in_invoice']))
    <div class="row">
        <div class="col-12">
            <center>
                {!! \App\CPU\Helpers::get_business_settings('warranty_policy')[session()->get('local')] ?? '' !!}
            </center>
        </div>
    </div>
    @endif
</div>
