@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('Bulk Import'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('admin.package.list', ['in_house',''])}}">{{\App\CPU\Helpers::translate('Packages')}}</a>
                </li>
                <li class="breadcrumb-item">{{\App\CPU\Helpers::translate('bulk_import')}} </li>
            </ol>
        </nav>
        <!-- Content Row -->
        <div class="row" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-12">
                <div class="jumbotron" style="background: white">
                    <h1 class="display-4">{{\App\CPU\Helpers::translate('Instructions')}} : </h1>
                    <p> 1. {{\App\CPU\Helpers::translate('Download the format file and fill it with proper data')}}.</p>

                    <p>2. {{\App\CPU\Helpers::translate('You can download the example file to understand how the data must be filled')}}.</p>

                    <p>3. {{\App\CPU\Helpers::translate('Once you have downloaded and filled the format file, upload it in the form below and submit')}}.</p>

                    <p> 4. {{\App\CPU\Helpers::translate('After uploading items you need to edit them and set images and choices')}}.</p>

                    <p> 5. {{\App\CPU\Helpers::translate('You can get package and package id from their list, please input the right ids')}}.</p>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
<script>
    // File Upload
    "use strict";

    $('.upload-file__input').on('change', function() {
        $(this).siblings('.upload-file__img').find('img').attr({
            'src': '{{asset('/public/assets/back-end/img/excel.png')}}',
            'width': 80
        });
    });

    function resetImg() {
        $('.upload-file__img img').attr({
            'src': '{{asset('/public/assets/back-end/img/drag-upload-file.png')}}',
            'width': 'auto'
        });
    }
</script>
@endpush
