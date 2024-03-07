@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Seller List'))

@push('css_or_js')

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
                                {{Helpers::translate('seller_list')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.sellers.seller-add')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2 disabled" disabled>
                        <i class="fa fa-clone"></i>
                    </button>

                    <button title="{{Helpers::translate('Save')}}" class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
                    onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 edit-btn"
                    onclick="$('.table').addClass('editMode');$('.save-btn').show();$(this).hide()">
                        <i class="fa fa-pencil"></i>
                    </button>

                    <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
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
                                    <a class="dropdown-item bulk-export" href="{{ route('admin.sellers.export') }}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-export" href="{{route('admin.sellers.pdf')}}">
                                        {{\App\CPU\Helpers::translate('export to pdf')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.sellers.bulk-import')}}">
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

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
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
                                <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                            </tr>
                            </thead>
                            <thead class="theadF">
                            <tr>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                                </th>
                                <th class="theadFilter"></th>
                                <th></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class="theadFilter"></th>
                                <th class=""></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sellers as $key=>$seller)
                                <tr>
                                    <form class="table-editor-form" method="POST" action="{{route('admin.sellers.change',[$seller['id']])}}" enctype="multipart/form-data">
                                    <td>
                                        @csrf
                                        <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                        <span class="rowId" hidden>{{$seller->id}}</span>
                                    </td>
                                    <td>{{$sellers->firstItem()+$key}}</td>
                                    <td>
                                        <span class="spanValue">
                                            <a title="{{\App\CPU\Helpers::translate('View')}}"
                                            class="title-color"
                                            href="{{route('admin.sellers.view',$seller->id)}}">
                                                {{$seller->vendor_account_number}}
                                            </a>
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->vendor_account_number }}" name="vendor_account_number" />
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
                                        <span class="spanValue">
                                            <a title="{{\App\CPU\Helpers::translate('View')}}"
                                            class="title-color"
                                            href="{{route('admin.sellers.view',$seller->id)}}">
                                                {{$seller->shop->name ?? null}}
                                            </a>
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->shop->name ?? null }}" name="shop[name]" />
                                    </td>

                                    <td>
                                        <span class="spanValue">
                                            <a title="{{\App\CPU\Helpers::translate('View')}}"
                                            class="title-color"
                                            href="{{route('admin.sellers.view',$seller->id)}}">
                                                {{$seller->name}}
                                            </a>
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->name }}" name="name" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            <a title="{{\App\CPU\Helpers::translate('View')}}"
                                            class="title-color"
                                            href="{{route('admin.sellers.view',$seller->id)}}">
                                                {{$seller->delegate_name}}
                                            </a>
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->delegate_name }}" name="delegate_name" />
                                    </td>

                                    <td>
                                        <span class="spanValue">
                                            <div class="mb-1">
                                                <strong><a class="title-color hover-c1" href="mailto:{{$seller->email}}">{{$seller->email}}</a></strong>
                                            </div>
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->email }}" name="email" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            <a class="title-color hover-c1" href="tel:{{$seller->phone}}">{{$seller->phone}}</a>
                                        </span>
                                        <input class="form-control editValue" dir="ltr" type="text" value="{{ $seller->phone ?? '+966' }}" name="phone" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            {{$seller->delegate_phone}}
                                        </span>
                                        <input class="form-control editValue" dir="ltr" type="text" value="{{ $seller->delegate_phone ?? '+966' }}" name="delegate_phone" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            {{$seller->commercial_registration_no}}
                                        </span>
                                        <input class="form-control editValue" type="number" value="{{ $seller->commercial_registration_no }}" name="commercial_registration_no" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            {{$seller->tax_no}}
                                        </span>
                                        <input class="form-control editValue" type="number" value="{{ $seller->tax_no }}" name="tax_no" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            {{$seller->bank_name}}
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->bank_name }}" name="bank_name" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            {{$seller->holder_name}}
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->holder_name }}" name="holder_name" />
                                    </td>
                                    <td>
                                        <span class="spanValue">
                                            {{$seller->account_no}}
                                        </span>
                                        <input class="form-control editValue" type="text" value="{{ $seller->account_no }}" name="account_no" />
                                    </td>
                                    <td>
                                        <span class="colLbl">
                                            {{\App\CPU\Helpers::translate('Active status')}}:
                                        </span>
                                        <div style="padding-left: 35%;padding-right: 35%;">
                                            <label class="switch switch-status mx-1">
                                                <input type="checkbox" class="status"
                                                id="{{$seller['id']}}" {{$seller->status=='approved'?'checked':''}}>
                                                <span class="slider round"></span>
                                            </label>
                                            <span hidden>{{$seller->status=='approved' ?? '0'}}</span>
                                        </div>
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
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a title="{{\App\CPU\Helpers::translate('View')}}"
                                                class="btn btn-outline-info btn-sm square-btn"
                                                href="{{route('admin.sellers.view',$seller->id)}}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                        </div>
                                    </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form hidden action="{{route('admin.sellers.bulk-delete')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-center justify-content-md-end">
                            <!-- Pagination -->
                            {!! $sellers->links() !!}
                        </div>
                    </div>

                    @if(count($sellers)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                            <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
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
                url: "{{route('admin.sellers.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data.success == true || data == 1) {
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                    else if(data == 2) {
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload();
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\Helpers::translate('Status updated failed. Product must be approved')}}');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        toastr.error('{{\App\CPU\Helpers::translate('Seller must have an account number first')}}');
                    }
                }
            });
        });
    </script>
@endpush
