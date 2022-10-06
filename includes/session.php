<?php
// clase para las sesiones de usuarios
if(!isset($_SESSION))
{ session_start(); }
class Session {

 public $msg;
 private $login = false;

 function __construct(){
   $this->flash_msg();
   $this->userLoginSetup();
 }

  public function usuarioLogeado(){
    return $this->login;
  }
  public function login($user_id){
    $_SESSION['user_id'] = $user_id;
  }

  public function periodo($periodo){
    $_SESSION['periodo'] = $periodo;
  }

  public function area($area){
    $_SESSION['area'] = $area;
  }
  public function id_docente($docente){
    $_SESSION['id_docente'] = $docente;
  }

  public function usuarioID($user_id){
    $_SESSION['usuario_id'] = $user_id;
  }

  public function tipoUsuario($tipo){
    $_SESSION['tipo_usuario'] = $tipo;
  }
  private function userLoginSetup()
  {
    if(isset($_SESSION['user_id']))
    {
      $this->login = true;
    } else {
      $this->login = false;
    }

  }
  public function logout(){
    unset($_SESSION['user_id']);
  }

  
  public function msg($type ='', $msg =''){
    if(!empty($msg)){
       if(strlen(trim($type)) == 1){
         $type = str_replace( array('d', 'i', 'w','s'), array('danger', 'info', 'warning','success'), $type );
       }
       $_SESSION['msg'][$type] = $msg;
    } else {
      return $this->msg;
    }
  }

  private function flash_msg(){

    if(isset($_SESSION['msg'])) {
      $this->msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    } else {
      $this->msg;
    }
  }
}

$session = new Session();
$msg = $session->msg();

?>