<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/business-settings/sms-module') ?'active':'' }}"><a href="{{route('admin.business-settings.sms-module')}}">{{\App\CPU\Helpers::translate('SMS_Config')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/mail') ?'active':'' }}"><a href="{{route('admin.business-settings.mail.index')}}">{{\App\CPU\Helpers::translate('Mail_Config')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/payment-method') ?'active':'' }}"><a href="{{route('admin.business-settings.payment-method.index')}}">{{\App\CPU\Helpers::translate('Payment_Methods')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/captcha') ?'active':'' }}"><a href="{{route('admin.business-settings.captcha')}}">{{\App\CPU\Helpers::translate('Recaptcha')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/map-api') ?'active':'' }}"><a href="{{route('admin.business-settings.map-api')}}">{{\App\CPU\Helpers::translate('Google_Map_APIs')}}</a></li>
        <li class="{{ Request::is('admin/business-settings/fcm-index') ?'active':'' }}"><a href="{{route('admin.business-settings.fcm-index')}}">{{\App\CPU\Helpers::translate('Push_Notification_Setup')}}</a></li>
        <li class="{{ Request::is('admin/social-login/view') ?'active':'' }}"><a href="{{route('admin.social-login.view')}}">{{\App\CPU\Helpers::translate('Social_Media_Login')}}</a></li>
    </ul>
</div>
