<div class="w-100">
    <div class="card-header">
        <h4>{{\App\CPU\Helpers::translate('Product price & stock')}}</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="bg-light px-2 py-1">
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Purchase price')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <input type="number" min="0" step="0.01"
                            placeholder="{{\App\CPU\Helpers::translate('Purchase price') }}"
                            name="options_values[{{$index}}][purchase_price]" class="form-control"
                            value={{ \App\CPU\Convert::default($product->purchase_price) }} required>
                        </div>
                      </div>
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Quantity')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <input type="number" min="0" value={{ $product->current_stock }} step="1"
                            placeholder="{{\App\CPU\Helpers::translate('Quantity') }}"
                            name="options_values[{{$index}}][current_stock]" class="form-control" required>
                        </div>
                      </div>
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Min Quantity alert')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                          <input dir="rtl" name="options_values[{{$index}}][min_quantity_alert]" aria-describedby="basic-addon1" placeholder="{{\App\CPU\Helpers::translate('Min Quantity alert')}}" min="0" type="text" class="form-control" value="{{$product->min_quantity_alert}}">
                        </div>
                      </div>
                      <div class="my-4 input-group">
                        <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Show product for pricing levels')}}</span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <select multiple class="text-dark SumoSelect-custom multiselect w-100 testselect2-custom"
                            onchange="$('input[name=show_for_pricing_levels]').val($(this).val().toString())"
                            >
                                @foreach (\App\CPU\Helpers::getPricingLevels() as $pl)
                                <option @if(in_array($pl->id,explode(',',$product->show_for_pricing_levels))) selected @endif value="{{$pl->id}}">
                                    {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$pl['id'],'name') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="options_values[{{$index}}][show_for_pricing_levels]" value="{{$product->show_for_pricing_levels}}">
                      </div>
                      <div class="input-group">

                          <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">
                            {{\App\CPU\Helpers::translate('Has discount')}}
                        </span>
                        <div class="form-control p-0 text-start " dir="auto">
                            <div class="react-datepicker-wrapper">
                                <div class="react-datepicker__input-container">
                                    <input
                                    @if($product->has_discount == '1')
                                    checked
                                    @endif
                                    name="options_values[{{$index}}][has_discount]"
                                    type="checkbox" class="form-control" value="1">
                                    <input type="hidden">
                              </div>
                            </div>
                          </div>
                      </div>
                      <div hidden="">
                        <div class="input-group">
                          <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Starting date')}}</span>
                          <div class="form-control p-0 text-start " dir="auto">
                            <div class="react-datepicker-wrapper">
                              <div class="react-datepicker__input-container">
                                <input type="text" name="options_values[{{$index}}][start_time]" class="form-control" value="">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="input-group">
                          <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 230px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Ending date')}}</span>
                          <div class="form-control p-0 text-start " dir="auto">
                            <div class="react-datepicker-wrapper">
                              <div class="react-datepicker__input-container">
                                <input type="text" name="options_values[{{$index}}][end_time]" class="form-control" value="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-12">
                    <div class="d-flex mx-3 overflow-auto h-100">

                        @foreach (\App\CPU\Helpers::getPricingLevelsValues($product['id']) as $plIndex=>$pl)
                        <div class="px-3 py-1" style="min-width: 300px;">
                            <label class="form-label">
                                {{ \App\CPU\Helpers::getTranslation('App\Model\pricing_levels',$pl['id'],'name') }}
                            </label>
                            <div class="my-4 input-group">
                              <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 180px; max-width: fit-content;">{{\App\CPU\Helpers::translate('selling_price')}}</span>
                              <div class="form-control p-0 text-start " dir="auto">
                                <input hidden name="options_values[{{$index}}][pricing][{{$plIndex}}][pricing_level_id]" value="{{$pl->id}}">
                                <input dir="rtl" name="options_values[{{$index}}][pricing][{{$plIndex}}][value]" aria-describedby="basic-addon1" placeholder="{{\App\CPU\Helpers::translate('selling_price')}}" min="0" type="number" class="form-control"
                                value="{{$product['pricing'][$plIndex]['value'] ?? ''}}"
                                >
                              </div>
                            </div>
                            <div class="my-4 input-group">
                              <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 180px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Min quantity per order')}}</span>
                              <div class="form-control p-0 text-start " dir="auto">
                                <input dir="rtl" name="options_values[{{$index}}][pricing][{{$plIndex}}][min_qty]" aria-describedby="basic-addon1"  placeholder="{{\App\CPU\Helpers::translate('Min quantity per order')}}" min="0" type="number" class="form-control"
                                value="{{$product['pricing'][$plIndex]['min_qty'] ?? ''}}"
                                >
                              </div>
                            </div>
                            <div class="my-4 input-group">
                              <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 180px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Max quantity per order')}}</span>
                              <div class="form-control p-0 text-start " dir="auto">
                                <input dir="rtl" name="options_values[{{$index}}][pricing][{{$plIndex}}][max_qty]" aria-describedby="basic-addon1" placeholder="{{\App\CPU\Helpers::translate('Max quantity per order')}}" min="0" type="number" class="form-control"
                                value="{{$product['pricing'][$plIndex]['max_qty'] ?? ''}}"
                                >
                              </div>
                            </div>
                            <div class="my-4 input-group">
                              <span class="custom-input-group-text input-group-text bg-primary text-light" style="width: auto; min-width: 180px; max-width: fit-content;">{{\App\CPU\Helpers::translate('Discount Price')}}</span>
                              <div class="form-control p-0 text-start " dir="auto">
                                <input dir="rtl" name="options_values[{{$index}}][pricing][{{$plIndex}}][discount_price]" aria-describedby="basic-addon1" placeholder="{{\App\CPU\Helpers::translate('Discount Price')}}" min="0" type="number" @if($product->has_discount !== '1') readonly @endif class="form-control discount_enabled"
                                value="{{$product['pricing'][$plIndex]['discount_price'] ?? ''}}"
                                >
                              </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
