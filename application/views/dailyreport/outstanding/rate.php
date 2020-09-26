<?php error_reporting(0); ?>
<h3>Distribusi Rate Nasional <?php echo date('d-m-Y'); ?></h3>
<hr/>

<table class="table" border="1">
<tr bgcolor="#aaaa55">
    <td colspan="10" align="center" width="950">JAWA BARAT</td>
</tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center"  width="30">No</td>
        <td rowspan="2" align="left" width="165"> Unit</td>
        <td rowspan="2" align="center" width="100"> Noa </td>
        <td rowspan="2" align="center" width="150">OS</td>
        <td colspan="3" align="center" width="250"> < 1.5%</td>
        <td colspan="3" align="center" width="255"> >= 1.5%</td>
    </tr>
    <tr bgcolor="#cccccc">
        <td align="center"  width="50">Noa</td>
        <td align="center" width="150"> UP</td>
        <td align="center" width="50"> % </td>
        <td align="center"  width="50">Noa</td>
        <td align="center" width="155"> UP</td>
        <td align="center" width="50"> % </td>    
    </tr>
    <?php $totup_jbr=0; $totnoa_jbr=0; $totup_small=0; $totup_big=0; $totnoa_big=0; $totnoa_small=0; ?>
    <?php $no=0; foreach ($rate as $index => $data): $no++;?>
    <?php if($data->area=='Jawa Barat'): ?>
        <?php  $percentSmall = ($data->small_then_up/$data->total_up * 100); 
                   if($percentSmall!=0){ $percentSmall = number_format($percentSmall,2);}else{ $percentSmall=0;}
            ?>
        <tr bgcolor="<?php echo $percentSmall > 25 ? 'red' : ''?>" >
            <td align="center"  width="30"><?php echo $no; ?></td>
            <td align="left" width="165"> <?php echo $data->name; ?></td>
            <td align="center" width="100"><?php echo $data->small_then_noa + $data->bigger_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->total_up,0); ?> </td>
            <td align="center"  width="50"><?php echo $data->small_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->small_then_up,0); ?> </td>
     
            <td align="center" width="50"><?php echo $percentSmall; ?></td>
            <td align="center"  width="50"><?php echo $data->bigger_then_noa; ?></td>
            <td align="right" width="155"> <?php echo number_format($data->bigger_then_up,0); ?> </td>
            <?php  $percentBig = ($data->bigger_then_up/$data->total_up * 100); 
                   if($percentBig!=0){ $percentBig = number_format($percentBig,2);}else{ $percentBig=0;}
            ?>
            <td align="center" width="50"><?php echo $percentBig; ?></td>    
        </tr>
    <?php  $totup_jbr +=$data->total_up; 
           $totnoa_jbr +=$data->small_then_noa + $data->bigger_then_noa; 
           $totup_small +=$data->small_then_up;
           $totup_big +=$data->bigger_then_up;
           $totnoa_small +=$data->small_then_noa;
           $totnoa_big +=$data->bigger_then_noa;
    ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <tr bgcolor="#ebebe0">
    <td colspan="2"></td>
    <td align="center"><?php echo number_format($totnoa_jbr,0); ?></td>
    <td align="right"><?php echo number_format($totup_jbr,0); ?></td>
    <td align="center"><?php echo number_format($totnoa_small,0); ?></td>
    <td align="right"><?php echo number_format($totup_small,0); ?></td>
    <td></td>
    <td align="center"><?php echo number_format($totnoa_big,0); ?></td>
    <td align="right"><?php echo number_format($totup_big,0); ?></td>
    <td></td>
    </tr>
</table>

<br/><br/>
<table class="table" border="1">
<tr bgcolor="#aaaa55">
    <td colspan="10" align="center" width="950">JAWA Timur</td>
</tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center"  width="30">No</td>
        <td rowspan="2" align="left" width="165"> Unit</td>
        <td rowspan="2" align="center" width="100"> Noa </td>
        <td rowspan="2" align="center" width="150">OS</td>
        <td colspan="3" align="center" width="250"> < 1.5%</td>
        <td colspan="3" align="center" width="255"> >= 1.5%</td>
    </tr>
    <tr bgcolor="#cccccc">
        <td align="center"  width="50">Noa</td>
        <td align="center" width="150"> UP</td>
        <td align="center" width="50"> % </td>
        <td align="center"  width="50">Noa</td>
        <td align="center" width="155"> UP</td>
        <td align="center" width="50"> % </td>    
    </tr>
    <?php $totup_jbt=0; $totnoa_jbt=0; $totup_small_jbt=0; $totup_big_jbt=0; $totnoa_big_jbt=0; $totnoa_small_jbt=0; ?>
    <?php $no=0; foreach ($rate as $index => $data):?>
    <?php if($data->area=='Jawa Timur'):  $no++;?>
        <?php  $percentSmall = ($data->small_then_up/$data->total_up * 100); 
                    if($percentSmall!=0){ $percentSmall = number_format($percentSmall,2);}else{ $percentSmall=0;}
                ?>
        <tr bgcolor="<?php echo $percentSmall > 25 ? 'red' : ''?>">
            <td align="center"  width="30"><?php echo $no; ?></td>
            <td align="left" width="165"> <?php echo $data->name; ?></td>
            <td align="center" width="100"><?php echo $data->small_then_noa + $data->bigger_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->total_up,0); ?> </td>
            <td align="center"  width="50"><?php echo $data->small_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->small_then_up,0); ?> </td>
         
            <td align="center" width="50"><?php echo $percentSmall; ?></td>
            <td align="center"  width="50"><?php echo $data->bigger_then_noa; ?></td>
            <td align="right" width="155"> <?php echo number_format($data->bigger_then_up,0); ?> </td>
            <?php  $percentBig = ($data->bigger_then_up/$data->total_up * 100); 
                   if($percentBig!=0){ $percentBig = number_format($percentBig,2);}else{ $percentBig=0;}
            ?>
            <td align="center" width="50"><?php echo $percentBig; ?></td>    
        </tr>
    <?php  $totup_jbt +=$data->total_up; 
           $totnoa_jbt +=$data->small_then_noa + $data->bigger_then_noa; 
           $totup_small_jbt +=$data->small_then_up;
           $totup_big_jbt +=$data->bigger_then_up;
           $totnoa_small_jbt +=$data->small_then_noa;
           $totnoa_big_jbt +=$data->bigger_then_noa;
    ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <tr bgcolor="#ebebe0">
    <td colspan="2"></td>
    <td align="center"><?php echo number_format($totnoa_jbt,0); ?></td>
    <td align="right"><?php echo number_format($totup_jbt,0); ?></td>
    <td align="center"><?php echo number_format($totnoa_small_jbt,0); ?></td>
    <td align="right"><?php echo number_format($totup_small_jbt,0); ?></td>
    <td></td>
    <td align="center"><?php echo number_format($totnoa_big_jbt,0); ?></td>
    <td align="right"><?php echo number_format($totup_big_jbt,0); ?></td>
    <td></td>
    </tr>
</table>

<br/><br/>
<table class="table" border="1">
<tr bgcolor="#aaaa55">
    <td colspan="10" align="center" width="950">NTB</td>
</tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center"  width="30">No</td>
        <td rowspan="2" align="left" width="165"> Unit</td>
        <td rowspan="2" align="center" width="100"> Noa </td>
        <td rowspan="2" align="center" width="150">OS</td>
        <td colspan="3" align="center" width="250"> < 1.5%</td>
        <td colspan="3" align="center" width="255"> >= 1.5%</td>
    </tr>
    <tr bgcolor="#cccccc">
        <td align="center"  width="50">Noa</td>
        <td align="center" width="150"> UP</td>
        <td align="center" width="50"> % </td>
        <td align="center"  width="50">Noa</td>
        <td align="center" width="155"> UP</td>
        <td align="center" width="50"> % </td>    
    </tr>
    <?php $totup_ntb=0; $totnoa_ntb=0; $totup_small_ntb=0; $totup_big_ntb=0; $totnoa_big_ntb=0; $totnoa_small_ntb=0; ?>
    <?php $no=0; foreach ($rate as $index => $data):?>
    <?php if($data->area=='NTB'):  $no++;?>
    <?php  $percentSmall = ($data->small_then_up/$data->total_up * 100); 
                   if($percentSmall!=0){ $percentSmall = number_format($percentSmall,2);}else{ $percentSmall=0;}
            ?>
          <tr bgcolor="<?php echo $percentSmall > 25 ? 'red' : ''?>">
            <td align="center"  width="30"><?php echo $no; ?></td>
            <td align="left" width="165"> <?php echo $data->name; ?></td>
            <td align="center" width="100"><?php echo $data->small_then_noa + $data->bigger_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->total_up,0); ?> </td>
            <td align="center"  width="50"><?php echo $data->small_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->small_then_up,0); ?> </td>
         
            <td align="center" width="50"><?php echo $percentSmall; ?></td>
            <td align="center"  width="50"><?php echo $data->bigger_then_noa; ?></td>
            <td align="right" width="155"> <?php echo number_format($data->bigger_then_up,0); ?> </td>
            <?php  $percentBig = ($data->bigger_then_up/$data->total_up * 100); 
                   if($percentBig!=0){ $percentBig = number_format($percentBig,2);}else{ $percentBig=0;}
            ?>
            <td align="center" width="50"><?php echo $percentBig; ?></td>    
        </tr>
    <?php  $totup_ntb+=$data->total_up; 
           $totnoa_ntb +=$data->small_then_noa + $data->bigger_then_noa; 
           $totup_small_ntb +=$data->small_then_up;
           $totup_big_ntb +=$data->bigger_then_up;
           $totnoa_small_ntb +=$data->small_then_noa;
           $totnoa_big_ntb +=$data->bigger_then_noa;
    ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <tr bgcolor="#ebebe0">
    <td colspan="2"></td>
    <td align="center"><?php echo number_format($totnoa_ntb,0); ?></td>
    <td align="right"><?php echo number_format($totup_ntb,0); ?></td>
    <td align="center"><?php echo number_format($totnoa_small_ntb,0); ?></td>
    <td align="right"><?php echo number_format($totup_small_ntb,0); ?></td>
    <td></td>
    <td align="center"><?php echo number_format($totnoa_big_ntb,0); ?></td>
    <td align="right"><?php echo number_format($totup_big_ntb,0); ?></td>
    <td></td>
    </tr>
</table>

<br/><br/>
<table class="table" border="1">
<tr bgcolor="#aaaa55">
    <td colspan="10" align="center" width="950">NTT</td>
</tr>
    <tr bgcolor="#cccccc">
        <td rowspan="2" align="center"  width="30">No</td>
        <td rowspan="2" align="left" width="165"> Unit</td>
        <td rowspan="2" align="center" width="100"> Noa </td>
        <td rowspan="2" align="center" width="150">OS</td>
        <td colspan="3" align="center" width="250"> < 1.5%</td>
        <td colspan="3" align="center" width="255"> >= 1.5%</td>
    </tr>
    <tr bgcolor="#cccccc">
        <td align="center"  width="50">Noa</td>
        <td align="center" width="150"> UP</td>
        <td align="center" width="50"> % </td>
        <td align="center"  width="50">Noa</td>
        <td align="center" width="155"> UP</td>
        <td align="center" width="50"> % </td>    
    </tr>
    <?php $totup_ntt=0; $totnoa_ntt=0; $totup_small_ntt=0; $totup_big_ntt=0; $totnoa_big_ntt=0; $totnoa_small_ntt=0; ?>
    <?php $no=0; foreach ($rate as $index => $data):?>
    <?php if($data->area=='NTT'):  $no++;?>
    <?php  $percentSmall = ($data->small_then_up/$data->total_up * 100); 
                   if($percentSmall!=0){ $percentSmall = number_format($percentSmall,2);}else{ $percentSmall=0;}
            ?>
       <tr bgcolor="<?php echo $percentSmall > 25 ? 'red' : ''?>">
            <td align="center"  width="30"><?php echo $no; ?></td>
            <td align="left" width="165"> <?php echo $data->name; ?></td>
            <td align="center" width="100"><?php echo $data->small_then_noa + $data->bigger_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->total_up,0); ?> </td>
            <td align="center"  width="50"><?php echo $data->small_then_noa; ?></td>
            <td align="right" width="150"> <?php echo number_format($data->small_then_up,0); ?> </td>
          
            <td align="center" width="50"><?php echo $percentSmall; ?></td>
            <td align="center"  width="50"><?php echo $data->bigger_then_noa; ?></td>
            <td align="right" width="155"> <?php echo number_format($data->bigger_then_up,0); ?> </td>
            <?php  $percentBig = ($data->bigger_then_up/$data->total_up * 100); 
                   if(!is_nan($percentBig)){ $percentBig = number_format($percentBig,2);}else{ $percentBig=0;}
            ?>
            <td align="center" width="50"><?php echo $percentBig; ?></td>    
        </tr>
    <?php  $totup_ntt+=$data->total_up; 
           $totnoa_ntt +=$data->small_then_noa + $data->bigger_then_noa; 
           $totup_small_ntt +=$data->small_then_up;
           $totup_big_ntt +=$data->bigger_then_up;
           $totnoa_small_ntt +=$data->small_then_noa;
           $totnoa_big_ntt +=$data->bigger_then_noa;
    ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <tr bgcolor="#ebebe0">
    <td colspan="2"></td>
    <td align="center"><?php echo number_format($totnoa_ntt,0); ?></td>
    <td align="right"><?php echo number_format($totup_ntt,0); ?></td>
    <td align="center"><?php echo number_format($totnoa_small_ntt,0); ?></td>
    <td align="right"><?php echo number_format($totup_small_ntt,0); ?></td>
    <td></td>
    <td align="center"><?php echo number_format($totnoa_big_ntt,0); ?></td>
    <td align="right"><?php echo number_format($totup_big_ntt,0); ?></td>
    <td></td>
    </tr>
</table>