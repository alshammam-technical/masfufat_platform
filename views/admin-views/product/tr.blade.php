@foreach($pro as $k=>$p)
<tr>
    <td class="td-w-100">
        <form class="table-editor-form" method="POST" action="{{route('admin.product.change',[$p['id']])}}">
            @csrf
        <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
        <span class="rowId" hidden>{{$p->id}}</span>
    </td>
    <td class="td-w-100" scope="row">
        <a href="{{route('admin.product.edit',[$p['id']])}}">
            {{$p->id}}
        </a>
    </td>
    @if($type == "seller")
    <td class="td-w-100" scope="row">
        @php($sid = $p->seller['id'] ?? '0')
        <a href="{{route('admin.sellers.view',['id'=>$sid])}}">
            {{$p->seller->shop->name ?? ''}}
        </a>
    </td>
    @endif

    <td class="td-w-100">
        @php($local = session()->get('local'))
        <img class="rounded productImg" width="64"
        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
        src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($p['images'])->$local)) ? json_decode($p['images'])->$local[0] ?? '' : ''}}">

        <div class="custom-file editValue w-100" style="text-align: left">
            <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
            <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('choose file')}}</label>
        </div>
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Item Number')}}:
        </span>
        <span class="spanValue">
            {{$p['item_number']}}
        </span>
        <input class="form-control editValue" type="number" inputmode="numeric"
        value="{{ $p->item_number }}"
        name="item_number">
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('product_code_sku')}}:
        </span>
        <span class="spanValue">
            {{$p['code']}}
        </span>
        <input class="form-control editValue" type="number" inputmode="numeric"
        value="{{ $p->code }}"
        name="code">
    </td>
    @php($name = $p['name'])
    @foreach(\App\CPU\Helpers::get_langs() as $lang)
    <td class="td-w-100">
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Product Name')}}:
        </span>
        <a class="spanValue" style="white-space: initial" href="{{route('admin.product.edit',[$p['id']])}}">
            {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p['id'],'name',$lang) ?? $name }}
        </a>
        <input class="form-control editValue lang_value" type="text"
        value="{{ \App\CPU\Helpers::get_prop('App\Model\Product',$p['id'],'name',$lang) ?? $name }}"
        name="name[]"
        onchange="translateName(event,'tr','input[name=\'name[]\']')"
        >
        <a role="button" class="btn btn-primary editValue" onclick="emptyInput(event,'tr','.lang_value')">{{ Helpers::translate('Field dump') }}</a>
        <input type="hidden" value="{{$lang}}" name="lang[]">
    </td>
    @endforeach
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('current_stock')}}:
        </span>
        <span class="spanValue">
            {{$p['current_stock']}}
        </span>
        <input class="form-control editValue" type="number" inputmode="numeric"
        value="{{ $p->current_stock }}"
        name="current_stock">
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('purchase_price')}}:
        </span>
        <span class="spanValue">
            {{\App\CPU\BackEndHelper::set_symbol(($p['purchase_price']))}}
        </span>
        <input class="form-control editValue" type="text"
        value="{{ \App\CPU\Convert::default($p->purchase_price) }}"
        name="purchase_price">
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('selling_price')}}:
        </span>
        <span class="spanValue">
            {{\App\CPU\BackEndHelper::set_symbol(($p['unit_price']))}}
        </span>
        <input class="form-control editValue" type="text"
        value="{{\App\CPU\Convert::default($p->unit_price)}}"
        name="unit_price">
    </form>
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Active featured')}}:
        </span>
        <div style="padding-left: 35%;padding-right: 35%;">
            <label class="switch switch-featured mx-1">
                <input onclick="featured_status('{{$p['id']}}')" type="checkbox" class="switcher_input" {{$p->featured == 1?'checked':''}}>
                <span class="switcher_control"></span>
            </label>
        </div>
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Publish on market')}}:
        </span>
        <div style="padding-left: 35%;padding-right: 35%;">
            <label class="switch switch-status mx-1">
                <input type="checkbox" class="status status-market"
                id="{{$p['id']}}" {{$p->status == 1?'checked':''}}>
                <span class="slider round"></span>
            </label>
            <span hidden>{{$p->status ?? '0'}}</span>
        </div>
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Publish on market date/time')}}:
        </span>
        <span class="spanValue">
            {{$p->publish_on_market_date}} {{$p->publish_on_market_time}}
        </span>
        <input name="publish_on_market_date" class="form-control editValue" placeholder="DD/MM/YYYY" type="date" value="{{$p->publish_on_market_date}}">
        <input name="publish_on_market_time" class="form-control editValue" placeholder="HH:mm" type="time" value="{{$p->publish_on_market_time}}">
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Publish on App')}}:
        </span>
        <div style="padding-left: 35%;padding-right: 35%;">
            <label class="switch switch-App mx-1">
                <input type="checkbox" class="status status-app"
                id="{{$p['id']}}" {{$p->publish_on_app == '1'?'checked':''}}>
                <span class="slider round"></span>
            </label>
            <span hidden>{{$p->publish_on_app ?? '0'}}</span>
        </div>
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Publish on market date/time')}}:
        </span>
        <span class="spanValue">
            {{$p->publish_on_app_date}} {{$p->publish_on_app_time}}
        </span>
        <input name="publish_on_app_date" class="form-control editValue" placeholder="DD/MM/YYYY" type="date" value="{{$p->publish_on_app_date}}">

        <input name="publish_on_app_time" class="form-control border-0 col-13 editValue" placeholder="HH:mm" type="time" value="{{$p->publish_on_app_time}}">
        </div>
    </td>
    <td style="white-space: inherit">
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Active Show product')}}:
        </span>
        @switch($p->display_for ?? null)
            @case('purchase')
            {{\App\CPU\Helpers::translate('to purchase')}}
                @break

            @case('add')
                {{\App\CPU\Helpers::translate('to add')}}
                @break

            @case('both')
                {{\App\CPU\Helpers::translate('Both')}}
                @break
            @default

        @endswitch
    </td>
    @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
    <td>
        @php($sfp = explode(',',$p['show_for_pricing_levels']))
        @foreach ($sfp as $phindex=>$pl)
            {!! !$phindex ? '' : '<br/>' !!} {{ Helpers::get_prop("App\Model\pricing_levels",$pl,"name") }}
        @endforeach
    </td>
    @endif
    @isset($pending)
    <td>
        <div class="d-flex gap-10 align-items-center justify-content-center">
            @if(Helpers::module_permission_check('admin.products.updated-product-list.approve'))
            <button class="btn btn--primary btn-primary btn-sm"
                onclick="update_shipping_status({{$p['id']}},1)">
                {{\App\CPU\Helpers::translate('Approve')}}
            </button>
            @endif
            @if(Helpers::module_permission_check('admin.products.updated-product-list.reject'))
            <button class="btn btn-danger btn-sm"
                onclick="update_shipping_status({{$p['id']}},0)">
                {{\App\CPU\Helpers::translate('deneid')}}
            </button>
            @endif
        </div>
    </td>
    @else
    <td class="td-w-100">
        <a class="btn btn-primary btn-sm"
            title="{{\App\CPU\Helpers::translate('Edit')}}"
            href="{{route('admin.product.edit',[$p['id']])}}">
            <i class="tio-edit"></i>
        </a>
    </td>
    @endisset
</tr>
@endforeach
