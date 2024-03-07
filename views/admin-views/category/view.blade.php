@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Category'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-lg-6 pt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{\App\CPU\Helpers::translate('categories')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6">
                <div class="d-flex table-actions flex-wrap justify-content-end mx-3">
                    <div class="d-flex">
                    <a title="{{Helpers::translate('Add new')}}" class="btn ti-plus btn-success my-2 btn-icon-text m-2" href="{{route('admin.category.add-new')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <button title="{{Helpers::translate('Add from')}}" class="btn btn-info mdi mdi-arrange-bring-forward btnAddFrom my-2 btn-icon-text m-2" disabled onclick="addFrom('categories')">
                        <i class="fa fa-clone"></i>
                    </button>

                    <button title="{{Helpers::translate('Save')}}" class="btn ti-save btn-success my-2 btn-icon-text m-2 save-btn" style="display: none"
                    onclick="$('.table').removeClass('editMode');$('.edit-btn').show();$(this).hide();saveTableChanges()">
                        <i class="fa fa-save"></i>
                    </button>

                    <button title="{{Helpers::translate('Edit')}}" class="btn btn-info my-2 btn-icon-text m-2 edit-btn"
                    onclick="$('.table').addClass('editMode');$('.save-btn').show();$(this).hide()">
                        <i class="fa fa-pencil"></i>
                    </button>

                    <button title="{{Helpers::translate('delete')}}" class="btnDeleteRow btn ti-trash btn-danger my-2 btn-icon-text m-2"
                    onclick="form_alert('bulk-delete','Want to delete this item ?')"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                    <button title="{{Helpers::translate('show/hide columns')}}" class="btn buttons-collection dropdown-toggle buttons-colvis d-none btn-primary my-2 btn-icon-text m-2">
                        <i class="fa fa-toggle"></i>
                    </button>
                    @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                    <form class="form-control p-0 text-start mt-2 d-flex bulk-pricing-form" dir="auto" style="width: 300px" method="POST" action="{{route('admin.category.bulk-pricing_levels')}}">
                        @csrf
                        <button title="{{ Helper::translate('delete pricing levels for selected items') }}" class="btn btn-info"><i class="fa fa-close"></i></button>
                        <select multiple class="text-dark SumoSelect-custom w-100 testselect2-custom"
                        onchange="$('input[name=show_for_pricing_levels]').val($(this).val().toString());$(this).closest('form').submit();"
                        >
                            @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                            <option value="{{$pl->id}}">
                                {{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl->id,'name') }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="show_for_pricing_levels">
                        <input type="hidden" name="ids" class="ids">
                    </form>
                    @endif
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
                                    <a class="dropdown-item bulk-export" href="{{ route('admin.category.bulk-export') }}">
                                        {{\App\CPU\Helpers::translate('export to excel')}}
                                    </a>
                                    <a class="dropdown-item bulk-export" href="{{ route('admin.category.pdf') }}">
                                        {{\App\CPU\Helpers::translate('export to pdf')}}
                                    </a>
                                    <a class="dropdown-item bulk-import" href="{{ route('admin.category.bulk-import') }}">
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
        </div>

        <!-- Content Row -->
        <div class="row" style="margin-top: 20px" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th style="width: 100px">{{ \App\CPU\Helpers::translate('category ID')}}</th>
                                    <th>{{ \App\CPU\Helpers::translate('Category Icon')}}</th>
                                    <th>{{ \App\CPU\Helpers::translate('image')}}</th>
                                    <th>{{\App\CPU\Helpers::translate('priority')}}</th>
                                    @php($default_lang = session()->get('local'))
                                    @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                    <th>{{ \App\CPU\Helpers::translate('name')}} ({{$lang}})</th>
                                    @endforeach
                                    <th>{{ \App\CPU\Helpers::translate('home_status')}}</th>
                                    <th class="text-center" style="width:15%;">{{ \App\CPU\Helpers::translate('action')}}</th>
                                </tr>
                                </thead>

                                <thead class="theadF">
                                    <tr>
                                        <th scope="">
                                            <input type="checkbox" class="selectAllRecords" onchange="checkAll(event.target.checked)" />
                                        </th>
                                        <th class="theadFilter"></th>
                                        <th></th>
                                        <th></th>
                                        <th class="theadFilter"></th>
                                        @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                        <th class="theadFilter"></th>
                                        @endforeach
                                        <th class="theadFilter"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($categories as $key=>$category)
                                    <tr>
                                        <form class="table-editor-form" method="POST" action="{{route('admin.category.update',[$category['id']])}}">
                                        <td>
                                            @csrf
                                            <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
                                            <span class="rowId" hidden>{{$category->id}}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin.category.edit',[$category['id']])}}">
                                                {{$category['id']}}
                                            </a>
                                        </td>
                                        <td>
                                            <img class="rounded" width="64"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'icon',session()->get('local')) ?? null))}}" />

                                            <div class="custom-file editValue w-100" style="text-align: left">
                                                <input type="file" name="icon[]" id="customFileUpload" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <img class="rounded" width="64"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 src="{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'image',session()->get('local')) ?? $category->icon))}}" />

                                            <div class="custom-file editValue w-100" style="text-align: left">
                                                <input type="file" name="image[]" id="customFileUpload" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('choose file')}}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="spanValue">{{$category['priority']}}</span>
                                            <input class="form-control editValue" type="number" min="0" name="priority" value="{{$category['priority']}}" />
                                        </td>
                                        @php($name = $category['name'])
                                        @foreach(\App\CPU\Helpers::get_langs() as $lang)
                                        <td>
                                            <span class="spanValue">
                                                <a href="{{route('admin.category.edit',[$category['id']])}}">
                                                    {{ \App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'name',$lang) ?? $name }}
                                                </a>
                                            </span>
                                            <input class="form-control editValue lang_value" type="text"
                                            value="{{ \App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'name',$lang) ?? $name }}"
                                            name="name[]"
                                            onchange="translateName(event,'tr','input[name=\'name[]\']')"
                                            >
                                            <a role="button" class="btn btn-primary editValue" onclick="emptyInput(event,'tr','.lang_value')">{{ Helpers::translate('Field dump') }}</a>
                                            <input type="hidden" value="{{$lang}}" name="lang[]">
                                        </td>
                                        @endforeach


                                        <td>
                                            <center>
                                                <label class="switch switch-status mx-1">
                                                    <input type="checkbox"
                                                    id="{{$category['id']}}" class="switcher_input category-status" {{$category->home_status == 1?'checked':''}}>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </center>
                                            <span hidden>
                                                {{$category->home_status}}
                                            </span>
                                        </td>
                                        <td>
                                            <center>
                                                <a class="btn btn-primary btn-sm edit" style="cursor: pointer;"
                                                title="{{ \App\CPU\Helpers::translate('Edit')}}"
                                                href="{{route('admin.category.edit',[$category['id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                            </center>
                                        </td>
                                        </form>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form hidden action="{{route('admin.category.bulk-delete')}}" method="post" id="bulk-delete">
                            @csrf @method('delete')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.category.bulk-status',['status'=>true])}}" method="post" id="bulk-enable">
                            @csrf @method('post')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>

                        <form hidden action="{{route('admin.category.bulk-status',['status'=>false])}}" method="post" id="bulk-disable">
                            @csrf @method('post')
                            <input type="text" name="ids" class="ids">
                            <input type="text" name="not_ids" class="not_ids">
                        </form>
                    </div>

                    @if(count($categories)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\Helpers::translate('no_data_found')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')



<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
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
            $('#dataTable').DataTable({
                "pageLength": {{\App\CPU\Helpers::pagination_limit()}}
            });
        });
    </script>

    <script>
        $(document).on('change', '.category-status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.category.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    home_status: status
                },
                success: function (data) {
                    if(data.success == true) {
                        toastr.success('{{\App\CPU\Helpers::translate('Status updated successfully')}}');
                    }
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\Helpers::translate('Are_you_sure')}}?',
                text: "{{\App\CPU\Helpers::translate('You_will_not_be_able_to_revert_this')}}!",
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
                        url: "{{route('admin.category.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\Helpers::translate('Category_deleted_Successfully.')}}');
                            location.reload();
                        }
                    });
                }
            })
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

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
