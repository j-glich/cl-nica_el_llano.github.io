<?php
try {
    require_once($_SERVER['DOCUMENT_ROOT']."/clinica/config/conexion.php");
  } catch (\Exception $e) {
    require_once("../config/conexion.php");
  }

require __DIR__ . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$nombreArchivo = "SISTEMA FARMACIA.xlsx";
$documento = IOFactory::load($nombreArchivo);
$hojaActual =$documento->getSheet(2);

$numeroFilas = $hojaActual->getHighestDataRow();
$letra = $hojaActual->getHighestColumn();
$numeroLetra = Coordinate::columnIndexFromString($letra);
$categoria = 3;
$user = 200;
$ip_adress= $_SERVER['REMOTE_ADDR'];
if($ip_adress=='::1')
  $ip_adress="127.0.0.1";

for ($indiceFila=2; $indiceFila <= $numeroFilas; $indiceFila++) { 
  $id_producto = $hojaActual->getCellByColumnAndRow(1,$indiceFila);
  $cantidad = $hojaActual->getCellByColumnAndRow(3,$indiceFila);
  $fecha = $hojaActual->getCellByColumnAndRow(5,$indiceFila)->getValue();
  if ($cantidad == '') {
    $cantidad = 0;
  }

  $date2 = Date::excelToDateTimeObject($fecha);
 if($date2->format('Y-m-d')  == "1970-01-01"){
    $fecha = "";
    $sql = "call sp_al_in_entra_inventario_excel2('$id_producto','$cantidad',NULL,'$user','$ip_adress');";
    $result = execQuery($sql);
    echo " ".  $id_producto .'-'. $cantidad . '-' . $fecha . '<br>';
  }else{
    $fecha = $date2->format('Y-m-d');
    $sql = "call sp_al_in_entra_inventario_excel2('$id_producto','$cantidad','$fecha','$user','$ip_adress');";
    $result = execQuery($sql);
  echo " ".  $id_producto .'-'. $cantidad . '-' . $fecha . '<br>';
  }
}


?>