@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Employee List'))
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
                <img src="{{asset('/public/assets/back-end/img/employee.png')}}" width="20" alt="">
                {{\App\CPU\Helpers::translate('employee_list')}}
            </h2>
        </div>
        <!-- End Page Title -->



        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header flex-wrap gap-10">
                        <h5 class="mb-0 d-flex gap-2 align-items-center">
                            {{\App\CPU\Helpers::translate('employee_table')}}
                            <span class="badge badge-soft-dark radius-50 fz-12">{{$em->total()}}</span>
                        </h5>
                        <div>
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET" style="width: 330px">
                                <div class="input-group input-group-merge input-group-custom">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input type="search" name="search" class="form-control"
                                           placeholder="{{\App\CPU\Helpers::translate('search_by_name_or_email_or_phone')}}"
                                           value="{{$search}}" required>
                                    <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{route('admin.employee.add-new')}}" class="btn btn--primary btn-primary">
                                <i class="tio-add"></i>
                                <span class="text">{{\App\CPU\Helpers::translate('Add New')}}</span>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize table-nowrap">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Name')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Email')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Phone')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Role')}}</th>
                                <th>{{\App\CPU\Helpers::translate('Status')}}</th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($em as $k=>$e)
                                @if($e->role)
                                    <tr>
                                        <th scope="row">{{$k+1}}</th>
                                        <td class="text-capitalize">{{$e['name']}}</td>
                                        <td>
                                            {{$e['email']}}
                                        </td>
                                        <td>{{$e['phone']}}</td>
                                        <td>{{$e->role['name']}}</td>
                                        <td>
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher_input" id="{{$e['id']}}"
                                                       class="toggle-switch-input" {{$e->status?'checked':''}}>
                                                <span class="switcher_control"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{route('admin.employee.update',[$e['id']])}}"
                                                   class="btn btn-outline--primary btn-sm square-btn"
                                                   title="{{\App\CPU\Helpers::translate('Edit')}}">
                                                    <i class="tio-edit"></i>
                                                </a>

                                                <a href="#"
                                                    onclick="route_alert('{{route('admin.employee.delete',[$e['id']])}}','{{ Helpers::translate('Are you sure?') }}')"
                                                   class="btn btn-outline-danger btn-sm square-btn mx-1"
                                                   title="{{\App\CPU\Helpers::translate('Delete')}}">
                                                    <i class="tio-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$em->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('change', '.switcher_input', function () {
            let id = $(this).attr("id");

            let status = 0;
            if (jQuery(this).prop("checked") === true) {
                status = 1;
            }

            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure')}}?',
                text: '{{\App\CPU\Helpers::translate('want_to_change_status')}}',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{url('/')}}/admin/employee/status/"+id+"/"+status,
                        method: 'GET',
                        success: function (data) {
                            if(data == 1){
                                toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                            }else{
                                toastr.error("{{ Helpers::translate('Access Denied !') }}")
                                location.reload()
                            }
                        }
                    });
                }
            })
        });
    </script>
@endpush
