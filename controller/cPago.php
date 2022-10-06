<?php
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '0';
if($opcion == 1){
  $folio_orden = $_POST['fol_orden'];
  $metodoP = $_POST['metodoP'];
  $factura = $_POST['factura'];
  $comentarios = $_POST['comentarios'];
  $pagTotal = $_POST['pagTotal'];
}

require_once("../models/mPago.php");

?>