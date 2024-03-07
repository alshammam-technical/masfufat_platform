@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Add new notification'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{Helpers::translate('push_notification')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            @if(Helpers::module_permission_check('marketing.notification.add'))
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.notification.store')}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="title-color text-capitalize"
                                               for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('Notice title')}} </label>
                                        <input type="text" name="title" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Notice title')}}"
                                               required>
                                    </div>
                                    <input name="id" type="hidden" value="0" />
                                    <div class="form-group">
                                        <label class="title-color text-capitalize"
                                               for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('Notice text')}} </label>
                                        <textarea name="description" id="description" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="title-color text-capitalize">{{\App\CPU\Helpers::translate('Image')}} </label>
                                        <span class="text-info">({{\App\CPU\Helpers::translate('Ratio_1:1')}})</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                   for="customFileEg1">{{\App\CPU\Helpers::translate('Choose file')}}</label>
                                        </div>
                                        <center>
                                            <img class="upload-img-view mt-4" id="viewer"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{{asset('public/assets/admin/img/900x400/img1.jpg')}}"
                                                 alt="image"/>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{\App\CPU\Helpers::translate('reset')}} </button>
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Send Notification')}}  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                    {{ \App\CPU\Helpers::translate('Push_Notification_Table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $notifications->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Search by notice title')}}"
                                               aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit"
                                                class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{\App\CPU\Helpers::translate('SL')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Notice title')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Notice text')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Image')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Read by')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Status')}} </th>
                                <th>{{\App\CPU\Helpers::translate('date & time sent')}} </th>
                                <th>{{\App\CPU\Helpers::translate('Resend')}} </th>
                                <th class="text-center">{{\App\CPU\Helpers::translate('Action')}} </th>
                            </tr>

                            </thead>

                            <tbody>
                            @foreach($notifications as $key=>$notification)
                                <tr>
                                    <td>{{$notifications->firstItem()+ $key}}</td>
                                    <td>
                                        <span class="d-block">
                                            {{\Illuminate\Support\Str::limit($notification['title'],30)}}
                                        </span>
                                    </td>
                                    <td>
                                        {{\Illuminate\Support\Str::limit($notification['description'],40)}}
                                    </td>
                                    <td>
                                        <img class="min-w-75" width="75" height="75"
                                             onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                                             src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}">
                                    </td>
                                    {{--    --}}
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-outline-success square-btn btn-sm"
                                         data-id="{{ $notification->id }}" onclick="$(this).next('div').modal('toggle')">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <div class="modal fade {{session('direction')}}" id="show-modal-view{{$notification->id}}" tabindex="-1" role="dialog" aria-labelledby="show-modal-image"
                                            aria-hidden="true" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};background-color: rgb(0 0 0 / 75%);">
                                            <div class="modal-dialog  modal-lg" role="document" style="top: 10%">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="row">
                                                            <div class="col-md-12"><h5
                                                                    class="modal-title font-nameA ">{{\App\CPU\Helpers::translate('Read by')}} : </h5>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>
                                                            @foreach (explode(',',$notification->seen_by) ?? [] as $id)
                                                            @if(App\User::find($id))
                                                            <li>
                                                                {{ App\User::find($id)->name }}
                                                            </li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{--    --}}
                                    <td>
                                        <label class="switcher">
                                            <input type="checkbox" class="status switcher_input"
                                                   id="{{$notification['id']}}" {{$notification->status == 1?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($notification['created_at'])->format('Y/m/d H:i') }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-outline-success square-btn btn-sm"
                                           onclick="resendNotification(this)" data-id="{{ $notification->id }}">
                                            <i class="tio-refresh"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline--primary btn-sm edit square-btn"
                                               title="{{\App\CPU\Helpers::translate('Edit')}}"
                                               href="{{route('admin.notification.edit',[$notification['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete"
                                               title="{{\App\CPU\Helpers::translate('Delete')}}"
                                               href="javascript:"
                                               id="{{$notification['id']}}')">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <table class="mt-4">
                            <tfoot>
                            {!! $notifications->links() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
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
                url: "{{route('admin.notification.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 1){
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }else{
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                    }
                    location.reload();
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
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes, delete it')}}!',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.notification.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function (data) {
                            if(data == 1){
                                toastr.success('{{\App\CPU\Helpers::translate('notification deleted successfully')}}');
                            }else{
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        function resendNotification(t) {
            let id = $(t).data('id');

            Swal.fire({
                title: '{{\App\CPU\Helpers::translate("Are_you_sure?")}}',
                text: '{{\App\CPU\Helpers::translate('Resend_notification')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#161853',
                cancelButtonText: '{{\App\CPU\Helpers::translate("No")}}',
                confirmButtonText: '{{\App\CPU\Helpers::translate("Yes")}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route("admin.notification.resend-notification") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (res) {
                            let toasterMessage = res.success ? toastr.success : toastr.info;

                            toasterMessage(res.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            $('#count-' + id).text(parseInt($('#count-' + id).text()) + 1);
                            $("input[name=title]").val(res.title)
                            document.getElementById('description').value = res.description
                            $("input[name=id]").val(res.id)
                            $("#viewer").attr('src','{{asset('storage/app/public/notification')}}/'+res.image)
                        },
                        complete: function () {
                            $('#loading').hide();
                        }
                    });
                }
            })
        }
    </script>
@endpush
