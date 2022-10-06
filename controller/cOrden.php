<?php
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '0';
if($opcion == 1){
  $fechaC = $_POST['dateC'];
  $fechaE = $_POST['dateE'];
  $proveedor = $_POST['proveedor'];
  $formap = $_POST['formpago'];
}
if($opcion == 2){
  $tam_producto = $_POST['tam_producto'];
  $sp_cargaH = $_POST['sp_cargaH'];
  $folio = $_POST['folio'];
}
if($opcion == 3 || $opcion == 10){
  $id = $_POST['id'];
}
if($opcion == 4 || $opcion == 5 || $opcion ==7){
  $id = $_POST['id'];
}
if($opcion == 6){
  $id = $_POST['id'];
  $fechaC = $_POST['fechaC'];
  $fechaE = $_POST['fechaE'];
  $proveedor = $_POST['proveedor'];
  $formap = $_POST['formpago'];
}
if ($opcion == 11) {
  $dateC = $_POST['dateC'];
  $dateE = $_POST['dateE'];
  $proveedor = $_POST['proveedor'];
  $formap = $_POST['formpago'];
  $strCarga = $_POST['strCarga'];
}
 require_once("../models/mOrden.php");
 /* Bloque de control para poder realizar la actualización de los registros */

function listar_productos_orden($id){
  return liOrdenC($id);
}
function listar_orden_x_id($id){
return liOrdenC_x_id($id);
}
function listar_metodo_pago(){
  return limetodo();
  }
  function listar_total_a_pagar($id){
    return litotal($id);
    }
    function listar_pagos($id){
      return lipago($id);
      }

    function listar_total_a_pagar_general($id){
        return litotal2($id);
        }
        
?>

