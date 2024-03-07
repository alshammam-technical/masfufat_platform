@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Sub Sub Category'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{asset('/public/assets/back-end/img/brand-setup.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Sub Sub Category Setup')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <form action="{{route('admin.sub-sub-category.store')}}" method="POST">
                            @csrf
                            @php($language = \App\Model\BusinessSetting::where('type', 'pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')
                            @if($language)
                                @php($default_lang = json_decode($language)[0])
                                <ul class="nav nav-tabs lightSlider w-fit-content mb-4">
                                    @foreach(Helpers::get_langs() as $lang)
                                        <li class="nav-item text-capitalize">
                                            <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" href="#"
                                               id="{{$lang}}-link">
                                               <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                               {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="row">
                                    @foreach(Helpers::get_langs() as $lang)
                                        <div
                                            class="col-12 form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                            <label class="title-color"
                                                   for="exampleFormControlInput1">
                                                   <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                   {{\App\CPU\Helpers::translate('Sub_sub_category name')}}<span class="text-danger">*</span>
                                                ({{strtoupper($lang)}})</label>
                                            <input type="text" name="name[]" class="form-control"
                                                   placeholder="{{\App\CPU\Helpers::translate('New_Sub_Sub_Category')}}" {{$lang == ($default_lang ?? session()->get('local')) ? 'required':''}}>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    @endforeach
                                    @else
                                        <div class="col-12">
                                            <div class="form-group lang_form" id="{{$default_lang}}-form">
                                                <label
                                                    class="title-color">
                                                    <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                                    {{\App\CPU\Helpers::translate('Sub_sub_category name')}}<span class="text-danger">*</span>
                                                    ({{strtoupper($lang)}})</label>
                                                <input type="text" name="name[]" class="form-control"
                                                       placeholder="{{\App\CPU\Helpers::translate('New_Sub_Category')}}" required>
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{$default_lang}}">
                                        </div>
                                    @endif

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="title-color">{{\App\CPU\Helpers::translate('main category')}}
                                                <span class="text-danger">*</span></label>
                                            <select class="form-control" id="cat_id" required>
                                                <option value="" disabled selected>{{\App\CPU\Helpers::translate('Select_main_category')}}</option>
                                                @foreach(\App\Model\Category::where(['position'=>0])->get() as $category)
                                                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="title-color text-capitalize"
                                                for="name">{{\App\CPU\Helpers::translate('sub_category name')}}<span class="text-danger">*</span></label>
                                            <select required name="parent_id" id="parent_id" class="form-control">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="title-color text-capitalize" for="priority">{{\App\CPU\Helpers::translate('priority')}}
                                                <span>
                                                    <i class="tio-info-outined" title="{{\App\CPU\Helpers::translate('the_lowest_number_will_get_the_highest_priority')}}"></i>
                                                </span>
                                            </label>
                                            <select class="form-control" name="priority" id="" required>
                                                <option disabled selected>{{\App\CPU\Helpers::translate('Set_Priority')}}</option>
                                                @for ($i = 0; $i <= 10; $i++)
                                                <option
                                                value="{{$i}}" >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                                            <button type="reset" class="btn btn-secondary">{{\App\CPU\Helpers::translate('reset')}}</button>
                                            <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-20" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-5 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="text-capitalize d-flex gap-2">
                                    {{ \App\CPU\Helpers::translate('sub_sub_category_list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12">{{ $categories->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-7 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\Helpers::translate('Search_by_Sub_Sub_Category')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ \App\CPU\Helpers::translate('SL')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('sub_sub_category_name')}}</th>
                                <th>{{ \App\CPU\Helpers::translate('priority')}}</th>
                                <th class="text-center">{{ \App\CPU\Helpers::translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td>{{$category['id']}}</td>
                                    <td>{{$category['name']}}</td>
                                    <td>{{$category['priority']}}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn"
                                                title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                                href="{{route('admin.category.edit',[$category['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete square-btn"
                                                title="{{ \App\CPU\Helpers::translate('Delete')}}"
                                                id="{{$category['id']}}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{$categories->links()}}
                        </div>
                    </div>

                    @if(count($categories)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                            <p class="mb-0">{{\App\CPU\Helpers::translate('No_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
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
        $( document ).ready(function() {

            var id = $("#cat_id").val();
            if (id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.sub-sub-category.getSubCategory')}}',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        $("#parent_id").html(result);
                    }
                });
            }
        });
    </script>
    <script>
        $('#cat_id').on('change', function () {
            var id = $(this).val();
            if (id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.sub-sub-category.getSubCategory')}}',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        $("#parent_id").html(result);
                    }
                });
            }
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are_you_sure_to_delete_this?')}}',
                text: "{{\App\CPU\Helpers::translate('You_wont_be_able_to_revert_this!')}}",
                showCancelButton: true,
                type: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\Helpers::translate('Yes')}}, {{\App\CPU\Helpers::translate('delete_it')}}!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.sub-sub-category.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('Sub_Sub_Category_Deleted_Successfully')}}.');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
