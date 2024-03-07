@php
$values_sections = 0;
if(!isset($product)){
    $product = new \App\Model\Product();
}
@endphp
@foreach ($arr as $key=>$items)
@php
if (!isset($products[$key])){
    $products[$key] = new \App\Model\Product();
}
@endphp
{{--  accordion  --}}
<div class="card-body pt-0 pl-0 pr-0 wd-100p option-value-acc">
    <div aria-multiselectable="true" class="accordion accordion-color" id="accordion{{$key}}" role="tablist">
        <div class="card">
            <div class="card-header bg-primary justify-content-center" id="headingOne{{$key}}" role="tab">
                <a aria-controls="collapseOne{{$key}}" aria-expanded="false"
                data-toggle="collapse" href="#collapseOne{{$key}}"
                class="option-value-collapse collapsed option-value-collapse_op_i_{{$key}} w-100 text-center" style="font-size: 20px"
                >
                @if(!isset($items->c))

                @foreach ($items as $item)
                <span class="text-light option-value-collapse_span option-value-collapse_opIndex{{$item->c ?? $items->c}} option-value-collapse_{{$item->c ?? $items->c}}_{{$item->vc ?? $items->vc}}"></span>
                @endforeach

                @else
                <span class="text-light option-value-collapse_span option-value-collapse_opIndex{{$item->c ?? $items->c}} option-value-collapse_{{$item->c ?? $items->c}}_{{$item->vc ?? $items->vc}}"></span>

                @endif
                </a>
            </div>
            <div aria-labelledby="headingOne{{$key}}"
            class="collapse"
            data-parent="#accordion{{$key}}"
            id="collapseOne{{$key}}"
            role="tabpanel">
                <div class="card-body ov-card-body">
                    <div class="row">
                        <div class="col-lg-4 serialNumbers serialNumbers_on" style="max-height: 400px;overflow-y: auto; @if($product['enable_serial_numbers'] !== 1) display: none @endif"
                        >
                            <div class="row mg-t-10">
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="options_values[{{$values_sections}}][selling_order]" type="radio" value="asc" @if($data->selling_order == "asc") checked @endif
                                    @if(!$data->selling_order) checked @endif> <span>{{\App\CPU\Helpers::translate('selling asc')}}</span></label>
                                </div>
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="options_values[{{$values_sections}}][selling_order]" type="radio" value="desc" @if($data->selling_order == "desc") checked @endif> <span>{{\App\CPU\Helpers::translate('selling desc')}}</span></label>
                                </div>
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="options_values[{{$values_sections}}][selling_order]" type="radio" value="random" @if($data->selling_order == "random") checked @endif>
                                        <span>{{\App\CPU\Helpers::translate('selling random')}}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="snValuesContainer custom-sortable ui-sortable" values_sections="{{$values_sections}}">
                                <input type="text" data-role="tagsinput" class="form-control" name="options_values[{{$values_sections}}][serial_numbers]"
                                value="{{ is_array($products[$key]['serial_numbers']) ? implode(',',$products[$key]['serial_numbers']) : $products[$key]['serial_numbers'] }}">
                                @foreach ($product['serial_numbers'] ?? [] as $snKey=>$sn)
                                <div class="snInputs-c card custom-card card-body card-draggable tx-white p-1" snInputsIndex="{{$snKey + 1}}">
                                    <div class="input-group">
                                        <div class="input-group-append" style="cursor: move">
                                            <span class="input-group-text">
                                                <i class="ti-move"></i>
                                            </span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text sn-rank">{{$snKey+1}}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>


                        <div class="col-lg-4" style="max-height: 400px;overflow-y: auto">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 230px" id="basic-addon1">{{\App\CPU\Helpers::translate('product_code')}}</span>
                                </div>

                                <input value="{{$products[$key]['code']}}" name="options_values[{{$values_sections}}][code]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('product_code')}}*" type="text" required>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 230px" id="basic-addon1">{{\App\CPU\Helpers::translate('gtin')}}</span>
                                </div>
                                <input value="{{$products[$key]['gtin']}}" name="options_values[{{$values_sections}}][gtin]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('gtin')}}*" type="text" required>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 230px" id="basic-addon1">{{\App\CPU\Helpers::translate('mpn')}}</span>
                                </div>
                                <input value="{{$products[$key]['mpn']}}" name="options_values[{{$values_sections}}][mpn]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('mpn')}}*" type="text" required>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 230px" id="basic-addon1">{{\App\CPU\Helpers::translate('HS Code')}}</span>
                                </div>
                                <input value="{{$products[$key]['hs_code']}}" name="options_values[{{$values_sections}}][hs_code]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('HS Code')}}*" type="text" required>
                            </div>






                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('Length')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['length']}}" name="options_values[{{$values_sections}}][length]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Length')}}*" type="text" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('Width')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['width']}}" name="options_values[{{$values_sections}}][width]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Width')}}*" type="text" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('Height')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['height']}}" name="options_values[{{$values_sections}}][height]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Height')}}*" type="text" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('Size')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['size']}}" name="options_values[{{$values_sections}}][size]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Size')}}*" type="text" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('space')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['space']}}" name="options_values[{{$values_sections}}][space]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('space')}}*" type="text" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('weight')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['weight']}}" name="options_values[{{$values_sections}}][weight]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('weight')}}*" type="text" required>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text bg-primary text-light text-start">
                                            <span class="text-start" style="width: 40px" id="basic-addon1">{{\App\CPU\Helpers::translate('Unit')}}</span>
                                        </div>
                                        <div class="form-control p-0">
                                            <select
                                                class="js-example-basic-multiple js-states js-example-responsive form-control"
                                                name="options_values[{{$values_sections}}][unit]">
                                                @foreach(\App\CPU\Helpers::units() as $x)
                                                    <option
                                                        value={{$x}} {{ $product['unit']==$x ? 'selected' : ''}}>{{$x}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="width: 72px" id="basic-addon1">{{\App\CPU\Helpers::translate('Made in')}}</span>
                                        </div>
                                        <input value="{{$products[$key]['made_in']}}" name="options_values[{{$values_sections}}][made_in]" aria-describedby="basic-addon1" class="form-control text-dark" placeholder="{{\App\CPU\Helpers::translate('Made in')}}*" type="text" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex wd-xl-100p wd-md-90p wd-sm-80p">
                        <a class="btn btn-white fs-30 btn-prev-pri"> <i class="fa fa-angle-right text-primary"></i> </a>
                        <div class="overflow-auto d-flex scroll-behavior-smooth mn-wd-sm-75p" id="product_pri_container">
                            @include('admin-views.product.optionsQuantityAndStock',['product'=>$products[$key],'index'=>$key])
                        </div>
                        <a class="btn btn-white fs-30 btn-next-pri"> <i class="fa fa-angle-left text-primary"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- accordion -->
</div>
@php
    $values_sections++;
@endphp
{{--  accordion end  --}}
@endforeach
