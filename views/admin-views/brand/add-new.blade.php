@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Brand Add'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3 col-lg-5">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/brand.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Brand Setup')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="col-lg-7">
            <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                <div class="d-flex">
                <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.brands-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                    <i class="fa fa-th"></i>
                </button>
                <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.brands-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                    <i class="fa fa-table"></i>
                </button>
                <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.brand.add-new')}}">
                    <i class="fa fa-plus"></i>
                </a>
                <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" disabled>
                    <i class="fa fa-clone"></i>
                </button>

                <button disabled class="btn ti-save btn-success my-2 btn-icon-text m-2 " style="display: none"
                onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                    <i class="fa fa-save"></i>
                </button>

                <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 "
                onclick="$('.btn-save').click()">
                    <i class="fa fa-save"></i>
                </button>

                <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                disabled
                >
                    <i class="fa fa-trash"></i>
                </button>

                <button title="{{Helpers::translate('show/hide columns')}}"  disabled class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                    <i class="fa fa-toggle"></i>
                </button>
                </div>
                <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                    <div class="dropdown dropdown">
                        <button disabled aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
                            <i class="ti-bag"></i>
                        </button>
                        <div aria-labelledby="droprightMenuButton" class="dropdown-menu">
                            <a class="dropdown-item" href="#"
                            onclick="form_alert('bulk-enable','Are you sure ?')"
                            >
                                <i class="ti-check"></i>{{\App\CPU\Helpers::translate('enable')}}
                            </a>
                            <a class="dropdown-item" href="#"
                            onclick="form_alert('bulk-disable','Are you sure ?')"
                            >
                                <i class="ti-close"></i>{{\App\CPU\Helpers::translate('diable')}}
                            </a>
                            <a class="dropdown-item" href="#" onclick="stateClear()">
                                <i class=""></i> {{\App\CPU\Helpers::translate('Restore Defaults')}}
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="ti-reload"></i>{{\App\CPU\Helpers::translate('refresh')}}
                            </a>
                            <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle bulk-import-export" data-toggle="dropdown" id="droprightMenuButton" type="button"
                            onclick='$(".dt-button-collection").remove();'>
                                <i class="ti-angle-down"></i>
                                {{\App\CPU\Helpers::translate('Import/Export')}}
                            </a>
                            <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">

                                <a class="dropdown-item bulk-export" href="{{route('admin.brand.bulk-export')}}">
                                    {{\App\CPU\Helpers::translate('export to excel')}}
                                </a>
                                <a class="dropdown-item bulk-import" href="{{route('admin.brand.bulk-import')}}">
                                    {{\App\CPU\Helpers::translate('import from excel')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.brand.add-new')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @php
                                                $language=\App\Model\BusinessSetting::where('type','pnc_language')->first();
                                                $language = $language->value ?? null;
                                                $language = json_decode($language);
                                                $default_lang = session()->get('local');
                                                if (($key = array_search($default_lang, $language)) !== false) {
                                                    unset($language[$key]);
                                                }
                                                array_unshift($language,$default_lang);
                                                $language = json_encode($language);
                                            @endphp
                        <div class="col-md-4">
                            <ul class="nav nav-tabs lightSlider w-fit-content mb-0 px-6">
                                @foreach(Helpers::get_langs() as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" href="#"
                                            id="{{$lang}}-link">
                                            <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                            {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                @foreach(Helpers::get_langs() as $lang)
                                    <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                        <label for="name" class="title-color label-w-btn">
                                            <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                            {{ \App\CPU\Helpers::translate('Brand_Name')}}<span class="text-danger">*</span> ({{strtoupper($lang)}})
                                            <a class="btn btn-primary" onclick="emptyInput(event,'.card-body','.brand-name')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                        </label>
                                        <input type="text" name="name[]" onchange="translateName(event,'.card-body','input[name=\'name[]\']')" class="form-control brand-name" id="name" value="" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                                <div class="form-group">
                                    <label for="name" class="title-color">{{ \App\CPU\Helpers::translate('Brand_Logo')}}<span class="text-danger">*</span></label>
                                    <span class="ml-1 text-info">( {{\App\CPU\Helpers::translate('ratio')}} 1:1 )</span>
                                    <div class="custom-file text-left" required>
                                        <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="text-center">
                                    <img class="upload-img-view" id="viewer"
                                        src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex gap-3 justify-content-end">
                            <button type="reset" id="reset" class="btn btn-secondary px-4">{{ \App\CPU\Helpers::translate('reset')}}</button>
                            <button type="submit" class="btn btn--primary btn-primary btn-save px-4">{{ \App\CPU\Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')


    <script>
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];

            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

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

        $("#customFileUpload").change(function () {
            readURL(this);
        });


        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('are_you_sure?')}}',
                text: "{{\App\CPU\Helpers::translate('You_will_not_be_able_to_revert_this!')}}",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes delete_it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.brand.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('Brand_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
