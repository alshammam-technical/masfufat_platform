@extends('layouts.front-end.app',['hide_all'=>true])

@section('title',\App\CPU\Helpers::translate('My Order List'))

@push('css_or_js')
    <style>
        .cansl{
            margin-left: -50px;
        }

        .tooltiptext {
            width: 250px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;

            /* تحديد الموقع بالنسبة للعنصر الأصل */
            position: absolute;
            z-index: 101;
            left: 50%;
            margin-left: -125px; /* نصف عرض الtooltip للمحافظة على التوسيط */
        }



        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
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
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border- {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
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

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }

        body{
            display: none;
        }

        .table{
            display: block !important;
        }

        thead, tbody{
            width: 100%;
            display: inline-table;
        }

        td,th{
            width: 14%;
        }
    </style>

    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
            background-color: white !important;
        }

        #main{
            margin: 0px !important;
            width: 100%;
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
            background-color: white;
            border: white;
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

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }

        tbody {
        display: block;
        overflow-y: auto;
        height: 500px;
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

        td,th{
            width: 11%;
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
        .badge-confirmed{
            padding: 15px !important;
            color: black;
            background-color: #FDCD05;
        }
        .badge-processing{
            padding: 15px !important;
            color: white;
            background-color: #259F00;
        }
        .badge-out_for_delivery{
            padding: 15px !important;
            color: white;
            background-color: #646AFF;
        }
        .badge-delivered{
            padding: 15px !important;
            color: white;
            background-color: #259F00;
        }
        .badge-returned{
            padding: 15px !important;
            color: white;
            background-color: #FF000F;
        }
        .badge-failed{
            padding: 15px !important;
            color: white;
            background-color: #FF000F;
        }
        .badge-canceled{
            padding: 15px !important;
            color: white;
            background-color: #FF000F;
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
    </style>
@endpush

@section('content')


    <!-- Page Content-->
    <div style="overflow: auto;border-radius: 11px">
        <table class="table">
            <thead>
            <tr style="background-color: #F8F8F8;">
                <td class="tdBorder">
                    <div class="py-2"><span
                            class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('Order#')}}</span></div>
                </td>

                <td class="tdBorder orderDate">
                    <div class="py-2"><span
                            class="d-block spandHeadO">{{\App\CPU\Helpers::translate('Order Date')}}</span>
                    </div>
                </td>
                <td class="tdBorder">
                    <div class="py-2"><span
                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('Status')}}</span></div>
                </td>
                <td class="tdBorder hidden sm:table-cell">
                    <div class="py-2"><span
                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('Total')}}</span></div>
                </td>
                <td class="tdBorder">
                    <div class="py-2"><span
                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('action')}}</span></div>
                </td>
            </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="bodytr font-weight-bold">
                        {{$order['id']}}
                        <a class="btn btn-primary" onclick="copyToClipboard({{$order['id']}})"> <i class="fa fa-copy"></i> </a>
                    </td>
                    <td class="bodytr orderDate"><span class="">{{$order['created_at']}}</span></td>
                    <td class="bodytr">
                        @if($order['order_status']=='failed' || $order['order_status']=='canceled')
                            <span class="badge badge-{{$order['order_status']}} text-capitalize">
                                {{\App\CPU\Helpers::translate($order['order_status'] =='failed' ? 'Failed To Deliver' : $order['order_status'])}}
                            </span>
                            @isset($order['admin_note'])
                            <span class="tooltip-info bg-secondary cansl py-2 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}">
                                <i class="fa fa-info mx-3"></i>
                            </span>
                            <div class="tooltip-custom relative">
                                <span class="tooltiptext" style="display: none">{{ $order['admin_note'] }}</span>
                            </div>
                            @endisset

                        @elseif($order['order_status']=='confirmed' || $order['order_status']=='processing' || $order['order_status']=='delivered')
                            <span class="badge badge-{{$order['order_status']}} text-capitalize">
                                {{\App\CPU\Helpers::translate($order['order_status']=='processing' ? 'packaging' : $order['order_status'])}}
                            </span>
                        @else
                            <span class="badge badge-{{$order['order_status']}} text-capitalize">
                                {{\App\CPU\Helpers::translate($order['order_status'])}}
                            </span>
                        @endif
                    </td>
                    <td class="bodytr hidden sm:table-cell">
                        @if(App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id !== $order->id)
                        {{ \App\CPU\Helpers::currency_converter(Helpers::get_order_totals($order)['total_amount'] - ($order['shipping_cost'] + ($order['shipping_tax'] * ($order['shipping_cost']/100)))) }}
                        @else
                        {{ \App\CPU\Helpers::currency_converter(Helpers::get_order_totals($order)['total']) }}
                        @endif
                    </td>
                    <td class="bodytr">
                        <div class="d-flex w-full justify-content-center">
                            @if (\App\CPU\Helpers::store_module_permission_check('order.details.view'))
                            <a target="_parent" href="{{ route('account-order-details', ['id'=>$order->id]) }}"
                                class="p-2 mt-2">
                                <i class="fa fa-eye text-info"></i>
                            </a>
                            @endif
                            @if($order['payment_method']=='cash_on_delivery' && $order['order_status']=='pending')
                            @if (\App\CPU\Helpers::store_module_permission_check('order.direct.delete'))

                                <a href="javascript:"
                                    onclick="route_alert('{{ route('order-cancel',[$order->id]) }}','{{\App\CPU\Helpers::translate('want_to_cancel_this_order?')}}')"
                                    class="p-2 top-margin">
                                    <i class="ri-delete-bin-5-fill text-danger"></i>
                                </a>
                            @endif
                            @else

                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($orders->count()==0)
            <center class="mt-3 mb-2">{{\App\CPU\Helpers::translate('no_order_found')}}</center>
        @endif

        <div class="card-footer py-0">
            {{$orders->links()}}
        </div>
    </div>
@endsection

@push('script')
    <script>
        function cancel_message() {
            toastr.info('{{\App\CPU\Helpers::translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
        <script>
            $(document).ready(function() {
                $('.table').insertBefore('body')

                $('.tooltip-info').on('mouseenter', function() {
                    // Get the tooltip element
                    var tooltip = $(this).next('.tooltip-custom').find('.tooltiptext');

                    // Calculate available space
                    var triggerOffset = $(this).offset();
                    var triggerHeight = $(this).outerHeight();
                    var tooltipHeight = tooltip.outerHeight();
                    var spaceAbove = triggerOffset.top - $(window).scrollTop();
                    var spaceBelow = $(window).height() - (spaceAbove + triggerHeight);

                    // Show the tooltip
                    tooltip.stop(true, true).fadeIn(300);

                    // Determine where to show the tooltip
                    if (spaceAbove < tooltipHeight && spaceBelow > tooltipHeight) {
                        // Not enough space above and more space below
                        tooltip.css({
                            'top': '100%', // Show below
                            'bottom': 'auto',
                            'margin-top': '10px',
                            'margin-bottom': '0'
                        });
                    } else {
                        // Enough space above or less space below
                        tooltip.css({
                            'top': 'auto',
                            'bottom': '100%', // Show above
                            'margin-top': '0',
                            'margin-bottom': '10px'
                        });
                    }
                });

                $('.tooltip-info').on('mouseleave', function() {
                    // Hide the tooltip when not hovered
                    var tooltip = $(this).next('.tooltip-custom').find('.tooltiptext');
                    tooltip.stop(true, true).fadeOut(300);
                });

                // Prevent the tooltip from triggering a mouseleave when the mouse is over it
                $('.tooltip-custom').on('mouseenter', function() {
                    $(this).prev('.tooltip-info').trigger('mouseenter');
                });

                $('.tooltip-custom').on('mouseleave', function() {
                    $(this).prev('.tooltip-info').trigger('mouseleave');
                });
            });


        </script>
@endpush
