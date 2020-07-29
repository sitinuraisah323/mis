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
		$.ajax({
			url : '<?php echo base_url('api/transactions/mortages/upload');?>',
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

	$(document).on('click','.btn-edit', function(e){
		e.preventDefault();
		$.ajax({
			url : '<?php echo base_url('api/transactions/mortages/show/');?>'+$(this).data('id'),
			dataType:'JSON',
			success : function(response) {
				var data = response.data;
				$('[name="id"]').val(data.id);
				$('[name="nic"]').val(data.nic);
				$('[name="date_sbk"]').val(data.date_sbk);
				$('[name="deadline"]').val(data.deadline);
				$('[name="date_auction"]').val(data.date_auction);
				$('[name="estimation"]').val(data.estimation);
				$('[name="amount_loan"]').val(data.amount_loan);
				$('[name="amount_admin"]').val(data.amount_admin);
				$('[name="capital_lease"]').val(data.capital_lease);
				$('[name="periode"]').val(data.periode);
				$('[name="installment"]').val(data.installment);
				$('[name="interest"]').val(data.interest);
				$('[name="description_1"]').val(data.description_1);
				$('[name="description_2"]').val(data.description_2);
				$('[name="description_3"]').val(data.description_3);
				$('[name="description_4"]').val(data.description_4);
				$('#modal-form').trigger('click');
			}
		});
	});

	$('.btn-save').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url : '<?php echo base_url('api/transactions/mortages/update');?>',
			type : 'POST',
			data : $('.form-modal').serialize(),
			success : function(response) {
				location.reload();
			}
		});
	});


	function initDataTable(){
		var option = {
			data: {
				type: 'remote',
				source: {
					read: {
						url: '<?php echo base_url("api/transactions/mortages"); ?>',
						map: function(raw) {
							// sample data mapping
							var dataSet = raw;
							if (typeof raw.data !== 'undefined') {
								dataSet = raw.data;
							}
							return dataSet;
						},
					},
				},
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
				saveState : {cookie: false,webstorage: false},
			},
			sortable: true,
			pagination: true,
			search: {
				input: $('#generalSearch'),
			},
			columns: [
				{
					field: 'no_sbk',
					title: 'NO SBK',
					sortable: 'asc',
					width:60,
					textAlign: 'center',
				},
				{
					field: 'unit',
					title: 'Unit',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'nic',
					title: 'NO Cif',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'name',
					title: 'Nama Nasabah',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'date_sbk',
					title: 'Tanggal SBK',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'deadline',
					title: 'Jatuh Tempo',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'date_auction',
					title: 'Tanggal Lelang',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'estimation',
					title: 'Tafsiran',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'amount_loan',
					title: 'UP',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'amount_admin',
					title: 'Admin',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'description_1',
					title: 'Uraian 1',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'description_2',
					title: 'Uraian 2',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'description_3',
					title: 'Uraian 3',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'description_4',
					title: 'Uraian 4',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'capital_lease',
					title: 'Sewa Modal',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'periode',
					title: 'Jangka',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'installment',
					title: 'Cicilan',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'interest',
					title: 'Bunga',
					sortable: 'asc',
					width:60,
					textAlign: 'left',
				},
				{
					field: 'action',
					title: 'Action',
					sortable: false,
					width: 100,
					overflow: 'visible',
					textAlign: 'center',
					autoHide: false,
					template: function (row) {
						var result ="";
						result = result + '<button data-id="' + row.id + '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit" ><i class="flaticon-edit-1" style="cursor:pointer;"></i></button>';
						return result;
					}
				}
			],
			layout:{
				header:true
			}
		}
		datatable = $('#kt_datatable').KTDatatable(option);
		datatable.on("kt-datatable--on-layout-updated",function(){
			//initDTEvents();
		})
	}

	$(document).ready(function () {
		initDataTable();
	});
</script
