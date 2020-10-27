<h3>Outstanding Nasional <?php echo date('d-m-Y'); ?></h3>
<hr/>
    <?php 
    $totalNoaOstYesterday_ = 0;
    $totalNoaOstToday_ = 0;
    $totalUpOstToday_ = 0;
    $totalUpaOstYesterday_ = 0;
    $totalRepaymentTodayUp_ = 0;
    $totalRepaymentTodayNoa_ = 0;
    $totalOstNoa_ = 0;
    $totalOstUp_ = 0;
    $totalOstTicket_ = 0;
    $totalDisbureNoa_ = 0;
    $totalDisbureUp_ = 0;
    $totalDisbureTicket_ = 0;
    $dateOST = date('d-m-Y',strtotime($datetrans));
    $dateLastOST = date('d-m-Y', strtotime('-1 days', strtotime($datetrans)))

    ?>
    <table class="table" border="1">
            <tr bgcolor="#aaaa55">
                <td colspan="14" align="center" width="900">JAWA BARAT</td>
            </tr>
            <tr bgcolor="#cccccc">
            <td rowspan="2" align="center"  width="20">No</td>
            <td rowspan="2" align="left" width="120">Unit</td>
            <!-- <td rowspan="2" align="center" width="25">Open</td>
            <td rowspan="2" align="center" width="20">OJK</td> -->
            <td colspan="2" align="center" width="120">OST Sebelumnya(<?php echo $dateLastOST;?>)</td>
            <td colspan="2" align="center" width="120">Kredit(<?php echo $datetrans;?>)</td>
            <td colspan="2" align="center" width="120">Pelunasan & Cicilan(<?php echo $datetrans;?>)</td>
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
            <?php if($data->area=='Jawa Barat'){ ?>
            <tr>
                <td align="center"><?php echo $no;?></td>
                <td align="left"><?php echo $data->name;?></td>
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
            <?php } ?>
            <?php endforeach ?>
            <tr>
                <td align="right" colspan="2"> </td>
                <td align="center"><?php echo $totalNoaOstYesterday; ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterday,0); ?></td>
                <td align="center"><?php echo $totalNoaOstToday; ?></td>
                <td align="right"><?php echo number_format($totalUpOstToday,0); ?></td>
                <td align="center"><?php echo $totalRepaymentTodayNoa; ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUp,0); ?></td>
                <td align="center"><?php echo $totalOstNoa; ?></td>
                <td align="right"><?php echo number_format($totalOstUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalOstUp/$totalOstNoa),0); ?></td>
                <td align="center"><?php echo $totalDisbureNoa; ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalDisbureUp/$totalDisbureNoa),0); ?></td>
            </tr>
           </table>

           <?php 
           $totalNoaOstYesterday_   = $totalNoaOstYesterday;
           $totalNoaOstToday_       = $totalNoaOstToday;
           $totalUpOstToday_        = $totalUpOstToday;
           $totalUpaOstYesterday_   = $totalUpaOstYesterday;
           $totalRepaymentTodayUp_  = $totalRepaymentTodayUp;
           $totalRepaymentTodayNoa_ = $totalRepaymentTodayNoa;
           $totalOstNoa_            = $totalOstNoa;
           $totalOstUp_             = $totalOstUp;
           $totalOstTicket_         = $totalOstTicket;
           $totalDisbureNoa_        = $totalDisbureNoa;
           $totalDisbureUp_         = $totalDisbureUp;
           $totalDisbureTicket_     = $totalDisbureTicket;
           ?>

            <br/><br/>
           <table class="table" border="1">
           <tr bgcolor="#aaaa55">
                <td colspan="14" align="center" width="900">JAWA TIMUR</td>
            </tr>
            <tr bgcolor="#cccccc">
            <td rowspan="2" align="center"  width="20">No</td>
            <td rowspan="2" align="center" width="120">Unit</td>
            <!-- <td rowspan="2" align="center" width="25">Open</td>
            <td rowspan="2" align="center" width="20">OJK</td> -->
            <td colspan="2" align="center" width="120">OST Sebelumnya(<?php echo $dateLastOST;?>)</td>
            <td colspan="2" align="center" width="120">Kredit(<?php echo $datetrans;?>)</td>
            <td colspan="2" align="center" width="120">Pelunasan & Cicilan(<?php echo $datetrans;?>)</td>
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
            <?php if($data->area=='Jawa Timur'){ ?>
            <tr>
                <td align="center"><?php echo $no;?></td>
                <td align="left"><?php echo $data->name;?></td>
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
            <?php } ?>
            <?php endforeach ?>
            <tr>
                <td align="right" colspan="2"> </td>
                <td align="center"><?php echo $totalNoaOstYesterday; ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterday,0); ?></td>
                <td align="center"><?php echo $totalNoaOstToday; ?></td>
                <td align="right"><?php echo number_format($totalUpOstToday,0); ?></td>
                <td align="center"><?php echo $totalRepaymentTodayNoa; ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUp,0); ?></td>
                <td align="center"><?php echo $totalOstNoa; ?></td>
                <td align="right"><?php echo number_format($totalOstUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalOstUp/$totalOstNoa),0); ?></td>
                <td align="center"><?php echo $totalDisbureNoa; ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalDisbureUp/$totalDisbureNoa),0); ?></td>
            </tr>
</table>

            <?php 
           $totalNoaOstYesterday_   = $totalNoaOstYesterday_ + $totalNoaOstYesterday;
           $totalNoaOstToday_       = $totalNoaOstToday_ + $totalNoaOstToday;
           $totalUpOstToday_        = $totalUpOstToday_ + $totalUpOstToday;
           $totalUpaOstYesterday_   = $totalUpaOstYesterday_ + $totalUpaOstYesterday;
           $totalRepaymentTodayUp_  = $totalRepaymentTodayUp_ + $totalRepaymentTodayUp;
           $totalRepaymentTodayNoa_ = $totalRepaymentTodayNoa_ + $totalRepaymentTodayNoa;
           $totalOstNoa_            = $totalOstNoa_ + $totalOstNoa;
           $totalOstUp_             = $totalOstUp_ + $totalOstUp;
           $totalOstTicket_         = $totalOstTicket_ + $totalOstTicket;
           $totalDisbureNoa_        = $totalDisbureNoa_ + $totalDisbureNoa;
           $totalDisbureUp_         = $totalDisbureUp_ + $totalDisbureUp;
           $totalDisbureTicket_     = $totalDisbureTicket_ + $totalDisbureTicket;
           ?>

<br/><br/>
           <table class="table" border="1">
           <tr bgcolor="#aaaa55">
                <td colspan="14" align="center" width="900">NTB</td>
            </tr>
            <tr bgcolor="#cccccc">
            <td rowspan="2" align="center"  width="20">No</td>
            <td rowspan="2" align="center" width="120">Unit</td>
            <!-- <td rowspan="2" align="center" width="25">Open</td>
            <td rowspan="2" align="center" width="20">OJK</td> -->
            <td colspan="2" align="center" width="120">OST Sebelumnya(<?php echo $dateLastOST;?>)</td>
            <td colspan="2" align="center" width="120">Kredit(<?php echo $datetrans;?>)</td>
            <td colspan="2" align="center" width="120">Pelunasan & Cicilan(<?php echo $datetrans;?>)</td>
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
            <?php if($data->area=='NTB'){ ?>
            <tr>
                <td align="center"><?php echo $no;?></td>
                <td align="left"><?php echo $data->name;?></td>
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
            <?php } ?>
            <?php endforeach ?>
            <tr>
                <td align="right" colspan="2"> </td>
                <td align="center"><?php echo $totalNoaOstYesterday; ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterday,0); ?></td>
                <td align="center"><?php echo $totalNoaOstToday; ?></td>
                <td align="right"><?php echo number_format($totalUpOstToday,0); ?></td>
                <td align="center"><?php echo $totalRepaymentTodayNoa; ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUp,0); ?></td>
                <td align="center"><?php echo $totalOstNoa; ?></td>
                <td align="right"><?php echo number_format($totalOstUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalOstUp/$totalOstNoa),0); ?></td>
                <td align="center"><?php echo $totalDisbureNoa; ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalDisbureUp/$totalDisbureNoa),0); ?></td>
            </tr>
</table>

            <?php 
           $totalNoaOstYesterday_   = $totalNoaOstYesterday_ + $totalNoaOstYesterday;
           $totalNoaOstToday_       = $totalNoaOstToday_ + $totalNoaOstToday;
           $totalUpOstToday_        = $totalUpOstToday_ + $totalUpOstToday;
           $totalUpaOstYesterday_   = $totalUpaOstYesterday_ + $totalUpaOstYesterday;
           $totalRepaymentTodayUp_  = $totalRepaymentTodayUp_ + $totalRepaymentTodayUp;
           $totalRepaymentTodayNoa_ = $totalRepaymentTodayNoa_ + $totalRepaymentTodayNoa;
           $totalOstNoa_            = $totalOstNoa_ + $totalOstNoa;
           $totalOstUp_             = $totalOstUp_ + $totalOstUp;
           $totalOstTicket_         = $totalOstTicket_ + $totalOstTicket;
           $totalDisbureNoa_        = $totalDisbureNoa_ + $totalDisbureNoa;
           $totalDisbureUp_         = $totalDisbureUp_ + $totalDisbureUp;
           $totalDisbureTicket_     = $totalDisbureTicket_ + $totalDisbureTicket;
           ?>

<br/><br/>
           <table class="table" border="1">
           <tr bgcolor="#aaaa55">
                <td colspan="14" align="center" width="900">NTT</td>
            </tr>
            <tr bgcolor="#cccccc">
            <td rowspan="2" align="center"  width="20">No</td>
            <td rowspan="2" align="center" width="120">Unit</td>
            <!-- <td rowspan="2" align="center" width="25">Open</td>
            <td rowspan="2" align="center" width="20">OJK</td> -->
            <td colspan="2" align="center" width="120">OST Sebelumnya(<?php echo $dateLastOST;?>)</td>
            <td colspan="2" align="center" width="120">Kredit(<?php echo $datetrans;?>)</td>
            <td colspan="2" align="center" width="120">Pelunasan & Cicilan(<?php echo $datetrans;?>)</td>
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
            <?php if($data->area=='NTT'){ ?>
            <tr>
                <td align="center"><?php echo $no;?></td>
                <td align="left"><?php echo $data->name;?></td>
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
            <?php } ?>
            <?php endforeach ?>
            <tr>
                <td align="right" colspan="2"> </td>
                <td align="center"><?php echo $totalNoaOstYesterday; ?></td>
                <td align="right"><?php echo number_format($totalUpaOstYesterday,0); ?></td>
                <td align="center"><?php echo $totalNoaOstToday; ?></td>
                <td align="right"><?php echo number_format($totalUpOstToday,0); ?></td>
                <td align="center"><?php echo $totalRepaymentTodayNoa; ?></td>
                <td align="right"><?php echo number_format($totalRepaymentTodayUp,0); ?></td>
                <td align="center"><?php echo $totalOstNoa; ?></td>
                <td align="right"><?php echo number_format($totalOstUp,0); ?></td>
                <td align="right"><?php echo number_format(round($totalOstUp/$totalOstNoa),0); ?></td>
                <td align="center"><?php echo $totalDisbureNoa; ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp,0); ?></td>
                <td align="right"><?php echo number_format($totalDisbureUp/$totalDisbureNoa,0); ?></td>
            </tr>
</table>
            <?php 
           $totalNoaOstYesterday_   = $totalNoaOstYesterday_ + $totalNoaOstYesterday;
           $totalNoaOstToday_       = $totalNoaOstToday_ + $totalNoaOstToday;
           $totalUpOstToday_        = $totalUpOstToday_ + $totalUpOstToday;
           $totalUpaOstYesterday_   = $totalUpaOstYesterday_ + $totalUpaOstYesterday;
           $totalRepaymentTodayUp_  = $totalRepaymentTodayUp_ + $totalRepaymentTodayUp;
           $totalRepaymentTodayNoa_ = $totalRepaymentTodayNoa_ + $totalRepaymentTodayNoa;
           $totalOstNoa_            = $totalOstNoa_ + $totalOstNoa;
           $totalOstUp_             = $totalOstUp_ + $totalOstUp;
           $totalOstTicket_         = $totalOstTicket_ + $totalOstTicket;
           $totalDisbureNoa_        = $totalDisbureNoa_ + $totalDisbureNoa;
           $totalDisbureUp_         = $totalDisbureUp_ + $totalDisbureUp;
           $totalDisbureTicket_     = $totalDisbureTicket_ + $totalDisbureTicket;
           ?>
<br/>
<table class="table" border="1">            
    <tr bgcolor="#ffff00">
        <td align="right" colspan="2" width="140">Total </td>
        <td align="center"  width="40"><?php echo $totalNoaOstYesterday_; ?></td>
        <td align="right" width="80"><?php echo number_format($totalUpaOstYesterday_,0); ?></td>
        <td align="center"  width="40"><?php echo $totalNoaOstToday_; ?></td>
        <td align="right" width="80"><?php echo number_format($totalUpOstToday_,0); ?></td>
        <td align="center"  width="40"><?php echo $totalRepaymentTodayNoa_; ?></td>
        <td align="right" width="80"><?php echo number_format($totalRepaymentTodayUp_,0); ?></td>
        <td align="center"  width="40"><?php echo $totalOstNoa_; ?></td>
        <td align="right" width="80"><?php echo number_format($totalOstUp_,0); ?></td>
        <td align="right" width="80"><?php echo number_format(round($totalOstUp_/$totalOstNoa_),0); ?></td>
        <td align="center"  width="40"><?php echo $totalDisbureNoa_; ?></td>
        <td align="right" width="80"><?php echo number_format($totalDisbureUp_,0); ?></td>
        <td align="right" width="80"><?php echo number_format(round($totalDisbureUp_/$totalDisbureNoa_),0); ?></td>
    </tr>
</table>
