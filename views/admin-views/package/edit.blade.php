@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Package Edit'))

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
                    <a href="#">
                        {{Helpers::translate('Customers')}}
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{route('admin.package.list')}}">
                        {{Helpers::translate('Packages')}}
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Add')}}</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <div class="col-lg-7" style="display: none">
        <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
            <div class="d-flex">
            <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.packages-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                <i class="fa fa-th"></i>
            </button>
            <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.packages-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                <i class="fa fa-table"></i>
            </button>
            <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.package.add-new')}}">
                <i class="fa fa-plus"></i>
            </a>
            <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('packages')">
                <i class="fa fa-clone"></i>
            </button>


            <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2"
            onclick="$('.btn-save').click()">
                <i class="fa fa-save"></i>
            </button>

            <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
            onclick="form_alert('bulk-delete','Want to delete this item ?')"
            >
                <i class="fa fa-trash"></i>
            </button>
            <form hidden action="{{route('admin.package.bulk-delete')}}" method="post" id="bulk-delete">
                @csrf @method('delete')
                <input type="text" name="ids" class="ids" value="{{$b['id']}}">
                <input type="text" name="back" value="1">
            </form>
            <button disabled class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
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

                            <a class="dropdown-item bulk-export" href="{{route('admin.package.bulk-export')}}">
                                {{\App\CPU\Helpers::translate('export to excel')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.package.update',[$b['id']])}}" method="post" enctype="multipart/form-data">
                        @csrf
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
                            <div class="col-md-6 nnn">
                                @foreach(Helpers::get_langs() as $lang)
                                        <?php
                                        if (count($b['translations'])) {
                                            $translate = [];
                                            foreach ($b['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                                if ($t->locale == $lang && $t->key == "desc") {
                                                    $translate[$lang]['desc'] = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                    <div class="form-group {{$lang != session()->get('local') ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                        <label class="title-color" for="name">{{ \App\CPU\Helpers::translate('Package_Name')}} ({{strtoupper($lang)}})
                                            <a class="btn btn-primary" onclick="emptyInput(event,'.nnn','.theName')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                        </label>
                                        <input type="text" name="name[]" value="{{$lang==session()->get('local')?$b['name']:($translate[$lang]['name']??'')}}"
                                        onchange="translateName(event,'.nnn','input[name=\'name[]\']')"
                                        class="form-control theName" id="name"
                                        placeholder="{{ \App\CPU\Helpers::translate('Ex')}} : {{ \App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}
                                        />

                                        <div class="form-group">
                                            <label class="title-color" for="desc">{{ \App\CPU\Helpers::translate('Package_Description')}} ({{strtoupper($lang)}})</label>
                                            <input type="text" name="desc[]" value="{{$lang==session()->get('local')?$b['desc']:($translate[$lang]['desc']??'')}}"
                                                    class="form-control" id="desc"
                                                    onchange="translateName(event,'.nnn','input[name=\'desc[]\']')"
                                                    placeholder="{{ \App\CPU\Helpers::translate('Ex')}} : {{ \App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                        </div>
                                    </div>


                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach

                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <label class="title-color mb-0">{{ \App\CPU\Helpers::translate('Price') }}</label>
                                        </div>

                                        <input type="text" name="price" value="{{$b['price']}}"
                                            placeholder="{{ \App\CPU\Helpers::translate('Price') }}" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <label class="title-color mb-0">{{ \App\CPU\Helpers::translate('period') }} ({{Helpers::translate('in days')}})</label>
                                        </div>

                                        <input type="number" name="period" value="{{$b['period']}}"
                                            placeholder="{{ \App\CPU\Helpers::translate('period') }}" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <label class="title-color mb-0">{{ \App\CPU\Helpers::translate('package type') }}</label>
                                        </div>

                                        <select class="form-control" name="type" required>
                                            <option @if($b->type == "monthly") selected @endif value="monthly">{{ Helpers::translate('monthly') }}</option>
                                            <option @if($b->type == "yearly") selected @endif value="yearly">{{ Helpers::translate('yearly') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="title-color" for="services">{{\App\CPU\Helpers::translate('Services')}}</label>
                                    <div class="form-control p-0">
                                        <select
                                        class="SumoSelect-custom"
                                        multiple id="" required="">
                                        @foreach (\App\services_packaging::all() as $item)
                                            @php($name = $item['name'])
                                            @foreach($item['translations'] as $t)
                                                @if($t->locale == App::getLocale() && $t->key == "name")
                                                    @php($name = $t->value)
                                                @else
                                                    @php($name = $item['name'])
                                                @endif
                                            @endforeach
                                            <option @if(in_array($item['id'],explode(',',$b['services']))) selected @endif value="{{$item['id']}}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="services" value="{{$b['services']}}">
                                </div>

                                <div class="my-4 input-group pricing_levelc_c">
                                    <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('pricing level')}}</span>
                                    <div class="form-control p-0 text-start " dir="auto">
                                        <select name="pricing_level" class="text-dark SumoSelect-custom multiselect w-100 testselect2-custom"
                                        onchange="$('input[name=pricing_level]').val($(this).val().toString())"
                                        >
                                            @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                                            <option @if($pl->id == $b->pricing_level) selected @endif value="{{$pl->id}}">
                                                {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$pl['id'],'name') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="title-color" for="package">{{ \App\CPU\Helpers::translate('Package_Logo')}}</label>
                                    <span class="ml-2 text-info">{{ \App\CPU\Helpers::translate('ratio')}} 1:1</span>
                                    <div class="custom-file text-left">
                                        <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-center">
                                    <img class="upload-img-view" id="viewer"
                                        onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                                        src="{{asset('storage/app/public/package')}}/{{$b['icon']}}" alt="banner image"/>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="submit" class="btn btn--primary btn-primary btn-save px-4" hidden>{{ \App\CPU\Helpers::translate('update')}}</button>
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
            if (lang == '{{session()->get('local')}}') {
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
