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
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
    <br>
    <br>
    <br>
        
    <?php include("encabezado_entrada.php");?>
    <br>
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='clouds'>DATOS CLIENTE</td>
           <td class='clouds'>-</td>
        </tr>
		<tr>
           <td style="width:50%;text-align: left;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				$rw_cliente=mysqli_fetch_array($sql_cliente);
			?>
			 Nombre:
		   </td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['nombre_cliente'];?></td>
        </tr>
        <tr>
 		   <td style="width:50%;text-align: left;"> Dirección:</td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['direccion_cliente'];?></td>
       </tr>
        <tr>
 		   <td style="width:50%;text-align: left;"> Telefono:</td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['telefono_cliente'];?></td>
       </tr>
         <tr>
 		   <td style="width:50%;text-align: left;"> NIT:</td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['nit_cliente'];?></td>
       </tr>
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='clouds'>USUARIO</td>
		  <td style="width:40%;" class='clouds'>FECHA</td>
		   <td style="width:25%;" class='clouds'>HORA</td>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php 
				$sql_user=mysqli_query($con,"select * from usuarios where id_usuario='$id_usuario'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['nombre']." ".$rw_user['apellido'];
				$sql_fecha=mysqli_query($con,"select DATE_FORMAT(fecha_entrada, '%d de %M de %Y') AS fecha, RIGHT(fecha_entrada, 8) AS hora FROM entrada where entrada.id_entrada='".$id_entrada."'");
				$rwfecha=mysqli_fetch_array($sql_fecha);
			?>
		   </td>

		  <td style="width:40%;"><?php echo $rwfecha['fecha'];?></td>
		   <td style="width:25%;" ><?php echo $rwfecha['hora'];?></td>
        </tr>
		
        
   
    </table>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <th style="width: 80%" class='clouds'>DESCRIPCION</th>
            <th style="width: 20%;text-align: right" class='clouds'>VALOR ENTRADA.</th>
            
        </tr>



        <tr style="font-style:italic; font-weight:bold; font-size: 13pt;">
            <td class='silver' style="width: 80%; text-align: left"><?php echo $descripcion;?></td>
            <td class='silver' style="width: 20%; text-align: center"><?php echo '$ '.number_format ($valor_entrada,0, ",", "."); ?></td>
        </tr>

  
    </table>
	
	<br>
	<br>
  <div style="font-size:11pt;text-align:center;font-weight:bold">-------------------------------------------------</div>
	<div style="font-size:11pt;text-align:center;font-weight:bold">-     Firma     -</div>
	
    <br>
    <br>
    <br>
    <br>
    <br>
	
	    <br>
    <br>
    <br>
        
    <?php include("encabezado_entrada.php");?>
    <br>  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='clouds'>DATOS CLIENTE</td>
           <td class='clouds'>-</td>
        </tr>
		<tr>
           <td style="width:50%;text-align: left;" >
			 Nombre:
		   </td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['nombre_cliente'];?></td>
        </tr>
        <tr>
 		   <td style="width:50%;text-align: left;"> Dirección:</td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['direccion_cliente'];?></td>
       </tr>
        <tr>
 		   <td style="width:50%;text-align: left;"> Telefono:</td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['telefono_cliente'];?></td>
       </tr>
         <tr>
 		   <td style="width:50%;text-align: left;"> NIT:</td>
		   <td style="width:50%;text-align: right;"><?php echo $rw_cliente['nit_cliente'];?></td>
       </tr>
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='clouds'>USUARIO</td>
		  <td style="width:40%;" class='clouds'>FECHA</td>
		   <td style="width:25%;" class='clouds'>HORA</td>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php echo $rw_user['nombre']." ".$rw_user['apellido'];?>
		   </td>

		  <td style="width:40%;"><?php echo $rwfecha['fecha'];?></td>
		   <td style="width:25%;" ><?php echo $rwfecha['hora'];?></td>
        </tr>
		
        
   
    </table>
	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <th style="width: 80%" class='clouds'>DESCRIPCION</th>
            <th style="width: 20%;text-align: right" class='clouds'>VALOR ENTRADA.</th>
            
        </tr>



        <tr style="font-style:italic; font-weight:bold; font-size: 13pt;">
            <td class='silver' style="width: 80%; text-align: left"><?php echo $descripcion;?></td>
            <td class='silver' style="width: 20%; text-align: center"><?php echo '$ '.number_format ($valor_entrada,0, ",", "."); ?></td>
        </tr>

  
    </table>
	
	<br>
	<br>
  <div style="font-size:11pt;text-align:center;font-weight:bold">-------------------------------------------------</div>
	<div style="font-size:11pt;text-align:center;font-weight:bold">-     Firma     -</div>
	
</page>

