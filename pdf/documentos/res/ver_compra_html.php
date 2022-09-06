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
<page format="letter" backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 8pt; font-family: arial" >
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
	<?php include("encabezado_compra.php");?>
    <br>
    <br>
    

<?php
$sumador_total=0;
$sql=mysqli_query($con, "select * from productos, compras where productos.id_producto=compras.id_producto and compras.id_compra='".$id_compra."'");
$row=mysqli_fetch_array($sql);
$sql_fecha=mysqli_query($con,"select DATE_FORMAT(fecha_compra, '%d de %M de %Y') AS fecha, RIGHT(fecha_compra, 8) AS hora FROM compras where compras.id_compra='".$id_compra."'");
$rwfecha=mysqli_fetch_array($sql_fecha);
	$id_producto=$row["id_producto"];
	$id_cliente=$row['id_cliente'];
	$peso_compra=$row['peso_compra'];
    $precio_carga=$row['precio_compra']*125;
    $peso_bruto=$row['peso_bruto'];
    $tara=($peso_bruto-$peso_compra);
	$nombre_producto=$row['nombre_producto'];
	$fecha=$rwfecha['fecha'];
	$hora=$rwfecha['hora'];
	$precio_compra=$row['precio_compra'];
	$sacos=$row['saco_fibra']+$row['saco_fique'];
    $precio_compra_f=number_format($precio_compra,0);//Formateo variables
    $precio_compra_r=str_replace(",","",$precio_compra_f);//Reemplazo las comas
    $precio_carga_f=number_format($precio_carga,0);//Formateo variables
    $precio_carga_r=str_replace(",","",$precio_carga_f);//Reemplazo las comas
	$precio_total=$precio_compra_r*$peso_compra;
	$precio_total_f=number_format($precio_total,0);//Precio total formateado
	$precio_total_r=str_replace(".","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador	
	$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
	$rw_cliente=mysqli_fetch_array($sql_cliente);

	?>
	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
		<tr>
            <td  style="width:10%; ">Fecha:</td>
            <td  style="width:35%; text-align:right;" ><?php echo $fecha; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td  style="width:10%; ">Fecha:</td>
            <td  style="width:35%; text-align:right;" ><?php echo $fecha; ?></td>
        </tr>
        <tr>
            <td style="width:10%; ">Hora:</td>
            <td style="width:35%; text-align:right;" ><?php echo $hora; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:10%; ">Hora:</td>
            <td style="width:35%; text-align:right;" ><?php echo $hora; ?></td>
        </tr>
  		<tr>
            <td  style="width:10%; ">Cliente:</td>
            <td  style="width:35%; text-align:right;" ><?php echo $rw_cliente['nombre_cliente']; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td  style="width:10%; ">Cliente:</td>
            <td  style="width:35%; text-align:right;" ><?php echo $rw_cliente['nombre_cliente']; ?></td>
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
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">

		
        <tr>
            <td style="width:20%; ">Bultos:</td>
            <td style="width:25%; text-align:right;" ><?php echo $sacos; ?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:20%; ">Bultos:</td>
            <td  style="width:25%; text-align:right;" ><?php echo $sacos; ?></td>
        </tr>
        <tr>
            <td style="width:20%;">Producto:</td>
            <td style="width:25%; text-align:right"><?php echo $nombre_producto;?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:20%;">Producto:</td>
            <td style="width:25%; text-align:right"><?php echo $nombre_producto;?></td>
        </tr>
        <tr>
            <td style="width:20%;">Precio Kilo:</td>
            <td  style="width:25%; text-align:right"><?php echo $precio_compra_f;?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td  style="width:20%;">Precio Kilo:</td>
            <td  style="width:25%; text-align:right"><?php echo $precio_compra_f;?></td>
        </tr>
        <tr>
            <td style="width:20%;">Precio Carga:</td>
            <td style="width:25%; text-align:right"><?php echo $precio_carga_f;?></td>
            <td style="width:10%; ">&nbsp;</td>
            <td style="width:20%;">Precio Carga:</td>
            <td style="width:25%; text-align:right"><?php echo $precio_carga_f;?></td>
        </tr>

    </table>
    <br>
    <br>
    <table margin:5px; border="" cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">

        <tr>
            <td style="width:20%; font-size: 12pt">Peso y Empaque:</td>
            <td style="width:25%; text-align:right; font-size: 14pt" ><?php echo $peso_bruto; ?></td>
             <td style="width:10%; ">&nbsp;</td>
           <td  style="width:20%; font-size: 12pt">Peso y Empaque:</td>
            <td  style="width:25%; text-align:right; font-size: 14pt" ><?php echo $peso_bruto; ?></td>
        </tr>
<tr>
            <td class="clouds" style="width:20%; font-size: 12pt">Menos Empaque:</td>
            <td class="clouds" style="width:25%; text-align:right; font-size: 14pt" ><?php echo $tara; ?></td>
             <td style="width:10%; ">&nbsp;</td>
           <td class="clouds" style="width:20%; font-size: 12pt">Menos Empaque:</td>
            <td class="clouds" style="width:25%; text-align:right; font-size: 14pt" ><?php echo $tara; ?></td>
        </tr>
<tr style="font-style:italic; font-weight:bold;">
            <td  style="width:20%; font-size: 14pt">Peso Neto:</td>
            <td style="width:25%; text-align:right; font-size: 14pt" ><?php echo $peso_compra; ?></td>
             <td style="width:10%; ">&nbsp;</td>
           <td style="width:20%; font-size: 14pt">Peso Neto:</td>
            <td style="width:25%; text-align:right; font-size: 14pt" ><?php echo $peso_compra; ?></td>
        </tr>
        <tr style="font-style:italic; font-weight:bold;">
            <td class="clouds" style="width:20%; font-size: 15pt">TOTAL:</td>
            <td class="clouds" style="width:25%; text-align:right; font-size: 16pt"><?php echo $precio_total_f;?></td>
              <td style="width:10%; ">&nbsp;</td>
          <td class="clouds" style="width:20%; font-size: 14pt">TOTAL:</td>
            <td class="clouds" style="width:25%; text-align:right; font-size: 16pt"><?php echo $precio_total_f;?></td>
        </tr>

    </table>
	
	
	


</page>
