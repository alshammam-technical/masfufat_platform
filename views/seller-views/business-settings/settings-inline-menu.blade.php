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
<div class="mt-2 mx-4 position-fixed bg-white" style="border-radius: 11px">
    <ul class="list-unstyled m-3" style="overflow-y: auto;height: 700px;width:200px">
        <li class="navbar-vertical-aside-has-menu {{(Request::is('seller/shop/*') || Request::is('seller/profile/*') || Request::is('seller/business-settings/wallet/*') || Request::is('seller/business-settings/shipping-method/*'))?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                href="javascript:"
               title="{{\App\CPU\Helpers::translate('Business_Setup')}}">
                <i class="tio-globe nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                {{\App\CPU\Helpers::translate('Business_Setup')}}
            </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{(Request::is('seller/shop/*') || Request::is('seller/profile/*') || Request::is('seller/business-settings/wallet/*') || Request::is('seller/business-settings/shipping-method/*'))?'block':'none'}}">
                <li class="{{ Request::is('seller/shop/*') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('seller.shop.view')}}">
                        {{\App\CPU\Helpers::translate('My_Shop')}}
                    </a>
                </li>

                <li class="{{ Request::is('seller/profile/*') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('seller.profile.view')}}">
                        {{\App\CPU\Helpers::translate('My_Bank_Info')}}
                    </a>
                </li>

                <li class="{{ Request::is('seller/business-settings/wallet/*') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('seller.business-settings.wallet.report')}}">
                        {{\App\CPU\Helpers::translate('wallet')}}
                    </a>
                </li>

                <li class="{{ Request::is('seller/business-settings/shipping-method/*') ?'active':'' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('seller.business-settings.shipping-method.add')}}">
                        {{\App\CPU\Helpers::translate('Shipping_Method')}}
                    </a>
                </li>
            </ul>
        </li>

        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/delivery-man*')?'active':''}}">
            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
            href="javascript:">
                <i class="tio-user nav-icon"></i>
                <span class="navbar-vertical-aside-mini-mode-hidden-elements">
                {{\App\CPU\Helpers::translate('Delivery-Man')}}
            </span>
            </a>
            <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display: {{Request::is('seller/delivery-man*')?'block':'none'}}">
                <li class="nav-item {{Request::is('seller/delivery-man/add')?'active':''}}">
                    <a class="nav-link " href="{{route('seller.delivery-man.add')}}">
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('Add_New')}}</span>
                    </a>
                </li>
                <li class="nav-item {{Request::is('seller/delivery-man/list') || Request::is('seller/delivery-man/earning-statement*') || Request::is('seller/delivery-man/earning-active-log*') || Request::is('seller/delivery-man/order-wise-earning*')?'active':''}}">
                    <a class="nav-link" href="{{route('seller.delivery-man.list')}}">
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('List')}}</span>
                    </a>
                </li>
                <li class="nav-item {{Request::is('seller/delivery-man/withdraw-list') || Request::is('seller/delivery-man/withdraw-view*')?'active':''}}">
                    <a class="nav-link " href="{{route('seller.delivery-man.withdraw-list')}}"
                       title="{{\App\CPU\Helpers::translate('withdraws')}}">
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('withdraws')}}</span>
                    </a>
                </li>

                <li class="nav-item {{Request::is('seller/delivery-man/emergency-contact') ? 'active' : ''}}">
                    <a class="nav-link " href="{{route('seller.delivery-man.emergency-contact.index')}}"
                       title="{{\App\CPU\Helpers::translate('withdraws')}}">
                        <span class="text-truncate">{{\App\CPU\Helpers::translate('Emergency_Contact')}}</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
