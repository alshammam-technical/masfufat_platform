@php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
@php($product->discount = Helpers::getProductPrice_pl($product['id'])['discount_price'] ?? 0)
@php($product->discount_type = Helpers::getProductPrice_pl($product['id'])['discount_type'] ?? 0)
@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))
@php($current_lang = session()->get('local'))
@if(!$product->slug)
@php($product->slug = Helpers::gen_slug($product->id))
@endif
<style>
    .quick-view{
        display: none;
        padding-bottom: 8px;
    }

    .quick-view , .single-product-details{
        background: #ffffff;
    }
</style>

@php($pending_products = auth('customer')->user()->pending_products ?? [])
@if(!\App\CPU\Helpers::productChoosen($product->id))
@if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "add" || (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
<!-- Checkbox -->
<div class="form-group" style="position: absolute;top: 0;">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input product-checkbox" name="linked[]" value="{{$product->id}}">
        <label class="custom-control-label" for="linked[]" onclick="$(this).prev('input').click()" style="transform: scale(1.5)"></label>
    </div>
</div>
<!-- End Checkbox -->
@endif
@endif

<div class="product-single-hover rounded-lg with-transitions bg-primary" style="border-radius: 16px;box-shadow: #c3c3c3 0px 0px 20px 0px;">


    <div class=" inline_product clickable d-flex justify-content-center rounded-top-11" style="cursor: pointer;background:white;height: 240px;">
        <div class="d-flex d-block" style="cursor: pointer;">
            <a href="{{route('product',$product->slug)}}">
                <img class="bg-light"
                src="{{ Helpers::getImg('storage/app/public/product/'.$current_lang.'/'.(isset(json_decode($product['images'])->$current_lang) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''),'241.625','241.625') }}"
                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                style="width: 240px;border-radius: 5px 5px 0px 0px;">
                @if(strlen(Helpers::getItemName('products','promo_title',$product->id)) >= 5)
                <div class="p-2 text-dark w-75 promo-title {{(intval(Helpers::get_prop('App\Model\Product',$product->id,'promo_pos')) == 0) ? 'top-right' : Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') ?? 'top-right'}}" style="background-color: {{Helpers::get_prop('App\Model\Product',$product->id,'promo_bg') ?? '#373f50'}};">
                    <strong style="opacity: 1;color: {{Helpers::get_prop('App\Model\Product',$product->id,'promo_text') ?? 'white'}} !important">{{Helpers::getItemName('products','promo_title',$product->id)}}</strong>
                </div>
                @endif
            </a>
        </div>
    </div>
    <div class="single-product-details rounded-bottom-11" style="position:relative;height:145px;padding-top:10px;border-radius: 0px 0px 5px 5px; ">
        <div class="text-{{Session::get('direction') === "rtl" ? 'right pr-3' : 'left pl-3'}}">
            <a href="{{route('product',$product->slug)}}" class="fs-20 fw-bold">
                {{ Helpers::getItemName('products','name',$product->id) }}
            </a>
            @if(Helpers::get_prop('App\Model\Product',$product->id,'short_desc_qv') ?? false)
            <p>{{Helpers::getItemName('products','short_desc',$product->id)}}</p>
            @endif
        </div>
        @if(1==2)
        <div class="rating-show justify-content-between text-center">
            @if ((\App\Model\BusinessSetting::where('type','products_rating')->first()->value ?? ''))
            <span class="d-inline-block font-size-sm text-body">
                @for($inc=0;$inc<5;$inc++)
                    @if($inc<$overallRating[0])
                        <i class="sr-star czi-star-filled active"></i>
                    @else
                        <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                    @endif
                @endfor
                <label class="badge-style">( {{$product->reviews_count}} )</label>
            </span>
            @endif
        </div>
        @endif
        <div class="text-start ps-3">
            @isset($deal_of_the_day->product)
            @if($deal_of_the_day->product->discount > 0)
                <strike style="font-size: 12px!important;color: #E96A6A!important;">
                    {{\App\CPU\Helpers::currency_converter($deal_of_the_day->product->unit_price)}}
                </strike>
            @endif
            <span class="text-accent text-success" style="font-size: 22px !important;">
                {{\App\CPU\Helpers::currency_converter(
                    $deal_of_the_day->product->unit_price-(\App\CPU\Helpers::get_product_discount($deal_of_the_day->product,$deal_of_the_day->product->unit_price))
                )}}
            </span>
            @else
            <span class="text-accent text-success" style="font-size: 22px !important;">
                {{\App\CPU\Helpers::currency_converter(
                    $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                )}}
            </span>
            @endisset
            </br>
            <span class="text-dark" style="font-size: 22px !important;">
                {{ Helpers::translate('current stock') }} : {{ $product->current_stock }}
            </span>

            <div>
                @if($product->discount > 0)
                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                    </strike>
                    <span style="font-size: 12px!important;" class="text-success mx-2">
                        @if($product->discount > 0)
                            @php($product->discount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
                            @php($product->discount_type = Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
                            @if ($product->discount_type == 'percent')
                            {{round($product->discount)}}%
                            @elseif($product->discount_type =='flat')
                                {{\App\CPU\Helpers::currency_converter($product->discount)}}
                            @endif {{\App\CPU\Helpers::translate('off_')}}
                        @endif
                    </span>
                @endif
            </div>

        </div>

    </div>
    @isset($noBtns)
    @else
    @include('web-views.partials.product-actions')
    @endisset


</div>

<form id="add-to-cart-form-{{$product->id}}" hidden>
    @csrf
    @php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 0)
    <input type="hidden" name="quantity" value="{{ $minimum_order_qty ?? 1 }}">
    <input type="hidden" name="id" value="{{ $product->id }}">

    <div class="position-relative mb-4">
        @if (count(json_decode($product->colors)) > 0)
            <div class="d-flex flex-wrap gap-2">
                <div class="product-description-label">{{\App\CPU\Helpers::translate('color')}}:</div>

                <div class="color-select d-flex gap-2 flex-wrap" id="option1">
                    @foreach (json_decode($product->colors) as $key => $color)
                    <input class="btn-check" type="radio" onclick="color_change(this);"
                            id="{{ $product->id }}-color-{{ $key }}"
                            name="color" value="{{ $color }}"
                            @if($key == 0) checked @endif autocomplete="off">
                    <label id="label-{{ $product->id }}-color-{{ $key }}" class="btn btn-sm mb-0 {{$key==0?'border-add':""}}" style="background: {{ $color }};"
                            for="{{ $product->id }}-color-{{ $key }}"
                                data-bs-toggle="tooltip"></label>
                    @endforeach
                </div>
            </div>
        @endif
        @php($qty = 0)
    </div>
    @foreach (json_decode($product->choice_options) as $key => $choice)
        <h5 class="text-capitalize mt-3 mb-2">{{ $choice->title }}</h5>
        <div class="d-flex gap-2 flex-wrap">
            @foreach ($choice->options as $key => $option)
                <input class="btn-check" type="radio"
                       id="{{ $choice->name }}-{{ $option }}"
                       name="{{ $choice->name }}" value="{{ $option }}"
                       @if($key == 0) checked @endif autocomplete="off">
                <label class="btn btn-sm check-label border-0 mb-0"
                       for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
            @endforeach
        </div>
    @endforeach
</form>

