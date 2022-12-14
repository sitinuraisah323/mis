<script>
//globals
var cariForm;
var objAreas = [];
var objUnit = [];
var months = [
    {
        id:1,
        name:"Januari",
    },
    {
        id:2,
        name:"Februari",
    },
    {
        id:3,
        name:"Maret",
    },
    {
        id:4,
        name:"April",
    },
    {
        id:5,
        name:"Mei",
    },
    {
        id:6,
        name:"Juni",
    },
    {
        id:7,
        name:"Juli",
    },
    {
        id:8,
        name:"Agustus",
    },
    {
        id:9,
        name:"September",
    },
    {
        id:10,
        name:"Oktober",
    },
    {
        id:11,
        name:"November",
    },
    {
        id:12,
        name:"Desember",
    },
]


// function formatRupiah(angka){
//     var number_string = angka.replace(/[^,\d]/g, '').toString(),
//     split   		= number_string.split(','),
//     sisa     		= split[0].length % 3,
//     rupiah     		= split[0].substr(0, sisa),
//     ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

//     // tambahkan titik jika yang di input sudah menjadi angka ribuan
//     if(ribuan){
//         separator = sisa ? '.' : '';
//         rupiah += separator + ribuan.join('.');
//     }
//     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
//     return rupiah;
// }

// function formatNumber(angka){
//     var clean = angka.replace(/\D/g, '');
//     return clean;
// }


// function convertToRupiah(angka)
// {
// 	var rupiah = '';		
// 	var angkarev = angka.toString().split('').reverse().join('');
// 	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
// 	return rupiah.split('',rupiah.length-1).reverse().join('');
// }
                       
// var amount_booking = $('[name="amount_booking"]').value ;
// var amount_outstanding = $('[name="amount_outstanding"]').value ;

// amount_booking.addEventListener('keyup', function(e){convertNumber(); hitung(); });
// amount_outstanding.addEventListener('keyup', function(e){convertNumber(); hitung(); });

// function convertNumber(){
//     var amount_booking = $('[name="amount_booking"]').val();
//     var amount_outstanding = $('[name="amount_outstanding"]').val();
    
//     amount_booking.value   = formatRupiah(amount_booking.value);
//     amount_outstanding.value   = formatRupiah(amount_outstanding.value);
    
// }


// function hitung(){
//     var amount_booking   = $('[name="amount_booking"]').val();
//     var amount_outstsanding  = $('[name="amount_outstsanding"]').val();
   
//     if(amount_booking){amount_booking=formatNumber(amount_booking);}else{amount_booking=0;}
//     if(amount_outstsanding){amount_outstsanding=formatNumber(amount_outstsanding);}else{amount_outstsanding=0;}
   
// }

// var amount_booking = $('[name="amount_booking"]').value;
// var amount_outstanding = $('[name="amount_outstanding"]').value;
// 		amount_outstanding.addEventListener('keyup', function(e){
// 			// tambahkan 'Rp.' pada saat form di ketik
// 			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
// 			amount_outstanding.value = formatRupiah(this.value);
// 		});

//         /* Fungsi formatRupiah */
// 		function formatRupiah(angka){
// 			var number_string = angka.replace(/[^,\d]/g, '').toString(),
// 			split   		= number_string.split(','),
// 			sisa     		= split[0].length % 3,
// 			rupiah     		= split[0].substr(0, sisa),
// 			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

// 			// tambahkan titik jika yang di input sudah menjadi angka ribuan
// 			if(ribuan){
// 				separator = sisa ? '.' : '';
// 				rupiah += separator + ribuan.join('.');
// 			}

// 		return	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
//         }
			
// $(document).on('keyup', 'money_format' function(){
//     const number = this.value.replace(/./g,"");
//     this.value = convertToRupiah(number);
// })
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
    $('[name="month"]').select2({ placeholder: "all", width: '100%' });
    $('[name="year"]').select2({ placeholder: "Select a year", width: '100%' });
    //events
    $('#btncari').on('click',function(){
        $('.rowappend').remove();
        var area = $('[name="area"]').val();
        var unit = $('[name="id_unit"]').val();
        var nasabah = $('#nasabah').val();
        var statusrpt = $('#status').val();
		var dateStart = $('[name="date-start"]').val();
		var dateEnd = $('[name="date-end"]').val();
		var permit = $('[name="permit"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/unitstarget"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit},
			success : function(response,status){
                const targetUnits = response.data;
                const trBody = $('.table').find('tbody').find('tr').remove();
                const unit = $('[name="id_unit"]').val();

                let filterUnit = objUnit;

                if(unit > 0){
                    filterUnit = filterUnit.filter(get=>get.id === unit);
                }
            
                filterUnit.forEach((unit, index)=>{
                    const { id, name, area } =unit;
                    const getMonth = $('[name="month"]').val();
                    const getYear = $('[name="year"]').val();
                    let filterMonth = months.filter(data=>{
                        return data.id == getMonth
                    });

                    if(filterMonth.length === 0){
                        filterMonth = months;
                    }

                    filterMonth.forEach(month=>{
                        const getTarget = targetUnits.filter(data=>data.id_unit == id && data.year == getYear && data.month == month.id);
                        let amount_outstanding = 0;
                        let amount_booking = 0;
                        if(getTarget.length > 0){
                            amount_booking = getTarget[0].amount_booking;
                            amount_outstanding = getTarget[0].amount_outstanding;
                        }
                        let html = '';
                        html += `<tr>`;
                        html += `<td>${name}</td>`;
                        html += `<td><input type="hidden" name="id_unit" value="${id}">${area}</td>`;
                        html += `<td><input type="hidden" name="year" value="${getYear}">${getYear}</td>`;
                        html += `<td><input type="hidden" name="month" value="${month.id}">${month.name}</td>`;
                        html += `<td><input value="${amount_booking}"  name="amount_booking" class="form-control money_format" type="text" name="amount_booking"></td>`;
                        html += `<td><input value="${amount_outstanding}" name="amount_outstanding;" class="form-control money_format" type="text" name="amount_outstanding"></td>`;
                        html += `<td><button type="button" class="btn btn-primary btn-save">Save</button></td>`;
                        html += `</tr>`;
                        $('.table').find('tbody').append(html);

                        
                        // $('[name="amount_booking"]').value = convertToRupiah(this.value);
                        // $('[name="amount_outstanding"]').value = convertToRupiah(this.value);
                       
                    })
                 
                });
                KTApp.unblockPage();
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
                $('.money_format').trigger('keyup');
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
            objUnit = response.data;
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

function buildTenor(tenor,method){
	if(method !== 'INSTALLMENT'){
		return method;
	}
	return `installment ${tenor}x`
}

function initGetNasabah(){
    $("#unit").on('change',function(){
        var area = $('#area').val();
        var unit = $('#unit').val();
        var customers =  document.getElementById('nasabah');
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
}


jQuery(document).ready(function() {
    $.ajax({
        type : 'GET',
        url : "<?php echo base_url("api/datamaster/units"); ?>",
        dataType : "json",
        success : function(response,status){
            objUnit = response.data;
        },
    });

    initCariForm();
    initGetNasabah();
    initUnitNasabah();
    initAlert();

	$('#btncari').trigger('click');
});

var type = $('[name="area"]').attr('type');
if(type == 'hidden'){
    $('[name="area"]').trigger('change');
}

function change(element) {
	const data = {
		status:element.value,
		code:element.getAttribute('data-code')
	}
	$.ajax({
		type : 'POST',
		url : "<?php echo base_url("api/lm/transactions/change"); ?>",
		dataType : "json",
		data:data,
		success : function(response,status){
			AlertUtil.showSuccess(response.message,5000);
		},
	});
}
function deleted(id) {
	var targetId = id;
	swal.fire({
		title: 'Anda Yakin?',
		text: "Akan menghapus data ini",
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Ya, Hapus'
	}).then(function(result) {
		if (result.value) {
			KTApp.blockPage();
			$.ajax({
				type : 'GET',
				url : "<?php echo base_url('api/lm/transactions/delete');?>/"+targetId,
				dataType : "json",
				success : function(data,status){
					KTApp.unblockPage();
					if(data.status == true){
						AlertUtil.showSuccess(data.message,5000);
						$('#btncari').trigger('click');
					}else{
						AlertUtil.showFailed(data.message);
					}
				},
				error: function (jqXHR, textStatus, errorThrown){
					KTApp.unblockPage();
					AlertUtil.showFailed("Cannot communicate with server please check your internet connection");
				}
			});
		}
	});
};

$(document).on('click','.btn-save', (element)=>{
    const tr = element.target.closest('td').closest('tr');
    const amount_booking = tr.querySelector('[name="amount_booking"]').value;
    const amount_outstanding = tr.querySelector('[name="amount_outstanding"]').value;
    const month = tr.querySelector('[name="month"]').value;
    const year = tr.querySelector('[name="year"]').value;
    const id_unit = tr.querySelector('[name="id_unit"]').value;
    const data = {
        unit:id_unit,
        year:year,
        month:month,
        booking:amount_booking,
        outstanding:amount_outstanding,
    };
    $.ajax({
        type : 'POST',
        url : "<?php echo base_url('api/datamaster/unitstarget/insert');?>/",
        dataType : "json",
        data:data,
        success : function(response,status){
            KTApp.unblockPage();
            if(response.status == 200){
                AlertUtil.showSuccess(response.message,5000);
                $('#btncari').trigger('click');
            }else{
                AlertUtil.showFailed(response.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            KTApp.unblockPage();
            AlertUtil.showFailed("Check Correct Field");
        }
    });
})

</script>
