<div id="sidebarMain" class="d-none">
    <aside style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="d-flex bg-white">
            {{--  fav  --}}
            <div style="background-color: #0d0e22;width: 291px;overflow: auto;">
                <div id="fav-bar" class="d-flex fav-sortable ui-sortable px-1" style="width: 290px;height: 65px;overflow: auto;z-index: 10000;position: relative;flex-wrap: wrap;justify-content: center;">
                    @php($fav_menu = auth('seller')->user()->fav_menu ?? [])
                    @php($index_ = 0)
                    @foreach ($fav_menu as $index=>$item)
                    <a class="btn ti-plus btn-primary my-2 btn-icon-text m-1 fav_item card-draggable ui-sortable-handle text-truncate" href="{{$item['href']}}"
                    title="{{Helpers::translate($item['title_b'])}}"
                    t="{{$item['title_b']}}"
                    item_index="{{$index}}">
                        <i class="{{$item['icon']}}"></i>
                        @if (Helpers::get_business_settings('show_notifications_in_fav'))
                        <span class="btn-status btn-sm-status btn-status-danger badge-pill" style="top: 20px;right: 0px;font-size: 11px;display: none"></span>
                        @endif
                    </a>
                    @php($index_++)
                    @endforeach
                    @for ($i = $index_; $i < 10; $i++)
                    <a class="btn ti-plus btn-dark my-2 btn-icon-text m-1" href="#">
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
                <div class="navbar-brand-wrapper justify-content-between side-logo">
                    <!-- Logo -->
                    <a class="navbar-brand w-100" href="{{route('seller.dashboard.index')}}" aria-label="Front">
                        @php($shop = App\Model\Shop::where(['seller_id' => auth('seller')->id()])->first())
                        @if (isset($shop))
                            <img onerror="this.src='{{asset('public/assets/back-end/img/900x400/img1.jpg')}}'"
                                class="navbar-brand-logo-mini for-web-logo w-50 mt-4 mx-2"
                                style="width: 100% !important;object-position:center"
                                src="{{asset('storage/app/public/seller')}}/{{auth('seller')->user()->image}}" alt="Logo">
                        @else
                            <img class="navbar-brand-logo-mini for-web-logo w-50 mt-4 mx-2"
                                style="width: 100% !important;object-position:center"
                                src="{{asset('public/assets/back-end/img/900x400/img1.jpg')}}" alt="Logo">
                        @endif
                    </a>
                    <!-- End Logo -->

                    <!-- Navbar Vertical Toggle -->
                    <button type="button" class="d-none js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->

                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip" data-placement="right" title="" data-original-title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align" data-template="<div class=&quot;tooltip d-none d-sm-block&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><div class=&quot;tooltip-inner&quot;></div></div>" data-toggle="tooltip" data-placement="right" title="" data-original-title="Expand"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <ul class="navbar-nav navbar-nav-lg nav-tabs">
                        <!-- Dashboards -->
                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/dashboard')?'show':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.dashboard.index')}}">
                                <i class="tio-home-vs-1-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="Dashboard">
                                    {{\App\CPU\Helpers::translate('Dashboard')}}
                                </span>
                            </a>
                        </li>
                        <!-- End Dashboards -->
                        @php($seller = auth('seller')->user())
                        <!-- POS -->
                        @php($sellerId = $seller->id)
                        @php($seller_pos=\App\Model\BusinessSetting::where('type','seller_pos')->first()->value)
                        @if ($seller_pos==1)
                            @if ($seller->pos_status == 1)
                                <li class="nav-item">
                                    <small
                                        class="nav-subtitle">{{\App\CPU\Helpers::translate('pos system')}} </small>
                                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                                </li>
                                <li class="navbar-vertical-aside-has-menu {{Request::is('seller/pos')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('seller.pos.index')}}">
                                        <i class="tio-shopping nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="POS">{{\App\CPU\Helpers::translate('POS')}}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <!-- End POS -->


                        <li class="navbar-vertical-aside-has-menu {{(Request::is('seller/product/*') || Request::is('seller/reviews/list*'))?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1" href="javascript:">
                                <i class="fa fa-box nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('product_management')}}
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                                style="display: {{(Request::is('seller/product/*') || (Request::is('seller/reviews/list'))
                                                )?'block':''}}">
                                <li class="navbar-vertical-aside-has-menu {{(Request::is('seller/product*'))?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('seller.product.list')}}">
                                        <i class="tio-premium-outlined nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="Products">
                                            {{\App\CPU\Helpers::translate('Products')}}
                                        </span>
                                    </a>
                                </li>

                                <li class="navbar-vertical-aside-has-menu {{Request::is('seller/reviews/list*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                                    href="{{route('seller.reviews.list')}}">
                                        <i class="tio-star nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="Customer Reviews">
                                            {{\App\CPU\Helpers::translate('Customer Reviews')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="navbar-vertical-aside-has-menu">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1" href="javascript:">
                                <i class="tio-truck nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('order_management')}}
                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none"><i class="fa fa-bell"></i></span>
                                </span>
                            </a>
                            <!-- Order -->
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub px-0"
                                        style="display: {{(Request::is('seller/orders/*')
                                           )?'block':''}}">
                                <li class="navbar-vertical-aside-has-menu {{Request::is('seller/orders*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                    href="javascript:void(0)" title="{{\App\CPU\Helpers::translate('orders')}}">
                                        <i class="tio-shopping-cart-outlined nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                            {{\App\CPU\Helpers::translate('orders')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1" style="display: none"><i class="fa fa-bell"></i></span>
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{Request::is('seller/order*')?'block':'none'}}">
                                        <li class="nav-item {{Request::is('seller/orders/list/all')?'active':''}}">
                                            <a class="nav-link" href="{{route('seller.orders.list',['all'])}}"
                                            title="{{\App\CPU\Helpers::translate('All')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="All orders">
                                                    {{\App\CPU\Helpers::translate('All')}}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/pending')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['pending'])}}"
                                            title="{{\App\CPU\Helpers::translate('pending')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="pending orders">
                                                {{\App\CPU\Helpers::translate('pending')}}
                                                <span class="badge badge-soft-warning ml-1 b-bell" style="display: none">
                                                    <i class="fa fa-bell"></i>
                                                </span>
                                                <span class="badge badge-soft-info badge-pill ml-1">
                                                    {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'pending'])->count()}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                                        <i class="fa fa-bell"></i>
                                                    </span>
                                                </span>
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/confirmed')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['confirmed'])}}"
                                            title="{{\App\CPU\Helpers::translate('confirmed')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="confirmed orders">
                                                    {{\App\CPU\Helpers::translate('confirmed')}}
                                                    <span class="badge badge-soft-success badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'confirmed'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/processing')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['processing'])}}"
                                            title="{{\App\CPU\Helpers::translate('Packaging')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="Packaging orders">
                                                {{\App\CPU\Helpers::translate('Packaging')}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'processing'])->count()}}
                                                    </span>
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/out_for_delivery')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['out_for_delivery'])}}"
                                            title="{{\App\CPU\Helpers::translate('out_for_delivery')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="out_for_delivery orders">
                                                {{\App\CPU\Helpers::translate('out_for_delivery')}}
                                                    <span class="badge badge-soft-warning badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'out_for_delivery'])->count()}}
                                                    </span>
                                            </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/delivered')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['delivered'])}}"
                                            title="{{\App\CPU\Helpers::translate('delivered')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate"  t="delivered orders">
                                                {{\App\CPU\Helpers::translate('delivered')}}
                                                    <span class="badge badge-soft-success badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'delivered'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/returned')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['returned'])}}"
                                            title="{{\App\CPU\Helpers::translate('returned')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="returned orders">
                                                    {{\App\CPU\Helpers::translate('returned')}}
                                                        <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where('order_status','returned')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/orders/list/failed')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['failed'])}}"
                                            title="{{\App\CPU\Helpers::translate('failed')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="Failed_to_Deliver orders">
                                                    {{\App\CPU\Helpers::translate('Failed_to_Deliver')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'failed'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li class="nav-item {{Request::is('seller/orders/list/canceled')?'active':''}}">
                                            <a class="nav-link " href="{{route('seller.orders.list',['canceled'])}}"
                                            title="{{\App\CPU\Helpers::translate('canceled')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="canceled orders">
                                                    {{\App\CPU\Helpers::translate('canceled')}}
                                                        <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\Order::where('seller_id',auth('seller')->user()->id)->where(['order_status'=>'canceled'])->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="navbar-vertical-aside-has-menu {{Request::is('seller/refund-section/refund/*')?'active':''}}">
                                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle px-1"
                                    href="javascript:" title="{{\App\CPU\Helpers::translate('Refund_Requests')}}">
                                        <i class="tio-receipt-outlined nav-icon"></i>
                                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                            {{\App\CPU\Helpers::translate('Refund_Requests')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1" style="display: none"><i class="fa fa-bell"></i></span>
                                        </span>
                                    </a>
                                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                        style="display: {{Request::is('seller/refund-section/refund*')?'block':'none'}}">
                                        <li class="nav-item {{Request::is('seller/refund-section/refund/list/pending')?'active':''}}">
                                            <a class="nav-link"
                                            href="{{route('seller.refund-section.refund.list',['pending'])}}"
                                            title="{{\App\CPU\Helpers::translate('pending')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="r pending orders">
                                                {{\App\CPU\Helpers::translate('pending')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','pending')->count()}}
                                                        <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                                            <i class="fa fa-bell"></i>
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>

                                        <li class="nav-item {{Request::is('seller/refund-section/refund/list/approved')?'active':''}}">
                                            <a class="nav-link"
                                            href="{{route('seller.refund-section.refund.list',['approved'])}}"
                                            title="{{\App\CPU\Helpers::translate('approved')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="approved orders">
                                                {{\App\CPU\Helpers::translate('approved')}}
                                                    <span class="badge badge-soft-info badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','approved')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/refund-section/refund/list/refunded')?'active':''}}">
                                            <a class="nav-link"
                                            href="{{route('seller.refund-section.refund.list',['refunded'])}}"
                                            title="{{\App\CPU\Helpers::translate('refunded')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="refunded orders">
                                                {{\App\CPU\Helpers::translate('refunded')}}
                                                    <span class="badge badge-soft-success badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','refunded')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{Request::is('seller/refund-section/refund/list/rejected')?'active':''}}">
                                            <a class="nav-link"
                                            href="{{route('seller.refund-section.refund.list',['rejected'])}}"
                                            title="{{\App\CPU\Helpers::translate('rejected')}}">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate" t="rejected orders">
                                                {{\App\CPU\Helpers::translate('rejected')}}
                                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                                        {{\App\Model\RefundRequest::where('status','rejected')->count()}}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>



                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/messages*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle p-1"
                               href="javascript:">
                                <i class="tio-user nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    {{\App\CPU\Helpers::translate('messages')}}
                                    <span class="badge badge-soft-warning badge-pill ml-1" style="display: none"><i class="fa fa-bell"></i></span>
                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display: {{Request::is('seller/messages*')?'block':'none'}}">
                                <li class="nav-item {{Request::is('seller/messages/chat/customer')?'active':''}}">
                                    <a class="nav-link " href="{{route('seller.messages.chat', ['type' => 'customer'])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="customers messages">
                                            {{\App\CPU\Helpers::translate('Customer messages')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{Request::is('seller/messages/chat/delivery-man')?'active':''}}">
                                    <a class="nav-link" href="{{route('seller.messages.chat', ['type' => 'delivery-man'])}}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate" t="delivery man messages">
                                            {{\App\CPU\Helpers::translate('Delivery-Man messages')}}
                                            <span class="badge badge-soft-warning badge-pill ml-1" style="display: none">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!-- End Pages -->
                        @php($shippingMethod = \App\CPU\Helpers::get_business_settings('shipping_method'))
                        @if($shippingMethod=='sellerwise_shipping' && 1 == 2)
                            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/shipping-method*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link"
                                   href="{{route('seller.business-settings.shipping-method.add')}}">
                                    <i class="tio-settings nav-icon"></i>
                                    <span
                                        class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize" t="shipping_method">
                                        {{\App\CPU\Helpers::translate('shipping_method')}}
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if(1==2)
                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/business-settings/withdraw*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.business-settings.withdraw.list')}}">
                                <i class="tio-wallet-outlined nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize" t="withdraws">
                                        {{\App\CPU\Helpers::translate('withdraws')}}
                                    </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/profile*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.profile.view')}}">
                                <i class="tio-shop nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="My_Bank_Info">
                                    {{\App\CPU\Helpers::translate('My_Bank_Info')}}
                                </span>
                            </a>
                        </li>


                        <li class="navbar-vertical-aside-has-menu {{Request::is('seller/shop*')?'active':''}}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="{{route('seller.shop.view')}}">
                                <i class="tio-home nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="My_Shop">
                                    {{\App\CPU\Helpers::translate('My_Shop')}}
                                </span>
                            </a>
                        </li>
                        @endif

                        @php( $shipping_method = \App\CPU\Helpers::get_business_settings('shipping_method'))
                        @if($shipping_method=='sellerwise_shipping' && 1 == 2)
                            <li class="nav-item {{Request::is('seller/delivery-man*')?'scroll-here':''}}">
                                <small class="nav-subtitle">{{\App\CPU\Helpers::translate('delivery_man_management')}}</small>
                                <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                            </li>
                            <li class="navbar-vertical-aside-has-menu {{Request::is('seller/delivery-man*')?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle p-1"
                                   href="javascript:">
                                    <i class="tio-user nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="Delivery-Man">
                                    {{\App\CPU\Helpers::translate('Delivery-Man')}}
                                </span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                    style="display: {{Request::is('seller/delivery-man*')?'block':'none'}}">
                                    <li class="nav-item {{Request::is('seller/delivery-man/add')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.delivery-man.add')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate" t="new Delivery-Man">{{\App\CPU\Helpers::translate('Add_New')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('seller/delivery-man/list') || Request::is('seller/delivery-man/earning-statement*') || Request::is('seller/delivery-man/earning-active-log*') || Request::is('seller/delivery-man/order-wise-earning*')?'active':''}}">
                                        <a class="nav-link" href="{{route('seller.delivery-man.list')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate" t="list Delivery-Man">{{\App\CPU\Helpers::translate('List')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{Request::is('seller/delivery-man/withdraw-list') || Request::is('seller/delivery-man/withdraw-view*')?'active':''}}">
                                        <a class="nav-link " href="{{route('seller.delivery-man.withdraw-list')}}"
                                           title="{{\App\CPU\Helpers::translate('withdraws')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate" t="withdraws Delivery-Man">{{\App\CPU\Helpers::translate('withdraws')}}</span>
                                        </a>
                                    </li>

                                    <li class="nav-item {{Request::is('seller/delivery-man/emergency-contact/') ? 'active' : ''}}">
                                        <a class="nav-link " href="{{route('seller.delivery-man.emergency-contact.index')}}"
                                           title="{{\App\CPU\Helpers::translate('withdraws')}}">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate" t="Emergency_Contact">{{\App\CPU\Helpers::translate('Emergency_Contact')}}</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            @endif
                            <li class="navbar-vertical-aside-has-menu {{(Request::is('seller/business-settings/web-config/environment-setup') || Request::is('seller/business-settings/web-config/mysitemap') || Request::is('seller/business-settings/analytics-index') || Request::is('seller/currency/view') || Request::is('seller/business-settings/web-config/db-index') || Request::is('seller/business-settings/language*'))?'active':''}}">
                                <a class="js-navbar-vertical-aside-menu-link nav-link px-1"
                                   title="{{\App\CPU\Helpers::translate('settings')}}"
                                   href="{{route('seller.settings')}}">
                                    <i class="fa fa-gear nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate" t="settings">
                                        {{\App\CPU\Helpers::translate('settings')}}
                                    </span>
                                </a>
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
        $(window).on('load' , function() {
            if($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });
    </script>
@endpush
