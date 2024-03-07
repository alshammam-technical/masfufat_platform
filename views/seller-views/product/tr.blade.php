@foreach($pro as $k=>$p)
<tr>
    <form class="table-editor-form" method="POST" action="{{route('seller.product.change',[$p['id']])}}">
    <td class="td-w-100">
        @csrf
        <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
        <span class="rowId" hidden>{{$p->id}}</span>
    </td>
    <td class="td-w-100" scope="row">
        <a href="{{route('seller.product.edit',['id'=>$p->id])}}">
            {{$p->id}}
        </a>
    </td>

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
            {{\App\CPU\Helpers::translate('selling_price')}}:
        </span>
        <span class="spanValue">
            {{$p['item_number']}}
        </span>
        <input class="form-control editValue" type="text"
        value="{{\App\CPU\Convert::default($p->item_number)}}"
        name="item_number">
    </td>
    <td>
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('selling_price')}}:
        </span>
        <span class="spanValue">
            {{$p['code']}}
        </span>
        <input class="form-control editValue" type="text"
        value="{{\App\CPU\Convert::default($p->code)}}"
        name="code">
    </td>
    @php($name = $p['name'])
    @foreach(\App\CPU\Helpers::get_langs() as $lang)
    <td class="td-w-100">
        <span class="colLbl">
            {{\App\CPU\Helpers::translate('Product Name')}}:
        </span>
        <a class="spanValue" style="white-space: initial">
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
            {{\App\CPU\Helpers::translate('purchase_price')}}:
        </span>
        <span class="spanValue">
            {{ $p['purchase_price'] }}
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
    </td>
    <td>
        @if($p->request_status == 0)
            @if(\Carbon\Carbon::parse($p->updated_at) == \Carbon\Carbon::parse($p->created_at))
            <label class="badge badge-soft-warning">{{Helpers::translate('New Products')}}</label>
            @else
            <label class="badge badge-soft-dark">{{Helpers::translate('updated_products')}}</label>
            @endif
        @elseif($p->request_status == 1)
            <label class="badge badge-soft-success">{{Helpers::translate('Approved Products')}}</label>
        @elseif($p->request_status == 2)
            <label class="badge badge-soft-danger">{{Helpers::translate('Denied Products')}}</label>
        @endif
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
    </form>
    <td class="td-w-100">
        <a class="btn btn-primary btn-sm"
            title="{{\App\CPU\Helpers::translate('Edit')}}"
            href="{{route('seller.product.edit',[$p['id']])}}">
            <i class="tio-edit"></i>
        </a>
    </td>
</tr>
@endforeach
