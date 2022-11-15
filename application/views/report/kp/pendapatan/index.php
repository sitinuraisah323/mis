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
            <span class="kt-subheader__desc">Pendapatan</span>
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
                       Data  Pendapatan
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

				<form id="form_bukukas" class="form-horizontal" method="post" action="<?php echo base_url("gcore/pendapatan/export"); ?>">
				<div class="kt-portlet__body">
				<div class="col-md-12" >
					<div class="form-group row">
						
						<input type = 'hidden' name = 'level' id = 'level' value = "<?php echo $this->session->userdata('user')->level;?>">
						
						<?php if ( $this->session->userdata( 'user' )->level == 'unit' ):?>
						<input type = 'hidden' name = 'area_id' id='area_id' value = "<?php echo $this->session->userdata('user')->area_Id;?>">
						<input type = 'hidden' name = 'branch_id' id='branch_id' value = "<?php echo $this->session->userdata('user')->branchId;?>">
						
						<input type = 'hidden' name = 'unit_id' id = 'unit_id' value = "<?php echo $this->session->userdata('user')->office_id;?>">
						<?php elseif ( $this->session->userdata( 'user' )->level == 'kasir' ):?>
						<input type = 'hidden' name = 'area_id' id='area_id' value = "<?php echo $this->session->userdata('user')->area_Id;?>">
						<input type = 'hidden' name = 'branch_id' id='branch_id' value = "<?php echo $this->session->userdata('user')->branchId;?>">
		
						<input type = 'hidden' name = 'unit_id' id = 'unit_id' value = "<?php echo $this->session->userdata('user')->office_id;?>">
						
						<?php elseif ( $this->session->userdata( 'user' )->level == 'area' ):?>
						<input type = 'hidden' name = 'area_id' id='area_id' value = "<?php echo $this->session->userdata('user')->area_id;?>">

						<div class="col-md-2">
							<label class="col-form-label">Branch</label>
							<select class="form-control" name="branch_id" id="branch_id">
							</select>
						</div>
						<div class="col-md-2">
							<label class="col-form-label">Unit</label>
							<select class="form-control" name="unit_id" id="unit_id">
							</select>
						</div>
						<?php elseif ( $this->session->userdata( 'user' )->level == 'cabang' ):?>
						<input type = 'hidden' name = 'area_id' id='area_id' value = "<?php echo $this->session->userdata('user')->areaId;?>">
						<input type = 'hidden' name = 'branch_id' id='branch_id' value = "<?php echo $this->session->userdata('user')->branch_id;?>">
						<div class="col-md-2">
							<label class="col-form-label">Unit</label>
							<select class="form-control" name="unit_id" id="unit_id">
							</select>
						</div>
						<?php else:?>
						<div class="col-md-2">
							<label class="col-form-label">Area</label>
							<select class="form-control" name="area_id" id="area_id">
                        <!--<option value = 'all'>All</option>-->
                        <?php
                        // if ( !empty( $areas ) ) {
                        //     foreach ( $areas as $row ) {
                        //         echo '<option value='.$row->id.'>'.$row->area.'</option>';
                        //     }
                        // }
                        // ?>
                        </select>
						</div>
						
						
						<div class="col-md-2">
							<label class="col-form-label">Branch</label>
							<select class="form-control" name="branch_id" id="branch_id">
							     <!--<option value = 'all'>All</option>-->
							</select>
						</div>
						<div class="col-md-2">
							<label class="col-form-label">Unit</label>
							<select class="form-control" name="unit_id" id="unit_id">
							     <!--<option value = 'all'>All</option>-->
							</select>
						</div>
						<?php endif ;
						?>

						<div class="col-md-2">
							<label class="col-form-label">Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                            <option value="all">All</option>
                            <option value="Admin">Admin</option>
                            <option value="Sewa">Sewa Modal</option>
                            <option value="Denda">Denda</option>								
                            <option value="Lainnya">Pendapatan Lainnya</option>
                            <!-- <option value="Gadai Cicilan">Gadai Cicilan</option> -->
                        </select>

                    </div>
					<div class="col-lg-2">
						<label class="col-form-label">Dari</label>
						<input type="date" class="form-control" name="date-start" value="<?php echo date('Y-m-01');?>"> 
					</div>
					<div class="col-lg-2">
						<label class="col-form-label">Sampai dengan</label>
						<input type="date" class="form-control" name="date-end" value="<?php echo date('Y-m-d');?>">
					</div>
                    <!-- <div class="col-lg-2">
						<label class="col-form-label">Buket</label>
                        <select name="packet" class="form-control">
                                <option value="all">All</option>
                                <option value="120-135">1.DPD 1 - 15</option>
                                <option value="136-150">2.DPD 16-30 </option>
                                <option value=">150">3.DPD 30++</option>
                                <option value="-7">4.-7 DPD</option>
                                <option value="-10">5.-10 DPD</option>
                        </select>
                	</div> -->
					<div class="col-lg-1">
						<button type="button" class="btn btn-brand btn-icon" name="btncari" id="btncari"><i class="fa fa-search"></i></button>
                        <button type="submit" class="btn btn-danger btn-icon" name="btnexport_csv" id="btnexport_csv"><i class="fa fa-file-excel"></i></button>
                        
					</div>

				</div>
				</form>

				<div class="col-md-12">
                <div class="kt-section__content table-responsive">
						<table class="table">
						  	<thead class="thead-light">
						    	<tr>
						      		<th class="text-center">No</th>
									<th class="text-center">Unit</th>
									
									<th class="text-center">Tanggal</th>
									<th class="text-center">Bulan</th>
									<th class="text-center">Tahun</th>					
									<th class='text-right'>Uraian</th>
									<th class="text-right">Jumlah</th>
									
						    	</tr>
						  	</thead>
						  	<tbody>
						  	</tbody>
						</table>
				</div>
            </div>

				</div>

			</div>
			</div>
		</div>
		<!-- end:: Content -->
		<input type="hidden" name="url_get" id="url_get" value="<?php echo base_url('api/report/bukukas/get_transaksi_unit') ?>"/>
		<input type="hidden" name="url_get_units" id="url_get_units" value="<?php echo base_url('api/datamaster/units/get_unit_bycabang') ?>"/>
		<input type="hidden" name="url_get_unit" id="url_get_unit" value="<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>
	</div>
</div>


<?php
$this->load->view('temp/Footer.php');

$this->load->view('report/kp/pendapatan/viewCicilan.php');
$this->load->view('report/kp/pendapatan/script.php');

?>
