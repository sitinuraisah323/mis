<h3>Pencapaian Target <?php echo date('d-m-Y'); ?></h3>
<table class="table" border="1">
	<thead class="thead-light">
	<tr  bgcolor="#cccccc">
		<th align="center" width="5%"> No </th>
		<th width="20%"> Unit</th>
		<th width="20%"> Area</th>
		<th width="20%" align="right"> Credit </th>
		<th width="20%" align="right"> Target </th>
		<th width="15%" align="center"> Persentas (%) </th>

	</tr>
	</thead>
	<tbody>
	<?php $no=0;
	$totalCredit =0;
	$totalUp = 0;
	$totalPersent = 0;
	foreach($data as $data): $no++;?>
		<tr>
			<td width="5%" align="center"> <?php echo $no;?></td>
			<td width="20%" align="left"> <?php echo $data->name;?></td>
			<td width="20%" align="left"> <?php echo $data->area;?></td>
			<td width="20%" align="right"> <?php echo number_format($data->target->booking,0);?> </td>
			<td width="20%" align="right"> <?php echo number_format($data->target->up,0);?> </td>
			<td width="15%" align="center"> <?php echo $data->target->persentase ? $data->target->persentase * 100 : 0;?> </td>
            <?php $totalCredit +=$data->target->booking; ?>
            <?php $totalUp +=$data->target->up; ?>
            <?php $totalPersent +=$data->target->persentase; ?>
		</tr>
	<?php endforeach ?>
    <tr>
    <td width="45%" align="right">Total</td>
    <td width="20%" align="right"><?php echo number_format($totalCredit,0); ?></td>
    <td width="20%" align="right"><?php echo number_format($totalUp,0); ?></td>
    <td width="15%" align="center"><?php echo round($totalCredit / $totalUp  * 100,2); ?></td>
    </tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>