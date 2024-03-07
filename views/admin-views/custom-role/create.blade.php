@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Create Role'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Employee_Role_Setup')}}
            </h2>
        </div>
        <!-- End Page Title -->



        <!-- Content Row -->
        @if(Helpers::module_permission_check('custom-role.create.add'))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="submit-create-role" method="post" action="{{route('admin.custom-role.store')}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="name" class="title-color">{{\App\CPU\Helpers::translate('role_name')}}</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            aria-describedby="emailHelp"
                                            placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('financial management')}}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-4 flex-wrap">
                                <label for="name" class="title-color font-weight-bold mb-0">{{\App\CPU\Helpers::translate('module_permission')}} </label>
                                <div class="form-group d-flex gap-2">
                                    <input type="checkbox" id="select_all">
                                    <label class="title-color mb-0" for="select_all">{{\App\CPU\Helpers::translate('Select_All')}}</label>
                                </div>
                            </div>

                            <ul class="nav nav-tabs lightSliderawzero w-fit-content mb-0 px-6">
                                @foreach ($pages as $key=>$page)
                                    <li class="nav-item text-capitalize w-auto text-nowrap">
                                        <a class="nav-link _link {{$key == 'Dashboard' ? 'active':''}}" href="#" id="{{str_replace(' ','',$key)}}-link">
                                            {{ Helpers::translate($key) }}
                                        </a>
                                    </li>
                                @endforeach
                                <li>
                                    <div style="min-width: 100px">

                                    </div>
                                </li>
                            </ul>

                            @foreach ($pages as $key=>$page)
                            @php($k = str_replace(' ','',$key))
                            <div class="mt-5 mx-5 {{$key != 'Dashboard' ? 'd-none':''}} _form" id="{{str_replace(' ','',$key)}}-form">
                                @isset($page['children'])
                                @foreach ($page['children'] as $kk=>$item)
                                <h3>
                                    {{ Helpers::translate($item['caption']) }}
                                </h3>
                                <div class="row">
                                    @foreach ($item['actions'] ?? [] as $i=>$action)
                                    <div class="col-sm-6 col-lg-3 px-0">
                                        <div class="form-group d-flex gap-2">
                                            <input type="checkbox" name="modules[]" value="{{$item['name'].'.'.$action}}" class="module-permission {{$k.$kk}}_chbx" id="{{$k.$kk.$action}}"
                                            @if(!$i)
                                            onchange="changeChildren(this,'.{{$k.$kk}}_chbx')"
                                            @else
                                            onchange="changeParent(this,'#{{$k.$kk.'view'}}')"
                                            @endif
                                            >
                                            <label class="title-color mb-0" for="{{$k.$kk.$action}}">
                                                @if($key == "products")
                                                    @if ($action == "enable")
                                                        {{\App\CPU\Helpers::translate('enable in market and app')}}
                                                    @elseif($action == "disable")
                                                        {{\App\CPU\Helpers::translate('diable in market and app')}}
                                                    @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                    @endif
                                                @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                                @else
                                <div class="row">
                                    @foreach ($page['actions'] ?? [] as $action)
                                    <div class="col-sm-6 col-lg-3 px-0">
                                        <div class="form-group d-flex gap-2">
                                            <input type="checkbox" name="modules[]" value="{{$page['name']}}" class="module-permission" id="{{$page['name']}}"

                                            >
                                            <label class="title-color mb-0" for="{{$page['name']}}">
                                                @if($key == "products")
                                                    @if ($action == "enable")
                                                        {{\App\CPU\Helpers::translate('enable in market and app')}}
                                                    @elseif($action == "disable")
                                                        {{\App\CPU\Helpers::translate('diable in market and app')}}
                                                    @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                    @endif
                                                @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endisset
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-md-4 col-lg-6 mb-2 mb-sm-0">
                                <h5 class="d-flex align-items-center gap-2">
                                    {{\App\CPU\Helpers::translate('Teams group list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ count($rl) }}</span>
                                </h5>
                            </div>
                            <div class="col-md-8 col-lg-6 d-flex flex-wrap flex-sm-nowrap justify-content-sm-end gap-3">
                                <!-- Search -->
                                <form action="{{url()->current()}}?search={{$search}}" method="GET" style="width: 400px">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{\App\CPU\Helpers::translate('search by role')}}"
                                               value="{{$search}}">
                                        <button type="submit" class="btn btn--primary btn-primary">{{Helpers::translate('Search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                                <div class="">
                                    <button type="button" class="btn btn-outline--primary text-nowrap" data-toggle="dropdown">
                                        <i class="tio-download-to"></i>
                                        {{Helpers::translate('Export')}}
                                        <i class="tio-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a class="dropdown-item" href="{{route('admin.custom-role.export')}}">Excel</a></li>
                                        <div class="dropdown-divider"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table" cellspacing="0"
                                    style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                <thead class="thead-light thead-50 text-capitalize table-nowrap">
                                    <tr>
                                        <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('role_name')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('created_at')}}</th>
                                        <th>{{\App\CPU\Helpers::translate('status')}}</th>
                                        <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rl as $k=>$r)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$r['name']}}</td>
                                        <td>{{date('Y/m/d',strtotime($r['created_at']))}}</td>
                                        <td>
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher_input employee-role-status"
                                                        id="{{$r['id']}}" {{$r['status'] == 1?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{route('admin.custom-role.update',[$r['id']])}}"
                                                    class="btn btn-outline--primary btn-sm square-btn"
                                                    title="{{\App\CPU\Helpers::translate('Edit') }}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a href="#"
                                                    class="btn btn-outline-danger btn-sm delete"
                                                    title="{{\App\CPU\Helpers::translate('Delete') }}" id="{{$r['id']}}">
                                                    <i class="tio-delete"></i>
                                                </a>
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
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        function changeChildren(ths,selector){
            if(!ths.checked) {
                $(selector).removeAttr('checked')
            }
        }

        function changeParent(ths,selector){
            if(ths.checked) {
                $(selector).prop('checked',1)
            }
        }


        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{ \App\CPU\Helpers::translate('Are_you_sure_delete_this_role')}}?',
                text: "{{ \App\CPU\Helpers::translate('You_will_not_be_able_to_revert_this')}}!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ \App\CPU\Helpers::translate('Yes')}}, {{ \App\CPU\Helpers::translate('delete_it')}}!',
                cancelButtonText: "{{ \App\CPU\Helpers::translate('cancel')}}",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.custom-role.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function (data) {
                            if(data !== 1){
                                toastr.error("{{ Helpers::translate('Access Denied !') }}")
                                location.reload()
                            }else{
                                toastr.success('{{ \App\CPU\Helpers::translate('Role_deleted_successfully')}}');
                                location.reload();
                            }
                        }
                    });
                }
            })
        });
    </script>
    <script>
        $("._link").click(function (e) {
            e.preventDefault();
            $("._link").removeClass('active');
            $("._form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let keyy = form_id.split("-")[0];
            console.log(keyy);
            $("#" + keyy + "-form").removeClass('d-none');
            if (keyy == 'Dashboard') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $('#submit-create-role').on('submit',function(e){

            var fields = $("input[name='modules[]']").serializeArray();
            if (fields.length === 0)
            {
                toastr.warning('{{ \App\CPU\Helpers::translate('select_minimum_one_selection_box') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                return false;
            }else{
                $('#submit-create-role').submit();
            }
        });
    </script>
    <script>
        $(document).on('change', '.employee-role-status', function () {
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
                url: "{{route('admin.custom-role.employee-role-status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == '0'){
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }else{
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                }
            });
        });
    </script>

    <script>
        $("#select_all").on('change', function (){
            if($("#select_all").is(":checked") === true){
                console.log($("#select_all").is(":checked"));
                $(".module-permission").prop("checked", true);
            }else{
                $(".module-permission").removeAttr("checked");
            }
        });
    </script>
@endpush
