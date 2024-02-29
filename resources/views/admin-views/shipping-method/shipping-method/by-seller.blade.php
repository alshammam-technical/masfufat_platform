@extends('layouts.back-end.app')

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this page -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #banner-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #banner-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }

        @media (max-width: 500px) {
            #banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }


        }


    </style>
@endpush

@section('content')
    <div class="content container-fluid"> <!-- Page Heading -->
        <div style="display: flex; align-items: center; width: 100%;">
            <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Shipping Method by Seller')}}</li>
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

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\Helpers::translate('shipping_method table')}} ( {{\App\CPU\Helpers::translate('Suggested')}} )</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
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
                                        <td>
                                            {{$method['title']}}<br>
                                            {{\App\CPU\Helpers::translate('By')}} : <a
                                                href="{{route('admin.sellers.view',$method->creator_id)}}">{{$method->seller->f_name??""}} {{$method->seller->l_name??""}}</a>
                                        </td>
                                        <td>
                                            {{$method['duration']}}
                                        </td>
                                        <td>
                                            {{($method['cost']) .\App\CPU\BackEndHelper::currency_symbol()}}
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
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->


    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
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
