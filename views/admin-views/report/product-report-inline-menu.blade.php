<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/report/all-product') ?'active':'' }}"><a href="{{route('admin.report.all-product')}}">{{\Helpers::translate('All_Products')}}</a></li>
        <li class="{{ Request::is('admin/stock/product-stock') ?'active':'' }}"><a href="{{route('admin.stock.product-stock')}}">{{\Helpers::translate('Product stock report')}}</a></li>
        <li class="{{ Request::is('admin/stock/product-in-wishlist') ?'active':'' }}"><a href="{{route('admin.stock.product-in-wishlist')}}">{{\Helpers::translate('Wish_Listed_Products')}}</a></li>
    </ul>
</div>
