<?php 
function contare($tabla, $columna, $valor)
{
$query_contare = "SELECT *, COUNT(programa.cod_programa) AS disp FROM ".$tabla." WHERE ".$columna." = '".$valor."' GROUP BY ".$columna;
$contare = mysql_query($query_contare, $conexion) or die(mysqli_error($conexion));
$row_contare = mysqli_fetch_assoc($contare);
$totalRows_contare = mysqli_num_rows($contare);
$row_contare['disp'];

mysqli_free_result($contare);
}
?>
