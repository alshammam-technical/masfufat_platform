<div id="sidebarMain" class="d-none">

    <aside
        style="background: #ffffff!important; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">

        <div class="d-flex bg-white">
            {{--  fav  --}}
            <div style="background-color: #0d0e22;width: 291px;overflow: auto;">
                <div id="fav-bar" class="d-flex fav-sortable ui-sortable px-1"
                    style="width: 290px;height: 65px;overflow: auto;z-index: 10000;position: relative;flex-wrap: wrap;justify-content: center;">
                    @php($fav_menu = auth('admin')->user()->fav_menu ?? [])
                    @php($index_ = 0)
                    @foreach ($fav_menu as $index=>$item)
                    <a class="btn ti-plus btn-primary my-2 btn-icon-text m-1 fav_item card-draggable ui-sortable-handle text-truncate"
                        href="{{$item['href']}}" title="{{Helpers::translate($item['title_b'])}}"
                        t="{{$item['title_b']}}" item_index="{{$index}}">
                        <i class="{{$item['icon']}}"></i>
                        @if (Helpers::get_business_settings('show_notifications_in_fav'))
                        <span class="btn-status btn-sm-status btn-status-danger badge-pill"
                            style="top: 20px;right: 0px;font-size: 11px;display: none"></span>
                        @endif
                    </a>
                    @php($index_++)
                    @endforeach
                    @for ($i = $index_; $i < 10; $i++) <a class="btn ti-plus btn-dark my-2 btn-icon-text m-1" href="#">
                        <i class="p-2 is_blank"></i>
                        </a>
                        @endfor
                </div>
            </div>
            {{--  end-fav  --}}
            <div id="actions-bar" class="px-6" style="position: absolute;z-index:100">

            </div>
        </div>
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">

                <div class="navbar-brand-wrapper justify-content-between side-logo px-0">
                    <!-- Logo -->
                    @php($e_commerce_logo=\App\Model\BusinessSetting::where(['type'=>'company_admin_logo'])->first()->value)
                    <a class="navbar-brand" href="{{route('admin.dashboard.index')}}" aria-label="Front">
                        <img onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'"
                            class="navbar-brand-logo-mini for-web-logo w-50 mt-4 mx-2"
                            src="{{asset("storage/app/public/dashboard/$e_commerce_logo")}}" alt="Logo">
                    </a>
                    <div class="hs-unfold w-100 text-center mt-4">
                        <a title="Website home"
                            class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
                            href="{{route('home')}}" target="_blank">
                            <i class="tio-globe text-white"></i>
                            {{--<span class="btn-status btn-sm-status btn-status-danger"></span>--}}
                        </a>
                    </div>
                    <!-- Navbar Vertical Toggle -->
                    <button type="button"
                        class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>


                <!-- Content -->
                <div class="navbar-vertical-content mt-2">
                    <!-- Search Form -->
                    <div class="sidebar--search-form py-3">
                        <div class="search--form-group">
                            <button type="button" class="btn"><i class="tio-search"></i></button>
                            <input type="text" class="js-form-search form-control form--control" id="search-bar-input"
                                placeholder="{{\App\CPU\Helpers::translate('Search Menu...')}}">
                        </div>
                    </div>
                    <!-- <div class="input-group">
                        <diV class="card search-card" id="search-card"
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                            <div class="card-body search-result-box" id="search-result-box">

                            </div>
                        </diV>
                    </div> -->
                    <!-- End Search Form -->
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/dashboard')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link px-0"
                                href="{{route('admin.dashboard.index')}}">
                                <i class="tio-home-vs-1-outlined nav-icon text-center"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="Dashboard">
                                    {{\App\CPU\Helpers::translate('Dashboard')}}
                                </span>
                            </a>
                        </li>

                        <!-- End Dashboards -->

                        <!-- POS -->
                        @if (\App\CPU\Helpers::module_permission_check('admin.pos'))
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link px-1"
                                href="{{route('admin.pos.index')}}">
                                <i class="fa fa-store nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="pos">
                                    {{\App\CPU\Helpers::translate('pos')}}
                                </span>
                            </a>
                        </li>
                        @endif
                        <!-- End POS -->

                        @if(\App\CPU\Helpers::module_permission_check("admin.products.in_house.view,admin.products.in_house.edit,admin.products.in_house.delete,admin.products.seller.view,admin.products.seller.edit,admin.products.seller.delete,admin.category.view,admin.category.edit,admin.category.delete,admin.brand.view,admin.brand.edit,admin.brand.delete,customer_reviews.view,customer_reviews.delete"))
                        <!--product management-->
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="fa fa-box nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="product_management">
                                    {{\App\CPU\Helpers::translate('product_management')}}
                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none"><i
                                            class="fa fa-bell"></i></span>
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0" style="display: {{(Request::is('admin/product/list/in_house')
                                    || Request::is('admin/product/stock-limit-list/in_house')
                                    || Request::is('admin/product/bulk-import')
                                    || Request::is('admin/brand/list')
                                    || Request::is('admin/category/view')
                                       )?'block':''}}">
                                <!-- Pages -->
                                @if(\App\CPU\Helpers::module_permission_check('admin.products.in_house.view'))
                                <li class="nav-item {{Request::is('admin/product/list/in_house')?'active':''}}">
                                    <a class="nav-link px-2" href="{{route('admin.product.list',['in_house', ''])}}">
                                        <i class="tio-shop nav-icon text-center"></i>
                                        <span class="text-truncate" t="InHouse Products">
                                            {{\App\CPU\Helpers::translate('InHouse Products')}}

                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.products.seller.0.view,admin.products.seller.1.view,admin.products.seller.2.view,admin.products.updated-product-list.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/product/list/seller*')||Request::is('admin/product/updated-product-list')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-2"
                                        href="javascript:">
                                        <i class="tio-airdrop nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Sellers Products">
                                            {{\App\CPU\Helpers::translate('Sellers Products')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none"><i class="fa fa-bell"></i></span>
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-3"
                                        style="display: {{Request::is('admin/product/list/seller*')||Request::is('admin/product/updated-product-list')?'block':''}}">
                                        @if(\App\CPU\Helpers::module_permission_check('admin.products.seller.0.view'))
                                        <li
                                            class="nav-item {{str_contains(url()->current().'?status='.request()->get('status'),'/admin/product/list/seller?status=0')==1?'active':''}}">
                                            <a class="nav-link px-2"
                                                href="{{route('admin.product.list',['seller', 'status'=>'0'])}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="New Products">
                                                    {{\App\CPU\Helpers::translate('New Products')}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1"
                                                        style="display: none"></span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::get_business_settings('product_wise_shipping_cost_approval')==1)
                                        @if(\App\CPU\Helpers::module_permission_check('admin.products.updated-product-list.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/product/updated-product-list')?'active':''}}">
                                            <a class="nav-link px-2"
                                                href="{{route('admin.product.updated-product-list')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="updated_products">
                                                    {{\App\CPU\Helpers::translate('updated_products')}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1"
                                                        style="display: none"></span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('admin.products.seller.1.view'))
                                        <li
                                            class="nav-item {{str_contains(url()->current().'?status='.request()->get('status'),'/admin/product/list/seller?status=1')==1?'active':''}}">
                                            <a class="nav-link px-2"
                                                href="{{route('admin.product.list',['seller', 'status'=>'1'])}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="Approved Products">
                                                    {{\App\CPU\Helpers::translate('Approved Products')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('admin.products.seller.2.view'))
                                        <li
                                            class="nav-item {{str_contains(url()->current().'?status='.request()->get('status'),'/admin/product/list/seller?status=2')==1?'active':''}}">
                                            <a class="nav-link px-2"
                                                href="{{route('admin.product.list',['seller', 'status'=>'2'])}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="Denied Products">
                                                    {{\App\CPU\Helpers::translate('Denied Products')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.category.view'))
                                <li class="nav-item {{Request::is('admin/category/view')?'active':''}}">
                                    <a class="nav-link px-2" href="{{ route('admin.category.view') }}">
                                        <i class="tio-filter-list nav-icon text-center"></i>
                                        <span class="text-truncate" t="categories">
                                            {{\App\CPU\Helpers::translate('categories')}}

                                        </span>
                                    </a>
                                </li>
                                @endif

                                @if(\App\CPU\Helpers::module_permission_check('admin.brand.view'))
                                <li class="nav-item {{Request::is('admin/brand/list')?'active':''}}">
                                    <a class="nav-link px-2" href="{{ route('admin.brand.list') }}">
                                        <i class="tio-apple-outlined nav-icon text-center"></i>
                                        <span class="text-truncate" t="brands">
                                            {{\App\CPU\Helpers::translate('brands')}}

                                        </span>
                                    </a>
                                </li>
                                @endif


                                @if(\App\CPU\Helpers::module_permission_check('customer_reviews.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/reviews*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.reviews.list')}}">
                                        <i class="tio-circle nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Customer Reviews">
                                            {{\App\CPU\Helpers::translate('Customer Reviews')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <!--product management ends-->
                        @endif

                        @if(\App\CPU\Helpers::module_permission_check("order.pending.view,order.confirmed.view,order.processing.view,order.out_for_delivery.view,order.delivered.view,order.returned.view,order.failed.view,order.canceled.view,refund.pending.view,refund.approved.view,refund.refunded.view,refund.rejected.view"))
                        <!-- Order Management -->
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="tio-truck nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="order_management">
                                    {{\App\CPU\Helpers::translate('order_management')}}
                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                        <i class="fa fa-bell"></i>
                                    </span>
                                </span>
                            </a>
                            <!-- Order -->
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0" style="display: {{(Request::is('admin/orders/*')
                                       )?'block':''}}">
                                @if(\App\CPU\Helpers::module_permission_check('order.pending.view,order.confirmed.view,order.processing.view,order.out_for_delivery.view,order.delivered.view,order.returned.view,order.failed.view,order.canceled.view'))
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/orders*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                        href="javascript:void(0)" title="{{\App\CPU\Helpers::translate('orders')}}">
                                        <i class="tio-shopping-cart-outlined nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="orders">
                                            {{\App\CPU\Helpers::translate('orders')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{Request::is('admin/order*')?'block':'none'}}">
                                        <li class="nav-item {{Request::is('admin/orders/list/all')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['all'])}}"
                                                title="{{\App\CPU\Helpers::translate('All')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="All orders">
                                                    {{\App\CPU\Helpers::translate('All')}}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{\App\Model\Order::count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        @if(\App\CPU\Helpers::module_permission_check('order.pending.view'))
                                        <li class="nav-item {{Request::is('admin/orders/list/pending')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['pending'])}}"
                                                title="{{\App\CPU\Helpers::translate('pending')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="pending orders">
                                                    {{\App\CPU\Helpers::translate('pending')}}
                                                    <span class="badge badge-soft-warning ml-1 b-bell"
                                                        style="display: none">
                                                        <i class="fa fa-bell"></i>
                                                    </span>
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'pending'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.confirmed.view'))
                                        <li class="nav-item {{Request::is('admin/orders/list/confirmed')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['confirmed'])}}"
                                                title="{{\App\CPU\Helpers::translate('confirmed')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="confirmed orders">
                                                    {{\App\CPU\Helpers::translate('confirmed')}}
                                                    <span class="badge badge-soft-success badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'confirmed'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.processing.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/orders/list/processing')?'active':''}}">
                                            <a class="nav-link px-4"
                                                href="{{route('admin.orders.list',['processing'])}}"
                                                title="{{\App\CPU\Helpers::translate('Packaging')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="Packaging orders">
                                                    {{\App\CPU\Helpers::translate('Packaging')}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'processing'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.out_for_delivery.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/orders/list/out_for_delivery')?'active':''}}">
                                            <a class="nav-link px-4"
                                                href="{{route('admin.orders.list',['out_for_delivery'])}}"
                                                title="{{\App\CPU\Helpers::translate('out_for_delivery')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="out_for_delivery orders">
                                                    {{\App\CPU\Helpers::translate('out_for_delivery')}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'out_for_delivery'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.delivered.view'))
                                        <li class="nav-item {{Request::is('admin/orders/list/delivered')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['delivered'])}}"
                                                title="{{\App\CPU\Helpers::translate('delivered')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="delivered orders">
                                                    {{\App\CPU\Helpers::translate('delivered')}}
                                                    <span class="badge badge-soft-success badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'delivered'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.returned.view'))
                                        <li class="nav-item {{Request::is('admin/orders/list/returned')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['returned'])}}"
                                                title="{{\App\CPU\Helpers::translate('returned')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="returned orders">
                                                    {{\App\CPU\Helpers::translate('returned')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\Order::where('order_status','returned')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.failed.view'))
                                        <li class="nav-item {{Request::is('admin/orders/list/failed')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['failed'])}}"
                                                title="{{\App\CPU\Helpers::translate('failed')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="Failed_to_Deliver orders">
                                                    {{\App\CPU\Helpers::translate('Failed_to_Deliver')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'failed'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.canceled.view'))
                                        <li class="nav-item {{Request::is('admin/orders/list/canceled')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.list',['canceled'])}}"
                                                title="{{\App\CPU\Helpers::translate('canceled')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="canceled orders">
                                                    {{\App\CPU\Helpers::translate('canceled')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\Order::where(['order_status'=>'canceled'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order.add.view'))
                                        <li class="nav-item {{Request::is('admin/orders/add')?'active':''}}">
                                            <a class="nav-link px-4" href="{{route('admin.orders.add')}}"
                                                title="{{\App\CPU\Helpers::translate('Add Order')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="canceled orders">
                                                    {{\App\CPU\Helpers::translate('Add Order')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif

                                @if(\App\CPU\Helpers::module_permission_check('refund.pending.view,refund.approved.view,refund.refunded.view,refund.rejected.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/refund-section/refund/*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                        href="javascript:" title="{{\App\CPU\Helpers::translate('Refund_Requests')}}">
                                        <i class="tio-receipt-outlined nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Refund_Requests orders">
                                            {{\App\CPU\Helpers::translate('Refund_Requests')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{Request::is('admin/refund-section/refund*')?'block':'none'}}">
                                        @if(\App\CPU\Helpers::module_permission_check('refund.pending.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/refund-section/refund/list/pending')?'active':''}}">
                                            <a class="nav-link px-4"
                                                href="{{route('admin.refund-section.refund.list',['pending'])}}"
                                                title="{{\App\CPU\Helpers::translate('pending Refund_Requests')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="r pending orders">
                                                    {{\App\CPU\Helpers::translate('pending Refund_Requests')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','pending')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif

                                        @if(\App\CPU\Helpers::module_permission_check('refund.approved.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/refund-section/refund/list/approved')?'active':''}}">
                                            <a class="nav-link px-4"
                                                href="{{route('admin.refund-section.refund.list',['approved'])}}"
                                                title="{{\App\CPU\Helpers::translate('approved Refund_Requests')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="approved orders">
                                                    {{\App\CPU\Helpers::translate('approved Refund_Requests')}}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','approved')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('refund.refunded.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/refund-section/refund/list/refunded')?'active':''}}">
                                            <a class="nav-link px-4"
                                                href="{{route('admin.refund-section.refund.list',['refunded'])}}"
                                                title="{{\App\CPU\Helpers::translate('refunded Refund_Requests')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="refunded orders">
                                                    {{\App\CPU\Helpers::translate('refunded Refund_Requests')}}
                                                    <span class="badge badge-soft-success badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','refunded')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('refund.rejected.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/refund-section/refund/list/rejected')?'active':''}}">
                                            <a class="nav-link px-4"
                                                href="{{route('admin.refund-section.refund.list',['rejected'])}}"
                                                title="{{\App\CPU\Helpers::translate('rejected Refund_Requests')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="rejected orders">
                                                    {{\App\CPU\Helpers::translate('rejected Refund_Requests')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','rejected')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <!--Order Management Ends-->
                        @endif

                        @if(\App\CPU\Helpers::module_permission_check("order.canceled.view,marketing.banner.view,marketing.coupon.view,marketing.affiliate.view,marketing.deal.flash.view,marketing.deal.day.view,marketing.deal.feature.view,marketing.notification.view,marketing.sms.view,marketing.mail.view,marketing.announcement.view"))
                        <!--marketing section-->
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="fa fa-bullhorn nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="promotion_management">
                                    {{\App\CPU\Helpers::translate('promotion_management')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                style="display: {{Request::is('admin/pos/*')?'block':'none'}}">
                                @if(\App\CPU\Helpers::module_permission_check('marketing.banner.view'))
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/banner*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.banner.list')}}">
                                        <i class="tio-photo-square-outlined nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="banners">
                                            {{\App\CPU\Helpers::translate('banners')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.abandoned_carts.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/abandoned-carts')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.abandoned-carts.list')}}"
                                        title="{{\App\CPU\Helpers::translate('Abandoned carts')}}">
                                        <i class="tio-shopping-cart nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Abandoned carts">
                                            {{\App\CPU\Helpers::translate('Abandoned carts')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.coupon.view'))
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/coupon*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.coupon.add-new')}}">
                                        <i class="tio-credit-cards nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="coupons">
                                            {{\App\CPU\Helpers::translate('coupons')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.affiliate.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/affiliate*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.Affiliate.list')}}" title="">
                                        <i class="tio-dollar nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Affiliate">
                                            {{\App\CPU\Helpers::translate('Affiliate')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.deal.flash.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/deal/flash')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.deal.flash')}}">
                                        <i class="tio-flash nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="flash_deals">
                                            {{\App\CPU\Helpers::translate('flash_deals')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.deal.day.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/deal/day')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.deal.day')}}">
                                        <i class="tio-crown-outlined nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="deal_of_the_day">
                                            {{\App\CPU\Helpers::translate('deal_of_the_day')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.deal.feature.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/deal/feature')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.deal.feature')}}">
                                        <i class="tio-flag-outlined nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="featured_deal">
                                            {{\App\CPU\Helpers::translate('featured_deal')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.notification.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/notification*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.notification.add-new')}}"
                                        title="{{\App\CPU\Helpers::translate('Push_Notification')}}">
                                        <i class="tio-notifications-on-outlined nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Push_Notification">
                                            {{\App\CPU\Helpers::translate('Push_Notification')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.sms.view'))
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/sms*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.sms.add-new')}}"
                                        title="{{\App\CPU\Helpers::translate('Send messages')}}">
                                        <i class="fa fa-sms nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Send messages">
                                            {{\App\CPU\Helpers::translate('Send messages')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.mail.view'))
                                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/mail*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.mail.add-new')}}"
                                        title="{{\App\CPU\Helpers::translate('emails')}}">
                                        <i class="fa fa-mail-bulk nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="emails">
                                            {{\App\CPU\Helpers::translate('emails')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('marketing.announcement.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/announcement')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-2"
                                        href="{{route('admin.business-settings.announcement')}}"
                                        title="{{\App\CPU\Helpers::translate('announcement')}}">
                                        <i class="tio-mic-outlined nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="announcement">
                                            {{\App\CPU\Helpers::translate('announcement')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <!--marketing section ends here-->
                        @endif

                        @if(\App\CPU\Helpers::module_permission_check("admin.sellers.view,sellers.view,withdraw_list.view"))
                        <!--sellers section-->
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="fa fa-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="sellers">
                                    {{\App\CPU\Helpers::translate('sellers')}}
                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                        <i class="fa fa-bell"></i>
                                    </span>
                                </span>
                            </a>

                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-2"
                                style="display: {{Request::is('admin/pos/*')?'block':'none'}}">
                                @if(\App\CPU\Helpers::module_permission_check('admin.sellers.view'))
                                <li class="nav-item {{Request::is('admin/sellers/seller-list')?'active':''}}">
                                    <a class="nav-link px-2" href="{{route('admin.sellers.seller-list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="sellers list">
                                            {{\App\CPU\Helpers::translate('sellers list')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none"></span>
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.withdraw_list.view'))
                                <li class="nav-item {{Request::is('admin/sellers/withdraw_list')?'active':''}}">
                                    <a class="nav-link px-2" href="{{route('admin.sellers.withdraw_list')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="withdraws list">
                                            {{\App\CPU\Helpers::translate('withdraws list')}}

                                        </span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <!--sellers section ends here-->
                        @endif





                        @if(\App\CPU\Helpers::module_permission_check('admin.customers.view,wallet.view,subscriptions.view,loyalty.view,contact.view,support-ticket.view'))
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="fa fa-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="customers">
                                    {{\App\CPU\Helpers::translate('customers')}}
                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                        <i class="fa fa-bell"></i>
                                    </span>
                                </span>
                            </a>

                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-2"
                                style="display: {{(Request::is('admin/stores/list') || Request::is('admin/customer/wallet*') || Request::is('admin/customer/view*') || Request::is('admin/reviews*') || Request::is('admin/contact*') || Request::is('admin/support-ticket*') || Request::is('admin/customer/loyalty/report'))?'none':'none'}}">
                                @if(\App\CPU\Helpers::module_permission_check('admin.customers.view'))
                                <li
                                    class="nav-item {{Request::is('admin/stores/list') || Request::is('admin/stores/view*') || Request::is('admin/customer/view*') || Request::is('admin/subscriptions*')?'':''}}">
                                    <a class="nav-link px-2" href="{{route('admin.stores.list')}}"
                                        title="{{\App\CPU\Helpers::translate('Customer_List')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="Customer_List">
                                            {{\App\CPU\Helpers::translate('Customer_List')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none"></span>
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.customers.wallet.view'))
                                <li class="nav-item {{Request::is('admin/customer/wallet/report')?'active':''}}">
                                    <a class="nav-link p-2" title="{{\App\CPU\Helpers::translate('wallet')}}"
                                        href="{{route('admin.customer.wallet.report')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="wallet">
                                            {{\App\CPU\Helpers::translate('wallet')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.subscriptions.view'))
                                <li class="nav-item {{(Request::is('admin/subscriptions*'))?'active':''}}">
                                    <a class="nav-link p-2" title="{{\App\CPU\Helpers::translate('Subscriptions')}}"
                                        href="{{route('admin.subscriptions')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="subscriptions">
                                            {{\App\CPU\Helpers::translate('Subscriptions')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.loyalty.view'))
                                <li class="nav-item {{Request::is('admin/customer/loyalty/report')?'active':''}}">
                                    <a class="nav-link p-2" title="{{\App\CPU\Helpers::translate('Loyalty_Points')}}"
                                        href="{{route('admin.customer.loyalty.report')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="Loyalty_Points">
                                            {{\App\CPU\Helpers::translate('Loyalty_Points')}}
                                        </span>
                                    </a>
                                </li>
                                @endif

                                <!-- end refund section -->
                                @if(\App\CPU\Helpers::module_permission_check('admin.contact.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/contact*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-0"
                                        href="{{route('admin.contact.list')}}"
                                        title="{{\App\CPU\Helpers::translate('Contact us messages')}}">
                                        <i class="tio-messages nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="messages"><span class="position-relative">
                                                {{\App\CPU\Helpers::translate('Contact us messages')}}
                                                @php($message=\App\Model\Contact::where('seen',0)->count())
                                            </span>
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none"></span>
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(\App\CPU\Helpers::module_permission_check('admin.support-ticket.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/support-ticket*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-0"
                                        href="{{route('admin.support-ticket.view')}}"
                                        title="{{\App\CPU\Helpers::translate('Support_Ticket')}}">
                                        <i class="tio-chat nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Support_Ticket"><span class="position-relative">
                                                {{\App\CPU\Helpers::translate('Support_Ticket')}}
                                            </span>
                                            <span class="badge badge-soft-warning badge-pill ml-1"
                                                style="display: none"></span>
                                        </span>
                                    </a>
                                </li>
                                @endif
                                <!--support section ends here-->
                            </ul>
                        </li>
                        @endif

                        @if(\App\CPU\Helpers::module_permission_check('admin.end_user.view'))
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="fa fa-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="online stores">
                                    {{\App\CPU\Helpers::translate('online stores')}}
                                </span>
                            </a>

                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{(Request::is('admin/customer/wallet*') || Request::is('admin/customer/list') || Request::is('admin/reviews*') || Request::is('admin/contact*') || Request::is('admin/support-ticket*') || Request::is('admin/customer/loyalty/report'))?'none':'none'}}">
                                <li class="nav-item {{Request::is('admin/customer/list')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.customer.list',['end_customer'=>true])}}"
                                        title="{{\App\CPU\Helpers::translate('Customer_List')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="Online stores list">
                                            {{\App\CPU\Helpers::translate('Online stores list')}} </span>
                                    </a>
                                </li>
                                <!--support section ends here-->
                            </ul>
                        </li>
                        @endif
                        <!--user section ends here-->




                        @if(Helpers::module_permission_check('inhoue-product-sale.view,seller-report.view,order-transaction-list.view,admin-earning.view,all-product.view,product-stock.view,product-in-wishlist.view,order.view'))
                        <!--reports-->
                        <li
                            class="navbar-vertical-aside-has-menu {{(Request::is('admin/report/*') ||  Request::is('admin/transaction/order-transaction-list') ||  Request::is('admin/refund-section/refund-list') || Request::is('admin/stock/product-stock') || Request::is('admin/stock/product-in-wishlist')) ?'active show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="fa fa-file nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="reports">
                                    {{\App\CPU\Helpers::translate('reports')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-1"
                                style="display: {{(Request::is('admin/report/*') ||  Request::is('admin/transaction/order-transaction-list') || Request::is('admin/stock/product-stock') || Request::is('admin/stock/product-in-wishlist') || Request::is('admin/refund-section/refund-list'))?'block':'none'}}">
                                @if(Helpers::module_permission_check('inhoue-product-sale.view,seller-report.view,order-transaction-list.view,admin-earning.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{(Request::is('admin/report/earning') || Request::is('admin/report/inhoue-product-sale') || Request::is('admin/report/seller-report') ||  Request::is('admin/transaction/order-transaction-list') || Request::is('admin/report/earning') || Request::is('admin/transaction/list') || Request::is('admin/report/admin-earning') || Request::is('admin/refund-section/refund-list')) ?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-0"
                                        href="javascript:"
                                        title="{{\App\CPU\Helpers::translate('Sales_&_Transaction_Report')}}">
                                        <i class="tio-chart-bar-4 nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Sales_&_Transaction_Report">
                                            {{\App\CPU\Helpers::translate('Sales_&_Transaction_Report')}}
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{(Request::is('admin/report/earning') || Request::is('admin/report/inhoue-product-sale') || Request::is('admin/report/admin-earning') || Request::is('admin/report/seller-report') ||  Request::is('admin/transaction/order-transaction-list') || Request::is('admin/report/earning') || Request::is('admin/transaction/list') || Request::is('admin/refund-section/refund-list')) ?'block':'none'}}">


                                        @if(\App\CPU\Helpers::module_permission_check('inhoue-product-sale.view'))
                                        <li
                                            class="nav-item {{Request::is('admin/report/inhoue-product-sale')?'active':''}}">
                                            <a class="nav-link px-3"
                                                href="{{route('admin.report.inhoue-product-sale')}}"
                                                title="{{\App\CPU\Helpers::translate('inhouse sales')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="inhouse sales">
                                                    {{\App\CPU\Helpers::translate('inhouse sales')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('seller-report.view'))
                                        <li class="nav-item {{Request::is('admin/report/seller-report')?'active':''}}">
                                            <a class="nav-link px-3" href="{{route('admin.report.seller-report')}}"
                                                title="{{\App\CPU\Helpers::translate('seller sales')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate text-capitalize">
                                                    {{\App\CPU\Helpers::translate('seller sales')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('order-transaction-list.view'))
                                        <li
                                            class="navbar-vertical-aside-has-menu {{(Request::is('admin/transaction/order-transaction-list') || Request::is('admin/transaction/expense-transaction-list') || Request::is('admin/transaction/refund-transaction-list'))?'active':''}}">
                                            <a class="nav-link px-3"
                                                href="{{route('admin.transaction.order-transaction-list')}}"
                                                title="{{Helpers::translate('Transaction_Report')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                                    {{Helpers::translate('Transaction_Report')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('admin-earning.view'))
                                        <li
                                            class="navbar-vertical-aside-has-menu {{Request::is('admin/report/admin-earning')?'active':''}}">
                                            <a class="js-navbar-vertical-aside-menu-link nav-link px-3"
                                                href="{{route('admin.report.admin-earning')}}"
                                                title="{{\App\CPU\Helpers::translate('Earning Reports')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                                    t="Earning Reports">
                                                    {{\App\CPU\Helpers::translate('Earning Reports')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif

                                @if(Helpers::module_permission_check('all-product.view,product-stock.view,product-in-wishlist.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{ (Request::is('admin/stock/product-in-wishlist')) ?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-0"
                                        href="javascript:" title="{{\App\CPU\Helpers::translate('Product_Report')}}">
                                        <i class="tio-chart-bar-4 nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Product_Report">
                                            {{\App\CPU\Helpers::translate('Product_Report')}}
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{(Request::is('admin/report/all-product') || Request::is('admin/stock/product-stock') || Request::is('admin/stock/product-in-wishlist')) ?'block':'none'}}">
                                        @if(\App\CPU\Helpers::module_permission_check('all-product.view'))
                                        <li
                                            class="navbar-vertical-aside-has-menu {{(Request::is('admin/report/all-product') || Request::is('admin/stock/product-in-wishlist'))?'active':''}}">
                                            <a class="js-navbar-vertical-aside-menu-link nav-link px-3"
                                                title="{{\App\CPU\Helpers::translate('Wishlisted_Products')}}"
                                                href="{{route('admin.report.all-product')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                                    t="Wishlisted_Products">
                                                    {{\App\CPU\Helpers::translate('All Products')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('product-stock.view'))
                                        <li
                                            class="navbar-vertical-aside-has-menu {{(Request::is('admin/stock/product-stock') || Request::is('admin/stock/product-stock'))?'active':''}}">
                                            <a class="js-navbar-vertical-aside-menu-link nav-link px-3"
                                                title="{{\App\CPU\Helpers::translate('Product_Stock')}}"
                                                href="{{route('admin.stock.product-stock')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                                    t="Product_Stock">
                                                    {{\App\CPU\Helpers::translate('Product_Stock')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(\App\CPU\Helpers::module_permission_check('product-in-wishlist.view'))
                                        <li
                                            class="navbar-vertical-aside-has-menu {{Request::is('admin/stock/product-in-wishlist')?'active':''}}">
                                            <a class="js-navbar-vertical-aside-menu-link nav-link px-3"
                                                href="{{route('admin.stock.product-in-wishlist')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span
                                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                                    t="Product_Stock">
                                                    {{\App\CPU\Helpers::translate('products in the wishlist report')}}
                                                </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif

                                @if(\App\CPU\Helpers::module_permission_check('order.view'))
                                <li
                                    class="navbar-vertical-aside-has-menu {{Request::is('admin/report/order')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link px-0"
                                        href="{{route('admin.report.order')}}"
                                        title="{{\App\CPU\Helpers::translate('Order Report')}}">
                                        <i class="tio-chart-bar-1 nav-icon text-center"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Order Report">
                                            {{\App\CPU\Helpers::translate('Order Report')}}
                                        </span>
                                    </a>
                                </li>
                                @endif


                            </ul>
                        </li>
                        <!--reports end-->
                        @endif

                        @if(\App\CPU\Helpers::module_permission_check('archive.list.in_house.view,archive.list.sellers_products.view,archive.list.categories.view,archive.list.brands.view,archive.list.reviews.view,archive.list.refund_requests.view,archive.list.banner.view,archive.list.carts.view,archive.list.coupons.view,archive.list.notifications.view,archive.list.flash_deals.view,archive.list.deal_of_the_days.view,archive.list.feature_deals.view,archive.list.announcement.view,archive.list.sellers.view,archive.list.shops.view'))
                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                href="javascript:">
                                <i class="tio-archive nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="Archive">
                                    {{\App\CPU\Helpers::translate('Archive')}}
                                </span>
                            </a>

                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{(Request::is('admin/archive*'))?'none':'none'}}">
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.in_house.view'))
                                <li class="nav-item {{Request::is('admin/archive/in_house')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'in_house'])}}"
                                        title="{{\App\CPU\Helpers::translate('InHouse Products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="InHouse Products">
                                            {{\App\CPU\Helpers::translate('InHouse Products')}} </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.sellers_products.view'))
                                <li class="nav-item {{Request::is('admin/archive/sellers_products')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'sellers_products'])}}"
                                        title="{{\App\CPU\Helpers::translate('Sellers Products')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="Sellers Products">
                                            {{\App\CPU\Helpers::translate('Sellers Products')}} </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.categories.view'))
                                <li class="nav-item {{Request::is('admin/archive/categories')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'categories'])}}"
                                        title="{{\App\CPU\Helpers::translate('Categories')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="Categories">
                                            {{\App\CPU\Helpers::translate('Categories')}} </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.brands.view'))
                                <li class="nav-item {{Request::is('admin/archive/brands')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'brands'])}}"
                                        title="{{\App\CPU\Helpers::translate('Brands')}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="Brands">
                                            {{\App\CPU\Helpers::translate('Brands')}} </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.reviews.view'))
                                <li class="nav-item {{Request::is('admin/archive/reviews')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'reviews'])}}"
                                        title="{{\App\CPU\Helpers::translate('Reviews')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Reviews">
                                            {{\App\CPU\Helpers::translate('Reviews')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.refund_requests.view'))
                                <li class="nav-item {{Request::is('admin/archive/refund_requests')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'refund_requests'])}}"
                                        title="{{\App\CPU\Helpers::translate('Refund_Requests')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Refund_Requests">
                                            {{\App\CPU\Helpers::translate('Refund_Requests')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.banner.view'))
                                <li class="nav-item {{Request::is('admin/archive/banner')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'banner'])}}"
                                        title="{{\App\CPU\Helpers::translate('banners')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="banners">
                                            {{\App\CPU\Helpers::translate('banners')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.carts.view'))
                                <li class="nav-item {{Request::is('admin/archive/carts')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'carts'])}}"
                                        title="{{\App\CPU\Helpers::translate('Abandoned carts')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Abandoned carts">
                                            {{\App\CPU\Helpers::translate('Abandoned carts')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.coupons.view'))
                                <li class="nav-item {{Request::is('admin/archive/coupons')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'coupons'])}}"
                                        title="{{\App\CPU\Helpers::translate('coupons')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="coupons">
                                            {{\App\CPU\Helpers::translate('coupons')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.notifications.view'))
                                <li class="nav-item {{Request::is('admin/archive/notifications')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'notifications'])}}"
                                        title="{{\App\CPU\Helpers::translate('Marketing campaigns')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="Marketing campaigns">
                                            {{\App\CPU\Helpers::translate('Marketing campaigns')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.flash_deals.view'))
                                <li class="nav-item {{Request::is('admin/archive/flash_deals')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'flash_deals'])}}"
                                        title="{{\App\CPU\Helpers::translate('flash_deals')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="flash_deals">
                                            {{\App\CPU\Helpers::translate('flash_deals')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.deal_of_the_days.view'))
                                <li class="nav-item {{Request::is('admin/archive/deal_of_the_days')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'deal_of_the_days'])}}"
                                        title="{{\App\CPU\Helpers::translate('deal_of_the_day')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="deal_of_the_day">
                                            {{\App\CPU\Helpers::translate('deal_of_the_day')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.feature_deals.view'))
                                <li class="nav-item {{Request::is('admin/archive/feature_deals')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'feature_deals'])}}"
                                        title="{{\App\CPU\Helpers::translate('featured_deal')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="featured_deal">
                                            {{\App\CPU\Helpers::translate('featured_deal')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.announcement.view'))
                                <li class="nav-item {{Request::is('admin/archive/announcement')?'active':''}}">
                                    <a class="nav-link px-0"
                                        href="{{route('admin.archive.list',['type'=>'announcement'])}}"
                                        title="{{\App\CPU\Helpers::translate('announcement')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="announcement">
                                            {{\App\CPU\Helpers::translate('announcement')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.sellers.view'))
                                <li class="nav-item {{Request::is('admin/archive/sellers')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'sellers'])}}"
                                        title="{{\App\CPU\Helpers::translate('sellers')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="sellers">
                                            {{\App\CPU\Helpers::translate('sellers')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (\App\CPU\Helpers::module_permission_check('archive.list.shops.view'))
                                <li class="nav-item {{Request::is('admin/archive/shops')?'active':''}}">
                                    <a class="nav-link px-0" href="{{route('admin.archive.list',['type'=>'shops'])}}"
                                        title="{{\App\CPU\Helpers::translate('customers')}}">
                                        <i class="tio-circle nav-indicator-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                            t="customers">
                                            {{\App\CPU\Helpers::translate('customers')}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                <!--support section ends here-->
                            </ul>
                        </li>
                        @endif


                        @if(\App\CPU\Helpers::module_permission_check("web-config.view,web-config.app.view,inhouse-shop.view,seller-settings.view,customer-settings.view,refund-section.view,shipping-method.setting.view,order-settings.view,product-settings.add,delivery-restriction.view,web-config.environment.view,web-config.mysitemap.download,analytics-index.view,currency.view,language.view,web-config.db.clear,admin.business-settings.about-us,admin.business-settings.terms-condition,admin.business-settings.privacy-policy,admin.business-settings.warranty-policy,social-media.view,file-manager.view,package.view,ServicesPackaging.view,admin.pricing-levels.view,required_fields.view,sms-module.view,mail.view,payment-method.view,map-api.view,fcm-index.view,social-login.view,custom-role.create.view,employee.view,delivery-man.view,delivery-man.chat.view,delivery-man.withdraw-list.view,emergency-contact.view,countries.view,areas.view,cities.view,provinces.view"))
                        <!--System Settings-->
                        <li
                            class="navbar-vertical-aside-has-menu {{(Request::is('admin/business-settings/web-config/environment-setup') || Request::is('admin/business-settings/web-config/mysitemap') || Request::is('admin/business-settings/analytics-index') || Request::is('admin/currency/view') || Request::is('admin/business-settings/web-config/db-index') || Request::is('admin/business-settings/language*'))?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link px-0"
                                title="{{\App\CPU\Helpers::translate('settings')}}" href="{{route('admin.settings')}}">
                                <i class="fa fa-gear nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"
                                    t="settings">
                                    {{\App\CPU\Helpers::translate('settings')}}
                                </span>
                            </a>
                        </li>
                        <!--System Settings end-->
                        @endif


                        <li class="nav-item" style="padding-top: 50px">
                            <div class="nav-divider"></div>
                        </li>
                    </ul>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </aside>
</div>

@push('script_2')
<script>
    $(window).on('load', function () {
        if ($(".navbar-vertical-content li.active").length) {
            $('.navbar-vertical-content').animate({
                scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
            }, 10);
        }
    });

    //Sidebar Menu Search
    var $rows = $('.navbar-vertical-content li');
    $('#search-bar-input').keyup(function () {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

</script>
@endpush
