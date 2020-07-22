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
				<h3 class="kt-subheader__title">Dashboard</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				<span class="kt-subheader__desc">Executive Summary</span>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	 <!-- begin:: Content -->
    
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">	
            <!--begin::Portlet-->
                <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Filtering Executive Summary
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-group">
                                <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-angle-down"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <div class="col-md-12" >
                                <div class="form-group row">
                                    <label class="col-form-label">Area</label>
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

                                    <label class="col-form-label">Transaksi</label>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" name="transaksi" id="transaksi">
                                            <option></option>
                                            <?php foreach(array(
                                                'OUTSTANDING'   => 'Outstanding',
                                                'PENCAIRAN'   => 'Pencairan',
                                                'PELUNASAN'   => 'Pelunasan',
                                                'PENDAPATAN'   => 'Pendapatan',
                                                'PENGELUARAN'   => 'Pengeluaran',
                                                'SALDOKAS'   => 'Saldo Kas',
                                            ) as $value => $show):?>	
                                            <option value="<?php echo $value;?>"><?php echo $show;?></option>
                                            <?php endforeach?>
                                                
                                        </select>
                                    </div>

                                    <label class="col-form-label">Tanggal</label>
                                    <div class="col-lg-2">
                                        <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <button type="button" class="btn btn-brand btn-icon" name="btncari" id="btncari"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end begin::Portlet-->
            </div>
        </div>
    </div>

    <form id="form_graph" class="form-horizontal">
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Nasional graph            
                            </h3>
                            <span class="kt-widget14__desc">
                                Graph performance each unit
                            </span>
                        </div>
                        <div class="kt-widget11">
                            <div id="graph" style="height:300px;"></div>
                        </div>
                    </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>			
        </div>
     </div>
     </form>
	 
		<!-- end:: Content -->
		<input type="hidden" name="url_get" id="url_get" value="<?php echo base_url('api/report/bukukas/get_transaksi_unit') ?>"/>
		<input type="hidden" name="url_get_unit" id="url_get_unit" value="<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>
	</div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('dashboard/summary/_script.php');
?>
