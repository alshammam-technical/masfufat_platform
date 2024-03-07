<table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
    class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table" dir="{{session()->get('direction')}}">
    <thead class="thead-light">
    <tr>
        <th style="width: 100px">{{ \App\CPU\Helpers::translate('category ID')}}</th>
        <th>{{ \App\CPU\Helpers::translate('icon')}}</th>
        <th>{{\App\CPU\Helpers::translate('priority')}}</th>
        @php($default_lang = session()->get('local'))
        @foreach(\App\CPU\Helpers::get_langs() as $lang)
        <th>{{ \App\CPU\Helpers::translate('name')}} ({{$lang}})</th>
        @endforeach
        <th>{{ \App\CPU\Helpers::translate('home_status')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $key=>$category)
        <tr>
            <td class="text-center">
                <center>
                    {{$category['id']}}
                </center>
            </td>
            <td>
                <img class="rounded" width="64"
                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                    src="{{asset("storage/app/public/category/".(\App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'image',session()->get('local')) ?? $category->icon))}}" />
            </td>
            <td>
                <span class="spanValue">{{$category['priority']}}</span>
            </td>
            @php($name = $category['name'])
            @foreach(\App\CPU\Helpers::get_langs() as $lang)
            <td>
                <span class="spanValue">
                    {{ \App\CPU\Helpers::get_prop('App\Model\Category',$category['id'],'name',$lang) ?? $name }}
                </span>
            </td>
            @endforeach
            <td>
                <center>
                    {{$category->home_status}}
                </center>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
