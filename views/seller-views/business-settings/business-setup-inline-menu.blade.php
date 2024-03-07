<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('seller/shop/*') ?'active':'' }}">
            <a href="{{route('seller.shop.view')}}">
                {{\App\CPU\Helpers::translate('My_Shop')}}
            </a>
        </li>

        <li class="{{ Request::is('seller/profile/*') ?'active':'' }}">
            <a href="{{route('seller.profile.view')}}">
                {{\App\CPU\Helpers::translate('My_Bank_Info')}}
            </a>
        </li>

        <li class="{{ Request::is('seller/business-settings/wallet/*') ?'active':'' }}">
            <a href="{{route('seller.business-settings.wallet.report')}}">
                {{\App\CPU\Helpers::translate('wallet')}}
            </a>
        </li>

        <li class="{{ Request::is('seller/business-settings/shipping-method/*') ?'active':'' }}">
            <a href="{{route('seller.business-settings.shipping-method.setting')}}">
                {{\App\CPU\Helpers::translate('Shipping_Method')}}
            </a>
        </li>
    </ul>
</div>
