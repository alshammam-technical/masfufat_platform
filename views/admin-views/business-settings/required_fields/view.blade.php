@extends('layouts.back-end.app')

@section('title', \App\CPU\Helpers::translate('required_fields'))

@push('css_or_js')

@endpush

@section('content')
@include('admin-views.business-settings.settings-inline-menu')
    <div class="content container-fluid" style="padding-{{(Session::get('direction') == 'rtl') ? 'right' : 'left'}}: 24%">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <i class="fa fa-star"></i>
                {{\App\CPU\Helpers::translate('required_fields')}}
            </h2>
        </div>
        @php($required_fields = json_decode(\App\Model\BusinessSetting::where('type','required_fields')->first()->value ?? '{}'))
        <form method="POST" action="{{route('admin.product-settings.updateBusinessDynamic',['prop'=>'required_fields','encode'=>1])}}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="input-group col-lg-3">
                            <label for="required_fields[products]" style="width: 250px">
                                {{ \App\CPU\Helpers::translate('Products') }}
                                <div class="form-control p-0">
                                    @php($products = explode(',',($required_fields->products ?? '[]')))
                                    <select id="products" class="SumoSelect-custom" multiple>
                                        <option @if(in_array('short_desc.*',$products)) selected @endif value="short_desc.*"> {{ \App\CPU\Helpers::translate('Brief description') }} </option>
                                        <option @if(in_array('promo_title.*',$products)) selected @endif value="promo_title.*"> {{ \App\CPU\Helpers::translate('Promo title') }} </option>
                                        <option @if(in_array('description.*',$products)) selected @endif value="description.*"> {{ \App\CPU\Helpers::translate('description') }} </option>
                                        <option @if(in_array('main_category',$products)) selected @endif value="main_category"> {{ \App\CPU\Helpers::translate('Main Category') }} </option>
                                        <option @if(in_array('item_number',$products)) selected @endif value="item_number"> {{ \App\CPU\Helpers::translate('Item Number') }} </option>
                                        <option @if(in_array('code',$products)) selected @endif value="code"> {{ \App\CPU\Helpers::translate('product_code_sku') }} </option>
                                        <option @if(in_array('gtin',$products)) selected @endif value="gtin"> {{ \App\CPU\Helpers::translate('gtin') }} </option>
                                        <option @if(in_array('mpn',$products)) selected @endif value="mpn"> {{ \App\CPU\Helpers::translate('mpn') }} </option>
                                        <option @if(in_array('hs_code',$products)) selected @endif value="hs_code"> {{ \App\CPU\Helpers::translate('HS Code') }} </option>
                                        <option @if(in_array('length',$products)) selected @endif value="length"> {{ \App\CPU\Helpers::translate('Length') }} </option>
                                        <option @if(in_array('width',$products)) selected @endif value="width"> {{ \App\CPU\Helpers::translate('Width') }} </option>
                                        <option @if(in_array('height',$products)) selected @endif value="height"> {{ \App\CPU\Helpers::translate('Height') }} </option>
                                        <option @if(in_array('size',$products)) selected @endif value="size"> {{ \App\CPU\Helpers::translate('Size') }} </option>
                                        <option @if(in_array('space',$products)) selected @endif value="space"> {{ \App\CPU\Helpers::translate('space') }} </option>
                                        <option @if(in_array('weight',$products)) selected @endif value="weight"> {{ \App\CPU\Helpers::translate('weight') }} </option>
                                        <option @if(in_array('unit',$products)) selected @endif value="unit"> {{ \App\CPU\Helpers::translate('Unit') }} </option>
                                        <option @if(in_array('made_in',$products)) selected @endif value="made_in"> {{ \App\CPU\Helpers::translate('Made in') }} </option>
                                        <option @if(in_array('color',$products)) selected @endif value="color"> {{ \App\CPU\Helpers::translate('color') }} </option>
                                        <option @if(in_array('current_stock',$products)) selected @endif value="current_stock"> {{ \App\CPU\Helpers::translate('Quantity') }} </option>
                                        <option @if(in_array('min_quantity_alert',$products)) selected @endif value="min_quantity_alert"> {{ \App\CPU\Helpers::translate('Min Quantity alert') }} </option>
                                        @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                                        <option @if(in_array('show_for_pricing_levels',$products)) selected @endif value="show_for_pricing_levels"> {{ \App\CPU\Helpers::translate('Show product for pricing levels') }} </option>
                                        @endif
                                        <option @if(in_array('unit_price',$products)) selected @endif value="unit_price"> {{ \App\CPU\Helpers::translate('selling_price') }} </option>
                                        <option @if(in_array('purchase_price',$products)) selected @endif value="purchase_price"> {{ \App\CPU\Helpers::translate('Purchase price') }} </option>
                                        <option @if(in_array('suggested_price',$products)) selected @endif value="suggested_price"> {{ \App\CPU\Helpers::translate('suggested price') }} </option>
                                        @php($admin_shipping = \App\Model\ShippingType::where('seller_id',0)->first())
                                        @php($shippingType =isset($admin_shipping)==true?$admin_shipping->shipping_type:'order_wise')
                                        @if($shippingType!=='order_wise')
                                        <option @if(in_array('shipping_cost',$products)) selected @endif value="shipping_cost"> {{ \App\CPU\Helpers::translate('shipping_cost') }} </option>
                                        @endif
                                        <option @if(in_array('meta_title',$products)) selected @endif value="meta_title"> {{ \App\CPU\Helpers::translate('Meta Title') }} </option>
                                        <option @if(in_array('meta_description',$products)) selected @endif value="meta_description"> {{ \App\CPU\Helpers::translate('Meta Description') }} </option>
                                        <option @if(in_array('meta_image',$products)) selected @endif value="meta_image"> {{ \App\CPU\Helpers::translate('Meta Image') }} </option>
                                        <option @if(in_array('video_link.*',$products)) selected @endif value="video_link.*"> {{ \App\CPU\Helpers::translate('Youtube video link') }} </option>
                                        <option @if(in_array('images',$products)) selected @endif value="images"> {{ \App\CPU\Helpers::translate('Upload product images') }} </option>
                                        <option @if(in_array('videos',$products)) selected @endif value="videos"> {{ \App\CPU\Helpers::translate('Upload product Videos') }} </option>
                                    </select>
                                </div>
                                <input type="hidden" name="required_fields[products]" value="{{$required_fields->products ?? ''}}">
                            </label>
                        </div>

                        <div class="input-group col-lg-3">
                            <label for="required_fields[categories]" style="width: 250px">
                                {{ \App\CPU\Helpers::translate('categories') }}
                                <div class="form-control p-0">
                                    @php($categories = explode(',',($required_fields->categories ?? '[]')))
                                    <select id="categories" class="SumoSelect-custom" multiple>
                                        <option @if(in_array('image',$categories)) selected @endif value="image"> {{ \App\CPU\Helpers::translate('Category Logo') }} </option>
                                        <option @if(in_array('icon',$categories)) selected @endif value="icon"> {{ \App\CPU\Helpers::translate('Category Icon') }} </option>
                                        <option @if(in_array('show_for_pricing_levels',$categories)) selected @endif value="show_for_pricing_levels"> {{ \App\CPU\Helpers::translate('Show category for pricing levels') }} </option>
                                    </select>
                                </div>
                                <input type="hidden" name="required_fields[categories]" value="{{$required_fields->categories ?? ''}}">
                            </label>
                        </div>

                        <div class="input-group col-lg-3">
                            <label for="required_fields[brands]" style="width: 250px">
                                {{ \App\CPU\Helpers::translate('brands') }}
                                <div class="form-control p-0">
                                    @php($brands = explode(',',($required_fields->brands ?? '[]')))
                                    <select id="brands" class="SumoSelect-custom" multiple>
                                        <option @if(in_array('image',$brands)) selected @endif value="image"> {{ \App\CPU\Helpers::translate('Brand Logo') }} </option>
                                        <option @if(in_array('show_for_pricing_levels',$brands)) selected @endif value="show_for_pricing_levels"> {{ \App\CPU\Helpers::translate('Show brand for pricing levels') }} </option>
                                    </select>
                                </div>
                                <input type="hidden" name="required_fields[brands]" value="{{$required_fields->brands ?? ''}}">
                            </label>
                        </div>

                        <div class="input-group col-lg-3">
                            <label for="required_fields[sellers]" style="width: 250px">
                                {{ \App\CPU\Helpers::translate('sellers') }}
                                <div class="form-control p-0">
                                    @php($sellers = explode(',',($required_fields->sellers ?? '[]')))
                                    <select id="sellers" class="SumoSelect-custom" multiple>
                                        <option @if(in_array('vendor_account_number',$sellers)) selected @endif value="vendor_account_number"> {{ \App\CPU\Helpers::translate('Vendor Account number') }} </option>
                                        <option @if(in_array('phone',$sellers)) selected @endif value="phone"> {{ \App\CPU\Helpers::translate('license owners phone') }} </option>
                                        <option @if(in_array('delegate_name',$sellers)) selected @endif value="delegate_name"> {{ \App\CPU\Helpers::translate('delegates_name') }} </option>
                                        <option @if(in_array('delegate_phone',$sellers)) selected @endif value="delegate_phone"> {{ \App\CPU\Helpers::translate('delegates_phone') }} </option>
                                        <option @if(in_array('commercial_registration_no',$sellers)) selected @endif value="commercial_registration_no"> {{ \App\CPU\Helpers::translate('seller_commercial_registration_no') }} </option>
                                        <option @if(in_array('tax_no',$sellers)) selected @endif value="tax_no"> {{ \App\CPU\Helpers::translate('seller tax number') }} </option>
                                        <option @if(in_array('country',$sellers)) selected @endif value="country"> {{ \App\CPU\Helpers::translate('country') }} </option>
                                        <option @if(in_array('area',$sellers)) selected @endif value="area"> {{ \App\CPU\Helpers::translate('area') }} </option>
                                        <option @if(in_array('city',$sellers)) selected @endif value="city"> {{ \App\CPU\Helpers::translate('City') }} </option>
                                        <option @if(in_array('governorate',$sellers)) selected @endif value="governorate"> {{ \App\CPU\Helpers::translate('governorate') }} </option>
                                        <option @if(in_array('address',$sellers)) selected @endif value="address"> {{ \App\CPU\Helpers::translate('the address') }} </option>
                                        <option @if(in_array('bank_name',$sellers)) selected @endif value="bank_name"> {{ \App\CPU\Helpers::translate('bank_name') }} </option>
                                        <option @if(in_array('branch',$sellers)) selected @endif value="branch"> {{ \App\CPU\Helpers::translate('Branch') }} </option>
                                        <option @if(in_array('holder_name',$sellers)) selected @endif value="holder_name"> {{ \App\CPU\Helpers::translate('holder_name') }} </option>
                                        <option @if(in_array('account_no',$sellers)) selected @endif value="account_no"> {{ \App\CPU\Helpers::translate('account_no') }} </option>
                                        <option @if(in_array('lat',$sellers)) selected @endif value="lat"> {{ \App\CPU\Helpers::translate('Coordinates') }} - (Lat) </option>
                                        <option @if(in_array('lon',$sellers)) selected @endif value="lon"> {{ \App\CPU\Helpers::translate('Coordinates') }} - (Lon) </option>
                                        <option @if(in_array('image',$sellers)) selected @endif value="image"> {{ \App\CPU\Helpers::translate('Seller logo') }} </option>
                                        <option @if(in_array('banner.*',$sellers)) selected @endif value="banner.*"> {{ \App\CPU\Helpers::translate('Seller Banner') }} </option>
                                        <option @if(in_array('commercial_registration_img',$sellers)) selected @endif value="commercial_registration_img"> {{ \App\CPU\Helpers::translate('seller_commercial_registration_image') }} </option>
                                        <option @if(in_array('tax_certificate_img',$sellers)) selected @endif value="tax_certificate_img"> {{ \App\CPU\Helpers::translate('seller_tax_certificate_image') }} </option>
                                    </select>
                                </div>
                                <input type="hidden" name="required_fields[sellers]" value="{{$required_fields->sellers ?? ''}}">
                            </label>
                        </div>

                        <div class="input-group col-lg-3">
                            <label for="required_fields[stores]" style="width: 250px">
                                {{ \App\CPU\Helpers::translate('stores') }}
                                <div class="form-control p-0">
                                    @php($stores = explode(',',($required_fields->stores ?? '[]')))
                                    <select id="stores" class="SumoSelect-custom" multiple>
                                        <option @if(in_array('vendor_account_number',$stores)) selected @endif value="vendor_account_number"> {{ \App\CPU\Helpers::translate('Store Account number') }} </option>
                                        <option @if(in_array('name',$stores)) selected @endif value="name"> {{ \App\CPU\Helpers::translate('license_owners_name') }} </option>
                                        <option @if(in_array('phone',$stores)) selected @endif value="phone"> {{ \App\CPU\Helpers::translate('license owners phone') }} </option>
                                        <option @if(in_array('delegate_name',$stores)) selected @endif value="delegate_name"> {{ \App\CPU\Helpers::translate('delegates_name') }} </option>
                                        <option @if(in_array('delegate_phone',$stores)) selected @endif value="delegate_phone"> {{ \App\CPU\Helpers::translate('delegates_phone') }} </option>
                                        <option @if(in_array('commercial_registration_no',$stores)) selected @endif value="commercial_registration_no"> {{ \App\CPU\Helpers::translate('commercial_registration_no') }} </option>
                                        <option @if(in_array('tax_no',$stores)) selected @endif value="tax_no"> {{ \App\CPU\Helpers::translate('tax number') }} </option>
                                        @if(\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? '')
                                        <option @if(in_array('pricing_level',$stores)) selected @endif value="pricing_level"> {{ \App\CPU\Helpers::translate('pricing level') }} </option>
                                        @endif
                                        <option @if(in_array('governorate',$stores)) selected @endif value="governorate"> {{ \App\CPU\Helpers::translate('governorate') }} </option>
                                        <option @if(in_array('address',$stores)) selected @endif value="address"> {{ \App\CPU\Helpers::translate('address') }} </option>
                                        <option @if(in_array('lat',$stores)) selected @endif value="lat">  {{ \App\CPU\Helpers::translate('Coordinates') }} - (Lat)  </option>
                                        <option @if(in_array('lon',$stores)) selected @endif value="lon">  {{ \App\CPU\Helpers::translate('Coordinates') }} - (Lon) </option>
                                        <option @if(in_array('image',$stores)) selected @endif value="image"> {{ \App\CPU\Helpers::translate('Store Image') }} </option>
                                        <option @if(in_array('commercial_registration_img',$stores)) selected @endif value="commercial_registration_img"> {{ \App\CPU\Helpers::translate('commercials_registrations_image') }} </option>
                                        <option @if(in_array('tax_certificate_img',$stores)) selected @endif value="tax_certificate_img"> {{ \App\CPU\Helpers::translate('shop_tax_certificates_image') }} </option>
                                    </select>
                                </div>
                                <input type="hidden" name="required_fields[stores]" value="{{$required_fields->stores ?? ''}}">
                            </label>
                        </div>


                    </div>
                    <div class="d-flex justify-content-end">
                        @if(Helpers::module_permission_check('required_fields.edit'))
                        <button type="submit" class="btn btn--primary btn-primary px-4">
                            {{ \App\CPU\Helpers::translate('save') }}
                        </button>
                        @endif
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();

            toastr.success("{{\App\CPU\Helpers::translate('Copied to the clipboard')}}");
        }
    </script>

@endpush
