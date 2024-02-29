@extends('web-views.education.frontend.layouts.front')
@section('title', "{{\App\CPU\Helpers::translate('help Center')}}" )
@section('content')
    <section class="section-content mt-5">
        <div class="container-lg">
            <div class="section-content-title mb-4 text-center">
                <h2 class="mb-0">{{ \App\CPU\Helpers::translate('Training Bag') }}</h2>
            </div>
            <p class="section-content-text col-lg-6 mx-auto text-center">
                {{ \App\CPU\Helpers::translate('Welcome to the training package for the masfufat platform') }}.
            </p>
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mt-4 mt-lg-5">
                @foreach ($data as $item)
                    <div class="col">
                        <div class="questions">
                            <div class="questions-title mb-3">
                                <h5 class="mb-2">{{ $item['categories']->name }}
                                    ({{ count($item['articles']) }})</h5>
                            </div>
                            <div class="questions-content">
                                @foreach (array_slice($item['articles'], 0, 5) as $article)
                                <a href="{{ route('education.article', $article->slug) }}"><i
                                    class="far fa-file-alt fa-lg me-2 mx-2"></i>{{ $article->title }}</a>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('education.category', $item['categories']->slug) }}">{{ \App\CPU\Helpers::translate('View All', 'home page') }}<i
                                        class="fas fa-angle-left ms-1 mx-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @if ($popularArticles->count() > 0)
        <section class="section-content">
            <div class="container-lg">
                <div class="section-content-title mb-4">
                    <h2 class="mb-0">{{ \App\CPU\Helpers::translate('Popular Articles') }}</h2>
                </div>
                <div class="row row-cols-1 row-cols-lg-2 gx-3 mt-4">
                    @foreach ($popularArticles as $popularArticle)
                        <div class="col">
                            <a href="{{ route('education.article', $popularArticle->slug) }}"
                                class="popular">{{ $popularArticle->title }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
