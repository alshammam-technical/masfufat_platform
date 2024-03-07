@php($minimum_order_qty = Helpers::getProductPrice_pl($product['id'])['min_qty'] ?? 0)
<div class="text-center quick-view d-block pb-0 rounded-bottom-11 bg-primary">
    <div class="w-100 m-0 p-0 bg-white" style="display: flex;align-items: flex-start;">
        @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "purchase" || (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
        <a class="btn btn-primary btn-sm text-light rounded-0"
        title="{{\App\CPU\Helpers::translate('Add to cart')}}"
        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;width: inherit;margin-{{(session('direction') ?? 'rtl') == 'rtl' ? 'left' : 'right' }}:1px;" href="javascript:"
        onclick="addToCart('add-to-cart-form-{{$product->id}}')">
            <div>
                <p class="py-0 my-0">
                    <i class="fa fa-shopping-cart text-white"></i>
                </p>
                <p class="py-0 mb-0 mt-2">
                    {{ Helpers::translate('add to cart') }}
                </p>
            </div>
        </a>
        @endif

        @if((Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "add" || (Helpers::getProductPrice_pl($product->id)['display_for'] ?? '') == "both")
            <a class="btn btn-primary @if(!\App\CPU\Helpers::productChoosen($product->id)) @else disabled @endif btn-sm btn-add-linked text-light rounded-0"
            @if(!\App\CPU\Helpers::productChoosen($product->id))
                onclick="addToLinked(event,this,{{$product->id}})"
            @endif
            title="{{\App\CPU\Helpers::translate('Add to store')}}"
            style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;width: inherit" href="javascript:">
                <div>
                    <p class="py-0 my-0">
                        <i class="fa fa-store text-white"></i>
                    </p>
                    <p class="py-0 mb-0 mt-2">
                        {{ Helpers::translate('add to store') }}
                    </p>
                </div>
            </a>
        @endif
    </div>
</div>
