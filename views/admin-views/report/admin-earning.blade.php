@extends('layouts.back-end.app')

@section('title', \Helpers::translate('Earning Report'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/earning_report.png')}}" alt="">
                {{\Helpers::translate('Earning_Reports')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.report.earning-report-inline-menu')
        <!-- End Inlile Menu -->

        <div class="card mb-2">
            <div class="card-body">
                <form action="" id="form-data" method="GET">
                    <h4 class="mb-3">{{ \Helpers::translate('Filter_Data')}}</h4>
                    <div class="row gy-3 gx-2 align-items-center text-left">
                        <div class="col-sm-6 col-md-3">
                            <select class="form-control __form-control" name="date_type" id="date_type">
                                <option value="this_year" {{ $date_type == 'this_year'? 'selected' : '' }}>{{\Helpers::translate('This_Year')}}</option>
                                <option value="this_month" {{ $date_type == 'this_month'? 'selected' : '' }}>{{\Helpers::translate('This_Month')}}</option>
                                <option value="this_week" {{ $date_type == 'this_week'? 'selected' : '' }}>{{\Helpers::translate('This_Week')}}</option>
                                <option value="custom_date" {{ $date_type == 'custom_date'? 'selected' : '' }}>{{\Helpers::translate('Custom_Date')}}</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3" id="from_div">
                            <div class="form-floating">
                                <input type="date" name="from" value="{{ $from }}" id="from_date" class="form-control">
                                <label>{{ \Helpers::translate('Start Date')}}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3" id="to_div">
                            <div class="form-floating">
                                <input type="date" value="{{ $to }}" name="to" id="to_date" class="form-control">
                                <label>{{ \Helpers::translate('End Date')}}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <button type="submit" class="btn btn--primary px-4 w-100">
                                {{ \Helpers::translate('Filter')}}
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
                        <h4 class="subtitle">{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($earning_data['total_earning_statistics']))) }}</h4>
                        <h6 class="subtext">{{ \Helpers::translate('Total Earnings')}}</h6>
                    </div>
                    <div class="coupon__discount w-100 text-right d-flex justify-content-between">
                        <div class="text-center">
                            <strong class="text-danger">{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($earning_data['total_commission'])) }}</strong>
                            <div>{{ \Helpers::translate('Commission')}}</div>
                        </div>
                        <div class="text-center">
                            <strong class="text-primary">{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($earning_data['total_inhouse_earning'])) }}</strong>
                            <div>{{ \Helpers::translate('In-House')}}</div>
                        </div>
                        <div class="text-center">
                            <strong class="text-success">{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($earning_data['total_shipping_earn'])) }}</strong>
                            <div>
                                {{ \Helpers::translate('Shipping')}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="{{asset('/public/assets/back-end/img/products.svg')}}" alt="">
                    <div class="info">
                        <h4 class="subtitle">{{ $earning_data['total_in_house_products'] }}</h4>
                        <h6 class="subtext">{{ \Helpers::translate('Total In-House Products')}}</h6>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="{{asset('/public/assets/back-end/img/stores.svg')}}" alt="">
                    <div class="info">
                        <h4 class="subtitle">{{ $earning_data['total_stores'] }}</h4>
                        <h6 class="subtext">{{ \Helpers::translate('Total_Shop')}}</h6>
                    </div>
                </div>
            </div>
            <div class="center-chart-area">
                <div class="center-chart-header">
                    <h3 class="title">{{ \Helpers::translate('Earning Statistics')}}</h3>
                </div>
                <canvas id="updatingData" class="store-center-chart"
                    data-hs-chartjs-options='{
                "type": "bar",
                "data": {
                  "labels": [{{ '"'.implode('","', array_keys($earning_data['total_earning_statistics'])).'"' }}],
                  "datasets": [
                  {
                    "label": "{{\Helpers::translate('Total Earnings')}}",
                    "data": [{{ '"'.implode('","', array_values($earning_data['total_earning_statistics'])).'"' }}],
                    "backgroundColor": "#a2ceee",
                    "hoverBackgroundColor": "#0177cd",
                    "borderColor": "#a2ceee"
                  }
                  ]
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
            <div class="right-content">
                <!-- Dognut Pie -->
                <div class="card h-100 bg-white payment-statistics-shadow">
                    <div class="card-header border-0 ">
                        <h5 class="card-title">
                            <span>{{ \Helpers::translate('Payment Statistics')}}</span>
                        </h5>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="position-relative pie-chart">
                            <div id="dognut-pie" class="label-hide"></div>
                            <!-- Total Orders -->
                            <div class="total--orders">
                                <h3>{{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['total_payment'])) }}</h3>
                                <span>{{ \Helpers::translate('Payments Amount')}}</span>
                            </div>
                            <!-- Total Orders -->
                        </div>
                        <div class="apex-legends m-1 w-100">
                            <div class="before-bg-004188">
                                <span>{{\Helpers::translate('cash_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['cash_payment'])) }})</span>
                            </div>
                            <div class="before-bg-0177CD">
                                <span>{{\Helpers::translate('digital_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['digital_payment'])) }}) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </div>
                            <div class="before-bg-A2CEEE">
                                <span>{{\Helpers::translate('Wallet_Payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['wallet_payment'])) }})</span>
                            </div>
                            <div class="before-bg-CDE6F5">
                                <span>{{\Helpers::translate('bank_tranfer_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['offline_payment'])) }})</span>
                            </div>
                            <div class="before-bg-AA4F34">
                                <span>{{\Helpers::translate('delayed_payments')}} ({{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($payment_data['delayed_payment'])) }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dognut Pie -->
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex flex-wrap w-100 gap-3 align-items-center">
                    <h4 class="mb-0 mr-auto">
                        {{\Helpers::translate('Total_Earnings')}}
                        <span class="badge badge-soft-dark radius-50 fz-12">{{ count($inhouse_earn) }}</span>
                    </h4>
                    <div>
                        <button type="button" class="btn btn-outline--primary text-nowrap btn-block"
                                data-toggle="dropdown">
                            <i class="tio-download-to"></i>
                            {{\Helpers::translate('Export')}}
                            <i class="tio-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.report.admin-earning-excel-export', ['date_type'=>$date_type, 'from'=>$from, 'to'=>$to]) }}">
                                    {{\Helpers::translate('Excel')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="datatable"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                        class="table __table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{\Helpers::translate('SL')}}</th>
                        <th>{{\Helpers::translate('Duration')}}</th>
                        <th>{{\Helpers::translate('In-House Earning')}}</th>
                        <th>{{\Helpers::translate('Commission Earning')}}</th>
                        <th>{{\Helpers::translate('Earn From Shipping')}}</th>
                        <th>{{\Helpers::translate('Discount Given')}}</th>
                        <th>{{\Helpers::translate('VAT/TAX')}}</th>
                        <th>{{\Helpers::translate('Refund Given')}}</th>
                        <th>{{\Helpers::translate('Total Earning')}}</th>
                        <th class="text-center">{{\Helpers::translate('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($inhouse_earn as $key=>$earning)
                        @php($inhouse_earning = $earning+$discount_given[$key]-$total_tax[$key])
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ Helpers::translate($key) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($inhouse_earning)) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($admin_commission_earn[$key])) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($shipping_earn[$key])) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($discount_given[$key])) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total_tax[$key])) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($refund_given[$key])) }}</td>
                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($inhouse_earning+$admin_commission_earn[$key]+$total_tax[$key]+$shipping_earn[$key]-$discount_given[$key]-$refund_given[$key])) }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('admin.report.admin-earning-duration-download-pdf') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="duration" value="{{ $key }}">
                                        <input type="hidden" name="inhouse_earning" value="{{ $inhouse_earning }}">
                                        <input type="hidden" name="admin_commission" value="{{ $admin_commission_earn[$key] }}">
                                        <input type="hidden" name="shipping_earn" value="{{ $shipping_earn[$key] }}">
                                        <input type="hidden" name="discount_given" value="{{ $discount_given[$key] }}">
                                        <input type="hidden" name="total_tax" value="{{ $total_tax[$key] }}">
                                        <input type="hidden" name="refund_given" value="{{ $refund_given[$key] }}">
                                        <input type="hidden" name="total_earning" value="{{ $inhouse_earning+$admin_commission_earn[$key]+$shipping_earn[$key]+$total_tax[$key]-$discount_given[$key]-$refund_given[$key] }}">
                                        <button type="submit" class="btn btn-outline-success square-btn btn-sm"><i class="tio-download-to"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($inhouse_earn)==0)
                        <tr>
                            <td colspan="9">
                                <div class="text-center p-4">
                                    <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                         alt="Image Description">
                                    <p class="mb-0">{{ \Helpers::translate('No_data_to_show')}}</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush

@push('script_2')

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



    <!-- Dognut Pie Chart -->
    <script>
        var options = {
            series: [
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['cash_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['digital_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['wallet_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['offline_payment']) }},
                {{ \App\CPU\BackEndHelper::usd_to_currency($payment_data['delayed_payment']) }},
            ],

            chart: {
                width: 320,
                type: 'donut',
            },
            labels: [
                '{{\Helpers::translate('Cash_Payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['cash_payment'])) }})',
                '{{\Helpers::translate('Digital_Payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['digital_payment'])) }})',
                '{{\Helpers::translate('Wallet_Payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['wallet_payment'])) }})',
                '{{\Helpers::translate('bank_tranfer_payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['offline_payment'])) }})',
                '{{\Helpers::translate('delayed_payments')}} ({{ \App\CPU\BackEndHelper::currency_symbol() }}{{ \App\CPU\BackEndHelper::format_currency(\App\CPU\BackEndHelper::usd_to_currency($payment_data['delayed_payment'])) }})',
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

