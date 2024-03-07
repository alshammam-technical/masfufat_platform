@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Database setup'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
<div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/system-setting.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Database setup')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inline Menu -->

        <!-- End Inline Menu -->


    <div class="row">
        <div class="col-12 mb-3">
            <div class="alert badge-soft-danger mb-0 mx-sm-2 {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}" role="alert">
                {{\App\CPU\Helpers::translate('This_page_contains_sensitive_information.Make_sure_before_changing.')}}
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.business-settings.web-config.clean-db')}}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach($tables as $key=>$table)
                                <div class="col-sm-6 col-xl-3">
                                    <div class="form-group form-check {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                                        <input type="checkbox" name="tables[]" value="{{$table}}"
                                            class="form-check-input"
                                            id="business_section_{{$key}}">
                                        <label class="form-check-label text-dark"
                                            style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                            for="business_section_{{$key}}">{{ Helpers::translate($table) }}</label>
                                        <span class="badge-pill badge-secondary mx-2">{{$rows[$key]}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end gap-10 flex-wrap mt-3">
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Clear')}}</button>
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
        $("#purchase_code_div").click(function () {
            var type = $('#purchase_code').get(0).type;
            if (type === 'password') {
                $('#purchase_code').get(0).type = 'text';
            } else if (type === 'text') {
                $('#purchase_code').get(0).type = 'password';
            }
        });
    })
</script>

<script>
    $("form").on('submit',function(e) {
        e.preventDefault();
        Swal.fire({
            title: '{{\App\CPU\Helpers::translate('Are you sure?')}}',
            text: "{{\App\CPU\Helpers::translate('Sensitive_data! Make_sure_before_changing.')}}",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '{{$web_config['primary_color']}}',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                this.submit();
            }else{
                e.preventDefault();
                toastr.success("{{\App\CPU\Helpers::translate('Cancelled')}}");
                location.reload();
            }
        })
    });
</script>
@endpush
