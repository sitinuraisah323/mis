<table class="table" border="1">
            <tr bgcolor="#cccccc">
            <td rowspan="2" align="center">No</td>
            <td rowspan="2" align="center">Unit</td>
            <td rowspan="2" align="center">Area</td>
            <td rowspan="2" align="center">Open</td>
            <td rowspan="2" align="center">OJK</td>
            <td colspan="2" align="center">OST Hari ini</td>
            <td colspan="2" align="center">Kredit Hari ini</td>
            <td colspan="2" align="center">Pelunasan & Cicilan Hari ini</td>
            <td colspan="3" align="center">Total Outstanding</td>
            <td colspan="3" align="center">Total Disburse</td>
            </tr>
            <tr bgcolor="#cccccc">
            <td align="center">Noa</td>
            <td align="center">Ost</td>
            <td align="center">Noa</td>
            <td align="center">Kredit</td>
            <td align="center">Noa</td>
            <td align="center">Kredit</td>
            <td align="center">Noa</td>
            <td align="center">Ost</td>
            <td align="center">Ticket Size</td>
            <td align="center">Noa</td>
            <td align="center">Kredit</td>
            <td align="center">Ticket Size</td>
            </tr>
            <?php foreach($users as $user):?>
            <tr>
                <td align="center"><?php echo $user->username;?></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>         
                <td align="center"></td>         
                <td align="center"></td>         
            </tr>
            <?php endforeach ?>
           </table>