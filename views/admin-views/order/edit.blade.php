@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Add Order'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{route('admin.orders.list',['all'])}}">
                                {{Helpers::translate('orders')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{Helpers::translate('Add Order')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{ Helpers::translate('the customer') }}
                    </h3>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="row">
                        <div class="col-1">
                            <img
                            class="avatar rounded-circle avatar-70" style="width: 75px;height: 42px"
                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            src="{{asset('storage/app/public/user')}}/{{($customer->store_informations['image'] ?? '')}}"
                            alt="Image">
                        </div>
                        <div class="col-10">
                            <h5 class="px-2">
                                {{ $customer->id ?? null }}
                                -
                                <a target="_blank" href="{{ route('admin.customer.update', ['id'=>$customer['id']]) }}">
                                    {{ $customer->name }}
                                </a>
                            </h5>
                            <div class="d-flex mt-4">
                                <h5 dir="ltr" class="pt-3 px-2"> {{ $customer->phone }} </h5>
                                <a target="_bank" role="button" class="btn btn-primary" href="tel:{{$customer->phone}}">
                                    {{ Helpers::translate('Dial') }}
                                </a>
                                <a target="_bank" role="button" class="btn btn-success mx-2" href="http://wa.me/{{$customer->phone}}">
                                    <i class="tio-whatsapp-outlined text-white mx-1"></i>
                                    {{ Helpers::translate('Whatsapp') }}
                                </a>

                                <a target="_bank" role="button" class="btn btn-primary mx-2" data-target="#quick_sms" data-toggle="modal">
                                    <i class="tio-sms text-white mx-1"></i>
                                    {{ Helpers::translate('Sms') }}
                                </a>

                                <a target="_bank" role="button" class="btn btn-info mx-2" href="mailto:{{$customer->email}}">
                                    <i class="tio-email-outlined text-white mx-1"></i>
                                    {{ Helpers::translate('Email') }}
                                </a>
                            </div>
                            <div class="d-flex mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{ Helpers::translate('products') }}
                    </h3>

                    <div class="col-lg-8"></div>

                    <a target="_bank" role="button" class="btn btn-primary mx-2" data-target="#products_add" data-toggle="modal">
                        <i class="tio-shopping-cart text-white mx-1"></i>
                        {{ Helpers::translate('Add products to cart') }}
                    </a>


                    <a role="button" class="btn btn-info mx-2" onclick="$('#enable-discount').show();location.replace('#enable-discount')">
                        {{ Helpers::translate('enable discount') }}
                    </a>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">{{ Helpers::translate('Item Number') }}</th>
                                <th class="text-center">{{ Helpers::translate('product_code_sku') }}</th>
                                <th class="text-center">{{ Helpers::translate('product') }}</th>
                                <th class="text-center">{{ Helpers::translate('quantity') }}</th>
                                <th class="text-center">{{ Helpers::translate('price') }}</th>
                                <th class="text-center">{{ Helpers::translate('Discount on each piece') }}</th>
                                <th class="text-center">{{ Helpers::translate('total') }}</th>
                                <th class="text-center">{{ Helpers::translate('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @foreach ($cart as $item)
                            @if($item->product)
                            <tr>
                                <td class="pt-5 text-center"> {{$item->product['item_number']}} </td>
                                <td class="pt-5 text-center"> {{$item->product['code']}} </td>
                                <td class="text-start" style="width: 660px;">
                                    <a target="_blank" href="{{ route('admin.product.edit', ['id'=>$item->product['id']]) }}">
                                        @php($local = session()->get('local'))
                                        <img class="rounded productImg" width="64"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($item->product['images'])->$local)) ? json_decode($item->product['images'])->$local[0] ?? '' : ''}}">
                                        {{ Str::limit(\App\CPU\Helpers::get_prop('App\Model\Product',$item->product['id'],'name',session()->get('local') ?? 'sa') ?? $item->product->name, 36) }}
                                    </a>
                                </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center " type="number" min="0" max="100" id="quantity_{{$item->id}}" value="{{ $item->quantity }}"/>  </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center bg-light" readonly disabled type="text" id="price_{{$item->id}}" value="{{ $item->price }}"/>  </td>
                                <td style="width: 100px" class="text-center pt-4"> <input style="width: 100px" class="form-control text-center " type="number" min="0" max="100" id="discount_{{$item->id}}" value="{{ $item->discount }}"/>  </td>
                                <td class="pt-5 text-center">
                                    <span class="calc_price_b" id="calc_price_b_{{$item->id}}" style="display: none">
                                        {{ $item->quantity*$item->price }}
                                        @php($total = $total + ($item->quantity*$item->price))
                                    </span>
                                    <span class="calc_price" id="calc_price_{{$item->id}}">
                                        {{ $item->quantity*$item->price }}
                                        @php($total = $total + ($item->quantity*$item->price))
                                    </span>
                                </td>
                                <td class="pt-3 text-center">
                                    <button class="btn btn-primary mx-1 update_price" onclick="update_price({{$item->id}})">
                                        {{ Helpers::translate('update') }}
                                    </button>
                                    <button class="btn btn-danger mx-1" onclick="form_alert('delete-{{$item->id}}','Want to delete this item ?')">
                                        {{ Helpers::translate('delete') }}
                                    </button>
                                    <form hidden id="delete-{{$item->id}}" action="{{ route('admin.abandoned-carts.delete',['id'=>$item->id]) }}" method="POST">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end">
                                {{ Helpers::translate('Total') }}:
                            </td>
                            <td colspan="2" style="width: 125px" class="text-start">
                                <span id="total_price_b"></span>
                                <span id="total_price" style="display: none;"></span>
                                <span>{{ \App\CPU\BackEndHelper::set_symbol('') }}</span>
                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 pt-6" id="enable-discount" @if(!$offer) style="display: none" @endif>
        @php($o = $offer->offer ?? [])
        @include('admin-views.cart.offer_form',['id'=>$offer['id'] ?? null,'offer'=>1])
        <div class="row w-100 m-0 pt-4">
            <div class="row-12 w-100 px-1 mb-0 mx-3">
                <button class="btn btn-primary w-100" onclick="$('#offer_form').submit()">
                    <i class="tio-send"></i>
                    {{ Helpers::translate('Send the offer') }}
                </button>
            </div>
        </div>
    </div>

    <div class="row w-100 m-0 py-4">
        <div class="row-12 w-100 px-1">
            <button class="btn btn-primary w-100">
                {{ Helpers::translate('complete the order') }}
            </button>
        </div>
    </div>

    <div class="modal fade" id="Shipping_Address" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="height: 90%" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('Shipping Address')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="$('#added_products').val('')"><span aria-hidden="true">&times;</span></a>
                </div>
                <section class="col-lg-9 mt-3">

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="row">
                                        <div class="col-md-12"><h5 class="modal-title font-nameA ">{{\App\CPU\Helpers::translate('Add a new address')}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <form class="">
                                        <div class="col-md-12">
                                            <!-- Nav pills -->
                                            <ul class="donate-now">
                                                <li>
                                                    <input type="radio" id="a25" name="amount"/>
                                                    <label for="a25">{{\App\CPU\Helpers::translate('permanent')}}</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="a50" name="amount"/>
                                                    <label for="a50">{{\App\CPU\Helpers::translate('Home')}}</label>
                                                </li>
                                                <li>
                                                    <input type="radio" id="a75" name="amount" checked="checked"/>
                                                    <label for="a75">{{\App\CPU\Helpers::translate('Office')}}</label>
                                                </li>

                                            </ul>
                                        </div>
                                        <!-- Tab panes -->


                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="firstName">{{\App\CPU\Helpers::translate('Contact person name')}}</label>
                                                <input type="text" class="form-control" id="firstName" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lastName">{{\App\CPU\Helpers::translate('Floor,Suite')}}</label>
                                                <input type="text" class="form-control" id="lastName" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="firstName">{{\App\CPU\Helpers::translate('City')}}</label>
                                                <input type="text" class="form-control" id="firstName" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lastName">{{\App\CPU\Helpers::translate('Zip code')}}</label>
                                                <input type="text" class="form-control" id="lastName" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="firstName">{{\App\CPU\Helpers::translate('State')}}</label>
                                                <input type="text" class="form-control" id="firstName" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lastName">{{\App\CPU\Helpers::translate('Country')}}</label>
                                                <input type="text" class="form-control" id="lastName" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="firstName">{{\App\CPU\Helpers::translate('Phone')}}</label>
                                                <input type="text" class="form-control" id="firstName" placeholder="">
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">

                                            </div>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="closeB" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}</button>
                                    <button type="button" class="btn btn-p"> {{\App\CPU\Helpers::translate('Update Information')}}</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="button" onclick="$('#added_products_form').submit()">{{\App\CPU\Helpers::translate('Apply')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="products_add" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="height: 90%" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('Add products to cart')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="$('#added_products').val('')"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">
                    <iframe style="width: 100%;height: 80%" scrol src="{{ route('admin.pos.index',['hide_all' => 1]) }}" frameborder="0" scrolling="no"></iframe>
                    <h3>{{ Helpers::translate('added products') }}:</h3>
                    <form id="added_products_form" action="{{ route('admin.abandoned-carts.add_products',['cart_group_id'=>$cart_group_id]) }}" method="post" style="max-height: 100px;overflow-y: auto">
                        @csrf

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="button" onclick="$('#added_products_form').submit()">{{\App\CPU\Helpers::translate('Apply')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="quick_sms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\Helpers::translate('send sms')}}</h5><a aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">
                    <form action="{{ route('admin.sms.store') }}" method="post" id="quickSms">
                        @csrf
                        <textarea class="w-100" name="description" id="description" style="height: 127px;"></textarea>
                        <input type="hidden" name="email_to[store]" value="store">
                        <input type="hidden" name="sent_to[store]" value="{{$customer->phone}}">
                    </form>
                </div>
                <div class="modal-footer">
                    <a class="btn ripple btn-success" type="button" onclick="$('#quickSms').click()">{{\App\CPU\Helpers::translate('Send')}}</a>
                </div>
            </div>
        </div>
    </div>
    {{--  Address  --}}
    <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12"><h5 class="modal-title font-name ">{{\App\CPU\Helpers::translate('add_new_address')}}</h5></div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{route('address-store')}}" method="post">
                        @csrf
                        @php($store = auth('customer')->user()->store_informations)
                        <!-- Tab panes -->
                        <div class="form-row mb-1">
                            <div class="form-group col-md-6">
                                <label for="person_name">{{\App\CPU\Helpers::translate('address name')}}</label>
                                <input class="form-control" type="text" id="title"
                                    name="title"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="person_name">{{\App\CPU\Helpers::translate('contact_person_name')}}</label>
                                <input class="form-control" type="text" id="person_name"
                                    value="{{ $store['company_name'] }}"
                                    name="name"
                                    required>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('The receiving person mobile number')}}
                                <span
                                style="color: red">*</span></label>
                                <div class="form-group  w-100 col-lg-12">
                                    <input tabindex="3" name="phone" class="form-control phoneInput text-left" dir="ltr" value="{{ $store['phone'] ?? '+966'}}" />
                                </div>
                            </div>
                            <div class="col-mh-6"></div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Country')}}
                                        <span
                                            style="color: red">*</span></label>
                                    <select name="country" id="" class="form-control SumoSelect-custom" data-bs-live-search="true" required
                                    onchange="$('#area_id,.area_id').attr('disabled',1);$('#area_id_loading').show();$.get('{{route('get-shipping-areas')}}?code='+$(this).val()).then(d=>{$('#area_id,.area_id').html(d);$('#area_id,.area_id').removeAttr('disabled');$('#area_id_loading').hide();$('#area_id').SumoSelect().sumo.reload()})">
                                        <option></option>
                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                            <option @if($store['country'] == $country['id']) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Governorate')}}
                                        <span style="color: red">*</span></label>
                                    <select name="area_id" id="area_id" class="form-control SumoSelect-custom" data-bs-live-search="true" required></select>
                                    <span class="text-warning" id="area_id_loading" style="display: none;">{{ Helpers::translate('Please wait') }}</span>
                                    <input type="hidden" id="area_id_hidden" >
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="zip_code">{{\App\CPU\Helpers::translate('zip_code')}}</label>
                                @if($zip_restrict_status)
                                    <select name="zip" class="form-control selectpicker" data-bs-live-search="true" id="" required>
                                        @foreach($delivery_zipcodes ?? [] as $zip)
                                            <option value="{{ $zip->zipcode }}" >{{ $zip->zipcode }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input class="form-control" type="number" id="zip_code" name="zip" required>
                                @endif
                            </div>
                            <div class="col-md-6">

                            </div>

                            <div class="form-group col-lg-6">
                                <label
                                    for="exampleInputEmail1">{{ \App\CPU\Helpers::translate('Street - neighborhood')}}<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="address"
                                          type="text"
                                          name="address" required></textarea>
                            </div>

                        </div>

                        @if (1==2)
                        <div class="form-row mb-1">
                            <div class="form-group col-md-12">
                                <label for="own_address">{{\App\CPU\Helpers::translate('address')}}</label>
                                <textarea class="form-control" id="address"
                                    type="text"  name="address" required>{{$shippingAddress->address}}</textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input id="pac-input" class="controls rounded" style="height: 3em;width:fit-content;" title="{{\App\CPU\Helpers::translate('search_your_location_here')}}" type="text" placeholder="{{\App\CPU\Helpers::translate('search_here')}}"/>
                                <div style="height: 200px;" id="location_map_canvas"></div>
                            </div>
                        </div>
                        @endif
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                            <button type="submit" class="btn btn--primary text-light">{{\App\CPU\Helpers::translate('Add')}}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-6">
        <!-- Sidebar-->

    <!-- Content  -->
        <section class="col-lg-12 col-md-12">
            <div class="card box-shadow-sm">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                            <div class="col-sm-4">
                                <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\Helpers::translate('ADDRESSES')}}</h1>
                            </div>
                            <div class="mt-2 col-sm-4" style="text-align: end">
                                <button type="submit" class="btn btn--primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="add_new_address">{{\App\CPU\Helpers::translate('add_new_address')}}
                                </button>
                            </div>
                        </div>
                        @foreach($shippingAddresses as $shippingAddress)
                            <section class="col-lg-6 col-md-6 mb-4 mt-5">
                                <div class="card" style="text-transform: capitalize;">

                                        <div class="card-header p-3 pb-0" style="padding: 5px;">

                                            <div class="row">
                                                <label for="a25" class="col-6">
                                                    {{\App\CPU\Helpers::translate('permanent')}}
                                                </label>
                                                <div class="col-6 text-end">
                                                    <div class="form-check form-switch p-0">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="addressAs" value="permanent"
                                                        {{ $shippingAddress->address_type == 'permanent' ? 'checked' : ''}}
                                                        />
                                                      </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body mt-3" style="padding: {{Session::get('direction') === "rtl" ? '0 13px 15px 15px' : '0 15px 15px 13px'}};">

                                            <div class="d-flex justify-content-between" style="padding: 5px;">
                                                <div>
                                                    <span class="fw-bold">
                                                        {{$shippingAddress->title ?? $shippingAddress->address_type }}
                                                    </span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <a class="bg-black ps-1 rounded wd-25 ht-25" title="Edit Address" id="edit" href="{{route('address-edit',$shippingAddress->id)}}">
                                                        <i class="ri-pencil-fill text-white fa-md"></i>
                                                    </a>

                                                    <a class="ps-1 pt-1 rounded wd-25 ht-25" title="Delete Address" href="{{ route('address-delete',['id'=>$shippingAddress->id])}}" onclick="return confirm('{{\App\CPU\Helpers::translate('Are you sure you want to Delete')}}?');" id="delete">
                                                        <i class="ri-delete-bin-5-fill text-danger fa-lg"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <label for="person_name" class="col-6">
                                                    <strong>
                                                        {{\App\CPU\Helpers::translate('contact_person_name')}}:
                                                    </strong>
                                                </label>
                                                <div class="col-6 text-end">
                                                    {{$shippingAddress->contact_person_name}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <label for="person_name" class="col-6">
                                                    <strong>
                                                        {{ \App\CPU\Helpers::translate('The receiving person mobile number')}}:
                                                    </strong>
                                                </label>
                                                <div class="col-6 text-end" dir="ltr">
                                                    {{$shippingAddress->phone}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Country')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    <select name="country" disabled id="" data-bs-live-search="true" required style="color: black;font-weight:bold;border: none;text-align-last: end;border: none;background-blend-mode: hue;width: 95px;float: left;text-align-last:end;height:32px;margin-top:-10px" class="p-0 form-control bg-white">
                                                        <option></option>
                                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                                            <option @if($country->code == $shippingAddress->country) selected @endif value="{{ $country->code }}" icon="{{ $country->photo }}">
                                                                {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Governorate')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    <select disabled name="area_id" id="area_id{{$shippingAddress->id}}" data-bs-live-search="true" required style="color: black;font-weight:bold;border: none;text-align-last: end;border: none;background-blend-mode: hue;width: 95px;float: left;text-align-last:end;height:32px;margin-top:-10px" class="p-0 form-control bg-white"></select>
                                                    <span class="text-warning area_id" id="area_id_loading" style="display: none;">{{ Helpers::translate('Please wait') }}</span>
                                                    <input type="hidden" id="area_id_hidden" value="{{$shippingAddress->area_id ?? '0'}}">
                                                </div>
                                            </div>
                                            <script>
                                                $('#area_id{{$shippingAddress->id}}').attr('disabled',1);$('#area_id{{$shippingAddress->id}}_loading').show();$.get('{{route('get-shipping-areas')}}?code={{$shippingAddress->country}}').then(d=>{$('#area_id{{$shippingAddress->id}}').html(d);$('#area_id{{$shippingAddress->id}}_loading').hide();$('#area_id{{$shippingAddress->id}}').find('option[value={{$shippingAddress->area_id}}]').attr("selected","selected")})
                                            </script>


                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                        {{\App\CPU\Helpers::translate('zip_code')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    {{$shippingAddress->zip}}
                                                </div>
                                            </div>

                                            <div class="form-row mb-1">
                                                <strong class="col-6">
                                                    {{ \App\CPU\Helpers::translate('Street - neighborhood')}}:
                                                </strong>
                                                <div class="col-6 text-end">
                                                    {{$shippingAddress->address}}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                            </section>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{--  Payment  --}}

    <section class="col-lg-12 mt-5">
        <div class="checkout_details mt-3 card bg-light border-11">
            <!-- Payment methods accordion-->
            <div class="row p-4">
                <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                    <div class="col-sm-4">
                        <h1 class="h3  mb-0 folot-left headerTitle">
                            {{\App\CPU\Helpers::translate('choose_payment')}}</h1>
                    </div>
                </div>
            </div>
            <div class="row w-100 mx-0">
                @php($digital_payment=\App\CPU\Helpers::get_user_paymment_methods(null,'digital_payment'))
                @php($myfatoorahS=\App\CPU\Helpers::get_user_paymment_methods(null,'myfatoorah'))
                @if (($digital_payment['status'] ?? null)==1)
                @if(($myfatoorahS['status'] ?? null) == "1")
                @foreach ($myFatoorahMethods as $pm)
                @if($pm->ImageUrl == "https://sa.myfatoorah.com/imgs/payment-methods/ap.png" && !$mac_device)
                @else
                <div class="col-md-4 mb-4" style="cursor: pointer">
                    <div class="card">
                        <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                            action="{{route('pay-myfatoorah',['paymentMethodId' => $pm->PaymentMethodId])}}">
                            <div class="card-body" style="height: auto">
                                {{ csrf_field() }}
                                <div class="btn btn-block click-if-alone d-block"
                                    onclick="$(this).next().slideToggle()">
                                    <img width="80" src="{{ $pm->ImageUrl }}" />
                                    <p>
                                        <strong>
                                            {{ session()->get('local') == 'sa' ? $pm->PaymentMethodAr : $pm->PaymentMethodEn }}
                                        </strong>
                                    </p>
                                </div>
                                @if($pm->ImageUrl !== "https://sa.myfatoorah.com/imgs/payment-methods/ap.png")
                                <div style="display: none">
                                    <div class="row">
                                        <div class="col-12 pt-1">
                                            <div class="form-group">
                                                <label for="cardNumber">
                                                    {{ Helpers::translate('cardNumber') }}
                                                </label>
                                                <input class="form-control mx-0 w-100" type="text"
                                                    name="cardNumber" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 pt-1 text-center">
                                            <div class="form-group">
                                                <label for="expiryMonth">
                                                    {{ Helpers::translate('expiryMonth') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4 border-right border-left pt-1 text-center">
                                            <div class="form-group">
                                                <label for="expiryYear">
                                                    {{ Helpers::translate('expiryYear') }}
                                                </label>
                                                <strong
                                                    title="{{ Helpers::translate('(last two numbers, ex: 23 instead of 2023)') }}">
                                                    <i class="fa fa-info" style="font-size: 14px"></i>
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-4 pt-1 text-center">
                                            <div class="form-group">
                                                <label for="securityCode" style="font-size: 12px">
                                                    {{ Helpers::translate('securityCode') }}
                                                </label>
                                                <strong
                                                    title="{{ Helpers::translate('((It consists of 3 numbers))') }}">
                                                    <i class="fa fa-info" style="font-size: 14px"></i>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group pt-1 text-center">
                                                <input class="form-control mx-0 w-100" type="number" max="12"
                                                    autocomplete="off" name="expiryMonth" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-4 border-right border-left pt-1 text-center">
                                            <div class="form-group">
                                                <input class="form-control mx-0 w-100" max="99" type="number"
                                                    autocomplete="off" name="expiryYear" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group pt-1 text-center">
                                                <input class="form-control mx-0 w-100" type="text"
                                                    autocomplete="off" name="securityCode" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-0 m-0 w-100">
                                        <button class="btn btn-success w-100"
                                            type="submit">{{ Helpers::translate('ok') }}</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                @endforeach
                @endif
                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'bank_transfer'))
                @if(!$cod_not_show && count($config))
                <div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body p-0" style="height: max-content;">
                            <form action="{{route('checkout-complete')}}" method="post"
                                class="needs-validation d-grid text-center" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="payment_method" value="bank_transfer">
                                <div class="text-center py-5" onclick="$(this).next().slideToggle()">
                                    <img width="66.3"
                                        src="{{asset('public/assets/front-end/img/bank-transfer-icon.png')}}" />
                                    <p>
                                        <strong>
                                            {{ Helpers::translate('bank_transfer') }}
                                        </strong>
                                    </p>
                                </div>
                                <div style="display: none">
                                    <div class="h-100 p-2">
                                        @php($banks=\App\CPU\Helpers::get_user_paymment_methods(null,'bank_transfer'))
                                        @php($banks_=\App\CPU\Helpers::get_user_paymment_methods(auth('customer')->id(),'bank_transfer'))
                                        @php($item_index = 0)
                                        @php($conf['environment'] = $conf['environment']??'sandbox')
                                        <div class="w-100 text-center p-3 rounded"
                                            style="background-color: #f2f2f2;">
                                            <div class="form-group">
                                                <select name="bank" id="bank" class="form-control"
                                                    onchange="$('._banks').hide();$('.'+$(this).val()+'_bank').show();">
                                                    @foreach ($banks as $index=>$bank)
                                                    @if(($bank['status'] ?? null)  && ($banks_[$index]['status']))
                                                    <option value="{{$index}}">{{$bank['name']}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            @foreach ($banks as $index=>$conf)
                                            @if(($conf['status'] ?? null))
                                            <div class="_banks {{$index}}_bank" @if($index)
                                                style="display: none" @endif>
                                                <div class="form-group">
                                                    <label class="d-flex title-color h6">
                                                        {{\App\CPU\Helpers::translate('Account owner name')}} :
                                                        <br />
                                                        {{$conf['owner_name'] ?? ''}}
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label class="d-flex title-color h6">
                                                        {{\App\CPU\Helpers::translate('Account number')}} :
                                                        {{$conf['account_number'] ?? ''}}
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label class="d-flex title-color h6">
                                                        {{\App\CPU\Helpers::translate('IBAN number')}} :
                                                        {{$conf['iban'] ?? ''}}
                                                    </label>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>

                                        <div class="form-group">
                                            <label for="attachment">
                                                {{ Helpers::translate('Please attach the receipt image') }}
                                            </label>
                                            <input class="form-control mx-0 w-100" type="file"
                                                accept=".docx,.pdf,.png,.jpg" name="attachment" placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="holder_name">
                                                {{ Helpers::translate('Account Holder Name') }}
                                            </label>
                                            <input class="form-control mx-0 w-100" type="text"
                                                name="holder_name" placeholder="">
                                        </div>
                                        @php($item_index++)
                                        @php($config['environment'] = $config['environment']??'sandbox')
                                        <div class="p-0 m-0 w-100">
                                            <button class="btn btn-success w-100" type="submit">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif




                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'stripe'))
                @if(($config['status'] ?? null))
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            <button class="btn btn-block click-if-alone d-block" type="button"
                                id="checkout-button">
                                {{-- <i class="czi-card"></i> {{\App\CPU\Helpers::translate('Credit / Debit card ( Stripe )')}}
                                --}}
                                <img width="150" src="{{asset('public/assets/front-end/img/stripe.png')}}" />
                                <p>
                                    <strong>
                                        {{ Helpers::translate('stripe') }}
                                    </strong>
                                </p>
                            </button>
                            <script type="text/javascript">
                                // Create an instance of the Stripe object with your publishable API key
                                var stripe = Stripe('{{$config['
                                    published_key ']}}');
                                var checkoutButton = document.getElementById("checkout-button");
                                checkoutButton.addEventListener("click", function () {
                                    fetch("{{route('pay-stripe')}}", {
                                        method: "GET",
                                    }).then(function (response) {
                                        console.log(response)
                                        return response.text();
                                    }).then(function (session) {
                                        /*console.log(JSON.parse(session).id)*/
                                        return stripe.redirectToCheckout({
                                            sessionId: JSON.parse(session).id
                                        });
                                    }).then(function (result) {
                                        if (result.error) {
                                            alert(result.error.message);
                                        }
                                    }).catch(function (error) {
                                        console.error(
                                            "{{\App\CPU\Helpers::translate('Error')}}:",
                                            error);
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                @endif

                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'razor_pay'))
                @php($inr=\App\Model\Currency::where(['symbol'=>'₹'])->first())
                @php($usd=\App\Model\Currency::where(['code'=>'USD'])->first())
                @if(isset($inr) && isset($usd) && ($config['status'] ?? null))

                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            <form action="{!!route('payment-razor')!!}" method="POST">
                                @csrf
                                <!-- Note that the amount is in paise = 50 INR -->
                                <!--amount need to be in paisa-->
                                <script src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-bs-key="{{ \Illuminate\Support\Facades\Config::get('razor.razor_key') }}"
                                    data-bs-amount="{{(round(\App\CPU\Convert::usdToinr($amount)))*100}}"
                                    data-bs-buttontext="Pay {{(\App\CPU\Convert::usdToinr($amount))*100}} INR"
                                    data-bs-name="{{\App\Model\BusinessSetting::where(['type'=>'company_name'])->first()->value}}"
                                    data-bs-description=""
                                    data-bs-image="{{asset('storage/app/public/company/'.\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)}}"
                                    data-bs-prefill.name="{{auth('customer')->user()->f_name}}"
                                    data-bs-prefill.email="{{auth('customer')->user()->email}}"
                                    data-bs-theme.color="#ff7529">
                                </script>
                            </form>
                            <button class="btn btn-block click-if-alone d-block" type="button"
                                onclick="$('.razorpay-payment-button').click()">
                                <img width="150" src="{{asset('public/assets/front-end/img/razor.png')}}" />
                                <p>
                                    <strong>
                                        {{ Helpers::translate('razor') }}
                                    </strong>
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paystack'))
                @if(($config['status'] ?? null))
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paystack'))
                            @php($order=\App\Model\Order::find(session('order_id')))
                            <form method="POST" action="{{ route('paystack-pay') }}" accept-charset="UTF-8"
                                class="form-horizontal" role="form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="hidden" name="email"
                                            value="{{auth('customer')->user()->email}}"> {{-- required --}}
                                        <input type="hidden" name="orderID"
                                            value="{{session('cart_group_id')}}">
                                        <input type="hidden" name="amount"
                                            value="{{\App\CPU\Convert::usdTozar($amount*100)}}">
                                        {{-- required in kobo --}}

                                        <input type="hidden" name="currency"
                                            value="{{\App\CPU\Helpers::currency_code()}}">
                                        <input type="hidden" name="metadata"
                                            value="{{ json_encode($array = ['key_name' => 'value',]) }}">
                                        {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                        <input type="hidden" name="reference"
                                            value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                                        <p>
                                            <button class="paystack-payment-button" style="display: none"
                                                type="submit" value="Pay Now!"></button>
                                        </p>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-block click-if-alone d-block" type="button"
                                onclick="$('.paystack-payment-button').click()">
                                <img width="100" src="{{asset('public/assets/front-end/img/paystack.png')}}" />
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @php($myr=\App\Model\Currency::where(['code'=>'MYR'])->first())
                @php($usd=\App\Model\Currency::where(['code'=>'usd'])->first())
                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'senang_pay'))
                @if(isset($myr) && isset($usd) && ($config['status'] ?? null))
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'senang_pay'))
                            @php($user=auth('customer')->user())
                            @php($secretkey = $config['secret_key'])
                            @php($data = new \stdClass())
                            @php($data->merchantId = $config['merchant_id'])
                            @php($data->detail = 'payment')
                            @php($data->order_id = session('cart_group_id'))
                            @php($data->amount = \App\CPU\Convert::usdTomyr($amount))
                            @php($data->name = $user->f_name.' '.$user->l_name)
                            @php($data->email = $user->email)
                            @php($data->phone = $user->phone)
                            @php($data->hashed_string = md5($secretkey . urldecode($data->detail) .
                            urldecode($data->amount) . urldecode($data->order_id)))

                            <form name="order" method="post"
                                action="https://{{env('APP_MODE')=='live'?'app.senangpay.my':'sandbox.senangpay.my'}}/payment/{{$config['merchant_id']}}">
                                <input type="hidden" name="detail" value="{{$data->detail}}">
                                <input type="hidden" name="amount" value="{{$data->amount}}">
                                <input type="hidden" name="order_id" value="{{$data->order_id}}">
                                <input type="hidden" name="name" value="{{$data->name}}">
                                <input type="hidden" name="email" value="{{$data->email}}">
                                <input type="hidden" name="phone" class="phoneInput" value="{{$data->phone}}">
                                <input type="hidden" name="hash" value="{{$data->hashed_string}}">
                            </form>

                            <button class="btn btn-block click-if-alone d-block" type="button"
                                onclick="document.order.submit()">
                                <img width="100" src="{{asset('public/assets/front-end/img/senangpay.png')}}" />
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paymob_accept'))
                @if(($config['status'] ?? null))
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            <form class="needs-validation d-grid text-center" method="POST"
                                id="payment-form-paymob" action="{{route('paymob-credit')}}">
                                {{ csrf_field() }}
                                <button class="btn btn-block click-if-alone d-block" type="submit">
                                    <img width="150"
                                        src="{{asset('public/assets/front-end/img/paymob.png')}}" />
                                    <p>
                                        <strong>
                                            {{ Helpers::translate('paymob') }}
                                        </strong>
                                    </p>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'bkash'))
                @if(isset($config) && ($config['status'] ?? null))
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            <button class="btn btn-block click-if-alone d-block" id="bKash_button"
                                onclick="BkashPayment()">
                                <img width="100" src="{{asset('public/assets/front-end/img/bkash.png')}}" />
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paytabs'))
                @if(isset($config) && ($config['status'] ?? null))
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 175px">
                            <button class="btn btn-block click-if-alone d-block"
                                onclick="location.href='{{route('paytabs-payment')}}'"
                                style="margin-top: -11px">
                                <img width="150" src="{{asset('public/assets/front-end/img/paytabs.png')}}" />
                                <p>
                                    <strong>
                                        {{ Helpers::translate('paytabs') }}
                                    </strong>
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                {{--@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'fawry_pay'))
                    @if(isset($config)  && ($config['status'] ?? null))
                        <div class="col-md-6 mb-4" style="cursor: pointer">
                            <div class="card">
                                <div class="card-body" style="height: 175px">
                                    <button class="btn btn-block" onclick="location.href='{{route('fawry')}}'"
                style="margin-top: -11px">
                <img width="150" src="{{asset('public/assets/front-end/img/fawry.svg')}}" />
                </button>
            </div>
        </div>
</div>
@endif--}}

@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'mercadopago'))
@if(isset($config) && ($config['status'] ?? null))
<div class="col-md-6 mb-4" style="cursor: pointer">
    <div class="card">
        <div class="card-body" style="height: 175px">
            <a class="btn btn-block click-if-alone d-block" href="{{route('mercadopago.index')}}">
                <img width="150" src="{{asset('public/assets/front-end/img/MercadoPago_(Horizontal).svg')}}" />
                <p>
                    <strong>
                        {{ Helpers::translate('mercadopago') }}
                    </strong>
                </p>
            </a>
        </div>
    </div>
</div>
@endif

@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'flutterwave'))
@if(isset($config) && ($config['status'] ?? null))
<div class="col-md-6 mb-4" style="cursor: pointer">
    <div class="card">
        <div class="card-body pt-2" style="height: 175px">
            <form method="POST" action="{{ route('flutterwave_pay') }}">
                {{ csrf_field() }}

                <button class="btn btn-block click-if-alone d-block" type="submit">
                    <img width="200" src="{{asset('public/assets/front-end/img/fluterwave.png')}}" />
                </button>
            </form>
        </div>
    </div>
</div>
@endif

@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paytm'))
@if(isset($config) && ($config['status'] ?? null))
<div class="col-md-6 mb-4" style="cursor: pointer">
    <div class="card">
        <div class="card-body" style="height: 175px">
            <a class="btn btn-block click-if-alone d-block" href="{{route('paytm-payment')}}">
                <img style="max-width: 175px; margin-top: -10px"
                    src="{{asset('public/assets/front-end/img/paytm.png')}}" />
            </a>
        </div>
    </div>
</div>
@endif

@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'liqpay'))
@if(isset($config) && ($config['status'] ?? null))
<div class="col-md-6 mb-4" style="cursor: pointer">
    <div class="card">
        <div class="card-body" style="height: 175px">
            <a class="btn btn-block click-if-alone d-block" href="{{route('liqpay-payment')}}">
                <img style="max-width: 175px; margin-top: 0px"
                    src="{{asset('public/assets/front-end/img/liqpay4.png')}}" />
            </a>
        </div>
    </div>
</div>
@endif
{{--  </div>  --}}
@endif

{{--  <div class="row w-100 mx-0">  --}}
@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'cash_on_delivery'))
@if(!$cod_not_show && ($config['status'] ?? null))
<div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer" onclick="$(this).find('.ok-b').slideToggle()">
    <div class="card">
        <div class="card-body" style="height: 175px">
            <form action="{{route('checkout-complete')}}" method="get"
                class="needs-validation d-grid text-center">
                <input type="hidden" name="payment_method" value="cash_on_delivery">
                <div class="btn btn-block click-if-alone d-block">
                    <img width="120" style="margin-top: -10px"
                        src="{{asset('public/assets/front-end/img/cod.png')}}" />
                    <p>
                        <strong>
                            {{ Helpers::translate('cash_on_delivery') }}
                        </strong>
                    </p>
                </div>
                <div class="p-0 m-0 w-100 ok-b" style="display: none">
                    <button class="btn btn-success w-100" type="submit">Ok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'delayed'))
@if(!$cod_not_show && ($config['status'] ?? null))
<div class="col-md-4 mb-4" id="cod-for-cart" style="cursor: pointer" onclick="$(this).find('.ok-b').slideToggle()">
    <div class="card">
        <div class="card-body" style="height: 175px">
            <form action="{{route('checkout-complete')}}" method="get"
                class="needs-validation d-grid text-center">
                <input type="hidden" name="payment_method" value="delayed">
                <div class="btn btn-block click-if-alone d-block">
                    <img width="70" src="{{asset('public/assets/front-end/img/delayed.jpg')}}" />
                    <p>
                        <strong>
                            {{ Helpers::translate('delayed payment') }}
                        </strong>
                    </p>
                </div>
                <div class="p-0 m-0 w-100 ok-b" style="display: none">
                    <button class="btn btn-success w-100" type="submit">Ok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


@if (($digital_payment['status'] ?? null)==1)
@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'customer_wallet')['wallet_status'])
@if($config==1)
<div class="col-md-4 mb-4" style="cursor: pointer">
    <div class="card">
        <div class="card-body d-grid text-center" style="height: 175px">
            <button class="btn btn-block click-if-alone d-block" type="submit" data-bs-toggle="modal"
                data-bs-target="#wallet_submit_button">

                <img width="50" style="margin-top: -10px"
                    src="{{asset('public/assets/front-end/img/wallet.jpg')}}" />
                <p>
                    <strong>
                        {{ Helpers::translate('wallet') }}
                    </strong>
                </p>
            </button>
        </div>
    </div>
</div>
@endif
@endif

@php($config=\App\CPU\Helpers::get_business_settings('offline_payment'))
@if(isset($config) && $config['status'])
<div class="col-sm-4" id="cod-for-cart">
    <div class="card cursor-pointer">
        <div class="card-body __h-100px">
            <form action="{{route('offline-payment-checkout-complete')}}" method="get"
                class="needs-validation d-grid text-center">
                <span class="btn btn-block click-if-alone d-block" data-bs-toggle="modal"
                    data-bs-target="#offline_payment_submit_button">
                    <img width="150" class="__mt-n-10"
                        src="{{asset('public/assets/front-end/img/pay-offline.png')}}" />
                </span>
            </form>
        </div>
    </div>
</div>
@endif

@php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
@php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount)



@if (($digital_payment['status'] ?? null)==1)

@php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'ssl_commerz_payment'))
@if(($config['status'] ?? null))
<div class="col-md-6 mb-4" style="cursor: pointer">
    <div class="card">
        <div class="card-body" style="height: 175px">
            <form action="{{ url('/pay-ssl') }}" method="POST" class="needs-validation d-grid text-center">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                <button class="btn btn-block click-if-alone d-block" type="submit">
                    <img width="150" src="{{asset('public/assets/front-end/img/sslcomz.png')}}" />
                    <p>
                        <strong>
                            {{ Helpers::translate('sslcomz') }}
                        </strong>
                    </p>
                </button>
            </form>
        </div>
    </div>
</div>
@endif
</div>
<div class="row">
    @php($config=\App\CPU\Helpers::get_user_paymment_methods(null,'paypal'))
    @if(($config['status'] ?? null))
    <div class="col-md-6 mb-4" style="cursor: pointer">
        <div class="card">
            <div class="card-body" style="height: 175px">
                <form class="needs-validation d-grid text-center" method="POST" id="payment-form"
                    action="{{route('pay-paypal')}}">
                    {{ csrf_field() }}
                    <button class="btn btn-block click-if-alone d-block" type="submit">
                        <img width="150" src="{{asset('public/assets/front-end/img/paypal.png')}}" />
                        <p>
                            <strong>
                                {{ Helpers::translate('paypal') }}
                            </strong>
                        </p>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

@endif

</div>
<!-- Navigation (desktop)-->
</div>
</section>
    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'package-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
</div>

@push('script')
    <script>
        $(".update_price").click();
    </script>
@endpush

@endsection


