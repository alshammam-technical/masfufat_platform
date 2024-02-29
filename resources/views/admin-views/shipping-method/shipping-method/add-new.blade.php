@extends('layouts.back-end.app')

@push('css_or_js')
    <!-- Custom styles for this page -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this page -->
@endpush

@section('content')
    <div class="content container-fluid"> <!-- Page Heading -->
        <div style="display: flex; align-items: center; width: 100%;">
            <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Shipping Method')}}</li>
                </ol>
            </nav>
            <button id="help-center-button" class=" my-2 btn-icon-text m-2 btnn" style="border-radius: 10px;" target="_blank">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                width="16.000000pt" height="16.000000pt" viewBox="0 0 48.000000 48.000000"
                preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,48.000000) scale(0.100000,-0.100000)"
                fill="#000000" stroke="none">
                <path d="M20 460 c-15 -15 -20 -33 -20 -70 l0 -50 180 0 180 0 0 50 c0 84 -13
                90 -180 90 -127 0 -142 -2 -160 -20z m75 -50 c0 -18 -6 -26 -23 -28 -13 -2
                -25 3 -28 12 -10 26 4 48 28 44 17 -2 23 -10 23 -28z m100 0 c0 -18 -6 -26
                -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z m100 0 c0
                -18 -6 -26 -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z"/>
                <path d="M0 240 l0 -60 93 0 92 0 20 37 c11 21 37 47 60 60 l40 23 -152 0
                -153 0 0 -60z"/>
                <path d="M291 242 c-38 -20 -71 -73 -71 -112 0 -62 68 -130 130 -130 62 0 130
                68 130 130 0 62 -68 130 -130 130 -14 0 -41 -8 -59 -18z m93 -38 c18 -18 21
                -60 5 -69 -5 -4 -14 -18 -20 -32 -5 -13 -15 -23 -22 -20 -16 6 -11 46 10 69
                13 15 14 21 4 31 -9 9 -16 7 -29 -11 -18 -23 -32 -21 -32 4 0 19 29 44 50 44
                10 0 26 -7 34 -16z m-19 -143 c7 -12 -12 -24 -25 -16 -11 7 -4 25 10 25 5 0
                11 -4 15 -9z"/>
                <path d="M0 90 c0 -78 18 -90 134 -90 l95 0 -24 43 c-14 23 -25 54 -25 70 l0
                27 -90 0 -90 0 0 -50z"/>
                </g>
                </svg>
            </button>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{\App\CPU\Helpers::translate('shipping_method form')}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.business-settings.shipping-method.add')}}"
                              style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                              method="post">
                            @csrf
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <label for="title">{{\App\CPU\Helpers::translate('title')}}</label>
                                        <input type="text" name="title" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <label for="duration">{{\App\CPU\Helpers::translate('duration')}}</label>
                                        <input type="text" name="duration" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('4 to 6 days')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <label for="cost">{{\App\CPU\Helpers::translate('cost')}}</label>
                                        <input type="text" pattern="\d*" t="number" min="0" max="1000000" name="cost" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('10')}} ">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit"
                                        class="btn bg-primaryColor btn-primary ">{{\App\CPU\Helpers::translate('Submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\Helpers::translate('shipping_method table')}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0"
                                   style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};">
                                <thead>
                                <tr>
                                    <th scope="col">{{\App\CPU\Helpers::translate('sl#')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('title')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('duration')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('cost')}}</th>
                                    <th scope="col">{{\App\CPU\Helpers::translate('status')}}</th>
                                    <th scope="col" style="width: 50px">{{\App\CPU\Helpers::translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shipping_methods as $k=>$method)
                                    <tr>
                                        <th scope="row">{{$k+1}}</th>
                                        <td>{{$method['title']}}</td>
                                        <td>
                                            {{$method['duration']}}
                                        </td>
                                        <td>
                                            {{\App\CPU\BackEndHelper::set_symbol(($method['cost']))}}
                                        </td>

                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="status"
                                                       id="{{$method['id']}}" {{$method->status == 1?'checked':''}}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <div class="dropdown float-right">
                                                <button class="btn btn-seconary btn-sm dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="tio-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-top: 0px !important">
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.business-settings.shipping-method.edit',[$method['id']])}}">{{\App\CPU\Helpers::translate('Edit')}}</a>
                                                    <a class="dropdown-item delete" style="cursor: pointer;"
                                                       id="{{ $method['id'] }}">{{\App\CPU\Helpers::translate('Delete')}}</a>
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
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Call the dataTables jQuery plugin
        $(document).on('change', '.status', function () {
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
                url: "{{route('admin.business-settings.shipping-method.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                }
            });
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are you sure delete this')}} ?',
                text: "{{\App\CPU\Helpers::translate('You will not be able to revert this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, delete it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.business-settings.shipping-method.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('Shipping Method deleted successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
