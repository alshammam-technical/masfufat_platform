<div class="modal-header p-2">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@php
$current_lang = session()->get('local');
@endphp
<div class="modal-body">
    <div class="media gap-3">
        <!-- Product gallery-->
        <div class="d-flex align-items-center justify-content-center active">
            <img class="img-responsive rounded"
                src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($product['images'])->$current_lang)) ? json_decode($product['images'])->$current_lang[0] ?? '' : ''}}"
                 onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                 data-zoom="{{asset('storage/app/public/product')}}/{{$product['image']}}"
                 alt="Product image" height="100">
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="details media-body">
            <h4 class="mb-3 product-title">{{ \App\CPU\Helpers::getItemName('products','name',$product['id']) }}</h4>

            <div class="mb-2 text-dark">
                <h4 class="c1 font-weight-normal text-accent">
                    {{\App\CPU\Helpers::get_price_range($product,true) }}
                </h4>
            </div>

            @if($product->discount > 0)
                <div class="mb-3 text-dark">
                    <strong>{{\App\CPU\Helpers::translate('Discount')}} : </strong>
                    <strong id="set-discount-amount"></strong>
                </div>
            @endif


        </div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            @php
            $cart = false;
            if (session()->has('cart')) {
                foreach (session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $product['id']) {
                        $cart = $cartItem;
                    }
                }
            }
            $max_order_qty = Helpers::getProductPrice_pl($product['id'])['max_qty'] ?? 1;
            $max_order_qty = intval($max_order_qty) == 0 ? 1 : $max_order_qty;
            $minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 1;
            $minimum_order_qty = intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty;
            @endphp
            <h3 class="mb-3">{{\App\CPU\Helpers::translate('Brief description')}}</h3>
            <span class="d-block text-dark">
                {{ \App\CPU\Helpers::get_prop('App\Model\Product',$product['id'],'short_desc',session()->get('local')) ?? '' }}
            </span>

            <h3 class="mb-3">{{\App\CPU\Helpers::translate('Promo title')}}</h3>
            <span class="d-block text-dark">
                {{ \App\CPU\Helpers::get_prop('App\Model\Product',$product['id'],'promo_title',session()->get('local')) ?? '' }}
            </span>

            <h3 class="mb-3">{{\App\CPU\Helpers::translate('description')}}</h3>
            <span class="d-block text-dark">
                {!! \App\CPU\Helpers::get_prop('App\Model\Product',$product['id'],'description',session()->get('local')) ?? '' !!}
            </span>
            <form id="add-to-cart-form">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="{{ $minimum_order_qty ?? 1 }}"
                min="{{ intval($minimum_order_qty) == 0 ? 1 : $minimum_order_qty }}"
                max="{{intval($max_order_qty) == 0 ? 1 : $max_order_qty}}" />
                <input type="hidden" name="product_name" value="{{ \App\CPU\Helpers::getItemName('products','name',$product['id']) }}"/>
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
                                            data-toggle="tooltip"></label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @php
                        $qty = 0;
                        if(!empty($product->variation)){
                        foreach (json_decode($product->variation) as $key => $variation) {
                                $qty += $variation->qty;
                            }
                        }
                    @endphp
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

                <!-- Quantity + Add to cart -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h3 class="product-description-label mb-0">{{\App\CPU\Helpers::translate('Quantity')}}:</h3>
                    <div class="product-quantity d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="product-quantity-group">
                                <button type="button" class="btn-number"
                                        data-type="minus" data-field="quantity"
                                        disabled="disabled">
                                        <i class="tio-remove"></i>
                                </button>
                                <input type="text" name="quantity" value="{{ $minimum_order_qty ?? 1 }}"
                                       class="form-control input-number text-center cart-qty-field"
                                       placeholder="1" value="1" min="1" max="100">
                                <button type="button" class="btn-number" data-type="plus"
                                        data-field="quantity">
                                        <i class="tio-add"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-3 title-color" id="chosen_price_div">
                    <div class="product-description-label">{{\App\CPU\Helpers::translate('Total Price')}}:</div>
                    <div class="product-price">
                        <strong id="chosen_price"></strong>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn--primary btn-primary px-4" onclick="addToCart()" type="button">
                        <i class="tio-shopping-cart"></i>
                        {{\App\CPU\Helpers::translate('add')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function () {
        getVariantPrice();
    });
</script>
<script>
    $(document).on('ready', function () {
        console.log($product->id)
    });
</script>
<script>
    function color_change(val)
    {
        console.log(val.id);
        $('.color-border').removeClass("border-add");
        $('#label-'+val.id).addClass("border-add");
    }
</script>
