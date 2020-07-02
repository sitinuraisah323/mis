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
				$('.modal').modal('hide');
			},
			error: function (jqXHR, textStatus, errorThrown){
					console.log(jqXHR);
			}
		});
	})
</script>
