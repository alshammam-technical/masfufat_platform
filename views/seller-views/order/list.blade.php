@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\Helpers::translate('Order List'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->

    <div class="content container-fluid">
        <!-- Page Title -->
            <div class="col-lg-5 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
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
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0">
                <img src="{{asset('/public/assets/back-end/img/all-orders.png')}}" class="mb-1 mr-1" alt="">
                <span class="page-header-title">
                    @if($status =='processing')
                        {{ ucwords(str_replace('_',' ','Packaging' )) }}
                    @elseif($status =='failed')
                        {{ ucwords(str_replace('_',' ','Failed to Deliver' )) }}
                    @else
                        {{ ucwords(str_replace('_',' ',$status )) }}
                    @endif
                </span>
                {{\App\CPU\Helpers::translate('Orders')}}
            </h2>
            <span class="badge badge-soft-dark radius-50 fz-14">{{$orders->total()}}</span>
        </div>

        <div class="card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url()->current() }}" id="form-data" method="GET">
                        <div class="row gy-3 gx-2">
                            <div class="col-12 pb-0">
                                <h4>{{\App\CPU\Helpers::translate('select date range')}}</h4>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <select name="filter" class="form-control">
                                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>{{\App\CPU\Helpers::translate('All')}}</option>
                                    @if ($seller_pos == 1 && $seller->pos_status == 1 && ($status == 'all' || $status == 'delivered'))
                                    <option value="POS" {{ $filter == 'POS' ? 'selected' : '' }}>{{\App\CPU\Helpers::translate('POS')}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-floating">
                                    <input type="date" name="from" value="{{$from}}" id="from_date"
                                        class="form-control">
                                    <label>{{\App\CPU\Helpers::translate('Start Date')}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-floating">
                                    <input type="date" value="{{$to}}" name="to" id="to_date"
                                        class="form-control">
                                    <label>{{\App\CPU\Helpers::translate('End Date')}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <button type="submit" class="btn btn--primary btn-primary btn-block">
                                    {{\App\CPU\Helpers::translate('show data')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                @if($status == 'all' && $filter != 'POS')
                <div class="row g-2 mb-20">
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_pending" href="{{route('seller.orders.list', ['pending', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/pending.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('pending')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $pending }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_confirmed" href="{{route('seller.orders.list', ['confirmed', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/confirmed.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('confirmed')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $confirmed }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_packaging" href="{{route('seller.orders.list', ['processing', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/packaging.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('Packaging')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $processing }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_out-for-delivery" href="{{route('seller.orders.list', ['out_for_delivery', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/out-of-delivery.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('out_for_delivery')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $out_for_delivery }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_delivered" href="{{route('seller.orders.list', ['delivered', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/delivered.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('delivered')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $delivered }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_canceled" href="{{route('seller.orders.list', ['canceled', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/canceled.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('canceled')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $canceled }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_returned" href="{{route('seller.orders.list', ['returned', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/returned.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('returned')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $returned }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <!-- Order Stats -->
                        <a class="order-stats order-stats_failed" href="{{route('seller.orders.list', ['failed', 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search])}}">
                            <div class="order-stats__content">
                                <img width="20" src="{{asset('/public/assets/back-end/img/failed-to-deliver.png')}}" alt="">
                                <h6 class="order-stats__subtitle">{{\App\CPU\Helpers::translate('failed_to_deliver')}}</h6>
                            </div>
                            <span class="order-stats__title">
                                {{ $failed }}
                            </span>
                        </a>
                        <!-- End Order Stats -->
                    </div>
                </div>
                @endif

                <!-- Data Table Top -->
                <div class="px-3 py-4 light-bg">
                    <div class="row g-2 flex-grow-1">
                        <div class="col-sm-8 col-md-6 col-lg-4">
                            <form action="{{ url()->current() }}" method="GET">
                                <!-- Search -->
                                <div class="input-group input-group-merge input-group-custom">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{\App\CPU\Helpers::translate('search_orders')}}" aria-label="Search orders" value="{{ $search }}" required>
                                    <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>
                        <div class="col-sm-4 col-md-6 col-lg-8 d-flex justify-content-sm-end">
                            <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{\App\CPU\Helpers::translate('export')}}
                                <i class="tio-chevron-down"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-item" href="{{ route('seller.orders.order-bulk-export', ['status' => $status, 'from' => $from, 'to' => $to, 'filter' => $filter, 'search' => $search]) }}">
                                        <img width="14" src="{{asset('/public/assets/back-end/img/excel.png')}}" alt="">
                                        {{\App\CPU\Helpers::translate('Excel')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Data Table Top -->

                <div class="table-responsive">
                    <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th class="text-capitalize">{{\App\CPU\Helpers::translate('SL')}}</th>
                                <th class="text-capitalize">{{\App\CPU\Helpers::translate('Order_ID')}}</th>
                                <th class="text-capitalize">{{\App\CPU\Helpers::translate('Order_Date')}}</th>
                                <th class="text-capitalize">{{\App\CPU\Helpers::translate('customer_info')}}</th>
                                <th class="text-capitalize">{{\App\CPU\Helpers::translate('Total_amount')}}</th>
                                <th class="text-capitalize">{{\App\CPU\Helpers::translate('Order_Status')}} </th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $k=>$order)
                            <tr>
                                <td>
                                    {{$orders->firstItem()+$k}}
                                </td>
                                <td>
                                    <a  class="title-color hover-c1" href="{{route('seller.orders.details',$order['id'])}}">{{$order['id']}}</a>
                                </td>
                                <td>
                                    <div>{{date('d M Y',strtotime($order['created_at']))}}</div>
                                    <div>{{date('H:i A',strtotime($order['created_at']))}}</div>
                                </td>
                                <td>
                                    @if($order->customer_id == 0)
                                        <strong class="title-name">Walking customer</strong>
                                    @else
                                        <div>{{$order->customer ? $order->customer['f_name'].' '.$order->customer['l_name'] : 'Customer Data not found'}}</div>
                                        <a class="d-block title-color" href="tel:{{ $order->customer ? $order->customer->phone : '' }}">{{ $order->customer ? $order->customer->phone : '' }}</a>
                                    @endif
                                </td>
                                <td>
                                    <div>{{\App\CPU\BackEndHelper::set_symbol(($order->order_amount))}}</div>

                                    @if($order->payment_status=='paid')
                                        <span class="badge badge-soft-success">{{\App\CPU\Helpers::translate('paid')}}</span>
                                    @else
                                        <span class="badge badge-soft-danger">{{\App\CPU\Helpers::translate('unpaid')}}</span>
                                    @endif
                                    </td>
                                    <td class="text-capitalize ">
                                        @if($order->order_status=='pending')
                                            <label
                                                class="badge badge-soft-primary">{{$order['order_status']}}</label>
                                        @elseif($order->order_status=='processing' || $order->order_status=='out_for_delivery')
                                            <label
                                                class="badge badge-soft-warning">{{str_replace('_',' ',$order['order_status'] == 'processing' ? 'packaging' : $order['order_status'])}}</label>
                                        @elseif($order->order_status=='delivered' || $order->order_status=='confirmed')
                                            <label
                                                class="badge badge-soft-success">{{$order['order_status']}}</label>
                                        @elseif($order->order_status=='returned')
                                            <label
                                                class="badge badge-soft-danger">{{$order['order_status']}}</label>
                                        @elseif($order['order_status']=='failed')
                                            <span class="badge badge-danger fz-12">
                                                {{$order['order_status'] == 'failed' ? 'Failed To Deliver' : ''}}
                                            </span>
                                        @else
                                            <label
                                                class="badge badge-soft-danger">{{$order['order_status']}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a  class="btn btn-outline--primary btn-sm square-btn"
                                                title="{{\App\CPU\Helpers::translate('view')}}"
                                                href="{{route('seller.orders.details',[$order['id']])}}">
                                                <i class="tio-invisible"></i>

                                            </a>
                                            <a  class="btn btn-outline-info btn-sm square-btn" target="_blank"
                                                title="{{\App\CPU\Helpers::translate('invoice')}}"
                                                href="{{route('seller.orders.generate-invoice',[$order['id']])}}">
                                                <i class="tio-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-responsive mt-4">
                    <div class="d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {{$orders->links()}}
                    </div>
                </div>
                <!-- End Pagination -->

                @if(count($orders)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                        <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

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
@endpush
