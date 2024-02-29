@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My Wallet'))

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
            color: black !important;
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
    </style>

    <style>
        thead{
            background-color: #F8F8F8;
            border-radius: 11px;
        }

        .tdBorder {
            border: none;
            text-align: center;
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

        .table, .dataTables_scrollHead{
            background-color: white;
            border: white;
        }
    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
        <!-- Content  -->
            <section class="col-lg-12 col-md-12">

                <div class="row justify-content-between mx-0 mb-4">
                    <div class="col-6 bg-primary p-4 border border-primary text-center" style="border-radius: 12px">
                        <p class="text-white h4 text-center">
                            {{\App\CPU\Helpers::translate('wallet_amount')}}
                        </p>
                        <p class="text-white h2 text-center fw-bolder">
                            {{\App\CPU\Helpers::currency_converter($total_wallet_balance)}}
                        </p>
                        <a href="">

                        </a>
                    </div>
                </div>

                <div class="card box-shadow-sm">
                    <div class="card-body p-0">
                        <div style="overflow: auto">
                            <table class="table">
                                <thead>
                                <tr style="background-color: #F8F8F8;">
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO ">{{\App\CPU\Helpers::translate('sl#')}}</span></div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO">{{\App\CPU\Helpers::translate('transaction_type')}} </span>
                                        </div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO">{{\App\CPU\Helpers::translate('credit')}} </span>
                                        </div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('debit')}}</span></div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('balance')}}</span></div>
                                    </td>
                                    <td class="tdBorder">
                                        <div class="py-2"><span
                                                class="d-block spandHeadO"> {{\App\CPU\Helpers::translate('date')}}</span></div>
                                    </td>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($wallet_transactio_list as $key=>$item)
                                    <tr>
                                        <td class="bodytr">
                                            {{$wallet_transactio_list->firstItem()+$key}}
                                        </td>
                                        <td class="bodytr"><span class="text-capitalize">{{Helpers::translate($item['transaction_type'])}}</span></td>
                                        <td class="bodytr"><span class="">{{\App\CPU\Helpers::currency_converter($item['credit'])}}</span></td>
                                        <td class="bodytr"><span class="">{{\App\CPU\Helpers::currency_converter($item['debit'])}}</span></td>
                                        <td class="bodytr"><span class="">{{\App\CPU\Helpers::currency_converter($item['balance'])}}</span></td>
                                        <td class="bodytr"><span class="">{{$item['created_at']}}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($wallet_transactio_list->count()==0)
                                <center class="mt-3 mb-2">{{\App\CPU\Helpers::translate('no_transaction_found')}}</center>
                            @endif

                            <div class="card-footer">
                                {{$wallet_transactio_list->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')

@endpush
