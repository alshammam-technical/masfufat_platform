<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <i class="tio-clear"></i>
</button>
<div class="coupon__details p-5">
    <div class="coupon__details-left">
        <div class="coupon-info">
            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('coupon_title')}} :</span>
                <strong id="min_purchase">{{ $coupon->title }}</strong>
            </div>
            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('coupon_code')}} :</span>
                <strong id="min_purchase">{{ $coupon->code }}</strong>
            </div>
            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('coupon_type')}} :</span>
                <strong id="min_purchase">{{ Helpers::translate($coupon->coupon_type) }}</strong>
            </div>

            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('minimum_purchase')}} :</span>
                <strong id="min_purchase">{{\App\CPU\BackEndHelper::set_symbol(($coupon->min_purchase))}}</strong>
            </div>
            @if($coupon->coupon_type != 'free_delivery' && $coupon->discount_type == 'percentage')
            <div class="coupon-info-item" id="max_discount_modal_div">
                <span>{{\App\CPU\Helpers::translate('maximum_discount')}} : </span>
                <strong id="max_discount">{{\App\CPU\BackEndHelper::set_symbol(($coupon->max_discount))}}</strong>
            </div>
            @endif
            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('start_date')}} : </span>
                <span id="start_date">{{ \Carbon\Carbon::parse($coupon->start_date)->format('dS M Y') }}</span>
            </div>
            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('expire_date')}} : </span>
                <span id="expire_date">{{ \Carbon\Carbon::parse($coupon->expire_date)->format('dS M Y') }}</span>
            </div>
            <div class="coupon-info-item">
                <span>{{\App\CPU\Helpers::translate('discount_bearer')}} : </span>
                <span id="expire_date">{{\App\CPU\Helpers::translate($coupon->coupon_bearer == 'inhouse' ? 'admin' : $coupon->coupon_bearer)}}</span>
            </div>
        </div>
    </div>
    <div class="coupon__details-right">
        <div class="coupon">
            @if($coupon->coupon_type == 'free_delivery')
                <img src="{{ asset('public/assets/back-end/img/free-delivery.png') }}" alt="Free delivery" width="100">
            @else
                <div class="d-flex">
                    <span> {{\App\CPU\Helpers::translate('The amount of the discount')}} : </span>
                    <h4 id="discount" class=" mx-1">
                        {{$coupon->discount_type=='amount'?\App\CPU\BackEndHelper::set_symbol(($coupon->discount)):$coupon->discount.'%'}}
                    </h4>
                </div>

            @endif
        </div>
    </div>
</div>
