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
            <h3 class="kt-subheader__title"><a href="<?php echo base_url('datamaster/customers');?>">Datamaster</a></h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
			<span class="kt-subheader__desc">Nasabah</span>
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
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head kt-portlet__head--lg">
				<div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand fa fa-align-justify"></i>
                    </span>
					<h3 class="kt-portlet__head-title">
						Data Nasabah
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<button type="button" class="btn btn-brand btn-icon-sm upload" >
							<i class="flaticon2-plus"></i> Upload
						</button>
					</div>
				</div>
			</div>

			<div class="kt-portlet__body kt-portlet__body--fit">
				<div class="col-md-pull-12" >
					<!--begin: Alerts -->
					<div class="kt-section">
						<div class="kt-section__content">
							<div class="alert alert-success fade show kt-margin-r-20 kt-margin-l-20 kt-margin-t-20" role="alert" id="success_alert" style="display: none">
								<div class="alert-icon"><i class="flaticon-warning"></i></div>
								<div class="alert-text" id="success_message"></div>
								<div class="alert-close">
									<button type="button" class="close" aria-label="Close" id="success_alert_dismiss">
										<span aria-hidden="true"><i class="la la-close"></i></span>
									</button>
								</div>
							</div>
							<div class="alert alert-danger fade show kt-margin-r-20 kt-margin-l-20 kt-margin-t-20" role="alert" id="failed_alert" style="display: none">
								<div class="alert-icon"><i class="flaticon-warning"></i></div>
								<div class="alert-text" id="failed_message"></div>
								<div class="alert-close">
									<button type="button" class="close" aria-label="Close" id="failed_alert_dismiss">
										<span aria-hidden="true"><i class="la la-close"></i></span>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!--end: Alerts -->
					<!--begin: Search Form -->
					<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-l-20 kt-margin-r-20  kt-margin-b-10">
						<div class="row align-items-center">
							<div class="col-xl-8 order-2 order-xl-1">
								<div class="row align-items-center">
									<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
										<div class="kt-input-icon kt-input-icon--left">
											<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
											<span class="kt-input-icon__icon kt-input-icon__icon--left">
                                            <span><i class="la la-search"></i></span>
                                        </span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end: Search Form -->
				</div>
				<?php //print_r($areas); ?>
				<!--begin: Datatable -->
				<table class="kt-datatable" id="kt_datatable" width="100%">
				</table>
				<!--end: Datatable -->
			</div>
		</div>
	</div>
	<!-- end:: Content -->

</div>
</div>
<div class="modal" id="modal-upload" tabindex="-1" role="dialog">
	<form class="modal-dialog form-input" role="document" method="post" enctype="multipart/form-data">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload File Customers</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="file">File</label>
					<input type="file" name="file">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
</div>


<form class="modal form-modal" id="modal-form" tabindex="-2" role="dialog">
	<div class="modal-dialog"  role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload File Customers</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="hidden" name="id">
					<label for="file">No Cif</label>
					<input type="text" class="form-control" name="no_cif" required readonly>
				</div>
				<div class="form-group">
					<label for="file">Nama</label>
					<input type="text" class="form-control" name="name" required>
				</div>
				<div class="form-group">
					<label for="file">No Hp/telp</label>
					<input type="text" class="form-control" name="mobile" >
				</div>
				<div class="form-group">
					<label for="file">Tempat Lahir</label>
					<input type="text" class="form-control" name="birth_place" >
				</div>
				<div class="form-group">
					<label for="file">Tanggal Lahir</label>
					<input type="date" class="form-control" name="birth_date" >
				</div>
				<div class="form-group">
					<label for="file">Jenis Kelamin</label>
					<select name="gender" class="form-control" >
						<option value="">--Select Gender--</option>
						<?php foreach (array('MALE' => 'Pria', 'FEMALE' => 'Wanita') as $value => $key):?>
							<option value="<?php echo $value;?>"><?php echo $key;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label for="file">Status Kawin</label>
					<select name="gender" class="form-control" >
						<option value="">--Select Marital--</option>
						<?php foreach (array('SINGLE' => 'Belum Kawin', 'MARRIED' => 'Kawin','DISVORCED' => 'Cerai') as $value => $key):?>
							<option value="<?php echo $value;?>"><?php echo $key;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label for="file">Provinsi</label>
					<input type="text" class="form-control" name="province" >
				</div>
				<div class="form-group">
					<label for="file">Kota</label>
					<input type="text" class="form-control" name="city" >
				</div>
				<div class="form-group">
					<label for="file">Alamat</label>
					<input type="text" class="form-control" name="address" >
				</div>
				<div class="form-group">
					<label for="file">Pekerjaan</label>
					<input type="text" class="form-control" name="job" >
				</div>
				<div class="form-group">
					<label for="file">Nama Ibu</label>
					<input type="text" class="form-control" name="mother_name" >
				</div>
				<div class="form-group">
					<label for="file">Nama Saudara</label>
					<input type="text" class="form-control" name="sibling_name" >
				</div>
				<div class="form-group">
					<label for="file">Tempat lahir Saudara</label>
					<input type="text" class="form-control" name="sibling_birth_place" >
				</div>
				<div class="form-group">
					<label for="file">Tanggal lahir Saudara</label>
					<input type="date" class="form-control" name="sibling_birth_date" >
				</div>
				<div class="form-group">
					<label for="file">Pekerjaan Saudara</label>
					<input type="text" class="form-control" name="sibling_job" >
				</div>
				<div class="form-group">
					<label for="file">Hubungan Saudara</label>
					<input type="text" class="form-control" name="sibling_relation" >
				</div>
				<div class="form-group">
					<label for="file">Alamat Saudara</label>
					<input type="text" class="form-control" name="sibling_address_1" >
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-save">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</form>
<?php
$this->load->view('temp/Footer.php', array(
	'js'	=> 'customers/js'
));
?>
