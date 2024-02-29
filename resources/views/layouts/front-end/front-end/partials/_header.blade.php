<style>

    @font-face{
        font-family:"tajawal";
        src:url("{{asset('public/fonts/Tajawal-Regular.ttf')}}")
    }

    *{
        font-family:"tajawal"
    }

    body{
        background-color: white;
    }

    .card-body.search-result-box {
        overflow: scroll;
        height: 400px;
        overflow-x: hidden;
    }

    .active .seller {
        font-weight: 700;
    }

    .for-count-value {
        position: absolute;

        right: 0.6875rem;;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        color: {{$web_config['primary_color']}};

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    .count-value {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        color: {{$web_config['primary_color']}};

        font-size: .75rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.25rem;
    }

    @media (min-width: 992px) {
        .navbar-sticky.navbar-stuck .navbar-stuck-menu.show {
            display: block;
            height: 55px !important;
        }
    }

    @media (min-width: 768px) {
        .navbar-stuck-menu {
            background-color: {{$web_config['primary_color']}};
            line-height: 15px;
            padding-bottom: 6px;
        }

    }

    @media (max-width: 767px) {
        .search_button {
            background-color: transparent !important;
        }

        .search_button .input-group-text i {
            color: {{$web_config['primary_color']}}                              !important;
        }

        .navbar-expand-md .dropdown-menu > .dropdown > .dropdown-toggle {
            position: relative;
            padding- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 1.95rem;
        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}}                              !important;
        }
    }

    @media (max-width: 768px) {
        .tab-logo {
            width: 10rem;
        }
    }

    @media (max-width: 360px) {
        .mobile-head {
            padding: 3px;
        }
    }

    @media (max-width: 471px) {
        .navbar-brand img {

        }

        .mega-nav1 {
            background: white;
            color: {{$web_config['primary_color']}}                              !important;
            border-radius: 3px;
        }

        .mega-nav1 .nav-link {
            color: {{$web_config['primary_color']}} !important;
        }
    }
    #anouncement {
        width: 100%;
        padding: 2px 0;
        text-align: center;
        color:white;
    }
</style>




<header class="box-shadow-sm rtl bg-white text-dark">
    <!-- Topbar-->



    @php($announcement=\App\CPU\Helpers::get_business_settings('announcement'))
    <div class="navbar-sticky sm:bg-white mobile-head rounded-0 @if (isset($announcement) && $announcement['status']==1) pt-3 @else pt-3 @endif pb-2">
        {{--  exp notify  --}}
        @if ((auth('customer')->check() || auth('delegatestore')->check()) && session('exp_notify_days'))
            @php($msg_text = Helpers::get_business_settings('exp_notify_text'))
            @isset($user)
            @else
            @php($user=auth('customer')->user())
            @endisset
            @php($msg_text = str_replace('{NAME}',$user->name,$msg_text))
            @php($msg_text = str_replace('{remaining_days}', Helpers::customer_exp_days(auth('customer')->id()),$msg_text))
            @php($msg_text = str_replace('{DATE}', auth('customer')->user()->subscription_end,$msg_text))
            <div id="exp_notify_days" class="absolute top-0 start-0 w-full d-flex justify-content-between align-items-center" style="z-index:10000;background-color: {{ Helpers::get_business_settings('exp_notify_bg') }};color:{{Helpers::get_business_settings('exp_notify_color')}};height:40px">
                <strong class="d-flex justify-content-between align-items-center w-full">
                    <a href="{{route('subscriptions')}}" style="text-align:center; font-size: 15px;width:100%;background-color: {{ Helpers::get_business_settings('exp_notify_bg') }};color:{{Helpers::get_business_settings('exp_notify_color')}}!important;">{{ $msg_text }} </a>
                </strong>
            </div>
            <div id="exp_notify_days" class="top-0 start-0 w-full d-flex justify-content-between align-items-center" style="z-index:10000;height:40px">
                <strong class="d-flex justify-content-between align-items-center w-full">
                </strong>
            </div>
        @endif
        {{--  exp notify end  --}}
        <div class="navbar navbar-expand-md px-0" style="background-color: inherit">
            <div class="flex-nowrap sm:flex-wrap sm:ms-[4%] w-full header56" style="background-color: inherit;">
                <div class="container flex-nowrap sm:flex-wrap ps-0">
                    <div class="d-flex sm:w-44 w-1/3">
                        <button class="btn btn-primary d-lg-none py-0 pe-1 ps-1 active:bg-primaryColor w-50" onclick="toggleSidebar(mini)">
                            <i>
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25.334 9.33301H6.66732" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M25.334 16H12.0007" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M25.334 22.667H17.334" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </i>
                        </button>

                        <div class="lg:w-50 navbar-brand-wrapper justify-content-between side-logo px-0 pt-0 sm:me-2 sm:bg-primaryColor bg-white">
                            <!-- Logo -->
                            @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'shop_header_icon'])->first()->value)
                            <a href="{{route('home')}}" aria-label="Front" class="d-block w-16 sm:w-28 sm:h-auto h-full">
                                <img
                                    style="height: 100%"
                                    onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'"
                                    class="navbar-brand-logo-mini for-web-logo wd-200 m-0 mt-0"
                                    src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'shop_header_icon'])->pluck('value')[0]}}"
                                    alt="Logo">
                            </a>
                        </div>
                    </div>

                    <div style="flex-wrap:  nowrap" class="hidden sm:flex">
                        @php($currency_model = \App\CPU\Helpers::get_business_settings('currency_model'))
                        @if($currency_model=='multi_currency')
                            <div class="text-center topbar-text dropdown disable-autohide pt-3 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-4' : 'mr-4'}}"
                            style="width: 100px;height:61px;background-color: #f1f1f1;border-radius: 11px"
                            >
                                <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown"
                                >
                                    <span>{{session('currency_code')}} {{session('currency_symbol')}}</span>
                                </a>
                                <ul class="bg-white dropdown-menu dropdown-menu-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}"
                                    style="min-width: 160px!important;text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                    @foreach (\App\Model\Currency::where('status', 1)->get() as $key => $currency)
                                        <li style="cursor: pointer" class="dropdown-item text-dark"
                                            onclick="currency_change('{{$currency['code']}}')">
                                            {{ $currency->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @php( $local = \App\CPU\Helpers::default_lang())
                        <div
                            class="topbar-text dropdown disable-autohide  text-capitalize pt-3 text-center"
                            style="width: 120px;height:61px;background-color: #f1f1f1;border-radius: 11px">
                            <a class="topbar-link" href="#" data-toggle="dropdown">
                                @foreach(json_decode($language['value'],true) as $data)
                                    @if($data['code']==$local)
                                        <div class="flex">
                                            <img class="col-3 px-0 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}"  src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png" style="height: fit-content">
                                            <p class="col-6">
                                                {{$data['name']}}
                                            </p>
                                            <div class="col-2">
                                                <i class="dropdown-toggle"></i>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </a>
                            <ul class="bg-white dropdown-menu dropdown-menu-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}"
                                style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                @foreach(json_decode($language['value'],true) as $key =>$data)
                                    @if($data['status']==1)
                                        <li onclick="alert_wait()">
                                            <a class="dropdown-item pb-1" href="{{route('lang',[$data['code']])}}">
                                                <img class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"
                                                    width="20"
                                                    src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png"
                                                    alt="{{$data['name']}}"/>
                                                <span style="text-transform: capitalize">{{$data['name']}}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>


                    <!-- Search-->
                    <div class="input-group-overlay d-none d-md-block mx-4"
                        style="width: 58rem;height: 61px;text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}">
                        <form action="{{route('products')}}" type="submit" class="search_form with-transitions border-0 w-full" style="background-color: #f1f1f1;border-radius: 15px">
                            <input class="form-control appended-form-control search-bar-input with-transitions w-full bg-transparent border-0 text-center placeholder-black" type="text"
                                autocomplete="off"
                                placeholder="{{\App\CPU\Helpers::translate('search')}}"
                                name="name"
                                style="height: 61px;color: black">
                            <button class="input-group-append-overlay search_button bg-transparent" type="submit"
                                    style="background-color: white;border-radius: {{(Session::get('direction') ?? 'rtl') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 7px 7px 0px; left: unset; right: 0'}};top:0;border:none">
                                    <span class="input-group-text" style="font-size: 20px;">
                                        <i class="ri-search-2-line font-size-xl" style="color: black"></i>
                                    </span>
                            </button>
                            <input name="data_from" value="search" hidden>
                            <input name="page" value="1" hidden>
                            <div class="card search-card"
                                style="position: absolute;background: white;z-index: 999;width: max-content;display: none">
                                <div class="card-body search-result-box"
                                    style="overflow:scroll; height:400px;overflow-x: hidden"></div>
                            </div>
                        </form>
                    </div>
                    <!-- Toolbar-->
                    <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center w-2/2 sm:ms-2.5 gap-x-3">


                        @if((auth('customer')->check() || auth('delegatestore')->check()))
                        <div class="flex navbar-tool dropdown no-b-icon sm:me-3 me-0 sm:ms-0 ms-2 w-14 justify-end">
                            <a class="navbar-tool-icon-box dropdown-toggle pt-0 sm:w-16 sm:h-16 w-10 h-10" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <div class="navbar-tool-icon-box w-full h-100 pt-0 inline-grid">
                                        <i class="z-10 text-center align-content-center inline-flex px-1 pt-0 justify-center" style="margin-top: 5px;">
                                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M20.59 22C20.59 18.13 16.74 15 12 15C7.26 15 3.41 18.13 3.41 22" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </i>
                                        @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
                                        @php($user = \App\User::find($storeId))
                                        <span class="bg-inherit h-[28px]" style="margin-top: -11px;">{{ $user->store_informations['vendor_account_number'] ?? ''}}</span>

                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-top: 0px !important">
                                @if (\App\CPU\Helpers::store_module_permission_check('my_account.data.view'))
                                <a class="dropdown-item"
                                   href="{{route('user-account')}}"> {{ \App\CPU\Helpers::translate('my_profile')}}</a>
                                   <div class="dropdown-divider"></div>
                                   @endif
                                <a class="dropdown-item"
                                   href="{{route('customer.auth.logout')}}">{{ \App\CPU\Helpers::translate('logout')}}</a>
                            </div>
                        </div>

                        @if (\App\CPU\Helpers::store_module_permission_check('my_account.my_wallet.view'))
                            <div class="navbar-tool dropdown mr-0 hidden sm:flex">

                                <a href="{{ route('wallet') }}" class="navbar-tool-icon-box dropdown-toggle pt-0 sm:w-16 sm:h-16 w-10 h-10">
                                    <div class="w-full h-100 sm:pt-2 pt-0">
                                            <i class="ri-wallet-line font-size-xl"></i>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @else
                            <div class="flex navbar-tool dropdown no-b-icon">
                                <a class="navbar-tool-icon-box dropdown-toggle sm:w-16 sm:h-16" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                    <div class="navbar-tool-icon-box w-full h-100 pt-1">
                                            <i class="text-center align-content-center inline-flex p-1">
                                                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M20.59 22C20.59 18.13 16.74 15 12 15C7.26 15 3.41 18.13 3.41 22" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}" aria-labelledby="dropdownMenuButton"
                                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                    <a class="dropdown-item" href="{{route('customer.auth.login')}}">
                                        <i class="ri-user-add-fill {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i> {{\App\CPU\Helpers::translate('sing_in')}}
                                    </a>
                                    <a class="dropdown-item" href="{{route('customer.auth.register')}}">
                                        <i class="fa fa-user-circle {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>{{\App\CPU\Helpers::translate('sing_up')}}
                                    </a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{route('seller.auth.login')}}">
                                        <i class="ri-user-add-fill {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i> {{\App\CPU\Helpers::translate('Seller login')}}
                                    </a>
                                    <a class="dropdown-item" href="{{route('shop.apply')}}">
                                        <i class="fa fa-user-circle {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>{{\App\CPU\Helpers::translate('Become a Seller')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('store.home.show_notifications'))
                        <div class="flex navbar-tool dropdown {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-0' : 'ml-0'}}">
                            <a href="{{ route('notifications') }}" class="navbar-tool-icon-box dropdown-toggle pt-2 sm:w-16 sm:h-16 w-10 h-10">
                                <span class="navbar-tool-label text-light" style="background-color: #fd0505 !important;    font-weight: bold;">
                                    <span class="countNotifications">
                                        @auth('customer')
                                        {{ Helpers::get_customer_notifications() }}
                                        @endauth
                                        @auth('delegatestore')
                                        {{ Helpers::get_customer_notifications() }}
                                        @endauth
                                    </span>
                            </span>
                            <div class="w-full h-100 sm:pt-2 pt-0">
                                <i class="text-center align-content-center inline-flex p-0 sm:pt-2 pt-0">
                                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.0206 2.91016C8.71058 2.91016 6.02058 5.60016 6.02058 8.91016V11.8002C6.02058 12.4102 5.76058 13.3402 5.45058 13.8602L4.30058 15.7702C3.59058 16.9502 4.08058 18.2602 5.38058 18.7002C9.69058 20.1402 14.3406 20.1402 18.6506 18.7002C19.8606 18.3002 20.3906 16.8702 19.7306 15.7702L18.5806 13.8602C18.2806 13.3402 18.0206 12.4102 18.0206 11.8002V8.91016C18.0206 5.61016 15.3206 2.91016 12.0206 2.91016Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                            <path d="M13.8699 3.20043C13.5599 3.11043 13.2399 3.04043 12.9099 3.00043C11.9499 2.88043 11.0299 2.95043 10.1699 3.20043C10.4599 2.46043 11.1799 1.94043 12.0199 1.94043C12.8599 1.94043 13.5799 2.46043 13.8699 3.20043Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15.0195 19.0596C15.0195 20.7096 13.6695 22.0596 12.0195 22.0596C11.1995 22.0596 10.4395 21.7196 9.89953 21.1796C9.35953 20.6396 9.01953 19.8796 9.01953 19.0596" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"/>
                                        </svg>
                                </i>
                            </div>
                            </a>
                        </div>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('my_account.wish_list.view'))
                        <div class="flex navbar-tool dropdown {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-0' : 'ml-0'}}">
                            <a class="navbar-tool-icon-box dropdown-toggle pt-2 sm:w-16 sm:h-16 w-10 h-10" href="{{route('wishlists')}}">
                                <span class="navbar-tool-label text-light">
                                    <span
                                        class="countWishlist" style="color: #000 !important;    font-weight: bold;">{{\App\Model\Wishlist::whereHas('wishlistProduct',function($q){
                                            return $q;
                                        })->where('customer_id', auth('customer')->id() ?? auth('delegatestore')->id())->count()}}</span>
                            </span>
                            <div class="w-full h-100 sm:pt-2 pt-0">
                                <i class="text-center align-content-center inline-flex p-0 sm:pt-2 pt-0">
                                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.62 20.8096C12.28 20.9296 11.72 20.9296 11.38 20.8096C8.48 19.8196 2 15.6896 2 8.68961C2 5.59961 4.49 3.09961 7.56 3.09961C9.38 3.09961 10.99 3.97961 12 5.33961C13.01 3.97961 14.63 3.09961 16.44 3.09961C19.51 3.09961 22 5.59961 22 8.68961C22 15.6896 15.52 19.8196 12.62 20.8096Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                </i>
                            </div>
                            </a>
                        </div>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('store.home.show_cart'))
                        <div class="flex sm:hidden navbar-tool {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-0' : 'ml-0'}}">
                            <a href="{{ route('shop-cart') }}" class="navbar-tool-icon-box dropdown-toggle pt-2 sm:w-16 sm:h-16 w-10 h-10" style="color: #000 !important">
                            <i class="text-center align-content-center inline-flex p-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.25 22.5C17.2165 22.5 18 21.7165 18 20.75C18 19.7835 17.2165 19 16.25 19C15.2835 19 14.5 19.7835 14.5 20.75C14.5 21.7165 15.2835 22.5 16.25 22.5Z" fill="black"/>
                                        <path d="M8.25 22.5C9.2165 22.5 10 21.7165 10 20.75C10 19.7835 9.2165 19 8.25 19C7.2835 19 6.5 19.7835 6.5 20.75C6.5 21.7165 7.2835 22.5 8.25 22.5Z" fill="black"/>
                                        <path d="M4.84 3.94L4.64 6.39C4.6 6.86 4.97 7.25 5.44 7.25H20.75C21.17 7.25 21.52 6.93 21.55 6.51C21.68 4.74 20.33 3.3 18.56 3.3H6.27C6.17 2.86 5.97 2.44 5.66 2.09C5.16 1.56 4.46 1.25 3.74 1.25H2C1.59 1.25 1.25 1.59 1.25 2C1.25 2.41 1.59 2.75 2 2.75H3.74C4.05 2.75 4.34 2.88 4.55 3.1C4.76 3.33 4.86 3.63 4.84 3.94Z" fill="black"/>
                                        <path d="M20.5101 8.75H5.17005C4.75005 8.75 4.41005 9.07 4.37005 9.48L4.01005 13.83C3.87005 15.54 5.21005 17 6.92005 17H18.0401C19.5401 17 20.8601 15.77 20.9701 14.27L21.3001 9.6C21.3401 9.14 20.9801 8.75 20.5101 8.75Z" fill="black"/>
                                    </svg>
                            </i>
                            </a>
                        </div>

                        <div id="cart_items" class="hidden sm:block">
                            @include('layouts.front-end.partials.cart')
                        </div>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('store.home.show_education'))
                        <div  class="flex navbar-tool dropdown {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-0' : 'ml-0'}}">
                            <button id="help-center-button" class="navbar-tool-icon-box dropdown-toggle pt-2 sm:w-16 sm:h-16 w-10 h-10" title="{{Helpers::translate('Help Center')}}" href="{{route('education.home')}}" style="background-color: #FDCD05">
                            <div class="w-full h-100 sm:pt-2 pt-0">
                                <i class="text-center align-content-center inline-flex p-0 sm:pt-2 pt-0">
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                    width="25" height="25" viewBox="0 0 48.000000 48.000000"
                                    preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,48.000000) scale(0.100000,-0.100000)"
                                    fill="#000000" stroke="none">
                                    <path d="M20 460 c-15 -15 -20 -33 -20 -70 l0 -50 180 0 180 0 0 50 c0 84 -13
                                    90 -180 90 -127 0 -142 -2 -160 -20z m75 -50 c0 -18 -6 -26 -23 -28 -13 -2
                                    -25 3 -28 12 -10 26 4 48 28 44 17 -2 23 -10 23 -28z m100 0 c0 -18 -6 -26
                                    -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z m100 0 c0
                                    -18 -6 -26 -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z"/>
                                    <path d="M0 240 l0 -60 93 0 92 0 20 37 c11 21 37 47 60 60 l40 23 -152 0
                                    -153 0 0 -60z"/>
                                    <path d="M291 242 c-38 -20 -71 -73 -71 -112 0 -62 68 -130 130 -130 62 0 130
                                    68 130 130 0 62 -68 130 -130 130 -14 0 -41 -8 -59 -18z m93 -38 c18 -18 21
                                    -60 5 -69 -5 -4 -14 -18 -20 -32 -5 -13 -15 -23 -22 -20 -16 6 -11 46 10 69
                                    13 15 14 21 4 31 -9 9 -16 7 -29 -11 -18 -23 -32 -21 -32 4 0 19 29 44 50 44
                                    10 0 26 -7 34 -16z m-19 -143 c7 -12 -12 -24 -25 -16 -11 7 -4 25 10 25 5 0
                                    11 -4 15 -9z"/>
                                    <path d="M0 90 c0 -78 18 -90 134 -90 l95 0 -24 43 c-14 23 -25 54 -25 70 l0
                                    27 -90 0 -90 0 0 -50z"/>
                                    </g>
                                    </svg>
                                </i>
                            </div>
                            </button>
                        </div>
                        @endif
                        {{--  @if((auth('customer')->check() || auth('delegatestore')->check()))
                            <input type="hidden" name="products" id="linkedProducts">
                            <button onclick="addAllToLinked(event,this)" class="btn bg-primaryColor addto-list with-transitions hidden" style="display: none">
                                <i class="ri-store-2-line font-size-xl mx-2"></i>
                                {{\App\CPU\Helpers::translate('Add to my products list')}}
                                &nbsp; (<span id="selectedCount" class="mx-2">0</span>)
                            </button>
                        @endif  --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-md navbar-stuck-menu w-full mx-0 bg-transparent"  >
            <div class="container" style="padding-left: 10px;padding-right: 10px;">
                <div class="collapse navbar-collapse" id="navbarCollapse"
                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}; ">

                    <!-- Search-->
                    <div class="input-group-overlay d-md-none my-3">
                        <form action="{{route('products')}}" type="submit" class="search_form with-transitions">
                            <input class="form-control appended-form-control search-bar-input-mobile" type="text"
                                   autocomplete="off"
                                   placeholder="{{\App\CPU\Helpers::translate('search')}}" name="name">
                            <input name="data_from" value="search" hidden>
                            <input name="page" value="1" hidden>
                            <button class="input-group-append-overlay search_button bg-dark" type="submit"
                                    style="border-radius: {{(Session::get('direction') ?? 'rtl') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 7px 7px 0px; left: unset; right: 0'}};">
                            <span class="input-group-text" style="font-size: 20px;">
                                <i class="czi-search text-white"></i>
                            </span>
                            </button>
                            <diV class="card search-card"
                                 style="position: absolute;background: white;z-index: 999;width: max-content;display: none">
                                <div class="card-body search-result-box" id=""
                                     style="overflow:scroll; height:400px;overflow-x: hidden"></div>
                            </diV>
                        </form>
                    </div>

                    @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
                    <ul class="navbar-nav mega-nav pr-2 pl-2 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}} d-none d-xl-block ">
                        <!--web-->

                    </ul>



                    <ul class="navbar-nav mega-nav1 pr-2 pl-2 d-block d-xl-none"><!--mobile-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-0' : 'pl-0'}}"
                               href="#" data-toggle="dropdown">
                                <i class="czi-menu align-middle mt-n1 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                <span
                                    style="margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 20px !important;">{{ \App\CPU\Helpers::translate('categories')}}</span>
                            </a>
                            <ul class="dropdown-menu"
                                style="right: 0%; text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                @foreach($categories as $category)
                                    <li class="dropdown">
                                        <a class="dropdown-item <?php if ($category->childes->count() > 0) echo "dropdown-toggle"?> "
                                           <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown'"?> href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                            <img src="{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'image',session()->get('local')) ?? $category->icon))}}"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 style="width: 18px; height: 18px; ">
                                            <span
                                                class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>
                                        </a>
                                        @if($category->childes->count()>0)
                                            <ul class="dropdown-menu"
                                                style="right: 100%; text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                                @foreach($category['childes'] as $subCategory)
                                                    <li class="dropdown">
                                                        <a class="dropdown-item <?php if ($subCategory->childes->count() > 0) echo "dropdown-toggle"?> "
                                                           <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown'"?> href="{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                            <span
                                                                class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                        </a>
                                                        @if($subCategory->childes->count()>0)
                                                            <ul class="dropdown-menu"
                                                                style="right: 100%; text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                                                @foreach($subCategory['childes'] as $subSubCategory)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                           href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <!-- Primary menu-->

                </div>
            </div>
        </div>


    </div>
</header>
{{--  side menu  --}}
@if((auth('customer')->check() || auth('delegatestore')->check()))
    @include('layouts.front-end.partials._side-bar')
@endif
{{--  side menu end  --}}

<script>
function myFunction() {
  $('#anouncement').addClass('d-none').removeClass('d-flex')
}
</script>

