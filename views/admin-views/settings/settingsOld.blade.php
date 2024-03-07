@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Settings'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .flip-card {
            background-color: transparent;
            width: 350px;
            height: 250px;
            perspective: 1000px;
            padding: 20px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }

        .flip-cardd:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .flip-card-front {
            color: white;
            background-color: #041562;
        }

        .flip-card-back,.flip-card-front {
            border-radius: 11px;
            padding: 20px
        }

        .flip-card-back {
            background-color: #041562;
            color: white;
            transform: rotateY(180deg);
            overflow-y: auto;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            padding: 15px;
        }

        .navbar-vertical-aside-has-menu{
            text-align: start
        }

        .nav-card, .nav-card *{
            background-color: #041562;
            color: white;
        }

        .p-relative{
            position: relative;
        }

        .p-absolute{
            position: absolute;
        }
    </style>
@endpush

@section('content')
<div class="w-100 d-flex flex-wrap justify-content-center">
    <div class="flip-card flip-cardd">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <a href="#">
                    <h1 class="text-center text-primary w-100"><i class="fa fa-"></i></h1>
                    <h3 class="text-center text-white w-100 mb-4"></h3>
                    <h3 class="text-center text-white w-100"> {{\App\CPU\Helpers::translate('business_settings')}} </h3>
                </a>
            </div>
            <div class="flip-card-back">
                <div class="text-light mb-2">
                    <ul class="js-navbar-vertical-aside-submenu nav nav-card px-0 d-block" style="text-align-last: start">

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/seller-settings*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('admin.business-settings.seller-settings.index')}}">
                                <i class="tio-user-big-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('seller_settings')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/payment-method')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('admin.business-settings.payment-method.index')}}">
                                <i class="tio-money-vs nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('payment_method')}}
                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/sms-module')?'active':''}}">
                            <a class="nav-link" href="{{route('admin.business-settings.sms-module')}}"
                            title="{{\App\CPU\Helpers::translate('sms settings module')}}">
                                <i class="tio-sms-active-outlined nav-icon"></i>
                                <span
                                    class="text-truncate">{{\App\CPU\Helpers::translate('sms module settings')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/shipping-method/setting')?'active':''}}">
                            <a class="nav-link" href="{{route('admin.business-settings.shipping-method.setting')}}"
                            title="{{\App\CPU\Helpers::translate('shipping')}}">
                                <i class="tio-car nav-icon"></i>
                                <span
                                    class="text-truncate">{{\App\CPU\Helpers::translate('shipping')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/language*')?'active':''}}">
                            <a class="nav-link" href="{{route('admin.business-settings.language.index')}}"
                            title="{{\App\CPU\Helpers::translate('languages')}}">
                                <i class="tio-book-opened nav-icon"></i>
                                <span class="text-truncate">{{\App\CPU\Helpers::translate('languages')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/social-login/view')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('admin.social-login.view')}}">
                                <i class="tio-top-security-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('social_login')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/currency/view')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('admin.currency.view')}}">
                                <i class="tio-dollar-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('currencies')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/transaction/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('admin.transaction.list')}}">
                                <i class="tio-money nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            {{\App\CPU\Helpers::translate('order_Transactions')}}
                            </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/transaction/refund-list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="#">
                                <i class="tio-money nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            {{\App\CPU\Helpers::translate('refund_Transactions')}}
                            </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flip-card flip-cardd">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <a href="#">
                    <h1 class="text-center text-primary w-100"><i class="fa fa-"></i></h1>
                    <h3 class="text-center text-white w-100 mb-4"></h3>
                    <h3 class="text-center text-white w-100"> {{\App\CPU\Helpers::translate('web_&_app_settings')}} </h3>
                </a>
            </div>
            <div class="flip-card-back">
                <div class="text-light mb-2">
                    <ul class="js-navbar-vertical-aside-submenu nav nav-card px-0 d-block" style="text-align-last: start">
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/web-config')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.web-config.index')}}">
                                <i class="tio-globe nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('web_config')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/web-config/db-index')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.web-config.db-index')}}">
                                <i class="tio-cloud nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('clean_database')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/web-config/environment-setup')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.web-config.environment-setup')}}">
                                <i class="tio-labels nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('environment_setup')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/web-config/refund-index')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="#">
                                <i class="tio-money nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('refund_settings')}}
                                </span>
                            </a>
                        </li>
                        @if(1==0)
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/analytics-index')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.analytics-index')}}">
                                <i class="tio-chart-pie-2 nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('analytics')}}
                                </span>
                            </a>
                        </li>
                        @endif
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/mail')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.mail.index')}}">
                                <i class="tio-email nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('mail_config')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/fcm-index')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.fcm-index')}}">
                                <i class="tio-notifications-alert nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('notification')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                href="javascript:">
                                <i class="tio-pages-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('page_setup')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                style="display: {{Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/business-settings/terms-condition')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.business-settings.terms-condition')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CPU\Helpers::translate('terms_and_condition')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/business-settings/privacy-policy')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.business-settings.privacy-policy')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CPU\Helpers::translate('privacy_policy')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/business-settings/about-us')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.business-settings.about-us')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CPU\Helpers::translate('about_us')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/helpTopic/list')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.helpTopic.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CPU\Helpers::translate('faq')}}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/social-media')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.business-settings.social-media')}}">
                                <i class="tio-twitter nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('social_media')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/map-api*')?'active':''}}">
                            <a class="nav-link" href="{{route('admin.business-settings.map-api')}}"
                                title="{{\App\CPU\Helpers::translate('third_party_apis')}}"
                            >
                                <span class="tio-key nav-icon"></span>
                                <span
                                    class="text-truncate">{{\App\CPU\Helpers::translate('third_party_apis')}}</span>
                            </a>
                        </li>
                        @if(1==0)
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/file-manager*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.file-manager.index')}}">
                                <i class="tio-album nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('gallery')}}
                                </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flip-card flip-cardd">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <a href="#">
                    <h1 class="text-center text-primary w-100"><i class="fa fa-"></i></h1>
                    <h3 class="text-center text-white w-100 mb-4"></h3>
                    <h3 class="text-center text-white w-100"> {{\App\CPU\Helpers::translate('Reports')}} </h3>
                </a>
            </div>
            <div class="flip-card-back">
                <div class="text-light mb-2">
                    <ul class="js-navbar-vertical-aside-submenu nav nav-card px-0 d-block" style="text-align-last: start">
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/stock/product-stock')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="{{route('admin.stock.product-stock')}}">
                                <i class="tio-fullscreen-1-1 nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            {{\App\CPU\Helpers::translate('products stock reports')}}
                            </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/earning')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.report.earning')}}">
                                <i class="tio-chart-pie-1 nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('Earnings Report')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/order')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="{{route('admin.report.order')}}">
                                <i class="tio-chart-bar-1 nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('Orders Report')}}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/report/inhoue-product-sale') || Request::is('admin/report/seller-product-sale') ?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                                href="javascript:">
                                <i class="tio-chart-bar-4 nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('sales report')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                style="display: {{Request::is('admin/report/inhoue-product-sale') || Request::is('admin/report/seller-product-sale') ?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/report/inhoue-product-sale')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.report.inhoue-product-sale')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">
                                            {{\App\CPU\Helpers::translate('inhouse sales')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/report/seller-product-sale')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.report.seller-product-sale')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize">
                                            {{\App\CPU\Helpers::translate('sellers sales')}}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{Request::is('admin/product/stock-limit-list/in_house')?'active':''}}">
                            <a class="nav-link" href="{{route('admin.product.stock-limit-list',['in_house', ''])}}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">{{\App\CPU\Helpers::translate('stock_limit_products')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flip-card flip-cardd">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <a href="#">
                    <h1 class="text-center text-primary w-100"><i class="fa fa-"></i></h1>
                    <h3 class="text-center text-white w-100 mb-4"></h3>
                    <h3 class="text-center text-white w-100"> {{\App\CPU\Helpers::translate('employee_section')}} </h3>
                </a>
            </div>
            <div class="flip-card-back">
                <div class="text-light mb-2">
                    <ul class="js-navbar-vertical-aside-submenu nav nav-card px-0 d-block" style="text-align-last: start">
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/custom-role*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('admin.custom-role.create')}}">
                                <i class="tio-incognito nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{\App\CPU\Helpers::translate('employee_role')}}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/employee*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:">
                                <i class="tio-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{\App\CPU\Helpers::translate('employees')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                style="display: {{Request::is('admin/employee*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/employee/add-new')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.employee.add-new')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\Helpers::translate('add_new')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/employee/list')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.employee.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\Helpers::translate('employees list')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flip-card flip-cardd">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <a href="#">
                    <h1 class="text-center text-primary w-100"><i class="fa fa-"></i></h1>
                    <h3 class="text-center text-white w-100 mb-4"></h3>
                    <h3 class="text-center text-white w-100"> {{\App\CPU\Helpers::translate('delivery_man_management')}} </h3>
                </a>
            </div>
            <div class="flip-card-back">
                <div class="text-light mb-2">
                    <ul class="js-navbar-vertical-aside-submenu nav nav-card px-0 d-block" style="text-align-last: start">
                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/delivery-man*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle"
                               href="javascript:">
                                <i class="tio-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                        {{\App\CPU\Helpers::translate('delivery-man')}}
                                    </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                style="display: {{Request::is('admin/delivery-man*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('admin/delivery-man/add')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.delivery-man.add')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\Helpers::translate('add_new')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('admin/delivery-man/list')?'active':''}}">
                                    <a class="nav-link px-5" href="{{route('admin.delivery-man.list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{\App\CPU\Helpers::translate('delivery man List')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flip-card flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front p-relative">
                <a href="/admin/pricing-levels" class="p-absolute w-100 h-100" style="top: 0; left: 0">
                    <h1 class="text-center text-primary w-100"><i class="fa fa-"></i></h1>
                    <h3 class="text-center text-white w-100 mb-4"></h3>
                    <h3 class="text-center text-white w-100"> {{\App\CPU\Helpers::translate('Pricing Levels')}} </h3>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
