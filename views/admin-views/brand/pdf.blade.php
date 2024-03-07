<style>
    th,td{
        text-align: start;
    }
</style>
<table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
    class="datatable table table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table" dir="{{session()->get('direction')}}">
    <thead class="thead-light">
    <tr>
        <th scope="col" style="width: 100px">
            {{ \App\CPU\Helpers::translate('brand ID')}}
        </th>
        <th scope="col">{{ \App\CPU\Helpers::translate('image')}}</th>
        <th scope="col">{{ \App\CPU\Helpers::translate('priority')}}</th>
        @foreach(\App\CPU\Helpers::get_langs() as $lang)
        <th scope="col">{{ \App\CPU\Helpers::translate('name')}} ({{$lang}})</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($br as $b)
        <tr>
            <td class="text-center">{{$b['id']}}</td>
            <td>
                <img class="rounded" width="64"
                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                src="{{asset('storage/app/public/brand')}}/{{(\App\CPU\Helpers::get_prop('App\Model\Brand',$b['id'],'image',session()->get('local')) ?? $b['image'])}}">
            </td>
            <td class="text-center">
                <span class="spanValue">
                    {{$b['priority']}}
                </span>
            </td>
            @php($name = $b['name'])
            @foreach(\App\CPU\Helpers::get_langs() as $lang)
            <td>
                <span class="spanValue">
                    {{ \App\CPU\Helpers::get_prop('App\Model\Brand',$b['id'],'name',$lang) ?? $name }}
                </span>
            </td>
            @endforeach
        </tr>
    @endforeach

    </tbody>
</table>
