@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Payment_Methods'))

@push('css_or_js')
<style>
    .bt-container{
        padding: 15px;
    }

    .bt-container:nth-child(even){
        background-color: #e9e9e9;
    }
</style>
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Payment_Methods')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->

    <!-- End Inlile Menu -->

        <div class="row gy-3">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist" content="myTabContent" style="place-content: center">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="cash_on_delivery" data-bs-toggle="tab" role="button"
                            aria-controls="cash_on_delivery" aria-selected="true">{{ Helpers::translate('cash_on_delivery') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="delayed" data-bs-toggle="tab" role="button"
                            aria-controls="delayed" aria-selected="true">{{ Helpers::translate('delayed') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="bank_transfer" data-bs-toggle="tab" role="button"
                            aria-controls="bank_transfer" aria-selected="true">{{ Helpers::translate('bank_transfer') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="customer_wallet" data-bs-toggle="tab" role="button"
                            aria-controls="customer_wallet" aria-selected="true">{{ Helpers::translate('customer_wallet') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="digital_payments" data-bs-toggle="tab" role="button"
                            aria-controls="digital_payments" aria-selected="false">
                            {{ Helpers::translate('digital payment methods') }}
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="digital_payments">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4 text-uppercase d-flex">{{\App\CPU\Helpers::translate('PAYMENT_METHOD')}}</h5>
                                        @php($config=\App\CPU\Helpers::get_business_settings('digital_payment'))
                                        <form action="{{route('admin.business-settings.payment-method.update',['digital_payment'])}}"
                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                            method="post">
                                            @csrf
                                            @if(isset($config))
                                                <label
                                                    class="title-color font-weight-bold d-block mb-3">{{\App\CPU\Helpers::translate('digital_payment')}} ({{ Helpers::translate('for buying') }})</label>
                                                <div class="d-flex flex-wrap gap-5">
                                                    <div class="d-flex gap-10 align-items-center mb-2">
                                                        <input id="digital-payment-method-active" type="radio" name="status"
                                                            value="1" {{$config['status']==1?'checked':''}}>
                                                        <label for="digital-payment-method-active"
                                                            class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                                    </div>
                                                    <div class="d-flex gap-10 align-items-center mb-2">
                                                        <input id="digital-payment-method-inactive" type="radio" name="status"
                                                            value="0" {{$config['status']==0?'checked':''}}>
                                                        <label for="digital-payment-method-inactive"
                                                            class="title-color mb-0">{{\App\CPU\Helpers::translate('Inactive')}}</label>
                                                    </div>
                                                </div>

                                                <label
                                                    class="title-color font-weight-bold d-block mb-3">{{\App\CPU\Helpers::translate('digital_payment')}} ({{ Helpers::translate('for subscription') }})</label>
                                                <div class="d-flex flex-wrap gap-5">
                                                    <div class="d-flex gap-10 align-items-center mb-2">
                                                        <input id="digital-payment-method-active" type="radio" name="subs_status"
                                                            value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                        <label for="digital-payment-method-active"
                                                            class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                                    </div>
                                                    <div class="d-flex gap-10 align-items-center mb-2">
                                                        <input id="digital-payment-method-inactive" type="radio" name="subs_status"
                                                            value="0" {{($config['subs_status'] ?? null)==0?'checked':''}}>
                                                        <label for="digital-payment-method-inactive"
                                                            class="title-color mb-0">{{\App\CPU\Helpers::translate('Inactive')}}</label>
                                                    </div>
                                                </div>

                                                <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                            class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('ok')}}</button>
                                                    @else
                                                        <button type="submit"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('ok')}}</button>
                                                    @endif
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4 text-uppercase d-flex">{{Helpers::translate('PAYMENT_METHOD')}}</h5>
                                        @php($config=\App\CPU\Helpers::get_business_settings('offline_payment'))
                                        <form action="{{route('admin.business-settings.payment-method.update',['offline_payment'])}}"
                                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                              method="post">
                                            @csrf
                                            @if(isset($config))
                                                <label
                                                    class="title-color font-weight-bold d-block mb-3">{{Helpers::translate('offline_payment')}}</label>

                                                <div class="d-flex flex-wrap gap-5">
                                                    <div class="d-flex gap-10 align-items-center mb-2">
                                                        <input id="offline_payment-method-active" type="radio" name="status"
                                                               value="1" {{$config['status']==1?'checked':''}}>
                                                        <label for="offline_payment-method-active"
                                                               class="title-color mb-0">{{Helpers::translate('Active')}}</label>
                                                    </div>
                                                    <div class="d-flex gap-10 align-items-center mb-2">
                                                        <input id="offline_payment-method-inactive" type="radio" name="status"
                                                               value="0" {{$config['status']==0?'checked':''}}>
                                                        <label for="offline_payment-method-inactive"
                                                               class="title-color mb-0">{{Helpers::translate('Inactive')}}</label>
                                                    </div>
                                                </div>

                                                <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                            class="btn btn--primary px-4 text-uppercase">{{Helpers::translate('submit')}}</button>
                                                </div>
                                            @else
                                                <div>
                                                    <button type="submit"
                                                            class="btn btn--primary px-4 text-uppercase">{{Helpers::translate('Configure')}}</button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (\App\CPU\Helpers::get_business_settings('digital_payment')['status'] == 1)
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('ssl_commerz_payment'))
                                            <form
                                                action="{{route('admin.business-settings.payment-method.update',['ssl_commerz_payment'])}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('SSLCOMMERZ')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('SSLCOMMERZ')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img src="{{asset('/public/assets/back-end/img/ssl-commerz.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option
                                                                value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                            <option
                                                                value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('Store ID')}} </label>
                                                        <input type="text" class="form-control" name="store_id"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['store_id']}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('Store password')}}</label>
                                                        <input type="text" class="form-control" name="store_password"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['store_password']}}">
                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">

                                            @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
                                            <form action="{{route('admin.business-settings.payment-method.update',['paypal'])}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    <center class="mb-3">
                                                        <img src="{{asset('/public/assets/back-end/img/paypal.png')}}" alt="">
                                                    </center>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Paypal')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Paypal')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                        <select class="js-example-responsive form-control w-100"
                                                                name="environment">

                                                            <option
                                                                value="sandbox" {{isset($config['environment'])==true?$config['environment']=='sandbox'?'selected':'':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                            <option
                                                                value="live" {{isset($config['environment'])==true?$config['environment']=='live'?'selected':'':''}}>{{\App\CPU\Helpers::translate('live')}}</option>

                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="title-color d-flex">{{\App\CPU\Helpers::translate('Paypal Client')}}{{\App\CPU\Helpers::translate('ID')}}</label>
                                                        <input type="text" class="form-control" name="paypal_client_id"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['paypal_client_id']}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="title-color d-flex">{{\App\CPU\Helpers::translate('Paypal Secret')}} </label>
                                                        <input type="text" class="form-control" name="paypal_secret"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['paypal_secret']}}">
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                                            <form action="{{route('admin.business-settings.payment-method.update',['stripe'])}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Stripe')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('Stripe')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img src="{{asset('/public/assets/back-end/img/stripe.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option
                                                                value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                            <option
                                                                value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('published_key')}}</label>
                                                        <input type="text" class="form-control" name="published_key"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['published_key']}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                        <input type="text" class="form-control" name="api_key"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['api_key']}}">
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('razor_pay'))
                                            <form action="{{route('admin.business-settings.payment-method.update',['razor_pay'])}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('razor_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('razor_pay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img src="{{asset('/public/assets/back-end/img/razorpay.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option
                                                                value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                            <option
                                                                value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Key')}}  </label>
                                                        <input type="text" class="form-control" name="razor_key"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['razor_key']}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('secret')}}</label>
                                                        <input type="text" class="form-control" name="razor_secret"
                                                            value="{{env('APP_MODE')=='demo'?'':$config['razor_secret']}}">
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('senang_pay'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['senang_pay']):'javascript:'}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('senang_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('senang_pay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/senangpay.png')}}"
                                                            alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option
                                                                value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                            <option
                                                                value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>
                                                        <div
                                                            class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                                            <span class="form-ellipsis {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}"
                                                                id="id_senang_pay">{{ url('/') }}/return-senang-pay</span>
                                                            <span class="btn btn--primary btn-primary text-nowrap btn-xs"
                                                                onclick="copyToClipboard('#id_senang_pay')">
                                                            <i class="tio-copy"></i>
                                                            {{\App\CPU\Helpers::translate('Copy URI')}}
                                                        </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('secret key')}}</label>
                                                        <input type="text" class="form-control" name="secret_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('Merchant ID')}}</label>
                                                        <input type="text" class="form-control" name="merchant_id"
                                                            value="{{env('APP_MODE')!='demo'?$config['merchant_id']:''}}">
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('paytabs'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['paytabs']):'javascript:'}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytabs')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytabs')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/paytabs.png')}}" alt="">
                                                    </center>


                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('choose_environment')}}</label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option
                                                                value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>{{\App\CPU\Helpers::translate('sandbox')}}</option>
                                                            <option
                                                                value="live" {{$config['environment']=='live'?'selected':''}}>{{\App\CPU\Helpers::translate('live')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('profile_id')}}</label>
                                                        <input type="text" class="form-control" name="profile_id"
                                                            value="{{env('APP_MODE')!='demo'?$config['profile_id']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('server_key')}}</label>
                                                        <input type="text" class="form-control" name="server_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['server_key']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('base_url_by_region')}}</label>
                                                        <input type="text" class="form-control" name="base_url"
                                                            value="{{env('APP_MODE')!='demo'?$config['base_url']:''}}">
                                                    </div>


                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">

                                            @php($config=\App\CPU\Helpers::get_business_settings('paystack'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['paystack']):'javascript:'}}"
                                                method="post">
                                                @csrf
                                                @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paystack')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paystack')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/paystack.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>

                                                        <div
                                                            class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                                            <span class="form-ellipsis {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}"
                                                                id="id_paystack">{{ url('/') }}/paystack-callback</span>
                                                            <span class="btn btn--primary btn-primary text-nowrap btn-xs"
                                                                onclick="copyToClipboard('#id_paystack')"><i
                                                                    class="tio-copy"></i> {{\App\CPU\Helpers::translate('Copy URI')}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                        <input type="text" class="form-control" name="publicKey"
                                                            value="{{env('APP_MODE')!='demo'?$config['publicKey']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('secretKey')}} </label>
                                                        <input type="text" class="form-control" name="secretKey"
                                                            value="{{env('APP_MODE')!='demo'?$config['secretKey']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paymentUrl')}} </label>
                                                        <input type="text" class="form-control" name="paymentUrl"
                                                            value="{{env('APP_MODE')!='demo'?$config['paymentUrl']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('merchantEmail')}} </label>
                                                        <input type="text" class="form-control" name="merchantEmail"
                                                            value="{{env('APP_MODE')!='demo'?$config['merchantEmail']:''}}">
                                                    </div>
                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('paymob_accept'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['paymob_accept']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paymob_accept')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paymob_accept')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/paymob.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Callback_URI')}}</label>

                                                        <div
                                                            class="form-control d-flex align-items-center justify-content-between py-1 pl-3 pr-2">
                                                            <span class="form-ellipsis {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}"
                                                                id="id_paymob_accept">{{ url('/') }}/paymob-callback</span>
                                                            <span class="btn btn--primary btn-primary text-nowrap btn-xs"
                                                                onclick="copyToClipboard('#id_paymob_accept')">
                                                                <i class="tio-copy"></i>
                                                                {{\App\CPU\Helpers::translate('Copy URI')}}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                        <input type="text" class="form-control" name="api_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('iframe_id')}}</label>
                                                        <input type="text" class="form-control" name="iframe_id"
                                                            value="{{env('APP_MODE')!='demo'?$config['iframe_id']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('integration_id')}}</label>
                                                        <input type="text" class="form-control" name="integration_id"
                                                            value="{{env('APP_MODE')!='demo'?$config['integration_id']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('HMAC')}}</label>
                                                        <input type="text" class="form-control" name="hmac"
                                                            value="{{env('APP_MODE')!='demo'?$config['hmac']:''}}">
                                                    </div>


                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="card">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('fawry_pay'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['fawry_pay']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('fawry_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('fawry_pay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/fawry.svg')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('merchant_code')}}</label>
                                                        <input type="text" class="form-control" name="merchant_code"
                                                            value="{{env('APP_MODE')!='demo'?$config['merchant_code']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('security_key')}}</label>
                                                        <input type="text" class="form-control" name="security_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['security_key']:''}}">
                                                    </div>


                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('mercadopago'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['mercadopago']):'javascript:'}}"
                                                method="post">
                                                @csrf
                                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                    <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('mercadopago')}} ({{ Helpers::translate('for buying') }})</h5>

                                                    <label class="switcher show-status-text">
                                                        <input class="switcher_input" type="checkbox"
                                                            name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                    <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('mercadopago')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                    <label class="switcher show-status-text">
                                                        <input class="switcher_input" type="checkbox"
                                                            name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>

                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/mercado.svg')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                        <input type="text" class="form-control" name="public_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('access_token')}}</label>
                                                        <input type="text" class="form-control" name="access_token"
                                                            value="{{env('APP_MODE')!='demo'?$config['access_token']:''}}">
                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">

                                            @php($config=\App\CPU\Helpers::get_business_settings('liqpay'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['liqpay']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))

                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('liqpay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('liqpay')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/liqpay4.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                        <input type="text" class="form-control" name="public_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('privateKey')}}</label>
                                                        <input type="text" class="form-control" name="private_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['private_key']:''}}">
                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">

                                            @php($config=\App\CPU\Helpers::get_business_settings('flutterwave'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['flutterwave']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('flutterwave')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('flutterwave')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/fluterwave.png')}}"
                                                            alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('publicKey')}}</label>
                                                        <input type="text" class="form-control" name="public_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            class="d-flex title-color">{{\App\CPU\Helpers::translate('secret key')}}</label>
                                                        <input type="text" class="form-control" name="secret_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('hash')}}</label>
                                                        <input type="text" class="form-control" name="hash"
                                                            value="{{env('APP_MODE')!='demo'?$config['hash']:''}}">
                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('paytm'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['paytm']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytm')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytm')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/paytm.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paytm_merchant_key')}}</label>
                                                        <input type="text" class="form-control" name="paytm_merchant_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_key']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paytm_merchant_mid')}}</label>
                                                        <input type="text" class="form-control" name="paytm_merchant_mid"
                                                            value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_mid']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('paytm_merchant_website')}}</label>
                                                        <input type="text" class="form-control" name="paytm_merchant_website"
                                                            value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_website']:''}}">
                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('bkash'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['bkash']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bkash')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bkash')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/bkash.png')}}" alt="">
                                                    </center>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">
                                                            {{\App\CPU\Helpers::translate('choose_environment')}}
                                                        </label>
                                                        <select class="js-example-responsive form-control" name="environment">
                                                            <option value="sandbox" {{$config['environment']=='sandbox'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('sandbox')}}
                                                            </option>
                                                            <option value="live" {{$config['environment']=='live'?'selected':''}}>
                                                                {{\App\CPU\Helpers::translate('live')}}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                        <input type="text" class="form-control" name="api_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_secret')}}</label>
                                                        <input type="text" class="form-control" name="api_secret"
                                                            value="{{env('APP_MODE')!='demo'?$config['api_secret']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('username')}}</label>
                                                        <input type="text" class="form-control" name="username"
                                                            value="{{env('APP_MODE')!='demo'?$config['username']:''}}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('password')}}</label>
                                                        <input type="text" class="form-control" name="password"
                                                            value="{{env('APP_MODE')!='demo'?$config['password']:''}}">
                                                    </div>


                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::get_business_settings('myfatoorah'))
                                            <form
                                                action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['myfatoorah']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('myfatoorah')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('myfatoorah')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                    </div>

                                                    <center class="mb-3">
                                                        <img height="60" src="{{asset('/public/assets/back-end/img/myfatoorah.png')}}" alt="">
                                                    </center>


                                                    <div class="form-group">
                                                        <label class="d-flex title-color">{{\App\CPU\Helpers::translate('api_key')}}</label>
                                                        <input type="text" class="form-control" name="api_key"
                                                            value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                                                    </div>

                                                    <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                                class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                        @else
                                                            <button type="submit"
                                                                    class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                        @endif
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <strong>
                                                {{ Helpers::translate('Payment methods logos') }}
                                            </strong>
                                        </div>
                                        <div class="card-body">
                                            @php($config=\App\CPU\Helpers::getMyFatoorahMethods())
                                            <form action="{{ route('admin.business-settings.payment_methods_imgs') }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @foreach ($config as $pm)
                                                @if($pm->PaymentMethodEn !== "Apple Pay (Mada)")
                                                    <li class="row overflow-hidden">
                                                        <div class="col-3">
                                                            {{ Helpers::translate($pm->PaymentMethodEn) }}
                                                        </div>
                                                        <div class="col-3">
                                                            @php($sh = Helpers::get_business_settings('payment_methods_img')[$pm->PaymentMethodCode.$pm->PaymentMethodId] ?? null)
                                                            <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" style="width: 100%;height:40px;border-radius:11px">
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="file" onchange="readURL(this)" name="payment_methods_img[{{$pm->PaymentMethodCode.$pm->PaymentMethodId}}]" />
                                                        </div>
                                                    </li>
                                                @endif
                                                @endforeach
                                                <li class="row overflow-hidden">
                                                    <div class="col-3">
                                                        {{ Helpers::translate('cash on dellivery') }}
                                                    </div>
                                                    <div class="col-3">
                                                        @php($sh = Helpers::get_business_settings('payment_methods_img')['cod'] ?? null)
                                                        <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" style="width: 100%;height:40px;border-radius:11px">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="file" onchange="readURL(this)" name="payment_methods_img[cod]" />
                                                    </div>
                                                </li>
                                                <li class="row overflow-hidden">
                                                    <div class="col-3">
                                                        {{ Helpers::translate('customer_wallet') }}
                                                    </div>
                                                    <div class="col-3">
                                                        @php($sh = Helpers::get_business_settings('payment_methods_img')['wallet'] ?? null)
                                                        <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" style="width: 100%;height:40px;border-radius:11px">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="file" onchange="readURL(this)" name="payment_methods_img[wallet]" />
                                                    </div>
                                                </li>
                                                <li class="row overflow-hidden">
                                                    <div class="col-3">
                                                        {{ Helpers::translate('delayed') }}
                                                    </div>
                                                    <div class="col-3">
                                                        @php($sh = Helpers::get_business_settings('payment_methods_img')['delayed'] ?? null)
                                                        <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" style="width: 100%;height:40px;border-radius:11px">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="file" onchange="readURL(this)" name="payment_methods_img[delayed]" />
                                                    </div>
                                                </li>
                                                <li class="row overflow-hidden">
                                                    <div class="col-3">
                                                        {{ Helpers::translate('bank_transfer') }}
                                                    </div>
                                                    <div class="col-3">
                                                        @php($sh = Helpers::get_business_settings('payment_methods_img')['bank_transfer'] ?? null)
                                                        <img class="px-2 mb-2" src="{{ asset('storage/app/public/landing/img/payment_methods/'.($sh)) }}" alt="" style="width: 100%;height:40px;border-radius:11px">
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="file" onchange="readURL(this)" name="payment_methods_img[bank_transfer]" />
                                                    </div>
                                                </li>
                                                <div class="mt-9 d-flex flex-wrap justify-content-end gap-10">
                                                    <button
                                                            class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="bank_transfer">
                        <form class="row gy-3" action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['bank_transfer']):'javascript:'}}"
                        method="post">
                        @csrf
                            @php($config['environment'] = $config['environment']??'sandbox')
                            @php($item_index = 0)
                            @php($banks=\App\CPU\Helpers::get_business_settings('bank_transfer'))
                            @foreach ($banks ?? [] as $config)
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                                    <div class="bt-container">
                                                        <div class="w-100 text-start">
                                                            <div class="btn btn-danger" onclick="$(this).closest('.bt-container').remove()">
                                                                <i class="fa fa-close"></i>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}} ({{ Helpers::translate('for buying') }})</h5>

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                    name="bank_transfer[{{$item_index}}][status]" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                    name="bank_transfer[{{$item_index}}][subs_status]" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                                <span class="switcher_control"></span>
                                                            </label>
                                                        </div>

                                                        <center class="mb-3">
                                                            <i class="fa fa-bank" style="font-size: 60px"></i>
                                                        </center>


                                                        <div class="form-group">
                                                            <label class="d-flex title-color">{{\App\CPU\Helpers::translate('name')}}</label>
                                                            <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][name]"
                                                                value="{{$config['name'] ?? ''}}">
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account owner name')}}</label>
                                                            <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][owner_name]"
                                                                value="{{$config['owner_name'] ?? ''}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account number')}}</label>
                                                            <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][account_number]"
                                                                value="{{$config['account_number'] ?? ''}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="d-flex title-color">{{\App\CPU\Helpers::translate('IBAN number')}}</label>
                                                            <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][iban]"
                                                                value="{{$config['iban'] ?? ''}}">
                                                        </div>
                                                    </div>


                                                <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                            @if(!$banks) style="display: none" @endif
                                                            class="btn btn--primary btn-primary px-4 text-uppercase save_bank_transfer">{{\App\CPU\Helpers::translate('save')}}</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            @php($item_index++)
                            @endforeach
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="w-100 text-center">
                                            <div role="button" class="btn btn-success add_new_bank" onclick="$('.new_bank_transfer').show();$(this).hide()">
                                                {{ Helpers::translate('add new') }}
                                            </div>
                                        </div>
                                        <div style="display: none" class="new_bank_transfer">
                                            <div class="bt-container">
                                                <div class="w-100 text-start">
                                                    <div class="btn btn-danger" onclick="$(this).closest('.new_bank_transfer').hide();$('.add_new_bank').show()">
                                                        <i class="fa fa-close"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-3 mt-3">
                                                    <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bank_transfer')}}</h5>

                                                    <label class="switcher show-status-text">
                                                        <input class="switcher_input" type="checkbox"
                                                        value="1" name="bank_transfer[{{$item_index}}][status]" />
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>

                                                <center class="mb-3">
                                                    <i class="fa fa-bank" style="font-size: 60px"></i>
                                                </center>


                                                <div class="form-group">
                                                    <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Name')}}</label>
                                                    <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][name]" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account owner name')}}</label>
                                                    <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][owner_name]" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="d-flex title-color">{{\App\CPU\Helpers::translate('Account number')}}</label>
                                                    <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][account_number]" />
                                                </div>

                                                <div class="form-group">
                                                    <label class="d-flex title-color">{{\App\CPU\Helpers::translate('IBAN number')}}</label>
                                                    <input type="text" class="form-control" name="bank_transfer[{{$item_index}}][iban]" />
                                                </div>

                                            </div>

                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                        @if(!$banks) style="display: none" @endif
                                                        class="btn btn--success btn-success px-4 text-uppercase save_bank_transfer">{{\App\CPU\Helpers::translate('add')}}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="cash_on_delivery">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="mb-4 text-uppercase d-flex">{{\App\CPU\Helpers::translate('PAYMENT_METHOD')}}</h5>
                                    @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                                    <form action="{{route('admin.business-settings.payment-method.update',['cash_on_delivery'])}}"
                                          style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                          method="post">
                                        @csrf

                                        @if(isset($config))
                                            <label
                                                class="mb-3 d-block font-weight-bold title-color">{{\App\CPU\Helpers::translate('cash_on_delivery')}} ({{ Helpers::translate('for buying') }})</label>

                                            <div class="d-flex flex-wrap gap-5">
                                                <div class="d-flex gap-10 align-items-center mb-2">
                                                    <input id="system-default-payment-method-active" type="radio" name="status"
                                                           value="1" {{$config['status']==1?'checked':''}}>
                                                    <label for="system-default-payment-method-active"
                                                           class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                                </div>
                                                <div class="d-flex gap-10 align-items-center mb-2">
                                                    <input id="system-default-payment-method-inactive" type="radio" name="status"
                                                           value="0" {{$config['status']==0?'checked':''}}>
                                                    <label for="system-default-payment-method-inactive"
                                                           class="title-color mb-0">{{\App\CPU\Helpers::translate('Inactive')}}</label>
                                                </div>
                                            </div>
                                            <label
                                                class="mb-3 d-block font-weight-bold title-color">{{\App\CPU\Helpers::translate('cash_on_delivery')}} ({{ Helpers::translate('for subscription') }})</label>
                                            <div class="d-flex flex-wrap gap-5">
                                                <div class="d-flex gap-10 align-items-center mb-2">
                                                    <input id="system-default-payment-method-active" type="radio" name="subs_status"
                                                           value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                    <label for="system-default-payment-method-active"
                                                           class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                                </div>
                                                <div class="d-flex gap-10 align-items-center mb-2">
                                                    <input id="system-default-payment-method-inactive" type="radio" name="subs_status"
                                                           value="0" {{($config['subs_status'] ?? null)==0?'checked':''}}>
                                                    <label for="system-default-payment-method-inactive"
                                                           class="title-color mb-0">{{\App\CPU\Helpers::translate('Inactive')}}</label>
                                                </div>
                                            </div>

                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                        class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('submit')}}</button>
                                                @else
                                                    <button type="submit"
                                                            class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('Configure')}}</button>
                                                @endif
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="customer_wallet">
                        <form action="{{ route('admin.customer.customer-settings-update') }}" method="post"
                        enctype="multipart/form-data" id="update-settings">
                        <input type="hidden" name="payments_page" value="1">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="border-bottom py-3 px-4">
                                        <div class="d-flex justify-content-between align-items-center gap-10">
                                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                                <i class="tio-wallet"></i>
                                                {{\App\CPU\Helpers::translate('customer_wallet_settings')}} ({{ Helpers::translate('for buying') }}):
                                            </h5>

                                            <label class="switcher" for="customer_wallet">
                                                <input type="checkbox"
                                                    onchange="section_visibility('customer_wallet')" name="customer_wallet"
                                                    id="customer_walletcb" value="1"
                                                    data-section="wallet-section" {{isset($data['wallet_status'])&&$data['wallet_status']==1?'checked':''}}>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center gap-10 form-control mt-4" id="customer_wallet_section">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('refund_to_wallet')}}<span
                                                    class="input-label-secondary"
                                                    title="{{\App\CPU\Helpers::translate('refund_to_wallet_hint')}}"><img
                                                        src="{{asset('/public/assets/back-end/img/info-circle.svg')}}"
                                                        alt="{{\App\CPU\Helpers::translate('show_hide_food_menu')}}"></span> :</span>

                                            <label class="switcher" for="refund_to_wallet">
                                                <input type="checkbox" class="switcher_input" name="refund_to_wallet"
                                                    id="refund_to_wallet"
                                                    value="1" {{isset($data['wallet_add_refund'])&&$data['wallet_add_refund']==1?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('Save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="border-bottom py-3 px-4">
                                        <div class="d-flex justify-content-between align-items-center gap-10">
                                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                                <i class="tio-wallet"></i>
                                                {{\App\CPU\Helpers::translate('customer_wallet_settings')}} ({{ Helpers::translate('for subscription') }}):
                                            </h5>

                                            <label class="switcher" for="customer_subs_wallet">
                                                <input type="checkbox"
                                                    onchange="section_visibility('customer_subs_wallet')" name="wallet_subs_status"
                                                    id="customer_walletcb" value="1"
                                                    data-section="wallet-section" {{isset($data['wallet_subs_status'])&&$data['wallet_subs_status']==1?'checked':''}}>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center gap-10 form-control mt-4" id="customer_subs_wallet_section">
                                            <span class="title-color">{{\App\CPU\Helpers::translate('refund_to_wallet')}}<span
                                                    class="input-label-secondary"
                                                    title="{{\App\CPU\Helpers::translate('refund_to_wallet_hint')}}"><img
                                                        src="{{asset('/public/assets/back-end/img/info-circle.svg')}}"
                                                        alt="{{\App\CPU\Helpers::translate('show_hide_food_menu')}}"></span> :</span>

                                            <label class="switcher" for="refund_to_wallet_subs">
                                                <input type="checkbox" class="switcher_input" name="refund_to_wallet_subs"
                                                    id="refund_to_wallet_subs"
                                                    value="1" {{isset($data['refund_to_wallet_subs'])&&$data['refund_to_wallet_subs']==1?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('Save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>




                    <div class="tab-pane fade " role="tabpanel" aria-labelledby="delayed">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    @php($config=\App\CPU\Helpers::get_business_settings('delayed'))
                                    <form
                                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.payment-method.update',['delayed']):'javascript:'}}"
                                        method="post">
                                    @csrf
                                    @if(isset($config))
                                            @php($config['environment'] = $config['environment']??'sandbox')
                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('delayed')}} ({{ Helpers::translate('for buying') }})</h5>

                                                <label class="switcher show-status-text">
                                                    <input class="switcher_input" type="checkbox"
                                                           name="status" value="1" {{$config['status']==1?'checked':''}}>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </div>

                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('delayed')}} ({{ Helpers::translate('for subscription') }})</h5>

                                                <label class="switcher show-status-text">
                                                    <input class="switcher_input" type="checkbox"
                                                           name="subs_status" value="1" {{($config['subs_status'] ?? null)==1?'checked':''}}>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </div>

                                            <center class="mb-3">
                                                <h2> {{\App\CPU\Helpers::translate('delayed')}} </h2>
                                            </center>


                                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                                        class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('save')}}</button>
                                                @else
                                                    <button type="submit"
                                                            class="btn btn--primary btn-primary px-4 text-uppercase">{{\App\CPU\Helpers::translate('configure')}}</button>
                                                @endif
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>









            </div>


        </div>
    </div>
@endsection

@push('script')
    <script>
        var item_index = {{$item_index}};

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success("{{\App\CPU\Helpers::translate('Copied to the clipboard')}}");
        }

        function new_bank_transfer(ths,e){
            var html = $('.new_bank_transfer').html();
            html = html.replaceAll('{{$item_index}}',item_index)
            $(html).insertBefore($('.save_bank_transfer').parent());
            $('.save_bank_transfer').show();
            item_index++;
        }
    </script>
@endpush

@push('script_2')
    <script>
        $(document).on('ready', function () {
            @if (isset($data['wallet_status'])&&$data['wallet_status']!=1)
            $('#customer_wallet_section').attr('style', 'display: none !important');
            @endif

            @if (isset($data['loyalty_point_status'])&&$data['loyalty_point_status']!=1)
            $('.loyalty-point-section').attr('style', 'display: none !important');
            @endif
        });
    </script>

    <script>
        function section_visibility(id) {
            if ($('#customer_walletcb').is(':checked')) {
                $('#customer_wallet_section').attr('style', 'display: block');
            } else {
                $('#customer_wallet_section').attr('style', 'display: none !important');
            }
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).closest('.row').find('img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
