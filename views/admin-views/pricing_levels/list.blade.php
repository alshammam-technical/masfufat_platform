@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Pricing levels List'))
@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-5">
                <nav aria-label="breadcrumb" style="width:100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Pricing levels')}}</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <button class="btn btn-info my-2 btn-icon-text m-2" disabled>
                        <i class="fa fa-th"></i>
                    </button>
                    <button class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" disabled>
                        <i class="fa fa-table"></i>
                    </button>
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{ route('admin.pricing_levels.add-new') }}">
                        <i class="fa fa-plus"></i>
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
                                <a class="dropdown-item" onclick="$('').click()" href="#">
                                    <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                                </a>
                                <a class="dropdown-item" onclick="$('').click()" href="#">
                                    <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                                </a>
                                <a class="dropdown-item" onclick="$('').click()" href="#">
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
                                    <a class="dropdown-item bulk-export" href="#">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" onclick="$('').click()" href="{{route('admin.pricing_levels.bulk-import')}}">
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
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('ID')}}
                                    </th>
                                    <th scope="col">{{ \App\CPU\Helpers::translate('pricing level number')}}</th>
                                    @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                        <th scope="col">{{ \App\CPU\Helpers::translate('name')}} ({{$lang}})</th>
                                    @endforeach
                                    <th>{{\App\CPU\Helpers::translate('the status')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('default pricing level')}}</th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('action')}}
                                    </th>
                                </tr>
                                </thead>
                                <thead class="theadF">
                                    <tr>
                                        <th scope="">
                                            <input type="checkbox" onchange="checkAll(event.target.checked)" />
                                        </th>
                                        <th class="theadFilter" scope="col"></th>
                                        @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                        <th class="theadFilter" scope="col"></th>
                                        @endforeach
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>

                                @foreach($br as $k=>$b)
                                    <tr>
                                        <form class="table-editor-form" method="POST" action="{{route('admin.pricing_levels.update',[$b['id']])}}">
                                        <td>
                                            @csrf
                                            <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                            <span class="rowId" hidden>{{$b->id}}</span>
                                        </td>
                                        <td>{{$b['id']}}</td>
                                        <td>{{$b['rank']}}</td>
                                        @php($name = $b['name'])
                                        @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                        <td>
                                            <span class="spanValue" style="text-wrap:balance">
                                                {{ \App\CPU\Helpers::get_prop('App\Model\pricing_levels',$b['id'],'name',$lang) ?? $name }}
                                            </span>
                                            <input class="form-control editValue lang_value" type="text"
                                            value="{{ \App\CPU\Helpers::get_prop('App\Model\pricing_levels',$b['id'],'name',$lang) ?? $name }}"
                                            name="name[]"
                                            onchange="translateName(event,'tr','input[name=\'name[]\']')"
                                            >
                                            <a role="button" class="btn btn-primary editValue" onclick="emptyInput(event,'tr','.lang_value')">{{ Helpers::translate('Field dump') }}</a>
                                            <input type="hidden" value="{{$lang}}" name="lang[]">
                                        </td>
                                        @endforeach
                                        <td>
                                            <div class="w-100 text-center justify-content-center grid-item">
                                                <label class="switch switch-status">
                                                    <input type="checkbox" class="status status"
                                                    id="{{$b['id']}}" {{$b->enabled == 1?'checked':''}}>
                                                    <span class="slider round"></span>
                                                </label>
                                                <span hidden>{{$b->enabled ?? '0'}}</span>
                                            </div>
                                        </td>

                                        @php($def = Helpers::get_business_settings('default_pricing_level'))
                                        <td>
                                            <div class="w-100 text-center justify-content-center grid-item">
                                                <label class="switch switch-default">
                                                    <input type="checkbox" class="status default"
                                                    id="{{$b['id']}}" {{$def == $b['id']?'checked':''}}>
                                                    <span class="slider round"></span>
                                                </label>
                                                <span hidden>{{$def == $b['id'] ?? '0'}}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <a class="btn btn-primary btn-sm" title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                               href="{{route('admin.pricing_levels.update',[$b['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                        </td>
                                        </form>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <form hidden action="{{route('admin.pricing_levels.bulk-delete')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('change', '.status:not(.default)', function () {
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
                url: "{{route('admin.pricing_levels.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 0){
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }else{
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                }
            });
        });
        $(document).on('change', '.default', function () {
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
                url: "{{route('admin.pricing_levels.default-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                        location.reload()
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }
                }
            });
        });
    </script>
@endpush
