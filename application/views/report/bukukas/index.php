<?php 
$this->load->view('temp/HeadTop.php');
$this->load->view('temp/HeadBottom.php');
$this->load->view('temp/HeadMobile.php');
$this->load->view('temp/TopBar.php');
$this->load->view('temp/MenuBar.php');
?>

<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">								
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container ">
        <div class="kt-subheader__main">            
            <h3 class="kt-subheader__title">Report</h3>            
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>            
            <span class="kt-subheader__desc">Buku Kas</span>            
        </div>
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">                              
            </div>
        </div>
    </div>
</div>
<!-- end:: Content Head -->

 <!-- begin:: Content -->
 <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand fa fa-align-justify"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                       Data Buku Kas
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">  
                           
                    </div>      
                </div>
            </div>

        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="col-md-pull-12" >  
                <!--begin: Alerts -->   
                <div class="kt-section">
                    <div class="kt-section__content">
                        <div class="alert alert-success fade show kt-margin-r-20 kt-margin-l-20 kt-margin-t-20" role="alert" id="success_alert" style="display: none">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text" id="success_message"></div>
                            <div class="alert-close">
                                <button type="button" class="close" aria-label="Close" id="success_alert_dismiss">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                        </div>  
                         <div class="alert alert-danger fade show kt-margin-r-20 kt-margin-l-20 kt-margin-t-20" role="alert" id="failed_alert" style="display: none">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text" id="failed_message"></div>
                            <div class="alert-close">
                                <button type="button" class="close" aria-label="Close" id="failed_alert_dismiss">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                        </div>                   
                    </div>                   
                </div>        
                <!--end: Alerts -->          
            </div>

            <!--begin: Datatable -->        
            <!-- <table class="kt-datatable" id="kt_datatable" width="100%">
            </table> -->
            <!--end: Datatable -->

            <form id="form_bukukas" class="form-horizontal">
            <div class="kt-portlet__body">
            <div class="col-md-12" > 

                <div class="form-group row">
                    <label class="col-lg-1 col-form-label">Area</label>
                    <div class="col-lg-3">
                        <select class="form-control select2" name="area" id="area">
                            <option></option>
                            <?php 
                                if (!empty($areas)){
                                    foreach($areas as $row){
                                       echo "<option value=".$row->id.">".$row->area."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <label class="col-lg-1 col-form-label">Unit</label>
                    <div class="col-lg-3">
                    <select class="form-control select2" name="unit" id="unit">
                            <option></option>
                            <?php 
                                if (!empty($units)){
                                    foreach($units as $row){
                                       echo "<option value=".$row->id.">".$row->name."</option>";
                                    }
                                }
                            ?>
                            </select>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-brand btn-icon" name="btncari" id="btncari"><i class="fa fa-search"></i></button>
                    </div>
				</div>	               

            </div>

            <div class="col-md-12">
                <div class="kt-section__content">
						<table class="table">
						  	<thead class="thead-light">
						    	<tr>
						      		<th>No</th>
						      		<th>Tanggal</th>
						      		<th>Bulan</th>
						      		<th>Tahun</th>
						      		<th>Uraian</th>
						      		<th>Penerimaan Kas</th>
						      		<th>Pengeluaran Kas</th>
						      		<th>Saldo</th>
						    	</tr>
						  	</thead>
						  	<tbody>						    					    	
						  	</tbody>
						</table>
				</div>
            </div>

            </div>
            </form>

        </div>
        </div>
    </div>
    <!-- end:: Content -->
	<input type="hidden" name="url_get" id="url_get" value="<?php echo base_url('api/report/bukukas/get_transaksi_unit') ?>"/>
</div>
</div>

<?php 
$this->load->view('temp/Footer.php');
//$this->load->view('transactions/unitsdailycash/_upload.php');
// $this->load->view('datamaster/areas/_edit.php');
$this->load->view('report/bukukas/_script.php');
?>
<script>
function initCariForm(){

    var validator = $("#form_bukukas" ).validate({
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

    $('#btncari').on('click',function(){ 
        $('.rowappend').remove();
        var area = $('#area').val();
        var unit = $('#unit').val();
        //alert(area); 
        //alert(unit); 
        var url_data = $('#url_get').val() + '/' + area +'/'+ unit;
        $.get(url_data, function (data, status) {
        var response = JSON.parse(data);
        if (status = true) {
            //console.log(response);
            var currentSaldo = 0;
            var TotSaldoIn = 0;
            var TotSaldoOut = 0;
            for (var i = 0; i < response.data.length; i++) {
                var date = moment(response.data[i].date).format('DD-MM-YYYY');
                var month = moment(response.data[i].date).format('MMMM');
                var year = moment(response.data[i].date).format('YYYY');
                var cashin=0;
                var cashout=0;
                if(response.data[i].type=='CASH_IN'){cashin= response.data[i].amount; currentSaldo +=  parseInt(response.data[i].amount); TotSaldoIn +=  parseInt(response.data[i].amount);}
                if(response.data[i].type=='CASH_OUT'){cashout= response.data[i].amount; currentSaldo -=  parseInt(response.data[i].amount); TotSaldoOut +=  parseInt(response.data[i].amount);}
                var newData = '<tr class="rowappend">';
                newData +='<td></td>';
                newData +='<td>'+date+'</td>';
                newData +='<td>'+month+'</td>';
                newData +='<td>'+year+'</td>';
                newData +='<td>'+response.data[i].description+'</td>';
                newData +='<td>'+cashin+'</td>';
                newData +='<td>'+cashout+'</td>';
                newData +='<td>'+currentSaldo+'</td>';
                newData +='</tr>';
                $('.kt-section__content table').append(newData);
            }

            var newData = '<tr class="rowappend">';
                newData +='<td></td>';
                newData +='<td></td>';
                newData +='<td></td>';
                newData +='<td></td>';
                newData +='<td></td>';
                newData +='<td>'+TotSaldoIn+'</td>';
                newData +='<td>'+TotSaldoOut+'</td>';
                newData +='<td>'+currentSaldo+'</td>';
                newData +='</tr>';
                $('.kt-section__content table').append(newData);
        }
        });
    });

    return {
        validator:validator
    }

}



jQuery(document).ready(function() { 
    // $('#area').select2({
    //     placeholder: "Please select a area",
    //     width: '100%'
    // });
    // $('#unit').select2({
    //     placeholder: "Please select a Unit",
    //     width: '100%'
    // });

    //initCariForm();

});
</script>
