@php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 0)
<div class="text-center quick-view d-block pb-0 rounded-bottom-11 bg-primary product-actions">
    <div class="w-full m-0 p-0 bg-white relative" style="display: flex;align-items: flex-start;">
        @if (Helpers::store_module_permission_check('store.products.add_to_cart'))
        @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "purchase" || (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
        <a

        class="_add-link rounded-b-md rounded-t-none sm:w-full @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "add" || (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both") w-1/2 @else w-full @endif bg-primary text-light"

        @if(Helpers::cart_check($product->id) == 1) disabled @endif
        title=""
        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;margin-{{(session('direction') ?? 'rtl') == 'rtl' ? 'left' : 'right' }}:1px; @if($product->current_stock == 0) background-color: #828282 !important; @elseif(Helpers::cart_check($product->id) == 1) background-color: #8471a6 !important;  @endif" href="javascript:"
        onclick="addToCart(this,'add-to-cart-form-{{$product->id}}')">
            <div>
                <p class="py-0 my-0">
                    <i class="fa fa-shopping-cart text-white"></i>
                </p>
                <p class="py-0 mb-0 mt-2 sm:text-md sm:text-sm text-xs">
                    @if(Helpers::cart_check($product->id) == true)
                    {{ Helpers::translate("Added_to_cart") }}
                    @else
                    {{ Helpers::translate('add to cart') }}
                    @endif
                </p>
            </div>
        </a>
        @endif
        @endif

        @if (Helpers::store_module_permission_check('store.products.syncc'))
        @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "add" || (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
            <a class="rounded-b-md rounded-t-none sm:w-full w-1/2 sm:min-h-full min-h-[72px] @if(Helpers::productChoosen($product->id) == 'linked')  bg-success @else bg-primary @endif @if((Helpers::productChoosen($product->id) == 'pending' || Helpers::productChoosen($product->id) == 'linked') && Helpers::productChoosen($product->id) !== 'no_linked_found') disabled @else  @endif _add-linked text-light"
            @if(Helpers::productChoosen($product->id) == false)
                onclick="addToLinked(event,this,{{$product->id}})"
            @elseif(Helpers::productChoosen($product->id) == 'no_linked_found')
                onclick='Swal.fire({
                    title: "<strong>{{ Helpers::translate('no linked accounts') }}</strong>",
                    icon: "info",
                    html: `
                    {{ Helpers::translate('no linked accounts!') }}
                      <a target="_blank" href="{{ route('linked-accounts') }}">{{ Helpers::translate('click here to link') }}</a>
                    `,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonAriaLabel: "{{ Helpers::translate('ok') }}",
                  });'
            @endif
            title="{{Helpers::translate('Add to store')}}"
            style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px; @if(Helpers::productChoosen($product->id) !== 'no_linked_found') @if(Helpers::productChoosen($product->id) == 'linked') background-color:#198754!important @elseif(Helpers::productChoosen($product->id) == 'pending') background-color: #8471a6 !important;    @elseif($product->current_stock == 0) background-color: #828282 !important; @endif @endif" href="javascript:">
                <div>
                    <p class="py-0 my-0">
                        @if(Helpers::productChoosen($product->id) == 'linked')  <i class="fa fa-check-circle text-white"></i> @else <i class="fa fa-store text-white"></i>@endif
                    </p>
                    <p class="py-0 mb-0 mt-2 sm:text-md sm:text-sm text-xs">
                        @if(Helpers::productChoosen($product->id) == 'linked')  {{ Helpers::translate('synchronous') }} @elseif(Helpers::productChoosen($product->id) == 'pending') {{ Helpers::translate('Added_to_list') }} @else {{ Helpers::translate('add to store') }}@endif
                    </p>
                </div>
            </a>
        @endif
        @endif
    </div>
</div>

<form id="add-to-cart-form-{{$product->id}}" hidden>
    @csrf
    @php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 0)
    <input type="hidden" name="quantity" value="{{ $minimum_order_qty ?? 1 }}">
    <input type="hidden" name="id" value="{{ $product->id }}">
</form>
