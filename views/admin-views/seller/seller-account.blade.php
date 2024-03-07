<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            @if(!isset($profile))
            <div class="row p-5">
                <h5 class="mb-0 col-1">{{\App\CPU\Helpers::translate('Seller Account')}}</h5>
                @if ($seller->status=="pending")
                <div class="col-4 float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                    <div class="flex-start">
                        <h4 class="mx-1"><i class="tio-shop-outlined"></i></h4>
                        <div><h4>{{\App\CPU\Helpers::translate('Seller_request_for_open_a_shop.')}}</h4></div>
                    </div>
                    <div>
                        <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$seller->id}}">
                            <input type="hidden" name="status" value="approved">
                            <button type="submit"
                                    class="btn btn--primary btn-primary btn-sm">{{\App\CPU\Helpers::translate('Approve')}}</button>
                        </form>
                        <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$seller->id}}">
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit"
                                    class="btn btn-danger btn-sm">{{\App\CPU\Helpers::translate('reject')}}</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @endif
            @if(!isset($profile))
            <div class="row px-5">
                <div class="col-1">
                    <div><h4>{{\App\CPU\Helpers::translate('Status')}}: </h4></div>
                    <div class="mx-1">
                        <h4>{!! $seller->status=='approved'?'<label class="badge badge-success">'.Helpers::translate('Active_').'</label>':'<label class="badge badge-danger">'.Helpers::translate('In-Active').'</label>' !!}</h4>
                    </div>
                </div>
                <div class="col-2">

                @if($seller->status=='approved')
                <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                    @csrf
                    <input type="hidden" @if(!isset($profile)) name="id" @else disabled @endif value="{{$seller->id}}">
                    <input type="hidden" @if(!isset($profile)) name="status" @else disabled @endif value="suspended">
                    <button type="submit"
                            class="btn btn-sm btn-outline-danger">{{\App\CPU\Helpers::translate('suspend')}}</button>
                </form>
                @elseif($seller->status=='rejected' || $seller->status=='suspended')
                    <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                        @csrf
                        <input type="hidden" @if(!isset($profile)) name="id" @else disabled @endif value="{{$seller->id}}">
                        <input type="hidden" @if(!isset($profile)) name="status" @else disabled @endif value="approved">
                        <button type="submit"
                                class="btn btn-outline-success">{{\App\CPU\Helpers::translate('activate')}}</button>
                    </form>
                @endif
                </div>
            </div>
            @endif
            <form class="card-body" method="POST" id="seller_form"
            enctype="multipart/form-data"
            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                @csrf

                @if (!isset($profile))
                <div class="row">
                    <div class="input-group mb-2 bg-light p-3">
                        <div class="w-100">
                            <label class="ckbox">
                                <input class="switch_inputs" value="1" name="show_sellers_section"  @if ($seller->show_sellers_section ?? true) checked @endif type="checkbox"><span>{{\App\CPU\Helpers::translate('show on store')}}</span></label>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="form-group col-auto">
                        <label>{{\App\CPU\Helpers::translate('Vendor Account number')}}: </label>
                        <input @if(!isset($profile)) name="vendor_account_number" @else disabled @endif class="form-control" value="{{$seller->vendor_account_number}}" style="width: 120px" />
                    </div>
                    <div class="form-group col-lg-2">
                        <label>{{\App\CPU\Helpers::translate('company_name')}}: </label>
                        <input @if(!isset($profile)) name="shop[name]" @else disabled @endif class="form-control" value="{{$seller->shop->name ?? ''}}" />
                    </div>
                    <div class="form-group col-lg-2">
                        <label>{{\App\CPU\Helpers::translate('license_owners_name')}}: </label>
                        <input @if(!isset($profile)) name="name" @else disabled @endif class="form-control" value="{{$seller->name}}" />
                    </div>

                    <div class="form-group col-lg-2">
                        <label>{{\App\CPU\Helpers::translate('license owners phone')}}: </label>
                        <input @if(!isset($profile)) name="phone" @else disabled @endif class="form-control phoneInput text-left" dir="ltr" value="{{$seller->phone ?? '+966'}}" />
                    </div>

                    <div class="form-group col-lg-2">
                        <label>{{\App\CPU\Helpers::translate('Email')}}: </label>
                        <input readonly onclick="$(this).removeAttr('readonly')" @if(!isset($profile)) name="email" @else disabled @endif class="form-control" value="{{$seller->email}}" />
                    </div>

                    <div class="form-group col-lg-2">
                        <label>{{\App\CPU\Helpers::translate('Password')}}: </label>
                        <input readonly onclick="$(this).removeAttr('readonly')" type="password" @if(!isset($profile)) name="password" @else disabled @endif class="form-control" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>{{\App\CPU\Helpers::translate('delegates_name')}}: </label>
                                <input @if(!isset($profile)) name="delegate_name" @else disabled @endif class="form-control" value="{{$seller->delegate_name}}" />
                            </div>
                            <div class="form-group col-lg-3">
                                <label>{{\App\CPU\Helpers::translate('delegates_phone')}}: </label>
                                <input @if(!isset($profile)) name="delegate_phone" @else disabled @endif class="form-control phoneInput" dir="ltr" value="{{$seller->delegate_phone ?? '+966'}}" />
                            </div>

                            <div class="form-group col-lg-3">
                                <label>{{\App\CPU\Helpers::translate('seller_commercial_registration_no')}}: </label>
                                <input type="number" @if(!isset($profile)) name="commercial_registration_no" @else disabled @endif class="form-control" value="{{$seller->commercial_registration_no}}" />
                            </div>
                            <div class="form-group col-lg-3">
                                <label>{{\App\CPU\Helpers::translate('seller tax number')}}: </label>
                                <input @if(!isset($profile)) name="tax_no" @else disabled @endif class="form-control" value="{{$seller->tax_no}}" type="number" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label>{{\App\CPU\Helpers::translate('country')}}: </label>
                                    <select @if(!isset($profile)) name="country" @else disabled @endif class="form-control SumoSelect-custom changeOnLoad" onchange="getChildren('areas','select.seller-area',event.target.value)">
                                        <option></option>
                                        @foreach (\App\CPU\Helpers::getCountries() as $country)
                                            <option @if($country->id == $seller->country) selected @endif value="{{ $country->id }}" icon="{{ $country->photo }}">
                                                {{ \App\CPU\Helpers::getItemName('countries','name',$country->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label>{{\App\CPU\Helpers::translate('area')}}: </label>
                                    <select @if(!isset($profile)) name="area" @else disabled @endif class="form-control SumoSelect-custom seller-area" onchange="getChildren('cities','select.seller-city',event.target.value)">
                                        <option value="{{$seller->area}}" selected>{{ \App\CPU\Helpers::getItemName('areas','name',$seller->area) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label>{{\App\CPU\Helpers::translate('City')}}: </label>
                                    <select @if(!isset($profile)) name="city" @else disabled @endif class="form-control SumoSelect-custom seller-city" onchange="getChildren('provinces','select.seller-governorate',event.target.value)">
                                        <option value="{{$seller->city}}" selected>{{ \App\CPU\Helpers::getItemName('cities','name',$seller->city) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label>{{\App\CPU\Helpers::translate('governorate')}}: </label>
                                    <select @if(!isset($profile)) name="governorate" @else disabled @endif class="form-control SumoSelect-custom seller-governorate">
                                        <option value="{{$seller->governorate}}" selected>{{ \App\CPU\Helpers::getItemName('provinces','name',$seller->governorate) }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{\App\CPU\Helpers::translate('the address')}}: </label>
                                    <input @if(!isset($profile)) name="address" @else disabled @endif class="form-control" value="{{$seller->address}}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="mb-4">
                                        <p class="locations-card-body w-100 pos-relative wd-150px">
                                            <div id="location_map_canvas"></div>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Coordinates')}} - {{Helpers::translate('longitude')}} : </label>
                                            <input @if(!isset($profile)) name="lon" id="longitude"  @else disabled @endif aria-describedby="basic-addon1" value="{{$seller->lon}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Coordinates')}} - lon" type="text" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{\App\CPU\Helpers::translate('Coordinates')}} - {{Helpers::translate('latitude')}} : </label>
                                            <input @if(!isset($profile)) name="lat" id="latitude"  @else disabled @endif aria-describedby="basic-addon1" value="{{$seller->lat}}" class="form-control" placeholder="{{\App\CPU\Helpers::translate('Coordinates')}} - lat" type="text" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"> {{\App\CPU\Helpers::translate('bank_info')}}</h5>
                            </div>
                            <div class="card-body"
                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                <div class="mt-2">
                                    <div class="form-group">
                                        <label>{{\App\CPU\Helpers::translate('bank_name')}}:</label>
                                        <input @if(!isset($profile)) name="bank_name" @else disabled @endif class="form-control" value="{{$seller->bank_name}}" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{\App\CPU\Helpers::translate('Branch')}}:</label>
                                        <input @if(!isset($profile)) name="branch" @else disabled @endif class="form-control" value="{{$seller->branch}}" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{\App\CPU\Helpers::translate('holder_name')}}:</label>
                                        <input @if(!isset($profile)) name="holder_name" @else disabled @endif class="form-control" value="{{$seller->holder_name}}" />
                                    </div>
                                    <div class="form-group">
                                        <label>{{\App\CPU\Helpers::translate('account_no')}}:</label>
                                        <input @if(!isset($profile)) name="account_no" @else disabled @endif class="form-control" value="{{$seller->account_no}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="form-group col-lg-3">
                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-6 mt-4 px-6"></ul>
                            <center>
                                <img class="upload-img-view" id="viewer1"
                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                src="{{asset('storage/app/public/shop')}}/{{$seller->shop->image ?? null}}"/>
                                <label class="w-100">{{\App\CPU\Helpers::translate('Seller logo')}}</label>
                            </center>

                            <div class="form-group">
                                @if(!isset($profile))
                                <div class="custom-file text-left">
                                    <input type="file" @if(!isset($profile)) name="image" @else disabled @endif id="customFileUpload1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                </div>
                                @endif
                            </div>
                    </div>

                    <div class="form-group col-lg-3">
                            <ul class="nav nav-tabs lightSliderr w-fit-content mb-0 px-6">
                                @foreach(Helpers::get_langs() as $lang)
                                    <li class="nav-item text-capitalize">
                                        <a class="nav-link lang_link {{$lang == ($default_lang ?? session()->get('local')) ? 'active':''}}"
                                            role="button"
                                        id="{{$lang}}-link"><img class="ml-2" width="20" src="{{asset('public/assets/front-end')}}/img/flags/{{$lang}}.png">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @foreach(Helpers::get_langs() as $lang)
                            <input type="hidden" name="lang[]" value="{{$lang}}">
                            <div class="form-group {{$lang != ($default_lang ?? session()->get('local')) ? 'd-none':''}} lang_form mt-3"
                                id="{{$lang}}-form">
                                <center>
                                        <img class="upload-img-view viewer"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/shop/banner')}}/{{Helpers::get_prop('App\Model\Seller',$seller['id'],'banner',$lang) ?? $seller->shop->banner ?? ''}}" />
                                        <label class="w-100">{{\App\CPU\Helpers::translate('Seller Banner')}}</label>
                                </center>

                                <div class="">
                                    @if(!isset($profile))
                                    <div class="custom-file text-left banner-control">
                                        <input type="file" @if(!isset($profile)) name="banner[{{$lang}}]" @else disabled @endif class="custom-file-input customFileEg1"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload image')}}</label>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                    </div>

                    <div class="form-group col-lg-3">
                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-6 mt-4 px-6"></ul>
                        <center>
                            <img class="upload-img-view" id="viewer2"
                            onerror="this.src='{{$seller->commercial_registration_img ? asset('public/assets/front-end/img/download.png') : asset('public/assets/front-end/img/image-place-holder.png')}}'"
                            @if($seller->commercial_registration_img)
                            role="button"
                            onclick="window.open('{{asset('storage/app/public/seller')}}/{{$seller->commercial_registration_img}}')"
                            @endif
                            src="{{asset('storage/app/public/seller')}}/{{$seller->commercial_registration_img}}"/>
                            <label class="w-100">{{\App\CPU\Helpers::translate('seller_commercial_registration_image')}} {{ Helpers::translate('(attachment)') }}</label>
                        </center>
                    @if(!isset($profile))
                        <div class="custom-file text-left">
                            <input type="file" @if(!isset($profile)) name="commercial_registration_img" @else disabled @endif id="customFileUpload2" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .pdf, .doc, .docx|image/*">
                            <label class="custom-file-label" for="customFileUpload">{{\App\CPU\Helpers::translate('Upload file')}}</label>
                        </div>
                    @endif
                    </div>

                    <div class="form-group col-lg-3">
                        <ul class="nav nav-tabs lightSliderr w-fit-content mb-6 mt-4 px-6"></ul>
                        <center>
                            <img class="upload-img-view" id="viewer3"
                                src="{{asset('storage/app/public/seller')}}/{{$seller->tax_certificate_img}}"
                                @if($seller->tax_certificate_img)
                                role="button"
                                onclick="window.open('{{asset('storage/app/public/seller')}}/{{$seller->tax_certificate_img}}')"
                                @endif
                                onerror="this.src='{{$seller->tax_certificate_img ? asset('public/assets/front-end/img/download.png') : asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                alt="banner image"/>
                                <label class="w-100">{{\App\CPU\Helpers::translate('seller_tax_certificate_image')}} {{ Helpers::translate('(attachment)') }}</label>
                        </center>
                    @if(!isset($profile))
                        <div class="custom-file text-left">
                            <input type="file" @if(!isset($profile)) name="tax_certificate_img" @else disabled @endif id="customFileUpload3" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff, .pdf, .doc, .docx|image/*">
                            <label class="custom-file-label" for="tax_certificate_img">{{\App\CPU\Helpers::translate('Upload file')}}</label>
                        </div>
                    @endif
                    </div>
                </div>


            </form>
            @if(!isset($profile))
            <div class="d-flex justify-content-end gap-3" @if(!isset($profile)) hidden @endif>
                <button onclick="check()" type="reset" id="reset" class="btn btn-secondary px-4" hidden>{{ \App\CPU\Helpers::translate('reset')}}</button>
                <button onclick="check()" type="submit" class="btn btn--primary btn-primary btn-save px-4" @if(!isset($profile)) hidden @endif>{{ \App\CPU\Helpers::translate('update')}}</button>
            </div>
            @endif
        </div>
    </div>

    @push('script')
        <script>
            function check() {
                $(".error_required").removeClass('error_required');
                $(".error_required_message").remove();
                var formData = new FormData(document.getElementById('seller_form'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: @isset($seller->id) '{{route("admin.sellers.change",$seller->id)}}' @else '{{route("admin.sellers.seller-add")}}' @endisset
                    ,data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.errors) {
                            for (var i = 0; i < data.errors.length; i++) {
                                if(data.errors[i].code == "brand_id"){
                                    $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").insertBefore(".brand_id_div");
                                }
                                var nm = data.errors[i].code.indexOf('.') >= 0 ? data.errors[i].code.replace('.','[')+']' : data.errors[i].code;
                                var nmEmptyBrackets
                                var result = nm.match(/\[(.*)\]/);
                                if(result){
                                    nmEmptyBrackets = nm.replace(result[0],'[]')
                                    if(!isNaN(parseInt(result[1]))){
                                        nm = nm.replace(result[0],'[]')
                                    }
                                }
                                if(nm == "country"){
                                    $(".sumo_country").addClass("error_required");
                                }
                                if(nm == "area"){
                                    $(".sumo_area").addClass("error_required");
                                }
                                if(nm == "city"){
                                    $(".sumo_city").addClass("error_required");
                                }
                                if(nm == "governorate"){
                                    $(".sumo_governorate").addClass("error_required");
                                }
                                if(nm == "image"){
                                    $("input[name='"+nm+"']").parent().addClass("error_required");
                                }
                                if(nm == "banner"){
                                    $(".banner-control").addClass("error_required");
                                }
                                if(nm == "commercial_registration_img"){
                                    $("input[name='"+nm+"']").parent().addClass("error_required");
                                }
                                if(nm == "tax_certificate_img"){
                                    $("input[name='"+nm+"']").parent().addClass("error_required");
                                }
                                $("input[name='"+nm+"']").addClass("error_required");
                                $("input[name='"+nm+"']").closest('.foldable-section').slideDown();
                                $("<span class='error_required_message text-danger'>"+data.errors[i].message+"</span>").appendTo($("input[name='"+nm+"']").closest('.form-group'));
                            }
                            toastr.error("{{ Helpers::translate('Please fill all red bordered fields') }}", {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        } else {
                            $('#seller_form').submit();
                        }
                    }
                });
            }
        </script>
        <script>
            @php($dir = session()->get('direction'))
            if($(".lightSliderr").hasClass("lightSlider")){}else{
                $(".lightSliderr").lightSlider({
                    rtl: {{ ($dir == 'rtl') ? 'true' : 'false' }},
                    enableDrag:true,
                    enableTouch:true,
                    freeMove:true,
                    pager:false,
                    prevHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'right' : 'left' }}'></i></button>",
                    nextHtml:"<button class='btn btn-primary'><i class='fa fa-angle-{{ ($dir == 'rtl') ? 'left' : 'right' }}'></i></button>",
                });
            }

            $(".lang_link").click(function (e) {
                e.preventDefault();
                $(".lang_link").removeClass('active');
                $(".lang_form").addClass('d-none');
                $(this).addClass('active');

                let form_id = this.id;
                let lang = form_id.split("-")[0];
                console.log(lang);
                $("#" + lang + "-form").removeClass('d-none');
                if (lang == '{{$default_lang ?? session()->get('local')}}') {
                    $(".from_part_2").removeClass('d-none');
                } else {
                    $(".from_part_2").addClass('d-none');
                }
            });
        </script>
        <script>
            function readURLBanner(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(input).closest('.form-group').find('.viewer').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".customFileEg1").change(function () {
                readURLBanner(this);
            });
        </script>
    @endpush

</div>
