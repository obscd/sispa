<?php
require_once('../Connections/conexion.php');
include ("funciones/funcionesdb.php");
$codMeta = $_GET['cod'];
$codCarpeta = $_GET['file'];
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
        nombre,
        codigo_carpeta
        FROM
        carpeta
        WHERE
        codigo_carpeta = "'.$codCarpeta.'"';
    $carpeta = fetchRow($consulta, $conexion);
    $consulta = '
        SELECT
        *
        FROM
        documentos
        WHERE
        cod_carpeta_doc = ' . $carpeta['codigo_carpeta'];
    $documentos = fetchAll($consulta, $conexion);    
}
$cabeceras = array('TITULO', 'DESCRIPCION', 'USUARIO');
$campos = array('documentos_tipo', 'documentos_descripcion', 'usuario_doc');
function tipoArchivo($archivo){
    $extencion = explode(".", $archivo);
    $tipo = $extencion[count($extencion) - 1];
    return $tipo;
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
    <tr>
        <td>CARPETA : </td>
        <td><?php echo $carpeta['nombre']; ?></td>
    </tr>
</table>
<?php }?>
<div class="row">
    <div class="col-sm-4">
        <button type="button" class="btn btn-default" onclick="documentos('carpeta','<?php echo $meta['cod_meta']; ?>','busqueda')"> Volver Atras </button>
    </div>
    <div class="col-sm-8">
        <div id="datatable-responsive_filter" class="dataTables_filter">
            <div class="text-right">
                <label>
                    <input type="text" class="form-control input-sm" id="myInput" onkeyup="mySearch()" placeholder="Buscar por titulo..." aria-controls="datatable-responsive">
                </label>
            </div>
        </div>
    </div>
</div>
<table id="myTable" class="table table-striped table-bordered" cellspacing="0">
    <tr>
        <th bgcolor="#2A3F54"><div class="text-center">Nº</div></th>
        <?php foreach ($cabeceras as $cabecera) { ?>
            <th bgcolor="#2A3F54">
                <div class="text-center"><?php echo $cabecera; ?></div>
            </th>
        <?php } ?> 
        <th bgcolor="#2A3F54"><div class="text-center">DESCARGAR ADJUNTO</div></th>
    </tr>
    <?php if($documentos){ ?>
        <?php foreach ($documentos as $num=>$fila){?>
            <tr>                        
                <td><div class="text-center"><?php echo $num+1;?></div></td>
                <?php for($i=0;$i<count($campos);$i++){?>                        
                    <td><div class="text-center"><?php echo strip_tags($fila[strtolower($campos[$i])]);?></div></td>
                <?php }?>   
                    <td><div class="text-center">
                <?php
                    $doccc = tipoArchivo($fila['cod_documento_fis']);
                    if($doccc=='jpg' || $doccc=='jpeg' || $doccc=='gif' || $doccc=='png'){
                        echo '<a href="../vendors/iniciarportal.com.php?getimg='.base64_encode('res_'.$fila['cod_documento_fis']).'" target="new">
                              <img src="../vendors/iniciarportal.com.php?getimg='.base64_encode('min_'.$fila['cod_documento_fis']).'" width="50">
                              </a>';
                        echo '<a href="../down.php?item=res_'.$fila['cod_documento_fis'].'"><img src="../images/descarga.png" width="35"></a>';		
                    }else{
                        echo '<img src="../images/'.$doccc.'.jpg" width="50">';
                        echo '<a href="../down.php?item='. $fila['cod_documento_fis'].'"><img src="../images/descarga.png" width="35"></a>';
                    }
                ?>
                </div></td>                                                                            
            </tr>
        <?php }?>
    <?php }else{?>
    <tr>
        <td colspan="<?php echo count($campos)+2;?>"><div class="text-center">No se adjuntaron Documentos.</div></td>
    </tr>
    <?php }?>
</table>