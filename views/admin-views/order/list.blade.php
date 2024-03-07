@extends('layouts.back-end.app',['disableDatatableColsWidth'=>1])

@section('title', \App\CPU\Helpers::translate('Order List'))

@push('css_or_js')
    <style>
        .dropdown-item, .dropdown-submenu{
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .dataTables_empty{
            display: none;
        }

        .datatable * td:not(.actions-col,:first-of-type,.id_col), .datatable * th:not(.actions-col,:first-of-type,.id_col), .products-dataTable * td:not(.actions-col,:first-of-type,.id_col), .products-dataTable * th:not(.actions-col,:first-of-type,.id_col){
            width: 120px !important;
            min-width: 120px !important;
            max-width: 120px !important;
            white-space: inherit;
        }

        .actions-col{
            width: 70px !important;
            min-width: 70px !important;
            max-width: 70px !important;
        }
        .datatable * td:first-of-type,
        .datatable * th:first-of-type
        {
            width: 10px !important;
            min-width: 10px !important;
            max-width: 10px !important;
        }

        .theadF * th{
            border: 0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div>

            <!-- Page Title -->
            {{--  toolbar  --}}
            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    @if (1 == 2)
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.brand.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    @endif

                    <button title="{{Helpers::translate('show filters')}}" class="btnDeleteRow btn ti-trash btn-info my-2 btn-icon-text m-2"
                    onclick="$('.custom-filters').slideToggle()"
                    >
                        <i class="fa fa-filter"></i>
                    </button>
                    <div id="colsMenu" style="position: relative;">

                    </div>
                    <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    onclick="form_alert('order-bulk-delete','Are you sure ?')"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    </div>
                    <form hidden id="order-bulk-delete" method="post"
                    action="{{ route('admin.orders.order-bulk-delete') }}">@csrf <input type="hidden" name="ids" class="ids" /></form>
                    <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="min-height: 45px">
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu text-start py-2">
                                <li class="dropdown-submenu order_status">
                                    <a class="test" tabindex="-1" href="#">{{\App\CPU\Helpers::translate('Amend the request status')}} <span class="caret"></span></a>
                                    <ul class="dropdown-menu py-2">
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-pending','Are you sure ?')">
                                                <form hidden id="bulk-status-pending" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'pending']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('pending')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-confirmed','Are you sure ?')">
                                                <form hidden id="bulk-status-confirmed" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'confirmed']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('confirmed')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-Processing','Are you sure ?')">
                                                <form hidden id="bulk-status-Processing" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'processing']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('Processing')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-out_for_delivery','Are you sure ?')">
                                                <form hidden id="bulk-status-out_for_delivery" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'out_for_delivery']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('out_for_delivery')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-delivered','Are you sure ?')">
                                                <form hidden id="bulk-status-delivered" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'delivered']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('delivered')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-returned','Are you sure ?')">
                                                <form hidden id="bulk-status-returned" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'returned']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('returned')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-failed','Are you sure ?')">
                                                <form hidden id="bulk-status-failed" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'failed']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('failed')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-canceled','Are you sure ?')">
                                                <form hidden id="bulk-status-canceled" method="post"
                                                    action="{{ route('admin.orders.order-bulk-status', ['status' => 'canceled']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('canceled')}}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu shipping_status">
                                    <a class="test" tabindex="-1" href="#">{{\App\CPU\Helpers::translate('Amend the payment status')}} <span class="caret"></span></a>
                                    <ul class="dropdown-menu py-2">
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-paid','Are you sure ?')">
                                                <form hidden id="bulk-status-paid" method="post"
                                                    action="{{ route('admin.orders.order-bulk-payment', ['status' => 'paid']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('paid')}}
                                            </a>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('bulk-status-unpaid','Are you sure ?')">
                                                <form hidden id="bulk-status-unpaid" method="post"
                                                    action="{{ route('admin.orders.order-bulk-payment', ['status' => 'unpaid']) }}">
                                                    @csrf <input type="hidden" name="ids" class="ids"></form>
                                                {{\App\CPU\Helpers::translate('unpaid')}}
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-submenu generate_bill_of_lading">
                                    <a class="test" tabindex="-1" href="#">{{\App\CPU\Helpers::translate('Generate bills of lading')}} <span class="caret"></span></a>
                                    <ul class="dropdown-menu py-2">
                                        @foreach (Helpers::get_business_settings('shipping_companies') ?? [] as $sh)
                                        @if($sh !== "None")
                                        <li>
                                            <a class="dropdown-item" type="button"
                                                onclick="form_alert('gen_bills_of_lading-{{$sh}}','Are you sure ?')">
                                                <form id="gen_bills_of_lading-{{$sh}}" hidden action="{{ route('admin.orders.genAWB') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="ids" class="ids">
                                                    <input type="hidden" name="courier" value="{{$sh}}">
                                                </form>
                                                {{\App\CPU\Helpers::translate($sh)}}
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="print_bill_of_lading">
                                    <a class="dropdown-item" onclick="form_alert('bills_of_lading','Are you sure ?')">
                                        {{\App\CPU\Helpers::translate('Print bills of lading')}}
                                    </a>
                                    <form id="bills_of_lading" hidden action="{{ route('admin.orders.printAWB') }}" method="post" target="_blank">
                                        @csrf <input type="hidden" name="ids" class="ids"></form>
                                    </form>
                                </li>

                                <li class="generate_invoice">
                                    <a class="dropdown-item" onclick="form_alert('gen_invoices','Are you sure ?')">
                                        {{\App\CPU\Helpers::translate('Print orders invoices')}}
                                    </a>
                                    <form id="gen_invoices" hidden action="{{ route('admin.orders.generate-invoice_p',0) }}" method="post" target="_blank">
                                        @csrf <input type="hidden" name="ids" class="ids"></form>
                                    </form>
                                </li>
                                <li class="generate_bill_of_lading">
                                    <a class="dropdown-item" style="white-space: initial;">
                                        {{\App\CPU\Helpers::translate('Issuing and printing the shipping and orders bills')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="stateClear();location.replace('{{route('admin.orders.list',['status'=>$status])}}')">
                                        <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.orders.order-bulk-export', ['status' => $status, 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search]) }}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                    <label class="input-group mt-2" style="height: 34px">
                        <input
                        type="search"
                        class="form-control form-control-sm"
                        placeholder="..."
                        style="border-radius:0px 6px 6px 0px !important;height: 43px"
                        onkeyup="globalSearch(event.target.value)"
                        >
                        <button class="btn search-btn btn-primary" onclick="productsDTsearch()" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                        <i class="fa fa-search"></i>
                        </button>
                    </label>
                </div>
                <div>
                    <div class="mt-2" style="height: 45px;display: flex;width: 330px;">
                        <input id="selectFrom" class="mx-2 form-control" placeholder="{{ Helpers::translate('select from the id') }}" />
                        <input id="selectTo" class="mx-2 form-control" placeholder="{{ Helpers::translate('to the id') }}" />
                        <button class="btn btn-primary" onclick="selectRange()">
                            {{ Helpers::translate('select') }}
                        </button>
                    </div>
                </div>
                </div>
            </div>
            {{--  toolbar  --}}
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{\App\CPU\Helpers::translate('Orders')}}
                            (
                            @if($status =='processing')
                                {{ ucwords(str_replace('_',' ',Helpers::translate('Packaging') )) }}
                            @elseif($status =='failed')
                                {{ ucwords(str_replace('_',' ',Helpers::translate('Failed to Deliver') )) }}
                            @else
                                {{ ucwords(str_replace('_',' ',Helpers::translate($status) )) }}
                            @endif
                            )
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <!-- Order States -->
            <div class="card">
                <div class="card custom-filters" style="display: none">
                    <div class="card-body">
                        <form action="{{ url()->current() }}" id="form-data" class="filters-form" method="post">
                            @csrf
                            <input type="hidden" id="sortBy" name="sortBy" value="{{$filters['sortBy'] ?? 'id'}}" />
                            <input type="hidden" id="sortType" name="sortType" value="{{$filters['sortType'] ?? 'desc'}}" />
                            <div class="row gy-3 gx-2">
                                <div class="col-12 pb-0">
                                    <h4>{{\App\CPU\Helpers::translate('select date range')}}</h4>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <select name="filter" class="form-control">
                                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All</option>
                                        <option value="admin" {{ $filter == 'admin' ? 'selected' : '' }}>In House</option>
                                        <option value="seller" {{ $filter == 'seller' ? 'selected' : '' }}>Seller</option>
                                        @if($status == 'all' || $status == 'delivered')
                                        <option value="POS" {{ $filter == 'POS' ? 'selected' : '' }}>POS</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-floating">
                                        <input type="date" name="from" value="{{$from}}" id="from_date"
                                            class="form-control">
                                        <label>{{ Helpers::translate('Start Date') }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 mt-2 mt-sm-0">
                                    <div class="form-floating">
                                        <input type="date" value="{{$to}}" name="to" id="to_date"
                                            class="form-control">
                                        <label>{{ Helpers::translate('End Date') }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 mt-2 mt-sm-0  ">
                                    <button type="submit" class="btn btn--primary btn-primary btn-block btn-filters-form" onclick="formUrlChange(this)" data-action="{{ url()->current() }}">
                                        {{\App\CPU\Helpers::translate('show data')}}
                                    </button>
                                </div>
                                @if(is_array($filters))
                                @foreach ($filters as $key=>$value)
                                    <input type="hidden" name="{{$key}}" value="{{$value}}">
                                @endforeach
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Order stats -->
                    @if($status == 'all' && $filter != 'POS')
                    <div class="row g-2 mb-2">
                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <!-- Card -->
                            <a class="order-stats order-stats_pending py-3 h-75 " href="{{route('admin.orders.list',['pending'])}}">
                                <div class="order-stats__content">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/pending.png')}}" class="svg" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('pending')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $pending_count }}
                                </span>
                            </a>
                            <!-- End Card -->
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <!-- Card -->
                            <a class="order-stats order-stats_confirmed py-3 h-75 " href="{{route('admin.orders.list',['confirmed'])}}">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/confirmed.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('confirmed')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $confirmed_count }}
                                </span>
                            </a>
                            <!-- End Card -->
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <!-- Card -->
                            <a class="order-stats order-stats_packaging py-3 h-75 " href="{{route('admin.orders.list',['processing'])}}">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/packaging.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('Packaging')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $processing_count }}
                                </span>
                            </a>
                            <!-- End Card -->
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <!-- Card -->
                            <a class="order-stats order-stats_out-for-delivery py-3 h-75" href="{{route('admin.orders.list',['out_for_delivery'])}}">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/out-of-delivery.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('out_for_delivery')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $out_for_delivery_count }}
                                </span>
                            </a>
                            <!-- End Card -->
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <div class="order-stats order-stats_delivered cursor-pointer py-3 h-75"
                                onclick="location.href='{{route('admin.orders.list',['delivered'])}}'">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/delivered.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('delivered')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $delivered_count }}
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <div class="order-stats order-stats_failed cursor-pointer py-3 h-75"
                                onclick="location.href='{{route('admin.orders.list',['failed'])}}'">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/failed-to-deliver.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('Failed_To_Delivery')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $failed_count }}
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <div class="order-stats order-stats_returned cursor-pointer py-3 h-75"
                                onclick="location.href='{{route('admin.orders.list',['returned'])}}'">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/returned.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('returned')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $returned_count }}
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                            <div class="order-stats order-stats_canceled cursor-pointer py-3 h-75"
                                onclick="location.href='{{route('admin.orders.list',['canceled'])}}'">
                                <div class="order-stats__content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                    <img width="20" src="{{asset('/public/assets/back-end/img/canceled.png')}}" alt="">
                                    <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('canceled')}}</h6>
                                </div>
                                <span class="order-stats__title">
                                    {{ $canceled_count }}
                                </span>
                            </div>
                        </div>

                    </div>
                    @endif
                    <!-- End Order stats -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="datatable r-r table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th></th>
                                    <th>{{\App\CPU\Helpers::translate('Order ID')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Order Date')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('order source')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('customer info')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Seller Information')}}</th>
                                    <th class="text-right">{{\App\CPU\Helpers::translate('Total Amount')}}</th>
                                    <th class="text-right">{{\App\CPU\Helpers::translate('shipping method')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('Order Status')}} </th>
                                    <th class="text-center actions-col">{{\App\CPU\Helpers::translate('Action')}}</th>
                                </tr>
                            </thead>
                            <thead class="theadF">
                                <tr>
                                    <th scope="">
                                        <input type="checkbox" class="selectAllRecords" onchange="checkAll_(event.target.checked)" />
                                    </th>
                                    <th class="theadFilter" field="id"></th>
                                    <th class="theadFilter" field="created_at"></th>
                                    <th class="theadFilter" field="ordered_using"></th>
                                    <th class="theadFilter" field="customer_id"></th>
                                    <th class="theadFilter" field="seller_is"></th>
                                    <th class="theadFilter d-flex" field="order_amount" style="flex-direction: row-reverse">
                                        <select name="payment_status" class="filter-custom form-control bg-white" style="max-width: 15px;padding: 10px">
                                            <option value=""></option>
                                            <option @if(($filters['payment_status'] ?? null) == "paid") selected @endif value="paid">
                                                {{\App\CPU\Helpers::translate('Paid')}}
                                            </option>
                                            <option @if(($filters['payment_status'] ?? null) == "unpaid") selected @endif value="unpaid">
                                                {{\App\CPU\Helpers::translate('Unpaid')}}
                                            </option>
                                        </select>
                                    </th>
                                    <th class="" field="shipping_method_id"></th>
                                    <th class="" field="order_status">
                                        <select name="order_status" class="filter-custom form-control bg-white">
                                            <option value=""></option>
                                            <option
                                                value="pending" {{($filters['order_status'] ?? null) == 'pending'?'selected':''}} > {{\App\CPU\Helpers::translate('Pending')}}</option>
                                            <option
                                                value="confirmed" {{($filters['order_status'] ?? null) == 'confirmed'?'selected':''}} > {{\App\CPU\Helpers::translate('Confirmed')}}</option>
                                            <option
                                                value="processing" {{($filters['order_status'] ?? null) == 'processing'?'selected':''}} >{{\App\CPU\Helpers::translate('Packaging')}} </option>
                                            <option class="text-capitalize"
                                                    value="out_for_delivery" {{($filters['order_status'] ?? null) == 'out_for_delivery'?'selected':''}} >{{\App\CPU\Helpers::translate('out_for_delivery')}} </option>
                                            <option
                                                value="delivered" {{($filters['order_status'] ?? null) == 'delivered'?'selected':''}} >{{\App\CPU\Helpers::translate('Delivered')}} </option>
                                            <option
                                                value="returned" {{($filters['order_status'] ?? null) == 'returned'?'selected':''}} > {{\App\CPU\Helpers::translate('Returned')}}</option>
                                            <option
                                                value="failed" {{($filters['order_status'] ?? null) == 'failed'?'selected':''}} >{{\App\CPU\Helpers::translate('Failed_to_Deliver')}} </option>
                                            <option
                                                value="canceled" {{($filters['order_status'] ?? null) == 'canceled'?'selected':''}} >{{\App\CPU\Helpers::translate('Canceled')}} </option>
                                        </select>
                                    </th>
                                    <th class="actions-col">
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            @include('admin-views.order.tr')
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->
                </div>
            </div>
            <!-- End Order States -->

            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal d-none">
                <span class="hs-nav-scroller-arrow-prev d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-left"></i>
                    </a>
                </span>

                <span class="hs-nav-scroller-arrow-next d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-right"></i>
                    </a>
                </span>

                <!-- Nav -->
                <ul class="nav nav-tabs lightSlider page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{\App\CPU\Helpers::translate('order_list')}}</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->
    </div>
@endsection

@push('script_2')
    <script>
        function filter_order() {
            $.get({
                url: '{{route('admin.orders.inhouse-order-filter')}}',
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    toastr.success('{{\App\CPU\Helpers::translate('order_filter_success')}}');
                    location.reload();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        };
    </script>
    <script>
        $('#from_date,#to_date').change(function () {
            let fr = $('#from_date').val();
            let to = $('#to_date').val();
            if(fr != ''){
                $('#to_date').attr('required','required');
            }
            if(to != ''){
                $('#from_date').attr('required','required');
            }
            if (fr != '' && to != '') {
                if (fr > to) {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    toastr.error('{{\App\CPU\Helpers::translate('Invalid date range')}}!', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }

        })
    </script>
    <script>
        var orderBy = 'id'
        var sortType = 'desc'
        var skip = 0;
        $(".dataTables_scrollBody").on("scroll",function(e){
            var ths = $(this);
            var tbody = $(this).find('tbody');
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop() <= elem.outerHeight()) {
                skip = skip + 10
                var s = table.state();
                s.skip = skip
                s.status = "{{$status}}"
                s._token = "{{ csrf_token() }}"
                var filters = new Object();
                @foreach ($filters as $k=>$f)
                filters['{{$k}}'] = "{{$f}}";
                @endforeach
                s.filters = filters
                s.filters.sortBy = $("#sortBy").val()
                s.filters.sortType = $("#sortType").val()
                $.ajax({
                    url:"{{route('admin.getTable',['limit'=>20,'skip'=>20,'table'=>'orders'])}}",
                    type: 'post',
                    data: s,
                    success:function(data){
                        $(data).appendTo(tbody);
                        if(allRecSelected){
                            checkAll_p(allRecSelected);
                        }
                    }
                })
            }
        })
        var clicked = false;
        $(document).on('mousedown','.sorting',function(){
            clicked = true;
        })

        $(".buttons-colvis:not(:first)").remove();

        $(document).on("click",".buttons-colvis",function(){
            $(".dt-button-collection")
            .appendTo("#colsMenu")
            .attr('style','top:65px')
        })

        table.on('order',function(e,t){
            if(clicked){
                sortType = t.aLastSort[0].dir
                sortBy = $('.theadF').find('th:eq('+t.aLastSort[0].col+')').attr('field');
                @foreach ($filters as $k=>$f)
                @if($f)
                    $(".filters-form").find("input[name='"+$(this).attr('name')+"']").remove();
                    $('<input name="{{$k}}" value="{{$f}}" type="hidden" />').appendTo(".filters-form");
                @endif
                @endforeach
                $(".filters-form").find("input[name='sortBy']").remove();
                $('<input name="sortBy" value="'+sortBy+'" type="hidden" />').appendTo(".filters-form");

                $(".filters-form").find("input[name='sortType']").remove();
                $('<input name="sortType" value="'+sortType+'" type="hidden" />').appendTo(".filters-form");

                $(".btn-filters-form").click();
            }
            @foreach ($filters as $key=>$value)
                $("input[name='{{$key}}']").val("{{$value}}");
            @endforeach
        })

        $(".filter-custom").change(function(){
            var namee = $(this).attr('name')
            $(".filters-form").find("input[name='"+namee+"']").remove();
            if($(this).val() !== ""){
                var a = $("<input name='"+namee+"' />").appendTo(".filters-form");
                a.attr('type','text');
                a.val($(this).val());
            }
            $(".btn-filters-form").click();
        })

        function checkAll_(checked){
            $(".trSelector").prop('checked',checked);
            if(checked){
                $('.ids').val("all")
                $("#table_selected").text("{{$allcount}}")
                $("tbody").find('tr').addClass('selected')
            }else{
                $('.ids').val("")
                $("#table_selected").text(0)
                $("tbody").find('tr').removeClass('selected')
            }
            if(checked){
                table.rows( ).select();
            }else{
                table.rows( ).deselect();
            }
        }

        function selectRange(){
            var from = $("#selectFrom").val();
            var to = $("#selectTo").val();
            var f = from;
            if(parseInt(from) > parseInt(to)){
                from = to;
                to = f;
            }
            for(let i = parseInt(from); i <= parseInt(to); i++){
                $("#order-"+i).prop('checked',true);
                $("#order-"+i).change();
                var tr = $("#order-"+i).closest('tr');
                table.rows(tr).select();
            }
        }
    </script>
@endpush
