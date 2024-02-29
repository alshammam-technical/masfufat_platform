<style>

    body {
        font-family: 'Titillium Web', sans-serif
    }

    .card {
        border: none
    }

    .totals tr td {
        font-size: 13px
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #6A6A6A;
    }

    .font-name {
        font-weight: 600;
        font-size: 15px;
        color: #030303;
    }

    .sellerName {

        font-weight: 600;
        font-size: 14px;
        color: #030303;
    }

    .wishlist_product_img img {
        margin: 15px;
    }

    @media (max-width: 600px) {
        .font-name {
            font-size: 12px;
            font-weight: 400;
        }

        .amount {
            font-size: 12px;
        }
    }

    @media (max-width: 600px) {
        .wishlist_product_img {
            width: 20%;
        }

        .forPadding {
            padding: 6px;
        }

        .sellerName {

            font-weight: 400;
            font-size: 12px;
            color: #030303;
        }

        .wishlist_product_desc {
            width: 50%;
            margin-top: 0px !important;
        }

        .wishlist_product_icon {
            margin-left: 1px !important;
        }

        .wishlist_product_btn {
            width: 30%;
            margin-top: 10px !important;
        }

        .wishlist_product_img img {
            margin: 8px;
        }
    }

    .bg-grey{
        background-color: #f2f2f2;
    }
</style>
@php($current_lang = session()->get('local'))
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@if($notifications->count()>0)
    @foreach($notifications as $notification)
        <div class="card box-shadow-sm mt-5">
            <div class="product">
                <div class="card {{ in_array($storeId,explode(',',$notification->seen_by)) ? '' : 'bg-grey' }}">
                    <div class="row forPadding">
                        <div class="wishlist_product_img col-md-2 col-lg-2 col-sm-2">
                            <a>
                                <img width="50%"
                                    onerror="$(this).remove()"
                                    src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}"
                                    >
                            </a>
                        </div>
                        <div class="wishlist_product_desc col-md-5 mt-4 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'pr-4' : 'pl-4'}} mb-3">
                            <span class="font-name mb-1 d-block">
                                <a href="@if ($notification->title == Helpers::translate('Your support ticket has been answered') || $notification->title == Helpers::translate('A support ticket has been sent to you'))
                                    {{route('support-ticket.index',[$notification->ticket_id ?? ''])}}
                                @else
                                   #
                                @endif">
                                    {{ $notification->title ?? Helpers::translate('New notification') }}
                                </a>
                            </span>
                            <br>

                            <div class="">
                                {!! $notification->description !!}
                            </div>
                        </div>
                        <div class="wishlist_product_btn col-md-3 mt-6 float-right bodytr font-weight-bold" style="color: #92C6FF;">

                            {{ $notification->created_at }}
                        </div>
                        <div class="wishlist_product_btn col-md-2 mt-6 float-right bodytr font-weight-bold text-center">
                            @if(!in_array($storeId,explode(',',$notification->seen_by)))
                            <a role="button" class="text-success" onclick="$.get('{{route('notifications.read',['id'=>$notification['id']])}}').then(d=>{return 1});$(this).closest('.bg-grey').removeClass('bg-grey');$(this).remove()">
                                <i class="fa fa-eye"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <center>
        <h6 class="text-muted">
            {{\App\CPU\Helpers::translate('No notifications found')}}.
        </h6>
    </center>
@endif
