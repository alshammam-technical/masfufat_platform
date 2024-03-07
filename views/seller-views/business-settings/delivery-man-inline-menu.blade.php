<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
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
</div>
