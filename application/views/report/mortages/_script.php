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

    $('#area').select2({ placeholder: "Select a area", width: '100%' });
    $('#unit').select2({ placeholder: "Select a Unit", width: '100%' });
    $('#status').select2({ placeholder: "Select a status", width: '100%' });
    //events
    $('#btncari').on('click',function(){
        $('.rowappend').remove();
        var area = $('#area').val();
        var unit = $('#unit').val();
        var statusrpt = $('#status').val();
		var dateStart = $('[name="date-start"]').val();
		var dateEnd = $('[name="date-end"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/mortages/report"); ?>",
			dataType : "json",
			data:{id_unit:unit,statusrpt:statusrpt,dateStart:dateStart,dateEnd:dateEnd},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
						template += "<td class='text-center'>"+no+"</td>";
						template += "<td class='text-center'><a href='#' class='viewcicilan' data-toggle='modal' data-target='#modal_cicilan' data-id="+data.no_sbk+" data-unit="+data.id_unit+">"+data.no_sbk+"</a></td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
						template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";
						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount_loan)+"</td>";
						template += "<td class='text-right'></td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount_loan);
						admin += parseInt(data.amount_admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='7' class='text-right'>Total</td>";
					template += "<td class='text-right'>"+convertToRupiah(admin)+"</td>";
					template += "<td class='text-right'>"+convertToRupiah(amount)+"</td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-section__content #tblcicilan').append(template);
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

function initGetUnit(){
    $("#area").on('change',function(){
        var area = $('#area').val();
        var units =  document.getElementById('unit');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unit").empty();
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id;
                    opt.text = response.data[i].name;
                    units.appendChild(opt);
                }
            }
        });
    });
}

function popView(el){
    $('.rowappend_mdl').remove();
    var nosbk = $(el).attr('data-id');
    var unit = $(el).attr('data-unit');
    //alert(unit);
    KTApp.block('#form_bukukas .kt-portlet__body', {});
    $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/repaymentmortage/get_byid"); ?>",
			dataType : "json",
			data:{nosbk:nosbk,unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend_mdl'>";
						template += "<td class='text-center'>"+no+"</td>";
                        template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_kredit).format('DD-MM-YYYY')+"</td>";
                        if(data.date_installment ==null || data.date_installment =="1970-01-01"){ var datePayment="-"; }else{ var datePayment = moment(data.date_installment).format('DD-MM-YYYY');}
						template += "<td class='text-center'>"+datePayment+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        template += "<td class='text-right'>"+convertToRupiah(data.capital_lease)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.saldo)+"</td>";
						template += '</tr>';
						no++;
					});
					$('.kt-portlet__body #mdl_vwcicilan').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
}

jQuery(document).ready(function() {
    initCariForm();
    initGetUnit();

    $(document).on("click", ".viewcicilan", function () {
                var el = $(this);
                popView(el);
    });
});

</script>
