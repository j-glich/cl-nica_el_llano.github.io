<?php
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '0';
if($opcion == 1){
$in_nombre = $_POST['in-nombre'];
$in_correo = $_POST['in-correo'];
$in_rfc = ($_POST['in-rfc']) ;
$contacto= ($_POST['contacto']);
}
if($opcion == 2){
  $id = $_POST['id'];
  $in_nombre = $_POST['in-nombre'];
  $in_correo = $_POST['in-correo'];
  $in_rfc = ($_POST['in-rfc']) ;
  $contacto= ($_POST['contacto']);
  }

 require_once("../models/mProveedor.php");
 /* Bloque de control para poder realizar la actualización de los registros */

/**      ******************** */ 
 function listar_proveedores(){
    return li_proveedores();
  }
  
?>



