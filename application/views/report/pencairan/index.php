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
            <span class="kt-subheader__desc">Pencairan</span>            
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
                       Data Pencairan
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
                    <div class="col-lg-2">
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
                    <div class="col-lg-2">
                    <select class="form-control select2" name="unit" id="unit">
                            <option></option>
                            </select>
                    </div>
                    <label class="col-lg-1 col-form-label">Tanggal</label>
					<div class="col-lg-2">
						<input type="date" class="form-control" name="date-start" value="<?php echo date('Y-m-d');?>">
					</div>
					<div class="col-lg-2">
						<input type="date" class="form-control" name="date-end" value="<?php echo date('Y-m-d');?>">
					</div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-brand btn-icon" name="btncari" id="btncari"><i class="fa fa-search"></i></button>
                    </div>
				</div>	               

            </div>

            <div class="col-md-12">
                <div class="kt-section__content">
						<table class="table" id="tblpencairan">
						  	<thead class="thead-light">
						    	<tr>
						      		<th class="text-center">No</th>
						      		<th>Area</th>
						      		<th>Unit</th>						      	
						      		<th class="text-center">Jan</th>
						      		<th class="text-center">Feb</th>
						      		<th class="text-center">Mar</th>
						      		<th class="text-center">Apr</th>
						      		<th class="text-center">Mei</th>
						      		<th class="text-center">Jun</th>
						      		<th class="text-center">Jul</th>
						      		<th class="text-center">Aug</th>
						      		<th class="text-center">Sep</th>
						      		<th class="text-center">Okt</th>
						      		<th class="text-center">Nov</th>
						      		<th class="text-center">Des</th>
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
	<input type="hidden" name="url_get_unit" id="url_get_unit" value="<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>
</div>
</div>

<?php 
$this->load->view('temp/Footer.php');
$this->load->view('report/pelunasan/_script.php');
?>