@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Update Notification'))

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
                            <a href="{{ route('admin.sms.add-new') }}">
                                {{Helpers::translate('push_sms')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{Helpers::translate('push_notification_update')}}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        <!-- End Page Title -->

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.notification.update',[$notification['id']])}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('Title')}}</label>
                                <input type="text" value="{{$notification['title']}}" name="title" class="form-control"
                                       placeholder="{{\App\CPU\Helpers::translate('New notification')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('Description')}}</label>
                                <textarea name="description" class="form-control"
                                          required>{{$notification['description']}}</textarea>
                            </div>
                            <div class="form-group text-left">
                                <label class="title-color">{{\App\CPU\Helpers::translate('Image')}}</label>
                                <span class="text-info"> ( {{\App\CPU\Helpers::translate('Ratio_1:1')}}  )</span>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{\App\CPU\Helpers::translate('Choose file')}}</label>
                                </div>
                                <center>
                                    <img class="upload-img-view mt-4"
                                        id="viewer"
                                        onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                                        src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}"
                                         alt="image"/>
                                </center>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{\App\CPU\Helpers::translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->
    </div>
    </div>

@endsection

@push('script_2')
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
    </script>
@endpush
