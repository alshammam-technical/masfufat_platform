@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Currency_Setup'))

@push('css_or_js')

@endpush

@section('content')
@php($currency_model=\App\CPU\Helpers::get_business_settings('currency_model'))
@php($default=\App\CPU\Helpers::get_business_settings('system_default_currency'))
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/system-setting.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Currency_Setup')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inline Menu -->

        <!-- End Inline Menu -->

        <div class="row gy-2">
            @if(Helpers::module_permission_check('currency.add'))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <img width="18" src="{{asset('/public/assets/back-end/img/currency.png')}}" alt="">
                            {{\App\CPU\Helpers::translate('Add New Currency')}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.currency.store')}}" method="post">
                            @csrf
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="name" class="form-control"
                                               id="name" placeholder="{{\App\CPU\Helpers::translate('Enter currency Name')}}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="symbol" class="form-control"
                                               id="symbol" placeholder="{{\App\CPU\Helpers::translate('Enter currency symbol')}}">
                                    </div>
                                </div>

                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="code" class="form-control"
                                               id="code" placeholder="{{\App\CPU\Helpers::translate('Enter currency code')}}">
                                    </div>
                                    @if($currency_model=='multi_currency')
                                        <div class="col-md-6 mb-3">
                                            <input type="number" min="0" max="1000000"
                                                   name="exchange_rate" step="0.00000001"
                                                   class="form-control" id="exchange_rate"
                                                   placeholder="{{\App\CPU\Helpers::translate('Enter currency exchange rate')}}">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" id="add" class="btn btn--primary btn-primary text-capitalize">
                                    <i class="tio-add"></i> {{\App\CPU\Helpers::translate('add')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="tio-settings"></i>
                            {{\App\CPU\Helpers::translate('system_default_currency')}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form class="form-inline_" action="{{route('admin.currency.system-currency-update')}}"
                              method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    @php($default=\App\Model\BusinessSetting::where('type', 'system_default_currency')->first())
                                    <div class="form-group mb-2">
                                        <select class="form-control js-select2-custom"
                                                name="currency_id">
                                            @foreach (App\Model\Currency::where('status', 1)->get() as $key => $currency)
                                                <option
                                                    value="{{ $currency->id }}" {{$default->value == $currency->id?'selected':''}} >
                                                    {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if(Helpers::module_permission_check('currency.edit'))
                                <div class="col-md-12 mt-3">
                                    <div class="d-flex justify-content-end flex-wrap gap-10">
                                        <button type="submit"
                                                class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Save')}}</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex align-items-center gap-10">
                                    {{\App\CPU\Helpers::translate('Currency table')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $currencies->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Search Currency Name or Currency Code')}}"
                                               aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}
">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('currency_name')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('currency_symbol')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('currency_code')}}</th>
                                    @if($currency_model=='multi_currency')
                                        <th>{{\App\CPU\Helpers::translate('exchange_rate')}}
                                            ({{App\Model\Currency::where('id', $default->value)->first()->code}}= ?)
                                        </th>
                                    @endif
                                    <th>{{\App\CPU\Helpers::translate('status')}}</th>
                                    <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($k = 0)
                            @foreach($currencies->sortBy('exchange_rate') as $key =>$data)
                            @php($k++)
                                <tr>
                                    <td>{{$k }}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->symbol}}</td>
                                    <td>{{$data->code}}</td>
                                    @if($currency_model=='multi_currency')
                                        <td>{{$data->exchange_rate}}</td>
                                    @endif
                                    <td>
                                        @if($default['value']!=$data->id)
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher_input status"
                                                        id="{{$data->id}}" <?php if ($data->status == 1) echo "checked" ?>>
                                                <span class="switcher_control"></span>
                                            </label>
                                        @else
                                            <label class="badge badge-info">{{\App\CPU\Helpers::translate('Default')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-10 justify-content-center">
                                            @if($data->code!='USDzzzz')
                                                @if(Helpers::module_permission_check('currency.edit'))
                                                <a  title="{{\App\CPU\Helpers::translate('Edit')}}"
                                                    type="button" class="btn btn-outline--primary btn-sm btn-xs edit"
                                                    href="{{route('admin.currency.edit',[$data->id])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                @endif
                                                @if ($default['value']!=$data->id)
                                                    @if(Helpers::module_permission_check('currency.delete'))
                                                    <a  title="{{\App\CPU\Helpers::translate('Delete')}}"
                                                        type="button" class="btn btn-outline-danger btn-sm btn-xs delete"
                                                        id="{{$data->id}}"
                                                        >
                                                        <i class="tio-delete"></i>
                                                    </a>
                                                    @endif
                                                @else
                                                    @if(Helpers::module_permission_check('currency.delete'))
                                                    <a href="javascript:" title="{{\App\CPU\Helpers::translate('Delete')}}"
                                                        type="button" class="btn btn-outline-danger btn-sm btn-xs"
                                                        onclick="default_currency_delete_alert()"
                                                        >
                                                        <i class="tio-delete"></i>
                                                    </a>
                                                    @endif
                                                @endif
                                            @else
                                                @if(Helpers::module_permission_check('currency.edit'))
                                                <button title="{{\App\CPU\Helpers::translate('Edit')}}"
                                                        class="btn btn-outline--primary btn-sm btn-xs edit" disabled>
                                                    <i class="tio-edit"></i>
                                                </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$currencies->links()}}
                        </div>
                    </div>

                    @if(count($currencies)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                 alt="Image Description">
                            <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level custom scripts -->
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        $('#add').on('click', function () {
            var name = $('#name').val();
            var symbol = $('#symbol').val();
            var code = $('#code').val();
            var exchange_rate = $('#exchange_rate').val();
            if (name == "" || symbol == "" || code == "" || exchange_rate == "") {
                alert('{{\App\CPU\Helpers::translate('All input field is required')}}');
                return false;
            } else {
                return true;
            }
        });
        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.currency.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (response) {
                    if (response.status === 1) {
                        toastr.success(response.message);
                    } else if(response == 0){
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete', function () {
        var id = $(this).attr("id");
        Swal.fire({
            title: '{{\App\CPU\Helpers::translate('Are you sure delete this')}} ?',
            text: "{{\App\CPU\Helpers::translate('You will not be able to revert this')}}!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, delete it')}}!',
            type: 'warning',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('admin.currency.delete')}}",
                    method: 'POST',
                    data: {id: id},
                    success: function (data) {

                        if(data.status ==1){
                            toastr.success('{{\App\CPU\Helpers::translate('Currency removed successfully!')}}');
                            location.reload();
                        }else{
                            toastr.warning('{{\App\CPU\Helpers::translate('This Currency cannot be removed due to payment gateway dependency!')}}');
                            location.reload();
                        }
                    }
                });
            }
        })
    });
    </script>
    <script>
        function default_currency_delete_alert()
        {
            toastr.warning('{{\App\CPU\Helpers::translate('default currency can not be deleted!to delete change the default currency first!')}}');
        }
    </script>
@endpush