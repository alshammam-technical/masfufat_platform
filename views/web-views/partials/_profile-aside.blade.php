<style>
    body {
        font-family: sans-serif;
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #6A6A6A;
    }

    label {
        font-size: 16px;
    }

    .divider-role {
        border-bottom: 1px solid whitesmoke;
    }

    .sidebarL h3:hover + .divider-role {
        border-bottom: 3px solid {{$web_config['secondary_color']}}    !important;
        transition: .2s ease-in-out;
    }

    .price_sidebar {
        padding: 20px;
    }

    @media (max-width: 600px) {

        .sidebar_heading h1 {
            text-align: center;
            color: aliceblue;
            padding-bottom: 17px;
            font-size: 19px;
        }

        .sidebarR {
            padding: 24px;
        }

        .price_sidebar {
            padding: 20px;
        }
    }

</style>

<div class="sidebarR col-lg-3 col-md-3">
    <!--Price Sidebar-->
    <div class="price_sidebar rounded-lg box-shadow-sm" id="shop-sidebar" style="margin-bottom: -10px;background: white">
        <div class="box-shadow-sm">

        </div>

        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('user-account*')?'active-menu':''}}" href="{{route('user-account')}}">
                        {{ \App\CPU\Helpers::translate('my account data') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>


        @if (App\CPU\Helpers::get_business_settings('wallet_status') == 1)
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('wallet*') ? 'active-menu' :''}}" href="{{route('wallet') }} ">
                        {{ \App\CPU\Helpers::translate('my_wallet') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        @endif

        @if (App\CPU\Helpers::get_business_settings('loyalty_point_status') == 1)
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('wallet*') ? 'active-menu' :''}}" href="{{route('loyalty') }} ">
                        {{ \App\CPU\Helpers::translate('my_loyalty_point') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        @endif

        @if(auth('customer')->user()->is_active)
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('wishlists*') ? 'active-menu' :''}}" href="{{route('wishlists') }} ">
                        {{ \App\CPU\Helpers::translate('wish_list') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        @endif

        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-tickets*') ? 'active-menu' :''}}" href="{{route('account-tickets') }} ">
                        {{ \App\CPU\Helpers::translate('support_ticket') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>

        @if (App\CPU\Helpers::get_business_settings('chat_with_seller_status') == 1)
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('chat/seller*') ? 'active-menu' :''}}" href="{{route('chat',['type'=>'seller'])}}">
                        {{ \App\CPU\Helpers::translate('chat_with_seller') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        @endif

        @if (App\CPU\Helpers::get_business_settings('chat_with_delivery_status') == 1)
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('/chat/delivery-man*') ? 'active-menu' :''}}" href="{{route('chat',['type'=>'delivery-man'])}}">
                        {{ \App\CPU\Helpers::translate('chat_with_delivery-man') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        @endif

        @if(auth('customer')->user()->is_active)
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('linked-accounts') ? 'active-menu' :''}}" href="{{route('linked-accounts')}}">
                        {{ \App\CPU\Helpers::translate('Settings for linking my online store API') }}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        @endif


    </div>
</div>


















