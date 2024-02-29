@extends('layouts.back-end.app')
{{--@section('title','Customer')--}}
@section('title', \App\CPU\Helpers::translate('Details'))

@push('css_or_js')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

            @media screen and (max-width: 720px){
                .dropdown-menu {
                    width: 350px !important;
                }
            }
            .drpit {
                max-width: 490px;
            }
            .dropdown-menu.drpmn {
                max-height: 300px; /* اضبط الارتفاع الأقصى حسب الحاجة */
                overflow-y: auto; /* يسمح بالتمرير العمودي إذا كان المحتوى أطول من الارتفاع */
            }

            .dropdown-item.drpit {
                white-space: normal; /* يسمح بالانتقال لسطر جديد */
            }

            ul.pagination{
                padding: 0px;
            }

            .dataTables_info:nth-child(even){
                right: 0% !important;
            }

            .dataTables_info{
                position: unset;
                width: 100%;
            }

            #DataTables_Table_0_info
            {
                display: none;
            }

            .dtr-title{
                display: block !important;
            }

            .dropdown-menu {
                width: max-content !important;
            }
            .dropdown-menu .active > a, .dropdown-menu .active > a:hover{
                background-image: -webkit-linear-gradient(top, #fff, #fff) !important;
                border-bottom: 1px solid #000;
            }
            .dropdown-menu .active > a, .dropdown-menu .active > a:hover{
                color: #000 !important;
            }
            .drpmn{
                right: 0 !important;
                left: 44px !important;
            }
            .toolbar-icon::after{
                display:none;
              }


        .nav-item{
            margin-{{ session('dir') == 'ltr' ? 'right' : 'left' }}: 20px;
        }
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
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }


        .table th, .table td{
            border: none;
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
            border-bottom: 3px solid {{$web_config['primary_color']}} !important;
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
    </style>
    <style>
        .cu_link{
            width: 117px;
            min-width: 117px;
            height: 87px;
            min-height: 87px;
            padding: 0px;
        }

        .cu_link div{
            border-radius: .3125rem !important;
            display: grid;
            justify-items: center;
            color: black;
            height: 100%;
            padding-top: 7px;
            font-size: 14px;
        }

        .cu_link:not(.active) div{
            border: thin solid black;
        }

        .cu_link.active{
            background-color: #5A409B !important;
        }
        .cu_link.active div{
            filter: invert(1);
            font-weight: bold;
        }

        .store_sidebar{
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .store_sidebar.active{
            background-color: #f5f3ff !important;
        }

        .payment_method_acc .active{
            background-color: #673bb7 !important;
            color: white !important;
        }

        .payment_method_acc a{
            width: 100%;
            display: block;
            padding: 10px;
            color: black;
            background-color: #BABABA;
        }

        .payment_method_acc a i{
            border: black solid thin;
            border-radius: 5px !important;
            padding: 2px;
            float: inline-end;
        }

        .payment_method_acc .active i{
            border: white solid thin;
        }

        .buttons-colvis{
            display: none;
        }
    </style>
    <script>
        var def_img = "data:image/svg+xml,%3Csvg width='160' height='160' viewBox='0 0 160 160' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='0.5' y='0.5' width='159' height='159' rx='7.5' fill='%23F7F4FF' stroke='%235A409B' stroke-dasharray='5 5'/%3E%3Cpath d='M95.6974 45.75H90.5524C89.0299 45.75 87.9099 46.38 87.4024 47.5C87.1224 48.0075 86.9999 48.6025 86.9999 49.3025V54.4475C86.9999 56.67 88.3299 58 90.5524 58H95.6974C96.3974 58 96.9924 57.8775 97.4999 57.5975C98.6199 57.09 99.2499 55.97 99.2499 54.4475V49.3025C99.2499 47.08 97.9199 45.75 95.6974 45.75ZM97.3424 52.6275C97.1674 52.8025 96.9049 52.925 96.6249 52.9425H94.1574V53.835L94.1749 55.375C94.1574 55.6725 94.0524 55.9175 93.8424 56.1275C93.6674 56.3025 93.4049 56.425 93.1249 56.425C92.5474 56.425 92.0749 55.9525 92.0749 55.375V52.925L89.6249 52.9425C89.0474 52.9425 88.5749 52.4525 88.5749 51.875C88.5749 51.2975 89.0474 50.825 89.6249 50.825L91.1649 50.8425H92.0749V48.3925C92.0749 47.815 92.5474 47.325 93.1249 47.325C93.7024 47.325 94.1749 47.815 94.1749 48.3925L94.1574 49.635V50.825H96.6249C97.2024 50.825 97.6749 51.2975 97.6749 51.875C97.6574 52.1725 97.5349 52.4175 97.3424 52.6275Z' fill='%235A409B'/%3E%3Cpath d='M74.75 62.1659C77.0502 62.1659 78.915 60.3012 78.915 58.0009C78.915 55.7007 77.0502 53.8359 74.75 53.8359C72.4497 53.8359 70.585 55.7007 70.585 58.0009C70.585 60.3012 72.4497 62.1659 74.75 62.1659Z' fill='%235A409B'/%3E%3Cpath d='M95.6976 58H94.8751V66.0675L94.6476 65.875C93.2826 64.7025 91.0776 64.7025 89.7126 65.875L82.4326 72.1225C81.0676 73.295 78.8626 73.295 77.4976 72.1225L76.9026 71.6325C75.6601 70.5475 73.6826 70.4425 72.2826 71.3875L65.7376 75.78C65.3526 74.8 65.1251 73.6625 65.1251 72.3325V57.6675C65.1251 52.7325 67.7326 50.125 72.6676 50.125H87.0001V49.3025C87.0001 48.6025 87.1226 48.0075 87.4026 47.5H72.6676C66.2976 47.5 62.5001 51.2975 62.5001 57.6675V72.3325C62.5001 74.24 62.8326 75.9025 63.4801 77.3025C64.9851 80.6275 68.2051 82.5 72.6676 82.5H87.3326C93.7026 82.5 97.5001 78.7025 97.5001 72.3325V57.5975C96.9926 57.8775 96.3976 58 95.6976 58Z' fill='%235A409B'/%3E%3C/svg%3E%0A";
    </script>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-print-none pb-2">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">

                    <!-- Page Title -->
                    <div class="col-lg-6 pt-0 px-0">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        @isset($end_customer)
                                        <a href="{{ route('admin.customer.list', ['end_customer'=>1]) }}">
                                        @else
                                        <a href="{{ route('admin.stores.list') }}">
                                        @endisset
                                            @isset($end_customer)
                                            {{\App\CPU\Helpers::translate('End customer list')}}
                                            @else
                                            {{\App\CPU\Helpers::translate('Customer_list')}}
                                            @endisset
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a>
                                            {{$customer['id'] ? Helpers::translate('edit') : Helpers::translate('Add')}}
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
                    <!-- End Page Title -->

                    <div class="d-sm-flex align-items-sm-center">
                        @if ($customer['is_store'] == "1")
                        <h3 class="page-header-title">{{\App\CPU\Helpers::translate('Customer ID')}} #{{$customer['id']}}</h3>
                        @else
                        <div class="card lg:w-2/5 sm:w-full md:w-full">
                            <div class="card-body border">
                                <strong>
                                    {{ Helpers::translate('End customer informations') }}
                                </strong>
                                <div class="row">
                                    <div class="col-6">
                                        <strong>
                                            {{ Helpers::translate('name') }}
                                        </strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{ $customer->name ?? $customer->first_name . ' ' . $customer->last_name }}
                                    </div>

                                    <div class="col-6">
                                        <strong>
                                            {{ Helpers::translate('orders count') }}
                                        </strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{ $customer->orders->count() }}
                                    </div>

                                    <div class="col-6">
                                        <strong>
                                            {{ Helpers::translate('mobile number') }}
                                        </strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{ $customer->phone }}
                                    </div>

                                    <div class="col-6">
                                        <strong>
                                            {{ Helpers::translate('email') }}
                                        </strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{ $customer->email }}
                                    </div>

                                    <div class="col-6">
                                        <strong>
                                            {{ Helpers::translate('address') }}
                                        </strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{ $customer->street_address }}
                                    </div>

                                    <div class="col-6">
                                        <strong>
                                            {{ Helpers::translate('joined at') }}
                                        </strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{date('Y/m/d h:i a',strtotime($customer['created_at']))}}
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif
                        @if($customer->is_store)
                        <span class="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2 mr-sm-3' : 'ml-2 ml-sm-3'}}">
                            <i class="tio-date-range"></i>
                            {{\App\CPU\Helpers::translate('Joined At')}} : {{date('d-m-Y',strtotime($customer['created_at']))}} , {{\App\CPU\Helpers::translate('the hour')}} : {{date('H:i A',strtotime($customer['created_at']))}}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7" hidden>
                    <div style="display:none" class="d-flex table-actions flex-wrap justify-content-end mx-3">
                        <div class="d-flex">
                        <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.brands-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                            <i class="fa fa-th"></i>
                        </button>
                        <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.brands-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                            <i class="fa fa-table"></i>
                        </button>
                        <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.stores.add-new')}}" disabled>
                            <i class="fa fa-plus"></i>
                        </a>

                        @if(\App\CPU\Helpers::module_permission_check('admin.customers.loginAs') && $customer['id'])
                        <a title="{{\App\CPU\Helpers::translate('Login as')}}"
                            class="btn btn-info my-2 btn-icon-text m-2"
                            target="_blank" style="background-color:#fdcd05;border-color:#fdcd05" target="_blank"
                            href="{{route('admin.stores.loginAs',['id'=>$customer['id']])}}">

                                <i class="fas fa-door-open" style='font-size:20px;color:black'></i>

                        </a>
                        @endif

                        <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('brands')">
                            <i class="fa fa-clone"></i>
                        </button>


                        @if($customer->is_store)
                        <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
                        onclick="$('.btn-save').click()">
                            <i class="fa fa-save"></i>
                        </button>
                        @endif

                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                        onclick="form_alert('bulk-delete','Want to delete this item ?')"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                        <form hidden action="{{route('admin.stores.add-new')}}" method="post" id="bulk-delete">
                            @csrf
                            <input type="text" name="ids" class="ids" value="{{$customer['id']}}">
                            <input type="text" name="back" value="1">
                        </form>
                        <button disabled class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                            <i class="fa fa-toggle"></i>
                        </button>
                        </div>
                        <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                            <div class="dropdown dropdown">
                                <button disabled aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:47px">
                                    <i class="ti-bag"></i>
                                </button>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu">
                                    <a class="dropdown-item" href="#"
                                    onclick="form_alert('bulk-enable','Are you sure ?')"
                                    >
                                        <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                                    </a>
                                    <a class="dropdown-item" href="#"
                                    onclick="form_alert('bulk-disable','Are you sure ?')"
                                    >
                                        <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="stateClear()">
                                        <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                                    </a>
                                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                    onclick='$(".dt-button-collection").remove();'>
                                        <i class="ti-angle-down"></i>
                                        {{\App\CPU\Helpers::translate('Import/Export')}}
                                    </a>
                                    <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                        <a class="dropdown-item bulk-export" href="{{route('admin.stores.add-new')}}">
                                            {{\App\CPU\Helpers::translate('export to excel')}}
                                        </a>
                                        <a class="dropdown-item bulk-import" href="{{route('admin.stores.add-new')}}">
                                            {{\App\CPU\Helpers::translate('import from excel')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($previousStore)
                        <a title="{{Helpers::translate('Previous')}}" class="btn btn-info my-2 btn-icon-text m-2 ml-2" href="{{route('admin.customer.view',[$previousStore['id']])}}" style="background-color:#fdcd05;border-color:#fdcd05">
                            <i class="far fa-arrow-alt-circle-right text-black text-lg"></i>
                        </a>
                        @endif
                        @if($nextStore)
                            <a title="{{Helpers::translate('Next')}}" class="btn btn-info my-2 btn-icon-text m-2 ml-2" href="{{route('admin.customer.view',[$nextStore['id']])}}" style="background-color:#fdcd05;border-color:#fdcd05">
                                <i class="far fa-arrow-alt-circle-left  text-black text-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Modal -->
    <div class="modal fade" id="publishNoteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">{{ \App\CPU\Helpers::translate('Add a new support ticket') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-group" action="{{route('admin.customer.add-ticket-customer')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">{{\App\CPU\Helpers::translate('Ticket title')}}</label>
                                <input type="text" class="form-control" id="ticket-subject" name="ticket_subject"
                                    required>
                            </div>
                        <div class="form-group col-md-6">
                            <div class="">
                                <label class="" for="inlineFormCustomSelect">{{\App\CPU\Helpers::translate('Type')}}</label>
                                <select class="custom-select " id="ticket-type" name="ticket_type" required>
                                    <option
                                        value="Website problem">{{\App\CPU\Helpers::translate('problem in website or app')}}</option>
                                    <option value="Partner request">{{\App\CPU\Helpers::translate('partner_request')}}</option>
                                    <option value="Complaint">{{\App\CPU\Helpers::translate('Complaint')}}</option>
                                    <option
                                    value="Info inquiry">{{\App\CPU\Helpers::translate('inquiry')}} </option>
                                    <option value="Complaint">{{\App\CPU\Helpers::translate('Help on request')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}"/>
                        <div class="dropdown drpd" style="top: 5.4rem;right: 0.4rem;">
                            <i class="toolbar-icon fas fa-file dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                            <div class="dropdown-menu drpmn" aria-labelledby="dropdownMenuButton">
                                <input type="search" class="form-control dropdown-search" placeholder="ابحث...">
                                <div class="dropdown-items">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach ($categories ?? [] as $index => $category)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-toggle="tab" href="#category{{ $category->id }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        @foreach ($categories ?? [] as $index => $category)
                                            <div id="category{{ $category->id }}" class="container px-0 pt-1 tab-pane {{ $index == 0 ? 'active' : '' }}">
                                                @foreach ($category->quickResponses as $wordIndex => $word)
                                                    <a class="dropdown-item drpit px-3 text-right" href="#" data-value="{{ $word->name }}">{{ $wordIndex + 1 }}. {{ $word->name }}</a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                        </div>
                        <textarea class="form-control" name="massege" rows="3"></textarea>
                        <input type="hidden" name="id" value="{{ $customer->id }}" class="ids">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="attachments">{{\App\CPU\Helpers::translate('Attachments')}}</label>
                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple accept=".jpg, .jpeg, .png, .pdf, .xls, .docx, .mp4">
                                <small>{{\App\CPU\Helpers::translate('Allowed Types: jpg, jpeg, png, pdf, xls, docx, mp4')}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{\App\CPU\Helpers::translate('Close')}}
                        </button>
                        <button type="submit" class="btn bg-primaryColor btn-primary bg-primaryColor">{{\App\CPU\Helpers::translate('submit_a_ticket')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        @if($customer->is_store)
        <div class="col-md-12 px-0 mb-3" style="display: flex;justify-content: center;">
            <ul class="nav nav-tabs w-fit-content mb-0 px-0">
                <li class="nav-item text-capitalize">
                    <div class="cu_link btn active" href="#" id="account-link" onmouseup="$('.save-btn').removeAttr('disabled')">
                        <div>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.3596 8.27L22.0696 5.5C21.6496 2.48 20.2796 1.25 17.3497 1.25H14.9896H13.5097H10.4697H8.98965H6.58965C3.64965 1.25 2.28965 2.48 1.85965 5.53L1.58965 8.28C1.48965 9.35 1.77965 10.39 2.40965 11.2C3.16965 12.19 4.33965 12.75 5.63965 12.75C6.89965 12.75 8.10965 12.12 8.86965 11.11C9.54965 12.12 10.7097 12.75 11.9997 12.75C13.2896 12.75 14.4197 12.15 15.1096 11.15C15.8797 12.14 17.0696 12.75 18.3096 12.75C19.6396 12.75 20.8396 12.16 21.5896 11.12C22.1896 10.32 22.4597 9.31 22.3596 8.27Z" fill="#000000"/>
                                <path d="M11.3511 16.6602C10.0811 16.7902 9.12109 17.8702 9.12109 19.1502V21.8902C9.12109 22.1602 9.34109 22.3802 9.61109 22.3802H14.3811C14.6511 22.3802 14.8711 22.1602 14.8711 21.8902V19.5002C14.8811 17.4102 13.6511 16.4202 11.3511 16.6602Z" fill="#000000"/>
                                <path d="M21.3689 14.4001V17.3801C21.3689 20.1401 19.1289 22.3801 16.3689 22.3801C16.0989 22.3801 15.8789 22.1601 15.8789 21.8901V19.5001C15.8789 18.2201 15.4889 17.2201 14.7289 16.5401C14.0589 15.9301 13.1489 15.6301 12.0189 15.6301C11.7689 15.6301 11.5189 15.6401 11.2489 15.6701C9.46891 15.8501 8.11891 17.3501 8.11891 19.1501V21.8901C8.11891 22.1601 7.89891 22.3801 7.62891 22.3801C4.86891 22.3801 2.62891 20.1401 2.62891 17.3801V14.4201C2.62891 13.7201 3.31891 13.2501 3.96891 13.4801C4.23891 13.5701 4.50891 13.6401 4.78891 13.6801C4.90891 13.7001 5.03891 13.7201 5.15891 13.7201C5.31891 13.7401 5.47891 13.7501 5.63891 13.7501C6.79891 13.7501 7.93891 13.3201 8.83891 12.5801C9.69891 13.3201 10.8189 13.7501 11.9989 13.7501C13.1889 13.7501 14.2889 13.3401 15.1489 12.6001C16.0489 13.3301 17.1689 13.7501 18.3089 13.7501C18.4889 13.7501 18.6689 13.7401 18.8389 13.7201C18.9589 13.7101 19.0689 13.7001 19.1789 13.6801C19.4889 13.6401 19.7689 13.5501 20.0489 13.4601C20.6989 13.2401 21.3689 13.7201 21.3689 14.4001Z" fill="#000000"/>
                            </svg>
                            {{\App\CPU\Helpers::translate('main store informations')}}
                        </div>
                    </div>
                </li>
                <li class="nav-item text-capitalize">
                    <div class="cu_link btn" href="#" id="orders-link" onmouseup="$('.save-btn').removeAttr('disabled')">
                        <div>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.24 5.57957H18.84L15.46 2.19957C15.19 1.92957 14.75 1.92957 14.47 2.19957C14.2 2.46957 14.2 2.90957 14.47 3.18957L16.86 5.57957H7.14L9.53 3.18957C9.8 2.91957 9.8 2.47957 9.53 2.19957C9.26 1.92957 8.82 1.92957 8.54 2.19957L5.17 5.57957H4.77C3.87 5.57957 2 5.57957 2 8.13957C2 9.10957 2.2 9.74957 2.62 10.1696C2.86 10.4196 3.15 10.5496 3.46 10.6196C3.75 10.6896 4.06 10.6996 4.36 10.6996H19.64C19.95 10.6996 20.24 10.6796 20.52 10.6196C21.36 10.4196 22 9.81957 22 8.13957C22 5.57957 20.13 5.57957 19.24 5.57957Z" fill="#000000"/>
                                <path d="M19.0506 12H4.87064C4.25064 12 3.78064 12.55 3.88064 13.16L4.72064 18.3C5.00064 20.02 5.75064 22 9.08064 22H14.6906C18.0606 22 18.6606 20.31 19.0206 18.42L20.0306 13.19C20.1506 12.57 19.6806 12 19.0506 12ZM12.0006 19.5C9.66064 19.5 7.75064 17.59 7.75064 15.25C7.75064 14.84 8.09064 14.5 8.50064 14.5C8.91064 14.5 9.25064 14.84 9.25064 15.25C9.25064 16.77 10.4806 18 12.0006 18C13.5206 18 14.7506 16.77 14.7506 15.25C14.7506 14.84 15.0906 14.5 15.5006 14.5C15.9106 14.5 16.2506 14.84 16.2506 15.25C16.2506 17.59 14.3406 19.5 12.0006 19.5Z" fill="#000000"/>
                            </svg>
                            {{\App\CPU\Helpers::translate('Online store requests')}}
                        </div>
                    </div>
                </li>
                <li class="nav-item text-capitalize">
                    <div class="cu_link btn" href="#" id="subscription-link" onmouseup="$('.save-btn').removeAttr('disabled')">
                        <div>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8C20.6569 8 22 6.65685 22 5C22 3.34315 20.6569 2 19 2C17.3431 2 16 3.34315 16 5C16 6.65685 17.3431 8 19 8Z" fill="#000000"/>
                                <path d="M19.8 9.42C19.78 9.42 19.76 9.43 19.74 9.43C19.64 9.45 19.54 9.46 19.43 9.48C19.01 9.52 18.56 9.5 18.1 9.41C17.98 9.38 17.88 9.36 17.77 9.32C17.44 9.24 17.13 9.11 16.84 8.94C16.72 8.88 16.6 8.8 16.49 8.73C16.01 8.4 15.6 7.99 15.27 7.51C15.2 7.4 15.12 7.28 15.06 7.16C14.89 6.87 14.76 6.56 14.68 6.23C14.64 6.12 14.62 6.02 14.59 5.9C14.5 5.44 14.48 4.99 14.52 4.57C14.54 4.46 14.55 4.36 14.57 4.26C14.57 4.24 14.58 4.22 14.58 4.2C14.7 3.58 14.24 3 13.6 3H7.52C7.38 3 7.24 3.01 7.11 3.02C6.99 3.03 6.88 3.04 6.76 3.06C6.64 3.07 6.52 3.09 6.41 3.11C4 3.46 2.46 4.99 2.11 7.41C2.09 7.52 2.07 7.64 2.06 7.76C2.04 7.88 2.03 7.99 2.02 8.11C2.01 8.24 2 8.38 2 8.52V16.48C2 16.62 2.01 16.76 2.02 16.89C2.03 17.01 2.04 17.12 2.06 17.24C2.07 17.36 2.09 17.48 2.11 17.59C2.46 20.01 4 21.54 6.41 21.89C6.52 21.91 6.64 21.93 6.76 21.94C6.88 21.96 6.99 21.97 7.11 21.98C7.24 21.99 7.38 22 7.52 22H15.48C15.62 22 15.76 21.99 15.89 21.98C16.01 21.97 16.12 21.96 16.24 21.94C16.36 21.93 16.48 21.91 16.59 21.89C19 21.54 20.54 20.01 20.89 17.59C20.91 17.48 20.93 17.36 20.94 17.24C20.96 17.12 20.97 17.01 20.98 16.89C20.99 16.76 21 16.62 21 16.48V10.4C21 9.76 20.42 9.3 19.8 9.42ZM6.75 12.5H11.75C12.16 12.5 12.5 12.84 12.5 13.25C12.5 13.66 12.16 14 11.75 14H6.75C6.34 14 6 13.66 6 13.25C6 12.84 6.34 12.5 6.75 12.5ZM15.75 18H6.75C6.34 18 6 17.66 6 17.25C6 16.84 6.34 16.5 6.75 16.5H15.75C16.16 16.5 16.5 16.84 16.5 17.25C16.5 17.66 16.16 18 15.75 18Z" fill="#000000"/>
                            </svg>
                            {{\App\CPU\Helpers::translate('Online store subscriptions')}}
                        </div>
                    </div>
                </li>
                @isset($customer['id'])
                <li class="nav-item text-capitalize">
                    <div class="cu_link btn" href="#" id="paymentmethods-link" onmouseup="$('.save-btn').attr('disabled','disabled')">
                        <div>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9392 2.20983L9.52922 7.81983H7.11922C6.71922 7.81983 6.32922 7.84983 5.94922 7.92983L6.94922 5.52983L6.98922 5.43983L7.04922 5.27983C7.07922 5.20983 7.09922 5.14983 7.12922 5.09983C8.28922 2.40983 9.58922 1.56983 11.9392 2.20983Z" fill="#000000"/>
                                <path d="M18.7311 8.08953L18.7111 8.07953C18.1111 7.90953 17.5011 7.81953 16.8811 7.81953H10.6211L12.8711 2.58953L12.9011 2.51953C13.0411 2.56953 13.1911 2.63953 13.3411 2.68953L15.5511 3.61953C16.7811 4.12953 17.6411 4.65953 18.1711 5.29953C18.2611 5.41953 18.3411 5.52953 18.4211 5.65953C18.5111 5.79953 18.5811 5.93953 18.6211 6.08953C18.6611 6.17953 18.6911 6.25953 18.7111 6.34953C18.8611 6.85953 18.8711 7.43953 18.7311 8.08953Z" fill="#000000"/>
                                <path d="M12.5195 17.6601H12.7695C13.0695 17.6601 13.3195 17.3901 13.3195 17.0601C13.3195 16.6401 13.1995 16.5801 12.9395 16.4801L12.5195 16.3301V17.6601Z" fill="#000000"/>
                                <path d="M18.2883 9.52031C17.8383 9.39031 17.3683 9.32031 16.8783 9.32031H7.11828C6.43828 9.32031 5.79828 9.45031 5.19828 9.71031C3.45828 10.4603 2.23828 12.1903 2.23828 14.2003V16.1503C2.23828 16.3903 2.25828 16.6203 2.28828 16.8603C2.50828 20.0403 4.20828 21.7403 7.38828 21.9503C7.61828 21.9803 7.84828 22.0003 8.09828 22.0003H15.8983C19.5983 22.0003 21.5483 20.2403 21.7383 16.7403C21.7483 16.5503 21.7583 16.3503 21.7583 16.1503V14.2003C21.7583 11.9903 20.2883 10.1303 18.2883 9.52031ZM13.2783 15.5003C13.7383 15.6603 14.3583 16.0003 14.3583 17.0603C14.3583 17.9703 13.6483 18.7003 12.7683 18.7003H12.5183V18.9203C12.5183 19.2103 12.2883 19.4403 11.9983 19.4403C11.7083 19.4403 11.4783 19.2103 11.4783 18.9203V18.7003H11.3883C10.4283 18.7003 9.63828 17.8903 9.63828 16.8903C9.63828 16.6003 9.86828 16.3703 10.1583 16.3703C10.4483 16.3703 10.6783 16.6003 10.6783 16.8903C10.6783 17.3103 10.9983 17.6603 11.3883 17.6603H11.4783V15.9703L10.7183 15.7003C10.2583 15.5403 9.63828 15.2003 9.63828 14.1403C9.63828 13.2303 10.3483 12.5003 11.2283 12.5003H11.4783V12.2803C11.4783 11.9903 11.7083 11.7603 11.9983 11.7603C12.2883 11.7603 12.5183 11.9903 12.5183 12.2803V12.5003H12.6083C13.5683 12.5003 14.3583 13.3103 14.3583 14.3103C14.3583 14.6003 14.1283 14.8303 13.8383 14.8303C13.5483 14.8303 13.3183 14.6003 13.3183 14.3103C13.3183 13.8903 12.9983 13.5403 12.6083 13.5403H12.5183V15.2303L13.2783 15.5003Z" fill="#000000"/>
                                <path d="M10.6797 14.14C10.6797 14.56 10.7997 14.62 11.0597 14.72L11.4797 14.87V13.54H11.2297C10.9197 13.54 10.6797 13.81 10.6797 14.14Z" fill="#000000"/>
                            </svg>
                            {{\App\CPU\Helpers::translate('Payment methods available for this store')}}
                        </div>
                    </div>
                </li>
                @endisset
                <li class="nav-item text-capitalize">
                    <div class="cu_link btn" href="#" id="products-link" onmouseup="$('.save-btn').removeAttr('disabled')">
                        <div>
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M26.947 10.4266L16.6803 16.3733C16.267 16.6133 15.747 16.6133 15.3203 16.3733L5.05362 10.4266C4.32029 9.99992 4.13362 8.99992 4.69362 8.37326C5.08029 7.93326 5.52029 7.57325 5.98695 7.31992L13.2136 3.31992C14.7603 2.45326 17.267 2.45326 18.8136 3.31992L26.0403 7.31992C26.507 7.57325 26.947 7.94659 27.3336 8.37326C27.867 8.99992 27.6803 9.99992 26.947 10.4266Z" fill="#000000"/>
                                <path d="M15.2393 18.8535V27.9468C15.2393 28.9602 14.2127 29.6268 13.306 29.1868C10.5593 27.8402 5.93266 25.3202 5.93266 25.3202C4.30599 24.4002 2.97266 22.0802 2.97266 20.1735V13.2935C2.97266 12.2402 4.07932 11.5735 4.98599 12.0935L14.5727 17.6535C14.9727 17.9068 15.2393 18.3602 15.2393 18.8535Z" fill="#000000"/>
                                <path d="M16.7617 18.8535V27.9468C16.7617 28.9602 17.7884 29.6268 18.6951 29.1868C21.4417 27.8402 26.0684 25.3202 26.0684 25.3202C27.6951 24.4002 29.0284 22.0802 29.0284 20.1735V13.2935C29.0284 12.2402 27.9217 11.5735 27.0151 12.0935L17.4284 17.6535C17.0284 17.9068 16.7617 18.3602 16.7617 18.8535Z" fill="#000000"/>
                            </svg>
                            {{\App\CPU\Helpers::translate('Concurrent products')}}
                        </div>
                    </div>
                </li>
                <li class="nav-item text-capitalize">
                    <div class="cu_link btn" href="#" id="tickets-link" onmouseup="$('.save-btn').removeAttr('disabled')">
                        <div>
                            <svg width="27" height="27" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path  fill="#000000" d="M21.3333 2.66675H10.6667C5.33332 2.66675 2.66666 5.33341 2.66666 10.6667V28.0001C2.66666 28.7334 3.26666 29.3334 3.99999 29.3334H21.3333C26.6667 29.3334 29.3333 26.6667 29.3333 21.3334V10.6667C29.3333 5.33341 26.6667 2.66675 21.3333 2.66675ZM18.6667 20.3334H9.33332C8.78666 20.3334 8.33332 19.8801 8.33332 19.3334C8.33332 18.7867 8.78666 18.3334 9.33332 18.3334H18.6667C19.2133 18.3334 19.6667 18.7867 19.6667 19.3334C19.6667 19.8801 19.2133 20.3334 18.6667 20.3334ZM22.6667 13.6667H9.33332C8.78666 13.6667 8.33332 13.2134 8.33332 12.6667C8.33332 12.1201 8.78666 11.6667 9.33332 11.6667H22.6667C23.2133 11.6667 23.6667 12.1201 23.6667 12.6667C23.6667 13.2134 23.2133 13.6667 22.6667 13.6667Z" fill="white"/>
                            </svg>
                            {{\App\CPU\Helpers::translate('Support tickets')}}
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        @endif

        @if(isset($customer['id']) && $customer->is_store)
        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="paymentmethods-tab" style="place-content: center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="row gy-3">



                    <div class="col-md-12" id="myTabContent">
                        <ul class="nav nav-tabs mb-3 d-block" id="myTab" role="tablist" content="cash_on_delivery_tab" style="place-content: center">
                            <li class="py-2 px-0 nav-item payment_method_acc mb-3 mx-0" role="presentation">
                                <a class="" id="cash_on_delivery" data-bs-toggle="tab" role="button"
                                    aria-controls="cash_on_delivery" aria-selected="true">{{ Helpers::translate('cash_on_delivery') }}
                                    <i class="fa fa-angle-down"></i>
                                    <i class="fa fa-angle-up" style="display: none"></i>
                                </a>
                            </li>
                            <div class="tab-pane mt-2" role="tabpanel" style="display: none" aria-labelledby="cash_on_delivery">
                                <div class="col-md-12">
                                    <div class="card h-100">
                                        <div class="card-body p-0">
                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'cash_on_delivery'))
                                            <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'cash_on_delivery'])}}" style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};" method="post">
                                                <div class="d-flex flex-wrap gap-10">
                                                    @csrf
                                                    @if(isset($config))
                                                    <div class="d-flex flex-wrap gap-5">
                                                        <div class="mb-3 d-flex gap-10 align-items-center mb-2">
                                                            <label class="dd-block font-weight-bold title-color pt-2">
                                                                {{\App\CPU\Helpers::translate('cash_on_delivery')}} ({{ Helpers::translate('for buying') }})
                                                            </label>
                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox" name="status" value="1" @if(($config['status'] ?? null)==1) checked @endif />
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'cash_on_delivery_sub'))
                                                    <div class="d-flex flex-wrap gap-5">
                                                        <div class="mb-3 d-flex gap-10 align-items-center mb-2">
                                                            <label class="dd-block font-weight-bold title-color pt-2">
                                                                {{\App\CPU\Helpers::translate('cash_on_delivery')}} ({{ Helpers::translate('for subscription') }})
                                                            </label>
                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox" name="subs_status" value="1" @if(($config['subs_status'] ?? null)==1) checked @endif>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 d-flex flex-wrap justify-content-start gap-10">
                                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                    @else
                                                        <button type="submit"
                                                                class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <li class="py-2 px-0 nav-item payment_method_acc mb-3 mx-0" role="presentation">
                                <a class=" " id="delayed" data-bs-toggle="tab" role="button"
                                    aria-controls="delayed" aria-selected="true">{{ Helpers::translate('delayed') }}
                                    <i class="fa fa-angle-down"></i>
                                    <i class="fa fa-angle-up" style="display: none"></i>
                                </a>
                            </li>
                            <div class="tab-pane mt-2" role="tabpanel" style="display: none" aria-labelledby="delayed">
                                <div class="col-md-12">
                                    <div class="card h-100">
                                        <div class="card-body p-0">
                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'delayed'))
                                            <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'delayed']):'javascript:'}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                @php($config['environment'] = $config['environment']??'sandbox')
                                                <div class="mt-3 d-flex flex-wrap justify-content-start gap-10">
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('delayed')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                    name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('delayed')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                    name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="mb-3 d-flex flex-wrap justify-content-start gap-10">
                                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                    @else
                                                        <button type="submit"
                                                                class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <li class="py-2 px-0 nav-item payment_method_acc mb-3 mx-0" role="presentation">
                                <a class=" " id="bank_transfer" data-bs-toggle="tab" role="button"
                                    aria-controls="bank_transfer" aria-selected="true">{{ Helpers::translate('bank_transfer') }}
                                    <i class="fa fa-angle-down"></i>
                                    <i class="fa fa-angle-up" style="display: none"></i>
                                </a>
                            </li>
                            <div class="tab-pane mt-2" role="tabpanel" style="display: none" aria-labelledby="bank_transfer">
                                <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'bank_transfer']):'javascript:'}}"
                                method="post" class="row gy-3">
                                @csrf
                                    @php($config['environment'] = $config['environment']??'sandbox')
                                    @php($item_index = 0)
                                    @php($banks=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'bank_transfer'))
                                    @foreach ($banks ?? [] as $config)
                                        <div class="col-md-12">
                                            <div class="card h-100">
                                                <div class="card-body p-0">
                                                    <div class="bt-container">
                                                        <div class="w-full text-start">
                                                            <div class="btn btn-danger" onclick="$(this).closest('.bt-container').remove()">
                                                                <i class="fa fa-close"></i>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-10 mt-3">
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="bank_transfer[{{$item_index}}][status]" value="1" {{(($config['status'] ?? null) ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="bank_transfer[{{$item_index}}][subs_status]" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>
                                                        </div>


                                                        <div class="d-flex flex-wrap gap-10 w-full">
                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('name')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][name]"
                                                                    value="{{$config['name'] ?? ''}}">
                                                            </div>


                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account owner name')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][owner_name]"
                                                                    value="{{$config['owner_name'] ?? ''}}">
                                                            </div>

                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account number')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][account_number]"
                                                                    value="{{$config['account_number'] ?? ''}}">
                                                            </div>

                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('IBAN number')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][iban]"
                                                                    value="{{$config['iban'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="mt-3 d-flex flex-wrap justify-content-start gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                @if(!$banks) style="display: none" @endif
                                                                class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase save_bank_transfer">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @php($item_index++)
                                    @endforeach
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="w-full text-center">
                                                    <div role="button" class="btn btn-success add_new_bank" onclick="$('.new_bank_transfer').show();$(this).hide()">
                                                        {{ Helpers::translate('add new') }}
                                                    </div>
                                                </div>
                                                <div style="display: none" class="new_bank_transfer">
                                                    <div class="bt-container">
                                                        <div class="w-full text-start">
                                                            <div class="btn btn-danger" onclick="$(this).closest('.new_bank_transfer').hide();$('.add_new_bank').show()">
                                                                <i class="fa fa-close"></i>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3 mt-3">
                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}}</h5>

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                value="1" name="bank_transfer[{{$item_index}}][status]" />
                                                                <span class="switcher_control"></span>
                                                            </label>

                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}} ({{ Helpers::translate('for subscription') }})</h5>
                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                value="1" name="bank_transfer[{{$item_index}}][subs_status]" />
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-10 w-full">
                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Name')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][name]" />
                                                            </div>

                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account owner name')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][owner_name]" />
                                                            </div>

                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account number')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][account_number]" />
                                                            </div>

                                                            <div class="form-group d-block w-1/5">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('IBAN number')}}</label>
                                                                <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][iban]" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-start gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                @if(!$banks) style="display: none" @endif
                                                                class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase save_bank_transfer">{{\App\CPU\Helpers::translate('add')}}</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <li class="py-2 px-0 nav-item payment_method_acc mb-3 mx-0" role="presentation">
                                <a class=" " id="customer_wallet" data-bs-toggle="tab" role="button"
                                    aria-controls="customer_wallet" aria-selected="true">{{ Helpers::translate('customer_wallet') }}
                                    <i class="fa fa-angle-down"></i>
                                    <i class="fa fa-angle-up" style="display: none"></i>
                                </a>
                            </li>
                            <div class="tab-pane mt-2" role="tabpanel" style="display: none" aria-labelledby="customer_wallet">
                                <form action="{{ route('admin.customer.payment-method.update',[$customer['id'],'customer_wallet']) }}" method="post"
                                enctype="multipart/form-data" id="update-settings">
                                    <input type="hidden" name="payments_page" value="1">
                                    @csrf
                                    <div class="w-fit-content">
                                        <div class="d-flex gap-10">
                                            <div class="lg:w-1/2 md:w-full border">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center gap-10 form-control border-0 mt-0">
                                                            <span class="title-color">
                                                                {{\App\CPU\Helpers::translate('customer_wallet_settings')}} ({{ Helpers::translate('for buying') }})
                                                            </span>

                                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'customer_wallet'))

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                {{isset($config['wallet_status'])&&$config['wallet_status']==1?'checked':''}}
                                                                value="1" name="wallet_status" />
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center gap-10 form-control border-0 mt-4" id="customer_wallet_section">
                                                            <span class="title-color">{{\App\CPU\Helpers::translate('refund_to_wallet')}}</span>

                                                            <label class="switcher" for="refund_to_wallet">
                                                                <input type="checkbox" class="switcher_input" name="refund_to_wallet"
                                                                    id="refund_to_wallet"
                                                                    value="1" {{isset($config['refund_to_wallet'])&&$config['refund_to_wallet']==1?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                        <div class="d-flex justify-content-start mt-3 w-full">
                                                            <button class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="lg:w-1/2 md:w-full border">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center gap-10 form-control border-0 mt-0">
                                                            <span class="title-color">
                                                                {{\App\CPU\Helpers::translate('customer_wallet_settings')}} ({{ Helpers::translate('for subscription') }}):
                                                            </span>

                                                            <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                            {{isset($config['wallet_subs_status'])&&$config['wallet_subs_status']==1?'checked':''}}
                                                            value="1" name="wallet_subs_status" />
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                        </div>

                                                        <div class="d-flex justify-content-between align-items-center gap-10 form-control border-0 mt-4" id="customer_subs_wallet_section">
                                                            <span class="title-color">{{\App\CPU\Helpers::translate('refund_to_wallet')}}</span>

                                                            <label class="switcher" for="refund_to_wallet_subs">
                                                                <input type="checkbox" class="switcher_input" name="refund_to_wallet_subs"
                                                                    id="refund_to_wallet_subs"
                                                                    value="1" {{isset($config['refund_to_wallet_subs'])&&$config['refund_to_wallet_subs']==1?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                        <div class="d-flex justify-content-start w-full mt-3">
                                                            <button class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <li class="py-2 px-0 nav-item payment_method_acc mb-3 mx-0" role="presentation">
                                <a class="" id="digital_payments" data-bs-toggle="tab" role="button"
                                    aria-controls="digital_payments" aria-selected="false">
                                    {{ Helpers::translate('digital payment methods') }}
                                    <i class="fa fa-angle-down"></i>
                                    <i class="fa fa-angle-up" style="display: none"></i>
                                </a>
                            </li>
                            <div class="tab-pane mt-2" role="tabpanel" style="display: none" aria-labelledby="digital_payments">
                                <div class="row gy-3">
                                    <div class="col-md-12">
                                        <div class="card h-100">
                                            <div class="card-body border">
                                                @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'digital_payment'))
                                                <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'digital_payment'])}}"
                                                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                                                    method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                        <div class="d-flex flex-wrap gap-10">
                                                            <label
                                                                class="title-color font-weight-bold d-block mb-3">{{\App\CPU\Helpers::translate('digital_payment')}} ({{ Helpers::translate('for buying') }})</label>
                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox" name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}} />
                                                                <span class="switcher_control"></span>
                                                            </label>

                                                            <label
                                                                class="title-color font-weight-bold d-block mb-3">{{\App\CPU\Helpers::translate('digital_payment')}} ({{ Helpers::translate('for subscription') }})</label>
                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox" name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}} />
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>
                                                        <div class="mt-3 d-flex flex-wrap justify-content-start gap-10">
                                                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                    class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-50">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                            @else
                                                                <button type="submit"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-50">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                            @endif
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @if ((Helpers::get_user_paymment_methods($customer['id'],'digital_payment')['status'] ?? 0) == 1)
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'ssl_commerz_payment'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'ssl_commerz_payment'])}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="mb-3">
                                                                <img src="{{asset('/public/assets/back-end/img/ssl-commerz.png')}}" alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('SSLCOMMERZ')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('SSLCOMMERZ')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>



                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option
                                                                        value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                                    <option
                                                                        value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('Store ID')}} </label>
                                                                <input type="text" class="form-control" name="store_id"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['store_id']}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('Store password')}}</label>
                                                                <input type="text" class="form-control" name="store_password"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['store_password']}}">
                                                            </div>

                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paypal'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'paypal'])}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="mb-3">
                                                                <img src="{{asset('/public/assets/back-end/img/paypal.png')}}" alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Paypal')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Paypal')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                                <select class="js-example-responsive form-control w-full"
                                                                        name="environment">

                                                                    <option
                                                                        value="sandbox" {{isset($config['environment'])==true?$config['environment']=='sandbox'?'selected':'':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                                    <option
                                                                        value="live" {{isset($config['environment'])==true?$config['environment']=='live'?'selected':'':''}}>{{\App\CPU\Helpers::translate('live')}}</option>

                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="title-color d-flex">{{\App\CPU\Helpers::translate('Paypal Client')}}{{\App\CPU\Helpers::translate('ID')}}</label>
                                                                <input type="text" class="form-control" name="paypal_client_id"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['paypal_client_id']}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="title-color d-flex">{{\App\CPU\Helpers::translate('Paypal Secret')}} </label>
                                                                <input type="text" class="form-control" name="paypal_secret"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['paypal_secret']}}">
                                                            </div>
                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'stripe'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'stripe'])}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img src="{{asset('/public/assets/back-end/img/stripe.png')}}" alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Stripe')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Stripe')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>


                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option
                                                                        value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                                    <option
                                                                        value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('published_key')}}</label>
                                                                <input type="text" class="form-control" name="published_key"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['published_key']}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                                <input type="text" class="form-control" name="api_key"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['api_key']}}">
                                                            </div>
                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'razor_pay'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'razor_pay'])}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img src="{{asset('/public/assets/back-end/img/razorpay.png')}}" alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('razor_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('razor_pay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>


                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option
                                                                        value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                                    <option
                                                                        value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Key')}}  </label>
                                                                <input type="text" class="form-control" name="razor_key"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['razor_key']}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('secret')}}</label>
                                                                <input type="text" class="form-control" name="razor_secret"
                                                                    value="{{env('APP_MODE')=='demo'?'':$config['razor_secret']}}">
                                                            </div>
                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'senang_pay'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'senang_pay']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/senangpay.png')}}"
                                                                    alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('senang_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('senang_pay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>


                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option
                                                                        value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                                    <option
                                                                        value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>
                                                                <div
                                                                    class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                                                    <span class="form-ellipsis {{ (Session::get('direction') ?? 'rtl') === 'rtl' ? 'text-right' : 'text-left' }}"
                                                                        id="id_senang_pay">{{ url('/') }}/return-senang-pay</span>
                                                                    <span class="btn bg-primaryColor btn-primary text-nowrap btn-xs"
                                                                        onclick="copyToClipboard('#id_senang_pay')">
                                                                    <i class="tio-copy"></i>
                                                                    {{\App\CPU\Helpers::translate('Copy URI')}}
                                                                </span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('secret key')}}</label>
                                                                <input type="text" class="form-control" name="secret_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('Merchant ID')}}</label>
                                                                <input type="text" class="form-control" name="merchant_id"
                                                                    value="{{env('APP_MODE')!='demo'?$config['merchant_id']:''}}">
                                                            </div>
                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paytabs'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paytabs']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/paytabs.png')}}" alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytabs')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytabs')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>



                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option
                                                                        value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                                    <option
                                                                        value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('profile_id')}}</label>
                                                                <input type="text" class="form-control" name="profile_id"
                                                                    value="{{env('APP_MODE')!='demo'?$config['profile_id']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('server_key')}}</label>
                                                                <input type="text" class="form-control" name="server_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['server_key']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('base_url_by_region')}}</label>
                                                                <input type="text" class="form-control" name="base_url"
                                                                    value="{{env('APP_MODE')!='demo'?$config['base_url']:''}}">
                                                            </div>


                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paystack'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paystack']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/paystack.png')}}" alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paystack')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paystack')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>



                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>

                                                                <div
                                                                    class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                                                    <span class="form-ellipsis {{ (Session::get('direction') ?? 'rtl') === 'rtl' ? 'text-right' : 'text-left' }}"
                                                                        id="id_paystack">{{ url('/') }}/paystack-callback</span>
                                                                    <span class="btn bg-primaryColor btn-primary text-nowrap btn-xs"
                                                                        onclick="copyToClipboard('#id_paystack')"><i
                                                                            class="tio-copy"></i> {{\App\CPU\Helpers::translate('Copy URI')}}</span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                                <input type="text" class="form-control" name="publicKey"
                                                                    value="{{env('APP_MODE')!='demo'?$config['publicKey']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('secretKey')}} </label>
                                                                <input type="text" class="form-control" name="secretKey"
                                                                    value="{{env('APP_MODE')!='demo'?$config['secretKey']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paymentUrl')}} </label>
                                                                <input type="text" class="form-control" name="paymentUrl"
                                                                    value="{{env('APP_MODE')!='demo'?$config['paymentUrl']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('merchantEmail')}} </label>
                                                                <input type="text" class="form-control" name="merchantEmail"
                                                                    value="{{env('APP_MODE')!='demo'?$config['merchantEmail']:''}}">
                                                            </div>
                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paymob_accept'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paymob_accept']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/paymob.png')}}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paymob_accept')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paymob_accept')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>

                                                                <div
                                                                    class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                                                    <span class="form-ellipsis {{ (Session::get('direction') ?? 'rtl') === 'rtl' ? 'text-right' : 'text-left' }}"
                                                                        id="id_paymob_accept">{{ url('/') }}/paymob-callback</span>
                                                                    <span class="btn bg-primaryColor btn-primary text-nowrap btn-xs"
                                                                        onclick="copyToClipboard('#id_paymob_accept')">
                                                                        <i class="tio-copy"></i>
                                                                        {{\App\CPU\Helpers::translate('Copy URI')}}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                                <input type="text" class="form-control" name="api_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('iframe_id')}}</label>
                                                                <input type="text" class="form-control" name="iframe_id"
                                                                    value="{{env('APP_MODE')!='demo'?$config['iframe_id']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('integration_id')}}</label>
                                                                <input type="text" class="form-control" name="integration_id"
                                                                    value="{{env('APP_MODE')!='demo'?$config['integration_id']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('HMAC')}}</label>
                                                                <input type="text" class="form-control" name="hmac"
                                                                    value="{{env('APP_MODE')!='demo'?$config['hmac']:''}}">
                                                            </div>


                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="card">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'fawry_pay'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'fawry_pay']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/fawry.svg')}}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('fawry_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('fawry_pay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('merchant_code')}}</label>
                                                                <input type="text" class="form-control" name="merchant_code"
                                                                    value="{{env('APP_MODE')!='demo'?$config['merchant_code']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('security_key')}}</label>
                                                                <input type="text" class="form-control" name="security_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['security_key']:''}}">
                                                            </div>


                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'mercadopago'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'mercadopago']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <img width="200" src="{{asset('/public/assets/back-end/img/mercado.svg')}}" alt="">
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('mercadopago')}} ({{ Helpers::translate('for buying') }})</h5>

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                    name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('mercadopago')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                    name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')



                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                                <input type="text" class="form-control" name="public_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('access_token')}}</label>
                                                                <input type="text" class="form-control" name="access_token"
                                                                    value="{{env('APP_MODE')!='demo'?$config['access_token']:''}}">
                                                            </div>

                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'liqpay'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'liqpay']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))

                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/liqpay4.png')}}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('liqpay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('liqpay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                                <input type="text" class="form-control" name="public_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('privateKey')}}</label>
                                                                <input type="text" class="form-control" name="private_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['private_key']:''}}">
                                                            </div>

                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'flutterwave'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'flutterwave']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/fluterwave.png')}}"
                                                                    alt="">
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('flutterwave')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('flutterwave')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                                <input type="text" class="form-control" name="public_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    class="d-flex title-color">{{\App\CPU\Helpers::translate('secret key')}}</label>
                                                                <input type="text" class="form-control" name="secret_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('hash')}}</label>
                                                                <input type="text" class="form-control" name="hash"
                                                                    value="{{env('APP_MODE')!='demo'?$config['hash']:''}}">
                                                            </div>

                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paytm'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paytm']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/paytm.png')}}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytm')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytm')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paytm_merchant_key')}}</label>
                                                                <input type="text" class="form-control" name="paytm_merchant_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_key']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paytm_merchant_mid')}}</label>
                                                                <input type="text" class="form-control" name="paytm_merchant_mid"
                                                                    value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_mid']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paytm_merchant_website')}}</label>
                                                                <input type="text" class="form-control" name="paytm_merchant_website"
                                                                    value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_website']:''}}">
                                                            </div>

                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'bkash'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'bkash']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/bkash.png')}}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bkash')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bkash')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">
                                                                    {{\App\CPU\Helpers::translate('choose_environment')}}
                                                                </label>
                                                                <select class="js-example-responsive form-control" name="environment">
                                                                    <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('sandbox')}}
                                                                    </option>
                                                                    <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                        {{\App\CPU\Helpers::translate('live')}}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                                <input type="text" class="form-control" name="api_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_secret')}}</label>
                                                                <input type="text" class="form-control" name="api_secret"
                                                                    value="{{env('APP_MODE')!='demo'?$config['api_secret']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('username')}}</label>
                                                                <input type="text" class="form-control" name="username"
                                                                    value="{{env('APP_MODE')!='demo'?$config['username']:''}}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('password')}}</label>
                                                                <input type="text" class="form-control" name="password" id="password"
                                                                    value="{{env('APP_MODE')!='demo'?$config['password']:''}}">
                                                                    <span class="fa fa-eye-slash toggle-password" style="position: absolute;left: 5%;top: 60%;cursor: pointer;"></span>
                                                            </div>




                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body border">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'myfatoorah'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'myfatoorah']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')

                                                            <div class="mb-3">
                                                                <img width="200" src="{{asset('/public/assets/back-end/img/myfatoorah.png')}}" alt="">
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('myfatoorah')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>

                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('myfatoorah')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                    <span class="switcher_control"></span>
                                                                </label>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                                <input type="text" class="form-control" name="api_key"
                                                                    value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                                            </div>

                                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                        class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase w-full">{{\App\CPU\Helpers::translate('Save changes')}}</button>
                                                                @else
                                                                    <button type="submit"
                                                                            class="btn bg-primaryColor btn-primary px-4 bg-primaryColor" text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                                @endif
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </ul>


                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($customer->is_store)
            @php($store = $customer->store_informations)
            <div class="row mt-0 cu_form" id="account-tab">
                <div class="col-md-12">
                    <div class="card">
                        @if(!isset($new))
                            <div class="card-header text-capitalize">
                                <div class="col-lg-1">
                                    <h5 class="mb-0">{{\App\CPU\Helpers::translate('Store Account')}}</h5>
                                </div>
                                <div class="col-lg-11">
                                @if(($customer['is_active'] ?? '')==1)
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="suspended">
                                        <input type="hidden" name="bool_res" value="1">
                                        <button type="submit"
                                        class="btn btn-sm btn-outline-danger">{{\App\CPU\Helpers::translate('suspend')}}</button>
                                    </form>
                                    @elseif(($customer['is_active'] ?? '')==0)
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="bool_res" value="1">
                                        <button type="submit"
                                                class="btn btn-outline-success">{{\App\CPU\Helpers::translate('activate')}}</button>
                                    </form>
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="2">
                                        <input type="hidden" name="bool_res" value="0">
                                        <button type="submit"
                                        class="btn btn-outline-danger">{{\App\CPU\Helpers::translate('reject')}}</button>
                                    </form>
                                    @elseif(($customer['is_active'] ?? '')==2)
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="bool_res" value="1">
                                        <button type="submit"
                                                class="btn btn-outline-success">{{\App\CPU\Helpers::translate('activate')}}</button>
                                    </form>
                                @endif
                                </div>
                            </div>
                        @endif
                        @include('store_account')
                        <div class="d-flex justify-content-end gap-3" hidden>
                            <button type="reset" id="reset" class="btn btn-secondary px-4" hidden>{{ \App\CPU\Helpers::translate('reset')}}</button>
                            <button type="submit" onclick="check()" class="btn bg-primaryColor btn-primary btn-save px-4" hidden>{{ \App\CPU\Helpers::translate('update')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="orders-tab">
            <div class="col-lg-12 mb-3 mb-lg-0">
                <div class="card">
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table datatable table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-full">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{\App\CPU\Helpers::translate('sl')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Order ID')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Total')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('order source')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('order date & time')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('shipping method')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('order status')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $key=>$order)
                                <tr>
                                    <td>{{$orders->firstItem()+$key}}</td>
                                    <td>
                                        <a href="{{route('admin.orders.details',['id'=>$order['id']])}}" class="title-color hover-c1">{{$order['id']}}</a>
                                    </td>
                                    <td>
                                        {{\App\CPU\BackEndHelper::set_symbol((Helpers::get_order_totals($order)['total']))}}
                                    </td>

                                    <td class="">
                                        {!! $order->ext_order_id >= 1 ? Helpers::translate('synchronous') : Helpers::translate('direct') . '<br/>' !!}
                                        @switch($order->ordered_using)
                                            @case("Windows")
                                                {{ Helpers::translate('Computer browser') }}
                                                @break
                                            @case("PostmanRuntime")
                                                {{ Helpers::translate('Computer browser') }}
                                                @break
                                            @case("Dart")
                                                {{ Helpers::translate('Mobile application') }}
                                                @break
                                            @case("Android")
                                                {{ Helpers::translate('Mobile browser') }}
                                                @break
                                            @case("Mac")
                                                {{ Helpers::translate('Mobile browser') }}
                                                @break
                                            @default

                                        @endswitch
                                    </td>

                                    <td>
                                        <div>{{date('Y/m/d',strtotime($order['created_at']))}} </div>
                                        <div dir="ltr">{{ date("h:i A",strtotime($order['created_at'])) }}</div>
                                    </td>

                                    <td style="white-space: inherit;">
                                        @isset($order->shipping_info['shipment_data'])
                                        @php($shipping_info = $order->shipping_info['shipment_data'])
                                        <p>
                                            {{ Helpers::translate("Bettween Company") }} - {{ Helpers::translate($order->shipping_info['shipment_data']['status']) }}
                                        </p>
                                        <div class="row">
                                            <div class="col-9 px-1">
                                                <a href="{{ $shipping_info['shipping_tracking_url'] ?? null }}" target="_blank">
                                                    {{ $shipping_info['awb_no'] ?? null }}
                                                </a>
                                            </div>

                                            <div class="col-3 text-center p-0 generate_bill_of_lading">
                                                <form action="https://api.fastcoo-tech.com/API/Print/{{$shipping_info['awb_no']}}" method="get" target="_blank">
                                                    <button style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('bill of lading')}}">
                                                        <i class="tio-print"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                        @php($shipping_info = $order->shipping_info)
                                        @isset($shipping_info['order']['status'])
                                        <p>
                                            {{ Helpers::translate($shipping_info['order']['courier']) }} - {{ Helpers::translate($shipping_info['order']['status']) }}
                                        </p>
                                        <div class="row">
                                            <div class="col-9 px-1">
                                                {{ $shipping_info['order']['courierRefCode'] }}
                                            </div>

                                            <div class="col-3 text-center p-0 generate_bill_of_lading">
                                                <form action="{{ route('admin.orders.printAWB') }}" method="post" target="_blank">
                                                    @csrf
                                                    <input type="hidden" name="ids" value="{{ $order['id'] }}">
                                                    <button style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('bill of lading')}}">
                                                        <i class="tio-print"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                        @php($def_sh = Helpers::get_business_settings('default_shipping_company'))
                                        @if(Helpers::module_permission_check('order.'.$order->order_status.'.generate_bill_of_lading'))
                                        <form id="shipping_form_{{$order['id']}}" class="row generate_bill_of_lading" method="post" action="{{route('admin.orders.genAWB')}}">
                                            <input type="hidden" name="ids" value="{{$order->id}}">
                                            @csrf
                                            <select name="courier" class="col-9" required id="courier_{{$order['id']}}">
                                                <option @if($def_sh == "None") selected @endif disabled></option>
                                                @foreach (Helpers::get_business_settings('shipping_companies') ?? [] as $sh)
                                                @if($sh !== "None")
                                                <option @if($def_sh == $sh) selected @endif value="{{$sh}}">{{ Helpers::translate($sh) }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            <div class="btn btn-primary col-3" onclick="if($('#courier_{{$order['id']}}').val() == 'between'){form_alert('shipping_form_{{$order['id']}}','{{Helpers::translate('order status will be changed to ')}} ({{Helpers::translate('Confirmed')}})')}else{$('#shipping_form_{{$order['id']}}').submit()}">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </form>
                                        @endif
                                        @endisset
                                        @endisset
                                    </td>

                                    <td class="text-center text-capitalize">
                                        @if($order['order_status']=='pending')
                                            <span class="badge badge-soft-info fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>

                                        @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
                                            <span class="badge badge-soft-warning fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @elseif($order['order_status']=='confirmed')
                                            <span class="badge badge-soft-success fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @elseif($order['order_status']=='failed')
                                            <span class="badge badge-danger fz-12">
                                                {{$order['order_status'] == 'failed' ? Helpers::translate('Failed To Deliver') : ''}}
                                            </span>
                                        @elseif($order['order_status']=='delivered')
                                            <span class="badge badge-soft-success fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger fz-12">
                                                {{Helpers::translate($order['order_status'])}}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-10">
                                            <a class="btn btn-white border-0"
                                                title="{{\App\CPU\Helpers::translate('View')}}"
                                                href="{{route('admin.orders.details',['id'=>$order['id']])}}">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.5819 11.9999C15.5819 13.9799 13.9819 15.5799 12.0019 15.5799C10.0219 15.5799 8.42188 13.9799 8.42188 11.9999C8.42188 10.0199 10.0219 8.41992 12.0019 8.41992C13.9819 8.41992 15.5819 10.0199 15.5819 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M11.9998 20.2697C15.5298 20.2697 18.8198 18.1897 21.1098 14.5897C22.0098 13.1797 22.0098 10.8097 21.1098 9.39973C18.8198 5.79973 15.5298 3.71973 11.9998 3.71973C8.46984 3.71973 5.17984 5.79973 2.88984 9.39973C1.98984 10.8097 1.98984 13.1797 2.88984 14.5897C5.17984 18.1897 8.46984 20.2697 11.9998 20.2697Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                            <a class="btn btn-white border-0"
                                                title="{{\App\CPU\Helpers::translate('Invoice')}}"
                                                target="_blank"
                                                href="{{route('admin.orders.generate-invoice',[$order['id']])}}">
                                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.2878 13V17C19.2878 17.5304 19.0737 18.0391 18.6927 18.4142C18.3116 18.7893 17.7948 19 17.2558 19H3.03198C2.49307 19 1.97622 18.7893 1.59515 18.4142C1.21408 18.0391 1 17.5304 1 17V13" stroke="#292D32" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M5.0625 8L10.1425 13L15.2224 8" stroke="#292D32" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10.1445 13V1" stroke="#292D32" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- Footer -->
                        <div class="card-footer">
                            <!-- Pagination -->
                        {!! $orders->links() !!}
                        <!-- End Pagination -->
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>

        {{--  Concurrent products  --}}
        @if($customer->is_store)
        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="products-tab">
            <div class="col-lg-12 mb-3 mb-lg-0">
            <div class="pt-2 px-0 tab-content" id="synced">
                <div class="row w-full text-center py-3 bg-light mx-0 mt-4" style="border-radius: 12px">

                    <div class="col-md-4 text-center justify-content-center d-flex">
                        <div style="display:none" class="d-flex table-actions flex-wrap justify-content-center mx-3 bg-white wd-md-50p">
                            <button class="btn ti-save btn-primary my-2 btn-icon-text m-2" onclick="saveAll()">
                                <i class="fa fa-save"></i>
                            </button>

                            <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete-linked','Want to delete this items ?')">
                                <i class="ri-delete-bin-5-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0 px-0 border" id="items">
                    <div>
                        <table style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};margin-top:0px !important;    width: 109.65em;"
                        class="products-dataTable0 linked_products_table table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">

                                    </th>
                                    <th class="text-center"><strong>{{ Helpers::translate('ID') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('image') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('Item Number') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('product_code_sku') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('name') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('sale price in store') }}</strong></th>
                                    <th class="text-center"><strong>{{ Helpers::translate('actions') }}</strong></th>
                                </tr>
                            </thead>
                            <thead class="theadP">
                                <tr>
                                    <th scope="">
                                        <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked)" />
                                    </th>
                                    <th colName="id" class="theadFilter" scope="col"></th>
                                    <th class="" scope="col"></th>
                                    <th colName="name" class="theadFilter" scope="col"></th>
                                    <th colName="item_number" class="theadFilter"></th>
                                    <th colName="code" class="theadFilter"></th>
                                    <th colName="purchase_price" class="theadFilter"></th>
                                    <th colName="unit_price" class="theadFilter"></th>
                                    <th colName="featured" class="theadFilter"></th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($current_lang = session()->get('local'))
                                @foreach($products_linked ?? [] as $k=>$p)
                                @php($p['unit_price'] = Helpers::getProductPrice_pl($p->id)['value'] ?? 0)
                                <tr class="lptr">
                                    <td class="td-w-full">
                                        @if(isset($end) && $end)
                                            <span class="engh"></span>
                                        @endif
                                        <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                        <span class="rowId" hidden>{{$p->id}}</span>
                                    </td>
                                    <td class="td-w-full text-center" scope="row">{{$p->id}}</td>

                                    <td class="td-w-full text-center">
                                        @php($local = session()->get('local'))
                                        <img class="rounded productImg" width="64"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($p['images'])->$current_lang)) ? json_decode($p['images'])->$current_lang[0] ?? '' : ''}}"
                                        >
                                    </td>
                                    <td class="text-center">
                                        {{ $p['item_number'] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $p['code'] }}
                                    </td>
                                    @php($name = $p['name'])
                                    <td class=" text-center" style="
                                    max-width: none !important;
                                    min-width: auto !important;
                                ">
                                        {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p['id'],'name',session()->get('local')) ?? $name }}
                                    </td>
                                    <td class="text-center">
                                        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p['id'],\App\User::find($customer->id))['value'] ?? $p['unit_price']))}}
                                    </td>
                                    <td class="text-center">
                                        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p['id'])['suggested_price'] ?? $p['suggested_price']))}}
                                    </td>
                                    <td class="text-center">
                                        {{ \App\CPU\BackEndHelper::set_symbol(floatval(Helpers::get_linked_price($p['id'], $customer->id)) == 0
                                            ? (floatval(Helpers::getProductPrice_pl($p['id'])['suggested_price'] ?? $p['suggested_price']) !== 0
                                                ? Helpers::getProductPrice_pl($p['id'])['suggested_price'] ?? $p['suggested_price']
                                                : Helpers::getProductPrice_pl($p['id'])['value'] ?? $p['suggested_price'])
                                            : Helpers::get_linked_price($p['id'], $customer->id)) }}
                                    </td>

                                    <td class="td-w-full">
                                        <a class="text-light rounded-0 col-12"
                                        title="{{\App\CPU\Helpers::translate('Delete from list')}}"
                                        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;text-align: -webkit-center;" href="javascript:"
                                        onclick="deleteFromLinked(event,{{$p->id}})">
                                        <svg width="36" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.75 4.48486C13.2525 4.23736 10.74 4.10986 8.235 4.10986C6.75 4.10986 5.265 4.18486 3.78 4.33486L2.25 4.48486" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.375 3.7275L6.54 2.745C6.66 2.0325 6.75 1.5 8.0175 1.5H9.9825C11.25 1.5 11.3475 2.0625 11.46 2.7525L11.625 3.7275" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.1373 6.85498L13.6498 14.4075C13.5673 15.585 13.4998 16.5 11.4073 16.5H6.5923C4.4998 16.5 4.4323 15.585 4.3498 14.4075L3.8623 6.85498" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.74756 12.375H10.2451" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.125 9.375H10.875" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        </a>
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
        @endif

        @if($customer->is_store)
        @php($sub = App\Model\Subscription::where(['user_id'=>$customer->id,'package_id'=>$customer->subscription])->orderBy('id','desc')->first())
        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="subscription-tab">
            <div class="table-responsive">
                <table style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                    class="subs-dataTable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="id_col">
                            {{ \App\CPU\Helpers::translate('ID')}}
                        </th>
                        <th>
                            {{\App\CPU\Helpers::translate('Customer')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('the package')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('start date')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('expiry date')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('remaining time')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('subscription status')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('payment method')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{ \App\CPU\Helpers::translate('attachment')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(App\Model\Subscription::whereHas('customer',function(){})->where('user_id',$customer->id)->get() as $k=>$sub)
                    @isset($sub->pakcage->name)
                    @isset($sub->customer['id'])
                        <tr>
                            <td class="id_col">
                                {{ $sub->id }}
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$sub->customer['id']])}}">
                                    {{ $sub->customer->store_informations['company_name'] ?? 'deleted user' }}
                                </a>
                            </td>
                            <td>
                                {{ $sub->pakcage->name }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($sub->created_at)->format('Y/m/d   H:i') }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($sub->expiry_date)->format('Y/m/d') }}   {{ Carbon\Carbon::parse($sub->created_at)->format('H:i') }}
                            </td>
                            <td>
                                @if($sub->expiry_date <= Carbon\Carbon::today())
                                -
                                @else
                                {{ Helpers::customer_exp_days_by_sub($sub->id) . ' ' . Helpers::translate('day/days') }}
                                @endif
                            </td>
                            <td>
                                @switch($sub->status)
                                    @case('paid')
                                        <span class="badge text-success fz-12 px-0">
                                            {{\App\CPU\Helpers::translate($sub->status)}}
                                        </span>
                                        @break
                                    @case('active')
                                        <span class="badge text-success fz-12 px-0">
                                            {{\App\CPU\Helpers::translate($sub->status)}}
                                        </span>
                                        @break
                                    @case("expired")
                                        <span class="badge text-danger fz-12 px-0">
                                            {{\App\CPU\Helpers::translate('expired')}}
                                        </span>
                                        @break
                                    @case("pending")
                                        <span class="badge text-warning fz-12 px-0">
                                            {{\App\CPU\Helpers::translate('pending subscription')}}
                                        </span>
                                        @break
                                    @case("upgraded")
                                        <span class="badge text-dark fz-12 px-0">
                                            {{\App\CPU\Helpers::translate('expired (upgraded)')}}
                                        </span>
                                        @break
                                    @default
                                    {{ $sub->status }}
                                @endswitch
                            </td>
                            <td>
                                {{ Helpers::translate($sub->payment_method) }}
                            </td>
                            <td>
                                @if (strpos($sub->payment_method, 'bank_transfer') !== false)
                                    <a target="_blank" href="{{ asset('/storage/app/public/user/').'/'.$sub->attachment }}">
                                        {{ Helpers::translate('view') }} / {{ Helpers::translate('download') }}
                                    </a>
                                    @if ($sub->status=="pending" && Helpers::module_permission_check('admin.subscriptions.approve'))
                                    <br/>
                                        @if(Helpers::module_permission_check('admin.subscriptions.approve'))
                                        <button class="btn btn-primary" onclick="form_alert('approve-sub-{{$sub->id}}','{{ Helpers::translate('Approve request?') }}')">
                                            {{ Helpers::translate('Approve') }}
                                        </button>
                                        <form id="approve-sub-{{$sub->id}}" action="{{route('admin.subscriptions.approve')}}">
                                            <input type="hidden" name="id" value="{{$sub->id}}">
                                        </form>
                                        @endif
                                    @endif
                                @else
                                    {{ $sub->attachment }}
                                @endif
                            </td>
                        </tr>
                    @endisset
                    @endisset
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>


        <div class="row bg-white cu_form" id="tickets-tab">
            <div class="col-lg-12 mb-3 mb-lg-0">
                <div class="card">
                    <!-- Table -->
                    <div class="d-flex align-items-center my-3">
                        <a title="{{ Helpers::translate('Add a support ticket') }}" class="btn btn-icon-text" style="background-color:#673ab7; display: inline-flex; align-items: center;" href="#" data-toggle="modal" data-target="#publishNoteModal">
                            <svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path  fill="#ffffff" d="M21.3333 2.66675H10.6667C5.33332 2.66675 2.66666 5.33341 2.66666 10.6667V28.0001C2.66666 28.7334 3.26666 29.3334 3.99999 29.3334H21.3333C26.6667 29.3334 29.3333 26.6667 29.3333 21.3334V10.6667C29.3333 5.33341 26.6667 2.66675 21.3333 2.66675ZM18.6667 20.3334H9.33332C8.78666 20.3334 8.33332 19.8801 8.33332 19.3334C8.33332 18.7867 8.78666 18.3334 9.33332 18.3334H18.6667C19.2133 18.3334 19.6667 18.7867 19.6667 19.3334C19.6667 19.8801 19.2133 20.3334 18.6667 20.3334ZM22.6667 13.6667H9.33332C8.78666 13.6667 8.33332 13.2134 8.33332 12.6667C8.33332 12.1201 8.78666 11.6667 9.33332 11.6667H22.6667C23.2133 11.6667 23.6667 12.1201 23.6667 12.6667C23.6667 13.2134 23.2133 13.6667 22.6667 13.6667Z" fill="white"/>
                            </svg>
                            <span class="text-white mx-2">{{ \App\CPU\Helpers::translate('Add a support ticket') }}</span>
                        </a>
                    </div>


                    <div class="table-responsive">
                        <table
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-full">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{\App\CPU\Helpers::translate('sl')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('ticket ID')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Date and time the support ticket was registered')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Latest update on support ticket')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('the topic')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Status')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($tickets ?? [] as $key=>$ticket)
                                <tr>
                                    <td class="px-6">{{$key + 1}}</td>
                                    <td class="px-7">
                                        <a href="{{route('admin.orders.details',['id'=>$ticket['id']])}}" class="title-color hover-c1">{{$ticket['id']}}</a>
                                    </td>
                                    <td class="px-6">
                                        {{date('Y/m/d',strtotime($ticket['created_at']))}}&nbsp;<span class="fz-13" dir="ltr">{{ date("h:i A",strtotime($ticket['created_at'])) }}
                                    </td>

                                    <td class="px-6">
                                        {{date('Y/m/d',strtotime($ticket['updated_at']))}}&nbsp;<span class="fz-13" dir="ltr">{{ date("h:i A",strtotime($ticket['updated_at'])) }}
                                    </td>

                                    <td class="px-6">
                                        {{ $ticket->subject }}
                                    </td>

                                    <td style="white-space: inherit;">
                                        <label class="switcher">
                                            <input class="switcher_input statusticket" type="checkbox"
                                                   {{$ticket->status=='open'?'checked':''}} id="{{$ticket->id}}">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>



                                    <td>
                                        <div class="d-flex justify-content-center gap-10">
                                            <a class="btn btn-white border-0"
                                                title="{{\App\CPU\Helpers::translate('View')}}"
                                                href="{{route('admin.support-ticket.singleTicket',$ticket['id'])}}">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.5819 11.9999C15.5819 13.9799 13.9819 15.5799 12.0019 15.5799C10.0219 15.5799 8.42188 13.9799 8.42188 11.9999C8.42188 10.0199 10.0219 8.41992 12.0019 8.41992C13.9819 8.41992 15.5819 10.0199 15.5819 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M11.9998 20.2697C15.5298 20.2697 18.8198 18.1897 21.1098 14.5897C22.0098 13.1797 22.0098 10.8097 21.1098 9.39973C18.8198 5.79973 15.5298 3.71973 11.9998 3.71973C8.46984 3.71973 5.17984 5.79973 2.88984 9.39973C1.98984 10.8097 1.98984 13.1797 2.88984 14.5897C5.17984 18.1897 8.46984 20.2697 11.9998 20.2697Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
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
        <!-- End Row -->
        @endif
    </div>
@endsection

@push('script_2')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    @if($customer->is_store)
    {{--  map  --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
    <script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>
    <script>
        function initAutocomplete() {
            var myLatLng = { lat: {{$shipping_latitude??'-33.8688'}}, lng: {{$shipping_longitude??'151.2195'}} };

            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: { lat: {{$shipping_latitude??'23.8859'}}, lng: {{$shipping_longitude??'45.0792'}} },
                zoom: 16,
                mapTypeId: "roadmap",
                streetViewControl:false,
            });

            //
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });
            addYourLocationButton(map, marker);
            //

            var userMarker = new google.maps.Marker({
                map: map,
                title: 'My Location'
            });


            marker.setMap( map );
            var geocoder = geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                var coordinates = JSON.parse(coordinates);
                var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
                marker.setPosition( latlng );
                map.panTo( latlng );

                document.getElementById('latitude').value = coordinates['lat'];
                document.getElementById('longitude').value = coordinates['lng'];

                geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById('address').value = results[1].formatted_address;
                            console.log(results[1].formatted_address);
                        }
                    }
                });
            });

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var mrkr = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    google.maps.event.addListener(mrkr, "click", function (event) {
                        document.getElementById('latitude').value = this.position.lat();
                        document.getElementById('longitude').value = this.position.lng();

                    });

                    markers.push(mrkr);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        };
        $(document).on('ready', function () {
            initAutocomplete();

        });

        $(document).on("keydown", "input", function(e) {
        if (e.which==13) e.preventDefault();
        });
    </script>
    {{--  end map  --}}
    @endif
    <script>
        $(".cu_link").click(function (e) {
            e.preventDefault();
            $(".cu_link").removeClass('active');
            $(".cu_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let x = form_id.split("-")[0];
            $("#" + x + "-tab").removeClass('d-none');
            setTimeout(function(){
                switch (x) {
                    case "orders":
                        table.draw();
                        break;
                    case "products":
                        pTable.draw();
                        break;
                    case "subscription":
                        sTable.draw();
                        break;
                }
            },500)
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer1').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL_(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL__(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer3').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL___(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer4').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function deleteFromLinked(e,productLocalId){
            alert_wait();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.customer.products-delete')}}?id="+productLocalId,
                method: 'POST',
                data: {
                    Id: '{{ $customer->id }}',
                },
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

        $("#customFileUpload1").change(function () {
            readURL(this);
        });

        $(".payment_method_acc").click(function(){
            $(".payment_method_acc").find('.fa-angle-up').hide()
            $(".payment_method_acc").find('.fa-angle-down').show()
            $(".payment_method_acc").next('.tab-pane').slideUp()
            $(".payment_method_acc").find('a').removeClass('active')
            if($(this).next('.tab-pane').is(':visible')){
            }else{
                $(this).find('a').addClass('active')
                $(this).next('.tab-pane').slideDown()
                $(this).find('a').find('.fa-angle-up').show()
                $(this).find('a').find('.fa-angle-down').hide()
            }
        })

        $("#customFileUpload2").change(function () {
            readURL_(this);
        });

        $("#customFileUpload3").change(function () {
            readURL__(this);
        });

        $("#customFileUpload4").change(function () {
            readURL___(this);
        });
    </script>
    <script>
        $(document).on('change', '.statusticket', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") === true) {
                var status = 'open';
            } else if ($(this).prop("checked") === false) {
                var status = 'close';
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.support-ticket.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success("{{ Helpers::translate('Ticket status updated successfully') }}");
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // تعيين معالج النقر لكل عنصر dropdown-item
            $('.drpit').click(function(e) {
                e.preventDefault(); // منع السلوك الافتراضي للرابط
                var value = $(this).data('value'); // الحصول على القيمة من البيانات المخزنة في data-value
                var textarea = $('#publishNoteModal textarea[name="massege"]');
                var currentValue = textarea.val(); // الحصول على القيمة الحالية لـ <textarea>

                // إضافة مسافة بعد النص الحالي إذا كان هناك نص موجود بالفعل
                if (currentValue.length > 0) {
                    currentValue += ' '; // فراغ بين النص الحالي والنص الجديد
                }

                textarea.val(currentValue + value); // إضافة القيمة الجديدة إلى النص الحالي
                $('#publishNoteModal').modal('show'); // إظهار المودال
            });
        });

        $('.dropdown-search').on('input', function() {
            var searchVal = this.value.toLowerCase();
            $('.dropdown-items .drpit').each(function() {
                var text = $(this).text().toLowerCase();
                if (text.includes(searchVal)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

</script>
<script>
    $(document).ready(function() {
        // تبديل الـ tabs
        $('a[data-toggle="tab"]').on('click', function (e) {
            e.preventDefault(); // منع السلوك الافتراضي للوصلة
            var currentTab = $(this); // الحصول على التاب الحالي
            var targetPane = currentTab.attr("href"); // الحصول على الهدف المرتبط بالتاب

            // إزالة الفئة active من جميع عناصر التاب وإضافتها للتاب الحالي
            $('a[data-toggle="tab"]').removeClass('active');
            currentTab.addClass('active');

            // إزالة الفئات active و show من جميع عناصر المحتوى وإضافتها للمحتوى المرتبط بالتاب الحالي
            $('.tab-pane').removeClass('active show');
            $(targetPane).addClass('active show');
        });

        // عند تفعيل تاب معين، أظهر المحتوى المرتبط به
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href"); // الحصول على الهدف المرتبط بالتاب
            $('.tab-pane').removeClass('active show'); // إزالة الفئات active و show من جميع التابات
            $(target).addClass('active show'); // إضافة الفئات active و show إلى المحتوى المرتبط بالتاب المنشط
        });

        // عند النقر خارج الـ dropdown، يجب إغلاقه
        $(window).on('click', function (e) {
            if (!$(e.target).closest('.drpd').length) {
                $('.drpd').removeClass('show');
                $('.drpmn').removeClass('show');
            }
        });

        // منع إغلاق الـ dropdown عند التبديل بين التابات
        $('.drpd').on('click', function (e) {
            e.stopPropagation(); // منع انتشار الحدث لأعلى
        });

        $('.toolbar-icon').on('click', function (e) {
            // تأكد من أن الحدث الافتراضي لا يتم منعه
            var dropdownMenu = $(this).next('.drpmn');
            if (dropdownMenu.hasClass('show')) {
                dropdownMenu.removeClass('show');
            } else {
                // إغلاق جميع القوائم المنسدلة الأخرى قبل إظهار هذه القائمة
                $('.drpmn').removeClass('show');
                dropdownMenu.addClass('show');
            }
            // لمنع إغلاق الـ dropdown عند النقر على الأيقونة نفسها
            e.stopPropagation();
        });
    });
</script>
@endpush


