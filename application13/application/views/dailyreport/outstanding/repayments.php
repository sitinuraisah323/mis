<h3>Pelunasan Nasional (<?php echo date('F Y', strtotime($datetrans)); ?>)</h3>
<table class="table" border="1">
	<thead class="thead-light">
	<tr  bgcolor="#cccccc">
		<th align="center" width="20" rowspan="2"> No </th>
		<th width="120" rowspan="2"> Unit</th>
		<th width="100" rowspan="2" > Area</th>
		<th width="300" colspan="3" align="center">Total Pelunasan Akumulasi  (<?php echo date('d F Y', strtotime($datetrans)); ?>)</th>
		<th width="300"colspan="3" align="center" >Total Pelunasan Today  (<?php echo date('d F Y', strtotime($datetrans)); ?>)</th>
	</tr>
	<tr>
		<th width=100 align="right">Jumlah</th>
		<th width=100 align="center"> kurang 120 Hari </th>
		<th width=100 align="center"> lebih 120 Hari</th>
		<th width=100 align="right">Jumlah</th>
		<th width=100 align="center"> kurang 120 Hari </th>
		<th width=100 align="center"> lebih 120 Hari</th>
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
	foreach($repayments as $data): $no++;?>
		<tr>
			<td width="20" align="center"> <?php echo $no;?></td>
			<td width="120" align="left"> <?php echo $data->unit;?></td>
			<td width="100" align="left"> <?php echo $data->area;?></td>
			<td width="100" align="right"> <?php echo money($data->akumulasi_up);?></td>
			<td width="100" align="center"> <?php echo round($data->akumulasi_prev, 2). ' %';?></td>
			<td width="100" align="center"> <?php echo round($data->akumulasi_over).' %';?></td>
			<td width="100" align="right"> <?php echo money($data->today_up);?></td>
			<td width="100" align="center"> <?php echo round($data->today_prev, 2). ' %';?></td>
			<td width="100" align="center"> <?php echo round($data->today_over, 2). ' %';?></td>
		</tr>
		<?php
			$akumulasi_over += $data->akumulasi_over;
			$akumulasi_up += $data->akumulasi_up;
			$akumulasi_prev += $data->akumulasi_prev;
			$today_up +=  $data->today_up;
			$today_prev +=  $data->today_prev;
			$today_over +=  $data->today_over;
		?>
	<?php endforeach ?>
    <tr bgcolor="yellow">
    <td colspan="3" align="right">Total</td>
	<td width="100" align="right"><?php echo money($akumulasi_up);?></td>
	<td width="100" align="center"><?php echo round($akumulasi_prev/$no).' %';?></td>
	<td width="100" align="center"><?php echo round($akumulasi_over/$no).' %';?></td>
	<td width="100" align="right"><?php echo money($today_up);?></td>
	<td width="100" align="center"><?php echo round($today_prev/$no).' %';?></td>
	<td width="100" align="center"><?php echo round($today_over/$no).' %';?></td>
    </tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>