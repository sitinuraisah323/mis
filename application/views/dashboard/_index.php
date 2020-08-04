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
                    <div class="kt-portlet kt-iconbox kt-iconbox--wave">
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
                                    <a class="kt-link" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                    Saldo  Unit
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="kt-portlet kt-iconbox kt-iconbox--wave">
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
                                    <a class="kt-link" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                    Selisih Saldo unit
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="kt-portlet kt-iconbox kt-iconbox--wave">
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
                                    <a class="kt-link" href="#">0</a>
                                </h3>
                                <div class="kt-iconbox__content">
                                    NOA
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4">
                    <!--begin:: Widgets-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Booking            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Booking today & yesterday
                                </span>
                            </div>	 
                            <div class="kt-widget14__content">	
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_booking" style="height: 150px; width: 150px;"></div>
                                </div> 
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-danger"></span>
                                        <span class="kt-widget14__stats">60</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">40</span>
                                    </div>
                                </div>			
                            </div> 
                        </div>
                    </div>		
                    <!--end:: Widgets-->    
                </div>

                <div class="col-xl-4 col-lg-4">
                    <!--begin:: Widgets-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Outstanding            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Outstanding today & yesterday
                                </span>
                            </div>	 
                            <div class="kt-widget14__content">	
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_outstanding" style="height: 150px; width: 150px;"></div>
                                </div> 
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-danger"></span>
                                        <span class="kt-widget14__stats">80</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">20</span>
                                    </div>
                                </div>			
                            </div> 
                        </div>
                    </div>		
                    <!--end:: Widgets-->    
                </div>

                <div class="col-xl-4 col-lg-4">
                    <!--begin:: Widgets-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Day Past Due(DPD)            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Day Past Due(DPD)  today & yesterday
                                </span>
                            </div>	 
                            <div class="kt-widget14__content">	
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_dpd" style="height: 150px; width: 150px;"></div>
                                </div> 
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-danger"></span>
                                        <span class="kt-widget14__stats">70</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">30</span>
                                    </div>
                                </div>			
                            </div> 
                        </div>
                    </div>		
                    <!--end:: Widgets-->    
                </div>

                <div class="col-xl-4 col-lg-4">
                    <!--begin:: Widgets-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Pencairan            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Pencairan Reguler & Cicilan
                                </span>
                            </div>	 
                            <div class="kt-widget14__content">	
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_pencairan" style="height: 150px; width: 150px;"></div>
                                </div> 
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-danger"></span>
                                        <span class="kt-widget14__stats">70</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">30</span>
                                    </div>
                                </div>			
                            </div> 
                        </div>
                    </div>		
                    <!--end:: Widgets-->    
                </div>

                <div class="col-xl-4 col-lg-4">
                    <!--begin:: Widgets-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Pelunasan            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Pelunasan Reguler & Cicilan
                                </span>
                            </div>	 
                            <div class="kt-widget14__content">	
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_pelunasan" style="height: 150px; width: 150px;"></div>
                                </div> 
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-danger"></span>
                                        <span class="kt-widget14__stats">70</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">30</span>
                                    </div>
                                </div>			
                            </div> 
                        </div>
                    </div>		
                    <!--end:: Widgets-->    
                </div>

                <div class="col-xl-4 col-lg-4">
                    <!--begin:: Widgets-->
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-widget14">
                            <div class="kt-widget14__header">
                                <h3 class="kt-widget14__title">
                                    Review Pendapatan & Pengeluaran            
                                </h3>
                                <span class="kt-widget14__desc">
                                    Pendaptan & Pengeluaran
                                </span>
                            </div>	 
                            <div class="kt-widget14__content">	
                                <div class="kt-widget14__chart">
                                    <div id="kt_chart_profit" style="height: 150px; width: 150px;"></div>
                                </div> 
                                <div class="kt-widget14__legends">
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-danger"></span>
                                        <span class="kt-widget14__stats">70</span>
                                    </div>
                                    <div class="kt-widget14__legend">
                                        <span class="kt-widget14__bullet kt-bg-brand"></span>
                                        <span class="kt-widget14__stats">30</span>
                                    </div>
                                </div>			
                            </div> 
                        </div>
                    </div>		
                    <!--end:: Widgets-->    
                </div>

            <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('temp/Footer.php');
$this->load->view('dashboard/_js.php');
?>
