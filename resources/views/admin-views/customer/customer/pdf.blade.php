<table
    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
    class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table" dir="{{session()->get('direction')}}">
    <thead class="thead-light">
    <tr>
        <th>{{\App\CPU\Helpers::translate('SL')}}</th>

        @if($end_customer)
        <th>{{\App\CPU\Helpers::translate('photo')}}</th>
        @else
        <th>{{\App\CPU\Helpers::translate('store photo')}}</th>
        @endif

        @if($end_customer)
        <th>{{\App\CPU\Helpers::translate('name')}}</th>
        @else
        <th>{{\App\CPU\Helpers::translate('customer_name')}}</th>
        @endif

        <th>{{\App\CPU\Helpers::translate('email')}}</th>
        <th>{{\App\CPU\Helpers::translate('phone')}}</th>

        <th>{{\App\CPU\Helpers::translate('delegates_name')}}</th>
        <th>{{\App\CPU\Helpers::translate('delegates_phone')}}</th>
        <th>{{\App\CPU\Helpers::translate('commercial_registration_no')}}</th>
        <th>{{\App\CPU\Helpers::translate('tax_number')}}</th>

        <th>{{\App\CPU\Helpers::translate('the account number')}}</th>

        <th>{{\App\CPU\Helpers::translate('Total Order')}} </th>
        <th>{{\App\CPU\Helpers::translate('block')}} / {{\App\CPU\Helpers::translate('unblock')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($customers as $key=>$customer)
        <tr>
            <td>
                {{$key + 1}}
            </td>
            <td>
                <img
                    width="64"
                    src="{{asset('storage/app/public/user')}}/{{$customer->store_informations['image'] ?? ''}}"
                    onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                    class="rounded-circle"
                />
            </td>
            <td>
                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                    class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                    {{\Illuminate\Support\Str::limit(($customer->store_informations['company_name'] ?? ''),20)}}
                </a>
            </td>
            <td>
                <a class="title-color hover-c1" href="mailto:{{$customer->email}}">{{$customer->email}}</a></strong>
            </td>
            <td>
                <a class="title-color hover-c1" href="tel:{{$customer->phone}}">{{$customer->phone}}</a>
            </td>

            <td>
                {{\Illuminate\Support\Str::limit(($customer->store_informations['delegate_name'] ?? ''),20)}}
            </td>
            <td>
                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                    class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                    {{\Illuminate\Support\Str::limit(($customer->store_informations['delegate_phone'] ?? ''),20)}}
                </a>
            </td>
            <td>
                {{\Illuminate\Support\Str::limit(($customer->store_informations['commercial_registration_no'] ?? ''),20)}}
            </td>
            <td>
                {{\Illuminate\Support\Str::limit(($customer->store_informations['tax_no'] ?? ''),20)}}
            </td>
            <td>
                {{\Illuminate\Support\Str::limit(($customer->store_informations['vendor_account_number'] ?? ''),20)}}
            </td>


            <td>
                <label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12">
                    {{$customer->orders->count()}}
                </label>
            </td>

            <td>
                {{$customer->is_active}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
