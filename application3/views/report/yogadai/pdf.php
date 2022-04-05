<h3>Outstanding Nasional <?php echo date('d-m-Y');  ?></h3>
<?php  
    $dateOST = date('d-m-Y',strtotime($datetrans));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($datetrans)));

    // $totalNoaOstYesterday = 0;
    // $totalNoaOstToday= 0;
    // $totalUpOstToday= 0;
    // $totalUpaOstYesterday = 0;
    // $totalRepaymentTodayUp = 0;
    // $totalRepaymentTodayNoa = 0;
    // $totalOstNoa = 0;
    // $totalOstUp = 0;
    // $totalNoaOstYesterdayMor = 0;
    // $totalNoaOstTodayMor = 0;
    // $totalUpOstTodayMor = 0;
    // $totalUpaOstYesterdayMor = 0;
    // $totalRepaymentTodayUpMor = 0;
    // $totalRepaymentTodayNoaMor = 0;
    // $totalOstNoaMor = 0;
    // $totalOstUpMor = 0;
    // $totalOst = 0;
    // $totalOstTicket = 0;
    // $totalDisbureNoa = 0;
    // $totalDisbureUp = 0;
    // $totalDisbureTicket = 0;
?>
<hr/>

         <table class="table" border="1">
            <tr bgcolor="#cccccc">
                <td rowspan="2" align="center"  width="20">No</td>
                <td rowspan="2" align="left" width="120"> Unit</td>
                <td colspan="6" align="center" width="350">Gadai Reguler</td>
                <td colspan="4" align="center" width="240">Gadai Cicilan</td>
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
            
                <td align="center" width="30" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894">Kredit</td>
                <td align="center" width="30" bgcolor="#d6d6c2">Noa</td>
                <td align="center" width="90" bgcolor="#d6d6c2">Pelunasan</td>
             
                <td align="center" width="40" bgcolor="#b8b894">Noa</td>
                <td align="center" width="90" bgcolor="#b8b894"> Kredit</td>
                <td align="center" width="70" bgcolor="#b8b894"> Ticket Size</td>
            </tr>
            <?php $no_ = 0;?>
            <?php foreach($outstanding->data as $data): $no_++;?>
            <tr>
                <td align="center"><?php echo $no_; ?></td>
                <td align="left"> <?php echo $data->name;?></td>

                <td align="center"><?php echo $data->ost_yesterday->noa;?></td>
                <td align="right"><?php echo number_format($data->ost_yesterday->up,0);?></td>
                <td align="center"><?php echo $data->credit_today->noa_reguler;?></td>
                <td align="right"><?php echo number_format($data->credit_today->up_reguler,0);?></td>
                <td align="center"><?php echo $data->repayment_today->noa_reguler;?></td>
                <td align="right"><?php echo number_format($data->repayment_today->up_reguler,0);?></td>
           

                <td align="center"><?php echo $data->credit_today->noa_mortages;?></td>
                <td align="right"><?php echo number_format($data->credit_today->up_mortages,0);?></td>
                <td align="center"><?php echo $data->repayment_today->noa_mortages;?></td>
                <td align="right"><?php echo number_format($data->repayment_today->up_mortages,0);?></td>
          
                <td align="right"><?php echo number_format($data->total_outstanding->up,0); ?></td>
                
                <td align="center"><?php echo $data->total_disburse->noa;?></td>
                <td align="right"><?php echo number_format($data->total_disburse->credit,0);?></td>
                <td align="right"><?php echo number_format($data->total_disburse->tiket,0);?></td>
            </tr>
            <?php endforeach;?>
    </table>