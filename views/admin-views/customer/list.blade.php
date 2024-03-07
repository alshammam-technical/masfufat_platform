@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Customer List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="row">
            <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                @if($end_customer)
                                {{\App\CPU\Helpers::translate('End customer list')}}
                                @else
                                {{\App\CPU\Helpers::translate('Customer_list')}}
                                @endif
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->
            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2 @if($end_customer) disabled @endif"
                    @if($end_customer)
                    disabled
                    @else
                    href="{{route('admin.stores.add-new')}}"
                    @endif
                    >
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" disabled>
                        <i class="fa fa-clone"></i>
                    </button>

                    <button title="{{Helpers::translate('Save')}}" class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
                    onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 edit-btn"
                    @if($end_customer)
                    disabled
                    @else
                    onclick="$('.table').addClass('editMode');$('.save-btn').show();$(this).hide()"
                    @endif
                    >
                        <i class="fa fa-pencil"></i>
                    </button>

                    <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"

                    onclick="form_alert('bulk-delete','Want to delete this item ?')"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <button title="{{Helpers::translate('show/hide columns')}}" class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                        <i class="fa fa-toggle"></i>
                    </button>
                    </div>
                    <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                        <div class="dropdown dropdown">
                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
                                <i class="ti-bag"></i>
                            </button>
                            <div aria-labelledby="droprightMenuButton" class="dropdown-menu">
                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-enable','Are you sure ?')"
                                >
                                    <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                                </a>

                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-disable','Are you sure ?')"
                                >
                                    <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                                </a>
                                <a class="dropdown-item" href="#" onclick="stateClear()">
                                    <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                                </a>
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                onclick='$(".dt-button-collection").remove();'>
                                    <i class="ti-angle-down"></i>
                                    {{\App\CPU\Helpers::translate('Import/Export')}}
                                </a>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                    <a class="dropdown-item bulk-export" href="{{route('admin.customer.export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-export" href="{{route('admin.stores.pdf')}}">
                                        {{\App\CPU\Helpers::translate('export to pdf')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.stores.bulk-import')}}">
                                        {{\App\CPU\Helpers::translate('import from excel')}}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div>
                    <label class="input-group mt-2" style="height: 34px">
                        <input
                        type="search"
                        class="form-control form-control-sm"
                        placeholder="..."
                        style="border-radius:0px 6px 6px 0px !important;height: 43px"
                        onkeyup="globalSearch(event.target.value)"
                        >
                        <button class="btn search-btn btn-primary" onclick="productsDTsearch()" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                        <i class="fa fa-search"></i>
                        </button>
                    </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card">
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                    class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>{{\App\CPU\Helpers::translate('SL')}}</th>

                        @if($end_customer)
                        @else
                        <th>{{\App\CPU\Helpers::translate('store photo')}}</th>
                        @endif

                        @if(!$end_customer)
                        <th>{{\App\CPU\Helpers::translate('the account number')}}</th>
                        @endif

                        @if($end_customer)
                        <th>{{\App\CPU\Helpers::translate('name')}}</th>
                        @else
                        <th>{{\App\CPU\Helpers::translate('customer_name')}}</th>
                        @endif

                        <th>{{\App\CPU\Helpers::translate('email')}}</th>
                        @if($end_customer)
                        <th>{{\App\CPU\Helpers::translate('mobile number')}}</th>
                        @endif

                        @if(!$end_customer)
                        <th>{{\App\CPU\Helpers::translate('subscription status')}}</th>
                        <th>{{\App\CPU\Helpers::translate('package')}}</th>
                        <th>{{\App\CPU\Helpers::translate('license_owners_name')}}</th>
                        <th>{{\App\CPU\Helpers::translate('License owner mobile number')}}</th>
                        <th>{{\App\CPU\Helpers::translate('delegates_name')}}</th>
                        <th>{{\App\CPU\Helpers::translate('delegates_phone')}}</th>
                        <th>{{\App\CPU\Helpers::translate('commercial_registration_no')}}</th>
                        <th>{{\App\CPU\Helpers::translate('tax_number')}}</th>
                        @endif

                        <th>{{\App\CPU\Helpers::translate('Total Orders')}} </th>

                        @if(!$end_customer)
                        <th>{{\App\CPU\Helpers::translate('status')}}</th>
                        @endif
                        <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                    </tr>
                    </thead>

                    <thead class="theadF">
                    <tr>
                        <th scope="">
                            <input type="checkbox" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                        </th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="" scope="col"></th>

                        @if(!$end_customer)
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        @endif


                        @if(!$end_customer)
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        @endif

                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($customers as $key=>$customer)
                        <tr>
                            <td>
                                <form class="table-editor-form" method="POST"
                                action="{{route('admin.customer.update',['id'=>$customer['id'],'bool_r'=>1])}}"
                                enctype="multipart/form-data"
                                >
                                @csrf
                                <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                <span class="rowId" hidden>{{$customer->id}}</span>
                            </td>
                            <td>
                                {{$key + 1}}
                            </td>

                            @if($end_customer)
                            @else
                            <td>
                                <img
                                    width="64"
                                    src="{{asset('storage/app/public/user')}}/{{$customer->store_informations['image'] ?? ''}}"
                                    onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                    class="rounded-circle"
                                />

                                <div class="custom-file editValue w-100" style="text-align: left">
                                    <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                </div>
                            </td>
                            @endif

                            @if(!$end_customer)
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['vendor_account_number'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->store_informations['vendor_account_number'] ?? ''}}"
                                name="vendor_account_number">
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['company_name'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->store_informations['company_name'] ?? ''}}"
                                name="company_name">
                            </td>
                            @else
                            <td>
                                {{$customer->name}}
                            </td>
                            @endif
                            <td>
                                <div class="mb-1">
                                   <span class="spanValue">
                                       <strong><a class="title-color hover-c1" href="mailto:{{$customer->email}}">{{$customer->email}}</a></strong>
                                    </span>
                                    <input class="form-control editValue" type="text"
                                    value="{{$customer->email}}"
                                    name="email">
                                </div>
                            </td>
                            @if($end_customer)
                            <td>
                                <span class="spanValue">
                                    <a class="title-color hover-c1" href="tel:{{$customer->phone}}">{{$customer->phone}}</a>
                                </span>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->phone}}"
                                name="phone" />
                            </td>
                            @endif
                            @if(!$end_customer)
                            <td>
                                {!! Helpers::customer_exp_days($customer->id) !!} {{ Helpers::customer_exp_days($customer->id) == '-' ? '' : Helpers::translate('day/days remaining') }}
                            </td>

                            <td>
                                <span class="spanValue">
                                    <a target="_blank" class="title-color hover-c1" href="{{ route('admin.package.update',[$customer->subscription]) }}">
                                        {{ Helpers::getItemName("packages","",$customer['subscription']) ?? Helpers::translate('There are no activated packages') }}
                                    </a>
                                </span>
                            </td>
                            @endif

                            @if(!$end_customer)
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['name'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->store_informations['name'] ?? ''}}"
                                name="name">
                            </td>
                            <td>
                                <span class="spanValue">
                                    <a class="title-color hover-c1" href="tel:{{$customer->phone}}">{{$customer->phone}}</a>
                                </span>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->phone}}"
                                name="phone" />
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['delegate_name'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->store_informations['delegate_name'] ?? ''}}"
                                name="delegate_name">
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['delegate_phone'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="text"
                                value="{{$customer->store_informations['delegate_phone'] ?? ''}}"
                                name="delegate_phone">
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['commercial_registration_no'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="number"
                                value="{{$customer->store_informations['commercial_registration_no'] ?? ''}}"
                                name="commercial_registration_no">
                            </td>
                            <td>
                                <a href="{{route('admin.customer.view',[$customer['id']])}}"
                                   class="title-color hover-c1 d-flex align-items-center gap-10 spanValue">
                                    {{\Illuminate\Support\Str::limit(($customer->store_informations['tax_no'] ?? ''),20)}}
                                </a>
                                <input class="form-control editValue" type="number"
                                value="{{$customer->store_informations['tax_no'] ?? ''}}"
                                name="tax_no">
                            </td>

                            @endif


                            <td>
                                <label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12">
                                    {{$customer->orders->count()}}
                                </label>
                            </td>

                            @if(!$end_customer)
                            <td>
                                <center>
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher_input"
                                        id="{{$customer['id']}}" {{$customer->is_active == 1?'checked':''}}>
                                        <span class="switcher_control"></span>
                                    </label>
                                </center>
                            </td>
                            @endif

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a title="{{\App\CPU\Helpers::translate('View')}}"
                                       class="btn btn-outline-info btn-sm square-btn"
                                       href="{{route('admin.customer.view',[$customer['id']])}}">
                                        <i class="tio-invisible"></i>
                                    </a>
                                </div>
                            </td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <form hidden action="{{route('admin.stores.bulk-delete')}}" method="post" id="bulk-delete">
                @csrf @method('delete')
                <input type="text" name="ids" class="ids">
                <input type="text" name="not_ids" class="not_ids">
            </form>

            <!-- End Table -->



            @if(count($customers)==0)
                <div class="text-center p-4">
                    <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                         alt="Image Description">
                    <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                </div>
        @endif
        <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('change', '.switcher_input', function () {
            let id = $(this).attr("id");

            let status = 0;
            if (jQuery(this).prop("checked") === true) {
                status = 1;
            }

            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
                text: '{{\App\CPU\Helpers::translate('want_to_change_status')}}',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.customer.status-update')}}",
                        method: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function (data) {
                            if(data == 1){
                                toastr.success('{{\App\CPU\Helpers::translate('notification deleted successfully')}}');
                            }else if(data == 0){
                                toastr.error("{{ Helpers::translate('Access Denied !') }}")
                            }
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
