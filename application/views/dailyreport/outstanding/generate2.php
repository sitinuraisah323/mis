<h3>Outstanding Nasional <?php echo date('d-m-Y');  ?></h3>
<?php  
    $dateOST = date('d-m-Y',strtotime($datetrans));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($datetrans)));

    $totalNoaOstYesterday = 0;
    $totalNoaOstToday= 0;
    $totalUpOstToday= 0;
    $totalUpaOstYesterday = 0;
    $totalRepaymentTodayUp = 0;
    $totalRepaymentTodayNoa = 0;
    $totalOstNoa = 0;
    $totalOstUp = 0;
    //mortages
    $totalNoaOstYesterdayMor = 0;
    $totalNoaOstTodayMor = 0;
    $totalUpOstTodayMor = 0;
    $totalUpaOstYesterdayMor = 0;
    $totalRepaymentTodayUpMor = 0;
    $totalRepaymentTodayNoaMor = 0;
    $totalOstNoaMor = 0;
    $totalOstUpMor = 0;
    $totalOst = 0;

    $totalOstTicket = 0;
    $totalDisbureNoa = 0;
    $totalDisbureUp = 0;
    $totalDisbureTicket = 0;
    $activate = 1;
?>
<hr />

<?php 
    // var_dump($outstanding); exit;
    foreach($outstanding as $area => $datas):

    // var_dump($datas->area); exit;
    // echo $datas->activate; exit;
        // if( $activate == 1){
    // if($areas == "Jawa Barat"){
    //     $areas = 0;
    // }
    if($areas !== "Makasar"){
        $areas == 0;
    
    
    if($areas !== "Jawa Barat"){
    ?>

<table class="table" border="1">
    <tr bgcolor="#aaaa55">
        <td colspan="25" align="center" width="1400"><?php echo $area;?></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center" width="20">No</td>
        <td rowspan="2" align="left" width="120"> Unit</td>
        <td colspan="8" align="center" width="480">Gadai Reguler</td>
        <td colspan="8" align="center" width="480">Gadai Cicilan</td>
        <td rowspan="2" align="center" width="100">Total <br />Outstanding <br />(<?php echo $dateOST; ?>)</td>
        <td colspan="3" align="center" width="200">Disburse</td>
    </tr>
    <tr>
        <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Regular<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
        <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
    </tr>
    <?php 
            }
        }
                //initial 
                $totalNoaYesterday = 0;
                $totalUpYesterday = 0;
                $totalNoaReg = 0;
                $totalUpReg = 0;
                $totalNoaMor = 0;
                $totalUpMor = 0;
                $totalOut = 0;
                $totalNoaRegArea = 0;
                $totalUpRegArea = 0;
                $totalNoaRepRegArea = 0;
                $totalUpRepRegArea = 0;
                $totalUpArea = 0;

                $totalNoaOstYesterdayArea = 0;
                $totalNoaOstTodayArea = 0;
                $totalUpOstTodayArea = 0;
                $totalUpaOstYesterdayArea = 0;
                $totalRepaymentTodayUpArea = 0;
                $totalRepaymentTodayNoaArea = 0;
                $totalOstNoaArea = 0;
                $totalOstUpArea = 0;

                $totalNoaOstYesterdayAreaMor = 0;
                $totalNoaOstTodayAreaMor = 0;
                $totalUpOstTodayAreaMor = 0;
                $totalUpaOstYesterdayAreaMor = 0;
                $totalRepaymentTodayUpAreaMor = 0;
                $totalRepaymentTodayNoaAreaMor = 0;
                $totalOstNoaAreaMor = 0;
                $totalOstUpAreaMor = 0;

                $totalDisbureNoaArea = 0;
                $totalDisbureUpArea = 0;
                $totalDisbureTicketArea = 0;
                $no_ = 0;

            ?>
    <?php foreach($datas as $data): $no_++;?>
    <?php
        //     echo $data->activate; exit;
        if( $data->activate == 1){
                //perhitungan total unit
                $totalNoaReg = ($data->ost_yesterday->noa_os_reguler + $data->ost_today->noa_reguler)-($data->ost_today->noa_rep_reguler);
                $totalUpReg = ($data->ost_yesterday->os_reguler+ $data->ost_today->up_reguler)-($data->ost_today->up_rep_reguler);
                $totalNoaMor = ($data->ost_yesterday->noa_os_mortages + $data->ost_today->noa_mortages)-($data->ost_today->noa_rep_mortages);
                $totalUpMor = ($data->ost_yesterday->os_mortages+ $data->ost_today->up_mortages)-($data->ost_today->up_rep_mortages);
                $totalOut = $totalUpReg + $totalUpMor; 

                //perhitungan total area
                $totalNoaYesterday  += $data->ost_yesterday->noa_os_reguler;
                $totalUpYesterday   += $data->ost_yesterday->os_reguler;
                $totalNoaRegArea    += $data->ost_today->noa_reguler;
                $totalUpRegArea     += $data->ost_today->up_reguler;
                $totalNoaRepRegArea += $data->ost_today->noa_mortages;
                $totalUpRepRegArea  += $data->ost_today->up_mortages;

                $totalNoaOstYesterdayArea += $data->ost_yesterday->noa_os_reguler;
                $totalUpaOstYesterdayArea += $data->ost_yesterday->os_reguler;
                $totalNoaOstTodayArea += $data->ost_today->noa_reguler;
                $totalUpOstTodayArea += $data->ost_today->up_reguler;
                $totalRepaymentTodayUpArea += $data->ost_today->up_rep_reguler;
                $totalRepaymentTodayNoaArea += $data->ost_today->noa_rep_reguler;
                $totalOstNoaArea += $totalNoaReg;
                $totalOstUpArea += $totalUpReg;

                $totalNoaOstYesterdayAreaMor += $data->ost_yesterday->noa_os_mortages;
                $totalUpaOstYesterdayAreaMor += $data->ost_yesterday->os_mortages;
                $totalNoaOstTodayAreaMor += $data->ost_today->noa_mortages;
                $totalUpOstTodayAreaMor += $data->ost_today->up_mortages;
                $totalRepaymentTodayUpAreaMor += $data->ost_today->up_rep_mortages;
                $totalRepaymentTodayNoaAreaMor += $data->ost_today->noa_rep_mortages;
                $totalOstNoaAreaMor += $totalNoaMor;
                $totalOstUpAreaMor += $totalUpMor;

                $totalUpArea +=$totalOut;

                $totalDisbureNoaArea += $data->total_disburse->noa;
                $totalDisbureUpArea += $data->total_disburse->credit;
                $totalDisbureTicketArea += $data->total_disburse->tiket;

                //all resume
                $totalNoaOstYesterday += $data->ost_yesterday->noa_os_reguler;
                $totalUpaOstYesterday += $data->ost_yesterday->os_reguler;
                $totalNoaOstToday += $data->ost_today->noa_reguler;
                $totalUpOstToday += $data->ost_today->up_reguler;
                $totalRepaymentTodayUp += $data->ost_today->up_rep_reguler;
                $totalRepaymentTodayNoa += $data->ost_today->noa_rep_reguler;
                $totalOstNoa += $totalNoaReg;
                $totalOstUp += $totalUpReg;

                $totalNoaOstYesterdayMor += $data->ost_yesterday->noa_os_mortages;
                $totalUpaOstYesterdayMor += $data->ost_yesterday->os_mortages;
                $totalNoaOstTodayMor += $data->ost_today->noa_mortages;
                $totalUpOstTodayMor += $data->ost_today->up_mortages;
                $totalRepaymentTodayUpMor += $data->ost_today->up_rep_mortages;
                $totalRepaymentTodayNoaMor += $data->ost_today->noa_rep_mortages;
                $totalOstNoaMor += $totalNoaMor;
                $totalOstUpMor += $totalUpMor;

                $totalOst +=  $totalUpReg+$totalUpMor;

                $totalDisbureNoa += $data->total_disburse->noa;
                $totalDisbureUp += $data->total_disburse->credit;
                $totalDisbureTicket += $data->total_disburse->tiket;
            ?>
    <tr>
        <td align="center"><?php echo $no_; ?></td>
        <td align="left"> <?php echo $data->name;?></td>

        <td align="center"><?php echo $data->ost_yesterday->noa_os_reguler;?></td>
        <td align="right"><?php echo number_format($data->ost_yesterday->os_reguler,0);?></td>
        <td align="center"><?php echo $data->ost_today->noa_reguler;?></td>
        <td align="right"><?php echo number_format($data->ost_today->up_reguler,0);?></td>
        <td align="center"><?php echo $data->ost_today->noa_rep_reguler;?></td>
        <td align="right"><?php echo number_format($data->ost_today->up_rep_reguler,0);?></td>
        <td align="center"><?php echo number_format($totalNoaReg,0); ?></td>
        <td align="right"><?php echo number_format($totalUpReg,0); ?></td>

        <td align="center"><?php echo $data->ost_yesterday->noa_os_mortages;?></td>
        <td align="right"><?php echo number_format($data->ost_yesterday->os_mortages,0);?></td>
        <td align="center"><?php echo $data->ost_today->noa_mortages;?></td>
        <td align="right"><?php echo number_format($data->ost_today->up_mortages,0);?></td>
        <td align="center"><?php echo $data->ost_today->noa_rep_mortages;?></td>
        <td align="right"><?php echo number_format($data->ost_today->up_rep_mortages,0);?></td>
        <td align="center"><?php echo number_format($totalNoaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalUpMor,0); ?></td>

        <td align="right"><?php echo number_format($totalOut,0); ?></td>

        <td align="center"><?php echo number_format($data->total_disburse->noa,0); ?></td>
        <td align="right"><?php echo number_format($data->total_disburse->credit,0); ?></td>
        <td align="right"><?php echo number_format($data->total_disburse->tiket,0);?></td>
    </tr>
    <?php
             }
            endforeach;
            
        if($data->activate == 1){
 ?>

    <tr bgcolor="#ffff00">
        <td align="right" colspan="2"> Total_</td>
        <td align="center"><?php echo number_format($totalNoaOstYesterdayArea,0); ?></td>
        <td align="right"><?php echo number_format($totalUpaOstYesterdayArea,0); ?></td>
        <td align="center"><?php echo number_format($totalNoaOstTodayArea,0); ?></td>
        <td align="right"><?php echo number_format($totalUpOstTodayArea,0); ?></td>
        <td align="center"><?php echo number_format($totalRepaymentTodayNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($totalRepaymentTodayUpArea,0); ?></td>
        <td align="center"><?php echo number_format($totalOstNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($totalOstUpArea,0); ?></td>
        <td align="center"><?php echo number_format($totalNoaOstYesterdayAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalUpaOstYesterdayAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($totalNoaOstTodayAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalUpOstTodayAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($totalRepaymentTodayNoaAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalRepaymentTodayUpAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($totalOstNoaAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalOstUpAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalUpArea,0); ?></td>

        <td align="center"><?php echo number_format($totalDisbureNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($totalDisbureUpArea,0); ?></td>
        <td align="right"><?php echo number_format($totalDisbureUpArea/$totalDisbureNoaArea,0); ?></td>

    </tr>
</table>
<br /><br />

<?php 
    }
    endforeach;?>


<!-- Gcore Jabar -->
<h3>Gcore Outstanding Nasional <?php echo date('d-m-Y');  ?></h3>
<?php  
    $dateOST = date('d-m-Y',strtotime($datetrans));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($datetrans)));

    $noaOstYesterday = 0;
    $noaOstToday= 0;
    $upOstToday= 0;
    $upaOstYesterday = 0;
    $repaymentTodayUp = 0;
    $repaymentTodayNoa = 0;
    $ostNoa = 0;
    $ostUp = 0;
    //mortages
    $noaOstYesterdayMor = 0;
    $noaOstTodayMor = 0;
    $upOstTodayMor = 0;
    $upaOstYesterdayMor = 0;
    $repaymentTodayUpMor = 0;
    $repaymentTodayNoaMor = 0;
    $ostNoaMor = 0;
    $ostUpMor = 0;
    $ost = 0;

    $ostTicket = 0;
    $disbureNoa = 0;
    $disbureUp = 0;
    $disbureTicket = 0;
?>
<hr />

<?php  
    // echo $datas->activate; exit;
        // if( $activate == 1){
    ?>

<table class="table" border="1">
    <tr bgcolor="#aaaa55">
        <td colspan="25" align="center" width="1400"><?php echo "Jawa Barat";?></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center" width="20">No</td>
        <td rowspan="2" align="left" width="120"> Unit</td>
        <td colspan="8" align="center" width="480">Gadai Reguler</td>
        <td colspan="8" align="center" width="480">Gadai Cicilan</td>
        <td rowspan="2" align="center" width="100">Total <br />Outstanding <br />(<?php echo $dateOST; ?>)</td>
        <td colspan="3" align="center" width="200">Disburse</td>
    </tr>
    <tr>
        <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Regular<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
        <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
    </tr>
    <?php 
            // }
                //initial 
                $noaYesterday = 0;
                $upYesterday = 0;
                $noaReg = 0;
                $upReg = 0;
                $noaMor = 0;
                $upMor = 0;
                $out = 0;
                $noaRegArea = 0;
                $upRegArea = 0;
                $noaRepRegArea = 0;
                $upRepRegArea = 0;
                $upArea = 0;

                $noaOstYesterdayArea = 0;
                $noaOstTodayArea = 0;
                $upOstTodayArea = 0;
                $upaOstYesterdayArea = 0;
                $repaymentTodayUpArea = 0;
                $repaymentTodayNoaArea = 0;
                $ostNoaArea = 0;
                $ostUpArea = 0;

                $noaOstYesterdayAreaMor = 0;
                $noaOstTodayAreaMor = 0;
                $upOstTodayAreaMor = 0;
                $upaOstYesterdayAreaMor = 0;
                $repaymentTodayUpAreaMor = 0;
                $repaymentTodayNoaAreaMor = 0;
                $ostNoaAreaMor = 0;
                $ostUpAreaMor = 0;

                $disbureNoaArea = 0;
                $disbureUpArea = 0;
                $disbureTicketArea = 0;
                $no_ = 0;

                $noaRegSis = 0;
                $upRegSis =0;
                $noaMor = 0;
                $upMor = 0;
                $out =0 ;


            ?>
    <?php foreach($osSiscol as $datas => $datasa): 
            foreach($datasa as $data): $no_++;?>
    <?php
            // var_dump($data); exit;
        //     echo $data->activate; exit;
        // if( $activate == 1){
               //perhitungan total unit
                $noaRegSis = ($data->regular->yesterday->noa + $data->regular->today->noa)-($data->regular->repayment->noa);
                $upRegSis = ($data->regular->yesterday->os+ $data->regular->today->os)-($data->regular->repayment->os);

                $noaMor = ($data->regular->yesterday->no + $data->ost_today->noa_mortages)-($data->ost_today->noa_rep_mortages);
                $upMor = ($data->regular->yesterday->os+ $data->ost_today->up_mortages)-($data->ost_today->up_rep_mortages);
                $out = $upRegSis + $upMorSis; 

                //perhitungan total area
                $noaYesterday  += $data->regular->yesterday->noa;
                $upYesterday   += $data->regular->yesterday->os;
                $noaRegArea    += $data->regular->disbursement->noa;
                $upRegArea     += $data->regular->disbursement->os;
                $noaRepRegArea += $data->ost_today->noa_mortages;
                $upRepRegArea  += $data->ost_today->up_mortages;

                $noaOstYesterdayArea += $data->regular->yesterday->noa;
                $upaOstYesterdayArea += $data->regular->yesterday->os;
                $noaOstTodayArea += $data->regular->disbursement->noa;
                $upOstTodayArea += $data->regular->disbursement->os;
                $repaymentTodayUpArea += $data->regular->repayment->noa;
                $repaymentTodayNoaArea += $data->regular->repayment->noa;
                $ostNoaArea += $noaRegSis;
                $ostUpArea += $upRegSis;

                $noaOstYesterdayAreaMor += $data->ost_yesterday->noa_os_mortages;
                $upaOstYesterdayAreaMor += $data->ost_yesterday->os_mortages;
                $noaOstTodayAreaMor += $data->ost_today->noa_mortages;
                $upOstTodayAreaMor += $data->ost_today->up_mortages;
                $repaymentTodayUpAreaMor += $data->ost_today->up_rep_mortages;
                $repaymentTodayNoaAreaMor += $data->ost_today->noa_rep_mortages;
                $ostNoaAreaMor += $totalNoaMor;
                $ostUpAreaMor += $totalUpMor;

                $upArea += $out;

                $disbureNoaArea += $data->disburse->noa;
                $disbureUpArea += $data->disburse->credit;
                $disbureTicketArea += $data->disburse->ticket_size;

                //all resume
                $noaOstYesterday += $data->regular->yesterday->noa;
                $upaOstYesterday += $data->regular->yesterday->os;
                $noaOstToday += $data->regular->disbursement->noa;
                $upOstToday += $data->regular->disbursement->os;
                $repaymentTodayUp += $data->regular->repayment->os;
                $repaymentTodayNoa += $data->regular->repayment->noa;
                $ostNoa += $noaRegSis;
                $ostUp += $upRegSis;

                $noaOstYesterdayMor += $data->ost_yesterday->noa_os_mortages;
                $upaOstYesterdayMor += $data->ost_yesterday->os_mortages;
                $noaOstTodayMor += $data->ost_today->noa_mortages;
                $upOstTodayMor += $data->ost_today->up_mortages;
                $repaymentTodayUpMor += $data->ost_today->up_rep_mortages;
                $repaymentTodayNoaMor += $data->ost_today->noa_rep_mortages;
                $ostNoaMor += $noaMor;
                $ostUpMor += $upMor;

                $ost +=  $upReg+$upMor;

                $disbureNoa += $data->disburse->noa;
                $disbureUp += $data->disburse->credit;
                $disbureTicket += $data->disburse->ticket_size;
                $mortage = 0;
            ?>
    <tr>
        <td align="center"><?php echo $no_; ?></td>
        <td align="left"> <?php echo $data->unit_name;?></td>

        <td align="center"><?php echo $data->regular->yesterday->noa;?></td>
        <td align="right"><?php echo number_format($data->regular->yesterday->os,0);?></td>
        <td align="center"><?php echo $data->regular->disbursement->noa;?></td>
        <td align="right"><?php echo number_format($data->regular->disbursement->os,0);?></td>
        <td align="center"><?php echo $data->regular->repayment->noa;?></td>
        <td align="right"><?php echo number_format($data->regular->repayment->os,0);?></td>
        <td align="center"><?php echo number_format($noaRegSis,0); ?></td>
        <td align="right"><?php echo number_format($upRegSis,0); ?></td>

        <td align="center"><?php echo $mortage?></td>
        <td align="right"><?php echo number_format($mortage,0);?></td>
        <td align="center"><?php echo $mortage?></td>
        <td align="right"><?php echo number_format($mortage,0);?></td>
        <td align="center"><?php echo $mortage?></td>
        <td align="right"><?php echo number_format($mortage,0);?></td>
        <td align="center"><?php echo number_format($mortage,0); ?></td>
        <td align="right"><?php echo number_format($mortage,0); ?></td>

        <td align="right"><?php echo number_format($out,0); ?></td>

        <td align="center"><?php echo $data->disburse->noa;?></td>
        <td align="right"><?php echo number_format($data->disburse->credit,0);?></td>
        <td align="right"><?php echo number_format($data->disburse->ticket_size,0);?></td>
    </tr>
    <?php
            //  }
            endforeach;
            endforeach;
           
        // if($activate == 1){
 ?>

    <tr bgcolor="#ffff00">
        <td align="right" colspan="2"> Total_</td>
        <td align="center"><?php echo number_format($noaOstYesterdayArea,0); ?></td>
        <td align="right"><?php echo number_format($upaOstYesterdayArea,0); ?></td>
        <td align="center"><?php echo number_format($noaOstTodayArea,0); ?></td>
        <td align="right"><?php echo number_format($upOstTodayArea,0); ?></td>
        <td align="center"><?php echo number_format($repaymentTodayNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($repaymentTodayUpArea,0); ?></td>
        <td align="center"><?php echo number_format($ostNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($ostUpArea,0); ?></td>
        <td align="center"><?php echo number_format($noaOstYesterdayAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($upaOstYesterdayAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($noaOstTodayAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($upOstTodayAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($repaymentTodayNoaAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($repaymentTodayUpAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($mortage,0); ?></td>
        <td align="right"><?php echo number_format($mortage,0); ?></td>
        <td align="right"><?php echo number_format($upArea,0); ?></td>

        <td align="center"><?php echo number_format($disbureNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($disbureUpArea,0); ?></td>
        <td align="right"><?php echo number_format($disbureUpArea/$disbureNoaArea,0); ?></td>

    </tr>
</table>
<br /><br />

<?php 
    // }
    // endforeach;?>

<!-- End GCore Jabar -->

<!-- Gcore Makasar -->
<!-- <h3>Gcore Outstanding Nasional <?php echo date('d-m-Y');  ?></h3> -->
<?php  
    $dateOST = date('d-m-Y',strtotime($datetrans));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($datetrans)));

    $noaOstYesterdayMakasar = 0;
    $noaOstTodayMakasar= 0;
    $upOstTodayMakasar= 0;
    $upaOstYesterdayMakasar = 0;
    $repaymentTodayUpMakasar = 0;
    $repaymentTodayNoaMakasar = 0;
    $ostNoaMakasar = 0;
    $ostUpMakasar = 0;
    //mortages
    $noaOstYesterdayMor = 0;
    $noaOstTodayMor = 0;
    $upOstTodayMor = 0;
    $upaOstYesterdayMor = 0;
    $repaymentTodayUpMor = 0;
    $repaymentTodayNoaMor = 0;
    $ostNoaMor = 0;
    $ostUpMor = 0;
    $ostMakasar = 0;

    $ostTicketMakasar = 0;
    $disbureNoaMakasar = 0;
    $disbureUpMakasar = 0;
    $disbureTicketMakasar = 0;
?>
<hr />

<?php 
    // echo $datas->activate; exit;
        // if( $activate == 1){
    ?>

<table class="table" border="1">
    <tr bgcolor="#aaaa55">
        <td colspan="25" align="center" width="1400"><?php echo "Makasar";?></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center" width="20">No</td>
        <td rowspan="2" align="left" width="120"> Unit</td>
        <td colspan="8" align="center" width="480">Gadai Reguler</td>
        <td colspan="8" align="center" width="480">Gadai Cicilan</td>
        <td rowspan="2" align="center" width="100">Total <br />Outstanding <br />(<?php echo $dateOST; ?>)</td>
        <td colspan="3" align="center" width="200">Disburse</td>
    </tr>
    <tr>
        <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Regular<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
        <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
    </tr>
    <?php 
            // }
                //initial 
                $noaYesterday = 0;
                $upYesterday = 0;
                $noaReg = 0;
                $upReg = 0;
                $noaMor = 0;
                $upMor = 0;
                $out = 0;
                $noaRegArea = 0;
                $upRegArea = 0;
                $noaRepRegArea = 0;
                $upRepRegArea = 0;
                $upArea = 0;

                $noaOstYesterdayArea = 0;
                $noaOstTodayArea = 0;
                $upOstTodayArea = 0;
                $upaOstYesterdayArea = 0;
                $repaymentTodayUpArea = 0;
                $repaymentTodayNoaArea = 0;
                $ostNoaArea = 0;
                $ostUpArea = 0;

                $noaOstYesterdayAreaMor = 0;
                $noaOstTodayAreaMor = 0;
                $upOstTodayAreaMor = 0;
                $upaOstYesterdayAreaMor = 0;
                $repaymentTodayUpAreaMor = 0;
                $repaymentTodayNoaAreaMor = 0;
                $ostNoaAreaMor = 0;
                $ostUpAreaMor = 0;

                $disbureNoaArea = 0;
                $disbureUpArea = 0;
                $disbureTicketArea = 0;
                $no_ = 0;

                $noaRegSis = 0;
                $upRegSis =0;
                $noaMor = 0;
                $upMor = 0;
                $out =0 ;


            ?>
    <?php foreach($panakukang as $datas => $datasa): $no_++;
            foreach($datasa as $data): ?>
    <?php
            // var_dump($data); exit;
        //     echo $data->activate; exit;
        // if( $activate == 1){
               //perhitungan total unit
                $noaRegSis = ($data->regular->yesterday->noa + $data->regular->today->noa)-($data->regular->repayment->noa);
                $upRegSis = ($data->regular->yesterday->os+ $data->regular->today->os)-($data->regular->repayment->os);

                $noaMor = ($data->regular->yesterday->no + $data->ost_today->noa_mortages)-($data->ost_today->noa_rep_mortages);
                $upMor = ($data->regular->yesterday->os+ $data->ost_today->up_mortages)-($data->ost_today->up_rep_mortages);
                $out = $upRegSis + $upMorSis; 

                //perhitungan total area
                $noaYesterday  += $data->regular->yesterday->noa;
                $upYesterday   += $data->regular->yesterday->os;
                $noaRegArea    += $data->regular->disbursement->noa;
                $upRegArea     += $data->regular->disbursement->os;
                $noaRepRegArea += $data->ost_today->noa_mortages;
                $upRepRegArea  += $data->ost_today->up_mortages;

                $noaOstYesterdayArea += $data->regular->yesterday->noa;
                $upaOstYesterdayArea += $data->regular->yesterday->os;
                $noaOstTodayArea += $data->regular->disbursement->noa;
                $upOstTodayArea += $data->regular->disbursement->os;
                $repaymentTodayUpArea += $data->regular->repayment->noa;
                $repaymentTodayNoaArea += $data->regular->repayment->noa;
                $ostNoaArea += $noaRegSis;
                $ostUpArea += $upRegSis;

                $noaOstYesterdayAreaMor += $data->ost_yesterday->noa_os_mortages;
                $upaOstYesterdayAreaMor += $data->ost_yesterday->os_mortages;
                $noaOstTodayAreaMor += $data->ost_today->noa_mortages;
                $upOstTodayAreaMor += $data->ost_today->up_mortages;
                $repaymentTodayUpAreaMor += $data->ost_today->up_rep_mortages;
                $repaymentTodayNoaAreaMor += $data->ost_today->noa_rep_mortages;
                $ostNoaAreaMor += $totalNoaMor;
                $ostUpAreaMor += $totalUpMor;

                $upArea += $out;

                $disbureNoaArea += $data->disburse->noa;
                $disbureUpArea += $data->disburse->credit;
                $disbureTicketArea += $data->disburse->ticket_size;

                //all resume
                $ostYesterdayMakasar += $data->regular->yesterday->noa;
                $upaOstYesterdayMakasar += $data->regular->yesterday->os;
                $noaOstTodayMakasar += $data->regular->today->noa;
                $upOstTodayMakasar += $data->regular->today->os;
                $repaymentTodayUpMakasar += $data->regular->repayment->os;
                $repaymentTodayNoaMakasar += $data->regular->repayment->noa;
                $ostNoaMakasar += $noaReg;
                $ostUpMakasar += $upReg;

                $noaOstYesterdayMorMakasar += $data->ost_yesterday->noa_os_mortages;
                $upaOstYesterdayMorMakasar += $data->ost_yesterday->os_mortages;
                $noaOstTodayMorMakasar += $data->ost_today->noa_mortages;
                $upOstTodayMorMakasar += $data->ost_today->up_mortages;
                $repaymentTodayUpMorMakasar += $data->ost_today->up_rep_mortages;
                $repaymentTodayNoaMorMakasar += $data->ost_today->noa_rep_mortages;
                $ostNoaMorMakasar += $noaMor;
                $ostUpMorMakasar += $upMor;

                $ostMakasar +=  $upReg+$upMor;

                $disbureNoaMakasar += $data->disburse->noa;
                $disbureUpMakasar += $data->disburse->credit;
                $disbureTicketMakasar += $data->disburse->ticket_size;
                $mortage = 0;
            ?>
    <tr>
        <td align="center"><?php echo $no_; ?></td>
        <td align="left"> <?php echo $data->unit_name;?></td>

        <td align="center"><?php echo $data->regular->yesterday->noa;?></td>
        <td align="right"><?php echo number_format($data->regular->yesterday->os,0);?></td>
        <td align="center"><?php echo $data->regular->disbursement->noa;?></td>
        <td align="right"><?php echo number_format($data->regular->disbursement->os,0);?></td>
        <td align="center"><?php echo $data->regular->repayment->noa;?></td>
        <td align="right"><?php echo number_format($data->regular->repayment->os,0);?></td>
        <td align="center"><?php echo number_format($noaRegSis,0); ?></td>
        <td align="right"><?php echo number_format($upRegSis,0); ?></td>

        <td align="center"><?php echo $mortage?></td>
        <td align="right"><?php echo number_format($mortage,0);?></td>
        <td align="center"><?php echo $mortage?></td>
        <td align="right"><?php echo number_format($mortage,0);?></td>
        <td align="center"><?php echo $mortage?></td>
        <td align="right"><?php echo number_format($mortage,0);?></td>
        <td align="center"><?php echo number_format($mortage,0); ?></td>
        <td align="right"><?php echo number_format($mortage,0); ?></td>

        <td align="right"><?php echo number_format($out,0); ?></td>

        <td align="center"><?php echo $data->disburse->noa;?></td>
        <td align="right"><?php echo number_format($data->disburse->credit,0);?></td>
        <td align="right"><?php echo number_format($data->disburse->ticket_size,0);?></td>
    </tr>
    <?php
            //  }
            endforeach;
            endforeach;
           
        // if($activate == 1){
 ?>

    <tr bgcolor="#ffff00">
        <td align="right" colspan="2"> Total_</td>
        <td align="center"><?php echo number_format($noaOstYesterdayArea,0); ?></td>
        <td align="right"><?php echo number_format($upaOstYesterdayArea,0); ?></td>
        <td align="center"><?php echo number_format($noaOstTodayArea,0); ?></td>
        <td align="right"><?php echo number_format($upOstTodayArea,0); ?></td>
        <td align="center"><?php echo number_format($repaymentTodayNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($repaymentTodayUpArea,0); ?></td>
        <td align="center"><?php echo number_format($ostNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($ostUpArea,0); ?></td>
        <td align="center"><?php echo number_format($noaOstYesterdayAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($upaOstYesterdayAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($noaOstTodayAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($upOstTodayAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($repaymentTodayNoaAreaMor,0); ?></td>
        <td align="right"><?php echo number_format($repaymentTodayUpAreaMor,0); ?></td>
        <td align="center"><?php echo number_format($mortage,0); ?></td>
        <td align="right"><?php echo number_format($mortage,0); ?></td>
        <td align="right"><?php echo number_format($upArea,0); ?></td>

        <td align="center"><?php echo number_format($disbureNoaArea,0); ?></td>
        <td align="right"><?php echo number_format($disbureUpArea,0); ?></td>
        <td align="right"><?php echo number_format($disbureUpArea/$disbureNoaArea,0); ?></td>

    </tr>
</table>
<br /><br />

<?php 
    // }
    // endforeach;?>

<!-- End GCore Makasar -->

<table class="table" border="1">
    <tr bgcolor="#D4D5D5">
        <td colspan="23" align="center" width="1400">Summary Outstanding</td>
    </tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center" width="140" class="text-md-center">Total <br />Outstanding
            Kemarin<br />(<?php echo $dateLastOST; ?>)</td>
        <!-- <td rowspan="2" align="left" width="120"></td> -->
        <td colspan="8" align="center" width="480">Total Gadai Reguler</td>
        <td colspan="8" align="center" width="480">Total Gadai Cicilan</td>
        <td rowspan="2" align="center" width="100"><br />Total <br />Outstanding <br />(<?php echo $dateOST; ?>)</td>
        <td colspan="3" align="center" width="200">Total Disburse</td>
    </tr>
    <tr>
        <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Regular<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br />(<?php echo $dateLastOST; ?>)</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
        <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
        <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
        <td align="center" width="30" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan<br />(<?php echo $dateOST; ?>)</td>

        <td align="center" width="40" bgcolor="#b8b894">Noa</td>
        <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
        <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
    </tr>

    <?php 
            // var_dump($totalDisbureUpArea/$totalDisbureNoaArea); 
            // var_dump($disbureTicket); 
            // var_dump($disbureTicketMakasar); exit; 
            ?>

    <tr bgcolor="#ffff00">
        <td align="center">
            <?php echo number_format($totalUpaOstYesterday + $totalUpaOstYesterdayMor + $upaOstYesterday + $upaOstYesterdayMor + $upaOstYesterdayMakasar + $upaOstYesterdayMorMakasar,0);  ?>
        </td>
        <td align="center">
            <?php echo number_format($totalNoaOstYesterday + $noaOstYesterday + $noaOstYesterdayMakasar,0); ?></td>
        <td align="right">
            <?php echo number_format($totalUpaOstYesterday + $upaOstYesterday + $upaOstYesterdayMakasar,0); ?></td>
        <td align="center"><?php echo number_format($totalNoaOstToday + $noaOstToday + $noaOstTodayMakasar,0); ?></td>
        <td align="right"><?php echo number_format($totalUpOstToday + $upOstToday + $upOstTodayMakasar,0); ?></td>
        <td align="center">
            <?php echo number_format($totalRepaymentTodayNoa + $repaymentTodayNoa + $repaymentTodayNoaMakasar,0); ?>
        </td>
        <td align="right">
            <?php echo number_format($totalRepaymentTodayUp + $repaymentTodayUp + $repaymentTodayUpMakasar,0); ?></td>
        <td align="center"><?php echo number_format($totalOstNoa + $ostNoa + $ostNoaMakasar,0); ?></td>
        <td align="right"><?php echo number_format($totalOstUp + $ostUp + $ostUpMakasar,0); ?></td>
        <td align="center"><?php echo number_format($totalNoaOstYesterdayMor ,0); ?></td>
        <td align="right"><?php echo number_format($totalUpaOstYesterdayMor,0); ?></td>
        <td align="center"><?php echo number_format($totalNoaOstTodayMor,0); ?></td>
        <td align="right"><?php echo number_format($totalUpOstTodayMor,0); ?></td>
        <td align="center"><?php echo number_format($totalRepaymentTodayNoaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalRepaymentTodayUpMor,0); ?></td>
        <td align="center"><?php echo number_format($totalOstNoaMor,0); ?></td>
        <td align="right"><?php echo number_format($totalOstUpMor,0); ?></td>
        <td align="right"><?php echo number_format($totalOst + $ost + $ostMakasar,0); ?></td>
        <td align="center"><?php echo number_format($totalDisbureNoa + $disbureNoa + $disbureNoaMakasar,0); ?></td>
        <td align="right"><?php echo number_format($totalDisbureUp + $disbureUp + $disbureUpMakasar,0); ?></td>
        <td align="right"><?php echo number_format($totalDisbureTicket + $disbureTicket + $disbureTicketMakasar,0); ?>
        </td>
    </tr>
</table>