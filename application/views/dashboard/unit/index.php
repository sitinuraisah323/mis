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

                <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert" id="message_alert" style="display: none;">                    
                        <div class="alert-text">                        
                            <h4 class="alert-heading">Got Issues!</h4>
                            <p>Terdapat kesalahan pencatatan transaksi sebesar <span class="badge badge-primary"><b><label class="total_err"></b></span> dari  <span class="badge badge-primary"><b><label class="total_noa_err"></b></span> Noa status masih aktif, hal ini terjadi karena kesalahan pencatatan data nasabah, untuk selanjutnya tiap unit bisa lebih teliti lagi dalam pencatatan transaksi supaya kesalahan tidak terulang lagi.</p>
                            <hr>
                            <p class="mb-0">Kesalahan pencatatan transaksi ini akan diakui sebagai OS di GHAnet jika statusnya masih aktif</p>
                        </div>
                        <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                    </div>
                </div>

                <div class="col-lg-5">
                <form id="form_cardOut" class="form-horizontal">
                    <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M11.2600599,5.81393408 L2,16 L22,16 L12.7399401,5.81393408 C12.3684331,5.40527646 11.7359848,5.37515988 11.3273272,5.7466668 C11.3038503,5.7680094 11.2814025,5.79045722 11.2600599,5.81393408 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M12.0056789,15.7116802 L20.2805786,6.85290308 C20.6575758,6.44930487 21.2903735,6.42774054 21.6939717,6.8047378 C21.8964274,6.9938498 22.0113578,7.25847607 22.0113578,7.535517 L22.0113578,20 L16.0113578,20 L2,20 L2,7.535517 C2,7.25847607 2.11493033,6.9938498 2.31738608,6.8047378 C2.72098429,6.42774054 3.35378194,6.44930487 3.7307792,6.85290308 L12.0056789,15.7116802 Z" fill="#000000"/>
                                </g>
                            </svg>					
                            </div>
                            <div class="kt-iconbox__desc">
                                <h3 class="kt-iconbox__title">
                                    <a class="kt-link Outstanding" href="#">0</a> (OS)
                                </h3>
                                <div class="kt-iconbox__content">
                                   UP Reguler ( <b><a class="kt-link upregular" href="#">0</a></b>) of <b><a class="kt-link noareg" href="#">0</a></b> Noa
                                   <br/>UP Cicilan ( <b><a class="kt-link saldocicilan" href="#">0</a></b>) of <b><a class="kt-link noacicilan" href="#">0</a></b> Noa                                      
                                   <!-- <br/>UP Cicilan ( <b><a class="kt-link upcicilan" href="#">0</a></b>)  -->
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>


                <div class="col-lg-4">
                    <form id="form_saldounit" class="form-horizontal">
                    <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
                                    <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000"/>
                                </g>
                            </svg>					
                            </div>
                            <div class="kt-iconbox__desc">
                                <h3 class="kt-iconbox__title">
                                    <a class="kt-link cash-saldo" href="#">0</a>(Selisih)
                                </h3>
                                <div class="kt-iconbox__content">                                    
                                    Saldo Unit ( <b><a class="kt-link saldounit" href="#">0</a></b>) 
                                   <br/>Saldo GHAnet ( <b><a class="kt-link saldoghanet" href="#">0</a></b>)                                    
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="col-lg-3">
                <form id="form_cardDPD" class="form-horizontal">
                    <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M14,7 C13.6666667,10.3333333 12.6666667,12.1167764 11,12.3503292 C11,12.3503292 12.5,6.5 10.5,3.5 C10.5,3.5 10.287918,6.71444735 8.14498739,10.5717225 C7.14049032,12.3798172 6,13.5986793 6,16 C6,19.428689 9.51143904,21.2006583 12.0057195,21.2006583 C14.5,21.2006583 18,20.0006172 18,15.8004732 C18,14.0733981 16.6666667,11.1399071 14,7 Z" fill="#000000"/>
                                </g>
                            </svg>					
                            </div>
                            <div class="kt-iconbox__desc">
                                <h3 class="kt-iconbox__title">
                                    <a class="kt-link dpd-unit" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                   Day Past Due(DPD) of <b><a class="kt-link dpdnoa" href="#">0</a></b> Noa
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>                

                <div class="col-xl-6 col-lg-6">
                    <!--begin:: Widgets-->
                    <form id="form_booking" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Booking            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Booking on <?php echo date('F'); ?>
                                </span>
                            </div>	 
                            <div class="Kt-widget11">	
                                    <canvas id="grapBooking" style="height:200px;"></canvas>
                            </div> 
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingBook">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseBook" aria-expanded="true" aria-controls="collapseBook">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapseBook" class="collapse" aria-labelledby="headingBook" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tblBooking"> 
                                            <tr>
                                                <td class="text-left"><b>Date</b></td>
                                                <td class="text-center"><b>Noa</b></td>
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
                    <form id="form_outstanding" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Outstanding            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Outstanding on <?php echo date('F'); ?>
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="grapOutstanding" style="height:200px;"></canvas> 
                            </div> 
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingOut">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOut" aria-expanded="true" aria-controls="collapseOut">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapseOut" class="collapse" aria-labelledby="headingOut" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tblOutstanding"> 
                                            <tr>
                                                <td class="text-left"><b>Date</b></td>
                                                <td class="text-center"><b>Noa</b></td>
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
                    <form id="form_dpd" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Day Past Due(DPD)            
                                </h3>
                                <span class="kt-widget14__desc">
                                    DPD on <?php echo date('F'); ?>
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="grapDPD" style="height:200px;"></canvas> 
                            </div>  
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingDPD">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseDPD" aria-expanded="true" aria-controls="collapseDPD">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapseDPD" class="collapse" aria-labelledby="headingDPD" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tbldpd"> 
                                            <tr>
                                                <td class="text-left"><b>Customer</b></td>
                                                <td class="text-center"><b>Tanggal Kredit</b></td>
                                                <td class="text-center"><b>Tanggal Deadline</b></td>
                                                <td class="text-right"><b>UP</b></td>
                                                <td class="text-center"><b>DPD</b></td>
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
                    <form id="form_pencairan" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Pencairan & Pelunasan           
                                </h3>
                                <span class="kt-widget14__desc">
                                    Pencairan & Pelunasan on <?php echo date('F'); ?>
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="grapPencairan" style="height:200px;"></canvas> 
                            </div> 
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingPencairan">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsePencairan" aria-expanded="true" aria-controls="collapsePencairan">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapsePencairan" class="collapse" aria-labelledby="headingPencairan" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tblpencairan"> 
                                            <tr>
                                                <td class="text-left"><b>Date</b></td>
                                                <td class="text-right"><b>Pencairan</b></td>
                                                <td class="text-right"><b>Pelunasan</b></td>
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
                    <form id="form_rate" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Rate           
                                </h3>
                                <span class="kt-widget14__desc">
                                    summary Rate Reguler
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="grapRate" style="height:200px;"></canvas> 
                            </div>  
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingRate">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseRate" aria-expanded="true" aria-controls="collapseRate">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapseRate" class="collapse" aria-labelledby="headingRate" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tblrate"> 
                                            <tr>
                                                <td class="text-left"><b>Rate</b></td>
                                                <td class="text-right"><b>Noa</b></td>                                                
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
                    <form id="form_kas" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Pendaptan & Pengeluaran            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Pendaptan & Pengeluaran on <?php echo date('F'); ?>
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="grapkas" style="height:200px;"></canvas> 
                            </div>  
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingprofit">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseprofit" aria-expanded="true" aria-controls="collapseprofit">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapseprofit" class="collapse" aria-labelledby="headingprofit" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tblprofit"> 
                                            <tr>
                                                <td class="text-left"><b>Date</b></td>
                                                <td class="text-right"><b>Pendapatan</b></td>
                                                <td class="text-right"><b>Pengeluaran</b></td>
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
                    <form id="form_tarbooking" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Target Booking            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Target Booking on <?php echo date('Y'); ?>
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="graptarBooking" style="height:200px;"></canvas> 
                            </div>  
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingtarBook">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsetarBook" aria-expanded="true" aria-controls="collapsetarBook">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapsetarBook" class="collapse" aria-labelledby="headingtarBook" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tbltarbook"> 
                                            <tr>
                                                <td class="text-left"><b>Month</b></td>
                                                <td class="text-left"><b>Status</b></td>
                                                <td class="text-right"><b>Target</b></td>
                                                <td class="text-right"><b>Realisasi</b></td>
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
                    <form id="form_tarout" class="form-horizontal">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Target Outstanding            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Target Outstanding on <?php echo date('Y'); ?>
                                </span>
                            </div>	 
                            <div class="kt-widget11">	                               
                                <canvas id="graptarOut" style="height:200px;"></canvas> 
                            </div> 
                            <hr/>
                            <!--begin::Accordion-->
                            <div class="accordion accordion-light accordion-toggle-plus" id="accordionExample3">
                                <div class="card">
                                    <div class="card-header" id="headingtarOut">
                                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsetarOut" aria-expanded="true" aria-controls="collapsetarOut">
                                            View Detail
                                        </div>
                                    </div>
                                    <div id="collapsetarOut" class="collapse" aria-labelledby="headingtarOut" data-parent="#accordionExample3">
                                        <div class="card-body">
                                            <table class="table" id="tbltarout"> 
                                            <tr>
                                                <td class="text-left"><b>Month</b></td>
                                                <td class="text-left"><b>Status</b></td>
                                                <td class="text-right"><b>Target</b></td>
                                                <td class="text-right"><b>Realisasi</b></td>
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

            <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('dashboard/unit/_script.php');
?>
