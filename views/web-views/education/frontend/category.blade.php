@extends('web-views.education.frontend.layouts.grid')
@section('title', $category->name)
@section('footer', 'normal')
@section('content')
    <div class="page-content">
        @include('web-views.education.frontend.includes.sidebar')
        <div class="article">
            <nav class="mb-5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('education.home')}}">{{ \App\CPU\Helpers::translate('Home') }}</a></li><i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 12px;margin-right: 12px;margin-left: 12px;margin-top: 8px;"></i>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>
            <div class="cate">
                <div class="cate-title">
                    <h3 class="fw-400">{{ $category->name }}</h3>
                </div>
                @foreach ($articles as $article)
                    <a href="{{ route('education.article', $article->slug) }}" class="cate-article">
                        <div class="cate-article-icon mx-3">
                            <i class="far fa-file-alt"></i>
                        </div>
                        <div class="cate-article-info">
                            <p class="cate-article-title mb-0">{{ $article->title }}</p>
                            <p class="text-muted small mb-0">{{ $article->short_description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $articles->links() }}
        </div>
    </div>
@endsection
