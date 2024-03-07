<div class="border border-light m-4 p-2 prop-c-c">
    <div class="w-100 wk-text-center">
        <div class="w-100">
            <div class="text-start">
                <h5>
                    {{ \App\CPU\Helpers::translate('Choose property') }}
                </h5>
            </div>
            <div class="row pr-3 pl-3">
                <div class="col-lg-2">
                    <select name="productprops[{{$propIndex}}][property]" id="" class="select2 form-control propValue_select productprops_select">
                        <option> {{ \App\CPU\Helpers::translate('Choose') }} </option>
                        @foreach (\App\CPU\Helpers::getProductsProps() as $prop)
                            <option
                            @if($prop->id == ($item['property'] ?? '')) selected @endif
                            value="{{$prop->id}}"> {{  \App\CPU\Helpers::getItemName("products_props","name",$prop['id']) }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-5 d-flex options-input2 p-0">
                    <div class="row border rounded-15">
                        <ul class="nav nav-tabs lightSliderr w-100 mb-4">
                            @foreach(Helpers::get_langs() as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link_props {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}" role="button"
                                        id="{{$lang}}-link_props">
                                        <img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">
                                        {{ucfirst(\App\CPU\Helpers::get_language_name($lang)).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="row w-100">
                            <div class="col-md-7 px-6">
                                @foreach(Helpers::get_langs() as $lang)
                                    <div class="{{$lang != session()->get('local')? 'd-none':''}} lang_form_props {{$lang}}-form_props">
                                        <input name="productprops[{{$propIndex}}][value][{{$lang}}]" type="text" id=""
                                        value="{{$item['value'][$lang] ?? ''}}"
                                        class="form-control OptionTypesNewPropValue product-prop OptionTypes {{$lang}}OptionType" placeholder="{{ \App\CPU\Helpers::translate('value') }}" @if(isset($productId)) value="{{Helpers::getProp('3',$lang,$productId,'product_props',$parentId)}}" @endif
                                        onchange="translateName(event,'.prop-c-c','.product-prop')"
                                        />
                                        <a class="btn btn-primary w-50" onclick="emptyInput(event,'.prop-c-c','.product-prop')">{{\App\CPU\Helpers::translate('Field dump')}}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="text-start">
                        <a class="btn btn-primary" onclick="$(this).closest('.prop-c-c').remove()">
                            {{ \App\CPU\Helpers::translate("delete") }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
