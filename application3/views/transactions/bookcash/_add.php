<!--begin::Modal-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BAP Kas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_add" class="form-horizontal">
                    <div class="form-body">
                        <div class="row"> 
                            <div class="col-md-6">   
                                <div class="form-group row">  
                                <?php if($this->session->userdata('user')->level == 'administrator'):?>                                
                                    <label class="col-lg-4 col-form-label">Units</label>
                                    <div class="col-lg-8">
                                        <select class="form-control form-control-sm select2" name="id_unit" id="id_unit">
                                            <option value="">Pilih Unit</option>
                                            <?php foreach ($units as $unit):?>
                                                <option value="<?php echo $unit->id;?>"><?php echo $unit->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <br/><br/>
                                    </div>                                 
                                <?php else:?>
                                    <input type="hidden" class="form-control form-control-sm" name="id_unit" id="unitid" value="<?php echo $this->session->userdata('user')->id_unit;?>">
                                <?php endif;?>                                    
                                    <label class="col-lg-5 col-form-label">Kasir</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control form-control-sm" id="kasir" name="kasir">
                                    </div>
                                    <label class="col-lg-5 col-form-label">Tanggal</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control form-control-sm" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" style="background-color:grey; color:white;" readonly>
                                    </div>
                                    <label class="col-lg-5 col-form-label">Sisa UP Regular</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control form-control-sm" id="os_unit" name="os_unit" value="0">
                                    </div>
                                    <label class="col-lg-5 col-form-label">Sisa UP Cicilan</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control form-control-sm" id="os_cicilan" name="os_cicilan" value="0">
                                    </div>
                                    <label class="col-lg-5 col-form-label">OS Unit</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control form-control-sm" id="os" name="os" style="background-color:grey; color:white;" readonly>
                                    </div>
                                </div>
                            </div>  

                            <div class="col-md-6">   
                                <div class="form-group row">                          
                                    <label class="col-lg-4 col-form-label">Saldo Awal</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="saldoawal" name="saldoawal">
                                    </div>
                                    <label class="col-lg-4 col-form-label">Penerimaan</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="penerimaan" name="penerimaan">
                                    </div>
                                    <div class="col-lg-4"></div>
                                    <label class="col-lg-4 col-form-label">Pengeluaran</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="pengeluaran" name="pengeluaran">
                                    </div>
                                    <div class="col-lg-4"></div>
                                    <label class="col-lg-4 col-form-label">Total Mutasi</label>
                                    <div class="col-lg-8">
                                    <input type="text" class="form-control form-control-sm" id="totmutasi" name="totmutasi" style="background-color:grey; color:white;" readonly>
                                    <input type="hidden" class="form-control form-control-sm" id="mutasi" name="mutasi" style="background-color:grey; color:white;" readonly>
                                    </div>
                                    <label class="col-lg-4 col-form-label">Saldo Akhir</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="saldoakhir" name="saldoakhir" style="background-color:grey; color:white;" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-md-12">    
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>                     
                            </div> 

                            <div class="col-md-6">    
                                <b>Uang Kertas dan Plastik</b>  
                                <table class="table" id="kertas">
                                <tr>
                                <th>Pecahan</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                </tr>                                                            
                                </table>                  
                            </div> 

                            <div class="col-md-6">    
                                <b>Uang Logam</b>  
                                <table class="table" id="logam">
                                <tr>
                                <th>Pecahan</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                </tr>                                                               
                                </table>                   
                            </div>   

                            <div class="col-md-12">    
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                <div class="form-group row">                          
                                    <label class="col-lg-2 col-form-label">Total</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="total" name="total" style="background-color:grey; color:white;" readonly>
                                    </div>
                                    <label class="col-lg-4 col-form-label">Selisih uang fisik dengan saldo akhir</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control form-control-sm" id="selisih" name="selisih" style="background-color:grey; color:white;" readonly>
                                    </div>
                                </div> 

                                 <div class="form-group row">                          
                                    <label class="col-lg-2 col-form-label">Note</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control form-control" id="note" name="note">
                                    </div>                                    
                                </div>      
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
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_add_submit">Kirim</button>
            </div>
           
        </div>
    </div>
</div>
</div>
<!--end::Modal-->