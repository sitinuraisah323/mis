<script>
<?php 
$date =  date('Y-m-d');
//$currdate =date("Y-m-t", strtotime($date));
$lastdate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
$nextlastdate = date('Y-m-d', strtotime('-2 days', strtotime($date)));
?>
var currdate    = "<?php echo $lastdate;?>";
var lastdate    = "<?php echo $nextlastdate;?>";
var currday     = "<?php echo date('d'); ?>";
var currmonth   = "<?php echo date('n'); ?>";
var curryear    = "<?php echo date('Y'); ?>";

function demoGraph() {
    $('#bar-chart').empty();
    var transaction = [];
	KTApp.block('#form_outstanding .kt-widget14', {});
    $.ajax({
		url:"<?php echo base_url('api/dashboards/newoutstanding');?>",
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
					a:unit.ost_today.up,
					b:unit.ost_today.m_up
				});
			});
		},
		complete:function () {
			var data = transaction,
					config = {
                        data: data,
                        xkey: 'y',
                        ykeys: ['a', 'b'],
                        labels: ['Gadai Reguler', 'Gadai Cicilan'],
                        fillOpacity: 0.6,
                        hideHover: 'auto',
                        behaveLikeLine: true,
                        resize: true,
                        pointFillColors:['#ffffff'],
                        pointStrokeColors: ['black'],
                        lineColors:['gray','red']
					};

                    config.element = 'bar-chart';
                    config.stacked = true;
                    Morris.Bar(config);
			KTApp.unblock('#form_outstanding .kt-widget14', {});
		},
	});

    // var data = [
    //             { y: 'Guluk Guluk', a: 50, b: 90},
    //             { y: '2015', a: 65,  b: 75},
    //             { y: '2016', a: 50,  b: 50},
    //             { y: '2017', a: 75,  b: 60},
    //             { y: '2018', a: 80,  b: 65},
    //             { y: '2019', a: 90,  b: 70},
    //             { y: '2020', a: 100, b: 75},
    //             { y: '2021', a: 115, b: 75},
    //             { y: '2022', a: 120, b: 85},
    //             { y: '2023', a: 145, b: 85},
    //             { y: '2024', a: 160, b: 95}
    //            ],                    
    //     config = {
    //         data: data,
    //         xkey: 'y',
    //         ykeys: ['a', 'b'],
    //         labels: ['Gadai Reguler', 'Gadai Cicilan'],
    //         fillOpacity: 0.6,
    //         hideHover: 'auto',
    //         behaveLikeLine: true,
    //         resize: true,
    //         pointFillColors:['#ffffff'],
    //         pointStrokeColors: ['black'],
    //         lineColors:['gray','red']
    //     };
    //     config.element = 'bar-chart';
    //     config.stacked = true;
    //     Morris.Bar(config);

}

jQuery(document).ready(function() {
    demoGraph();
});
</script>