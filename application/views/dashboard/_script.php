<script>
//globals
var cariForm;
<?php 
$date =  date('Y-m-d');
//$currdate =date("Y-m-t", strtotime($date));
$lastdate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
$nextlastdate = date('Y-m-d', strtotime('-2 days', strtotime($date)));
?>
var currdate = "<?php echo $lastdate;?>";
var lastdate = "<?php echo $nextlastdate;?>";
var currmonth = "<?php echo date('m'); ?>";

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

 function outstanding() {
	$('svg').remove();
    $('#graphOutstanding').empty();
	//var currdate = '2020-07-20';
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
			date:currdate,
		},
		success:function (response) {
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.total_outstanding.up
				});
				today += unit.total_outstanding.up;
				yesterday += unit.ost_yesterday.up;
			});
		},
		complete:function () {
			$('#form_outstanding').find('.total-today').text('Rp. '+convertToRupiah(today));
			$('#form_outstanding').find('.total-yesterday').text('Rp. '+convertToRupiah(yesterday));
			$('#form_outstanding').find('.date-today').text(currdate);
			$('#form_outstanding').find('.date-yesterday').text(lastdate);
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
			config.element = 'graphOutstanding';
			new Morris.Bar(config);
			KTApp.unblock('#form_outstanding .kt-widget14', {});
		},
	});
}

function pencairan() {
	$('svg').remove();
    $('#graphPencairan').empty();
	var totalCurr = 0;
	var totalLast = 0;

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
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalLast += parseInt(unit.amount);
			});
		},
		complete:function () {
			$('#form_pencairan').find('.date-yesterday').text(lastdate);
			$('#form_pencairan').find('.total-yesterday').text(totalLast);
		},
	});

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
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalCurr += unit.amount;
			});
		},
		complete:function () {
			$('#form_pencairan').find('.date-today').text(currdate);
			$('#form_pencairan').find('.total-today').text(totalCurr);
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
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalLast += parseInt(unit.amount);
			});
		},
		complete:function () {
			$('#form_pelunasan').find('.total-yesterday').text('Rp.'+totalLast);
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
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalCurr += parseInt(unit.amount);
			});
		},
		complete:function () {
			$('#form_pelunasan').find('.total-today').text('Rp.'+totalCurr);
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
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				total += parseInt(unit.amount);
			});
		},
		complete:function () {
			$('#form_pendapatan').find('.date-today').text(currdate);
			$('#form_pendapatan').find('.date-today').text('Rp.'+total);
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
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				})
				total += parseInt(unit.amount);
			});
		},
		complete:function () {
			$('#form_pengeluaran').find('.date-today').text(currdate);
			$('#form_pengeluaran').find('.total-today').text('Rp.'+total);
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

function saldo() {
	$('svg').remove();
	$('#graphSaldo').empty();
	var transaction = [];
	var totalCurr = 0;
	var totalLast = 0;
	//var currdate = '2020-07-20';
	KTApp.block('#form_saldo .kt-widget14', {});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/saldo');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			month:currmonth,
		},
		success:function (response) {
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.amount
				});
				totalCurr += parseInt(unit.amount);
			});
		},
		complete:function () {
			$('#form_saldo').find('.total-today').text('Rp. '+convertToRupiah(totalCurr));
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
			$.each(response.data, function (index,unit) {
				transaction.push({
					y:unit.name,
					a:unit.up
				});
				total += parseInt(unit.up);
			});
		},
		complete:function () {
			$('#form_dpd').find('.date-today').text(currdate);
			$('#form_dpd').find('.total-today').text('Rp.'+total);
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

function disburse() {
	$('svg').remove();
	$('#graphDisburse').empty();
	var transaction = [];
	var dateToday = "<?php echo  date('d', strtotime('-1 days', strtotime($date)));?>";
	var dateYesterday = "<?php echo  date('d', strtotime('-2 days', strtotime($date)))?>";
	//var currdate = '20';
	var totalYesterday = 0;
	var totalToday = 0;
	KTApp.block('#form_disburse .kt-widget14', {});
	$.ajax({
		url: "<?php echo base_url('api/dashboards/disburse');?>",
		type: "GET",
		dataType: "JSON",
		data: {
			area: '',
			date: dateToday,
		},
		success: function (response) {
			$.each(response.data, function (index, unit) {
				totalToday += unit.amount;
				transaction.push({
					y: unit.name,
					a: unit.amount,
					area:unit.id_area
				})
			});
		},
		complete: function () {
			$('#form_disburse').find('.total-today').text(totalToday);
			$('#form_disburse').find('.date-today').text(currdate);
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
						barColors: ['#3578FC', '#FF0000', '#FFD500'],
						// barColors: function (row, series, type) {
						//     if (data[no].area == 1) return "#e2f53b";
						//     else if (data[no].area == 2) return "#FFD500";
						//     else if (data[no].area == 3) return "#FF0000";
						//     else if (data[no].area == 4) return "#000000";
						// 	else  return '#2370b8';
						// }
					};
			//config element name
			config.element = 'graphDisburse';
			new Morris.Bar(config);
			KTApp.unblock('#form_disburse .kt-widget14', {});
		}
	});
	$.ajax({
		url:"<?php echo base_url('api/dashboards/disburse');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:'',
			date:dateYesterday,
		},
		success:function (response) {
			$.each(response.data, function (index,unit) {
				totalYesterday += unit.amount;
				transaction.push({
					y:unit.name,
					a:unit.amount
				})
			});
		},
		complete:function () {
			$('#form_disburse').find('.total-yesterday').text(totalYesterday);
			$('#form_disburse').find('.date-yesterday').text(lastdate);
		},

	});

}

function notfound(){
    $("#graph").empty();
    var div = document.getElementById('graph');
    div.innerHTML += '<div class="alert alert-success" role="alert"><strong>Well done! </strong> &nbsp&nbsp Graph not found</div>';
    // var label = "Not Found";
    // $("#graph").appendChild(label);
    KTApp.unblock('#form_bukukas .kt-portlet__body', {});
}

jQuery(document).ready(function() {
    //initCariForm();
	disburse();
	outstanding();
	pencairan();
	dpd();
	saldo();
	pelunasan();
	pendapatan();
	pengeluaran();
});

</script>