<script>
//globals
var cariForm;

function convertToRupiah(angka)
{
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}

function initAlert(){
    AlertUtil = {
        showSuccess : function(message,timeout){
            $("#success_message").html(message);
            if(timeout != undefined){
                setTimeout(function(){
                    $("#success_alert_dismiss").trigger("click");
                },timeout)
            }
            $("#success_alert").show();
            KTUtil.scrollTop();
        },
        hideSuccess : function(){
            $("#success_alert_dismiss").trigger("click");
        },
        showFailed : function(message,timeout){
            $("#failed_message").html(message);
            if(timeout != undefined){
                setTimeout(function(){
                    $("#failed_alert_dismiss").trigger("click");
                },timeout)
            }
            $("#failed_alert").show();
            KTUtil.scrollTop();
        },
        hideFailed : function(){
            $("#failed_alert_dismiss").trigger("click");
        },
        showFailedDialogAdd : function(message,timeout){
            $("#failed_message_add").html(message);
            if(timeout != undefined){
                setTimeout(function(){
                    $("#failed_alert_dismiss_add").trigger("click");
                },timeout)
            }
            $("#failed_alert_add").show();
        },
        hideSuccessDialogAdd : function(){
            $("#failed_alert_dismiss_add").trigger("click");
        },
        showFailedDialogEdit : function(message,timeout){
            $("#failed_message_edit").html(message);
            if(timeout != undefined){
                setTimeout(function(){
                    $("#failed_alert_dismiss_edit").trigger("click");
                },timeout)
            }
            $("#failed_alert_edit").show();
        },
        hideSuccessDialogAdd : function(){
            $("#failed_alert_dismiss_edit").trigger("click");
        }
    }
    $("#failed_alert_dismiss").on("click",function(){
        $("#failed_alert").hide();
    })
    $("#success_alert_dismiss").on("click",function(){
        $("#success_alert").hide();
    })
    $("#failed_alert_dismiss_add").on("click",function(){
        $("#failed_alert_add").hide();
    })
    $("#failed_alert_dismiss_edit").on("click",function(){
        $("#failed_alert_edit").hide();
    })
}

function initCariForm(){
    //validator
    var validator = $("#form_bukukas").validate({
        ignore:[],
        rules: {
            area: {
                required: true,
            },
            unit: {
                required: true,
            }
        },
        invalidHandler: function(event, validator) {
            KTUtil.scrollTop();
        }
    });

    $('#area').select2({ placeholder: "Select Area", width: '100%' });
    $('#unit').select2({ placeholder: "Select Unit", width: '100%' });
    //events
    $('#btncari').on('click',function(){
        $('.rowappend').remove();
		var unit = $('[name="id_unit"]').val();
		var area = $('[name="area"]').val();
		var dateStart = $('[name="date-start"]').val();
		var dateEnd = $('[name="date-end"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/report"); ?>",
			dataType : "json",
			data:{id_unit:unit,dateStart:dateStart,dateEnd:dateEnd, area:area},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
                    var amountIn = 0;
                    var amountOut = 0;
                    var amountBalanceFinal = 0;
                    var amountGap = 0;
                    var amountBalanceFirst = 0;
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
						template += "<td class='text-center'>"+no+"</td>";
						template += "<td class='text-center'>"+data.kasir+"</td>";
						template += "<td class='text-center'>"+moment(data.date).format('DD-MM-YYYY')+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_balance_first)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_in)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_out)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_balance_final)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_gap)+"</td>";
						template += "<td class='text-center'><span data-id='"+data.id+"' href='' class='btn btn-sm btn-clean btn-icon btn-icon-md viewBtn' title='View Data' data-toggle='modal' data-target='#modal_view'><i class='flaticon-eye' style='cursor:pointer;'></i></span></td>";
						template += '</tr>';
						no++;
                        amountIn += parseInt(data.amount_in);
                        amountOut += parseInt(data.amount_out);
                        amountBalanceFinal += parseInt(data.amount_balance_final);
                        amountGap += parseInt(data.amount_gap);
                        amountBalanceFirst += parseInt(data.amount_balance_first);
					});
                    $('.kt-section__content table').find('tfoot').find('.saldoawal').text(convertToRupiah(amountBalanceFirst));
                    $('.kt-section__content table').find('tfoot').find('.penerimaan').text(convertToRupiah(amountIn));
                    $('.kt-section__content table').find('tfoot').find('.pengeluaran').text(convertToRupiah(amountOut));
                    $('.kt-section__content table').find('tfoot').find('.saldoakhir').text(convertToRupiah(amountBalanceFinal));
                    $('.kt-section__content table').find('tfoot').find('.selisih').text(convertToRupiah(amountGap));
					$('.kt-section__content table').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

    $('[name="area"]').on('change',function(){
        var area = $(this).val();
        var units =  document.getElementById('unit');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unit").empty();
				var opt = document.createElement("option");
				opt.value = "0";
				opt.text = "All";
				units.appendChild(opt);
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id;
                    opt.text = response.data[i].name;
                    units.appendChild(opt);
                }
            }
        });
    });

function popView(el)
{
    $('.rowappend_kertas').remove();
    $('.rowappend_logam').remove();
    var id = $(el).attr('data-id');
    //console.log(id);  
    $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/getBookCash"); ?>",
			dataType : "json",
			data:{id:id},
			success : function(response,status){
				if(response.status == true){
                    console.log(response.data.name);
                    $('#units').val(response.data.name);
                    $('#kasir').val(response.data.name);
                    $('#date').val(response.data.date);
                    $('#saldoawal').val(response.data.amount_balance_final);
                    $('#penerimaan').val(response.data.amount_in);
                    $('#pengeluaran').val(response.data.amount_out);
                    $('#mutasi').val(response.data.amount_mutation);
                    $('#saldoakhir').val(response.data.amount_balance_first);
                    $('#selisih').val(response.data.amount_gap);                   
                    
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				//KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});

        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/getDetailBookCash"); ?>",
			dataType : "json",
			data:{id:id},
			success : function(response,status){
				if(response.status == true){
                    var templateKertas = '';
                    var templateLogam = '';
					var no = 1;
					var k_totpecahan = 0;
					var l_totpecahan = 0;
                    var totalkertas = 0;
                    var totallogam  = 0;
                    var total  = 0;
                    $.each(response.data, function (index, data) {
                        if(data.type=="KERTAS"){
                            templateKertas += "<tr class='rowappend_kertas'>";
                            templateKertas += "<td>"+convertToRupiah(data.amount)+"</td>";
                            templateKertas += "<td>"+data.summary+"</td>";
                            k_totpecahan = parseInt(data.amount) * parseInt(data.summary);
                            templateKertas += "<td class='text-right'>"+convertToRupiah(k_totpecahan)+"</td>";
                            templateKertas += '</tr>';
                            totalkertas +=k_totpecahan;
                            no++;
                        }
                        if(data.type=="LOGAM"){
                            templateLogam += "<tr class='rowappend_logam'>";
                            templateLogam += "<td>"+convertToRupiah(data.amount)+"</td>";
                            templateLogam += "<td>"+data.summary+"</td>";
                            l_totpecahan = parseInt(data.amount) * parseInt(data.summary);
                            templateLogam += "<td class='text-right'>"+convertToRupiah(l_totpecahan)+"</td>";
                            templateLogam += '</tr>';
                            totallogam +=l_totpecahan;
                            no++;
                        }						
					});
                    templateKertas += '<tr class="rowappend_kertas">';
                    templateKertas +='<td colspan="2" class="text-right"></td>';                    
                    templateKertas +='<td class="text-right"><b>'+convertToRupiah(totalkertas)+'</b></td>';                    
                    templateKertas +='</tr>';

                    templateLogam += '<tr class="rowappend_logam">';
                    templateLogam +='<td colspan="2" class="text-right"></td>';                    
                    templateLogam +='<td class="text-right"><b>'+convertToRupiah(totallogam)+'</b></td>';                    
                    templateLogam +='</tr>';
                    total = parseInt(totalkertas) + parseInt(totallogam);
					$('#kertas').append(templateKertas);
					$('#logam').append(templateLogam);
                    $('#total').val(total);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				//KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
    
}

jQuery(document).ready(function() {
    initCariForm();
    initGetUnit();

    $(document).on("click", ".viewBtn", function () {
                var el = $(this);
                popView(el);
    });
});

var type = $('[name="area"]').attr('type');
if(type == 'hidden'){
	$('[name="area"]').trigger('change');
}
</script>
