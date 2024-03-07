@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Environment_Setup'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
<div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
    <!-- Page Title -->
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/public/assets/back-end/img/system-setting.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Environment_Setup')}}
        </h2>
    </div>

    {{--  actions  --}}
    <div class="col-lg-7 d-none">
        <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
            <div class="d-flex">
            <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2 disabled" href="" disabled>
                <i class="fa fa-plus"></i>
            </a>
            <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('products')"
            disabled
            >
                <i class="fa fa-clone"></i>
            </button>

            <button disabled class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
            onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                <i class="fa fa-save"></i>
            </button>

            <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
            onclick="$('.btn-save').click()">
                <i class="fa fa-save"></i>
            </button>

            <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
            onclick="form_alert('bulk-delete','Want to delete this item ?')"
            disabled
            >
                <i class="fa fa-trash"></i>
            </button>


            <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.products-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                <i class="fa fa-th"></i>
            </button>
            <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.products-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                <i class="fa fa-table"></i>
            </button>

            <button disabled class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                <i class="fa fa-toggle"></i>
            </button>
            </div>
            <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                <div class="dropdown dropdown">
                    <button disabled aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
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

                            <a class="dropdown-item bulk-export" href="#">
                                {{\App\CPU\Helpers::translate('export to excel')}}
                            </a>
                            <a class="dropdown-item bulk-import" href="#">
                                {{\App\CPU\Helpers::translate('import from excel')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  actions end  --}}
    <!-- End Page Title -->

    <!-- Inlile Menu -->

    <!-- End Inlile Menu -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="border-bottom px-4 py-3">
                    <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                        <img width="20" src="{{asset('/public/assets/back-end/img/environment.png')}}" alt="">
                        {{\App\CPU\Helpers::translate('Environment_Information')}}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.business-settings.web-config.update-environment')}}" method="post"
                            enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('APP_NAME')}}</label>
                                    <input type="text" value="{{ env('APP_NAME') }}"
                                            name="app_name" class="form-control"
                                            placeholder="Ex : EFood" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('APP_DEBUG')}}</label>
                                    <select name="app_debug" class="form-control js-select2-custom">
                                        <option value="true" {{env('APP_DEBUG')==1?'selected':''}}>
                                            {{\App\CPU\Helpers::translate('True')}}
                                        </option>
                                        <option value="false" {{env('APP_DEBUG')==0?'selected':''}}>
                                            {{\App\CPU\Helpers::translate('False')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('APP_MODE')}}</label>
                                    <select name="app_mode" class="form-control js-select2-custom">
                                        <option value="live" {{env('APP_MODE')=='live'?'selected':''}}>
                                            {{\App\CPU\Helpers::translate('Live')}}
                                        </option>
                                        <option value="dev" {{env('APP_MODE')=='dev'?'selected':''}}>
                                            {{\App\CPU\Helpers::translate('Dev')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('APP_URL')}}</label>
                                    <input type="text" value="{{ env('APP_URL') }}"
                                            name="app_url" class="form-control"
                                            placeholder="Ex : http://localhost" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('DB_CONNECTION')}}</label>
                                    <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_CONNECTION') : '---' }}"
                                            name="db_connection" class="form-control"
                                            placeholder="Ex : mysql" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('DB_HOST')}}</label>
                                    <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_HOST') : '---' }}"
                                            name="db_host" class="form-control"
                                            placeholder="Ex : http://localhost/" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('DB_PORT')}}</label>
                                    <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_PORT') : '---' }}"
                                            name="db_port" class="form-control"
                                            placeholder="Ex : 3306" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('DB_DATABASE')}}</label>
                                    <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_DATABASE') : '---' }}"
                                            name="db_database" class="form-control"
                                            placeholder="Ex : demo_db" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('DB_USERNAME')}}</label>
                                    <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_USERNAME') : '---' }}"
                                            name="db_username" class="form-control"
                                            placeholder="Ex : root" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('DB_PASSWORD')}}</label>
                                    <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_PASSWORD') : '---' }}"
                                            name="db_password" class="form-control"
                                            placeholder="Ex : password" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('BUYER_USERNAME')}}</label>

                                    <input type="text" value="{{ env('BUYER_USERNAME') }}" class="form-control"
                                            disabled>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group" id="purchase_code_div">
                                    <label class="title-color d-flex">{{\App\CPU\Helpers::translate('PURCHASE_CODE')}}</label>
                                    <div class="input-icons">
                                        <input type="password" value="{{ env('PURCHASE_CODE') }}" class="form-control" id="purchase_code" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end flex-wrap gap-10">
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                class="btn btn--primary btn-primary px-4 btn-save d-none">{{\App\CPU\Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
