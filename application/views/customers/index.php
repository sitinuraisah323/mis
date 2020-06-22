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
            <h3 class="kt-subheader__title"><a href="<?php echo base_url('datamaster/customers');?>">Lists</a></h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <a class="kt-subheader__desc upload">Upload</a>
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
						List Customers
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<div class="tab-pane active" id="kt_widget11_tab1_content">
					<!--begin::Widget 11-->
					<div class="kt-widget11">
						<div class="table-responsive">
							<table class="table ">
								<thead>
								<tr>
									<td>NO CIF</td>
									<td>NIK</td>
									<td>Name</td>
									<td>Phone</td>
									<td>Birth Day</td>
									<td>Gender</td>
									<td>Marital</td>
									<td>Province</td>
									<td>City</td>
									<td>Address</td>
									<td>Citizenship</td>
									<td>Mother</td>
									<td>Sibling Name</td>
									<td>Sibling Birth Day</td>
									<td>Sibling Relation</td>
									<td>Sibling Job</td>
									<td>Status</td>
									<td>Action</td>
								</tr>
								</thead>
								<tbody>
								<?php if($customers):?>
									<?php foreach ($customers as $customer):?>
										<tr>
											<td><?php echo $customer->no_cif;?></td>
											<td><?php echo $customer->nik;?></td>
											<td><?php echo $customer->name;?></td>
											<td><?php echo $customer->mobile;?></td>
											<td><?php echo $customer->birth_place.', '.$customer->birth_date;?></td>
											<td><?php echo $customer->gender;?></td>
											<td><?php echo $customer->marital;?></td>
											<td><?php echo $customer->province;?></td>
											<td><?php echo $customer->city;?></td>
											<td><?php echo $customer->address;?></td>
											<td><?php echo $customer->citizenship;?></td>
											<td><?php echo $customer->mother_name;?></td>
											<td><?php echo $customer->sibling_name;?></td>
											<td><?php echo $customer->sibling_birth_place.' ,'.$customer->sibling_birth_date;?></td>
											<td><?php echo $customer->sibling_relation;?></td>
											<td><?php echo $customer->sibling_job;?></td>
											<td><?php echo $customer->status == 'PUBLISH' ? 'Aktif' : 'Non Aktif';?></td>
											<td>
												<button class="btn btn-edit btn-info" data-id="<?php echo $customer->id;?>">Edit</button>
											</td>
										</tr>
									<?php endforeach;?>
								<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<!--end::Widget 11-->
				</div>
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
					<label for="file">Name</label>
					<input type="text" class="form-control" name="name" required>
				</div>
				<div class="form-group">
					<label for="file">Mobile</label>
					<input type="text" class="form-control" name="mobile" >
				</div>
				<div class="form-group">
					<label for="file">Birth Place</label>
					<input type="text" class="form-control" name="birth_place" >
				</div>
				<div class="form-group">
					<label for="file">Birth Date</label>
					<input type="date" class="form-control" name="birth_date" >
				</div>
				<div class="form-group">
					<label for="file">Gender</label>
					<select name="gender" class="form-control" >
						<option value="">--Select Gender--</option>
						<?php foreach (array('MALE', 'FEMALE') as $value):?>
							<option value="<?php echo $value;?>"><?php echo $value;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label for="file">Marital</label>
					<select name="gender" class="form-control" >
						<option value="">--Select Marital--</option>
						<?php foreach (array('SINGLE', 'MARRIED','DISVORCED') as $value):?>
							<option value="<?php echo $value;?>"><?php echo $value;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="form-group">
					<label for="file">Province</label>
					<input type="text" class="form-control" name="province" >
				</div>
				<div class="form-group">
					<label for="file">City</label>
					<input type="text" class="form-control" name="city" >
				</div>
				<div class="form-group">
					<label for="file">Address</label>
					<input type="text" class="form-control" name="address" >
				</div>
				<div class="form-group">
					<label for="file">JOB</label>
					<input type="text" class="form-control" name="job" >
				</div>
				<div class="form-group">
					<label for="file">Mother Name</label>
					<input type="text" class="form-control" name="mother_name" >
				</div>
				<div class="form-group">
					<label for="file">Sibling Name</label>
					<input type="text" class="form-control" name="sibling_name" >
				</div>
				<div class="form-group">
					<label for="file">Sibling Birth Place</label>
					<input type="text" class="form-control" name="sibling_birth_place" >
				</div>
				<div class="form-group">
					<label for="file">Sibling Birth Date</label>
					<input type="date" class="form-control" name="sibling_birth_date" >
				</div>
				<div class="form-group">
					<label for="file">Sibling JOB</label>
					<input type="text" class="form-control" name="sibling_job" >
				</div>
				<div class="form-group">
					<label for="file">Sibling Relationship</label>
					<input type="text" class="form-control" name="sibling_relation" >
				</div>
				<div class="form-group">
					<label for="file">Sibling Address</label>
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
