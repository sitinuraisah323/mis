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
				<span class="kt-subheader__desc">GHA</span>
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
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Booking Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Booking Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Outstanding Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Outstanding Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                DPD Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                DPD Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pencairan Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Pencairan Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pelunasan Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Pelunasan Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pengeluaran Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Pengeluaran Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pendapatan Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                            Pendapatan Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Saldo Kas Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Saldo Kas Nasional <?php echo date('d-m-Y'); ?>
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

	<!-- end:: Content -->

	</div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('dashboard/_script.php');
?>
