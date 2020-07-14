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
            <span class="kt-subheader__desc">#Home</span>
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
<!--begin::Row-->
<div class="row">
	<div class="col-xl-6">
		<!--begin::Portlet-->
		<div class="kt-portlet">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon kt-hidden">
						<i class="la la-gear"></i>
					</span>
					<h3 class="kt-portlet__head-title">
					Welcome Page
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<table>
					<tr>
						<th>Unit</th>
						<th>Noa Ost Kemarin</th>
						<th>Up Ost Kemarin</th>
						<th>Noa Ost Hari ini</th>
						<th>Up Ost Hari ini</th>
						<th>Noa Pelunasan hari ini</th>
						<th>Up Pelunasan Hari ini</th>
						<th>Total Noa</th>
						<th>Total Up</th>
						<th>Ticket</th>
					</tr>
					<?php foreach ($units as $unit):?>
						<tr>
							<td><?php echo $unit->name;?></td>
							<td><?php echo $unit->ost_yesterday->noa;?></td>
							<td><?php echo $unit->ost_yesterday->up;?></td>
							<td><?php echo $unit->credit_today->noa;?></td>
							<td><?php echo $unit->credit_today->up;?></td>
							<td><?php echo $unit->repayment_today->noa;?></td>
							<td><?php echo $unit->repayment_today->up;?></td>
							<td><?php echo $unit->total_outstanding->noa;?></td>
							<td><?php echo $unit->total_outstanding->up;?></td>
							<td><?php echo $unit->total_outstanding->tiket;?></td>
						</tr>
					<?php endforeach;?>
				</table>
			</div>
		</div>
		<!--end::Portlet-->
	</div>
</div>
<!--end::Row-->
</div>
<!-- end:: Content -->

</div>
</div>
	<script type="text/javascript">
		var url = '<?php echo base_url();?>';
	</script>
<?php
$this->load->view('temp/Footer.php');
?>
