<script type="text/javascript">
	$('#kt_inbox_compose').on('submit', function (e) {
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			type : 'POST',
			url : "<?php echo base_url("api/datamaster/units/delete"); ?>",
			data : data,
			dataType : "json",
			success : function(response,status){
				console.log(response);
			},
			error: function (jqXHR, textStatus, errorThrown){
					console.log(jqXHR);
			}
		});
	})
</script>
