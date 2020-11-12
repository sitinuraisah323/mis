<script>
    $('#area').select2({ placeholder: "Select Area", width: '100%' });
    $('#unit').select2({ placeholder: "Select Unit", width: '100%' });
    $('#status').select2({ placeholder: "Select a Status", width: '100%' });

    const searchHandler = (event)=>{
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url();?>/api/lm/stocks/grams",
            data:{
                date_start:event.target.querySelector('[name="date_start"]').value,
                date_end:event.target.querySelector('[name="date_end"]').value,
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
        window.location.href = `<?php echo base_url('datamaster/stocks/export');?>?date_start=${date_start}&date_end=${date_end}`
    }
</script>