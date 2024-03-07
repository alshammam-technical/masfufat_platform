@extends('layouts.back-end.app')
@section('title', \App\CPU\Helpers::translate('Edit Role'))
@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{\App\CPU\Helpers::translate('Role_Update')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="submit-create-role" action="{{route('admin.custom-role.update',[$role['id']])}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="title-color">{{\App\CPU\Helpers::translate('role_name')}}</label>
                                <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name"
                                       aria-describedby="emailHelp"
                                       placeholder="{{\App\CPU\Helpers::translate('Ex')}} : {{\App\CPU\Helpers::translate('Store')}}">
                            </div>

                            <label for="module" class="title-color mb-0">{{\App\CPU\Helpers::translate('module_permission')}} : </label>
                            <hr>

                            <ul class="nav nav-tabs lightSliderawzero w-fit-content mb-0 px-6">
                                @foreach ($pages as $key=>$page)
                                    <li class="nav-item text-capitalize w-auto text-nowrap">
                                        <a class="nav-link _link {{$key == 'Dashboard' ? 'active':''}}" href="#" id="{{str_replace(' ','',$key)}}-link">
                                            {{ Helpers::translate($key) }}
                                        </a>
                                    </li>
                                @endforeach
                                <li>
                                    <div style="min-width: 100px">

                                    </div>
                                </li>
                            </ul>

                            @foreach ($pages as $key=>$page)
                            @php($k = str_replace(' ','',$key))
                            <div class="mt-5 mx-5 {{$key != 'Dashboard' ? 'd-none':''}} _form" id="{{str_replace(' ','',$key)}}-form">
                                @isset($page['children'])
                                @foreach ($page['children'] as $kk=>$item)
                                <h3>
                                    {{ Helpers::translate($item['caption']) }}
                                </h3>
                                <div class="row">
                                    @foreach ($item['actions'] ?? [] as $i=>$action)
                                    <div class="col-sm-6 col-lg-3 px-0">
                                        <div class="form-group d-flex gap-2">
                                            <input type="checkbox" name="modules[]" value="{{$item['name'].'.'.$action}}" class="module-permission {{$k.$kk}}_chbx" id="{{$k.$kk.$action}}"
                                            @if(!$i)
                                            onchange="changeChildren(this,'.{{$k.$kk}}_chbx')"
                                            @else
                                            onchange="changeParent(this,'#{{$k.$kk.'view'}}')"
                                            @endif
                                            {{in_array($item['name'].'.'.$action,(array)json_decode($role['module_access']))?'checked':''}}
                                            >
                                            <label class="title-color mb-0" for="{{$k.$kk.$action}}">
                                                @if($key == "products")
                                                    @if ($action == "enable")
                                                        {{\App\CPU\Helpers::translate('enable in market and app')}}
                                                    @elseif($action == "disable")
                                                        {{\App\CPU\Helpers::translate('diable in market and app')}}
                                                    @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                    @endif
                                                @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                                @else
                                <div class="row">
                                    @foreach ($page['actions'] ?? [] as $action)
                                    <div class="col-sm-6 col-lg-3 px-0">
                                        <div class="form-group d-flex gap-2">
                                            <input type="checkbox" name="modules[]" value="{{$page['name']}}" class="module-permission" id="{{$page['name']}}"
                                            {{in_array($page['name'],(array)json_decode($role['module_access']))?'checked':''}}
                                            >
                                            <label class="title-color mb-0" for="{{$page['name']}}">
                                                @if($key == "products")
                                                    @if ($action == "enable")
                                                        {{\App\CPU\Helpers::translate('enable in market and app')}}
                                                    @elseif($action == "disable")
                                                        {{\App\CPU\Helpers::translate('diable in market and app')}}
                                                    @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                    @endif
                                                @else
                                                    {{\App\CPU\Helpers::translate($action)}}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endisset
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{\App\CPU\Helpers::translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    function changeChildren(ths,selector){
        if(!ths.checked) {
            $(selector).removeAttr('checked')
        }
    }

    function changeParent(ths,selector){
        if(ths.checked) {
            $(selector).prop('checked',1)
        }
    }

    $("._link").click(function (e) {
        e.preventDefault();
        $("._link").removeClass('active');
        $("._form").addClass('d-none');
        $(this).addClass('active');

        let form_id = this.id;
        let keyy = form_id.split("-")[0];
        console.log(keyy);
        $("#" + keyy + "-form").removeClass('d-none');
        if (keyy == 'Dashboard') {
            $(".from_part_2").removeClass('d-none');
        } else {
            $(".from_part_2").addClass('d-none');
        }
    });

    $('#submit-create-role').on('submit',function(e){

        var fields = $("input[name='modules[]']").serializeArray();
        if (fields.length === 0)
        {
            toastr.warning('{{ \App\CPU\Helpers::translate('select_minimum_one_selection_box') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
            return false;
        }else{
            $('#submit-create-role').submit();
        }
    });
</script>
@endpush
