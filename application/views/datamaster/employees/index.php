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
            <h3 class="kt-subheader__title">Data Master</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <span class="kt-subheader__desc">Pegawai</span>
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
                       Data Pegawai
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                            <button type="button" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#modal_add">
                                <i class="flaticon2-plus"></i> Buat Baru
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
<!--begin::Modal-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="post" id="input-form" enctype="multipart/form-data" class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Input Level</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>

			<input type="hidden" name="id" value="">
			<div class="modal-body form">
				<div class="form-horizontal">
					<div class="form-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Unit</label>
									<select  name="id_unit" class="form-control">
										<?php foreach ($units as $unit):?>
											<option value="<?php echo $unit->id;?>"><?php echo $unit->name;?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="form-group">
									<label>NIK</label>
									<input type="text" name="nik" class="form-control">
								</div>
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="fullname" class="form-control">
								</div>
								<div class="form-group">
									<label>Tempat Lahir</label>
									<input type="text" name="birth_place" class="form-control">
								</div>
								<div class="form-group">
									<label>Tanggal Lahir</label>
									<input type="date" name="birth_date" class="form-control">
								</div>
								<div class="form-group">
									<label>Jenis Kelamin</label>
									<select type="text" name="gender" class="form-control">
										<?php foreach (array('MALE'=>'Pria', 'FEMALE' => 'Wanita') as $value => $label):?>
											<option value="<?php echo $value;?>"><?php echo $label;?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="form-group">
									<label>No Hp</label>
									<input type="text" name="mobile" class="form-control">
								</div>
								<div class="form-group">
									<label>Status Kawin</label>
									<select  name="marital" class="form-control">
										<?php foreach (array('MARRIED'=>'Menikah','SINGLE'=>'Belum Kawin','DIVORCE'=>'BERCERAI') as $value=>$label):?>
											<option value="<?php echo $value;?>"><?php echo $label;?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="form-group">
									<label>Golongan Darah</label>
									<select  name="blood_group" class="form-control">
										<?php foreach (array('+A','+B','+AB','+O','-A','-B','-AB','-O') as $value=>$label):?>
											<option value="<?php echo $label;?>"><?php echo $label;?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<input type="text" name="address" class="form-control">
								</div>
								<div class="form-group">
									<label>Position</label>
									<input type="text" name="position" class="form-control">
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="text" name="username" class="form-control">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" class="form-control">
								</div>
								<div class="form-group">
									<label>Level</label>
									<select name="id_level" class="form-control">
										<?php foreach ($levels as $level):?>
											<option value="<?php echo $level->id;?>"><?php echo $level->level;?></option>
										<?php endforeach;?>
									</select>
								</div>
								<hr>
							</div>
							<div class="col-md-12" >
								<div class="kt-section">
									<div class="kt-section__content">
										<div class="alert alert-danger fade show" role="alert" id="failed_alert_add" style="display: none;">
											<div class="alert-text" id="failed_message_add"></div>
											<div class="alert-close">
												<button type="button" class="close" aria-label="Close" id="failed_alert_dismiss_add">
													<span aria-hidden="true"><i class="la la-close"></i></span>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="btn_add_submit">Submit</button>
			</div>
		</form>
	</div>
</div>
<!--end::Modal-->

<?php
$this->load->view('temp/Footer.php', array(
	'js'	=> 'datamaster/employees/js'
));
?>
