<h3>Outstanding Nasional <?php echo date('d-m-Y'); ?></h3>
<hr/>

    <table class="table" border="1">
            <!-- <tr>
                <td rowspan="20" align="center">Jawa Barat</td>
            </tr> -->
            <tr bgcolor="#cccccc">
            <td rowspan="2" align="center"  width="20">No</td>
            <td rowspan="2" align="center" width="120">Unit</td>
            <td rowspan="2" align="center" width="60">Area</td>
            <!-- <td rowspan="2" align="center" width="25">Open</td>
            <td rowspan="2" align="center" width="20">OJK</td> -->
            <td colspan="2" align="center" width="120">OST Kemarin</td>
            <td colspan="2" align="center" width="120">Kredit Hari ini</td>
            <td colspan="2" align="center" width="120">Pelunasan & Cicilan Hari ini</td>
            <td colspan="3" align="center" width="200">Total Outstanding</td>
            <td colspan="3" align="center" width="200">Total Disburse</td>
            </tr>
            <tr bgcolor="#cccccc">
            <td align="center" width="40">Noa</td>
            <td align="center" width="80">Ost</td>
            <td align="center" width="40">Noa</td>
            <td align="center" width="80">Kredit</td>
            <td align="center" width="40">Noa</td>
            <td align="center" width="80">Kredit</td>
            <td align="center" width="40">Noa</td>
            <td align="center" width="80">Ost</td>
            <td align="center" width="80">Ticket Size</td>
            <td align="center" width="40">Noa</td>
            <td align="center" width="80">Kredit</td>
            <td align="center" width="80">Ticket Size</td>
            </tr>
            <?php $no=0;
                  $totalNoaOstYesterday = 0;
                  $totalNoaOstToday = 0;
                  $totalUpOstToday = 0;
                  $totalUpaOstYesterday = 0;
                  $totalRepaymentTodayUp = 0;
                  $totalRepaymentTodayNoa = 0;
                  $totalOstNoa = 0;
                  $totalOstUp = 0;
                  $totalOstTicket = 0;
                  $totalDisbureNoa = 0;
                  $totalDisbureUp = 0;
                  $totalDisbureTicket = 0;
            foreach($outstanding as $data): $no++;?>
            <tr>
                <td align="center"><?php echo $no;?></td>
                <td align="left"><?php echo $data->name;?></td>
                <td align="center"><?php echo $data->area;?></td>
                <!-- <td align="center">-</td>
                <td align="center">-</td> -->
                <td align="center"><?php echo $data->ost_yesterday->noa;?></td>
                <td align="right"><?php echo number_format($data->ost_yesterday->up,0);?></td>
                <td align="center"><?php echo $data->credit_today->noa;?></td>
                <td align="right"><?php echo number_format($data->credit_today->up,0);?></td>
                <td align="center"><?php echo $data->repayment_today->noa;?></td>
                <td align="right"><?php echo number_format($data->repayment_today->up,0);?></td>
                <td align="center"><?php echo $data->total_outstanding->noa;?></td>
                <td align="right"><?php echo number_format($data->total_outstanding->up,0);?></td>
                <td align="right"><?php echo number_format($data->total_outstanding->tiket,0);?></td>
                <td align="center"><?php echo $data->total_disburse->noa;?></td>
                <td align="right"><?php echo number_format($data->total_disburse->credit,0);?></td>
                <td align="right"><?php echo number_format($data->total_disburse->tiket,0);?></td>
                <?php
                    $totalNoaOstYesterday += $data->ost_yesterday->noa;
                    $totalNoaOstToday += $data->credit_today->noa;
                    $totalUpOstToday += $data->credit_today->up;
                    $totalUpaOstYesterday += $data->ost_yesterday->up;
                    $totalRepaymentTodayUp += $data->repayment_today->up;
                    $totalRepaymentTodayNoa += $data->repayment_today->noa;
                    $totalOstNoa += $data->total_outstanding->noa;
                    $totalOstUp += $data->total_outstanding->up;
                    $totalOstTicket += $data->total_outstanding->tiket;
                    $totalDisbureNoa += $data->total_disburse->noa;
                    $totalDisbureUp += $data->total_disburse->credit;
                    $totalDisbureTicket += $data->total_disburse->tiket;
                ?>
            </tr>
            <?php endforeach ?>
            <tr>
                <td align="right" colspan="3">Total </td>
                <td align="center"><?php echo $totalNoaOstYesterday; ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterday,0); ?></td>
                <td align="center"><?php echo $totalNoaOstToday; ?></td>
                <td align="right"><?php echo number_format($totalUpOstToday,0); ?></td>
                <td align="center"><?php echo $totalRepaymentTodayNoa; ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUp,0); ?></td>
                <td align="center"><?php echo $totalOstNoa; ?></td>
                <td align="right"><?php echo number_format($totalOstUp,0); ?></td>
                <td align="right"><?php echo number_format($totalOstTicket,0); ?></td>
                <td align="center"><?php echo $totalDisbureNoa; ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp,0); ?></td>
                <td align="right"><?php echo number_format($totalDisbureTicket,0); ?></td>
            </tr>
           </table>

