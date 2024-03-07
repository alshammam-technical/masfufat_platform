@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\Helpers::translate('Product List'))

@push('css_or_js')

@endpush

@section('content')

<style>
    ul.pagination{
        padding: 0px;
    }

    td,th{
        max-width: 100px;
        min-width: 100px;
        width: 100px;
    }

    .dataTables_info:nth-child(even){
        right: 0% !important;
    }

    .dataTables_info{
        position: unset;
        width: 100%;
    }

    .dataTables_empty, .dataTables_info[role="status"]{
        display: none;
    }
</style>
<script>
    var dataTables_scrollBody_height = 0;
</script>
<div class="content container-fluid">  <!-- Page Heading -->
    <div class="row" style="margin-top: 0px">
        <div class="col-lg-5">
            <nav aria-label="breadcrumb mb-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                    <li class="breadcrumb-item mx-1" aria-current="page"><a href="#">{{\App\CPU\Helpers::translate('Products')}}</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-7">
            <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                <div class="d-flex">

                <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('seller.product.add-new')}}">
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
                                <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable in market and app')}}
                            </a>
                            <a class="dropdown-item" href="#"
                            onclick="form_alert('bulk-disable','Are you sure ?')"
                            >
                                <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable in market and app')}}
                            </a>
                            <a class="dropdown-item" href="#" onclick="stateClear()">
                                <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                            </a>
                            <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button"
                            onclick='$(".dt-button-collection").remove();'>
                                <i class="ti-angle-down"></i>
                                {{\App\CPU\Helpers::translate('Import/Export')}}
                            </a>
                            <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                <a class="dropdown-item" href="{{route('seller.product.bulk-export')}}">
                                    {{\App\CPU\Helpers::translate('export to excel')}}
                                </a>
                                <a class="dropdown-item" href="{{route('seller.product.bulk-import')}}">
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
                    <button class="btn search-btn btn-primary" onclick="globalSearch($(this).prev('input').val())" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                    <i class="fa fa-search"></i>
                    </button>
                </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};margin-top:0px !important"
                               class="products-dataTable table table-striped table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">

                                    </th>
                                    <th>{{\App\CPU\Helpers::translate('SL#')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('image')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Item Number')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('product_code_sku')}}</th>
                                    @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                    <th>{{\App\CPU\Helpers::translate('Product Name')}} ({{$lang}})</th>
                                    @endforeach
                                    <th>{{\App\CPU\Helpers::translate('purchase_price')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('selling_price')}}</th>
                                    <th>{{Helpers::translate('verify_status')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Publish on market')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Publish on market date/time')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Publish on App')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('Publish on App date/time')}}</th>
                                    <th style="width: 5px" class="text-center"></th>
                                </tr>
                            </thead>
                            <thead class="theadF">
                                <tr>
                                    <th scope="">
                                        <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked)" />
                                    </th>
                                    <th colName="id" class="theadFilter"></th>
                                    <th class=""></th>
                                    <th colName="item_number" class="theadFilter"></th>
                                    <th colName="code" class="theadFilter"></th>
                                    @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                    <th colName="name" class="theadFilter"></th>
                                    @endforeach
                                    <th colName="purchase_price" class="theadFilter"></th>
                                    <th colName="unit_price" class="theadFilter"></th>
                                    <th colName="verify_status" class="theadFilter"></th>
                                    <th colName="publish_on_market" class="theadFilter"></th>
                                    <th colName="publish_on_market_time" class="theadFilter"></th>
                                    <th colName="publish_on_app" class="theadFilter"></th>
                                    <th colName="publish_on_app_time" class="theadFilter"></th>
                                    <th style="width: 5px" class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody style="display: none">
                            @include('seller-views.product.tr',['pro'=>$pro])
                            </tbody>
                        </table>
                        <div class="table-responsive pagingLinks mt-0 mb-2 px-0">
                            <div class="px-0 d-flex justify-content-lg-end">
                            </div>
                        </div>
                    </div>


                    <form hidden action="{{route('seller.product.bulk-delete',['search'=>$search])}}" method="post" id="bulk-delete">
                        @csrf @method('delete')
                        <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                    </form>

                    <form hidden
                        action="{{route('seller.product.bulk-status',['status'=>true,'search'=>$search])}}"
                        method="post" id="bulk-enable">
                        @csrf @method('post')
                        <input type="text" name="ids" class="ids">
                        <input type="text" name="not_ids" class="not_ids">
                    </form>

                    <form hidden
                        action="{{route('seller.product.bulk-status',['status'=>false,'search'=>$search])}}"
                        method="post" id="bulk-disable">
                        @csrf @method('post')
                        <input type="text" name="ids" class="ids">
                        <input type="text" name="not_ids" class="not_ids">
                    </form>


                </div>
                @if(count($pro)==0)
                    <div class="text-center p-4">
                        <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        var skip = 0;
        var allRecSelected = false;
        var table = $('.products-dataTable').DataTable({
            dom: 'Blfrti',
            buttons: [
                {
                    extend: 'excel',
                    text:'<i class="fa fa-file-excel-o"></i>',
                    className: 'btn btn-success'
                },
                {
                    extend: 'colvis',
                    text:'<i class="fa fa-toggle-on"></i>',
                    className: 'btn btn-info'
                },
            ],
            paging:false,
            responsive: false,
            colReorder: true,
            fixedHeader: true,
            stateSave: true,
            scrollY: '490px',
            scrollX: true,
            autoWidth:false,
            columnDefs: [

            ],
            order: [[ 2, 'asc' ]],
            scrollCollapse: true,
            initComplete: function () {
                $('<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><nav class="pagination" role="navigation" aria-label="pagination"></nav></div>').insertAfter('.dataTables_info');
                $(".table-responsive.pagingLinks").appendTo('.dataTables_paginate nav')
                var btns = $('.dt-button');
                btns.removeClass('dt-button');
                var that = this
                dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                this.api().columns().every( function (e) {
                    var column = this;
                    if(!$(".theadF tr .theadFilter").eq(column.index()).find('input').length){
                        var select = $('<input type="text" class="form-control dt-filter" placeholder="" />')
                        .appendTo( $(".theadF tr .theadFilter").eq(column.index()) )
                        .on( 'change', function (e) {
                                skip = 0;
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                that.api().columns($(e.target).parent().index())
                                .search($(this).val());
                                var s = table.state()
                                s.skip = skip
                                s.columns[$(e.target).parent().index()].search.search = $(this).val();
                                $.ajax({
                                    type: 'get',
                                    url :"{{route('seller.product.list_skip',['search'=>$search])}}",
                                    data: s,
                                    success: function(data){
                                        $(".dataTables_scrollBody * tbody").html(data);
                                        if(allRecSelected){
                                            checkAll_p(allRecSelected);
                                        }
                                    }
                                })
                        } );
                    }
                } );
                //$(".buttons-colvis").insertAfter(".btnDeleteRow");
                //$(".buttons-colvis").addClass("my-2 btn-icon-text m-2 px-2");
                $('.dataTables_filter').remove();
                $('.dataTables_length').hide();
                //$('<div class="dataTables_info" role="status" aria-live="polite">{{\App\CPU\Helpers::translate("Selected Records")}}: <span id="table_selected"></span></div>').insertAfter(".dataTables_info");
                $('.products-dataTable tbody').show();
                $('<div class="dataTables_info" role="status" aria-live="polite">{{\App\CPU\Helpers::translate("Selected Records")}}: <span id="table_selected"></span></div>').insertAfter(".dataTables_info");
            },
            language: {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "Nothing found - sorry",
                "info": "",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        });
        $(document).ready(function () {
            if(localStorage.getItem('tableView') === 'grid'){
                $(".btn-grid").click();
            }
            table.on('draw',function(){
                dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })
            table.draw();

            table.on('order',function(){
                skip = 0;
                var s = table.state();
                s.skip = skip
                $.ajax({
                    type: 'get',
                    url :"{{route('seller.product.list_skip',['search'=>$search])}}",
                    data: table.state(),
                    success: function(data){
                        $(".dataTables_scrollBody * tbody").html(data);
                        if(allRecSelected){
                            checkAll_p(allRecSelected);
                        }
                    }
                })
            })


            $(".btnDT").click(function(){
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })

        });

        $(".dataTables_scrollBody").on("scroll",function(e){
            var ths = $(this);
            var tbody = $(this).find('tbody');
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop() <= elem.outerHeight()) {
                skip = skip + 10
                var s = table.state();
                s.skip = skip
                $.ajax({
                    url:"{{route('seller.product.list_skip',['search'=>$search])}}",
                    data: s,
                    success:function(data){
                        $(data).appendTo(tbody);
                        if(allRecSelected){
                            checkAll_p(allRecSelected);
                        }
                    }
                })
            }
        })

    </script>

    <script>
        // Call the dataTables jQuery plugin

        $(document).on('change', '.status-market', function () {
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
                url: "{{route('seller.product.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data.success == true) {
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\Helpers::translate('Status updated failed. Product must be approved')}}');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        $(document).on('change', '.status-app', function () {
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
                url: "{{route('seller.product.status-app-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data.success == true) {
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\Helpers::translate('Status updated failed. Product must be approved')}}');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        function globalSearch(value){
            skip = 0;
            var val = $.fn.dataTable.util.escapeRegex(
                value
            );
            table.search(value);
            var s = table.state()
            s.search.search = value;
            s.skip = skip
            $.ajax({
                type: 'get',
                url :"{{route('seller.product.list_skip',['search'=>$search])}}",
                data: s,
                success: function(data){
                    $(".dataTables_scrollBody * tbody").html(data);
                    if(allRecSelected){
                        checkAll_p(allRecSelected);
                    }
                }
            })
        }

        function featured_status(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('seller.product.featured-status')}}",
                method: 'POST',
                data: {
                    id: id
                },
                success: function () {
                    toastr.success('{{\App\CPU\Helpers::translate('Featured status updated successfully')}}');
                }
            });
        }

        function checkAll_p(checked){
            $(".btnAddFrom").attr('disabled');
            allRecSelected = checked;
            $(".trSelector").prop('checked',checked);
            if(checked){
                $('.ids').val("all")
                $("#table_selected").text({{$pro_count}})
                $("tbody").find('tr').addClass('selected')
            }else{
                $('.ids').val("")
                $("#table_selected").text(0)
                $("tbody").find('tr').removeClass('selected')
            }
            if(checked){
                table.rows( ).select();
            }else{
                table.rows( ).deselect();
            }
        }

        function addFrom_p(){
            var id = $(".ids").val()
            if(id){
                location.replace("{{route('seller.clone')}}?table=products&id="+id);
            }
        }

    </script>
@endpush
