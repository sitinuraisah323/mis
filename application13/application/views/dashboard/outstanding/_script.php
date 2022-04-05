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
		var dateStart = $('[name="date"]').val();
		var lasttrans = "";
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/dashboards/outstanding"); ?>",
			dataType : "json",
			data:{area:area,cabang:cabang,id_unit:unit,date:dateStart},
			success : function(response,status){
				KTApp.unblockPage();
				var html = '';
				var foot = '';
				var int = 1;
				var totalNoaOstYesterday = 0;
				var totalNoaOstToday = 0;
				var totalUpOstToday = 0;
				var totalUpaOstYesterday = 0;
				var totalRepaymentTodayUp = 0;
				var totalRepaymentTodayNoa = 0;
				var totalOstNoa = 0;
				var totalOstUp = 0;
				var totalOstTicket = 0;
				var totalDisbureNoa = 0;
				var totalDisbureUp = 0;
				var totalDisbureTicket = 0;
				$.each(response.data, function (index, data) {
					totalNoaOstYesterday += parseInt(data.ost_yesterday.noa);
					totalNoaOstToday += parseInt(data.credit_today.noa);
				    totalUpOstToday += parseInt(data.credit_today.up);
					totalUpaOstYesterday += parseInt(data.ost_yesterday.up);
					totalRepaymentTodayUp += parseInt(data.repayment_today.up);
					totalRepaymentTodayNoa += parseInt(data.repayment_today.noa);
					totalOstNoa += parseInt(data.total_outstanding.noa);
					totalOstUp += parseInt(data.total_outstanding.up);
					totalOstTicket += parseInt(data.total_outstanding.tiket);
					totalDisbureNoa += parseInt(data.total_disburse.noa);
					totalDisbureUp += parseInt(data.total_disburse.credit);
					totalDisbureTicket += parseInt(data.total_disburse.tiket.toFixed(2));
					html += '<tr>'
					html += '<td class="text-center">'+ int +'</td>';
					html += '<td>'+ data.name +'</td>';
					html += '<td>'+ data.area +'</td>';
					html += '<td> </td>';
					html += '<td> </td>';
					html += '<td class="text-center">'+data.ost_yesterday.noa+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.ost_yesterday.up)+'</td>';
					html += '<td class="text-center">'+data.credit_today.noa+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.credit_today.up)+'</td>';
					html += '<td class="text-center">'+data.repayment_today.noa+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.repayment_today.up)+'</td>';
					html += '<td class="text-center">'+data.total_outstanding.noa+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.total_outstanding.up)+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.total_outstanding.tiket)+'</td>';
					html += '<td class="text-center">'+data.total_disburse.noa+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.total_disburse.credit)+'</td>';
					html += '<td class="text-right">'+convertToRupiah(data.total_disburse.tiket.toFixed(2))+'</td>';
					html += '</tr>'
					int++;
					lasttrans = data.lasttrans;
				});

				$('.table').find('tbody').find('tr').remove();
				$('.table').find('tbody').html(html);

				foot += '<tr>'
				foot += '<td class="text-right" colspan="5">Total</td>';
				foot += '<td class="text-center">'+totalNoaOstYesterday+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalUpaOstYesterday)+'</td>';
				foot += '<td class="text-center">'+totalNoaOstToday+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalUpOstToday)+'</td>';
				foot += '<td class="text-center">'+totalRepaymentTodayNoa+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalRepaymentTodayUp)+'</td>';
				foot += '<td class="text-center">'+totalOstNoa+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalOstUp)+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalOstTicket)+'</td>';
				foot += '<td class="text-center">'+totalDisbureNoa+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalDisbureUp)+'</td>';
				foot += '<td class="text-right">'+convertToRupiah(totalDisbureTicket)+'</td>';
				foot += '</tr>'

				$('.table').find('tfoot').remove('tr');
				$('.table').find('tfoot').html(foot);


				console.log(html)

			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				var date =  moment(lasttrans).format('DD-MM-YYYY');
				var res = new Date(lasttrans);
				var kemarin = res.setDate(res.getDate()-1);
				var kemarin =  moment(kemarin).format('DD-MM-YYYY');
				document.getElementById("dateos").innerHTML=kemarin;
				document.getElementById("datecredit").innerHTML=date;
				document.getElementById("datecicilan").innerHTML=date;
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
