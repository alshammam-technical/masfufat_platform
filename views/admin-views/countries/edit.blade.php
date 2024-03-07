@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('county Edit'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('admin.countries.list') }}">
                        {{\App\CPU\Helpers::translate('Countries')}}
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a>
                        {{\App\CPU\Helpers::translate('edit')}}
                    </a>
                </li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <div class="col-lg-7" hidden>
        <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
            <div class="d-flex">
            <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.countries.add-new')}}">
                <i class="fa fa-plus"></i>
            </a>
            <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2">
                <i class="fa fa-clone"></i>
            </button>

            <button title="{{Helpers::translate('Save')}}" class="btn ti-save btn-success my-2 btn-icon-text m-2 "
            onclick="$('.btn-save').click()">
                <i class="fa fa-save"></i>
            </button>


            <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
            onclick="form_alert('bulk-delete','Want to delete this item ?')"
            >
                <i class="fa fa-trash"></i>
            </button>
            <form hidden action="{{route('admin.countries.bulk-delete')}}" method="post" id="bulk-delete">
                @csrf @method('delete')
                <input type="text" name="ids" class="ids" value="{{$b['id']}}">
                <input type="text" name="back" value="1">
            </form>

            <button title="{{Helpers::translate('show/hide columns')}}" class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                <i class="fa fa-toggle"></i>
            </button>
            </div>
            <div class="moreOptions justify-content-center mt-2 mr-2 ml-4">
                <div class="dropdown dropdown">
                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button" style="height:43px">
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
                            <a class="dropdown-item bulk-export" href="{{route('admin.countries.bulk-export')}}">
                                {{\App\CPU\Helpers::translate('export to excel')}}
                            </a>
                            <a class="dropdown-item bulk-import" href="{{route('admin.countries.bulk-import')}}">
                                {{\App\CPU\Helpers::translate('import from excel')}}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div>
            <label class="input-group mt-2" style="height: 34px">
                <input
                type="search"
                class="form-control form-control-sm"
                placeholder="..."
                style="border-radius:0px 6px 6px 0px !important;height: 43px"
                onkeyup="globalSearch(event.target.value)"
                >
                <button class="btn search-btn btn-primary" onclick="productsDTsearch()" style="border-radius:6px 0px 0px 6px !important;margin-top:1px">
                <i class="fa fa-search"></i>
                </button>
            </label>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.countries.update',[$b['id']])}}" method="post" enctype="multipart/form-data">
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
                                    <li class="nav-item text-capitalize">
                                        <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                           href="#"
                                           id="{{$lang}}-link">
                                           <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                           {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        <div class="row">
                            <div class="col-md-6">
                                @foreach(Helpers::get_langs() as $i=>$lang)
                                    <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                        <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('Country name')}} ({{strtoupper($lang)}})
                                            <a class="btn btn-primary" onclick="emptyInput(event,'.card-body','.the-name')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                        </label>
                                        <input type="text" name="name[]" onchange="translateName(event,'.card-body','input[name=\'name[]\']')"
                                        value="{{ \App\CPU\Helpers::get_prop('App\countries',$b['id'],'name',$lang) }}"
                                                class="form-control the-name" id="name"
                                                placeholder="{{ \App\CPU\Helpers::translate('Ex')}} : {{ \App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="{{$lang}}-form">
                                    <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('Code') }}
                                    </label>
                                    <input type="text" name="code"
                                    value="{{ $b['code'] ?? '' }}" class="form-control the-name" id="code" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3" hidden>
                            <button hidden type="submit" class="btn btn--primary btn-primary btn-save px-4">{{ \App\CPU\Helpers::translate('update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'package-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
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
            console.log(lang);
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
    </script>
@endpush
