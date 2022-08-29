<?php
require_once('../functions.php');
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "localhost";
$database_conexion = "monitoreo2";
$username_conexion = "root";
$password_conexion = "";
$conexion = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion); 
mysqli_select_db($conexion, $database_conexion);

function mysqli_result($res, $row, $field=0) {
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
} 
?>