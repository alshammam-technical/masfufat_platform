<html dir="rtl">
    <script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/bootstrap.min.css">
    <style>
        div[dir="rtl"] * div{
            text-align: right !important;
        }
        @media screen {
            #a-layout, #roll-layout{
                display: none;
            }
        }
        @media print {
            #a-layout:not(.print_me), #roll-layout:not(.print_me){
                display: none;
            }

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

            .d-print-none{
                display: none;
            }
        }
    </style>

    @php($customer = \App\User::find($order['customer_id']))
    @php($logo=\App\Model\BusinessSetting::where(['type'=>'company_admin_logo'])->first()->value)
    {{--  <div style="width:410px;">  --}}
        <div class="d-print-none w-full text-center mt-5">
            <button class="btn btn-primary" onclick="$('#a-layout').addClass('print_me');$('#roll-layout').removeClass('print_me');window.print()">
                {{ Helpers::translate('print an A4 copy') }}
            </button>
            <button class="btn btn-primary" onclick="$('#a-layout').removeClass('print_me');$('#roll-layout').addClass('print_me');window.print()">
                {{ Helpers::translate('print a roll copy') }}
            </button>
        </div>
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
                            @if (isset($shop))
                                <img class="d-inline navbar-brand-logo"
                                    onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                    src="{{asset("storage/app/public/dashboard/$logo")}}" alt="Logo" height="40">
                                <img class="d-inline navbar-brand-logo-mini"
                                    onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                    src="{{asset("storage/app/public/dashboard/$logo")}}"
                                    alt="Logo" height="40">

                            @else
                                <img class="d-inline navbar-brand-logo-mini"
                                    src="{{asset("storage/app/public/dashboard/$logo")}}"
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
                    <div class="row mb-3 cm-strong"> السجل التجاري: {{$customer->store_informations['commercial_registration_no'] ?? ''}} </div>
                    <div class="row mb-3 cm-strong"> الرقم الضريبي: {{$customer->store_informations['tax_no'] ?? ''}} </div>
                    <div class="row mb-3 cm-strong"> رقم الجوال: <span dir="ltr">{{$customer->store_informations['phone'] ?? $customer->phone ?? ''}}</span> </div>
                </div>
                <div class="col-3">
                    <div class="row cm-strong">
                        {!! DNS1D::getBarcodeHTML($order['id'], 'CODABAR') !!}
                    </div>
                </div>
                <div class="col-3">
                    <div class="row mb-3 cm-strong">
                        التاريخ: {{date('Y/m/d h:i a',strtotime($order['created_at']))}}
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

        <div>
            <div>
                @include('web-views.order-details-component',['colf'=>true])
            </div>
        </div>

        @if(isset(\App\CPU\Helpers::get_business_settings('warranty_policy')['show_in_invoice']))
        <div class="mt-5 pt-3 px-3 border-bottom border-dark" style="text-align: start">
            {!! \App\CPU\Helpers::get_business_settings('warranty_policy')[session()->get('local')] ?? '' !!}
        </div>
        @endif

        <div class="row">
            <div class="col-4 text-start">تاريخ التقرير : {{date('Y/m/d h:i a',strtotime($order['created_at']))}}</div>
            <div class="col-4 text-center"> 1 / 1 </div>
            <div class="col-4 text-end">طبع بواسطة : مدير النظام</div>
        </div>

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
                            src="{{asset("storage/app/public/dashboard/$logo")}}" />
                    @else
                        <img class="rounded productImg" width="64"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            src="{{asset("storage/app/public/dashboard/$logo")}}" />
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
                    <div class="row mt-2"><div class="col-12 cm-strong">تاريخ الفاتورة: {{date('Y/m/d h:i a',strtotime($order['created_at']))}} </div></div>
                    <div class="row mt-2"><div class="col-12 cm-strong">الموظف: {{ '10124' }} </div></div>
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

        <div>
            <div>
                @include('web-views.order-details-component',['small_table'=>1])
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
</html>
