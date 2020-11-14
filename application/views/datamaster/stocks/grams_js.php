<script>
    $('#area').select2({ placeholder: "Select Area", width: '100%' });
    $('#unit').select2({ placeholder: "Select Unit", width: '100%' });
    $('#status').select2({ placeholder: "Select a Status", width: '100%' });

    const searchHandler = (event)=>{
        event.preventDefault();
        const id_area =   $('#area').val();
        const id_unit =   $('#unit').val();
        $.ajax({
            url:"<?php echo base_url();?>api/lm/stocks/grams",
            data:{
                date_start:event.target.querySelector('[name="date_start"]').value,
                date_end:event.target.querySelector('[name="date_end"]').value,
                id_area, id_unit
            },
            dataType:"JSON",
            type:"GET",
            success:function(res){
                const cloneds = document.querySelector('.table').querySelectorAll('[data-template="item-cloned"]');
                if(cloneds.length > 0){
                    cloneds.forEach(el=>el.remove());
                }
                res.data.forEach(data=>{
                    const table = document.querySelector('.table').querySelector('[data-template="item"]').cloneNode(true);
                    table.classList.remove('d-none');
                    table.setAttribute('data-template','item-cloned');
                    table.querySelector('[data-post="weight"]').textContent = data.weight+' grams';
                    table.querySelector('[data-post="unit"]').textContent = data.unit;
                    table.querySelector('[data-post="stock_begin"]').textContent = data.stock_begin;
                    table.querySelector('[data-post="stock_in"]').textContent = data.stock_in;
                    table.querySelector('[data-post="total"]').textContent = data.total;
                    table.querySelector('[data-post="stock_out"]').textContent = data.stock_out;
                    table.querySelector('[data-post="price"]').textContent = convertToRupiah(data.price);
                    document.querySelector('.table').querySelector('tbody').appendChild(table);
                })
            }
        })
    }

    $('#form_bukukas').trigger('submit');

    const excel = (event) =>{
        const date_start = event.target.closest('form').querySelector('[name="date_start"]').value;
        const date_end = event.target.closest('form').querySelector('[name="date_end"]').value;
        const id_unit = $('#unit').val();
        const id_area = $('#area').val();
        window.location.href = `<?php echo base_url('datamaster/stocks/export');?>?date_start=${date_start}&date_end=${date_end}&id_area=${id_area}&id_unit=${id_unit}`
    }

    
    $('[name="area"]').on('change',function(){
            var area = $('[name="area"]').val();
            var units =  $('[name="id_unit"]');
            var url_data = '<?php echo base_url();?>/api/datamaster/units/get_units_cicilan_byarea/' + area;
            $.get(url_data, function (data, status) {
                var response = JSON.parse(data);
                if (status) {
                    $("#unit").empty();
                    var opt = document.createElement("option");
                    opt.value = "0";
                    opt.text = "All";
                    units.append(opt)
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id;
                        opt.text = response.data[i].name;
                        units.append(opt);
                    }
                }
            });
    });
</script>