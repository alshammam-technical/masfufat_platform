@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('cities List'))
@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="row" style="margin-top: 20px">
            <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('admin.business-settings.web-config.index') }}">
                                {{\App\CPU\Helpers::translate('Settings')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{\App\CPU\Helpers::translate('Cities')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.cities.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" disabled="disabled" onclick="addFrom('cities')">
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
                                    <a class="dropdown-item bulk-export" href="{{route('admin.cities.bulk-export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.cities.bulk-import')}}">
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
                                class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th scope="col" style="width: 100px">
                                        {{ \App\CPU\Helpers::translate('ID')}}
                                    </th>
                                    @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                    <th>{{\App\CPU\Helpers::translate('Name')}} ({{$lang}})</th>
                                    @endforeach
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('belongs to')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('active')}}
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
                                        @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                        <th class="theadFilter" scope="col"></th>
                                        @endforeach
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($cities as $k=>$b)
                                    <tr>
                                        <form class="table-editor-form" method="POST" action="{{route('admin.cities.update',[$b['id']])}}">
                                            <td>
                                                @csrf
                                                <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                                <span class="rowId" hidden>{{$b->id}}</span>
                                            </td>
                                            <td class="text-center">{{$cities->firstItem()+$k}}</td>
                                            @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                            <td>
                                                <span class="spanValue">
                                                    {{ \App\CPU\Helpers::get_prop('App\cities',$b['id'],'name',$lang) ?? $b['name'] }}
                                                </span>
                                                <input
                                                class="form-control lang_value editValue"
                                                onchange="translateName(event,'tr','input[name=\'name[]\']')"
                                                type="text"
                                                value="{{ \App\CPU\Helpers::get_prop('App\cities',$b['id'],'name',$lang) ?? $b['name'] }}"
                                                name="name[]">
                                                <a role="button" class="btn btn-primary editValue" onclick="emptyInput(event,'tr','.lang_value')">{{ Helpers::translate('Field dump') }}</a>
                                                <input type="hidden" value="{{$lang}}" name="lang[]">
                                            </td>
                                            @endforeach
                                            <td>
                                                <span class="spanValue">
                                                    {{ \App\CPU\Helpers::get_prop('App\areas',$b['parent_id'],'name') ?? $b['name'] }}
                                                </span>
                                                <div class="input-group col-lg-12 editValue">
                                                    <select
                                                    aria-describedby="basic-addon1" value="" class="SumoSelect-custom form-control text-dark"
                                                    onchange="$('.inputPrent_{{$b['id']}}').val(event.target.value)"
                                                    >
                                                        <option value=""></option>
                                                        @foreach (Helpers::getAreas() as $key=>$item)
                                                            <option
                                                            @if($item->id == $b->parent_id) selected @endif
                                                                value='{{ $item->id }}'> {{Helpers::get_prop('App\areas',$item->id,'name')}} </option>
                                                        @endforeach
                                                    </select>
                                                    <input value="{{$b->parent_id}}" type="hidden" name="parent_id" class="inputPrent_{{$b['id']}}">
                                                </div>
                                            </td>
                                            <td>
                                                <center>
                                                    <label class="switcher">
                                                        <input type="checkbox" class="switcher_input"
                                                        id="{{$b['id']}}" {{$b->enabled == 1?'checked':''}}>
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </center>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                                href="{{route('admin.cities.update',[$b['id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <form hidden action="{{route('admin.cities.bulk-delete')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.cities.bulk-status',['status'=>true])}}" method="post" id="bulk-enable">
                            @csrf @method('post')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.cities.bulk-status',['status'=>false])}}" method="post" id="bulk-disable">
                            @csrf @method('post')
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
        $(document).on('change', '.switcher_input', function () {
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
                url: "{{route('admin.cities.bulk-status')}}",
                method: 'POST',
                data: {
                    ids: id,
                    status: status,
                    boolRes: true,
                },
                success: function (data) {
                    if(data == 0){
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload();
                    }
                    if(data == true) {
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
    </script>
@endpush
