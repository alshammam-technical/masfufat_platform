@extends('web-views.education.frontend.layouts.grid')
@section('title', $article->title)
@section('description', $article->short_description)
@section('footer', 'normal')
@section('content')
@php($item = \App\article_categories::where('id',$article->category_id)->first())
    <div class="page-content">
        @include('web-views.education.frontend.includes.sidebar')
        <div class="article">
            <nav class="mb-5">
                <ol class="breadcrumb" style="
                float: right;">
                    <li class="breadcrumb-item" style="margin-left: 10px;"><a href="{{route('education.home')}}">{{ \App\CPU\Helpers::translate('Home') }}</a><i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 12px;margin-right: 12px;"></i></li>
                    <li class="breadcrumb-itemapp" style="margin-left: 10px;"><a
                            href="{{ route('education.category', $item->slug) }}">{{ $article->category->name }}</a><i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 12px;margin-right: 12px;"></i>
                    </li>
                    <li class="breadcrumb-item active">{{ $article->title }}</li>
                </ol>
            </nav>
            <div class="d-flex flex-column align-items-start mb-4">
                <h2 class="mb-0 border-bottom py-3 fw-600">{{ $article->title }}</h2>
                <h4 class="mb-0 border-bottom py-3 fw-400">{{ $article->short_description }}</h4>
                <div class="my-4 text-justify">
                    {!! $article->content !!}
                </div>
            </div>
            <!-- Video container -->

            {{--  <div class="video-container" style="width:100%; margin-bottom:20px;border-radius: 0px 0px 50px 0px;">
                <video width="80%" controls style="border-radius: 0px 0px 50px 0px;" controlsList="nodownload">
                    <source src="{{ asset('storage/app/public/education/video/' . $article->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>  --}}
            </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // البحث عن جميع علامات الفيديو في الصفحة
        var videos = document.getElementsByTagName('video');

        // تكرار على كل علامة فيديو وإضافة خاصية controls
        for (var i = 0; i < videos.length; i++) {
            videos[i].setAttribute('controls', '');
            videos[i].setAttribute('controlsList', 'nodownload');
        }
    });
</script>
@endsection
