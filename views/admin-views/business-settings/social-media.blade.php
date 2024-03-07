@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Social_Media_Links setup'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 25%">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/social media.png')}}" width="20" alt="">
                {{\App\CPU\Helpers::translate('Social_Media_Links setup')}}
            </h2>
        </div>
        <!-- End Page Title -->



        <!-- Content Row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ \App\CPU\Helpers::translate('add Social_Media_Link')}}</h5>
                    </div>
                    <div class="card-body">
                        <form id="social-media-form" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <input type="hidden" id="id" name="id">
                                        <div class="input-group w-100">
                                            <label class="w-100">
                                                {{ Helpers::translate('name') }}
                                                <input type="text" name="name" class="form-control" id="name" placeholder="{{\App\CPU\Helpers::translate('Enter Social Media name')}}" required>
                                            </label>
                                        </div>
                                        <div class="input-group w-100">
                                            <label class="w-100">
                                                {{ Helpers::translate('link') }}
                                                <input type="text" name="link" class="form-control" id="link" placeholder="{{\App\CPU\Helpers::translate('Enter Social Media Link')}}" required>
                                            </label>
                                        </div>
                                        <div class="input-group w-100">
                                            <label class="w-100">
                                                {{ Helpers::translate('the logo') }}
                                                <input id="png" type="file" name="png" class="form-control">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" id="id">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-10 justify-content-end flex-wrap">
                                <a id="add" class="btn btn--primary btn-primary px-4">{{ \App\CPU\Helpers::translate('save')}}</a>
                                <a id="update" class="btn btn--primary btn-primary px-4 d--none">{{ \App\CPU\Helpers::translate('update')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <h5 class="mb-0 d-flex">{{ \App\CPU\Helpers::translate('social_media_table')}}</h5>
                    </div>
                    <div class="pb-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100" id="dataTable" cellspacing="0"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{ \App\CPU\Helpers::translate('sl')}}</th>
                                        <th>{{ \App\CPU\Helpers::translate('the logo')}}</th>
                                        <th>{{ \App\CPU\Helpers::translate('name')}}</th>
                                        <th>{{ \App\CPU\Helpers::translate('link')}}</th>
                                        <th>{{ \App\CPU\Helpers::translate('status')}}</th>
                                        {{-- <th>{{ \App\CPU\Helpers::translate('icon')}}</th> --}}
                                        <th>{{ \App\CPU\Helpers::translate('action')}}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
        fetch_social_media();

        function fetch_social_media() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.fetch')}}",
                method: 'GET',
                success: function (data) {

                    if (data.length != 0) {
                        var html = '';
                        for (var count = 0; count < data.length; count++) {
                            html += '<tr>';
                            html += '<td class="column_name" data-column_name="sl" data-id="' + data[count].id + '">' + (count + 1) + '</td>';
                            html += '<td class="column_name" data-column_name="name" data-id="' + data[count].id + '"><img width="50" onerror="this.src=\'{{asset("public/assets/front-end/img/image-place-holder.png")}}\'" src="{{asset('storage/app/public/social_logos')}}/'+data[count].png+'" /></td>';
                            html += '<td class="column_name" data-column_name="logo" data-id="' + data[count].id + '">' + data[count].name + '</td>';
                            html += '<td class="column_name" data-column_name="slug" data-id="' + data[count].id + '">' + data[count].link + '</td>';
                            html += `<td class="column_name" data-column_name="status" data-id="${data[count].id}">
                                <label class="switcher">
                                    <input type="checkbox" class="switcher_input status" id="${data[count].id}" ${data[count].active_status == 1 ? "checked" : ""} >
                                    <span class="switcher_control"></span>
                                </label>
                            </td>`;
                            @if(Helpers::module_permission_check('social-media.edit'))
                            html += '<td>';
                            @if(Helpers::module_permission_check('social-media.edit'))
                                html += '<a type="button" class="btn btn--primary btn-primary btn-xs edit" id="' + data[count].id + '"><i class="fa fa-edit text-white"></i></a>';
                            @endif
                            @if(Helpers::module_permission_check('social-media.delete'))
                            html += '<a type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fa fa-trash text-white"></i></a>';
                            @endif
                            html += '</td></tr>';
                            @endif
                            //html += '<td><a type="button" class="btn btn-outline--primary btn-xs edit square-btn" id="' + data[count].id + '"><i class="tio-edit"></i></a> </td></tr>';
                        }
                        $('tbody').html(html);
                    }
                }
            });
        }

        $('#add').on('click', function () {
            $('#add').attr("disabled", true);
            var name = $('#name').val();
            var link = $('#link').val();
            if (name == "") {
                toastr.error('{{\App\CPU\Helpers::translate('Social Name Is Requeired')}}.');
                return false;
            }
            if (link == "") {
                toastr.error('{{\App\CPU\Helpers::translate('Social Link Is Requeired')}}.');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var data = new FormData(document.getElementById('social-media-form'));
            $.ajax({
                url: "{{route('admin.business-settings.social-media-store')}}",
                method: 'POST',
                data: data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error == 1) {
                        toastr.error('{{\App\CPU\Helpers::translate('Social Media Already taken')}}');
                    } else {
                        toastr.success('{{\App\CPU\Helpers::translate('Social Media inserted Successfully')}}.');
                    }
                    $('#name').val('');
                    $('#link').val('');
                    $('#png').val('');
                    fetch_social_media();
                }
            });
        });
        $('#update').on('click', function () {
            $('#update').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#name').val();
            var link = $('#link').val();
            var icon = $('#icon').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var data = new FormData(document.getElementById('social-media-form'));
            $.ajax({
                url: "{{route('admin.business-settings.social-media-update')}}",
                method: 'POST',
                data: data,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#name').val('');
                    $('#link').val('');
                    $('#icon').val('');
                    $('#png').val('');

                    toastr.success('{{\App\CPU\Helpers::translate('Social info updated Successfully')}}.');
                    $('#update').hide();
                    $('#add').show();
                    fetch_social_media();

                }
            });
            $('#save').hide();
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            if (confirm("{{\App\CPU\Helpers::translate('Are you sure delete this social media')}}?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('admin.business-settings.social-media-delete')}}",
                    method: 'POST',
                    data: {id: id},
                    success: function (data) {
                        fetch_social_media();
                        toastr.success('{{\App\CPU\Helpers::translate('Social media deleted Successfully')}}.');
                    }
                });
            }
        });
        $(document).on('click', '.edit', function () {
            $('#update').show();
            $('#add').hide();
            var id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.business-settings.social-media-edit')}}",
                method: 'POST',
                data: {id: id},
                success: function (data) {
                    $(window).scrollTop(0);
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#link').val(data.link);
                    $('#icon').val(data.icon);
                    fetch_social_media()
                }
            });
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
                url: "{{route('admin.business-settings.social-media-status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data == 0){
                        toastr.error("{{ Helpers::translate('Access Denied !') }}")
                        location.reload()
                    }else{
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                }
            });
        });
    </script>
@endpush
