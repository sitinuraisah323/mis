<h3>Outstanding Nasional <?php echo date('d-m-Y'); ?></h3>
<table class="table" border="1">
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

<h3><br/>DPD Nasional <?php echo date('d-m-Y'); ?></h3>
<table class="table" border="1">
	<thead class="thead-light">
	<tr  bgcolor="#cccccc">
		<th class="text-center">No</th>
		<th>Unit</th>
		<th>Area</th>
		<th class="text-center">Open</th>
		<th class="text-center">Ijin Ojk</th>
		<th colspan="2" class="text-center">DPD Kemarin</th>
		<th colspan="2" class="text-center">DPD Hari Ini</th>
		<th colspan="2" class="text-center">Pelunasan DPD Hari Ini</th>
		<th colspan="2" class="text-center">Total DPD</th>
		<th class="text-center">%</th>
	</tr>
	<tr  bgcolor="#cccccc">
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th class="text-center">Noa</th>
		<th class="text-right">Ost</th>
		<th class="text-center">Noa</th>
		<th class="text-right">Ost</th>
		<th class="text-center">Noa</th>
		<th class="text-right">Ost</th>
		<th class="text-center">Noa</th>
		<th class="text-right">Ost</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php $no=0;
	$dpdYesterdayNoa =0;
	 $dpdYesterdayUp =0;
    $dpdTodayNoa =0;
	 $dpdTodayUp=0;
	$dpdRepaymentNoa=0;
	$dpdRepaymenUp=0;
	$dpdTotalNoa=0;
	$dpdTotalUp=0;
	$percentage=0;
	foreach($outstanding as $data): $no++;?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td align="left"><?php echo $data->name;?></td>
			<td align="center"><?php echo $data->area;?></td>
			<td align="center">-</td>
			<td align="center">-</td>
			<td align="center"><?php echo $data->dpd_yesterday->noa;?></td>
			<td align="right"><?php echo number_format($data->dpd_yesterday->ost,0);?></td>
			<td align="center"><?php echo $data->dpd_today->noa;?></td>
			<td align="right"><?php echo number_format($data->dpd_today->ost,0);?></td>
			<td align="center"><?php echo $data->dpd_repayment_today->noa;?></td>
			<td align="right"><?php echo number_format($data->dpd_repayment_today->ost,0);?></td>
			<td align="center"><?php echo $data->total_dpd->noa;?></td>
			<td align="right"><?php echo number_format($data->total_dpd->ost,0);?></td>
			<td align="right"><?php echo $data->percentage;?></td>
			<?php
			$dpdYesterdayNoa +=$data->dpd_yesterday->noa;
			$dpdYesterdayUp +=$data->dpd_yesterday->ost;
			$dpdTodayNoa +=$data->dpd_today->noa;
			$dpdTodayUp+=$data->dpd_today->ost;
			$dpdRepaymentNoa+=$data->dpd_repayment_today->noa;
			$dpdRepaymenUp+=$data->dpd_repayment_today->ost;
			$dpdTotalNoa+=$data->total_dpd->noa;
			$dpdTotalUp+=$data->total_dpd->ost;
			$percentage += $data->percentage;
			?>
		</tr>
	<?php endforeach ?>
		<tr>
			<td align="right" colspan="5">Total </td>
			<td><?php echo $dpdYesterdayNoa?></td>
			<td><?php echo $dpdYesterdayUp;?></td>
			<td><?php echo $dpdTodayNoa;?></td>
			<td><?php echo $dpdTodayUp;?></td>
			<td><?php echo $dpdRepaymentNoa;?></td>
			<td><?php echo $dpdRepaymenUp;?></td>
			<td><?php echo $dpdTotalNoa;?></td>
			<td><?php echo $dpdTotalUp;?></td>
			<td><?php echo $percentage/$no;?></td>
		</tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>
<h3>Pencairan <?php echo date('d-m-Y'); ?></h3>
<table class="table" border="1">
	<?php $total = [];?>
	<?php foreach ($pencairan as $index => $data):?>
		<?php if($index == 0):?>
			<tr bgcolor="#cccccc">
				<td><?php echo $data['no'];?></td>
				<td><?php echo $data['unit'];?></td>
				<td><?php echo $data['area'];?></td>
				<?php foreach ($data['dates'] as $key => $date):?>
					<td><?php echo $date;?></td>
				<?php endforeach;?>
			</tr>
		<?php else:?>
			<tr>
				<td><?php echo $data->id;?></td>
				<td><?php echo $data->name;?></td>
				<td><?php echo $data->area;?></td>
				<?php foreach ($data->dates as $key => $date):?>
					<?php if(key_exists($key,$total)):?>
						<?php $total[$key] = $total[$key]+$date;?>
					<?php else:?>
						<?php $total[$key] = $date;?>
					<?php endif;?>
					<td><?php echo number_format($date, 2);?></td>
				<?php endforeach;?>
			</tr>
		<?php endif;?>
	<?php endforeach;?>

	<tfoot>
	<tr><td colspan="3" class="text-right">Total</td>
		<?php foreach ($total as $value):?>
			<td><?php echo money($value);?></td>
		<?php endforeach;?>
	</tr>
	</tfoot></table>

<h3>Pelunasan <?php echo date('d-m-Y'); ?></h3>
<table class="table" border="1">
	<?php $total = [];?>
	<?php foreach ($pelunasan as $index => $data):?>
		<?php if($index == 0):?>
			<tr bgcolor="#cccccc">
				<td><?php echo $data['no'];?></td>
				<td><?php echo $data['unit'];?></td>
				<td><?php echo $data['area'];?></td>
				<?php foreach ($data['dates'] as $date):?>
					<td><?php echo $date;?></td>
				<?php endforeach;?>
			</tr>
		<?php else:?>
			<tr>
				<td><?php echo $data->id;?></td>
				<td><?php echo $data->name;?></td>
				<td><?php echo $data->area;?></td>
				<?php foreach ($data->dates as $key => $date):?>
					<?php if(key_exists($key,$total)):?>
							<?php $total[$key] = $total[$key]+$date;?>
					<?php else:?>
						<?php $total[$key] = $date;?>
					<?php endif;?>
					<td><?php echo money($date);?></td>
				<?php endforeach;?>
			</tr>
		<?php endif;?>
	<?php endforeach;?>
	<tfoot>
		<tr><td colspan="3" class="text-right">Total</td>
			<?php foreach ($total as $value):?>
				<td><?php echo money($value);?></td>
			<?php endforeach;?>
		</tr>
	</tfoot>
</table>
