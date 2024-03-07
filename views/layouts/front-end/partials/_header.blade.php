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
            padding- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1.95rem;
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


@if ((auth('customer')->check() && session('exp_notify_days') && isset($sub->expiry_date)) || 1==2)
    <?php
    $user = auth('customer')->user();
    $sub = App\Model\Subscription::where(['user_id'=>$user->id,'package_id'=>$user->subscription])->whereIn('status',['paid','active'])->orderBy('id','desc')->first();
    $exp = Carbon\Carbon::parse($sub->expiry_date);
    $msg_text = Helpers::get_business_settings('exp_notify_text');
    $msg_text = str_replace('{NAME}',auth('customer')->user()->name,$msg_text);
    $msg_text = str_replace('{remaining_days}', Carbon\Carbon::today()->diff($exp)->days,$msg_text);
    $msg_text = str_replace('{DATE}', $exp->format('Y/m/d'),$msg_text);
    ?>
    <div class="d-flex justify-content-between align-items-center" style="background-color: {{ Helpers::get_business_settings('exp_notify_bg') }};color:{{Helpers::get_business_settings('exp_notify_color')}};height:40px">
        <strong class="d-flex justify-content-between align-items-center w-100">
            <a href="{{route('subscriptions')}}" style="text-align:center; font-size: 15px;width:100%;background-color: {{ Helpers::get_business_settings('exp_notify_bg') }};color:{{Helpers::get_business_settings('exp_notify_color')}}!important;">{{ $msg_text }} </a>
        </strong>
    </div>
@endif


<header class="box-shadow-sm rtl bg-white text-dark">
    <!-- Topbar-->



    @php($announcement=\App\CPU\Helpers::get_business_settings('announcement'))
    <div class="navbar-sticky bg-white mobile-head @if (isset($announcement) && $announcement['status']==1) pt-5 @else pt-3 @endif pb-2">
        <div class="navbar navbar-expand-md bg-white">
            <div class="navbar-brand-wrapper justify-content-between side-logo px-0 pt-0 ms-5">
                <!-- Logo -->
                @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'shop_header_icon'])->first()->value)
                <a href="{{route('home')}}" aria-label="Front" class="d-block">
                    <img
                        style="max-width: 136px"
                         onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'"
                         class="navbar-brand-logo-mini for-web-logo wd-200 m-0"
                         src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'shop_header_icon'])->pluck('value')[0]}}"
                         alt="Logo">
                </a>
                <!-- Navbar Vertical Toggle -->
                <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs" onclick="$('body').addClass('navbar-vertical-aside-closed-mode')">
                    <i class="fa fa-close text-light"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <div class="container ">
                <button class="btn btn-dark d-lg-none" onclick="$('body').removeClass('navbar-vertical-aside-closed-mode')">
                    <i class="fa fa-bars"></i>
                </button>
                <button class="btn btn-dark d-lg-none" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="fa fa-angle-down"></span>
                </button>
                <div style="flex-wrap:  nowrap;display: flex;">
                    @php($currency_model = \App\CPU\Helpers::get_business_settings('currency_model'))
                    @if($currency_model=='multi_currency')
                        <div class="text-center topbar-text dropdown disable-autohide pt-3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"
                        style="width: 100px;height:61px;background-color: #f1f1f1;border-radius: 11px"
                        >
                            <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown"
                            >
                                <span>{{session('currency_code')}} {{session('currency_symbol')}}</span>
                            </a>
                            <ul class="bg-white dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"
                                style="min-width: 160px!important;text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
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
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            @foreach(json_decode($language['value'],true) as $data)
                                @if($data['code']==$local)
                                    <img class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}" width="20"
                                        src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png"
                                        alt="Eng">
                                    {{$data['name']}}
                                @endif
                            @endforeach
                        </a>
                        <ul class="bg-white dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @foreach(json_decode($language['value'],true) as $key =>$data)
                                @if($data['status']==1)
                                    <li onclick="alert_wait()">
                                        <a class="dropdown-item pb-1" href="{{route('lang',[$data['code']])}}">
                                            <img class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"
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
                     style="height: 61px;text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                    <form action="{{route('products')}}" type="submit" class="search_form with-transitions border-0" style="background-color: #f1f1f1;border-radius: 15px">
                        <input class="form-control appended-form-control search-bar-input with-transitions w-100 bg-transparent border-0 text-center placeholder-black" type="text"
                               autocomplete="off"
                               placeholder="{{\App\CPU\Helpers::translate('search')}}"
                               name="name"
                               style="height: 61px;color: black">
                        <button class="input-group-append-overlay search_button bg-transparent" type="submit"
                                style="background-color: white;border-radius: {{Session::get('direction') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 7px 7px 0px; left: unset; right: 0'}};top:0;border:none">
                                <span class="input-group-text" style="font-size: 20px;">
                                    <i class="ri-search-2-line font-size-xl" style="color: black"></i>
                                </span>
                        </button>
                        <input name="data_from" value="search" hidden>
                        <input name="page" value="1" hidden>
                        <div class="card search-card"
                             style="position: absolute;background: white;z-index: 999;width: 100%;display: none">
                            <div class="card-body search-result-box"
                                 style="overflow:scroll; height:400px;overflow-x: hidden"></div>
                        </div>
                    </form>
                </div>
                <!-- Toolbar-->
                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center" style="margin-right: 10px;">


                    @if(auth('customer')->check())
                        <div class="navbar-tool dropdown no-b-icon me-3">
                            <a class="navbar-tool-icon-box dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false" style="width: 61px;height: 61px;">
                                <div class="navbar-tool-icon-box w-100 h-100 pt-2">
                                        <i class="ri-user-line font-size-xl"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-top: 0px !important">
                                <a class="dropdown-item"
                                   href="{{route('user-account')}}"> {{ \App\CPU\Helpers::translate('my_profile')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                   href="{{route('customer.auth.logout')}}">{{ \App\CPU\Helpers::translate('logout')}}</a>
                            </div>
                        </div>
                        <div class="navbar-tool dropdown no-b-icon">
                            <a href="{{ route('wallet') }}" class="navbar-tool-icon-box dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false" style="width: 61px;height: 61px;">
                                <div class="navbar-tool-icon-box w-100 h-100 pt-2">
                                        <i class="ri-wallet-line font-size-xl"></i>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="navbar-tool dropdown no-b-icon">
                            <a class="navbar-tool-icon-box dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false" style="width: 61px;height: 61px;">
                                <div class="navbar-tool-icon-box w-100 h-100 pt-2">
                                        <i class="ri-user-line font-size-xl"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}" aria-labelledby="dropdownMenuButton"
                                 style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                <a class="dropdown-item" href="{{route('customer.auth.login')}}">
                                    <i class="ri-user-add-fill {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i> {{\App\CPU\Helpers::translate('sing_in')}}
                                </a>
                                <a class="dropdown-item" href="{{route('customer.auth.register')}}">
                                    <i class="fa fa-user-circle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>{{\App\CPU\Helpers::translate('sing_up')}}
                                </a>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{route('seller.auth.login')}}">
                                    <i class="ri-user-add-fill {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i> {{\App\CPU\Helpers::translate('Seller login')}}
                                </a>
                                <a class="dropdown-item" href="{{route('shop.apply')}}">
                                    <i class="fa fa-user-circle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>{{\App\CPU\Helpers::translate('Become a Seller')}}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="navbar-tool dropdown {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                        <a href="{{ route('notifications') }}" class="navbar-tool-icon-box dropdown-toggle pt-2" style="width: 61px;height: 61px;">
                            <span class="navbar-tool-label text-light">
                                <span class="countNotifications">
                                    @auth('customer')
                                    {{ Helpers::get_customer_notifications() }}
                                    @endauth
                                </span>
                           </span>
                           <i class="ri-notification-line font-size-xl"></i>
                        </a>
                    </div>
                    <div class="navbar-tool dropdown {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                        <a class="navbar-tool-icon-box dropdown-toggle pt-2" href="{{route('wishlists')}}" style="width: 61px;height: 61px;">
                            <span class="navbar-tool-label text-light">
                                <span
                                    class="countWishlist">{{session()->has('wish_list')?count(session('wish_list')):0}}</span>
                           </span>
                           <i class="ri-heart-line font-size-xl"></i>
                        </a>
                    </div>
                    <div id="cart_items">
                        @include('layouts.front-end.partials.cart')
                    </div>
                    @if(auth('customer')->check())
                        <input type="hidden" name="products" id="linkedProducts">
                        <button onclick="addAllToLinked(event,this)" class="btn btn--primary addto-list with-transitions" style="display: none">
                            <i class="ri-store-2-line font-size-xl"></i>
                            {{\App\CPU\Helpers::translate('Add to my products list')}}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-md navbar-stuck-menu w-100 mx-0 bg-transparent"  >
            <div class="container" style="padding-left: 10px;padding-right: 10px;">
                <div class="collapse navbar-collapse" id="navbarCollapse"
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}; ">

                    <!-- Search-->
                    <div class="input-group-overlay d-md-none my-3">
                        <form action="{{route('products')}}" type="submit" class="search_form with-transitions">
                            <input class="form-control appended-form-control search-bar-input-mobile" type="text"
                                   autocomplete="off"
                                   placeholder="{{\App\CPU\Helpers::translate('search')}}" name="name">
                            <input name="data_from" value="search" hidden>
                            <input name="page" value="1" hidden>
                            <button class="input-group-append-overlay search_button bg-dark" type="submit"
                                    style="border-radius: {{Session::get('direction') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 7px 7px 0px; left: unset; right: 0'}};">
                            <span class="input-group-text" style="font-size: 20px;">
                                <i class="czi-search text-white"></i>
                            </span>
                            </button>
                            <diV class="card search-card"
                                 style="position: absolute;background: white;z-index: 999;width: 100%;display: none">
                                <div class="card-body search-result-box" id=""
                                     style="overflow:scroll; height:400px;overflow-x: hidden"></div>
                            </diV>
                        </form>
                    </div>

                    @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
                    <ul class="navbar-nav mega-nav pr-2 pl-2 {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} d-none d-xl-block ">
                        <!--web-->

                    </ul>



                    <ul class="navbar-nav mega-nav1 pr-2 pl-2 d-block d-xl-none"><!--mobile-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{Session::get('direction') === "rtl" ? 'pr-0' : 'pl-0'}}"
                               href="#" data-toggle="dropdown">
                                <i class="czi-menu align-middle mt-n1 {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>
                                <span
                                    style="margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 20px !important;">{{ \App\CPU\Helpers::translate('categories')}}</span>
                            </a>
                            <ul class="dropdown-menu"
                                style="right: 0%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                @foreach($categories as $category)
                                    <li class="dropdown">
                                        <a class="dropdown-item <?php if ($category->childes->count() > 0) echo "dropdown-toggle"?> "
                                           <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown'"?> href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                            <img src="{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'image',session()->get('local')) ?? $category->icon))}}"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 style="width: 18px; height: 18px; ">
                                            <span
                                                class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>
                                        </a>
                                        @if($category->childes->count()>0)
                                            <ul class="dropdown-menu"
                                                style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                @foreach($category['childes'] as $subCategory)
                                                    <li class="dropdown">
                                                        <a class="dropdown-item <?php if ($subCategory->childes->count() > 0) echo "dropdown-toggle"?> "
                                                           <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown'"?> href="{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                            <span
                                                                class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                        </a>
                                                        @if($subCategory->childes->count()>0)
                                                            <ul class="dropdown-menu"
                                                                style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
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
@if(auth('customer')->check())
    @include('layouts.front-end.partials._side-bar')
@endif
{{--  side menu end  --}}

<script>
function myFunction() {
  $('#anouncement').addClass('d-none').removeClass('d-flex')
}
</script>

