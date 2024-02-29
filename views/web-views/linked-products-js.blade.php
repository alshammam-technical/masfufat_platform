    <script>
        function tax_opin(option,value)
        {
            $.get('{{ route('linked-products-get') }}/options/'+option+'/'+value).then((result) => {
                if(option !== 'custom_tax'){
                    toastr.success("{{ Helpers::translate('Settings Saved Successfully!') }}")
                }else if(value == false){
                    toastr.success("{{ Helpers::translate('Settings Saved Successfully!') }}")
                }
                if(table[0]){
                    cleared = 1;
                    skip = 0;
                    theLength = 21
                    scc[0] = true
                    table[0].clear();
                    table[0].draw();
                }
            });
        }


        function profit_changed(product_id, cost_price, profit_)
        {
            if($("#custom_tax_checkbox").is(":checked")){
                $("#profit_ratio_"+product_id).val((profit_/cost_price*100).toFixed(2))
                var own_price = parseFloat(profit_) + cost_price
                $("#ownprice_"+product_id).val(own_price)
                var custom_tax_value = $("#custom_tax_value").val()
                var tax = parseFloat(own_price) * (parseFloat(custom_tax_value) / 100)
                $("#total_"+product_id).text((own_price + tax).toFixed(2));
                $("#tax_"+product_id).text(tax.toFixed(2));
            }else{
                var local_total = parseFloat($("#local_total_"+product_id).text())
                $("#profit_ratio_"+product_id).val((profit_/local_total*100).toFixed(2))
                var own_price = parseFloat(profit_) + local_total
                $("#ownprice_"+product_id).val(own_price)
            }
            price_edits['pid-'+product_id]=own_price;
            doo_formats(product_id)
        }

        function ratio_changed(product_id, cost_price, ratio)
        {
            if($("#custom_tax_checkbox").is(":checked")){
                var profit_ = (ratio*cost_price/100).toFixed(2)
                $("#profit_"+product_id).val(profit_)
                var own_price = parseFloat(profit_) + cost_price
                $("#ownprice_"+product_id).val(own_price)
                var custom_tax_value = $("#custom_tax_value").val()
                var tax = parseFloat(own_price) * (parseFloat(custom_tax_value) / 100)
                $("#total_"+product_id).text((own_price + tax).toFixed(2));
                $("#tax_"+product_id).text(tax.toFixed(2));
            }else{
                var local_total = parseFloat($("#local_total_"+product_id).text())
                var profit_ = (ratio*local_total/100).toFixed(2)
                $("#profit_"+product_id).val(profit_)
                var own_price = parseFloat(profit_) + local_total
                $("#ownprice_"+product_id).val(own_price)
            }
            price_edits['pid-'+product_id]=own_price;
            doo_formats(product_id)
        }
        var gr = "green";
        function own_price_changed(product_id, cost_price, own_price)
        {
            if($("#custom_tax_checkbox").is(":checked")){
                var profit_ = parseFloat(own_price) - cost_price
                var ratio_ = (profit_/cost_price*100).toFixed(2);
                $("#profit_"+product_id).val(profit_)
                $("#profit_ratio_"+product_id).val(ratio_)
                $("#ownprice_"+product_id).val(parseFloat(profit_) + cost_price)
                var custom_tax_value = $("#custom_tax_value").val()
                var tax = parseFloat(own_price) * (parseFloat(custom_tax_value) / 100)
                $("#tax_"+product_id).text(tax.toFixed(2));
                $("#total_"+product_id).text((parseFloat(own_price) + tax).toFixed(2));
            }else{
                var local_total = parseFloat($("#local_total_"+product_id).text())
                var profit_ = parseFloat(own_price) - local_total
                var ratio_ = (profit_/local_total*100).toFixed(2);
                $("#profit_"+product_id).val(profit_)
                $("#profit_ratio_"+product_id).val(ratio_)
                $("#ownprice_"+product_id).val(parseFloat(profit_) + local_total)
            }
            doo_formats(product_id)
        }

        function doo_formats(product_id){
            //
            if(parseFloat($("#profit_"+product_id).val()) <= 0){
                gr = "red"
                $("#profit_"+product_id).removeClass('border-green-600')
                $("#profit_"+product_id).addClass('border-red-600')
            }else{
                gr = "green"
                $("#profit_"+product_id).addClass('border-green-600')
                $("#profit_"+product_id).removeClass('border-red-600')
            }
            if(parseFloat($("#profit_ratio_"+product_id).val()) <= 0){
                gr = "red"
                $("#profit_"+product_id).removeClass('border-green-600')
                $("#profit_"+product_id).addClass('border-red-600')
            }else{
                gr = "green"
                $("#profit_"+product_id).addClass('border-green-600')
                $("#profit_"+product_id).removeClass('border-red-600')
            }
            if(gr == "red"){
                $("#product_"+product_id).find(".gr").removeClass('border-green-600')
                $("#product_"+product_id).find(".gr").addClass('border-red-600')
            }else{
                $("#product_"+product_id).find(".gr").addClass('border-green-600')
                $("#product_"+product_id).find(".gr").removeClass('border-red-600')
            }
            //
        }
    </script>
