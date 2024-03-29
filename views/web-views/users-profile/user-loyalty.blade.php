@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My Loyalty Point'))

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
    </style>
    <style>
        thead{
            background-color: #F8F8F8;
            border-radius: 11px;
        }

        thead * td{
            padding-top: 15px !important;
            padding-bottom: 15px !important;
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

        td{
            color: black
        }

        .table th, .table td{
            border: none;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
        <!-- Content  -->
            <section class="col-lg-12 col-md-12">
                @php
                    $wallet_status = App\CPU\Helpers::get_business_settings('wallet_status');
                    $loyalty_point_status = App\CPU\Helpers::get_business_settings('loyalty_point_status');
                @endphp
                <div class="justify-content-between">
                    <div class="row justify-content-between mx-0 mb-4">
                        <div class="col-6 bg-primary p-4 border border-primary text-center" style="border-radius: 12px">
                            <p class="text-white h4 text-center">
                                {{\App\CPU\Helpers::translate('total_loyalty_point')}}
                            </p>
                            <p class="mt-5 mb-0 text-white d-flex text-center fw-bolder" style="align-items: center;justify-content: center;">
                                <span class="text-white h2">
                                    {{$total_loyalty_point}}
                                </span>
                                <span class="text-white h4">
                                    {{ Helpers::translate('Points') }}
                                </span>
                            </p>
                        </div>

                        <div class="col-6 text-end">
                            @if ($wallet_status == 1 && $loyalty_point_status == 1)
                            <button type="button" class="btn btn--primary text-light mt-6 py-3 px-4" data-bs-toggle="modal" data-bs-target="#convertToCurrency">
                                {{\App\CPU\Helpers::translate('convert_to_currency')}}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-sm">

                    <div class="card-body p-0">
                        <div style="overflow: auto">
                            <table class="table">
                                <thead>
                                <tr style="background-color: F8F8F8;">
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
                                @foreach($loyalty_point_list as $key=>$item)
                                    <tr>
                                        <td class="bodytr">
                                            {{$loyalty_point_list->firstItem()+$key}}
                                        </td>
                                        <td class="bodytr"><span class="text-capitalize">{{Helpers::translate($item['transaction_type'])}}</span></td>
                                        <td class="bodytr"><span class="">{{ $item['credit']}}</span></td>
                                        <td class="bodytr"><span class="">{{ $item['debit']}}</span></td>
                                        <td class="bodytr"><span class="">{{ $item['balance']}}</span></td>
                                        <td class="bodytr"><span class="">{{$item['created_at']}}</span></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($loyalty_point_list->count()==0)
                                <center class="mt-3 mb-2">{{\App\CPU\Helpers::translate('no_transaction_found')}}</center>
                            @endif
                            <div class="card-footer">
                                {{$loyalty_point_list->links()}}
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>


  <!-- Modal -->
  <div class="modal fade" id="convertToCurrency" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{\App\CPU\Helpers::translate('convert_to_currency')}}</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('loyalty-exchange-currency')}}" method="POST">
            @csrf
        <div class="modal-body">
            <div>
                <span>
                    {{\App\CPU\Helpers::translate('your loyalty point will convert to currency and transfer to your wallet')}}
                </span>
            </div>
            <div class="text-center">
                <span class="text-warning">
                    {{\App\CPU\Helpers::translate('minimum point for convert to currency is :')}} {{App\CPU\Helpers::get_business_settings('loyalty_point_minimum_point point')}}
                </span>
            </div>
            <div class="text-center">
                <span >
                    {{App\CPU\Helpers::get_business_settings('loyalty_point_exchange_rate point')}} = {{\App\CPU\Helpers::currency_converter(1)}}
                </span>
            </div>

            <div class="form-row">
                <div class="form-group col-12">

                    <input class="form-control" type="number" id="city" name="point" required>
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
          <button type="submit" class="btn btn--primary text-light">{{\App\CPU\Helpers::translate('submit')}}</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection

@push('script')

@endpush
