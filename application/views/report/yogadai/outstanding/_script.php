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
        var area = $('[name="area_id"]').val();
        var cabang = $('[name="branch_id"]').val();
        var unit = $('[name="unit_id"]').val();
		var date = $('[name="date"]').val();
		var lastdate ="";
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/yogadai/outstanding"); ?>",
			dataType : "json",
			data:{area:area,cabang:cabang,unit:unit,date:date},
			success : function(response,status){
				KTApp.unblockPage();
				//if(response.status == true){
					var template = '';
					var no = 1;
					var yesterdayOst = 0;
					var yesterdayNoa = 0;
                    var todayOstRegulerCredit = 0;
                    var todayNoaRegulerCredit = 0;
                    var todayOstRegulerRepayment = 0;
                    var todayNoaRegulerRepayment = 0;

                    var todayOstMortagesCredit = 0;
                    var todayNoaMortagesCredit = 0;
                    var todayOstMortagesRepayment = 0;
                    var todayNoaMortagesRepayment = 0;
                    var totalOstNoa = 0;
                    var totalOstUp = 0;
                    var totalDisburUp = 0;
                    var totalDisburNoa = 0

					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-center'>"+no+"</td>";
                        template += "<td class='text-left'>"+data.name+"</td>";
                        template += "<td class='text-center'>"+data.ost_yesterday.noa+"</td>";
                        template += "<td class='text-right'>"+data.ost_yesterday.up+"</td>";

                        template += "<td class='text-center'>"+data.credit_today.noa_reguler+"</td>";
                        template += "<td class='text-right'>"+data.credit_today.up_reguler+"</td>";
                        template += "<td class='text-center'>"+data.repayment_today.noa_reguler+"</td>";
                        template += "<td class='text-right'>"+data.repayment_today.up_reguler+"</td>";
                        
                        template += "<td class='text-center'>"+data.credit_today.noa_mortages+"</td>";
                        template += "<td class='text-right'>"+data.credit_today.up_mortages+"</td>";
                        template += "<td class='text-center'>"+data.repayment_today.noa_mortages+"</td>";
                        template += "<td class='text-right'>"+data.repayment_today.up_mortages+"</td>";
                    template += "<td class='text-right'>"+data.total_outstanding.noa+"</td>";
                        template += "<td class='text-right'>"+data.total_outstanding.up+"</td>";
                        totalOstNoa += data.total_outstanding.noa;
                     
                        template += "<td class='text-center'>"+data.total_disburse.noa+"</td>";
                        template += "<td class='text-right'>"+data.total_disburse.credit+"</td>";
                        template += "<td class='text-right'>"+data.total_disburse.tiket+"</td>";
                       
                        template += '</tr>';
						no++;

                        totalDisburUp += data.total_disburse.credit;
                        totalDisburNoa += data.total_disburse.noa;

                        totalOstUp += data.total_outstanding.up;
                        yesterdayOst += data.ost_yesterday.up;
                        yesterdayNoa += data.ost_yesterday.noa;

                        todayOstRegulerCredit += data.credit_today.up_reguler;
                        todayNoaRegulerCredit += data.credit_today.noa_reguler;

                        todayNoaRegulerRepayment += data.repayment_today.noa_reguler;
                        todayOstRegulerRepayment += data.repayment_today.up_reguler;

                        todayOstMortagesCredit += data.credit_today.up_mortages;
                        todayNoaMortagesCredit += data.credit_today.noa_mortages;

                        todayNoaMortagesRepayment += data.repayment_today.noa_mortages;
                        todayOstMortagesRepayment += data.repayment_today.up_mortages;
                        
                        lastdate = data.lastdate;
					});

                    template += "<tr class='rowappend'>";
                    template += "<td class='text-center'></td>";
                    template += "<td class='text-left'></td>";
                    template += "<td class='text-center'>"+yesterdayNoa+"</td>";
                    template += "<td class='text-right'>"+yesterdayOst+"</td>";

                    template += "<td class='text-center'>"+todayNoaRegulerCredit+"</td>";
                    template += "<td class='text-right'>"+todayOstRegulerCredit+"</td>";
                    template += "<td class='text-center'>"+todayNoaRegulerRepayment+"</td>";
                    template += "<td class='text-right'>"+todayOstRegulerRepayment+"</td>";
                    
                    template += "<td class='text-center'>"+todayNoaMortagesCredit+"</td>";
                    template += "<td class='text-right'>"+todayOstMortagesCredit+"</td>";
                    template += "<td class='text-center'>"+todayNoaMortagesRepayment+"</td>";
                    template += "<td class='text-right'>"+todayOstMortagesRepayment+"</td>";
                    template += "<td class='text-right'>"+totalOstNoa+"</td>";
                
                    template += "<td class='text-right'>"+totalOstUp+"</td>";
                    
                    template += "<td class='text-center'>"+totalDisburNoa+"</td>";
                    template += "<td class='text-right'>"+totalDisburUp+"</td>";
                    template += "<td class='text-right'>"+(totalDisburUp/totalDisburNoa).toFixed(2)+"</td>";
                    
                    template += '</tr>';

					$('.kt-section__content table').append(template);
				//}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
                //var date =  moment(lastdate).format('DD-MM-YYYY');
				//document.getElementById("dateos").innerHTML="(Last Date Transaction in " + date + ")";
				KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}




const initArea = ()=>{
    $.ajax({
        type : 'GET',
        url : "<?php echo base_url("api/yogadai/datamaster/areas"); ?>",
        dataType : "json",
        success:function(res){
            let template = '<option value="">All</option>';
            res.data.forEach(res=>{
                template += `<option value="${res.id}">${res.name}</option>`;
            })
            $('[name="area_id"]').append(template);
        },
        error:function(e){
            console.log(e);
        }
    });
}

$('[name="area_id"]').on('change', function(){
    let area_id = $(this).val();
    $('[name="branch_id"]').empty();
    $('[name="unit_id"]').empty();
    $.ajax({
        type : 'GET',
        url : "<?php echo base_url("api/yogadai/datamaster/branchies"); ?>/"+area_id,
        dataType : "json",
        success:function(res){
            let template = '<option value="">All</option>';
            res.data.forEach(res=>{
                template += `<option value="${res.id}">${res.name}</option>`;
            })
            $('[name="branch_id"]').append(template);
        },
        error:function(e){
            console.log(e);
        }
    });
})


$('[name="branch_id"]').on('change', function(){
    let branch_id = $(this).val();
    $('[name="unit_id"]').empty();
    $.ajax({
        type : 'GET',
        url : "<?php echo base_url("api/yogadai/datamaster/units"); ?>/"+branch_id,
        dataType : "json",
        success:function(res){
            let template = '<option value="">All</option>';
            res.data.forEach(res=>{
                template += `<option value="${res.name}">${res.name}</option>`;
            })
            $('[name="unit_id"]').append(template);
        },
        error:function(e){
            console.log(e);
        }
    });
})

$('#btnexport_csv').on('click', function(e){
    var area = $('[name="area_id"]').val() ? $('[name="area_id"]').val() : '';
    var cabang = $('[name="branch_id"]').val() ? $('[name="branch_id"]').val() : '';
    var unit = $('[name="unit_id"]').val() ? $('[name="unit_id"]').val() : '';
    var date = $('[name="date"]').val() ? $('[name="date"]').val() : '';
    window.location.href = `<?php echo base_url('report/yogadai/excel');?>?area=${area}&cabang=${cabang}&unit=${unit}&date=${date}`;
});
$('#btnexport_pdf').on('click', function(e){
    var area = $('[name="area_id"]').val() ? $('[name="area_id"]').val() : '';
    var cabang = $('[name="branch_id"]').val() ? $('[name="branch_id"]').val() : '';
    var unit = $('[name="unit_id"]').val() ? $('[name="unit_id"]').val() : '';
    var date = $('[name="date"]').val() ? $('[name="date"]').val() : '';
    window.location.href = `<?php echo base_url('report/yogadai/pdf');?>?area=${area}&cabang=${cabang}&unit=${unit}&date=${date}`;
});



jQuery(document).ready(function() {
    initCariForm();
    initArea();
});
</script>



