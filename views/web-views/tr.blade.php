@php($current_lang = session()->get('local'))
@foreach($pro as $k=>$p)
@php($p['unit_price'] = Helpers::getProductPrice_pl($p->id)['value'])
<tr class="lptr">
    <td class="td-w-100">
        <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
        <span class="rowId" hidden>{{$p->id}}</span>
    </td>
    <td class="td-w-100" scope="row">{{$p->id}}</td>

    <td class="td-w-100">
        @php($local = session()->get('local'))
        <img class="rounded productImg" width="64"
        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
        src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($p['images'])->$current_lang)) ? json_decode($p['images'])->$current_lang[0] ?? '' : ''}}"
        >
    </td>
    <td>
        {{ $p['item_number'] }}
    </td>
    <td>
        {{ $p['code'] }}
    </td>
    @php($name = $p['name'])
    <td class="td-w-100">
        {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p['id'],'name',session()->get('local')) ?? $name }}
    </td>
    <td>
        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p['id'])['value'] ?? $p['unit_price']))}}
    </td>
    <td>
        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p['id'])['suggested_price'] ?? $p['suggested_price']))}}
    </td>
    <td>
        <input type="number" class="form-control price_in_store text-start" onchange="price_edits['pid-{{$p['id']}}']=event.target.value"
        value="{{ (intval(Helpers::getProductPrice_pl($p['id'])['suggested_price']) !== 0) ? Helpers::getProductPrice_pl($p['id'])['suggested_price'] : Helpers::getProductPrice_pl($p['id'])['value'] }}" />
    </td>
    <td class="td-w-100">
        @if(isset($extra_data['Sync']) && $extra_data['Sync'] === 'SyncDeleteFromList')
        @if($p['status'] == 1 && $p['publish_on_app'] == 1)
        <a class="text-light rounded-0 col-12"
        title="{{\App\CPU\Helpers::translate('re-sync')}}"
        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
        onclick="SyncDeleteFromList(event, {{ $p->id }})">
            <i class="ri-restart-fill text-success" style="font-size: 25px;"></i>
        </a>
        @endif
        @endif
        <a class="text-light rounded-0 col-12"
        title="{{\App\CPU\Helpers::translate('Delete from list')}}"
        style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
        onclick="{{$delete_function}}(event,{{$p->id}})">
            <i class="ri-delete-bin-5-fill text-danger"></i>
        </a>
    </td>
</tr>
@endforeach
