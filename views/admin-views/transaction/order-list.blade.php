@extends('layouts.back-end.app')

@section('title', Helpers::translate('Order_Transactions'))

@section('content')
    <div class="content container-fluid ">
        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/order_report.png')}}" alt="">
                {{Helpers::translate('transaction_report')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.report.transaction-report-inline-menu')
        <!-- End Inlile Menu -->
        <div class="card mb-2">
            <div class="card-body">
                <h4 class="mb-3">{{Helpers::translate('Filter_Data')}}</h4>
                <form action="#" id="form-data" method="GET" class="w-100">
                    <div class="row  gx-2 gy-3 align-items-center text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        <div class="col-sm-6 col-md-3">
                            <div class="">
                                <select class="form-control __form-control" name="status">
                                    <option class="text-center" value="0" disabled>
                                        ---{{Helpers::translate('select_status')}}---
                                    </option>
                                    <option class="text-capitalize"
                                            value="all" {{ $status == 'all'? 'selected' : '' }} >{{Helpers::translate('all_status')}} </option>
                                    <option class="text-capitalize"
                                            value="disburse" {{ $status == 'disburse'? 'selected' : '' }} >{{Helpers::translate('paid')}} </option>
                                    <option class="text-capitalize"
                                            value="hold" {{ $status == 'hold'? 'selected' : '' }}>{{Helpers::translate('unpaid')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="">
                                <select class="js-select2-custom form-control __form-control" name="seller_id">
                                    <option class="text-center" value="all" {{ $seller_id == 'all' ? 'selected' : '' }}>
                                        {{Helpers::translate('all')}}
                                    </option>
                                    <option class="text-center" value="inhouse" {{ $seller_id == 'inhouse' ? 'selected' : '' }}>
                                        {{Helpers::translate('inhouse')}}
                                    </option>
                                    @foreach($sellers as $seller)
                                        <option class="text-left text-capitalize"
                                                value="{{ $seller->id }}" {{ $seller->id == $seller_id ? 'selected' : '' }}>
                                            {{ $seller->shop['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="">
                                <select class="js-select2-custom form-control __form-control" name="customer_id">
                                    <option class="text-center" value="all" {{ $customer_id == 'all' ? 'selected' : '' }}>
                                        {{Helpers::translate('all_customer')}}
                                    </option>
                                    @foreach($customers as $customer)
                                        <option class="text-left text-capitalize"
                                                value="{{ $customer->id }}" {{ $customer->id == $customer_id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <select class="form-control __form-control" name="date_type" id="date_type">
                                <option value="this_year" {{ $date_type == 'this_year'? 'selected' : '' }}>{{Helpers::translate('This_Year')}}</option>
                                <option value="this_month" {{ $date_type == 'this_month'? 'selected' : '' }}>{{Helpers::translate('This_Month')}}</option>
                                <option value="this_week" {{ $date_type == 'this_week'? 'selected' : '' }}>{{Helpers::translate('This_Week')}}</option>
                                <option value="custom_date" {{ $date_type == 'custom_date'? 'selected' : '' }}>{{Helpers::translate('Custom_Date')}}</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3" id="from_div">
                            <div class="form-floating">
                                <input type="date" name="from" value="{{$from}}" id="from_date" class="form-control __form-control">
                                <label>{{Helpers::translate('start_date')}}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3" id="to_div">
                            <div class="form-floating">
                                <input type="date" value="{{$to}}" name="to" id="to_date" class="form-control __form-control">
                                <label>{{Helpers::translate('end_date')}}</label>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end gap-2 pt-0">
                            <button type="submit" class="btn btn--primary px-4 min-w-120 __h-45px" onclick="formUrlChange(this)"
                                    data-action="{{ url()->current() }}">
                                {{Helpers::translate('filter')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="store-report-content mb-2">
            <div class="left-content">
                <div class="left-content-card">
                    <img src="{{asset('/public/assets/back-end/img/cart.svg')}}" alt="">
                    <div class="info">
                        <h4 class="subtitle">{{ $order_data['total_orders'] }}</h4>
                        <h6 class="subtext">{{Helpers::translate('Total Orders')}}</h6>
                    </div>
                    <div class="coupon__discount w-100 text-right d-flex justify-content-between">
                        <div class="text-center">
                            <strong class="text-primary">{{ $order_data['in_house_orders'] }}</strong>
                            <div class="d-flex">
                                <span>{{Helpers::translate('In-House Orders')}}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <strong class="text-success">{{ $order_data['seller_orders'] }}</strong>
                            <div class="d-flex">
                                <span>{{Helpers::translate('Seller Orders')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="{{asset('/public/assets/back-end/img/products.svg')}}" alt="">
                    <div class="coupon__discount w-100 text-right d-flex justify-content-between">
                        <div class="text-center">
                            <strong class="text-primary">{{ $order_data['total_in_house_products'] }}</strong>
                            <div class="d-flex">
                                <span>{{Helpers::translate('In-House Products')}}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <strong class="text-success">{{ $order_data['total_seller_products'] }}</strong>
                            <div class="d-flex">
                                <span>{{Helpers::translate('Seller Products')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="{{asset('/public/assets/back-end/img/stores.svg')}}" alt="">
                    <div class="info">
                        <h4 class="subtitle">{{ $order_data['total_stores'] }}</h4>
                        <h6 class="subtext">{{Helpers::translate('Total Stores')}}</h6>
                    </div>
                </div>
            </div>
            @if (1==1)
            <div class="center-chart-area">
                <div class="center-chart-header">
                    <h3 class="title">{{Helpers::translate('Order Statistics')}}</h3>
                </div>
                <canvas id="updatingData" class="store-center-chart"
                        data-hs-chartjs-options='{
                "type": "bar",
                "data": {
                  "labels": [{{ '"'.implode('","', array_keys($order_transaction_chart['order_amount'])).'"' }}],
                  "datasets": [{
                    "label": "{{Helpers::translate('total_order_amount')}}",
                    "data": [{{ '"'.implode('","', array_values($order_transaction_chart['order_amount'])).'"' }}],
                    "backgroundColor": "#a2ceee",
                    "hoverBackgroundColor": "#0177cd",
                    "borderColor": "#a2ceee"
                  }]
                },
                "options": {
                  "scales": {
                    "yAxes": [{
                      "gridLines": {
                        "color": "#e7eaf3",
                        "drawBorder": false,
                        "zeroLineColor": "#e7eaf3"
                      },
                      "ticks": {
                        "beginAtZero": true,
                        "fontSize": 12,
                        "fontColor": "#97a4af",
                        "fontFamily": "Open Sans, sans-serif",
                        "padding": 5,
                        "postfix": " {{ \App\CPU\BackEndHelper::currency_symbol() }}"
                      }
                    }],
                    "xAxes": [{
                      "gridLines": {
                        "display": false,
                        "drawBorder": false
                      },
                      "ticks": {
                        "fontSize": 12,
                        "fontColor": "#97a4af",
                        "fontFamily": "Open Sans, sans-serif",
                        "padding": 5
                      },
                      "categoryPercentage": 0.3,
                      "maxBarThickness": "10"
                    }]
                  },
                  "cornerRadius": 5,
                  "tooltips": {
                    "prefix": " ",
                    "hasIndicator": true,
                    "mode": "index",
                    "intersect": false
                  },
                  "hover": {
                    "mode": "nearest",
                    "intersect": true
                  }
                }
              }'>
                </canvas>
            </div>
            @endif
            <div class="right-content">
                <!-- Dognut Pie -->
                <div class="card h-100 bg-white payment-statistics-shadow">
                    <div class="card-header border-0 ">
                        <h5 class="card-title">
                            <span>{{Helpers::translate('Payment Statistics')}}</span>
                        </h5>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="position-relative pie-chart">
                            <div id="dognut-pie" class="label-hide"></div>
                            <!-- Total Orders -->
                            <div class="total--orders">
                                <h3>{{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['total_payment'])) }}</h3>
                                <span>{{Helpers::translate('completed')}} {{Helpers::translate('payments')}}</span>
                            </div>
                            <!-- Total Orders -->
                        </div>
                        <div class="apex-legends">
                            <div class="before-bg-004188">
                                <span>{{Helpers::translate('cash_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['cash_payment'])) }})</span>
                            </div>
                            <div class="before-bg-0177CD">
                                <span>{{Helpers::translate('digital_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['digital_payment'])) }}) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </div>
                            <div class="before-bg-A2CEEE">
                                <span>{{Helpers::translate('wallet')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['wallet_payment'])) }})</span>
                            </div>
                            <div class="before-bg-CDE6F5">
                                <span>{{Helpers::translate('bank_tranfer_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['offline_payment'])) }})</span>
                            </div>
                            <div class="before-bg-AA4F34">
                                <span>{{Helpers::translate('delayed_payment')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['delayed_payment'])) }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dognut Pie -->
            </div>
        </div>
        <div class="card">
            <div class="px-3 py-4">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <h4 class="mb-0 mr-auto">
                        {{Helpers::translate('Total Transactions')}}
                        <span class="badge badge-soft-dark radius-50 fz-12">{{ $transactions->total() }}</span>
                    </h4>
                    <form action="{{ url()->full() }}" method="GET" class="mb-0">
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-custom">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input type="hidden" name="date_type" value="{{ $date_type }}">
                            <input type="hidden" name="from" value="{{ $from }}">
                            <input type="hidden" name="to" value="{{ $to }}">
                            <input type="hidden" name="seller_id" value="{{ $seller_id }}">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                   placeholder="{{ Helpers::translate('Search by orders id')}}"
                                   aria-label="Search orders"
                                   value="{{ $search }}"
                                   required>
                            <button type="submit" class="btn btn--primary">{{ Helpers::translate('search')}}</button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <div>
                        <a href="{{ route('admin.transaction.order-transaction-summary-pdf', ['date_type'=>request('date_type'), 'seller_id'=>request('seller_id'), 'customer_id'=>request('customer_id'), 'status'=>request('status'), 'from'=>request('from'), 'to'=>request('to')]) }}" class="btn btn-outline--primary text-nowrap btn-block">
                            <i class="tio-file-text"></i>
                            {{Helpers::translate('Download PDF')}}
                        </a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline--primary text-nowrap btn-block"
                                data-toggle="dropdown">
                            <i class="tio-download-to"></i>
                            {{Helpers::translate('export')}}
                            <i class="tio-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('admin.transaction.order-transaction-export-excel', ['date_type'=>request('date_type'), 'seller_id'=>request('seller_id'), 'customer_id'=>request('customer_id'), 'status'=>request('status'), 'from'=>request('from'), 'to'=>request('to')]) }}"  >{{Helpers::translate('Excel')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="datatable"
                       style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 __table">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{Helpers::translate('SL')}}</th>
                        <th>{{Helpers::translate('order_id')}}</th>
                        <th>{{Helpers::translate('shop_name')}}</th>
                        <th>{{Helpers::translate('customer_name')}}</th>
                        <th>{{Helpers::translate('total_product_amount')}}</th>
                        <th>{{Helpers::translate('product_discount')}}</th>
                        <th>{{Helpers::translate('coupon_discount')}}</th>
                        <th>{{Helpers::translate('discounted_amount')}}</th>
                        <th>{{Helpers::translate('VAT/TAX')}}</th>
                        <th>{{Helpers::translate('shipping_charge')}}</th>
                        <th>{{Helpers::translate('order_amount')}}</th>
                        <th>{{Helpers::translate('delivered_by')}}</th>
                        <th>{{Helpers::translate('admin_discount')}}</th>
                        <th>{{ Helpers::translate('seller_discount') }}</th>
                        <th>{{ Helpers::translate('admin_commission') }}</th>
                        <th>{{Helpers::translate('admin_net_income')}}</th>
                        <th>{{Helpers::translate('seller_net_income')}}</th>
                        <th>{{Helpers::translate('payment_method')}}</th>
                        <th>{{Helpers::translate('Payment Status')}}</th>
                        <th class="text-center">{{Helpers::translate('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $key=>$transaction)
                    @if(isset($transaction->order_details[0]))
                        <tr>
                            <td>{{$transactions->firstItem()+$key}}</td>
                            <td>
                                <a class="title-color" href="{{route('admin.orders.details',['id'=>$transaction['order_id']])}}">{{$transaction['order_id']}}</a>
                            </td>
                            <td>
                                @if($transaction['seller_is'] == 'admin')
                                    {{ \App\CPU\Helpers::get_business_settings('company_name') }}
                                @else
                                    @if (isset($transaction->seller->shop))
                                        {{ $transaction->seller->shop->name }}
                                    @else
                                        {{Helpers::translate('not_found')}}
                                    @endif
                                @endif

                            </td>
                            <td>
                                @if (isset($transaction->customer))
                                    <a href="{{route('admin.customer.view',[$transaction->customer['id']])}}"
                                       class="title-color hover-c1 d-flex align-items-center gap-10">
                                        {{ $transaction->customer->name }}
                                    </a>
                                @else
                                    {{Helpers::translate('not_found')}}
                                @endif
                            </td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction->order_details[0]->order_details_sum_price)) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction->order_details[0]->order_details_sum_discount))}}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction->order->discount_amount ?? 0)) }}</td>
                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction->order_details[0]->order_details_sum_price - $transaction->order_details[0]->order_details_sum_discount - ($transaction->order->discount_amount ?? 0)))}}</td>                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['tax']))}}</td>
                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['delivery_charge']))}}</td>
                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction->order->order_amount ?? 0))}}</td>
                            <td>{{$transaction['delivered_by']}}</td>
                            <td>
                                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency((($transaction->order->coupon_discount_bearer ?? null) == 'inhouse' && $transaction->order->discount_type == 'coupon_discount') ? ($transaction->order->discount_amount ?? '') : 0 )) }}
                            </td>
                            <td>
                                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency((($transaction->order->coupon_discount_bearer ?? null) == 'seller' && $transaction->order->discount_type == 'coupon_discount') ? ($transaction->order->discount_amount ?? '') : 0 )) }}
                            </td>
                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['admin_commission']))}}</td>
                            <td>
                                <?php
                                    $admin_net_income = 0;
                                    if($transaction['seller_is'] == 'admin'){
                                        $admin_net_income += $transaction['order_amount'] + $transaction['tax'];
                                    }
                                    if(isset($transaction->order->delivery_man) && ($transaction->order->delivery_man->seller_id ?? 0) == '0'){
                                        $admin_net_income += $transaction['delivery_charge'];
                                    }
                                    $admin_net_income += $transaction['admin_commission'];
                                ?>
                                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($admin_net_income)) }}
                            </td>
                            <td>
                                <?php
                                    $seller_net_income = 0;
                                    if(isset($transaction->order) && isset($transaction->order->delivery_man) && ($transaction->order->delivery_man->seller_id ?? 0) != '0'){
                                        $seller_net_income += $transaction['delivery_charge'];
                                    }

                                    $coupon_discount_seller = ($transaction['order']['coupon_discount_bearer'] ?? 0) == 'seller' ? ($transaction['order']['discount_amount'] ?? 0) : 0;
                                    if($transaction['seller_is'] == 'seller'){
                                        $seller_net_income += ($transaction['order_amount'] + $transaction['tax'] - $transaction['admin_commission'] - $coupon_discount_seller);
                                    }
                                ?>
                                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller_net_income)) }}
                            </td>
                            <td>{{Helpers::translate($transaction['payment_method'])}}</td>
                            <td>
                                <div class="text-center">
                                    <span class="badge {{ $transaction['status'] == 'disburse' ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                        {{Helpers::translate(str_replace('_',' ',$transaction['status']))}}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.transaction.pdf-order-wise-transaction', ['order_id'=>($transaction->order_id)]) }}" class="btn btn-outline-success square-btn btn-sm">
                                        <i class="tio-download-to"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
                @if(count($transactions)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                             alt="Image Description">
                        <p class="mb-0">{{ Helpers::translate('No_data_to_show')}}</p>
                    </div>
                @endif
            </div>

            <div class="table-responsive mt-4">
                <div class="px-4 d-flex justify-content-lg-end">
                    <!-- Pagination -->
                    {{$transactions->links()}}
                </div>
            </div>

        </div>

    </div>
@endsection

@push('script')
<!-- Chart JS -->
    <script src="{{ asset('public/assets/back-end') }}/js/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/js/chart.js.extensions/chartjs-extensions.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/js/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js">
    </script>
<!-- Chart JS -->

    <!-- Apex Charts -->
    <script src="{{ asset('/public/assets/back-end/js/apexcharts.js') }}"></script>
    <!-- Apex Charts -->

    <script>
        $(document).ready(function () {
            $('.js-select2-custom').select2();
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
                    toastr.error('Invalid date range!', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }

        })

        $("#date_type").change(function() {
            let val = $(this).val();
            $('#from_div').toggle(val === 'custom_date');
            $('#to_div').toggle(val === 'custom_date');

            if(val === 'custom_date'){
                $('#from_date').attr('required','required');
                $('#to_date').attr('required','required');
            }else{
                $('#from_date').val(null).removeAttr('required')
                $('#to_date').val(null).removeAttr('required')
            }
        }).change();


    </script>



@endpush


@push('script_2')
    <!-- Dognut Pie Chart -->
    <script>
        var options = {
            series: [
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['digital_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['cash_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['wallet_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['offline_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['delayed_payment']) }},
            ],
            chart: {
                width: 320,
                type: 'donut',
            },
            labels: [
                '{{Helpers::translate('Cash_Payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['cash_payment'])) }})',
                '{{Helpers::translate('Digital_Payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['digital_payment'])) }})',
                '{{Helpers::translate('Wallet_Payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['wallet_payment'])) }})',
                '{{Helpers::translate('bank_tranfer_payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['offline_payment'])) }})',
                '{{Helpers::translate('delayed_payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['delayed_payment'])) }})',
            ],
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#004188', '#004188', '#004188', '#7b94a4','#aa4f34']
                }
            },
            responsive: [{
                breakpoint: 1650,
                options: {
                    chart: {
                        width: 260
                    },
                }
            }],
            colors: ['#004188', '#0177CD', '#0177CD', '#7b94a4','#aa4f34'],
            fill: {
                colors: ['#004188', '#A2CEEE', '#0177CD', '#7b94a4','#aa4f34']
            },
            legend: {
                show: false
            },
        };

        var chart = new ApexCharts(document.querySelector("#dognut-pie"), options);
        chart.render();
    </script>
    <!-- Dognut Pie Chart -->




    <script>
        // Bar Charts
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function() {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ url('/') }}/admin/store/get-stores',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        // all:true,
                        @if (isset($zone))
                            zone_ids: [{{ $zone->id }}],
                        @endif
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });


    </script>


@endpush
