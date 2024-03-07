@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('updated_product_list'))

@push('css_or_js')

@endpush

@section('content')

<div class="content container-fluid">
    <!-- Page Title -->
    <div class="row" style="margin-top: 20px">
        <div class="col-lg-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                    <li class="breadcrumb-item mx-1" aria-current="page"><a href="#">{{\App\CPU\Helpers::translate('updated_products')}}</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-7">
            <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.product.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom_p()" disabled>
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

                    <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    onclick="form_alert('bulk-delete','Want to delete this item ?')"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <button title="{{Helpers::translate('grid view')}}" class="btn btn-info btn-grid my-2 btn-icon-text m-2" onclick="$('.products-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','600px');localStorage.setItem('tableView','grid')">
                        <i class="fa fa-th"></i>
                    </button>
                    <button title="{{Helpers::translate('table view')}}" class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.products-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height);localStorage.setItem('tableView','table')">
                        <i class="fa fa-table"></i>
                    </button>
                    <button title="{{Helpers::translate('show/hide columns')}}" class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                        <i class="fa fa-toggle"></i>
                    </button>
                    @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                    <form class="form-control p-0 text-start mt-2 d-flex bulk-pricing-form" dir="auto" style="width: 300px" method="POST" action="{{route('admin.product.bulk-pricing_levels',['type'=>0])}}">
                        @csrf
                        <button title="{{ Helper::translate('delete pricing levels for selected items') }}" class="btn btn-info"><i class="fa fa-close"></i></button>
                        <select multiple class="text-dark SumoSelect-custom w-100 testselect2-custom"
                        onchange="$('input[name=show_for_pricing_levels]').val($(this).val().toString());$(this).closest('form').submit();"
                        >
                            @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                            <option value="{{$pl->id}}">
                                {{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="show_for_pricing_levels">
                        <input type="hidden" name="ids" class="ids">
                        <input type="hidden" name="not_ids" class="not_ids">
                    </form>
                    @endif
                </div>
                <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                    <div class="dropdown ">
                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
                            <i class="ti-bag"></i>
                        </button>
                        <div aria-labelledby="droprightMenuButton" class="dropdown-menu parent-dropdown ">
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

                            <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-show-product" data-toggle="display" id="showFor" type="button"
                            onmouseover="$('.display-menu').addClass('show');$('.export-menu').removeClass('show');$('.parent-dropdown').addClass('show')">
                                <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('Show product')}}
                            </a>
                            <div class="c dropdown-menu display-menu tx-13 bulk-show-product" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-to-purchase','Are you sure ?')"
                                >
                                    {{\App\CPU\Helpers::translate('to purchase')}}
                                </a>
                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-to-add','Are you sure ?')"
                                >
                                    {{\App\CPU\Helpers::translate('to add')}}
                                </a>
                                <a class="dropdown-item" href="#"
                                onclick="form_alert('bulk-to-both','Are you sure ?')"
                                >
                                    {{\App\CPU\Helpers::translate('both')}}
                                </a>
                            </div>

                            <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="export" id="droprightMenuButton" type="button"
                            onmouseover="$('.export-menu').addClass('show');$('.display-menu').removeClass('show');$('.parent-dropdown').addClass('show')">
                                <i class="ti-angle-down"></i>
                                {{\App\CPU\Helpers::translate('Import/Export')}}
                            </a>
                            <div class="child dropdown-menu export-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                <a class="dropdown-item bulk-export" href="{{route('admin.product.bulk-export')}}">
                                    {{Helpers::translate('export to excel')}}
                                </a>
                                <a class="dropdown-item bulk-export" href="{{route('admin.product.pdf')}}?type={{0}}">
                                    {{Helpers::translate('export to pdf')}}
                                </a>
                                <a class="dropdown-item bulk-import" href="{{route('admin.product.bulk-import')}}">
                                    {{Helpers::translate('import from excel')}}
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
                <div>
                    <label class="input-group mt-2" style="height: 34px">
                        <input
                        onfocus="$('.search_note').fadeIn()"
                        onblur="$('.search_note').fadeOut()"
                        type="search"
                        class="form-control form-control-sm"
                        placeholder="..."
                        style="border-radius:0px 6px 6px 0px !important;height: 43px"
                        onchange="globalSearch(event.target.value)"
                        >
                        <button class="btn search-btn btn-primary" onclick="globalSearch($(this).prev('input').val())" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                        <i class="fa fa-search"></i>
                        </button>
                    </label>
                    <p class="mb-0 mt-1 bg-white p-2 rounded search_note" style="position: absolute;display: none">{{Helpers::translate('note: plase press enter when done typing')}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row gy-2 justify-content-between align-items-center">
                        <div class="col-auto">
                            <h5 class="mb-0">
                                    {{\App\CPU\Helpers::translate('product_table')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $pro->total() }}</span>
                            </h5>
                        </div>
                        <div class="col-auto">
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-custom">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                           placeholder="{{\App\CPU\Helpers::translate('Search Product Name')}}" aria-label="Search orders"
                                           value="{{ $search }}" required>
                                    <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                        <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                            <th>{{\App\CPU\Helpers::translate('Product Name')}}</th>
                            <th>{{\App\CPU\Helpers::translate('previous_shipping_cost')}}</th>
                            <th>{{\App\CPU\Helpers::translate('new_shipping_cost')}}</th>
                            <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pro as $k=>$p)
                            <tr>
                                <th scope="row">{{$pro->firstItem()+$k}}</th>
                                <td>
                                    <a href="{{route('admin.product.edit',[$p['id']])}}" class="title-color hover-c1">
                                        {{ \App\CPU\Helpers::get_prop('App\Model\Product',$p['id'],'name',session()->get('lang')) ?? $p['name'] }}
                                    </a>
                                </td>
                                <td>
                                    {{\App\CPU\BackEndHelper::set_symbol(($p['shipping_cost']))}}
                                </td>
                                <td>
                                    {{\App\CPU\BackEndHelper::set_symbol(($p['temp_shipping_cost']))}}
                                </td>

                                <td>
                                    <div class="d-flex gap-10 align-items-center justify-content-center">
                                        @if(Helpers::module_permission_check('admin.products.updated-product-list.approve'))
                                        <button class="btn btn--primary btn-primary btn-sm"
                                        onclick="update_shipping_status({{$p['id']}},1)">
                                            {{\App\CPU\Helpers::translate('Approve')}}
                                        </button>
                                        @endif

                                        @if(Helpers::module_permission_check('admin.products.updated-product-list.reject'))
                                        <button class="btn btn-danger btn-sm"
                                            onclick="update_shipping_status({{$p['id']}},0)">
                                            {{\App\CPU\Helpers::translate('deneid')}}
                                        </button>
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
                        {{$pro->links()}}
                    </div>
                </div>

                @if(count($pro)==0)
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
    function update_shipping_status(product_id,status) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.product.updated-shipping')}}",
                method: 'POST',
                data: {
                    product_id: product_id,
                    status:status
                },
                success: function (data) {

                    toastr.success('{{\App\CPU\Helpers::translate('status updated successfully')}}');
                    location.reload();
                }
            });
        }
</script>

@endpush
