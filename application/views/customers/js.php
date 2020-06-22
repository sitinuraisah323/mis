<script>
	$('.upload').on('click', function (e) {
		e.preventDefault();
		$('#modal-upload').modal('show');
	});
	$('#modal-form').on('click', function (e) {
		e.preventDefault();
		$(this).modal('show');
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

	$('.btn-edit').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url : '<?php echo base_url('api/datamaster/customers/show/');?>'+$(this).data('id'),
			dataType:'JSON',
			success : function(response) {
				var data = response.data;
				$('[name="id"]').val(data.id);
				$('[name="no_cif"]').val(data.no_cif);
				$('[name="name"]').val(data.name);
				$('[name="mobile"]').val(data.mobile);
				$('[name="birth_date"]').val(data.birth_date);
				$('[name="birth_place"]').val(data.birth_place);
				$('[name="gender"]').val(data.gender);
				$('[name="marital"]').val(data.marital);
				$('[name="province"]').val(data.province);
				$('[name="city"]').val(data.city);
				$('[name="address"]').val(data.address);
				$('[name="job"]').val(data.job);
				$('[name="mother_name"]').val(data.mother_name);
				$('[name="sibling_name"]').val(data.sibling_name);
				$('[name="sibling_birth_date"]').val(data.sibling_birth_date);
				$('[name="sibling_birth_place"]').val(data.sibling_birth_place);
				$('[name="sibling_job"]').val(data.sibling_job);
				$('[name="sibling_relation"]').val(data.sibling_relation);
				$('[name="sibling_address_1"]').val(data.sibling_address_1);
				$('#modal-form').trigger('click');
			}
		});
	});

	$('.btn-save').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url : '<?php echo base_url('api/datamaster/customers/update');?>',
			type : 'POST',
			data : $('.form-modal').serialize(),
			success : function(response) {
				location.reload();
			}
		});
	});
</script
