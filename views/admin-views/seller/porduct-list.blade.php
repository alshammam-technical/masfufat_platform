@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Product List'))
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">  <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Products')}}</li>
        </ol>
    </nav>

    <div class="d-md-flex_ align-items-center justify-content-between mb-0">
        <div class="row text-center">
            <div class="col-12">
                <h3 class="h3 mt-2 text-black-50">{{\App\CPU\Helpers::translate('product_list')}}</h3>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{\App\CPU\Helpers::translate('product_table')}}
                        <span class="badge badge-soft-dark ml-2">{{$product->total()}}</span>
                    </h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL#')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Product Name')}}</th>
                                <th>{{\App\CPU\Helpers::translate('purchase_price')}}</th>
                                <th>{{\App\CPU\Helpers::translate('selling_price')}}</th>
                                <th>{{\App\CPU\Helpers::translate('featured')}}</th>
                                <th style="width: 5px">{{\App\CPU\Helpers::translate('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product as $k=>$p)
                                <tr>
                                    <th scope="row">{{$product->firstItem()+$k}}</th>
                                    <td>
                                        <a href="{{route('admin.product.view',[$p['id']])}}">
                                            {{substr($p['name'],0,20)}}{{strlen($p['name'])>20?'...':''}}
                                        </a>
                                    </td>
                                    <td>
                                        {{ ($p['purchase_price']).\App\CPU\BackEndHelper::currency_symbol()}}
                                    </td>
                                    <td>
                                        {{ ($p['unit_price']).\App\CPU\BackEndHelper::currency_symbol()}}
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox"
                                                   onclick="featured_status('{{$p['id']}}')" {{$p->featured == 1?'checked':''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-top: 0px !important">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.product.edit',[$p['id']])}}">{{\App\CPU\Helpers::translate('Edit')}}</a>
                                                <a class="dropdown-item" href="javascript:"
                                                onclick="form_alert('product-{{$p['id']}}','Want to delete this item ?')">{{\App\CPU\Helpers::translate('Delete')}}</a>
                                                <form action="{{route('admin.product.delete',[$p['id']])}}"
                                                      method="post" id="product-{{$p['id']}}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </div>
                                        <!-- End Dropdown -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$product->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
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
                url: "{{route('admin.product.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data.success == true) {
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    } else {
                        toastr.error('{{\App\CPU\Helpers::translate('Status updated failed. Product must be approved')}}');
                        location.reload();
                    }
                }
            });
        });

        function featured_status(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.product.featured-status')}}",
                method: 'POST',
                data: {
                    id: id
                },
                success: function () {
                    toastr.success('{{\App\CPU\Helpers::translate('Featured status updated successfully')}}');
                }
            });
        }
    </script>
@endpush
