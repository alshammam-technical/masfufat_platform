@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Subscriptions'))
@push('css_or_js')
    <style>
        .id_col{
            width: 50px !important;
            min-width: 50px !important;
            max-width: 50px !important;
        }
    </style>
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
                            <a href="#">
                                {{\App\CPU\Helpers::translate('Customers')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{\App\CPU\Helpers::translate('Subscriptions')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.countries.add-new')}}">
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
                                    <a class="dropdown-item bulk-export" href="{{route('admin.countries.bulk-export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.countries.bulk-import')}}">
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
                        <div class="row g-2 mb-2">
                            <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                                <!-- Card -->
                                <a class="order-stats order-stats_pending py-3 h-75 " href="{{route('admin.subscriptions')}}">
                                    <div class="order-stats__content">
                                        <h6 class="order-stats__subtitle">
                                            {{Helpers::translate('All')}}
                                        </h6>
                                    </div>
                                    <span class="order-stats__title">
                                        {{ \App\Model\Subscription::count() }}
                                    </span>
                                </a>
                                <!-- End Card -->
                            </div>
                            @foreach (\App\Package::where('enabled','1')->orderBy('price')->get() as $pack)
                            <div class="col-sm-6 col-lg-auto" style="width: 12.5%">
                                <!-- Card -->
                                <a class="order-stats order-stats_pending py-3 h-75 " href="{{route('admin.subscriptions')}}?pack_id={{$pack->id}}">
                                    <div class="order-stats__content">
                                        <h6 class="order-stats__subtitle">
                                            {{ \App\CPU\Helpers::get_prop('App\Package',$pack['id'],'name') }} ({{Helpers::translate($pack->type)}})
                                        </h6>
                                    </div>
                                    <span class="order-stats__title">
                                        {{ \App\Model\Subscription::where('package_id',$pack->id)->count() }}
                                    </span>
                                </a>
                                <!-- End Card -->
                            </div>
                            @endforeach
                        </div>
                        @if(Helpers::module_permission_check('admin.subscriptions.settings'))
                        <div class="card-header px-3 py-0 tx-medium my-auto tx-white bg-primary">
                            <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.settings-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
                                <h4 class="ml-2 mr-2 pt-2 text-white">
                                    <i class="fa fa-angle-down toggleAngle" style="display: none"></i>
                                    <i class="fa fa-angle-up toggleAngle"></i>
                                </h4>
                                <h4 class="mt-2 text-white">{{\App\CPU\Helpers::translate("Settings")}}</h4>
                            </div>
                        </div>
                        <div class="settings-section m-3" style="display: none">
                            <form class="row" method="POST">
                                @csrf
                                <div class="col-lg-5">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text bg-primary text-light text-start">
                                            <span class="text-start" id="basic-addon1">
                                                {{\App\CPU\Helpers::translate('Notify users')}}
                                            </span>
                                        </div>
                                        <input name="exp_notify_days" aria-describedby="basic-addon1"
                                        value="{{ Helpers::get_business_settings('exp_notify_days') ?? 5 }}"
                                        style="width: 207px;max-width: 207px"
                                        class="form-control text-center text-dark" placeholder="" type="number" required>

                                        <div class="input-group-append">
                                            <div class="input-group-text bg-primary">
                                                <span class="text-start">
                                                    {{\App\CPU\Helpers::translate('days before expiry date')}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-text bg-primary text-light text-start">
                                            <span class="text-start" id="basic-addon1">
                                                {{\App\CPU\Helpers::translate('Notify via')}}
                                            </span>
                                        </div>
                                        @php($config = Helpers::get_business_settings('exp_notify_via'))
                                        <div class="form-control text-dark m-0 p-0">
                                            <select multiple class="text-dark testselect2-custom w-100">
                                                <option @if(in_array("email",explode(',',$config) ?? [])) selected @endif value="email"> {{ \App\CPU\Helpers::translate('email') }} </option>
                                                <option @if(in_array("sms",explode(',',$config) ?? [])) selected @endif value="sms"> {{ \App\CPU\Helpers::translate('sms') }} </option>
                                                <option @if(in_array("application",explode(',',$config) ?? [])) selected @endif value="application"> {{ \App\CPU\Helpers::translate('mobile Application') }} </option>
                                                <option @if(in_array("website",explode(',',$config) ?? [])) selected @endif value="website"> {{ \App\CPU\Helpers::translate('Website') }} </option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="exp_notify_via" value="{{ $config }}">
                                    </div>

                                    <div class="input-group mb-0">
                                        <div class="input-group-text bg-primary text-light text-start">
                                            <span class="text-start" id="basic-addon1">
                                                {{\App\CPU\Helpers::translate('Notification text')}}
                                            </span>
                                        </div>
                                    </div>
                                    <textarea class="w-100" name="exp_notify_text" id="msg_description" cols="30" rows="10">{{ Helpers::get_business_settings('exp_notify_text') }}</textarea>
                                    {{--    --}}
                                    <div class="row mb-0">
                                        <div class="col-12 msg_description_c">
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <label>{{ Helpers::translate('customer name') }}</label>
                                                    <a role="button" class="btn btn-primary" onclick="insert_to_msg(document.getElementById('msg_description'),'{NAME} ')"> {NAME} </a>
                                                </div>
                                                <div class="col-4">
                                                    <label>{{ Helpers::translate('Remaining days') }}</label>
                                                    <a role="button" class="btn btn-primary" onclick="insert_to_msg(document.getElementById('msg_description'),'{remaining_days} ')"> {remaining_days} </a>
                                                </div>
                                                <div class="col-4">
                                                    <label>{{ Helpers::translate('expiry date') }}</label>
                                                    <a role="button" class="btn btn-primary" onclick="insert_to_msg(document.getElementById('msg_description'),'{DATE} ')"> {DATE} </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{--    --}}

                                    {{--  style  --}}
                                    <h4 class="mb-5 mt-10">{{\App\CPU\Helpers::translate('expiry date ntification bar')}}</h4>
                                    <div class="d-flex gap-10 align-items-center mb-2">
                                        <input type="radio" name="exp_notify_bar_status"
                                                value="1" {{Helpers::get_business_settings('exp_notify_bar_status')==1?'checked':''}}>
                                        <label class="title-color mb-0">{{\App\CPU\Helpers::translate('Active')}}</label>
                                    </div>
                                    <div class="d-flex gap-10 align-items-center mb-4">
                                        <input type="radio" name="exp_notify_bar_status"
                                                value="0" {{Helpers::get_business_settings('exp_notify_bar_status')==0?'checked':''}}>
                                        <label class="title-color mb-0">{{\App\CPU\Helpers::translate('Inactive')}}</label>
                                    </div>
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-group text-center">
                                            <label class="title-color">{{\App\CPU\Helpers::translate('background_color')}}</label>
                                            <input type="color" name="exp_notify_bg"
                                                    value="{{ Helpers::get_business_settings('exp_notify_bg') }}" id="background-color"
                                                    class="form-control form-control_color">
                                            <div class="title-color mb-4 mt-3" id="background-color-set">{{ Helpers::get_business_settings('exp_notify_bg') }}</div>
                                        </div>
                                        <div class="form-group text-center">
                                            <label class="title-color">{{\App\CPU\Helpers::translate('text_color')}}</label>
                                            <input type="color" name="exp_notify_color" id="text-color" value="{{ Helpers::get_business_settings('exp_notify_color') }}"
                                                    class="form-control form-control_color">
                                            <div class="title-color mb-4 mt-3" id="text-color-set">{{ Helpers::get_business_settings('exp_notify_color') }}</div>
                                        </div>
                                    </div>
                                    {{--  style  --}}
                                    <button class="btn btn-success w-100 mt-3">
                                        {{ Helpers::translate('Save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th scope="col" class="id_col">
                                        {{ \App\CPU\Helpers::translate('ID')}}
                                    </th>
                                    <th>
                                        {{\App\CPU\Helpers::translate('Customer')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('the package')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('start date')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('expiry date')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('remaining time')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('subscription status')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('payment method')}}
                                    </th>
                                    <th scope="col" style="width: 100px" class="text-center">
                                        {{ \App\CPU\Helpers::translate('attachment')}}
                                    </th>
                                </tr>
                                </thead>
                                <thead class="theadF">
                                    <tr>
                                        <th scope="">
                                            <input type="checkbox" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                                        </th>
                                        <th class="theadFilter id_col" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th scope="col">
                                            <select type="text" class="form-control bg-white dt-filter-custom" placeholder="">
                                                <option value=""></option>
                                                @foreach (\App\Package::where('enabled','1')->orderBy('price')->get() as $pl)
                                                @php($n = Helpers::get_prop("App\Package",$pl['id'],"name"))
                                                    <option value="{{$n}}">
                                                        {{$n}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th scope="col">
                                            <select type="text" class="form-control bg-white dt-filter-custom" placeholder="">
                                                <option></option>
                                                <option>{{\App\CPU\Helpers::translate('pending subscription')}}</option>
                                                <option>{{ Helpers::translate('paid') }}</option>
                                                <option>{{ Helpers::translate('active') }}</option>
                                                <option>{{\App\CPU\Helpers::translate('expired')}}</option>
                                                <option>{{\App\CPU\Helpers::translate('expired (upgraded)')}}</option>
                                            </select>
                                        </th>
                                        <th class="theadFilter" scope="col"></th>
                                        <th class="theadFilter" scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($subs as $k=>$sub)
                                @isset($sub->pakcage->name)
                                @isset($sub->customer['id'])
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                            <span class="rowId" hidden>{{$sub->id}}</span>
                                        </td>
                                        <td class="id_col">
                                            {{ $sub->id }}
                                        </td>
                                        <td>
                                            <a href="{{route('admin.customer.view',[$sub->customer['id']])}}">
                                                {{ $sub->customer->store_informations['company_name'] ?? 'deleted user' }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $sub->pakcage->name }}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($sub->created_at)->format('Y/m/d   H:i') }}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($sub->expiry_date)->format('Y/m/d') }}   {{ Carbon\Carbon::parse($sub->created_at)->format('H:i') }}
                                        </td>
                                        <td>
                                            @if($sub->expiry_date <= Carbon\Carbon::today())
                                            -
                                            @else
                                            {{ Carbon\Carbon::today()->diffInDays(Carbon\Carbon::parse($sub->expiry_date)) . ' ' . Helpers::translate('day/days') }}
                                            @endif
                                        </td>
                                        <td>
                                            @switch($sub->status)
                                                @case('paid')
                                                    <span class="badge text-success fz-12 px-0">
                                                        {{\App\CPU\Helpers::translate($sub->status)}}
                                                    </span>
                                                    @break
                                                @case('active')
                                                    <span class="badge text-success fz-12 px-0">
                                                        {{\App\CPU\Helpers::translate($sub->status)}}
                                                    </span>
                                                    @break
                                                @case("expired")
                                                    <span class="badge text-danger fz-12 px-0">
                                                        {{\App\CPU\Helpers::translate('expired')}}
                                                    </span>
                                                    @break
                                                @case("pending")
                                                    <span class="badge text-warning fz-12 px-0">
                                                        {{\App\CPU\Helpers::translate('pending subscription')}}
                                                    </span>
                                                    @break
                                                @case("upgraded")
                                                    <span class="badge text-dark fz-12 px-0">
                                                        {{\App\CPU\Helpers::translate('expired (upgraded)')}}
                                                    </span>
                                                    @break
                                                @default
                                                {{ $sub->status }}
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ Helpers::translate($sub->payment_method) }}
                                        </td>
                                        <td>
                                            @if (strpos($sub->payment_method, 'bank_transfer') !== false)
                                                <a target="_blank" href="{{ asset('/storage/app/public/user/').'/'.$sub->attachment }}">
                                                    {{ Helpers::translate('view') }} / {{ Helpers::translate('download') }}
                                                </a>
                                                @if ($sub->status=="pending" && Helpers::module_permission_check('admin.subscriptions.approve'))
                                                <br/>
                                                    @if(Helpers::module_permission_check('admin.subscriptions.approve'))
                                                    <button class="btn btn-primary" onclick="form_alert('approve-sub-{{$sub->id}}','{{ Helpers::translate('Approve request?') }}')">
                                                        {{ Helpers::translate('Approve') }}
                                                    </button>
                                                    <form id="approve-sub-{{$sub->id}}" action="{{route('admin.subscriptions.approve')}}">
                                                        <input type="hidden" name="id" value="{{$sub->id}}">
                                                    </form>
                                                    @endif
                                                @endif
                                            @else
                                                {{ $sub->attachment }}
                                            @endif
                                        </td>
                                    </tr>
                                @endisset
                                @endisset
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <form hidden action="{{route('admin.countries.bulk-delete')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.countries.bulk-status',['status'=>true])}}" method="post" id="bulk-enable">
                            @csrf @method('post')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.countries.bulk-status',['status'=>false])}}" method="post" id="bulk-disable">
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
                url: "{{route('admin.countries.bulk-status')}}",
                method: 'POST',
                data: {
                    ids: id,
                    status: status,
                    boolRes: true,
                },
                success: function (data) {
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

        $(".dt-filter-custom").change(function(e){
            var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
            );
            table.columns($(e.target).parent().index())
                .search($(this).val())
                .draw();
        })

        function insert_to_msg(myField,myValue){
            //IE support
            if (document.selection) {
                myField.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
            }
            //MOZILLA and others
            else if (myField.selectionStart || myField.selectionStart == '0') {
                var startPos = myField.selectionStart;
                var endPos = myField.selectionEnd;
                myField.value = myField.value.substring(0, startPos)
                    + myValue
                    + myField.value.substring(endPos, myField.value.length);
            } else {
                myField.value += myValue;
            }
        }
    </script>
@endpush
