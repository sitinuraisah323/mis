<script>
 function outstanding() {
	$('svg').remove();
    $('#graph').empty();
	//alert('test');
    var transaction = [];
    var data_booking = [];
    var data_pendapatan = [];
    var data_pengeluaran = [];
    var data_rate = [];
    var data_dpd = [];
    var data_os = [];
    $.ajax({
		url:"<?php echo base_url('api/transactions/regularpawns/performance');?>",
		type:"GET",
		dataType:"JSON",
		data:{
			area:$('[name="area"]').val(),
			date:$('[name="date"]').val(),
		},
		success:function (response) {
			const booking = response.data.booking;
			const pendapatan = response.data.pendapatan;
			const pengeluaran = response.data.pengeluaran;
			const rate = response.data.repayment;
			const dpd = response.data.dpd;
			const os = response.data.outstanding;
			$.each(os, function (index,unit) {
				data_os.push({
					y:index,
					a:unit
				})
			});

			$.each(dpd, function (index,unit) {
				data_dpd.push({
					y:index,
					a:unit
				})
			});


			$.each(booking, function (index,unit) {
				data_booking.push({
					y:index,
					a:unit
				})
			});
			$.each(pendapatan, function (index,unit) {
				data_pendapatan.push({
					y:index,
					a:unit
				})
			});
			$.each(pengeluaran, function (index,unit) {
				data_pengeluaran.push({
					y:index,
					a:unit
				})
			});
			$.each(rate, function (index,unit) {
				data_rate.push({
					y:index,
					a:unit
				})
			});
			initOs(data_os);
			initDpd(data_dpd);
			initBooking(data_booking);
			initPengeluaran(data_pengeluaran);
			initPendapatan(data_pendapatan);
			initRate(data_rate);
		},
		complete:function () {
			
		},
	});

}

function initRate(rate){
	var data = rate,
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
				};
		//config element name
		config.element = 'graph-rate';
		new Morris.Bar(config);
		KTApp.unblock('#rate .kt-portlet__body', {});
}
function initPendapatan(pendatapan){
	var data = pendatapan,
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
				};
		//config element name
		config.element = 'graph-pendapatan';
		new Morris.Bar(config);
		KTApp.unblock('#pendapatan .kt-portlet__body', {});
}

function initPengeluaran(pengeluaran){
	var data = pengeluaran,
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
				};
		//config element name
		config.element = 'graph-pengeluaran';
		new Morris.Bar(config);
		KTApp.unblock('#pengeluaran .kt-portlet__body', {});
}
function initBooking(booking){
	var data = booking,
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
				};
		//config element name
		config.element = 'graph-booking';
		new Morris.Bar(config);
		KTApp.unblock('#booking .kt-portlet__body', {});
}
function initDpd(booking){
	var data = booking,
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
				};
		//config element name
		config.element = 'graph-dpd';
		new Morris.Bar(config);
		KTApp.unblock('#booking .kt-portlet__body', {});
}

function initOs(booking){
	var data = booking,
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
				};
		//config element name
		config.element = 'graph-os';
		new Morris.Bar(config);
		KTApp.unblock('#booking .kt-portlet__body', {});
}
jQuery(document).ready(function() {
    outstanding();
});

</script>
