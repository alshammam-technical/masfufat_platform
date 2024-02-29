@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('categoriess'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .datatable * td:first-of-type,
        .datatable * th:first-of-type
        {
            width: 10px !important;
            min-width: 10px !important;
            max-width: 10px !important;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="row">
            <!-- Page Title -->
            <div class="col-lg-12 pt-0">
                <div style="display: flex; align-items: center; width: 100%;">
                    <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{\App\CPU\Helpers::translate('Training bag')}}</a></li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a>{{\App\CPU\Helpers::translate('Categories')}}</a>
                            </li>
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
            </div>
            <!-- End Page Title -->
            <div class="col-lg-7" hidden>
                <div style="display:none" class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                        @if (\App\CPU\Helpers::module_permission_check('education_categoriess_stores.add'))
                    <a title="{{Helpers::translate('Add new')}}" class="btn btn-success my-2 btn-icon-text m-2"
                    href="{{route('admin.store-education.back-end.categories.add')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    @endif
                    @if (\App\CPU\Helpers::module_permission_check('education_categoriess_stores.delete'))
                    <button title="{{Helpers::translate('delete')}}" class=" btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    onclick="form_alert('categories-bulk-delete','Are you sure ?')"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Card -->
        <div class="card">
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                    style="text-align: {{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}};"
                    class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>{{\App\CPU\Helpers::translate('SL')}}</th>
                        <th>{{\App\CPU\Helpers::translate('Category Name')}}</th>
                        <th>{{\App\CPU\Helpers::translate('Numbers of Articles')}}</th>
                        <th>{{\App\CPU\Helpers::translate('Published date')}}</th>
                        <th class="text-center">{{\App\CPU\Helpers::translate('Action')}}</th>
                    </tr>
                    </thead>

                    <thead class="theadF">
                    <tr>
                        <th scope="">
                            <input type="checkbox" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                        </th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                        <th class="theadFilter" scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $key=>$category)
                        <tr>
                            <td>
                                <form class="table-editor-form" method="POST"
                                action="{{route('admin.customer.update',['id'=>$category['id'],'bool_r'=>1])}}"
                                enctype="multipart/form-data"
                                >
                                @csrf
                                <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                <span class="rowId" hidden>{{$category->id}}</span>
                            </td>
                            <td>
                                {{$key + 1}}
                            </td>
                            <td><a class="title-color hover-c1 d-flex align-items-center gap-10 spanValue"
                                href="{{ route('admin.store-education.back-end.categories.edit', $category->id) }}" style="justify-content: center;">{{ $category->name }}</a>
                            </td>
                            @php($art_count = \App\article::where('category_id',$category->id)->count())
                            <td><a href="#"><span class="title-color hover-c1 d-flex align-items-center gap-10 spanValue" style="justify-content: center;">{{ $art_count }}</span></a></td>
                            <td><a href="#"><span class="title-color hover-c1 d-flex align-items-center gap-10 spanValue" style="justify-content: center;">{{ $category->created_at }}</span></a></td>


                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a title="{{\App\CPU\Helpers::translate('View')}}"
                                           class="btn btn-white border-0" target="_blank"
                                           href="{{ route('admin.store-education.category', $category->slug) }}">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.5799 11.9999C15.5799 13.9799 13.9799 15.5799 11.9999 15.5799C10.0199 15.5799 8.41992 13.9799 8.41992 11.9999C8.41992 10.0199 10.0199 8.41992 11.9999 8.41992C13.9799 8.41992 15.5799 10.0199 15.5799 11.9999Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M11.9998 20.2702C15.5298 20.2702 18.8198 18.1902 21.1098 14.5902C22.0098 13.1802 22.0098 10.8102 21.1098 9.40021C18.8198 5.80021 15.5298 3.72021 11.9998 3.72021C8.46984 3.72021 5.17984 5.80021 2.88984 9.40021C1.98984 10.8102 1.98984 13.1802 2.88984 14.5902C5.17984 18.1902 8.46984 20.2702 11.9998 20.2702Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                        @if (\App\CPU\Helpers::module_permission_check('education_categoriess_stores.edit'))
                                        <a title="{{\App\CPU\Helpers::translate('Edit')}}"
                                           class="btn btn-white border-0"
                                           href="{{ route('admin.store-education.back-end.categories.edit', [$category['id']]) }}">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.0399 3.01976L8.15988 10.8998C7.85988 11.1998 7.55988 11.7898 7.49988 12.2198L7.06988 15.2298C6.90988 16.3198 7.67988 17.0798 8.76988 16.9298L11.7799 16.4998C12.1999 16.4398 12.7899 16.1398 13.0999 15.8398L20.9799 7.95976C22.3399 6.59976 22.9799 5.01976 20.9799 3.01976C18.9799 1.01976 17.3999 1.65976 16.0399 3.01976Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                        </a>
                                        @endif
                                        @if (\App\CPU\Helpers::module_permission_check('education_categoriess_stores.delete'))
                                        <a title="{{\App\CPU\Helpers::translate('Delete')}}"
                                           class="btn btn-white border-0 delete-category" data-id="{{ $category['id'] }}" title="{{\App\CPU\Helpers::translate('Delete')}}" href="javascript:void(0)">
                                           <svg width="36" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.75 4.48486C13.2525 4.23736 10.74 4.10986 8.235 4.10986C6.75 4.10986 5.265 4.18486 3.78 4.33486L2.25 4.48486" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.375 3.7275L6.54 2.745C6.66 2.0325 6.75 1.5 8.0175 1.5H9.9825C11.25 1.5 11.3475 2.0625 11.46 2.7525L11.625 3.7275" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.1373 6.85498L13.6498 14.4075C13.5673 15.585 13.4998 16.5 11.4073 16.5H6.5923C4.4998 16.5 4.4323 15.585 4.3498 14.4075L3.8623 6.85498" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.74756 12.375H10.2451" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.125 9.375H10.875" stroke="#FF000F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <form hidden action="{{route('admin.store-education.back-end.categories-bulk-delete')}}" method="post" id="categories-bulk-delete">
                @csrf
                @method('delete')
                <input type="text" name="ids" class="ids">
                <input type="text" name="not_ids" class="not_ids">
            </form>

            <!-- End Table -->



            @if(count($categories)==0)
                <div class="text-center p-4">
                    <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                         alt="Image Description">
                    <p class="mb-0">{{\App\CPU\Helpers::translate('No data to show')}}</p>
                </div>
        @endif
        <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
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
                        url: "{{route('admin.customer.status-update')}}",
                        method: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function (data) {
                            if(data == 1){
                                toastr.success('{{\App\CPU\Helpers::translate('notification deleted successfully')}}');
                            }else if(data == 0){
                                toastr.error("{{ Helpers::translate('Access Denied !') }}")
                            }
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.delete-category').click(function(){
                var id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var url = "{{ route('admin.store-education.back-end.categories.delete') }}";

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                        });
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "id": id
                            },
                            success: function(response){
                                if(response == 1){
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    );
                                    setTimeout(function(){
                                        location.reload();
                                    }, 3000);
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the category.',
                                        'error'
                                    )
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>


@endpush
