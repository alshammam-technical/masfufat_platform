@extends('layouts.back-end.app')
{{--@section('title','Customer')--}}
@section('title', \App\CPU\Helpers::translate('Details'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-print-none pb-2">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">

                    <!-- Page Title -->
                    <div class="col-lg-6 pt-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    @isset($end_customer)
                                    <a href="{{ route('admin.customer.list', ['end_customer'=>1]) }}">
                                    @else
                                    <a href="{{ route('admin.stores.list') }}">
                                    @endisset
                                        @isset($end_customer)
                                        {{\App\CPU\Helpers::translate('End customer list')}}
                                        @else
                                        {{\App\CPU\Helpers::translate('Customer_list')}}
                                        @endisset
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <a>
                                        {{$customer['id'] ? Helpers::translate('edit') : Helpers::translate('Add')}}
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <!-- End Page Title -->

                    <div class="d-sm-flex align-items-sm-center">
                        @if ($customer['is_store'] == "1")
                        <h3 class="page-header-title">{{\App\CPU\Helpers::translate('Customer ID')}} #{{$customer['id']}}</h3>
                        @else
                        <h3 class="page-header-title">{{\App\CPU\Helpers::translate('End Customer ID')}} #{{$customer['id']}}</h3>
                        @endif
                        @if($customer->is_store)
                        <span class="{{Session::get('direction') === "rtl" ? 'mr-2 mr-sm-3' : 'ml-2 ml-sm-3'}}">
                        <i class="tio-date-range">
                        </i> {{\App\CPU\Helpers::translate('Joined At')}} : {{date('d M Y H:i:s',strtotime($customer['created_at']))}}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7" hidden>
                    <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                        <div class="d-flex">
                        <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.brands-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                            <i class="fa fa-th"></i>
                        </button>
                        <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.brands-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                            <i class="fa fa-table"></i>
                        </button>
                        <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2 disabled" href="{{route('admin.customer.update_')}}" disabled>
                            <i class="fa fa-plus"></i>
                        </a>
                        <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('brands')">
                            <i class="fa fa-clone"></i>
                        </button>


                        @if($customer->is_store)
                        <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
                        onclick="$('.btn-save').click()">
                            <i class="fa fa-save"></i>
                        </button>
                        @endif

                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                        onclick="form_alert('bulk-delete','Want to delete this item ?')"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                        <form hidden action="{{route('admin.stores.add-new')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids" value="{{$customer['id']}}">
                            <input type="text" name="back" value="1">
                        </form>
                        <button disabled class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                            <i class="fa fa-toggle"></i>
                        </button>
                        </div>
                        <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                            <div class="dropdown dropdown">
                                <button disabled aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
                                    <i class="ti-bag"></i>
                                </button>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu">
                                    <a class="dropdown-item" href="#"
                                    onclick="form_alert('bulk-enable','Are you sure ?')"
                                    >
                                        <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                                    </a>
                                    <a class="dropdown-item" href="#"
                                    onclick="form_alert('bulk-disable','Are you sure ?')"
                                    >
                                        <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="stateClear()">
                                        <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                                    </a>
                                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                    onclick='$(".dt-button-collection").remove();'>
                                        <i class="ti-angle-down"></i>
                                        {{\App\CPU\Helpers::translate('Import/Export')}}
                                    </a>
                                    <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                        <a class="dropdown-item bulk-export" href="{{route('admin.stores.add-new')}}">
                                            {{\App\CPU\Helpers::translate('export to excel')}}
                                        </a>
                                        <a class="dropdown-item bulk-import" href="{{route('admin.stores.add-new')}}">
                                            {{\App\CPU\Helpers::translate('import from excel')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        @if($customer->is_store)
        <div class="col-md-12 px-0 mb-3">
            <ul class="nav nav-tabs w-fit-content mb-0 px-6">
                <li class="nav-item text-capitalize">
                    <a class="nav-link cu_link active" href="#" id="account-link">
                        {{\App\CPU\Helpers::translate('main store informations')}}
                    </a>
                </li>
                <li class="nav-item text-capitalize">
                    <a class="nav-link cu_link" href="#" id="orders-link">
                        {{\App\CPU\Helpers::translate('Online store requests')}}
                    </a>
                </li>
                <li class="nav-item text-capitalize">
                    <a class="nav-link cu_link" href="#" id="subscription-link">
                        {{\App\CPU\Helpers::translate('Online store subscriptions')}}
                    </a>
                </li>
                @isset($customer['id'])
                <li class="nav-item text-capitalize">
                    <a class="nav-link cu_link" href="#" id="paymentmethods-link">
                        {{\App\CPU\Helpers::translate('Payment methods available for this store')}}
                    </a>
                </li>
                @endisset
            </ul>
        </div>
        @endif

        @if(isset($customer['id']) && $customer->is_store)
        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="paymentmethods-tab" style="place-content: center">
            <div class="col-lg-8 mb-3 mb-lg-0">
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


                        <div class="tab-content py-3" id="myTabContent">
                            <div class="tab-pane fade" role="tabpanel" aria-labelledby="digital_payments">
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="mb-4 text-uppercase d-flex">{{\App\CPU\Helpers::translate('PAYMENT_METHOD')}} 11</h5>
                                                @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'digital_payment'))
                                                <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'digital_payment'])}}"
                                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                                    method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                        <label
                                                            class="title-color font-weight-bold d-block mb-3">{{\App\CPU\Helpers::translate('digital_payment')}} ({{ Helpers::translate('for buying') }})</label>
                                                        <div class="d-flex flex-wrap gap-5">
                                                            <div class="d-flex gap-10 align-items-center mb-2">
                                                                <input id="digital-payment-method-active" type="radio" name="status"
                                                                    value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                                <label for="digital-payment-method-active"
                                                                    class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                                            </div>
                                                            <div class="d-flex gap-10 align-items-center mb-2">
                                                                <input id="digital-payment-method-inactive" type="radio" name="status"
                                                                    value="0" {{($config['status'] ?? null)==0?'checked':''}}>
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
                                    @if ((Helpers::get_user_paymment_methods($customer['id'],'digital_payment')['status'] ?? 0) == 1)
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'ssl_commerz_payment'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'ssl_commerz_payment'])}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('SSLCOMMERZ')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paypal'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'paypal'])}}"
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'stripe'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'stripe'])}}"
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'razor_pay'))
                                                    <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'razor_pay'])}}"
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'senang_pay'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'senang_pay']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('senang_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paytabs'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paytabs']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytabs')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paystack'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paystack']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paystack')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paymob_accept'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paymob_accept']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paymob_accept')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'fawry_pay'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'fawry_pay']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('fawry_pay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'mercadopago'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'mercadopago']):'javascript:'}}"
                                                        method="post">
                                                        @csrf
                                                        <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                            <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('mercadopago')}} ({{ Helpers::translate('for buying') }})</h5>

                                                            <label class="switcher show-status-text">
                                                                <input class="switcher_input" type="checkbox"
                                                                    name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'liqpay'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'liqpay']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))

                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('liqpay')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'flutterwave'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'flutterwave']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('flutterwave')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'paytm'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'paytm']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('paytm')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'bkash'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'bkash']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('bkash')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'myfatoorah'))
                                                    <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'myfatoorah']):'javascript:'}}"
                                                        method="post">
                                                    @csrf
                                                    @if(isset($config))
                                                            @php($config['environment'] = $config['environment']??'sandbox')
                                                            <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                                <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('myfatoorah')}} ({{ Helpers::translate('for buying') }})</h5>

                                                                <label class="switcher show-status-text">
                                                                    <input class="switcher_input" type="checkbox"
                                                                        name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" role="tabpanel" aria-labelledby="bank_transfer">
                                <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'bank_transfer']):'javascript:'}}"
                                method="post" class="row gy-3">
                                @csrf
                                    @php($config['environment'] = $config['environment']??'sandbox')
                                    @php($item_index = 0)
                                    @php($banks=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'bank_transfer'))
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
                                                                            name="bank_transfer[{{$item_index}}][status]" value="1" {{(($config['status'] ?? null) ?? null)==1?'checked':''}}>
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
                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'cash_on_delivery'))
                                            <form action="{{route('admin.customer.payment-method.update',[$customer['id'],'cash_on_delivery'])}}"
                                                  style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                                  method="post">
                                                @csrf
                                                @if(isset($config))
                                                    <label
                                                        class="mb-3 d-block font-weight-bold title-color">{{\App\CPU\Helpers::translate('cash_on_delivery')}} ({{ Helpers::translate('for buying') }})</label>

                                                    <div class="d-flex flex-wrap gap-5">
                                                        <div class="d-flex gap-10 align-items-center mb-2">
                                                            <input id="system-default-payment-method-active" type="radio" name="status"
                                                                   value="1" {{($config['status'] ?? null)==1?'checked':''}}>
                                                            <label for="system-default-payment-method-active"
                                                                   class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                                        </div>
                                                        <div class="d-flex gap-10 align-items-center mb-2">
                                                            <input id="system-default-payment-method-inactive" type="radio" name="status"
                                                                   value="0" {{($config['status'] ?? null)==0?'checked':''}}>
                                                            <label for="system-default-payment-method-inactive"
                                                                   class="title-color mb-0">{{\App\CPU\Helpers::translate('Inactive')}}</label>
                                                        </div>
                                                    </div>
                                                @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'cash_on_delivery_sub'))
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
                                <form action="{{ route('admin.customer.payment-method.update',[$customer['id'],'customer_wallet']) }}" method="post"
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

                                                    @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'customer_wallet'))
                                                    <label class="switcher" for="customer_wallet">
                                                        <input type="checkbox"
                                                            onchange="section_visibility('customer_wallet')" name="wallet_status"
                                                            id="customer_walletcb" value="1"
                                                            data-section="wallet-section" {{isset($config['wallet_status'])&&$config['wallet_status']==1?'checked':''}}>
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
                                                            value="1" {{isset($config['refund_to_wallet'])&&$config['refund_to_wallet']==1?'checked':''}}>
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
                                                            data-section="wallet-section" {{isset($config['wallet_subs_status'])&&$config['wallet_subs_status']==1?'checked':''}}>
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
                                                            value="1" {{isset($config['refund_to_wallet_subs'])&&$config['refund_to_wallet_subs']==1?'checked':''}}>
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
                                            @php($config=\App\CPU\Helpers::get_user_paymment_methods($customer['id'],'delayed'))
                                            <form action="{{env('APP_MODE')!='demo'?route('admin.customer.payment-method.update',[$customer['id'],'delayed']):'javascript:'}}"
                                                method="post">
                                            @csrf
                                            @if(isset($config))
                                                    @php($config['environment'] = $config['environment']??'sandbox')
                                                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-3">
                                                        <h5 class="text-uppercase">{{\App\CPU\Helpers::translate('delayed')}} ({{ Helpers::translate('for buying') }})</h5>

                                                        <label class="switcher show-status-text">
                                                            <input class="switcher_input" type="checkbox"
                                                                   name="status" value="1" {{($config['status'] ?? null)==1?'checked':''}}>
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
        @endif
        @if($customer->is_store)
            @php($store = $customer->store_informations)
            <div class="row mt-0 cu_form" id="account-tab">
                <div class="col-md-12">
                    <div class="card">
                        @if(!isset($new))
                            <div class="card-header text-capitalize">
                                <div class="col-lg-1">
                                    <h5 class="mb-0">{{\App\CPU\Helpers::translate('Store Account')}}</h5>
                                </div>
                                <div class="col-lg-11">
                                @if(($customer['is_active'] ?? '')==1)
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="suspended">
                                        <input type="hidden" name="bool_res" value="1">
                                        <button type="submit"
                                        class="btn btn-sm btn-outline-danger">{{\App\CPU\Helpers::translate('suspend')}}</button>
                                    </form>
                                    @elseif(($customer['is_active'] ?? '')==0)
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="bool_res" value="1">
                                        <button type="submit"
                                                class="btn btn-outline-success">{{\App\CPU\Helpers::translate('activate')}}</button>
                                    </form>
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="2">
                                        <input type="hidden" name="bool_res" value="0">
                                        <button type="submit"
                                        class="btn btn-outline-danger">{{\App\CPU\Helpers::translate('reject')}}</button>
                                    </form>
                                    @elseif(($customer['is_active'] ?? '')==2)
                                    <form class="d-inline-block" action="{{route('admin.customer.status-update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{($customer['id'] ?? '')}}">
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="bool_res" value="1">
                                        <button type="submit"
                                                class="btn btn-outline-success">{{\App\CPU\Helpers::translate('activate')}}</button>
                                    </form>
                                @endif
                                </div>
                            </div>
                        @endif
                        <form class="card-body" method="POST" id="customer_form"
                        enctype="multipart/form-data"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @csrf
                            @include('admin-views.customer.store-profile')
                        </form>
                        <div class="d-flex justify-content-end gap-3" hidden>
                            <button type="reset" id="reset" class="btn btn-secondary px-4" hidden>{{ \App\CPU\Helpers::translate('reset')}}</button>
                            <button type="submit" onclick="check()" class="btn btn--primary btn-primary btn-save px-4" hidden>{{ \App\CPU\Helpers::translate('update')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="orders-tab">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card">
                    <div class="p-3">
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <form action="{{ url()->current() }}" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\Helpers::translate('Search orders')}}" aria-label="Search orders" value="{{ $search }}"
                                            required>
                                        <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('sl')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Order ID')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Total')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($orders as $key=>$order)
                                <tr>
                                    <td>{{$orders->firstItem()+$key}}</td>
                                    <td>
                                        <a href="{{route('admin.orders.details',['id'=>$order['id']])}}" class="title-color hover-c1">{{$order['id']}}</a>
                                    </td>
                                    <td> {{\App\CPU\BackEndHelper::set_symbol(($order['order_amount']))}}</td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-10">
                                            <a class="btn btn-outline--primary btn-sm edit square-btn"
                                                title="{{\App\CPU\Helpers::translate('View')}}"
                                                href="{{route('admin.orders.details',['id'=>$order['id']])}}"><i
                                                    class="tio-invisible"></i> </a>
                                            <a class="btn btn-outline-info btn-sm square-btn"
                                                title="{{\App\CPU\Helpers::translate('Invoice')}}"
                                                target="_blank"
                                                href="{{route('admin.orders.generate-invoice',[$order['id']])}}"><i
                                                    class="tio-download"></i> </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($orders)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                                <p class="mb-0">{{ \App\CPU\Helpers::translate('No_data_to_show')}}</p>
                            </div>
                        @endif
                        <!-- Footer -->
                        <div class="card-footer">
                            <!-- Pagination -->
                        {!! $orders->links() !!}
                        <!-- End Pagination -->
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Card -->
                <div class="card">
                    @if($customer)
                        <div class="card-body">
                            <h4 class="mb-4 d-flex align-items-center gap-2">
                                <img src="{{asset('/public/assets/back-end/img/seller-information.png')}}" alt="">
                                @if($customer->is_store)
                                {{\App\CPU\Helpers::translate('Customer')}}
                                @else
                                {{\App\CPU\Helpers::translate('the end customer')}}
                                @endif
                            </h4>

                            <div class="media">

                                <div class="media-body d-flex flex-column gap-1">
                                    <span class="title-color hover-c1"><strong>{{$customer['f_name'].' '.$customer['l_name']}}</strong></span>
                                    <span class="title-color">
                                        <strong>{{\App\Model\Order::where('customer_id',$customer['id'])->count()}} </strong>{{\App\CPU\Helpers::translate('orders')}}
                                    </span>
                                    <span class="title-color"><strong>{{$customer['phone']}}</strong></span>
                                    <span class="title-color">{{$customer['email']}}</span>
                                    <span class="title-color">{{$customer['street_address']}}</span>
                                    <span class="media-body text-right">
                                        <i class="tio-date-range">
                                        </i> {{\App\CPU\Helpers::translate('Joined At')}} : {{date('d M Y H:i:s',strtotime($customer['created_at']))}}
                                    </span>
                                </div>
                            </div>
                        </div>
                @endif

                <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>

        @if($customer->is_store)
        @php($sub = App\Model\Subscription::where(['user_id'=>$customer->id,'package_id'=>$customer->subscription])->orderBy('id','desc')->first())
        <div class="row bg-white cu_form @if($customer->is_store) d-none @endif" id="subscription-tab">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="p-3">
                    @if($sub)
                    @php($package = \App\Package::find($customer['subscription']))
                    @else
                    @php($package = \App\Package::where('price','0')->first())
                    @endif
                    @if($package)
                    <p class="row">
                        <p class="h3 col-6">
                            @isset($customer->id)
                            {{ \App\CPU\Helpers::get_prop('App\Package',$package['id'] ?? null,'name') }} ({{ Helpers::translate($package->type) }} - {{ $package->period . Helpers::translate('day/days') }})
                            @if (!$sub && Carbon\Carbon::parse($customer->created_at)->addDays($package->period)->lt(Carbon\Carbon::today()))
                                -
                                <strong class="text-danger">
                                    {{ Helpers::translate('expired')}}
                                </strong>
                                @elseif(!$sub)
                                -
                                @php($exp = Carbon\Carbon::parse($package->expiry_date))
                                @php($now = Carbon\Carbon::today())
                                <strong class="text-danger">
                                    @if($exp <= Carbon\Carbon::today())
                                    {{ Helpers::translate('expired from')}}
                                    {{ Carbon\Carbon::today()->diff($exp)->days }}
                                    {{ Helpers::translate('day/days')}}
                                    @else
                                    {{ Carbon\Carbon::today()->diff($exp)->days }}
                                    {{ Helpers::translate('day/days remaining')}}
                                    @endif
                                </strong>
                            @endif
                            :
                            @endisset
                        </p>
                        <p class="h4 col-6">
                            @isset($customer->id)
                            @foreach (\App\services_packaging::all() as $item)
                                @php($name = $item['name'])
                                @foreach($item['translations'] as $t)
                                    @if($t->locale == App::getLocale() && $t->key == "name")
                                        @php($name = $t->value)
                                    @else
                                        @php($name = $item['name'])
                                    @endif
                                @endforeach
                                @if(in_array($item['id'],explode(',',$package['services'])))
                                <option selected value="{{$item['id']}}">
                                    {{ $name }}
                                </option>
                                @endif
                            @endforeach
                            @endisset
                        </p>
                    </p>
                    @endif
                    @if($sub)
                    <p class="row">
                        <p class="h3 col-6">{{ \App\CPU\Helpers::translate('subscription start date')}}: </p>
                        <p class="h4 col-6">
                            <span dir="ltr">
                                {{ Carbon\Carbon::parse($sub->created_at)->format('H:i   Y/m/d') }}
                            </span>
                        </p>
                    </p>
                    <p class="row">
                        <p class="h3 col-6">{{ \App\CPU\Helpers::translate('subscription expiration date')}}: </p>
                        <p class="h4 col-6">
                            @php($exp = Carbon\Carbon::parse($sub->expiry_date))
                            @php($now = Carbon\Carbon::today())
                            <span dir="ltr">
                                {{ Carbon\Carbon::parse($sub->created_at)->format('H:i') }} {{ $exp->format('Y/m/d') }}
                            </span>
                            <strong class="text-danger my-2">
                                (
                                    @if($exp <= Carbon\Carbon::today())
                                    {{ Helpers::translate('expired from')}}
                                    {{ Carbon\Carbon::today()->diff($exp)->days }}
                                    {{ Helpers::translate('day/days')}}
                                    @else
                                    {{ Carbon\Carbon::today()->diff($exp)->days }}
                                    {{ Helpers::translate('day/days remaining')}}
                                    @endif
                                )
                            </strong>
                        </p>
                    </p>
                    <p class="row">
                        <p class="h3 col-6">{{ \App\CPU\Helpers::translate('Payment method')}}: </p>
                        <p class="h4 col-6">{{ Helpers::translate($sub['payment_method']) }} - {{\App\CPU\BackEndHelper::set_symbol(($sub['amount']))}}</p>
                    </p>
                    @if($sub['payment_method'] !== "bank_transfer")
                    <p class="row">
                        <p class="h3 col-6">{{ \App\CPU\Helpers::translate('Reference number')}}: </p>
                        <p class="h4 col-6">
                            @if ($sub->attachment)
                            @if (file_exists(asset('/storage/app/public/user/').'/'.$sub->attachment))
                            @else
                                {{ $sub->attachment }}
                            @endif
                            @endif
                        </p>
                    </p>
                    @endif
                    @if ($sub->attachment)
                    <p class="row">
                        <p class="h3 col-6">{{ \App\CPU\Helpers::translate('attachment')}}: </p>
                        <p class="h4 col-6">
                            <a target="_blank" href="{{ asset('/storage/app/public/user/').'/'.$sub->attachment }}">
                                {{ Helpers::translate('view') }} / {{ Helpers::translate('download') }}
                            </a>
                        </p>
                    </p>
                    @endif
                    <p class="row">
                        <p class="h3 col-6">{{ \App\CPU\Helpers::translate('Subscription status')}}: </p>
                        <p class="h4 col-6">{{ Helpers::translate($sub['status']) }}</p>
                    </p
                    @endif
                </div>
            </div>
        </div>
        <!-- End Row -->
        @endif
    </div>
@endsection

@push('script_2')

    @if($customer->is_store)
    {{--  map  --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.49"></script>
    <script src="{{ asset('public/assets/front-end/js/bootstrap-select.min.js') }}"></script>
    <script>
        function initAutocomplete() {
            var myLatLng = { lat: {{$shipping_latitude??'-33.8688'}}, lng: {{$shipping_longitude??'151.2195'}} };

            const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
                center: { lat: {{$shipping_latitude??'23.8859'}}, lng: {{$shipping_longitude??'45.0792'}} },
                zoom: 16,
                mapTypeId: "roadmap",
                streetViewControl:false,
            });

            //
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
            });
            addYourLocationButton(map, marker);
            //

            var userMarker = new google.maps.Marker({
                map: map,
                title: 'My Location'
            });


            marker.setMap( map );
            var geocoder = geocoder = new google.maps.Geocoder();
            google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                var coordinates = JSON.parse(coordinates);
                var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
                marker.setPosition( latlng );
                map.panTo( latlng );

                document.getElementById('latitude').value = coordinates['lat'];
                document.getElementById('longitude').value = coordinates['lng'];

                geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById('address').value = results[1].formatted_address;
                            console.log(results[1].formatted_address);
                        }
                    }
                });
            });

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var mrkr = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    google.maps.event.addListener(mrkr, "click", function (event) {
                        document.getElementById('latitude').value = this.position.lat();
                        document.getElementById('longitude').value = this.position.lng();

                    });

                    markers.push(mrkr);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        };
        $(document).on('ready', function () {
            initAutocomplete();

        });

        $(document).on("keydown", "input", function(e) {
        if (e.which==13) e.preventDefault();
        });
    </script>
    {{--  end map  --}}
    @endif
    <script>
        function check() {
            $(".error_required").removeClass('error_required');
            $(".error_required_message").remove();
            var formData = new FormData(document.getElementById('customer_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: @isset($customer['id']) '{{route("admin.customer.update_",['id' => $customer->id])}}' @else '{{route("admin.customer.update",['id' => 0])}}' @endisset
                ,data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            if(data.errors[i].code == "brand_id"){
                                $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertBefore(".brand_id_div");
                            }
                            var nm = data.errors[i].code.indexOf('.') >= 0 ? data.errors[i].code.replace('.','[')+']' : data.errors[i].code;
                            var nmEmptyBrackets
                            var result = nm.match(/\[(.*)\]/);
                            if(result){
                                nmEmptyBrackets = nm.replace(result[0],'[]')
                                if(!isNaN(parseInt(result[1]))){
                                    nm = nm.replace(result[0],'[]')
                                }
                            }
                            if(nm == "country"){
                                $(".sumo_country").addClass("error_required");
                            }
                            if(nm == "area"){
                                $(".sumo_area").addClass("error_required");
                            }
                            if(nm == "city"){
                                $(".sumo_city").addClass("error_required");
                            }
                            if(nm == "governorate"){
                                $(".sumo_governorate").addClass("error_required");
                            }
                            if(nm == "pricing_level"){
                                $(".sumo_pricing_level").addClass("error_required");
                            }
                            if(nm == "image"){
                                $("input[name='"+nm+"']").parent().addClass("error_required");
                            }
                            if(nm == "banner"){
                                $(".banner-control").addClass("error_required");
                            }
                            if(nm == "commercial_registration_img"){
                                $("input[name='"+nm+"']").parent().addClass("error_required");
                            }
                            if(nm == "tax_certificate_img"){
                                $("input[name='"+nm+"']").parent().addClass("error_required");
                            }
                            $("input[name='"+nm+"']").addClass("error_required");
                            $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                            $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").appendTo($("input[name='"+nm+"']").closest('.form-group'));
                        }
                        toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        @if(Helpers::module_permission_check('admin.customers.edit'))
                        toastr.success('{{ Helpers::translate('updated successfully!') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        @endif
                        $('#customer_form').submit();
                    }
                }
            });
        }
    </script>
    <script>
        $(".cu_link").click(function (e) {
            e.preventDefault();
            $(".cu_link").removeClass('active');
            $(".cu_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let x = form_id.split("-")[0];
            $("#" + x + "-tab").removeClass('d-none');
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer1').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL_(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL__(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer3').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL___(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer4').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload1").change(function () {
            readURL(this);
        });

        $("#customFileUpload2").change(function () {
            readURL_(this);
        });

        $("#customFileUpload3").change(function () {
            readURL__(this);
        });

        $("#customFileUpload4").change(function () {
            readURL___(this);
        });
    </script>
@endpush
