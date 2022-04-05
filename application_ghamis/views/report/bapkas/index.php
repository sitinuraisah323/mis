<?php
$this->load->view( 'temp/HeadTop.php' );
$this->load->view( 'temp/HeadBottom.php' );
$this->load->view( 'temp/HeadMobile.php' );
$this->load->view( 'temp/TopBar.php' );
$this->load->view( 'temp/MenuBar.php' );
?>

<div class = 'kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch' id = 'kt_body'>
<div class = 'kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor' id = 'kt_content'>
<!-- begin:: Content Head -->
<div class = 'kt-subheader   kt-grid__item' id = 'kt_subheader'>
<div class = 'kt-container '>
<div class = 'kt-subheader__main'>
<h3 class = 'kt-subheader__title'>Report</h3>
<span class = 'kt-subheader__separator kt-subheader__separator--v'></span>
<span class = 'kt-subheader__desc'>BAP Kas</span>
</div>
<div class = 'kt-subheader__toolbar'>
<div class = 'kt-subheader__wrapper'>
</div>
</div>
</div>
</div>
<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class = 'kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid'>
<div class = 'kt-portlet kt-portlet--mobile'>
<div class = 'kt-portlet__head kt-portlet__head--lg'>
<div class = 'kt-portlet__head-label'>
<span class = 'kt-portlet__head-icon'>
<i class = 'kt-font-brand fa fa-align-justify'></i>
</span>
<h3 class = 'kt-portlet__head-title'>
Data BAP Kas
</h3>
</div>
<div class = 'kt-portlet__head-toolbar'>
<div class = 'kt-portlet__head-wrapper'>

</div>
</div>
</div>

<div class = 'kt-portlet__body kt-portlet__body--fit'>
<div class = 'col-md-pull-12' >
<!--begin: Alerts -->
<div class = 'kt-section'>
<div class = 'kt-section__content'>
<div class = 'alert alert-success fade show kt-margin-r-20 kt-margin-l-20 kt-margin-t-20' role = 'alert' id = 'success_alert' style = 'display: none'>
<div class = 'alert-icon'><i class = 'flaticon-warning'></i></div>
<div class = 'alert-text' id = 'success_message'></div>
<div class = 'alert-close'>
<button type = 'button' class = 'close' aria-label = 'Close' id = 'success_alert_dismiss'>
<span aria-hidden = 'true'><i class = 'la la-close'></i></span>
</button>
</div>
</div>
<div class = 'alert alert-danger fade show kt-margin-r-20 kt-margin-l-20 kt-margin-t-20' role = 'alert' id = 'failed_alert' style = 'display: none'>
<div class = 'alert-icon'><i class = 'flaticon-warning'></i></div>
<div class = 'alert-text' id = 'failed_message'></div>
<div class = 'alert-close'>
<button type = 'button' class = 'close' aria-label = 'Close' id = 'failed_alert_dismiss'>
<span aria-hidden = 'true'><i class = 'la la-close'></i></span>
</button>
</div>
</div>
</div>
</div>
<!--end: Alerts -->
</div>

<!--begin: Datatable -->
<!-- <table class = 'kt-datatable' id = 'kt_datatable' width = '100%'>
</table> -->
<!--end: Datatable -->

<form id = 'form_bukukas' class = 'form-horizontal' method = 'post' action = '<?php echo base_url('report/bapkas/export'); ?>'>
<div class = 'kt-portlet__body'>
<div class = 'col-md-12' >
<div class = 'form-group row'>
<?php if ( $this->session->userdata( 'user' )->level == 'unit' ):?>
<input type = 'hidden' name = 'id_unit' value = "<?php echo $this->session->userdata('user')->id_unit;?>">
<?php elseif ( $this->session->userdata( 'user' )->level == 'area' ):?>
<input type = 'hidden' name = 'area' value = "<?php echo $this->session->userdata('user')->id_area;?>">

<div class = 'col-lg-2'>
<label class = 'col-form-label'>Unit</label>
<select class = 'form-control select2' name = 'id_unit' id = 'unit'>
<option value = '0'>All</option>
</select>
</div>
<?php elseif ( $this->session->userdata( 'user' )->level == 'cabang' ):?>
<input type = 'hidden' name = 'cabang' value = "<?php echo $this->session->userdata('user')->id_cabang;?>">
<div class = 'col-lg-2'>
<label class = 'col-form-label'>Unit</label>
<select class = 'form-control select2' name = 'id_unit' id = 'unit'>
<option value = '0'>All</option>
</select>
</div>
<?php else:?>
<div class = 'col-lg-2'>
<label class = 'col-form-label'>Area</label>
<select class = 'form-control select2' name = 'area' id = 'area'>
<option value = '0'>All</option>
<?php
if ( !empty( $areas ) ) {
    foreach ( $areas as $row ) {
        echo '<option value='.$row->id.'>'.$row->area.'</option>';
    }
}
?>
</select>
</div>
<div class = 'col-lg-2'>
<label class = 'col-form-label'>Unit</label>
<select class = 'form-control select2' name = 'id_unit' id = 'unit'>
<option value = '0'>All</option>
</select>
</div>
<?php endif ;
?>
<div class = 'col-lg-2'>
<label class = 'col-form-label'>Tanggal</label>
<input type = 'date' class = 'form-control' name = 'date-start' value = "<?php echo date('Y-m-d');?>">
</div>
<!-- <div class = 'col-lg-2'>
<label class = 'col-form-label'>Sampai</label>
<input type = 'date' class = 'form-control' name = 'date-end' value = "<?php echo date('Y-m-d');?>">
</div>                     -->
<div class = 'col-lg-2'>
<label class = 'col-form-label'>&nbsp</label>
<div class = 'position-relative'>
<button type = 'button' class = 'btn btn-brand btn-icon' name = 'btncari' id = 'btncari'><i class = 'fa fa-search'></i></button>
<!-- <button type = 'submit' class = 'btn btn-success btn-icon' name = 'btnexport' id = 'btnexport' onclick = 'export_xls()'><i class = 'fa fa-file-excel'></i></button> -->
<button type = 'submit' class = 'btn btn-danger btn-icon' name = 'btnexport_csv' id = 'btnexport_csv'><i class = 'fa fa-file-excel'></i></button>
</div>
</div>
</div>

</div>

<div class = 'col-md-12'>
<div class = 'kt-section__content'>
<table class = 'table'>
<thead class = 'thead-light'>
<tr>
<th class = 'text-center'>No</th>
<th class = 'text-left'>Units</th>
<!-- <th class = 'text-left'>Kasir</th> -->
<th class = 'text-center'>Tanggal</th>
<th class = 'text-right'>Saldo Awal</th>
<th class = 'text-right'>Penerimaan</th>
<th class = 'text-right'>Pengeluaran</th>
<th class = 'text-right'>Saldo Akhir</th>
<th class = 'text-right'>Selisih</th>
<th class = 'text-right'>NOA Reg</th>
<th class = 'text-right'>OS. Regular</th>
<th class = 'text-right'>NOA Cicil</th>
<th class = 'text-right'>OS. Cicilan</th>
<th class = 'text-right'>NOA Total</th>
<th class = 'text-right'>Total OS</th>
<th class = 'text-center'>#</th>
<th></th>
</tr>
</thead>
<tbody>
</tbody>
<tfoot>
<tr>
<th colspan = '3' class = 'text-right'>Total</th>
<th class = 'saldoawal text-right'></th>
<th class = 'penerimaan text-right'></th>
<th class = 'pengeluaran text-right'></th>
<th class = 'saldoakhir text-right'></th>
<th class = 'selisih text-right'></th>
<th class = 'noaregular text-right'></th>
<th class = 'osreg text-right'></th>
<th class = 'noacicilan text-right'></th>
<th class = 'osnonreg text-right'></th>
<th class = 'noatotal text-right'></th>
<th class = 'totos text-right'></th>
</tr>
</tfoot>
</table>
</div>
</div>

</div>
</form>

</div>
</div>
</div>
<!-- end:: Content -->
<input type = 'hidden' name = 'url_get' id = 'url_get' value = "<?php echo base_url('api/report/bukukas/get_transaksi_unit') ?>"/>
<input type = 'hidden' name = 'url_get_unit' id = 'url_get_unit' value = "<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>
<input type = 'hidden' name = 'url_get_units' id = 'url_get_units' value = "<?php echo base_url('api/datamaster/units/get_unit_bycabang') ?>"/>

</div>
</div>

<?php
$this->load->view( 'temp/Footer.php' );
$this->load->view( 'report/bapkas/_script.php' );
$this->load->view( 'report/bapkas/_view.php' );
?>
