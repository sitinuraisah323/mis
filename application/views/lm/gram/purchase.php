<?php
$this->load->view('temp/HeadTop.php');
$this->load->view('temp/HeadBottom.php');
$this->load->view('temp/HeadMobile.php');
$this->load->view('temp/TopBar.php');
$this->load->view('temp/MenuBar.php');
?>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				Purchases
			</h3>
		</div>
	</div>
	<!--begin::Form-->
	<form class="kt-form">
		<div class="kt-portlet__body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-3">Kode Transaksi</label>
						<div class="col-md-9">
							<input type="text" name="code" class="form-control">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-3">Karyawan</label>
						<div class="col-md-9">
							<select class="custom-select form-control" name="id_employee" required>
								<option ="">Karyawan</option>
								<?php if($employees):?>
									<?php foreach ($employees as $employee):?>
										<option value="<?php echo $employee->id;?>"><?php echo implode('-', array($employee->fullname, $employee->unit));?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-3">Date</label>
						<div class="col-md-9">
							<input type="date" name="date" class="form-control">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label class="col-md-3">Metode</label>
						<div class="col-md-9">
							<select name="method" class="form-control">
								<?php foreach (array('CASH'=>'Cash','INSTALLMENT'=>'Cicil') as $key => $value):?>
									<option value="<?php echo $key;?>"><?php echo $value;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="lm">LM</label>
						<select class="form-control search-purchase">
							<option value="">Pilih Lm</option>

						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead class="thead-light">
							<tr>
								<th>Weight</th>
								<th>Harga Perpcs</th>
								<th>Amount</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody data-append="choice">
							<tr data-template="choice" class="d-none">
								<th><input type="hidden" class="id_lm_gram"><span data-post="id_lm_gram"></span></th>
								<td>
									<input type="hidden"  class="price_perpcs">
									<input type="hidden" class="price_buyback_perpcs">
									<span data-post="price_perpcs"></span>
								</td>
								<td><input type="text" value="0" class="form-control amount"></td>
								<td><input type="hidden" class="total"><span data-post="total">0</span></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="3" class="text-right">total</th>
								<th><input type="text" class="form-control" name="total"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<div class="kt-portlet__foot">
			<div class="kt-form__actions">
				<button type="reset" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-secondary">Cancel</button>
			</div>
		</div>
	</form>
	<!--end::Form-->
</div>
<?php
$this->load->view('temp/Footer.php');
$this->load->view('lm/gram/js.php');
?>
