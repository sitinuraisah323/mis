<h3>Tanggal <?php echo $dateStart ?> - <?php echo $dateEnd;?></h3>
    <table class="table" border="1">
        <thead class="thead-light">
            <tr  bgcolor="#cccccc">
                <th rowspan="3" width="55">Unit</th>
                <th width="900" align="center" colspan="<?php count($grams);?>"> Gramasi </th>
            </tr>
            <tr>
                <?php foreach($grams as $gram):?>
                <th colspan="3" width="<?php echo 900/count($grams);?>" align="center"><?php echo $gram->weight.' gram'?></th>
                <?php endforeach;?>
            </tr>
            <tr>
                <?php foreach($grams as $gram):?>
                
                <th width="<?php echo 900/count($grams)/3;?>" align="center">Piecis</th>
                <th width="<?php echo 900/count($grams)/3;?>" align="center">Harga Pokok</th>
                <th width="<?php echo 900/count($grams)/3;?>" align="center">Harga Jual</th>
                <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
               <?php foreach($units as $unit):?>         
                    <tr>                    
                        <td width="55"><?php echo $unit->name;?></td>
                        <?php foreach($unit->grams as $index => $gram):?>
                            <th width="<?php echo 900/count($grams)/3;?>" align="center"><?php echo $gram->sales->amount;?></th>
                            <th width="<?php echo 900/count($grams)/3;?>" align="center"><?php echo $gram->sales->price_perpcs;?></th>
                            <th width="<?php echo 900/count($grams)/3;?>" align="center"><?php echo $gram->sales->price_buyback_perpcs;?></th>
                        <?php endforeach?>                    
                    </tr>
               <?php endforeach;?>       
        </tbody>
        <tfoot>
        </tfoot>
    </table>
