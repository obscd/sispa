<?php
// 
$query = "SELECT programa.cod_programa, COUNT(accion.id_accion) AS nprogra FROM (programa LEFT JOIN accion ON programa.cod_programa=accion.cod_programa_ac)  GROUP BY accion.cod_programa_ac";
function inicipcounter($consulta, $conexion, $variable, $valor)
{

$tactividad = mysql_query($consulta, $conexion) or die(mysqli_error($conexion));
$row_tactividad = mysqli_fetch_assoc($tactividad);
$vector['ted']="thot";
		do { 
			$accion[$row_tactividad[$variable]]=$row_tactividad[$valor];
		  } while ($row_tactividad = mysqli_fetch_assoc($tactividad));
return $vector[];
}
inicipcounter($query,$conexion,'cod_programa','nprograma')

?>
