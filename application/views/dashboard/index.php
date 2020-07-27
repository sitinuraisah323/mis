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
                        <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Last Day</span>&nbsp;
                        <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date('M'); ?> <?php echo  date('d', strtotime('-1 days', strtotime(date('Y-m-d')))); ?></span>
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
                <form id="form_disburse" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
							<div class="row">
								<div class="col-md-6">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i> Booking Nasional
									</h3>
									<span class="kt-widget14__desc">
                           		     Graph performance unit of nasional booking
                            		</span>
								</div>
								<div class="col-md-6">
									<span class="kt-widget14__desc">
										<span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
										<span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div>
							</div>
                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div id="graphDisburse" style="height:300px;"></div>                           
                        </div>
                    </div>
                </div>	        
                </form>	        
                <!--end:: Widgets-->    
            </div>

			<div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_outstanding" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">                
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
							<div class="row">
								<div class="col-md-6">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i> Outstanding Nasional
									</h3>
									<span class="kt-widget14__desc">
										Graph performance unit of nasional outstanding
									</span>
								</div>
								<div class="col-md-6">
									<span class="kt-widget14__desc">
										<span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
										<span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div>
							</div>
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
                <form id="form_dpd" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <div class="row">
								<div class="col-md-6">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i>  Day Past Due(DPD) Nasional 
									</h3>
									<span class="kt-widget14__desc">
                                    Graph performance each unit of nasional day past due(DPD)
									</span>
								</div>
								<div class="col-md-6">
									<span class="kt-widget14__desc">
                                    <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
                                    <span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div>
							</div>                           
                        </div>
                        <div class="kt-widget11">
                                <div id="graphDPD" style="height:300px;"></div>                           
                        </div>
                    </div>
                </div>	        
                </form>	        
                <!--end:: Widgets-->    
            </div>
			<div class="col-xl-6 col-lg-6">
                <!--begin:: Widgets-->
                <form id="form_saldo" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header kt-margin-b-30">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="kt-widget14__title">
                                            <i class="fa fa-chart-bar"></i>  Saldo Kas Nasional 
                                        </h3>
                                        <span class="kt-widget14__desc">
                                        Graph performance each unit of nasional saldo kas
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="kt-widget14__desc">
                                        <span class="date-today"></span> <span class="total-today"></span>
                                        </span>
                                        <hr>
                                        <span class="kt-widget14__desc">
                                        <span class="date-yesterday"></span> <span class="total-yesterday"></span>
                                        </span>
                                    </div>
                                </div>                                
                            </div>
                            <div class="kt-widget11">
                                <div id="graphSaldo" style="height:300px;"></div>                           
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
                <form id="form_pencairan" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                            <i class="fa fa-chart-bar"></i> Pencairan Nasional             
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
                            <i class="fa fa-chart-bar"></i> Pelunasan Nasional             
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
                            <i class="fa fa-chart-bar"></i> Pengeluaran Nasional             
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
                            <i class="fa fa-chart-bar"></i>  Pendapatan Nasional             
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
