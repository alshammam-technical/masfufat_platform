@extends('layouts.front-end.app')

@section('title', \App\CPU\Helpers::translate('Add Employee'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .form-control{
            direction: {{ (session('direction') == 'rtl') ? 'rtl' : 'ltr' }};
        }
        label{
            text-align: {{ (session('direction') == 'rtl') ? 'right' : 'left' }} !important ;
        }
        h3{
            font-size: 1.5rem !important;
        }

        .SumoSelect{
            width: 100% !important;
        }

        .SumoSelect .select-all{
            height: 40px !important;
        }

        .SumoSelect>.CaptionCont{
            text-align: start
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
<!-- Content -->
<div class="content mx-3">
    <!-- Page Header -->
    <div class="mb-3">
        <div class="row gy-2 align-items-center">
            <div class="col-sm">
                <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                    <i  class="fa fa-user"></i>
                    {{\App\CPU\Helpers::translate('my account settings')}}
                </h2>
            </div>
            <!-- End Page Title -->
            @if (\App\CPU\Helpers::seller_module_permission_check('dashboard'))
            <div class="col-sm-auto">
                <a class="btn bg-primaryColor btn-primary bg-primaryColor" href="{{route('dashboard.index')}}">
                    <i class="tio-home mr-1"></i> {{\App\CPU\Helpers::translate('Dashboard')}}
                </a>
            </div>
            @endif
        </div>
        <!-- End Row -->
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-lg-12 px-0">

            <!-- Card -->
            <div id="passwordDiv" class="card mb-3 mb-lg-5">
                <div class="card-header">
                    <h5 class="mb-0 text-{{ (session('direction') == 'rtl') ? 'right' : 'left' }} font-weight-bold">{{\App\CPU\Helpers::translate('Add a person authorized for you')}}</h5>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <!-- Form -->
                    <form action="{{route('delegates.store')}}"
                          method="post"
                          enctype="multipart/form-data">
                    @csrf

                    <!-- Form Group -->
                        <div class="row form-group">
                            <label for="name"
                                   class="col-sm-3 col-form-label input-label"> {{\App\CPU\Helpers::translate('Name of authorized person')}}</label>

                            <div class="col-sm-9">
                                <input type="text" class="js-pwstrength form-control" name="name"
                                        placeholder="{{\App\CPU\Helpers::translate('Name of authorized person')}}" required>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="email"
                                   class="col-sm-3 col-form-label input-label "> {{\App\CPU\Helpers::translate('Email of the authorized person')}} </label>

                            <div class="col-sm-9">
                                <div class="">
                                    <input type="email" class="form-control" name="email"
                                            placeholder="{{\App\CPU\Helpers::translate('Email of the authorized person')}}" required>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="phone"
                                   class="col-sm-3 col-form-label input-label "> {{\App\CPU\Helpers::translate('Phone of the authorized person')}} </label>

                            <div class="col-sm-9">
                                <div class="mb-1">
                                    <input class="form-control phoneInput text-left" dir="ltr" value="{{old('phone') ?? '+966'}}" name="phone" style="direction: ltr"
                                            placeholder="{{\App\CPU\Helpers::translate('Phone of the authorized person')}}">
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="row form-group">
                            <label for="email"
                                   class="col-sm-3 col-form-label input-label "> {{\App\CPU\Helpers::translate('is Chief Commissioner')}} </label>

                            <div class="col-sm-9">
                                <div class="text-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}">
                                    <span class=""><label class="switcher mt-1 d-inline-block">
                                        <input type="checkbox" class="is_chief switcher_input"
                                        name="is_chief"  value="0"  @if(\App\CPU\Helpers::hasEmployeeTypeforstores('is_chief')) disabled @endif>
                                        <span class="switcher_control"></span>
                                    </label></span>
                                </div>
                            </div>
                        </div>
                        <!-- End Form Group -->



                    <!-- End Form -->
                </div>
                <!-- End Body -->
            </div>
            <!-- End Card -->

            <!-- Sticky Block End Point -->
            <div id="stickyBlockEndPoint"></div>
        </div>
        <div class="col-lg-12 px-0 mt-2">
            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="font-weight-bold mb-0">{{\App\CPU\Helpers::translate('Employee Permissions')}}</h3>
                    <div class="mt-1 mx-5">
                        <label class="ckbox">
                            <input value="0" class="switch_inputs switch_inputs_addfrom" inputsClass="addfrom" name="addfrom" type="checkbox"><span>{{\App\CPU\Helpers::translate('add from anouther employee')}}</span></label>
                    </div>
                </div>

                <div class="card-body">
                    <div class="perm">


                            <div class="form-check mb-5 {{ (session('direction') == 'rtl') ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                                <input class="form-check-input" type="checkbox" id="checkAllPermissions">
                                <span for="checkAllPermissions">{{ Helpers::translate('Select All Permissions') }}</span>
                            </div>
                            {{--    --}}
                            @foreach ($pages as $key=>$page)
                            <div class="row modules-row p-3 py-1">
                                @php($k = str_replace(' ','',$key))
                                @isset($page['children'])
                                @php($children = $page['children'])
                                @else
                                @php($children = [['caption' => $page['name'], 'name' => $page['name'], 'actions' => $page['actions']]])
                                @endisset
                                <h3 class="font-weight-bold text-{{ (session('direction') == 'rtl') ? 'right' : 'left' }}">
                                    {{ Helpers::translate($key) }}
                                </h3>
                                @foreach ($children as $kk=>$item)
                                <div class="col-lg-12">
                                    <label class="row" for="modules[]" style="width: 100%">
                                        <label class="font-weight-bold col-6 pt-2">
                                            {{ Helpers::translate($item['caption']) }}
                                        </label>
                                        <div class="col-6">
                                            <div class="form-control border-muted p-0">
                                                @php($admins = explode(',',($required_fields->admins ?? '[]')))
                                                <select class="SumoSelect-custom border-0 modulesSelect" multiple>
                                                    @if(!empty($role))
                                                    @foreach ($item['actions'] ?? [] as $i=>$action)
                                                        <option value="{{$item['name'].'.'.$action}}">
                                                            {{ Helpers::translate($action) }}
                                                        </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <input type="hidden" name="modules[]" value="{{$required_fields->admins ?? ''}}">
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                            {{--    --}}


                    </div>

                    <div class="add_from">
                        <div class="row form-group">
                            <label for="email"
                                   class="col-sm-3 col-form-label input-label pt-0"> {{\App\CPU\Helpers::translate('Choose authorized person')}} </label>

                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <select tabindex="11" class="form-control text-dark from_employee" name="from_employee">
                                        <option value="" disabled selected>{{\App\CPU\Helpers::translate('Choose authorized person')}}</option>
                                        @foreach ($employees as $key=>$e)
                                            <option value="{{$e->id}}">{{ $key+1 }} - {{ $e->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mx-6">
                        <button type="submit"
                                class="btn bg-primaryColor btn-primary bg-primaryColor py-2 px-4 font-weight-bold mt-2">{{\App\CPU\Helpers::translate('Add')}}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
</div>
@endsection
@push('script')
<script>
    $(document).ready(function(){
        $(".modulesSelect").change();
    })
</script>
<script>
    $(document).ready(function() {
        $('select.SumoSelect-custom').SumoSelect();

        // Bind click event handlers
        bindCheckAllListeners();
    });

    function bindCheckAllListeners() {
        $(document).on('click', '#checkAllPermissions', function() {
            var isChecked = $(this).is(':checked');
            $('select.SumoSelect-custom').each(function() {
                var sumoSelect = $(this)[0].sumo;
                if (sumoSelect) {
                    if (isChecked) {
                        sumoSelect.selectAll();
                    } else {
                        sumoSelect.unSelectAll();
                    }
                } else {
                    console.error('SumoSelect is not initialized on this element:', this);
                }
                $(this).change();
            });
        });
    }

    </script>

    <script>
        $(document).ready(function() {
            $('.add_from').hide();
            $('.div_foldable_section').css('max-height', '45rem');
            $('.switch_inputs_addfrom').change(function() {
                if ($(this).is(':checked')) {
                    // إظهار حقل الإدخال
                    $('.add_from').show();
                    $('.perm').hide();
                    $('.div_foldable_section').css('max-height', 'max-content');
                } else {
                    // إخفاء حقل الإدخال
                    $('.add_from').hide();
                    $('.perm').show();
                    $('.div_foldable_section').css('max-height', '45rem');
                }
            });

            $('.is_chief').change(function() {
                if($(this).is(':checked')) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });
        });
</script>
@endpush
