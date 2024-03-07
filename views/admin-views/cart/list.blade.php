@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('carts List'))
@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="row" style="margin-top: 0px">
            <div class="col-lg-5">
                <nav aria-label="breadcrumb" style="width:100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('carts')}}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn btn-success my-2 btn-icon-text m-2" data-target="#reminder_add" data-toggle="modal">
                        {{ Helpers::translate('Abandoned baskets reminders') }}
                    </a>

                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2">
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
                                    <a class="dropdown-item bulk-export" href="{{route('admin.abandoned-carts.bulk-export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.abandoned-carts.bulk-import')}}">
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

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card" style="width:100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="card-body">
                        <h2> {{ Helpers::translate('Abandoned baskets reminders') }} </h2>
                        @foreach (\App\Model\Cart::where('cart_group_id' , '111')
                        ->whereNotNull('offer')->get() as $offerKey=>$single_offer)
                        @php($so = $single_offer->offer ?? [])
                        <a class="mt-6 row">
                            <h5 class="col-6 pt-2">
                                {{ Helpers::translate('reminder after') }}
                                {{ $so['leaving_duration'] ?? null }}
                                {{ Helpers::translate('Hours and') }}
                                {{ $so['leaving_duration_m'] ?? null }}
                                {{ Helpers::translate('Minutes of leaving the cart') }}
                                    -
                                    {{ Helpers::translate('If total equals or less than') }}: {{ $so['discount_if'] ?? null }} {{ Helpers::translate('SAR') }}
                                    -
                                    {{ Helpers::translate('Discount value') }} {{ ($so['discount_type'] == 'static_cost') ? $so['static_cost_value'].' '.Helpers::translate('SAR') ?? '' : $so['percent'].'%' ?? '' }}
                            </h5>
                            <div class="col-6 text-end">
                                <div class="row">
                                    <div class="col-9">

                                    </div>
                                    <div class="col-1" style="margin-top: 11px;">
                                        <label class="switch switch-status mx-1">
                                            <input type="checkbox" class="status" @if(($so['enabled'] ?? "false") == "true") checked @endif onchange="$.get('{{route('admin.abandoned-carts.switch_offer',['id'=>$single_offer['id']])}}?status='+event.target.checked).then(data=>{toastr.success('{{Helpers::translate('done')}}')})">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <div class="col-1">
                                        <button data-toggle="modal" data-target="#reminder_add{{$single_offer['id']}}" class="btn btn-primary mb-3">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>

                                    <div class="col-1">
                                        <button class="btn btn-danger mb-3"
                                        onclick="form_alert('delete-offer-{{$single_offer['id']}}','Want to delete this offer ?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <form action="{{ route('admin.abandoned-carts.delete_offer', ['id'=>$single_offer['id']]) }}" id="delete-offer-{{$single_offer['id']}}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="modal fade" id="reminder_add{{$single_offer['id']}}" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content h-100">
                                    <div class="modal-header">
                                        <a aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="$('#added_products').val('')"><span aria-hidden="true">&times;</span></a>
                                    </div>
                                    <div class="modal-body card-body">
                                        @include('admin-views.cart.offer_form',['o' => $so,'id'=>$single_offer['id'],'cart_group_id'=>$offerKey])
                                    </div>

                                    <div class="modal-footer">
                                        <button onclick="$(this).closest('.modal').find('form').submit()" class="btn ripple btn-success" type="button" onclick="$('#added_products_form').submit()">{{\App\CPU\Helpers::translate('Apply')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom mb-2">

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card" style="width:100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('Cart ID')}}
                                    </th>
                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('Customer name')}}
                                    </th>
                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('cart creation date')}}
                                    </th>

                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('products number')}}
                                    </th>

                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('total cost')}}
                                    </th>

                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('action')}}
                                    </th>
                                </tr>
                                </thead>
                                <thead class="theadF">
                                    <tr>
                                        <th scope="">
                                            <input type="checkbox" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                                        </th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($cart as $k=>$b)
                                    <tr>
                                        <form class="table-editor-form" method="POST" action="{{route('admin.abandoned-carts.update',[$b['cart_group_id']])}}">
                                            <td>
                                                @csrf
                                                <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                                <span class="rowId" hidden>{{$b->cart_group_id}}</span>
                                            </td>
                                            <td>
                                                {{ $b->cart_group_id }}
                                            </td>

                                            <td>{{ $b->customer->name ?? '' }}</td>
                                            <td>{{ $b->created_at }}</td>
                                            <td>{{ $b->products }}</td>
                                            <td>{{ $b->total_cost }}</td>

                                            <td>
                                                <a class="btn btn-primary btn-sm" title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                                href="{{route('admin.abandoned-carts.update',[$b['cart_group_id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <form hidden action="{{route('admin.abandoned-carts.bulk-delete')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.abandoned-carts.bulk-status',['status'=>true])}}" method="post" id="bulk-enable">
                            @csrf @method('post')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.abandoned-carts.bulk-status',['status'=>false])}}" method="post" id="bulk-disable">
                            @csrf @method('post')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reminder_add" tabindex="-1" role="dialog" aria-labelledby="productsModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <a aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="$('#added_products').val('')"><span aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body card-body">

                    @include('admin-views.cart.offer_form')
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-success" onclick="$(this).closest('.modal').find('form').submit()" type="button" onclick="$('#added_products_form').submit()">{{\App\CPU\Helpers::translate('Apply')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
