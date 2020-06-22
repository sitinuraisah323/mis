<script>
	$('.upload').on('click', function (e) {
		e.preventDefault();
		$('.modal').modal('show');
	});
	$('.form-input').on('submit', function (e) {
		e.preventDefault();
		var data = new FormData(this);
		console.log(data);
		$.ajax({
			url : '<?php echo base_url('api/datamaster/customers/upload');?>',
			type : 'POST',
			data : data,
			async: true,
			cache: false,
			contentType: false,
			processData: false,
			success : function(response) {
				location.reload();
			}
		});
	});
</script
