@php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))
@foreach($products as $product)
    @php($product->unit_price = Helpers::getProductPrice_pl($product->id)['value'] ?? 0)
    @php($product->discount = Helpers::getProductPrice_pl($product->id)['discount_price'] ?? 0)
    @php($product->discount_type = Helpers::getProductPrice_pl($product->id)['discount_type'] ?? 0)
    @if(!empty($product['product_id']))
        @php($product=$product->product)
    @endif
    <div class=" {{Request::is('products*')?'col-lg-4 col-md-4 col-sm-12 col-12':'col-lg-4 col-md-4 col-sm-12 col-12'}} {{Request::is('shopView*')?'col-lg-3 col-md-4 col-sm-4 col-6':''}} mb-2 p-2">
        @if(!empty($product))
            @include('web-views.partials._single-product',['p'=>$product,'decimal_point_settings'=>$decimal_point_settings])
        @endif
    </div>
@endforeach


