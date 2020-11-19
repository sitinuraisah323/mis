<h3>Stock Lm Nasional (<?php echo date('d m Y'); ?>)</h3>
<table class="table" border="1">
	<thead class="thead-light">
		<tr  bgcolor="#cccccc">
			<th rowspan="2" width="5%"> No </th>
			<th rowspan="2" width="20%"> Unit </th>
			<th colspan="7" width="35%"> Gramasi</th>
			<th rowspan="2" width="10%" style="text-align:right"> Total</th>
		</tr>
		<tr>
			<?php foreach($grams as $gram):?>
				<th width="5%" style="text-align:right"><?php echo $gram->weight;?></th>
			<?php endforeach;?>
		</tr>
	</thead>
	
	<tbody>
	<?php $total = 0;?>
	<?php foreach($data as $index => $row):?>
		<tr>
			<td width="5%" style="text-align:right"><?php echo $index+1;?>. </td>
			<td  width="20%"> <?php echo $row->name;?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{0.1};?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{0.25};?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{0.5};?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{1};?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{2.5};?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{5};?> </td>
			<td  width="5%" style="text-align:right"> <?php echo $row->{10};?> </td>
		
			<?php $subtotal = $row->{0.1} +  $row->{0.25} +   $row->{0.5} +  $row->{1} + $row->{5} + $row->{10};?>
			<td  width="10%" style="text-align:right"> <?php echo $subtotal;?> </td>
			<?php $total += $subtotal;?>
		</tr>
	<?php endforeach?>
		<tr>
			<th colspan="9" style="text-align:center"> Total </th>
			<th style="text-align:right"><?php echo $total;?></th>
		</tr>
	</tbody>
</table>