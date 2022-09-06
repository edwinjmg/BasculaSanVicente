<?php 
	if ($con){
?>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <!--<td style="width: 25%; color: #444444;">
                <img style="width: 100%;" src="../../<?php echo get_row('perfil','logo_url', 'id_perfil', 1);?>" alt="Logo"><br>
                
            </td>-->
			<td style="width: 50%; color: #34495e;font-size:14px;text-align:left">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?></span>
				<br><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)." "?><br> 
				<?php echo get_row('perfil','telefono', 'id_perfil', 1);?><br>
            </td>
            <td style="width:10%; ">&nbsp;</td>
			<td style="width: 40%;text-align:right; font-style:italic; font-weight:bold;font-size: 14pt">
			Entrada <?php echo $id_entrada;?>
			</td>
			
        </tr>
    </table>
	<?php }?>	
	