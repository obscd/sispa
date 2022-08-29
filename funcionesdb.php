<?php
function fetchAll($query,$model)
{
    $resultado=mysqli_query($model, $query);
    $tabla=mysql_fetch_all($resultado);
    mysqli_free_result($resultado);
    return $tabla;
}

function fetchRow($query,$model)
{
    $resultado = mysqli_query($model, $query) or die(mysqli_error($model));
    $fila = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);
    return $fila;
}
function find($tabla,$find,$campo,$model)
{
    $query1="select
    *
    from ".$tabla."
    where  ".$campo."='".$find."'
    ";
    $datos=fetchRow($query1,$model);
    return $datos;
}

function findAll($tabla,$find,$campo,$model)
{
    $query1="select
    *
    from ".$tabla."
    where  ".$campo."='".$find."'
    ";
    $datos=fetchAll($query1,$model);
    return $datos;
}

function mysql_fetch_all($result)
{
    $all = array();
    while ($row = mysqli_fetch_assoc($result)){ $all[] = $row; }
    return $all;
}