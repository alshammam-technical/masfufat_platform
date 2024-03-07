@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Feature Deal Update'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 text-capitalize d-flex gap-2 align-items-center">
            <img width="20" src="{{asset('/public/assets/back-end/img/featured_deal.png')}}" alt="">
            {{\App\CPU\Helpers::translate('update_feature_deal')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.deal.update',[$deal['id']])}}" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" method="post">
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

                        @php($default_lang = json_decode($language)[0])
                        <ul class="nav nav-tabs lightSlider w-fit-content mb-4">
                            @foreach(Helpers::get_langs() as $lang)
                                <li class="nav-item text-capitalize">
                                    <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                       href="#"
                                       id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                       <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                       {{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="form-group">
                            @foreach(Helpers::get_langs() as $lang)
                                <?php
                                if (count($deal['translations'])) {
                                    $translate = [];
                                    foreach ($deal['translations'] as $t) {
                                        if ($t->locale == $lang && $t->key == "title") {
                                            $translate[$lang]['title'] = $t->value;
                                        }
                                    }
                                }
                                ?>
                                <div class="row {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <input type="text" name="deal_type" value="feature_deal"  class="d-none">
                                    <div class="col-md-12">
                                        <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('title')}}  ({{strtoupper($lang)}})</label>
                                        <input type="text" name="title[]" class="form-control" id="title"
                                               value="{{$lang==$default_lang?$deal['title']:($translate[$lang]['title']??'')}}"
                                               placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('LUX')}}"
                                               {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                            @endforeach
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('start_date')}}</label>
                                    <input type="date" value="{{date('Y-m-d',strtotime($deal['start_date']))}}" name="start_date" required
                                           class="form-control">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="name" class="title-color text-capitalize">{{ \App\CPU\Helpers::translate('end_date')}}</label>
                                    <input type="date" value="{{date('Y-m-d', strtotime($deal['end_date']))}}" name="end_date" required
                                           class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="reset" id="reset" class="btn btn-secondary">{{ \App\CPU\Helpers::translate('reset')}}</button>
                            <button type="submit" class="btn btn--primary btn-primary">{{ \App\CPU\Helpers::translate('update')}}</button>
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
        $(document).ready(function () {
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
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

@endpush
