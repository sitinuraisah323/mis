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
            <span class="kt-subheader__desc">Pusat</span>            
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
 <div class="row">
    <div class="col-lg-4">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--tab">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon kt-hidden">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Disburse/Booking Nasional(YTD)
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="kt_Nasional" style="height:250px;"></div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>

    <div class="col-lg-4">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--tab">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon kt-hidden">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Disburse/Booking Bulan June(MTD)
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="kt_Month" style="height:250px;"></div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>

    <div class="col-lg-4">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--tab">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon kt-hidden">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Saldo Kas
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="kt_Saldo" style="height:250px;"></div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
</div>	
</div>
<!-- end:: Content -->
</div>

<?php 
$this->load->view('temp/Footer.php');
$this->load->view('dashboards/pusat/_script.php');
?>