<h3>Pendapatan Gcore (<?php echo date('F Y', strtotime($datetrans)); ?>)</h3>
<table class="table" border="1">
    <thead class="thead-light">
        <tr bgcolor="#cccccc">
            <!-- <th align="center" width="5%"> No </th> -->
            <th align="center" width="5%"> ID </th>
            <th width="30%"> Unit</th>
            <th width="30%"> Description</th>
            <th width="10%" align="right"> date </th>
            <th width="20%" align="right"> Saldo </th>

        </tr>
    </thead>
    <tbody>
        <?php $no=0;
	$total =0;
     foreach($pendapatan as $datas => $datasa): $no_++; ?>

        <?php foreach($datasa as $data): ?>
        <tr>
            <!-- <td width="5%" align="center"> <?php //echo $no;?></td> -->
            <td width="5%" align="left"> <?php echo $data->id;?></td>
            <td width="30%" align="left"> <?php echo $data->unit_office_name;?></td>
            <td width="30%" align="left"> <?php echo $data->description;?></td>
            <td width="10%" align="left"> <?php echo $data->date;?></td>
            <td width="20%" align="right"> <?php echo number_format($data->amount,0);?> </td>
            <?php// $total +=$data->amount; ?>
        </tr>
        <?php endforeach;
    $total = $data->amount;
    endforeach; ?>
        <tr>
            <td width="80%" align="right">Total</td>
            <td width="20%" align="right"><?php echo number_format($total,0); ?></td>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>