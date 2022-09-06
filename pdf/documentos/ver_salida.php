<?php
	/*-------------------------
	Autor: Edwin Medina
	
	Mail: edwin.jmg@gmail.com
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../registro.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	//Archivo de funciones PHP
	include("../../funciones.php");
	$id_salida= intval($_GET['id_salida']);
	$sql_count=mysqli_query($con,"select * from salida where id_salida='".$id_salida."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Salida no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_salida=mysqli_query($con,"select * from salida where id_salida='".$id_salida."'");
	$rw_salida=mysqli_fetch_array($sql_salida);
	//$numero_compra=$rw_compra['numero_compra'];
	$id_cliente=$rw_salida['id_cliente'];
	$id_usuario=$rw_salida['id_usuario'];
	$fecha_salida=$rw_salida['fecha_salida'];
	$descripcion=$rw_salida['descripcion'];
	$valor_salida=$rw_salida['valor_salida'];
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_salida_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'letter', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('salida.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }