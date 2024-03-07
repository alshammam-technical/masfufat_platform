<!DOCTYPE html>
<html>
  <head>
    <title>Parcel Sandbox</title>
    <meta charset="UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    {{--  datepicker  --}}
    <script type="module" src="https://cdn.jsdelivr.net/npm/@duetds/date-picker@1.4.0/dist/duet/duet.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@duetds/date-picker@1.4.0/dist/duet/duet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@duetds/date-picker@1.4.0/dist/duet/themes/default.css" />
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/bootstrap.min.css">
    {{--  datepicker end  --}}

    <!--First need to import 3rd party dropdown plugin-->
    <script src="https://cdn.jsdelivr.net/npm/@revolist/revo-dropdown@latest/dist/revo-dropdown/revo-dropdown.js"></script>
    <!--Second import plugin for revo-grid which provides column editor as select -->
    <script src="{{asset('public\assets\back-end\js\revogrid\select.js')}}"></script>
    <script src="{{asset('public\assets\back-end\js\revogrid\numeral.js')}}"></script>
    <script src="{{asset('public\assets\back-end\js\revogrid\date.js')}}"></script>
    <!--Revogrid -->
    <script src="node_modules/@revolist/revogrid/dist/revo-grid/revo-grid.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/@revolist/revogrid@3.0.61/dist/revo-grid/revo-grid.js"></script>
    <style>
        html,
        body {
            height: 100%;}.SumoSelect{
            width: 100% !important;}.optWrapper{
            position: fixed !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/sumoselect.min.css" integrity="sha512-vU7JgiHMfDcQR9wyT/Ye0EAAPJDHchJrouBpS9gfnq3vs4UGGE++HNL3laUYQCoxGLboeFD+EwbZafw7tbsLvg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/jquery.sumoselect.min.js" integrity="sha512-Ut8/+LO2wW6HfMEz1vxHpiwMMQfw7Yf/0PdpTERAbK2VJQt4eVDsmFL269zUCkeG/QcEcc/tcORSrGHlP89nBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>

  <body>
    <button class="btn btn-success m-3" onclick="save()">
        {{Helpers::translate('Save')}}
    </button>

    <revo-grid theme="material" />
    <script>
        var vvv = [];
        class customSelect {
            constructor(t, r) {
                this.column = t,
                this.saveCallback = r
            }
            componentDidRender() {
                if(this.column['parent']){
                    grid.getFocused().then(focused =>{
                        var currentRow = focused.cell['y']
                        grid.getSource().then(d =>{
                            var value = d[currentRow][this.column['parent']]
                            var objectt = this.column['api']
                            $.ajax({
                                url:'{{route("home")}}/admin/getChildren/'+objectt+'/'+value,
                                success: function(data){
                                    $('select').html(data);
                                    if(vvv !== ''){
                                        if(!Array.isArray(vvv)){
                                            vvv = vvv.split(',')
                                        }
                                        vvv.forEach(function(item){
                                            $('select').find("option[value='"+item+"']").attr("selected","selected")
                                        })
                                    }
                                    sumo()
                                    $(".SumoSelect-custom").show();
                                }
                            })
                        })
                    })
                }else{
                    sumo()
                }
            }render(createElement) {        var r, e, n, o, a, i;
                let u = ""
                  , s = "";
                var selectEl = createElement(
                    "select",
                    {
                        multiple: !this.column['single'],
                        style: {width: "90%",                },
                        value: u,
                        class: {
                        "inner-cell SumoSelect-custom": true
                        },
                        onchange: (e) =>{
                            const r = "Tab" == e.target;
                            "object" == typeof $(e.target).val() ? this.saveCallback($(e.target).val(), r) : this.saveCallback($(e.target).val(), r)
                        }
                    },
                    undefined
                );
                if(this.column['parent']){
                    return this.editCell && (u = (this.editCell.model || {})[null === (r = this.editCell) || void 0 === r ? void 0 : r.prop] || ""),
                    u !== (null === (e = this.editCell) || void 0 === e ? void 0 : e.val) && (s = null === (n = this.editCell) || void 0 === n ? void 0 : n.val),
                    vvv = u,
                    selectEl.$children$ = [],
                    this.column.editorSource.forEach(function(item){
                        selectEl.$children$.push(createElement('option',{value: item.value,selected: u.includes(`${item.value.toString()}`)},item.label))
                    }),createElement(
                        "select",
                        {
                            multiple: !this.column['single'],
                            style: {
                                width: "90%",
                                display: "none",
                            },
                            value: u,
                            class: {
                            "inner-cell SumoSelect-custom": true
                            },
                            onchange: (e) =>{
                                const r = "Tab" == e.target;
                                "object" == typeof $(e.target).val() ? this.saveCallback($(e.target).val(), r) : this.saveCallback($(e.target).val(), r)
                            }
                        },
                        undefined
                    )}        return this.editCell && (u = (this.editCell.model || {})[null === (r = this.editCell) || void 0 === r ? void 0 : r.prop] || ""),
                u !== (null === (e = this.editCell) || void 0 === e ? void 0 : e.val) && (s = null === (n = this.editCell) || void 0 === n ? void 0 : n.val),
                selectEl.$children$ = [],
                this.column.editorSource.forEach(function(item){
                    selectEl.$children$.push(createElement('option',{value: item.value,selected: u.includes(`${item.value.toString()}`)},item.label))
                }),selectEl
            }}class customCheckbox {
            constructor(t, r) {
                this.column = t,
                this.saveCallback = r
            }
            componentDidRender() { sumo(); }
            render(createElement) {
                var r, e, n, o, a, i;
                let u = "", s = "";        return this.editCell && (u = (this.editCell.model || {})[null === (r = this.editCell) || void 0 === r ? void 0 : r.prop] || ""),
                u !== (null === (e = this.editCell) || void 0 === e ? void 0 : e.val) && (s = null === (n = this.editCell) || void 0 === n ? void 0 : n.val),
                createElement(
                    'input',
                    {
                        type: 'checkbox',
                        value: 1,
                        checked: u == 1,
                        onchange: (e) =>{
                            const r = "Tab" == e.target;
                            "object" == typeof $(e.target).val() ? this.saveCallback($(e.target).is(':checked') ? 1 : 0, r) : this.saveCallback($(e.target).is(':checked') ? 1 : 0, r)
                        },
                    })
            }}class customColor {
            constructor(t, r) {
                this.column = t,
                this.saveCallback = r
            }
            componentDidRender() { sumo() }
            render(createElement) {
                var r, e, n, o, a, i;
                let u = "", s = "";        return this.editCell && (u = (this.editCell.model || {})[null === (r = this.editCell) || void 0 === r ? void 0 : r.prop] || ""),
                u !== (null === (e = this.editCell) || void 0 === e ? void 0 : e.val) && (s = null === (n = this.editCell) || void 0 === n ? void 0 : n.val),
                createElement(
                    'input',
                    {
                        type: 'color',
                        value: u,
                        onchange: (e) =>{
                            const r = "Tab" == e.target;
                            "object" == typeof $(e.target).val() ? this.saveCallback($(e.target).val(), r) : this.saveCallback($(e.target).val(), r)
                        },
                    })
            }
        }

    </script>
    <script>
        var var required_cols = "";
        const grid = document.querySelector("revo-grid");
        const columns = [
            {
                "prop": "item_number",
                "name": "{{Helpers::translate('Item Number')}}",
                "size": 300,
            },
            {
                "prop": "code",
                "name": "{{Helpers::translate('code_sku')}}",
                "size": 300
            },
            @foreach(Helpers::get_langs() as $index => $lang)
            {
                "prop": "name[{{$index}}]",
                "name": "{{Helpers::translate('name').'('.Helpers::translate($lang.' language').')'}}",
                "size": 300
            },
            {
                "prop": "short_desc[{{$index}}]",
                "name": "{{Helpers::translate('short_description').'('.Helpers::translate($lang.' language').')'}}",
                "size": 300
            },
            {
                "prop": "promo_title[{{$index}}]",
                "name": "{{Helpers::translate('Promo title').'('.Helpers::translate($lang.' language').')'}}",
                "size": 300
            },
            {
                "labelKey": "label",
                "valueKey": "value",
                "source": [
                    {
                        "label": "{{Helpers::translate('top right')}}",
                        "value": "top-right"
                    },
                    {
                        "label": "{{Helpers::translate('top left')}}",
                        "value": "top-left"
                    },
                    {
                        "label": "{{Helpers::translate('bottom right')}}",
                        "value": "bottom-right"
                    },
                    {
                        "label": "{{Helpers::translate('bottom left')}}",
                        "value": "bottom-left"
                    }
                    ],
                    "columnType": "select",
                    "prop": "promo_pos[{{$index}}]",
                    "name": "{{Helpers::translate('Promo title position').'('.Helpers::translate($lang.' language').')'}}",
                    "size": 300
                },
                {
                    "prop": "promo_bg[{{$index}}]",
                    "name": "{{Helpers::translate('Promo background color').'('.Helpers::translate($lang.' language').')'}}",
                    "size": 300
                },
                {
                "prop": "promo_text[{{$index}}]",
                "name": "{{Helpers::translate('Promo background text').'('.Helpers::translate($lang.' language').')'}}",
                "size": 300
            },
            {
                "prop": "description[{{$index}}]",
                "name": "{{Helpers::translate('description').'('.Helpers::translate($lang.' language').')'}}",
                "size": 300
            },
            @endforeach
            {
                "prop": "has_tax",
                "name": "{{Helpers::translate('The product is subject to tax')}}",
                "size": 300,
                "editor": "checkbox",
            },
            {
                "columnType": "numeric",
                "prop": "tax",
                "name": "{{Helpers::translate('Tax')}}",
                "size": 300
            },
            {
                "labelKey": "label",
                "valueKey": "value",
                "source": [
                    {
                        "label": "{{Helpers::translate('physical')}}",
                        "value": "physical"
                    },
                    {
                        "label": "{{Helpers::translate('digital')}}",
                        "value": "digital"
                    },
                    {
                        "label": "{{Helpers::translate('booking')}}",
                        "value": "booking"
                    }
                ],
                "columnType": "select",
                "prop": "product_type",
                "name": "{{Helpers::translate('product_type')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "upon_request",
                "name": "{{Helpers::translate('Upon Request')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "irreversible",
                "name": "{{Helpers::translate('Irreversible')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "guarantee",
                "name": "{{Helpers::translate('Has a guarantee')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "attachment",
                "name": "{{Helpers::translate('Attach a file upon request')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "notable",
                "name": "{{Helpers::translate('Noteable')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "sold_separately",
                "name": "{{Helpers::translate('Sold separately')}}",
                "size": 300
            },
            {
                "prop": "linked_products",
                "name": "{{Helpers::translate('Linked Products')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "purchase_note",
                "name": "{{Helpers::translate('Purchase Note')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "allow_pre_order",
                "name": "{{Helpers::translate('Allow pre-order')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "shipping_options",
                "name": "{{Helpers::translate('Shipping options for this product')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "props[is_shareable]",
                "name": "{{Helpers::translate('is shareable')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "enable_serial_numbers",
                "name": "{{Helpers::translate('Enable Serial Numbers')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "enable_multimedia",
                "name": "{{Helpers::translate('Enable Multimedia')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "multi_stores",
                "name": "{{Helpers::translate('Multi Stores')}}",
                "size": 300
            },
            {
                "prop": "productprops[countries]",
                "name": "{{Helpers::translate('The product is only sold to selected countries')}}",
                "size": 300,
                "editor": 'select',
                "editorSource": {!! Helpers::getCountriesOptions() !!},
            },
            {
                "prop": "productprops[areas]",
                "name": "{{Helpers::translate('The product is only sold to selected areas')}}",
                "size": 300,
                "editor": 'select',
                "editorSource": [],
                "parent": "productprops[countries]",
                "api": "areas",
            },
            {
                "prop": "productprops[cities]",
                "name": "{{Helpers::translate('The product is only sold to selected cities')}}",
                "size": 300,
                "editor": 'select',
                "editorSource": [],
                "parent": "productprops[areas]",
                "api": "cities",
            },
            {
                "prop": "productprops[provinces]",
                "name": "{{Helpers::translate('The product is only sold to selected provinces')}}",
                "size": 300,
                "editor": 'select',
                "editorSource": [],
                "parent": "productprops[cities]",
                "api": "provinces",
            },
            {
                "labelKey": "label",
                "valueKey": "value",
                "source": [
                    {
                        "label": "{{Helpers::translate('No')}}",
                        "value": "2"
                    },
                    {
                        "label": "{{Helpers::translate('Always')}}",
                        "value": "1"
                    },
                    {
                        "label": "{{Helpers::translate('When the quantity is')}}",
                        "value": "0"
                    }
                ],
                "columnType": "select",
                "prop": "productprops[selected_countries_show_quantity_always]",
                "name": "{{Helpers::translate('Show quantity for consumers')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "send_using",
                "name": "{{Helpers::translate('Send products digital contents to consumer')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "multiply_qty",
                "name": "{{Helpers::translate('shipping_cost_multiply_with_quantity')}}",
                "size": 300
            },
            {
                "prop": "category_id",
                "name": "{{Helpers::translate('Category')}}",
                "size": 300,
                "editor": 'select',
                "editorSource": {!! Helpers::getCategoriesOptions() !!},
            },
            {
                "prop": "main_category",
                "name": "{{Helpers::translate('Main Category')}}",
                "size": 300,
                "editor": 'select',
                "parent": "category_id",
                "api": "selectedCategory",
                "single": 1,
                "editorSource": [],
            },
            {
                "prop": "brand_id",
                "name": "{{Helpers::translate('Brand')}}",
                "size": 300,
                "single": 1,
                "editor": 'select',
                "editorSource": {!! Helpers::getBrandsOptions() !!},
            },
            {
                "columnType": "numeric",
                "prop": "gtin",
                "name": "{{Helpers::translate('gtin')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "mpn",
                "name": "{{Helpers::translate('mpn')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "hs_code",
                "name": "{{Helpers::translate('HS Code')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "length",
                "name": "{{Helpers::translate('Length')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "width",
                "name": "{{Helpers::translate('Width')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "height",
                "name": "{{Helpers::translate('Height')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "size",
                "name": "{{Helpers::translate('Size')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "space",
                "name": "{{Helpers::translate('space')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "unit",
                "name": "{{Helpers::translate('Unit')}}",
                "size": 300
            },
            {
                "prop": "made_in",
                "name": "{{Helpers::translate('Made in')}}",
                "size": 300
            },
            {
                "editor": "color",
                "prop": "color",
                "name": "{{Helpers::translate('color')}}",
                "size": 300
            },
            {
                "columnType": "date",
                "prop": "publish_on_market",
                "name": "{{Helpers::translate('Publish on market')}}",
                "size": 300
            },
            {
                "columnType": "date",
                "prop": "publish_on_app_time",
                "name": "{{Helpers::translate('Publish on App')}}",
                "size": 300
            },
            {
                "editor": "checkbox",
                "prop": "featured",
                "name": "{{Helpers::translate('featured')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "purchase_price",
                "name": "{{Helpers::translate('Purchase price')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "quantity",
                "name": "{{Helpers::translate('Quantity')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "min_quantity_alert",
                "name": "{{Helpers::translate('Min Quantity alert')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "shipping_cost",
                "name": "{{Helpers::translate('shipping_cost')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "unit_price",
                "name": "{{Helpers::translate('selling_price(Default pricing level)')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "min_quantity",
                "name": "{{Helpers::translate('Min quantity per order(Default pricing level)')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "max_quantity",
                "name": "{{Helpers::translate('Max quantity per order(Default pricing level)')}}",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "discount_type",
                "name": "{{Helpers::translate('Discount_Type(Default pricing level)')}}",
                "size": 300
            },
            {
                "prop": "discount",
                "name": "{{Helpers::translate('Discount(Default pricing level)')}}",
                "size": 300
            },
            {
                "prop": "suggested_price",
                "name": "{{Helpers::translate('suggested price(Default pricing level)')}}",
                "size": 300
            },
            @foreach(Helpers::getPricingLevels() as $index=>$pl)
            {
                "columnType": "numeric",
                "prop": "pricing[{{$pl->id}}][value]",
                "name": "{{Helpers::translate('selling_price')}} ({{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }})",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "pricing[{{$pl->id}}][min_qty]",
                "name": "{{Helpers::translate('Min quantity per order')}} ({{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }})",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "pricing[{{$pl->id}}][max_qty]",
                "name": "{{Helpers::translate('Max quantity per order')}} ({{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }})",
                "size": 300
            },
            {
                "columnType": "numeric",
                "prop": "pricing[{{$pl->id}}][discount_type]",
                "name": "{{Helpers::translate('Discount_Type')}} ({{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }})",
                "size": 300
            },
            {
                "prop": "pricing[{{$pl->id}}][discount_price]",
                "name": "{{Helpers::translate('Discount')}} ({{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }})",
                "size": 300
            },
            {
                "prop": "pricing[{{$pl->id}}][suggested_price]",
                "name": "{{Helpers::translate('suggested price')}} ({{ \App\CPU\Helpers::get_prop("App\Model\pricing_levels",$pl['id'],"name") }})",
                "size": 300
            },
            @endforeach
            {
                "prop": "meta_title",
                "name": "{{Helpers::translate('Meta_title')}}",
                "size": 300
            },
            {
                "prop": "meta_description",
                "name": "{{Helpers::translate('Meta_description')}}",
                "size": 300
            },
            {
                "prop": "meta_image",
                "name": "{{Helpers::translate('Meta Image')}}",
                "size": 300
            },
            {
                "prop": "video_url",
                "name": "{{Helpers::translate('Youtube video link')}}",
                "size": 300
            },
            {
                "prop": "thumbnail",
                "name": "{{Helpers::translate('thumbnail url')}}",
                "size": 300
            },
            {
                "prop": "videos",
                "name": "{{Helpers::translate('direct video url')}}",
                "size": 300
            }
        ];
        const items = [
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            {},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},
            ];
        grid.columns = columns;
        grid.source = items;
        // define your custom column type here
        grid.columnTypes = {
            select: new window.RevoGridColumnSelect.CreateSelectColumnType(),
            numeric: new window.numeral.default(),
            date: new window.dateColType.default(),
        };
        grid.range = true;
        // apply columns
        grid.resize = true;
        grid.columns = columns;
        // apply rows
        grid.source = items;
        //apply editors
        grid.editors = {
            'select': customSelect,
            'checkbox': customCheckbox,
            'color': customColor,
        };
    </script>
    <script>
        function sumo(){
            $('.SumoSelect-custom,.testselect2-custom').SumoSelect({
                search:true,
                placeholder: '{{\App\CPU\Helpers::translate('Select')}}',
                searchText: "...",
                selectAll: true,
                locale: ['{{\App\CPU\Helpers::translate('Ok')}}', '{{\App\CPU\Helpers::translate('Cancel')}}', '{{\App\CPU\Helpers::translate('Select All')}}'],
                captionFormatAllSelected: '{{\App\CPU\Helpers::translate('All Selected')}}! ( {0} )',
                captionFormat: '{0} {{\App\CPU\Helpers::translate('Selected')}}',
                okCancelInMulti:true
            });
        }
        var current = 0;

        async function save(){
            var timerInterval;
            Swal.fire({
                title: `{{ \App\CPU\Helpers::translate('Please wait')}}...`,
                timerProgressBar: false,
                allowOutsideClick: false,
                showConfirmButton:false,
                didOpen: () => {
                Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
            });
            var source_length = grid.source.length
            var c = true;
            for (let key = current; key <= (parseInt(source_length) + 1); key++) {
                if(!c){
                    break;
                }
                var item = grid.source[key];
                var row = parseInt(key) + 1;
                current = key;
                var formData = new FormData();
                if(item['item_number']){
                    $.each(item, function(propName, propVal) {
                        if(!excep.includes(propName)){
                            formData[key].set(propName, propVal)
                        }
                    });
                    @foreach (Helpers::get_langs() as $index => $lang)
                        formData.append("lang[]", "{{ $lang }}")
                    @endforeach
                    formData.append("_token", "{{ csrf_token() }}")
                    await $.ajax({
                        url: "{{ route('admin.product.bulk-import-ii') }}",
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data){
                            if(data.errors){
                                html = data.errors.map(async(item) => {console.log(item);return '<br/>' + item.message});
                                Swal.fire({
                                    position: 'top-end',
                                    html: "{{\App\CPU\Helpers::translate('Check the row')}}: " + row + required_cols
                                    ,
                                    type: 'error',
                                    title: "{{\App\CPU\Helpers::translate('Please fill all empty fields!')}}",
                                    showConfirmButton: true,
                                });
                                c = false
                            }else{
                                if(row == source_length){
                                    location.replace("{{route('admin.product.list',['type' => 'in_house'])}}")
                                }
                            }
                        },
                        error: function(){
                            Swal.fire({
                                position: 'top-end',
                                html: "{{\App\CPU\Helpers::translate('Check the row')}}: " + row + required_cols,
                                type: 'error',
                                title: "{{\App\CPU\Helpers::translate('Please fill all empty fields!')}}",
                                showConfirmButton: true,
                            });
                            c = false
                        }
                    })
                }else{
                    if(!c){
                        break;
                    }else{
                        if(row == source_length){
                            location.replace("{{route('admin.product.list',['type' => 'in_house'])}}")
                        }
                    }
                }
            }
        }
    </script>
  </body>
</html>
