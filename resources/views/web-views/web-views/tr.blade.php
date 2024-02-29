@php($current_lang = session()->get('local'))
@foreach($pro as $k=>$p)
@php($p->unit_price = Helpers::getProductPrice_pl($p->id)['value'] ?? 0)
<tr class="lptr">
    <td class="sm:hidden"></td>
    <td class="td-w-full">
        @if(isset($end) && $end)
            <span class="engh"></span>
        @endif
        <input id="product-{{ $p->id }}" type="checkbox" class="trSelector" onchange="handleRowSelect(this,'{{ $formId }}',{{ $formId == 'bulk-delete-linked' ? 1 : 2 }})">
        <span class="rowId" hidden>{{$p->id}}</span>
    </td>
    <td class="td-w-full" >{{$p->id}}</td>

    <td class=" td-w-full">
        @php($local = session()->get('local'))
        <img class="rounded productImg" width="64"
        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($p->images)->$current_lang)) ? json_decode($p->images)->$current_lang[0] ?? '' : ''}}"
        >
    </td>
    <td class="">
        {{ $p->item_number }}
    </td>
    <td class="">
        {{ $p->code }}
    </td>
    @php($name = $p->name)
    <td class=" td-w-full">
        {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p->id,'name',session()->get('local')) ?? $name }}
    </td>
    <td>
        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p->id)['value'] ?? $p->unit_price))}}
    </td>
    <td class="">
        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p->id)['suggested_price'] ?? $p->suggested_price))}}
    </td>
    <td class="">
        @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
        @php($price = floatval(Helpers::get_linked_price($p->id, $storeId)) == 0
        ? (floatval(Helpers::getProductPrice_pl($p->id)['suggested_price']) !== 0
            ? Helpers::getProductPrice_pl($p->id)['suggested_price']
            : Helpers::getProductPrice_pl($p->id)['value'])
        : Helpers::get_linked_price($p->id, $storeId))
        <input type="text" pattern="\d*" t="number" class="form-control price_in_store text-center sm:text-start" onchange="price_edits['pid-{{$p->id}}']=event.target.value" value="
        {{ $price }}"
        />
        <p class="hidden">
            {{ $price }}
        </p>
    </td>
    <td>
        {{ Helpers::get_linked_date($p->id, $storeId) }}
    </td>
    <td class="td-w-full">
        @if(isset($extra_data['Sync']) && $extra_data['Sync'] === 'SyncDeleteFromList')
        @if($p->status == 1 && $p->publish_on_app == 1 && $p->request_status == 1)
        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.sync'))
        <a class="text-light rounded-0 col-12"
        title="{{\App\CPU\Helpers::translate('re-sync')}}"
        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
        onclick="SyncDeleteFromList(event, {{ $p->id }})">
            <i class="ri-restart-fill text-success" style="font-size: 25px;"></i>
        </a>
        @endif
        @endif
        @endif
        @if ((\App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.delete') && isset($extra_data['Sync'])) || (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.sync.delete') && !isset($extra_data['Sync'])))
        <a class="text-light rounded-0 col-12"
        title="{{\App\CPU\Helpers::translate('Delete from list')}}"
        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
        onclick="deleteFromLinked(event,{{$p->id}})">
            <i class="ri-delete-bin-5-fill text-danger"></i>
        </a>
        @endif
    </td>
</tr>
@endforeach
