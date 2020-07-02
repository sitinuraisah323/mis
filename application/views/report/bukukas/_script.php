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

    $('#area').select2({ placeholder: "Please select a area", width: '100%' });
    $('#unit').select2({ placeholder: "Please select a Unit", width: '100%' });

    //events
    $('#btncari').on('click',function(){ 
        $('.rowappend').remove();
        var area = $('#area').val();
        var unit = $('#unit').val();
        var url_data = $('#url_get').val() + '/' + area +'/'+ unit;        
        var isValid = $("#form_bukukas").valid();
        if(isValid){
        KTApp.block('#form_bukukas .kt-portlet__body', {});
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status = true) {
                var currentSaldo = 0;
                var TotSaldoIn = 0;
                var TotSaldoOut = 0;
                var no = 0;
                for (var i = 0; i < response.data.length; i++) {
                    no++;
                    var date = moment(response.data[i].date).format('DD-MM-YYYY');
                    var month = moment(response.data[i].date).format('MMMM');
                    var year = moment(response.data[i].date).format('YYYY');
                    var cashin=0;
                    var cashout=0;
                    if(response.data[i].type=='CASH_IN'){cashin= response.data[i].amount; currentSaldo +=  parseInt(response.data[i].amount); TotSaldoIn +=  parseInt(response.data[i].amount);}
                    if(response.data[i].type=='CASH_OUT'){cashout= response.data[i].amount; currentSaldo -=  parseInt(response.data[i].amount); TotSaldoOut +=  parseInt(response.data[i].amount);}
                    var newData = '<tr class="rowappend">';
                    newData +='<td class="text-center">'+no+'</td>';
                    newData +='<td>'+date+'</td>';
                    newData +='<td class="text-center">'+month+'</td>';
                    newData +='<td class="text-center">'+year+'</td>';
                    newData +='<td>'+response.data[i].description+'</td>';
                    newData +='<td class="text-right">'+convertToRupiah(cashin)+'</td>';
                    newData +='<td class="text-right">'+convertToRupiah(cashout)+'</td>';
                    newData +='<td class="text-right">'+convertToRupiah(currentSaldo)+'</td>';
                    newData +='</tr>';
                    $('.kt-section__content table').append(newData);
                }

                var newData = '<tr class="rowappend">';
                    newData +='<td colspan="5" class="text-right"><b>Total</b></td>';                    
                    newData +='<td class="text-right"><b>'+convertToRupiah(TotSaldoIn)+'</b></td>';
                    newData +='<td class="text-right"><b>'+convertToRupiah(TotSaldoOut)+'</b></td>';
                    newData +='<td class="text-right"><b>'+convertToRupiah(currentSaldo)+'</b></td>';
                    newData +='</tr>';
                    $('.kt-section__content table').append(newData);
            }
            KTApp.unblock('#form_bukukas .kt-portlet__body');

        });  
        }
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
