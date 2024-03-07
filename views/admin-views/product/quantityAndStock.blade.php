@php($plevels = Helpers::getPricingLevels())
<div class="card mt-2 rest-part">
    <div class="card-header p-3 tx-medium my-auto tx-white bg-primary">
        <div class="d-flex btn text-white w-100" onclick="$(this).closest('.card-header').next('.foldable-section').slideToggle();$(this).closest('.card-header').find('.toggleAngle').toggle()">
            <h4 class="ml-2 mr-2 pt-2 text-white">
                <i class="fa fa-angle-up toggleAngle" style=""></i>
                <i class="fa fa-angle-down toggleAngle" style="display:none"></i>
            </h4>
            <h5 class="mt-2 text-white">{{Helpers::translate("Product price & stock")}}</h5>
        </div>
    </div>
    <div class="card-body pt-0 px-3 foldable-section row" style="display: none">
        <div class="form-group col-lg-4">
            <label class="form-label">
                <br/>
            </label>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="bg-light px-2 py-1">
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{Helpers::translate('Purchase price')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <input type="number" min="0" step="0.01"
                            placeholder="{{Helpers::translate('Purchase price') }}"
                            name="purchase_price" class="form-control" dir="{{ session()->get('direction') }}"
                            value={{ \App\CPU\Convert::default($product->purchase_price) }} required>
                        </div>
                      </div>
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{Helpers::translate('Quantity')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <input type="number" min="0" value={{ $product->current_stock }} step="1" dir="{{ session()->get('direction') }}"
                            placeholder="{{Helpers::translate('Quantity') }}"
                            name="current_stock" class="form-control" required>
                        </div>
                      </div>
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{Helpers::translate('Min Quantity alert')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                          <input dir="rtl" name="min_quantity_alert" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('Min Quantity alert')}}" min="0" type="number" class="form-control" value="{{$product->min_quantity_alert}}">
                        </div>
                      </div>

                      @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                      <div class="my-4 input-group show_for_pricing_levels-container">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{Helpers::translate('Show product for pricing levels')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <select multiple class="text-dark SumoSelect-custom w-100 testselect2-custom"
                            onchange="$('input[name=show_for_pricing_levels]').val($(this).val().toString())"
                            >
                                @foreach ($plevels as $pl)
                                <option @if(in_array($pl->id,explode(',',$product->show_for_pricing_levels))) selected @endif value="{{$pl->id}}">
                                    {{ Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="show_for_pricing_levels" value="{{$product->show_for_pricing_levels}}">
                      </div>
                      @endif
                      @if($shippingType!=='order_wise')
                        <div class="my-4 input-group">
                            <div class="mb-2 mt-2 input-group" id="shipping_cost">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="width: auto; min-width: 230px; max-width: fit-content;">
                                        {{Helpers::translate('shipping_cost')}}
                                    </div>
                                </div>
                                <input type="number" min="0" value="{{\App\CPU\Convert::default($product->shipping_cost)}}" step="1"
                                        placeholder="{{Helpers::translate('shipping_cost')}}"
                                        name="shipping_cost" class="form-control" required>
                            </div>
                        </div>
                    @endif
                      <div class="input-group">

                          <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">
                            {{Helpers::translate('Has discount')}}
                        </span>
                        <div class="form-control p-0 text-center" dir="auto">
                            <div class="react-datepicker-wrapper" style="display: inline-block">
                                <div class="react-datepicker__input-container">

                                    <div class="w-100">
                                        <label class="ckbox">
                                            <input style="margin-bottom: -2px"
                                            @if($product->has_discount == '1')
                                            checked
                                            @endif
                                            type="checkbox">
                                        </label>

                                        <label class="switcher title-color">
                                            <input type="checkbox" class="switcher_input"
                                            value="1"
                                            onchange="$('input[name=has_discount]').val(event.target.checked ? 1 : 0);$('.discount_enabled').attr('readonly',!event.target.checked);$('#discount_pr').slideUp();if(event.target.checked){$('#discount_pr').slideDown()}"
                                            id="has_discount_check"
                                            inputsClass="publish_on_market"
                                            name="publish_on_market" {{($product->has_discount)?'checked':''}}>
                                            <span class="switcher_control"></span>
                                        </label>

                                    </div>

                                    <input type="hidden" name="has_discount">
                              </div>
                            </div>
                          </div>
                      </div>
                      <div id="discount_pr" style="display: none">
                        <div class="input-group">
                          <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{Helpers::translate('Starting date')}}</span>
                          <div class="form-control p-0 text-start " dir="auto">
                            <div class="react-datepicker-wrapper">
                              <div class="react-datepicker__input-container">
                                <input type="date" name="start_time" class="form-control" value="{{$product['start_time']}}">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="input-group">
                          <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{Helpers::translate('Ending date')}}</span>
                          <div class="form-control p-0 text-start " dir="auto">
                            <div class="react-datepicker-wrapper">
                              <div class="react-datepicker__input-container">
                                <input type="date" name="end_time" class="form-control" value="{{$product['end_time']}}">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-lg-8">
            <div class="d-flex mx-3 overflow-auto h-100">
                {{--    --}}
                <div class="px-3 py-1" style="min-width: 350px;">
                    <label class="form-label">
                        {{ Helpers::translate('Default pricing level') }}
                    </label>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('selling_price')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="unit_price" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('selling_price')}}" min="0" type="number" class="form-control"
                        value="{{$product->unit_price ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('Min quantity per order')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="min_quantity" aria-describedby="basic-addon1"  placeholder="{{Helpers::translate('(for direct purchase)')}}" min="0" type="number" class="form-control"
                        value="{{$product->min_quantity ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('Max quantity per order')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="max_quantity" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('(for direct purchase)')}}" min="0" type="number" class="form-control"
                        value="{{$product->max_quantity ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('discount_type')}}</span>
                        <div class="form-control p-0 text-start">
                            <select class="js-example-basic-multiple js-states js-example-responsive demo-select2 w-100" name="discount_type">
                                <option value="percent" {{($product->discount_type ?? '')=='percent'?'selected':''}}>{{Helpers::translate('Percent')}}</option>
                                <option value="flat" {{($product->discount_type ?? '')=='flat'?'selected':''}}>{{Helpers::translate('Flat')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('Discount')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="discount" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('Discount Price')}}" min="0" type="number" @if($product->has_discount !== '1') readonly @endif class="form-control discount_enabled"
                        value="{{$product['the_discount'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('suggested price')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="suggested_price" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('suggested price')}}" min="0" type="number" class="form-control"
                        value="{{$product['suggested_price'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="input-group mb-0  p-0 pb-0">
                        <div class="w-100 border p-1">
                            <label for="props[selected_countries_show_quantity_always]">
                                {{ \App\CPU\Helpers::translate('Show product') }}:
                            </label>
                            <div class="">
                                <label class="rdiobox">
                                    <input   name="display_for" @if(($product->display_for ?? '') == "purchase") checked @endif value="purchase" type="radio" >
                                    <span>{{ \App\CPU\Helpers::translate('to purchase') }}</span></label>
                            </div>
                            <div class="">
                                <label class="rdiobox">
                                    <input  name="display_for" @if(($product->display_for ?? '') == "add") checked @endif value="add" type="radio" >
                                    <span>{{ \App\CPU\Helpers::translate('to add') }}</span></label>
                            </div>
                            <div class="mg-t-20 mg-lg-t-0">
                                <label class="rdiobox">
                                    <input name="display_for" @if(($product->display_for ?? '') == "both") checked @endif value="both" type="radio" >
                                    <span>{{ \App\CPU\Helpers::translate('Both') }}:</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                {{--    --}}

                @foreach ($plevels as $index=>$pl)
                <div class="px-3 py-1" style="min-width: 350px;">
                    <label class="form-label">
                        {{ Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }}
                    </label>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('selling_price')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input hidden name="pricing[{{$pl->id}}][pricing_level_id]" value="{{$pl->id}}">
                        <input dir="rtl" name="pricing[{{$pl->id}}][value]" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('selling_price')}}" min="0" type="number" class="form-control"
                        value="{{$product['pricing'][$pl->id]['value'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('Min quantity per order')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="pricing[{{$pl->id}}][min_qty]" aria-describedby="basic-addon1"  placeholder="{{Helpers::translate('(for direct purchase)')}}" min="0" type="number" class="form-control"
                        value="{{$product['pricing'][$pl->id]['min_qty'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('Max quantity per order')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="pricing[{{$pl->id}}][max_qty]" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('(for direct purchase)')}}" min="0" type="number" class="form-control"
                        value="{{$product['pricing'][$pl->id]['max_qty'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('discount_type')}}</span>
                        <div class="form-control p-0 text-start">
                            <select class="js-example-basic-multiple js-states js-example-responsive demo-select2 w-100" name="pricing[{{$pl->id}}][discount_type]">
                                <option value="percent" {{($product['pricing'][$pl->id]['discount_type'] ?? '')=='percent'?'selected':''}}>{{Helpers::translate('Percent')}}</option>
                                <option value="flat" {{($product['pricing'][$pl->id]['discount_type'] ?? '')=='flat'?'selected':''}}>{{Helpers::translate('Flat')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('Discount')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="pricing[{{$pl->id}}][discount_price]" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('Discount Price')}}" min="0" type="number" @if($product->has_discount !== '1') readonly @endif class="form-control discount_enabled"
                        value="{{$product['pricing'][$pl->id]['discount_price'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="my-4 input-group">
                      <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 155px; max-width: fit-content;">{{Helpers::translate('suggested price')}}</span>
                      <div class="form-control p-0 text-start " dir="auto">
                        <input dir="rtl" name="pricing[{{$pl->id}}][suggested_price]" aria-describedby="basic-addon1" placeholder="{{Helpers::translate('suggested price')}}" min="0" type="number" class="form-control"
                        value="{{$product['pricing'][$pl->id]['suggested_price'] ?? ''}}"
                        >
                      </div>
                    </div>
                    <div class="input-group mb-0  p-0 pb-0">
                        <div class="w-100 border p-1">
                            <label for="props[selected_countries_show_quantity_always]">
                                {{ \App\CPU\Helpers::translate('Show product') }}:
                            </label>
                            <div class="">
                                <label class="rdiobox">
                                    <input   name="pricing[{{$pl->id}}][display_for]" @if(($product['pricing'][$pl->id]['display_for'] ?? '') == "purchase") checked @endif value="purchase" type="radio" >
                                    <span>{{ \App\CPU\Helpers::translate('to purchase') }}</span></label>
                            </div>
                            <div class="">
                                <label class="rdiobox">
                                    <input  name="pricing[{{$pl->id}}][display_for]" @if(($product['pricing'][$pl->id]['display_for'] ?? '') == "add") checked @endif value="add" type="radio" >
                                    <span>{{ \App\CPU\Helpers::translate('to add') }}</span></label>
                            </div>
                            <div class="mg-t-20 mg-lg-t-0">
                                <label class="rdiobox">
                                    <input name="pricing[{{$pl->id}}][display_for]" @if(($product['pricing'][$pl->id]['display_for'] ?? '') == "both") checked @endif value="both" type="radio" >
                                    <span>{{ \App\CPU\Helpers::translate('Both') }}:</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </div>
</div>
