<?php
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '0';
if($opcion == 1){
$id_p = $_POST['id'];
$nom_lote = (isset($_POST['lote'])) ? $_POST['lote'] : '';
$fecha_cad = $_POST['fechaC'];
$fecha_fa = $_POST['fechaF'];
$cantidad = $_POST['cantidad'];
$id_orden_producto = $_POST['id_orden_producto'];
$almacen = $_POST['almacen'];
}
if($opcion == 3){
  $id = $_POST['id'];

}
if($opcion == 2 || $opcion == 4){
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $lote = $_POST['lote'];
  $fechaC = $_POST['fechaC'];
  $fechaF = $_POST['fechaF'];
  $cantidad = $_POST['cantidad'];
}
if($opcion == 5){
  $id = $_POST['cve_producto'];
  $nom_lote = $_POST['lote'];
  $fecha_cad = $_POST['fechaC'];
  $fecha_fa = $_POST['fechaF'];
  $cantidad = $_POST['cantidad'];
  }
  if($opcion == 10){
    
    $almacen = $_POST['almacen'];
    $id = $_POST['cve_producto'];
    $nom_lote = $_POST['lote'];
    $fecha_cad = $_POST['fechaC'];
    $fecha_fa = $_POST['fechaF'];
    $cantidad = $_POST['cantidad'];
    }


 require_once("../models/mInventario.php");
 /* Bloque de control para poder realizar la actualización de los registros */

/**      ******************** */ 
 function listar_proveedores(){
    return li_proveedores();
  }
  function listar_alamacen(){
    return almacen();
  }

  function listar_consulta($producto,$almacen,$categoria,$existencia,$fechaC,$estado){
     return consulta($producto,$almacen,$categoria,$existencia,$fechaC,$estado);
  }

    
?>


