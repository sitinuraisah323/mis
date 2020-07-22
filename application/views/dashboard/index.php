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
				<div href="" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Dashboard Overview" data-placement="left">
                        <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
                        <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date('M'); ?> <?php echo date('d'); ?></span>
                        <i class="flaticon2-calendar-1"></i>
                </div>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	 <!-- begin:: Content -->
     <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Booking Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                                Graph performance each unit of nasional booking
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:250px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>

			<div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_outstanding" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">                
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Outstanding Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
							Graph performance each unit of nasional outstanding
                            </span>

                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div id="graphOutstanding" style="height:300px;"></div>                           
                        </div>
                    </div>
                </div>	        
                </form>	        
                <!--end:: Widgets-->    
            </div>

        </div>
     </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                DPD Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
							Graph performance each unit of nasional DPD
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;">
                            <canvas  id="kt_chart_daily_sales"></canvas>
                        </div>
                    </div>
                </div>	        
                <!--end:: Widgets-->    
            </div>
			<div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Saldo Kas Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
							Graph performance each unit of nasional saldo
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
            <div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_pencairan" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pencairan Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
							Graph performance each unit of nasional pencairan
                            </span>
                        </div>                        
                        <div class="kt-widget11">
                            <div id="graphPencairan" style="height:300px;"></div>                           
                        </div>                        
                    </div>
                </div>	   
                </form>     
                <!--end:: Widgets-->    
            </div>
			<div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_pelunasan" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pelunasan Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
							Graph performance each unit of nasional payment
                            </span>
                        </div>
                        <div class="kt-widget11">
                            <div id="graphPelunasan" style="height:300px;"></div>                           
                        </div>   
                    </div>
                </div>	        
                </form>	        
                <!--end:: Widgets-->    
            </div>
        </div>
    </div>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_pengeluaran" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pengeluaran Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
							Graph performance each unit of nasional cash out
                            </span>
                        </div>
                        <div class="kt-widget11">
                            <div id="graphPengeluaran" style="height:300px;"></div>                           
                        </div>
                    </div>
                </div>	        
                </form>	        
                <!--end:: Widgets-->    
            </div>
			<div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_pendapatan" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                Pendapatan Nasional             
                            </h3>
                            <span class="kt-widget14__desc">
                            Graph performance each unit of nasional cash in
                            </span>
                        </div>
                        <div class="kt-widget11">
                            <div id="graphPendapatan" style="height:300px;"></div>                           
                        </div>
                    </div>
                </div>	        
                </form>	        
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
