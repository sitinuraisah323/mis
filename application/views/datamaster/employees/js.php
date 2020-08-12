<script>
//globals
var datatable;
var AlertUtil;
var createForm;
var editForm;

function InitClear(){
    $('.modal').on('hidden.bs.modal', function(){
        $("#id_unit").val([]).trigger("change");
        $("#gender").val([]).trigger("change");
        $("#blood_group").val([]).trigger("change");
        $("#marital").val([]).trigger("change");
        $("#id_level").val([]).trigger("change");
        $(this).find('form')[0].reset();        
    });    
}

function initDTEvents(){
    $(".btn_delete").on("click",function(){
        var targetId = $(this).data("id");
        //alert(targetId);
        swal.fire({
            title: 'Anda Yakin?',
            text: "Akan menghapus data ini",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus'
        }).then(function(result) {
            if (result.value) {
                KTApp.blockPage();
                $.ajax({
                    type : 'GET',
                    url : "<?php echo base_url("api/datamaster/employees/delete/"); ?>"+targetId,
                    dataType : "json",
                    success : function(data,status){
                        KTApp.unblockPage();
                        if(data.status == true){
                            datatable.reload();
                            AlertUtil.showSuccess(data.message,5000);
                        }else{
                            AlertUtil.showFailed(data.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        KTApp.unblockPage();
                        AlertUtil.showFailed("Cannot communicate with server please check your internet connection");
                    }
                });
            }
        });
    });

    $(".btn_edit").on("click",function(){
        var targetId = $(this).data("id");
        KTApp.blockPage();
        $.ajax({
            type : 'GET',
            url : "<?php echo base_url("api/datamaster/employees/show/"); ?>"+targetId,
            dataType : "json",
            success : function(response,status){
                KTApp.unblockPage();
                if(response.status == true){
                    //populate form
					$('#modal_add').find('[name="id"]').val(response.data.id);
					$('#modal_add').find('[name="fullname"]').val(response.data.fullname);
					$('#modal_add').find('[name="id_unit"]').val(response.data.id_unit);
                    $("#id_unit").trigger('change');
					$('#modal_add').find('[name="nik"]').val(response.data.nik);
					$('#modal_add').find('[name="birth_place"]').val(response.data.birth_place);
					$('#modal_add').find('[name="birth_date"]').val(response.data.birth_date);
					$('#modal_add').find('[name="username"]').val(response.data.username);
					$('#modal_add').find('[name="gender"]').val(response.data.gender);
					$('#modal_add').find('[name="email"]').val(response.data.email);
                    $("#gender").trigger('change');
					$('#modal_add').find('[name="mobile"]').val(response.data.mobile);
					$('#modal_add').find('[name="marital"]').val(response.data.marital);
                    $("#marital").trigger('change');
					$('#modal_add').find('[name="blood_group"]').val(response.data.blood_group);
                    $("#blood_group").trigger('change');
                    if(response.data.id_area){
						$('#modal_add').find('[name="id_area"]').val(response.data.id_area);
					}
					$('#modal_add').find('[name="address"]').val(response.data.address);
					$('#modal_add').find('[name="position"]').val(response.data.position);
					$('#modal_add').find('[name="email"]').val(response.data.email);
					$('#modal_add').find('[name="id_level"]').val(response.data.id_level);
					$('#modal_add').find('[name="bpjs_kesehatan"]').val(response.data.bpjs_kesehatan);
					$('#modal_add').find('[name="last_education"]').val(response.data.last_education);
					$('#modal_add').find('[name="bpjs_tk"]').val(response.data.bpjs_tk);
					$('#modal_add').find('[name="no_employment"]').val(response.data.no_employment);
					$('#modal_add').find('[name="join_date"]').val(response.data.join_date);
					$('#modal_add').find('[name="no_rek"]').val(response.data.no_rek);
					$('#modal_add').find('[name="masa_kerja"]').val(response.data.masa_kerja);
                    $("#id_level").trigger('change');
                    $('#modal_add').modal('show');
                }else{
                    AlertUtil.showFailed(data.message);
                    $('#modal_add').modal('show');
                }
            },
			complete:function(xhr){
				$('[name="id_area"]').trigger('change');
				$('[name="id_unit"]').trigger('change');
			},
            error: function (jqXHR, textStatus, errorThrown){
                KTApp.unblockPage();
                AlertUtil.showFailed("Cannot communicate with server please check your internet connection");
            }
        });
    });
}


function initDataTable(){
    var option = {
        data: {
            type: 'remote',
            source: {
              read: {
                url: '<?php echo base_url("api/datamaster/employees"); ?>',
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
                field: 'id',
                title: 'ID',
                sortable: 'asc',
                width:60,
                textAlign: 'center',
            },
			{
				field: 'name',
				title: 'Unit',
				sortable: 'asc',
				textAlign: 'left',
			},
            {
                field: 'nik',
                title: 'Nik',
                sortable: 'asc',
                textAlign: 'left',
            },
            {
                field: 'fullname',
                title: 'Nama',
                sortable: 'asc',
                textAlign: 'left',
            },
			{
				field: 'birthday',
				title: 'Tempat Tanggal Lahir',
				sortable: 'asc',
				textAlign: 'left',
				template:function (row) {
					return row.birth_place+', '+row.birth_place
				}
			},
			{
				field: 'gender',
				title: 'Jenis Kelamin',
				sortable: 'asc',
				textAlign: 'left',
			},
			{
				field: 'mobile',
				title: 'Mobile',
				sortable: 'asc',
				textAlign: 'left',
			},
			{
				field: 'marital',
				title: 'Status Kawin',
				sortable: 'asc',
				textAlign: 'left',
			},
			{
				field: 'blood_group',
				title: 'Golongan Darah',
				sortable: 'asc',
				textAlign: 'left',
			},
			{
				field: 'address',
				title: 'Alamat',
				sortable: 'asc',
				textAlign: 'left',
			},
			{
				field: 'position',
				title: 'Jabatan',
				sortable: 'asc',
				textAlign: 'left',
			},
			  {
				  field: 'masa_kerja',
				  title: 'Masa Kerja',
				  sortable: 'asc',
				  textAlign: 'left',
			  },
			  {
				  field: 'no_rek',
				  title: 'No Rekening',
				  sortable: 'asc',
				  textAlign: 'left',
			  },
			  {
				  field: 'join_date',
				  title: 'Join Date',
				  sortable: 'asc',
				  textAlign: 'left',
			  },
			  {
				  field: 'no_employment',
				  title: 'No Karyawam',
				  sortable: 'asc',
				  textAlign: 'left',
			  },
			  {
				  field: 'bpjs_tk',
				  title: 'BPJS TK',
				  sortable: 'asc',
				  textAlign: 'left',
			  },
			  {
				  field: 'bpjs_kesehatan',
				  title: 'BPJS Kesehatan',
				  sortable: 'asc',
				  textAlign: 'left',
			  },
			  {
				  field: 'last_education',
				  title: 'Pendidikan Terakhir',
				  sortable: 'asc',
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
                        result = result + '<span data-id="' + row.id + '" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn_edit" title="Edit" ><i class="flaticon-edit-1" style="cursor:pointer;"></i></span>';
                        result = result + '<span data-id="' + row.id + '" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn_delete" title="Delete" ><i class="flaticon2-trash" style="cursor:pointer;"></i></span>';
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
        initDTEvents();
    })
}

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

function initCreate(){
     InitClear();
     //events
     $("#input-form").on("submit",function(e){
    	e.preventDefault();
    	var id = $('[name="id"]').val();
    	var url;
    	if(id){
    		url = "<?php echo base_url("api/datamaster/employees/update"); ?>";
		}else{
    		url = "<?php echo base_url("api/datamaster/employees/insert"); ?>";
		}
        KTApp.block('#modal_add .modal-content', {});
        $.ajax({
            type : 'POST',
            url : url,
            data : $(this).serialize(),
            dataType : "json",
            success : function(data,status){
				$('#modal_add').find('[name="id"]').val("");
				$('#modal_add').find('[name="name"]').val("");
				$('#modal_add').find('[name="id_parent"]').val("");
                KTApp.unblock('#modal_add .modal-content');
                if(data.status == true){
                    datatable.reload();
                    $('#modal_add').modal('hide');
                    AlertUtil.showSuccess(data.message,5000);
                }else{
                    AlertUtil.showFailedDialogAdd(data.message);
                }
                getMenu();
            },
            error: function (jqXHR, textStatus, errorThrown){
                KTApp.unblock('#modal_add .modal-content');
                AlertUtil.showFailedDialogAdd("Cannot communicate with server please check your internet connection");
            }
        });
    });

}

   
	function getMenu(){
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url('api/datamaster/employees');?>',
			data : $(this).serialize(),
			dataType : "json",
			success : function(response,status){
				$('[name="id_parent"]').find('option').remove();
				$('[name="id_parent"]').append('<option value="0">--Sebagai Menu Utama--</option>');
				$.each(response.data, function (index, data) {
					$('[name="id_parent"]').append('<option value="'+data.id+'">'+data.name+'</option>')
				});
			},
		});
	}

    function getSelect2(){
        $('#id_unit').select2({ placeholder: "Please select a Unit",width: '100%'});
        $('#gender').select2({ placeholder: "Please select a Gender",width: '100%'});
        $('#marital').select2({ placeholder: "Please select a Status",width: '100%'});
        $('#blood_group').select2({ placeholder: "Please select a Blood Group",width: '100%'});
        $('#id_level').select2({ placeholder: "Please select a Level",width: '100%'});
    }

    $('[name="id_level"]').on('change', function(){
        if($(this).find(':selected').text() == 'area'){
            $('[name="id_area"]').parents('.form-group').removeClass('d-none');            
            $('[name="id_unit"]').val('').parents('.form-group').addClass('d-none');   
        }else if($(this).find(':selected').text() == 'unit'){
            $('[name="id_area"]').parents('.form-group').removeClass('d-none');
            $('[name="id_unit"]').val('').parents('.form-group').addClass('d-none');            
        }else{
            $('[name="id_unit"]').val('').parents('.form-group').addClass('d-none');
            $('[name="id_area"]').val('').parents('.form-group').addClass('d-none');
        }
    });
    var options = '';

    $(document).on('change', '[name="id_area"]', function(){
        var id_area = $(this).val();
        if($('[name="id_level"]').find(':selected').text() == 'unit'){
            $('[name="id_unit"]').append(options);
            $.each($('[name="id_unit"]').find('option'), function(index, element){
                if(id_area != $(this).data('area')){
                    options += '<option value="'+$(this).val()+'" data-area="'+$(this).data('area')+'">'+$(this).text()+'</option>';
                    $(this).remove();
                }
            });
            $('[name="id_unit"]').parents('.form-group').removeClass('d-none');
        };
    });



jQuery(document).ready(function() {
    initDataTable();
    getSelect2();
    initAlert();
    initCreate();
    getMenu();
});

</script>
