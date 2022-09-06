<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* Si la conexión a la base de datos, ejecuta la instruccion sql. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM bancos where nombre_cuenta like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,20"); 
	
	/* Recupera y almacena en un array el resultado de la consulta.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_banco=$row['id_banco'];
		$row_array['value'] = $row['nombre_cuenta'];
		$row_array['id_banco']=$id_banco;
		$row_array['nombre_cuenta']=$row['nombre_cuenta'];
		$row_array['numero_cueta']=$row['numero_cuenta'];
		array_push($return_arr,$row_array);
    }
	
}

/* Libera los recursos de conexión. */
mysqli_close($con);
//echo (console.log("'.$return_arr.'"));

/* Devuelve los resultados en un array en formato json. */
echo json_encode($return_arr);
}
?>