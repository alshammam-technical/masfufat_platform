@extends('layouts.front-end.app')

@section('title', $web_config['name']->value.' '.\App\CPU\Helpers::translate('Online Shopping').' | '.$web_config['name']->value.' '.\App\CPU\Helpers::translate('Ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/home.css"/>
    <style>
        .media {
            background: white;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
        }

        .cz-countdown-days {
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;

        }

        .cz-countdown-hours {
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;
        }

        .cz-countdown-minutes {
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;
        }

        .cz-countdown-seconds {
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */
            flex: 1;
        }

        .flash_deal_product_details .flash-product-price {
            font-weight: 700;
            font-size: 18px;
            color: {{$web_config['primary_color']}};
        }

        .featured_deal_left {
            height: 130px;
            background: {{$web_config['primary_color']}} 0% 0% no-repeat padding-box;
            padding: 10px 13px;
            text-align: center;
        }

        .category_div:hover {
            color: {{$web_config['secondary_color']}};
        }

        .deal_of_the_day {
            /* filter: grayscale(0.5); */
            /* opacity: .8; */
            background: {{$web_config['secondary_color']}};
            border-radius: 3px;
        }

        .deal-title {
            font-size: 12px;

        }

        .for-flash-deal-img img {
            max-width: none;
        }
        .best-selleing-image {
            background:{{$web_config['primary_color']}}10;
            width:30%;
            display:flex;
            align-items:center;
            border-radius: 5px;
        }
        .best-selling-details {
            padding:10px;
            width:50%;
        }
        .top-rated-image{
            background:{{$web_config['primary_color']}}10;
            width:30%;
            display:flex;
            align-items:center;
            border-radius: 5px;
        }
        .top-rated-details {
            padding:10px;width:70%;
        }

        @media (max-width: 375px) {
            .cz-countdown {
                display: flex !important;

            }

            .cz-countdown .cz-countdown-seconds {

                margin-top: -5px !important;
            }

            .for-feature-title {
                font-size: 20px !important;
            }
        }

        @media (max-width: 600px) {
            .flash_deal_title {
                /*font-weight: 600;*/
                /*font-size: 18px;*/
                /*text-transform: uppercase;*/

                font-weight: 700;
                font-size: 25px;
                text-transform: uppercase;
            }

            .cz-countdown .cz-countdown-value {
                /* font-family: "Roboto", sans-serif; */
                font-size: 11px !important;
                font-weight: 700 !important;

            }

            .featured_deal {
                opacity: 1 !important;
            }

            .cz-countdown {
                display: inline-block;
                flex-wrap: wrap;
                font-weight: normal;
                margin-top: 4px;
                font-size: smaller;
            }

            .view-btn-div-f {

                margin-top: 6px;
                float: right;
            }

            .view-btn-div {
                float: right;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }


            .for-mobile {
                display: none;
            }

            .featured_for_mobile {
                max-width: 100%;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .best-selleing-image {
                width: 50%;
                border-radius: 5px;
            }
            .best-selling-details {
                width:50%;
            }
            .top-rated-image {
                width: 50%;
            }
            .top-rated-details {
            width:50%;
        }
        }


        @media (max-width: 360px) {
            .featured_for_mobile {
                max-width: 100%;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .featured_deal {
                opacity: 1 !important;
            }
        }

        @media (max-width: 375px) {
            .featured_for_mobile {
                max-width: 100%;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .featured_deal {
                opacity: 1 !important;
            }

        }

        @media (min-width: 768px) {
            .displayTab {
                display: block !important;
            }

        }

        @media (max-width: 800px) {

            .latest-product-margin {
                margin-left: 0px !important;
                }
            .for-tab-view-img {
                width: 40%;
            }

            .for-tab-view-img {
                width: 105px;
            }

            .widget-title {
                font-size: 19px !important;
            }
            .flash-deal-view-all-web {
                display: none !important;
            }
            .categories-view-all {
                {{session('direction') === "rtl" ? 'margin-left: 10px;' : 'margin-right: 6px;'}}
            }
            .categories-title {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 0px;' : 'margin-left: 6px;'}}
            }
            .seller-list-title{
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 0px;' : 'margin-left: 10px;'}}
            }
            .seller-list-view-all {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left: 20px;' : 'margin-right: 10px;'}}
            }
            .seller-card {
                padding-left: 0px !important;
            }
            .category-product-view-title {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 16px;' : 'margin-left: -8px;'}}
            }
            .category-product-view-all {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left: -7px;' : 'margin-right: 5px;'}}
            }
            .recomanded-product-card {
                background: #F8FBFD;margin:20px;height: 343px; border-radius: 5px;
            }
            .recomanded-buy-button {
                text-align: center;
                margin-top: 30px;
            }
        }
        @media(min-width:801px){
            .flash-deal-view-all-mobile{
                display: none !important;
            }
            .categories-view-all {
                {{session('direction') === "rtl" ? 'margin-left: 30px;' : 'margin-right: 27px;'}}
            }
            .categories-title {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 25px;' : 'margin-left: 25px;'}}
            }
            .seller-list-title{
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 6px;' : 'margin-left: 10px;'}}
            }
            .seller-list-view-all {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left: 12px;' : 'margin-right: 10px;'}}
            }
            .seller-card {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'padding-left:0px !important;' : 'padding-right:0px !important;'}}
            }
            .category-product-view-title {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 10px;' : 'margin-left: -12px;'}}
            }
            .category-product-view-all {
                {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left: -20px;' : 'margin-right: 0px;'}}
            }
            .recomanded-product-card {
                background: #F8FBFD;margin:20px;height: 343px; border-radius: 5px;
            }
            .recomanded-buy-button {
                text-align: center;
                margin-top: 63px;
            }

        }

        .featured_deal_carosel .carousel-inner {
            width: 100% !important;
        }

        .badge-style2 {
            color: black !important;
            background: transparent !important;
            font-size: 11px;
        }
        .countdown-card{
            background:{{$web_config['primary_color']}}10;
            height: 150px!important;
            border-radius:5px;

        }
        .flash-deal-text{
            color: {{$web_config['primary_color']}};
            text-transform: uppercase;
            text-align:center;
            font-weight:700;
            font-size:20px;
            border-radius:5px;
            margin-top:25px;
        }
        .countdown-background{
            background: {{$web_config['primary_color']}};
            padding: 5px 5px;
            border-radius:5px;
            margin-top:15px;
        }
        .carousel-wrap{
            position: relative;
        }
        .owl-nav{
            top: 40%;
            position: absolute;
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
     }
     .owl-prev{
         float: left;

     }
     .owl-next{
         float: right;
     }
     .czi-arrow-left{
        color: {{$web_config['primary_color']}};
        background: {{$web_config['primary_color']}}10;
        padding: 5px;
        border-radius: 50%;
        margin-left: -12px;
        font-weight: bold;
        font-size: 12px;
     }
     .czi-arrow-right{
        color: {{$web_config['primary_color']}};
        background: {{$web_config['primary_color']}}10;
        padding: 5px;
        border-radius: 50%;
        margin-right: -15px;
        font-weight: bold;
        font-size: 12px;
     }
    .owl-carousel .nav-btn .czi-arrow-left{
      height: 47px;
      position: absolute;
      width: 26px;
      cursor: pointer;
      top: 100px !important;
  }
  .flash-deals-background-image{
    background: {{$web_config['primary_color']}}10;
    border-radius:5px;
    width:125px;
    height:125px;
  }
  .view-all-text{
    color:{{$web_config['secondary_color']}} !important;
    font-size:14px;
  }
  .feature-product-title {
    text-align: center;
    font-size: 22px;
    margin-top: 15px;
    font-style: normal;
    font-weight: 700;
  }
  .feature-product .czi-arrow-left{
        color: {{$web_config['primary_color']}};
        background: {{$web_config['primary_color']}}10;
        padding: 5px;
        border-radius: 50%;
        margin-left: -80px;
        font-weight: bold;
        font-size: 12px;
     }

     .feature-product .owl-nav{
        top: 40%;
        position: absolute;
        display: flex;
        justify-content: space-between;
        /* width: 100%; */
        z-index: -999;
    }
     .feature-product .czi-arrow-right{
        color: {{$web_config['primary_color']}};
        background: {{$web_config['primary_color']}}10;
        padding: 5px;
        border-radius: 50%;
        margin-right: -80px;
        font-weight: bold;
        font-size: 12px;
     }
     .shipping-policy-web{
        background: #ffffff;width:100%; border-radius:5px;
     }
     .shipping-method-system{
        height: 130px;width: 70%;margin-top: 15px;
     }

     .flex-between {
         display: flex;
         justify-content: space-between;
     }
     .new_arrival_product .czi-arrow-left{
         margin-left: -28px;
     }
     .new_arrival_product .owl-nav{
         z-index: -999;
     }
    </style>


@endpush

@section('content')
@php($decimal_point_settings = !empty(\App\CPU\Helpers::get_business_settings('decimal_point_settings')) ? \App\CPU\Helpers::get_business_settings('decimal_point_settings') : 0)
@php($current_lang = session()->get('local'))
@if (\App\CPU\Helpers::store_module_permission_check('store.home.view'))
    <!-- Hero (Banners + Slider)-->
    <section class="bg-transparent mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    @include('web-views.partials._home-top-slider')
                </div>
            </div>
        </div>
    </section>

    {{--flash deal--}}
    @php($flash_deals=\App\Model\FlashDeal::with(['products'=>function($query){
                $query->with('product')->whereHas('product',function($q){
                    //$q->active();
                });
            }])->where(['status'=>1])->where(['deal_type'=>'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->first())
    @if ($flash_deals)
    <div class="container">
        <div class="flash-deal-view-all-web row d-flex justify-content-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'start' : 'end'}}" style="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left: 2px;' : 'margin-right:2px;'}}">
            @if (count($flash_deals->products)>0)
                <a class="text-capitalize view-all-text" href="{{route('flash-deals',[isset($flash_deals)?$flash_deals['id']:0])}}">
                    {{ \App\CPU\Helpers::translate('view_all')}}
                    <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left-circle mr-1 ml-n1 mt-1 float-left' : 'right-circle ml-1 mr-n1'}}"></i>
                </a>
            @endif
        </div>
        <div class="row d-flex mb-3 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'flex-row-reverse' : 'flex-row'}}">




        </div>
    </div>
    @endif

    {{--brands--}}

    <!-- Products grid (featured products)-->

    @if (count($featured_products) !== 0 )
    <div class="container rtl">
        <div class="row justify-content-center">
            {{-- featured products --}}
            <div class="col-md-12 mt-0 mb-4 py-5" style="border-radius: 16px">
                <div class="latest-product-margin" style="margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right:0px' : 'left:0px'}}">
                    <div class="row mt-2 mx-0">
                        <div class="col-6 mb-4 px-0 text-start">
                            <span class="for-feature-title text-dark" style="text-align: center;font-size:4.3vh !important; font-weight:700">{{ \App\CPU\Helpers::translate('featured_products')}}</span>
                        </div>
                    </div>
                    @if (count($featured_products) > 4)

                    <div class="carousel-wrap" >
                        <div class="owl-carousel owl-theme p-2" id="new-arrivals-product">
                            @foreach($featured_products as $key1 =>$product)
                            @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
                            <div style="margin:2px;">
                                @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="row mt-2 mb-3 d-flex justify-content-between">
                        <div class="col-md-12 col-12 ">
                           <div class="row d-flex justify-content-md-center">
                            @foreach($featured_products as $key1 =>$product)
                                <div class="col-md-3 col-6 mt-5 sm:mt-2 mt-md-0" style="">
                                   @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                </div>
                           @endforeach
                            </div>
                       </div>


                   </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{--featured deal--}}
    @php($featured_deals=\App\Model\FlashDeal::with(['products'=>function($query_one){
        $query_one->with('product.reviews')->whereHas('product',function($query_two){
            //$query_two->active();
        });
    }])
    ->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))
    ->where(['status'=>1])->where(['deal_type'=>'feature_deal'])
    ->first())


    {{--deal of the day--}}
    <div class="container rtl">
        {{--  start  --}}
        <div id="features-section1" class="row mb-5 mt-8 d-sm-none d-lg-block pos-relative" dir="{{session()->get('direction') ?? 'rtl'}}" style="height:450px">
            <div class="col-lg-12 p-0 text-dark text-center">
                <strong class="text-dark text-center w-full h3" data-bs-aos="fade-up">
                    {{\App\CPU\Helpers::translate('What characterize Masfufat')}}
                </strong>

                <div class="flex mt-8" style="overflow-x: auto">
                    <div
                    data-bs-aos="fade-down"
                    data-bs-aos-duration="1000"
                    class="col-4 text-center">
                        <img src="{{asset('/public/assets/landing/img/package4-icon.png')}}" alt="" class="self-center inline">
                        <p class="section3_cols_title text-white">
                            <strong class="h2 text-black">
                                {{\App\CPU\Helpers::translate('High quality')}}
                            </strong>
                        </p>
                    </div>

                    <div
                    data-bs-aos="fade-down"
                    data-bs-aos-duration="1500"
                    class="col-4 text-center">
                        <img src="{{asset('/public/assets/landing/img/store-icon.png')}}" alt="" class="self-center inline">
                        <p class="section3_cols_title text-white">
                            <strong class="h2 text-black">
                                {{\App\CPU\Helpers::translate('provide products')}}
                            </strong>
                        </p>
                    </div>

                    <div
                    data-bs-aos="fade-down"
                    data-bs-aos-duration="3000"
                    class="col-4 text-center">
                        <img src="{{asset('/public/assets/landing/img/shipping-icon.png')}}" alt="" class="self-center inline">
                        <p class="section3_cols_title text-white">
                            <strong class="h2 text-black">
                                {{\App\CPU\Helpers::translate('Packaging and shipping')}}
                            </strong>
                        </p>
                    </div>

                </div>
            </div>
        </div>
        {{--  end  --}}
        @if ($flash_deals)
        <div class="row justify-content-center">
            <div class="col-12 mt-0 mb-4 py-5 bg-secondary px-4" style="border-radius: 16px">
                <div class="latest-product-margin" style="margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right:0px' : 'left:0px'}}">
                    <div class="row mt-0 mx-0">
                        <div class="col-2 mb-0 px-0 text-start py-4">
                            <span class="for-feature-title text-dark" style="text-align: center;font-size:32px !important; font-weight:700">{{ \App\CPU\Helpers::translate('flash deal')}}</span>
                        </div>
                        {{--    --}}
                        <div class="col-4 mb-0 px-3 text-start">
                            <div class="m-2">
                                <div class="flash-deal-text my-0 bg-dark">
                                    <span class="text-white">{{ \App\CPU\Helpers::translate('Remaining at the end of the deal')}}</span>
                                </div>
                                <div style=" text-align: center;color: #ffffff !important;">
                                    <div class="countdown-background mt-0 bg-white">
                                        <span class="cz-countdown d-flex justify-content-center align-items-center"
                                            data-bs-countdown="{{isset($flash_deals)?date('m/d/Y',strtotime($flash_deals['end_date'])):''}} 11:59:00 PM">
                                            <span class="cz-countdown-days">
                                                <span class="text-dark">{{ \App\CPU\Helpers::translate('day')}}</span>
                                                <span class="cz-countdown-value text-dark">00</span>
                                            </span>
                                            <span class="cz-countdown-value p-1">:</span>
                                            <span class="cz-countdown-hours">
                                                <span class="text-dark">{{ \App\CPU\Helpers::translate('hrs')}}</span>
                                                <span class="cz-countdown-value text-dark">00</span>
                                            </span>
                                            <span class="cz-countdown-value p-1">:</span>
                                            <span class="cz-countdown-minutes">
                                                <span class="text-dark">{{ \App\CPU\Helpers::translate('min')}}</span>
                                                <span class="cz-countdown-value text-dark">00</span>
                                            </span>
                                            <span class="cz-countdown-value p-1">:</span>
                                            <span class="cz-countdown-seconds">
                                                <span class="text-dark">{{ \App\CPU\Helpers::translate('sec')}}</span>
                                                <span class="cz-countdown-value text-dark">00</span>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--    --}}
                        <div class="col-6 mb-0 px-0 text-end py-4">
                            <a class="text-capitalize btn-primary w-auto p-3 rounded-pill"
                            href="{{route('products',['data_from'=>'latest'])}}">
                                {{ \App\CPU\Helpers::translate('view_all')}}
                                <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left mr-1 ml-n1 mt-0 float-left' : 'right ml-1 mr-n1'}}"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-2 justify-content-center">
                        @foreach($flash_deals->products ?? [] as $key=>$deal)
                            @if( $deal->product && $key <= 2)
                            @php($product = $deal->product)
                            <div class="col-sm-6 col-md-3 col-12 mb-4 mx-6 px-0 bg-white" style="border-radius: 16px">
                                <div style="margin:2px;">
                                    @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings,'noBtns'=>1])
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{--    --}}
        @if(isset($featured_deals))
        <section class="row justify-content-center">
            {{--    --}}
            <div class="row justify-content-center w-full px-0">
                <div class="col-md-8 mt-0 mb-4 py-3 bg-dark px-0" style="border-radius: 16px;height:max-content">
                    <div class="latest-product-margin" style="margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right:0px' : 'left:0px'}}">
                        <div class="row mt-0 mx-0 ps-3 pe-3">
                            <div class="col-6 mb-0 px-0 text-start py-1">
                                <span class="for-feature-title text-light" style="text-align: center;font-size:32px !important; font-weight:700">{{ \App\CPU\Helpers::translate('featured_deal')}}</span>
                            </div>
                            <div class="col-6 mb-0 px-0 text-end py-1">
                                <a class="text-capitalize btn-white text-dark w-auto p-3 rounded-pill"
                                href="{{route('products',['data_from'=>'latest'])}}">
                                    {{ \App\CPU\Helpers::translate('view_all')}}
                                    <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left mr-1 ml-n1 mt-0 float-left' : 'right ml-1 mr-n1'}}"></i>
                                </a>
                            </div>
                        </div>

                        <div class="row mt-2 justify-content-center mx-3">
                            @foreach($featured_deals->products as $key=>$deal)
                                @if( $deal->product && $key <= 2)
                                @php($product = $deal->product)
                                @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                <div class="col-12 m-1 bg-white" style="border-style: solid;border-radius:5px;"
                                        data-bs-href="{{route('product',$product->slug)}}">
                                    <div class="row" style="padding:8px;">

                                        <div class="top-rated-image bg-white">
                                            <a class="d-block d-flex justify-content-center bg-light" style="width:100%;height:100%;"
                                                href="{{route('product',$product->slug)}}">
                                                <img style="border-radius:5px;"
                                                class="wd-100"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{ Helpers::getImg('storage/app/public/product/'.$current_lang.'/'.(isset(json_decode($product['images'])->$current_lang) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''),'178.500','178.500') }}"
                                                    alt="Product"/>
                                            </a>
                                        </div>
                                        <div class="top-rated-details row" >
                                            <h6 class="widget-product-title col-9 text-start pt-2">
                                                <a dir="{{session('direction')}}" class="fs-25"
                                                href="{{route('product',$product->slug)}}">
                                                    {{\Illuminate\Support\Str::limit(\App\CPU\Helpers::getItemName('products','name',$product['id'],$lang ?? 'sa') ?? $product['name'],100)}}
                                                </a>
                                            </h6>
                                            @php($top_overallRating = \App\CPU\ProductManager::get_overall_rating($product['reviews']))
                                            <div class="col-3 p-0">
                                                <div class="widget-product-meta text-start">
                                                    <span class="text-accent text-success">
                                                        {{\App\CPU\Helpers::currency_converter(
                                                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                                        )}}
                                                    </span>

                                                    <div>
                                                        @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                                        @if($productdiscount > 0)
                                                            <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                                {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                                            </strike>
                                                            <span style="font-size: 12px!important;" class="text-success mx-2">
                                                                @if($productdiscount > 0)
                                                                    @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                                                    @php($productdiscount_type = Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
                                                                    @if ($productdiscount_type == 'percent')
                                                                    {{round($productdiscount)}}%
                                                                    @elseif($productdiscount_type =='flat')
                                                                        {{\App\CPU\Helpers::currency_converter($productdiscount)}}
                                                                    @endif {{\App\CPU\Helpers::translate('off_')}}
                                                                @endif
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Deal of the day/Recommended Product --}}
                <div class="col-md-4 mt-0 mb-4 py-0 ps-4 pe-0" style="border-radius: 16px">
                    <div class="deal_of_the_day bg-primary h-100" style="border-radius: 16px;">
                        @if(isset($deal_of_the_day) && isset($deal_of_the_day->product))
                            <div class="d-flex justify-content-start align-items-center mx-3" style="width: 70%">
                                <h1 class="align-items-center mt-0 pt-3" style="color: white"> {{ \App\CPU\Helpers::translate('deal_of_the_day') }}</h1>
                            </div>
                            <div class="recomanded-product-card">

                                <div class="d-flex justify-content-center align-items-center bg-light" style="margin:20px 20px -20px 20px;">
                                    <img style="border-radius:5px 5px 0px opx;"
                                        class="wd-150"
                                        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($deal_of_the_day->product['images'])->$current_lang)) ? json_decode($deal_of_the_day->product['images'])->$current_lang[0] ?? '' : ''}}"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        alt="">
                                </div>
                                <div style="margin:20px;padding-top: 10px;height: 150px;border-radius: 0px 0px 5px 5px;">
                                    <div style="text-align: left">

                                        @php($overallRating = \App\CPU\ProductManager::get_overall_rating($deal_of_the_day->product['reviews']))
                                        <div class="rating-show text-start mb-2">
                                            <h5 style="font-weight: 600;" class="wd-md-70p text-black">
                                                {{$deal_of_the_day->product['name']}}
                                            </h5>
                                            @if ((\App\Model\BusinessSetting::where('type','products_rating')->first()->value ?? '') && 1==2)
                                            <span class="d-inline-block font-size-sm text-body">
                                                @for($inc=0;$inc<5;$inc++)
                                                    @if($inc<$overallRating[0])
                                                        <i class="sr-star czi-star-filled active"></i>
                                                    @else
                                                        <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                                    @endif
                                                    @endfor
                                                    <label class="badge-style">( {{$deal_of_the_day->product->reviews_count}} )</label>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="text-start">

                                            @if($deal_of_the_day->product->discount > 0)
                                                <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                    {{\App\CPU\Helpers::currency_converter($deal_of_the_day->product->unit_price)}}
                                                </strike>
                                            @endif
                                            <span class="text-accent text-success" style="font-size: 22px !important;">
                                                {{\App\CPU\Helpers::currency_converter(
                                                    $deal_of_the_day->product->unit_price-(\App\CPU\Helpers::get_product_discount($deal_of_the_day->product,$deal_of_the_day->product->unit_price))
                                                )}}
                                            </span>

                                            <div>
                                                @if($deal_of_the_day->product->discount > 0)
                                                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                                    </strike>
                                                    <span style="font-size: 12px!important;" class="text-success mx-2">
                                                        @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                                        @if($productdiscount > 0)
                                                            @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                                            @php($productdiscount_type = Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
                                                            @if ($productdiscount_type == 'percent')
                                                            {{round($productdiscount)}}%
                                                            @elseif($productdiscount_type =='flat')
                                                                {{\App\CPU\Helpers::currency_converter($productdiscount)}}
                                                            @endif {{\App\CPU\Helpers::translate('off_')}}
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full d-inline-block">
                                <div class="pos-relative w-full">
                                    <div class="pos-absolute text-white w-full text-center" style="top:-60px">
                                        <button class="buy_btn btn-primary border-white px-5"
                                        onclick="location.href='{{route('product',$deal_of_the_day->product->slug)}}'">
                                            {{\App\CPU\Helpers::translate('buy_now')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            @php($product=\App\Model\Product::inRandomOrder()->first())
                            @if(isset($product))
                            @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
                                <div class="d-flex justify-content-center align-items-center">
                                    <h1 style="color: white"> {{ \App\CPU\Helpers::translate('recommended_product') }}</h1>
                                </div>
                                <div class="recomanded-product-card">

                                    <div class="d-flex justify-content-center align-items-center" style="margin:20px 20px -20px 20px;padding-top: 20px;">
                                        <img style=""
                                        @isset($deal_of_the_day->product)
                                        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($deal_of_the_day->product['images'])->$current_lang)) ? json_decode($deal_of_the_day->product['images'])->$current_lang[0] ?? '' : ''}}"
                                        @endisset
                                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                            alt="">
                                    </div>
                                    <div style="background:#ffffff;margin:20px;padding-top: 10px;height: 200px;border-radius: 0px 0px 5px 5px;">
                                        <div style="text-align: left; padding: 20px;">

                                            @php($overallRating = \App\CPU\ProductManager::get_overall_rating($product['reviews']))
                                            <div class="rating-show" style="height:125px; ">
                                                <h5 style="font-weight: 600; color: {{$web_config['primary_color']}}">
                                                    {{\Illuminate\Support\Str::limit(Helpers::getItemName('products','name',$product->id),40)}}
                                                </h5>
                                                <span class="d-inline-block font-size-sm text-body">
                                                    @for($inc=0;$inc<5;$inc++)
                                                        @if($inc<$overallRating[0])
                                                            <i class="sr-star czi-star-filled active"></i>
                                                        @else
                                                            <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                                        @endif
                                                    @endfor
                                                    <label class="badge-style">( {{$product->reviews_count}} )</label>
                                                </span>
                                            </div>
                                            <div class="float-right">
                                                @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                                @if($productdiscount > 0)
                                                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                                                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                                    </strike>
                                                @endif
                                                <span class="text-accent" style="margin: 10px;font-size: 22px !important;">
                                                    {{\App\CPU\Helpers::currency_converter(
                                                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                                    )}}
                                                </span>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="recomanded-buy-button">
                                    <button class="buy_btn" style="color:{{$web_config['primary_color']}}"
                                            onclick="location.href='{{route('product',$product->slug)}}'">{{\App\CPU\Helpers::translate('buy_now')}}
                                    </button>
                                </div>

                            @endif
                        @endif
                    </div>

                </div>
            </div>
            {{--    --}}
        </section>
        {{--    --}}
        @endif

        @if(count($latest_products))
        <div class="row justify-content-center">
            {{-- Latest products --}}
            <div class="col-md-12 mt-0 mb-4 py-5" style="border-radius: 16px">
                <div class="latest-product-margin" style="margin-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right:0px' : 'left:0px'}}">
                    <div class="row mt-2 mx-0">
                        <div class="col-6 mb-4 px-0 text-start">
                            <span class="for-feature-title text-dark text-2xl" style="text-align: center;font-weight:700">{{ \App\CPU\Helpers::translate('latest_products')}}</span>
                        </div>
                        <div class="col-6 mb-4 sm:px-5 px-0 text-end">
                            <a class="text-capitalize btn-primary w-auto p-3 rounded-pill"
                               href="{{route('products',['data_from'=>'latest'])}}">
                                {{ \App\CPU\Helpers::translate('view_all')}}
                                <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left-circle mr-1 ml-n1 mt-0 float-left' : 'right-circle ml-1 mr-n1'}}"></i>
                            </a>
                        </div>
                    </div>

                    <div class="carousel-wrap" >
                        <div class="owl-carousel owl-theme p-2" id="new-arrivals-product">
                            @foreach($latest_products as $product)
                            @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
                                <div style="margin:2px;">
                                    @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>


@php($main_section_banner = \App\Model\Banner::where('banner_type','Main Section Banner')->where('published',1)->inRandomOrder()->first())
    @if (isset($main_section_banner))
    <div class="container rtl mb-3">
        <div class="row" >
            <div class="col-12 pl-0 pr-0">
                <a href="{{$main_section_banner->url}}"
                    style="cursor: pointer;">
                    <img class="d-block footer_banner_img" style="width: 100%;border-radius: 5px;height: auto !important;"
                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            src="{{asset('storage/app/public/banner')}}/{{\App\CPU\Helpers::get_prop('App\Model\Banner',$main_section_banner['id'],'image',session()->get('local')) ?? $main_section_banner['photo']}}">
                </a>
            </div>
        </div>
    </div>
    @endif

    @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
    <div class="container rtl mb-3" style="">
        <div class="col-md-12" style="background-color:white;padding:20px;border-radius:10px;">
            <div class="new_arrival_product" style="margin-left:-5px;">
                <div class="carousel-wrap" >
                    <div class="owl-carousel owl-theme p-2" id="new-arrivals-product">
                        @foreach($latest_products as $key=>$product)

                                @include('web-views.partials._product-card-1',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Banner  --}}
    <div class="container rtl mt-3 mb-3">
        <div class="row">
            @foreach(\App\Model\Banner::where('banner_type','Footer Banner')->where('published',1)->inRandomOrder()->take(2)->get() as $banner)
                <div class="col-md-12 mt-2">
                    <a href="{{$banner->url}}"
                        style="cursor: pointer;">
                         <img class="" style="width: 100%; border-radius:5px;height:auto;"
                              onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                              src="{{asset('storage/app/public/banner')}}/{{\App\CPU\Helpers::get_prop('App\Model\Banner',$banner['id'],'image',session()->get('local')) ?? $banner['photo']}}">
                     </a>
                </div>
            @endforeach
        </div>
    </div>
    {{-- Categorized product --}}
    @foreach($home_categories as $category)
        @if(count($category['products']))
        <section class="container rtl mb-3">
            <!-- Heading-->
            <div class="sm:ps-5 sm:pe-5 sm:py-5 ps-0 pe-0 bg-white rounded-md">
                <div class="flex-between sm:pe-4">
                    <div class="category-product-view-title ms-0 sm:ms-3" >
                        <span class="for-feature-title {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'float-right' : 'float-left'}}"
                                style="font-weight: 700;font-size: 20px;text-transform: uppercase;{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'text-align:right;' : 'text-align:left;'}}">
                                {{Str::limit($category['name'],38)}}
                        </span>
                    </div>
                    <div class="category-product-view-all" >
                        <a class="text-capitalize btn-primary w-auto p-3 rounded-pill"
                            href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">{{ \App\CPU\Helpers::translate('view_all')}}
                            <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left-circle mr-1 ml-n1 mt-0 float-left' : 'right-circle ml-1 mr-n1'}}"></i>
                        </a>

                    </div>
                </div>

                <div class="row mt-2 mb-3 d-flex justify-content-between">
                     <div class="col-md-12 col-12 ">
                        <div class="row d-flex" >
                            @foreach($category['products'] ?? [] as $key=>$product)
                            @if ($key<4)
                                <div class="col-md-3 col-6 mt-5 sm:mt-2 mt-md-0" style="">
                                    @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                </div>
                            @endif
                        @endforeach
                         </div>
                    </div>


                </div>
            </div>
        </section>
        @endif
    @endforeach

    @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
    @if ($business_mode == 'multi' && (\App\Model\BusinessSetting::where('type','show_sellers_section')->first()->value ?? ''))
    <section class="container bg-primary w-full px-5 py-10 justify-content-center text-center d-flex mb-10 overflow-hidden">
        <div class="wd-md-75p">
            <h2 class="mb-5 text-white">
                {{ Helpers::translate('Our Partners') }}
            </h2>
            <div class="owl-carousel owl-theme p-2" id="our-partners">
                @foreach (App\Model\Seller::where(['status' => 'approved','show_sellers_section' => true])->get() as $seller)
                <a href="{{route('shopView',['id'=>$seller['id']])}}" style="width: 68px;height: 68px;border-radius: 12px" class="text-center justify-content-center inline-block">
                    <img style="width: 68px;height: 68px;border-radius: 12px" src="{{asset('storage/app/public/shop')}}/{{$seller->shop->image ?? null}}" onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'" alt="">
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    @else
    <div class="container rtl">
        {{--  start  --}}
        <div id="features-section1" class="row mb-5 mt-8 d-sm-none d-lg-block pos-relative" dir="{{session()->get('direction') ?? 'rtl'}}" style="height:450px">
            <div class="col-lg-12 p-0 text-dark text-center">
                <strong class="text-dark text-center w-full h3 font-weight-bold" data-bs-aos="fade-up">
                    {{\App\CPU\Helpers::translate('Welcome To Masfufat')}}
                </strong>
            </div>
        </div>
    @endif




@endsection

@push('script')

@endpush

