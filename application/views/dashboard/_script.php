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

// function convertToRupiah(angka){
//    var reverse = angka.toString().split('').reverse().join(''),
//    ribuan = reverse.match(/\d{1,3}/g);
//    ribuan = ribuan.join('.').split('').reverse().join('');
//    return ribuan;
//  }

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
        var area = $('#area').val();
		var dateStart = $('[name="date-start"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/dashboards/outstanding"); ?>",
			dataType : "json",
			data:{area:area,date:dateStart},
			success : function(response,status){
				KTApp.unblockPage();
				var html = '';
				var int = 1;
				$.each(response.data, function (index, data) {
					html += '<tr>'
					html += '<td>'+ int +'</td>';
					html += '<td>'+ data.name +'</td>';
					html += '<td>'+ data.area +'</td>';
					html += '<td> </td>';
					html += '<td> </td>';
					html += '<td>'+data.ost_yesterday.noa+'</td>';
					html += '<td>'+data.ost_yesterday.up+'</td>';
					html += '<td>'+data.credit_today.noa+'</td>';
					html += '<td>'+data.credit_today.up+'</td>';
					html += '<td>'+data.repayment_today.noa+'</td>';
					html += '<td>'+data.repayment_today.up+'</td>';
					html += '<td>'+data.total_outstanding.noa+'</td>';
					html += '<td>'+data.total_outstanding.up+'</td>';
					html += '<td>'+data.total_outstanding.tiket+'</td>';
					html += '<td>'+data.total_disburse.noa+'</td>';
					html += '<td>'+data.total_disburse.credit+'</td>';
					html += '<td>'+data.total_disburse.tiket+'</td>';
					html += '<td>'+data.dpd_yesterday.noa+'</td>';
					html += '<td>'+data.dpd_yesterday.ost+'</td>';
					html += '<td>'+data.dpd_today.noa+'</td>';
					html += '<td>'+data.dpd_today.ost+'</td>';
					html += '<td>'+data.dpd_repayment_today.noa+'</td>';
					html += '<td>'+data.dpd_repayment_today.ost+'</td>';
					html += '<td>'+data.total_dpd.noa+'</td>';
					html += '<td>'+data.total_dpd.ost+'</td>';
					html += '<td>'+data.percentage+'</td>';
					html += '</tr>'
					int++;
				});
				$('.table').find('tbody').find('tr').remove();
				$('.table').find('tbody').html(html);
				console.log(html)

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

jQuery(document).ready(function() {
    initCariForm();
    initGetUnit();
});

</script>
