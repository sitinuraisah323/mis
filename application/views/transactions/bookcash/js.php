<script>
//globals
var datatable;
var AlertUtil;
var createForm;
var editForm;

function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}

function formatNumber(n) {
    var result = "";

    // format number 1000000 to 1,234,567
    if (n != null) {
        n = n.toString();
    } else {
        n = "0";
    }

    result = + n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return result;
}

function initDTEvents(){
    $(".btn_delete").on("click",function(){
        var targetId = $(this).data("id");
        //alert(targetId);
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
                    url : "<?php echo base_url("api/datamaster/bookcash/delete/"); ?>"+targetId,
                    dataType : "json",
                    success : function(data,status){
                        KTApp.unblockPage();
                        if(data.status == true){
                            datatable.reload();
                            AlertUtil.showSuccess(data.message,5000);
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
    });

    $(".btn_edit").on("click",function(){
        var targetId = $(this).data("id");
        KTApp.blockPage();
        $.ajax({
            type : 'GET',
            url : "<?php echo base_url("api/datamaster/bookcash/show/"); ?>"+targetId,
            dataType : "json",
            success : function(response,status){
              	$('.append').find('.form-group').remove();
              	$('.modal-title').text(response.data.unit_name);
              	var total = 0;
              	$.each(response.data.detail, function (index,data) {
              		total += data.summary * data.amount;
					$('.append').append('<div class="form-group"><label>'+data.read+'</label><span class="form-control">'+data.summary+'</span></div>');
				});
				$('.append').append('<div class="form-group"><label>Total</label><span class="form-control">'+total+'</span></div>');
				KTApp.unblockPage();
			},
            error: function (jqXHR, textStatus, errorThrown){
                KTApp.unblockPage();
                AlertUtil.showFailed("Cannot communicate with server please check your internet connection");
            },
			complete:function () {
				$('#modal_add').modal('show');
			}
        });
    });
}


function initDataTable(){
    var option = {
        data: {
            type: 'remote',
            source: {
              read: {
                url: '<?php echo base_url("api/datamaster/bookcash"); ?>',
                map: function(raw) {
                  // sample data mapping
                  var dataSet = raw;
                  if (typeof raw.data !== 'undefined') {
                    dataSet = raw.data;
                  }
                  return dataSet;
                },
              },
            },
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
            saveState : {cookie: false,webstorage: false},
          },
          sortable: true,
          pagination: true,
          search: {
            input: $('#generalSearch'),
          },
          columns: [
            {
                field: 'id',
                title: 'ID',
                sortable: 'asc',
                width:60,
                textAlign: 'center',
            },
            {
                field: 'unit_name',
                title: 'Nama Unit',
                sortable: 'asc',
                textAlign: 'left',
            },
            {
                field: 'date',
                title: 'Tanggal',
                sortable: 'asc',
                textAlign: 'left',
            },
            {
                field: 'kasir',
                title: 'Kasir',
                sortable: 'asc',
                textAlign: 'left',
            },
            {
                field: 'amount_balance_first',
                title: 'Saldo Awal',
                sortable: 'asc',
                textAlign: 'left',
                template: function (row) {
                    var result = "<div class='date-td'>";
                    result =convertToRupiah(row.amount_balance_first);
                    result = result + "</div>";
                    return result;
                }
            },
            {
                field: 'amount_in',
                title: 'Penerimaan',
                sortable: 'asc',
                textAlign: 'left',
                template: function (row) {
                    var result = "<div class='date-td'>";
                    result =convertToRupiah(row.amount_balance_first);
                    result = result + "</div>";
                    return result;
                }
            },
            {
                field: 'amount_out',
                title: 'Pengeluaran',
                sortable: 'asc',
                textAlign: 'left',
                template: function (row) {
                    var result = "<div class='date-td'>";
                    result =convertToRupiah(row.amount_out);
                    result = result + "</div>";
                    return result;
                }
            },
            {
                field: 'amount_balance_final',
                title: 'Saldo Akhir',
                sortable: 'asc',
                textAlign: 'left',
                template: function (row) {
                    var result = "<div class='date-td'>";
                    result =convertToRupiah(row.amount_balance_final);
                    result = result + "</div>";
                    return result;
                }
            },
            {
                field: 'action',
                title: 'Action',
                sortable: false,
                width: 100,
                overflow: 'visible',
                textAlign: 'center',
                autoHide: false,
                template: function (row) {
                    var result ="";
                        var currdate = moment().format("YYYY-MM-DD");
                        var createdate = moment(row.date_create).format("YYYY-MM-DD");
                        if(createdate >= currdate){
                            result = result + "<span data-id='"+ row.id +"' href='' class='btn btn-sm btn-clean btn-icon btn-icon-md EditBtn' title='Edit Data' data-toggle='modal' data-target='#modal_edit'><i class='flaticon-edit-1' style='cursor:pointer;'></i></span>";
                            result = result + '<span data-id="' + row.id + '" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn_delete" title="Delete" ><i class="flaticon2-trash" style="cursor:pointer;"></i></span>';
                        }
                        result = result + "<span data-id='"+ row.id +"' href='' class='btn btn-sm btn-clean btn-icon btn-icon-md viewBtn' title='View Data' data-toggle='modal' data-target='#modal_view'><i class='flaticon-eye' style='cursor:pointer;'></i></span>";

                    return result;
                }
            }
          ],
          layout:{
            header:true
          }
    }
    datatable = $('#kt_datatable').KTDatatable(option);
    datatable.on("kt-datatable--on-layout-updated",function(){
        initDTEvents();
    })
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

    // var validator = $("#form_add").validate({
    //     ignore:[],
    //     rules: {
    //         kasir: {
    //             kasir: true,
    //         },
    //         date: {
    //             date: true,
    //         },
    //         saldoawal: {
    //             saldoawal: true,
    //         },
    //         penerimaan: {
    //             penerimaan: true,
    //         },
    //         pengeluaran: {
    //             pengeluaran: true,
    //         }, 
    //         saldoakhir: {
    //             saldoakhir: true,
    //         }
    //     },
    //     invalidHandler: function(event, validator) {
    //         KTUtil.scrollTop();
    //     }
    // });

    $('#id_unit').select2({
        placeholder: "Please select a Unit",
        width: '100%'
    }); 

//events
$('#btn_add_submit').on('click',function(){
    var isValid = $( "#form_add" ).valid();
      if(isValid){
        KTApp.block('#modal_add .modal-content', {});
    $.ajax({
        type : 'POST',
        url : "<?php echo base_url("api/datamaster/bookcash/insert"); ?>",
        data : $('#form_add').serialize(),
        dataType : "json",
        success : function(data,status){
            KTApp.unblock('#modal_add .modal-content');
            if(data.status == true){
                datatable.reload();
                $('#modal_add').modal('hide');
                AlertUtil.showSuccess(data.message,5000);
            }else{
                AlertUtil.showFailedDialogAdd(data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            KTApp.unblock('#modal_add .modal-content');
            AlertUtil.showFailedDialogAdd("Cannot communicate with server please check your internet connection");
        }
    });
      }
})

// $('#modal_add').on('hidden.bs.modal', function () {
//        validator.resetForm();
//     })
// return {
//         validator:validator
//     }
}

function initEditForm(){

$('#e_id_unit').select2({
    placeholder: "Please select a Unit",
    width: '100%'
}); 

//events
$('#btn_edit_submit').on('click',function(){
var isValid = $( "#form_edit" ).valid();
  if(isValid){
    KTApp.block('#modal_edit .modal-content', {});
$.ajax({
    type : 'POST',
    url : "<?php echo base_url("api/datamaster/bookcash/update"); ?>",
    data : $('#form_edit').serialize(),
    dataType : "json",
    success : function(data,status){
        KTApp.unblock('#modal_edit .modal-content');
        if(data.status == true){
            datatable.reload();
            $('#modal_edit').modal('hide');
            AlertUtil.showSuccess(data.message,5000);
        }else{
            AlertUtil.showFailedDialogEdit(data.message);
        }
    },
    error: function (jqXHR, textStatus, errorThrown){
        KTApp.unblock('#modal_edit .modal-content');
        AlertUtil.showFailedDialogEdit("Cannot communicate with server please check your internet connection");
    }
});
  }
})

}

function popAdd(el){
    $('.rowappend_kertas').remove();
    $('.rowappend_logam').remove();
    //KTApp.block('#modal_add .kt-portlet__body', {});
    $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/Bookcash/get_type_money_kertas"); ?>",
			dataType : "json",
			//data:{nosbk:nosbk,unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					//var saldo = up;
					//var cicilan = 0;
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend_kertas'>";
						template += "<td><input type='text' class='form-control form-control-sm pecahan' id='k_pecahan_"+no+"' name='k_pecahan[]' value="+data.amount+" readonly><input type='hidden' class='form-control form-control-sm pecahan' id='k_fraction_"+no+"' name='k_fraction[]' value="+data.id+" readonly></td>";
                        template += "<td><input type='text' class='form-control form-control-sm jumlah' id='k_jumlah_"+no+"' name='k_jumlah[]'></td>";
						template += "<td><input type='text' class='form-control form-control-sm total' id='k_total_"+no+"' name='k_total[]' readonly></td>";
						template += '</tr>';
						no++;
					});
					$('#kertas').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#modal_add .kt-portlet__body', {});
			}
		});

        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/Bookcash/get_type_money_logam"); ?>",
			dataType : "json",
			//data:{nosbk:nosbk,unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					//var saldo = up;
					//var cicilan = 0;
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend_logam'>";
						template += "<td><input type='text' class='form-control form-control-sm pecahan' id='l_pecahan_"+no+"' name='l_pecahan[]' value="+data.amount+" readonly><input type='hidden' class='form-control form-control-sm pecahan' id='l_fraction_"+no+"' name='l_fraction[]' value="+data.id+" readonly></td>";
                        template += "<td><input type='text' class='form-control form-control-sm jumlah' id='l_jumlah_"+no+"' name='l_jumlah[]'></td>";
						template += "<td><input type='text' class='form-control form-control-sm total' id='l_total_"+no+"' name='l_total[]' readonly></td>";
						template += '</tr>';
						no++;
					});
					$('#logam').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#modal_add .kt-portlet__body', {});
			}
		});
}

function popEdit(el)
{
    $('.rowappend_kertas').remove();
    $('.rowappend_logam').remove();
    var id = $(el).attr('data-id');

    $('#e_id_unit').select2({
        placeholder: "Please select a Unit",
        width: '100%'
    });

    //console.log(id);  
    $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/getBookCash"); ?>",
			dataType : "json",
			data:{id:id},
			success : function(response,status){
				if(response.status == true){
                    console.log(response.data.name);
                    $('#id_edit').val(response.data.id);
                    $('#e_id_unit').val(response.data.id_unit).trigger("change");
                    $('#e_units').val(response.data.name);                    
                    $('#e_kasir').val(response.data.kasir);
                    $('#e_date').val(response.data.date);
                    $('#e_saldoawal').val(response.data.amount_balance_final);
                    $('#e_penerimaan').val(response.data.amount_in);
                    $('#e_pengeluaran').val(response.data.amount_out);
                    $('#e_totmutasi').val(response.data.amount_mutation);
                    $('#e_saldoakhir').val(response.data.amount_balance_first);
                    //$('#e_total').val(response.data.total);                    
                    $('#e_selisih').val(response.data.amount_gap);                   
                    
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				//KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});

        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/getDetailBookCash"); ?>",
			dataType : "json",
			data:{id:id},
			success : function(response,status){
				if(response.status == true){
                    var templateKertas = '';
                    var templateLogam = '';
					var no = 1;
					var k_totpecahan = 0;
					var l_totpecahan = 0;
                    var totalkertas = 0;
                    var totallogam  = 0;
                    var total  = 0;
                    $.each(response.data, function (index, data) {
                        if(data.type=="KERTAS"){
                            templateKertas += "<tr class='rowappend_kertas'>";
                            templateKertas += "<td><input type='text' class='form-control form-control-sm e_pecahan' name='e_k_pecahan[]' value="+data.amount+" readonly><input type='hidden' class='form-control form-control-sm e_pecahan' name='e_k_money[]' value="+data.id+" readonly></td>";
                            templateKertas += "<td><input type='text' class='form-control form-control-sm e_jumlah' name='e_k_jumlah[]' value="+data.summary+"></td>";
                            k_totpecahan = parseInt(data.amount) * parseInt(data.summary);
                            templateKertas += "<td class='text-right'><input type='text' class='form-control form-control-sm e_total' name='e_k_total[]' value="+k_totpecahan+" readonly></td>";
                            templateKertas += '</tr>';
                            totalkertas +=k_totpecahan;
                            no++;
                        }
                        if(data.type=="LOGAM"){
                            templateLogam += "<tr class='rowappend_logam'>";
                            templateLogam += "<td><input type='text' class='form-control form-control-sm e_pecahan' name='e_l_pecahan[]' value="+data.amount+" readonly><input type='hidden' class='form-control form-control-sm e_pecahan' name='e_l_money[]' value="+data.id+" readonly></td>";
                            templateLogam += "<td><input type='text' class='form-control form-control-sm e_jumlah' name='e_l_jumlah[]' value='"+data.summary+"'></td>";
                            l_totpecahan = parseInt(data.amount) * parseInt(data.summary);
                            templateLogam += "<td class='text-right'><input type='text' class='form-control form-control-sm e_total' name='e_l_total[]' value='"+l_totpecahan+"' readonly></td>";
                            templateLogam += '</tr>';
                            totallogam +=l_totpecahan;
                            no++;
                        }						
					});
                    // templateKertas += '<tr class="rowappend_kertas">';
                    // templateKertas +='<td colspan="2" class="text-right"></td>';                    
                    // templateKertas +='<td class="text-right"><b>'+convertToRupiah(totalkertas)+'</b></td>';                    
                    // templateKertas +='</tr>';

                    // templateLogam += '<tr class="rowappend_logam">';
                    // templateLogam +='<td colspan="2" class="text-right"></td>';                    
                    // templateLogam +='<td class="text-right"><b>'+convertToRupiah(totallogam)+'</b></td>';                    
                    // templateLogam +='</tr>';
                    total = parseInt(totalkertas) + parseInt(totallogam);
					$('#e_kertas').append(templateKertas);
					$('#e_logam').append(templateLogam);
                    $('#e_total').val(total);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				//KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
    
}

function popView(el)
{
    $('.rowappend_kertas').remove();
    $('.rowappend_logam').remove();
    var id = $(el).attr('data-id');
    //console.log(id);  
    $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/getBookCash"); ?>",
			dataType : "json",
			data:{id:id},
			success : function(response,status){
				if(response.status == true){
                    console.log(response.data.name);
                    $('#v_units').val(response.data.name);
                    $('#v_kasir').val(response.data.kasir);
                    $('#v_date').val(response.data.date);
                    $('#v_saldoawal').val(response.data.amount_balance_final);
                    $('#v_penerimaan').val(response.data.amount_in);
                    $('#v_pengeluaran').val(response.data.amount_out);
                    $('#v_mutasi').val(response.data.amount_mutation);
                    $('#v_saldoakhir').val(response.data.amount_balance_first);
                    $('#v_selisih').val(response.data.amount_gap);                   
                    
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				//KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});

        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/bookcash/getDetailBookCash"); ?>",
			dataType : "json",
			data:{id:id},
			success : function(response,status){
				if(response.status == true){
                    var templateKertas = '';
                    var templateLogam = '';
					var no = 1;
					var k_totpecahan = 0;
					var l_totpecahan = 0;
                    var totalkertas = 0;
                    var totallogam  = 0;
                    var total  = 0;
                    $.each(response.data, function (index, data) {
                        if(data.type=="KERTAS"){
                            templateKertas += "<tr class='rowappend_kertas'>";
                            templateKertas += "<td>"+convertToRupiah(data.amount)+"</td>";
                            templateKertas += "<td>"+data.summary+"</td>";
                            k_totpecahan = parseInt(data.amount) * parseInt(data.summary);
                            templateKertas += "<td class='text-right'>"+convertToRupiah(k_totpecahan)+"</td>";
                            templateKertas += '</tr>';
                            totalkertas +=k_totpecahan;
                            no++;
                        }
                        if(data.type=="LOGAM"){
                            templateLogam += "<tr class='rowappend_logam'>";
                            templateLogam += "<td>"+convertToRupiah(data.amount)+"</td>";
                            templateLogam += "<td>"+data.summary+"</td>";
                            l_totpecahan = parseInt(data.amount) * parseInt(data.summary);
                            templateLogam += "<td class='text-right'>"+convertToRupiah(l_totpecahan)+"</td>";
                            templateLogam += '</tr>';
                            totallogam +=l_totpecahan;
                            no++;
                        }						
					});
                    templateKertas += '<tr class="rowappend_kertas">';
                    templateKertas +='<td colspan="2" class="text-right"></td>';                    
                    templateKertas +='<td class="text-right"><b>'+convertToRupiah(totalkertas)+'</b></td>';                    
                    templateKertas +='</tr>';

                    templateLogam += '<tr class="rowappend_logam">';
                    templateLogam +='<td colspan="2" class="text-right"></td>';                    
                    templateLogam +='<td class="text-right"><b>'+convertToRupiah(totallogam)+'</b></td>';                    
                    templateLogam +='</tr>';
                    total = parseInt(totalkertas) + parseInt(totallogam);
					$('#v_kertas').append(templateKertas);
					$('#v_logam').append(templateLogam);
                    $('#v_total').val(total);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				//KTApp.unblockPage();
			},
			complete:function () {
				//KTApp.unblock('#form_bukukas .kt-portlet__body', {});
			}
		});
    
}

function hitung(){
    var saldoawal   = $("#saldoawal").val();
    var penerimaan  = $("#penerimaan").val();
    var pengeluaran = $("#pengeluaran").val();
    var mutasi      = (parseInt(saldoawal) + parseInt(penerimaan)) - parseInt(pengeluaran);
    var saldoakhir  = mutasi;
    if(!isNaN(mutasi)){
        $('[name="totmutasi"]').val(mutasi);
    }
    if(!isNaN(saldoakhir)){
        $('[name="saldoakhir"]').val(saldoakhir);
    }
}

function e_hitung(){
    var saldoawal   = $("#e_saldoawal").val();
    var penerimaan  = $("#e_penerimaan").val();
    var pengeluaran = $("#e_pengeluaran").val();
    var mutasi      = (parseInt(saldoawal) + parseInt(penerimaan)) - parseInt(pengeluaran);
    var saldoakhir  = mutasi;
    if(!isNaN(mutasi)){
        $('[name="e_totmutasi"]').val(mutasi);
    }
    if(!isNaN(saldoakhir)){
        $('[name="e_saldoakhir"]').val(saldoakhir);
    }
}

jQuery(document).ready(function() {
    initDataTable();
    initAlert();
    initCariForm();
    initEditForm();

    $(document).on("click", ".add", function () {
        var el = $(this);
        popAdd(el);
    });

    $(document).on("click", ".EditBtn", function () {
        var el = $(this);
        popEdit(el);
    });

    $(document).on("click", ".viewBtn", function () {
                var el = $(this);
                popView(el);
    });

});

$(document).on('change', '.jumlah', function(){
    var thisElement = $(this);
    var pecahan = thisElement.parents('tr').find('.pecahan').val();
    var jumlah = thisElement.parents('tr').find('.jumlah').val();
    thisElement.parents('tr').find('.total').val(parseInt(pecahan) * parseInt(jumlah));
    calculateSum();
});

$(document).on('change', '.e_jumlah', function(){
    var thisElement = $(this);
    var pecahan = thisElement.parents('tr').find('.e_pecahan').val();
    var jumlah = thisElement.parents('tr').find('.e_jumlah').val();
    thisElement.parents('tr').find('.e_total').val(parseInt(pecahan) * parseInt(jumlah));
    e_calculateSum();
});

function calculateSum(){
    var total = 0;
    var selisih = 0;
    var saldoakhir = $('[name="saldoakhir"]').val();
    $('.total').each(function(index, value){
        if($(this).val() > 0){
            total += parseInt($(this).val());
        }
    });
    selisih = parseInt(saldoakhir) - parseInt(total);
    $('[name="total"]').val(total);
    $('[name="selisih"]').val(selisih);
}

function e_calculateSum(){
    var total = 0;
    var selisih = 0;
    var saldoakhir = $('[name="e_saldoakhir"]').val();
    $('.e_total').each(function(index, value){
        if($(this).val() > 0){
            total += parseInt($(this).val());
        }
    });
    selisih = parseInt(saldoakhir) - parseInt(total);
    $('[name="e_total"]').val(total);
    $('[name="e_selisih"]').val(selisih);
}
</script>
