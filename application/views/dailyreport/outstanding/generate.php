<h3>Outstanding Nasional <?php echo date('d-m-Y'); ?></h3>
<hr/>
    <?php 
        $totalNoaYesReg = 0;
        $totalOstYesReg = 0;
        //kredit reguler
        $totalNoaOstTodayRegKredit = 0;
        $totalUpOstTodayRegKredit = 0;
        //pelunasan reguler
        $totalNoaOstTodayRegPelunasan = 0;
        $totalUpOstTodayRegPelunasan = 0;
        //OSReg
        $totalNoaTodayReg = 0;
        $totalOstTodayReg = 0;

        $totalNoaYesCcl = 0;
        $totalOstYesCcl = 0;
         //kredit cicilan
         $totalNoaOstTodayCclKredit = 0;
         $totalUpOstTodayCclKredit = 0;
         //pelunasan cicilan
         $totalNoaOstTodayCclPelunasan = 0;
         $totalUpOstTodayCclPelunasan = 0;
         //OS Cicilan
         $totalNoaTodayCcl = 0;
         $totalOstTodayCcl = 0;

        $totalosunit_= 0;
        $totalallosunit_= 0;
        $totalnoareg_ =0;
        $totalosreg_ =0;
        $totaloscicilan_ =0;
        $totalnoadisburse_= 0;
        $totalupdisburse_= 0;
        $totalticket_ =0;
        $dateOST = date('d-m-Y',strtotime($datetrans));
        $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($datetrans)));

        //echo "<pre/>";
        //print_r($outstanding);
    ?>

    <table class="table" border="1">
            <!-- <tr bgcolor="#aaaa55">
                <td colspan="14" align="center" width="900">JAWA BARAT</td>
            </tr> -->
            <tr bgcolor="#cccccc">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="left" width="120"> Unit</td>
                <td colspan="8" align="center" width="480">Gadai Reguler<?php //echo $dateLastOST;?></td>
                <td colspan="8" align="center" width="480">Gadai Cicilan<?php //echo $datetrans;?></td>
                <td rowspan="2" align="center" width="100">Total <br/>Outstanding</td>
                <td colspan="3" align="center" width="200">Disburse<?php //echo $dateLastOST;?></td>
            </tr>
            <tr>
                <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Ost. Regular</td>

                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan</td>

                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
                <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
            </tr>
            <?php $no=0;           
            foreach($outstanding as $data): $no++; ?>
            <?php 
                //reguler
                $totalosreg_ = ($data->ost_yesterday->os_regular + $data->ost_today->up_regular) - ($data->ost_today->repyment_regular); 
                $totalnoareg_ = ($data->ost_yesterday->noa_regular + $data->ost_today->noa_regular) - ($data->ost_today->noa_repyment_regular); 
                //cicilan
                $totaloscicilan_ = ($data->ost_yesterday->os_mortages + $data->ost_today->up_mortage) - ($data->ost_today->repayment_mortage); 
                $totalnoacicilan_ = ($data->ost_yesterday->noa_mortages + $data->ost_today->noa_mortage); 
                $totalosunit_= $totalosreg_ + $totaloscicilan_;
           ?>
            <tr>
                <td align="center"><?php echo $no;?></td>
                <td align="left"> <?php echo $data->name;?></td>

                <td align="center"><?php echo $data->ost_yesterday->noa_regular;?></td>
                <td align="right"><?php echo number_format($data->ost_yesterday->os_regular,0);?></td>
                <td align="center"><?php echo number_format($data->ost_today->noa_regular,0);?></td>
                <td align="right"><?php echo number_format($data->ost_today->up_regular,0);?></td>
                <td align="center"><?php echo number_format($data->ost_today->noa_repyment_regular,0);?></td>
                <td align="right"><?php echo number_format($data->ost_today->repyment_regular,0);?></td>
                <td align="center"><?php echo $totalnoareg_;?></td>
                <td align="right"><?php echo number_format($totalosreg_,0);?></td>

                <td align="center"><?php echo $data->ost_yesterday->noa_mortages;?></td>
                <td align="right"><?php echo number_format($data->ost_yesterday->os_mortages,0);;?></td>
                <td align="center"><?php echo number_format($data->ost_today->noa_mortage,0);?></td>
                <td align="right"><?php echo number_format($data->ost_today->up_mortage,0);?></td>
                <td align="center"><?php echo number_format($data->ost_today->noa_repayment_mortage,0);?></td>
                <td align="right"><?php echo number_format($data->ost_today->repayment_mortage,0);?></td>
                <td align="center"><?php echo $totalnoacicilan_;?></td>
                <td align="right"><?php echo number_format($totaloscicilan_,0);?></td>    
                <td align="right"><?php echo number_format($totalosunit_,0);;?></td>
                
                <td align="center"><?php echo $data->disburse->noa;?></td>
                <td align="right"><?php echo number_format($data->disburse->up,0);?></td>
                <td align="right"><?php echo number_format($data->disburse->tiket,0);?></td>
                <?php
                    $totalNoaYesReg += $data->ost_yesterday->noa_regular;
                    $totalOstYesReg += $data->ost_yesterday->os_regular;
                    $totalNoaOstTodayRegKredit += $data->ost_today->noa_regular;
                    $totalUpOstTodayRegKredit += $data->ost_today->up_regular;
                    $totalNoaOstTodayRegPelunasan += $data->ost_today->noa_repyment_regular;
                    $totalUpOstTodayRegPelunasan  += $data->ost_today->repyment_regular;
                    $totalNoaTodayReg += $totalnoareg_;
                    $totalOstTodayReg += $totalosreg_;

                    $totalNoaYesCcl += $data->ost_yesterday->noa_mortages;
                    $totalOstYesCcl += $data->ost_yesterday->os_mortages;
                    $totalNoaOstTodayCclKredit += $data->ost_today->noa_mortage;
                    $totalUpOstTodayCclKredit += $data->ost_today->up_mortage;
                    $totalNoaOstTodayCclPelunasan += $data->ost_today->noa_repayment_mortage;
                    $totalUpOstTodayCclPelunasan  += $data->ost_today->repayment_mortage;
                    $totalNoaTodayCcl += $totalnoacicilan_;
                    $totalOstTodayCcl += $totaloscicilan_;
                    $totalallosunit_ +=$totalosunit_;
                    $totalnoadisburse_  += $data->disburse->noa;
                    $totalupdisburse_   += $data->disburse->up;
                    $totalticket_       += $data->disburse->tiket;
                ?>
            </tr>
            <?php //} ?>
            <?php endforeach ?>
            <tr bgcolor="#ffff00">
                <td align="right" colspan="2"> Total_</td>
                <td align="center"><?php echo number_format($totalNoaYesReg,0); ?></td>
                <td align="right"><?php echo number_format($totalOstYesReg,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstTodayRegKredit,0); ?></td>
                <td align="right"><?php echo number_format($totalUpOstTodayRegKredit,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstTodayRegPelunasan,0); ?></td>
                <td align="right"><?php echo number_format($totalUpOstTodayRegPelunasan,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaTodayReg,0); ?></td>
                <td align="right"><?php echo number_format($totalOstTodayReg,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaYesCcl,0); ?></td>
                <td align="right"><?php echo number_format($totalOstYesCcl,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstTodayCclKredit,0); ?></td>
                <td align="right"><?php echo number_format($totalUpOstTodayCclKredit,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstTodayCclPelunasan,0); ?></td>
                <td align="right"><?php echo number_format($totalUpOstTodayCclPelunasan,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaTodayCcl,0); ?></td>
                <td align="right"><?php echo number_format($totalOstTodayCcl,0); ?></td>
                <td align="right"><?php echo number_format($totalallosunit_,0); ?></td>
                <td align="center"><?php echo number_format($totalnoadisburse_,0); ?></td>
                <td align="right"><?php echo number_format($totalupdisburse_,0); ?></td>
                <td align="right"><?php echo number_format($totalticket_,0); ?></td>
            </tr>
    </table>


