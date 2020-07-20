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

// function convertToRupiah(angka){
//    var reverse = angka.toString().split('').reverse().join(''),
//    ribuan = reverse.match(/\d{1,3}/g);
//    ribuan = ribuan.join('.').split('').reverse().join('');
//    return ribuan;
//  }

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
    $('#status').select2({ placeholder: "Select a status", width: '100%' });
    //events
    $('#btncari').on('click',function(){
        $('.rowappend').remove();
        var area = $('#area').val();
		var dateStart = $('[name="date-start"]').val();
        KTApp.block('#form_bukukas .kt-portlet__body', {});
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("api/dashboards/pencairan"); ?>",
			dataType : "json",
			data:{area:area,date:dateStart},
			success : function(response,status){
				KTApp.unblockPage();
				var body = '';
				var head = '';
				var int = 0;
				$.each(response.data, function (index, data) {
					if(index > 0){
						body += '<tr>';
						body += '<td>'+int+'</td>'
						body += '<td>'+data.name+'</td>'
						body += '<td>'+data.area+'</td>'
						$.each(data.dates, function (index, date) {
							body += '<td>'+date+'</td>';
						});
						body += '</tr>';
					}else{
						head += '<tr>';
						head += '<td>'+data.no+'</td>'
						head += '<td>'+data.unit+'</td>'
						head += '<td>'+data.area+'</td>'
						$.each(data.dates, function (index, date) {
							head += '<td>'+date+'</td>';
						})
						head += '</tr>';
					}
					int++;
				});
				$('.table').find('tbody').find('tr').remove();
				$('.table').find('thead').find('tr').remove();
				$('.table').find('thead').html(head);
				$('.table').find('tbody').html(body);

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

function initGetUnit(){
    $("#area").on('change',function(){
        var area = $('#area').val();
        var units =  document.getElementById('unit');
        var url_data = $('#url_get_unit').val() + '/' + area;
        $.get(url_data, function (data, status) {
            var response = JSON.parse(data);
            if (status) {
                $("#unit").empty();
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id;
                    opt.text = response.data[i].name;
                    units.appendChild(opt);
                }
            }
        });
    });
}

var KTMorrisChartsDemo1 = function () {

var Criteria = function () {
    var data = [{
        y: 'Fatal',
        a: 10,                    
    },
    {
        y: 'High',
        a: 50,
    },
    {
        y: 'Medium',
        a: 30,
    },{
        y: 'Low',
        a: 40
    }],
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
            //barColors: ['#000000', '#FF0000', '#FFD500', '#3578FC']
            barColors: function (row, series, type) {
                if (row.label == "Low") return "#3578FC";
                else if (row.label == "Medium") return "#FFD500";
                else if (row.label == "High") return "#FF0000";
                else if (row.label == "Fatal") return "#000000";
        }

        };
    //config element name
    config.element = 'Severity_graph';
    new Morris.Bar(config);
}

return {
    // public functions
    init: function () {
        //Location();
        Criteria();
    }
};
}();

jQuery(document).ready(function() {
    initCariForm();
    initGetUnit();
    KTMorrisChartsDemo1.init();
});

</script>
