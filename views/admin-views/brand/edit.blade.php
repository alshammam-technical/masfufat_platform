@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Brand Edit'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="row">
            <!-- Page Title -->
            <div class="col-lg-6 pt-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{route('admin.brand.list')}}">
                                {{Helpers::translate('Brands')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Edit')}}</li>
                    </ol>
                </nav>
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
                <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('brands')">
                    <i class="fa fa-clone"></i>
                </button>


                <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 "
                onclick="$('.btn-save').click()">
                    <i class="fa fa-save"></i>
                </button>

                <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                onclick="form_alert('bulk-delete','Want to delete this item ?')"
                >
                    <i class="fa fa-trash"></i>
                </button>
                <form hidden action="{{route('admin.brand.bulk-delete')}}" method="post" id="bulk-delete">
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

                                <a class="dropdown-item" href="{{route('admin.brand.bulk-export')}}">
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
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form id="brand_form" action="{{route('admin.brand.update',[$b['id'] ?? ''])}}" method="post" enctype="multipart/form-data">
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
                            <div class="col-md-4 px-0">
                                <ul class="nav nav-tabs lightSlider w-fit-content mb-0 px-6">
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
                            </div>
                        <div class="row">
                            <div class="col-md-4 pt-3">
                                @foreach(Helpers::get_langs() as $lang)
                                        <?php
                                        if (count($b['translations'])) {
                                            $translate = [];
                                            foreach ($b['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $name = $t->value;
                                                }
                                                if ($t->locale == $lang && $t->key == "image") {
                                                    $img = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                    <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                        <label class="title-color label-w-btn" for="name">
                                            {{ \App\CPU\Helpers::translate('Brand_Name')}} ({{strtoupper($lang)}})
                                            <a class="btn btn-primary" onclick="emptyInput(event,'.card-body','.brand-name')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                        </label>
                                        <input type="text" name="name[]" value="{{$name ?? ''}}"
                                                class="form-control brand-name" id="name"
                                                onchange="translateName(event,'.card-body','input[name=\'name[]\']')"
                                                placeholder="{{ \App\CPU\Helpers::translate('Ex')}} : {{ \App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>

                                        <div class="form-group">

                                            <img class="upload-img-view viewer"
                                            id="viewer"
                                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                            src="{{asset('storage/app/public/brand')}}/{{$img ?? ''}}"
                                            alt=""/>

                                            <div class="">
                                                <label class="title-color">{{\App\CPU\Helpers::translate('Brand Logo')}}</label>
                                                <span class="text-info">({{\App\CPU\Helpers::translate('ratio')}} 1:1)</span>
                                                <div class="custom-file text-left">
                                                    <input type="file" name="image[]" id="customFileEg1{{$lang}}"
                                                        class="custom-file-input customFileEg1"
                                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                    <label class="custom-file-label"
                                                        for="customFileEg1{{$lang}}">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                                <div class="form-group pt-3">
                                    <label class="title-color" for="priority">{{\App\CPU\Helpers::translate('priority')}}</label>
                                    <input class="form-control" type="number" min="0" name="priority" value="{{$b['priority']}}" />
                                </div>

                                @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                                <div class="my-4 input-group show_for_pricing_levelsc_c">
                                    <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Show brand for pricing levels')}}</span>
                                    <div class="form-control p-0 text-start " dir="auto">
                                        <select multiple class="text-dark SumoSelect-custom multiselect w-100 testselect2-custom"
                                        onchange="$('input[name=show_for_pricing_levels]').val($(this).val().toString())"
                                        >
                                            @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                                            <option @if(in_array($pl->id,explode(',',$b['show_for_pricing_levels']))) selected @endif value="{{$pl->id}}">
                                                {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$pl['id'],'name') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="show_for_pricing_levels" value="{{$b['show_for_pricing_levels']}}">
                                </div>
                                @endif

                            </div>
                            <div class="col-md-6 mb-3">

                            </div>
                        </div>

                    </form>
                    <div class="d-flex justify-content-end gap-3" hidden>
                        <button type="reset" id="reset" class="btn btn-secondary px-4" hidden>{{ \App\CPU\Helpers::translate('reset')}}</button>
                        <button onclick="check()" type="submit" class="btn btn--primary btn-primary btn-save px-4" hidden>{{ \App\CPU\Helpers::translate('update')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'brand-image-modal','width'=>1000,'margin_left'=>'-53%'])
    <!--modal-->
</div>
@endsection

@push('script')

<script>
    function check() {
        var formData = new FormData(document.getElementById('brand_form'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '{{route('admin.brand.update',[$b['id'] ?? ''])}}',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        var nm = data.errors[i].code.indexOf('.') >= 0 ? data.errors[i].code.replace('.','[')+']' : data.errors[i].code;
                        var result = nm.match(/\[(.*)\]/);
                        if(result){
                            if(!isNaN(parseInt(result[1]))){
                                nm = nm.replace(result[0],'[]')
                            }
                        }
                        if(nm == "image"){
                            $(".upload-img-view").addClass("error_required");
                        }
                        if(nm == "show_for_pricing_levels"){
                            $(".show_for_pricing_levelsc_c").addClass("error_required");
                        }
                        $("input[name='"+nm+"']").addClass("error_required");
                        $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                    }
                    toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                } else {
                    toastr.success('record updated successfully!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#brand_form').submit();
                }
            }
        });
    };
</script>

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
                    $(input).closest('.form-group').find('.viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
