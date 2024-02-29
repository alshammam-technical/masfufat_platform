@php($current_lang = session()->get('local'))
@foreach($pro ?? [] as $k=>$product)
@php($p = $product)
@isset($p->id)
    @php($p->unit_price = Helpers::getProductPrice_pl($p->id)['value'])
    <tr class="lptr border-gray-300 border-b-4" id="product_{{ $p->id }}">
        <td class="sm:hidden"></td>
        <td class="td-w-full">
            <input type="checkbox" class="trSelector" onchange="handleRowSelect(this,'{{ $formId }}',0)">
            <span class="rowId" id="product-{{ $p->id }}" hidden>{{$p->id}}</span>
        </td>
        <td class="td-w-full" scope="row">{{$p->id}}</td>

        <td class=" td-w-full">
            @php($local = session()->get('local'))
            <img class="rounded productImg" width="64"
            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
            src="{{asset("storage/app/public/product/$current_lang")}}/{{(isset(json_decode($p->images)->$current_lang)) ? json_decode($p->images)->$current_lang[0] ?? '' : ''}}"
            >
        </td>
        <td class="">
            <p>
                {{ $p->item_number }}
            </p>
            <p>
                {{ $p->code }}
            </p>
        </td>
        @php($name = $p->name)
        <td class="dtr-hidden td-w-full text-center">
            <div class="text-center flex content-center justify-center">
                <p class="max-w-[220px] text-wrap overflow-hidden text-center">
                   {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p->id,'name',session()->get('local')) ?? $name }}
                </p>
            </div>
        </td>
        <td class="sm:w-[125px]">
            @php($cost_price = Helpers::getProductPrice_pl($p->id)['value'] ?? $p->unit_price)
            @php($sugg_price_no_tax = floatval(Helpers::get_linked_price($p->id)) == 0 ? (floatval(Helpers::getProductPrice_pl($p->id)['suggested_price']) !== 0) ? Helpers::getProductPrice_pl($p->id)['suggested_price'] : Helpers::getProductPrice_pl($p->id)['value'] : Helpers::get_linked_price($p->id))
            @php($sugg_price = floatval(Helpers::get_linked_price($p->id)) == 0 ? (floatval(Helpers::getProductPrice_pl($p->id)['suggested_price']) !== 0) ? Helpers::getProductPrice_pl($p->id)['suggested_price'] : Helpers::getProductPrice_pl($p->id)['value'] : Helpers::get_linked_price($p->id))
            @php($profit = $sugg_price - $cost_price)
            @php($profit_ratio = number_format((float)($profit/$cost_price*100), 2, '.', ''))

            @php($custom_tax = null)
            @if(isset(auth('customer')->user()->store_informations['custom_tax']) && (auth('customer')->user()->store_informations['custom_tax'] ?? null) == "true")
            @php($custom_tax = auth('customer')->user()->store_informations['custom_tax_value'] ?? null)
            @php($custom_tax = $sugg_price*($custom_tax/100))
            @php($sugg_price = number_format((float)($sugg_price+$custom_tax), 2, '.', ''))
            @endif

            <p class="mb-0 text-start">
                {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($cost_price)) }}
            </p>
            @if((auth('customer')->user()->store_informations['show_calculations'] ?? null) == "true")
            <div class="text-center ps-0">
                <p class="text-start text-sm mb-0">{{ Helpers::translate('tax') }} : <span class="text-danger text-sm" id="local_tax_{{ $p->id }}">{{ number_format((float)($cost_price * $p->tax / 100), 2, '.', '') }}</span></p>
                <p class="text-start text-sm mb-0">{{ Helpers::translate('total') }} : <span class="text-success text-sm" id="local_total_{{ $p->id }}">{{ number_format((float)($cost_price + ($cost_price * $p->tax / 100)), 2, '.', '') }}</span></p>
            </div>
            @endif
            @if((auth('customer')->user()->store_informations['custom_tax'] ?? null) == "true")
            @php($profit_ = $sugg_price - $custom_tax - $cost_price)
            @else
            @php($profit_ = $sugg_price - ($cost_price + ($cost_price * $p->tax / 100)))
            @php($profit_ = number_format((float)($profit_),2,'.',''))
            @php($profit_ratio = $profit_ / ($cost_price + $cost_price * $p->tax / 100) * 100)
            @php($profit_ratio = number_format((float)($profit_ratio),2,'.',''))
            @endif
        </td>
        <td>
            <div class="text-center inline-block content-center">
                <div class="flex border-1 w-full rounded-md @if($profit_ >= 1 && $profit_ratio >= 1) border-green-600 @else border-red-600 @endif gr p-0">
                    <div class="flex rounded-md border-1 w-[90px] @if($profit_ >= 1) border-green-600 @else border-red-600 @endif gr">
                        <input id="profit_{{ $p->id }}"
                        value="{{ $profit_ }}"
                        onchange="profit_changed('{{ $p->id }}',{{ $cost_price }},event.target.value)"
                        class="border-0 py-1 px-1 w-[55px]" />
                        <span class="pt-1">
                            {{ \App\CPU\BackEndHelper::currency_symbol() }}
                        </span>
                    </div>
                    <div class="flex rounded-md border-1 w-[95px] @if($profit_ratio >= 1) border-green-600 @else border-red-600 @endif gr ms-1 pe-1">
                        <input id="profit_ratio_{{ $p->id }}"
                        value="{{ $profit_ratio }}"
                        onchange="ratio_changed('{{ $p->id }}',{{ $cost_price }},event.target.value)"
                        class="border-0 py-1 px-2 w-[80px]" />
                        <span class="pt-1">
                            %
                        </span>
                    </div>
                </div>
            </div>
        </td>
        <td class="">
            {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(Helpers::getProductPrice_pl($p->id)['suggested_price'] ?? $p->suggested_price))}}
        </td>
        <td class="">
            <div class="inline-block content-center">
                <div class="p-1 border w-min flex">
                    <input id="ownprice_{{ $p->id }}" type="text" pattern="\d*" t="number" lang="en" class="price_in_store text-center sm:text-start w-[70px]"
                    onchange="price_edits['pid-{{$p->id}}']=event.target.value;own_price_changed('{{ $p->id }}',{{ $cost_price }}, event.target.value)"
                    value="{{ $sugg_price_no_tax }}" />
                    {{ \App\CPU\BackEndHelper::currency_symbol() }}
                </div>
                @if(isset(auth('customer')->user()->store_informations['custom_tax']) && (auth('customer')->user()->store_informations['custom_tax'] ?? null) == "true")
                <div class="text-center ps-0">
                    <p class="text-start text-sm mb-0">{{ Helpers::translate('tax') }} : <span class="text-danger text-sm" id="tax_{{ $p->id }}">{{ number_format((float)($custom_tax ?? 0), 2, '.', '') }}</span></p>
                    <p class="text-start text-sm mb-0">{{ Helpers::translate('total') }} : <span class="text-success text-sm" id="total_{{ $p->id }}">{{ number_format((float)($sugg_price ?? 0), 2, '.', '') }}</span></p>
                </div>
                @endif
                <p class="hidden">
                    {{ $sugg_price }}
                </p>
            </div>
        </td>
        <td class="td-w-full">
            <div class="row">
                @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.delete'))
                    <a class="text-light rounded-0 col-6 flex justify-center"
                    title="{{\App\CPU\Helpers::translate('Delete from list')}}"
                    style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
                    onclick="deleteFromList(event,{{$p->id}})">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M28.0932 6.97268C25.9466 6.75935 23.7999 6.59935 21.6399 6.47935V6.46602L21.3465 4.73268C21.1465 3.50602 20.8532 1.66602 17.7332 1.66602H14.2399C11.1332 1.66602 10.8399 3.42602 10.6266 4.71935L10.3466 6.42602C9.10655 6.50602 7.86655 6.58602 6.62655 6.70602L3.90655 6.97268C3.34655 7.02602 2.94655 7.51935 2.99988 8.06602C3.05322 8.61268 3.53322 9.01268 4.09322 8.95935L6.81322 8.69268C13.7999 7.99935 20.8399 8.26602 27.9066 8.97268C27.9466 8.97268 27.9732 8.97268 28.0132 8.97268C28.5199 8.97268 28.9599 8.58602 29.0132 8.06602C29.0532 7.51935 28.6532 7.02602 28.0932 6.97268Z" fill="#FF000F"></path>
                            <path d="M25.6403 10.854C25.3203 10.5207 24.8803 10.334 24.427 10.334H7.57365C7.12032 10.334 6.66698 10.5207 6.36032 10.854C6.05365 11.1873 5.88032 11.6407 5.90698 12.1073L6.73365 25.7873C6.88032 27.814 7.06698 30.3473 11.7203 30.3473H20.2803C24.9337 30.3473 25.1203 27.8273 25.267 25.7873L26.0937 12.1207C26.1203 11.6407 25.947 11.1873 25.6403 10.854ZM18.2136 23.6673H13.7737C13.227 23.6673 12.7737 23.214 12.7737 22.6673C12.7737 22.1207 13.227 21.6673 13.7737 21.6673H18.2136C18.7603 21.6673 19.2136 22.1207 19.2136 22.6673C19.2136 23.214 18.7603 23.6673 18.2136 23.6673ZM19.3337 18.334H12.667C12.1203 18.334 11.667 17.8807 11.667 17.334C11.667 16.7873 12.1203 16.334 12.667 16.334H19.3337C19.8803 16.334 20.3337 16.7873 20.3337 17.334C20.3337 17.8807 19.8803 18.334 19.3337 18.334Z" fill="#FF000F"></path>
                        </svg>
                    </a>
                @endif

                <a class="text-light rounded-0 col-6" title="{{ Helpers::translate('Sync now') }}" style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:" onclick="$('.ids').val('{{$p->id}}');syncNow(0)">
                    <i class="ri-restart-fill text-success" style="font-size: 25px;"></i>
                </a>
            </div>
        </td>
    </tr>
@endisset
@endforeach
