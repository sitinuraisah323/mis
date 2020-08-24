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
                <?php if( date('H:i') > '20:00'){ ?>
                    <div href="" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Dashboard Overview" data-placement="left">
                        <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">To Day Transaction :</span>&nbsp;
                        <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date("l \of F d, Y");?></span>
                        <i class="flaticon2-calendar-1"></i>
                    </div>
                <?php }else{ ?>
                    <div href="" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Dashboard Overview" data-placement="left">
                        <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Last Day Transaction : </span>&nbsp;
                        <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php //echo date("l \of F Y H:i:s"); echo date('L M'); ?> <?php echo date('l \of F d, Y', strtotime('-1 days', strtotime(date('Y-m-d')))); ?></span>
                        <i class="flaticon2-calendar-1"></i>
                    </div>
                <?php }?>				
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content Head -->

	 <!-- begin:: Content -->
     <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            
            <div class="col-xl-6 col-lg-6">
            <input type="hidden" name="disbursmax" id="disbursmax">

                <!--begin:: Widgets-->
                <form id="form_disburse" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
							<div class="row">
								<div class="col-md-12">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i> Booking Nasional
                                        <hr/>
									</h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <!-- <span class="kt-widget14__bullet kt-bg-warning"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span> -->
                                        </div>
                                    </div>
									
								</div>
								<!-- <div class="col-md-6">
									<span class="kt-widget14__desc">
										Total Booking <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
										Total Booking <span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div> -->
							</div>
                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div id="graphDisburse" style="height:300px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingOne3Disburse">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne3Disburse" aria-expanded="true" aria-controls="collapseOne3Disburse">
                                        Jawa Barat
                                    </div>
                                </div>
                                <div id="collapseOne3Disburse" class="collapse" aria-labelledby="headingOne3Disburse" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblDisburseJabar">                                       
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo3Disburse">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo3Disburse" aria-expanded="false" aria-controls="collapseTwo3Disburse">
                                        Jawa Timur
                                    </div>
                                </div>
                                <div id="collapseTwo3Disburse" class="collapse" aria-labelledby="headingTwo3Disburse" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblDisburseJatim">                                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree3Disburse">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree3Disburse" aria-expanded="false" aria-controls="collapseThree3Disburse">
                                        NTB
                                    </div>
                                </div>
                                <div id="collapseThree3Disburse" class="collapse" aria-labelledby="headingThree3Disburse" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblDisburseNTB">                                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour4Disburse">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFour4Disburse" aria-expanded="false" aria-controls="collapseFour4Disburse">
                                        NTT
                                    </div>
                                </div>
                                <div id="collapseFour4Disburse" class="collapse" aria-labelledby="headingFour4Disburse" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblDisburseNTT">                                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion--> 
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
								<div class="col-md-12">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i> Outstanding Nasional
                                        <hr/>
									</h3>									
                                        <div class="kt-widget14__legends">
                                            <div class="kt-widget14__legend">
                                                <span class="kt-widget14__bullet kt-bg-info"></span>
                                                <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                                <span class="kt-widget14__bullet kt-bg-warning"></span>
                                                <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
                                            </div>
                                        </div>									
								</div>
								<!-- <div class="col-md-6">
									<span class="kt-widget14__desc">
										Os Nasional <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
										Os Nasional <span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div> -->
							</div>
                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div id="graphOutstanding" style="height:300px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingOne3">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                                        Jawa Barat
                                    </div>
                                </div>
                                <div id="collapseOne3" class="collapse" aria-labelledby="headingOne3" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblOutJabar">                                       
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo3">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                                        Jawa Timur
                                    </div>
                                </div>
                                <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo3" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblOutJatim">                                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree3">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                                        NTB
                                    </div>
                                </div>
                                <div id="collapseThree3" class="collapse" aria-labelledby="headingThree3" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblOutNTB">                                       
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour4">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseFour4" aria-expanded="false" aria-controls="collapseFour4">
                                        NTT
                                    </div>
                                </div>
                                <div id="collapseFour4" class="collapse" aria-labelledby="headingFour4" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblOutNTT">                                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion--> 
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
                                <div class="col-md-12">
                                    <h3 class="kt-widget14__title">
                                    <i class="fa fa-chart-bar"></i> Day Past Due(DPD) Nasional  
                                    <hr/>           
                                    </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                        <span class="kt-widget14__desc">
                                            DPD Nasional <span class="date-today"></span> <span class="total-today"></span>
                                        </span>
                                        <hr>
                                </div> -->
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
                <form id="form_pencairan" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">                           
                            <div class="row">
                                <div class="col-md-12">
                                   <h3 class="kt-widget14__title">
                                        <i class="fa fa-chart-bar"></i> Pencairan Gadai Reguler   
                                        <hr/>          
                                    </h3>
                                        <div class="kt-widget14__legends">
                                            <div class="kt-widget14__legend">
                                                <span class="kt-widget14__bullet kt-bg-info"></span>
                                                <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                                <span class="kt-widget14__bullet kt-bg-warning"></span>
                                                <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
                                            </div>
                                        </div>	
                                </div>
                                 <!-- <div class="col-md-6">
									<span class="kt-widget14__desc">
										Gadai Reguler <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
                                        Gadai Reguler <span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div> -->
                            </div>
                        </div>                        
                        <div class="kt-widget11">
                            <div id="graphPencairan" style="height:300px;"></div>                           
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
                <form id="form_pelunasan" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <div class="row">
                                <div class="col-md-12">
                                <h3 class="kt-widget14__title">
                                   <i class="fa fa-chart-bar"></i> Pelunasan   
                                   <hr/>          
                                </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-warning"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
                                        </div>
                                    </div>	
                                </div>
                                <!-- <div class="col-md-6">
									<span class="kt-widget14__desc">
										Pelunasan <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
									<span class="kt-widget14__desc">
                                        Pelunasan <span class="date-yesterday"></span> <span class="total-yesterday"></span>
									</span>
								</div> -->
                            </div>
                        </div>
                        <div class="kt-widget11">
                            <div id="graphPelunasan" style="height:300px;"></div>                           
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
                                <div class="col-md-12">
                                    <h3 class="kt-widget14__title">
                                    <i class="fa fa-chart-bar"></i> Saldo Kas Nasional  
                                    <hr/>           
                                    </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
									<span class="kt-widget14__desc">
										Total Saldo <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
								</div> -->
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
                <form id="form_pengeluaran" class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-widget14__header kt-margin-b-30">
                                <h3 class="kt-widget14__title">
                                <i class="fa fa-chart-bar"></i> Pengeluaran 
                                    <hr/>            
                                </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><?php  echo date('F'); ?> : <span class="total-today"></span></span>
                                        </div>
                                    </div>	
                            </div>                       
                        </div>
                        <!-- <div class="col-md-6">
                            <span class="kt-widget14__desc">
                                Pengeluaran <?php  echo date('F'); ?> <span class="total-today"></span>
                            </span>
                            <hr>
                        </div> -->
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
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="kt-widget14__header kt-margin-b-30">
                                    <h3 class="kt-widget14__title">
                                         <i class="fa fa-chart-bar"></i>  Pendapatan  
                                         <hr/>           
                                    </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><?php  echo date('F'); ?> : <span class="total-today"></span></span>
                                        </div>
                                    </div>
                                </div>                           
                            </div>
                            <!-- <div class="col-md-6">
                                <span class="kt-widget14__desc">
                                    Pendapatan <?php  //echo date('F'); ?> <span class="date-today"></span> <span class="total-today"></span>
                                </span>
                                <hr>
                           </div>                            -->
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
