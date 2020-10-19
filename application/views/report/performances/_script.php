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
			let tableos = $('#collapseOne1').find('table');
			tableos.append(`<tr><td>Bulan</td><td class="text-right">Jumlah</td></tr>`);
			let html = '';
			let sumOs = 0;
			$.each(os, function (index,unit) {
				html += `<tr><td>${index}</td><td class="text-right">${convertToRupiah(unit)}</td></tr>`;
				data_os.push({
					y:index,
					a:unit
				});
				sumOs += parseInt(unit);
			});
			html += `<tr><td>Total</td><td class="text-right">${convertToRupiah(sumOs)}</td></tr>`;
				
			tableos.append(html);

			let tabledpd = $('#collapseOne2').find('table');
			tabledpd.append(`<tr><td>Bulan</td><td class="text-right">Jumlah</td></tr>`);
			let htmldpd = '';

			let sumDPd = 0;
			$.each(dpd, function (index,unit) {
				data_dpd.push({
					y:index,
					a:unit
				})
				htmldpd += `<tr><td>${index}</td><td class="text-right">${convertToRupiah(unit)}</td></tr>`;
				sumDPd += parseInt(unit);
			});

			htmldpd += `<tr><td>Total</td><td class="text-right">${convertToRupiah(sumDPd)}</td></tr>`;
		

			tabledpd.append(htmldpd);

			let tablebooking = $('#collapseOne3').find('table');
			tablebooking.append(`<tr><td>Bulan</td><td class="text-right">Jumlah</td></tr>`);
			let htmlbooking = '';

			let sumBooking = 0;
			$.each(booking, function (index,unit) {
				htmlbooking += `<tr><td>${index}</td><td class="text-right">${convertToRupiah(unit)}</td></tr>`;
				data_booking.push({
					y:index,
					a:unit
				})
				sumBooking += parseInt(unit);
			});

			htmlbooking += `<tr><td>Total</td><td class="text-right">${convertToRupiah(sumBooking)}</td></tr>`;
				

			tablebooking.append(htmlbooking);

			let tablependapatan = $('#collapseOne5').find('table');
			tablependapatan.append(`<tr><td>Bulan</td><td class="text-right">Jumlah</td></tr>`);
			let htmlpendapatan = '';

			let sumPendapatan = 0;
			$.each(pendapatan, function (index,unit) {
				htmlpendapatan += `<tr><td>${index}</td><td class="text-right">${convertToRupiah(unit)}</td></tr>`;
				data_pendapatan.push({
					y:index,
					a:unit
				});
				sumPendapatan += parseInt(unit);
			});

			htmlpendapatan += `<tr><td>Total</td><td class="text-right">${convertToRupiah(sumPendapatan)}</td></tr>`;
			tablependapatan.append(htmlpendapatan);

			let tablepengeluaran = $('#collapseOne6').find('table');
			tablepengeluaran.append(`<tr><td>Bulan</td><td class="text-right">Jumlah</td></tr>`);
			let htmlpengeluaran = '';

			let sumPengeluaran = 0;
			$.each(pengeluaran, function (index,unit) {
				htmlpengeluaran += `<tr><td>${index}</td><td class="text-right">${convertToRupiah(unit)}</td></tr>`;			
				data_pengeluaran.push({
					y:index,
					a:unit
				})
				sumPengeluaran += parseInt(unit);
			});
			htmlpengeluaran += `<tr><td>Total</td><td class="text-right">${convertToRupiah(sumPengeluaran)}</td></tr>`;			
				
			tablepengeluaran.append(htmlpengeluaran);


			let tablerate = $('#collapseOne4').find('table');
			tablerate.append(`<tr><td>Bulan</td><td class="text-right">Jumlah</td></tr>`);
			let htmlrate = '';

			let sumRate = 0;
			$.each(rate, function (index,unit) {
				htmlrate += `<tr><td>${index}</td><td class="text-right">${convertToRupiah(unit)}</td></tr>`;			
				data_rate.push({
					y:index,
					a:unit
				});
				sumRate += parseInt(unit);
			});
			htmlrate += `<tr><td>Total</td><td class="text-right">${convertToRupiah(sumRate)}</td></tr>`;	

			tablerate.append(htmlrate);

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
