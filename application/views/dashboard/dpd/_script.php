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

    $('#area').select2({ placeholder: "Select area", width: '100%' });
    $('#unit').select2({ placeholder: "Select Unit", width: '100%' });
    $('#status').select2({ placeholder: "Select a status", width: '100%' });
    //events
    $('#btncari').on('click',function(){
        $('.rowappend').remove();
        var area = $('[name="area"]').val();
        var cabang = $('[name="cabang"]').val();
        var unit = $('[name="id_unit"]').val();
		var date = $('[name="date"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/dashboards/outstanding"); ?>",
			dataType : "json",
			data:{area:area,cabang:cabang,unit:unit,date:date},
			success : function(response,status){
				KTApp.unblockPage();
				var html = '';
				var tfoot = '';
				var int = 1;
				var dpdYesterdayNoa = 0;
				var dpdYesterdayUp = 0;
				var dpdTodayNoa = 0;
				var dpdTodayUp = 0;
				var dpdRepaymentNoa = 0;
				var dpdRepaymentUp = 0;
				var dpdTotalNoa = 0;
				var dpdTotalUp = 0;
				var percentage = 0;
				$.each(response.data, function (index, data) {
					dpdYesterdayNoa += data.dpd_yesterday.noa;
					dpdYesterdayUp += data.dpd_yesterday.ost;
					dpdTodayNoa += data.dpd_today.noa;
					dpdTodayUp += data.dpd_today.ost;
					dpdRepaymentNoa += data.dpd_repayment_today.noa;
					dpdRepaymentUp += data.dpd_repayment_today.ost;
					dpdTotalNoa += data.total_dpd.noa;
					dpdTotalUp += data.total_dpd.ost;
					percentage += data.percentage;
					html += '<tr>';
					html += '<td  class="text-center">'+ int +'</td>';
					html += '<td>'+ data.name +'</td>';
					html += '<td>'+ data.area +'</td>';
					html += '<td> </td>';
					html += '<td> </td>';
					html += '<td  class="text-center">'+data.dpd_yesterday.noa+'</td>';
					html += '<td  class="text-right">'+convertToRupiah(data.dpd_yesterday.ost)+'</td>';
					html += '<td  class="text-center">'+data.dpd_today.noa+'</td>';
					html += '<td  class="text-right">'+convertToRupiah(data.dpd_today.ost)+'</td>';
					html += '<td  class="text-center">'+data.dpd_repayment_today.noa+'</td>';
					html += '<td  class="text-right">'+convertToRupiah(data.dpd_repayment_today.ost)+'</td>';
					html += '<td  class="text-center">'+data.total_dpd.noa+'</td>';
					html += '<td  class="text-right">'+convertToRupiah(data.total_dpd.ost)+'</td>';
					html += '<td  class="text-center">'+parseFloat(data.percentage*100).toFixed(2)+'</td>';
					html += '</tr>';
					int++;
				});
				tfoot += '<tr>';
				tfoot += '<td  class="text-right" colspan="5">Total</td>';
				tfoot += '<td  class="text-center">'+dpdYesterdayNoa+'</td>';
				tfoot += '<td  class="text-right">'+convertToRupiah(dpdYesterdayUp)+'</td>';
				tfoot += '<td  class="text-center">'+dpdTodayNoa+'</td>';
				tfoot += '<td  class="text-right">'+convertToRupiah(dpdTodayUp)+'</td>';
				tfoot += '<td  class="text-center">'+dpdRepaymentNoa+'</td>';
				tfoot += '<td  class="text-right">'+convertToRupiah(dpdRepaymentUp)+'</td>';
				tfoot += '<td  class="text-center">'+dpdTotalNoa+'</td>';
				tfoot += '<td  class="text-right">'+convertToRupiah(dpdTotalUp)+'</td>';
				tfoot += '<td  class="text-center">'+parseFloat(percentage*100).toFixed(2)+'</td>';
				tfoot += '</tr>';

				$('.table').find('tbody').find('tr').remove();
				$('.table').find('tbody').html(html);
				$('.table').find('tfoot').html(tfoot);

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
	var area = $('[name="area"]').val();
	var units =  $('[name="id_unit"]');
	var url_data = $('#url_get_unit').val() + '/' + area;
	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unit").empty();
			units.append('<option value="0">All</option>');
			for (var i = 0; i < response.data.length; i++) {
				var opt = document.createElement("option");
				opt.value = response.data[i].code;
				opt.text = response.data[i].name;
				units.append(opt);
			}
		}
	});
});
var type = $('[name="area"]').attr('type');
if(type == 'hidden'){
	$('[name="area"]').trigger('change');
}

$('[name="cabang"]').on('change',function(){
	var cabang = $('[name="cabang"]').val();
	var units =  $('[name="id_unit"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;
	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unit").empty();
			units.append('<option value="0">All</option>');
			for (var i = 0; i < response.data.length; i++) {
				var opt = document.createElement("option");
				opt.value = response.data[i].id;
				opt.text = response.data[i].name;
				units.append(opt);
			}
		}
	});
});

var typecabang = $('[name="cabang"]').attr('type');
if(typecabang == 'hidden'){
	$('[name="cabang"]').trigger('change');
}

jQuery(document).ready(function() {
    initCariForm();
});

</script>
