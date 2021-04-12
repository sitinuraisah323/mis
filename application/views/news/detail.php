<?php
$this->load->view('temp/HeadTop.php');
$this->load->view('temp/HeadBottom.php');
$this->load->view('temp/HeadMobile.php');
$this->load->view('temp/TopBar.php');
$this->load->view('temp/MenuBar.php');
?>
<input type="hidden" name="id" value="<?php echo $id;?>"/>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="row mt-5 append-template">
		<div class="col-xl-12 col-lg-12 order-lg-1 order-xl-1 d-none" data-template="news">
			<!--begin:: Widgets/Blog-->
			<div class="kt-portlet kt-portlet--height-fluid kt-widget19">
				<div class="kt-portlet__body kt-portlet__body--fit kt-portlet__body--unfill">
					<div class="kt-widget19__pic kt-portlet-fit--top kt-portlet-fit--sides" style="min-height: 300px">
						<h3 class="kt-widget19__title kt-font-light">
								Introducing New Feature
						</h3>
						<div class="kt-widget19__shadow"></div>
						<div class="kt-widget19__labels">
							<a href="#" class="btn btn-label-light-o2 btn-bold ">Recent</a>
						</div>
					</div>
				</div>
				<div class="kt-portlet__body">
					<div class="kt-widget19__wrapper">
						<div class="kt-widget19__text">

						</div>
					</div>
					<div class="row attachments"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$this->load->view('temp/Footer.php');
$this->load->view('news/_script_detail.php');
?>
