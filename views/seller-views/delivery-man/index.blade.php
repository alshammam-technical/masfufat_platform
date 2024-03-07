@extends('layouts.back-end.app-seller')

@section('title',\App\CPU\Helpers::translate('Add new delivery-man'))

@push('css_or_js')

@endpush

@section('content')
@include('seller-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 17%">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/deliveryman.png')}}" alt="">
                {{\App\CPU\Helpers::translate('add_new_deliveryman')}}
            </h2>
        </div>
        <!-- End Page Title -->


        <form action="{{route('seller.delivery-man.store')}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('first name')}}</label>
                                <input type="text" value="{{old('f_name')}}" name="f_name" class="form-control" placeholder="{{\App\CPU\Helpers::translate('first name')}}"
                                        required>
                            </div>
                            <div class="form-group">
                                <label class="title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('last name')}}</label>
                                <input type="text" value="{{old('l_name')}}" name="l_name" class="form-control" placeholder="{{\App\CPU\Helpers::translate('last name')}}"
                                        required>
                            </div>
                            <div class="form-group">
                                <label class="title-color d-flex" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('phone')}}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <select class="js-example-basic-multiple js-states js-example-responsive form-control"
                                                name="country_code" id="colors-selector" required>
                                            @foreach($telephone_codes as $code)
                                                <option value="{{ $code['code'] }}">{{ $code['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" value="{{old('phone')}}" name="phone" class="form-control phoneInput" placeholder="{{\App\CPU\Helpers::translate('Ex : 017********')}}"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('identity type')}}</label>
                                <select name="identity_type" class="form-control">
                                    <option value="passport">{{\App\CPU\Helpers::translate('passport')}}</option>
                                    <option value="driving_license">{{\App\CPU\Helpers::translate('driving license')}}</option>
                                    <option value="nid">{{\App\CPU\Helpers::translate('nid')}}</option>
                                    <option value="company_id">{{\App\CPU\Helpers::translate('company id')}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('identity number')}}</label>
                                <input value="{{old('identity_number')}}" type="text" name="identity_number" class="form-control"
                                        placeholder="Ex : DH-23434-LS"
                                        required>
                            </div>
                            <div class="form-group">
                                <label class="title-color d-flex" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('address')}}</label>
                                <div class="input-group mb-3">
                                    <textarea name="address" class="form-control" id="address" rows="1" placeholder="Address">{{old('address')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('deliveryman image')}}</label>
                                <span class="text-info">* ( {{\App\CPU\Helpers::translate('ratio')}} 1:1 )</span>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="title-color custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                    <label class="custom-file-label title-color" for="customFileEg1">
                                        {{\App\CPU\Helpers::translate('choose file')}}
                                    </label>
                                </div>
                                <center class="mt-4">
                                    <img class="upload-img-view" id="viewer"
                                            src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="delivery-man image"/>
                                </center>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('identity_image')}}</label>
                                <div>
                                    <div class="row" id="coba"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('email')}}</label>
                                <input type="email" value="{{old('email')}}" name="email" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Ex : ex@example.com')}}" autocomplete="off"
                                        required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('password')}}</label>
                                <input type="text" name="password" class="form-control" placeholder="{{\App\CPU\Helpers::translate('password_minimum_8_characters')}}" autocomplete="off"
                                        required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="title-color">{{\App\CPU\Helpers::translate('confirm_password')}}</label>
                                <input type="text" name="confirm_password" class="form-control" placeholder="{{\App\CPU\Helpers::translate('password_minimum_8_characters')}}" autocomplete="off"
                                        required>
                            </div>
                        </div>
                    </div>
                    <span class="d-none" id="placeholderImg" data-img="{{asset('public/assets/back-end/img/400x400/img3.png')}}"></span>

                    <div class="d-flex gap-3 justify-content-end">
                        <button type="reset" id="reset" class="btn btn-secondary">{{\App\CPU\Helpers::translate('reset')}}</button>
                        <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('script_2')
    <script>
        $(".js-example-responsive").select2({
            width: 'resolve'
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
    </script>

    <script src="{{asset('public/assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '248px',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img3.png')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
@endpush
