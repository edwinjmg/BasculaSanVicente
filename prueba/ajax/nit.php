<?php
if (isset($_GET['nit'])){
include("../config/db.php");
include("../config/conexion.php");
$return_arr = array();
/* Si la conexión a la base de datos, ejecuta la instruccion sql. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM clientes where nit_cliente ='" . mysqli_real_escape_string($con,($_GET['nit']))."'"); 
	//echo "SELECT * FROM clientes where nit_cliente ='" . mysqli_real_escape_string($con,($_GET['nit']))."'";
	/* Recupera y almacena en un array el resultado de la consulta.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['nombre_cliente'];
		$row_array['id_cliente']=$id_cliente;
		$row_array['nombre_cliente']=$row['nombre_cliente'];
		$row_array['telefono_cliente']=$row['telefono_cliente'];
		$row_array['nit_cliente']=$row['nit_cliente'];
		$row_array['direccion_cliente']=$row['direccion_cliente'];
		array_push($return_arr,$row_array);
    
	}
}

/* Libera los recursos de conexión. */
mysqli_close($con);
//echo (console.log("'.$return_arr.'"));

/* Devuelve los resultados en un array en formato json. */
//print_r($row_array);
echo json_encode($return_arr);
}
?>