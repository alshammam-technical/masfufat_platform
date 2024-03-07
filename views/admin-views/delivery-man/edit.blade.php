@extends('layouts.back-end.app')

@section('title',\App\CPU\Helpers::translate('Update delivery-man'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/deliveryman.png')}}" width="20" alt="">
                {{\App\CPU\Helpers::translate('Update_Deliveryman')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-12 mb-3">
                <form action="{{route('admin.delivery-man.update',[$delivery_man['id']])}}" method="post"
                      enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">

                            @csrf
                            <h5 class="mb-0 page-header-title d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
                                <i class="tio-user"></i>
                                {{\App\CPU\Helpers::translate('General_Information')}}
                            </h5>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label
                                            class="title-color d-flex">{{\App\CPU\Helpers::translate('Full Name')}}</label>
                                        <input type="text" value="{{$delivery_man['f_name']}}" name="f_name"
                                               class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Full Name')}}"
                                               required>
                                    </div>


                                    <div class="form-group">
                                        <label class="title-color d-flex"
                                               for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('phone')}}</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="js-example-basic-multiple js-states js-example-responsive form-control"
                                                        name="country_code" id="colors-selector" required>
                                                    @foreach($telephone_codes as $code)
                                                        <option
                                                            value="{{ $code['code'] }}" {{ $code['code']== $delivery_man['country_code']? 'selected' : '' }}>{{ $code['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input dir="ltr" type="text" name="phone" value="{{$delivery_man['phone'] ?? '+966'}}"
                                                   class="form-control phoneInput" dir="ltr"
                                                   placeholder="{{\App\CPU\Helpers::translate('Ex : 017********')}}"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label
                                            class="title-color d-flex">{{\App\CPU\Helpers::translate('identity type')}}</label>
                                        <select name="identity_type" class="form-control" onchange='var v = $(this).val();$(".s_lbl").hide();$("."+v+"_lbl").show();'>
                                            <option
                                                value="passport" {{$delivery_man['identity_type']=='passport'?'selected':''}}>
                                                {{\App\CPU\Helpers::translate('passport')}}
                                            </option>
                                            <option
                                                value="driving_license" {{$delivery_man['identity_type']=='driving_license'?'selected':''}}>
                                                {{\App\CPU\Helpers::translate('driving license')}}
                                            </option>
                                            <option
                                                value="nid" {{$delivery_man['identity_type']=='nid'?'selected':''}}>{{\App\CPU\Helpers::translate('nid')}}
                                            </option>
                                            <option
                                                value="company_id" {{$delivery_man['identity_type']=='company_id'?'selected':''}}>
                                                {{\App\CPU\Helpers::translate('company id')}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: none" class="passport_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('passport number')}}</label>
                                        <label style="display: none" class="driving_license_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('driving_license number')}}</label>
                                        <label class="nid_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('identity number')}}</label>
                                        <label style="display: none" class="company_id_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('company_id number')}}</label>
                                        <input type="text" name="identity_number"
                                               value="{{$delivery_man['identity_number']}}"
                                               class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex : DH-23434-LS')}}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\Helpers::translate('address')}}</label>
                                        <textarea name="address" class="form-control" id="address" rows="1"
                                                  placeholder="Address">{{$delivery_man['address']}}</textarea>
                                    </div>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="d-flex mb-2 gap-2 align-items-center">
                                            <label
                                                class="title-color mb-0">{{\App\CPU\Helpers::translate('deliveryman image')}}</label>
                                            <span class="text-info">* ( {{\App\CPU\Helpers::translate('ratio')}} 1:1 )</span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" id="customFileEg1"
                                                       class="custom-file-input"
                                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label"
                                                       for="customFileEg1">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                            </div>
                                        </div>
                                        <center>
                                            <img class="upload-img-view" id="viewer"
                                                 src="{{asset('storage/app/public/delivery-man').'/'.$delivery_man['image']}}"
                                                 alt="delivery-man image"/>
                                        </center>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">

                                    <div class="form-group">
                                        <label style="display: none" class="passport_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('passport image')}}</label>
                                        <label style="display: none" class="driving_license_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('driving_license image')}}</label>
                                        <label class="nid_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('identity image')}}</label>
                                        <label style="display: none" class="company_id_lbl s_lbl title-color" for="exampleFormControlInput1">{{\App\CPU\Helpers::translate('company_id image')}}</label>
                                        <div>
                                            <div class="row" id="coba">
                                                @foreach(json_decode($delivery_man['identity_image'],true) as $img)
                                                    <div class="col-md-4 mb-3">
                                                        <img height="150"
                                                             src="{{asset('storage/app/public/delivery-man').'/'.$img}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <!-- End Page Header -->
                        <div class="card-body">
                            <h5 class="mb-0 page-header-title d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
                                <i class="tio-user"></i>
                                {{\App\CPU\Helpers::translate('Account_Information')}}
                            </h5>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\Helpers::translate('email')}}</label>
                                        <input type="email" value="{{$delivery_man['email']}}" name="email"
                                               class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex : ex@example.com')}}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{\App\CPU\Helpers::translate('password')}}</label>
                                        <input type="text" name="password" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex : password')}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            class="title-color d-flex">{{\App\CPU\Helpers::translate('confirm_password')}}</label>
                                        <input type="text" name="confirm_password" class="form-control"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex : password')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-end">
                                <button type="reset" id="reset"
                                        class="btn btn-secondary px-4">{{\App\CPU\Helpers::translate('reset')}}</button>
                                <button type="submit"
                                        class="btn btn--primary btn-primary px-4">{{\App\CPU\Helpers::translate('submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
                rowHeight: 'auto',
                groupClassName: 'col-6 col-md-4',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
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
