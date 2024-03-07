<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/business-settings/web-config') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.index')}}">{{\App\CPU\Helpers::translate('general')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/web-config/app-settings') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.app-settings')}}">{{\App\CPU\Helpers::translate('App_Settings')}}</a></li>
        <li class="{{ Request::is('admin/product-settings/inhouse-shop') ?'active':'' }}"><a href="{{ route('admin.product-settings.inhouse-shop') }}">{{\App\CPU\Helpers::translate('In-House_Shop')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/seller-settings') ?'active':'' }}"><a href="{{route('admin.business-settings.seller-settings.index')}}">{{\App\CPU\Helpers::translate('Seller')}}</a></li>
        <li class="{{ Request::is('admin/customer/customer-settings') ?'active':'' }}"><a href="{{route('admin.customer.customer-settings')}}">{{\App\CPU\Helpers::translate('Customer')}}</a></li>
        <li class="{{ Request::is('admin/refund-section/refund-index') ?'active':'' }}"><a href="{{route('admin.refund-section.refund-index')}}">{{\App\CPU\Helpers::translate('Refund')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/shipping-method/setting') ?'active':'' }}"><a href="{{route('admin.business-settings.shipping-method.setting')}}">{{\App\CPU\Helpers::translate('Shipping_Method')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/order-settings/index') ?'active':'' }}"><a href="{{route('admin.business-settings.order-settings.index')}}">{{\App\CPU\Helpers::translate('Order')}}</a></li>
        <li class="{{ Request::is('admin/product-settings') ?'active':'' }}"><a href="{{ route('admin.product-settings.index') }}">{{\App\CPU\Helpers::translate('Product')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/delivery-restriction') ? 'active':'' }}"><a href="{{ route('admin.business-settings.delivery-restriction.index') }}">{{\App\CPU\Helpers::translate('delivery_restriction')}}</a></li>


        <li class="{{ Request::is('admin/business-settings/web-config/environment-setup') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.environment-setup')}}">{{\App\CPU\Helpers::translate('Environment_Setup')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/web-config/mysitemap') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.mysitemap')}}">{{\App\CPU\Helpers::translate('Generate_Site_Map')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/analytics-index') ?'active':'' }}"><a href="{{route('admin.business-settings.analytics-index')}}">{{\App\CPU\Helpers::translate('Analytic_Script')}}</a></li>
        <li class="{{ Request::is('admin/currency/view') ?'active':'' }}"><a href="{{route('admin.currency.view')}}">{{\App\CPU\Helpers::translate('Currency_Setup')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/language') ?'active':'' }}"><a href="{{route('admin.business-settings.language.index')}}">{{\App\CPU\Helpers::translate('Languages')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/web-config/db-index') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.db-index')}}">{{\App\CPU\Helpers::translate('Clean_Database')}}</a></li>


        <li class="{{(Request::is('admin/business-settings/terms-condition') || Request::is('admin/business-settings/privacy-policy') || Request::is('admin/business-settings/about-us') || Request::is('admin/helpTopic/list'))?'active':''}}">
            <a href="{{route('admin.business-settings.terms-condition')}}"
               title="{{\App\CPU\Helpers::translate('pages')}}">
              {{\App\CPU\Helpers::translate('pages')}}
            </span>
            </a>
        </li>
        <li class="{{Request::is('admin/business-settings/social-media')?'active':''}}">
            <a
               href="{{route('admin.business-settings.social-media')}}"
               title="{{\App\CPU\Helpers::translate('Social_Media_Links')}}">
            {{\App\CPU\Helpers::translate('Social_Media_Links')}}
        </span>
            </a>
        </li>

        <li class="{{Request::is('admin/file-manager*')?'active':''}}">
            <a
               href="{{route('admin.file-manager.index')}}"
               title="{{\App\CPU\Helpers::translate('gallery')}}">
                {{\App\CPU\Helpers::translate('gallery')}}
            </span>
            </a>
        </li>

        <li class="{{ Request::is('admin/packages') ?'active':'' }}">
            <a href="{{route('admin.package.list')}}">
                {{\App\CPU\Helpers::translate('Packages')}}
            </a>
        </li>

        <li class="{{ Request::is('admin/packages-services') ?'active':'' }}">
            <a href="{{route('admin.ServicesPackaging.list')}}">
                {{\App\CPU\Helpers::translate('Packages services')}}
            </a>
        </li>


    </ul>
</div>
