@extends('layouts.front-end.app')

@section('title',\App\CPU\Helpers::translate('My linked products '))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="My linked products  of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="My linked products  of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <style>
        .headerTitle {
            font-size: 25px;
            font-weight: 700;
            margin-top: 2rem;
        }

        .for-container {
            width: 91%;
            border: 1px solid #D8D8D8;
            margin-top: 3%;
            margin-bottom: 3%;
        }

        .for-padding {
            padding: 3%;
        }

        td{
            vertical-align: middle !important;
        }

        .table, .dataTables_scrollHead, .table .thead-light th{
            background-color: #F8F8F8;
        }

        .table tbody tr, .table tbody tr td{
            background-color: white !important;
        }
    </style>

    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }


        .table th, .table td{
            border: none;
        }



        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: black !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border: none;
            text-align: center;
        }

        .table, .dataTables_scrollHead{
            background-color: #f8f8f8;
            border: #f8f8f8;
            overflow-y: hidden;
        }

        .dataTables_scrollHeadInner{
            border-radius: 0px !important;
            padding: 0px !important;
        }

        .dataTables_scrollHeadInner{
            background-color: #fff;
        }


        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td{
            border-radius: 0px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        thead, tbody{
            width: 100%;
            border-right: #F8F8F8 solid thin;
            border-left: #F8F8F8 solid thin;
            border-bottom: #F8F8F8 solid thin;
        }

        thead{
            background-color: #F8F8F8;
            border-radius: 11px;
        }

        .card{
            border: none !important;
            box-shadow: none !important;
        }

        *{
            box-shadow: none !important;
            border-radius: 11px !important;
        }

        thead,thead *{
            /*border:solid thin;*/
        }

        .badge-pending{
            padding: 15px !important;
            color: white;
            background-color: #BE52F2;
        }

        .card-footer{
            border: none !important;
            background-color: #F8F8F8 !important;
        }

        .pagination{
            background-color: white;
        }

        .page-item.active,.page-item.active .page-link{
            background-color: #0084F4 !important;
            border-radius: 0px !important;
        }

        .tab-btn.active{
            background-color: white !important;
            border:none !important;
            color: black !important;
        }
    </style>
@endpush

@section('content')

<form action="{{route('linked-products')}}" method="post" id="syncWithSalla" hidden >
    @csrf
    <input type="hidden" name="products" id="linkedProducts">
    <button class="btn btn-primary mt-2">
        <i class="czi-store"></i>
        {{\App\CPU\Helpers::translate('Add to my products list')}}
    </button>
</form>
<div class="p-md-10" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">

    <div class="row py-3 px-5 bg-light" style="border-radius: 12px">
        <div class="px-0 col-4 text-center bg-transparent justify-content-center d-block">
            <button class="p-3 m-0 text-center text-light w-90 btn btn-primary tab-btn active"
            onclick="$('.tab-content').hide();$('#unsync').show();retable(0);$('.tab-btn').removeClass('active');$(this).addClass('active')"
            >{{\App\CPU\Helpers::translate('My linked products (in pending)')}}</button>
        </div>

        <div class="px-0 col-4 text-center bg-transparent justify-content-center d-block">
            <button class="p-3 m-0 text-center text-light w-90 btn btn-primary tab-btn "
            onclick="$('.tab-content').hide();$('#synced').show();retable(1);$('.tab-btn').removeClass('active');$(this).addClass('active')"
            >{{\App\CPU\Helpers::translate('My linked products')}}</button>
        </div>



        <div class="px-0 col-4 text-center bg-transparent justify-content-center d-block">
            <button class="p-3 m-0 text-center text-light w-90 btn btn-primary tab-btn "
            onclick="$('.tab-content').hide();$('#sync-deleted').show();retable(2);$('.tab-btn').removeClass('active');$(this).addClass('active')"
            >{{\App\CPU\Helpers::translate('deleted products')}}</button>
        </div>
    </div>


    <div class="row pt-0 px-0 mt-6">
        <div class="pt-0 px-0 tab-content" id="unsync">
            <div class="card-body pt-0 px-0 border" id="items">
                <div>
                    <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};margin-top:0px !important" class="products-dataTable0 table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">

                                </th>
                                <th><strong>{{ Helpers::translate('ID') }}</strong></th>
                                <th><strong>{{ Helpers::translate('image') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Item Number') }}</strong></th>
                                <th><strong>{{ Helpers::translate('product_code_sku') }}</strong></th>
                                <th><strong>{{ Helpers::translate('name') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('sale price in my store') }}</strong></th>
                                <th><strong>{{ Helpers::translate('actions') }}</strong></th>
                            </tr>
                        </thead>
                        <thead class="theadF">
                            <tr>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked)" />
                                </th>
                                <th colName="id" class="theadFilter"></th>
                                <th class=""></th>
                                <th colName="name" class="theadFilter"></th>
                                <th colName="item_number" class="theadFilter"></th>
                                <th colName="code" class="theadFilter"></th>
                                <th colName="purchase_price" class="theadFilter"></th>
                                <th colName="unit_price" class="theadFilter"></th>
                                <th colName="featured" class="theadFilter"></th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('web-views.pending-tr',['pro'=>$products,'delete_function'=>'deleteFromList'])
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row w-100 text-center py-3 bg-light mx-0 mt-4" style="border-radius: 12px">

                <div class="col-md-4 text-center justify-content-center">

                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary mt-2 px-8 w-75" onclick="syncNow(0)">
                        {{ \App\CPU\Helpers::translate('Save & Sync now') }}
                    </button>
                </div>

                <div class="col-md-4 text-center justify-content-center d-flex">
                    <div class="d-flex table-actions flex-wrap justify-content-center mx-3 bg-white wd-md-50p">
                        <button class="btn ti-save btn-primary my-2 btn-icon-text m-2" onclick="saveAll()">
                            <i class="fa fa-save"></i>
                        </button>

                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete','Want to delete this items ?')">
                            <i class="ri-delete-bin-5-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <form hidden action="{{route('salla.products.bulk.delete')}}" method="post" id="bulk-delete">
            @csrf @method('delete')
            <input type="text" name="ids" class="ids">
                <input type="text" name="not_ids" class="not_ids">
        </form>
        <form hidden action="{{route('salla.linkedproducts.bulk.delete')}}" method="post" id="bulk-delete-linked">
            @csrf @method('delete')
            <input type="text" name="ids" class="ids">
                <input type="text" name="not_ids" class="not_ids">
        </form>


        <div class="pt-2 px-0 tab-content" id="synced" style="display: none">
            <div class="card-body pt-0 px-0 border" id="items">
                <div>
                    <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};margin-top:0px !important" class="products-dataTable1 linked_products_table table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">

                                </th>
                                <th><strong>{{ Helpers::translate('ID') }}</strong></th>
                                <th><strong>{{ Helpers::translate('image') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Item Number') }}</strong></th>
                                <th><strong>{{ Helpers::translate('product_code_sku') }}</strong></th>
                                <th><strong>{{ Helpers::translate('name') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('sale price in my store') }}</strong></th>
                                <th><strong>{{ Helpers::translate('actions') }}</strong></th>
                            </tr>
                        </thead>
                        <thead class="theadF">
                            <tr>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked)" />
                                </th>
                                <th colName="id" class="theadFilter"></th>
                                <th class=""></th>
                                <th colName="name" class="theadFilter"></th>
                                <th colName="item_number" class="theadFilter"></th>
                                <th colName="code" class="theadFilter"></th>
                                <th colName="purchase_price" class="theadFilter"></th>
                                <th colName="unit_price" class="theadFilter"></th>
                                <th colName="featured" class="theadFilter"></th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('web-views.tr',['pro'=>$products_linked,'delete_function'=>'deleteFromLinked',
                            'extra_data' => ['is_deleted' => 0]])
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row w-100 text-center py-3 bg-light mx-0 mt-4" style="border-radius: 12px">

                <div class="col-md-4 text-center justify-content-center">

                </div>

                <div class="col-md-4 text-center justify-content-center d-flex">
                    <div class="d-flex table-actions flex-wrap justify-content-center mx-3 bg-white wd-md-50p">
                        <button class="btn ti-save btn-primary my-2 btn-icon-text m-2" onclick="saveAll()">
                            <i class="fa fa-save"></i>
                        </button>

                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete-linked','Want to delete this items ?')">
                            <i class="ri-delete-bin-5-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2 px-0 tab-content" id="sync-deleted" style="display: none">
            <div class="card-body pt-0 px-0 border" id="items">
                <div>
                    <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};margin-top:0px !important" class="products-dataTable2 table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">

                                </th>
                                <th><strong>{{ Helpers::translate('ID') }}</strong></th>
                                <th><strong>{{ Helpers::translate('image') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Item Number') }}</strong></th>
                                <th><strong>{{ Helpers::translate('product_code_sku') }}</strong></th>
                                <th><strong>{{ Helpers::translate('name') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Purchase price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('Suggested sale price') }}</strong></th>
                                <th><strong>{{ Helpers::translate('sale price in my store') }}</strong></th>
                                <th><strong>{{ Helpers::translate('actions') }}</strong></th>
                            </tr>
                        </thead>
                        <thead class="theadF">
                            <tr>
                                <th scope="">
                                    <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll_p(event.target.checked)" />
                                </th>
                                <th colName="id" class="theadFilter"></th>
                                <th class=""></th>
                                <th colName="name" class="theadFilter"></th>
                                <th colName="item_number" class="theadFilter"></th>
                                <th colName="code" class="theadFilter"></th>
                                <th colName="purchase_price" class="theadFilter"></th>
                                <th colName="unit_price" class="theadFilter"></th>
                                <th colName="featured" class="theadFilter"></th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('web-views.tr',['pro'=>$products_deleted,'delete_function'=>'deleteFromList',
                            'extra_data' => ['is_deleted' => 1, 'Sync' => 'SyncDeleteFromList']])
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row w-100 text-center py-3 bg-light mx-0 mt-4" style="border-radius: 12px">

                <div class="col-md-4 text-center justify-content-center">

                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary mt-2 px-8 w-75" onclick="syncNow(1)">
                        {{ \App\CPU\Helpers::translate('Save & Sync now') }}
                    </button>
                </div>

                <div class="col-md-4 text-center justify-content-center d-flex">
                    <div class="d-flex table-actions flex-wrap justify-content-center mx-3 bg-white wd-md-50p">
                        <button class="btn ti-save btn-primary my-2 btn-icon-text m-2" onclick="saveAll()">
                            <i class="fa fa-save"></i>
                        </button>

                        <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2" onclick="form_alert('bulk-delete','Want to delete this items ?')">
                            <i class="ri-delete-bin-5-fill"></i>
                        </button>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

@push('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script>
        var skip = 0;
        var allRecSelected = false;
        var theadF = [];
        theadF[0] = $('.products-dataTable0').find(".theadF").html();
        theadF[1] = $('.products-dataTable1').find(".theadF").html();
        theadF[2] = $('.products-dataTable2').find(".theadF").html();
        var table = $('.products-dataTable0').DataTable({
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
            responsive: true,
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
                $('<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><nav class="pagination" role="navigation" aria-label="pagination"></nav></div>').insertAfter($('.products-dataTable0').closest('.tab-content').find(".dataTables_info"));
                $(".table-responsive.pagingLinks").appendTo($('.products-dataTable0').closest('.tab-content').find('.dataTables_paginate nav'))
                var btns = $('.products-dataTable0').closest('.tab-content').find('.dt-button');
                btns.removeClass('dt-button');
                var that = this
                dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                this.api().columns().every( function (e) {
                    var column = this;
                    var select = $('<input type="text" class="form-control dt-filter" placeholder="" />')
                    .appendTo( $(".products-dataTable0 .theadF tr .theadFilter").eq(column.index()) )
                    .on( 'change keyup', function (e) {
                            skip = 0;
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            that.api().columns($(e.target).parent().index())
                                .search($(this).val())
                                .draw();
                            $.ajax({
                                type: 'get',
                                url :"{{route('list_skip')}}?skip="+skip,
                                data: table.state(),
                                success: function(data){
                                    $("products-dataTable0 * tbody").html(data);
                                    if(allRecSelected){
                                        checkAll_p(allRecSelected);
                                    }
                                }
                            })
                        } );
                } );
                $(".buttons-colvis").insertAfter(".btnDeleteRow");
                $(".buttons-colvis").addClass("my-2 btn-icon-text m-2 px-2");
                $('.dataTables_filter').remove();
                $('.dataTables_length').hide();
                $('.products-dataTable0 tbody').show();
                $('<div class="dataTables_info" role="status" aria-live="polite">{{\App\CPU\Helpers::translate("Selected Records")}}: <span id="table_selected"></span></div>').insertAfter($('.products-dataTable0').closest('.tab-content').find(".dataTables_info"));
            },
            language: {
                "lengthMenu": "{{Helpers::translate('Display')}} _MENU_ {{Helpers::translate('records per page')}}",
                "zeroRecords": "{{Helpers::translate('Nothing data found')}}",
                "info": "",
                "infoEmpty": "{{Helpers::translate('No records available')}}",
                "infoFiltered": "{{Helpers::translate('filtered from _MAX_ total records')}}"
            }
        });

        var theIndex = 0

        function retable(index){
            theIndex = index
            $(".theadF").remove();
            table.destroy();
            $("<thead class='theadF'>" + theadF[index] + "</thead>").insertAfter('.products-dataTable'+index+' thead');
            $(".buttons-colvis").remove();
            table = $('.products-dataTable'+index+'').DataTable({
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
                responsive: true,
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
                    $('<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><nav class="pagination" role="navigation" aria-label="pagination"></nav></div>').insertAfter($('.products-dataTable'+index+'').closest('.tab-content').find(".dataTables_info"));
                    $(".table-responsive.pagingLinks").appendTo($('.products-dataTable'+index+'').closest('.tab-content').find('.dataTables_paginate nav'))
                    var btns = $('.products-dataTable'+index+'').closest('.tab-content').find('.dt-button');
                    btns.removeClass('dt-button');
                    var that = this
                    dataTables_scrollBody_height = $(".dataTables_scrollBody").css('height');
                    this.api().columns().every( function (e) {
                        var column = this;
                        var select = $('<input type="text" class="form-control dt-filter" placeholder="" />')
                        .appendTo( $(".products-dataTable"+index+" .theadF tr .theadFilter").eq(column.index()) )
                        .on( 'change keyup', function (e) {
                                skip = 0;
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                that.api().columns($(e.target).parent().index())
                                    .search($(this).val())
                                    .draw();
                                if(theIndex == 0){
                                    $.ajax({
                                        type: 'get',
                                        url :"{{route('list_skip')}}?skip="+skip,
                                        data: table.state(),
                                        success: function(data){
                                            $("products-dataTable0 * .dataTables_scrollBody * tbody").html(data);
                                            if(allRecSelected){
                                                checkAll_p(allRecSelected);
                                            }
                                        }
                                    })
                                }
                            } );
                    } );
                    $(".buttons-colvis").insertAfter(".btnDeleteRow");
                    $(".buttons-colvis").addClass("my-2 btn-icon-text m-2 px-2");
                    $('.dataTables_filter').remove();
                    $('.dataTables_length').hide();
                    $('.products-dataTable'+index+' tbody').show();
                    $('<div class="dataTables_info" role="status" aria-live="polite">{{\App\CPU\Helpers::translate("Selected Records")}}: <span id="table_selected"></span></div>').insertAfter($('.products-dataTable'+index+'').closest('.tab-content').find(".dataTables_info"));
                },
                language: {
                    "lengthMenu": "{{Helpers::translate('Display')}} _MENU_ {{Helpers::translate('records per page')}}",
                    "zeroRecords": "{{Helpers::translate('Nothing data found')}}",
                    "info": "",
                    "infoEmpty": "{{Helpers::translate('No records available')}}",
                    "infoFiltered": "{{Helpers::translate('filtered from _MAX_ total records')}}"
                }
            });
        }

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
                if(theIndex == 0){
                    skip = 0;
                    $.ajax({
                        type: 'get',
                        url :"{{route('list_skip')}}?skip="+skip,
                        data: table.state(),
                        success: function(data){
                            $("products-dataTable0 * .dataTables_scrollBody * tbody").html(data);
                            if(allRecSelected){
                                checkAll_p(allRecSelected);
                            }
                        }
                    })
                }
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

        $("products-dataTable0 * .dataTables_scrollBody").on("scroll",function(e){
            var ths = $(this);
            var tbody = $(this).find('tbody');
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop() <= elem.outerHeight()) {
                skip = skip + 10
                if(theIndex == 0){
                    $.ajax({
                        url:"{{route('list_skip')}}?skip="+skip,
                        data: table.state(),
                        success:function(data){
                            $(data).appendTo(tbody);
                            if(allRecSelected){
                                checkAll_p(allRecSelected);
                            }
                        }
                    })
                }
            }
        })
    </script>
    <script>
        var price_edits = new Object();
        var selectedProducts = "{{$pArr}}";
        selectedProducts = selectedProducts.split(',');
        function saveAll(){
            alert_wait();
            $.ajax({
                url:'{{ route('linked-products.price.edit') }}',
                type:'post',
                data:{
                    _token: '{{ csrf_token() }}',
                    price_edits:price_edits
                },
                success:function(data){
                    location.reload();
                }
            })
        }


        function checkAll_p(checked){
            $(".btnAddFrom").attr('disabled');
            allRecSelected = checked;
            $(".trSelector").prop('checked',checked);
            if(checked){
                $('.ids').val("all")
                $("#table_selected").text($('.dataTables_scrollBody').find('.lptr').length)
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

        function handleRowSelect(e){
            if($(".selectAllRecords").is(":checked")){
                var p;
                if(table.rows('.selected').data().length){
                    if(e.checked){
                        $(e).closest('tr').addClass("selected");
                        var p = parseInt($("#table_selected").text()) + 1;
                    }else{
                        $(e).closest('tr').removeClass("selected");
                        var p = parseInt($("#table_selected").text()) - 1;
                    }
                    $("#table_selected").text(p)
                    var non_selectedCols = []
                    $(e).closest('tbody').find('tr:not(.selected)').each(function(e,i){
                        non_selectedCols.push($(this).find('.rowId').text())
                    })
                    $(".not_ids").val(non_selectedCols)
                }
            }else{
                var p = 0;
                if(e.checked){
                    p = parseInt($("#table_selected").text()) + 1;
                }else{
                    p = parseInt($("#table_selected").text()) - 1;
                }
                $("#table_selected").text(p)
                $(e).closest("tr").toggleClass('selected');
                var data = table.rows('.selected').data();
                var selectedCols = []
                $('tr.selected').each(function(e,i){
                    selectedCols.push($(this).find('.rowId').text())
                })
                $(".ids").val(selectedCols)
                if(data.length == 1){

                }else{
                    $(".btn-addFrom").attr("disabled","disabled");
                }
                if(!$(".selectAllRecords").is(":checked") && (table.rows('.selected').data().length)){
                    //$("#table_selected").text(data.length)
                }
            }
            if($(".ids").val().includes(",") || !$(".ids").val()){
                $(".btnAddFrom").attr('disabled',true);
            }else{
                $(".btnAddFrom").removeAttr('disabled');
            }
        }

        function syncNow(deleted){
            var timerInterval;
            if($('.ids').val() == "all"){
                selectedProducts = "{{$pArr}}"
            }else{
                selectedProducts = $('.ids').val()
            }
            Swal.fire({
                title: `{{ Helpers::translate('Syncing is in progress, please wait')}}...`,
                text: `{{ Helpers::translate('this may take  a while, please do not refresh or close the page') }}`,
                timerProgressBar: true,
                allowOutsideClick: false,
                showConfirmButton:false,
                didOpen: () => {
                Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
            });

            $.ajax({
                url:'{{ route('linked-products.price.edit') }}',
                type:'post',
                data:{
                    _token: '{{ csrf_token() }}',
                    price_edits:price_edits,
                    deleted: deleted
                },success:function(data){
                    //
                    var timerInterval;
                    var arr = [];
                    var i = 1;
                    var url = "{{ route('salla.products.sync',['skip'=>10]) }}";
                    var counterLimit = 10;
                    if(selectedProducts.length <= 20){
                        url = "{{ route('salla.products.sync',['skip'=>2]) }}";
                        counterLimit = 2;
                    }
                    if(selectedProducts.length <= 10){
                        url = "{{ route('salla.products.sync',['skip'=>1]) }}";
                        counterLimit = 1;
                    }
                    $.ajax({
                        url:url,
                        data:{
                            ids : arr.toString(),
                            deleted: deleted,
                            ids: $('.ids').val(),
                        },
                        success:function(data){
                            Swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: "{{\App\CPU\Helpers::translate('Done')}}",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload()
                        },
                        error:function(data){
                            Swal.fire({
                                position: 'top-end',
                                html:(data.responseText.message) ? data.responseText.message : data.responseText + (arr.toString() ? '('+arr.toString()+')' : ''),
                                type: 'error',
                                title: "{{\App\CPU\Helpers::translate('An error occurred!')}}",
                                showConfirmButton: true,
                            });
                        }
                    })
                    //
                }
            })


        }

        function deleteFromList(event,product_id){
            alert_wait();
            $.ajax({
                url: "{{ route('linked-products.delete') }}?product_id="+product_id,
                success: function(data){
                    location.reload()
                }
            })
        }

        function SyncDeleteFromList(event,product_id){
            alert_wait();
            $.ajax({
                url: "{{ route('linked-products.deleted-sync') }}?product_id="+product_id,
                success: function(data){
                    location.reload()
                }
            })
        }

        function deleteFromLinked(e,productLocalId){
            alert_wait();
            $.ajax({
                url: "{{route('salla.products.delete')}}?id="+productLocalId,
                success:function(data){
                    $(e.target).closest(".products-container").remove();
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "{{\App\CPU\Helpers::translate('Done')}}",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload()
                }
            })
        }
    </script>
@endpush

@endsection
