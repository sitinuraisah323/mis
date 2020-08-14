<!--begin::Modal-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update BAP Kas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_edit" class="form-horizontal">
                    <div class="form-body">
                        <div class="row"> 
                            <div class="col-md-6">   
                                <div class="form-group row">  
                                <input type="hidden" class="form-control form-control-sm" id="id_edit" name="id_edit">
                                <?php if($this->session->userdata('user')->level == 'administrator'):?>                                
                                    <label class="col-lg-4 col-form-label">Units</label>
                                    <div class="col-lg-8">
                                        <select class="form-control form-control-sm select2" name="e_id_unit" id="e_id_unit">
                                            <option value="">Pilih Unit</option>
                                            <?php foreach ($units as $unit):?>
                                                <option value="<?php echo $unit->id;?>"><?php echo $unit->name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <br/><br/>
                                    </div>                                 
                                <?php else:?>
                                    <input type="hidden" class="form-control form-control-sm" name="e_id_unit" value="<?php echo $this->session->userdata('user')->id_unit;?>">
                                <?php endif;?>                                    
                                    <label class="col-lg-4 col-form-label">Kasir</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="e_kasir" name="e_kasir">
                                    </div>
                                    <label class="col-lg-4 col-form-label">Tanggal</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="e_date" name="e_date" style="background-color:grey; color:white;">
                                    </div>
                                </div>
                            </div>  

                            <div class="col-md-6">   
                                <div class="form-group row">                          
                                    <label class="col-lg-4 col-form-label">Saldo Awal</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="e_saldoawal" name="e_saldoawal" >
                                    </div>
                                    <label class="col-lg-4 col-form-label">Penerimaan</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="e_penerimaan" name="e_penerimaan">
                                    </div>
                                    <div class="col-lg-4"></div>
                                    <label class="col-lg-4 col-form-label">Pengeluaran</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="e_pengeluaran" name="e_pengeluaran">
                                    </div>
                                    <div class="col-lg-4"></div>
                                    <label class="col-lg-4 col-form-label">Total Mutasi</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="e_totmutasi" name="e_totmutasi" style="background-color:grey; color:white;" readonly>
                                        <input type="hidden" class="form-control form-control-sm" id="e_mutasi" name="e_mutasi" style="background-color:grey; color:white;" readonly>
                                    </div>
                                    <label class="col-lg-4 col-form-label">Saldo Akhir</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-sm" id="e_saldoakhir" name="e_saldoakhir" style="background-color:grey; color:white;" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-md-12">    
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>                     
                            </div> 

                            <div class="col-md-6">    
                                <b>Uang Kertas dan Plastik</b>  
                                <table class="table" id="e_kertas">
                                <tr>
                                <th>Pecahan</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                </tr>                                                            
                                </table>                  
                            </div> 

                            <div class="col-md-6">    
                                <b>Uang Logam</b>  
                                <table class="table" id="e_logam">
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
                                        <input type="text" class="form-control form-control-sm" id="e_total" name="e_total" style="background-color:grey; color:white;" readonly>
                                    </div>
                                    <label class="col-lg-2 col-form-label">Selisih</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control form-control-sm" id="e_selisih" name="e_selisih" style="background-color:grey; color:white;" readonly>
                                    </div>                                    
                                </div> 
                                <div class="form-group row">                          
                                    <label class="col-lg-2 col-form-label">Note</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control form-control" id="e_note" name="e_note">
                                    </div>                                    
                                </div>  
                            </div>
                            

                            <div class="col-md-12" >     
                                <div class="kt-section">
                                    <div class="kt-section__content">
                                            <div class="alert alert-danger fade show" role="alert" id="failed_alert_edit" style="display: none;">
                                            <div class="alert-text" id="failed_message_edit"></div>
                                            <div class="alert-close">
                                                <button type="button" class="close" aria-label="Close" id="failed_alert_dismiss_edit">
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
                                        <div class="alert alert-danger fade show" role="alert" id="failed_alert_edit" style="display: none;">
                                        <div class="alert-text" id="failed_message_add"></div>
                                        <div class="alert-close">
                                            <button type="button" class="close" aria-label="Close" id="failed_alert_dismiss_edit">
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
                <button type="button" class="btn btn-primary" id="btn_edit_submit">Update</button>
            </div>
           
        </div>
    </div>
</div>
</div>
<!--end::Modal-->