<aside class="sidebar" data-simplebar>
    @foreach ($data as $item)
        <div class="sidebar-category">
            <p class="sidebar-links-title h6 mb-4 toggle-category">
                {{ $item['categories']->name }}
                <span class="toggle-icon fas fa-chevron-down"></span>
            </p>
            <div class="sidebar-links" style="    margin-bottom: 30px;
            margin-top: -10px;">
                @foreach ($item['articles'] as $article)
                    <a href="{{ route('education.article', $article->slug) }}"
                        class="sidebar-links-item">{{ $article->title }}</a>
                @endforeach
            </div>
        </div>
    @endforeach
</aside>
