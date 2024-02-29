@php($pricing = Helpers::getProductPrice_pl($product->id) ?? [])
@php($product->unit_price = $pricing['value'] ?? 0)
@isset($deal_of_the_day->product)
@php($deal_of_the_day->product->unit_price = $pricing['value'] ?? 0)
@endisset
@php($productdiscount = $pricing['discount_price'] ?? 0)
@php($productdiscount_type = $pricing['discount_type'] ?? 0)
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
@php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
@php($user = \App\User::find($storeId))
@php($pending_products = $user->pending_products ?? [])
@if (\App\CPU\Helpers::store_module_permission_check('store.products.syncc'))
@if(!\App\CPU\Helpers::productChoosen($product->id))
@if($product->current_stock != 0)
@if(($pricing['display_for'] ?? '') == "add" || ($pricing['display_for'] ?? '') == "both")
<!-- Checkbox -->
<div class="form-group product-actions sm:block hidden" style="position: absolute;top: 0;">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input product-checkbox" name="linked[]" value="{{$product->id}}">
        <label class="custom-control-label" for="linked[]" onclick="$(this).prev('input').click()" style="transform: scale(1.5)"></label>
    </div>
</div>
<!-- End Checkbox -->
@endif
@endif
@endif
@endif

<div class="product-single-hover rounded-lg with-transitions bg-primary" style="border-radius: 16px;box-shadow: #c3c3c3 0px 0px 20px 0px;">

    <div class="sm:h-60 h-auto inline_product clickable d-flex justify-content-center rounded-top-11" style="cursor: pointer;background:white">
        <div class="d-flex d-block h-60" style="cursor: pointer;">

            <a href="{{ isset($admin) ? route('admin.product.edit', [$product['id']]) : route('product', $product->slug) }}" class="relative min-h-full max-h-[240px]">
                <img class="bg-light sm:w-60" @isset($admin)
                @php($domain = env('APP_URL'))
                @php($local = session()->get('local'))
                @php($path = $domain . '/storage/app/public/product/' . $local . '/')
                @php($img = (isset(json_decode($product['images'])->$local)) ? json_decode($product['images'])->$local[0] ?? '' : '')
                src="{{ $path.$img }}"
                @else
                src="{{ Helpers::getImg('storage/app/public/product/'.$current_lang.'/'.(isset(json_decode($product['images'])->$current_lang) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''),'241.625','241.625') }}" @endisset
                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                style="border-radius: 5px 5px 0px 0px;">
                @if(strlen(Helpers::get_prop('App\Model\Product',$product->id,'promo_title')) >= 5)
                <div class="p-2 text-dark w-75 promo-title {{(intval(Helpers::get_prop('App\Model\Product',$product->id,'promo_pos')) == 0) ? 'top-right' : Helpers::get_prop('App\Model\Product',$product->id,'promo_pos') ?? 'top-right'}}" style="background-color: {{Helpers::get_prop('App\Model\Product',$product->id,'promo_bg') ?? '#373f50'}};">
                    <strong style="opacity: 1;color: {{Helpers::get_prop('App\Model\Product',$product->id,'promo_text') ?? 'white'}} !important">{{Helpers::get_prop('App\Model\Product',$product->id,'promo_title')}}</strong>
                </div>
                @endif
            </a>
        </div>
    </div>
    <div class="single-product-details rounded-bottom-11 sm:h-48" style="position:relative;padding-top:10px;border-radius: 0px 0px 5px 5px; ">
        <div class="h-14 sm:h-auto text-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right pr-3' : 'left pl-3'}}">
            <a href="{{route('product',$product->slug)}}" class="text-lg fw-bold absolute sm:static sm:w-auto w-36">
                {{ \Illuminate\Support\Str::limit(Helpers::getItemName('products','name',$product->id),34) }}
            </a>
            @if(Helpers::get_prop('App\Model\Product',$product->id,'short_desc_qv') ?? false)
            <p>{{Helpers::get_prop('App\Model\Product',$product->id,'short_desc')}}</p>
            @endif
        </div>
        @if(1==2)
        <div class="rating-show justify-content-between text-center">
            @if (($products_rating ?? ''))
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
        <div class="bg-white relative sm:static sm:w-auto w-11/12 inset-x-2.5">
            <div class="text-start ps-0 sm:ps-4 row">
                @isset($deal_of_the_day->product)
                @if($deal_of_the_day->product->discount > 0)
                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                        {{\App\CPU\Helpers::currency_converter($deal_of_the_day->product->unit_price)}}
                    </strike>
                @endif
                <span class="col-md-6 col-12 text-accent text-success" style="font-size: 22px !important;font-weight: bold">
                    {{\App\CPU\Helpers::currency_converter(
                        $deal_of_the_day->product->unit_price-(\App\CPU\Helpers::get_product_discount($deal_of_the_day->product,$deal_of_the_day->product->unit_price))
                    )}}
                </span>
                @else
                <span class="col-md-6 col-12 ext-accent text-success" style="font-size: 22px !important;font-weight: bold">
                    {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                    )}}
                </span>
                @endisset
                @if($display_product_qty ?? \App\Model\BusinessSetting::where('type','display_product_qty')->first()->value ?? null)
                <span class="col-6 hidden sm:block" style="font-size: 15px !important;color:#A0A0A0">
                    {{ Helpers::translate('current stock') }} : <span class="text-success fw-bolder current-stock">{{ $product->current_stock }}</span>
                </span>
                @endif

                </br>


                <div>
                    @if($product->has_discount)
                        <span style="font-size: 15px!important;color: #A0A0A0!important;">
                            {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                        </span>
                        <span style="font-size: 15px!important;" class="text-success mx-2">
                            @php($productdiscount = $pricing['discount'] ?? 0)
                            @php($productdiscount_type = $pricing['discount_type'] ?? 0)
                            @if ($productdiscount_type == 'percent')
                            {{round($productdiscount)}}%
                            @elseif($productdiscount_type =='flat')
                                {{\App\CPU\Helpers::currency_converter($productdiscount)}}
                            @endif {{\App\CPU\Helpers::translate('Discount')}}
                        </span>
                    @endif
                    @if (isset($admin))
                        <span class="hidden sm:inline-block" style="font-size: 12px;font-weight:400">
                            <span class="text-muted ">{{\App\CPU\Helpers::translate('Product Number')}}:</span>
                            <span class="mb-3 text-danger">{{$product->item_number }}</span>
                        </span>
                        <br>
                        <span class="hidden sm:inline-block" style="font-weight:400">
                            <span class="text-muted">
                                {{\App\CPU\Helpers::translate('barcode')}}:
                            </span>
                            <span class="ext-accent text-success" style="font-weight: bold">
                                {{ $product->code }}
                            </span>
                        </span>
                    @else
                        @if($show_price_with_tax ?? \App\Model\BusinessSetting::where('type','show_price_with_tax')->first()->value ?? '')
                            @if($product->has_tax)
                            <span class="hidden sm:inline-block" style="font-size: 12px;font-weight:400">
                                <span class="text-muted ">{{\App\CPU\Helpers::translate('tax')}}:</span>
                                <span class="mb-3 text-danger">{{ Helpers::currency_converter($product->unit_price * $product->tax / 100) }}</span>
                            </span>
                            <br>
                            <span class="hidden sm:inline-block" style="font-weight:400">
                                <span class="text-muted">
                                    {{\App\CPU\Helpers::translate('total')}}:
                                </span>
                                <span class="ext-accent text-success" style="font-weight: bold">
                                    {{ Helpers::currency_converter($product->unit_price+($product->unit_price * $product->tax / 100)) }}
                                </span>
                            </span>
                            @endif
                        @endif
                    @endif
                </div>


            </div>
        </div>

    </div>
    @isset($noBtns)
    @else
    @if (\App\CPU\Helpers::store_module_permission_check('store.products.add_to_cart') || \App\CPU\Helpers::store_module_permission_check('store.products.syncc'))
    @include('web-views.partials.product-actions')
    @endif
    @endisset


</div>



