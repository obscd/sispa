<?php
//establecemos el timezone para obtener la hora local
date_default_timezone_set('America/El_Salvador');
 
//la fecha y hora de exportación sera parte del nombre del archivo Excel
$fecha = date("d-m-Y");
$gestion = date("Y");
if (isset($_POST['gestion'])) {
    $gestion = $_POST['gestion'];
}

//Inicio de exportación en Excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte-$gestion-$fecha.xls"); //Indica el nombre del archivo resultante
header("Pragma: no-cache");
header("Expires: 0");

//require_once('../locklvl.php'); 
//require_once('../lock.php'); 
require_once('../Connections/conexion.php');

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
        // $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        global $conexion;
        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conexion, $theValue) : mysqli_escape_string($conexion, $theValue);

        switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
        }
        return $theValue;
    }
}

$inicio = 2021;

for ($i=1; $i < 6; $i++) { 
    $gestiones[$i]=$inicio;
    $inicio++;
}

mysqli_select_db($conexion, $database_conexion);

# metas

$query_metas = sprintf("SELECT *  FROM pilar
                        INNER JOIN programa ON pilar.cod_pilar = programa.cod_pilar_pro
                        INNER JOIN accion ON programa.cod_programa = accion.cod_programa_ac
                        INNER JOIN coordinador ON accion.cod_accion = coordinador.cod_quien_necesita
                        INNER JOIN meta ON coordinador.cod_meta_coord = meta.cod_meta
                        INNER JOIN meta_usaurios ON meta.cod_meta = meta_usaurios.cod_meta_mtus
                        INNER JOIN entidad ON meta_usaurios.meta_login = entidad.sigla 
                        WHERE meta.gestion = %s",
                        GetSQLValueString($gestion, "text"));
$query_metas_groupby = $query_metas." GROUP BY meta.cod_meta;";
$metas = mysqli_query($conexion, $query_metas_groupby) or die(mysqli_error($conexion));
$row_metas = mysqli_fetch_assoc($metas);
$totalRows_metas = mysqli_num_rows($metas);

//Aqui va la tabla HTML
$head =  '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <style type="text/css">
        table {
            border: 1px solid;
        }

        table tr th {
            border: 1px solid;
            background-color: black;
            color: white !important;
        }
    </style>
  </head>
  <body>
    <table>
        <thead>
            <tr>
                <th>Componente</th>
                <th>Programa</th>
                <th>Acción</th>
                <th>Indicador</th>
                <th>Meta</th>
                <th>Avance</th>
                <th>% de avance</th>
                <th>Entidad</th>
            </tr>
        </thead>';

$body = '<tbody>';
    $j=1;
    $porcentaje_conteo;
    do {
        $pilar_descripcion = $row_metas["titulo_pilar"];
        $pilar_cod = $row_metas["cod_pilar"];
        $pilar_id = $row_metas["orden_pilar"];
        $programa_descripcion = $row_metas["titulo_programa"];
        $programa_cod =  $row_metas["cod_programa"];
        $programa_id = $row_metas["orden_programa"];
        $accion_descripcion = $row_metas["descr_accion"];
        $meta_descripcion = $row_metas["descr_meta"];
        $meta_cumplimiento = $row_metas["cumplimiento_meta"];
        $meta_respuesta = $row_metas["respuesta_real_decumpl"];

        if($row_metas["orden_programa"]==1 && $row_metas["orden_accion"]==1){
            # metas por pilar/componente 
            
            $query_metas_por_pilar = sprintf("AND pilar.cod_pilar = %s GROUP BY meta.cod_meta",
                GetSQLValueString($pilar_cod, "text"));
            $query_metas_por_pilar = $query_metas.$query_metas_por_pilar;
            $metas_por_pilar = mysqli_query($conexion, $query_metas_por_pilar) or die(mysqli_error($conexion));
            //$row_metas_pilar = mysqli_fetch_assoc($metas_por_pilar);
            $totalRows_metas_pilar = mysqli_num_rows($metas_por_pilar);

    
            $body = $body.'<tr>
            <!-- Componente/pilar -->
            <td style="vertical-align: middle;" rowspan="'.$totalRows_metas_pilar.'">'.$pilar_id.'. '.$pilar_descripcion.'</td>';
        } 
        if($row_metas["orden_accion"]==1) {
            # metas por pilar/componente y por programa
            $query_metas_pilar_programa = sprintf("AND pilar.cod_pilar = %s AND programa.cod_programa = %s GROUP BY meta.cod_meta",
                GetSQLValueString($pilar_cod, "text"),
                GetSQLValueString($programa_cod, "text"));
            $query_metas_pilar_programa = $query_metas.$query_metas_pilar_programa;
            $metas_pilar_programa = mysqli_query($conexion, $query_metas_pilar_programa) or die(mysqli_error($conexion));
            //$row_metas_pilar = mysqli_fetch_assoc($metas_por_pilar);
            $totalRows_metas_pilar_programa = mysqli_num_rows($metas_pilar_programa);

            $body = $body.'<td style="vertical-align: middle;" rowspan="'.$totalRows_metas_pilar_programa.'">'.$pilar_id.'.'.$programa_id.'. '.$programa_descripcion.'</td>';

        }
        
        $body = $body.'<td>'.$accion_descripcion.'</td>
        <td>'.$meta_descripcion.'</td>
        <td class="text-right">'.$meta_cumplimiento.'</td>
        <td class="text-right">'.$meta_respuesta.'</td>';
            if ($meta_cumplimiento>0){
                if ($meta_respuesta >0) {
                    $porcentaje = 100*$meta_respuesta/$meta_cumplimiento;
                } else {$porcentaje=0;}
            } else { $porcentaje=100;}

            if ($porcentaje<34) {$class = "btn-danger";} 
            if($porcentaje>33 && $porcentaje<67) {$class = "btn-warning";}
            if($porcentaje>67 && $porcentaje<101) {$class = "btn-success";}
 
            $body = $body.'<td class="text-right '.$class.'">'.$porcentaje.'</td>'; 
            $porcentaje_conteo[$j] = $porcentaje;
            $j++;

            mysqli_select_db($conexion, $database_conexion);
            $query_listarusuarios = sprintf("SELECT * FROM meta_usaurios WHERE cod_meta_mtus = %s ORDER BY id ASC", 
                GetSQLValueString($row_metas["cod_meta"], "text"));
            $listarusuarios = mysqli_query($conexion, $query_listarusuarios) or die(mysqli_error($conexion));
            $row_listarusuarios = mysqli_fetch_assoc($listarusuarios);
            $totalRows_listarusuarios = mysqli_num_rows($listarusuarios);
            $body = $body.'<td>';

            do {

                    $body = $body.$row_listarusuarios["meta_login"].'</br>';

            } while ($row_listarusuarios = mysqli_fetch_assoc($listarusuarios));
            $body = $body.'</td>
            </tr>';


    } while ($row_metas = mysqli_fetch_assoc($metas));

    $total = array_sum($porcentaje_conteo)/count($porcentaje_conteo);
    $total = round($total, 2);
 
$foot = '</tbody><tfoot>
    <tr>
        <th colspan="6">TOTAL</th>
        <th class="text-right">'.$total.'</th>
        <th></th>
    </tr>
</tfoot>
</table>
</body
</html>';

echo $head.$body.$foot;
?>