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

// document.getElementById("link").setAttribute("href", " ", "style", "color:blue;", "class", "viewcicilan", "title","View Data", "data-toggle",'modal',  "data-target", '#modal_cicilan', "data-month", '1'); 

// var template = " ";
// template += "<tr class='rowappend'>";
// template += "<td class='text-right'><a href='#' class='viewcicilan' data-toggle='modal' data-target='#modal_cicilan' data-nik="+data.nik+" data-cif="+data.nic+" data-unit="+data.id_unit+" data-statusrpt="+statusrpt+" data-nasabah="+data.customer_name+" >"+data.noa+"</a></td>";
// template += "</tr>";

// $('#januari').on('click', function(){
//     $('.rowappend').remove();
//     var month = $('[name="month"]').val();
//     KTApp.block('#form_bukukas .kt-portlet__body', {});
//     KTApp.unblockPage();
//     var template = " ";
//     template += "<input type='hidden' name='month' id='month' >";
//     $('.form-control')
// })

// if($('#btncari1').on('click')){
//     initCariForm();
// }

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
    $('#status').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabah').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_method').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_by').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari').on('click',function(){

        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="area"]').val();
        var unit = $('[name="id_unit"]').val();
        var nasabah = $('#nasabah').val();
        var statusrpt = $('#status').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_by"]').val();
        var sort_method = $('[name="sort_method"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="month"]').val();
        var year = $('[name="year"]').val();
        // console.log(month); exit;
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class = 'text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
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
    })

    return {
        validator:validator
    }
}


function initCariForm1(){
    //validator
    var validator = $("#form_februari").validate({
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


    $('#areaf').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitf').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusf').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahf').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodf').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_byf').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari1').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areaf"]').val();
        var unit = $('[name="id_unitf"]').val();
        var nasabah = $('#nasabahf').val();
        var statusrpt = $('#statusf').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_byf"]').val();
        var sort_method = $('[name="sort_methodf"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthf"]').val();
        var year = $('[name="yearf"]').val();
        // console.log(month); exit;
        KTApp.block('#form_februari .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #februari').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_februari .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm2(){
    //validator
    var validator = $("#form_maret").validate({
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


    $('#aream').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitm').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusm').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahm').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodm').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_bym').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari2').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="aream"]').val();
        var unit = $('[name="id_unitm"]').val();
        var nasabah = $('#nasabahm').val();
        var statusrpt = $('#statusm').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_bym]').val();
        var sort_method = $('[name="sort_methodm"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthm"]').val();
        var year = $('[name="yearm"]').val();
        // console.log(month); exit;
        KTApp.block('#form_maret .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #maret').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_maret .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}
function initCariForm3(){
    //validator
    var validator = $("#form_april").validate({
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


    $('#areaa').select2({ placeholder: "Select Area", width: '100%' });
    $('#unita').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusa').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabaha').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methoda').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_bya').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari3').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areaa"]').val();
        var unit = $('[name="id_unita"]').val();
        var nasabah = $('#nasabaha').val();
        var statusrpt = $('#statusa').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_bya]').val();
        var sort_method = $('[name="sort_methoda"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="montha"]').val();
        var year = $('[name="yeara"]').val();
        // console.log(month); exit;
        KTApp.block('#form_april .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #april').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_april .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm4(){
    //validator
    var validator = $("#form_mei").validate({
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


    $('#areamei').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitmei').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusmei').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahmei').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodmei').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_bymei').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari4').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areamei"]').val();
        var unit = $('[name="id_unitmei"]').val();
        var nasabah = $('#nasabahmei').val();
        var statusrpt = $('#statusmei').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_bymei]').val();
        var sort_method = $('[name="sort_methodmei"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthmei"]').val();
        var year = $('[name="yearmei"]').val();
        // console.log(month); exit;
        KTApp.block('#form_mei .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #mei').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_mei .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm5(){
    //validator
    var validator = $("#form_juni").validate({
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


    $('#areajun').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitjun').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusjun').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahjun').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodjun').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_byjun').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari5').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areajun"]').val();
        var unit = $('[name="id_unitjun"]').val();
        var nasabah = $('#nasabahjun').val();
        var statusrpt = $('#statusjun').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_byjun]').val();
        var sort_method = $('[name="sort_methodjun"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthjun"]').val();
        var year = $('[name="yearjun"]').val();
        // console.log(month); exit;
        KTApp.block('#form_juni .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #juni').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_juni .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm6(){
    //validator
    var validator = $("#form_juli").validate({
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


    $('#areajul').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitjul').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusjul').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahjul').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodjul').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_byjul').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari6').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areajul"]').val();
        var unit = $('[name="id_unitjul"]').val();
        var nasabah = $('#nasabahjul').val();
        var statusrpt = $('#statusjul').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_byjul]').val();
        var sort_method = $('[name="sort_methodjul"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthjul"]').val();
        var year = $('[name="yearjul"]').val();
        // console.log(month); exit;
        KTApp.block('#form_jul .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #juli').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_juli .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm7(){
    //validator
    var validator = $("#form_agustus").validate({
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


    $('#areaagus').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitagus').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusagus').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahagus').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodagus').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_byagus').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari7').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areaagus"]').val();
        var unit = $('[name="id_unitagus"]').val();
        var nasabah = $('#nasabahagus').val();
        var statusrpt = $('#statusagus').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_byagus]').val();
        var sort_method = $('[name="sort_methodagus"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthagus"]').val();
        var year = $('[name="yearagus"]').val();
        // console.log(month); exit;
        KTApp.block('#form_agustus .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #agustus').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_agus .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm8(){
    //validator
    var validator = $("#form_september").validate({
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


    $('#areasep').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitsep').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statussep').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahsep').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodsep').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_bysep').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari8').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areasep"]').val();
        var unit = $('[name="id_unitsep"]').val();
        var nasabah = $('#nasabahsep').val();
        var statusrpt = $('#statussep').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_bysep]').val();
        var sort_method = $('[name="sort_methodsep"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthsep"]').val();
        var year = $('[name="yearsep"]').val();
        // console.log(month); exit;
        KTApp.block('#form_september .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #september').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_september .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm9(){
    //validator
    var validator = $("#form_oktober").validate({
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


    $('#areaok').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitok').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusok').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahok').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodok').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_byok').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari9').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areaok"]').val();
        var unit = $('[name="id_unitok"]').val();
        var nasabah = $('#nasabahsep').val();
        var statusrpt = $('#statusok').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_byok]').val();
        var sort_method = $('[name="sort_methodok"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthok"]').val();
        var year = $('[name="yearok"]').val();
        // console.log(month); exit;
        KTApp.block('#form_oktober .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #oktober').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_oktober .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm10(){
    //validator
    var validator = $("#form_november").validate({
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


    $('#areanov').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitnov').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusnov').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahnov').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methodnov').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_bynov').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari10').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areanov"]').val();
        var unit = $('[name="id_unitnov"]').val();
        var nasabah = $('#nasabahnov').val();
        var statusrpt = $('#statusnov').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_bynov]').val();
        var sort_method = $('[name="sort_methodnov"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthnov"]').val();
        var year = $('[name="yearnov"]').val();
        // console.log(month); exit;
        KTApp.block('#form_november .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #november').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_november .kt-portlet__body', {});
			}
		});
    })

    return {
        validator:validator
    }
}

function initCariForm11(){
    //validator
    var validator = $("#form_desember").validate({
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


    $('#areades').select2({ placeholder: "Select Area", width: '100%' });
    $('#unitdes').select2({ placeholder: "Select Unit", width: '100%' });
    $('#statusdes').select2({ placeholder: "Select a Status", width: '100%' });
    $('#nasabahdes').select2({ placeholder: "Select a Nasabah", width: '100%' });
    $('#sort_methoddes').select2({ placeholder: "Select a Sort", width: '100%' });
    $('#sort_bydes').select2({ placeholder: "Select a Sort", width: '100%' });
    // $('#no_sbk').select2({ placeholder: "Select a No SBK", width: '100%' });
    //events
    $('#btncari11').on('click',function(){
        $('.rowappend').remove();
        // var month = $(el).attr('data-month');
        // console.log(month); exit;
        var area = $('[name="areades"]').val();
        var unit = $('[name="id_unitdes"]').val();
        var nasabah = $('#nasabahdes').val();
        var statusrpt = $('#statusdes').val();
		// var dateStart = $('[name="date-start"]').val();
		// var dateEnd = $('[name="date-end"]').val();
		// var permit = $('[name="permit"]').val();
        var sort_by = $('[name="sort_bydes]').val();
        var sort_method = $('[name="sort_methoddes"]').val();
        // var no_sbk = $('[name="no_sbk"]').val();
        var month = $('[name="monthdes"]').val();
        var year = $('[name="yeardes"]').val();
        // console.log(month); exit;
        KTApp.block('#form_desember .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/transactions/regularpawns/reportMonth"); ?>",
			dataType : "json",
			data:{area:area,id_unit:unit,nasabah:nasabah,sort_by, sort_method, month, year, statusrpt},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
					var template = '';
					var no = 1;
					var amount = 0;
					var admin = 0;
                    var status="";
					$.each(response.data, function (index, data) {
						template += "<tr class='rowappend'>";
                        template += "<td class='text-left'>"+data.unit+"</td>"
						template += "<td class='text-center'>"+data.nic+"</td>";
						template += "<td class='text-center'>"+data.no_sbk+"</td>";
						template += "<td class='text-center'>"+moment(data.date_sbk).format('DD-MM-YYYY')+"</td>";
                        template += "<td class='text-center'>"+moment(data.deadline).format('DD-MM-YYYY')+"</td>";

						template += "<td>"+data.customer_name+"</td>";
						template += "<td class='text-center'>"+data.capital_lease+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.estimation)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.admin)+"</td>";
						template += "<td class='text-right'>"+convertToRupiah(data.amount)+"</td>";
                        if(data.status_transaction=="L"){ status="Lunas";}
                        else if(data.status_transaction=="N"){ status="Aktif";}
                        template += "<td class='text-center'>"+status+"</td>";
                        template += "<td class='text-right'>";
                        if(data.description_1!=null){template += "- " + data.description_1;}
                        if(data.description_2!=null){template += "<br>- " + data.description_2;}
                        if(data.description_3!=null){template += "<br>- " + data.description_3;}
                        if(data.description_4!=null){template += "<br>- " + data.description_4;}
                        template +="</td>";
						template += '</tr>';
						no++;
						amount += parseInt(data.amount);
						admin += parseInt(data.admin);
					});
					template += "<tr class='rowappend'>";
					template += "<td colspan='8' class='text-right'><strong>Total</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(admin)+"</strong></td>";
					template += "<td class='text-right'><strong>"+convertToRupiah(amount)+"</strong></td>";
					template += "<td class='text-right'></td>";
					template += "<td class='text-right'></td>";
					template += '</tr>';
					$('.kt-portlet__body #desember').append(template);
				}
			},
			error: function (jqXHR, textStatus, errorThrown){
				KTApp.unblockPage();
			},
			complete:function () {
				KTApp.unblock('#form_desember .kt-portlet__body', {});
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

$('[name="areaf"]').on('change',function(){
        var area = $('[name="areaf"]').val();
        var units =  $('[name="id_unitf"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitf").empty();
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

$('[name="aream"]').on('change',function(){
        var area = $('[name="aream"]').val();
        var units =  $('[name="id_unitm"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitm").empty();
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

$('[name="areaa"]').on('change',function(){
        var area = $('[name="areaa"]').val();
        var units =  $('[name="id_unita"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unita").empty();
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

$('[name="areamei"]').on('change',function(){
        var area = $('[name="areamei"]').val();
        var units =  $('[name="id_unitmei"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitmei").empty();
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

$('[name="areajun"]').on('change',function(){
        var area = $('[name="areajun"]').val();
        var units =  $('[name="id_unitjun"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitjun").empty();
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

$('[name="areajul"]').on('change',function(){
        var area = $('[name="areajul"]').val();
        var units =  $('[name="id_unitjul"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitjul").empty();
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

$('[name="areaagus"]').on('change',function(){
        var area = $('[name="areaagus"]').val();
        var units =  $('[name="id_unitagus"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitagus").empty();
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

$('[name="areasep"]').on('change',function(){
        var area = $('[name="areasep"]').val();
        var units =  $('[name="id_unitsep"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitsep").empty();
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

$('[name="areaok"]').on('change',function(){
        var area = $('[name="areaok"]').val();
        var units =  $('[name="id_unitok"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitok").empty();
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

$('[name="areanov"]').on('change',function(){
        var area = $('[name="areanov"]').val();
        var units =  $('[name="id_unitnov"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitnov").empty();
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

$('[name="areades"]').on('change',function(){
        var area = $('[name="areades"]').val();
        var units =  $('[name="id_unitdes"]');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unitdes").empty();
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


$('[name="cabangf"]').on('change',function(){
	var cabang = $('[name="cabangf"]').val();
	var units =  $('[name="id_unitf"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitf").empty();
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

$('[name="cabangm"]').on('change',function(){
	var cabang = $('[name="cabangm"]').val();
	var units =  $('[name="id_unitm"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitm").empty();
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

$('[name="cabanga"]').on('change',function(){
	var cabang = $('[name="cabanga"]').val();
	var units =  $('[name="id_unita"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unita").empty();
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

$('[name="cabangmei"]').on('change',function(){
	var cabang = $('[name="cabangmei"]').val();
	var units =  $('[name="id_unitmei"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitmei").empty();
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

$('[name="cabangjun"]').on('change',function(){
	var cabang = $('[name="cabangjun"]').val();
	var units =  $('[name="id_unitjun"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitjun").empty();
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

$('[name="cabangjul"]').on('change',function(){
	var cabang = $('[name="cabangjul"]').val();
	var units =  $('[name="id_unitjul"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitjul").empty();
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

$('[name="cabangagus"]').on('change',function(){
	var cabang = $('[name="cabangagus"]').val();
	var units =  $('[name="id_unitagus"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitagus").empty();
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

$('[name="cabangsep"]').on('change',function(){
	var cabang = $('[name="cabangsep"]').val();
	var units =  $('[name="id_unitsep"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitsep").empty();
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

$('[name="cabangok"]').on('change',function(){
	var cabang = $('[name="cabangok"]').val();
	var units =  $('[name="id_unitok"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitok").empty();
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


$('[name="cabangnov"]').on('change',function(){
	var cabang = $('[name="cabangnov"]').val();
	var units =  $('[name="id_unitnov"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitnov").empty();
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

$('[name="cabangdes"]').on('change',function(){
	var cabang = $('[name="cabangdes"]').val();
	var units =  $('[name="id_unitdes"]');
	var url_data = $('#url_get_units').val() + '/' + cabang;



	$.get(url_data, function (data, status) {
		var response = JSON.parse(data);
		if (status) {
			$("#unitdes").empty();
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
var typecabangf = $('[name="cabangf"]').attr('type');
if(typecabangf == 'hidden'){
	$('[name="cabangf"]').trigger('change');
}

var typecabangm = $('[name="cabangm"]').attr('type');
if(typecabangm == 'hidden'){
	$('[name="cabangm"]').trigger('change');
}
var typecabanga = $('[name="cabanga"]').attr('type');
if(typecabanga == 'hidden'){
	$('[name="cabanga"]').trigger('change');
}
var typecabangmei = $('[name="cabangmei"]').attr('type');
if(typecabangmei == 'hidden'){
	$('[name="cabangmei"]').trigger('change');
}
var typecabangjun = $('[name="cabangjun"]').attr('type');
if(typecabangjun == 'hidden'){
	$('[name="cabangjun"]').trigger('change');
}
var typecabangjul = $('[name="cabangjul"]').attr('type');
if(typecabangjul == 'hidden'){
	$('[name="cabangjul"]').trigger('change');
}
var typecabangagus = $('[name="cabangagus"]').attr('type');
if(typecabangagus == 'hidden'){
	$('[name="cabangagus"]').trigger('change');
}
var typecabangsep = $('[name="cabangsep"]').attr('type');
if(typecabangsep == 'hidden'){
	$('[name="cabangsep"]').trigger('change');
}
var typecabangok = $('[name="cabangok"]').attr('type');
if(typecabangok == 'hidden'){
	$('[name="cabangok"]').trigger('change');
}
var typecabangnov = $('[name="cabangnov"]').attr('type');
if(typecabangnov == 'hidden'){
	$('[name="cabangnov"]').trigger('change');
}
var typecabangdes = $('[name="cabangdes"]').attr('type');
if(typecabangdes == 'hidden'){
	$('[name="cabangdes"]').trigger('change');
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

function initGetNasabahf(){
    $("#unitf").on('change',function(){
        var area = $('#areaf').val();
        var unit = $('#unitf').val(); 
        var customers =  document.getElementById('nasabahf');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahf").empty();
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
				KTApp.unblock('#form_februari .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahm(){
    $("#unitm").on('change',function(){
        var area = $('#aream').val();
        var unit = $('#unitm').val(); 
        var customers =  document.getElementById('nasabahm');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahm").empty();
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
				KTApp.unblock('#form_maret .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabaha(){
    $("#unita").on('change',function(){
        var area = $('#areaa').val();
        var unit = $('#unita').val(); 
        var customers =  document.getElementById('nasabaha');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabaha").empty();
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
				KTApp.unblock('#form_april .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahmei(){
    $("#unitmei").on('change',function(){
        var area = $('#areamei').val();
        var unit = $('#unitmei').val(); 
        var customers =  document.getElementById('nasabahmei');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahmei").empty();
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
				KTApp.unblock('#form_mei .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahjun(){
    $("#unitjun").on('change',function(){
        var area = $('#areajun').val();
        var unit = $('#unitjun').val(); 
        var customers =  document.getElementById('nasabahjun');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahjun").empty();
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
				KTApp.unblock('#form_juni .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahjul(){
    $("#unitjul").on('change',function(){
        var area = $('#areajul').val();
        var unit = $('#unitjul').val(); 
        var customers =  document.getElementById('nasabahjul');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahjul").empty();
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
				KTApp.unblock('#form_juli .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahagus(){
    $("#unitagus").on('change',function(){
        var area = $('#areaagus').val();
        var unit = $('#unitagus').val(); 
        var customers =  document.getElementById('nasabahagus');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahagus").empty();
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
				KTApp.unblock('#form_agustus .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahsep(){
    $("#unitsep").on('change',function(){
        var area = $('#areasep').val();
        var unit = $('#unitsep').val(); 
        var customers =  document.getElementById('nasabahsep');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahsep").empty();
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
				KTApp.unblock('#form_september .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahok(){
    $("#unitok").on('change',function(){
        var area = $('#areaok').val();
        var unit = $('#unitok').val(); 
        var customers =  document.getElementById('nasabahok');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahok").empty();
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
				KTApp.unblock('#form_oktober .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahnov(){
    $("#unitnov").on('change',function(){
        var area = $('#areanov').val();
        var unit = $('#unitnov').val(); 
        var customers =  document.getElementById('nasabahnov');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahnov").empty();
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
				KTApp.unblock('#form_november .kt-portlet__body', {});
			}
		});
       
    });    
}

function initGetNasabahdes(){
    $("#unitdes").on('change',function(){
        var area = $('#areades').val();
        var unit = $('#unitdes').val(); 
        var customers =  document.getElementById('nasabahdes');   

        //alert(unit);
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahdes").empty();
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
				KTApp.unblock('#form_desember .kt-portlet__body', {});
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


function initUnitNasabahf(){
        var unit=$('[name="id_unitf"]').val();
        var customers =  document.getElementById('nasabahf');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahf").empty();
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
				KTApp.unblock('#form_februari .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahm(){
        var unit=$('[name="id_unitm"]').val();
        var customers =  document.getElementById('nasabahm');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahm").empty();
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
				KTApp.unblock('#form_maret .kt-portlet__body', {});
			}
		});
}

function initUnitNasabaha(){
        var unit=$('[name="id_unita"]').val();
        var customers =  document.getElementById('nasabaha');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabaha").empty();
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
				KTApp.unblock('#form_april .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahmei(){
        var unit=$('[name="id_unitmei"]').val();
        var customers =  document.getElementById('nasabahmei');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahmei").empty();
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
				KTApp.unblock('#form_mei .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahjun(){
        var unit=$('[name="id_unitjun"]').val();
        var customers =  document.getElementById('nasabahjun');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahjun").empty();
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
				KTApp.unblock('#form_juni .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahjul(){
        var unit=$('[name="id_unitjul"]').val();
        var customers =  document.getElementById('nasabahjul');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahjul").empty();
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
				KTApp.unblock('#form_juli .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahagus(){
        var unit=$('[name="id_unitagus"]').val();
        var customers =  document.getElementById('nasabahagus');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahagus").empty();
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
				KTApp.unblock('#form_agustus .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahsep(){
        var unit=$('[name="id_unitsep"]').val();
        var customers =  document.getElementById('nasabahsep');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahsep").empty();
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
				KTApp.unblock('#form_september .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahok(){
        var unit=$('[name="id_unitok"]').val();
        var customers =  document.getElementById('nasabahok');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahok").empty();
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
				KTApp.unblock('#form_oktober .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahnov(){
        var unit=$('[name="id_unitnov"]').val();
        var customers =  document.getElementById('nasabahnov');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahnov").empty();
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
				KTApp.unblock('#form_november .kt-portlet__body', {});
			}
		});
}

function initUnitNasabahdes(){
        var unit=$('[name="id_unitdes"]').val();
        var customers =  document.getElementById('nasabahdes');     
        $.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/datamaster/units/get_customers_gr_byunit"); ?>",
			dataType : "json",
			data:{unit:unit},
			success : function(response,status){
				KTApp.unblockPage();
				if(response.status == true){
                    $("#nasabahdes").empty();
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
				KTApp.unblock('#form_desember .kt-portlet__body', {});
			}
		});
}



jQuery(document).ready(function() {
    initCariForm();
    initCariForm1();
    initCariForm2();
    initGetNasabah();
    initGetNasabahf();
    initGetNasabahm();
    initUnitNasabah();
    initUnitNasabahf();
    initUnitNasabahm();

    initCariForm3();
    initGetNasabaha();
    initUnitNasabaha();

    initCariForm4();
    initGetNasabahmei();
    initUnitNasabahmei();

    initCariForm5();
    initGetNasabahjun();
    initUnitNasabahjun();

    initCariForm6();
    initGetNasabahjul();
    initUnitNasabahjul();

    initCariForm7();
    initGetNasabahagus();
    initUnitNasabahagus();

    initCariForm8();
    initGetNasabahsep();
    initUnitNasabahsep();

    initCariForm9();
    initGetNasabahok();
    initUnitNasabahok();

    initCariForm10();
    initGetNasabahnov();
    initUnitNasabahnov();

    initCariForm11();
    initGetNasabahdes();
    initUnitNasabahdes();
});

var type = $('[name="area"]').attr('type');
if(type == 'hidden'){
    $('[name="area"]').trigger('change');
}
var typef = $('[name="areaf"]').attr('type');
if(typef == 'hidden'){
    $('[name="areaf"]').trigger('change');
}
var typem = $('[name="aream"]').attr('type');
if(typem == 'hidden'){
    $('[name="aream"]').trigger('change');
}
var typea = $('[name="areaa"]').attr('type');
if(typea == 'hidden'){
    $('[name="areaa"]').trigger('change');
}
var typemei = $('[name="areamei"]').attr('type');
if(typemei == 'hidden'){
    $('[name="areamei"]').trigger('change');
}
var typejun = $('[name="areajun"]').attr('type');
if(typejun == 'hidden'){
    $('[name="areajun"]').trigger('change');
}
var typejul = $('[name="areajul"]').attr('type');
if(typejul == 'hidden'){
    $('[name="areajul"]').trigger('change');
}
var typeagus = $('[name="areaagus"]').attr('type');
if(typeagus == 'hidden'){
    $('[name="areaagus"]').trigger('change');
}
var typesep = $('[name="areasep"]').attr('type');
if(typesep == 'hidden'){
    $('[name="areasep"]').trigger('change');
}
var typeok = $('[name="areaok"]').attr('type');
if(typeok == 'hidden'){
    $('[name="areaok"]').trigger('change');
}
var typenov = $('[name="areanov"]').attr('type');
if(typenov == 'hidden'){
    $('[name="areanov"]').trigger('change');
}
var typedes = $('[name="areades"]').attr('type');
if(typedes == 'hidden'){
    $('[name="areades"]').trigger('change');
}

</script>
