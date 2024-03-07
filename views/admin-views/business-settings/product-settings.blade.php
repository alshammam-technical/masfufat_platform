@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Web Config'))

@push('css_or_js')
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}?v=2" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
                {{\App\CPU\Helpers::translate('products settings')}}
            </h2>
        </div>
        <!-- End Page Title -->



        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.product-settings.stock-limit-warning') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            @php($stock_limit=\App\Model\BusinessSetting::where('type','stock_limit')->first())
                            <div class="form-group">
                                <label class="title-color d-flex">{{\App\CPU\Helpers::translate('minimum_stock_limit_for_warning')}}</label>
                                <input class="form-control" type="number" name="stock_limit"
                                        value="{{ $stock_limit->value?$stock_limit->value:"" }}"
                                        placeholder="{{\App\CPU\Helpers::translate('EX:123')}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <button type="submit" class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('Digital Product')}}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.product-settings.update-digital-product')}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('Digital Product on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="digital_product" type="radio" value="1"
                                       id="defaultCheck1" {{$digital_product==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck1">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="digital_product" type="radio" value="0"
                                       id="defaultCheck2" {{$digital_product==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck2">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('Product_Brand')}}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.product-settings.update-product-brand')}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('Product Brand on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="product_brand" type="radio" value="1"
                                       id="defaultCheck3" {{$brand==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="product_brand" type="radio" value="0"
                                       id="defaultCheck4" {{$brand==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('Sell by quantity')}}</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateSellByQty')}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('Sale by quantity on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="sell_by_qty" type="radio" value="1"
                                       id="defaultCheck3" {{$sell_by_qty==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="sell_by_qty" type="radio" value="0"
                                       id="defaultCheck4" {{$sell_by_qty==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('pricing levels')}}</h5>
                    </div>
                    @php($pricing_levels = \App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'pricing_levels'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('Pricing levels on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="pricing_levels" type="radio" value="1"
                                       id="defaultCheck3" {{$pricing_levels==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="pricing_levels" type="radio" value="0"
                                       id="defaultCheck4" {{$pricing_levels==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('selling_multiples_quantity')}}</h5>
                    </div>
                    @php($selling_multiples_quantity = \App\Model\BusinessSetting::where('type','selling_multiples_quantity')->first()->value ?? '')
                    @php($selling_multiples_quantity_value = \App\Model\BusinessSetting::where('type','selling_multiples_quantity_value')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.selling_multiples_quantity',['prop'=>'selling_multiples_quantity'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('selling_multiples_quantity on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="selling_multiples_quantity" type="radio" value="1"
                                onchange="$('.selling_multiples_quantity').show()"
                                       id="defaultCheck3" {{$selling_multiples_quantity==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="selling_multiples_quantity" type="radio" value="0"
                                onchange="$('.selling_multiples_quantity').hide()"
                                       id="defaultCheck4" {{$selling_multiples_quantity==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>

                            <div class="row gap-2 align-items-center selling_multiples_quantity" @if($selling_multiples_quantity==0) style="display: none !important" @endif>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('the Value')}}
                                </label>
                                <input class="" name="selling_multiples_quantity_value" type="text" value="{{$selling_multiples_quantity_value}}" />
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('hide_on_zero')}}</h5>
                    </div>
                    @php($hide_on_zero = \App\Model\BusinessSetting::where('type','hide_on_zero')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'hide_on_zero'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('hide_on_zero on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="hide_on_zero" type="radio" value="1"
                                       id="defaultCheck3" {{$hide_on_zero==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="hide_on_zero" type="radio" value="0"
                                       id="defaultCheck4" {{$hide_on_zero==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('multi_codes')}}</h5>
                    </div>
                    @php($multi_codes = \App\Model\BusinessSetting::where('type','multi_codes')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'multi_codes'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('multi_codes on/off')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="multi_codes" type="radio" value="1"
                                       id="defaultCheck3" {{$multi_codes==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="multi_codes" type="radio" value="0"
                                       id="defaultCheck4" {{$multi_codes==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('products_rating')}}</h5>
                    </div>
                    @php($products_rating = \App\Model\BusinessSetting::where('type','products_rating')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'products_rating'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('show products rating on store')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="products_rating" type="radio" value="1"
                                       id="defaultCheck3" {{$products_rating==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="products_rating" type="radio" value="0"
                                       id="defaultCheck4" {{$products_rating==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('orders_display')}}</h5>
                    </div>
                    @php($orders_display = \App\Model\BusinessSetting::where('type','orders_display')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'orders_display'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('orders')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="orders_display" type="radio" value="1"
                                       id="defaultCheck3" {{$orders_display==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="orders_display" type="radio" value="0"
                                       id="defaultCheck4" {{$orders_display==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('favorite')}}</h5>
                    </div>
                    @php($favorite = \App\Model\BusinessSetting::where('type','favorite')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'favorite'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('display favorite on store')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="favorite" type="radio" value="1"
                                       id="defaultCheck3" {{$favorite==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="favorite" type="radio" value="0"
                                       id="defaultCheck4" {{$favorite==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('show_price_with_tax')}}</h5>
                    </div>
                    @php($show_price_with_tax = \App\Model\BusinessSetting::where('type','show_price_with_tax')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'show_price_with_tax'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('display price_with_tax on store')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="show_price_with_tax" type="radio" value="1"
                                       id="defaultCheck3" {{$show_price_with_tax==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="show_price_with_tax" type="radio" value="0"
                                       id="defaultCheck4" {{$show_price_with_tax==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('show_main_category')}}</h5>
                    </div>
                    @php($show_main_category = \App\Model\BusinessSetting::where('type','show_main_category')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'show_main_category'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('display show_main_category when modifying products')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="show_main_category" type="radio" value="1"
                                       id="defaultCheck3" {{$show_main_category==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="show_main_category" type="radio" value="0"
                                       id="defaultCheck4" {{$show_main_category==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('Calculate shipping cost when displaying product')}}</h5>
                    </div>
                    @php($show_shipping_calc = \App\Model\BusinessSetting::where('type','show_shipping_calc')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'show_shipping_calc'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('Product price calculation method = product price + tax + shipping cost = total')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="show_shipping_calc" type="radio" value="1"
                                       id="defaultCheck3" {{$show_shipping_calc==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="show_shipping_calc" type="radio" value="0"
                                       id="defaultCheck4" {{$show_shipping_calc==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('Add a method for calculating the price of the product')}}</h5>
                    </div>
                    @php($show_calculating_price_product = \App\Model\BusinessSetting::where('type','show_calculating_price_product')->first()->value ?? '')
                    <div class="card-body">
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'show_calculating_price_product'])}}"
                              method="post">
                            @csrf
                            <label class="title-color d-flex mb-3">{{\App\CPU\Helpers::translate('Add a method for calculating the price of the product inclusive * quantity = total')}}</label>
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <input class="" name="show_calculating_price_product" type="radio" value="1"
                                       id="defaultCheck3" {{$show_calculating_price_product==1?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck3">
                                    {{\App\CPU\Helpers::translate('Turn on')}}
                                </label>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <input class="" name="show_calculating_price_product" type="radio" value="0"
                                       id="defaultCheck4" {{$show_calculating_price_product==0?'checked':''}}>
                                <label class="title-color mb-0" for="defaultCheck4">
                                    {{\App\CPU\Helpers::translate('Turn off')}}
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    @push('script')
        @if(!Helpers::module_permission_check('product-settings.edit'))
        <script>
            $("input,select").attr("disabled",true);
        </script>
        @endif
    @endpush

@endsection
