<table
    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
    class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table" dir="{{session()->get('direction')}}">
    <thead class="thead-light">
    <tr>
        <th></th>
        <th>{{\App\CPU\Helpers::translate('SL')}}</th>
        <th>{{\App\CPU\Helpers::translate('vendor_account_number')}}</th>
        <th>{{\App\CPU\Helpers::translate('company_logo')}}</th>
        <th>{{\App\CPU\Helpers::translate('company_name')}}</th>
        <th>{{\App\CPU\Helpers::translate('license_owners_name')}}</th>
        <th>{{\App\CPU\Helpers::translate('delegates_name')}}</th>
        <th>{{\App\CPU\Helpers::translate('email')}}</th>
        <th>{{\App\CPU\Helpers::translate('license owners phone')}}</th>
        <th>{{\App\CPU\Helpers::translate('delegates_phone')}}</th>
        <th>{{\App\CPU\Helpers::translate('seller_commercial_registration_no')}}</th>
        <th>{{\App\CPU\Helpers::translate('seller tax number')}}</th>
        <th>{{\App\CPU\Helpers::translate('bank_name')}}</th>
        <th>{{\App\CPU\Helpers::translate('holder_name')}}</th>
        <th>{{\App\CPU\Helpers::translate('account_no')}}</th>
        <th>{{\App\CPU\Helpers::translate('status')}}</th>
        <th class="text-center">{{\App\CPU\Helpers::translate('total_products')}}</th>
        <th class="text-center">{{\App\CPU\Helpers::translate('total_orders')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sellers as $key=>$seller)
        <tr>
            <td>
                {{$seller->id}}
            </td>
            <td>{{$sellers->firstItem()+$key}}</td>
            <td>
                {{$seller->vendor_account_number}}
            </td>

            <td>
                <center>
                    <img width="50"
                    onerror="this.src='{{asset('public/assets/back-end/img/400x400/img2.jpg')}}'"
                    src="{{asset('storage/app/public/shop')}}/{{$seller->shop->image ?? null}}"
                    alt="">
                </center>
            </td>

            <td>
                {{$seller->shop->name}}
            </td>

            <td>
                {{$seller->name}}
            </td>
            <td>
                {{$seller->delegate_name}}
            </td>

            <td>
                {{$seller->email}}
            </td>
            <td>
                <a class="title-color hover-c1" href="tel:{{$seller->phone}}">{{$seller->phone}}</a>
            </td>
            <td>
                <a class="title-color hover-c1" href="tel:{{$seller->delegate_phone}}">{{$seller->delegate_phone}}</a>
            </td>
            <td>
                {{$seller->commercial_registration_no}}
            </td>
            <td>
                {{$seller->tax_no}}
            </td>
            <td>
                {{$seller->bank_name}}
            </td>
            <td>
                {{$seller->holder_name}}
            </td>
            <td>
                {{$seller->account_no}}
            </td>
            <td>
                {{$seller->status}}
            </td>
            <td class="text-center">
                <a href="{{route('admin.sellers.product-list',[$seller['id']])}}"
                    class="btn text--primary bg-soft--primary font-weight-bold px-3 py-1 mb-0 fz-12">
                    {{$seller->product->count()}}
                </a>
            </td>
            <td class="text-center">
                <a href="{{route('admin.sellers.order-list',[$seller['id']])}}"
                    class="btn text-info bg-soft-info font-weight-bold px-3 py-1 fz-12 mb-0">
                    {{$seller->orders->where('seller_is','seller')->where('order_type','default_type')->count()}}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
