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
            <span class="kt-subheader__desc">Transaski Selisih</span>
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
                       Data Transaski Selisih
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

            <form id="form_bukukas" class="form-horizontal" method="post" action="<?php echo base_url("report/Customermis/export"); ?>">
            <div class="kt-portlet__body">
            <div class="col-md-12" >
                <div class="form-group row">
                <div class="col-lg-2">
                    <label class="col-form-label">Year</label>
                    <select name="year" class="form-control">
                        <?php for($year = date('Y'); $year>=2000; $year--):?>
                            <option value="<?php echo $year;?>"><?php echo $year;?></option>
                        <?php endfor;?>
                    </select>
                </div>
                <div class="col-lg-1">
                    <label class="col-form-label">Month</label>
                    <select name="month" class="form-control">
                        <?php for($i = 1; $i<=12;$i++):?>
                            <option value="<?php echo $i;?>"
                            <?php echo date('n') == $i ? 'selected' : ''?>
                            ><?php echo $i;?></option>
                        <?php endfor;?>
                    </select>
                </div>
                <?php if($this->session->userdata('user')->level == 'unit'):?>
                    <input type="hidden" name="id_unit" value="<?php echo $this->session->userdata('user')->id_unit;?>">
                <?php elseif($this->session->userdata('user')->level == 'area'):?>
                    <input type="hidden" name="area" value="<?php echo $this->session->userdata('user')->id_area;?>">
                    <div class="col-lg-2">
						<label class="col-form-label">Unit</label>
						<select class="form-control select2" name="id_unit" id="unit">
							<option value="0">All</option>
						</select>
                    </div>
                <?php elseif($this->session->userdata('user')->level == 'cabang'):?>
                    <input type="hidden" name="cabang" value="<?php echo $this->session->userdata('user')->id_cabang;?>">
                    <div class="col-lg-2">
                    <label class="col-form-label">Unit</label>
                        <select class="form-control select2" name="id_unit" id="unit">
                            <option value="0">All</option>
                        </select>
                    </div>
                <?php else:?>
                    <div class="col-lg-2">
						<label class="col-form-label">Area</label>
                        <select class="form-control select2" name="area" id="area">
                            <option value="0" selected>All</option>
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
                    <div class="col-lg-2">
						<label class="col-form-label">Unit</label>
						<select class="form-control select2" name="id_unit" id="unit">
							<option value="0">All</option>
						</select>
                    </div>
                <?php endif ;?>
					<div class="col-lg-2">
						<label class="col-form-label">Permit</label>
                        <select class="form-control select2" name="permit" id="permit">
                            <option value="OJK">OJK</option>
                            <option value="NON OJK">Non OJK</option>
                            <option value="OJK-1">New OJK</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
						<label class="col-form-label">Type</label>
                        <select class="form-control select2" name="type" id="type">
                            <option value="CASH">Ada dibuku kas tidak ada di transaksi</option>
                            <option value="REGULER">Ada ditransaksi tidak ada dibuku kas</option>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <label class="col-form-label">&nbsp</label>
                        <div class="position-relative">
                        <button type="button" class="btn btn-brand btn-icon" name="btncari" id="btncari"><i class="fa fa-search"></i></button>
                        <!-- <button type="submit" class="btn btn-danger btn-icon" name="btnexport_csv" id="btnexport_csv"><i class="fa fa-file-excel"></i></button> -->
                        </div>
                    </div>   
				</div>

            </div>

            <div class="col-md-12">
                <div class="kt-section__content">
						<table class="table" id="tbl1">
						  	<thead class="thead-light">
						    	<tr id="type-transaction" class="d-none">
						      		<th class="text-center">No</th>
									<th class="text-center">Unit</th>
									<th class="text-center">No SGE</th>
									<th class="text-center">Tanggal SBK</th>
									<th class="text-center">Tanggal Tempo</th>					      		
									<th class="text-center">Sewa Modal</th>
									<th class='text-right'>Taksiran</th>
									<th class='text-right'>Admin</th>
									<th class='text-right'>UP</th>
									<th class='text-right'>Status</th>
						    	</tr>
                                <tr id="type-cash" class="d-none"> 
						      		<th class="text-center">No</th>
									<th class="text-center">Unit</th>
									<th class="text-center">No Perk</th>
									<th class="text-center">Tanggal</th>
									<th class="text-center">Dekripsi</th>					      		
									<th class="text-center">Jumlah</th>
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
	<input type="hidden" name="url_get_unit" id="url_get_unit" value="<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>
    <input type="hidden" name="url_get_units" id="url_get_units" value="<?php echo base_url('api/datamaster/units/get_unit_bycabang') ?>"/>
</div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('report/transactionmiss/_edit.php');
$this->load->view('report/transactionmiss/_script.php');
?>