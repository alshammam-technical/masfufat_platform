@extends('layouts.back-end.app')

@section('content')

<div class="content container-fluid" >
    <!-- Page Title -->
        <div class="row">
            <div class="col-lg-12">
                <div style="display: flex; align-items: center; width: 100%;">
                    <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ Helpers::translate('general_settings') }}</a></li>
                                <li class="breadcrumb-item mx-1" aria-current="page">
                                <a class="text-primary font-weight-bold" href="#">
                                    {{ Helpers::translate('Shipping_Method') }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                    <button id="help-center-button" class=" my-2 btn-icon-text m-2 btnn" style="border-radius: 10px;" target="_blank">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                        width="16.000000pt" height="16.000000pt" viewBox="0 0 48.000000 48.000000"
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
                    </button>
                </div>
            </div>
            <div class="col-lg-7" hidden="">

            </div>
        </div>
    <!-- End Page Title -->

    <!-- Inlile Menu -->

    <!-- End Inlile Menu -->

    <div class="border-2 border-black-700 rounded-lg">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card h-100 border-0">
                    <div class="card-header border-0">
                        <h5 class="text-capitalize mb-0 font-weight-bold">
                            {{\App\CPU\Helpers::translate('shipping_responsibility')}}
                        </h5>
                    </div>
                    @php($shippingMethod=\App\CPU\Helpers::get_business_settings('shipping_method'))
                    <div class="card-body d-flex">
                        <div class="radio-button-container w-50">
                            <input class="radio-button" onclick="shipping_responsibility(this.value);" type="radio" name="shipping_res" value="inhouse_shipping" id="inhouse_shipping" {{ $shippingMethod=='inhouse_shipping'?'checked':'' }}>
                            <label class="radio-label" for="inhouse_shipping">
                                {{\App\CPU\Helpers::translate('inhouse_shipping')}}
                            </label>
                        </div>

                        <div style="width: 10%"></div>

                        <div class="radio-button-container w-50">
                            <input class="radio-button" onclick="shipping_responsibility(this.value);" type="radio" name="shipping_res" value="sellerwise_shipping" id="sellerwise_shipping" {{ $shippingMethod=='sellerwise_shipping'?'checked':'' }}>
                            <label class="radio-label" for="sellerwise_shipping">
                                {{\App\CPU\Helpers::translate('seller_wise_shipping')}}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @php($admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first())
            @php($shippingType =isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise')
            @php($shippingCostView = \App\CPU\Helpers::get_business_settings('shipping_cost_view'))
            <div class="col-md-4">
                <div class="card h-100 border-0">
                    <div class="card-header border-0">
                        <h5 class="text-capitalize mb-0 font-weight-bold">{{\App\CPU\Helpers::translate('choose_shipping_method')}}</h5>
                    </div>
                    <div class="card-body" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                        <div class="mb-2">
                            <label class="title-color" id="for_inhouse_deliver" >{{\App\CPU\Helpers::translate('for_inhouse_deliver')}}</label>
                            <select class="form-control text-capitalize w-full" name="shippingCategory" onchange="shipping_type(this.value);">
                                <option value="0" selected disabled>---{{\App\CPU\Helpers::translate('select')}}---</option>
                                <option value="order_wise" {{$shippingType=='order_wise'?'selected':'' }} >{{\App\CPU\Helpers::translate('order_wise')}} </option>
                                <option  value="category_wise" {{$shippingType=='category_wise' || Helpers::get_business_settings('shipping_cost_view')?'selected':'' }} >{{\App\CPU\Helpers::translate('category_wise')}}</option>
                                <option  value="product_wise" {{$shippingType=='product_wise'?'selected':'' }}>{{\App\CPU\Helpers::translate('product_wise')}}</option>
                            </select>
                            @if($shippingType!=='product_wise')
                            <div class="w-full mt-2 input-group" id="update_category_shipping_cost_">
                                <span> {{ Helpers::translate('dont show shipping cost field when editing products') }} </span>
                                <label class="switch mx-1">
                                    <input type="checkbox" class="status" id="shipping_cost_view" @if($shippingCostView) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                                <span> {{ Helpers::translate('show shipping cost field and choose it when its not 0') }} </span>
                                <span hidden="">1</span>
                            </div>
                            @endif
                        </div>
                        <div id="product_wise_note">
                            <p class="text-danger">{{\App\CPU\Helpers::translate('note')}}: {{\App\CPU\Helpers::translate("Please_make_sure_all_the product's_delivery_charges_are_up_to_date.")}}</p>
                        </div>
                        @if($shippingType=='product_wise')
                        <div id="product_wise_inputs">
                            <div class="w-full mt-2 input-group">
                                <span> {{ Helpers::translate('show shipping cost') }} </span>
                                <label class="switch mx-1">
                                    <input type="checkbox" class="status" id="shipping_cost_view" @if($shippingCostView) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                                <span hidden="">1</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4" >
                <div class="card h-100 border-0">
                    <div class="py-5"></div>
                    <div class="card-body pt-2">
                        <form action="{{route('admin.business-settings.shipping-method.shipping-companies')}}" method="post" class="form-control">
                            @php($config=Helpers::get_business_settings('shipping_companies_access'))
                            @csrf
                            <div class="form-group d-flex mb-0">
                                <label class="switcher mt-1 mx-2">
                                    <input type="checkbox" class="switcher_input" name="shipping_companies_access" value="1"
                                    @if($config == 1) checked @endif
                                    onchange="$(this).closest('form').submit()"
                                    />
                                    <input type="hidden" name="access__">
                                    <span class="switcher_control"></span>
                                </label>
                                <label class="title-color font-weight-bold" for="name">{{ \App\CPU\Helpers::translate('Allow the shipping companies to change the request status in Masfufat')}}</label>
                            </div>
                        </form>
                        {{--  for salla  --}}
                        <form action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'change_salla_order_status_by_shipping_comps'])}}" method="post" class="form-control">
                            @php($config=Helpers::get_business_settings('change_salla_order_status_by_shipping_comps'))
                            @csrf
                            <div class="form-group d-flex mb-0">
                                <label class="switcher mt-1 mx-2">
                                    <input type="checkbox" class="switcher_input" name="change_salla_order_status_by_shipping_comps" value="1"
                                    @if($config == 1) checked @endif
                                    onchange="$(this).closest('form').submit()"
                                    />
                                    <input type="hidden" name="access__">
                                    <span class="switcher_control"></span>
                                </label>
                                <label class="title-color font-weight-bold" for="name">{{ \App\CPU\Helpers::translate('Allow the shipping companies to change the request status in Salla')}}</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-3 mt-1">
        <div class="col-12" id="update_category_shipping_cost">
            @php($categories = App\Model\Category::where(['position' => 0])->get())
            <div class="card h-100">
                <div class="px-3 pt-4">
                    <h4 class="mb-0 text-capitalize">{{\App\CPU\Helpers::translate('update_category_shipping_cost')}}</h4>
                </div>
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-full" cellspacing="0"
                            style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('category_name')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('cost_per_product')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('multiply_with_QTY')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="{{route('admin.business-settings.category-shipping-cost.store')}}" method="POST">
                                    @csrf
                                    @foreach ($all_category_shipping_cost as $key=>$item)
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{$item->category!=null?$item->category->name:\App\CPU\Helpers::translate('not_found')}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control w-auto" name="ids[]" value="{{$item->id}}">
                                                <input type="text" pattern="\d*" t="number" class="form-control w-auto" min="0" step="0.01" name="cost[]" value="{{($item->cost)}}">
                                            </td>
                                            <td>
                                                <label class="mx-auto switcher">
                                                    <input type="checkbox" class="switcher_input" name="multiplyQTY[]"
                                                        id="" value="{{$item->id}}" {{$item->multiply_qty == 1?'checked':''}}>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">
                                            <div class="d-flex flex-wrap justify-content-end gap-10">
                                                <button type="submit" class="btn bg-primaryColor btn-primary bg-primaryColor">{{\App\CPU\Helpers::translate('Update')}}</button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" id="order_wise_shipping">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-0 text-capitalize text-2xl px-3 py-4">{{\App\CPU\Helpers::translate('add_order_wise_shipping')}}</h5>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" action="{{route('admin.business-settings.shipping-method.add')}}"
                                style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                method="post">
                                @csrf
                                <div class="form-group col-md-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="title">{{\App\CPU\Helpers::translate('title')}}</label>
                                            <input type="text" name="title" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="duration">{{\App\CPU\Helpers::translate('duration')}}</label>
                                            <input type="text" name="duration" class="form-control"
                                                placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('4 to 6 days')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="cost">{{\App\CPU\Helpers::translate('cost')}}</label>
                                            <input type="text" t="number" min="0" max="1000000" name="cost" class="form-control"
                                                placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10')}} ">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color" for="tax">{{\App\CPU\Helpers::translate('Value tax')}}</label>
                                            <input type="text" t="number" min="0" max="100" name="tax" class="form-control"
                                                placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10')}} ">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <button type="submit" class="btn bg-primaryColor btn-primary bg-primaryColor" style="top: 30px">
                                        <i class="border border-1 border-white fa fa-plus p-1">

                                        </i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="px-3 py-4">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2 text-2xl">
                                    {{\App\CPU\Helpers::translate('order_wise_shipping_method')}}
                                    <span class="text-2xl text-primary">({{ $shipping_methods->count() }})</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="table-responsive pb-3">
                            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" cellspacing="0"
                                style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{\App\CPU\Helpers::translate('sl')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('title')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('duration')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('cost')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('Value tax')}}</th>
                                        <th class="text-center">{{\App\CPU\Helpers::translate('status')}}</th>
                                        <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping_methods as $k=>$method)
                                    <tr>
                                        <th>{{$k+1}}</th>
                                        <td>{{$method['title']}}</td>
                                        <td>
                                            {{$method['duration']}}
                                        </td>
                                        <td>
                                            {{\App\CPU\BackEndHelper::set_symbol(($method['cost']))}}
                                        </td>
                                        <td>
                                            {{ $method['tax'] }}%
                                        </td>

                                        <td>
                                            <label class="switcher mx-auto">
                                                <input type="checkbox" class="switcher_input status"
                                                    id="{{$method['id']}}" {{$method->status == 1?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-wrap justify-content-center gap-10">
                                                @if(Helpers::module_permission_check('shipping-method.setting.add'))
                                                <a  class="btn btn-sm edit"
                                                title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                                href="{{route('admin.business-settings.shipping-method.edit',[$method['id']])}}">
                                                    <i>
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </i>
                                                </a>
                                                @endif
                                                @if(Helpers::module_permission_check('shipping-method.setting.delete'))
                                                <a  title="{{\App\CPU\Helpers::translate('delete')}}"
                                                    class="btn btn-sm delete" id="{{ $method['id'] }}">
                                                    <i>
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M18.8499 9.14062L18.1999 19.2106C18.0899 20.7806 17.9999 22.0006 15.2099 22.0006H8.7899C5.9999 22.0006 5.9099 20.7806 5.7999 19.2106L5.1499 9.14062" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M10.3301 16.5H13.6601" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M9.5 12.5H14.5" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-6">
        <div class="col-md-12">
            <form action="{{route('admin.business-settings.shipping-method.shipping-companies')}}" method="post" enctype="multipart/form-data">
            @csrf
            @php($def_sh=Helpers::get_business_settings('default_shipping_company'))
            @php($config=Helpers::get_business_settings('shipping_companies') ?? [])
            <h5 class="text-capitalize mb-0 text-2xl px-3 py-4">{{\App\CPU\Helpers::translate('Activating / disrupting delivery through shipping companies')}}</h5>
            <div class="card h-100">
                <div class="card-body" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                    <ul class="mb-2 list-unstyled overflow-hidden">
                        <li class="row">
                            <label class="col-2">
                                {{ Helpers::translate('default') }}
                            </label>
                        </li>
                        <li class="row">
                            <div class="col-4 text-center">
                                <label for="None_def">
                                    <input type="radio" @if($def_sh == "None") checked @endif name="default_shipping_company" id="None_def" value="None">
                                    {{ Helpers::translate('No default company') }}
                                </label>
                            </div>
                        </li>
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.Aramex'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "
                                ") checked @endif name="default_shipping_company" id="Aramex_def" value="Aramex" onchange="$('#Aramex').attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#Aramex').attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="Aramex"><input id="Aramex" @if(in_array('Aramex',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="Aramex" />{{ Helpers::translate('Aramex') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['Aramex'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[Aramex]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '1']) }}">
                                    <i>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </i>
                                </a>
                            </div>

                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.J&t'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "Jt") checked @endif name="default_shipping_company" id="Jt_def" value="Jt" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="Jt"><input id="Jt" @if(in_array('Jt',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="Jt" />{{ Helpers::translate('Jt') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['Jt'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[Jt]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '2']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.aymakan'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "aymakan") checked @endif name="default_shipping_company" id="aymakan_def" value="aymakan" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="aymakan"><input id="aymakan" @if(in_array('aymakan',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="aymakan" />{{ Helpers::translate('aymakan') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['aymakan'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[aymakan]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '3']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.ajex'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "ajex") checked @endif name="default_shipping_company" id="ajex_def" value="ajex" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="ajex"><input id="ajex" @if(in_array('ajex',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="ajex" />{{ Helpers::translate('ajex') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['ajex'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[ajex]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '4']) }}">
                                    <i>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </i>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.shipa'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "shipa") checked @endif name="default_shipping_company" id="shipa_def" value="shipa" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="shipa"><input id="shipa" @if(in_array('shipa',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="shipa" />{{ Helpers::translate('shipa') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['shipa'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[shipa]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '5']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.iMile'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "iMile") checked @endif name="default_shipping_company" id="iMile_def" value="iMile" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="iMile"><input id="iMile" @if(in_array('iMile',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="iMile" />{{ Helpers::translate('iMile') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['iMile'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[iMile]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '6']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.UPS'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "UPS") checked @endif name="default_shipping_company" id="UPS_def" value="UPS" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="UPS"><input id="UPS" @if(in_array('UPS',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="UPS" />{{ Helpers::translate('UPS') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['UPS'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[UPS]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '7']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.DHL'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "DHL") checked @endif name="default_shipping_company" id="DHL_def" value="DHL" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="DHL"><input id="DHL" @if(in_array('DHL',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="DHL" />{{ Helpers::translate('DHL') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['DHL'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[DHL]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '8']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.SMB'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "SMB") checked @endif name="default_shipping_company" id="SMB_def" value="SMB" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="SMB"><input id="SMB" @if(in_array('SMB',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="SMB" />{{ Helpers::translate('SMB') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['SMB'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[SMB]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '9']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.redbox'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "redbox") checked @endif name="default_shipping_company" id="redbox_def" value="redbox" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="redbox"><input id="redbox" @if(in_array('redbox',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="redbox" />{{ Helpers::translate('redbox') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['redbox'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[redbox]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-SM edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '11']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                        @if (\App\CPU\Helpers::service_permission_check('Shipping.between'))
                        <li class="row">
                            <div class="col-1 text-center">
                                <input type="radio" @if($def_sh == "between") checked @endif name="default_shipping_company" id="between_def" value="between" onchange="$('#'+$(this).val()).attr('checked','checked');$('.shipping_chbx').removeAttr('disabled');$('#'+$(this).val()).attr('disabled','disabled');">
                            </div>
                            <label class="col-4" for="between"><input id="between" @if(in_array('between',$config)) checked @endif name="shipping_companies[]" class="mx-2 shipping_chbx" type="checkbox" value="between" />{{ Helpers::translate('between') }}</label>
                            <div class="col-4">
                                @php($sh = Helpers::get_business_settings('shipping_company_img')['between'] ?? null)
                                <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/shipping/'.($sh)) }}" alt="" style="width: 100%;height:50px;border-radius:11px">
                            </div>
                            {{--  <div class="col-3">
                                <input type="file" onchange="readURL(this)" name="shipping_company_img[between]" />
                            </div>  --}}
                            <div class="col-1">
                                <a class="btn btn-sm edit mr-7" href="{{ route('admin.business-settings.shipping-method.costadjustment', ['id' => '10']) }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.0399 3.01928L8.15988 10.8993C7.85988 11.1993 7.55988 11.7893 7.49988 12.2193L7.06988 15.2293C6.90988 16.3193 7.67988 17.0793 8.76988 16.9293L11.7799 16.4993C12.1999 16.4393 12.7899 16.1393 13.0999 15.8393L20.9799 7.95928C22.3399 6.59928 22.9799 5.01928 20.9799 3.01928C18.9799 1.01928 17.3999 1.65928 16.0399 3.01928Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14.9099 4.15039C15.5799 6.54039 17.4499 8.41039 19.8499 9.09039" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">
                        {{ Helpers::translate('Save') }}
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>


</div>

@endsection

@push('script')
<script>
    $( document ).ready(function() {
        $("#{{$def_sh}}").attr('disabled','disabled');
        let shipping_responsibility ='{{$shippingMethod}}';
        console.log(shipping_responsibility);
        if(shipping_responsibility === 'sellerwise_shipping')
        {
            $("#for_inhouse_deliver").show();
        }else{
            $("#for_inhouse_deliver").hide();
        }
        let shipping_type = '{{$shippingType}}';

        if(shipping_type==='category_wise')
        {
            $('#product_wise_note').hide();
            $('.product_wise_inputs').hide();
            $('#order_wise_shipping').hide();
            $('#update_category_shipping_cost').show();
            $('#update_category_shipping_cost_').show();

        }else if(shipping_type==='order_wise'){
            $('#product_wise_note').hide();
            $('.product_wise_inputs').hide();
            $('#update_category_shipping_cost').hide();
            $('#update_category_shipping_cost_').hide();
            $('#order_wise_shipping').show();
        }else{

            $('#update_category_shipping_cost').hide();
            $('#update_category_shipping_cost_').hide();
            $('#order_wise_shipping').hide();
            $('#product_wise_note').show();
            $('.product_wise_inputs').show();
        }
    });
</script>
<script>
    function shipping_responsibility(val){
        if(val=== 'inhouse_shipping'){
            $( "#sellerwise_shipping" ).prop( "checked", false );
            $("#for_inhouse_deliver").hide();
        }else{
            $( "#inhouse_shipping" ).prop( "checked", false );
            $("#for_inhouse_deliver").show();
        }
        console.log(val);
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.shipping-method.shipping-store')}}",
                method: 'POST',
                data: {
                    shippingMethod: val
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success("{{\App\CPU\Helpers::translate('shipping_responsibility_updated_successfully!!')}}");
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        window.location.reload();
                    }

                }
            });
    }
</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).closest('.row').find('img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function shipping_type(val)
    {
        console.log(val);
        if(val==='category_wise')
        {
            $('#product_wise_note').hide();
            $('#order_wise_shipping').hide();
            $('#update_category_shipping_cost').show();
            $('#update_category_shipping_cost_').show();
        }else if(val==='order_wise'){
            $('#product_wise_note').hide();
            $('#update_category_shipping_cost').hide();
            $('#update_category_shipping_cost_').hide();
            $('#order_wise_shipping').show();
        }else{
            $('#update_category_shipping_cost').hide();
            $('#update_category_shipping_cost_').hide();
            $('#order_wise_shipping').hide();
            $('#product_wise_note').show();
        }

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.shipping-type.store')}}",
                method: 'POST',
                data: {
                    shippingType: val
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success("{{\App\CPU\Helpers::translate('shipping_method_updated_successfully!!')}}");
                        location.reload()
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }
                }
            });
    }
</script>
<script>
    // Call the dataTables jQuery plugin
    $(document).on('change', '.status', function () {
        var id = $(this).attr("id");
        if ($(this).prop("checked") == true) {
            var status = 1;
        } else if ($(this).prop("checked") == false) {
            var status = 0;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('admin.business-settings.shipping-method.status-update')}}",
            method: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function (data) {
                if(data == 0){
                    toastr.error("{{ Helpers::translate('Access Denied !') }}")
                    location.reload()
                }else{
                    toastr.success('{{\App\CPU\Helpers::translate('order wise shipping method Status updated successfully')}}');
                }
            }
        });
    });
    $(document).on('click', '.delete', function () {
        var id = $(this).attr("id");
        Swal.fire({
            title: '{{\App\CPU\Helpers::translate('Are you sure delete this')}} ?',
            text: "{{\App\CPU\Helpers::translate('You will not be able to revert this')}}!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, delete it')}}!',
            type: 'warning',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('admin.business-settings.shipping-method.delete')}}",
                    method: 'POST',
                    data: {id: id},
                    success: function () {
                        toastr.success('{{\App\CPU\Helpers::translate('Order Wise Shipping Method deleted successfully')}}');
                        location.reload();
                    }
                });
            }
        })
    });
</script>
@endpush
