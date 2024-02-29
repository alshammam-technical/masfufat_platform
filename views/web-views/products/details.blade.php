@extends('layouts.front-end.app')

@section('title',Helpers::get_prop('App\Model\Product',$product->id,'name'))

@push('css_or_js')
    <meta name="description" content="{{$product->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',Helpers::get_prop('App\Model\Product',$product->id,'name')) as $keyword) {{$keyword.' , '}} @endforeach">
    @if($product->added_by=='seller')
        @if($product->seller)
            <meta name="author" content="{{ $product->seller->shop?$product->seller->shop->name:$product->seller->f_name}}">
        @endif
    @elseif($product->added_by=='admin')
        <meta name="author" content="{{$web_config['name']->value}}">
    @endif
    <!-- Viewport-->

    @php
        $current_lang = session()->get('local');
    @endphp
    @if($product['meta_image']!=null)
        <meta property="og:image" content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"/>
    @endif

    @if($product['meta_title']!=null)
        <meta property="og:title" content="{{$product->meta_title}}"/>
        <meta property="twitter:title" content="{{$product->meta_title}}"/>
    @else
        <meta property="og:title" content="{{$product->name}}"/>
        <meta property="twitter:title" content="{{$product->name}}"/>
    @endif
    <meta property="og:url" content="{{route('product',[$product->slug])}}">

    @if($product['meta_description']!=null)
        <meta property="twitter:description" content="{!! $product['meta_description'] !!}">
        <meta property="og:description" content="{!! $product['meta_description'] !!}">
    @else
        <meta property="og:description"
              content="@foreach(explode(' ',Helpers::get_prop('App\Model\Product',$product->id,'name')) as $keyword) {{$keyword.' , '}} @endforeach">
        <meta property="twitter:description"
              content="@foreach(explode(' ',Helpers::get_prop('App\Model\Product',$product->id,'name')) as $keyword) {{$keyword.' , '}} @endforeach">
    @endif
    <meta property="twitter:url" content="{{route('product',[$product->slug])}}">

    <link rel="stylesheet" href="{{asset('public/assets/front-end/css/product-details.css')}}"/>
    <style>
        .msg-option {
            display: none;
        }

        .chatInputBox {
            width: 100%;
        }

        .go-to-chatbox {
            width: 100%;
            text-align: center;
            padding: 5px 0px;
            display: none;
        }

        .feature_header {
            display: flex;
            justify-content: center;
        }

        .btn-number:hover {
            color: {{$web_config['secondary_color']}};

        }

        .for-total-price {
            margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: -30%;
        }

        .feature_header span {
            padding- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 15px;
            font-weight: 700;
            font-size: 25px;
            background-color: #ffffff;
            text-transform: uppercase;
        }

        .flash-deals-background-image{
            background: {{$web_config['primary_color']}}10;
            border-radius:5px;
            width:125px;
            height:125px;
        }

        @media (max-width: 768px) {
            .feature_header span {
                margin-bottom: -40px;
            }

            .for-total-price {
                padding- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 30%;
            }

            .product-quantity {
                padding- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 4%;
            }

            .for-margin-bnt-mobile {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 7px;
            }

            .font-for-tab {
                font-size: 11px !important;
            }

            .pro {
                font-size: 13px;
            }
        }

        @media (max-width: 375px) {
            .for-margin-bnt-mobile {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 3px;
            }

            .for-discount {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

            .for-dicount-div {
                margin-top: -5%;
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: -7%;
            }

            .product-quantity {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 4%;
            }

        }

        @media (max-width: 500px) {
            .for-dicount-div {
                margin-top: -4%;
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: -5%;
            }

            .for-total-price {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: -20%;
            }

            .view-btn-div {

                margin-top: -9%;
                float: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}};
            }

            .for-discount {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 7%;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }

            .feature_header span {
                margin-bottom: -7px;
            }

            .for-mobile-capacity {
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 7%;
            }
        }
    </style>
    <style>
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }

        thead {
            background: {{$web_config['primary_color']}} !important;
            color: white;
        }
        .product-details-shipping-details{
            background: #ffffff;
            border-radius: 5px;
            font-size: 14;
            font-weight: 400;
            color: #212629;
        }
        .shipping-details-bottom-border{
            border-bottom: 1px #F9F9F9 solid;
        }


        @isset(json_decode($product->images)->$current_lang)
        @if(count(json_decode($product->images)->$current_lang) <= 3)
        .owl-next, .owl-prev{
            display: none;
        }
        @endif
        @endisset
    </style>
@endpush

@section('content')
    <?php
    $overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews);
    $rating = \App\CPU\ProductManager::get_rating($product->reviews);
    $decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings');
    $current_lang = session()->get('local');
    ?>
    <!-- Page Content-->
    <div class="w-full mt-4 rtl d-flex justify-content-center" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <!-- General info tab-->
        <div class="w-11/12" style="direction: {{session()->get('direction')}};">
            {{--    --}}
            <!-- Product gallery-->
            <div class="w-full mt-0">
                <div class="sm:columns-2">
                    <div class="sm:w-1/2 w-full sm:h-[440px]">
                        <div class="col-lg-12">
                            <div class="cz-product-gallery">
                                <div class="cz-preview">
                                    @if(strlen(Helpers::getItemName('products','promo_title',$product->id)) >= 5)
                                    <div class="p-2 text-dark w-75 promo-title {{Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') ?? 'top-right'}}" style="background-color: {{Helpers::get_prop('App\Model\Product',$product->id,'promo_bg') ?? '#373f50'}};">
                                        <strong style="opacity: 1;color: {{Helpers::get_prop('App\Model\Product',$product->id,'promo_text') ?? 'white'}} !important">{{Helpers::get_prop('App\Model\Product',$product->id,'promo_title')}}</strong>
                                    </div>
                                    @endif
                                    @if($product->images!=null)
                                        @foreach (json_decode($product->images)->$current_lang ?? [] as $key => $photo)
                                            <div
                                                class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                                id="image{{$key}}">
                                                <img class="sm:block hidden cz-image-zoom img-responsive" style="width:100%;max-height:323px;"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[$key] ?? '' : ''}}"
                                                    data-zoom="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[$key] ?? '' : ''}}"
                                                    alt="Product image" width="">
                                                <img class="sm:hidden block img-responsive" style="width:100%;max-height:323px;"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[$key] ?? '' : ''}}"
                                                    data-zoom="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[$key] ?? '' : ''}}"
                                                    alt="Product image" width="">
                                                <div class="cz-image-zoom-pane"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="cz">
                                    <div>
                                        <div class="row">
                                            <div class="table-responsive" data-bs-simplebar style="max-height: 515px; padding: 1px;">
                                                <div class="d-flex" id="cz-thumblist" style="padding-left: 3px;overflow: hidden;">
                                                    @if($product->images!=null)
                                                    @foreach (json_decode($product->images)->$current_lang ?? [] as $key => $photo)
                                                    <div class="cz-thumblist {{$key!==0?'ms-1':''}}">
                                                        <a class="cz-thumblist-item  {{$key==0?'active ms-0':''}} d-flex align-items-center justify-content-center "
                                                            href="#image{{$key}}">
                                                            <img onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                src="{{asset("storage/app/public/product/$current_lang/$photo")}}"
                                                                alt="Product thumb">
                                                        </a>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- Product details-->
                    <div class="sm:w-9/12 w-full mt-md-0 mt-sm-3 float-end" style="direction: {{ Session::get('direction') }}">
                        <div style="box-shadow: #afafaf 0px 0px 15px 0px;border-radius: 12px">
                            <div class="details border ht-100p p-0 bg-white border-0"
                                style="position: relative;border-radius: 12px">
                                <div class="row ps-5 pe-4 pt-3 mb-4">
                                    <div class="col-10 mt-3">
                                        <span class="mb-2"
                                            style="font-size: 22px;font-weight:800;color:black">{{Helpers::get_prop('App\Model\Product',$product->id,'name')}}</span>
                                    </div>
                                    <div class="col-2 text-end">
                                        <button type="button" onclick="@if ($countWishlist_)removeWishlistbutton({{ $product['id'] }}) @else addWishlist('{{$product['id']}}') @endif"
                                            class="btn for-hover-bg btn-white heart" style="color:{{$web_config['secondary_color']}};">
                                            <i class="ri-heart-fill h2 m-0" style="color:@if ($countWishlist_)
                                            #b70101
                                            @else
                                            #969696
                                            @endif " aria-hidden="true"></i>

                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2 pro ps-5 pe-4">
                                    @if ((\App\Model\BusinessSetting::where('type','products_rating')->first()->value ??
                                    '') && 1 == 2)
                                    <span
                                        class="d-inline-block  align-middle mt-1 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-md-2 ml-sm-0 pl-2' : 'mr-md-2 mr-sm-0 pr-2'}}"
                                        style="color: #FE961C">{{$overallRating[0]}}</span>
                                    <div class="star-rating"
                                        style="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left: 25px;' : 'margin-right: 25px;'}}">
                                        @for($inc=0;$inc<5;$inc++) @if($inc<$overallRating[0]) <i
                                            class="sr-star czi-star-filled active"></i>
                                            @else
                                            <i class="sr-star czi-star"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    @endif

                                    @if(\App\Model\BusinessSetting::where('type','products_rating')->first()->value ??
                                    '')

                                    <i style="color: gold" class="ri-star-fill"></i>
                                    <span style="font-weight: 400;"
                                        class="font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-1 ml-md-1 ml-1 pr-md-1 pr-sm-1 pl-md-1 pl-sm-1' : 'ml-1 mr-md-1 mr-1 pl-md-1 pl-sm-1 pr-md-1 pr-sm-1'}}">
                                        {{$overallRating[1]}} {{\App\CPU\Helpers::translate('Reviews')}}</span>
                                    @endif


                                    @if(\App\Model\BusinessSetting::where('type','orders_display')->first()->value ??
                                    '')
                                    <span class="me-2"
                                        style="width: 0px;height: 17px;border: 0.5px solid #D1D1D1; margin-top: 6px;font-weight: 400;">
                                    </span>
                                    <i style="color: blue" class="ri-box-3-fill"></i>
                                    <span style="font-weight: 400;"
                                        class="font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-1 ml-md-1 ml-1 pr-md-1 pr-sm-1 pl-md-1 pl-sm-1' : 'ml-1 mr-md-1 mr-1 pl-md-1 pl-sm-1 pr-md-1 pr-sm-1'}}">
                                        {{$countOrder}} {{\App\CPU\Helpers::translate('orders')}} </span>
                                    @endif


                                    @if(\App\Model\BusinessSetting::where('type','favorite')->first()->value ?? '')
                                    <span class="me-2"
                                        style="width: 0px;height: 17px;border: 0.5px solid #D1D1D1; margin-top: 6px;font-weight: 400;">
                                    </span>
                                    <i style="color: red" class="ri-heart-3-fill"></i>
                                    <span style="font-weight: 400;"
                                        class=" font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-1 ml-md-1 ml-0 pr-md-1 pr-sm-1 pl-md-1 pl-sm-1' : 'ml-1 mr-md-1 mr-0 pl-md-1 pl-sm-1 pr-md-1 pr-sm-1'}} text-capitalize">
                                        <span class="countWishlist-{{$product['id']}}">{{$countWishlist}}</span> {{\App\CPU\Helpers::translate('wish_listed')}} </span>
                                    @endif

                                </div>
                                <div class="ps-5 pe-4 mt-3 font-weight-bold" style="overflow: auto;max-height: 235px;">{{
                                    Helpers::get_prop('App\Model\Product',$product->id,'short_desc') }}</div>
                                <div class="pb-3 mt-7 ps-5 pe-4">
                                    <span class="col-6 text-accent text-success" style="font-size: 24px !important;">
                                        {{\App\CPU\Helpers::get_price_range($product) }}

                                        @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                                        @if($productdiscount > 0)
                                        <div>
                                            <strike style="font-size: 16px!important;color: #E96A6A!important;">
                                                {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                            </strike>
                                            <span style="font-size: 16px!important;" class="text-success mx-2">
                                                @if($productdiscount > 0)
                                                @php($productdiscount_type =
                                                Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
                                                @if ($productdiscount_type == 'percent')
                                                {{round($productdiscount)}}%
                                                @elseif($productdiscount_type =='flat')
                                                {{\App\CPU\Helpers::currency_converter($productdiscount)}}
                                                @endif {{\App\CPU\Helpers::translate('off_')}}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </span>
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-0' : 'ml-0'}} mb-2 d-block"
                                            @if(\App\Model\BusinessSetting::where('type','show_price_with_tax')->first()->value ?? '')
                                            @if($product->has_tax)
                                            <span class="d-inline-block" style="font-size: 10px;font-weight:400">
                                                <span class="text-muted ">{{\App\CPU\Helpers::translate('tax')}}:</span>
                                                <span class="mb-3 text-danger">{{ Helpers::currency_converter($product->unit_price * $product->tax / 100) }}</span>
                                            </span>
                                            @endif
                                            @endif

                                                @if(\App\CPU\Helpers::get_business_settings('shipping_cost_view'))
                                                <span class="d-inline-block mb-2">
                                                    <span
                                                        class="mb-3 text-black h5">{{\App\CPU\Helpers::translate('shipping cost')}}
                                                        : </span>
                                                    <span class="mb-3 text-black h5" id="shipping-cost">
                                                        {{\App\CPU\Helpers::currency_converter($product['shipping_cost'] ?? 0)}}
                                                    </span>
                                                </span>
                                                @endif
                                                <span class="mb-3 " id="chosen_price_div" style="display: inline-block;">
                                                    <div
                                                        class="d-flex justify-content-center align-items-center {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}">
                                                        <div class="product-description-label"><strong class="text-muted">{{\App\CPU\Helpers::translate('total_price')}}</strong>
                                                            : </div>
                                                        &nbsp; <strong class="text-success" style="color: black" id="chosen_price"></strong>
                                                    </div>
                                                </span>
                                            </span>
                                        </div>
                                        @php($display_product_qty = \App\Model\BusinessSetting::where('type','display_product_qty')->first()->value ?? '')
                                        @if($display_product_qty)
                                        <span class="col-6 text-muted" style="font-size: 18px !important;">
                                            {{ Helpers::translate('current stock') }} :
                                            <span class="text-success" style="font-size: 18px !important;">
                                                {{ $product->current_stock }}
                                            </span>
                                        </span>
                                        @endif

                                    </div>

                                </div>
                                <div class="mt-0 p-0 w-full">
                                    @php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 1)
                                    @php($minimum_order_qty = intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty)
                                    <form id="add-to-cart-form" class="mb-0" @csrf <input type="hidden" name="quantity"
                                        value="{{ $minimum_order_qty ?? 1 }}">
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        @if (count(json_decode($product->colors)) > 0)
                                        <div
                                            class="position-relative {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-n4' : 'mr-n4'}} mb-2">
                                            <div class="flex-start">
                                                <div class="product-description-label mt-2 text-body">
                                                    {{\App\CPU\Helpers::translate('color')}}:
                                                </div>
                                                <div>
                                                    <ul class="list-inline checkbox-color mb-1 flex-start {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                                        style="padding-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 0;">
                                                        @foreach (json_decode($product->colors) as $key => $color)
                                                        <div>
                                                            <li>
                                                                <input type="radio" id="{{ $product->id }}-color-{{ $key }}"
                                                                    name="color" value="{{ $color }}" @if($key==0) checked @endif>
                                                                <label style="background: {{ $color }};"
                                                                    for="{{ $product->id }}-color-{{ $key }}"
                                                                    data-bs-toggle="tooltip"></label>
                                                            </li>
                                                        </div>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php
                                                $qty = 0;
                                                if(!empty($product->variation)){
                                                    foreach (json_decode($product->variation) as $key => $variation) {
                                                        $qty += $variation->qty;
                                                    }
                                                }
                                            ?>
                                        </div>
                                        @endif
                                        @foreach (json_decode($product->choice_options) as $key => $choice)
                                        <div class="row flex-start mx-0 ps-5 pe-4">
                                            <div
                                                class="product-description-label text-body mt-2 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pl-2' : 'pr-2'}}">
                                                {{ $choice->title }}
                                                :
                                            </div>
                                            <div>
                                                <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2 mx-1 flex-start row"
                                                    style="padding-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 0;">
                                                    @foreach ($choice->options as $key => $option)
                                                    <div>
                                                        <li class="for-mobile-capacity">
                                                            <input type="radio" id="{{ $choice->name }}-{{ $option }}"
                                                                name="{{ $choice->name }}" value="{{ $option }}" @if($key==0)
                                                                checked @endif>
                                                            <label style="font-size: 12px;"
                                                                for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                                                        </li>
                                                    </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach

                                        @if(($product['product_type'] == 'physical') && ($product->current_stock <= 0))
                                            <div class="mx-2">
                                                <h5 class="mt-3 text-body" style="color: red !important;">
                                                    {{\App\CPU\Helpers::translate('out_of_stock')}}
                                                </h5>
                                            </div>
                                        @else
                                        <!-- Quantity + Add to cart -->
                                        <div>
                                            <div class="p-0 bg-primary">
                                                @php($max_order_qty = Helpers::getProductPrice_pl($product['id'])['max_qty'] ?? $product->current_stock)
                                                @php($max_order_qty = intval($max_order_qty) == 0 ? $product->current_stock : $max_order_qty)
                                                @php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 1)
                                                @php($minimum_order_qty = intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty)
                                                <div
                                                    class="px-4 product-quantity justify-content-between align-items-center rounded-bottom-11 bg-white">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="d-flex justify-content-center align-items-center border px-2 py-2 rounded-top-11 rounded-bottom-11 mb-3"
                                                                style="width: 160px;color: {{$web_config['primary_color']}}">
                                                                <span class="input-group-btn" style="">
                                                                    <button class="btn btn-number btn-minus" type="button" data-field="quantity" data-type="minus"
                                                                        style="padding-top: 4px;width: 30px;height: 30px;border-radius: 5px;background-color: black;opacity: inherit;"
                                                                        data-bs-type="minus" data-bs-field="quantity"
                                                                        mn-field="{{$minimum_order_qty}}" mx-field="{{$max_order_qty}}"
                                                                        disabled="disabled"
                                                                        style="padding: 10px;color: {{$web_config['primary_color']}}">
                                                                        <strong style="color: white;font-size: 24px">
                                                                            -
                                                                        </strong>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="quantity"
                                                                    class="form-control input-number text-center cart-qty-field quantity-input"
                                                                    id="cartQuantity{{$product['id']}}"
                                                                    onchange="updateCartQuantity('{{ intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty }}', '{{$product['id']}}', '{{ $max_order_qty }}')"
                                                                    placeholder="{{ intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty }}" value="{{ intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty }}"
                                                                    product-type="{{ $product->product_type }}"
                                                                    min="{{ intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty }}" max="{{intval($max_order_qty) == 0 ? 1 : $max_order_qty}}"
                                                                    style="padding: 0px !important;width: 40%;height: 35px;border:0px;font-size: 24px;font-weight: bold">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-number btn-plus" type="button" data-field="quantity" data-type="plus"
                                                                        product-type="{{ $product->product_type }}" data-bs-type="plus"
                                                                        style="padding-top: 4px;width: 30px;height: 30px;border-radius: 5px;background-color: black;opacity: inherit;"
                                                                        data-bs-field="quantity" mn-field="{{$minimum_order_qty}}"
                                                                        mx-field="{{$max_order_qty}}"
                                                                        style="padding: 10px;color: {{$web_config['primary_color']}}">
                                                                        <strong style="color: white;font-size: 24px">
                                                                            +
                                                                        </strong>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 pb-4">
                                                            @if(\App\Model\Product::where('parent_id',$product->id)->orWhere(function($qq)use($product){$qq->when($product->parent_id !== null,function($qqq)use($product){$qqq->where("id",$product->parent_id);});})->orWhere(function($q)use($product){$q->where("parent_id",$product->parent_id)->where("parent_id","!=",null);})->orderBy('name', 'asc')->first())
                                                            <select name="option" class="form-control" onchange="alert_wait();location.replace('{{ route('home') }}/product/'+$(this).val())">
                                                                <option selected disabled>{{ Helpers::translate('choose an option') }}</option>
                                                                @foreach (\App\Model\Product::where('parent_id',$product->id)->orWhere(function($qq)use($product){$qq->when($product->parent_id !== null,function($qqq)use($product){$qqq->where("id",$product->parent_id);});})->orWhere(function($q)use($product){$q->where("parent_id",$product->parent_id)->where("parent_id","!=",null);})->orderBy('name', 'asc')->get() as $key => $p)
                                                                <option value="{{ $p->slug }}">
                                                                    {{ \App\CPU\Helpers::getItemName('products','name',$p['id']) }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif


                                        @if (\App\CPU\Helpers::store_module_permission_check('store.products_details.add_to_cart') || \App\CPU\Helpers::store_module_permission_check('store.products_details.syncc'))
                                        <div class="text-center d-block pb-0 rounded-bottom-11 bg-primary">
                                            <div class="w-full" style="display: flex;align-items: flex-start;">
                                                @if (\App\CPU\Helpers::store_module_permission_check('store.products_details.add_to_cart'))
                                                @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') ==
                                                "purchase" ||
                                                (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
                                                <button class="_add-link btn btn-sm text-light rounded-start-11 rounded-end-0 rounded-top-0"
                                                    onclick="addToCart(this)" type="button"
                                                    style="margin-top:0px;padding-top:5px;padding-bottom:6px;padding-left:10px;padding-right:10px;width:  inherit;margin-{{(session('direction') ?? 'rtl') == 'rtl' ? 'left' : 'right' }}:1px; @if($product->current_stock == 0) background-color: #828282 !important; @elseif(Helpers::cart_check($product->id) == 1) background-color: #8471a6 !important;  @endif"
                                                    href="javascript:">
                                                    <div>
                                                        <p class="py-0 my-0">
                                                            <i class="ri-shopping-cart-fill text-white"></i>
                                                        </p>
                                                        <p class="py-0 mb-0 mt-2">
                                                            @if(Helpers::cart_check($product->id) == true)
                                                            {{ Helpers::translate("Added_to_cart") }}
                                                            @else
                                                            {{ Helpers::translate('add to cart') }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </button>
                                                @endif
                                                @endif
                                                @if (\App\CPU\Helpers::store_module_permission_check('store.products_details.syncc'))
                                                @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "add" ||
                                                (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
                                                <button
                                                class="btn @if(\App\CPU\Helpers::productChoosen($product->id) == 'linked')  bg-success @else bg-primary @endif  @if(\App\CPU\Helpers::productChoosen($product->id) == 'pending')  @else  @endif btn-sm btn-add-linked text-light rounded-end-11 rounded-start-0 rounded-top-0"
                                                    @if(Helpers::productChoosen($product->id) == 'no_linked_found')
                                                    onclick='Swal.fire({
                                                        title: "<strong>{{ Helpers::translate('no linked accounts') }}</strong>",
                                                        icon: "info",
                                                        html: `
                                                        {{ Helpers::translate('no linked accounts!') }}
                                                        <a target="_blank" href="{{ route('linked-accounts') }}">{{ Helpers::translate('click here to link') }}</a>
                                                        `,
                                                        showCloseButton: true,
                                                        showCancelButton: false,
                                                        focusConfirm: false,
                                                        confirmButtonAriaLabel: "{{ Helpers::translate('ok') }}",
                                                    });'
                                                    @elseif(\App\CPU\Helpers::productChoosen($product->id) == false)
                                                    onclick="addToLinked(event,this,{{$product['id']}})"
                                                    @endif
                                                    type="button"
                                                    style="margin-top:0px;padding-top:5px;padding-bottom:6px;padding-left:10px;padding-right:10px;width:
                                                    inherit;@if(\App\CPU\Helpers::productChoosen($product->id) == 'linked') background-color:#198754!important @elseif(\App\CPU\Helpers::productChoosen($product->id) == 'pending') background-color: #8471a6 !important;    @elseif($product->current_stock == 0) background-color: #828282 !important;   @endif">
                                                    <div>
                                                        <p class="py-0 my-0">
                                                            @if(\App\CPU\Helpers::productChoosen($product->id) == 'linked')  <i class="fa fa-check-circle text-white"></i> @else <i class="fa fa-store text-white"></i>@endif
                                                        </p>
                                                        <p class="py-0 mb-0 mt-2">
                                                            @if(\App\CPU\Helpers::productChoosen($product->id) == 'linked')  {{ Helpers::translate('synchronous') }} @elseif(\App\CPU\Helpers::productChoosen($product->id) == 'pending') {{ Helpers::translate('Added_to_list') }} @else {{ Helpers::translate('add to store') }}@endif
                                                        </p>
                                                    </div>
                                                </button>
                                                @endif
                                                @endif


                                            </div>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  seller  --}}
                {{--    --}}
                @php($products_for_review = App\Model\Product::where('added_by',$product->added_by)->where('user_id',$product->user_id)->withCount('reviews')->get())
                @if (App\CPU\Helpers::get_business_settings('chat_with_seller_status') !== 1)
                @endif
                <?php
                $total_reviews = 0;
                    foreach ($products_for_review as $item)
                    { $total_reviews += $item->reviews_count;
                    }
                ?>
                <div>

                    @if (App\CPU\Helpers::get_business_settings('chat_with_seller_status') == 1)
                    @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
                        @if ($storeId == '')
                        <a href="{{route('customer.auth.login')}}">
                            <div class="float-left" style="color:{{$web_config['primary_color']}};background: {{$web_config['primary_color']}}10;padding: 6px 15px 6px 15px;font-size:12px;">
                                <i class="fa fa-envelope"></i>
                            <span>{{\App\CPU\Helpers::translate('chat')}}</span>
                            </div>
                            </a>
                        @else

                        @endif
                    @endif
                    <div class="row">
                        {{--    --}}
                        @if (\App\Model\BusinessSetting::where('type','show_sellers_section')->first()->value ?? '')
                        <div class="col-12 sm:w-c98 w-min">
                            @if(\App\Model\BusinessSetting::where('type','show_seller_info')->first()->value ?? '')
                            <div style="background: #ffffff;border-radius: 13px;font-weight: 400;color: #212629;margin-top: 10px;" class="m-0 p-0">
                                {{--seller section--}}
                                <h5 class="text-start font-weight-bold mt-4 mb-0">{{\App\CPU\Helpers::translate('Seller_info')}}</h5>
                                @if($product->added_by=='seller')
                                    @if(isset($product->seller->shop))
                                        <div class="columns-1">
                                            <div class="w-full">
                                                <div class="d-flex">
                                                    <img style="height: 65px; width: 72px;height: auto; border-radius: 12px"
                                                        src="{{asset('storage/app/public/shop')}}/{{$product->seller->shop->image}}"
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        alt="">
                                                    <div class="ms-3 mt-3" style="font-weight: 700;font-size: 16px;max-width: max-content;display:block;white-space: nowrap">
                                                        {{$product->seller->shop->name}}

                                                        @if (\App\Model\BusinessSetting::where('type','show_sellers_products_count')->first()->value ?? '')
                                                        <div class="text-center d-flex mt-2" style="display: inline-block">
                                                            <span class="text-primary me-2" style="font-weight: 550;
                                                            font-size: 16px;">
                                                                {{$products_for_review->count()}}
                                                            </span>
                                                            <span class="text-primary" style="font-size: 16px;font-weight: 550">
                                                                {{\App\CPU\Helpers::translate('products')}}
                                                            </span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="w-1/3">
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="row d-flex justify-content-between">
                                        @if (App\CPU\Helpers::get_business_settings('chat_with_seller_status') == 1)
                                        <div class="col-12">
                                            <div class="d-flex">
                                                <div>
                                                    <img style="height: auto; width: 90px; border-radius: 50%"
                                                    src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'shop_header_icon'])->pluck('value')[0] ?? ''}}"
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        alt="">
                                                </div>
                                                <div class="px-0">
                                                    <span class="mt-2" style="font-weight: 700;font-size: 17px;max-width: auto;display:block">
                                                        {{$web_config['name']->value}}
                                                    </span>

                                                    {{--  products & rev  --}}
                                                        @php($products_for_review = App\Model\Product::where('added_by','admin')->where('user_id',$product->user_id)->withCount('reviews')->get())

                                                        <?php
                                                        $total_reviews = 0;
                                                            foreach ($products_for_review as $item)
                                                            { $total_reviews += $item->reviews_count;
                                                            }
                                                        ?>
                                                        <div class="mt-2 d-flex" style="max-height: 45px">
                                                            <div class="row d-flex justify-content-between me-1">
                                                                @if ((\App\Model\BusinessSetting::where('type','seller_products_rating')->first()->value ?? '') && 1 == 2)
                                                                <div class="col-12">
                                                                    <div class="" style="height: 79px;background:{{$web_config['primary_color']}}10;border-radius:5px;">
                                                                        <div class="text-center">
                                                                            <span style="color: {{$web_config['primary_color']}};font-weight: 700;
                                                                            font-size: 16px;">
                                                                                {{$total_reviews}}
                                                                            </span><br>
                                                                            <span style="font-size: 12px;">
                                                                                {{\App\CPU\Helpers::translate('reviews')}}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @if (\App\Model\BusinessSetting::where('type','show_sellers_products_count')->first()->value ?? '')
                                                                <div class="col-12">
                                                                    <div class="" style="height: 79px;border-radius:5px;">
                                                                        <div class="text-center d-flex mt-2">
                                                                            <span class="text-primary me-2" style="font-weight: 550;
                                                                            font-size: 16px;">
                                                                                {{$products_for_review->count()}}
                                                                            </span>
                                                                            <span class="text-primary" style="font-size: 16px;font-weight: 550">
                                                                                {{\App\CPU\Helpers::translate('products')}}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @if (\App\Model\BusinessSetting::where('type','show_sellers_section')->first()->value ?? '')
                                                            <a href="{{ route('shopView',[0]) }}" style="display: block;width:100%;text-align: center;z-index:1">
                                                                <button class="btn btn-primary px-8 mt-2" style="font-size: 12px">
                                                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                                                    {{\App\CPU\Helpers::translate('Visit Store')}}
                                                                </button>
                                                            </a>
                                                            @endif
                                                        </div>
                                                    {{--  products & rev  --}}
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endif
                        {{--    --}}
                    </div>
                    <div class="col-12 msg-option mt-2" id="msg-option">

                        <form action="">
                            <input type="text" class="seller_id" hidden seller-id="{{$product->seller->id }}">
                            <textarea shop-id="{{$product->seller->shop->id}}" class="chatInputBox"
                                    id="chatInputBox" rows="5"> </textarea>


                            <div class="row">
                                <button class="btn btn-secondary" style="color: white;display: block;width: 47%;margin: 3px;"
                                    id="cancelBtn">{{\App\CPU\Helpers::translate('cancel')}}
                                </button>
                                <button class="btn btn-success " style="color: white;display: block;width: 47%;margin: 3px;"
                                    id="sendBtn">{{\App\CPU\Helpers::translate('send')}}</button>
                            </div>

                        </form>

                    </div>

                    @if (\App\Model\BusinessSetting::where('type','show_sellers_section')->first()->value ?? '')
                    <a href="{{ route('shopView',[$product->seller->id]) }}">
                        <button class="btn btn-primary px-8 mt-2">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                            {{\App\CPU\Helpers::translate('Visit Store')}}
                        </button>
                    </a>
                    @endif
                </div>
                {{--    --}}
                {{--  seller  --}}

                    @if($product->props['is_shareable'] ?? false)
                    <div style="text-align:{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                        class="sharethis-inline-share-buttons"></div>
                    @endif
            </div>
        </div>

        {{--    --}}



    </div>
    <div class="w-full">
        {{--  @php($props_condition = $product['props'] && count($product['props']) && $product['props']['countries'] && $product['props']['areas'] && $product['props']['cities'] && $product['props']['provinces'] && $product['props']['selected_countries_show_quantity_number'])  --}}
        @php($props_condition = $product['props'] && count($product['props']) > 0 && !empty(array_filter((array) $product['props'])))
        @php($wdth = $props_condition ? 'w-1/4' : 'w-1/3')
        <div class="w-full mt-8" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
            <div class="w-full">
                <div class="w-full">
                    <div class=" mt-1">
                        <!-- Tabs-->
                        <ul class="nav nav-tabs lightSlider d-flex my-1 border-0" role="tablist"
                            style="margin-top:35px;overflow-x: auto;overflow-y:hidden;height: 55px;">
                            <li class="nav-item {{ $wdth }} text-center">
                                <a class="w-full nav-link sm:text-2xl text-sm active" href="#overview" data-bs-toggle="tab" role="tab"
                                    style="font-weight: 400">
                                    {{\App\CPU\Helpers::translate('description')}}
                                </a>
                            </li>
                            @if($props_condition)
                            <li class="nav-item {{ $wdth }} text-center">
                                <a class="w-full nav-link sm:text-2xl text-sm " href="#props" data-bs-toggle="tab" role="tab"
                                    style="font-weight: 400;">
                                    {{\App\CPU\Helpers::translate('Products Properties')}}
                                </a>
                            </li>
                            @endif
                            @if (\App\Model\BusinessSetting::where('type','products_rating')->first()->value ?? '')
                            <li class="nav-item {{ $wdth }} text-center">
                                <a class="w-full nav-link sm:text-2xl text-sm " href="#reviews" data-bs-toggle="tab" role="tab"
                                    style="font-weight: 400;">
                                    {{\App\CPU\Helpers::translate('reviews')}}
                                </a>
                            </li>
                            @endif

                            <li class="nav-item {{ $wdth }} text-center">
                                <a class="w-full nav-link sm:text-2xl text-sm " href="#specs" data-bs-toggle="tab" role="tab"
                                    style="font-weight: 400;">
                                    {{\App\CPU\Helpers::translate('specs')}}
                                </a>
                            </li>

                        </ul>
                        <div class="px-4 pt-lg-3 pb-3 mb-3 mr-0 mr-md-2"
                            style="background: #ffffff;border-radius:10px;min-height: auto;">
                            <div class="tab-content px-lg-3">
                                <!-- Tech specs tab-->
                                <div class="tab-pane fade active show" id="overview" role="tabpanel">
                                    <div class="row pt-2 specification">
                                        @if((($product->video_url[session()->get('local')] ?? null)!==null) && (filter_var($product->video_url[session()->get('local')], FILTER_VALIDATE_URL)))
                                        <div class="col-12 mb-4">
                                            <iframe width="420" height="315"
                                                src="{{$product->video_url[session()->get('local')]}}">
                                            </iframe>
                                        </div>
                                        @endif

                                        <div class="text-body col-lg-12 col-md-12" style="overflow: scroll;">
                                            {!! Helpers::get_prop('App\Model\Product',$product->id,'description') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="specs" role="tabpanel">
                                    <table class="table table-striped">
                                        @if( Helpers::getItemName('brands','name',$product['brand_id'])  != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Brand')}}</td>
                                            <td>
                                                <img width="50" class="mx-2"
                                                    src="{{asset('storage/app/public/brand')}}/{{ Helpers::get_prop('App\Model\Brand',$product['brand_id'],'image') ?? $product->brand['image'] }}"
                                                    alt="">
                                                {{ Helpers::getItemName('brands','name',$product['brand_id']) }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if($product['item_number'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Item Number')}}</td>
                                            <td>{{ $product['item_number'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['code'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('product_code_sku')}}</td>
                                            <td>{{ $product['code'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['gtin'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('gtin')}}</td>
                                            <td>{{ $product['gtin'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['mpn'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('mpn')}}</td>
                                            <td>{{ $product['mpn'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['hs_code'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('HS Code')}}</td>
                                            <td>{{ $product['hs_code'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['length'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Length')}}</td>
                                            <td>{{ $product['length'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['width'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Width')}}</td>
                                            <td>{{ $product['width'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['height'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Height')}}</td>
                                            <td>{{ $product['height'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['size'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Size')}}</td>
                                            <td>{{ $product['size'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['space'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('space')}}</td>
                                            <td>{{ $product['space'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['weight'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('weight')}}</td>
                                            <td>{{ $product['weight'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['unit'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Unit')}}</td>
                                            <td>{{ $product['unit'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['made_in'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('Made in')}}</td>
                                            <td>{{ $product['made_in'] }}</td>
                                        </tr>
                                        @endif
                                        @if($product['color'] != '')
                                        <tr>
                                            <td>{{\App\CPU\Helpers::translate('color')}}</td>
                                            <td>{{ $product['color'] }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="props" role="tabpanel">
                                    <table class="table table-striped">
                                        @foreach ($product['props'] ?? [] as $key=>$item)
                                        @isset($item['value'])
                                        @php($item = Helpers::json_($item))
                                        @if($key !== "is_shareable" && $key !== "show_product" && $key !==
                                        "selected_countries_show_quantity_number" && $key !== "countries" && $key !==
                                        "areas" && $key !== "cities" && $key !== "provinces")
                                        <tr>
                                            <td>{{  \App\CPU\Helpers::getItemName("products_props","name",$item['property'] ?? '') }}
                                            </td>
                                            <td>{{ isset($item['value']) ? $item['value'][session()->get('local') ?? 'ar'] : '' }}
                                            </td>
                                        </tr>
                                        @endif
                                        @endisset
                                        @endforeach
                                    </table>
                                </div>

                                @php($reviews_of_product = App\Model\Review::where('product_id',$product->id)->paginate(2))
                                <!-- Reviews tab-->
                                <div class="tab-pane fade show" id="reviews" role="tabpanel">
                                    <div class="row pt-2 pb-3">
                                        <div class="col-lg-4 col-md-5 ">
                                            <div class=" row d-flex justify-content-center align-items-center">
                                                <div class="col-12 d-flex justify-content-center align-items-center">
                                                    <h2 class="overall_review mb-2"
                                                        style="font-weight: 500;font-size: 50px;">
                                                        {{$overallRating[1]}}
                                                    </h2>
                                                </div>
                                                <div class="d-flex justify-content-center align-items-center star-rating ">
                                                    @if (round($overallRating[0])==5)
                                                    @for ($i = 0; $i < 5; $i++) <i
                                                        class="czi-star-filled font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                        </i>
                                                        @endfor
                                                        @endif
                                                        @if (round($overallRating[0])==4)
                                                        @for ($i = 0; $i < 4; $i++) <i
                                                            class="czi-star-filled font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                            </i>
                                                            @endfor
                                                            <i
                                                                class="czi-star font-size-sm text-muted {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                            @endif
                                                            @if (round($overallRating[0])==3)
                                                            @for ($i = 0; $i < 3; $i++) <i
                                                                class="czi-star-filled font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                                </i>
                                                                @endfor
                                                                @for ($j = 0; $j < 2; $j++) <i
                                                                    class="czi-star font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                                    </i>
                                                                    @endfor
                                                                    @endif
                                                                    @if (round($overallRating[0])==2)
                                                                    @for ($i = 0; $i < 2; $i++) <i
                                                                        class="czi-star-filled font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                                        </i>
                                                                        @endfor
                                                                        @for ($j = 0; $j < 3; $j++) <i
                                                                            class="czi-star font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                                            </i>
                                                                            @endfor
                                                                            @endif
                                                                            @if (round($overallRating[0])==1)
                                                                            @for ($i = 0; $i < 4; $i++) <i
                                                                                class="czi-star font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                                                </i>
                                                                                @endfor
                                                                                <i
                                                                                    class="czi-star-filled font-size-sm text-accent {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                                @endif
                                                                                @if (round($overallRating[0])==0)
                                                                                @for ($i = 0; $i < 5; $i++) <i
                                                                                    class="czi-star font-size-sm text-muted {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-1' : 'mr-1'}}">
                                                                                    </i>
                                                                                    @endfor
                                                                                    @endif
                                                </div>
                                                <div class="col-12 d-flex justify-content-center align-items-center mt-2">
                                                    <span class="text-center">
                                                        {{$reviews_of_product->total()}}
                                                        {{\App\CPU\Helpers::translate('ratings')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-7 pt-sm-3 pt-md-0">
                                            <div class="row d-flex align-items-center mb-2 font-size-sm">
                                                <div class="col-3 text-nowrap "><span
                                                        class="d-inline-block align-middle text-body">{{\App\CPU\Helpers::translate('Excellent')}}</span>
                                                </div>
                                                <div class="col-8">
                                                    <div class="progress text-body" style="height: 5px;">
                                                        <div class="progress-bar " role="progressbar"
                                                            style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[0] != 0) ? ($rating[0] / $overallRating[1]) * 100 : (0); ?>%;"
                                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1 text-body">
                                                    <span
                                                        class=" {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}} ">
                                                        {{$rating[0]}}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                <div class="col-3 text-nowrap "><span
                                                        class="d-inline-block align-middle ">{{\App\CPU\Helpers::translate('Good')}}</span>
                                                </div>
                                                <div class="col-8">
                                                    <div class="progress" style="height: 5px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[1] != 0) ? ($rating[1] / $overallRating[1]) * 100 : (0); ?>%; background-color: #a7e453;"
                                                            aria-valuenow="27" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <span
                                                        class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                        {{$rating[1]}}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                <div class="col-3 text-nowrap"><span
                                                        class="d-inline-block align-middle ">{{\App\CPU\Helpers::translate('Average')}}</span>
                                                </div>
                                                <div class="col-8">
                                                    <div class="progress" style="height: 5px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[2] != 0) ? ($rating[2] / $overallRating[1]) * 100 : (0); ?>%; background-color: #ffda75;"
                                                            aria-valuenow="17" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <span
                                                        class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                        {{$rating[2]}}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                <div class="col-3 text-nowrap "><span
                                                        class="d-inline-block align-middle">{{\App\CPU\Helpers::translate('Below Average')}}</span>
                                                </div>
                                                <div class="col-8">
                                                    <div class="progress" style="height: 5px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[3] != 0) ? ($rating[3] / $overallRating[1]) * 100 : (0); ?>%; background-color: #fea569;"
                                                            aria-valuenow="9" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <span
                                                        class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                        {{$rating[3]}}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row d-flex align-items-center text-body font-size-sm">
                                                <div class="col-3 text-nowrap"><span
                                                        class="d-inline-block align-middle ">{{\App\CPU\Helpers::translate('Poor')}}</span>
                                                </div>
                                                <div class="col-8">
                                                    <div class="progress" style="height: 5px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="background-color: {{$web_config['primary_color']}} !important;backbround-color:{{$web_config['primary_color']}};width: <?php echo $widthRating = ($rating[4] != 0) ? ($rating[4] / $overallRating[1]) * 100 : (0); ?>%;"
                                                            aria-valuenow="4" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <span
                                                        class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                        {{$rating[4]}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pb-4 mb-3">
                                        <div
                                            style="display: block;width:100%;text-align: center;background: #F3F4F5;border-radius: 5px;padding:5px;">
                                            <span
                                                class="text-capitalize">{{\App\CPU\Helpers::translate('Product Review')}}</span>
                                        </div>
                                    </div>
                                    <div class="row pb-4">
                                        <div class="col-12" id="product-review-list">
                                            @if(count($product->reviews)==0)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="text-danger text-center">
                                                        {{\App\CPU\Helpers::translate('product_review_not_available')}}
                                                    </h6>
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                        @if(count($product->reviews) > 0)
                                        <div class="col-12">
                                            <div class="card-footer d-flex justify-content-center align-items-center">
                                                <button class="btn"
                                                    style="background: {{$web_config['primary_color']}}; color: #ffffff"
                                                    onclick="load_review()">{{\App\CPU\Helpers::translate('view more')}}</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product carousel (You may also like)-->
    <div class="mx-md-10  mb-3 rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row flex-between w-full">
            <div class="text-capitalize" style="font-weight: 700; font-size: 30px;{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-right: 5px;' : 'margin-left: 5px;'}}">
                @if (count($relatedProducts)>0)
                <span>{{ \App\CPU\Helpers::translate('related Products')}}</span>
                @else
                <span>{{ \App\CPU\Helpers::translate('similar_products')}}</span>
                @endif
            </div>

            <div class="view_all d-flex justify-content-center align-items-center">
                <div>
                    @php($category=json_decode($product['category_ids']))
                    <a class="text-capitalize view-all-text" style="color:{{$web_config['primary_color']}} !important;{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'margin-left:10px;' : 'margin-right: 8px;'}}"
                       href="{{route('products',['id'=> $product['id'],'data_from'=>'product','page'=>1])}}">{{ \App\CPU\Helpers::translate('view_all')}}
                       <i class="czi-arrow-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left-circle mr-1 ml-n1 mt-1 ' : 'right-circle ml-1 mr-n1'}}"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Grid-->

        <!-- Product-->
        <div class="w-full">
            <div class="w-full flex flex-wrap mt-4">
                @if (count($relatedProducts)>0)
                    @foreach($relatedProducts as $key => $relatedProduct)
                        <div class="sm:w-1/5 w-1/2" style="margin-bottom: 20px;">
                        <div class="mx-2">
                            @include('web-views.partials._single-product',['product'=>$relatedProduct,'decimal_point_settings'=>$decimal_point_settings])
                        </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-danger text-center">{{\App\CPU\Helpers::translate('similar product_not_available')}}</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade rtl" id="show-modal-view" tabindex="-1" role="dialog" aria-labelledby="show-modal-image"
         aria-hidden="true" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="display: flex;justify-content: center">
                    <button class="btn btn-default"
                            style="border-radius: 50%;margin-top: -25px;position: absolute;{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: -7px;"
                            data-bs-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <img class="element-center" id="attachment-view" src="">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script type="text/javascript">
        cartQuantityInitialize();
        getVariantPrice();
        $('#add-to-cart-form input').on('change', function () {
            getVariantPrice();
        });

        function showInstaImage(link) {
            $("#attachment-view").attr("src", link);
            $('#show-modal-view').modal('toggle')
        }
    </script>
    <script>
        $( document ).ready(function() {
            load_review();
        });
        let load_review_count = 1;
        function load_review()
        {

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({
                    type: "post",
                    url: '{{route('review-list-product')}}',
                    data:{
                        product_id:{{$product->id}},
                        offset:load_review_count
                    },
                    success: function (data) {
                        $('#product-review-list').append(data.productReview)
                        if(data.not_empty == 0 && load_review_count>2){
                            toastr.info('{{\App\CPU\Helpers::translate('no more review remain to load')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            console.log('iff');
                        }
                    }
                });
                load_review_count++
        }
    </script>

    {{-- Messaging with shop seller --}}
    <script>
        $('#contact-seller').on('click', function (e) {
            // $('#seller_details').css('height', '200px');
            $('#seller_details').animate({'height': '276px'});
            $('#msg-option').css('display', 'block');
        });
        $('#sendBtn').on('click', function (e) {
            e.preventDefault();
            let msgValue = $('#msg-option').find('textarea').val();
            let data = {
                message: msgValue,
                shop_id: $('#msg-option').find('textarea').attr('shop-id'),
                seller_id: $('.msg-option').find('.seller_id').attr('seller-id'),
            }
            if (msgValue != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: '{{route('messages_store')}}',
                    data: data,
                    success: function (respons) {
                        console.log('send successfully');
                    }
                });
                $('#chatInputBox').val('');
                $('#msg-option').css('display', 'none');
                $('#contact-seller').find('.contact').attr('disabled', '');
                $('#seller_details').animate({'height': '125px'});
                $('#go_to_chatbox').css('display', 'block');
            } else {
                console.log('say something');
            }
        });
        $('#cancelBtn').on('click', function (e) {
            e.preventDefault();
            $('#seller_details').animate({'height': '114px'});
            $('#msg-option').css('display', 'none');
        });
    </script>

    <script type="text/javascript"
            src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons"
            async="async"></script>
            <script>
                $(document).ready(function(){
                    $('.nav-tabs .nav-link').on('click', function(e){
                        e.preventDefault();

                        $('.nav-tabs .nav-link').removeClass('active');
                        $('.tab-pane').removeClass('active show');

                        $(this).addClass('active');
                        var target = $(this).attr('href');
                        $(target).addClass('active show');
                    });
                });
                </script>
@endpush
