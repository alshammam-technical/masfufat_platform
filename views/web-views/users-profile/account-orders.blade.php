@extends('layouts.front-end.app',['hide_all'=>true])

@section('title',\App\CPU\Helpers::translate('My Order List'))

@push('css_or_js')
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

        .table{
            display: block !important;
        }

        thead, tbody{
            width: 100%;
            display: inline-table;
            border-right: #F8F8F8 solid thin;
            border-left: #F8F8F8 solid thin;
            border-bottom: #F8F8F8 solid thin;
        }

        thead{
            background-color: #F8F8F8;
            border-radius: 11px;
        }

        td,th{
            width: 20%;
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

        .badge-pending{
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

        .anouncementDiv{
            display: none !important;
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
                <td class="tdBorder">
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
                    <td class="bodytr">
                        {{\App\CPU\Helpers::currency_converter($order['order_amount'])}}
                    </td>
                    <td class="bodytr d-flex w-100 justify-content-center">
                        <a target="_parent" href="{{ route('account-order-details', ['id'=>$order->id]) }}"
                            class="p-2 mt-2">
                            <i class="fa fa-eye text-info"></i>
                        </a>
                        @if($order['payment_method']=='cash_on_delivery' && $order['order_status']=='pending')
                            <a href="javascript:"
                                onclick="route_alert('{{ route('order-cancel',[$order->id]) }}','{{\App\CPU\Helpers::translate('want_to_cancel_this_order?')}}')"
                                class="p-2 top-margin">
                                <i class="ri-delete-bin-5-fill text-danger"></i>
                            </a>
                        @else

                        @endif
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
@endpush
