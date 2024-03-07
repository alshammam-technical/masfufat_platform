@foreach($orders as $key=>$order)
<tr class="status-{{$order['order_status']}} class-all">
    <td>
        @csrf
        <input id="order-{{$order->id}}" type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
        <span class="rowId" hidden>{{$order->id}}</span>
    </td>
    <td >
        <a class="title-color" href="{{route('admin.orders.details',['id'=>$order['id']])}}">{{$order['id']}}</a>
    </td>
    <td>
        <div>{{date('Y/m/d',strtotime($order['created_at']))}} </div>
        <div dir="ltr">{{ date("h:i A",strtotime($order['created_at'])) }}</div>
    </td>
    <td class="">
        {!! $order->ext_order_id >= 1 ? Helpers::translate('synchronous') : Helpers::translate('direct') . '<br/>' !!}
        @switch($order->ordered_using)
            @case("Windows")
                {{ Helpers::translate('Computer browser') }}
                @break
            @case("PostmanRuntime")
                {{ Helpers::translate('Computer browser') }}
                @break
            @case("Dart")
                {{ Helpers::translate('Mobile application') }}
                @break
            @case("Android")
                {{ Helpers::translate('Mobile browser') }}
                @break
            @case("Mac")
                {{ Helpers::translate('Mobile browser') }}
                @break
            @default

        @endswitch
    </td>

    <td>
        @if($order->customer_id == 0)
            <strong class="title-name">Walking customer</strong>
        @else
            @if($order->customer)
                <a class="text-body text-capitalize" href="{{route('admin.orders.details',['id'=>$order['id']])}}">
                    <strong class="title-name text-wrap">{{$order->customer['name']}}</strong>
                </a>
                <a class="d-block title-color" dir="ltr" href="tel:{{ $order->customer['phone'] }}">{{ $order->customer['phone'] }}</a>
            @else
                <label class="badge badge-danger fz-12">{{\App\CPU\Helpers::translate('invalid_customer_data')}}</label>
            @endif
        @endif
    </td>
    <td>
        <span class="store-name font-weight-medium">
            @if($order->seller_is == 'seller')
                {{ isset($order->seller->shop) ? $order->seller->shop->name : 'Store not found' }}
            @elseif($order->seller_is == 'admin')
                {{\App\CPU\Helpers::translate('In-House')}}
            @elseif($order->seller_is == 'customer')
            {{ isset($order->details[0]->seller) ? $order->details[0]->seller->shop->name : \App\CPU\Helpers::translate('In-House') }}
            @endif
        </span>
    </td>
    <td class="text-right">
        @if($order->external_order)
        <div>{{ $order->external_order['total'].' '.$order->external_order['currency']}}</div>
        @else
        <div>{{\App\CPU\BackEndHelper::set_symbol(($order->order_amount))}}</div>
        @endif

        @if($order->payment_status=='paid')
            <span class="badge text-success fz-12 px-0" style="white-space: initial;line-height: inherit">
                {{\App\CPU\Helpers::translate('paid')}} - {{ Helpers::translate($order->payment_method) }}
            </span>
        @else
            <span class="badge text-danger fz-12 px-0">
                {{\App\CPU\Helpers::translate('unpaid')}}
            </span>
        @endif
    </td>
    <td style="white-space: inherit;">
        @isset($order->shipping_info['shipment_data'])
        @php($shipping_info = $order->shipping_info['shipment_data'])
        <p>
            {{ Helpers::translate("Bettween Company") }} - {{ Helpers::translate(Helpers::get_between_status($order['id'])) }}
        </p>
        <div class="row">
            <div class="col-9 px-1">
                <a href="{{ $shipping_info['shipping_tracking_url'] ?? null }}" target="_blank">
                    {{ $shipping_info['awb_no'] ?? null }}
                </a>
            </div>

            <div class="col-3 text-center p-0 generate_bill_of_lading">
                <form action="https://api.fastcoo-tech.com/API/Print/{{$shipping_info['awb_no']}}" method="get" target="_blank">
                    <button style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('bill of lading')}}">
                        <i class="tio-print"></i>
                    </button>
                </form>
            </div>
        </div>
        @else
        @php($shipping_info = $order->shipping_info)
        @isset($shipping_info['order']['status'])
        <p>
            {{ Helpers::translate($shipping_info['order']['courier']) }} - {{ Helpers::translate($shipping_info['order']['status']) }}
        </p>
        <div class="row">
            <div class="col-9 px-1">
                {{ $shipping_info['order']['courierRefCode'] }}
            </div>

            <div class="col-3 text-center p-0 generate_bill_of_lading">
                <form action="{{ route('admin.orders.printAWB') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="ids" value="{{ $order['id'] }}">
                    <button style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('bill of lading')}}">
                        <i class="tio-print"></i>
                    </button>
                </form>
            </div>
        </div>
        @else
        @php($def_sh = Helpers::get_business_settings('default_shipping_company'))
        @if(Helpers::module_permission_check('order.'.request("status").'.generate_bill_of_lading'))
        <form id="shipping_form_{{$order['id']}}" class="row generate_bill_of_lading" method="post" action="{{route('admin.orders.genAWB')}}">
            <input type="hidden" name="ids" value="{{$order->id}}">
            @csrf
            <select name="courier" class="col-8" required id="courier_{{$order['id']}}">
                <option @if($def_sh == "None") selected @endif disabled></option>
                @foreach (Helpers::get_business_settings('shipping_companies') ?? [] as $sh)
                @if($sh !== "None")
                <option @if($def_sh == $sh) selected @endif value="{{$sh}}">{{ Helpers::translate($sh) }}</option>
                @endif
                @endforeach
            </select>
            <div class="btn btn-primary col-4" onclick="if($('#courier_{{$order['id']}}').val() == 'between'){form_alert('shipping_form_{{$order['id']}}','{{Helpers::translate('order status will be changed to ')}} ({{Helpers::translate('Confirmed')}})')}else{$('#shipping_form_{{$order['id']}}').submit()}">
                <i class="fa fa-check"></i>
            </div>
        </form>
        @endif
        @endisset
        @endisset
    </td>
    <td class="text-center text-capitalize">
        @if($order['order_status']=='pending')
            <span class="badge badge-soft-info fz-12">
                {{Helpers::translate($order['order_status'])}}
            </span>

        @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
            <span class="badge badge-soft-warning fz-12">
                {{Helpers::translate($order['order_status'])}}
            </span>
        @elseif($order['order_status']=='confirmed')
            <span class="badge badge-soft-success fz-12">
                {{Helpers::translate($order['order_status'])}}
            </span>
        @elseif($order['order_status']=='failed')
            <span class="badge badge-danger fz-12">
                {{$order['order_status'] == 'failed' ? Helpers::translate('Failed To Deliver') : ''}}
            </span>
        @elseif($order['order_status']=='delivered')
            <span class="badge badge-soft-success fz-12">
                {{Helpers::translate($order['order_status'])}}
            </span>
        @else
            <span class="badge badge-soft-danger fz-12">
                {{Helpers::translate($order['order_status'])}}
            </span>
        @endif
    </td>
    <td class="actions-col">
        @if(1 == 2)
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="min-height: 45px">
                <span class="caret"></span></button>
            <ul class="dropdown-menu text-start py-2">
                <li>
                    <a class="dropdown-item"
                    href="{{route('admin.orders.details',['id'=>$order['id']])}}">
                        {{\App\CPU\Helpers::translate('view')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                    href="{{route('admin.orders.generate-invoice',[$order['id']])}}">
                        {{\App\CPU\Helpers::translate('print')}}
                    </a>
                </li>
                <li class="generate_bill_of_lading">
                    <a class="dropdown-item"
                    href="{{route('admin.orders.generate-invoice',[$order['id']])}}"
                    style="white-space: initial;"
                    >
                        {{\App\CPU\Helpers::translate('Issuing and printing the shipping and orders bills')}}
                    </a>
                </li>
            </ul>
        </div>
        @endif

        <div class="d-flex justify-content-center gap-2">
            <a style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline--primary square-btn btn-sm mr-1" title="{{\App\CPU\Helpers::translate('view')}}"
                href="{{route('admin.orders.details',['id'=>$order['id']])}}">
                <img src="{{asset('/public/assets/back-end/img/eye.svg')}}" class="svg" alt="">
            </a>
            @if(Helpers::module_permission_check('order.'.$order->order_status.'.generate_invoice'))
            <a style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('invoice')}}"
                href="{{route('admin.orders.generate-invoice',[$order['id']])}}">
                <i class="tio-print"></i>
            </a>
            <a style="min-width:25px;width:25px;min-height:25px;height:25px" class="btn btn-outline-success square-btn btn-sm mr-1" target="_blank" title="{{\App\CPU\Helpers::translate('invoice')}}"
                href="{{route('admin.orders.generate-invoice',[$order['id']])}}">
                <i class="tio-download-to"></i>
            </a>
            @endif
        </div>
    </td>
</tr>
@endforeach
