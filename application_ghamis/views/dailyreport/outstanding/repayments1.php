<h3>Pelunasan Nasional (<?php echo date('F Y', strtotime($datetrans)); ?>)</h3>
<table class="table" border="1">
	<thead class="thead-light">
	<tr  bgcolor="#cccccc">
		<th align="center" width="20" rowspan="3"> No </th>
		<th width="120" rowspan="3"> Unit</th>
		<th width="70" rowspan="3" > Area</th>
		<th width="300" colspan="4" align="center">Total Pelunasan Akumulasi  (<?php echo date('d F Y', strtotime($datetrans)); ?>)</th>
		<th width="400"colspan="8" align="center" >Total Pelunasan Today  (<?php echo date('d F Y', strtotime($datetrans)); ?>)</th>
	</tr>
	<tr>
		<th width=100 rowspan="2" align="right">NOA</th>
		<th width=100 rowspan="2" align="right">Jumlah</th>
		<th width=100   rowspan="2"align="center"> kurang 120 Hari </th>
		<th width=100  rowspan="2" align="center"> lebih 120 Hari</th>
		<th width=200 colspan="3" align="right">Reguler</th>
		<th width=200 colspan="3" align="right">Cicilan</th>
	</tr>
	<tr>
		<th width=100 rowspan="2" align="right">NOA</th>
		<th width=100 rowspan="2" align="right">Jumlah</th>
		<th width=50   rowspan="2"align="center"> kurang 120 Hari </th>
		<th width=50  rowspan="2" align="center"> lebih 120 Hari</th>
		<th width=100 rowspan="2" align="right">Jumlah</th>
		<th width=50   rowspan="2"align="center"> kurang 120 Hari </th>
		<th width=50  rowspan="2" align="center"> lebih 120 Hari</th>
	</tr>
	</thead>
	<tbody>
	<?php $no=0;
	$total =0;
	$akumulasi_over = 0;
	$akumulasi_up = 0;
	$akumulasi_prev = 0;
	$today_up = 0;
	$today_prev = 0;
	$today_over = 0;
	$today_up_loan = 0;
	$today_prev_loan = 0;
	$today_over_loan = 0;
	$no_loan  = 0;
	$noa_ak = 0;
	$noa_to =0;
	foreach($repayments as $data): $no++;?>
		<tr>
			<td width="20" align="center"> <?php echo $no;?></td>
			<td width="120" align="left"> <?php echo $data->unit;?></td>
			<td width="70" align="left"> <?php echo $data->area;?></td>
			<td width="100" align="right"> <?php echo money($data->noa_ak);?></td>
			<td width="100" align="right"> <?php echo money($data->akumulasi_up);?></td>
			<td width="100" align="center"> <?php echo round($data->akumulasi_prev, 2). ' %';?></td>
			<td width="100" align="center"> <?php echo round($data->akumulasi_over).' %';?></td>
			
			<td width="100" align="right"> <?php echo money($data->noa_to);?></td>
			<td width="100" align="right"> <?php echo money($data->today_up);?></td>
			<td width="50" align="center"> <?php echo round($data->today_prev, 2). ' %';?></td>
			<td width="50" align="center"> <?php echo round($data->today_over, 2). ' %';?></td>
			<td width="100" align="right"> <?php echo money($data->today_up_loan);?></td>
			<td width="50" align="center"> <?php echo round($data->today_prev_loan, 2). ' %';?></td>
			<td width="50" align="center"> <?php echo round($data->today_over_loan, 2). ' %';?></td>

		</tr>
		<?php
			$akumulasi_over += $data->akumulasi_over;
			$akumulasi_up += $data->akumulasi_up;
			$akumulasi_prev += $data->akumulasi_prev;
			$today_up +=  $data->today_up;
			$today_prev +=  $data->today_prev;
			$today_over +=  $data->today_over;
			$today_up_loan +=  $data->today_up_loan;
			$today_prev_loan +=  $data->today_prev_loan;
			$today_over_loan +=  $data->today_over_loan;
			$noa_ak += $data->noa_ak;
			$noa_to += $data->noa_to;
			if($data->today_up_loan){
				$no_loan++;
			}
		?>
	<?php endforeach ?>
    <tr bgcolor="yellow">
    <td colspan="4" align="right">Total</td>
	
	<td width="100" align="right"><?php echo money($noa_ak);?></td>
	<td width="100" align="right"><?php echo money($akumulasi_up);?></td>
	<td width="100" align="center"><?php echo round($akumulasi_prev/$no).' %';?></td>
	<td width="100" align="center"><?php echo round($akumulasi_over/$no).' %';?></td>
	
	<td width="100" align="right"><?php echo money($noa_to);?></td>
	<td width="100" align="right"><?php echo money($today_up);?></td>
	<td width="50" align="center"><?php echo round($today_prev/$no).' %';?></td>
	<td width="50" align="center"><?php echo round($today_over/$no).' %';?></td>
	<td width="100" align="right"><?php echo money($today_up_loan);?></td>
	<td width="50" align="center"><?php echo round($today_prev_loan/$no_loan).' %';?></td>
	<td width="50" align="center"><?php echo round($today_over_loan/$no_loan).' %';?></td>
    </tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>