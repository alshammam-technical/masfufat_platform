@php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))
@php($products_rating = \App\Model\BusinessSetting::where('type','products_rating')->first()->value ?? null)
@php($display_product_qty = \App\Model\BusinessSetting::where('type','display_product_qty')->first()->value ?? null)
@php($show_price_with_tax = \App\Model\BusinessSetting::where('type','show_price_with_tax')->first()->value ?? '')
@foreach($products as $product)
    @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
    @php($productdiscount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
    @php($productdiscount_type = Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
    @if(!empty($product['product_id']))
        @php($product=$product->product)
    @endif
    <div data-id="{{ $product->id }}" class="product-{{ $product->id }} {{Request::is('products*')?'col-lg-3 col-md-3 col-sm-12 col-6':'col-lg-3 col-md-3 col-sm-6 col-6'}} {{Request::is('shopView*')?'col-lg-3 col-md-3 col-sm-3 col-6':''}} mb-2 p-2">
        @if(!empty($product))
            @include('web-views.partials._single-product',
            [
                'p'=>$product,
                'decimal_point_settings'=>$decimal_point_settings,
                'products_rating' => $products_rating,
                'display_product_qty' => $display_product_qty,
                'show_price_with_tax' => $show_price_with_tax,
            ])
        @endif
    </div>
@endforeach


