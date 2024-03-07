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
    <div class="mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{asset('/public/assets/back-end/img/attribute.png')}}" alt="">
            {{\App\CPU\Helpers::translate('Attribute_Setup')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <!-- <div class="card-header">
                    {{ \App\CPU\Helpers::translate('Add')}} {{ \App\CPU\Helpers::translate('new')}} {{ \App\CPU\Helpers::translate('Attribute')}}
                </div> -->
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <form action="{{route('admin.attribute.store')}}" method="post">
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
                                        id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>

                        @foreach(Helpers::get_langs() as $lang)
                        <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                    id="{{$lang}}-form">
                            <input type="hidden" id="id">
                            <label class="title-color" for="name">
                                <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                {{ \App\CPU\Helpers::translate('Attribute')}} {{ \App\CPU\Helpers::translate('Name')}}<span class="text-danger">*</span>
                                    ({{strtoupper($lang)}})</label>
                            <input type="text" name="name[]" class="form-control" id="name"
                                   placeholder="{{\App\CPU\Helpers::translate('Enter_Attribute_Name')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                        </div>
                        <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                        @endforeach


                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button type="reset" class="btn btn-secondary">{{\App\CPU\Helpers::translate('reset')}}</button>
                            <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex align-items-center gap-2">{{ \App\CPU\Helpers::translate('Attribute')}} {{ \App\CPU\Helpers::translate('list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12">{{ $attributes->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\Helpers::translate('Search_by_Attribute_Name')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn--primary btn-primary">{{ \App\CPU\Helpers::translate('Search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                </div>
                <div style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ \App\CPU\Helpers::translate('SL')}}</th>
                                    <th class="text-center">{{ \App\CPU\Helpers::translate('Attribute_Name')}} </th>
                                    <th class="text-center">{{ \App\CPU\Helpers::translate('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($attributes as $key=>$attribute)
                                <tr>
                                    <td>{{$attributes->firstItem()+$key}}</td>
                                    <td class="text-center">{{$attribute['name']}}</td>
                                    <td>
                                       <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn"
                                                title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                                href="{{route('admin.attribute.edit',[$attribute['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete square-btn"
                                                title="{{ \App\CPU\Helpers::translate('Delete')}}"
                                                id="{{$attribute['id']}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                       </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <div class="d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {!! $attributes->links() !!}
                    </div>
                </div>

                @if(count($attributes)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                        <p class="mb-0">{{ \App\CPU\Helpers::translate('No_data_to_show')}}</p>
                    </div>
                @endif
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
            $('#dataTable').DataTable();
        });
    </script>
    <script>


        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are_you_sure_to_delete_this')}}?',
                text: "{{\App\CPU\Helpers::translate('You_will not_be_able_to_revert_this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes')}}, {{\App\CPU\Helpers::translate('delete_it')}}!',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.attribute.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('Attribute_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });



         // Call the dataTables jQuery plugin


    </script>
@endpush
