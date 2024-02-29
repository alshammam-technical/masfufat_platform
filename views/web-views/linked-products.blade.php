@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My linked products '))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="My linked products  of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="My linked products  of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
    <style>
        th{
            border-radius:0 !important;
            border:0 !important;
        }
        .headerTitle {
            font-size: 25px;
            font-weight: 700;
            margin-top: 2rem;
        }

        .for-container {
            width: 91%;
            border: 1px solid #D8D8D8;
            margin-top: 3%;
            margin-bottom: 3%;
        }

        .for-padding {
            padding: 3%;
        }

        td{
            vertical-align: middle !important;
        }

        .table, .dataTables_scrollHead, .table .thead-light th{
            background-color: #F8F8F8;
        }

        .table tbody tr, .table tbody tr td{
            background-color: white !important;
        }

        .dataTables_info{
            float: inherit !important;
        }
    </style>

    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }


        .table th, .table td{
            /*border: none;*/
        }



        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: black !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border: none;
            text-align: center;
        }

        .table, .dataTables_scrollHead{
            background-color: #f8f8f8;
            border: #f8f8f8;
            overflow-y: hidden;
        }

        .dataTables_scrollHeadInner{
            border-radius: 0px !important;
            padding: 0px !important;
        }

        .dataTables_scrollHeadInner{
            background-color: #fff;
        }


        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td{
            border-radius: 0px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        thead, tbody{
            width: 100%;
            border-right: #F8F8F8 solid thin;
            border-left: #F8F8F8 solid thin;
            border-bottom: #F8F8F8 solid thin;
        }

        thead{
            background-color: #F8F8F8;
            border-radius: 11px;
        }

        .card{
            border: none !important;
            box-shadow: none !important;
        }

        *{
            box-shadow: none !important;
            border-radius: 11px !important;
        }

        thead,thead *{
            /*border:solid thin;*/
        }

        .badge-pending,.badge-new{
            padding: 15px !important;
            color: white;
            background-color: #BE52F2;
        }

        .card-footer{
            border: none !important;
            background-color: #F8F8F8 !important;
        }

        .pagination{
            background-color: white;
        }

        .page-item.active,.page-item.active .page-link{
            background-color: #0084F4 !important;
            border-radius: 0px !important;
        }

        .tab-btn.active{
            background-color: white !important;
            border:none !important;
            color: black !important;
        }

        .productImg{
            display: inline !important;
        }
    </style>
@endpush

@section('content')

<form action="{{route('linked-products')}}" method="post" id="syncWithSalla" hidden >
    @csrf
    <input type="hidden" name="products" id="linkedProducts">
    <button class="btn btn-primary mt-2">
        <i class="czi-store"></i>
        {{\App\CPU\Helpers::translate('Add to my products list')}}
    </button>
</form>
<div class="p-md-10" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">

    <div class="flex py-3 px-5 bg-light" style="border-radius: 12px">
        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.view'))
        <div class="px-0 col-4 text-center bg-transparent justify-content-center d-block">
            <button class="p-3 m-0 text-center text-light w-90 btn btn-primary tab-btn text-sm sm:text-md whitespace-normal active"
            onclick="$('.tab-content').hide();$('#unsync').show();retable(0);retable(0);$('.tab-btn').removeClass('active');$(this).addClass('active')"
            >{{\App\CPU\Helpers::translate('My linked products (in pending)')}}</button>
        </div>
        @endif
        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.sync.view'))

        <div class="px-0 col-4 text-center bg-transparent justify-content-center d-block">
            <button class="p-3 m-0 text-center text-light w-90 btn btn-primary tab-btn text-sm sm:text-md whitespace-normal "
            onclick="$('.tab-content').hide();$('#synced').show();retable(1);retable(1);$('.tab-btn').removeClass('active');$(this).addClass('active')"
            >{{\App\CPU\Helpers::translate('My linked products')}}</button>
        </div>
        @endif
        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.view'))
        <div class="px-0 col-4 text-center bg-transparent justify-content-center d-block">
            <button class="p-3 m-0 text-center text-light w-90 btn btn-primary tab-btn text-sm sm:text-md whitespace-normal "
            onclick="$('.tab-content').hide();$('#sync-deleted').show();retable(2);retable(2);$('.tab-btn').removeClass('active');$(this).addClass('active')"
            >{{\App\CPU\Helpers::translate('deleted products')}}</button>
        </div>
        @endif
    </div>


    <div class="pt-0 px-0 mt-6">
        <div class="pt-0 px-0 tab-content" id="unsync">
            @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.settings_of_synchronization'))
            <button class="btn btn-primary bg-primaryColor" onclick="$('#sync_set').slideToggle()">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.8003 12.2926C24.387 12.2926 23.4003 10.5859 24.6003 8.4926C25.2937 7.27926 24.8803 5.7326 23.667 5.03926L21.3603 3.71926C20.307 3.0926 18.947 3.46593 18.3203 4.51926L18.1737 4.7726C16.9737 6.86593 15.0003 6.86593 13.787 4.7726L13.6403 4.51926C13.0403 3.46593 11.6803 3.0926 10.627 3.71926L8.32033 5.03926C7.10699 5.7326 6.69366 7.2926 7.38699 8.50593C8.60033 10.5859 7.61366 12.2926 5.20033 12.2926C3.81366 12.2926 2.66699 13.4259 2.66699 14.8259V17.1726C2.66699 18.5593 3.80033 19.7059 5.20033 19.7059C7.61366 19.7059 8.60033 21.4126 7.38699 23.5059C6.69366 24.7193 7.10699 26.2659 8.32033 26.9593L10.627 28.2793C11.6803 28.9059 13.0403 28.5326 13.667 27.4793L13.8137 27.2259C15.0137 25.1326 16.987 25.1326 18.2003 27.2259L18.347 27.4793C18.9737 28.5326 20.3337 28.9059 21.387 28.2793L23.6937 26.9593C24.907 26.2659 25.3203 24.7059 24.627 23.5059C23.4137 21.4126 24.4003 19.7059 26.8137 19.7059C28.2003 19.7059 29.347 18.5726 29.347 17.1726V14.8259C29.3337 13.4393 28.2003 12.2926 26.8003 12.2926ZM16.0003 20.3326C13.6137 20.3326 11.667 18.3859 11.667 15.9993C11.667 13.6126 13.6137 11.6659 16.0003 11.6659C18.387 11.6659 20.3337 13.6126 20.3337 15.9993C20.3337 18.3859 18.387 20.3326 16.0003 20.3326Z" fill="white"/>
                </svg>
                {{ Helpers::translate('Settings of synchronization') }}
                <i class="fa fa-angle-down ms-3"></i>
            </button>
            @endif
            <div class="pt-4 px-2" id="sync_set" style="display: none">
                <div class="flex">
                    <strong>
                        {{ Helpers::translate('Show the cost price + tax = total cost, to know the cost of the product clearly') }}
                    </strong>
                    <div class="px-2 pt-1">
                        <label class="switcher title-color">
                            <input type="checkbox" class="switcher_input" value="1"
                            onchange="tax_opin('show_calculations',event.target.checked)"
                            @if((auth('customer')->user()->store_informations['show_calculations'] ?? null) == "true") checked @endif
                            >
                            <span class="switcher_control"></span>
                        </label>
                    </div>
                </div>
                <div class="flex mt-6 min-h-[46px]">
                    <strong class="text-nowrap mt-2">
                        {{ Helpers::translate('Have you activated VAT in your store, through your platform settings?') }}
                    </strong>
                    <div class="px-2 pt-1 mt-2">
                        <label class="switcher title-color">
                            <input id="custom_tax_checkbox" type="checkbox" class="switcher_input" value="1" onchange="$('.tax_opin').toggle();tax_opin('custom_tax',event.target.checked)" @if((auth('customer')->user()->store_informations['custom_tax'] ?? null) == "true") checked @endif>
                            <span class="switcher_control"></span>
                        </label>
                    </div>
                    <div class="input-group tax_opin" @if((auth('customer')->user()->store_informations['custom_tax'] ?? null) == "true") @else style="display: none" @endif>
                        <span class="custom-input-group-text input-group-text bg-primary text-light rounded-s-md rounded-e-none">
                            {{ Helpers::translate('You have your value -added tax in your store') }}
                        </span>
                        <div class="form-control p-0 text-start max-w-[73px]" dir="auto">
                          <input id="custom_tax_value" dir="rtl" aria-describedby="basic-addon1" min="0" type="text" pattern="\d*" t="number" class="form-control rounded-e-md rounded-s-none" value="{{ (auth('customer')->user()->store_informations['custom_tax_value'] ?? null) }}" onchange="tax_opin('custom_tax_value',event.target.value)">
                        </div>
                    </div>
                </div>
                <p class="pt-2 text-danger">
                    {{ Helpers::translate('Note, when activating this option, an amount or profit rate will be added to the cost price only without calculating the tax, because it will be added in your store automatically.') }}
                </p>
            </div>

            <div class="columns-1 w-full text-center py-3 bg-light mx-0 mt-4 justify-center sm:flex" style="border-radius: 12px">

                <div class="col-md-4 text-center justify-content-center">

                </div>

                <div class="col-md-4">
                    @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.save_and_sync'))
                    <button class="btn btn-primary mt-2 px-8 w-75" onclick="syncNow(0)">
                        {{ \App\CPU\Helpers::translate('Save & Sync now') }}
                    </button>
                    @endif
                </div>

                <div class="col-md-4 text-end justify-content-end d-flex">
                    <div style="display:none" class="d-flex table-actions flex-wrap justify-content-center mx-3 wd-md-50p">
                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.save'))
                        <button class="btn ti-save my-2 btn-icon-text m-2 text-primaryColor" onclick="saveAll()">
                            {{--  icon  --}}
                            <svg width="27" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_2296_460927)"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 5.14272C8.25 4.51186 8.7876 3.99986 9.45 3.99986C10.1124 3.99986 10.65 4.51186 10.65 5.14272C10.65 5.77357 10.1124 6.28557 9.45 6.28557C8.7876 6.28557 8.25 5.77357 8.25 5.14272ZM19.2 17.7141C19.2 18.345 18.6624 18.857 18 18.857H6C5.3376 18.857 4.8 18.345 4.8 17.7141C4.8 17.0833 5.3376 16.5713 6 16.5713H18C18.6624 16.5713 19.2 17.0833 19.2 17.7141ZM19.2 13.1427C19.2 13.7736 18.6624 14.2856 18 14.2856H6C5.3376 14.2856 4.8 13.7736 4.8 13.1427C4.8 12.5119 5.3376 11.9999 6 11.9999H18C18.6624 11.9999 19.2 12.5119 19.2 13.1427ZM21.6 19.9999C21.6 20.6307 21.0624 21.1427 20.4 21.1427H3.6C2.9376 21.1427 2.4 20.6307 2.4 19.9999V8.62158C2.4 8.46958 2.4636 8.32441 2.5752 8.21812L4.8 6.09926V7.42843C4.8 8.69129 5.874 9.71415 7.2 9.71415H16.8C18.126 9.71415 19.2 8.69129 19.2 7.42843V2.857H20.4C21.0624 2.857 21.6 3.369 21.6 3.99986V19.9999ZM7.2 3.81355L8.0292 3.02386C8.1408 2.91757 8.2944 2.857 8.4528 2.857H16.8V6.28557C16.8 6.91643 16.2624 7.42843 15.6 7.42843H8.4C7.7376 7.42843 7.2 6.91643 7.2 6.28557V3.81355ZM21.6 0.571289H7.7148C7.3968 0.571289 7.092 0.69128 6.8676 0.904994L0.3564 7.09354C0.1308 7.3084 0.00479998 7.59869 0.00479998 7.90269L0 21.1427C0 22.4044 1.074 23.4284 2.3988 23.4284H21.6C22.926 23.4284 24 22.4056 24 21.1427V2.857C24 1.59415 22.926 0.571289 21.6 0.571289Z" fill="#5A409B"></path></g><defs><clipPath id="clip0_2296_460927"><rect width="24" height="24" fill="#5A409B"></rect></clipPath></defs></svg>
                            {{--  icon  --}}
                        </button>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.delete'))
                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete','Want to delete this items ?')">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.0932 6.97268C25.9466 6.75935 23.7999 6.59935 21.6399 6.47935V6.46602L21.3465 4.73268C21.1465 3.50602 20.8532 1.66602 17.7332 1.66602H14.2399C11.1332 1.66602 10.8399 3.42602 10.6266 4.71935L10.3466 6.42602C9.10655 6.50602 7.86655 6.58602 6.62655 6.70602L3.90655 6.97268C3.34655 7.02602 2.94655 7.51935 2.99988 8.06602C3.05322 8.61268 3.53322 9.01268 4.09322 8.95935L6.81322 8.69268C13.7999 7.99935 20.8399 8.26602 27.9066 8.97268C27.9466 8.97268 27.9732 8.97268 28.0132 8.97268C28.5199 8.97268 28.9599 8.58602 29.0132 8.06602C29.0532 7.51935 28.6532 7.02602 28.0932 6.97268Z" fill="#FF000F"/>
                                <path d="M25.6403 10.854C25.3203 10.5207 24.8803 10.334 24.427 10.334H7.57365C7.12032 10.334 6.66698 10.5207 6.36032 10.854C6.05365 11.1873 5.88032 11.6407 5.90698 12.1073L6.73365 25.7873C6.88032 27.814 7.06698 30.3473 11.7203 30.3473H20.2803C24.9337 30.3473 25.1203 27.8273 25.267 25.7873L26.0937 12.1207C26.1203 11.6407 25.947 11.1873 25.6403 10.854ZM18.2136 23.6673H13.7737C13.227 23.6673 12.7737 23.214 12.7737 22.6673C12.7737 22.1207 13.227 21.6673 13.7737 21.6673H18.2136C18.7603 21.6673 19.2136 22.1207 19.2136 22.6673C19.2136 23.214 18.7603 23.6673 18.2136 23.6673ZM19.3337 18.334H12.667C12.1203 18.334 11.667 17.8807 11.667 17.334C11.667 16.7873 12.1203 16.334 12.667 16.334H19.3337C19.8803 16.334 20.3337 16.7873 20.3337 17.334C20.3337 17.8807 19.8803 18.334 19.3337 18.334Z" fill="#FF000F"/>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 px-0 border" id="items">
                <div>
                    <table style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};margin-top:0px !important" class="products-dataTable0 table table-hover table-thead-bordered table-nowrap table-align-middle card-table"
                                    style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th class="sm:hidden" scope="col"></th>
                                <th scope="col">

                                </th>
                                <th><strong>{{ Helpers::translate('ID') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('image') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('Product Number & barcodee') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('name') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('The amount and the proportion of profit') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('sale price in my store') }}</strong></th>
                                <th><strong>{{ Helpers::translate('actions') }}</strong></th>
                            </tr>
                        </thead>
                        <thead class="theadF">
                            <tr>
                                <th class="sm:hidden" scope="col"></th>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked,'bulk-delete',0)" />
                                </th>
                                <th colName="id" class="theadFilter"></th>
                                <th class=""></th>
                                <th colName="name" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="item_number" class="hidden sm:table-cell theadFilter"></th>
                                <th class="theadFilter" colName="purchase_price"></th>
                                <th colName="unit_price" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="featured" class="hidden sm:table-cell theadFilter"></th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('web-views.pending-tr',['pro'=>$products,'delete_function'=>'deleteFromList','formId'=>'bulk-delete'])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <form hidden action="{{route('salla.products.bulk.delete')}}" method="post" id="bulk-delete">
            @csrf @method('delete')
            <input type="text" name="ids" class="ids">
            <input type="text" name="not_ids" class="not_ids">
        </form>
        <form hidden action="{{route('salla.linkedproducts.bulk.delete')}}" method="post" id="bulk-delete-linked">
            @csrf @method('delete')
            <input type="text" name="ids" class="ids">
                <input type="text" name="not_ids" class="not_ids">
        </form>
        <form hidden action="{{route('salla.linkedproducts.bulk.delete')}}" method="post" id="bulk-delete-deleted">
            @csrf @method('delete')
            <input type="text" name="ids" class="ids">
            <input type="text" name="not_ids" class="not_ids">
            <input type="hidden" name="deleted" value="1">
        </form>


        <div class="pt-2 px-0 tab-content" id="synced" style="display: none">
            <div class="row w-full text-center py-3 bg-light mx-0 mt-4" style="border-radius: 12px">

                <div class="col-md-4 text-center justify-content-center">

                </div>

                <div class="col-md-4 text-center justify-content-center d-flex">
                    <div style="display:none" class="d-flex table-actions flex-wrap justify-content-center mx-3 wd-md-50p">
                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.sync.save'))
                        <button class="btn ti-save my-2 btn-icon-text m-2" onclick="saveAll()">
                            <svg width="27" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_2296_460927)"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 5.14272C8.25 4.51186 8.7876 3.99986 9.45 3.99986C10.1124 3.99986 10.65 4.51186 10.65 5.14272C10.65 5.77357 10.1124 6.28557 9.45 6.28557C8.7876 6.28557 8.25 5.77357 8.25 5.14272ZM19.2 17.7141C19.2 18.345 18.6624 18.857 18 18.857H6C5.3376 18.857 4.8 18.345 4.8 17.7141C4.8 17.0833 5.3376 16.5713 6 16.5713H18C18.6624 16.5713 19.2 17.0833 19.2 17.7141ZM19.2 13.1427C19.2 13.7736 18.6624 14.2856 18 14.2856H6C5.3376 14.2856 4.8 13.7736 4.8 13.1427C4.8 12.5119 5.3376 11.9999 6 11.9999H18C18.6624 11.9999 19.2 12.5119 19.2 13.1427ZM21.6 19.9999C21.6 20.6307 21.0624 21.1427 20.4 21.1427H3.6C2.9376 21.1427 2.4 20.6307 2.4 19.9999V8.62158C2.4 8.46958 2.4636 8.32441 2.5752 8.21812L4.8 6.09926V7.42843C4.8 8.69129 5.874 9.71415 7.2 9.71415H16.8C18.126 9.71415 19.2 8.69129 19.2 7.42843V2.857H20.4C21.0624 2.857 21.6 3.369 21.6 3.99986V19.9999ZM7.2 3.81355L8.0292 3.02386C8.1408 2.91757 8.2944 2.857 8.4528 2.857H16.8V6.28557C16.8 6.91643 16.2624 7.42843 15.6 7.42843H8.4C7.7376 7.42843 7.2 6.91643 7.2 6.28557V3.81355ZM21.6 0.571289H7.7148C7.3968 0.571289 7.092 0.69128 6.8676 0.904994L0.3564 7.09354C0.1308 7.3084 0.00479998 7.59869 0.00479998 7.90269L0 21.1427C0 22.4044 1.074 23.4284 2.3988 23.4284H21.6C22.926 23.4284 24 22.4056 24 21.1427V2.857C24 1.59415 22.926 0.571289 21.6 0.571289Z" fill="#5A409B"></path></g><defs><clipPath id="clip0_2296_460927"><rect width="24" height="24" fill="#5A409B"></rect></clipPath></defs></svg>
                        </button>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.sync.delete'))
                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete-linked','Want to delete this items ?')">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.0932 6.97268C25.9466 6.75935 23.7999 6.59935 21.6399 6.47935V6.46602L21.3465 4.73268C21.1465 3.50602 20.8532 1.66602 17.7332 1.66602H14.2399C11.1332 1.66602 10.8399 3.42602 10.6266 4.71935L10.3466 6.42602C9.10655 6.50602 7.86655 6.58602 6.62655 6.70602L3.90655 6.97268C3.34655 7.02602 2.94655 7.51935 2.99988 8.06602C3.05322 8.61268 3.53322 9.01268 4.09322 8.95935L6.81322 8.69268C13.7999 7.99935 20.8399 8.26602 27.9066 8.97268C27.9466 8.97268 27.9732 8.97268 28.0132 8.97268C28.5199 8.97268 28.9599 8.58602 29.0132 8.06602C29.0532 7.51935 28.6532 7.02602 28.0932 6.97268Z" fill="#FF000F"></path>
                                <path d="M25.6403 10.854C25.3203 10.5207 24.8803 10.334 24.427 10.334H7.57365C7.12032 10.334 6.66698 10.5207 6.36032 10.854C6.05365 11.1873 5.88032 11.6407 5.90698 12.1073L6.73365 25.7873C6.88032 27.814 7.06698 30.3473 11.7203 30.3473H20.2803C24.9337 30.3473 25.1203 27.8273 25.267 25.7873L26.0937 12.1207C26.1203 11.6407 25.947 11.1873 25.6403 10.854ZM18.2136 23.6673H13.7737C13.227 23.6673 12.7737 23.214 12.7737 22.6673C12.7737 22.1207 13.227 21.6673 13.7737 21.6673H18.2136C18.7603 21.6673 19.2136 22.1207 19.2136 22.6673C19.2136 23.214 18.7603 23.6673 18.2136 23.6673ZM19.3337 18.334H12.667C12.1203 18.334 11.667 17.8807 11.667 17.334C11.667 16.7873 12.1203 16.334 12.667 16.334H19.3337C19.8803 16.334 20.3337 16.7873 20.3337 17.334C20.3337 17.8807 19.8803 18.334 19.3337 18.334Z" fill="#FF000F"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 px-0 border" id="items">
                <div>
                    <table style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};margin-top:0px !important" class="products-dataTable1 linked_products_table table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th class="sm:hidden" scope="col"></th>
                                <th scope="col">

                                </th>
                                <th><strong>{{ Helpers::translate('ID') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('image') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('Item Number') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('product_code_sku') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('name') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('sale price in my store') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('sync date') }}</strong></th>
                                <th><strong>{{ Helpers::translate('actions') }}</strong></th>
                            </tr>
                        </thead>
                        <thead class="theadF">
                            <tr>
                                <th class="sm:hidden" scope="col"></th>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked,'bulk-delete-linked',1)" />
                                </th>
                                <th colName="id" class="theadFilter"></th>
                                <th class=""></th>
                                <th colName="name" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="item_number" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="code" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="purchase_price" class="theadFilter"></th>
                                <th colName="unit_price" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="featured" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="synced_at" class="hidden sm:table-cell theadFilter"></th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('web-views.tr',['pro'=>$products_linked,'formId'=>'bulk-delete-linked','delete_function'=>'deleteFromLinked',
                            'extra_data' => ['is_deleted' => 0]])
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="pt-2 px-0 tab-content" id="sync-deleted" style="display: none">
            <div class="row w-full text-center py-3 bg-light mx-0 mt-4" style="border-radius: 12px">

                <div class="col-md-4 text-center justify-content-center">

                </div>

                <div class="col-md-4">
                    @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.sync'))
                    <button class="btn btn-primary mt-2 px-8 w-75" onclick="syncNow(1)">
                        {{ \App\CPU\Helpers::translate('Save & Sync now') }}
                    </button>
                    @endif
                </div>

                <div class="col-md-4 text-center justify-content-center d-flex">
                    <div style="display:none" class="d-flex table-actions flex-wrap justify-content-center mx-3 wd-md-50p">
                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.save'))
                        <button class="btn ti-save my-2 btn-icon-text m-2" onclick="saveAll()">
                            <svg width="27" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_2296_460927)"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 5.14272C8.25 4.51186 8.7876 3.99986 9.45 3.99986C10.1124 3.99986 10.65 4.51186 10.65 5.14272C10.65 5.77357 10.1124 6.28557 9.45 6.28557C8.7876 6.28557 8.25 5.77357 8.25 5.14272ZM19.2 17.7141C19.2 18.345 18.6624 18.857 18 18.857H6C5.3376 18.857 4.8 18.345 4.8 17.7141C4.8 17.0833 5.3376 16.5713 6 16.5713H18C18.6624 16.5713 19.2 17.0833 19.2 17.7141ZM19.2 13.1427C19.2 13.7736 18.6624 14.2856 18 14.2856H6C5.3376 14.2856 4.8 13.7736 4.8 13.1427C4.8 12.5119 5.3376 11.9999 6 11.9999H18C18.6624 11.9999 19.2 12.5119 19.2 13.1427ZM21.6 19.9999C21.6 20.6307 21.0624 21.1427 20.4 21.1427H3.6C2.9376 21.1427 2.4 20.6307 2.4 19.9999V8.62158C2.4 8.46958 2.4636 8.32441 2.5752 8.21812L4.8 6.09926V7.42843C4.8 8.69129 5.874 9.71415 7.2 9.71415H16.8C18.126 9.71415 19.2 8.69129 19.2 7.42843V2.857H20.4C21.0624 2.857 21.6 3.369 21.6 3.99986V19.9999ZM7.2 3.81355L8.0292 3.02386C8.1408 2.91757 8.2944 2.857 8.4528 2.857H16.8V6.28557C16.8 6.91643 16.2624 7.42843 15.6 7.42843H8.4C7.7376 7.42843 7.2 6.91643 7.2 6.28557V3.81355ZM21.6 0.571289H7.7148C7.3968 0.571289 7.092 0.69128 6.8676 0.904994L0.3564 7.09354C0.1308 7.3084 0.00479998 7.59869 0.00479998 7.90269L0 21.1427C0 22.4044 1.074 23.4284 2.3988 23.4284H21.6C22.926 23.4284 24 22.4056 24 21.1427V2.857C24 1.59415 22.926 0.571289 21.6 0.571289Z" fill="#5A409B"></path></g><defs><clipPath id="clip0_2296_460927"><rect width="24" height="24" fill="#5A409B"></rect></clipPath></defs></svg>
                        </button>
                        @endif

                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.delete'))
                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete-deleted','Want to delete this items ?')">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.0932 6.97268C25.9466 6.75935 23.7999 6.59935 21.6399 6.47935V6.46602L21.3465 4.73268C21.1465 3.50602 20.8532 1.66602 17.7332 1.66602H14.2399C11.1332 1.66602 10.8399 3.42602 10.6266 4.71935L10.3466 6.42602C9.10655 6.50602 7.86655 6.58602 6.62655 6.70602L3.90655 6.97268C3.34655 7.02602 2.94655 7.51935 2.99988 8.06602C3.05322 8.61268 3.53322 9.01268 4.09322 8.95935L6.81322 8.69268C13.7999 7.99935 20.8399 8.26602 27.9066 8.97268C27.9466 8.97268 27.9732 8.97268 28.0132 8.97268C28.5199 8.97268 28.9599 8.58602 29.0132 8.06602C29.0532 7.51935 28.6532 7.02602 28.0932 6.97268Z" fill="#FF000F"></path>
                                <path d="M25.6403 10.854C25.3203 10.5207 24.8803 10.334 24.427 10.334H7.57365C7.12032 10.334 6.66698 10.5207 6.36032 10.854C6.05365 11.1873 5.88032 11.6407 5.90698 12.1073L6.73365 25.7873C6.88032 27.814 7.06698 30.3473 11.7203 30.3473H20.2803C24.9337 30.3473 25.1203 27.8273 25.267 25.7873L26.0937 12.1207C26.1203 11.6407 25.947 11.1873 25.6403 10.854ZM18.2136 23.6673H13.7737C13.227 23.6673 12.7737 23.214 12.7737 22.6673C12.7737 22.1207 13.227 21.6673 13.7737 21.6673H18.2136C18.7603 21.6673 19.2136 22.1207 19.2136 22.6673C19.2136 23.214 18.7603 23.6673 18.2136 23.6673ZM19.3337 18.334H12.667C12.1203 18.334 11.667 17.8807 11.667 17.334C11.667 16.7873 12.1203 16.334 12.667 16.334H19.3337C19.8803 16.334 20.3337 16.7873 20.3337 17.334C20.3337 17.8807 19.8803 18.334 19.3337 18.334Z" fill="#FF000F"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 px-0 border" id="items">
                <div>
                    <table style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};margin-top:0px !important" class="products-dataTable2 table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th class="sm:hidden" scope="col"></th>
                                <th scope="col">

                                </th>
                                <th><strong>{{ Helpers::translate('ID') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('image') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('Item Number') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('product_code_sku') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('name') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                <th class=""><strong>{{ Helpers::translate('sale price in my store') }}</strong></th>
                                <th><strong>{{ Helpers::translate('actions') }}</strong></th>
                            </tr>
                        </thead>
                        <thead class="theadF">
                            <tr>
                                <th class="sm:hidden" scope="col"></th>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked,'bulk-delete-deleted',2)" />
                                </th>
                                <th colName="id" class="theadFilter"></th>
                                <th class=""></th>
                                <th colName="name" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="item_number" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="code" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="purchase_price" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="unit_price" class="hidden sm:table-cell theadFilter"></th>
                                <th colName="featured" class="hidden sm:table-cell theadFilter"></th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('web-views.tr',['pro'=>$products_deleted,'delete_function'=>'deleteFromList',
                            'extra_data' => ['is_deleted' => 1, 'Sync' => 'SyncDeleteFromList'],'formId'=>'bulk-delete-deleted'])
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
    </div>
</div>

@push('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    @include('web-views.linked-products-js')
    <script>
        var skip = 0;
        var allRecSelected = false;
        var theadF = [];

        function saveScrollPosition(){
            current0ScrollPosition = $('#unsync * .dataTables_scrollBody').scrollTop();
            current1ScrollPosition = $('#synced * .dataTables_scrollBody').scrollTop();
            current2ScrollPosition = $('#sync-deleted * .dataTables_scrollBody').scrollTop();
        }

        function restoreScrollPosition(){
            $('#unsync * .dataTables_scrollBody').scrollTop(current0ScrollPosition);
            $('#synced * .dataTables_scrollBody').scrollTop(current1ScrollPosition);
            $('#sync-deleted * .dataTables_scrollBody').scrollTop(current2ScrollPosition);
        }

        theadF[0] = $('.products-dataTable0').find(".theadF").html();
        theadF[1] = $('.products-dataTable1').find(".theadF").html();
        theadF[2] = $('.products-dataTable2').find(".theadF").html();

        var theIndex
        var boo;
        var currentScrollPosition;
        var current0ScrollPosition;
        var table = [];
        var theLength = {{ $pro_count[0] }};
        var theLengths = [];
        theLengths[0] = {{ $pro_count[0] }};
        theLengths[1] = {{ $pro_count[1] }};
        theLengths[2] = {{ $pro_count[2] }};
        var sc = true;
        var scc = [];
        var ddd;
        var cleared = false
        scc[0] = true
        scc[1] = true
        scc[2] = true
        retable(0)


        function retable(index){
            if(theIndex == index){
                return;
            }
            if(!theLengths[index]){
                return;
            }
            theIndex = index
            theLength = theLengths[index]
            $(".theadF").remove();
            if(table[index]){
                table[index].destroy();
            }

            $("<thead class='theadF'>" + theadF[index] + "</thead>").insertAfter('.products-dataTable'+index+' thead');
            $(".buttons-colvis").remove();
            table[index] = $('.products-dataTable'+index+'').DataTable({
                dom: 'Blfrti',
                buttons: [
                    {
                        extend: 'excel',
                        text:'<i class="fa fa-file-excel-o"></i>',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'colvis',
                        text:'<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.5299 9.46992L9.46992 14.5299C8.81992 13.8799 8.41992 12.9899 8.41992 11.9999C8.41992 10.0199 10.0199 8.41992 11.9999 8.41992C12.9899 8.41992 13.8799 8.81992 14.5299 9.46992Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M17.8201 5.76998C16.0701 4.44998 14.0701 3.72998 12.0001 3.72998C8.47009 3.72998 5.18009 5.80998 2.89009 9.40998C1.99009 10.82 1.99009 13.19 2.89009 14.6C3.68009 15.84 4.60009 16.91 5.60009 17.77" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.41992 19.5302C9.55992 20.0102 10.7699 20.2702 11.9999 20.2702C15.5299 20.2702 18.8199 18.1902 21.1099 14.5902C22.0099 13.1802 22.0099 10.8102 21.1099 9.40018C20.7799 8.88018 20.4199 8.39018 20.0499 7.93018" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15.5099 12.7002C15.2499 14.1102 14.0999 15.2602 12.6899 15.5202" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M9.47 14.5298L2 21.9998" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M22 2L14.53 9.47" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>',
                        className: 'btn btn-r'
                    },
                ],
                paging:false,
                responsive: true,
                columnDefs: [
                    {
                        "defaultContent": "-",
                        "targets": "_all"
                    },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: 2 },
                    { responsivePriority: 4, targets: 7 },
                    { responsivePriority: 5, targets: 10 },

                    { responsivePriority: 6, targets: 3 },
                    { responsivePriority: 7, targets: 4 },
                    { responsivePriority: 8, targets: 5 },
                    { responsivePriority: 9, targets: 6 },
                    { responsivePriority: 10, targets: 8 },
                    { responsivePriority: 11, targets: 9 },
                ],
                colReorder: true,
                fixedHeader: true,
                stateSave: false,
                scrollY: '490px',
                scrollX: true,
                autoWidth:false,
                order: [[ 2, 'asc' ]],
                scrollCollapse: true,
                initComplete: function () {
                    var that = this
                    $("#unsync * .dataTables_scrollBody").on("scroll",function(e){
                        if($(".engh").length){}else{
                            var ths = $(this);
                            var tbody = $(this).find('tbody');
                            var elem = $(e.currentTarget);
                            console.log(sc , scc[0] , (elem[0].scrollHeight - elem.scrollTop() <= (elem.outerHeight() + 20)) , table[0] !== undefined , theLength >= 21 , cleared)
                            if ((sc && scc[0] && (elem[0].scrollHeight - elem.scrollTop() <= (elem.outerHeight() + 20)) && table[0] !== undefined && theLength >= 21) || cleared) {
                                sc = false;
                                scc[0] = false;
                                if(!cleared){
                                    skip = skip + 20
                                }
                                var s = table[0].state()
                                s.tab = 0
                                saveScrollPosition()
                                $.ajax({
                                    url:"{{route('list_skip')}}?skip="+skip,
                                    data: s,
                                    success:function(data){
                                        if(cleared){
                                            skip = skip + 20
                                        }
                                        cleared = false
                                        if($(".engh").length){}else{
                                            $(data).each(function(e,i){
                                                var rowId = $(this).find('.rowId').text()
                                                if($('.dataTables_scrollBody:visible').find('#product-'+rowId).length){}else{
                                                    table[0].rows.add($(this))
                                                }
                                            })
                                            table[0].draw()

                                            sc = true
                                            scc[0] = $(data).length;
                                            if(allRecSelected){
                                                checkAll_p(allRecSelected);
                                            }
                                            $('*:contains("-")').filter(function() {
                                              return $(this).text() === '-';
                                            }).closest('tr').remove();
                                            restoreScrollPosition()
                                        }
                                    }
                                })
                            }
                        }
                    })
                    $("#synced * .dataTables_scrollBody").on("scroll",function(e){
                        if($(".engh").length){}else{
                            var ths = $(this);
                            var tbody = $(this).find('tbody');
                            var elem = $(e.currentTarget);
                            if (sc && scc[1] && (elem[0].scrollHeight - elem.scrollTop() <= (elem.outerHeight() + 20)) && table[1] !== undefined && theLength >= 21) {
                                sc = false;
                                scc[1] = false;
                                skip = skip + 20
                                var s = table[1].state()
                                s.tab = 1
                                saveScrollPosition()
                                console.log(0)
                                $.ajax({
                                    url:"{{route('list_skip')}}?skip="+skip,
                                    data: s,
                                    success:function(data){
                                        if($(".engh").length){}else{
                                            $(data).each(function(e,i){
                                                var rowId = $(this).find('.rowId').text()
                                                if($('.dataTables_scrollBody:visible').find('#product-'+rowId).length){}else{
                                                    table[1].rows.add($(this))
                                                }
                                            })
                                            table[1].draw()

                                            sc = true
                                            scc[1] = $(data).length;
                                            console.log(0)
                                            if(allRecSelected){
                                                checkAll_p(allRecSelected);
                                            }
                                            $('*:contains("-")').filter(function() {
                                              return $(this).text() === '-';
                                            }).closest('tr').remove();
                                            restoreScrollPosition()
                                        }
                                    }
                                })
                            }
                        }
                    })
                    $("#sync-deleted * .dataTables_scrollBody").on("scroll",function(e){
                        if($(".engh").length){}else{
                            var ths = $(this);
                            var tbody = $(this).find('tbody');
                            var elem = $(e.currentTarget);
                            if (sc && scc[2] && (elem[0].scrollHeight - elem.scrollTop() <= (elem.outerHeight() + 20)) && table[2] !== undefined && theLength >= 21) {
                                sc = false;
                                scc[2] = false;
                                skip = skip + 20
                                var s = table[2].state()
                                s.tab = 2
                                saveScrollPosition()
                                console.log(0)
                                $.ajax({
                                    url:"{{route('list_skip')}}?skip="+skip,
                                    data: s,
                                    success:function(data){
                                        if($(".engh").length){}else{
                                            $(data).each(function(e,i){
                                                var rowId = $(this).find('.rowId').text()
                                                if($('.dataTables_scrollBody:visible').find('#product-'+rowId).length){}else{
                                                    table[2].rows.add($(this))
                                                }
                                            })
                                            table[2].draw()

                                            sc = true
                                            scc[2] = $(data).length;
                                            if(allRecSelected){
                                                checkAll_p(allRecSelected);
                                            }
                                            $('*:contains("-")').filter(function() {
                                              return $(this).text() === '-';
                                            }).closest('tr').remove();
                                            restoreScrollPosition()
                                        }
                                    }
                                })
                            }
                        }
                    })
                    $('<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><nav class="pagination" role="navigation" aria-label="pagination"></nav></div>').insertAfter($('.products-dataTable'+index+'').closest('.tab-content').find(".dataTables_info"));
                    $('<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><nav class="pagination" role="navigation" aria-label="pagination"></nav></div>').insertAfter($('.products-dataTable'+index+'').closest('.tab-content').find(".dataTables_info"));
                    $(".table-responsive.pagingLinks").appendTo($('.products-dataTable'+index+'').closest('.tab-content').find('.dataTables_paginate nav'))
                    var btns = $('.products-dataTable'+index+'').closest('.tab-content').find('.dt-button');
                    btns.removeClass('dt-button');
                    var that = this
                    dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                    this.api().columns().every( function (e) {
                        var column = this;
                        var select = $('<input type="text" class="form-control dt-filter hidden sm:block " placeholder="" />')
                        .appendTo( $(".products-dataTable"+index+" .theadF tr .theadFilter").eq(column.index()) )
                        .on( 'change', function (e) {
                            skip = 0;
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            that.api().columns($(e.target).parent().index())
                            .search($(this).val());
                            var s = table[index].state()
                            s.columns[$(e.target).parent().index()].search.search = $(this).val();
                            s.skip = skip
                            s.tab = index

                            $.ajax({
                                type: 'get',
                                url :"{{route('list_skip')}}?skip="+skip,
                                data: s,
                                success: function(data){
                                    ddd = data;
                                    table[index].clear().draw()
                                    $(data).each(function(e,i){
                                        var rowId = $(this).find('.rowId').text()
                                        if($('.dataTables_scrollBody:visible').find('#product-'+rowId).length){
                                        }else{
                                            table[index].rows.add($(this))
                                        }
                                    })
                                    table[index].draw()
                                    scc[index] = true
                                    $('*:contains("-")').filter(function() {
                                      return $(this).text() === '-';
                                    }).closest('tr').remove();
                                    if(allRecSelected){
                                        checkAll_p(allRecSelected);
                                    }
                                }
                            })
                        });
                    } );
                    $(".buttons-colvis").appendTo(".table-actions:visible");
                    $(".buttons-colvis").addClass("my-2 btn-icon-text m-2 px-2");
                    $('.dataTables_filter').remove();
                    $('.dataTables_length').hide();
                    $('.products-dataTable'+index+' tbody').show();
                    $('<div class="dataTables_info" role="status" aria-live="polite">{{\App\CPU\Helpers::translate("Selected Records")}}: <span class="table_selected"></span></div>').insertAfter($('.products-dataTable'+index+'').closest('.tab-content').find(".dataTables_info"));
                },
                language: {
                    "lengthMenu": "{{Helpers::translate('Display')}} _MENU_ {{Helpers::translate('records per page')}}",
                    "zeroRecords": "{{Helpers::translate('...')}}",
                    "info": "",
                    "infoEmpty": "{{Helpers::translate('No records available')}}",
                    "infoFiltered": "{{Helpers::translate('filtered from _MAX_ total records')}}"
                }
            });
        }

        function deldef(){
            $('*:contains("-")').filter(function() {
                return $(this).text() === '-';
              }).closest('tr').remove();
        }

        $(document).ready(function () {
            if(localStorage.getItem('tableView') === 'grid'){
                $(".btn-grid").click();
            }
            table[0].on('draw',function(){
                deldef()
                dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })
            table[0].draw();


            table[1].on('draw',function(){
                deldef()
                dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })
            table[1].draw();

            table[2].on('draw',function(){
                deldef()
                dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })
            table[2].draw();

            table[0].on('order',function(){
                if(theIndex == 0){
                    skip = 0;
                    var s = table[0].state()
                    s.tab = 0
                    $.ajax({
                        type: 'get',
                        url :"{{route('list_skip')}}?skip="+skip,
                        data: s,
                        success: function(data){
                            $("#unsync * .dataTables_scrollBody * tbody").html(data);
                            scc[0] = true
                            if(allRecSelected){
                                checkAll_p(allRecSelected);
                            }
                        }
                    })
                }
            })

            table[1].on('order',function(){
                if(theIndex == 0){
                    skip = 0;
                    var s = table[1].state()
                    s.tab = 1
                    $.ajax({
                        type: 'get',
                        url :"{{route('list_skip')}}?skip="+skip,
                        data: s,
                        success: function(data){
                            $("#synced * .dataTables_scrollBody * tbody").html(data);
                            scc[1] = true
                            if(allRecSelected){
                                checkAll_p(allRecSelected);
                            }
                        }
                    })
                }
            })

            table[2].on('order',function(){
                if(theIndex == 0){
                    skip = 0;
                    var s = table[2].state()
                    s.tab = 2
                    $.ajax({
                        type: 'get',
                        url :"{{route('list_skip')}}?skip="+skip,
                        data: s,
                        success: function(data){
                            $("#synced * .dataTables_scrollBody * tbody").html(data);
                            scc[2] = true
                            if(allRecSelected){
                                checkAll_p(allRecSelected);
                            }
                        }
                    })
                }
            })


            $(".btnDT").click(function(){
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })

        });


    </script>
    <script>
        var price_edits = new Object();
        var selectedProducts = "{{$pArr}}";
        selectedProducts = selectedProducts.split(',');
        function saveAll(){
            alert_wait();
            $.ajax({
                url:'{{ route('linked-products.price.edit') }}',
                type:'post',
                data:{
                    _token: '{{ csrf_token() }}',
                    price_edits:price_edits
                },
                success:function(data){
                    location.reload();
                }
            })
        }


        function checkAll_p(checked,formid,index){
            $(".btnAddFrom").attr('disabled');
            allRecSelected = checked;
            $(".trSelector").prop('checked',checked);
            if(checked){
                $('#'+formid+' .ids').val("all")
                $(".dataTables_info:visible .table_selected").text(theLength)
                $("tbody").find('tr').addClass('selected')
            }else{
                $('#'+formid+' .ids').val("")
                $(".dataTables_info:visible .table_selected").text(0)
                $("tbody").find('tr').removeClass('selected')
            }
            if(checked){
                table[index].rows( ).select();
            }else{
                table[index].rows( ).deselect();
            }
        }

        function handleRowSelect(e,formid,index){
            if($(".selectAllRecords").is(":checked")){
                var p;
                if(table[index].rows('.selected').data().length){
                    if(e.checked){
                        $(e).closest('tr').addClass("selected");
                        var p = parseInt($(".dataTables_info:visible .table_selected").text()) + 1;
                    }else{
                        $(e).closest('tr').removeClass("selected");
                        var p = parseInt($(".dataTables_info:visible .table_selected").text()) - 1;
                    }
                    $(".dataTables_info:visible .table_selected").text(p)
                    var non_selectedCols = []
                    $(e).closest('tbody').find('tr:not(.selected):visible').each(function(e,i){
                        non_selectedCols.push($(this).find('.rowId').text())
                    })
                    $('#'+formid+' .not_ids').val(non_selectedCols)
                }
            }else{
                var p = 0;
                if(e.checked){
                    p = parseInt($(".dataTables_info:visible .table_selected").text()) + 1;
                }else{
                    p = parseInt($(".dataTables_info:visible .table_selected").text()) - 1;
                }
                $(".dataTables_info:visible .table_selected").text(p)
                $(e).closest("tr").toggleClass('selected');
                var data = table[index].rows('.selected').data();
                var selectedCols = []
                $('tr.selected:visible').each(function(e,i){
                    selectedCols.push($(this).find('.rowId').text())
                })
                $("#"+formid+" .ids").val(selectedCols)
                if(data.length == 1){

                }else{
                    $(".btn-addFrom").attr("disabled","disabled");
                }
                if(!$(".selectAllRecords").is(":checked") && (table[index].rows('.selected').data().length)){
                    //$(".dataTables_info:visible .table_selected").text(data.length)
                }
            }
            if($("#"+formid+" .ids").val().includes(",") || !$("#"+formid+" .ids").val()){
                $(".btnAddFrom").attr('disabled',true);
            }else{
                $(".btnAddFrom").removeAttr('disabled');
            }
        }

        function syncNow(deleted){
            var timerInterval;
            if($('.ids').val() == "all"){
                selectedProducts = "{{$pArr}}"
            }else{
                selectedProducts = $('.ids').val()
            }
            Swal.fire({
                title: `{{ Helpers::translate('Syncing is in progress, please wait')}}...`,
                text: `{{ Helpers::translate('this may take  a while, please do not refresh or close the page') }}`,
                timerProgressBar: true,
                allowOutsideClick: false,
                showConfirmButton:false,
                didOpen: () => {
                Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
            });

            $.ajax({
                url:'{{ route('linked-products.price.edit') }}',
                type:'post',
                data:{
                    _token: '{{ csrf_token() }}',
                    price_edits:price_edits,
                    deleted: deleted
                },success:function(data){
                    //
                    var timerInterval;
                    var arr = [];
                    var i = 1;
                    var url = "{{ route('salla.products.sync',['skip'=>20]) }}";
                    var counterLimit = 20;
                    if(selectedProducts.length <= 20){
                        url = "{{ route('salla.products.sync',['skip'=>2]) }}";
                        counterLimit = 2;
                    }
                    if(selectedProducts.length <= 20){
                        url = "{{ route('salla.products.sync',['skip'=>1]) }}";
                        counterLimit = 1;
                    }
                    $.ajax({
                        url:url,
                        data:{
                            ids : arr.toString(),
                            deleted: deleted,
                            ids: $('.ids').val(),
                        },
                        success:function(data){
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{\App\CPU\Helpers::translate('Done')}}",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload()
                        },
                        error:function(data){
                            Swal.fire({
                                position: 'top-end',
                                html:(data.responseText.message) ? data.responseText.message : data.responseText + (arr.toString() ? '('+arr.toString()+')' : ''),
                                type: 'error',
                                title: "{{\App\CPU\Helpers::translate('An error occurred!')}}",
                                showConfirmButton: true,
                            });
                        }
                    })
                    //
                }
            })


        }

        function deleteFromList(event,product_id){
            alert_wait();
            $.ajax({
                url: "{{ route('linked-products.delete') }}?product_id="+product_id,
                success: function(data){
                    location.reload()
                }
            })
        }

        function SyncDeleteFromList(event,product_id){
            alert_wait();
            var arr = [];

            $.ajax({
                url: "{{ route('linked-products.deleted-sync') }}?product_id="+product_id,
                success:function(data){
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "{{\App\CPU\Helpers::translate('Done')}}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload()
                },
                error:function(data){
                    Swal.fire({
                        position: 'top-end',
                        html:(data.responseText.message) ? data.responseText.message : data.responseText + (arr.toString() ? '('+arr.toString()+')' : ''),
                        type: 'error',
                        title: "{{\App\CPU\Helpers::translate('An error occurred!')}}",
                        showConfirmButton: true,
                    });
                }
            })
        }

        function deleteFromLinked(e,productLocalId){
            alert_wait();
            $.ajax({
                url: "{{route('salla.products.delete')}}?id="+productLocalId,
                success:function(data){
                    $(e.target).closest(".products-container").remove();
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "{{\App\CPU\Helpers::translate('Done')}}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload()
                }
            })
        }
    </script>
@endpush

@endsection
