{{--code improved Md. Al imrun Khandakar--}}
<div class="navbar-tool bg-black px-2 py-1 text-light dropdown rounded {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}"
     style="margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;height: 61px;">
    <a class="text-white font-size-xl pt-1" href="{{route('shop-cart')}}">
        <span class="navbar-tool-label">
            @php($cart=\App\CPU\CartManager::get_cart())
            {{$cart->count()}}
        </span>
        <i class="ri-shopping-cart-2-fill font-size-xl text-white"></i>
    </a>
    <a class="navbar-tool-text text-light bg-black {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}" href="{{route('shop-cart')}}">
        {{\App\CPU\Helpers::currency_converter(\App\CPU\CartManager::cart_total_applied_discount(\App\CPU\CartManager::get_cart()))}}
    </a>
    <!-- Cart dropdown-->
    <div class="dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
         style="width: 20rem;margin-top: 0px !important">
        <div class="widget widget-cart px-3 pt-2 pb-3">
            <div class="row">
                <div class="col-2">
                    <center class="text-danger" onclick="$('.dropdown-menu.dropdown-menu-left').hide();setTimeout(function(){$('.dropdown-menu.dropdown-menu-left').attr('style','width: 20rem; margin-top: 0px !important')},500)" role="button">
                        {{ Helpers::translate('Close') }}
                    </center>
                </div>
            </div>
            @if($cart->count() > 0)
                <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">
                    @php($sub_total=0)
                    @php($total_tax=0)
                    @php($current_lang = session()->get('local'))
                    @foreach($cart as  $cartItem)
                    @if($cartItem['slug'])
                        <div class="widget-cart-item pb-2 pt-2 border-bottom border-dark" style="max-height: 90px">
                            <button class="close text-danger " type="button" onclick="removeFromCart({{ $cartItem['id'] }})"
                                    aria-label="Remove" style="margin-top: -1% !important;">
                                <span aria-hidden="true">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </button>
                            <div class="media">
                                <a class="px-3 d-block {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"
                                   href="{{route('product',$cartItem['slug'])}}">
                                    <img width="64"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         @if($cartItem->product && json_decode($cartItem->product['images']))
                                         src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($cartItem->product['images'])->$current_lang)) ? json_decode($cartItem->product['images'])->$current_lang[0] ?? '' : ''}}"
                                         @endif
                                         alt="Product"/>
                                </a>
                                <div class="media-body" style="text-align: initial">
                                    <div class="d-flex">
                                        <span style="white-space: nowrap" class="flex-nowrap text-danger {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">x {{$cartItem['quantity']}}
                                        </span>
                                        <h5 class="widget-product-title">
                                            <a href="{{route('product',$cartItem['slug'])}}">
                                                <strong>{{Str::limit($cartItem['name'],30)}}</strong>
                                            </a>
                                        </h5>
                                    </div>
                                    @foreach(json_decode($cartItem['variations'],true) ?? [] as $key =>$variation)
                                        <span style="font-size: 14px">{{$key}} : {{$variation}}</span><br>
                                    @endforeach
                                    <div class="widget-product-meta">
                                        <span
                                            class="text-accent {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">
                                                {{\App\CPU\Helpers::currency_converter(($cartItem['price']-$cartItem['discount'])*$cartItem['quantity'])}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php($sub_total+=($cartItem['price']-$cartItem['discount'])*$cartItem['quantity'])
                        @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                    @endif
                    @endforeach
                </div>
                <hr>
                <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                    <div
                        class="font-size-sm {{Session::get('direction') === "rtl" ? 'ml-2 float-left' : 'mr-2 float-right'}} py-2 ">
                        <span class="">{{\App\CPU\Helpers::translate('Subtotal')}} :</span>
                        <span
                            class="text-accent font-size-base {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}">
                             {{\App\CPU\Helpers::currency_converter($sub_total)}}
                        </span>
                    </div>

                    <a class="btn btn-outline-secondary btn-sm" href="{{route('shop-cart')}}">
                        {{\App\CPU\Helpers::translate('Expand cart')}}<i
                            class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1' : 'right ml-1 mr-n1'}}"></i>
                    </a>
                </div>
                <a class="btn btn-primary btn-sm btn-block" href="{{route('checkout-details')}}">
                    <i class="czi-card {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} font-size-base align-middle"></i>{{\App\CPU\Helpers::translate('Checkout')}}
                </a>
            @else
                <div class="widget-cart-item">
                    <h6 class="text-danger text-center"><i
                            class="fa fa-cart-arrow-down"></i> {{\App\CPU\Helpers::translate('Cart is empty')}}
                    </h6>
                </div>
            @endif
        </div>
    </div>
</div>
{{--code improved Md. Al imrun Khandakar--}}
{{--to do discount--}}
