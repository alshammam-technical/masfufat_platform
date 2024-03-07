@php($current_lang = session()->get('local') ?? 'sa')
<div class="pos-product-item card" onclick="quickView('{{$product->id}}')">
    <div class="pos-product-item_thumb">
        @php($current_lang = session()->get('local') ?? 'sa')
        <img class="img-fit" src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                 onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'">
    </div>

    <div class="pos-product-item_content clickable">
        <div class="pos-product-item_title">
            <!-- {{ Str::limit($product['name'], 26) }} -->
            {{ \App\CPU\Helpers::getItemName('products','name',$product['id']) }}
        </div>
        <div class="pos-product-item_price">
            {{ \App\CPU\BackEndHelper::set_symbol(($product['unit_price']- \App\CPU\Helpers::get_product_discount($product, $product['unit_price'])))  }}
        </div>
    </div>
</div>
