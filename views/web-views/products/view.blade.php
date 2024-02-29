@extends('layouts.front-end.app')

@section('title',ucfirst($data['data_from']).' products')

@push('css_or_js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']}}"/>
    <meta property="og:title" content="Products of {{$web_config['name']}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']}}"/>
    <meta property="twitter:title" content="Products of {{$web_config['name']}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    @if(auth('delegatestore')->check())

    <style>
        .header56{
            margin-top: 40px !important;
        }
    </style>
    @endif

    <style>
        .btn{
            padding: 0.375rem 0.5rem !important;
            border-radius: 11px;
            border-radius: 7px !important
        }
        @media (min-width: 640px){
            #content{
                padding-top: 0px !important;
                margin-top: 76px !important;
            }
        }

        .headerTitle {
            font-size: 26px;
            font-weight: bolder;
            margin-top: 3rem;
        }

        .for-count-value {
            position: absolute;

        {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 0.6875 rem;;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;

            color: black;
            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .for-count-value {
            position: absolute;

        {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 0.6875 rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .for-brand-hover:hover {
            color: {{$web_config['primary_color']}};
        }

        .for-hover-lable:hover {
            color: {{$web_config['primary_color']}}       !important;
        }

        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}      !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .for-shoting {
            font-weight: 600;
            font-size: 14px;
            padding- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 9px;
            color: #030303;
        }

        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 6;
            height: 500px;
            top: 0;
        {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 0;
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
        {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 25 px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 18px;
            cursor: pointer;
            background-color: transparent !important;
            color: #373f50;
            width: 40%;
            border: none;
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
                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 0% !important;
            }

            .for-mobile {

                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

        }

        @media (max-width: 500px) {
            .for-mobile {

                margin- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}: 27%;
            }

            .openbtn:hover {
                background-color: #fff;
            }

            .for-display {
                display: flex !important;
            }

            .for-tab-display {
                display: none !important;
            }

            .openbtn-tab {
                margin-top: 0 !important;
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
        <style>
            .SumoSelect{
                display: block !important;
            }
            .SumoSelect>.CaptionCont{
                height: 46px !important;
                direction: ltr !important;
                border-color: rgb(208, 219, 233) !important;
            }
            .SumoSelect>.CaptionCont>span.placeholder{
                margin-top: 7px !important;
                color: #212529 !important ;
                font-style: normal !important;
                font-size: 16px !important;

            }
            .SumoSelect>.CaptionCont>label{
                left: 0 !important;
            }
            .SumoSelect>.CaptionCont>label>i{
                background: #fff url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='%2371869d' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.72,15.78a.75.75,0,0,1-.53.22h-.38a.77.77,0,0,1-.53-.22L6.15,10.64a.5.5,0,0,1,0-.71l.71-.71a.49.49,0,0,1,.7,0L12,13.67l4.44-4.45a.5.5,0,0,1,.71,0l.7.71a.5.5,0,0,1,0,.71Z'/%3E%3C/svg%3E") no-repeat left 0.5rem center/1rem 1rem !important;
                width: 31px !important;
                height: 28px !important;
                top: 5px !important;
            }
            .SumoSelect>.CaptionCont>span{
                margin-top: 7px !important;
                padding-right: 19px !important;
              }
    </style>
@endpush

@section('content')
@if (session('user_type') == 'delegate')
    <style>
        .fillt{
            padding-top: 4.75rem !important;
        }
    </style>
@endif
@php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))
    <!-- Page Content-->
    @php($main_section_banner = \App\Model\Banner::where('resource_type',request('data_from'))->where('resource_id',request('id'))->where('published',1)->inRandomOrder()->first())
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
    <div class="sm:mx-0 pb-0 mb-2 mb-md-0 rtl"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
         <div class="row">
            <div>
            </div>
         </div>
        <div class="d-block bg-light py-1 px-5 sticky sm:top-[25px] top-0 z-10 p-5 fillt">
            <div id="filters">
                <div class="row">
                    <h1 class="col-md-2 col-12 pt-2 px-4">
                        <label id="price-filter-count"> <span id="total_product"></span> {{\App\CPU\Helpers::translate('items found')}} </label>
                    </h1>
                    <div class="col-md-2 col-12 px-1 mb-2 sm:mb-0">
                        <!-- Search-->
                            <div class="input-group-overlay d-block mx-0"
                                style="height: 45px;text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}">
                                <input class="form-control w-full bg-transparent border-0 text-center placeholder-black" type="text"
                                    autocomplete="off"
                                    onchange="search = $(this).val();nodata=true;page=0;$('#ajax-products').html('');page = 0;$('#ajax-products').scroll()"
                                    placeholder="{{\App\CPU\Helpers::translate('search')}}"
                                    value="{{ request('name') }}"
                                    style="height: 45px;color: black">
                                <button class="input-group-append-overlay search_button bg-transparent" type="submit"
                                        style="background-color: white;border-radius: {{(Session::get('direction') ?? 'rtl') === "rtl" ? '7px 0px 0px 7px; right: unset; left: 0' : '0px 7px 7px 0px; left: unset; right: 0'}};top:0;border:none">
                                        <span class="input-group-text" style="font-size: 20px;">
                                            <i class="ri-search-2-line font-size-xl" style="color: black"></i>
                                        </span>
                                </button>
                                <input name="data_from" value="search" hidden>
                                <input name="page" value="1" hidden>

                            </div>
                        <!-- end Search-->
                    </div>

                    <div class="col-md-2 col-3 px-1">
                        <select onchange="order_by = $(this).val();nodata=true;page=0;$('#ajax-products').html('');page = 0;$('#ajax-products').scroll()" style="width: 100%;border-radius: 5px !important;"
                            class="form-control custom-select">
                            <option value="0">{{\App\CPU\Helpers::translate('All Products')}}</option>
                            <option @if(request('order_by') == "latest") selected @endif value="latest">{{\App\CPU\Helpers::translate('Latest')}}</option>
                            <option @if(request('order_by') == "low-high") selected @endif
                                value="low-high">{{\App\CPU\Helpers::translate('Low_to_High Price')}} </option>
                            <option @if(request('order_by') == "high-low") selected @endif
                                value="high-low">{{\App\CPU\Helpers::translate('High_to_Low Price')}}</option>
                            <option @if(request('order_by') == "q-low-high") selected @endif
                                value="q-low-high">{{\App\CPU\Helpers::translate('Low_to_High quantity')}}</option>
                            <option @if(request('order_by') == "q-high-low") selected @endif
                                value="q-high-low">{{\App\CPU\Helpers::translate('High_to_Low quantity')}}</option>
                            <option value="best-selling" @if(request('order_by')=='best-selling') selected @endif>
                                {{\App\CPU\Helpers::translate('best_selling_product')}}</option>
                            <option value="top-rated" @if(request('order_by')=='top-rated') selected @endif>
                                {{\App\CPU\Helpers::translate('top_rated')}}</option>
                            <option value="most-favorite" @if(request('order_by')=='most-favorite') selected @endif>
                                {{\App\CPU\Helpers::translate('most_favorite')}}</option>
                            <option value="featured_deal" @if(request('order_by')=='featured_deal') selected @endif>
                                {{\App\CPU\Helpers::translate('featured_deal')}}</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-3 px-1">
                        <select onchange="brand_id = $(this).val();console.log(brand_id);nodata=true;page=0;$('#ajax-products').html('');page = 0;$('#ajax-products').scroll()" style="background: #ffffff; appearance: auto;width: 100%;border-radius: 5px !important;"
                            class="form-control custom-select SumoSelect-custom selec2">
                            <option icon='' value="0">{{ Helpers::translate('all Brands') }}</option>
                            @foreach(\App\CPU\BrandManager::get_active_brands() as $brand)
                            <option @if(request('brand_id') == $brand['id']) selected @endif
                            icon="{{asset('storage/app/public/brand')}}/{{(\App\CPU\Helpers::get_prop('App\Model\Brand',$brand['id'],'image',session()->get('local')) ?? $brand['image'])}}"
                                value="{{$brand['id']}}" >
                                @php($name = $brand['name'])
                                @foreach($brand['translations'] as $t)
                                    @if($t->locale == App::getLocale() && $t->key == "name")
                                        @php($name = $t->value)
                                    @else
                                        @php($name = $brand['name'])
                                    @endif
                                @endforeach
                                {{ $name }}
                            </option>                        @endforeach
                        </select>
                    </div>


                    <div class="col-md-2 col-3 px-1">
                        <select onchange="category_id = $(this).val();nodata=true;page=0;$('#ajax-products').html('');page = 0;$('#ajax-products').scroll()" style="background: #ffffff; appearance: auto;width: 100%;border-radius: 5px !important;"
                            class="form-control custom-select selec3 SumoSelect-custom">
                            @php($categories=\App\CPU\CategoryManager::parents())
                            <option icon='' value="0">{{ Helpers::translate('all categories') }}</option>
                            @foreach($categories as $category)
                            @if(count($category->childes))
                                <optgroup icon='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'icon',session()->get('local')) ?? null))}}' label="<div class='flex'><img class='brFlag w-[35px] ml-1 mr-1' src='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'icon',session()->get('local')) ?? null))}}' style='width: 25%' /><label class='mt-1'>{{ Helpers::get_prop('App\Model\Category',$category['id'],'name') }}</label></div>">
                                    <option icon='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'icon',session()->get('local')) ?? null))}}' @if(request('category_id')==$category->id) selected @endif
                                        value="{{$category->id}}">{{ Helpers::get_prop('App\Model\Category',$category['id'],'name') }}
                                    </option>
                                    @foreach($category->childes as $sub_category)
                                    <option icon='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$sub_category['id'],'icon',session()->get('local')) ?? null))}}' @if(request('category_id')==$sub_category->id) selected @endif
                                        value="{{$sub_category->id}}">{{ Helpers::get_prop('App\Model\Category',$sub_category['id'],'name') }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option icon='{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'icon',session()->get('local')) ?? null))}}' @if(request('category_id')==$category->id) selected @endif
                                    value="{{$category->id}}">{{ Helpers::get_prop('App\Model\Category',$category['id'],'name') }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 col-3 px-1">
                        <input hidden name="data_from" value="{{$data['data_from']}}">
                        <div>
                            <select onchange="product_type = $(this).val();nodata=true;page=0;$('#ajax-products').html('');page = 0;$('#ajax-products').scroll()" class="form-control custom-select">
                                <option disabled {{ is_null(request('product_type')) ? 'selected' : '' }}>
                                    {{ Helpers::translate('Sync status') }}
                                </option>
                                <option value="" {{ request('product_type') === "" ? 'selected' : '' }}>
                                    {{\App\CPU\Helpers::translate('All cases')}}
                                </option>
                                <option @if(request('product_type') == "not-linked") selected @endif
                                    value="not-linked">{{\App\CPU\Helpers::translate('Asynchronous products')}}</option>
                                <option @if(request('product_type') == "linked") selected @endif
                                    value="linked">{{\App\CPU\Helpers::translate('My Linked Products')}} </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap w-full relative">


            <!-- Content  -->

            <section class="col-md-12 sm:px-5 px-0 text-center justify-center content-center contents">
                {{-- <div class="col-md-9"> --}}
                    <div class="row absolute sm:block hidden" style="background: white;margin:0px;border-radius:5px;">
                        <div class="col-md-6 d-flex  align-items-center">
                            {{-- if need data from also --}}
                            {{-- <h1 class="h3 text-dark mb-0 headerTitle text-uppercase">{{\App\CPU\Helpers::translate('product_by')}} {{$data['data_from']}} ({{ isset($brand_name) ? $brand_name : $data_from}})</h1> --}}
                        </div>
                        <div class="col-md-12 d-flex  align-items-center" style="margin-bottom: -6px;
                        margin-top: 20px;
                        padding-right: 0px;">
                            {{--  <div class="col-md-6 m-2 m-md-0 d-flex align-items-center justify-content-end">
                                <div class="btn-group-vertical" id="selection-buttons-container" style="display: none; position: fixed; top: 50%; right: 8rem; transform: translateY(-50%);">
                                    <button class="btn bg-primaryColor addto-list with-transitions sm:block hidden mb-3" id="selectAllButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16" style="margin-left: 10px;margin-right: 10px;">
                                            <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                          </svg>
                                        {{\App\CPU\Helpers::translate('Select All Products')}}
                                    </button>

                                    <button class="btn bg-primaryColor addto-list with-transitions sm:block hidden" id="deselectAllButton">
                                        <svg viewBox="147.713 148.346 15 14" width="32" height="32" fill="#fff" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="margin-left: 10px;margin-right: 10px;">
                                            <path d="M 154.713 149.846 C 154.713 149.57 154.937 149.346 155.213 149.346 L 162.213 149.346 C 162.489 149.346 162.713 149.57 162.713 149.846 L 162.713 150.846 C 162.713 151.122 162.489 151.346 162.213 151.346 L 155.213 151.346 C 154.937 151.346 154.713 151.122 154.713 150.846 L 154.713 149.846 Z M 149.713 148.346 C 148.609 148.346 147.713 149.241 147.713 150.346 L 147.713 152.346 C 147.713 153.45 148.609 154.346 149.713 154.346 L 151.713 154.346 C 152.818 154.346 153.713 153.45 153.713 152.346 L 153.713 150.346 C 153.713 149.241 152.818 148.346 151.713 148.346 L 149.713 148.346 Z M 149.713 156.346 C 148.609 156.346 147.713 157.241 147.713 158.346 L 147.713 160.346 C 147.713 161.45 148.609 162.346 149.713 162.346 L 151.713 162.346 C 152.818 162.346 153.713 161.45 153.713 160.346 L 153.713 158.346 C 153.713 157.241 152.818 156.346 151.713 156.346 L 149.713 156.346 Z M 154.713 157.846 C 154.713 157.57 154.937 157.346 155.213 157.346 L 162.213 157.346 C 162.489 157.346 162.713 157.57 162.713 157.846 L 162.713 158.846 C 162.713 159.122 162.489 159.346 162.213 159.346 L 155.213 159.346 C 154.937 159.346 154.713 159.122 154.713 158.846 L 154.713 157.846 Z M 154.713 152.846 C 154.713 152.57 154.937 152.346 155.213 152.346 L 160.213 152.346 C 160.598 152.346 160.839 152.762 160.646 153.096 C 160.557 153.251 160.392 153.346 160.213 153.346 L 155.213 153.346 C 154.937 153.346 154.713 153.122 154.713 152.846 M 154.713 160.846 C 154.713 160.57 154.937 160.346 155.213 160.346 L 160.213 160.346 C 160.598 160.346 160.839 160.762 160.646 161.096 C 160.557 161.251 160.392 161.346 160.213 161.346 L 155.213 161.346 C 154.937 161.346 154.713 161.122 154.713 160.846" transform="matrix(1, 0, 0, 1, 0, -2.842170943040401e-14)"/>
                                          </svg>
                                        {{\App\CPU\Helpers::translate('UnSelect All Products')}}
                                    </button>
                                </div>
                            </div>  --}}
                            <div class="col-md-6 m-2 m-md-0 d-flex align-items-center justify-content-end">
                                <div id="selection-buttons-container" style="display: none; position: fixed; top: 50%; right: 6rem; transform: translateY(-50%);    z-index: 5;">
                                    <input type="hidden" name="products" id="linkedProducts">
                                    <button onclick="addAllToLinked(event,this)" class="btn bg-primaryColor mb-3 addto-list with-transitions hidden" style="display: none">
                                        <i class="ri-store-2-line font-size-xl mx-1"></i>
                                        {{\App\CPU\Helpers::translate('Add to my products list')}}
                                         (<span id="selectedCount" class="mx-1">0</span>)
                                    </button>
                                  <button class="btn bg-primaryColor addto-list with-transitions sm:block hidden mb-3 d-flex align-items-center justify-content-center" id="selectAllButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16" style="margin-left: 10px;margin-right: 0px;border-radius: 0.25rem;">
                                        <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                      </svg>
                                    <span>{{\App\CPU\Helpers::translate('Select All Products')}}</span>
                                  </button>

                                  <button class="btn bg-primaryColor addto-list with-transitions sm:block hidden d-flex align-items-center justify-content-center" id="deselectAllButton">
                                    <svg viewBox="147.713 148.346 15 14" width="32" height="32" fill="#fff" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="margin-left: 10px;margin-right: 0px;border-radius: 0.25rem;">
                                        <path d="M 154.713 149.846 C 154.713 149.57 154.937 149.346 155.213 149.346 L 162.213 149.346 C 162.489 149.346 162.713 149.57 162.713 149.846 L 162.713 150.846 C 162.713 151.122 162.489 151.346 162.213 151.346 L 155.213 151.346 C 154.937 151.346 154.713 151.122 154.713 150.846 L 154.713 149.846 Z M 149.713 148.346 C 148.609 148.346 147.713 149.241 147.713 150.346 L 147.713 152.346 C 147.713 153.45 148.609 154.346 149.713 154.346 L 151.713 154.346 C 152.818 154.346 153.713 153.45 153.713 152.346 L 153.713 150.346 C 153.713 149.241 152.818 148.346 151.713 148.346 L 149.713 148.346 Z M 149.713 156.346 C 148.609 156.346 147.713 157.241 147.713 158.346 L 147.713 160.346 C 147.713 161.45 148.609 162.346 149.713 162.346 L 151.713 162.346 C 152.818 162.346 153.713 161.45 153.713 160.346 L 153.713 158.346 C 153.713 157.241 152.818 156.346 151.713 156.346 L 149.713 156.346 Z M 154.713 157.846 C 154.713 157.57 154.937 157.346 155.213 157.346 L 162.213 157.346 C 162.489 157.346 162.713 157.57 162.713 157.846 L 162.713 158.846 C 162.713 159.122 162.489 159.346 162.213 159.346 L 155.213 159.346 C 154.937 159.346 154.713 159.122 154.713 158.846 L 154.713 157.846 Z M 154.713 152.846 C 154.713 152.57 154.937 152.346 155.213 152.346 L 160.213 152.346 C 160.598 152.346 160.839 152.762 160.646 153.096 C 160.557 153.251 160.392 153.346 160.213 153.346 L 155.213 153.346 C 154.937 153.346 154.713 153.122 154.713 152.846 M 154.713 160.846 C 154.713 160.57 154.937 160.346 155.213 160.346 L 160.213 160.346 C 160.598 160.346 160.839 160.762 160.646 161.096 C 160.557 161.251 160.392 161.346 160.213 161.346 L 155.213 161.346 C 154.937 161.346 154.713 161.122 154.713 160.846" transform="matrix(1, 0, 0, 1, 0, -2.842170943040401e-14)"/>
                                      </svg>
                                    <span>{{\App\CPU\Helpers::translate('UnSelect All Products')}}</span>
                                  </button>
                                </div>
                              </div>

                        </div>
                    </div>
                {{-- </div> --}}
                <div class="row sm:mt-5 min-h-[750px] sm:px-[10%] ms-[inherit] w-full scrollbar-hide" id="ajax-products">
                    @if (count($products) > 0)
                    <div class="mt-3 w-full left-0" id="ajax-products2">
                        <div class='w-full please_wait'><center><img width='100px' src='{{asset('public/assets/front-end/img/loader_.gif')}}' /></center></div>
                    </div>
                    @else
                    <div class="text-center pt-5">
                        <h2>{{\App\CPU\Helpers::translate('No Product Found')}}</h2>
                    </div>
                    @endif
                </div>
                @if (count($products) > 0)
                <div class="row mt-3" id="ajax-products2">
                    <div class='w-full please_wait' style="display: none"><center><img width='100px' src='{{asset('public/assets/front-end/img/loader_.gif')}}' /></center></div>
                </div>
                @else
                <div class="text-center pt-5">
                    <h2>{{\App\CPU\Helpers::translate('No Product Found')}}</h2>
                </div>
                @endif
            </section>
        </div>
    </div>
    <style>
        .selec2-container {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .selec2-dropdown {
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .selec2-selection__rendered {
            line-height: 28px;
            padding-left: 10px;
        }

        .selec2-selection {
            height: 30px !important;
            border-radius: 4px;
            border: 1px solid #d4d4d4;
            background-color: #fff;
            font-size: 14px;
        }

        .selec2-search__field {
            padding: 4px 20px;
        }

        .selec2-selection__arrow {
            height: 30px;
        }

        .selec2-results__option {
            padding: 4px 10px;
            font-size: 14px;
        }

        .selec2-results__option--highlighted {
            background-color: #f5f5f5;
        }
        span.selec2-selection.selec2-selection--single{
            padding: 22.2px 0px;
        }
        span.selec2-dropdown.selec2-dropdown--below{
            border-radius: 10px;
        }
        input.selec2-search__field{
                border-radius: 6px;
        }
        .selec2-results__option{
            color:#212529;
        }
        .selec2-container--default .selec2-selection--single{border-color: rgb(208, 219, 233);}
        .selec2-container{
        box-shadow: none;
        }
        .selec2-container--default .selec2-results__option--highlighted[aria-selected] {
            background-color: #0d6efd;
            color: white; /* لتغيير لون النص إذا كنت ترغب في ذلك */
        }
        .img-flag {
            height: 20px;
            width: 20px;
            margin-right: 10px;
        }
    </style>
@endsection

@push('script')
    <script>
        var brand_id = "{{ request('brand_id') }}";
        var category_id = "{{ request('category_id') }}";
        var page = 0;
        var st = $(window).scrollTop();
        var order_by = "{{ request('order_by') }}";
        var min_price = "{{$data['min_price']}}";
        var max_price = "{{$data['max_price']}}";
        var product_type = "{{ request('product_type') }}";
        var search = "{{$data['name']}}";
        var done = false;

        var lastScrollTop = 0;
        var scrollThreshold = 1500;
        var nodata = true;
        $(document).ready(function(){
            $('.navbar-sticky').removeClass('navbar-sticky')
            if($('body').width() <= 640){
                $("#content").css('margin-top','44px')
            }
            page = page + 1;
            $.ajax({
                url:"{{route('products_lazy')}}",
                data: {
                    lazy:true,
                    page:page,
                    id: "{{$data['id']}}",
                    name: search,
                    brand_id: brand_id,
                    category_id: category_id,
                    order_by: order_by,
                    page_no: "{{$data['page_no']}}",
                    min_price: min_price,
                    max_price: max_price,
                    product_type: product_type,
                },
                success: function(data){
                    if (data.view) {
                        $(data.view).appendTo("#ajax-products");
                        $("#ajax-products2").clone().appendTo("#ajax-products");
                        $(".please_wait").hide()
                        $("#total_product").text(data.total_product)
                        $("#ajax-products #ajax-products2, #ajax-products * #ajax-products2").remove()
                    } else {
                        done = true
                    }
                }
            }).then(function(){
                if($('.inline_product').length == {{$products->total()}}){
                    $(".please_wait").hide();
                }
            })

            $(window).on("scroll",function(e){
                console.log(nodata)
                if ((Math.abs($(window).scrollTop() - lastScrollTop) >= scrollThreshold) || nodata) {
                    if(nodata){
                        page = 0;
                    }
                    if(!$("#ajax-products #ajax-products2, #ajax-products * #ajax-products2").length){
                        var j = $("#ajax-products2").clone()
                        j.appendTo("#ajax-products");
                    }
                    $('#ajax-products * .please_wait:last').show();
                    elem = $(e.target);
                    if(($(window).scrollTop() + $('#ajax-products').height() >= ($(document).height() * (0.2)) - 1100 && $(window).scrollTop() >= (st)) || nodata) {
                        nodata = false;
                        st = $(window).scrollTop()
                        page = page + 1;
                        $.ajax({
                            url:"{{route('products_lazy')}}",
                            data: {
                                lazy:true,
                                page:page,
                                id: "{{$data['id']}}",
                                name: search,
                                brand_id: brand_id,
                                category_id: category_id,
                                order_by: order_by,
                                page_no: "{{$data['page_no']}}",
                                min_price: min_price,
                                max_price: max_price,
                                product_type: product_type,
                            },
                            success: function(data){
                                if (data.view) {
                                    $(data.view).each(function(){
                                        var pid = $(this).attr('data-id')
                                        if(!$("#ajax-products").find('.product-'+pid).length){
                                            $(this).appendTo("#ajax-products");
                                        }
                                    })
                                    $(".please_wait").hide()
                                    $("#ajax-products #ajax-products2, #ajax-products * #ajax-products2").remove()
                                    $("#total_product").text(data.total_product)
                                } else {
                                    //$("#ajax-products").html('')
                                    //$("#total_product").text(0)
                                    $(".please_wait").hide()
                                    done = true
                                }
                            }
                        }).then(function(){
                            if($('.inline_product').length == {{$products->total()}}){
                                $(".please_wait").hide();
                            }
                        })
                    }else{
                    }
                    lastScrollTop = st;
                }else{
                }
            })
        })

        function openNav() {
            document.getElementById("mySidepanel").style.width = "70%";
            document.getElementById("mySidepanel").style.height = "100vh";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        function filter(value) {

        }

        function searchByPrice() {
            page = 1;
            st = $(window).scrollTop();
            let min = $('#min_price').val();
            let max = $('#max_price').val();
            max_price = max;
            min_price = min;
            done = false;
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    order_by: '{{$data['order_by']}}',
                    min_price: min,
                    max_price: max,
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                    $('#paginator-ajax').html(response.paginator);
                    $('#price-filter-count').text(response.total_product + ' {{\App\CPU\Helpers::translate('items found')}}')
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $('#searchByFilterValue, #searchByFilterValue-m').change(function () {
            var url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });

        $("#search-brand").on("keyup", function () {
            var value = this.value.toLowerCase().trim();
            $("#lista1 div>li").show().filter(function () {
                return $(this).text().toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{\App\CPU\Helpers::translate('Brands')}}"
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select3').select2({
                templateSelection: function (data) {
                  if (data.id === '') { // adjust for custom placeholder values
                    select3PH()
                    return;
                  }else{
                      return data.text;
                    }
                },
              });
        });
        function select3PH(){
            setTimeout(function(){
                var svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="6" height="6" rx="1" stroke="white" stroke-width="2" stroke-linejoin="round"/><rect x="4" y="14" width="6" height="6" rx="1" stroke="white" stroke-width="2" stroke-linejoin="round"/><rect x="14" y="14" width="6" height="6" rx="1" stroke="white" stroke-width="2" stroke-linejoin="round"/><rect x="14" y="4" width="6" height="6" rx="1" stroke="white" stroke-width="2" stroke-linejoin="round"/></svg>';
                $('.select3').next('.select2').find('.select2-selection__rendered').html(svg)
                $('.select3').next('.select2').find('.select2-selection').addClass("bg-primary")

            },500)
        }
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.SumoSelect > .CaptionCont > label').css('right', '');
            }, 3000);
        });

    </script>
@endpush
