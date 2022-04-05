<h3>Gadai Smartphone (<?php echo date('F Y', strtotime($datetrans)); ?>)</h3>
<table class="table" border="1">
    <thead class="thead-light">
        <tr bgcolor="#cccccc">
            <th align="center" width="20" rowspan="2"> No </th>
            <th width="120" rowspan="2"> Unit</th>
            <th width="100" rowspan="2"> Area</th>
            <th width="170" colspan="2" align="center">Total UP Akumulasi
                (<?php echo date('d F Y', strtotime($datetrans)); ?>)</th>
            <th width="140" colspan="2" align="center">Total UP Today
                (<?php echo date('d F Y', strtotime($datetrans)); ?>)</th>
            <!-- <th width="170"colspan="3" align="center" >Pelunasan (<?php //echo date('Y', strtotime($datetrans)); ?>)</th> -->

        </tr>
        <tr>
            <th width="40" align="center">NOA</th>
            <th width="130" align="right">Jumlah</th>
            <th width="40" align="center">NOA</th>
            <th width="100" align="right">Jumlah</th>

        </tr>
    </thead>
    <tbody>
        <?php 
	
	

	$ak_up = 0;
	$to_up = 0;
	$ak_noa = 0;
	$to_noa = 0;
	$disburse_noa = 0;
	$disburse_up = 0;



	foreach($smartphone as $data): $no++;?>
        <tr>
            <td width="20" align="center"> <?php echo $no;?></td>
            <td width="120" align="left"> <?php echo $data->unit;?></td>
            <td width="100" align="left"> <?php echo $data->area;?></td>

            <td width="40" align="center"> <?php echo $data->noa_ak;?></td>
            <td width="130" align="right"> <?php echo money($data->up_ak);?></td>

            <td width="40" align="center"> <?php echo $data->noa_to;?></td>
            <td width="100" align="right"> <?php echo money($data->up_to);?></td>

        </tr>
        <?php
			// $akumulasi_over += $data->akumulasi_over;
			$ak_up += $data->up_ak;
			// $akumulasi_prev += $data->akumulasi_prev;
			$to_up +=  $data->up_to;
			// $today_prev +=  $data->today_prev;
			// $today_over +=  $data->today_over;

			$ak_noa +=  $data->noa_ak;
			$to_noa +=  $data->noa_to;

				// $disburse_noa += $data->disburse_noa;				
				// $disburse_up += $data->disburse_up;


		?>
        <?php endforeach ?>
        <tr bgcolor="yellow">
            <td colspan="3" align="right">Total</td>
            <td width="40" align="center"><?php echo $ak_noa;?></td>
            <td width="130" align="right"><?php echo money($ak_up);?></td>
            <!-- <td width="100" align="center"><?php// echo round($akumulasi_prev/$no).' %';?></td>
	<td width="100" align="center"><?php// echo round($akumulasi_over/$no).' %';?></td> -->
            <td width="40" align="center"><?php echo $to_noa;?></td>
            <td width="100" align="right"><?php echo money($to_up);?></td>

        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>