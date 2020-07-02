<script type="text/javascript">
	$('#kt_inbox_compose').on('submit', function (e) {
		e.preventDefault();
		var dataNew = {};
		var data = $(this).serializeArray();
		var body = $('.ql-editor').text();
		$.each(data, function (index, dat) {
			dataNew[dat.name] = dat.value;
		});
		dataNew['compose_body'] = body;
		$.ajax({
			type : 'POST',
			url : "<?php echo base_url("api/report/inbox/insert"); ?>",
			data : dataNew,
			dataType : "json",
			success : function(response,status){
				window.location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown){
					console.log(jqXHR);
			}
		});
	})
	function initData(data){
		$.ajax({
			type : 'GET',
			url : "<?php echo base_url("dailyreport/unitsreport/data"); ?>",
			data : data,
			dataType : "html",
			success : function(response,status){
				$('.kt-inbox__items').find('.kt-inbox__item').remove();
				$('.kt-inbox__items').html(response);
			},
			error: function (jqXHR, textStatus, errorThrown){
				console.log(jqXHR);
			}
		});
	}
	var page;
	if("<?php echo $this->uri->segment(3);?>" == 'send'){
		page = 'PUBLISH';
	}else if("<?php echo $this->uri->segment(3);?>" == 'trash'){
		page = 'DELETE';
	}else{
		page = 'ALL';
	}

	$('.search').on('change', function () {
		var data = {query:$(this).val(), page:page};
		initData(data);
	});

	$(document).ready(function () {
		console.log(page);
		initData({page:page});
	});
</script>
