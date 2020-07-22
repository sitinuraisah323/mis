<script>
//globals
var datatable;
var AlertUtil;
var createForm;
var editForm;

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
                    url : "<?php echo base_url("api/datamaster/bookcash/delete/"); ?>"+targetId,
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
            url : "<?php echo base_url("api/datamaster/bookcash/show/"); ?>"+targetId,
            dataType : "json",
            success : function(response,status){
              	$('.append').find('.form-group').remove();
              	$('.modal-title').text(response.data.unit_name);
              	var total = 0;
              	$.each(response.data.detail, function (index,data) {
              		total += data.summary * data.amount;
					$('.append').append('<div class="form-group"><label>'+data.read+'</label><span class="form-control">'+data.summary+'</span></div>');
				});
				$('.append').append('<div class="form-group"><label>Total</label><span class="form-control">'+total+'</span></div>');
				KTApp.unblockPage();
			},
            error: function (jqXHR, textStatus, errorThrown){
                KTApp.unblockPage();
                AlertUtil.showFailed("Cannot communicate with server please check your internet connection");
            },
			complete:function () {
				$('#modal_add').modal('show');
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
                url: '<?php echo base_url("api/datamaster/bookcash"); ?>',
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
                field: 'unit_name',
                title: 'Nama Unit',
                sortable: 'asc',
                textAlign: 'left',
            },
            {
                field: 'timestamp',
                title: 'Tanggal Diinput',
                sortable: 'asc',
                textAlign: 'left',
            },
			  {
				  field: 'total',
				  title: 'Total',
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
						result = result + '<span data-id="' + row.id + '" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn_edit" title="View" ><i class="flaticon-eye" style="cursor:pointer;"></i></span>';
						result = result + '<a data-id="' + row.id + '" href="<?php echo base_url('datamaster/bookcash/form/');?>'+row.id+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit" ><i class="flaticon-edit-1" style="cursor:pointer;"></i></a>';
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


    //events
    $("#input-form").on("submit",function(e){
    	e.preventDefault();
    	var id = $('[name="id"]').val();
    	var url;
    	if(id){
    		url = "<?php echo base_url("api/datamaster/bookcash/update"); ?>";
		}else{
    		url = "<?php echo base_url("api/datamaster/bookcash/insert"); ?>";
		}
        $.ajax({
            type : 'POST',
            url : url,
            data : $(this).serialize(),
            dataType : "json",
            success : function(data,status){
				$('#modal_add').find('[name="id"]').val("");
				$('#modal_add').find('[name="level"]').val("");
                KTApp.unblock('#modal_add .modal-content');
                if(data.status == true){
                    datatable.reload();
                    $('#modal_add').modal('hide');
                    AlertUtil.showSuccess(data.message,5000);
                }else{
                    AlertUtil.showFailedDialogAdd(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                KTApp.unblock('#modal_add .modal-content');
                AlertUtil.showFailedDialogAdd("Cannot communicate with server please check your internet connection");
            }
        });
    });



jQuery(document).ready(function() {
    initDataTable();
    initAlert();
});

</script>
