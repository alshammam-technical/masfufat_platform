<!DOCTYPE html>
<html>
  <head>
    <title>{{ Helpers::translate('Import Brands') }}</title>
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
    <script src="https://cdn.jsdelivr.net/npm/@revolist/revogrid@latest/dist/revo-grid/revo-grid.js"></script>

    {{--  swal  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html,
        body {
            height: 92%;
        }

        .SumoSelect{
            width: 100% !important;
        }

        .optWrapper{
            position: fixed !important;
            top: 33px !important;
            display: block !important;
        }

        .rgCell, .rgHeaderCell{
            border: #cbcbcb solid thin
        }

        .select-all{
            height: 37px !important;
        }

        p.CaptionCont.SelectBox.inner-cell.SumoSelect-custom.search {
            position: fixed;
            top: 0;
            left: 0;
        }

        .SumoSelect>.optWrapper{
            width: 99% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/sumoselect.min.css" integrity="sha512-vU7JgiHMfDcQR9wyT/Ye0EAAPJDHchJrouBpS9gfnq3vs4UGGE++HNL3laUYQCoxGLboeFD+EwbZafw7tbsLvg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.8/jquery.sumoselect.min.js" integrity="sha512-Ut8/+LO2wW6HfMEz1vxHpiwMMQfw7Yf/0PdpTERAbK2VJQt4eVDsmFL269zUCkeG/QcEcc/tcORSrGHlP89nBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>

  <body>
    <button class="btn btn-success m-3" onclick="save()">
        {{Helpers::translate('Save')}}
    </button>
    <button class="btn btn-info m-3" onclick="exportFile()">
        {{Helpers::translate('Export')}}
    </button>

    <revo-grid theme="material" exporting="true" />
    <script>
        var vvv = [];
        var formData = [];
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
            }}
                class customColor {
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
                class textarea {
                    constructor(t, r) {
                        this.column = t,
                        this.saveCallback = r
                    }
                    componentDidRender() {
                        $("textarea").bind("paste", function(e){
                            // access the clipboard using the api
                            var pastedData = e.originalEvent.clipboardData.getData('text');
                            $(e.target).val(pastedData)
                        } );
                    }
                    render(createElement) {
                        var r, e, n, o, a, i;
                        let u = "", s = "";        return this.editCell && (u = (this.editCell.model || {})[null === (r = this.editCell) || void 0 === r ? void 0 : r.prop] || ""),
                        u !== (null === (e = this.editCell) || void 0 === e ? void 0 : e.val) && (s = null === (n = this.editCell) || void 0 === n ? void 0 : n.val),
                        createElement(
                            'textarea',
                            {
                                value: u,
                                style: {
                                    width:'100%',
                                    height:'500%',
                                },
                                rows:'1',
                                onchange: (e) =>{
                                    const r = "Tab" == e.target;
                                    "object" == typeof $(e.target).val() ? this.saveCallback($(e.target).val(), r) : this.saveCallback($(e.target).val(), r)
                                },
                                onkeydown: (e) => {
                                    if(e.keyCode == "86" && e.ctrlKey){
                                        this.saveCallback($(e.target).val(), true)
                                        var pastedData = e.originalEvent.clipboardData.getData('text');
                                        $(e.target).val($(e.target).val()+pastedData)
                                        this.saveCallback($(e.target).val(), true)
                                    }
                                },
                                onkeyup: (e) => {
                                    this.saveCallback($(e.target).val(), true)
                                }
                            },u)
                    }
                }
                class imgInput {
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
                                type: 'file',
                                accept: "image/*",
                                multiple:false,
                                value: u,
                                onchange: (e) =>{
                                    const r = "Tab" == e.target;
                                    var imgInput = e.target;
                                    var value = e.target.value;
                                    var file = imgInput.files[0];
                                    var imageType = /image.*/;
                                    if (file.type.match(imageType)) {
                                        var reader = new FileReader();
                                        var saveCallback = this.saveCallback;
                                        var totalFiles = imgInput.files.length;
                                        var column = this.column;
                                        this.column['cellTemplate'] = (createElement, props) => {
                                            return uploaded_temp(createElement,props)
                                        }
                                        reader.onload = function(e) {
                                            grid.getFocused().then(d => {
                                                var ind = d.cell.y;
                                                if(!formData[ind]){
                                                    formData[ind] = new FormData();
                                                }
                                                for (var i = 0; i < totalFiles; i++) {
                                                    var file = imgInput.files[i];
                                                    formData[ind].append(column.prop, file);
                                                }
                                                var img = new Image();
                                                img = reader.result;

                                                //"object" == typeof img ? saveCallback(img, r) : saveCallback(img , r)
                                            })


                                        }

                                        reader.readAsDataURL(file);
                                    } else {
                                        fileDisplayArea.innerHTML = "File not supported!"
                                    }
                                },
                            })
                    }
                }
                class videoInput {
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
                                type: 'file',
                                accept: "video/mp4",
                                multiple:true,
                                value: u,
                                onchange: (e) =>{
                                    const r = "Tab" == e.target;
                                    var videoInput = e.target;
                                    var value = e.target.value;
                                    var file = videoInput.files[0];
                                    var reader = new FileReader();
                                    var saveCallback = this.saveCallback;
                                    var totalFiles = videoInput.files.length;
                                    var column = this.column;
                                    this.column['cellTemplate'] = (createElement, props) => {
                                        return uploaded_temp(createElement,props)
                                    }
                                    reader.onload = function(e) {
                                        grid.getFocused().then(d => {
                                            var ind = d.cell.y;
                                            if(!formData[ind]){
                                                formData[ind] = new FormData();
                                            }
                                            for (var i = 0; i < totalFiles; i++) {
                                                var file = videoInput.files[i];
                                                formData[ind].append(column.prop, file);
                                            }
                                            var img = new Image();
                                            img = reader.result;

                                            //"object" == typeof img ? saveCallback(img, r) : saveCallback(img , r)
                                        })


                                    }

                                    reader.readAsDataURL(file);
                                },
                            })
                    }
                }


            function locked(column, saveCallback, closeCallback) {
                return {
                    element: null, // will be setup up after render
                    editCell: null, // will be setup up after render
                    /**
                    * required, define custom component structure
                    * @param createElement: (tagName: string, properties?: object, value?: any, children: Array) => VNode
                    */
                    render(createElement,props) {
                        return createElement(
                            'span',{
                            class: 'rowIndexSpan',
                             style: {
                                color: "black",
                                width: "100%",
                                textAlign: "start",
                                display: "block",
                                height: "100%",
                                padding: "15px",
                                paddingTop: '10px',
                             },
                         })
                    },
                    componentDidRender() {
                        grid.getFocused().then((d)=>{
                            $(".rowIndexSpan").text(d.cell.y + 1)
                        })
                    }, // optional, called after component rendered
                    disconnectedCallback() {}, // optional, called after component destroyed

                };
              };

            function uploaded_temp(createElement,props) {
                if(formData[props.rowIndex]){
                    return createElement('span', {
                        style: {
                            color: 'green',
                            direction: '{{ session()->get('direction') }}',
                            width: '100%',
                            textAlign: 'center',
                            display: 'block',
                        },
                    }, "{{ Helpers::translate('files added!') }}");
                }
            }
    </script>
    <script>
        function adapter(parent, props) {
            return props.rowIndex;
        }


        const grid = document.querySelector("revo-grid");
        const columns = [
            {
                prop: "rowNumber",
                name: "",
                "size": 60,
                cellTemplate(h, p) {
                  return p.rowIndex + 1;
                },
                editor:'locked'
            },
            {
                "prop": "priority",
                "name": "{{Helpers::translate('priority')}}",
                "columnType": "numeric",
                "size": 300,
            },
            @foreach(Helpers::get_langs() as $index => $lang)
            {
                "prop": "name[{{$index}}]",
                "name": "{{Helpers::translate('Brand_Name').'('.Helpers::translate($lang.' language').')'}}",
                "size": 300
            },
            @endforeach
            {
                "prop": "show_for_pricing_levels",
                "name": "{{Helpers::translate('Show brand for pricing levels')}}",
                "size": 300,
                "editor": 'select',
                "editorSource": {!! Helpers::getPricingLevelsOptions() !!},
            },
            {
                "editor": "checkbox",
                "prop": "status",
                "name": "{{Helpers::translate('status')}}",
                "size": 300
            },
            @foreach(Helpers::get_langs() as $index => $lang)
            {
                "prop": "image[]",
                "name": "{{Helpers::translate('Image (upload)').' ('.Helpers::translate($lang.' language').')'}}",
                "editor": "img",
                "size": 300
            },
            {
                "prop": "imagesUrls[{{$lang}}][]",
                "name": "{{Helpers::translate('Image (urls)').' ('.Helpers::translate($lang.' language').')'}}",
                "editor": "textarea",
                "size": 300
            },
            @endforeach
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
            'textarea': textarea,
            'select': customSelect,
            'checkbox': customCheckbox,
            'color': customColor,
            'img': imgInput,
            'video': videoInput,
            'locked': locked,
        };

        $(document).on("keyup keydown","body",function(e){
            if(e.keyCode == '37' || ((e.keyCode == '9') && (!e.shiftKey))){
                grid.getFocused().then((r)=>{
                        if(r.cell){
                            grid.scrollToColumnIndex(r.cell.x)
                        }
                    })
                }
                if((e.keyCode == '39') || ((e.keyCode == '9') && (e.shiftKey))){
                    grid.getFocused().then((r)=>{
                        if(r.cell){
                            grid.scrollToColumnIndex(r.cell.x)
                        }
                    })
                }
                if(e.keyCode == '38'){
                    grid.getFocused().then((r)=>{
                        if(r.cell){
                            grid.scrollToRow(r.cell.y)
                        }
                    })
                }
                if((e.keyCode == '40') || (e.keyCode == '13')){
                    grid.getFocused().then((r)=>{
                        if(r.cell){
                            grid.scrollToRow(r.cell.y - 15)
                        }
                    })
            }
        })
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
                text: `{{ Helpers::translate('this may take  a while, please do not refresh or close the page') }}`,
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
                var excep = ['image[]']
                if(item['priority']){
                    if(!formData[key]){
                        formData[key] = new FormData();
                    }
                    $.each(item, function(propName, propVal) {
                        if(!excep.includes(propName)){
                            formData[key].set(propName, propVal)
                        }
                    });
                    @foreach (Helpers::get_langs() as $index => $lang)
                        formData[key].append("lang[]", "{{ $lang }}")
                    @endforeach
                    formData[key].append("_token", "{{ csrf_token() }}")
                    await $.ajax({
                        url: "{{ route('admin.brand.bulk-import-ii') }}",
                        type: 'post',
                        data: formData[key],
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function(data){
                            if(data.errors){
                                var html = "<div dir='{{session()->get('direction')}}'>";
                                html += data.errors.map((item) => {return item.message + '<br/>'});
                                html += "</div>";
                                Swal.fire({
                                    position: 'top-end',
                                    html: "{{\App\CPU\Helpers::translate('Check the row')}}: " + row + html,
                                    type: 'error',
                                    title: "{{\App\CPU\Helpers::translate('Please fill all empty fields!')}}",
                                    showConfirmButton: true,
                                });
                                c = false
                                grid.scrollToRow(key)
                                grid.scrollToColumnProp(data.errors[0]['code'])
                            }else{
                                if(row == source_length){
                                    location.replace("{{route('admin.brand.list')}}")
                                }
                            }
                        },
                        error: function(){
                            Swal.fire({
                                position: 'top-end',
                                html: "{{\App\CPU\Helpers::translate('Check the row')}}: "+row,
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
                            location.replace("{{route('admin.brand.list')}}")
                        }
                    }
                }
            }
        }

        function exportFile(){
            grid.getPlugins().then(plugins => {
                plugins.forEach(p => {
                    if (p.exportFile) {
                        const exportPlugin = p;
                        exportPlugin.exportFile({  filename: 'new file' });
                    }
                })
            });
        }
    </script>
  </body>
</html>
