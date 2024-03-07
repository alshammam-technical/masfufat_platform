<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('seller/delivery-man/earning-statement*') ?'active':'' }}"><a href="{{ route('seller.delivery-man.earning-statement', ['id' => $delivery_man['id']]) }}">{{\App\CPU\Helpers::translate('Overview')}}</a></li>
        <li class="{{ Request::is('seller/delivery-man/earning-active-log*') ?'active':'' }}"><a href="{{ route('seller.delivery-man.earning-active-log', ['id' => $delivery_man['id']]) }}">{{\App\CPU\Helpers::translate('Order_History_Log')}}</a></li>
        <li class="{{ Request::is('seller/delivery-man/order-wise-earning*') ?'active':'' }}"><a href="{{ route('seller.delivery-man.order-wise-earning', ['id' => $delivery_man['id']]) }}">{{\App\CPU\Helpers::translate('Earning')}}</a></li>
    </ul>
</div>
