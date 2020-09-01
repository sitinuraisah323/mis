<script>
//globals
var cariForm;
var pencairan;
var pelunasan;
var cariForm;
var maxDis;
<?php 
if(date('H:i') > '20:00'){
	$date =  date('Y-m-d');
	$_1lastdate = date('Y-m-d', strtotime($date));
	$_2lastdate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
	$month = date('n', strtotime(date('Y-m-d')));;
	
}else{
	$date =  date('Y-m-d');
	$_1lastdate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
	$_2lastdate = date('Y-m-d', strtotime('-2 days', strtotime($date)));
	$month = date('n', strtotime('-1 month', strtotime($date)));
}

?>
var datenow = "<?php echo $date;?>";
var currdate = "<?php echo $_1lastdate;?>";
var lastdate = "<?php echo $_2lastdate;?>";

var currday = "<?php echo date('d', strtotime($_1lastdate)); ?>";
var lastday = "<?php echo date('d', strtotime($_2lastdate)); ?>";
var currmonth =  "<?php echo $month; ?>";
var curryears =  "<?php echo date('Y', strtotime(date('Y-m-d'))); ?>";

//alert(currdate);
//alert(lastdate);

function timer(){
	
}

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
    $('#transaksi').select2({ placeholder: "Select a transaksi", width: '100%' });
    
    //events
    $('#btncari').on('click',function(){
        $('svg').remove();
        var area = $('#area').val();
        var transaksi = $('#transaksi').val();
		var dateStart = $('[name="date-start"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
        //alert(transaksi);
        if(transaksi=="OUTSTANDING"){
            outstanding();
        }else if(transaksi=="PENCAIRAN"){
            pencairan();
        }else if(transaksi=="PELUNASAN"){
            pelunasan();
        }else if(transaksi == 'SALDOKAS'){
        	saldo()
		}else if(transaksi == 'PENGELUARAN'){
			pengeluaran()
		}else if(transaksi == 'PENDAPATAN'){
			pendapatan()
		}
		else{
            notfound();
        }        
    })
    return {
        validator:validator
    }
}

function totoutstanding() {
	var today = 0;
	var yesterday = 0;
	var max = 0;
	$.ajax({
		url:"<?php echo base_url('api/dashboards/totoutstanding');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:currdate,
		},
		success:function (response) {
			$.each(response.data, function (index,unit) {
				today += unit.ost_today;
				yesterday += unit.ost_yesterday;
				if(max > unit.ost_yesterday){ max=max;}else{ max=unit.ost_yesterday;}
			});
			console.log(max);
			//$('#valmax').val(max);
		},
		complete:function () {
			
			//$('#form_outstanding').find('.total-today').text('Rp. '+convertToRupiah(today));
			//$('#form_outstanding').find('.date-today').text(currdate);
			//$('#form_outstanding').find('.total-yesterday').text('Rp. '+convertToRupiah(yesterday));
			//$('#form_outstanding').find('.date-yesterday').text(lastdate);
		},
	});
}

function disburse() {
	$('svg').remove();
	$('#graphDisburse').empty();
	var transaction = [];
	var totalYesterday = 0;
	var totalToday = 0;
	var maxDisburse = 0;
	KTApp.block('#form_disburse .kt-widget14', {});
	$.ajax({
		url: "<?php echo base_url('api/dashboards/disburse');?>",
		type: "GET",
		dataType: "JSON",
		data: {
			area: '',
			date: currday,currmonth,curryears,
		},
		success: function (response) {
			$.each(response.data, function (index, unit) {
				totalToday += unit.amount;
				transaction.push({
					y: unit.name,
					a: unit.amount,
					area:unit.id_area
				})
				if(maxDisburse > unit.amount){maxDisburse=maxDisburse;}else{maxDisburse=unit.amount;}
			});
			maxDisburse = maxDisburse;
		},
		complete: function () {
			$('#form_disburse').find('.total-today').text(convertToRupiah(totalToday));
			$('#disbursmax').val(maxDisburse);
			$('#form_disburse').find('.date-today').text(currdate);
			var data = transaction,
					//config manager
					config = {
						type: 'horizontalBar',
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC', '#FF0000', '#FFD500'],
						// barColors: function (row, series, type) {
						//     if (data[no].area == 1) return "#e2f53b";
						//     else if (data[no].area == 2) return "#FFD500";
						//     else if (data[no].area == 3) return "#FF0000";
						//     else if (data[no].area == 4) return "#000000";
						// 	else  return '#2370b8';
						// }
					};
			config.element = 'graphDisburse';
			new Morris.Bar(config);
			KTApp.unblock('#form_disburse .kt-widget14', {});
		}
	});

	$.ajax({
		url: "<?php echo base_url('api/dashboards/disburse');?>",
		type: "GET",
		dataType: "JSON",
		data: {
			area: '',
			date: lastday,currmonth,curryears,
		},
		success: function (response) {
			$.each(response.data, function (index, unit) {
				totalYesterday += unit.amount;				
			});
			//console.log(" total kemarin : "+totalYesterday);
		},
		complete: function () {
			$('#form_disburse').find('.total-yesterday').text(convertToRupiah(totalYesterday));
			$('#form_disburse').find('.date-yesterday').text(lastdate);
		}
	});
	
	setTimeout(function(){ 
		var templateJBR="";
		var templateJTM="";
		var templateNTT="";
		var templateNTB="";
		var tempall="";
		var percentage=0;
		var totjabar 	= 0;
		var totjatim 	= 0;
		var totntb 		= 0;
		var totntt 		= 0;
		var totall 		= 0;
		var max = $('#disbursmax').val();
		console.log(max);
		//console.log('test');

		$.ajax({
			url: "<?php echo base_url('api/dashboards/disburse');?>",
			type: "GET",
			dataType: "JSON",
			data: {
				area: '',
				date: currday,currmonth,curryears,
			},
			success: function (response) {
				$.each(response.data, function (index, unit) {

					if(unit.area=='Jawa Barat')
					{
						percentage = (parseInt(unit.amount)/parseInt(max))*100;
						templateJBR += "<tr class='rowappendjabar'>";
						templateJBR += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
						templateJBR += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.amount+"' aria-valuemin='"+max+"' aria-valuemax=''></div></div></td>";
						templateJBR += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.amount)+"</b></td>";
						templateJBR += '</tr>';
						totjabar +=unit.amount;
					}

					if(unit.area=='Jawa Timur')
					{
						percentage = (parseInt(unit.amount)/parseInt(max))*100;
						templateJTM += "<tr class='rowappendjabar'>";
						templateJTM += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
						templateJTM += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.amount+"' aria-valuemin='"+max+"' aria-valuemax=''></div></div></td>";
						templateJTM += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.amount)+"</b></td>";
						templateJTM += '</tr>';
						totjatim +=unit.amount;
					}

					if(unit.area=='NTB')
					{
						percentage = (parseInt(unit.amount)/parseInt(max))*100;
						templateNTB += "<tr class='rowappendjabar'>";
						templateNTB += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
						templateNTB += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.amount+"' aria-valuemin='"+max+"' aria-valuemax=''></div></div></td>";
						templateNTB += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.amount)+"</b></td>";
						templateNTB += '</tr>';
						totntb +=unit.amount;
					}

					if(unit.area=='NTT')
					{
						percentage = (parseInt(unit.amount)/parseInt(max))*100;
						templateNTT+= "<tr class='rowappendjabar'>";
						templateNTT += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
						templateNTT += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.amount+"' aria-valuemin='"+max+"' aria-valuemax=''></div></div></td>";
						templateNTT += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.amount)+"</b></td>";
						templateNTT += '</tr>';
						totntt +=unit.amount;
					}
				});	

				if(templateJBR){
					templateJBR += "<tr class='rowappendjabar'>";
					templateJBR += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
					templateJBR += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
					templateJBR += '</tr>';
				}

				if(templateJTM){
					templateJTM += "<tr class='rowappendjabar'>";
					templateJTM += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
					templateJTM += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
					templateJTM += '</tr>';
				}

				if(templateNTB){
					templateNTB += "<tr class='rowappendjabar'>";
					templateNTB += "<td class='text-right' colspan='2'> Total NTB </td>";
					templateNTB += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
					templateNTB += '</tr>';
				}

				if(templateNTT){
					templateNTT += "<tr class='rowappendjabar'>";
					templateNTT += "<td class='text-right' colspan='2'> Total NTT </td>";
					templateNTT += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
					templateNTT += '</tr>';
				}

				totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
				if(totall){
					tempall += "<tr class='rowappendjabar'>";
					tempall += "<td class='text-right' colspan='2'> Total </td>";
					tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
					tempall += '</tr>';
				}

				$('#tblDisburse').append(templateJBR);			
				$('#tblDisburse').append(templateJTM);			
				$('#tblDisburse').append(templateNTB);			
				$('#tblDisburse').append(templateNTT);			
				$('#tblDisburse').append(tempall);			
			},
			complete: function () {
			}
		});

	}, 8000);
	
}

function outstanding() {
	$('svg').remove();
    $('#graphOutstanding').empty();
	$('#tblOut').empty();
	var pencentage =0;
    var transaction = [];
    var total = 0;
	KTApp.block('#form_outstanding .kt-widget14', {});
	 var today = 0;
	 var yesterday = 0;

    $.ajax({
		url:"<?php echo base_url('api/dashboards/outstanding');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:$('[name="area"]').val(),
			date:datenow,
		},
		success:function (response) {
			var templateJBR="";
			var templateJTM="";
			var templateNTT="";
			var templateNTB="";
			var tempall="";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.total_outstanding.up,
					b:unit.ost_yesterday.up
				});
				today += parseInt(unit.total_outstanding.up);
				yesterday += parseInt(unit.ost_yesterday.up);

				if(unit.area=='Jawa Barat')
				{
					percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					templateJBR += "<tr class='rowappendjabar'>";
					templateJBR += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
					templateJBR += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.total_outstanding.up+"' aria-valuemin='"+unit.max+"' aria-valuemax=''></div></div></td>";
					templateJBR += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.total_outstanding.up)+"</b></td>";
					templateJBR += '</tr>';
					totjabar +=unit.total_outstanding.up;
				}

				if(unit.area=='Jawa Timur')
				{
					percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					templateJTM += "<tr class='rowappendjatim'>";
					templateJTM += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
					templateJTM += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.total_outstanding.up+"' aria-valuemin='"+unit.max+"' aria-valuemax=''></div></div></td>";
					templateJTM += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.total_outstanding.up)+"</b></td>";
					templateJTM += '</tr>';
					totjatim +=unit.total_outstanding.up;
				}

				if(unit.area=='NTB')
				{
					percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					templateNTB += "<tr class='rowappendntb'>";
					templateNTB += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
					templateNTB += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.total_outstanding.up+"' aria-valuemin='"+unit.max+"' aria-valuemax=''></div></div></td>";
					templateNTB += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.total_outstanding.up)+"</b></td>";
					templateNTB += '</tr>';
					totntb +=unit.total_outstanding.up;
				}

				if(unit.area=='NTT')
				{
					percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					templateNTT += "<tr class='rowappendntt'>";
					templateNTT += "<td class='text-right' width='30%'><b>"+unit.name+"</b></td>";
					templateNTT += "<td class='text-left'  width='60%'><div class='progress progress-sm'><div class='progress-bar kt-bg-primary' role='progressbar' style='width: "+percentage+"%;' aria-valuenow='"+unit.total_outstanding.up+"' aria-valuemin='"+unit.max+"' aria-valuemax=''></div></div></td>";
					templateNTT += "<td class='text-right' width='10%'><b>"+convertToRupiah(unit.total_outstanding.up)+"</b></td>";
					templateNTT += '</tr>';
					totntt +=unit.total_outstanding.up;
				}
			});

			if(templateJBR){
					templateJBR += "<tr class='rowappendjabar'>";
					templateJBR += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
					templateJBR += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
					templateJBR += '</tr>';
				}

				if(templateJTM){
					templateJTM += "<tr class='rowappendjabar'>";
					templateJTM += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
					templateJTM += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
					templateJTM += '</tr>';
				}

				if(templateNTB){
					templateNTB += "<tr class='rowappendjabar'>";
					templateNTB += "<td class='text-right' colspan='2'> Total NTB </td>";
					templateNTB += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
					templateNTB += '</tr>';
				}

				if(templateNTT){
					templateNTT += "<tr class='rowappendjabar'>";
					templateNTT += "<td class='text-right' colspan='2'> Total NTT </td>";
					templateNTT += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
					templateNTT += '</tr>';
				}

				totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
				if(totall){
					tempall += "<tr class='rowappendjabar'>";
					tempall += "<td class='text-right' colspan='2'> Total </td>";
					tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
					tempall += '</tr>';
				}

				$('#tblOut').append(templateJBR);
				$('#tblOut').append(templateJTM);
				$('#tblOut').append(templateNTB);
				$('#tblOut').append(templateNTT);
				$('#tblOut').append(tempall);
		},
		complete:function () {
			$('#form_outstanding').find('.total-today').text('Rp. '+convertToRupiah(today));
			$('#form_outstanding').find('.date-today').text(currdate);
			$('#form_outstanding').find('.total-yesterday').text('Rp. '+convertToRupiah(yesterday));
			$('#form_outstanding').find('.date-yesterday').text(lastdate);
			var data = transaction,
					//config manager
					config = {
						//type: 'horizontalBar',
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
					};
			//config element name
			config.element = 'graphOutstanding';
			new Morris.Bar(config);
			KTApp.unblock('#form_outstanding .kt-widget14', {});
		},
	});
}

function dpd() {
	$('svg').remove();
	$('#graphDPD').empty();
	var transaction = [];
	var total = 0;
	KTApp.block('#form_dpd .kt-widget14', {});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/dpd');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:currdate,
		},
		success:function (response) {
			var Tempjabar 	= "";
			var Tempjatim	= "";
			var Tempntt		= "";
			var Tempntb		= "";
			var Tempall		= "";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.up
				});
				total += parseInt(unit.up);

				if(unit.area=='Jawa Barat')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempjabar += "<tr class='rowappendjabar'>";
					Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
					Tempjabar += '</tr>';
					totjabar += parseInt(unit.up);
				}

				if(unit.area=='Jawa Timur')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempjatim += "<tr class='rowappendjabar'>";
					Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
					Tempjatim += '</tr>';
					totjatim += parseInt(unit.up);
				}

				if(unit.area=='NTB')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempntb += "<tr class='rowappendjabar'>";
					Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
					Tempntb += '</tr>';
					totntb += parseInt(unit.up);
				}

				if(unit.area=='NTT')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempntt += "<tr class='rowappendjabar'>";
					Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
					Tempntt += '</tr>';
					totntt += parseInt(unit.up);
				}

			});
			if(Tempjabar){
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
				Tempjabar += '</tr>';
			}

			if(Tempjatim){
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
				Tempjatim += '</tr>';
			}

			if(Tempntt){
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-right' colspan='2'> Total NTT </td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
				Tempntt += '</tr>';
			}

			if(Tempntb){
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-right' colspan='2'> Total NTB </td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
				Tempntb += '</tr>';
			}

			totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
			if(totall){
				Tempall += "<tr class='rowappendjabar'>";
				Tempall += "<td class='text-right' colspan='2'> Total </td>";
				Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
				Tempall += '</tr>';
			}

			$('#tblDPD').append(Tempjabar);
			$('#tblDPD').append(Tempjatim);
			$('#tblDPD').append(Tempntt);
			$('#tblDPD').append(Tempntb);
			$('#tblDPD').append(Tempall);
		},
		complete:function () {
			$('#form_dpd').find('.date-today').text(currdate);
			$('#form_dpd').find('.total-today').text(convertToRupiah(total));
			var data = transaction,
					//config manager
					config = {
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
						// barColors: function (row, series, type) {
						//     if (row.label == "Low") return "#3578FC";
						//     else if (row.label == "Medium") return "#FFD500";
						//     else if (row.label == "High") return "#FF0000";
						//     else if (row.label == "Fatal") return "#000000";
						// }
					};
			//config element name
			config.element = 'graphDPD';
			new Morris.Bar(config);
			KTApp.unblock('#form_dpd .kt-widget14', {});
		},
	});

}

function pencairan() {
	$('svg').remove();
    $('#graphPencairan').empty();
	var totpencairan = 0;
	var totalCurr = 0;
	var totalLastPencairan = 0;

	$.ajax({
		url:"<?php echo base_url('api/dashboards/pencairandashboard');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:lastdate,
		},
		success:function (response) {
			$.each(response.data, function (index,unit) {
				totalLastPencairan += unit.amount;
				//totalLast = 0;
			});
		},
		complete:function () {
			$('#form_pencairan').find('.date-yesterday').text(lastdate);
			$('#form_pencairan').find('.total-yesterday').text(convertToRupiah(totalLastPencairan));
			totpencairan = totalLastPencairan;
		},
	});
	 pencairan = totpencairan;
	//var currdate = '2020-07-20';
	var transaction = [];
	KTApp.block('#form_pencairan .kt-widget14', {});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/pencairandashboard');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:currdate,
		},
		success:function (response) {

			var Tempjabar 	= "";
			var Tempjatim	= "";
			var Tempntt		= "";
			var Tempntb		= "";
			var Tempall		= "";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;

			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount					
				});				
				totalCurr += unit.amount;

				if(unit.area=='Jawa Barat')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempjabar += "<tr class='rowappendjabar'>";
					Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjabar += '</tr>';
					totjabar += parseInt(unit.amount);
				}

				if(unit.area=='Jawa Timur')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempjatim += "<tr class='rowappendjabar'>";
					Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjatim += '</tr>';
					totjatim += parseInt(unit.amount);
				}

				if(unit.area=='NTB')
				{
					//percentage = (parseInt(unit.total_outstanding.up)/parseInt(unit.max))*100;
					Tempntb += "<tr class='rowappendjabar'>";
					Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntb += '</tr>';
					totntb += parseInt(unit.amount);
				}

				if(unit.area=='NTT')
				{
					Tempntt += "<tr class='rowappendjabar'>";
					Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntt += '</tr>';
					totntt += parseInt(unit.amount);
				}

			});		

			if(Tempjabar){
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
				Tempjabar += '</tr>';
			}

			if(Tempjatim){
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
				Tempjatim += '</tr>';
			}

			if(Tempntt){
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-right' colspan='2'> Total NTT </td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
				Tempntt += '</tr>';
			}

			if(Tempntb){
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-right' colspan='2'> Total NTB </td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
				Tempntb += '</tr>';
			}

			totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
			if(totall){
				Tempall += "<tr class='rowappendjabar'>";
				Tempall += "<td class='text-right' colspan='2'> Total </td>";
				Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
				Tempall += '</tr>';
			}				

			$('#tblPencairan').append(Tempjabar);
			$('#tblPencairan').append(Tempjatim);
			$('#tblPencairan').append(Tempntt);
			$('#tblPencairan').append(Tempntb);
			$('#tblPencairan').append(Tempall);

		},
		complete:function () {
			$('#form_pencairan').find('.date-today').text(currdate);
			$('#form_pencairan').find('.total-today').text(convertToRupiah(totalCurr));
			var data = transaction,
					//config manager
					config = {
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
						// barColors: function (row, series, type) {
						//     if (row.label == "Low") return "#3578FC";
						//     else if (row.label == "Medium") return "#FFD500";
						//     else if (row.label == "High") return "#FF0000";
						//     else if (row.label == "Fatal") return "#000000";
						// }
					};
			//config element name
			config.element = 'graphPencairan';
			new Morris.Bar(config);
			KTApp.unblock('#form_pencairan .kt-widget14', {});
		},
	});

}

function pelunasan() {
	$('svg').remove();
	$('#graphPelunasan').empty();
	//var currdate = '2020-07-20';
	var totalCurr = 0;
	var totalLast = 0;
	var transaction = [];
	$.ajax({
		url:"<?php echo base_url('api/dashboards/pelunasandashboard');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:lastdate,
		},
		success:function (response) {
			
			$.each(response.data, function (index,unit) {				
				totalLast += parseInt(unit.amount);
			});			
		},
		complete:function () {
			$('#form_pelunasan').find('.total-yesterday').text(convertToRupiah(totalLast));
			$('#form_pelunasan').find('.date-yesterday').text(lastdate);
		},
	});



	KTApp.block('#form_pelunasan .kt-widget14', {});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/pelunasandashboard');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:currdate,
		},
		success:function (response) {
			var Tempjabar 	= "";
			var Tempjatim	= "";
			var Tempntt		= "";
			var Tempntb		= "";
			var Tempall		= "";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;

			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalCurr += parseInt(unit.amount);

				if(unit.area=='Jawa Barat')
				{
					Tempjabar += "<tr class='rowappendjabar'>";
					Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjabar += '</tr>';
					totjabar += parseInt(unit.amount);
				}

				if(unit.area=='Jawa Timur')
				{
					Tempjatim += "<tr class='rowappendjabar'>";
					Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjatim += '</tr>';
					totjatim += parseInt(unit.amount);
				}

				if(unit.area=='NTB')
				{
					Tempntb += "<tr class='rowappendjabar'>";
					Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntb += '</tr>';
					totntb += parseInt(unit.amount);
				}

				if(unit.area=='NTT')
				{
					Tempntt += "<tr class='rowappendjabar'>";
					Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntt += '</tr>';
					totntt += parseInt(unit.amount);
				}
			});

			if(Tempjabar){
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
				Tempjabar += '</tr>';
			}

			if(Tempjatim){
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
				Tempjatim += '</tr>';
			}

			if(Tempntt){
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-right' colspan='2'> Total NTT </td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
				Tempntt += '</tr>';
			}

			if(Tempntb){
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-right' colspan='2'> Total NTB </td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
				Tempntb += '</tr>';
			}

			totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
			if(totall){
				Tempall += "<tr class='rowappendjabar'>";
				Tempall += "<td class='text-right' colspan='2'> Total </td>";
				Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
				Tempall += '</tr>';
			}				

			$('#tblPelunasan').append(Tempjabar);
			$('#tblPelunasan').append(Tempjatim);
			$('#tblPelunasan').append(Tempntt);
			$('#tblPelunasan').append(Tempntb);
			$('#tblPelunasan').append(Tempall);

		},
		complete:function () {
			$('#form_pelunasan').find('.total-today').text(convertToRupiah(totalCurr));
			$('#form_pelunasan').find('.date-today').text(currdate);
			var data = transaction,
					//config manager
					config = {
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
						// barColors: function (row, series, type) {
						//     if (row.label == "Low") return "#3578FC";
						//     else if (row.label == "Medium") return "#FFD500";
						//     else if (row.label == "High") return "#FF0000";
						//     else if (row.label == "Fatal") return "#000000";
						// }
					};
			//config element name
			config.element = 'graphPelunasan';
			new Morris.Bar(config);
			KTApp.unblock('#form_pelunasan .kt-widget14', {});
		},
	});

}

function saldo() {
	$('svg').remove();
	$('#graphSaldo').empty();
	var transaction = [];
	var totalCurr = 0;
	var totalLast = 0;
	//var currdate = '2020-07-20';
	KTApp.block('#form_saldo .kt-widget14', {});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/saldounit');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			month:currmonth,
		},
		success:function (response) {
			var Tempjabar 	= "";
			var Tempjatim	= "";
			var Tempntt		= "";
			var Tempntb		= "";
			var Tempall		= "";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;

			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalCurr += parseInt(unit.amount);

				if(unit.area=='Jawa Barat')
				{
					Tempjabar += "<tr class='rowappendjabar'>";
					Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjabar += '</tr>';
					totjabar += parseInt(unit.amount);
				}

				if(unit.area=='Jawa Timur')
				{
					Tempjatim += "<tr class='rowappendjabar'>";
					Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjatim += '</tr>';
					totjatim += parseInt(unit.amount);
				}

				if(unit.area=='NTB')
				{
					Tempntb += "<tr class='rowappendjabar'>";
					Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntb += '</tr>';
					totntb += parseInt(unit.amount);
				}

				if(unit.area=='NTT')
				{
					Tempntt += "<tr class='rowappendjabar'>";
					Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntt += '</tr>';
					totntt += parseInt(unit.amount);
				}

			});

			if(Tempjabar){
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
				Tempjabar += '</tr>';
			}

			if(Tempjatim){
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
				Tempjatim += '</tr>';
			}

			if(Tempntt){
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-right' colspan='2'> Total NTT </td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
				Tempntt += '</tr>';
			}

			if(Tempntb){
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-right' colspan='2'> Total NTB </td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
				Tempntb += '</tr>';
			}

			totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
			if(totall){
				Tempall += "<tr class='rowappendjabar'>";
				Tempall += "<td class='text-right' colspan='2'> Total </td>";
				Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
				Tempall += '</tr>';
			}				

			$('#tblSaldo').append(Tempjabar);
			$('#tblSaldo').append(Tempjatim);
			$('#tblSaldo').append(Tempntt);
			$('#tblSaldo').append(Tempntb);
			$('#tblSaldo').append(Tempall);

		},
		complete:function () {
			$('#form_saldo').find('.total-today').text(convertToRupiah(totalCurr));
			$('#form_saldo').find('.date-today').text(currdate);
			var data = transaction,
					//config manager
					config = {
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
						// barColors: function (row, series, type) {
						//     if (row.label == "Low") return "#3578FC";
						//     else if (row.label == "Medium") return "#FFD500";
						//     else if (row.label == "High") return "#FF0000";
						//     else if (row.label == "Fatal") return "#000000";
						// }
					};
			//config element name
			config.element = 'graphSaldo';
			new Morris.Bar(config);
			KTApp.unblock('#form_saldo .kt-widget14', {});
		},
	});

}

function pengeluaran() {
	$('svg').remove();
	$('#graphPengeluaran').empty();
	var total = 0;
	//var currdate = '2020-07-20';
	var transaction = [];
	KTApp.block('#form_pengeluaran .kt-widget14', {});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/pengeluaran');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			month:currmonth,
		},
		success:function (response) {

			var Tempjabar 	= "";
			var Tempjatim	= "";
			var Tempntt		= "";
			var Tempntb		= "";
			var Tempall		= "";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;

			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				})
				total += parseInt(unit.amount);

				if(unit.area=='Jawa Barat')
				{
					Tempjabar += "<tr class='rowappendjabar'>";
					Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjabar += '</tr>';
					totjabar += parseInt(unit.amount);
				}

				if(unit.area=='Jawa Timur')
				{
					Tempjatim += "<tr class='rowappendjabar'>";
					Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjatim += '</tr>';
					totjatim += parseInt(unit.amount);
				}

				if(unit.area=='NTB')
				{
					Tempntb += "<tr class='rowappendjabar'>";
					Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntb += '</tr>';
					totntb += parseInt(unit.amount);
				}

				if(unit.area=='NTT')
				{
					Tempntt += "<tr class='rowappendjabar'>";
					Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntt += '</tr>';
					totntt += parseInt(unit.amount);
				}

			});

			if(Tempjabar){
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
				Tempjabar += '</tr>';
			}

			if(Tempjatim){
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
				Tempjatim += '</tr>';
			}

			if(Tempntt){
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-right' colspan='2'> Total NTT </td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
				Tempntt += '</tr>';
			}

			if(Tempntb){
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-right' colspan='2'> Total NTB </td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
				Tempntb += '</tr>';
			}

			totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
			if(totall){
				Tempall += "<tr class='rowappendjabar'>";
				Tempall += "<td class='text-right' colspan='2'> Total </td>";
				Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
				Tempall += '</tr>';
			}				

			$('#tblPengeluaran').append(Tempjabar);
			$('#tblPengeluaran').append(Tempjatim);
			$('#tblPengeluaran').append(Tempntt);
			$('#tblPengeluaran').append(Tempntb);
			$('#tblPengeluaran').append(Tempall);

		},
		complete:function () {
			$('#form_pengeluaran').find('.date-today').text(currdate);
			$('#form_pengeluaran').find('.total-today').text(convertToRupiah(total));
			var data = transaction,
					//config manager
					config = {
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
						// barColors: function (row, series, type) {
						//     if (row.label == "Low") return "#3578FC";
						//     else if (row.label == "Medium") return "#FFD500";
						//     else if (row.label == "High") return "#FF0000";
						//     else if (row.label == "Fatal") return "#000000";
						// }
					};
			//config element name
			config.element = 'graphPengeluaran';
			new Morris.Bar(config);
			KTApp.unblock('#form_pengeluaran .kt-widget14', {});
		},
	});

}

function pendapatan() {
	$('svg').remove();
	$('#graphPendapatan').empty();
	//var currdate = '2020-07-20';
	var total = 0;
	KTApp.block('#form_pendapatan .kt-widget14', {});
	var transaction = [];
	$.ajax({
		url:"<?php echo base_url('api/dashboards/pendapatan');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			month:currmonth,
		},
		success:function (response) {

			var Tempjabar 	= "";
			var Tempjatim	= "";
			var Tempntt		= "";
			var Tempntb		= "";
			var Tempall		= "";
			var totjabar 	= 0;
			var totjatim 	= 0;
			var totntb 		= 0;
			var totntt 		= 0;
			var totall 		= 0;

			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				total += parseInt(unit.amount);

				if(unit.area=='Jawa Barat')
				{
					Tempjabar += "<tr class='rowappendjabar'>";
					Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjabar += '</tr>';
					totjabar += parseInt(unit.amount);
				}

				if(unit.area=='Jawa Timur')
				{
					Tempjatim += "<tr class='rowappendjabar'>";
					Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempjatim += '</tr>';
					totjatim += parseInt(unit.amount);
				}

				if(unit.area=='NTB')
				{
					Tempntb += "<tr class='rowappendjabar'>";
					Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntb += '</tr>';
					totntb += parseInt(unit.amount);
				}

				if(unit.area=='NTT')
				{
					Tempntt += "<tr class='rowappendjabar'>";
					Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
					Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
					Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					Tempntt += '</tr>';
					totntt += parseInt(unit.amount);
				}

			});

			if(Tempjabar){
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-right' colspan='2'> Total Jawa Barat </td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
				Tempjabar += '</tr>';
			}

			if(Tempjatim){
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-right' colspan='2'> Total Jawa Timur </td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
				Tempjatim += '</tr>';
			}

			if(Tempntt){
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-right' colspan='2'> Total NTT </td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
				Tempntt += '</tr>';
			}

			if(Tempntb){
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-right' colspan='2'> Total NTB </td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
				Tempntb += '</tr>';
			}

			totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
			if(totall){
				Tempall += "<tr class='rowappendjabar'>";
				Tempall += "<td class='text-right' colspan='2'> Total </td>";
				Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
				Tempall += '</tr>';
			}				

			$('#tblPendapatan').append(Tempjabar);
			$('#tblPendapatan').append(Tempjatim);
			$('#tblPendapatan').append(Tempntt);
			$('#tblPendapatan').append(Tempntb);
			$('#tblPendapatan').append(Tempall);

		},
		complete:function () {
			$('#form_pendapatan').find('.date-today').text(currdate);
			$('#form_pendapatan').find('.total-today').text(convertToRupiah(total));
			var data = transaction,
					//config manager
					config = {
						data: data,
						xkey: 'y',
						ykeys: ['a'],
						labels: ['Values'],
						lineColors: ['#6e4ff5', '#f6aa33'],
						resize: true,
						xLabelAngle: '80',
						xLabelMargin: '10',
						parseTime: false,
						gridTextSize: '10',
						gridTextColor: '#5cb85c',
						verticalGrid: true,
						hideHover: 'auto',
						barColors: ['#3578FC','#FF0000', '#FFD500']
						// barColors: function (row, series, type) {
						//     if (row.label == "Low") return "#3578FC";
						//     else if (row.label == "Medium") return "#FFD500";
						//     else if (row.label == "High") return "#FF0000";
						//     else if (row.label == "Fatal") return "#000000";
						// }
					};
			//config element name
			config.element = 'graphPendapatan';
			new Morris.Bar(config);
			KTApp.unblock('#form_pendapatan .kt-widget14', {});
		},
	});
}

function targetBooking(){
	var data = [{
            label: 'Percentage',
            data: [10, 90, 40, 60],
            type: 'line',
            borderColor: '#ff0000',
			yAxisID: 'B',
            datalabels: {
                display: false
            }
        }, {
            label: 'Target',
            backgroundColor: '#006699',
			yAxisID: 'A',
            data: [6310, 5742, 4044, 5564]
        }, {
            label: 'Realisasi',
            backgroundColor: '#FFA000',
			yAxisID: 'A',
            data: [11542, 12400, 12510, 11450]
        }];
        
        
         var options = {
        	tooltips: {
            	mode: 'label',
			},						
			scales: {
				xAxes: [{
						stacked: true,
						gridLines: {
							display: false
						}
					}],
				yAxes: [{
						id: 'A',
						stacked: true,						
						ticks: {
							beginAtZero: true,
							callback: function (value) {
								valuek = convertToRupiah(value) ;
								return valuek;
							}
						}
					},{
							id: 'B',
							type: 'linear',
							position: 'right',
							ticks: {
								max: 100,
								min: 0,
							}
					}]
			}
    };

	var ctx = document.getElementById("graphtarBooking");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["India", "China", "USA", "Canada"],
            datasets: data
        },
        options: options
    });

}

function targetOutstanding(){
	var data = [{
            label: 'Percentage',
            data: [10, 90, 40, 60],
            type: 'line',
            borderColor: '#ff0000',
			yAxisID: 'B',
            datalabels: {
                display: false
            }
        }, {
            label: 'Target',
            backgroundColor: '#512DA8',
			yAxisID: 'A',
            data: [6310, 5742, 4044, 5564]
        }, {
            label: 'Realisasi',
            backgroundColor: '#FFA000',
			yAxisID: 'A',
            data: [11542, 12400, 12510, 11450]
        }];
        
        
         var options = {
        	tooltips: {
            	mode: 'label',
			},						
			scales: {
				xAxes: [{
						stacked: true,
						gridLines: {
							display: false
						}
					}],
				yAxes: [{
						id: 'A',
						stacked: true,						
						ticks: {
							beginAtZero: true,
							callback: function (value) {
								valuek = convertToRupiah(value) ;
								return valuek;
							}
						}
					},{
							id: 'B',
							type: 'linear',
							position: 'right',
							ticks: {
								max: 100,
								min: 0,
							}
					}]
			}
    };
    
  	var ctx = document.getElementById("graphtarOutstanding");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["India", "China", "USA", "Canada"],
            datasets: data
        },
        options: options
    });
}

function notfound(){
    $("#graph").empty();
    var div = document.getElementById('graph');
    div.innerHTML += '<div class="alert alert-success" role="alert"><strong>Well done! </strong> &nbsp&nbsp Graph not found</div>';
    KTApp.unblock('#form_bukukas .kt-portlet__body', {});
}

jQuery(document).ready(function() {
	disburse();
	outstanding();
	dpd();
	pencairan();
	pelunasan();
	saldo();
	pengeluaran();
	pendapatan();
	targetBooking();
	targetOutstanding();
	//GraphTest();
});

</script>
