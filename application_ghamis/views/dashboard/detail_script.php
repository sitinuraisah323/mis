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



$('[name="area"]').on('change',function(){
        var area = $('[name="area"]').val();
        var units =  $('[name="id_unit"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unit").empty();
				var opt = document.createElement("option");
				opt.value = "0";
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

function initGetNasabah(){
    $("#unit").on('change',function(){
        var area = $('#area').val();
        var unit = $('#unit').val(); 
        var customers =  document.getElementById('nasabah');   
        // var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
        // $.ajax({
        //     type:"GET",
        //     url:"<?php echo base_url('api/transactions/regularpawns');?>",
        //     dataType: "JSON",
        //     data:{unit},
        //     success:function(res){
        //         if(res.data.length > 0){
        //             $("#no_sbk").empty();
        //             var option = document.createElement("option");
        //             option.value = "0";
        //             option.text = "All";
        //             $('#no_sbk').append(option);
        //             res.data.forEach(data=>{
        //                 const opt = document.createElement('option');
        //                 opt.value = data.no_sbk;
        //                 opt.textContent = `${data.no_sbk}-${data.customer}`;
        //                 $('#no_sbk').append(opt);
        //             })
        //         }
        //     }
        // })


        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabah").empty();
                    var option = document.createElement("option");
                    option.value = "all";
                    option.text = "All";
                    customers.appendChild(option);
					$.each(response.data, function (index, data) {
                        //console.log(data);
                        var opt = document.createElement("option");
                        opt.value = data.nik;
                        opt.text = data.name;
                        customers.appendChild(opt);
					});
					
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
       
    });    
}

// var input = document.createElement("input");
// input.value =  

function initUnitNasabah(){
        var unit=$('[name="id_unit"]').val();
        var customers =  document.getElementById('nasabah');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabah").empty();
                    var option = document.createElement("option");
                    option.value = "all";
                    option.text = "All";
                    customers.appendChild(option);
					$.each(response.data, function (index, data) {
                        //console.log(data);
                        var opt = document.createElement("option");
                        opt.value = data.name;
                        opt.text = data.name;
                        customers.appendChild(opt);
					});					
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
    // initCariForm();
    initGetNasabah();
    initUnitNasabah();
});

var type = $('[name="area"]').attr('type');
if(type == 'hidden'){
    $('[name="area"]').trigger('change');
}

</script>
