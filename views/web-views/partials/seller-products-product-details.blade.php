@php($current_lang = session()->get('local'))
@if(isset($product))
    @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
    @php($productdiscount = Helpers::getProductPrice_pl($product['id'])['discount_price'] ?? 0)
    @php($productdiscount_type = Helpers::getProductPrice_pl($product['id'])['discount_type'] ?? 0)
    @php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))
    <div class="flash_deal_product rtl" style="cursor: pointer; height:155px; margin-bottom:10px;"
         onclick="location.href='{{route('product',$product->slug)}}'">
        @if($productdiscount > 0)
        <div class="d-flex" style="position:absolute;z-index:2;">
            <span class="for-discoutn-value p-1 pl-2 pr-2" style="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'border-radius:0px 5px' : 'border-radius:5px 0px'}};">
                @if ($productdiscount_type == 'percent')
                    {{round($productdiscount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                @elseif($productdiscount_type =='flat')
                    {{\App\CPU\Helpers::currency_converter($productdiscount)}}
                @endif {{\App\CPU\Helpers::translate('off')}}
            </span>
        </div>
        @endif
        <div class=" d-flex" style="">
            <div class=" d-flex align-items-center justify-content-center"
                 style="padding-{{(Session::get('direction') ?? 'rtl') === "rtl" ?'right:14px':'left:14px'}};padding-top:14px;">
                <div class="flash-deals-background-image" style="background: {{$web_config['primary_color']}}10">
                    <img style="height: 125px!important;width:125px!important;border-radius:5px;"
                    src="{{ Helpers::getImg('storage/app/public/product/'.$current_lang.'/'.(isset(json_decode($product['images'])->$current_lang) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''),'125','125') }}"
                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"/>
                </div>
            </div>
            <div class=" flash_deal_product_details pl-3 pr-3 pr-1 d-flex align-items-center">
                <div>
                    <div>
                        <span class="flash-product-title">
                            {{Helpers::getItemName('products','name',$product->id)}}
                        </span>
                    </div>
                    @if (\App\Model\BusinessSetting::where('type','products_rating')->first()->value ?? '')
                    <div class="flash-product-review">
                        @for($inc=0;$inc<5;$inc++)
                            @if($inc<$overallRating[0])
                                <i class="sr-star czi-star-filled active"></i>
                            @else
                                <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                            @endif
                        @endfor
                        <label class="badge-style2">
                            ( {{$product->reviews->count()}} )
                        </label>
                    </div>
                    @endif
                    <div>
                        @if($productdiscount > 0)
                            <strike
                                style="font-size: 12px!important;color: #E96A6A!important;">
                                {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                            </strike>
                        @endif
                    </div>
                    <div class="flash-product-price">
                        {{\App\CPU\Helpers::currency_converter($product->unit_price-\App\CPU\Helpers::get_product_discount($product,$product->unit_price))}}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
