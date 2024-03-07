@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Language Translate'))
@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="row" style="margin-top: 0px">
            <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('admin.business-settings.language.index') }}">
                                {{\App\CPU\Helpers::translate('Language')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{\App\CPU\Helpers::translate('translate')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <button class="btn ti-plus btn-success my-2 btn-icon-text m-2" onclick="">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2">
                        <i class="fa fa-clone"></i>
                    </button>
                    <button class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn">
                        <i class="fa fa-save"></i>
                    </button>
                    <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2">
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
                                <a class="dropdown-item" onclick="$('').click()" href="#">
                                    <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                                </a>
                                <a class="dropdown-item" onclick="$('').click()" href="#">
                                    <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                                </a>
                                <a class="dropdown-item"  onclick="stateClear()" href="#">
                                    <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                                </a>
                                <a class="dropdown-item" onclick="$('').click()" href="#">
                                    <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                                </a>
                                <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                                onclick='$(".dt-button-collection").remove();'>
                                    <i class="ti-angle-down"></i>
                                    {{\App\CPU\Helpers::translate('Import/Export')}}
                                </a>
                                <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">
                                    <a class="dropdown-item bulk-export" onclick="$('.buttons-excel').click()" href="#">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" onclick="$('').click()" href="#">
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
                        <div class="table-responsive">
                            <table id="dataTable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-striped table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('SL#')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('key word')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('located in')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('value')}}</th>
                                    <th scope="col"></th>
                                {{--<th scope="col"></th>--}}
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
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody style="display: none">
                                @foreach($lang_data as $count=>$language)
                                    <tr id="lang-{{$language['key']}}">
                                        <td></td>
                                        <td>{{$count+1}}</td>
                                        <td>
                                            <input type="text" name="key[]" value="{{$language['key']}}" hidden>
                                            <label>{{$language['key']}}</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="locations[]"
                                                   id="location-{{$count+1}}"
                                                   value="{{$language['location']}}"
                                                   onkeyup="$(this).next('span').text(event.target.value)"
                                                   >
                                            <span hidden>{{$language['location']}}</span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="value[]"
                                                   id="value-{{$count+1}}"
                                                   value="{{$language['value']}}"
                                                   onkeyup="$(this).next('span').text(event.target.value)"
                                                   >
                                            <span hidden>{{$language['value']}}</span>
                                        </td>
                                        <td style="width: 100px">
                                            <button type="button"
                                                    onclick="update_lang_('{{$language['key']}}',$('#value-{{$count+1}}').val(),$('#location-{{$count+1}}').val())"
                                                    class="btn btn-primary">{{\App\CPU\Helpers::translate('Update')}}
                                            </button>
                                        </td>
                                    <!--<td style="width: 100px">
                                            <button type="button"
                                                    onclick="remove_key('{{$language['key']}}')"
                                                    class="btn btn-danger">Remove
                                            </button>
                                        </td>-->
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/kt-2.7.0/r-2.3.0/rr-1.2.8/sb-1.3.4/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bulma.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        var table = $('#dataTable').DataTable({
            dom: 'Blfrtip',
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
            pageLength: {{\App\CPU\Helpers::pagination_limit()}},
            responsive: true,
            colReorder: true,
            fixedHeader: true,
            columnDefs: [
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },
            ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 2, 'asc' ]],
            scrollY: '490px',
            scrollCollapse: true,
            initComplete: function () {
                var btns = $('.dt-button');
                btns.removeClass('dt-button');
                var that = this
                this.api().columns().every( function (e) {
                    var column = this;
                    var select = $('<input type="text" class="form-control dt-filter" placeholder="" />')
                        .appendTo( $(".theadF tr .theadFilter").eq(column.index()) )
                        .on( 'change keyup', function (e) {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            that.api().columns($(e.target).parent().index())
                                .search($(this).val())
                                .draw();
                        } );
                } );
                $(".buttons-colvis").insertAfter(".btnDeleteRow");
                $(".buttons-colvis").addClass("my-2 btn-icon-text m-2 px-2");
                $('.dataTables_filter').remove();
                $('.dataTables_length').hide();
                $('#dataTable tbody').show();
            },
            language: {
                "zeroRecords": "Nothing found - sorry",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "info":"{{Helpers::translate('Showing')}} _START_ to _END_ {{Helpers::translate('of')}} _TOTAL_ {{Helpers::translate('entries')}}",
            }
        });
        $(document).ready(function () {
            table.on('draw',function(){
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })
            table.draw();

            $(".btnDT").click(function(){
                $(".dtsb-button").addClass('btn btn-primary bg-primary btnDT')
                $(".dtsb-button").removeClass('dtsb-button')
                $(".dtsb-group").addClass("pt-2")
                $(".dtsb-delete").removeClass("btn-primary")
                $(".dtsb-delete").addClass("btn-danger bg-danger")
                $(".dtsb-dropDown").removeClass("dtsb-dropDown dtsb-italic dtsb-select")
            })
        });
        function checkAll(checked){
            if(checked){
                table.rows( ).select();
            }else{
                table.rows( ).deselect();
            }
        }
    </script>

    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        function update_lang_(key, value, location) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.language.translate-submit',[$lang])}}",
                method: 'POST',
                data: {
                    key: key,
                    value: value,
                    locations: location,
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    toastr.success('{{\App\CPU\Helpers::translate('text_updated_successfully')}}');
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function remove_key(key) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.language.remove-key',[$lang])}}",
                method: 'POST',
                data: {
                    key: key
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    toastr.success('{{\App\CPU\Helpers::translate('Key removed successfully')}}');
                    $('#lang-'+key).hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>

@endpush
