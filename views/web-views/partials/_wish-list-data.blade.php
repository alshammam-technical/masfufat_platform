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
</style>
@php($current_lang = session()->get('local'))
@php($decimal_point_settings = !empty(\App\CPU\Helpers::get_business_settings('decimal_point_settings')) ? \App\CPU\Helpers::get_business_settings('decimal_point_settings') : 0)
@if($wishlists->count()>0)
    <div class="row mt-3">
    @foreach($wishlists as $wishlist)
    @php($product = $wishlist->product_full_info)
    @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
        @if( $wishlist->product_full_info)
            <div class="col-sm-6 col-md-3 col-6 mb-4 px-0 bg-white mx-0 sm:mx-2">
                <button class="absolute z-10 text-light rounded-0 col-12" onclick="removeWishlist({{ $product['id'] }});$(this).parent().remove()">
                    <i class="ri-heart-fill" style="color:#b70101;float: left;font-size: 30px;margin-top: -4px;"></i>
                </button>
                @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
            </div>
        @else
            <span class="badge badge-danger">{{\App\CPU\Helpers::translate('item_removed')}}</span>
        @endif
    @endforeach
    </div>
@else
    <center>
        <h6 class="text-muted">
            {{\App\CPU\Helpers::translate('No data found')}}.
        </h6>
    </center>
@endif
