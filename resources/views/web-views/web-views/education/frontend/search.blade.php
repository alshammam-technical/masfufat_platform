@extends('web-views.education.frontend.layouts.grid')
@section('title', str_replace('[COUNT]', $articles->count(), \App\CPU\Helpers::translate('help center')) . ' ' .
    request()->input('q'))
@section('footer', 'normal')
@section('content')
    <div class="page-content bg-white">
        <div class="container-lg">
            <div class="page-content-header">
                <a href="{{route('education.home')}}">
                    <i class="fas fa-arrow-left me-2"></i> {{ \App\CPU\Helpers::translate('help center') }}
                </a>
                <p class="mb-0 text-muted ms-3 small">
                    {{ str_replace('[COUNT]', $articles->count(), \App\CPU\Helpers::translate('help center')) }}
                    "{{ request()->input('q') }}"</p>
            </div>
            <div class="article p-0 mb-5">
                <div class="cate cate-border">
                    @forelse ($articles as $article)
                        <a href="{{ route('education.article', $article->slug) }}" class="cate-article">
                            <div class="cate-article-icon mx-3">
                                <i class="far fa-file-alt"></i>
                            </div>
                            <div class="cate-article-info">
                                <p class="cate-article-title mb-0 fs-5 fw-400">{{ $article->title }}</p>
                                <p class="text-muted small mb-0">{{ $article->short_description }}</p>
                            </div>
                        </a>
                    @empty
                        @include('web-views.education.frontend.includes.empty')
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
