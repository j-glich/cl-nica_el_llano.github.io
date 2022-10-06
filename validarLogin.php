<?php
define('ruta',$_SERVER['DOCUMENT_ROOT']);
require_once(ruta."/clinica/config/conexion.php");
//include_once 'includes/load.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
// include_once 'php/db/database.php';
global $db;

if(!session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE){
    session_start();
}
if (isset($_POST['nombreUsuario'])&&isset($_POST['contrasenaUsuario'])) {
  $nombre=$_POST['nombreUsuario'];
  $contrasena=$_POST['contrasenaUsuario']; 
  $new_pass_encr = md5($contrasena);

  $sql = "call sp_validar_usuario('$nombre','$new_pass_encr') ";
  $result=execQuery($sql);

  foreach( $result as $row){
  
   if($row['US_R_ROL'] == '1'  && $row['US_PASSWORD'] == $new_pass_encr){
      $session->login($row['US_NOMBRE']);
      $session->usuarioLogeado();
      $session->tipoUsuario($row['US_R_ROL']);
      $session->periodo($row['PE_ACTIVO']);
      $session->area('ISC');
    }
  }
        //Registrar el periodo
        /*
        Este código se tiene que reemplazar con la llamada al procedimiento almacenado. 
        */
  redirect("dist/index.php",false);
}else{
  $session->msg("w", "Nombre de usuario y/o contraseña incorrecto.");
  redirect("dist/page-login.php",false);
}
//    $sql = "CALL `sp_login_usuario`('{$nombre}','{$contrasena}',@valido,@tipo)";
//    $result=execQuery($sql);
  //  var_dump($result);
//    foreach ($result as $key) {
//      if ($key['valido']!=NULL) {


  //Usuario
 
   //   }else{
   //     $session->msg("w", "Nombre de usuario y/o contraseña incorrecto.");
    //    redirect("login.php",false);
    //  }
    //}
//}
//catch(Exception $e){
//    $session->msg("d", "Algo salio mal intentalo de nuevo");
//}



// var_dump($_SESSION);
?>

?>
