<script>

function convertToRupiah(angka)
{
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}

var KTDashboard = function() {
    var currentDate = "<?php $date = date('Y-m-d'); echo $date?>";
    var lastDate = "<?php echo  date('Y-m-d', strtotime($date . " -1 days"));?>";

    // Revenue Change.
    var outstandingchart = function() {
        var outstanding = [];
        var noa = [];
        var lbldate = [];

        KTApp.block('#form_outstanding .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unitost');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                Temp ="";
                $.each(response.data, function (index,unit) {
                    outstanding.push(unit.up);
                    noa.push(unit.noa);
                    lbldate.push(unit.date);       
                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.date+"</b></td>";
                    Temp += "<td class='text-center'><b>"+unit.noa+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
                    Temp += "</tr>";   
                    //totalnoa += parseInt(unit.noa);
                    //totalup += parseInt(unit.up);             
                });
                $('#tblOutstanding').append(Temp);
            },
            error:function(xhr){
            },
            complete:function(){   
            var dataout 	= outstanding;
			var datanoa	= noa;
			var datalable 		= lbldate;
			var data = [{
				label: 'Outstanding',
				backgroundColor: '#512DA8',
				yAxisID: 'A',
				data: dataout
			}, {
				label: 'Noa',
				backgroundColor: '#FFA000',
				yAxisID: 'A',
				data: datanoa
			}];			
			
			var options = {
                tooltips: { 
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, }, 
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
									var suffixes = ["", "k", "m", "b","t"];
									var suffixNum = Math.floor((""+value).length/3);
									var shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000,suffixNum)) : value).toPrecision(2));
									if (shortValue % 1 != 0) {
										var shortNum = shortValue.toFixed(1);
									}
									return shortValue+suffixes[suffixNum];
								}
							}
						}]
				}
		};

		var ctx = document.getElementById("grapOutstanding");
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: datalable,
				datasets: data
			},
			options: options
		});
                KTApp.unblock('#form_outstanding .kt-widget14', {});            
            }
        });
    }

    var bookingchart = function() {
        var outstanding = [];
        var noa = [];
        var lbldate = [];

        KTApp.block('#form_booking .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unitbooking');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temp 	= "";
                var totalnoa 	= 0
                var totalup 	= 0
                $.each(response.data, function (index,unit) {
                    outstanding.push(unit.up);
                    noa.push(unit.noa);
                    lbldate.push(unit.date);   

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.date+"</b></td>";
                    Temp += "<td class='text-center'><b>"+unit.noa+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
                    Temp += "</tr>";   
                    totalnoa += parseInt(unit.noa);
                    totalup += parseInt(unit.up);                                    
                });

                Temp += "<tr class='rowappendjabar'>";
                Temp += "<td class='text-right'> Total</td>";
                Temp += "<td class='text-center'><b>"+convertToRupiah(totalnoa)+"</b></td>";
                Temp += "<td class='text-right'><b>"+convertToRupiah(totalup)+"</b></td>";
                Temp += '</tr>';
                $('#tblBooking').append(Temp);

            },
            error:function(xhr){

            },
            complete:function(){
                var dataout 	= outstanding;
                    var datanoa	= noa;
                    var datalable 		= lbldate;
                    var data = [{
                        label: 'Booking',
                        backgroundColor: '#33cccc',
                        yAxisID: 'A',
                        data: dataout
                    }, {
                        label: 'Noa',
                        backgroundColor: '#FFA000',
                        yAxisID: 'A',
                        data: datanoa
                    }];			
                    
                    var options = {
                        tooltips: {
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
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
                                            // var suffixes = ["", "k", "m", "b","t"];
                                            // var suffixNum = Math.floor((""+value).length/3);
                                            // var shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000,suffixNum)) : value).toPrecision(2));
                                            // if (shortValue % 1 != 0) {
                                            //     var shortNum = shortValue.toFixed(1);
                                            // }
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("grapBooking");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datalable,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_booking .kt-widget14', {}); 
            }
        });
    }

    var pencairanchart = function() {
        var pencairan = [];
        var pelunasan = [];
        var lbldate = [];

        KTApp.block('#form_pencairan .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unitpencairan');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temp ="";
                var totpencairan=0;
                var totpelunasan=0;
                $.each(response.data, function (index,unit) {
                    pencairan.push(unit.pencairan);
                    pelunasan.push(unit.pelunasan);
                    lbldate.push(unit.date); 

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.date+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.pencairan)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.pelunasan)+"</b></td>";
                    Temp += "</tr>";   
                    totpencairan += parseInt(unit.pencairan);
                    totpelunasan += parseInt(unit.pelunasan);                      
                });

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-right'>Total </td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totpencairan)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totpelunasan)+"</b></td>";
                    Temp += "</tr>"; 
                    $("#tblpencairan").append(Temp);
            },
            error:function(xhr){

            },
            complete:function(){
                    var datapencairan 	= pencairan;
                    var datapelunasan	= pelunasan;
                    var datalable 		= lbldate;
                    var data = [{
                        label: 'Pencairan',
                        backgroundColor: '#ff6600',
                        yAxisID: 'A',
                        data: datapencairan
                    }, {
                        label: 'Pelunasan',
                        backgroundColor: '#0099ff',
                        yAxisID: 'A',
                        data: datapelunasan
                    }];			
                    
                    var options = {
                        tooltips: {
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
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
                                            // var suffixes = ["", "k", "m", "b","t"];
                                            // var suffixNum = Math.floor((""+value).length/3);
                                            // var shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000,suffixNum)) : value).toPrecision(2));
                                            // if (shortValue % 1 != 0) {
                                            //     var shortNum = shortValue.toFixed(1);
                                            // }
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("grapPencairan");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datalable,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_pencairan .kt-widget14', {}); 
            }
        });
    }

    var dpdchart = function() {
        var packet = [];
        var totpacket1 =0;
        var totpacket2 =0;
        var totpacket3 =0;
        var lblpacket = [];

        KTApp.block('#form_dpd .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unitdpd');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temppaket1 	= "";
                var Temppaket2	= "";
                var Temppaket3	= "";

                $.each(response.data, function (index,unit) {
                    if(parseInt(unit.dpd)>0 && parseInt(unit.dpd) <=15){
                        totpacket1 += parseInt(unit.amount);
                        Temppaket1 += "<tr class='rowappendpk1'>";
					    Temppaket1 += "<td class='text-left'><b>"+unit.customer_name+"</b></td>";
					    Temppaket1 += "<td class='text-center'><b>"+unit.date_sbk+"</b></td>";
					    Temppaket1 += "<td class='text-center'><b>"+unit.deadline+"</b></td>";
					    Temppaket1 += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					    Temppaket1 += "<td class='text-center'><b>"+unit.dpd+"</b></td>";
                        Temppaket1 += "</tr>";

                    }
                    if(parseInt(unit.dpd) >= 16 && parseInt(unit.dpd) <=30){
                        totpacket2 += parseInt(unit.amount);
                        Temppaket2 += "<tr class='rowappendpk1'>";
					    Temppaket2 += "<td class='text-left'><b>"+unit.customer_name+"</b></td>";
					    Temppaket2 += "<td class='text-center'><b>"+unit.date_sbk+"</b></td>";
					    Temppaket2 += "<td class='text-center'><b>"+unit.deadline+"</b></td>";
					    Temppaket2 += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					    Temppaket2 += "<td class='text-center'><b>"+unit.dpd+"</b></td>";
                        Temppaket2 += "</tr>";
                    }
                    if(parseInt(unit.dpd) > 31){
                        totpacket3 += parseInt(unit.amount);
                        Temppaket3 += "<tr class='rowappendpk1'>";
					    Temppaket3 += "<td class='text-left'><b>"+unit.customer_name+"</b></td>";
					    Temppaket3 += "<td class='text-center'><b>"+unit.date_sbk+"</b></td>";
					    Temppaket3 += "<td class='text-center'><b>"+unit.deadline+"</b></td>";
					    Temppaket3 += "<td class='text-right'><b>"+convertToRupiah(unit.amount)+"</b></td>";
					    Temppaket3 += "<td class='text-center'><b>"+unit.dpd+"</b></td>";
                        Temppaket3 += "</tr>";
                    }                   
                });
                packet.push(totpacket1,totpacket2,totpacket3);
                if(Temppaket1){
                    Temppaket1 += "<tr class='rowappendjabar'>";
                    Temppaket1 += "<td class='text-right' colspan='3'>DPD <= 15 hari - (Total)</td>";
                    Temppaket1 += "<td class='text-right'><b>"+convertToRupiah(totpacket1)+"</b></td>";
                    Temppaket1 += "<td class='text-right'><b></b></td>";
                    Temppaket1 += '</tr>';
			    }
                if(Temppaket2){
                    Temppaket2 += "<tr class='rowappendjabar'>";
                    Temppaket2 += "<td class='text-right' colspan='3'>DPD >= 16 & <=30 hari - (Total) </td>";
                    Temppaket2 += "<td class='text-right'><b>"+convertToRupiah(totpacket2)+"</b></td>";
                    Temppaket2 += "<td class='text-right'><b></b></td>";
                    Temppaket2 += '</tr>';
			    }
                if(Temppaket3){
                    Temppaket3 += "<tr class='rowappendjabar'>";
                    Temppaket3 += "<td class='text-right' colspan='3'> DPD >= 30 hari - (Total) </td>";
                    Temppaket3 += "<td class='text-right'><b>"+convertToRupiah(totpacket3)+"</b></td>";
                    Temppaket3 += "<td class='text-right'><b></b></td>";
                    Temppaket3 += '</tr>';
			    }
                $('#tbldpd').append(Temppaket1);
                $('#tbldpd').append(Temppaket2);
                $('#tbldpd').append(Temppaket3);
            },
            error:function(xhr){

            },
            complete:function(){
                    //console.log(packet);
                    var datapacket = packet;
                    var datalabel 	= ["Normal","Warning","Danger"];
                    var data = [{
                        label: 'DPD',
                        backgroundColor: ['#008000','#b3b300','#e62e00'],
                        yAxisID: 'A',
                        data: datapacket
                    }];			
                    
                    var options = {
                        tooltips: { 
                                    mode: 'label', 
                                    label: 'mylabel', 
                                    callbacks: { 
                                        label: function(tooltipItem, data) { 
                                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, }, 
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
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("grapDPD");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datalabel,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_dpd .kt-widget14', {}); 
            }
        });
    }

    var kaschart = function() {
        var pendapatan = [];
        var pengeluaran = [];
        var lbldate = [];

        KTApp.block('#form_kas .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unitprofit');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temp ="";
                var totcashin =0;
                var totcashout =0;
                $.each(response.data, function (index,unit) {
                    pendapatan.push(unit.pendapatan);
                    pengeluaran.push(unit.pengeluaran);
                    lbldate.push(unit.date); 

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.date+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.pendapatan)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.pengeluaran)+"</b></td>";
                    Temp += "</tr>";   
                    totcashin += parseInt(unit.pendapatan);
                    totcashout += parseInt(unit.pengeluaran);                    
                });

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-right'>Total </td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totcashin)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totcashout)+"</b></td>";
                    Temp += "</tr>";  
                    $('#tblprofit').append(Temp);
            },
            error:function(xhr){

            },
            complete:function(){
                    var datapendapatan 	= pendapatan;
                    var datapengeluaran	= pengeluaran;
                    var datalable 		= lbldate;
                    var data = [{
                        label: 'Pendapatan',
                        backgroundColor: '#009933',
                        yAxisID: 'A',
                        data: datapendapatan
                    }, {
                        label: 'Pengeluaran',
                        backgroundColor: '#e6e600',
                        yAxisID: 'A',
                        data: datapengeluaran
                    }];			
                    
                    var options = {
                        tooltips: {
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
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
                                            // var suffixes = ["", "k", "m", "b","t"];
                                            // var suffixNum = Math.floor((""+value).length/3);
                                            // var shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000,suffixNum)) : value).toPrecision(2));
                                            // if (shortValue % 1 != 0) {
                                            //     var shortNum = shortValue.toFixed(1);
                                            // }
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("grapkas");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datalable,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_kas .kt-widget14', {}); 
            }
        });
    }

    var SummaryRatechart = function() {
        var noa = [];
        var rate = [];
        var TotRate = [];
        var Totup = [];

        KTApp.block('#form_rate .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/summaryrateunit');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temp="";
                var totnoa=0;
                var totup=0;
                $.each(response.data, function (index,unit) {
                    noa.push(unit.noa);
                    rate.push(unit.rate);
                    TotRate.push(unit.tot_rate);                    
                    Totup.push(unit.up); 
                    
                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.rate+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.noa)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.up)+"</b></td>";
                    Temp += "</tr>";   
                    totnoa += parseInt(unit.noa);
                    totup += parseInt(unit.up);                   
                });
                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'>Total </td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totnoa)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totup)+"</b></td>";
                    Temp += "</tr>"; 
                    $('#tblrate').append(Temp); 
                   
            },
            error:function(xhr){

            },
            complete:function(){
                    //console.log(rate);
                    var dataNoa 	= noa;
                    var dataRate	= rate;
                    var TotRate	    = TotRate;
                    var up 		    = Totup;
                    var data = [{
                        label: 'UP',
                        backgroundColor: '#ff9900',
                        yAxisID: 'A',
                        data: up
                    }];			
                    
                    var options = {
                        tooltips: {
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
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
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("grapRate");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dataRate,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_rate .kt-widget14', {}); 
            }
        });
    }

    var TarBookinghart = function() {
        var target = [];
        var realisasi = [];
        var month = [];

        KTApp.block('#form_tarbooking .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unittargetbooking');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temp ="";
                var tottarget =0;
                var totbooking =0;

                $.each(response.data, function (index,unit) {
                    target.push(unit.target);
                    realisasi.push(unit.realisasi);
                    month.push(unit.date);    

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.date+"</b></td>";
                    if(unit.realisasi > unit.target){
                        status="<i class='fa fa-caret-up text-success'></i><span class='kt-widget16__price  kt-font-success'> Melebihi Target</span>";
                    }else{
                        status="<i class='fa fa-caret-down text-danger'></i><span class='kt-widget16__price  kt-font-danger'> Dibawah Target</span>";
                    }
                    Temp += "<td class='text-left'><b>"+status+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.target)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.realisasi)+"</b></td>";
                    Temp += "</tr>";   
                    tottarget += parseInt(unit.target);
                    totbooking += parseInt(unit.realisasi);                 
                });

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-right' colspan='2'>Total</td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(tottarget)+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(totbooking)+"</b></td>";
                    Temp += "</tr>";  
                    $("#tbltarbook").append(Temp);
            },
            error:function(xhr){

            },
            complete:function(){
                    console.log(month);
                    var datatarget 	    = target;
                    var datarealisasi	= realisasi;
                    var datamonth	    = month;
                    var data = [{
                            label: 'Target',
                            backgroundColor: '#ff0066',
                            yAxisID: 'A',
                            data: datatarget
                        },{
                            label: 'Realisasi',
                            backgroundColor: '#0066ff',
                            yAxisID: 'A',
                            data: datarealisasi
                        }];			
                    
                    var options = {
                        tooltips: {
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
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
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("graptarBooking");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datamonth,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_tarbooking .kt-widget14', {}); 
            }
        });
    }

    var TarOutstandinghart = function() {
        var target = [];
        var realisasi = [];
        var month = [];

        KTApp.block('#form_tarout .kt-widget14', {});
        $.ajax({
            url: "<?php echo base_url('api/dashboards/unittargetbooking');?>",
            type:"GET",
            dataType:"JSON",
            data:{date:currentDate},
            success:function(response){
                var Temp ="";
                var tottarget =0;
                var totrealisasi =0;
                var totout =0;
                $.each(response.data, function (index,unit) {
                    target.push(unit.target_out);
                    realisasi.push(unit.realisasi_out);
                    month.push(unit.date);     

                    Temp += "<tr class='rowappendpk1'>";
                    Temp += "<td class='text-left'><b>"+unit.date+"</b></td>";
                    if(unit.realisasi_out > unit.target_out){
                        status="<i class='fa fa-caret-up text-success'></i><span class='kt-widget16__price  kt-font-success'> Melebihi Target</span>";
                    }else{
                        status="<i class='fa fa-caret-down text-danger'></i><span class='kt-widget16__price  kt-font-danger'> Dibawah Target</span>";
                    }
                    Temp += "<td class='text-left'><b>"+status+"</b></td>";
                    Temp += "<td class='text-right'><b>"+convertToRupiah(unit.target_out)+"</b></td>";
                    if(unit.realisasi_out!=0){ totout = convertToRupiah(unit.realisasi_out);}else{totout=0;}
                    Temp += "<td class='text-right'><b>"+totout+"</b></td>";
                    Temp += "</tr>";   
                    tottarget += parseInt(unit.target_out);
                    totrealisasi += parseInt(unit.realisasi_out);

                });
                    $("#tbltarout").append(Temp);
            },
            error:function(xhr){

            },
            complete:function(){
                    console.log(month);
                    var datatarget 	    = target;
                    var datarealisasi	= realisasi;
                    var datamonth	    = month;
                    var data = [{
                            label: 'Target',
                            backgroundColor: '#ff0066',
                            yAxisID: 'A',
                            data: datatarget
                        },{
                            label: 'Realisasi',
                            backgroundColor: '#00b33c',
                            yAxisID: 'A',
                            data: datarealisasi
                        }];			
                    
                    var options = {
                        tooltips: {
                            mode: 'label', 
                            label: 'mylabel', 
                            callbacks: { 
                            label: function(tooltipItem, data) { 
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
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
                                            return convertToRupiah(value);
                                        }
                                    }
                                }]
                        }
                };
		        var ctx = document.getElementById("graptarOut");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: datamonth,
                        datasets: data
                    },
                    options: options
                });
                KTApp.unblock('#form_tarout .kt-widget14', {}); 
            }
        });
    }

    return {
        // Init demos
        init: function() {
            // init charts
            outstandingchart(); 
            bookingchart(); 
            dpdchart(); 
            pencairanchart();
            kaschart();
            SummaryRatechart();
            TarBookinghart();
            TarOutstandinghart();
            // demo loading
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function() {
                loading.hide();
            }, 3000);
        }
    };
}();

function initCash(){
    var saldo=0;
    var saldoselisih=0;
    var outstanding=0;
    var upregular=0;
    var upcicilan=0;
    var saldocicilan=0;
    var dpd=0;
    var dpdnoa=0;
    KTApp.block('#form_saldounit .kt-portlet', {});
    KTApp.block('#form_cardOut .kt-portlet', {}); 
    KTApp.block('#form_cardDPD .kt-portlet', {}); 
       
    $.ajax({
        url: "<?php echo base_url('api/dashboards/SummaryUnit');?>",
        type:"GET",
        dataType:"JSON",
        success:function(response){
            saldo        = response.data.saldo;
            saldounit    = response.data.saldounit;
            saldoselisih = parseInt(response.data.saldo) - parseInt(response.data.saldounit);
            outstanding  = response.data.outstanding;
            dpd          = response.data.dpd;
            upregular    = response.data.upreguler;
            upcicilan    = response.data.upcicilan;
            saldocicilan = response.data.saldocicilan;
            dpdnoa       = response.data.noadpd;
            noareg       = response.data.noareguler;
            noaunreg     = response.data.noa_cicilan;
           
        },
        error:function(xhr){
            $('.cash-saldo').text(0);
        },
        complete:function(){
            $('.Outstanding').empty();
            $('.cash-saldo').text(convertToRupiah(saldoselisih));
            $('.Outstanding').text(convertToRupiah(outstanding));
            $('.upregular').text(convertToRupiah(upregular));
            $('.noareg').text(convertToRupiah(noareg));            
            $('.saldocicilan').text(convertToRupiah(saldocicilan));
            $('.noacicilan').text(convertToRupiah(noaunreg));            
            $('.saldounit').text(convertToRupiah(saldo));
            $('.saldoghanet').text(convertToRupiah(saldounit));
            $('.dpd-unit').text(convertToRupiah(dpd));
            $('.dpdnoa').text(convertToRupiah(dpdnoa));            
          KTApp.unblock('#form_saldounit .kt-portlet', {}); 
          KTApp.unblock('#form_cardOut .kt-portlet', {});  
          KTApp.unblock('#form_cardDPD .kt-portlet', {});  
          //$("#message_alert").show();                    
        }
    });
}

function initCaseOs(){
    var total=0;
    var noa=0;
    //KTApp.block('#form_saldounit .kt-portlet', {});       
    $.ajax({
        url: "<?php echo base_url('api/dashboards/reportcustomers');?>",
        type:"GET",
        dataType:"JSON",
        success:function(response){
            $.each(response.data, function (index,unit) {
                    total += parseInt(unit.amount);
                    noa += 1;
            });
            total = total;
            noa = noa;
        },
        error:function(xhr){
        },
        complete:function(){
            if(total >0){
                $("#message_alert").show();                   
                $('.total_err').text(convertToRupiah(total));
                $('.total_noa_err').text(noa);
            }
        }
    });
}

// Class initialization on page load
jQuery(document).ready(function() {
    KTDashboard.init();
    initCash();
    initCaseOs();
});
</script>