<div class="input-group mb-4 mt-4 pt-4 wd-90p options-input2 option_div position-relative justify-content-center product-option-container">

    <div class="w-100 position-absolute t-0 text-start" onclick="$(this).closest('.option_div').slideUp();$(this).closest('.option_div').remove();viewValuesForOptions()">
        <a class="btn btn-danger position-absolute z-index2">
            <i class="fa fa-close"></i>
        </a>
    </div>
    <div class="row justify-content-center pl-3 pr-3 options-input1 w-100">
        <div class="input-group mb-4 w-lg-50 col-lg-4 options-input2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"> {{\App\CPU\Helpers::translate('Option title')}} </span>
            </div>
            @foreach (Helpers::get_langs() as $langIndex=>$lang)
            <input name="options[{{$key ?? 0}}][name][{{$lang}}]" aria-describedby="basic-addon1" value="{{$data['name'][$lang] ?? ''}}"
            class="form-control text-dark OptionTypes inputs_lang OptionTypes_lang {{$lang}}OptionType" placeholder="{{\App\CPU\Helpers::translate('Option title')}}*" type="text" required=""
            @if($lang !== session('local'))
            style="display: none"
            @endif
            onchange="translateName(event,'.input-group','.OptionTypes')"
            >
            @endforeach

            <div class="input-group-append bg-white">
                <select class="js-example-basic-multiple js-states js-example-responsive form-control select_lang " inputsClass="OptionTypes">
                    @foreach (Helpers::get_langs() as $langIndex=>$lang)
                    <option @if($lang == session('local')) selected @endif value="{{$lang}}">{{\App\CPU\Helpers::translate($lang.' language')}}</option>
                    @endforeach
                </select>
                <a class="btn btn-primary w-100" onclick="emptyInput(event,'.input-group','.OptionTypes')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
            </div>
        </div>

        <div class="col-lg-2">

        </div>

        <div class="input-group mb-4 mx-lg-wd-20p col-lg-4">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"> {{\App\CPU\Helpers::translate('Option type')}} </span>
            </div>
            <div class="form-control p-0 m-0 border-white bg-white">
                <select name="options[{{$key ?? 0}}][option_type]" class="js-example-basic-multiple js-states js-example-responsive form-control option_type_select">
                    <option @if(($data['option_type'] ?? '') == "text") selected @endif value="text">
                        {{\App\CPU\Helpers::translate('text')}}
                    </option>
                    <option @if(($data['option_type'] ?? '') == "color") selected @endif value="color">
                        {{\App\CPU\Helpers::translate('color')}}
                    </option>
                    <option @if(($data['option_type'] ?? '') == "photo") selected @endif value="photo">
                        {{\App\CPU\Helpers::translate('photo')}}
                    </option>
                    <option @if(($data['option_type'] ?? '') == "video") selected @endif value="video">
                        {{\App\CPU\Helpers::translate('video')}}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div id="optionValues{{$key}}" class="w-100">
        @foreach ($data['values'] ?? [] as $valueIndex=>$item)
            @include('admin-views.product.products-option-value',['data'=>$item,'optionIndex'=>$key,'optionValueIndex'=>$valueIndex,'product'=>$product])
        @endforeach
    </div>

    <div class="ml-0 mr-0 mt-0 wd-lg-20p wd-xl-20p p-2 border-success bd-dashed bd-4  btn add-option-value transitions d-block ht-50" onclick="newValue({{$key}})">
        <p class="fs-20 mt-0 mb-0">
            <i class="fa fa-plus text-success"></i>
            <span class="text-success"> {{ \App\CPU\Helpers::translate('Add new value') }} </span>
        </p>
    </div>
</div>
