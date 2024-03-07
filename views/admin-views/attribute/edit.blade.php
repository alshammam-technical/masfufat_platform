@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Attribute'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Title -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0">
                <img src="{{asset('/public/assets/back-end/img/attribute.png')}}" class="mb-1 mr-1" alt="">
                {{\App\CPU\Helpers::translate('Update attribute')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-md-12 mb-10">
                <div class="card">
                    <div class="card-body"
                         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form action="{{route('admin.attribute.update',[$attribute['id']])}}" method="post">
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
                                           id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @foreach(Helpers::get_langs() as $lang)
                                <?php
                                if (count($attribute['translations'])) {
                                    $translate = [];
                                    foreach ($attribute['translations'] as $t) {
                                        if ($t->locale == $lang && $t->key == "name") {
                                            $translate[$lang]['name'] = $t->value;
                                        }
                                    }
                                }
                                ?>
                                <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                     id="{{$lang}}-form">
                                    <input type="hidden" id="id">
                                    <label class="title-color" for="name">
                                        <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                        {{ \App\CPU\Helpers::translate('Attribute')}} {{ \App\CPU\Helpers::translate('Name')}}
                                        ({{strtoupper($lang)}})</label>
                                    <input type="text" name="name[]"
                                           value="{{$lang==$default_lang?$attribute['name']:($translate[$lang]['name']??'')}}"
                                           class="form-control" id="name"
                                           placeholder="{{\App\CPU\Helpers::translate('Enter_Attribute_Name')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                            @endforeach
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn px-4 btn-secondary">{{ \App\CPU\Helpers::translate('reset')}}</button>
                                <button type="submit" class="btn px-4 btn--primary">{{ \App\CPU\Helpers::translate('update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
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

    @endpush
