@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Pricing levels Edit'))

@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ \App\CPU\Helpers::translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\Helpers::translate('Pricing levels')}} {{ \App\CPU\Helpers::translate('Update')}}</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0 text-black-50">{{ \App\CPU\Helpers::translate('Pricing levels')}} {{ \App\CPU\Helpers::translate('Update')}}</h1>
                </div>
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.pricing_levels.update',[$b['id']])}}" method="post" enctype="multipart/form-data">
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
                            <ul class="nav nav-tabs lightSlider mb-4">
                                @foreach(Helpers::get_langs() as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                           href="#"
                                           id="{{$lang}}-link"
                                           >
                                           <img class="mx-2" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png" />
                                           {{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        <div class="row">
                            <div class="col-md-6">
                                @foreach(Helpers::get_langs() as $lang)
                                        <?php
                                        if ($b['translations'] && count($b['translations'])) {
                                            $translate = [];
                                            foreach ($b['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                    <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                        <label for="name">
                                            {{ \App\CPU\Helpers::translate('name')}} ({{strtoupper($lang)}})
                                            <a class="btn btn-primary" onclick="emptyInput(event,'.card-body','.level-name')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                        </label>
                                        <input type="text" name="name[]" value="{{Helpers::get_prop('App\Model\pricing_levels',$b['id'],'name',$lang)}}"
                                        class="form-control level-name" id="name"
                                        onchange="translateName(event,'.card-body','input[name=\'name[]\']')"
                                        placeholder="{{ \App\CPU\Helpers::translate('Ex')}} : {{ \App\CPU\Helpers::translate('LUX')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-primary float-right">{{ \App\CPU\Helpers::translate('update')}}</button>
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
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#dataTable').DataTable({
                "pageLength": {{\App\CPU\Helpers::pagination_limit()}}
            });
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
