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

                <div class="col-lg-4">
                <form id="form_saldounit" class="form-horizontal">
                    <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"/>
                                    </g>
                                </svg>					
                            </div>
                            <div class="kt-iconbox__desc">
                                <h3 class="kt-iconbox__title">
                                    <a class="kt-link cash-saldo" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                    Saldo
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="col-lg-4">
                <form id="form_cardOut" class="form-horizontal">
                    <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"/>
                                    </g>
                                </svg>					
                            </div>
                            <div class="kt-iconbox__desc">
                                <h3 class="kt-iconbox__title">
                                    <a class="kt-link Outstanding" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                    Outstanding
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="col-lg-4">
                <form id="form_cardDPD" class="form-horizontal">
                    <div class="kt-portlet kt-iconbox kt-iconbox--brand kt-iconbox--animate-slower">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000"/>
                                    </g>
                                </svg>					
                            </div>
                            <div class="kt-iconbox__desc">
                                <h3 class="kt-iconbox__title">
                                    <a class="kt-link dpd-unit" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                   Day Past Due(DPD)
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
                                    Outstanding unit on <?php echo date('F'); ?>
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
                                            <table class="table" id="tbltarOut"> 
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
                                            <table class="table" id="tbltarOut"> 
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

            <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('dashboard/unit/_script.php');
?>
