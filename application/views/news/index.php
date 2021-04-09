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
				News 
			</h3>
		</div>
	</div>
	<div class="kt-portlet__body container">
		<div class="row">
			<div class="col-md-12 news-template">
				<div class="media mt-5 d-none"  data-template="news">
					<img style="max-height:200px"  class="mr-3" alt="Generic placeholder image">
					<div class="media-body">
						<h3 class="mt-0"><a href="/" class="text-muted">Media heading</a></h3>
						<p class="summary"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!--end::Form-->
</div>
<?php
$this->load->view('temp/Footer.php');
$this->load->view('news/_add_script.php');
?>
