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

function formatNumber(angka){
    var clean = angka.replace(/\D/g, '');
    return clean;
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
    var validator = $("#form_pendapatan").validate({
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
    $('#category').select2({ placeholder: "Select a Category", width: '100%' });
    

    //events
    $('#btncari').on('click',function(){
        $('.rowappend').remove();
        var area        = $('[name="area"]').val();
        var unit        = $('[name="id_unit"]').val();
        //var category    = $('#category').val();
		// var dateStart   = $('[name="date-start"]').val();
		// var dateEnd     = $('[name="date-end"]').val();
        KTApp.block('#form_pendapatan .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/typerates"); ?>",
			dataType : "json",
			data:{area:area,unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
                // $('.kt-section__content #tblsm').append(template);
                let html = '';
                let no = 1;
                response.data.forEach(data=>{
                    html += '<tr>';
                    html += `<td>${no}</td>`;
                    html += `<td>${data.area}</td>`;
                    html += `<td>${data.name}</td>`;                    
                    html += `<td class="text-right">${data.total_up}</td>`;
                    html += `<td></td>`;
                    html += `<td></td>`;
                    html += '</tr>';
                    html += '<tr>';
                    html += `<th></th>`;
                    html += `<th>Rate</th>`;
                    html += `<th>Noa</th>`;
                    html += `<th class="text-right">Up</th>`;
                    html += `<th class="text-right">Sewa Model</th>`;
                    html += `<th class="text-right">%</th>`;
                    html += '</tr>';

                    html += '<tr>';
                    html += `<td></td>`;
                    html += `<td>< 15 </td>`;
                    html += `<td>${data.small_then_noa}</td>`;
                    html += `<td  class="text-right">${data.small_then_up ? data.small_then_up : '0'}</td>`;
                    let sewamodelSmall = data.small_then_up * 15/100;
                    html += `<td  class="text-right">${sewamodelSmall.toFixed(2)}</td>`;
                    let percentSmall = (data.small_then_up/data.total_up * 100);
                    html += `<td class="text-right">${percentSmall.toFixed(2)}</td>`;
                    html += '</tr>';

                    html += '<tr>';
                    html += `<td></td>`;
                    html += `<td> > 15 </td>`;
                    html += `<td>${data.bigger_then_noa}</td>`;
                    html += `<td   class="text-right">${data.bigger_then_up ? data.bigger_then_up : '0'}</td>`;
                    let sewamodelBigger = data.bigger_then_up * 15/100;
                    html += `<t  class="text-right"d>${sewamodelBigger.toFixed(2)}</td>`;
                    let percentBigger = (data.bigger_then_up/data.total_up * 100);
                    html += `<td class="text-right">${percentBigger.toFixed(2)}</td>`;
                    html += '</tr>';

                    no++;
                });
                $('#tblsm').find('tbody').append(html);
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_pendapatan .kt-portlet__body', {});
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


jQuery(document).ready(function() {     
    initCariForm(); 
});

var type = $('[name="area"]').attr('type');
if(type == 'hidden'){
    $('[name="area"]').trigger('change');
}
</script>
