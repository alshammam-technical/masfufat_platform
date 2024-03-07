<form method="post" id="offer_form" action="{{route('admin.abandoned-carts.send_offer',['cart_group_id'=>$cart_group_id ?? '111','id'=>$id ?? null])}}" class="col-md-12">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3>
                {{ Helpers::translate('discount') }}
            </h3>
        </div>
        <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            @isset($offer)
            @else
            <div class="row mt-5">
                <label class="w-100 mx-2">
                    {{ Helpers::translate('Discount if total equals or less than') }}:
                </label>
                <div class="col-5">
                    <div class="row w-100 mx-2 input-group">{{Helpers::translate('cart amount')}}</div>
                    <label class="row w-100 mx-2 input-group ">
                        <input type="number" inputmode="numeric" placeholder="{{Helpers::translate('cart amount')}}" name="offer[discount_if]" value="{{$o['discount_if'] ?? null}}" id="discount_if" class="form-control" />
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="text-dark">{{ Helpers::currency_code() }}</span>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="col-3">
                    <div class="row w-100 mx-2 input-group">{{Helpers::translate('The duration of leaving the basket')}}</div>
                    <label class="w-100 mx-2 input-group ">
                        <input type="text" name="offer[leaving_duration]" value="{{$o['leaving_duration'] ?? null}}" id="leaving_duration" class="form-control" />
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="text-dark">{{ Helpers::translate('hours') }}</span>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="col-auto text-center mt-5 pr-3 pl-0">
                    {{Helpers::translate('and')}}
                </div>
                <div class="col-3">
                    <div class="row w-100 mx-2 input-group" style="color: transparent">.</div>
                    <label class="w-100 mx-2 input-group ">
                        <input type="text" name="offer[leaving_duration_m]" value="{{$o['leaving_duration_m'] ?? null}}" id="leaving_duration_m" class="form-control" />
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="text-dark">{{ Helpers::translate('minutes') }}</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            @endisset
            <div class="row mt-5">
                <div class="col-11">
                    {{ Helpers::translate('When this condition is achieved') }}
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-10">
                    <label for="free_shipping" class="text-nowrap mx-2">
                        {{ Helpers::translate('give the customer a free shipping') }}
                    </label>
                </div>
                <div class="col-2">
                    <label class="switcher w-100 mx-2">
                        <input name="offer[free_shipping]" id="free_shipping" type="checkbox" class="switcher_input status" @if(($o['free_shipping'] ?? null) == "on") checked @endif />
                        <span class="switcher_control"></span>
                    </label>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-10">
                    <label for="cart_discount" class="text-nowrap mx-2 my-0">
                        {{ Helpers::translate('Granting the customer discount on the basket') }}
                        <div>
                        </div>
                    </label>
                </div>
                <div class="col-2">
                    <label class="switcher w-100 mx-2">
                        <input name="offer[cart_discount]" id="cart_discount" type="checkbox" class="switcher_input status"
                        @if($o['cart_discount'] ?? null) checked @endif
                        onchange="$('.discount_type').toggle()"
                        />
                        <span class="switcher_control"></span>
                    </label>
                </div>
            </div>

            <div class="row mt-5 discount_type" @if(($o['cart_discount'] ?? null) !== "on") style="display: none" @endif>
                <div class="col-6 form-control p-0 discount_type" @if(($o['cart_discount'] ?? null) !== "on") style="display: none" @endif>
                    <select name="offer[discount_type]" id="discount_type" class="my-0 SumoSelect-custom"
                    onchange="$('.discount_value').hide();$('.d_'+event.target.value).show();"
                    >
                        <option @if($o['discount_type'] ?? null == 'static_cost') selected @endif value="static_cost">{{ Helpers::translate('static cost') }}</option>
                        <option @if($o['discount_type'] ?? null == 'percent') selected @endif value="percent">{{ Helpers::translate('percent of the total') }}</option>
                    </select>
                </div>

                <div class="col-6">
                    <input value="{{$o['static_cost_value'] ?? null}}" type="number" inputmode="numeric" name="offer[static_cost_value]" id="static_cost_value" class="form-control d_static_cost discount_value" placeholder="{{ Helpers::translate('static cost') }}" @if(($o['discount_type'] ?? null) !== 'static_cost') style="display: none" @endif />

                    <div class="input-group discount_value d_percent" @if(($o['discount_type'] ?? null) !== 'percent') style="display: none" @endif >
                        <input value="{{$o['percent'] ?? null}}" type="number" inputmode="numeric" name="offer[percent]" id="percent" class="form-control d_percent" placeholder="{{ Helpers::translate('percent of the total') }}" @if(($o['discount_type'] ?? null) !== 'percent') style="display: none" @endif />
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="text-dark">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <p> {{ Helpers::translate('choose message sending method') }} </p>

                    <div class="form-control p-0">
                        <select multiple id="msg_method" class="my-0 SumoSelect-custom">
                            <option @if(in_array('sms',explode(',',$o['msg_method'] ?? null ?? '') ?? []) == 'sms') selected @endif value="sms">{{ Helpers::translate('Sms') }}</option>
                            <option @if(in_array('email',explode(',',$o['msg_method'] ?? null ?? '') ?? []) == 'email') selected @endif value="email">{{ Helpers::translate('Email') }}</option>
                            <option @if(in_array('mobile_notifications',explode(',',$o['msg_method'] ?? null ?? '') ?? []) == 'mobile_notifications') selected @endif value="mobile_notifications">{{ Helpers::translate('mobile notifications') }}</option>
                        </select>
                    </div>
                    <input type="hidden" name="offer[msg_method]" value="{{$o['msg_method'] ?? null ?? ''}}">

                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 msg_description_c">
                    <h5>{{ Helpers::translate('message text') }}</h5>
                    <textarea class="form-control p-2" name="offer[description]" id="msg_description_{{$cart_group_id ?? 'new'}}" style="height: 100px">{{$o['description'] ?? null}}</textarea>

                    <div class="row mt-2">
                        <div class="col-12 row my-1">
                            <label class="col-9">{{ Helpers::translate('customer name') }}</label>
                            <a role="button" class="btn btn-primary col-3" onclick="insert_to_msg(document.getElementById('msg_description_{{$cart_group_id ?? 'new'}}'),'{NAME}')"> {NAME} </a>
                        </div>
                        <div class="col-12 row my-1">
                            <label class="col-9">{{ Helpers::translate('discount amount') }}</label>
                            <a role="button" class="btn btn-primary col-3" onclick="insert_to_msg(document.getElementById('msg_description_{{$cart_group_id ?? 'new'}}'),'{DISCOUNT_AMOUNT}')"> {DISCOUNT_AMOUNT} </a>
                        </div>
                        <div class="col-12 row my-1">
                            <label class="col-9">{{ Helpers::translate('discount expiring date') }}</label>
                            <a role="button" class="btn btn-primary col-3" onclick="insert_to_msg(document.getElementById('msg_description_{{$cart_group_id ?? 'new'}}'),'{DATE}')"> {DATE} </a>
                        </div>
                    </div>

                </div>
            </div>
            @isset($offer)
            <input type="hidden" name="offer[expiring_days]" value="0">
            <div class="row mt-5">
                <div class="col-12">
                    <div class="group-input">
                        <label for="expiring_date">{{ Helpers::translate('discount expiring after') }}</label>
                        <input type="date" name="offer[expiring_date]" value="{{$o['expiring_date'] ?? null}}" id="expiring_date" class="form-control" />
                    </div>
                </div>
            </div>
            @else
            @php($expiring_date = $o['expiring_date'] ?? null)
            <input type="hidden" name="offer[expiring_days]" value="1">
            <div class="row mt-5">
                <div class="col-12">
                    <div class="group-input">
                        <label for="expiring_date">{{ Helpers::translate('discount expiring after') }}</label>
                        <select class="form-control" name="offer[expiring_date]">
                            <option value="1">{{ Helpers::translate('after 1 hour') }}</option>
                            <option value="2">{{ Helpers::translate('after 2 hours') }}</option>
                            <option value="3">{{ Helpers::translate('after 3 hours') }}</option>
                            <option value="4">{{ Helpers::translate('after 4 hours') }}</option>
                            <option value="5">{{ Helpers::translate('after 5 hours') }}</option>
                            <option value="6">{{ Helpers::translate('after 6 hours') }}</option>
                            <option value="7">{{ Helpers::translate('after 7 hours') }}</option>
                            <option value="8">{{ Helpers::translate('after 8 hours') }}</option>
                            <option value="9">{{ Helpers::translate('after 9 hours') }}</option>
                            <option value="10">{{ Helpers::translate('after 10 hours') }}</option>
                            <option value="11">{{ Helpers::translate('after 11 hours') }}</option>
                            <option value="12">{{ Helpers::translate('after 12 hours') }}</option>
                            <option value="13">{{ Helpers::translate('after 13 hours') }}</option>
                            <option value="14">{{ Helpers::translate('after 14 hours') }}</option>
                            <option value="15">{{ Helpers::translate('after 15 hours') }}</option>
                            <option value="16">{{ Helpers::translate('after 16 hours') }}</option>
                            <option value="17">{{ Helpers::translate('after 17 hours') }}</option>
                            <option value="18">{{ Helpers::translate('after 18 hours') }}</option>
                            <option value="19">{{ Helpers::translate('after 19 hours') }}</option>
                            <option value="20">{{ Helpers::translate('after 20 hours') }}</option>
                            <option value="21">{{ Helpers::translate('after 21 hours') }}</option>
                            <option value="22">{{ Helpers::translate('after 22 hours') }}</option>
                            <option value="23">{{ Helpers::translate('after 23 hours') }}</option>
                            <option value="24">{{ Helpers::translate('after 24 hours') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            @endisset
            @isset($offer)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="row">
                        <div class="col-11">
                            <h3 class="text-nowrap mx-2">
                                {{ Helpers::translate('sending date & time') }}
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-11">
                            <label for="send_now" class="text-nowrap mx-2">
                                {{ Helpers::translate('send now') }}
                            </label>
                        </div>
                        <div class="col-1">
                            <label class="switcher w-100 mx-2">
                                <input name="offer[send_now]" id="send_now" type="checkbox" class="switcher_input status"
                                onchange="$('.send_at').toggle()" @if($o['send_now'] ?? null ?? '') checked @endif
                                />
                                <span class="switcher_control"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row send_at" @if($o['send_now'] ?? null ?? '') style="display: none" @endif>
                        <div class="col-6">
                            <div class="group-input">
                                <input type="date" name="offer[send_date]" value="{{$o['send_date'] ?? null ?? ''}}" id="send_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-white">
                                        <i class="fa fa-clock text-dark"></i>
                                    </div>
                                </div>
                                <div class="form-control p-0">
                                    <select name="offer[send_time]" id="send_time" class="my-0 SumoSelect-custom">
                                        <option @if(($o['send_time'] ?? null) == '12:00 AM') selected @endif value="12:00 AM">12:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '12:30 AM') selected @endif value="12:30 AM">12:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '01:00 AM') selected @endif value="01:00 AM">01:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '01:30 AM') selected @endif value="01:30 AM">01:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '02:00 AM') selected @endif value="02:00 AM">02:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '02:30 AM') selected @endif value="02:30 AM">02:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '03:00 AM') selected @endif value="03:00 AM">03:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '03:30 AM') selected @endif value="03:30 AM">03:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '04:00 AM') selected @endif value="04:00 AM">04:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '04:30 AM') selected @endif value="04:30 AM">04:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '05:00 AM') selected @endif value="05:00 AM">05:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '05:30 AM') selected @endif value="05:30 AM">05:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '06:00 AM') selected @endif value="06:00 AM">06:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '06:30 AM') selected @endif value="06:30 AM">06:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '07:00 AM') selected @endif value="07:00 AM">07:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '07:30 AM') selected @endif value="07:30 AM">07:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '08:00 AM') selected @endif value="08:00 AM">08:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '08:30 AM') selected @endif value="08:30 AM">08:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '09:00 AM') selected @endif value="09:00 AM">09:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '09:30 AM') selected @endif value="09:30 AM">09:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '10:00 AM') selected @endif value="10:00 AM">10:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '10:30 AM') selected @endif value="10:30 AM">10:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '11:00 AM') selected @endif value="11:00 AM">11:00 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '11:30 AM') selected @endif value="11:30 AM">11:30 AM</option>
                                        <option @if(($o['send_time'] ?? null) == '12:00 PM') selected @endif value="12:00 PM">12:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '12:30 PM') selected @endif value="12:30 PM">12:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '01:00 PM') selected @endif value="01:00 PM">01:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '01:30 PM') selected @endif value="01:30 PM">01:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '02:00 PM') selected @endif value="02:00 PM">02:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '02:30 PM') selected @endif value="02:30 PM">02:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '03:00 PM') selected @endif value="03:00 PM">03:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '03:30 PM') selected @endif value="03:30 PM">03:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '04:00 PM') selected @endif value="04:00 PM">04:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '04:30 PM') selected @endif value="04:30 PM">04:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '05:00 PM') selected @endif value="05:00 PM">05:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '05:30 PM') selected @endif value="05:30 PM">05:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '06:00 PM') selected @endif value="06:00 PM">06:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '06:30 PM') selected @endif value="06:30 PM">06:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '07:00 PM') selected @endif value="07:00 PM">07:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '07:30 PM') selected @endif value="07:30 PM">07:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '08:00 PM') selected @endif value="08:00 PM">08:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '08:30 PM') selected @endif value="08:30 PM">08:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '09:00 PM') selected @endif value="09:00 PM">09:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '09:30 PM') selected @endif value="09:30 PM">09:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '10:00 PM') selected @endif value="10:00 PM">10:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '10:30 PM') selected @endif value="10:30 PM">10:30 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '11:00 PM') selected @endif value="11:00 PM">11:00 PM</option>
                                        <option @if(($o['send_time'] ?? null) == '11:30 PM') selected @endif value="11:30 PM">11:30 PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endisset
        </div>
    </div>
</form>

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

        function insert_to_msg(myField,myValue){
            //IE support
            if (document.selection) {
                myField.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
            }
            //MOZILLA and others
            else if (myField.selectionStart || myField.selectionStart == '0') {
                var startPos = myField.selectionStart;
                var endPos = myField.selectionEnd;
                myField.value = myField.value.substring(0, startPos)
                    + myValue
                    + myField.value.substring(endPos, myField.value.length);
            } else {
                myField.value += myValue;
            }
        }

        function update_price(id){
            var price = $(`#price_${id}`).val();
            var discount = $(`#discount_${id}`).val();
            var quantity = $(`#quantity_${id}`).val();
            var total_price = 0;
            var total_price_b = 0;
            $.ajax({
                url:"{{ route('admin.abandoned-carts.update-post') }}",
                type:'post',
                data:{
                    _token: '{{ csrf_token() }}',
                    id:id,
                    quantity:quantity,
                    discount:discount,
                },
                success:function(){
                    toastr.success('{{\App\CPU\Helpers::translate("updated successfully")}}');
                    $(`#calc_price_${id}`).text((price-discount)*((quantity)))
                    $(`#calc_price_b_${id}`).text((price)*((quantity)))
                    if( parseFloat($(`#calc_price_${id}`).text()) !== parseFloat($(`#calc_price_b_${id}`).text())){
                        $(`#calc_price_b_${id}`).attr("style","text-decoration: line-through;color:red")
                        $(`#calc_price_${id}`).show()
                    }else{
                        $(`#calc_price_b_${id}`).attr("style","")
                        $(`#calc_price_${id}`).hide()
                    }

                    $(".calc_price").each(function(){
                        total_price = total_price + parseFloat($(this).text());
                    })
                    $(".calc_price_b").each(function(){
                        total_price_b = total_price_b + parseFloat($(this).text());
                    })
                    $("#total_price").text(total_price)
                    $("#total_price_b").text(total_price_b)
                    if( parseInt($("#total_price_b").text()) !== parseInt($("#total_price").text())){
                        $("#total_price_b").attr("style","text-decoration: line-through;color:red")
                        $("#total_price").show()
                    }else{
                        $("#total_price_b").attr("style","")
                        $("#total_price").hide()
                    }
                }
            })
        }
        ///function cartQuantityInitialize() {
        $(document).on("click",'.btn-number',function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            productType = $(this).attr('product-type');
            var input = $(this).parent().find("input");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                console.log(productType)
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max') || (productType === 'digital')) {
                        input.val(currentVal + 1).change();
                    }

                    if ((parseInt(input.val()) == input.attr('max')) && (productType === 'physical')) {
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {
            productType = $(this).attr('product-type');
            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: '{{\App\CPU\Helpers::translate('Sorry, the minimum order quantity does not match')}}'
                });
                $(this).val($(this).data('oldValue'));
            }
            if (productType === 'digital' || valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: '{{\App\CPU\Helpers::translate('Sorry, stock limit exceeded')}}.'
                });
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        ////}
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });
    </script>
@endpush
