@foreach($provinces as $k=>$b)
<tr>
    <form class="table-editor-form" method="POST" action="{{route('admin.provinces.update',[$b['id']])}}">
        <td>
            @csrf
            <input type="checkbox" class="trSelector" onchange="handleRowSelect(this)">
            <span class="rowId" hidden>{{$b->id}}</span>
        </td>
        <td class="text-center">{{$b->id}}</td>
        @foreach(\App\CPU\Helpers::get_langs() as $lang)
        <td>
            <span class="spanValue">
                {{ \App\CPU\Helpers::get_prop('App\provinces',$b['id'],'name',$lang) ?? $b['name'] }}
            </span>
            <input
            class="form-control editValue lang_value"
            onchange="translateName(event,'tr','input[name=\'name[]\']')"
            type="text"
            value="{{ \App\CPU\Helpers::get_prop('App\provinces',$b['id'],'name',$lang) ?? $b['name'] }}"
            name="name[]">
            <a role="button" class="btn btn-primary editValue" onclick="emptyInput(event,'tr','.lang_value')">{{ Helpers::translate('Field dump') }}</a>
            <input type="hidden" value="{{$lang}}" name="lang[]">
        </td>
        @endforeach
        <td>
            <span class="spanValue">
                {{ \App\CPU\Helpers::get_prop('App\cities',$b['parent_id'],'name') ?? $b['name'] }}
            </span>
            <div class="input-group col-lg-12 editValue">
                <select
                aria-describedby="basic-addon1" value="" class="SumoSelect-custom form-control text-dark"
                onchange="$('.inputPrent_{{$b['id']}}').val(event.target.value)"
                >
                    <option value=""></option>
                    @foreach (Helpers::getCities() as $key=>$item)
                        <option
                        @if($item->id == $b->parent_id) selected @endif
                            value='{{ $item->id }}'> {{Helpers::get_prop('App\cities',$item->id,'name')}} </option>
                    @endforeach
                </select>
                <input value="{{$b->parent_id}}" type="hidden" name="parent_id" class="inputPrent_{{$b['id']}}">
            </div>
        </td>
        <td>
            <center>
                <label class="switcher">
                    <input type="checkbox" class="switcher_input"
                    id="{{$b['id']}}" {{$b->enabled == 1?'checked':''}}>
                    <span class="switcher_control"></span>
                </label>
            </center>
        </td>
        <td>
            <a class="btn btn-primary btn-sm" title="{{ \App\CPU\Helpers::translate('Edit')}}"
            href="{{route('admin.provinces.update',[$b['id']])}}">
                <i class="tio-edit"></i>
            </a>
        </td>
    </form>
</tr>
@endforeach
