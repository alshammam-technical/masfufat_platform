@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('Shop Page'))

@push('css_or_js')
    @if($shop['id'] != 0)
        <meta property="og:image" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}"/>
        <meta property="og:title" content="{{ $shop->name}} "/>
        <meta property="og:url" content="{{route('shopView',[$shop['id']])}}">
    @else
        <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"/>
        <meta property="og:title" content="{{ $shop['name']}} "/>
        <meta property="og:url" content="{{route('shopView',[$shop['id']])}}">
    @endif
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    @if($shop['id'] != 0)
        <meta property="twitter:card" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}"/>
        <meta property="twitter:title" content="{{route('shopView',[$shop['id']])}}"/>
        <meta property="twitter:url" content="{{route('shopView',[$shop['id']])}}">
    @else
        <meta property="twitter:card"
              content="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"/>
        <meta property="twitter:title" content="{{route('shopView',[$shop['id']])}}"/>
        <meta property="twitter:url" content="{{route('shopView',[$shop['id']])}}">
    @endif

    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">


    <link href="{{asset('public/assets/front-end')}}/css/home.css" rel="stylesheet">
    <style>
        .btn{
            border-radius: 7px !important
        }
        .headerTitle {
            font-size: 34px;
            font-weight: bolder;
            margin-top: 3rem;
        }

        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}                       !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        /***********************************/
        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 6;
            height: 500px;
            top: 0;
            left: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 40px;
        }

        .sidepanel a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            right: 0px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 18px;
            cursor: pointer;
            background-color: #ffffff;
            color: #373f50;
            width: 40%;
            border: none;
        }
        .custom-control-label{
            z-index: 99;
        }

        .openbtn:hover {
            background-color: #444;
        }

        .for-display {
            display: block !important;
        }

        @media (max-width: 360px) {
            .openbtn {
                width: 59%;
            }

            .for-shoting-mobile {
                margin-right: 0% !important;
            }

            .for-mobile {

                margin-left: 10% !important;
            }

        }

        @media screen and (min-width: 375px) {

            .for-shoting-mobile {
                margin-right: 7% !important;
            }

            .custom-select {
                width: 86px;
            }


        }

        @media (max-width: 500px) {
            .for-mobile {

                margin-left: 27%;
            }

            .openbtn:hover {
                background-color: #fff;
            }

            .for-display {
                display: flex !important;
            }

            .for-shoting-mobile {
                margin-right: 11%;
            }

            .for-tab-display {
                display: none !important;
            }

            .openbtn-tab {
                margin-top: 0 !important;
            }
            .seller-details {
                justify-content: center !important;
                padding-bottom: 8px;
            }

        }

        @media screen and (min-width: 500px) {
            .openbtn {
                display: none !important;
            }


        }

        @media screen and (min-width: 800px) {


            .for-tab-display {
                display: none !important;
            }

        }

        @media (max-width: 768px) {
            .headerTitle {
                font-size: 23px;

            }

            .openbtn-tab {
                margin-top: 3rem;
                display: inline-block !important;
            }

            .for-tab-display {
                display: inline;
            }

        }


    </style>
@endpush

@section('content')

@php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row rtl">
            <!-- banner  -->
            <div class="col-lg-12 mt-2">
                <div style="background: white">
                    @if($shop['id'] != 0)
                        <img style="width:100%; height: 372px; max-height: 372px; border-radius: 10px;"
                             src="{{asset('storage/app/public/shop/banner')}}/{{Helpers::get_prop('App\Model\Seller',$seller_id,'banner',session()->get('local')) ?? $shop->banner}}"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             alt="">
                    @else
                        @php($banner=\App\CPU\Helpers::get_business_settings('shop_banner'))
                        <img style="width:100%; height: 372px; max-height: 372px; border-radius: 10px;"
                             src="{{asset("storage/app/public/shop")}}/{{$banner[session()->get('local')]??""}}"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             alt="">
                    @endif
                </div>
            </div>
            {{-- sidebar opener --}}
            <div class="col-md-3 mt-2 rtl" style=" width: 100%; text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                <a class="openbtn-tab" style="" onclick="openNav()">
                    <div style="font-size: 20px; font-weight: 600; text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}" class="for-tab-display"> ☰ {{\App\CPU\Helpers::translate('categories')}}</div>
                </a>
            </div>
            {{-- seller info+contact --}}
            <div class="col-lg-12 rtl" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                <div style="border-radius:10px;background: #ffffff;{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'padding-left:5px;' : 'padding-left:5px;'}}">
                    <div class="row d-flex justify-content-between seller-details" style="">
                        {{-- logo --}}
                        <div class="d-flex" style="padding:8px;">
                            <div class="">
                                @if($shop['id'] != 0)
                                    <img style="max-height: 115px;width:120px;max-width: 120px; border-radius: 5px;"
                                         src="{{asset('storage/app/public/shop')}}/{{$shop->image}}"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         alt="">
                                @else
                                    <img style="height: 120px;width:120px;max-width: 120px; border-radius: 5px;"
                                         src="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         alt="">
                                @endif
                            </div>
                            <div class="row col-8 mx-1 align-items-center" style="display:inline-block;">
                                <span class="ml-4 font-weight-bold ">
                                    @if($shop['id'] != 0)
                                        {{ $shop->name}}
                                    @else
                                        {{ $web_config['name']->value }}
                                    @endif
                                </span>
                                <div class="row ml-4 flex-start">
                                    @if (\App\Model\BusinessSetting::where('type','seller_products_rating')->first()->value ?? '')
                                    <div class="mr-3">

                                        @for($count=0; $count<5; $count++)
                                            @if($avg_rating >= $count+1)
                                                <i class="sr-star czi-star-filled active"></i>
                                            @else
                                                <i class="sr-star czi-star active" style="color:#fea569 !important"></i>
                                            @endif
                                        @endfor
                                        (<span class="ml-1">{{round($avg_rating,2)}}</span>)
                                    </div>
                                    @endif
                                    <div class="d-flex" style="font-size: 12px;">
                                        @if (\App\Model\BusinessSetting::where('type','seller_products_rating')->first()->value ?? '')
                                        <span>{{ $total_review}} {{\App\CPU\Helpers::translate('reviews')}} </span>
                                        <span style="border-left: 1px solid #C4C4C4;margin:5px;"></span>
                                        @endif
                                        @php($total_product = \App\Model\Product::where(['added_by' => 'seller','user_id' => $id])->count())
                                        @if (\App\Model\BusinessSetting::where('type','seller_orders')->first()->value ?? '')
                                        <span>{{ $total_order}} {{\App\CPU\Helpers::translate('orders')}}</span>
                                        @endif
                                        @if (\App\Model\BusinessSetting::where('type','show_sellers_products_count')->first()->value ?? '')
                                            <span style="border-left: 1px solid #C4C4C4;margin:5px;"></span>
                                            <span>{{ $total_product }} {{\App\CPU\Helpers::translate('Product')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex  align-items-center" style="margin-bottom: -6px;
                        margin-top: 20px;
                        padding-right: 0px;">
                            {{--  <div class="col-md-6 m-2 m-md-0 d-flex align-items-center justify-content-end">
                                <div class="btn-group-vertical top-[50%] left-6 z-10" id="selection-buttons-container" style="display: none; position: fixed; transform: translateY(-50%);">
                                    <button class="btn bg-primaryColor addto-list with-transitions mb-3" id="selectAllButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16" style="margin-left: 10px;margin-right: 10px;">
                                            <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                          </svg>
                                        {{\App\CPU\Helpers::translate('Select All Products')}}
                                    </button>

                                    <button class="btn bg-primaryColor addto-list with-transitions" id="deselectAllButton">
                                        <svg viewBox="147.713 148.346 15 14" width="32" height="32" fill="#fff" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="margin-left: 10px;margin-right: 10px;">
                                            <path d="M 154.713 149.846 C 154.713 149.57 154.937 149.346 155.213 149.346 L 162.213 149.346 C 162.489 149.346 162.713 149.57 162.713 149.846 L 162.713 150.846 C 162.713 151.122 162.489 151.346 162.213 151.346 L 155.213 151.346 C 154.937 151.346 154.713 151.122 154.713 150.846 L 154.713 149.846 Z M 149.713 148.346 C 148.609 148.346 147.713 149.241 147.713 150.346 L 147.713 152.346 C 147.713 153.45 148.609 154.346 149.713 154.346 L 151.713 154.346 C 152.818 154.346 153.713 153.45 153.713 152.346 L 153.713 150.346 C 153.713 149.241 152.818 148.346 151.713 148.346 L 149.713 148.346 Z M 149.713 156.346 C 148.609 156.346 147.713 157.241 147.713 158.346 L 147.713 160.346 C 147.713 161.45 148.609 162.346 149.713 162.346 L 151.713 162.346 C 152.818 162.346 153.713 161.45 153.713 160.346 L 153.713 158.346 C 153.713 157.241 152.818 156.346 151.713 156.346 L 149.713 156.346 Z M 154.713 157.846 C 154.713 157.57 154.937 157.346 155.213 157.346 L 162.213 157.346 C 162.489 157.346 162.713 157.57 162.713 157.846 L 162.713 158.846 C 162.713 159.122 162.489 159.346 162.213 159.346 L 155.213 159.346 C 154.937 159.346 154.713 159.122 154.713 158.846 L 154.713 157.846 Z M 154.713 152.846 C 154.713 152.57 154.937 152.346 155.213 152.346 L 160.213 152.346 C 160.598 152.346 160.839 152.762 160.646 153.096 C 160.557 153.251 160.392 153.346 160.213 153.346 L 155.213 153.346 C 154.937 153.346 154.713 153.122 154.713 152.846 M 154.713 160.846 C 154.713 160.57 154.937 160.346 155.213 160.346 L 160.213 160.346 C 160.598 160.346 160.839 160.762 160.646 161.096 C 160.557 161.251 160.392 161.346 160.213 161.346 L 155.213 161.346 C 154.937 161.346 154.713 161.122 154.713 160.846" transform="matrix(1, 0, 0, 1, 0, -2.842170943040401e-14)"/>
                                          </svg>
                                        {{\App\CPU\Helpers::translate('UnSelect All Products')}}
                                    </button>
                                </div>
                            </div>  --}}
                            <div class="col-md-6 m-2 m-md-0 d-flex align-items-center justify-content-end">
                                <div class="btn-group top-[50%] left-6 z-10" id="selection-buttons-container" style="display: none; position: fixed; transform: translateY(-50%);    left: 10rem;">
                                  <button class="btn bg-primaryColor addto-list with-transitions mb-3 d-flex align-items-center justify-content-center" id="selectAllButton" style="border-radius: 0.25rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16" style="margin-left: 10px;margin-right: 10px;">
                                        <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                      </svg>
                                    <span>{{\App\CPU\Helpers::translate('Select All Products')}}</span>
                                  </button>

                                  <button class="btn bg-primaryColor addto-list with-transitions d-flex align-items-center justify-content-center" id="deselectAllButton" style="border-radius: 0.25rem;">
                                    <svg viewBox="147.713 148.346 15 14" width="32" height="32" fill="#fff" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="margin-left: 10px;margin-right: 10px;">
                                        <path d="M 154.713 149.846 C 154.713 149.57 154.937 149.346 155.213 149.346 L 162.213 149.346 C 162.489 149.346 162.713 149.57 162.713 149.846 L 162.713 150.846 C 162.713 151.122 162.489 151.346 162.213 151.346 L 155.213 151.346 C 154.937 151.346 154.713 151.122 154.713 150.846 L 154.713 149.846 Z M 149.713 148.346 C 148.609 148.346 147.713 149.241 147.713 150.346 L 147.713 152.346 C 147.713 153.45 148.609 154.346 149.713 154.346 L 151.713 154.346 C 152.818 154.346 153.713 153.45 153.713 152.346 L 153.713 150.346 C 153.713 149.241 152.818 148.346 151.713 148.346 L 149.713 148.346 Z M 149.713 156.346 C 148.609 156.346 147.713 157.241 147.713 158.346 L 147.713 160.346 C 147.713 161.45 148.609 162.346 149.713 162.346 L 151.713 162.346 C 152.818 162.346 153.713 161.45 153.713 160.346 L 153.713 158.346 C 153.713 157.241 152.818 156.346 151.713 156.346 L 149.713 156.346 Z M 154.713 157.846 C 154.713 157.57 154.937 157.346 155.213 157.346 L 162.213 157.346 C 162.489 157.346 162.713 157.57 162.713 157.846 L 162.713 158.846 C 162.713 159.122 162.489 159.346 162.213 159.346 L 155.213 159.346 C 154.937 159.346 154.713 159.122 154.713 158.846 L 154.713 157.846 Z M 154.713 152.846 C 154.713 152.57 154.937 152.346 155.213 152.346 L 160.213 152.346 C 160.598 152.346 160.839 152.762 160.646 153.096 C 160.557 153.251 160.392 153.346 160.213 153.346 L 155.213 153.346 C 154.937 153.346 154.713 153.122 154.713 152.846 M 154.713 160.846 C 154.713 160.57 154.937 160.346 155.213 160.346 L 160.213 160.346 C 160.598 160.346 160.839 160.762 160.646 161.096 C 160.557 161.251 160.392 161.346 160.213 161.346 L 155.213 161.346 C 154.937 161.346 154.713 161.122 154.713 160.846" transform="matrix(1, 0, 0, 1, 0, -2.842170943040401e-14)"/>
                                      </svg>
                                    <span>{{\App\CPU\Helpers::translate('UnSelect All Products')}}</span>
                                  </button>
                                </div>
                              </div>

                        </div>
                        </div>

                        {{-- contact --}}
                        @if (\App\CPU\Helpers::store_module_permission_check('store.sellerview.send_message'))
                        <div class="d-flex align-items-center">
                            <div class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-4' : 'mr-4'}}">
                                @if($seller_id!=0)
                                @if ((auth('customer')->check() || auth('delegatestore')->check()))
                                @if (App\CPU\Helpers::get_business_settings('chat_with_seller_status') == 1)
                                    <div class="d-flex">
                                        <a href="{{route('chat',['type'=>'seller'])}}" class="btn btn-block" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" style="border-radius: 25px;border: 1px solid #673bb7;color: ##673bb7 ;">
                                            <i class="fa fa-envelope mx-2" aria-hidden="true"></i>
                                            {{\App\CPU\Helpers::translate('Chat with seller ')}}
                                        </a>
                                    </div>
                                    {{--  <div class="d-flex">
                                        <button class="btn btn-block" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal" style="border-radius: 25px;border: 1px solid #1B7FED;color: #1B7FED ;">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            {{\App\CPU\Helpers::translate('Chat with seller ')}}
                                        </button>
                                    </div>  --}}
                                @else

                                @endif
                            @endif
                            @endif
                            </div>
                        </div>
                        @endif


                    </div>
                </div>

                {{-- Modal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="card-header">
                                {{\App\CPU\Helpers::translate('write_something')}}
                            </div>
                            <div class="modal-body">
                                <form action="{{route('messages_store')}}" method="post" id="chat-form">
                                    @csrf
                                    @if($shop['id'] != 0)
                                        <input value="{{$shop->id}}" name="shop_id" hidden>
                                        <input value="{{$shop->seller_id}}}" name="seller_id" hidden>
                                    @endif

                                    <textarea name="message" class="form-control" required></textarea>
                                    <br>
                                    @if($shop['id'] != 0)
                                        <button class="btn bg-primaryColor text-light" style="color: white;">{{\App\CPU\Helpers::translate('send')}}</button>
                                    @else
                                        <button class="btn bg-primaryColor text-light" style="color: white;" disabled>{{\App\CPU\Helpers::translate('send')}}</button>
                                    @endif
                                </form>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('chat', ['type' => 'seller'])}}" class="btn bg-primaryColor mx-1">
                                    {{\App\CPU\Helpers::translate('go_to chatbox')}}
                                </a>
                                <button type="button" class="btn btn-secondary pull-right" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>


        <div class="row mt-1 mr-0 rtl">
            {{-- sidebar (Category) - before toggle --}}
            <div class="col-lg-3 mt-3  mr-0 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pl-4' : 'pr-4'}}">
                <aside class=" hidden-xs SearchParameters" id="SearchParameters">
                    <!-- Categories Sidebar-->
                    <div class=" rounded-lg " id="shop-sidebar">
                        <div class="">
                            <!-- Categories-->
                            <div class="widget widget-categories mb-4 ">
                                <div>
                                    <div class="text-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}" style="display: block;">
                                        <h3 class="widget-title"
                                            style="font-weight: 700;font-size: 18px;display: inline;">{{\App\CPU\Helpers::translate('categories')}}</h3>
                                    </div>
                                </div>

                                <div class="accordion mt-2" id="shop-categories">
                                    @foreach($categories as $category)
                                        <div class="card" style="border-bottom: 2px solid #EEF6FF;background:none !important; ">



                                            <div class="card-header p-1 flex-between" >
                                                <div class="d-flex ">
                                                    <img class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'ml-2' : 'mr-2'}}" style="width: 20px; border-radius:5px;height:20px;"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset('storage/app/public/category')}}/{{$category['icon']}}">
                                                    <label class="for-hover-lable" style="cursor: pointer"
                                                        onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$category['id']])}}'" {{--onclick="productSearch({{$seller_id}}, {{$category['id']}})"--}}>
                                                        {{$category['name']}}
                                                    </label>
                                                </div>
                                                <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                        onclick="$('#collapse-{{$category['id']}}').toggle(400)">
                                                    {{$category->childes->count()>0?'+':''}}
                                                </strong>
                                            </div>
                                            <div class="card-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-{{$category['id']}}"
                                                 style="display: none">
                                                @foreach($category->childes as $child)
                                                    <div class=" for-hover-lable card-header p-1 flex-between">
                                                        <label style="cursor: pointer"
                                                               onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$child['id']])}}'">
                                                            {{$child['name']}}
                                                        </label>
                                                        <strong class="pull-right" style="cursor: pointer"
                                                                onclick="$('#collapse-{{$child['id']}}').toggle(400)">
                                                            {{$child->childes->count()>0?'+':''}}
                                                        </strong>
                                                    </div>
                                                    <div class="card-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-{{$child['id']}}"
                                                         style="display: none">
                                                        @foreach($child->childes as $ch)
                                                            <div class="card-header p-1 flex-between">
                                                                <label class="for-hover-lable" style="cursor: pointer"
                                                                       onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$ch['id']])}}'">
                                                                    {{$ch['name']}}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            {{-- sidebar (Category mobile) - after toggle --}}
            <div id="mySidepanel" class="sidepanel d-md-none" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right:0; left:auto' : 'right:auto; left:0'}};">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                <div class="cz-sidebar-body">
                    <div class="widget widget-categories mb-4 pb-4 border-bottom">
                        <div>
                            <div style="display: inline">
                                <h3 class="widget-title"
                                    style="font-weight: 700;display: inline">{{\App\CPU\Helpers::translate('categories')}}</h3>
                            </div>
                        </div>
                        <div class="divider-role"
                             style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: 5px;"></div>
                        <div class="accordion mt-n1" id="shop-categories" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                            @foreach($categories as $category)
                                <div class="card">
                                    <div class="card-header p-1 flex-between">
                                        <label class="for-hover-lable" style="cursor: pointer"
                                               onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$category['id']])}}'" {{--onclick="productSearch({{$seller_id}}, {{$category['id']}})"--}}>
                                            {{$category['name']}}
                                        </label>
                                        <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                onclick="$('#collapse-m-{{$category['id']}}').toggle(400)">
                                            {{$category->childes->count()>0?'+':''}}
                                        </strong>
                                    </div>
                                    <div class="card-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-m-{{$category['id']}}"
                                         style="display: none">
                                        @foreach($category->childes as $child)
                                            <div class=" for-hover-lable card-header p-1 flex-between">
                                                <label style="cursor: pointer"
                                                       onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$child['id']])}}'">
                                                    {{$child['name']}}
                                                </label>
                                                <strong class="pull-right" style="cursor: pointer"
                                                        onclick="$('#collapse-m-{{$child['id']}}').toggle(400)">
                                                    {{$child->childes->count()>0?'+':''}}
                                                </strong>
                                            </div>
                                            <div class="card-body {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-m-{{$child['id']}}"
                                                 style="display: none">
                                                @foreach($child->childes as $ch)
                                                    <div class="card-header p-1 flex-between">
                                                        <label class="for-hover-lable" style="cursor: pointer"
                                                               onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$ch['id']])}}'">
                                                            {{$ch['name']}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- main body (Products) --}}
            <div class="col-lg-9 product-div">
                <div class="row d-flex justify-content-end">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 pt-2" style="direction: ltr;">
                        <form class="{{--form-inline--}} md-form form-sm mt-0" method="get"
                              action="{{route('shopView',['id'=>$seller_id])}}">
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control" name="product_name" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                       placeholder="{{\App\CPU\Helpers::translate('Search products from this store')}}" aria-label="Recipient's username"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append" >
                                    <button type="submit" class="input-group-text" id="basic-addon2" style="background: #F3F5F9">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Products grid-->
                <div class="row" id="ajax-products">
                    @include('web-views.products._ajax-products',['products'=>$products,'decimal_point_settings'=>$decimal_point_settings])
                </div>
                <div class="row mt-3" id="ajax-products2">
                    <div class='w-full please_wait' style="display: none"><center><img width='100px' src='{{asset('public/assets/front-end/img/loader_.gif')}}' /></center></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var done = false;
        var page = 1;
        var st = $(window).scrollTop();
        function scrlload(e){
            if(!done){
                $('.please_wait').show();
            }
            elem = $(e.target);
            let bottomOfPage = document.body.scrollHeight - window.innerHeight;
            if (window.scrollY >= bottomOfPage - 100) {
                // User is close to the bottom of the page
                st = $(window).scrollTop()
                page = page + 1;
                $.ajax({
                    url:"{{route('shopView',['id'=>$id])}}",
                    data: {
                        lazy:true,
                        page:page,
                    },
                    success: function(data){
                        if (data) {
                            $(data).appendTo("#ajax-products");
                            //$(".please_wait").hide();
                        } else {
                            done = true
                        }
                    }
                }).then(function(){
                    if($('.inline_product').length == {{$products->total()}}){
                        $(".please_wait").hide();
                    }
                })
            }
        }

        $(document).ready(function(){
            var lastScrollTop = 0;
            var scrollThreshold = 2500;
            $(document).on("scroll",function(e){
                scrlload(e)
            })
        })

        function productSearch(seller_id, category_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{url('/')}}/shopView/' + seller_id + '?category_id=' + category_id,

                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>

    <script>
        function openNav() {

            document.getElementById("mySidepanel").style.width = "50%";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>

    <script>
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{route('messages_store')}}',
                data: $('#chat-form').serialize(),
                success: function (respons) {

                    toastr.success('{{\App\CPU\Helpers::translate('send successfully')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#chat-form').trigger('reset');
                }
            });

        });
    </script>
@endpush
