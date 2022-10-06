<?php
//Creacion objeto para almacenar los errores
 $errors = array();

/*--------------------------------------------------------------*/
/* Funcion para mostrar los mensajes de error o para los usuarios
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg =''){
   $output = array();
   $mensaje="";
   $alertTipo="";
   $icono="";
   if(!empty($msg)) {
      foreach ($msg as $key => $value) {
        if ($key=="danger") {
          $alertTipo="Peligro";
          $icono="<i class=\"icon fa fa-ban\"></i>";
        }
        if ($key=="warning") {
          $alertTipo="Precaución";
          $icono="<i class=\"icon fa fa-warning\"></i>";
        }
        if ($key=="success") {
          $alertTipo="Exito";
          $icono="<i class=\"icon fa fa-check\"></i>";
        }
        if ($key=="info") {
          $alertTipo="Información";
          $icono="<i class=\"icon fa fa-info\"></i>";
        }
         $output  = "<div class=\"alert alert-{$key} col-md-12\">".
          "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>".
          "<h4>{$icono}{$alertTipo}</h4>".
          remove_junk(first_character($value)).
          "</div>";
      }
      return $output;
   } else {
     return "" ;
   }
}
/*--------------------------------------------------------------*/
/* Mayusculas en el primer caracter
/*--------------------------------------------------------------*/
function first_character($str){
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* Remover caracteres html
/*--------------------------------------------------------------*/
function remove_junk($str){
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}
/*--------------------------------------------------------------*/
/*Funcion para redireccionar
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}

?>
