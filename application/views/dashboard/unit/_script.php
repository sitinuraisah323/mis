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
                $.each(response.data, function (index,unit) {
                    outstanding.push(unit.up);
                    noa.push(unit.noa);
                    lbldate.push(unit.date);                    
                });
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
                $.each(response.data, function (index,unit) {
                    outstanding.push(unit.up);
                    noa.push(unit.noa);
                    lbldate.push(unit.date);                    
                });
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
                $.each(response.data, function (index,unit) {
                    pencairan.push(unit.pencairan);
                    pelunasan.push(unit.pelunasan);
                    lbldate.push(unit.date);                    
                });
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
                $.each(response.data, function (index,unit) {
                    pendapatan.push(unit.pendapatan);
                    pengeluaran.push(unit.pengeluaran);
                    lbldate.push(unit.date);                    
                });
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
                $.each(response.data, function (index,unit) {
                    noa.push(unit.noa);
                    rate.push(unit.rate);
                    TotRate.push(unit.tot_rate);                    
                    Totup.push(unit.up);                    
                });
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
                $.each(response.data, function (index,unit) {
                    target.push(unit.target);
                    realisasi.push(unit.realisasi);
                    month.push(unit.date);                    
                });
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

    return {
        // Init demos
        init: function() {
            // init charts
            outstandingchart(); 
            bookingchart(); 
            //dpdchart(); 
            pencairanchart();
            kaschart();
            SummaryRatechart();
            TarBookinghart();
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
    var outstanding=0;
    var dpd=0;
    KTApp.block('#form_saldounit .kt-portlet', {});
    KTApp.block('#form_cardOut .kt-portlet', {}); 
    KTApp.block('#form_cardDPD .kt-portlet', {}); 
       
    $.ajax({
        url: "<?php echo base_url('api/dashboards/SummaryUnit');?>",
        type:"GET",
        dataType:"JSON",
        success:function(response){
            saldo = response.data.saldo;
            outstanding = response.data.outstanding;
            dpd = response.data.dpd;
           
        },
        error:function(xhr){
            $('.cash-saldo').text(0);
        },
        complete:function(){
            $('.cash-saldo').text(convertToRupiah(saldo));
            $('.Outstanding').text(convertToRupiah(outstanding));
            $('.dpd-unit').text(convertToRupiah(dpd));
          KTApp.unblock('#form_saldounit .kt-portlet', {}); 
          KTApp.unblock('#form_cardOut .kt-portlet', {});  
          KTApp.unblock('#form_cardDPD .kt-portlet', {});  
                   
        }
    });
}
// Class initialization on page load
jQuery(document).ready(function() {
    KTDashboard.init();
    initCash();
});
</script>