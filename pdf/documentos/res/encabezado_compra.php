<?php 
	if ($con){
?>
    <table cellspacing="0" style="width: 100%;">
        <tr>

			<td class="clouds" style="width: 35%; color: #34495e;font-size:12px;text-align:left">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?></span>
				<br><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)." "?><br> 
				<?php echo get_row('perfil','telefono', 'id_perfil', 1);?><br>
            </td>
            <!--<td class="clouds" style="width:35%; ">&nbsp;</td>-->
			<td class="clouds" style="width: 10%;text-align:right; font-size: 12pt">
			<b>Nº <?php echo $id_compra;?></b>
			</td>
            <td style="width:10%; ">&nbsp;</td>
			<td class="clouds" style="width: 35%; color: #34495e;font-size:12px;text-align:left">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?></span>
				<br><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)." "?><br> 
				<?php echo get_row('perfil','telefono', 'id_perfil', 1);?><br>
            </td>
            <!--<td class="clouds" style="width:35%; ">&nbsp;</td>-->         
			<td class="clouds" style="width: 10%;text-align:right; font-size: 12pt">
			<b>Nº <?php echo $id_compra;?></b>
			</td>
			
        </tr>
    </table>
	<?php }?>	