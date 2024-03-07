<table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};margin-top:0px !important"
                               class="products-dataTable table table-striped table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%" dir="{{session()->get('direction')}}">
    <thead class="thead-light">
        <tr>
            <th>{{\App\CPU\Helpers::translate('SL#')}}</th>
            <th>{{\App\CPU\Helpers::translate('image')}}</th>
            @foreach(\App\CPU\Helpers::get_langs() as $lang)
            <th>{{\App\CPU\Helpers::translate('Product Name')}} ({{$lang}})</th>
            @endforeach
            <th>{{\App\CPU\Helpers::translate('purchase_price')}}</th>
            <th>{{\App\CPU\Helpers::translate('selling_price')}}</th>
            <th>{{\App\CPU\Helpers::translate('featured')}}</th>
            <th>{{\App\CPU\Helpers::translate('Active status')}}</th>
            <th>{{\App\CPU\Helpers::translate('Show product')}}</th>
        </tr>
    </thead>
    <tbody style="display: none">
        @foreach($pro as $k=>$p)
        <tr>
            <td class="td-w-100" scope="row">{{$p->id}}</td>

            <td class="td-w-100">
                @php($local = session()->get('local'))
                <img class="rounded productImg" width="64"
                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                src="{{asset("storage/app/public/product/$local")}}/{{(isset(json_decode($p['images'])->$local)) ? json_decode($p['images'])->$local[0] ?? '' : ''}}">
            </td>
            @php($name = $p['name'])
            @foreach(\App\CPU\Helpers::get_langs() as $lang)
            <td class="td-w-100">
                <a class="spanValue" style="white-space: initial">
                    {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p['id'],'name',$lang) ?? $name }}
                </a>
            </td>
            @endforeach
            <td>
                <span class="spanValue">
                    {{\App\CPU\BackEndHelper::set_symbol(($p['purchase_price']))}}
                </span>
            </td>
            <td>
                <span class="spanValue">
                    {{\App\CPU\BackEndHelper::set_symbol(($p['unit_price']))}}
                </span>
            </td>
            <td>
                {{$p->featured}}
            </td>
            <td>
                {{$p->status}}
            </td>
            <td>
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
        </tr>
        @endforeach
    </tbody>
</table>
