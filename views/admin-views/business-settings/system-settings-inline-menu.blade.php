<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/business-settings/web-config/environment-setup') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.environment-setup')}}">{{\App\CPU\Helpers::translate('Environment_Setup')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/web-config/mysitemap') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.mysitemap')}}">{{\App\CPU\Helpers::translate('Generate_Site_Map')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/analytics-index') ?'active':'' }}"><a href="{{route('admin.business-settings.analytics-index')}}">{{\App\CPU\Helpers::translate('Analytic_Script')}}</a></li>
        <li class="{{ Request::is('admin/currency/view') ?'active':'' }}"><a href="{{route('admin.currency.view')}}">{{\App\CPU\Helpers::translate('Currency_Setup')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/language') ?'active':'' }}"><a href="{{route('admin.business-settings.language.index')}}">{{\App\CPU\Helpers::translate('Languages')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/web-config/db-index') ?'active':'' }}"><a href="{{route('admin.business-settings.web-config.db-index')}}">{{\App\CPU\Helpers::translate('Clean_Database')}}</a></li>
    </ul>
</div>
