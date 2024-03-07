@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('area Add'))

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
    <div class="col-lg-6 pt-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.business-settings.web-config.index') }}">
                        {{\App\CPU\Helpers::translate('Settings')}}
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.areas.list') }}">
                        {{\App\CPU\Helpers::translate('Areas')}}
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a>
                        {{\App\CPU\Helpers::translate('add')}}
                    </a>
                </li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.areas.add-new')}}" method="post" enctype="multipart/form-data">
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
                        <ul class="nav nav-tabs lightSlider w-fit-content mb-4">
                            @foreach(Helpers::get_langs() as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" href="#"
                                        id="{{$lang}}-link">
                                        <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                        {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="row">
                            <div class="col-md-6">
                                @foreach(Helpers::get_langs() as $lang)
                                    <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                        <label for="name" class="title-color">
                                            <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                            {{ \App\CPU\Helpers::translate('area_Name')}}<span class="text-danger">*</span> ({{strtoupper($lang)}})
                                            <a class="btn btn-primary" onclick="emptyInput(event,'.card-body','.theName')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                        </label>
                                        <input type="text" name="name[]" class="form-control theName" id="name" value="" placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}} onchange="translateName(event,'.card-body','input[name=\'name[]\']')">
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach

                            </div>
                        </div>

                        <div class="input-group col-lg-6">
                            <label for="parent_id">
                                {{Helpers::translate('belongs to')}}:
                            </label>
                            <select required name="parent_id" aria-describedby="basic-addon1" value="" class="SumoSelect-custom form-control text-dark">
                                <option value=""></option>
                                @foreach (Helpers::getCountries() as $key=>$item)
                                    <option
                                        value='{{ $item->id }}'> {{Helpers::get_prop('App\countries',$item->id,'name')}} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="d-flex gap-3 justify-content-end">
                            <button type="submit" class="btn btn--primary btn-primary px-4">{{ \App\CPU\Helpers::translate('submit')}}</button>
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
                        url: "{{route('admin.areas.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('area_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
