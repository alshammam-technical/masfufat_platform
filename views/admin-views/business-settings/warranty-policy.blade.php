@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('pages setup'))

@push('css_or_js')

@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/Pages.png')}}" width="20" alt="">
                {{\App\CPU\Helpers::translate('pages setup')}}
            </h2>
        </div>

        {{--  actions  --}}
        <div class="col-lg-7 d-none">
            <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                <div class="d-flex">
                <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2 disabled" href="" disabled>
                    <i class="fa fa-plus"></i>
                </a>
                <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" onclick="addFrom('products')"
                disabled
                >
                    <i class="fa fa-clone"></i>
                </button>

                <button disabled class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
                onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                    <i class="fa fa-save"></i>
                </button>

                <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 save-btn"
                onclick="$('.btn-save').click()">
                    <i class="fa fa-save"></i>
                </button>

                <button title="{{Helpers::translate('Delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                onclick="form_alert('bulk-delete','Want to delete this item ?')"
                disabled
                >
                    <i class="fa fa-trash"></i>
                </button>


                <button disabled class="btn btn-info my-2 btn-icon-text m-2" onclick="$('.products-dataTable').addClass('gridTable');$('.dataTables_scrollBody').css('max-height','650px')">
                    <i class="fa fa-th"></i>
                </button>
                <button disabled class="btn btn-info ti-menu-alt my-2 btn-icon-text m-2" onclick="$('.products-dataTable').removeClass('gridTable');$('.dataTables_scrollBody').css('max-height',dataTables_scrollBody_height)">
                    <i class="fa fa-table"></i>
                </button>

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
                            <a aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle" data-toggle="dropdown" id="droprightMenuButton" type="button"
                            onclick='$(".dt-button-collection").remove();'>
                                <i class="ti-angle-down"></i>
                                {{\App\CPU\Helpers::translate('Import/Export')}}
                            </a>
                            <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13" style="position: absolute;will-change: transform;top: -10%;left: -100%;transform: translate3d(0px, 145px, 0px);">

                                <a class="dropdown-item" href="#">
                                    {{\App\CPU\Helpers::translate('export to excel')}}
                                </a>
                                <a class="dropdown-item bulk-import" href="#">
                                    {{\App\CPU\Helpers::translate('import from excel')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  actions end  --}}
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.pages-inline-menu')
        <!-- End Inlile Menu -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('warranty_policy')}}</h5>
                    </div>

                    <form action="{{route('admin.business-settings.warranty-policy')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <label for="value[show_in_invoice]">
                                <input type="checkbox" name="value[show_in_invoice]" value="1" id="show_in_invoice" @if(json_decode($warranty_policy->value)->show_in_invoice ?? false) checked @endif>
                                {{ \App\CPU\Helpers::translate('show in invoices') }}
                            </label>
                            <div class="px-4 pt-3">
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
                                <a class="btn btn-primary" onclick="emptyDesc()">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                <ul class="nav nav-tabs lightSlider w-fit-content mb-4">
                                    @foreach (Helpers::get_langs() as $lang)
                                        <li class="nav-item">
                                            <a class="nav-link text-capitalize lang_link {{ $lang == ($default_lang ?? session()->get('local')) ?  'active' : '' }}"
                                            href="#"
                                            id="{{ $lang }}-link">
                                                <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                {{ \App\CPU\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @foreach(Helpers::get_langs() as $lang)
                            <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                <textarea class="form-control textarea{{$lang}}" id="textarea{{$lang}}" name="value[{{$lang}}]">{{(isset($warranty_policy->value)) ? json_decode($warranty_policy->value)->$lang ?? '' : ''}}</textarea>
                            </div>
                            @endforeach

                            <div class="form-group">
                                <input class="form-control btn--primary btn-save d-none" type="submit" name="btn">
                            </div>
                        </div>
                    </form>
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
    </script>

    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        @foreach (Helpers::get_langs() as $key=>$lang)
        var editor{{$lang}} = $('.textarea{{$lang}}').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
        CKEDITOR.instances['textarea{{$lang}}'].on("blur", function(e) {
            var val = e.editor.getData();
            if(val){
                @foreach (Helpers::get_langs() as $key=>$lang)
                if(!CKEDITOR.instances['textarea{{$lang}}'].getData()){
                    $.ajax({
                        type:'post',
                        url:"{{route('home')}}/admin/g-translate/{{$lang == 'sa' ? 'ar' : $lang}}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            word: val,
                        },
                        success:function(data){
                            CKEDITOR.instances['textarea{{$lang}}'].setData(data)
                        }
                    })
                }
                @endforeach
            }
        })
        @endforeach
        function emptyDesc(){
            @foreach (Helpers::get_langs() as $key=>$lang)
                CKEDITOR.instances['textarea{{$lang}}'].setData('')
            @endforeach
        }
    </script>
    {{--ck editor--}}
@endpush


