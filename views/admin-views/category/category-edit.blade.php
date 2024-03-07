@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Category'))

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
                            <a href="{{route('admin.category.view')}}">
                                {{Helpers::translate('categories')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('Edit')}}</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="col-lg-7" hidden>
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.categories-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                        <i class="fa fa-th"></i>
                    </button>
                    <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.categories-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                        <i class="fa fa-table"></i>
                    </button>
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.category.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('categories')">
                        <i class="fa fa-clone"></i>
                    </button>


                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
                    onclick="$('.btn-save').click()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    @if(isset($category['id']))
                    onclick="form_alert('bulk-delete','Want to delete this item ?')"
                    @else
                    disabled
                    @endif
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <form hidden action="{{route('admin.category.bulk-delete')}}" method="post" id="bulk-delete">
                        @csrf @method('delete')
                        <input type="text" name="ids" class="ids" value="{{$category['id']}}">
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
                                    <a class="dropdown-item bulk-export" href="{{route('admin.category.bulk-export')}}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{route('admin.category.bulk-import')}}">
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
                    <!-- <div class="card-header">
                        {{ \App\CPU\Helpers::translate('category_form')}}
                    </div> -->
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form id="category_form"
                         action="{{route('admin.category.update',[$category['id'] ?? ''])}}" method="POST" enctype="multipart/form-data">
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
                            </div>
                            <div class="row">
                                <div class="{{ $category['parent_id']==0 ? 'col-lg-4':'col-4' }}">
                                    <ul class="nav nav-tabs lightSliderr w-fit-content mb-0 px-6">
                                        @foreach(Helpers::get_langs() as $lang)
                                            <li class="nav-item text-capitalize">
                                                <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                                href="#"
                                                id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @foreach(Helpers::get_langs() as $lang)
                                    <div>
                                        <?php
                                        if (count($category['translations'])) {
                                            $translate = [];
                                            foreach ($category['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $name = $t->value;
                                                }
                                                if ($t->locale == $lang && $t->key == "image") {
                                                    $img = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form mt-3"
                                            id="{{$lang}}-form">
                                            <label class="title-color label-w-btn">
                                                <img class="ml-2 mb-1" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                {{\App\CPU\Helpers::translate('Category_Name')}}
                                                ({{strtoupper($lang)}})
                                                <a class="btn btn-primary" onclick="emptyInput(event,'.card-body','.category-name')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                            </label>
                                            <input type="text" name="name[]"
                                                onchange="translateName(event,'.card-body','input[name=\'name[]\']')"
                                                value="{{$name ?? null}}"
                                                class="form-control category-name"
                                                placeholder="{{\App\CPU\Helpers::translate('New Category')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>

                                                <div class="form-group">

                                                    <img class="upload-img-view viewer"
                                                    id="viewer"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset('storage/app/public/category')}}/{{$img ?? ''}}"
                                                    alt=""/>

                                                    <div class="">
                                                        <label class="title-color">{{\App\CPU\Helpers::translate('Category Logo')}}</label>
                                                        <span class="text-info">({{\App\CPU\Helpers::translate('ratio')}} 1:1)</span>
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="image[]" id="customFileEg1"
                                                                class="custom-file-input customFileEg1"
                                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <label class="custom-file-label"
                                                                for="customFileEg1">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <img class="upload-img-view viewer2"
                                                    id="viewer2"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset('storage/app/public/category')}}/{{Helpers::get_prop('App\Model\Category',$category['id'],'icon',$lang)}}"
                                                    alt=""/>

                                                    <div class="">
                                                        <label class="title-color">{{\App\CPU\Helpers::translate('Category icon')}}</label>
                                                        <span class="text-info">({{\App\CPU\Helpers::translate('ratio')}} 1:1)</span>
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="icon[]" id="customFileEg2"
                                                                class="custom-file-input customFileEg2"
                                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <label class="custom-file-label"
                                                                for="customFileEg2">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    </div>
                                    @endforeach

                                    <div class="form-group pt-3">
                                        <label class="title-color" for="priority">{{\App\CPU\Helpers::translate('priority')}}</label>
                                        <input class="form-control" type="number" min="0" name="priority" value="{{$category['priority']}}" />
                                    </div>

                                    @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                                    <div class="my-4 input-group show_for_pricing_levelsc_c">
                                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Show category for pricing levels')}}</span>
                                        <div class="form-control p-0 text-start " dir="auto">
                                            <select multiple class="text-dark SumoSelect-custom multiselect w-100 testselect2-custom"
                                            onchange="$('input[name=show_for_pricing_levels]').val($(this).val().toString())"
                                            >
                                                @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                                                <option @if(in_array($pl->id,explode(',',$category['show_for_pricing_levels']))) selected @endif value="{{$pl->id}}">
                                                    {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$pl['id'],'name') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="show_for_pricing_levels" value="{{$category['show_for_pricing_levels']}}">
                                    </div>
                                    @endif
                                </div>



                                <div class="col-lg-6 mt-5">
                                    <div class="form-group d-flex gap-2">
                                        <input type="checkbox" value="1" class="module-permission"
                                        @if(!!$category['parent_id']) checked @endif
                                        onchange="$('.parent_id_select').toggle();if(event.target.checked){$('.parent_id_select option').removeAttr('selected');$('.parent_id_select option:first').attr('selected',true)}"
                                        >
                                        <label class="title-color mb-0" style=";">{{\App\CPU\Helpers::translate('is sub category')}}</label>
                                    </div>

                                    <div class="form-group parent_id_select" @if(!$category['parent_id']) style="display: none" @endif>
                                        <label class="title-color"
                                                for="exampleFormControlSelect1">{{\App\CPU\Helpers::translate('main category')}}
                                            <span class="text-danger">*</span></label>
                                        <select id="exampleFormControlSelect1" name="parent_id"
                                                class="form-control" required>
                                            <option value="0" selected disabled>{{\App\CPU\Helpers::translate('Select_main_category')}}</option>
                                            @foreach(\App\Model\Category::where('id','<>',$category['id'])->get() as $categoryy)
                                                <option @if($categoryy['id'] == $category['parent_id']) selected @endif value="{{$categoryy['id']}}">
                                                    {{\App\CPU\Helpers::getItemName('categories','name',$categoryy['id'])}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>



                        </form>
                        <div class="d-flex justify-content-end gap-3 d-none" hidden style="display: none">
                            <button type="reset" id="reset" class="btn btn-secondary px-4 d-none">{{ \App\CPU\Helpers::translate('reset')}}</button>
                            <button onclick="check()" type="submit" class="btn btn--primary btn-primary px-4 btn-save d-none">{{ \App\CPU\Helpers::translate('update')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function check() {
            var formData = new FormData(document.getElementById('category_form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.category.update',[$category['id'] ?? ''])}}',
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
                                $(".viewer").addClass("error_required");
                            }
                            if(nm == "icon"){
                                $(".viewer2").addClass("error_required");
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
                        $('#category_form').submit();
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

        @php($dir = session()->get('direction'))
        if($(".lightSliderr").hasClass("lightSlider")){}else{
            $(".lightSliderr").lightSlider({
                rtl: {{ ($dir == 'rtl') ? 'true' : 'false' }},
                enableDrag:true,
                enableTouch:true,
                freeMove:true,
                pager:false,
                prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'right' : 'left' }}'></i></button>",
                nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'left' : 'right' }}'></i></button>",
            });
        }
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

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).closest('.form-group').find('.viewer2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".customFileEg2").change(function () {
            readURL2(this);
        });
    </script>
@endpush
