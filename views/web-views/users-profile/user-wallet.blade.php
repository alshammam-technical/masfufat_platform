@extends('layouts.front-end.app')

@section('title',Helpers::translate('my_Wallet'))

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/owl.theme.default.min.css"/>
    <style>
        .dropdown-toggle:not(.dropdown-toggle-empty)::after{
            margin-right: 5px !important;
            margin-left: 5px !important;
        }
    </style>
    @if(env('APP_DEBUG'))
    <script src="https://demo.myfatoorah.com/cardview/v1/session.js"></script>

    @elseif (($country_code ?? 'SA') == 'SA')
        <script src="https://portal.myfatoorah.com/cardview/v1/session.js"></script>

    @else
        <script src="https://sa.myfatoorah.com/cardview/v1/session.js"></script>
    @endif
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                    <h5 class="mb-0">{{Helpers::translate('wallet')}}</h5>

                    <button class="profile-aside-btn btn btn--primary px-2 rounded px-2 py-1 d-lg-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 9.81219C7 9.41419 6.842 9.03269 6.5605 8.75169C6.2795 8.47019 5.898 8.31219 5.5 8.31219C4.507 8.31219 2.993 8.31219 2 8.31219C1.602 8.31219 1.2205 8.47019 0.939499 8.75169C0.657999 9.03269 0.5 9.41419 0.5 9.81219V13.3122C0.5 13.7102 0.657999 14.0917 0.939499 14.3727C1.2205 14.6542 1.602 14.8122 2 14.8122H5.5C5.898 14.8122 6.2795 14.6542 6.5605 14.3727C6.842 14.0917 7 13.7102 7 13.3122V9.81219ZM14.5 9.81219C14.5 9.41419 14.342 9.03269 14.0605 8.75169C13.7795 8.47019 13.398 8.31219 13 8.31219C12.007 8.31219 10.493 8.31219 9.5 8.31219C9.102 8.31219 8.7205 8.47019 8.4395 8.75169C8.158 9.03269 8 9.41419 8 9.81219V13.3122C8 13.7102 8.158 14.0917 8.4395 14.3727C8.7205 14.6542 9.102 14.8122 9.5 14.8122H13C13.398 14.8122 13.7795 14.6542 14.0605 14.3727C14.342 14.0917 14.5 13.7102 14.5 13.3122V9.81219ZM12.3105 7.20869L14.3965 5.12269C14.982 4.53719 14.982 3.58719 14.3965 3.00169L12.3105 0.915687C11.725 0.330188 10.775 0.330188 10.1895 0.915687L8.1035 3.00169C7.518 3.58719 7.518 4.53719 8.1035 5.12269L10.1895 7.20869C10.775 7.79419 11.725 7.79419 12.3105 7.20869ZM7 2.31219C7 1.91419 6.842 1.53269 6.5605 1.25169C6.2795 0.970186 5.898 0.812187 5.5 0.812187C4.507 0.812187 2.993 0.812187 2 0.812187C1.602 0.812187 1.2205 0.970186 0.939499 1.25169C0.657999 1.53269 0.5 1.91419 0.5 2.31219V5.81219C0.5 6.21019 0.657999 6.59169 0.939499 6.87269C1.2205 7.15419 1.602 7.31219 2 7.31219H5.5C5.898 7.31219 6.2795 7.15419 6.5605 6.87269C6.842 6.59169 7 6.21019 7 5.81219V2.31219Z" fill="white"/>
                            </svg>
                    </button>
                </div>

                <div class="card">
                    <div class="card-body p-2">
                        <div class="row g-0 g-md-3 gap-3 h-100">

                            @php($add_funds_to_wallet = \App\CPU\Helpers::get_business_settings('add_funds_to_wallet'))

                            <div class="col-md-12">
                                <div class="row  g-3">
                                    <div class="col-md-12">
                                        <div class="row justify-content-between mx-0 mb-4">
                                            <div class="col-md-6 col-lg-6 bg-primary p-4 border border-primary text-center" style="border-radius: 12px">
                                                <p class="text-white h4 text-center">
                                                    {{\App\CPU\Helpers::translate('wallet_amount')}}
                                                </p>
                                                <p class="text-white h2 text-center fw-bolder">
                                                    {{\App\CPU\Helpers::currency_converter($total_wallet_balance)}}
                                                </p>
                                                @if (\App\CPU\Helpers::store_module_permission_check('my_account.my_wallet.recharge'))
                                                    @if ($add_funds_to_wallet || 1 == 1)
                                                        <button class="btn btn-white align-items-center" data-toggle="modal" data-target="#addFundToWallet">
                                                            <i class="tio-add-circle text-accent"></i>
                                                            <strong class="text-accent">{{ Helpers::translate('recharge') }}</strong>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        @if($add_funds_to_wallet)
                                        <div class="owl-carousel add-fund-carousel">
                                            @foreach ($add_fund_bonus_list as $bonus)
                                                    <div class="item">

                                                <div class="add-fund-carousel-card z-1 w-100 border rounded-10 p-4 ml-1">
                                                        <div>
                                                            <h4 class="mb-2 text-accent">{{ $bonus->title }}</h4>
                                                            <p class="mb-2 text-dark">{{ Helpers::translate('valid_till') }} {{ date('d M, Y',strtotime($bonus->end_date_time)) }}</p>
                                                        </div>
                                                        <div>
                                                            @if ($bonus->bonus_type == 'percentage')
                                                            <p>{{ Helpers::translate('recharge') }} {{ \App\CPU\Helpers::currency_converter($bonus->min_add_money_amount) }} {{ Helpers::translate('and_enjoy') }} {{ $bonus->bonus_amount }}% {{ Helpers::translate('bonus') }}</p>
                                                            @else
                                                                <p>{{ Helpers::translate('recharge') }} {{ \App\CPU\Helpers::currency_converter($bonus->min_add_money_amount) }} {{ Helpers::translate('and_enjoy') }} {{ \App\CPU\Helpers::currency_converter($bonus->bonus_amount) }} {{ Helpers::translate('bonus') }}</p>
                                                            @endif
                                                            <p class="fw-bold text-accent mb-0">{{ $bonus->description ? Str::limit($bonus->description, 40):'' }}</p>
                                                        </div>
                                                        <img class="slider-card-bg-img" width="50" src="{{ asset('public/assets/front-end/img/icons/add_fund_vector.png') }}" alt="">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="addFundToWallet" tabindex="-1" aria-labelledby="addFundToWalletModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body px-5 pt-0">

                                            <form action="{{ route('customer.add-fund-request') }}" method="post" onsubmit="ajsub(event)">
                                                @csrf
                                                <div class="pb-4">
                                                    <h4 class="text-center">{{ Helpers::translate('add_Fund_to_Wallet') }}</h4>
                                                    <p class="text-center">{{ Helpers::translate('add_fund_by_from_secured_digital_payment_gateways') }}</p>
                                                    <input type="number" t="number" class="h-70 form-control text-center text-24 rounded-10" id="add-fund-amount-input" name="amount" required placeholder="{{ \App\CPU\currency_symbol() }}500">
                                                    <input type="hidden" value="web" name="payment_platform" required>
                                                    <input type="hidden" value="{{ request()->url() }}" name="external_redirect_link" required>
                                                </div>

                                                <div id="add-fund-list-area" style="display: none">
                                                    <h6 class="mb-2">{{ Helpers::translate('payment_Methods') }} <small>({{ Helpers::translate('faster_&_secure_way_to_pay_bill') }})</small></h6>
                                                    <div class="gatways_list">

                                                        @forelse ($payment_gateways as $gateway)
                                                            <label class="form-check form--check rounded inline-flex">
                                                                <input type="radio" class="form-check-input d-none" name="payment_method" value="{{ $gateway->key_name }}" required>
                                                                <div class="check-icon pt-2">
                                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="8" cy="8" r="8" fill="#1455AC"/>
                                                                    <path d="M9.18475 6.49574C10.0715 5.45157 11.4612 4.98049 12.8001 5.27019L7.05943 11.1996L3.7334 7.91114C4.68634 7.27184 5.98266 7.59088 6.53004 8.59942L6.86856 9.22314L9.18475 6.49574Z" fill="white"/>
                                                                    </svg>
                                                                </div>
                                                                @php( $payment_method_title = !empty($gateway->additional_data) ? (json_decode($gateway->additional_data)->gateway_title ?? ucwords(str_replace('_',' ', $gateway->key_name))) : ucwords(str_replace('_',' ', $gateway->key_name)) )
                                                                @php( $payment_method_img = !empty($gateway->additional_data) ? json_decode($gateway->additional_data)->gateway_image : '' )
                                                                <div class="form-check-label d-flex align-items-center py-0">
                                                                    <img width="60" src="{{ asset('storage/app/public/payment_modules/gateway_image/'.$payment_method_img) }}"
                                                                    onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                                                    alt="img"

                                                                    />
                                                                    <span class="ml-3 px-2">{{ $payment_method_title }}</span>
                                                                </div>
                                                            </label>
                                                        @empty

                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center pt-2 pb-3 ok-b">
                                                    <button type="submit" class="btn btn--primary w-75 mx-3" id="add_fund_to_wallet_form_btn">{{ Helpers::translate('Payment completion') }}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.my_wallet.transaction_history'))
                            <div class="col-md-12">
                                <div class="">
                                    <div class="align-items-start d-flex flex-column flex-md-row gap-8 justify-content-between p-2 align-items-center">
                                        <h6 class="mb-0 fw-bold">{{ Helpers::translate('Transaction_History') }}</h6>

                                        <ul class="navbar-nav text-center" style="{{Session::get('direction') === "rtl" ? 'padding-right: 0px' : ''}}">
                                            <div class="dropdown border px-3">
                                                <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0">
                                                    {{ request()->has('type') ? (request('type') == 'all'? Helpers::translate('all_Transactions') : ucwords(Helpers::translate(request('type')))):Helpers::translate('all_Transactions')}}
                                                </button>

                                                <div class="dropdown-menu __dropdown-menu-3 __min-w-165px" aria-labelledby="dropdownMenuButton"
                                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};transform: Helpers::translate3d(7px, -230px, 0) !important;">

                                                    <a class="dropdown-item" href="{{route('wallet')}}/?type=all">
                                                        {{Helpers::translate('all_Transaction')}}
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{route('wallet')}}/?type=order_transactions">
                                                        {{Helpers::translate('order_transactions')}}
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{route('wallet')}}/?type=order_refund">
                                                        {{Helpers::translate('order_refund')}}
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{route('wallet')}}/?type=converted_from_loyalty_point">
                                                        {{Helpers::translate('converted_from_loyalty_point')}}
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{route('wallet')}}/?type=added_via_payment_method">
                                                        {{Helpers::translate('added_via_payment_method')}}
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{route('wallet')}}/?type=add_fund_by_admin">
                                                        {{Helpers::translate('add_fund_by_admin')}}
                                                    </a>
                                                </div>

                                            </div>
                                        </ul>
                                    </div>

                                    <div class="max-height-500">
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($wallet_transactio_list as $key=>$item)
                                            <div class="bg-light my-1 p-3 rounded d-flex justify-content-between g-2">
                                                <div class="w-100">
                                                    <h6 class="mb-2 d-flex align-items-center gap-8">
                                                        @if($item['debit'] != 0)
                                                            <img src="{{ asset('public/assets/front-end/img/icons/coin-danger.png') }}" width="25" alt="">
                                                        @else
                                                            <img src="{{ asset('public/assets/front-end/img/icons/coin-success.png') }}" width="25" alt="">
                                                        @endif

                                                        {{ $item['debit'] != 0 ? ' - '.\App\CPU\Helpers::currency_converter($item['debit']) : ' + '.\App\CPU\Helpers::currency_converter($item['credit']) }}

                                                    </h6>
                                                    <h6 class="text-muted mb-0 small">
                                                        @if ($item['transaction_type'] == 'add_fund_by_admin')
                                                            {{Helpers::translate('add_fund_by_admin')}} {{ $item['reference'] =='earned_by_referral' ? '('.Helpers::translate($item['reference']).')' : '' }}
                                                        @elseif($item['transaction_type'] == 'order_place')
                                                            {{Helpers::translate('order_place')}}
                                                        @elseif($item['transaction_type'] == 'loyalty_point')
                                                            {{Helpers::translate('converted_from_loyalty_point')}}
                                                        @elseif($item['transaction_type'] == 'add_fund')
                                                            {{Helpers::translate('added_via_payment_method')}}
                                                        @else
                                                            {{str_replace('_',' ',Helpers::translate($item['transaction_type']))}}
                                                        @endif
                                                    </h6>
                                                </div>
                                                <div class="text-end small">
                                                    <div class="text-muted mb-1 text-nowrap">{{date('d M, Y H:i A',strtotime($item['created_at']))}}</div>
                                                        @if($item['debit'] != 0)
                                                            <p class="text-danger fs-12 m-0">{{Helpers::translate('debit')}}</p>
                                                        @else
                                                            <p class="text-info fs-12 m-0">{{Helpers::translate('credit')}}</p>
                                                        @endif
                                                </div>
                                            </div>

                                            @if ($item['admin_bonus'] > 0)
                                            <div class="bg-light my-1 p-3 p-sm-3 rounded d-flex justify-content-between g-2">
                                                <div class="">
                                                    <h6 class="mb-2 d-flex align-items-center gap-8">
                                                        <img src="{{ asset('public/assets/front-end/img/icons/coin-success.png') }}" width="25" alt="">
                                                        <span>+ {{ \App\CPU\Helpers::currency_converter($item['admin_bonus']) }}</span>
                                                    </h6>
                                                    <h6 class="text-muted mb-0 small">
                                                        {{ucwords(str_replace('_', ' ', Helpers::translate('admin_bonus')))}}
                                                    </h6>
                                                </div>
                                                <div class="text-end small">
                                                    <div class="text-muted mb-1 text-nowrap">{{date('d M, Y H:i A',strtotime($item['created_at']))}}</div>
                                                        @if($item['debit'] != 0)
                                                            <p class="text-danger fs-12">{{Helpers::translate('debit')}}</p>
                                                        @else
                                                            <p class="text-info fs-12 m-0">{{Helpers::translate('credit')}}</p>
                                                        @endif
                                                </div>
                                            </div>
                                            @endif

                                            @endforeach
                                        </div>
                                    </div>
                                    @if($wallet_transactio_list->count()==0)
                                    <div class="d-flex flex-column gap-3 align-items-center text-center my-5">
                                        <img width="72" src="{{ asset('public/assets/front-end/img/icons/empty-transaction-history.png')}}" class="dark-support" alt="">
                                        <h6 class="text-muted mt-3">{{Helpers::translate('you_do_not_have_any')}}<br> {{ request('type') != 'all' ? ucwords(Helpers::translate(request('type'))) : '' }} {{Helpers::translate('transaction_yet')}}</h6>
                                    </div>
                                    @endif

                                    <div class="card-footer bg-transparent border-0 p-0 mt-3">

                                        @if (request()->has('type'))
                                            @php($paginationLinks = $wallet_transactio_list->links())
                                            @php($modifiedLinks = preg_replace('/href="([^"]*)"/', 'href="$1&type='.request('type').'"', $paginationLinks))
                                        @else
                                            @php($modifiedLinks = $wallet_transactio_list->links())
                                        @endif

                                        {!! $modifiedLinks !!}

                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
{{-- Owl Carousel --}}
<script src="{{asset('public/assets/front-end')}}/js/owl.carousel.min.js"></script>
<script>

    $(document).ready(function(){
        const img = $("img");
        img.on("error", function (event) {
            event.target.src = '{{asset('public/assets/front-end/img/image-place-holder.png')}}';
            event.onerror = null
        })
    });

    $('.add-fund-carousel').owlCarousel({
        loop: true,
        dots: true,
        autoplay: false,
        nav: false,
        margin: 20,
        '{{session('direction')}}': true,
        items: 1.3
    })

    $('#add_fund_to_wallet_form_btn').on('click', function(){
        if (!$("input[name='payment_method']:checked").val()) {
            toastr.error("{{ Helpers::translate('please_select_a_payment_Methods') }}");
        }
    })

    $('#add-fund-amount-input').on('keyup', function(){
        if($(this).val() == ''){
            $('#add-fund-list-area').slideUp();
        }else{
            if (!isNaN($(this).val()) && $(this).val() < 0) {
                $(this).val(0);
                toastr.error("{{ Helpers::translate('cannot_input_minus_value') }}");
            } else {
                $('#add-fund-list-area').slideDown();
                $('#add-fund-list-area').find('.check-icon').click();
            }
        }
    })

    function ajsub(e)
        {
            alert_wait()
            e.preventDefault()
            var ths = $(e.target)
            console.log('11')
            console.log(ths.serialize())
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('customer.add-fund-request') }}",
                data: ths.serialize(),
                success: function (response){
                    //location.replace(response)
                    ths.find('.ok-b').html(response);
                    Swal.close()
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + status + "\nError: " + error);
                }
            })
        }
</script>
@endpush

