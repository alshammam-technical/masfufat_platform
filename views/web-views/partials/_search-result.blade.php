<style>
    .list-group-item li, a {
        color: {{$web_config['primary_color']}};
    }

    .list-group-item li, a:hover {
        color: {{$web_config['secondary_color']}};
    }
</style>
<ul class="list-group list-group-flush">
    @foreach($products as $i)
        <li class="list-group-item" onclick="$('.search_form').submit()">
            <a href="{{ route('product',['slug'=>$i['slug']]) }}" onmouseover="$('.search-bar-input-mobile').val('{{ Helpers::get_prop('App\Model\Product',$i['id'],'name') }}');$('.search-bar-input').val('{{ Helpers::get_prop('App\Model\Product',$i['id'],'name') }}');">
                {{ Helpers::get_prop('App\Model\Product',$i['id'],'name') }}
            </a>
        </li>
    @endforeach
</ul>
