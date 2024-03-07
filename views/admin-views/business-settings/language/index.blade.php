@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('languages_Setup'))

@push('css_or_js')

@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/system-setting.png')}}" alt="">
                {{\App\CPU\Helpers::translate('languages_Setup')}}
            </h2>
        </div>
        <!-- End Page Title -->



        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger mb-3" role="alert">
                    {{\App\CPU\Helpers::translate('changing_some_settings_will_take_time_to_show_effect_please_clear_session_or_wait_for_60_minutes_else_browse_from_incognito_mode')}}
                </div>

                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex">
                                    {{\App\CPU\Helpers::translate('language_table')}}
                                </h5>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="d-flex gap-10 justify-content-sm-end">
                                    <div class="col-lg-12">
                                        <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                                            <div class="d-flex">
                                            <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.product.add-new')}}">
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
                                                            <a class="dropdown-item bulk-export" href="{{route('admin.product.bulk-export')}}">
                                                                {{\App\CPU\Helpers::translate('export to excel')}}
                                                            </a>
                                                            <a class="dropdown-item bulk-import" href="{{route('admin.product.bulk-import')}}">
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
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pb-3">
                        <table class="table datatable table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th></th>
                                <th>{{ \App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{\App\CPU\Helpers::translate('language name')}}</th>
                                <th>{{\App\CPU\Helpers::translate('language Code')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('status')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('default language')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <thead class="theadF">
                                <tr>
                                    <th scope="">
                                        <input type="checkbox" class="selectAllRecords" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                                    </th>
                                    <th class="theadFilter"></th>
                                    <th class="theadFilter"></th>
                                    <th class="theadFilter"></th>
                                    <th class="theadFilter"></th>
                                    <th class="theadFilter"></th>
                                    <th style="width: 5px" class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($language=App\Model\BusinessSetting::where('type','language')->first())
                            @foreach(json_decode($language['value'],true) as $key =>$data)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                        <span class="rowId" hidden>{{$data['id']}}</span>
                                    </td>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$data['code']}}.png" />
                                        {{$data['name']}} ( {{isset($data['direction'])?$data['direction']:'ltr'}}
                                        )
                                    </td>
                                    <td>{{$data['code']}}</td>
                                    <td>
                                        <label class="switcher mx-auto">
                                            <input type="checkbox"
                                                    onclick="updateStatus('{{route('admin.business-settings.language.update-status')}}','{{$data['code']}}')"
                                                    class="switcher_input" {{$data['status']==1?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switcher mx-auto">
                                            <input type="checkbox"
                                                    onclick="window.location.href ='{{route('admin.business-settings.language.update-default-status', ['code'=>$data['code']])}}'"
                                                    class="switcher_input" {{ ((array_key_exists('default', $data) && $data['default']==true) ? 'checked': ((array_key_exists('default', $data) && $data['default']==false) ? '' : 'disabled')) }}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-seconary btn-sm dropdown-toggle"
                                                    type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-top: 0px !important">
                                                @if($data['code']!='en')
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#lang-modal-update-{{$data['code']}}">{{\App\CPU\Helpers::translate('update')}}</a>
                                                @endif
                                                <a class="dropdown-item"
                                                    href="{{route('admin.business-settings.language.translate',[$data['code']])}}">{{\App\CPU\Helpers::translate('Translate')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="lang-modal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{\App\CPU\Helpers::translate('new_language')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('admin.business-settings.language.add-new')}}" method="post"
                          style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="recipient-name"
                                               class="col-form-label">{{\App\CPU\Helpers::translate('language')}} </label>
                                        <input type="text" class="form-control" id="recipient-name" name="name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="message-text"
                                               class="col-form-label">{{\App\CPU\Helpers::translate('country_code')}}</label>
                                        <select class="form-control country-var-select w-100" name="code">
                                            @foreach(\Illuminate\Support\Facades\File::files(base_path('public/assets/front-end/img/flags')) as $path)
                                                @if(pathinfo($path)['filename'] !='en')
                                                    <option value="{{ pathinfo($path)['filename'] }}"
                                                            title="{{ asset('public/assets/front-end/img/flags/'.pathinfo($path)['filename'].'.png') }}">
                                                        {{ strtoupper(pathinfo($path)['filename']) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{\App\CPU\Helpers::translate('direction')}} :</label>
                                        <select class="form-control" name="direction">
                                            <option value="ltr">LTR</option>
                                            <option value="rtl">RTL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                            <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Add')}} <i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach(json_decode($language['value'],true) as $key =>$data)
            <div class="modal fade" id="lang-modal-update-{{$data['code']}}" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{\App\CPU\Helpers::translate('new_language')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('admin.business-settings.language.update')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="recipient-name"
                                                   class="col-form-label">{{\App\CPU\Helpers::translate('language')}} </label>
                                            <input type="text" class="form-control" value="{{$data['name']}}"
                                                   name="name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="message-text"
                                                   class="col-form-label">{{\App\CPU\Helpers::translate('country_code')}}</label>
                                            <select class="form-control country-var-select w-100" name="code">
                                                @foreach(\Illuminate\Support\Facades\File::files(base_path('public/assets/front-end/img/flags')) as $path)
                                                    @if(pathinfo($path)['filename'] !='en' && $data['code']==pathinfo($path)['filename'])
                                                        <option value="{{ pathinfo($path)['filename'] }}"
                                                                title="{{ asset('public/assets/front-end/img/flags/'.pathinfo($path)['filename'].'.png') }}">
                                                            {{ strtoupper(pathinfo($path)['filename']) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\CPU\Helpers::translate('direction')}} :</label>
                                            <select class="form-control" name="direction">
                                                <option
                                                    value="ltr" {{isset($data['direction'])?$data['direction']=='ltr'?'selected':'':''}}>
                                                    LTR
                                                </option>
                                                <option
                                                    value="rtl" {{isset($data['direction'])?$data['direction']=='rtl'?'selected':'':''}}>
                                                    RTL
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{\App\CPU\Helpers::translate('close')}}</button>
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('update')}} <i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        function updateStatus(route, code) {
            $.get({
                url: route,
                data: {
                    code: code,
                },
                success: function (data) {
                    if(data == 0){
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }else{
                        toastr.success('{{\App\CPU\Helpers::translate('status_updated_successfully')}}');
                    }
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            // color select select2
            $('.country-var-select').select2({
                templateResult: codeSelect,
                templateSelection: codeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function codeSelect(state) {
                var code = state.title;
                if (!code) return state.text;
                return "<img class='image-preview' src='" + code + "'>" + state.text;
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $(".delete").click(function (e) {
                e.preventDefault();

                Swal.fire({
                    title: '{{\App\CPU\Helpers::translate('Are you sure to delete this')}}?',
                    text: "{{\App\CPU\Helpers::translate('You will not be able to revert this')}}!",
                    showCancelButton: true,
                    confirmButtonColor: 'primary',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '{{\App\CPU\Helpers::translate("Yes, delete it")}}!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = $(this).attr("id");
                    }
                })
            });
        });

    </script>
    <script>
        function default_language_delete_alert()
        {
            toastr.warning('{{\App\CPU\Helpers::translate('default language can not be deleted! to delete change the default language first!')}}');
        }
    </script>
@endpush
