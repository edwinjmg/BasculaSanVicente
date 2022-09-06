<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page format="LETTER" backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 8pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    &nbsp;
                </td>
                <td style="width: 50%; text-align: right; font-size: 6pt">
                    &copy; <?php echo "EM "; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
	<?php include("encabezado_venta.php");?>
    <br>
    <br>
    

<?php
$sumador_total=0;
$sql=mysqli_query($con, "select * from productos, ventas where productos.id_producto=ventas.id_producto and ventas.id_venta='".$id_venta."'");
$row=mysqli_fetch_array($sql);
$sql_fecha=mysqli_query($con,"select DATE_FORMAT(fecha_venta, '%d de %M de %Y') AS fecha, RIGHT(fecha_venta, 8) AS hora FROM ventas where ventas.id_venta='".$id_venta."'");
$rwfecha=mysqli_fetch_array($sql_fecha);
	$id_producto=$row["id_producto"];
	$id_cliente=$row['id_cliente'];
	$peso_venta=$row['peso_venta'];
	$nombre_producto=$row['nombre_producto'];
	$fecha=$rwfecha['fecha'];
	$hora=$rwfecha['hora'];
	$precio_venta=$row['precio_venta'];
	$sacos=$row['sacos'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$peso_venta;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(".","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador	
	$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
	$rw_cliente=mysqli_fetch_array($sql_cliente);

	?>
	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
            <td style="width:10%; ">Fecha:</td>
            <td style="width:35%; text-align:right;" ><?php echo $fecha; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%; ">Fecha:</td>
            <td style="width:35%; text-align:right;" ><?php echo $fecha; ?></td>
        </tr>
        <tr>
            <td style="width:10%; ">Hora:</td>
            <td style="width:35%; text-align:right;" ><?php echo $hora; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%; ">Hora:</td>
            <td style="width:35%; text-align:right;" ><?php echo $hora; ?></td>
        </tr>
  		<tr>
            <td style="width:10%; ">Cliente:</td>
            <td style="width:35%; text-align:right;" ><?php echo $rw_cliente['nombre_cliente']; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%; ">Cliente:</td>
            <td style="width:35%; text-align:right;" ><?php echo $rw_cliente['nombre_cliente']; ?></td>
        </tr>
        <tr>
            <td style="width:10%; ">Nit:</td>
            <td style="width:35%; text-align:right;" ><?php echo $rw_cliente['nit_cliente']; ?></td>
             <td style="width:10%; ">&nbsp;</td>
           <td style="width:10%; ">Nit:</td>
            <td style="width:35%; text-align:right;" ><?php echo $rw_cliente['nit_cliente']; ?></td>
        </tr>
   
    </table>
    <br>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">

		
        <tr>
            <td style="width:10%; ">Bultos:</td>
            <td style="width:35%; text-align:right;" ><?php echo $sacos; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%; ">Bultos:</td>
            <td style="width:35%; text-align:right;" ><?php echo $sacos; ?></td>
        </tr>
        <tr>
            <td style="width:10%;">Producto:</td>
            <td style="width:35%; text-align:right"><?php echo $nombre_producto;?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%;">Producto:</td>
            <td style="width:35%; text-align:right"><?php echo $nombre_producto;?></td>
        </tr>
        <tr>
            <td style="width:10%;">Precio X Kilo:</td>
            <td style="width:35%; text-align:right"><?php echo $precio_venta_f;?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%;">Precio X Kilo:</td>
            <td style="width:35%; text-align:right"><?php echo $precio_venta_f;?></td>
        </tr>

    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">

        <tr>
            <td style="width:10%; font-size: 14pt">Peso:</td>
            <td style="width:35%; text-align:right; font-size: 14pt" ><?php echo $peso_venta; ?></td>
             <td style="width:10%; ">&nbsp;</td>
           <td style="width:10%; font-size: 14pt">Peso:</td>
            <td style="width:35%; text-align:right; font-size: 14pt" ><?php echo $peso_venta; ?></td>
        </tr>
        <tr>
            <td class="clouds" style="width:10%; font-size: 18pt">Total:</td>
            <td class="clouds" style="width:35%; text-align:right; font-size: 18pt"><?php echo $precio_total_f;?></td>
              <td style="width:10%; ">&nbsp;</td>
          <td class="clouds" style="width:10%; font-size: 18pt">Total:</td>
            <td class="clouds" style="width:35%; text-align:right; font-size: 18pt"><?php echo $precio_total_f;?></td>
        </tr>

    </table>
	
	
	


</page>

