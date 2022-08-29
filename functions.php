<?php
$valc=0; // un contador por pagina
$color1='bgcolor="#fff"';// color de fondo tablas %2
$color2='bgcolor="#fff"';// color de fondo tablas
$close='Cerrar';
$editar="EDITAR";
function semaforo($sforo)
{
	$colrojo='class="rojo"';
	$colamarillo='class="amarillo"';
	$colverde='class="verde"';
	$negro='class="rojo"';

	if($sforo > 0 && $sforo < 33)
	{
		return ($colrojo);
	}
	if($sforo > 32 && $sforo < 85)
	{
		return ($colamarillo);
	}
	if($sforo > 84 && $sforo < 101)
	{
		return ($colverde);
	}
    if($sforo >  100)
	{
		return ($colverde);
	}
	if($sforo == 0)
	{
		return ($negro);
	}
}


$editFormActionx=1;//solo es para el truco de facturacion factura simple/facturar/index linea 39
//----------------------------- op aux configuracions
if (isset($_SESSION['ccontrol']))
	{
	$_SESSION['ccontrol']='';
	}
if (isset($_SESSION['MM_UserGroup']))
	{

		$nacceso=$_SESSION['MM_UserGroup'];// comparar en menus y paginas
	}
//$_SESSION["varnew"]=0;
//********************************************
// <a href="<?php echo ira('actividad.php'); ">empresa</a>

$hora=date('H:i:s');
$fecha = date('Y-m-d');
$fd=date('d');
$fm=date('m');
$fa=date('Y');
function fechaesp($fecha)
{
$fesp=explode('-',$fecha);
return $fesp[2].'/'.$fesp[1].'/'.$fesp[0];
}
//-----------------------------------------------------

function decimal($de)// formato con demial y separacion de miles
{
return 	number_format($de, 2, '.', ',');
}
//-------------------------------------------------------------
function cerosiz($ceron,$cerodig) // ceros a la izquierda
{
return str_pad($ceron,$cerodig, '0', STR_PAD_LEFT);
}

//*************************************************************
function diferenciaDias($inicio, $fin)
{
    $inicio = strtotime($inicio);
    $fin = strtotime($fin);
    $dif = $fin - $inicio;
    $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
    return ceil($diasFalt);
}
//***********************************************************
function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
$key=date('Ymdhis');//."_".$key;
return $key;
}
$a=32;

function contare($tabla, $columna, $valor)
{

$query_contare = "SELECT *, COUNT(".$columna.") AS disp FROM ".$tabla." WHERE ".$columna." = '".$valor."' GROUP BY ".$columna;
return ($query_contare);
}

function copiardir($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
function tipo($tip)
{
		$tipex = end(explode(".", $tip));
		return $tipex;
}


function resizeImagen($ruta, $nombre, $alto, $ancho,$nombreN,$extension){
    $rutaImagenOriginal = $ruta.$nombre;
    if($extension == 'GIF' || $extension == 'gif'){
    $img_original = imagecreatefromgif($rutaImagenOriginal);
    }
    if($extension == 'jpg' || $extension == 'JPG'){
    $img_original = imagecreatefromjpeg($rutaImagenOriginal);
    }
    if($extension == 'png' || $extension == 'PNG'){
    $img_original = imagecreatefrompng($rutaImagenOriginal);
    }
    $max_ancho = $ancho;
    $max_alto = $alto;
    list($ancho,$alto)=getimagesize($rutaImagenOriginal);
    $x_ratio = $max_ancho / $ancho;
    $y_ratio = $max_alto / $alto;
    if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho
  	$ancho_final = $ancho;
		$alto_final = $alto;
	} elseif (($x_ratio * $alto) < $max_alto){
		$alto_final = ceil($x_ratio * $alto);
		$ancho_final = $max_ancho;
	} else{
		$ancho_final = ceil($y_ratio * $ancho);
		$alto_final = $max_alto;
	}
    $tmp=imagecreatetruecolor($ancho_final,$alto_final);
    imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
    imagedestroy($img_original);
    $calidad=70;
    imagejpeg($tmp,$ruta.$nombreN,$calidad);

}


?>