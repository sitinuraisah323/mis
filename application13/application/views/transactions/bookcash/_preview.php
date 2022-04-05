<table>
	<tr>
		<td>
		<table>
			<tr>
				<td width="50">Cabang</td>
				<td width="10"> :</td>
				<td width="200"> <?php echo $bookcash->name; ?></td>
			</tr>
			<tr>
				<td width="50">Petugas </td>
				<td width="10"> :</td>
				<td width="200"> <?php echo $bookcash->kasir;?></td>
			</tr>
			<tr>
				<td width="50">Hari </td>
				<td width="10"> :</td>
				<td width="200"> <?php echo date('l', strtotime($bookcash->date));?></td>
			</tr>
			<tr>
				<td width="50">Tanggal </td>
				<td width="10"> :</td>
				<td width="200"> <?php echo date('d-m-Y',strtotime($bookcash->date));?></td>
			</tr>
		</table>
		</td>
		<td>
		<table>
			<tr>
				<td width="80">Saldo Awal</td>
				<td width="10"> :</td>
				<td width="80"> </td>
				<td width="200"> <?php echo number_format($bookcash->amount_balance_first,0); ?></td>
			</tr>
			<tr>
				<td width="80">Penerimaan </td>
				<td width="10"> :</td>
				<td width="80"> <?php echo number_format($bookcash->amount_in,0); ?></td>
				<td width="200"></td>
			</tr>
			<tr>
				<td width="80">Pengeluaran </td>
				<td width="10"> :</td>
				<td width="80"> <?php echo number_format($bookcash->amount_out,0); ?></td>
				<td width="200"></td>
			</tr>
			<tr>
				<td width="80">Mutasi </td>
				<td width="10"> :</td>
				<td width="80"> <?php echo number_format($bookcash->amount_mutation,0); ?></td>
				<td width="200"></td>
			</tr>
			<tr>
				<td width="80">Saldo Akhir </td>
				<td width="10"> :</td>
				<td width="80"> </td>
				<td width="200"> <?php echo number_format($bookcash->amount_balance_final,0); ?></td>
			</tr>
			<tr>
				<td width="80">Sisa UP Kredit </td>
				<td width="10"> :</td>
				<td width="80"> </td>
				<td width="200"> <?php echo number_format($bookcash->os_unit+$bookcash->os_cicilan,0); ?></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<br/>
<hr/>
<?php $totalkertas=0; $totallogam=0; //print_r($Detailbookcash); ?>
<br/>
<table>
<tr>
<td width="310"><br/><br/>
	<b>Uang Kertas dan Plastik</b>
	<br/><br/>
	<table border="1">
		<tr bgcolor="#e0e0d1">
			<td align="center">No</td>
			<td> Pecahan</td>
			<td align="center"> Jumlah</td>
			<td align="right"> Total</td>
		</tr>
		<?php $total =0; $subtotal =0; $no=0; foreach($Detailbookcash as $data): $no++; ?>
		<?php if($data->type=="KERTAS"){ ?>
		<tr>
			<td align="center"><?php echo $no; ?></td>
			<td> <?php echo number_format($data->amount,0); ?></td>
			<td align="center"> <?php echo number_format($data->summary,0); ?></td>
			<?php $subtotal = $data->amount *$data->summary; 
				  $total += $subtotal;
			?>
			<td align="right"> <?php echo number_format($subtotal,0); ?></td>
		</tr>
		<?php } ?>
		<?php endforeach ?>
		<tr>
			<td align="right" colspan="3"> Total</td>
			<td align="right"><?php echo number_format($total,0); ?></td>
		</tr>
	</table>
	<?php $totalkertas=$total;  ?>
</td>
<td width="10"></td>
<td width="310"><br/><br/>
	<b>Uang Logam</b>
	<br/><br/>
	<table border="1">
		<tr bgcolor="#e0e0d1">
			<td align="center"> No</td>
			<td> Pecahan</td>
			<td align="center"> Jumlah</td>
			<td align="right"> Total</td>
		</tr>
		<?php  $total =0; $subtotal =0; $no=0; foreach($Detailbookcash as $data): $no++;?>
		<?php if($data->type=="LOGAM"){ ?>
			<tr>
			<td align="center"><?php echo $no; ?></td>
			<td> <?php echo number_format($data->amount,0); ?></td>
			<td align="center"> <?php echo number_format($data->summary,0); ?></td>
			<?php $subtotal = $data->amount *$data->summary; 
				  $total +=$subtotal;
			?>
			<td align="right"> <?php echo number_format($subtotal,0); ?></td>
		</tr>
		<?php } ?>
		<?php endforeach ?>
		<tr>
			<td align="right" colspan="3"> Total</td>
			<td align="right"><?php echo number_format($total,0); ?></td>
		</tr>
	</table>
	</td>
</tr>
<table>
<?php $totallogam=$total; 
	$totpecahan=0;
	$selisih=0;
	$totpecahan=$totallogam+$totalkertas;
	$selisih = $bookcash->amount_balance_final - $totpecahan;
?> 

<br/><br/>
<table>
<tr>
<td width="80">Total</td>
<td width="10">: </td>
<td><?php echo number_format($totpecahan,0); ?></td>
</tr>
<tr>
<td width="80">Selisih</td>
<td width="10">: </td>
<td><?php echo number_format($selisih,0); ?></td>
</tr>
<tr>
<td width="80">Catatan</td>
<td width="10">:</td>
<td width="500"><?php echo $bookcash->note; ?></td>
</tr>
<table>

<br/><br/><br/>
<table>
<tr>
<td>
Kasir

<br/><br/><br/><br/><br/><br/>
(<?php echo $bookcash->kasir; ?>)
</td>
<td>
Kepala Unit
<br/><br/><br/><br/><br/><br/>
(<?php echo '.......................'; ?>)
</td>
</tr>
</table>
<br/><br/><br/><br/>__ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __