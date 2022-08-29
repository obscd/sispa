<?php
require_once('../Connections/conexion.php');
include ("funciones/funcionesdb.php");
$codMeta = $_GET['cod'];
if($codMeta){
    $consulta = '
        SELECT
        *
        FROM
        meta
        WHERE
        cod_meta = ' . $codMeta;
    $meta = fetchRow($consulta,$conexion);
    $consulta = '
        SELECT
        codigo_carpeta,
        nombre,
        count(id_documentos) AS n
        FROM
        carpeta c LEFT JOIN documentos d ON(c.codigo_carpeta=d.cod_carpeta_doc)
        WHERE
        cod_meta_carp = ' . $meta['cod_meta'].'
        GROUP BY
        codigo_carpeta';
    $carpetas = fetchAll($consulta, $conexion);
}
?>
<?php if($meta){?>
<table class="table">
    <tr>
        <td width="24%">GESTION : </td>
        <td width="73%"><?php echo $meta['gestion']; ?></td>
    </tr>
    <tr>
        <td>META : </td>
        <td><?php echo $meta['descr_meta']; ?></td>
    </tr>
</table>
<?php }?>
<hr>
<div class="row">
    <?php if($carpetas){?>
        <?php foreach($carpetas as $row){?>
            <div class="col-sm-3 col-md-3">
                <div class="thumbnail">
                    <a title="Ver Documentación" class="btn btn-succes" onClick="documentos('documento','<?php echo $codMeta; ?>&file=<?php echo $row['codigo_carpeta']; ?>','busqueda')">
                        <img src="../images/file.png" class="img-responsive">
                        <div class="caption text-center">
                            <p><?php echo $row['nombre'].' ('.$row['n'].')';?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php }?>
    <?php }else{?>
        <div class="col-sm-12">
            NO SE ENCONTRARON CARPETAS EN ESTA META
        </div>
    <?php }?>
</div>