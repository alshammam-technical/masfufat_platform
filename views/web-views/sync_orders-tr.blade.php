@foreach($orders as $oi => $o)
@foreach(Helpers::get_local_orders_ids_collection($o['id']) as $order)
    <tr>
        <td class="bodytr font-weight-bold">
            {{ $order->id }}
            <a class="btn btn-primary" onclick="copyToClipboard({{$order->id}})">
                <i class="fa fa-copy"></i>
            </a>
        </td>
        <td class="bodytr orderDate"><span class="">{{$order->created_at}}</span></td>
        <td class="bodytr">
            @if($order->order_status=='failed' || $order->order_status=='canceled')
                <span class="badge badge-{{$order->order_status}} text-capitalize">
                    {{\App\CPU\Helpers::translate($order->order_status =='failed' ? 'Failed To Deliver' : $order->order_status)}}
                </span>
                @isset($order['admin_note'])
                <span class="tooltip-info bg-secondary cansl py-2 {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'mr-2' : 'ml-2'}}">
                    <i class="fa fa-info mx-3"></i>
                </span>
                <div class="tooltip-custom relative">
                    <span class="tooltiptext" style="display: none">{{ $order['admin_note'] }}</span>
                </div>
                @endisset
            @elseif($order->order_status=='confirmed' || $order->order_status=='processing' || $order->order_status=='delivered')
                <span class="badge badge-{{$order->order_status}} text-capitalize">
                    {{\App\CPU\Helpers::translate($order->order_status=='processing' ? 'packaging' : $order->order_status)}}
                </span>
            @else
                <span class="badge badge-{{$order->order_status}} text-capitalize">
                    {{\App\CPU\Helpers::translate($order->order_status)}}
                </span>
            @endif
        </td>
        <td class="bodytr hidden sm:table-cell">
            @if((App\Model\Order::where('order_group_id',$order->order_group_id)->first()->id == $order->id) || ($order->shipping_tax))
            {{ \App\CPU\Helpers::currency_converter(Helpers::get_order_totals($order)['total']) }}
            @else
            {{ \App\CPU\Helpers::currency_converter(Helpers::get_order_totals($order)['total_amount'] - ($order->shipping_cost + ($order->shipping_tax * ($order->shipping_cost/100)))) }}
            @endif
        </td>
        <td class="bodytr font-weight-bold">
            @php(Helpers::get_external_order_details($order))
            @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
            @php($user = \App\User::find($storeId))
            @isset(Helpers::get_salla_store_name($user)->domain)
            <div class="w-full justify-content-center">
                @if (\App\CPU\Helpers::store_module_permission_check('order.details.view'))
                <a target="_parent" href="{{ route('orders.show', ['id'=>$order->id]) }}"
                    class="p-2 mt-2 col-auto">
                    <i class="fa fa-eye text-info"></i>
                </a>
                @endif
                @php($ps = $order->payment_status ?? null)
                @php($d = $order->external_order->details ?? null)
                @if(isset($d['data']) && $d['data']['status']['name'] !== "ملغي")
                @if($ps !== "paid" && in_array($order->order_status , ['pending','new']))
                <a role="button" target="_blank" href="{{ route('home') }}/checkout-complete-by-customer/{{ $order->id ?? null  }}" class="btn btn-primary col-auto">
                    {{ Helpers::translate('Payment completion') }}
                </a>
                @endif
                @endif
            </div>
            @endisset
        </td>
    </tr>
@endforeach
@endforeach
