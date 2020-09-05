<script>
//globals
var area = "<?php echo $area?>";
var month = '<?php echo $month?>';
var year = '<?php echo $year;?>';
$(document).ready(function(){
	targetBooking();
})

$('#area').select2({ placeholder: "Select Area", width: '100%' });
$('#month').select2({ placeholder: "Select Month", width: '100%' });
$('#tahun').select2({ placeholder: "Select Year", width: '100%' });

$('#btncari').on('click', function(){
	area = $('#area').val();
	month = $('#month').val();
	year = $('#tahun').val();
	targetBooking();
});


function convertToRupiah(angka)
{
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}

function targetBooking(){

var booking 	= [];
var target 		= [];
var percentage 	= [];
var unitlabel 	= [];
var tottarget 	 = 0;
var totrealisasi = 0;
KTApp.block('#form_tarBook .kt-widget14', {});
$.ajax({
	url:"<?php echo base_url('api/datamaster/unitstarget/reportreal');?>",
	type:"GET",
	dataType:"JSON",
	data:{
		area, year,month
	},
	success:function (response) {

		var Tempjabar 	= "";
		var Tempjatim	= "";
		var Tempntt		= "";
		var Tempntb		= "";
		var Tempall		= "";
		var totjabar 	= 0;
		var totjabarreal= 0;
		var totjatim 	= 0;
		var totjatimreal= 0;
		var totntb 		= 0;
		var totntbreal	= 0;
		var totntt 		= 0;
		var totnttreal	= 0;
		var totall 		= 0;
		var status		="";

		$.each(response.data, function (index,unit) {
			unitlabel.push(unit.name);
			booking.push(unit.booking.real);		
			target.push(unit.booking.target);
			percentage.push(unit.booking.percentage);

			tottarget += unit.booking.target;			
			totrealisasi += unit.booking.real;	

			if(unit.area=='Jawa Barat')
			{
				Tempjabar += "<tr class='rowappendjabar'>";
				Tempjabar += "<td class='text-left'><b>"+unit.area+"</b></td>";
				Tempjabar += "<td class='text-left'><b>"+unit.name+"</b></td>";
				if(unit.booking.percentage!=0){
					if(unit.booking.percentage >=100)
					{ status="<i class='fa fa-caret-up text-success'></i><span class='kt-widget16__price  kt-font-success'> Melebihi Target</span>";}
					else
					{status="<i class='fa fa-caret-down text-danger'></i><span class='kt-widget16__price  kt-font-danger'> Dibawah Target</span>";}
				}else{
					status="";
				}
				Tempjabar += "<td class='text-center'><b>"+status+"</b></td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.booking.target)+"</b></td>";
				Tempjabar += "<td class='text-right'><b>"+convertToRupiah(unit.booking.real)+"</b></td>";
				Tempjabar += "<td class='text-right'><b>"+unit.booking.percentage+"</b></td>";
				Tempjabar += '</tr>';
				totjabar += parseInt(unit.booking.target);
				totjabarreal += parseInt(unit.booking.real);
			}

			if(unit.area=='Jawa Timur')
			{
				Tempjatim += "<tr class='rowappendjabar'>";
				Tempjatim += "<td class='text-left'><b>"+unit.area+"</b></td>";
				Tempjatim += "<td class='text-left'><b>"+unit.name+"</b></td>";
				if(unit.booking.percentage!=0){
					if(unit.booking.percentage >=100)
					{ status="<i class='fa fa-caret-up text-success'></i><span class='kt-widget16__price  kt-font-success'> Melebihi Target</span>";}
					else
					{status="<i class='fa fa-caret-down text-danger'></i><span class='kt-widget16__price  kt-font-danger'> Dibawah Target</span>";}
				}else{
					status="";
				}
				Tempjatim += "<td class='text-center'><b>"+status+"</b></td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.booking.target)+"</b></td>";
				Tempjatim += "<td class='text-right'><b>"+convertToRupiah(unit.booking.real)+"</b></td>";
				Tempjatim += "<td class='text-right'><b>"+unit.booking.percentage+"</b></td>";
				Tempjatim += '</tr>';
				totjatim += parseInt(unit.booking.target);
				totjatimreal += parseInt(unit.booking.real);
			}

			if(unit.area=='NTB')
			{
				Tempntb += "<tr class='rowappendjabar'>";
				Tempntb += "<td class='text-left'><b>"+unit.area+"</b></td>";
				Tempntb += "<td class='text-left'><b>"+unit.name+"</b></td>";
				if(unit.booking.percentage!=0){
					if(unit.booking.percentage >=100)
					{ status="<i class='fa fa-caret-up text-success'></i><span class='kt-widget16__price  kt-font-success'> Melebihi Target</span>";}
					else
					{status="<i class='fa fa-caret-down text-danger'></i><span class='kt-widget16__price  kt-font-danger'> Dibawah Target</span>";}
				}else{
					status="";
				}
				Tempntb += "<td class='text-center'><b>"+status+"</b></td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.booking.target)+"</b></td>";
				Tempntb += "<td class='text-right'><b>"+convertToRupiah(unit.booking.real)+"</b></td>";
				Tempntb += "<td class='text-right'><b>"+unit.booking.percentage+"</b></td>";
				Tempntb += '</tr>';
				totntb += parseInt(unit.booking.target);
				totntbreal += parseInt(unit.booking.real);
			}

			if(unit.area=='NTT')
			{
				Tempntt += "<tr class='rowappendjabar'>";
				Tempntt += "<td class='text-left'><b>"+unit.area+"</b></td>";
				Tempntt += "<td class='text-left'><b>"+unit.name+"</b></td>";
				if(unit.booking.percentage!=0){
					if(unit.booking.percentage >=100)
					{ status="<i class='fa fa-caret-up text-success'></i><span class='kt-widget16__price  kt-font-success'> Melebihi Target</span>";}
					else
					{status="<i class='fa fa-caret-down text-danger'></i><span class='kt-widget16__price  kt-font-danger'> Dibawah Target</span>";}
				}else{
					status="";
				}
				Tempntt += "<td class='text-center'><b>"+status+"</b></td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.booking.target)+"</b></td>";
				Tempntt += "<td class='text-right'><b>"+convertToRupiah(unit.booking.real)+"</b></td>";
				Tempntt += "<td class='text-right'><b>"+unit.booking.percentage+"</b></td>";
				Tempntt += '</tr>';
				totntt += parseInt(unit.booking.target);
				totnttreal += parseInt(unit.booking.real);
			}		
		});

		if(Tempjabar){
			Tempjabar += "<tr class='rowappendjabar'>";
			Tempjabar += "<td class='text-right' colspan='3'> Total Jawa Barat </td>";
			Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabar)+"</b></td>";
			Tempjabar += "<td class='text-right'><b>"+convertToRupiah(totjabarreal)+"</b></td>";
			Tempjabar += "<td class='text-right'><b></b></td>";
			Tempjabar += '</tr>';
		}

		if(Tempjatim){
			Tempjatim += "<tr class='rowappendjabar'>";
			Tempjatim += "<td class='text-right' colspan='3'> Total Jawa Timur </td>";
			Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatim)+"</b></td>";
			Tempjatim += "<td class='text-right'><b>"+convertToRupiah(totjatimreal)+"</b></td>";
			Tempjatim += "<td class='text-right'><b></b></td>";
			Tempjatim += '</tr>';
		}

		if(Tempntt){
			Tempntt += "<tr class='rowappendjabar'>";
			Tempntt += "<td class='text-right' colspan='3'> Total NTT </td>";
			Tempntt += "<td class='text-right'><b>"+convertToRupiah(totntt)+"</b></td>";
			Tempntt += "<td class='text-right'><b>"+convertToRupiah(totnttreal)+"</b></td>";
			Tempntt += "<td class='text-right'><b></b></td>";
			Tempntt += '</tr>';
		}

		if(Tempntb){
			Tempntb += "<tr class='rowappendjabar'>";
			Tempntb += "<td class='text-right' colspan='3'> Total NTB </td>";
			Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntb)+"</b></td>";
			Tempntb += "<td class='text-right'><b>"+convertToRupiah(totntbreal)+"</b></td>";
			Tempntb += "<td class='text-right'><b></b></td>";
			Tempntb += '</tr>';
		}
		var realtotal =0;
		totall = parseInt(totjabar)+parseInt(totjatim)+parseInt(totntt)+parseInt(totntb);
		realtotal = parseInt(totjabarreal)+parseInt(totjatimreal)+parseInt(totnttreal)+parseInt(totntbreal);
		if(totall){
			Tempall += "<tr class='rowappendjabar'>";
			Tempall += "<td class='text-right' colspan='3'> Total </td>";
			Tempall += "<td class='text-right'><b>"+convertToRupiah(totall)+"</b></td>";
			Tempall += "<td class='text-right'><b>"+convertToRupiah(realtotal)+"</b></td>";
			Tempall += '</tr>';
		}				

		$('#tbltarBook').append(Tempjabar);
		$('#tbltarBook').append(Tempjatim);
		$('#tbltarBook').append(Tempntb);
		$('#tbltarBook').append(Tempntt);
		$('#tbltarBook').append(Tempall);

	},
	complete:function () {
		$('#form_tarBook').find('.total-target').text(convertToRupiah(tottarget));
		$('#form_tarBook').find('.total-realisasi').text(convertToRupiah(totrealisasi));			
		var datapercentage 	= percentage;
		var databooking 	= booking;
		var datatarget 		= target;
		var dataunitlabel 	= unitlabel;


		var data = [
		{
			label: 'Target',
			backgroundColor: '#006699',
			yAxisID: 'A',
			data: datatarget
		},
		 {
			label: 'Realisasi',
			backgroundColor: '#FFA000',
			yAxisID: 'A',
			data: databooking
		}];
		
		
		var options = {
			tooltips: {
				mode: 'label',
			},						
			scales: {
				xAxes: [{
						stacked: false,
						gridLines: {
							display: false
						}
					}],
				yAxes: [{
						id: 'A',
						stacked: false,						
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
								max: 200,
								min: 0,
							}
					}]
			}
	};

	var ctx = document.getElementById("graphtarBooking");
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: dataunitlabel,
			datasets: data
		},
		options: options
	});

		KTApp.unblock('#form_tarBook .kt-widget14', {});
	},
});
}

</script>
