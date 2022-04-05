<?php
$this->load->view('temp/HeadTop.php');
$this->load->view('temp/HeadBottom.php');
$this->load->view('temp/HeadMobile.php');
$this->load->view('temp/TopBar.php');
$this->load->view('temp/MenuBar.php');
$currmonth = date('Y-m-d');
?>

<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
	<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<!-- begin:: Content Head -->
	<div class="kt-subheader   kt-grid__item" id="kt_subheader">
		<div class="kt-container ">
			<div class="kt-subheader__main">
				<h3 class="kt-subheader__title">Dashboard</h3>
				<span class="kt-subheader__separator kt-subheader__separator--v"></span>
				<span class="kt-subheader__desc">GHA Nasional <input type="hidden" name="permit" id="permit" value="<?php echo $permit; ?>"/></span>
			</div>
			<div class="kt-subheader__toolbar">
				<div class="kt-subheader__wrapper">
                <?php if( date('H:i') > '20:00'){ $currmonth =  date('F', strtotime($currmonth));?>
                    <div href="" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Dashboard Overview" data-placement="left">
                        <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">To Day Transaction :</span>&nbsp;
                        <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date("l \of F d, Y");?></span>
                        <i class="flaticon2-calendar-1"></i>
                    </div>
                <?php }else{ $currmonth = date('F', strtotime('-1 days', strtotime($currmonth)));?>
                    <div href="" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Dashboard Overview" data-placement="left">
                        <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Last Day Transaction : </span>&nbsp;
                        <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date"><?php echo date('l \of F d, Y', strtotime('-1 days', strtotime(date('Y-m-d')))); ?></span>
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
                <!--begin:: Widgets-->
                <form class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">                
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
							<div class="row">
								<div class="col-md-12">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i>  <?php echo $bulan[0]; ?>
                                        <i class="fa fa-eye pull-right" ></i>
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
							</div>
                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingOne3">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                                      <a href="<?php echo base_url('dashboards/januari'); ?>">  31 <?php echo $bulan[ 0 ]; ?> 2021 </a> 
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingOne3" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblOut">                                       
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">                
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
							<div class="row">
								<div class="col-md-12">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i>  <?php echo $bulan[1]; ?>
                                        <i class="fa fa-eye pull-right" ></i>
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
							</div>
                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3cc">
                            <div class="card">
                                <div class="card-header" id="headingOne3cc">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne3cc" aria-expanded="true" aria-controls="collapseOne3cc">
                                      <a href="<?php echo base_url('dashboards/februari'); ?>">  28 <?php echo $bulan[ 1 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div class="collapse" aria-labelledby="headingOne3cc" data-parent="#accordionExample3cc">
                                    <div class="card-body">
                                        <table class="table" id="tblOutcicilan">                                       
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
                <input type="hidden" name="disbursmax" id="disbursmax">
                <!--begin:: Widgets-->
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
							<div class="row">
								<div class="col-md-12">
									<h3 class="kt-widget14__title">
										<i class="fa fa-chart-bar"></i>  <?php echo $bulan[2]; ?>
                                        <i class="fa fa-eye pull-right" ></i>
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
							</div>
                        </div>
                        <div class="kt-widget11">
                            <!-- <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div> -->
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingOne3Disburse">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne3Disburse" aria-expanded="true" aria-controls="collapseOne3Disburse">
                                      <a href="<?php echo base_url('dashboards/maret'); ?>">  31 <?php echo $bulan[ 2 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingOne3Disburse" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblDisburse">                                       
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <div class="row">
                                <div class="col-md-12">
                                <h3 class="kt-widget14__title">
                                   <i class="fa fa-chart-bar"></i>  <?php echo $bulan[3]; ?> 
                                   <i class="fa fa-eye pull-right" ></i>
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
                            <div style="height:50px;"></div>                           
                        </div>  
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPelunasan">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePelunasan" aria-expanded="true" aria-controls="collapsePelunasan">
                                     <a href="<?php echo base_url('dashboards/april'); ?>">   30 <?php echo $bulan[ 3 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPelunasan" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                        <div class="row">
                                <div class="col-md-12">
                                    <h3 class="kt-widget14__title">
                                    <i class="fa fa-chart-bar"></i> <?php echo $bulan[4]; ?> 
                                    <i class="fa fa-eye pull-right" ></i>
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
                                <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingDPD">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseDPD" aria-expanded="true" aria-controls="collapseDPD">
                                      <a href="<?php echo base_url('dashboards/mei'); ?>">  31 <?php echo $bulan[ 4 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingDPD" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        
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
                <form  class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header kt-margin-b-30">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="kt-widget14__title">
                                    <i class="fa fa-chart-bar"></i>  <?php echo $bulan[5]; ?>  
                                    <i class="fa fa-eye pull-right" ></i>
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
										Total Saldo <span class="date-today"></span> <span class="total-today"></span>
									</span>
									<hr>
								</div> -->
                            </div>
                               
                            </div>
                            <div class="kt-widget11">
                                <div style="height:50px;"></div>                           
                            </div>
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingSaldo">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseSaldo" aria-expanded="true" aria-controls="collapseSaldo">
                                       <a href="<?php echo base_url('dashboards/juni'); ?>"> 30 <?php echo $bulan[ 5 ]; ?> 2021  </a>
                                        </div>
                                    </div>
                                    <div  class="collapse" aria-labelledby="headingSaldo" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tblSaldo"> 
                                            <tr>
                                                <td class="text-left"><b>Area</b></td>
                                                <td class="text-left"><b>Unit</b></td>
                                                <td class="text-right"><b>Amount</b></td>
                                            </tr>                                       
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-widget14__header kt-margin-b-30">
                                <h3 class="kt-widget14__title">
                                <i class="fa fa-chart-bar"></i>  <?php echo $bulan[6]; ?> 
                                <i class="fa fa-eye pull-right" ></i>        
                                </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
                                     
                                        </div>
                                    </div>	
                            </div>                       
                        </div>
                        <!-- <div class="col-md-6">
                            <span class="kt-widget14__desc">
                                Pengeluaran <?php  //echo date('F'); ?> <span class="total-today"></span>
                            </span>
                            <hr>
                        </div> -->
                    </div>
                        <div class="kt-widget11">
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPengeluaran">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePengeluaran" aria-expanded="true" aria-controls="collapsePengeluaran">
                                      <a href="<?php echo base_url('dashboards/juli'); ?>">  31 <?php echo $bulan[ 6 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPengeluaran" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblPengeluaran">
                                        <tr>
                                            <td class="text-left"><b>Area</b></td>
                                            <td class="text-left"><b>Unit</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                        </tr>                                        
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">                    
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="kt-widget14__header kt-margin-b-30">
                                    <h3 class="kt-widget14__title">
                                         <i class="fa fa-chart-bar"></i>   <?php echo $bulan[7]; ?>  
                                         <i class="fa fa-eye pull-right" ></i>         
                                    </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
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
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPendapatan">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePendapatan" aria-expanded="true" aria-controls="collapsePendapatan">
                                     <a href="<?php echo base_url('dashboards/agustus'); ?>">   31 <?php echo $bulan[ 7 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPendapatan" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblPendapatan"> 
                                        <tr>
                                            <td class="text-left"><b>Area</b></td>
                                            <td class="text-left"><b>Unit</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                        </tr>                                       
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-widget14__header kt-margin-b-30">
                                <h3 class="kt-widget14__title">
                                <i class="fa fa-chart-bar"></i>  <?php echo $bulan[8]; ?>
                                <i class="fa fa-eye pull-right" ></i>        
                                </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
                                     
                                        </div>
                                    </div>	
                            </div>                       
                        </div>
                        <!-- <div class="col-md-6">
                            <span class="kt-widget14__desc">
                                Pengeluaran <?php  //echo date('F'); ?> <span class="total-today"></span>
                            </span>
                            <hr>
                        </div> -->
                    </div>
                        <div class="kt-widget11">
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPengeluaran">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePengeluaran" aria-expanded="true" aria-controls="collapsePengeluaran">
                                      <a href="<?php echo base_url('dashboards/september'); ?>">  30 <?php echo $bulan[ 8 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPengeluaran" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblPengeluaran">
                                        <tr>
                                            <td class="text-left"><b>Area</b></td>
                                            <td class="text-left"><b>Unit</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                        </tr>                                        
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">                    
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="kt-widget14__header kt-margin-b-30">
                                    <h3 class="kt-widget14__title">
                                         <i class="fa fa-chart-bar"></i>  <?php echo $bulan[9]; ?>  
                                         <i class="fa fa-eye pull-right" ></i>         
                                    </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
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
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPendapatan">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePendapatan" aria-expanded="true" aria-controls="collapsePendapatan">
                                      <a href="<?php echo base_url('dashboards/oktober'); ?>">  31 <?php echo $bulan[ 9 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPendapatan" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblPendapatan"> 
                                        <tr>
                                            <td class="text-left"><b>Area</b></td>
                                            <td class="text-left"><b>Unit</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                        </tr>                                       
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-widget14__header kt-margin-b-30">
                                <h3 class="kt-widget14__title">
                                <i class="fa fa-chart-bar"></i>  <?php echo $bulan[10]; ?>
                                <i class="fa fa-eye pull-right" ></i>        
                                </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-info"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
                                     
                                        </div>
                                    </div>	
                            </div>                       
                        </div>
                        <!-- <div class="col-md-6">
                            <span class="kt-widget14__desc">
                                Pengeluaran <?php  //echo date('F'); ?> <span class="total-today"></span>
                            </span>
                            <hr>
                        </div> -->
                    </div>
                        <div class="kt-widget11">
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPengeluaran">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePengeluaran" aria-expanded="true" aria-controls="collapsePengeluaran">
                                      <a href="<?php echo base_url('dashboards/november'); ?>">  30 <?php echo $bulan[ 10 ]; ?> 2021 </a> 
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPengeluaran" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblPengeluaran">
                                        <tr>
                                            <td class="text-left"><b>Area</b></td>
                                            <td class="text-left"><b>Unit</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                        </tr>                                        
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
                <form  class="form-horizontal">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">                    
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="kt-widget14__header kt-margin-b-30">
                                    <h3 class="kt-widget14__title">
                                         <i class="fa fa-chart-bar"></i>  <?php echo $bulan[11]; ?> 
                                         <i class="fa fa-eye pull-right"></i>         
                                    </h3>
                                    <div class="kt-widget14__legends">
                                        <div class="kt-widget14__legend">
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><span class="date-today"></span> : <span class="total-today"></span></span>
                                            <span class="kt-widget14__bullet kt-bg-success"></span>
                                            <span class="kt-widget14__stats"><span class="date-yesterday"></span> : <span class="total-yesterday"></span></span>
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
                            <div style="height:50px;"></div>                           
                        </div>
                        <hr/>
                        <!--begin::Accordion-->
                        <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                            <div class="card">
                                <div class="card-header" id="headingPendapatan">
                                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePendapatan" aria-expanded="true" aria-controls="collapsePendapatan">
                                       <a href="<?php echo base_url('dashboards/desember'); ?>"> 31 <?php echo $bulan[ 11 ]; ?> 2021  </a>
                                    </div>
                                </div>
                                <div  class="collapse" aria-labelledby="headingPendapatan" data-parent="#accordionExample3">
                                    <div class="card-body">
                                        <table class="table" id="tblPendapatan"> 
                                        <tr>
                                            <td class="text-left"><b>Area</b></td>
                                            <td class="text-left"><b>Unit</b></td>
                                            <td class="text-right"><b>Amount</b></td>
                                        </tr>                                       
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

    

    

    
	<!-- end:: Content -->

	</div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('dashboard/_script.php');
?>
