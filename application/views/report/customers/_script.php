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
        var unit = $('[name="id_unit"]').val();
        var statusrpt = $('#status').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportcustomers"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,statusrpt:statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var totamount = 0;
					var totadmin = 0;
                    var status="";

					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
						template += "<td class='text-center'>"+no+"</td>";
						template += "<td class='text-left'>"+data.unit_name+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";
                        if(data.date_repayment!=null){ var DateRepayment = moment(data.date_repayment).format('DD-MM-YYYY');}else{ var DateRepayment = "-";}
						template += "<td class='text-center'>"+DateRepayment+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
						template += "<td class='text-center'>"+status+"</td>";
						template += '</tr>';
                        totamount +=parseInt(data.amount);
                        totadmin +=parseInt(data.admin);
						no++;						
					});
                    template += "<tr class='rowappend'>";
                    template += "<td colspan='8' class='text-center'></td>";
                    template += "<td class='text-right'>"+convertToRupiah(totadmin)+"</td>";
                    template += "<td class='text-right'>"+convertToRupiah(totamount)+"</td>";
                    template += "<td class='text-center'></td>";
					template += '</tr>';
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

jQuery(document).ready(function() {
    initCariForm();
    //initGetUnit();
});

$('[name="area"]').on('change',function(){
        var area = $('[name="area"]').val();
        var units =  $('[name="id_unit"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unit").empty();
                var opt = document.createElement("option");
                    opt.value = "all";
                    opt.text = "All";
                    units.append(opt);
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id;
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

</script>
