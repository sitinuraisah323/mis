<h3>Penjualan Tanggal <?php echo date('d, D M Y')?></h3>
    <table class="table" border="1">
        <thead class="thead-light">
            <tr  bgcolor="#cccccc">
                <th rowspan="3" width="100">Unit</th>
                <th width="1000" align="center" colspan="<?php echo count($grams)*3;?>"> Gramasi </th>                
                <th rowspan="3" width="40" align="center">Total Gramasi</th>
                <th rowspan="3" width="40" align="center">Total Pcs</th>
                <th rowspan="3" width="100">Total HP</th>
                <th rowspan="3" width="100">Total HJ</th>
            </tr>
            <tr>
                <?php foreach($grams as $gram):?>
                <th colspan="3" width="<?php echo 1000/count($grams);?>" align="center"><?php echo $gram->weight.' gram'?></th>
                <?php endforeach;?>
            </tr>
            <tr>
                <?php foreach($grams as $gram):?>
                
                <th width="<?php echo 600/count($grams)/3;?>" align="center">Piecis</th>
                <th width="<?php echo 800/count($grams)/2;?>" align="center">Harga Pokok</th>
                <th width="<?php echo 800/count($grams)/2;?>" align="center">Harga Jual</th>
                <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
        <?php $totalAmount = 0; $totalHp = 0; $totalHj = 0; $totalGram = 0;?>
               <?php foreach($units as $unit):?>        
                    <tr>                    
                        <td width="100"><?php echo $unit->name;?></td>
                        
                <?php $totalAmountUnit = 0; $totalHpUnit = 0; $totalHjUnit = 0; $totalGramUnit = 0;?> 
                        <?php foreach($unit->grams as $index => $gram):?>
                            <th width="<?php echo 600/count($grams)/3;?>" align="center">
                            <?php if($gram->sales->amount):?>
                            <?php echo $gram->sales->amount;?>
                            <?php else:?>
                                -
                            <?php endif;?>
                            </th>
                            <th width="<?php echo 800/count($grams)/2;?>" align="center">
                            <?php if($gram->sales->price_perpcs):?>
                            <?php echo $gram->sales->price_buyback_perpcs;?>
                            <?php else:?>
                                -
                            <?php endif;?>
                            </th>
                            <th width="<?php echo 800/count($grams)/2;?>" align="center">
                            <?php if($gram->sales->price_buyback_perpcs):?>
                            <?php echo $gram->sales->price_perpcs;?>
                            <?php else:?>
                            -
                            <?php endif;?>
                            </th>
                            <?php $totalAmountUnit += $gram->sales->amount; 
                            if($gram->sales->price_buyback_perpcs){
                                $totalHpUnit += $gram->sales->price_buyback_perpcs *$gram->sales->amount;
                                $totalHp += $gram->sales->price_buyback_perpcs *$gram->sales->amount; 
                            }
                            if($gram->sales->price_perpcs){
                                $totalHj += $gram->sales->price_perpcs *$gram->sales->amount; 
                                $totalHjUnit += $gram->sales->price_perpcs *$gram->sales->amount;
                            }
                            $totalGramUnit +=  $gram->sales->amount * $gram->weight;?> 
                            <?php $totalAmount += $gram->sales->amount; 
                            $totalGram += $gram->sales->amount * $gram->weight;?>
                        <?php endforeach?>                 
                        <th width="40" align="center">
                        <?php if($totalGramUnit):?>
                        <?php echo $totalGramUnit;?>
                        <?php else:?>
                            -
                        <?php endif;?>
                        </th>
                        <th width="40" align="center">
                        <?php if($totalAmountUnit):?>
                        <?php echo $totalAmountUnit;?>
                        <?php else:?>
                            -
                        <?php endif;?>
                        </th>
                        <th width="100" align="right">
                        <?php if($totalHpUnit):?>
                        <?php echo $totalHpUnit;?>
                        <?php else:?>
                            -
                        <?php endif;?>
                        </th>
                        <th width="100" align="right">
                        <?php if($totalHjUnit):?>
                        <?php echo $totalHjUnit;?>
                        <?php else:?>
                            -
                        <?php endif;?>
                        </th>
                    </tr>
               <?php endforeach;?>       
        </tbody>
        <tfoot>
        </tfoot>
    </table>