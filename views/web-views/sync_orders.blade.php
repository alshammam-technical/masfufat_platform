@extends('layouts.front-end.app',['hide_all'=>true])

@section('title',\App\CPU\Helpers::translate('Orders List'))

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
            border- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
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

        tr td, tr th{
            width: 14.28571428571429%;
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

    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-6 btn btn-primary p-0">
                <a href="{{ route('orders') }}" class="w-100 grid-item">
                    <h1 class="h3 text-center text-light mb-0 p-3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">
                        {{\App\CPU\Helpers::translate('my synchronized orders')}}
                    </h1>
                </a>
            </div>
            <div class="col-6 btn p-0" style="border-bottom: solid black thin;">
                <a href="{{ route('account-oder') }}" class="w-100 grid-item">
                    <h1 class="h3 text-center mb-0 p-3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">
                        {{\App\CPU\Helpers::translate('my direct orders')}}
                    </h1>
                </a>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
        <!-- Content  -->
            <section class="col-lg-12 col-md-12">
                <div class="card box-shadow-sm">
                    <div style="overflow: auto">
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
                                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('Reference ID')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('end customer name')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('Payment method')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('amount')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('Status')}}</span></div>
                                </td>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="bodytr font-weight-bold">
                                        <a href="{{route('orders.show',['id'=>$order['id']])}}" target="_blank">
                                            {{ Helpers::get_local_orders_ids_3($order['id']) }}
                                        </a>
                                        <a class="btn btn-primary" onclick="copyToClipboard('{{ Helpers::get_local_orders_ids($order['id']) }}')"> <i class="fa fa-copy"></i> </a>
                                    </td>

                                    <td class="bodytr font-weight-bold">{{ \Carbon\Carbon::parse($order['date_time'])->format('H:i   Y/m/d') }}</td>
                                    <td class="bodytr font-weight-bold">
                                        <a class="btn btn-primary" onclick="copyToClipboard({{$order['reference_id']}})"> <i class="fa fa-copy"></i> </a>
                                        {{$order['reference_id']}}
                                    </td>
                                    <td class="bodytr font-weight-bold">{{$order['customer']['first_name']}} {{$order['customer']['last_name']}}</td>
                                    <td class="bodytr font-weight-bold">{{$order['payment_method']}}</td>
                                    <td class="bodytr font-weight-bold">{{ $order['total'].' '.$order['currency']}}</td>
                                    <td class="bodytr font-weight-bold">{{\App\CPU\Helpers::translate($order['status'])}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($orders->count()==0)
                            <center class="mt-3 mb-2">{{\App\CPU\Helpers::translate('no_order_found')}}</center>
                        @endif

                        <div class="card-footer">
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </section>




        </div>
    </div>
@endsection

@push('script')
    <script>
        $(".table").parent().insertAfter('body');
        function cancel_message() {
            toastr.info('{{\App\CPU\Helpers::translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush
