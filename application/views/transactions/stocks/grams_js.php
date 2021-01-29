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
                id_unit:event.target.querySelector('[name="id_unit"]').value,
            },
            dataType:"JSON",
            type:"GET",
            success:function(res){
                const cloneds = document.querySelector('.table').querySelectorAll('[data-template="item-cloned"]');
                if(cloneds.length > 0){
                    cloneds.forEach(el=>el.remove());
                }
                let totalWeight = 0;
                let totalPieces = 0;
                res.data.forEach(data=>{
                    const table = document.querySelector('.table').querySelector('[data-template="item"]').cloneNode(true);
                    table.classList.remove('d-none');
                    table.setAttribute('data-template','item-cloned');
                    table.querySelector('[data-post="weight"]').textContent = data.weight+' grams';
                    table.querySelector('[data-post="stock_begin"]').textContent = data.stock_begin;
                    table.querySelector('[data-post="stock_in"]').textContent = data.stock_in;
                    table.querySelector('[data-post="total"]').textContent = data.total;
                    table.querySelector('[data-post="stock_out"]').textContent = data.stock_out;
                    table.querySelector('[data-post="total-weight"]').textContent = (data.total*data.weight).toFixed(2);
                    document.querySelector('.table').querySelector('tbody').appendChild(table);
                    totalWeight += data.total*data.weight;
                    totalPieces += parseInt(data.total);
                })
                let tr = '<tr data-template="item-cloned">'
                tr += `<td colspan="4">Total</td>`
                tr += `<td >${totalPieces}</td>`
                tr += `<td>${totalWeight.toFixed(2)}</td>`
                tr += '</tr>'
                $('.table').find('tbody').append(tr);
            }
        })
    }

    $('#form_bukukas').trigger('submit');

    const excel = (event) =>{
        const date_start = event.target.closest('form').querySelector('[name="date_start"]').value;
        const date_end = event.target.closest('form').querySelector('[name="date_end"]').value;
        const id_unit =  event.target.closest('form').querySelector('[name="id_unit"]').value;
        window.location.href = `<?php echo base_url('transactions/stocks/export');?>?date_start=${date_start}&date_end=${date_end}&id_unit=${id_unit}`
    }
    const pdf = (event) =>{
        const date_start = event.target.closest('form').querySelector('[name="date_start"]').value;
        const date_end = event.target.closest('form').querySelector('[name="date_end"]').value;
        const id_unit =  event.target.closest('form').querySelector('[name="id_unit"]').value;
        window.location.href = `<?php echo base_url('transactions/stocks/pdf');?>?date_start=${date_start}&date_end=${date_end}&id_unit=${id_unit}`
    }
</script>