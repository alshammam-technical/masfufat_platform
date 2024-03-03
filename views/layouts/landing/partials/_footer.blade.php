<div id="footer1" class="footer bg-black mx-0 mb-0 px-5 pb-3" dir="{{session()->get('direction') ?? 'rtl'}}" style="position: absolute;z-index: 1034;/*margin-top: 40%;*/background-color: black;line-height: 50px;width: 100%;left: 0;">
    <div class="w-full text-start mt-2">
        <img src="{{asset("storage/app/public/company")."/".$web_config['shop_fav_icon_footer']->value}}" alt="" class="footer-logo my-3"
        onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'"
        style="width:137px" />
    </div>
    <div class="row pb-5" style="border-bottom: white solid">
        <div class="col-md-4 p-0">
            <div class="d-flex">
                @foreach (\App\Model\SocialMedia::where('active_status', 1)->get() as $item)
                <a class="rounded-circle wd-45 ht-45 text-center m-0 mx-2" href="{{$item->link}}"
                style="width: 45px;height: 45px">
                    <p class="h4 text-center mt-1">
                        <img class="rounded-circle wd-45 ht-45 text-center m-0 " width="50" src="{{asset('storage/app/public/social_logos')}}/{{$item->png}}" />
                    </p>
                </a>
                @endforeach
            </div>
            <div class="d-flex mt-4 flex-wrap">
                <a class="rounded-circle wd-45 ht-45 text-center m-0 mx-2 bg-white" href="{{$item->link}}"
                style="width: 45px;height: 45px">
                    <p class="h4 text-center mt-2">
                        <i class="fa fa-phone"></i>
                    </p>
                </a>
                <div class="col-md-3 p-0 pt-1 mx-0 text-start">
                    <strong style="font-size:24px" class="text-start text-white text-nowrap pe-2 mx-2">
                        {{\App\CPU\Helpers::translate('The Unified number')}}
                    </strong>
                </div>
                <div class="col-md-3 p-0 pt-2 mx-0 mt-0 text-start">
                    <strong class="text-start mt-1">
                        <a class="text-white pe-2" style="font-size:20px" href="tel:{{\App\CPU\Helpers::get_business_settings('company_phone')}}">{{\App\CPU\Helpers::get_business_settings('company_phone')}}</a>
                    </strong>
                </div>
            </div>
            {{--    --}}
            <div class="d-flex mt-4 flex-wrap">
                <a class="rounded-circle wd-45 ht-45 text-center m-0 mx-2 bg-white" href="{{$item->link}}"
                style="width: 45px;height: 45px">
                    <p class="h4 text-center mt-2">
                        <i class="fa fa-envelope"></i>
                    </p>
                </a>
                <div class="col-md-4 col-4 p-0 pt-1 mx-0 text-start">
                    <strong style="font-size:24px" class="text-start text-white text-nowrap pe-2 mx-2">
                        {{\App\CPU\Helpers::translate('Email')}}
                    </strong>
                </div>
                <div class="col-md-3 p-0 pt-2 mx-0 mt-0 text-start">
                    <strong class="text-start mt-1">
                        <a class="text-white pe-2" style="font-size:20px" href="mailto:{{\App\CPU\Helpers::get_business_settings('company_email')}}" class="text-secondary mx-2">{{\App\CPU\Helpers::get_business_settings('company_email')}}</a>
                    </strong>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <ul style="list-style-type: none;line-height: 50px" class="mt-0">
                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('terms')}}" class="text-light text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('Terms and Conditions')}}
                    </a>
                </li>

                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('privacy-policy')}}" class="text-light text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('privacy policy')}}
                    </a>
                </li>

                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('warranty-policy')}}" class="text-light text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('Warranty_Policy')}}
                    </a>
                </li>

                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('about-us')}}" class="text-light text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('About_Us')}}
                    </a>
                </li>

                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('helpTopic')}}" class="text-light text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('faq')}}
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-2 col-6">
            <ul style="list-style-type: none;line-height: 50px" class="mt-0">
                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('user-account')}}" class="text-white text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('My account')}}
                    </a>
                </li>
                @if((auth('customer')->check() || auth('delegatestore')->check()))
                @if (\App\CPU\Helpers::store_module_permission_check('my_account.support_ticket.view'))
                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{ route('account-tickets') }}" class="text-white text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('Technical support tickets')}}
                    </a>
                </li>
                @endif
                @else
                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{ route('account-tickets') }}" class="text-white text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('Technical support tickets')}}
                    </a>
                </li>
                @endif

                @if(\App\CPU\Helpers::get_business_settings('order_tracking_status'))
                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('track-order.index')}}" class="text-white text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('Order tracking')}}
                    </a>
                </li>
                @endif

                <li class="mb-2 text-light text-start h4 font-weight-bolder">
                    <a href="{{route('contacts')}}" class="text-white text-start h6 font-weight-bolder">
                        {{\App\CPU\Helpers::translate('Contact us')}}
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            @php($ios = \App\CPU\Helpers::get_business_settings('download_app_apple_stroe'))
            @php($android = \App\CPU\Helpers::get_business_settings('download_app_google_stroe'))
            @if($android['status'] || $ios['status'])
            <p class="h5 text-white w-full text-start mb-5">
                {{ Helpers::translate('Download the app now:') }}
            </p>
            <div class="row text-start px-0 mx-0">
                @if($ios['status'])
                <div class="col-4 px-0">
                    <a href="{{$ios['link']}}"><img src="{{asset('/public/assets/landing/img/appstore.png')}}" alt="" style="width:182px;"></a>
                </div>
                @endif

                @if($android['status'])
                <div class="col-4 px-0">
                    <a href="{{$android['link']}}"><img src="{{asset('/public/assets/landing/img/playstore.png')}}" alt="" style="width:182px;"></a>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-12 sm:px-2 px-0">
            <div class="ht-85p">
                <ul style="list-style-type: none" class="mt-2 ps-0 sm:ps-5">
                    <li class="sm:flex block px-0 text-secondary text-start h4 font-weight-bolder">
                        <p class="text-white text-start h5 mt-1 font-weight-bolder wd-150">
                            {{\App\CPU\Helpers::translate('Shipping options')}}
                        </p>
                        <div class="sm:px-3 d-flex flex-wrap">
                            @foreach (Helpers::get_business_settings('shipping_companies') as $sh)
                            @if($sh !== "None")
                            <img title="{{ Helpers::translate($sh) }}" class="mx-1 mb-2 footer-logos" src="{{asset('storage/app/public/landing/img/shipping/'.(Helpers::get_business_settings('shipping_company_img')[$sh] ?? null))}}" alt="" >
                            @endif
                            @endforeach
                        </div>
                    </li>

                    <li class="sm:flex block pb-0 pt-3 text-secondary text-start h4 font-weight-bolder">
                        <p class="text-white text-start h5 mt-1 font-weight-bolder wd-150">
                            {{\App\CPU\Helpers::translate('Payment options')}}
                        </p>
                        @php($digital_payment = \App\addonSetting::whereIn('settings_type', ['payment_config'])->where('is_active',1)->get())
                        <div class="sm:px-3 d-flex flex-wrap">
                            @foreach (Helpers::getMyFatoorahMethods(true) as $payment)
                            @php($additional_data = $payment['additional_data'] != null ? json_decode($payment['additional_data']) : [])
                            <img title="{{str_replace('_',' ',$payment->key_name)}}" class="mx-1 mb-2 footer-logos" src="{{asset('storage/app/public/payment_modules/gateway_image')}}/{{$additional_data != null ? ($additional_data->gateway_image ?? null) : ''}}" alt="" >
                            @endforeach


                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'cash_on_delivery'))
                            @if(($config['status'] ?? null))
                            @php($sh = Helpers::get_business_settings('payment_methods_img')['cod'] ?? null)
                            <img title="{{ Helpers::translate('cash on dellivery') }}" class="mx-2 mb-2 footer-logos" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" >
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'wallet_status'))
                            @if($config==1)
                            @php($sh = Helpers::get_business_settings('payment_methods_img')['wallet'] ?? null)
                            <img title="{{ Helpers::translate('customer_wallet') }}" class="mx-2 mb-2 footer-logos" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" >
                            @endif

                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'delayed'))
                            @if(($config['status'] ?? null))
                            @php($sh = Helpers::get_business_settings('payment_methods_img')['delayed'] ?? null)
                            <img title="{{ Helpers::translate('delayed') }}" class="mx-2 mb-2 footer-logos" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" >
                            @endif

                            @php($config=\App\CPU\Helpers::get_business_settings('bank_transfer'))
                            @if((count($config ?? []) ?? null))
                            @php($sh = Helpers::get_business_settings('payment_methods_img')['bank_transfer'] ?? null)
                            <img title="{{ Helpers::translate('bank_transfer') }}" class="mx-2 mb-2 footer-logos" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" >
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 text-start mt-10 d-flex">
            <img src="{{asset('/public/assets/landing/img/footer33.png')}}" alt="" class="mx-2" style="width: 41px;height: 53px;">
            <img src="{{asset('/public/assets/landing/img/footer34.png')}}" alt="" class="mx-2" style="width: 41px;height: 42px;">
            <strong class="text-white mx-3">{{Helpers::translate('tax_number')}}: 302255080100003</strong>
        </div>
    </div>
</div>

<!-- intlTelInput -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var inputs = $(".phoneInput");
        $(".phoneInput,input[type='number']").attr('inputmode','numeric')
        var iti = [];
        var phoneCountryCode;
        inputs.each(function(index){
            iti[index] = intlTelInput(this);
                phoneCountryCode = iti[index].getSelectedCountryData().dialCode;
            $(document).on("focus",".phoneInput",function(){
                phoneCountryCode = iti[index].getSelectedCountryData().dialCode;
            })
        })

        $(document).on("keydown",".phoneInput",function(){
            if($(this).val().length == ('+'+phoneCountryCode).length){
                $(this).val('+'+phoneCountryCode)
            }
        })

        $(document).on("keyup change",".phoneInput",function(e){
            var countryCode = '+'+phoneCountryCode;
            var value = $(this).val();
            var codeWithZero = countryCode + '0';
            if(value.startsWith(codeWithZero)){
                $(this).val(value.replace(codeWithZero,countryCode));
            }
            if(!value.startsWith(countryCode)){
                $(this).val(countryCode);
            }
            var isnum = /^\d+$/.test(value.replace('+',''))
            if(!isnum){
                $(this).val('+'+value.replace(/[^\d]/g, ""))
            }
        })

        var mini = true;

        function toggleSidebar(minii) {
            if (minii) {
                document.getElementById("mySidebar").style.zIndex = "1033";
                if($('body').width() >= 640){
                    document.getElementById("mySidebar").classList.add("sm:w-80");
                    document.getElementById("mySidebar").classList.remove('w-0')
                    document.getElementById("mySidebar").classList.remove('sm:w-20')
                    document.getElementById("mySidebar").classList.add('expanded');
                    if($("#download-app-section").length){
                        document.getElementById("download-app-section").style.display = "block";
                    }
                    @if((session('direction') ?? 'rtl') == 'ltr')
                    //document.getElementById("main").style.marginLeft = "250px";
                    @else
                    //document.getElementById("main").style.marginRight = "250px";
                    @endif
                }else{
                    document.getElementById("mySidebar").classList.add('w-full')
                    document.getElementById("mySidebar").classList.remove('w-0')
                    //document.getElementById("mySidebar").style.display = "block";
                }
                this.mini = false;
            } else {
                document.getElementById("mySidebar").style.zIndex = "1034";
                if($('body').width() >= 640){
                    document.getElementById("mySidebar").classList.add("sm:w-20");
                    document.getElementById("mySidebar").classList.remove("sm:w-80");
                    document.getElementById("mySidebar").classList.add('w-0')
                    document.getElementById("mySidebar").classList.remove('expanded');
                    if($("#download-app-section").length){
                        document.getElementById("download-app-section").style.display = "none";
                    }
                    @if((session('direction') ?? 'rtl') == 'ltr')
                    //document.getElementById("main").style.marginLeft = "85px";
                    @else
                    //document.getElementById("main").style.marginRight = "85px";
                    @endif
                }else{
                    document.getElementById("mySidebar").classList.remove('w-full')
                    document.getElementById("mySidebar").classList.add('w-0')
                    //document.getElementById("mySidebar").style.display = "none";
                }
                this.mini = true;
            }
        }

    </script>


