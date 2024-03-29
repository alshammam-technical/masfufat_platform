@extends('layouts.front-end.app')

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
        .btn-primary.orders-tab *{
            color: white !important;
        }
    </style>
@endpush

@section('content')

    <div class="container rtl bg-light p-4" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};border-radius: 11px">
        <div class="d-flex">
            <div class="w-50 bg-white" style="border-radius: 11px">
                <div class="btn w-100 btn-primary p-0 orders-tab a-orders-tab" style="border-radius: 11px">
                    <a href="#" class="w-100 text-center" style="display: grid" onclick="$('.order-frames').fadeOut();$('#account-orders').fadeIn();$('.orders-tab').removeClass('btn-primary');$('.a-orders-tab').addClass('btn-primary')">
                        <h5 class="h3 text-center mb-0 p-3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">
                            {{\App\CPU\Helpers::translate('my direct orders')}}
                        </h5>
                    </a>
                </div>
            </div>

            <div class="px-3 bg-light"></div>

            <div class="w-50 bg-white" style="border-radius: 11px">
                <div class="btn w-100 p-0 orders-tab sync-orders-tab" style="border-radius: 11px">
                    <a href="#" class="w-100 text-center" style="display: grid" onclick="$('.order-frames').fadeOut();$('#sync-orders').fadeIn();$('.orders-tab').removeClass('btn-primary');$('.sync-orders-tab').addClass('btn-primary')">
                        <h5 class="h3 text-center mb-0 p-3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">
                            {{\App\CPU\Helpers::translate('my synchronized orders')}}
                        </h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
        <!-- Content  -->
            <section class="col-lg-12 col-md-12 px-0">
                <div class="">
                    <iframe class="order-frames" id="account-orders" src="{{ route('account-oder') }}" frameborder="0" style="min-height: 1185px"></iframe>
                    <iframe class="order-frames" id="sync-orders" src="{{ route('sync_orders') }}" frameborder="0" style="min-height: 1185px;display: none"></iframe>
                </div>
            </section>




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
