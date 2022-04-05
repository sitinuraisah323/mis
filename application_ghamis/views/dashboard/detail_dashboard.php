<?php 
// $a=0;
// $b=0;
// foreach($bln as $bln){
// if($month[$a]){
//     $b=$a;
//     break;
// }
// $a++;
// }
?>

<!--begin::Modal-->
<div class="modal fade" id="modal_cicilan<?php echo $month[0];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Transakasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
            <form id="form_bukukas" class="form-horizontal" method="post" action="<?php echo base_url("report/regularpawns/export"); ?>">
			<div class="kt-portlet__body">     
                <div class="col-md-12" >
                <div class="form-group row">
                <?php if($this->session->userdata('user')->level == 'unit'):?>
                    <input type="hidden" name="id_unit" value="<?php echo $this->session->userdata('user')->id_unit;?>">
                <?php elseif($this->session->userdata('user')->level == 'area'):?>
                    <input type="hidden" name="area" value="<?php echo $this->session->userdata('user')->id_area;?>">
                    <div class="col-lg-2">
						<label class="col-form-label">Unit</label>
						<select class="form-control select2" name="id_unit" id="unit">
							<option value="0">All</option>
						</select>
                    </div>                
                <?php elseif($this->session->userdata('user')->level == 'cabang'):?>
                <input type="hidden" name="cabang" value="<?php echo $this->session->userdata('user')->id_cabang;?>">
                <div class="col-lg-2">
                <label class="col-form-label">Unit</label>
                    <select class="form-control select2" name="id_unit" id="unit">
                        <option value="0">All</option>
                    </select>
                </div>
                <?php else:?>
                    <div class="col-lg-2">
						<label class="col-form-label">Area</label>
                        <select class="form-control select2" name="area" id="area">
                            <option value="0">All</option>
                            <?php
                                if (!empty($areas)){
                                    foreach($areas as $row){
                                       echo "<option value=".$row->id.">".$row->area."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
						<label class="col-form-label">Unit</label>
						<select class="form-control select2" name="id_unit" id="unit">
							<option value="0">All</option>
						</select>
                    </div>
                <?php endif ;?>
                    <div class="col-lg-2">
						<label class="col-form-label">Status</label>
                        <select class="form-control select2" name="status" id="status">
                            <option value=""></option>
                            <option value="0">All</option>
                            <option value="1">Aktif</option>
                            <option value="2">Lunas</option>
                            <!-- <option value="3">Perpanjangan</option> -->
                        </select>
                    </div>
					<!-- <div class="col-lg-2">
						<label class="col-form-label">Ijin</label>
						<select class="form-control" name="permit">
							<option value="">Select Ijin</option>
							
						</select>
					</div> -->
					<!-- <div class="col-lg-2">
						<label class="col-form-label">Tanggal</label>
						<input type="date" class="form-control" name="date-start" value="<?php echo date('Y-m-01');?>">
					</div>
					<div class="col-lg-2">
						<label class="col-form-label">Tanggal</label>
						<input type="date" class="form-control" name="date-end" value="<?php echo date('Y-m-d');?>">
					</div> -->
                    <div class="col-lg-2">
						<label class="col-form-label">Nasabah</label>
                        <select class="form-control select2" name="nasabah" id="nasabah">
							<option value=""></option>
                            <option value="all">All</option>
						</select>
                    </div>
                    <div class="col-lg-2">
						<label class="col-form-label">Sort By</label>
                        <select class="form-control select2" name="sort_by" id="sort_by">
							<option value="0">Pilih</option>
                            <option value="no_sbk">No Sbk</option>
                            <option value="date_sbk">Tanggal Sbk</option>
						</select>
                    </div>
                    <div class="col-lg-2">
                      <label class="col-form-label">Sort Method</label>
                        <select class="form-control select2" name="sort_method" id="sort_method">
							<option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
						</select>
                    </div>
                    <!-- <div class="col-lg-2">
                        <label class="col-form-label">No Sbk</label>
						<select class="form-control select2" name="no_sbk" id="no_sbk">
                        </select>
					</div> -->
                    <input type="hidden" id="month" name="month" value="<?php echo $month[0];?>">
                    <input type="hidden" id="year" name="year" value="<?php echo '2021' ; ?>">


                    <div class="col-lg-2">
                        <label class="col-form-label">&nbsp</label>
                        <div class="position-relative">
                        <button type="button" class="btn btn-brand btn-icon" name="btncari" id="btncari"><i class="fa fa-search"></i></button>
                        <!-- <button type="submit" class="btn btn-success btn-icon" name="btnexport" id="btnexport" onclick="export_xls()"><i class="fa fa-file-excel"></i></button> -->
                        <button type="submit" class="btn btn-danger btn-icon" name="btnexport_csv" id="btnexport_csv"><i class="fa fa-file-excel"></i></button>
                        </div>
                    </div>                  
				</div>

                      
                <table class="table" id="mdl_vwcicilan">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th class="text-center">No</th> -->
                            <!-- <th class="text-center">No CIF</th> -->
                            <th class='text-center'>No.SBK</th>
                            <th class='text-center'>Tanggal SBK</th>
                            <th class='text-center'>Tanggal Tempo</th>
                            <th class='text-right'>Nasabah</th>    
                            <th class='text-right'>Sewa Modal</th>                            
                            <th class='text-right'>Tafsiran</th>
                            <th class = 'text-right'>Admin</th>
                            <th class = 'text-right'>UP</th>
                            <th class = 'text-center'>Status</th>
                            <!-- <th class = 'text-center'>Description</th> -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
			</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="modal_dua<?php echo $month[1];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Transakasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
            <form id="form_bukukas" class="form-horizontal" method="post" action="<?php echo base_url("report/regularpawns/export"); ?>">
			<div class="kt-portlet__body">     
                <div class="col-md-12" >
                <div class="form-group row">
                <?php if($this->session->userdata('user')->level == 'unit'):?>
                    <input type="hidden" name="id_unit" value="<?php echo $this->session->userdata('user')->id_unit;?>">
                <?php elseif($this->session->userdata('user')->level == 'area'):?>
                    <input type="hidden" name="area" value="<?php echo $this->session->userdata('user')->id_area;?>">
                    <div class="col-lg-2">
						<label class="col-form-label">Unit</label>
						<select class="form-control select2" name="id_unit" id="unit">
							<option value="0">All</option>
						</select>
                    </div>                
                <?php elseif($this->session->userdata('user')->level == 'cabang'):?>
                <input type="hidden" name="cabang" value="<?php echo $this->session->userdata('user')->id_cabang;?>">
                <div class="col-lg-2">
                <label class="col-form-label">Unit</label>
                    <select class="form-control select2" name="id_unit" id="unit">
                        <option value="0">All</option>
                    </select>
                </div>
                <?php else:?>
                    <div class="col-lg-2">
						<label class="col-form-label">Area</label>
                        <select class="form-control select2" name="area" id="area">
                            <option value="0">All</option>
                            <?php
                                if (!empty($areas)){
                                    foreach($areas as $row){
                                       echo "<option value=".$row->id.">".$row->area."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
						<label class="col-form-label">Unit</label>
						<select class="form-control select2" name="id_unit" id="unit">
							<option value="0">All</option>
						</select>
                    </div>
                <?php endif ;?>
                    <div class="col-lg-2">
						<label class="col-form-label">Status</label>
                        <select class="form-control select2" name="status" id="status">
                            <option value=""></option>
                            <option value="0">All</option>
                            <option value="1">Aktif</option>
                            <option value="2">Lunas</option>
                            <!-- <option value="3">Perpanjangan</option> -->
                        </select>
                    </div>
					<!-- <div class="col-lg-2">
						<label class="col-form-label">Ijin</label>
						<select class="form-control" name="permit">
							<option value="">Select Ijin</option>
							
						</select>
					</div> -->
					<!-- <div class="col-lg-2">
						<label class="col-form-label">Tanggal</label>
						<input type="date" class="form-control" name="date-start" value="<?php echo date('Y-m-01');?>">
					</div>
					<div class="col-lg-2">
						<label class="col-form-label">Tanggal</label>
						<input type="date" class="form-control" name="date-end" value="<?php echo date('Y-m-d');?>">
					</div> -->
                    <div class="col-lg-2">
						<label class="col-form-label">Nasabah</label>
                        <select class="form-control select2" name="nasabah" id="nasabah">
							<option value=""></option>
                            <option value="all">All</option>
						</select>
                    </div>
                    <div class="col-lg-2">
						<label class="col-form-label">Sort By</label>
                        <select class="form-control select2" name="sort_by" id="sort_by">
							<option value="0">Pilih</option>
                            <option value="no_sbk">No Sbk</option>
                            <option value="date_sbk">Tanggal Sbk</option>
						</select>
                    </div>
                    <div class="col-lg-2">
                      <label class="col-form-label">Sort Method</label>
                        <select class="form-control select2" name="sort_method" id="sort_method">
							<option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
						</select>
                    </div>
                    <!-- <div class="col-lg-2">
                        <label class="col-form-label">No Sbk</label>
						<select class="form-control select2" name="no_sbk" id="no_sbk">
                        </select>
					</div> -->
                    <input type="hidden" id="month" name="month" value="<?php echo $month[1];?>">
                    <input type="hidden" id="year" name="year" value="<?php echo '2021' ; ?>">


                    <div class="col-lg-2">
                        <label class="col-form-label">&nbsp</label>
                        <div class="position-relative">
                        <button type="button" class="btn btn-brand btn-icon" name="btncari1" id="btncari1"><i class="fa fa-search"></i></button>
                        <!-- <button type="submit" class="btn btn-success btn-icon" name="btnexport" id="btnexport" onclick="export_xls()"><i class="fa fa-file-excel"></i></button> -->
                        <button type="submit" class="btn btn-danger btn-icon" name="btnexport_csv" id="btnexport_csv"><i class="fa fa-file-excel"></i></button>
                        </div>
                    </div>                  
				</div>

                      
                <table class="table" id="mdl_dua">
                    <thead class="thead-light">
                        <tr>
                            <!-- <th class="text-center">No</th> -->
                            <th class="text-center">No CIF</th>
                            <th class='text-center'>No.SBK</th>
                            <th class='text-center'>Tanggal SBK</th>
                            <th class='text-center'>Tanggal Tempo</th>
                            <th class='text-right'>Nasabah</th>    
                            <th class='text-right'>Sewa Modal</th>                            
                            <th class='text-right'>Tafsiran</th>
                            <th class = 'text-right'>Admin</th>
                            <th class = 'text-right'>UP</th>
                            <th class = 'text-center'>Status</th>
                            <th class = 'text-center'>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </form>
			</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<input type="hidden" name="url_get" id="url_get" value="<?php echo base_url('api/report/bukukas/get_transaksi_unit') ?>"/>
<input type="hidden" name="url_get_units" id="url_get_units" value="<?php echo base_url('api/datamaster/units/get_unit_bycabang') ?>"/>
<input type="hidden" name="url_get_unit" id="url_get_unit" value="<?php echo base_url('api/datamaster/units/get_units_byarea') ?>"/>
<?php 
$this->load->view('dashboard/detail_script.php');
?>
