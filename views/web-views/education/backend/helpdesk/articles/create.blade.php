@extends('layouts.back-end.app')

@section('title',  \App\CPU\Helpers::translate('Add Article'))

@push('css_or_js')

@endpush

@section('content')

    <div class="content container-fluid" >
                <div class="col-lg-12 pt-0">
            <div style="display: flex; align-items: center; width: 100%;">
                <nav aria-label="breadcrumb" style="flex-grow: 1;width: 100%;">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\Helpers::translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">{{\App\CPU\Helpers::translate('Training bag')}}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('admin.store-education.back-end.articles')}}">{{\App\CPU\Helpers::translate('articles')}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a>
                                {{\App\CPU\Helpers::translate('Add Article')}}
                            </a>
                        </li>
                    </ol>
                </nav>
                <button id="help-center-button" class=" my-2 btn-icon-text m-2 btnn" style="border-radius: 10px;" target="_blank">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                    width="16.000000pt" height="16.000000pt" viewBox="0 0 48.000000 48.000000"
                    preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,48.000000) scale(0.100000,-0.100000)"
                    fill="#000000" stroke="none">
                    <path d="M20 460 c-15 -15 -20 -33 -20 -70 l0 -50 180 0 180 0 0 50 c0 84 -13
                    90 -180 90 -127 0 -142 -2 -160 -20z m75 -50 c0 -18 -6 -26 -23 -28 -13 -2
                    -25 3 -28 12 -10 26 4 48 28 44 17 -2 23 -10 23 -28z m100 0 c0 -18 -6 -26
                    -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z m100 0 c0
                    -18 -6 -26 -23 -28 -24 -4 -38 18 -28 44 3 9 15 14 28 12 17 -2 23 -10 23 -28z"/>
                    <path d="M0 240 l0 -60 93 0 92 0 20 37 c11 21 37 47 60 60 l40 23 -152 0
                    -153 0 0 -60z"/>
                    <path d="M291 242 c-38 -20 -71 -73 -71 -112 0 -62 68 -130 130 -130 62 0 130
                    68 130 130 0 62 -68 130 -130 130 -14 0 -41 -8 -59 -18z m93 -38 c18 -18 21
                    -60 5 -69 -5 -4 -14 -18 -20 -32 -5 -13 -15 -23 -22 -20 -16 6 -11 46 10 69
                    13 15 14 21 4 31 -9 9 -16 7 -29 -11 -18 -23 -32 -21 -32 4 0 19 29 44 50 44
                    10 0 26 -7 34 -16z m-19 -143 c7 -12 -12 -24 -25 -16 -11 7 -4 25 10 25 5 0
                    11 -4 15 -9z"/>
                    <path d="M0 90 c0 -78 18 -90 134 -90 l95 0 -24 43 c-14 23 -25 54 -25 70 l0
                    27 -90 0 -90 0 0 -50z"/>
                    </g>
                    </svg>
                </button>
            </div>
        </div>
        <!-- End Inlile Menu -->
        <form id="vironeer-submited-form" action="{{ route('admin.store-education.back-end.articles.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
        <div class="row gy-3">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{\App\CPU\Helpers::translate('Add Article')}}</h5>
                    </div>
                    <div class="card-body text-{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'right' : 'left'}}">
                        <div class="mb-3">
                            <label class="form-label">{{\App\CPU\Helpers::translate('article title') }} : <span
                                    class="red">*</span></label>
                                    <input type="text" name="title" class="form-control" value=""
                                    required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ \App\CPU\Helpers::translate('Article category') }} : <span
                                    class="red">*</span></label>
                            <select id="articleCategory" name="category" class="form-select" required>
                                <option value="" selected disabled>{{ \App\CPU\Helpers::translate('Choose') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{\App\CPU\Helpers::translate('Slug') }} : </label>
                                    <input type="text" name="slug" class="form-control" value=""
                                    required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{\App\CPU\Helpers::translate('Short description') }} : </label>
                            <textarea name="short_description" rows="6" class="form-control"
                                placeholder="{{\App\CPU\Helpers::translate('50 to 200 character at most') }}"
                              ></textarea>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">{{ \App\CPU\Helpers::translate('Article content') }} : <span
                                    class="red">*</span></label>
                            <textarea name="content" id="content" rows="10" class="form-control textarea"
                                required></textarea>
                        </div>
                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">{{\App\CPU\Helpers::translate('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <script src="{{ asset('/public/assets/education/vendor/libs/ckeditor/ckeditor.js') }}"></script>
@endsection
@include('admin-views.education.backend.includes.scripts')
@push('script_2')
{{--ck editor--}}
<script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
<script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
<script>
    $('.textarea').ckeditor({
        contentsLangDirection : '{{ Session::get('direction') }}',
        language: 'ar',
        ui: 'ar',
        extraPlugins: 'html5video',
        filebrowserUploadUrl: '{{ route('admin.store-education.back-end.articles.uploadv',['_token' => csrf_token() ]) }}',
        filebrowserUploadMethod: 'form'
    });

    var editor = $('.textarea').ckeditorGet();
    editor.on("blur", function(e) {
        var val = e.editor.getData();
    });
</script>





{{--ck editor--}}
@endpush
