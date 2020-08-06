<!--begin::Modal-->
<div class="modal fade" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="form_view">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail BAP Kas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kt-portlet__body"> 
                    <div class="row">                    
                        <div class="col-md-6"> 
                            <div class="form-group row"> 
                                <label class="col-lg-2 col-form-label">Unit</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control form-control-sm" id="v_units" name="v_units" readonly>
                                </div> 
                                <label class="col-lg-2 col-form-label">Kasir</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control form-control-sm" id="v_kasir" name="v_kasir" readonly>
                                </div> 
                                <label class="col-lg-2 col-form-label">Tanggal</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control form-control-sm" id="v_date" name="v_date" readonly>
                                </div> 
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row"> 
                                <label class="col-lg-4 col-form-label">Saldo Awal</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control form-control-sm" id="v_saldoawal" name="v_saldoawal" readonly>
                                </div> 
                                <label class="col-lg-4 col-form-label">Penerimaan</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control form-control-sm" id="v_penerimaan" name="v_penerimaan" readonly>
                                </div> 
                                <div class="col-lg-2"></div>
                                <label class="col-lg-4 col-form-label">Pengeluaran</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control form-control-sm" id="v_pengeluaran" name="v_pengeluaran" readonly>
                                </div> 
                                <div class="col-lg-2"></div>
                                <label class="col-lg-4 col-form-label">Mutasi</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control form-control-sm" id="v_mutasi" name="v_mutasi" readonly>
                                </div> 
                                <label class="col-lg-4 col-form-label">Saldo Akhir</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control form-control-sm" id="v_saldoakhir" name="v_saldoakhir" readonly>
                                </div> 
                            </div> 
                        </div>

                        <div class="col-md-12">    
                                <!-- <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>-->
                                <hr/>
                        </div> 

                        <div class="col-md-6">    
                                <b>Uang Kertas dan Plastik</b>  
                                <table class="table" id="v_kertas">
                                <tr>
                                <th>Pecahan</th>
                                <th>Jumlah</th>
                                <th class="text-right">Total</th>
                                </tr>                                                            
                                </table>                  
                        </div>

                        <div class="col-md-6">    
                                <b>Uang Logam</b>  
                                <table class="table" id="v_logam">
                                <tr>
                                <th>Pecahan</th>
                                <th>Jumlah</th>
                                <th class="text-right">Total</th>
                                </tr>                                                               
                                </table>                   
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row"> 
                                <label class="col-lg-4 col-form-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control form-control-sm" id="v_total" name="v_total" readonly>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row"> 
                                <label class="col-lg-4 col-form-label">Selisih</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control form-control-sm" id="v_selisih" name="v_selisih" readonly>
                                </div> 
                            </div>
                        </div>

                    </div>                                            
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!--end::Modal-->