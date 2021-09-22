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
            <h3 class="kt-subheader__title">Data Master</h3>            
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>            
            <span class="kt-subheader__desc">Stocks</span>
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
                        Stocks
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">  
                            <button type="button" class="btn btn-brand btn-icon-sm" onclick="showModal()">
                                <i class="flaticon2-plus"></i> Buat Baru     
                            </button>                             
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
                <!--begin: Search Form -->
                <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-l-20 kt-margin-r-20  kt-margin-b-10">
                    <form class="row align-items-center" action="<?php echo base_url('datamaster/stocks/excel');?>" method="post" >
                        <div class="col-md-2">
                            <label for="general" class="col-form-label">Cari</label>
                            <input type="text" class="form-control" id="generalSearch" name="generalSearch">
                        </div>    
                        <?php if($this->session->userdata('user')->level == 'unit'):?>
                            <input type="hidden" name="id_unit" value="<?php echo $this->session->userdata('user')->id_unit;?>">
                        <?php elseif($this->session->userdata('user')->level == 'area'):?>
                            <input type="hidden" name="area" value="<?php echo $this->session->userdata('user')->id_area;?>">
                            <div class="col-md-2">
                                <label class="col-form-label">Unit</label>
                                <select class="form-control select2" name="id_unit" id="unit">
                                    <option value="0">All</option>
                                </select>
                            </div>
                        <?php elseif($this->session->userdata('user')->level == 'cabang'):?>
                            <input type="hidden" name="cabang" value="<?php echo $this->session->userdata('user')->id_cabang;?>">
                             <div class="col-md-2">
                                <label class="col-form-label">Unit</label>
                                <select class="form-control select2" name="id_unit" id="unit">
                                    <option value="0">All</option>
                                </select>
                            </div>
                        <?php else:?>
                            <div class="col-md-2">
                                <label class="col-form-label">Area</label>
                                <select class="form-control select2" name="area" id="area">
                                    <option value="0">All</option>
                                    <?php
                                        if (!empty($areas)){
                                            foreach($areas as $row){
                                            echo "<option value=".$row->id.">".$row->area."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Unit</label>
                                <select class="form-control select2" name="id_unit" id="unit">
                                    <option value="0">All</option>
                                </select>
                            </div>
                        <?php endif ;?>  
                        <div class="col-md-2">
                        <label class="col-form-label">Tanggal</label>					
                            <input type="date" class="form-control" name="date_start" id="date_start" >
                        </div>
                        <div class="col-md-2">
                        <label class="col-form-label">Sampai</label>
                            <input type="date" class="form-control" name="date_end" id="date_end" >
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info"><i class="fas fa-file-excel"></i></button>
                        </div>
                    </form>
                </div>      
                <!--end: Search Form -->
            </div>
            <input type="hidden" name="url_get" id="url_get" value="<?php echo base_url('api/report/bukukas/get_transaksi_unit') ?>"/>
    <input type="hidden" name="url_get_units" id="url_get_units" value="<?php echo base_url('api/datamaster/units/get_unit_bycabang') ?>"/>
	<input type="hidden" name="url_get_unit" id="url_get_unit" value="<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>

            <?php //print_r($areas); ?>
            <!--begin: Datatable -->        
            <table class="kt-datatable" id="kt_datatable" width="100%">
            </table>
            <!--end: Datatable -->
        </div>
        </div>
    </div>
    <!-- end:: Content -->
	
</div>
</div>

<?php 
$this->load->view('datamaster/stocks/_add.php');
$this->load->view('temp/Footer.php');
$this->load->view('datamaster/stocks/_script.php');
?>
