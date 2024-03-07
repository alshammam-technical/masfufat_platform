@extends('layouts.back-end.app')

@section('title',\App\CPU\Helpers::translate('refund_settings'))

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
<div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
    <!-- Page Title -->
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{asset('/public/assets/back-end/img/business-setup.png')}}" alt="">
            {{\App\CPU\Helpers::translate('refund settings')}}
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


    <div class="card">
        <div class="card-header">
            <h5 class="text-center"><i class="tio-settings-outlined"></i>
                 {{\App\CPU\Helpers::translate('refund_request_after_order_within')}}
            </h5>

        </div>
        <div class="card-body">
             @php($refund_day_limit=\App\CPU\Helpers::get_business_settings('refund_day_limit'))

            <form action="{{route('admin.refund-section.refund-update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="input-label d-flex" for="name">{{\App\CPU\Helpers::translate('days')}}</label>
                            <input class="form-control col-12" type="number" name="refund_day_limit" value="{{$refund_day_limit}}" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn--primary btn-primary btn-save d-none">{{\App\CPU\Helpers::translate('submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    @if(!Helpers::module_permission_check('admin.refund-section.edit'))
    $(document).ready(function(){
        $("input,select").attr("disabled",true);
    })
    @endif
</script>
@endpush

@endsection
