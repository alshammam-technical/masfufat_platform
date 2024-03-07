<style>
    .navbar-vertical-aside-has-menu.active {
        background-color: #673bb7;
        border-radius: 11px;
        padding-left: 5px;
        padding-right: 5px;
    }

    .navbar-vertical-aside-has-menu.active *{
        color: white;
    }
</style>
<div class="mt-2 mx-6 position-fixed bg-white" style="border-radius: 11px;width: 310px">
    <ul class="list-unstyled m-3" style="overflow-y: auto;height: 700px;">



        <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/web-config') || Request::is('admin/business-settings/web-config/app-settings') || Request::is('admin/product-settings/inhouse-shop') || Request::is('admin/business-settings/seller-settings') || Request::is('admin/customer/customer-settings') || Request::is('admin/refund-section/refund-index') || Request::is('admin/business-settings/shipping-method/setting') || Request::is('admin/business-settings/order-settings/index') || Request::is('admin/product-settings') || Request::is('admin/business-settings/web-config/delivery-restriction') || Request::is('admin/business-settings/web-config/environment-setup') || Request::is('admin/business-settings/web-config/mysitemap') || Request::is('admin/business-settings/analytics-index') || Request::is('admin/currency/view') || Request::is('admin/business-settings/web-config/db-index') || Request::is('admin/business-settings/language*') || Request::is('admin/business-settings/language*') || Request::is('admin/business-settings/social-media*') || Request::is('admin/file-manager/index*'))?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
               href="javascript:" title="{{\App\CPU\Helpers::translate('Business_Setup')}}">
                <i class="tio-globe nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                    {{\App\CPU\Helpers::translate('Business_Setup')}}
                </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('admin/delivery-man*')?'none':'none'}}">
                @if (\App\CPU\Helpers::module_permission_check('web-config.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/web-config') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.web-config.index')}}">{{\App\CPU\Helpers::translate('general')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('web-config.app.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/web-config/app-settings') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.web-config.app-settings')}}">{{\App\CPU\Helpers::translate('App_Settings')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('inhouse-shop.view'))
                <li class="nav-item {{ Request::is('admin/product-settings/inhouse-shop') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.product-settings.inhouse-shop') }}">{{\App\CPU\Helpers::translate('In-House_Shop')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('seller-settings.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/seller-settings') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.seller-settings.index')}}">{{\App\CPU\Helpers::translate('Seller')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('customer-settings.view'))
                <li class="nav-item {{ Request::is('admin/customer/customer-settings') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.customer.customer-settings')}}">{{\App\CPU\Helpers::translate('shops settings')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('refund-section.view'))
                <li class="nav-item {{ Request::is('admin/refund-section/refund-index') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.refund-section.refund-index')}}">{{\App\CPU\Helpers::translate('Refund')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('shipping-method.setting.view,shipping-method.setting.add'))
                <li class="nav-item {{ Request::is('admin/business-settings/shipping-method/setting') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.shipping-method.setting')}}">{{\App\CPU\Helpers::translate('Shipping_Method')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('order-settings.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/order-settings/index') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.order-settings.index')}}">{{\App\CPU\Helpers::translate('Order settings')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('product-settings.view'))
                <li class="nav-item {{ Request::is('admin/product-settings') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.product-settings.index') }}">{{\App\CPU\Helpers::translate('Products Settings')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('delivery-restriction.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/delivery-restriction') ? 'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.business-settings.delivery-restriction.index') }}">{{\App\CPU\Helpers::translate('delivery_restriction')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('web-config.environment.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/web-config/environment-setup') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.web-config.environment-setup')}}">{{\App\CPU\Helpers::translate('Environment_Setup')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('web-config.mysitemap.download'))
                <li class="nav-item {{ Request::is('admin/business-settings/web-config/mysitemap') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.web-config.mysitemap')}}">{{\App\CPU\Helpers::translate('Generate_Site_Map')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('analytics-index.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/analytics-index') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.analytics-index')}}">{{\App\CPU\Helpers::translate('Analytic_Script')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('currency.view'))
                <li class="nav-item {{ Request::is('admin/currency/view') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.currency.view')}}">{{\App\CPU\Helpers::translate('Currency_Setup')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('language.view'))
                <li class="nav-item {{ Request::is('admin/business-settings/language') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.language.index')}}">{{\App\CPU\Helpers::translate('Languages')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('web-config.db.clear'))
                <li class="nav-item {{ Request::is('admin/business-settings/web-config/db-index') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.web-config.db-index')}}">{{\App\CPU\Helpers::translate('Database setup')}}</a></li>
                @endif
                @if (Helpers::module_permission_check('admin.business-settings.terms-condition,admin.business-settings.terms-condition,admin.business-settings.warranty-policy,admin.business-settings.about-us,admin.business-settings.privacy-policy'))
                <li class="nav-item {{(Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list'))?'active':''}}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link"

                    @if(Helpers::module_permission_check('admin.business-settings.terms-condition'))
                        href="{{route('admin.business-settings.terms-condition')}}"
                    @elseif(Helpers::module_permission_check('admin.business-settings.about-us'))
                        href="{{route('admin.business-settings.about-us')}}"
                    @elseif(Helpers::module_permission_check('admin.business-settings.privacy-policy'))
                        href="{{route('admin.business-settings.privacy-policy')}}"
                    @elseif(Helpers::module_permission_check('admin.business-settings.warranty-policy'))
                        href="{{route('admin.business-settings.warranty-policy')}}"
                    @endif


                    title="{{\App\CPU\Helpers::translate('pages setup')}}">
                    {{\App\CPU\Helpers::translate('pages setup')}}
                    </span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('social-media.view'))
                <li class="nav-item {{Request::is('admin/business-settings/social-media')?'active':''}}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                    href="{{route('admin.business-settings.social-media')}}"
                    title="{{\App\CPU\Helpers::translate('Social_Media_Links')}}">
                    {{\App\CPU\Helpers::translate('Social_Media_Links setup')}}
                    </span>
                    </a>
                </li>

                @endif
                @if (\App\CPU\Helpers::module_permission_check('file-manager.view'))
                <li class="nav-item {{Request::is('admin/file-manager*')?'active':''}}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                    href="{{route('admin.file-manager.index')}}"
                    title="{{\App\CPU\Helpers::translate('gallery')}}">
                        {{\App\CPU\Helpers::translate('gallery')}}
                    </span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('admin.package.view'))
                <li class="nav-item {{ Request::is('admin/packages') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.package.list')}}">
                        {{\App\CPU\Helpers::translate('Packages')}}
                    </a>
                </li>

                @endif
                @if (\App\CPU\Helpers::module_permission_check('admin.ServicesPackaging.view'))
                <li class="nav-item {{ Request::is('admin/packages-services') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.ServicesPackaging.list')}}">
                        {{\App\CPU\Helpers::translate('Packages services')}}
                    </a>
                </li>
                @endif

                @if (\App\CPU\Helpers::module_permission_check('admin.pricing-levels.view'))
                <li class="nav-item {{ Request::is('admin/pricing-levels') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.pricing_levels.list')}}">
                        {{\App\CPU\Helpers::translate('Pricing levels')}}
                    </a>
                </li>
                @endif

                @if (\App\CPU\Helpers::module_permission_check('required_fields.view'))
                <li class="nav-item {{ Request::is('admin/required_fields') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.required_fields.index')}}">
                        {{\App\CPU\Helpers::translate('required_fields')}}
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <li class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/mail') || Request::is('admin/business-settings/sms-module') || Request::is('admin/business-settings/captcha') || Request::is('admin/social-login/view') || Request::is('admin/business-settings/map-api') || Request::is('admin/business-settings/payment-method') || Request::is('admin/business-settings/fcm-index'))?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
               href="javascript:" title="{{\App\CPU\Helpers::translate('3rd_party')}}">
                <i class="tio-truck nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                    {{\App\CPU\Helpers::translate('3rd_party')}}
                </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{(Request::is('admin/business-settings/mail') || Request::is('admin/business-settings/sms-module') || Request::is('admin/business-settings/captcha') || Request::is('admin/social-login/view') || Request::is('admin/business-settings/map-api') || Request::is('admin/business-settings/payment-method') || Request::is('admin/business-settings/fcm-index'))?'block':'none'}}">
                @if (\App\CPU\Helpers::module_permission_check('sms-module.view'))
                <li class="{{ Request::is('admin/business-settings/sms-module') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.sms-module')}}">{{\App\CPU\Helpers::translate('SMS_Config')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('mail-module.view'))
                <li class="{{ Request::is('admin/business-settings/mail') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.mail.index')}}">{{\App\CPU\Helpers::translate('Mail_Config')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('payment-method.view'))
                <li class="{{ Request::is('admin/business-settings/payment-method') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.payment-method.index')}}">{{\App\CPU\Helpers::translate('Payment_Methods')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('map-api.view'))
                <li class="{{ Request::is('admin/business-settings/map-api') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.map-api')}}">{{\App\CPU\Helpers::translate('google map api setup')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('fcm-index.view'))
                <li class="{{ Request::is('admin/business-settings/fcm-index') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.fcm-index')}}">{{\App\CPU\Helpers::translate('Push_Notification_Setup')}}</a></li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('social-login.view'))
                <li class="{{ Request::is('admin/social-login/view') ?'active':'' }}"><a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.social-login.view')}}">{{\App\CPU\Helpers::translate('Social_Media_Login')}}</a></li>
                @endif
            </ul>
        </li>


        <li class="navbar-vertical-aside-has-menu text-start {{(Request::is('admin/employee*') || Request::is('admin/custom-role*'))?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
               href="javascript:" title="{{\App\CPU\Helpers::translate('employees')}}">
                <i class="fa fa-user nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                {{\App\CPU\Helpers::translate('employees')}}
            </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub mx-0 px-0"
                style="display: {{Request::is('admin/employee*') || Request::is('admin/custom-role*')?'block':'none'}}">
                @if (\App\CPU\Helpers::module_permission_check('custom-role.create.view'))
                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/custom-role*')?'active':''}}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link mx-0 px-2"
                       href="{{route('admin.custom-role.create')}}"
                       title="{{\App\CPU\Helpers::translate('Employee_Role_Setup')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                    {{\App\CPU\Helpers::translate('Employee_Role_Setup')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('employee.view'))
                <li class="nav-item {{(Request::is('admin/employee/list') || Request::is('admin/employee/add-new') || Request::is('admin/employee/update*'))?'active':''}}">
                    <a class="nav-link" href="{{route('admin.employee.list')}}"
                       title="{{\App\CPU\Helpers::translate('Employees')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('Employees')}}</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>


        <li class="navbar-vertical-aside-has-menu text-start {{Request::is('admin/delivery-man*')?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
               href="javascript:" title="{{\App\CPU\Helpers::translate('delivery-man')}}">
                <i class="tio-truck nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                    {{\App\CPU\Helpers::translate('delivery-man')}}
                </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                style="display: {{Request::is('admin/delivery-man*')?'block':'none'}}">
                @if (\App\CPU\Helpers::module_permission_check('delivery-man.view'))
                <li class="nav-item {{Request::is('admin/delivery-man/list') || Request::is('admin/delivery-man/earning-statement*') || Request::is('admin/delivery-man/earning-active-log*') || Request::is('admin/delivery-man/order-wise-earning*')?'active':''}}">
                    <a class="nav-link" href="{{route('admin.delivery-man.list')}}"
                       title="{{\App\CPU\Helpers::translate('List')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('List')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('delivery-man.chat.view'))
                <li class="nav-item {{Request::is('admin/delivery-man/chat')?'active':''}}">
                    <a class="nav-link" href="{{route('admin.delivery-man.chat')}}"
                       title="{{\App\CPU\Helpers::translate('Chat')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('deliverymen chats')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('delivery-man.withdraw-list.view'))
                <li class="nav-item {{Request::is('admin/delivery-man/withdraw-list') || Request::is('admin/delivery-man/withdraw-view*')?'active':''}}">
                    <a class="nav-link " href="{{route('admin.delivery-man.withdraw-list')}}"
                       title="{{\App\CPU\Helpers::translate('withdraws')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('deliverymen wallet balances')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('emergency-contact.view'))
                <li class="nav-item {{Request::is('admin/delivery-man/emergency-contact')?'active':''}}">
                    <a class="nav-link " href="{{route('admin.delivery-man.emergency-contact.index')}}"
                       title="{{\App\CPU\Helpers::translate('emergency_contact')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('Emergency_Contact')}}</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>

        <li class="navbar-vertical-aside-has-menu text-start {{Request::is('admin/country*')?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
               href="javascript:" title="{{\App\CPU\Helpers::translate('Configure geographical locations')}}">
                <i class="fa fa-globe nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                    {{\App\CPU\Helpers::translate('Configure geographical locations')}}
                </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                style="display: {{Request::is('admin/country*')?'block':'none'}}">
                @if (\App\CPU\Helpers::module_permission_check('admin.countries.view'))
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.countries.list')}}"
                       title="{{\App\CPU\Helpers::translate('Countries')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('Countries')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('admin.areas.view'))
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.areas.list')}}"
                       title="{{\App\CPU\Helpers::translate('Areas')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('Areas')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('admin.cities.view'))
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.cities.list')}}"
                       title="{{\App\CPU\Helpers::translate('cities')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('cities')}}</span>
                    </a>
                </li>
                @endif
                @if (\App\CPU\Helpers::module_permission_check('admin.provinces.view'))
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.provinces.list')}}"
                       title="{{\App\CPU\Helpers::translate('provinces')}}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('provinces')}}</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>


    </ul>
</div>
