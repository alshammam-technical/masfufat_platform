<div class="mb-0 wd-95p option-value-container mt-2 justify-content-center position-relative">


    <div class="input-group justify-content-center mx-wd-lg-75p mb-4 options-input2">
        <div class="input-group mb-4 w-lg-50 col-lg-4 options-input2 px-0">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"> {{\App\CPU\Helpers::translate('The Value')}} </span>
            </div>
            @foreach (Helpers::get_langs() as $langIndex=>$lang)
            <input name="options[{{$optionIndex ?? 0}}][values][{{$optionValueIndex ?? 0}}][name][{{$lang}}]" aria-describedby="basic-addon1" value="{{$data['name'][$lang] ?? ''}}"
            class="form-control text-dark OptionTypes OptionValue inputs_lang {{$lang}}OptionType" placeholder="{{\App\CPU\Helpers::translate('The Value')}} ({{\App\CPU\Helpers::translate($lang.' language')}})*" type="text" required=""
            @if($lang !== session('local'))
            style="display: none"
            @endif
            @if($lang == session('local'))
            onkeyup="$('.option-value-collapse_{{$optionIndex ?? 0}}_{{$optionValueIndex ?? 0}}').closest('.option-value-acc').show();$('.option-value-collapse_{{$optionIndex ?? 0}}_{{$optionValueIndex ?? 0}}').text(event.target.value)"
            @endif
            onchange="translateName(event,'.input-group','.OptionValue')"
            >
            @endforeach

            <div class="input-group-append bg-white">
                <select class="js-example-basic-multiple js-states js-example-responsive form-control select_lang" inputsClass="OptionTypes">
                    @foreach (Helpers::get_langs() as $langIndex=>$lang)
                    <option @if($lang == session('local')) selected @endif value="{{$lang}}">{{\App\CPU\Helpers::translate($lang.' language')}}</option>
                    @endforeach
                </select>
                <a class="btn btn-primary w-100" onclick="emptyInput(event,'.input-group','.OptionValue')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
            </div>
        </div>

        <div class="input-group-append OptionTypes colorOptionType" style="display: none">
            <input name="options[{{$optionIndex ?? 0}}][values][{{$optionValueIndex ?? 0}}][option_value_color]"
            type="color"
            value="{{$data['option_value_color'] ?? ''}}"
            class="form-control text-dark showAlpha wd-70 p-1"
            style="width: 70px"
            >
        </div>

        <div>
            <span class="input-group-text bg-white border-0 btn p-0" id="basic-addon1" style="max-height: 50px">
                <div class="wd-30 OptionTypes photoOptionType px-0" style="display: none">
                    <button class="btn btn-success" alt="" onclick="$(this).next('.product-color-fileInput').click()"><i class="fa fa-plus"></i></button>
                    <input name="options[{{$optionIndex ?? 0}}][values][{{$optionValueIndex ?? 0}}][option_value_photo]" type="file" accept="image/*" class="product-color-fileInput d-none" />
                </div>
                <div class="wd-40 OptionTypes videoOptionType pr-0 pl-0" style="display: none">
                    <button class="btn btn-success" alt="" onclick="$(this).next('.product-color-fileInput').click()"><i class="fa fa-plus"></i></button>
                    <input name="options[{{$optionIndex ?? 0}}][values][{{$optionValueIndex ?? 0}}][option_value_video]" type="file" accept="video/mp4" class="product-color-fileInput d-none" />
                </div>
            </span>
        </div>

        <div class="input-group-append bg-white">
            <div class="mt-0 text-start"
            onclick="$(this).closest('.option-value-container').remove();viewValuesForOptions()">
                <button class="btn btn-danger" optionIndex="{{$optionIndex}}" optionValueIndex="{{$optionValueIndex}}">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>

    </div>



</div>

