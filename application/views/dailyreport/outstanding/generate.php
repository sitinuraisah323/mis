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
?>
<hr/>

    <?php foreach($outstanding as $area => $datas):?>
    <table class="table" border="1">
            <tr bgcolor="#aaaa55">
                <td colspan="25" align="center" width="1400"><?php echo $area;?></td>
            </tr>
            <tr bgcolor="#cccccc">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="left" width="120"> Unit</td>
                <td colspan="8" align="center" width="480">Gadai Reguler</td>
                <td colspan="8" align="center" width="480">Gadai Cicilan</td>
                <td rowspan="2" align="center" width="100">Total <br/>Outstanding <br/>(<?php echo $dateOST; ?>)</td>
                <td colspan="3" align="center" width="200">Disburse</td>
            </tr>
            <tr>
                <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br/>(<?php echo $dateLastOST; ?>)</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Ost. Regular<br/>(<?php echo $dateOST; ?>)</td>

                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br/>(<?php echo $dateLastOST; ?>)</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan<br/>(<?php echo $dateOST; ?>)</td>

                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
                <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
            </tr>
            <?php 
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

            ?>
            <?php $no_ = 0;?>
            <?php foreach($datas as $data): $no_++;?>
            <?php
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
                
                <td align="center"><?php echo $data->total_disburse->noa;?></td>
                <td align="right"><?php echo number_format($data->total_disburse->credit,0);?></td>
                <td align="right"><?php echo number_format($data->total_disburse->tiket,0);?></td>
            </tr>
            <?php endforeach;?>
           
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
    <br/><br/>
    <?php endforeach;?>

    <table class="table" border="1"> 
    <tr bgcolor="#D4D5D5">
        <td colspan="23" align="center" width="1400">Summary Outstanding</td>
    </tr>  
    <tr bgcolor="#cccccc">
                <td rowspan="2" align="center"  width="140" class="text-md-center">Total <br/>Outstanding Kemarin<br/>(<?php echo $dateLastOST; ?>)</td>
                <!-- <td rowspan="2" align="left" width="120"></td> -->
                <td colspan="8" align="center" width="480">Total Gadai Reguler</td>
                <td colspan="8" align="center" width="480">Total Gadai Cicilan</td>
                <td rowspan="2" align="center" width="100"><br/>Total <br/>Outstanding <br/>(<?php echo $dateOST; ?>)</td>
                <td colspan="3" align="center" width="200">Total Disburse</td>
            </tr>
            <tr>
                <td align="center" width="40" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br/>(<?php echo $dateLastOST; ?>)</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="80" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="80" bgcolor="#d6d6c2">Pelunasan</td>
                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Ost. Regular<br/>(<?php echo $dateOST; ?>)</td>

                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Ost.Kemarin <br/>(<?php echo $dateLastOST; ?>)</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Ost. Cicilan<br/>(<?php echo $dateOST; ?>)</td>

                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
                <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
            </tr>         
    <tr bgcolor="#ffff00">
                <td align="center"><?php echo number_format($totalUpaOstYesterday + $totalUpaOstYesterdayMor,0);  ?></td>
                <td align="center"><?php echo number_format($totalNoaOstYesterday,0); ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterday,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstToday,0); ?></td>
                <td align="right"><?php echo number_format($totalUpOstToday,0); ?></td>
                <td align="center"><?php echo number_format($totalRepaymentTodayNoa,0); ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUp,0); ?></td>
                <td align="center"><?php echo number_format($totalOstNoa,0); ?></td>
                <td align="right"><?php echo number_format($totalOstUp,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstYesterdayMor,0); ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterdayMor,0); ?></td>
                <td align="center"><?php echo number_format($totalNoaOstTodayMor,0); ?></td>
                <td align="right"><?php echo number_format($totalUpOstTodayMor,0); ?></td>
                <td align="center"><?php echo number_format($totalRepaymentTodayNoaMor,0); ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUpMor,0); ?></td>
                <td align="center"><?php echo number_format($totalOstNoaMor,0); ?></td>
                <td align="right"><?php echo number_format($totalOstUpMor,0); ?></td>
                <td align="right"><?php echo number_format($totalOst,0); ?></td>
                <td align="center"><?php echo number_format($totalDisbureNoa,0); ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp,0); ?></td>
                <td align="right"><?php echo number_format($totalDisbureTicket,0); ?></td>
            </tr>
</table>