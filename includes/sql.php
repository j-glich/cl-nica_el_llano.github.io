<?php
  //require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Funcion para obtener los resultados de la bd
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Buscar por id en la bd
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Borrar por id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Contar los campos totales de una tabla por id
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Verificar si la tabla de la bd existe
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Verificar login
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }



  /*--------------------------------------------------------------*/
  /* Que usuario esta logeado
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Busar todos los usuarios
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Actualizar ultimo login del usuario
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Buscar todos los grupos de usuarios
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Buscar nivel de usuario
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  function find_area(){
    global $db;
    $sql="select * from area";
    return find_by_sql($sql);
  }
  /*--------------------------------------------------------------*/
  /* Verificar el nivel de usuario logeado
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     if ($require_level==4) {
       return true;
     }
     //if No esta loegado
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor Iniciar sesión...');
            redirect('index.php', false);
      //if grupo de usaurio dado de baja
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','Este nivel de usaurio esta inactivo!');
           redirect('home.php',false);
      //Veriicar el nivel del usuario en la pagina redierct a home
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo siento!  no tienes permiso para ver la página.");
            redirect('home.php', false);
        endif;

     }
     //Buscar cantidad de un producto
    function request_stock($id){
    global $db;
    $sql= "SELECT quantity from products where id=".$id  ;
    return find_by_sql($sql);
    }
      /**
       * Ingresar a la bd Solicitud del usaurio prestamo
       */
   function requestOut($id,$stock,$user_id,$quantity,$date_delivery_product,$date_delivery_product_2){
     global $db;
     //INSERT INTO `request` (`id_request`, `id_product`, `id_user`, `date_request`, `date_delivery`) VALUES
     $date = make_date();
     $sql="INSERT INTO request (id_product,id_user,date_request,status,quantity,date_delivery_product,date_delivery_user_expect) values (";
     $sql .="'$id','$user_id','$date','1','$quantity','$date_delivery_product','$date_delivery_product_2')";
     $db->query($sql);
     $sql="";
     $sql = "UPDATE products SET quantity='$stock' WHERE id = '{$id}'";
        $db->query($sql);
     return $db->affected_rows()=== 1 ? true : false;
   }
   /**
    * Conteo total de solicitudes
    */
  function total_request(){
    global $db;
    $sql="select id_request from request WHERE status=1";
    return find_by_sql($sql);
  }
  /**
   * Autorizar solicitud
   */
  function authorize_request($id){
    global $db;
    $date = make_date();
    $sql="UPDATE request set status=0, date_delivery='$date' where id_request=".$id;
    $db->query($sql);
    return $db->affected_rows()=== 1 ? true : false;
  }
  /**
   * Atualizar solicitud estatus cambiar
   */
  function update_request(){
    global $db;
    $sql="select * from request where status=1";
    $res=$db->query($sql);

    $data=find_by_sql($sql);
    $names_products = array();
    $names_users = array();
    $dates_requests = array();
    $id_requests = array();
    $quantity=array();
    $id_products=array();
    $dates_delivery_product=array();
    foreach ($data as $key) {
        $sql="select name from products where id=";
        $sql.=$key['id_product'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_products,$data2['name']);
        $sql="select name from users where id=".$key['id_user'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_users,$data2['name']);
        array_push($dates_requests,substr($key['date_request'],0,-9));
        array_push($id_requests,$key['id_request']);
        array_push($quantity,$key['quantity']);
        array_push($id_products,$key['id_product']);
        array_push($dates_delivery_product,$key['date_delivery_product']);
    }
    $fields=array($id_requests,$names_products,$names_users,$dates_requests,$quantity,$id_products,$dates_delivery_product);

    return $fields;
  }
  /**
   * Seleccionar area
   */
  function select_area(){
    global $db;
    $sql="select * from area";
    return find_by_sql($sql);
  }
  function request_total($status){
    global $db;
    if ($status==0) {
      $sql="select * from request where status=0";
    }else{
      $sql="select * from request";
    }
    $data=find_by_sql($sql);
    $names_products = array();
    $names_users = array();
    $dates_requests = array();
    $dates_delivery = array();
    $dates_delivery_user = array();
    $dates_delivery_user_expect = array();
    $dates_delivery_product = array();
    $id_requests = array();
    $status = array();
    $quantity=array();
    $comment=array();
    foreach ($data as $key) {
        $sql="select name from products where id=";
        $sql.=$key['id_product'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_products,$data2['name']);
        $sql="select name from users where id=".$key['id_user'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_users,$data2['name']);
        array_push($dates_requests,$key['date_request']);
        array_push($dates_delivery,$key['date_delivery']);
        array_push($id_requests,$key['id_request']);
        array_push($dates_delivery_user,$key['date_delivery_user']);
        array_push($dates_delivery_user_expect,$key['date_delivery_user_expect']);
        array_push($dates_delivery_product,$key['date_delivery_product']);
        array_push($quantity,$key['quantity']);
        array_push($status,$key['status']);
        array_push($comment,$key['comment']);
    }
    $fields=array($id_requests,$names_products,$names_users,$dates_requests,
    $dates_delivery,$dates_delivery_user,$dates_delivery_product,$status,
    $quantity,$comment,$dates_delivery_user_expect);

    return $fields;
  }
  /**
   * Buscar productos por rango de fechas
   */
  function product_date($date_first,$date_second){
    global $db;
    $sql="SELECT * from request where date_request BETWEEN '$date_first 00:00:00'  AND '$date_second 23:59:59' ";
    $data=find_by_sql($sql);
    $names_products = array();
    $names_users = array();
    $dates_requests = array();
    $dates_delivery = array();
    $dates_delivery_user = array();
    $dates_delivery_product = array();
    $id_requests = array();
    $status = array();
    $dates_delivery_user_expect = array();
    $quantity=array();
    $comment=array();
    foreach ($data as $key) {
        $sql="select name from products where id=";
        $sql.=$key['id_product'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_products,$data2['name']);
        $sql="select name from users where id=".$key['id_user'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_users,$data2['name']);
        array_push($dates_requests,$key['date_request']);
        array_push($dates_delivery,$key['date_delivery']);
        array_push($id_requests,$key['id_request']);
        array_push($dates_delivery_user,$key['date_delivery_user']);
        array_push($dates_delivery_product,$key['date_delivery_product']);
        array_push($quantity,$key['quantity']);
        array_push($dates_delivery_user_expect,$key['date_delivery_user_expect']);
        array_push($status,$key['status']);
        array_push($comment,$key['comment']);
    }
    $fields=array($id_requests,$names_products,$names_users,$dates_requests,
    $dates_delivery,$dates_delivery_user,$dates_delivery_product,$status,$comment,$dates_delivery_user_expect);

    return $fields;
  }
  /**
   * Total de productos para generar pdf
   */
  function request_total_pdf(){
    global $db;
    $sql="select * from request";
    $res=$db->query($sql);

    $data=find_by_sql($sql);
    $names_products = array();
    $names_users = array();
    $dates_requests = array();
    $dates_delivery = array();
    $dates_delivery_user = array();
    $dates_delivery_product = array();
    $id_requests = array();
    $status = array();
    $comment=array();
    foreach ($data as $key) {
        $sql="select name from products where id=";
        $sql.=$key['id_product'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_products,$data2['name']);
        $sql="select name from users where id=".$key['id_user'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_users,$data2['name']);
        array_push($dates_requests,$key['date_request']);
        array_push($dates_delivery,$key['date_delivery']);
        array_push($id_requests,$key['id_request']);
        array_push($dates_delivery_user,$key['date_delivery_user']);
        array_push($dates_delivery_product,$key['date_delivery_product']);
        array_push($status,$key['status']);
        array_push($comment,$key['comment']);
    }
    $fields=array($id_requests,$names_products,$names_users,$dates_requests,
    $dates_delivery,$dates_delivery_user,$dates_delivery_product,$status,$comment);

    return $fields;
  }
  /**
   * Entrega de material actualizar db
   */
  function request_delivery($id,$quantity,$comment){
    global $db;
    $date="";
    $sql="SELECT id_product from request where id_request=".$id;
    $date.=$sql;
    $data=find_by_sql($sql);
    foreach ($data as $key) {
      $id_product=$key['id_product'];
    }
    $date_delivery_product=make_date();
    $sql="UPDATE request set status=2,comment='$comment',date_delivery_user='$date_delivery_product' where id_request=".$id;
    $date.=$sql;
    $db->query($sql);
    $sql="UPDATE products set quantity=quantity+'$quantity' where id=".$id_product;
    $date.=$sql;
    $db->query($sql);
    return $date;
  }
  /**
   * Entrega de material
   */
  function request_delivery_comment($id,$quantity,$comment){
    global $db;
    $sql="SELECT id_product from request where id_request=".$id;
    $data=find_by_sql($sql);
    foreach ($data as $key) {
      $id_product=$key['id_product'];
    }
    $date_delivery_product=make_date();
    $sql="UPDATE request set status=2,comment='$comment',date_delivery_user='$date_delivery_product' where id_request=".$id;
    $db->query($sql);
    $sql="UPDATE products set quantity=quantity+'$quantity' where id=".$id_product;
    $db->query($sql);
    return $db->affected_rows()=== 1 ? true : false;
  }
  /**
   * Eliminar solicitud de la db
   */
  function request_remove($id,$id_product){
    global $db;
    $sql="select quantity from request where id_request=".$id;
    $data=find_by_sql($sql);
    foreach ($data as $key) {
      $quantity=$key['quantity'];
    }
    $sql="UPDATE products set quantity=quantity+'$quantity' where id=".$id_product;
    $db->query($sql);

    $sql="delete from request where id_request=".$id;
    $sql.=" and status=1";
    $db->query($sql);
    return $db->affected_rows()=== 1 ? true : false;
  }

  /**
   * Solicitud pendiente para usuario
   */
  function request_pending($id){
    global $db;
    $sql="select * from request where id_user=".$id;
    $sql.= " and status=1";
    $res=$db->query($sql);

    $data=find_by_sql($sql);
    $names_products = array();
    $names_users = array();
    $dates_requests = array();
    $dates_delivery = array();
    $dates_delivery_product = array();
    $id_requests = array();
    $status = array();
    $id_products=array();
    $quantity=array();
    foreach ($data as $key) {
        $sql="select name from products where id=";
        $sql.=$key['id_product'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_products,$data2['name']);
        $sql="select name from users where id=".$key['id_user'];
        $res=$db->query($sql);
        $data2=$res->fetch_array(MYSQLI_ASSOC);
        array_push($names_users,$data2['name']);
        array_push($dates_requests,$key['date_request']);
        array_push($dates_delivery,$key['date_delivery']);
        array_push($id_requests,$key['id_request']);
        array_push($status,$key['status']);
        array_push($id_products,$key['id_product']);
        array_push($quantity,$key['quantity']);
        array_push($dates_delivery_product,$key['date_delivery_product']);
    }
    $fields=array($id_requests,$names_products,$names_users,$dates_requests,$dates_delivery,$status,$id_products,$quantity,$dates_delivery_product);

    return $fields;
  }
/**
 * Mostrar productos
 */
  function join_product_table(){
     global $db;
      $sql  =" SELECT p.id,p.name,p.quantity,p.media_id,p.date,p.description,c.name";
      $sql  .=" AS categorie,m.file_name AS image";
      $sql  .=" FROM products p";
      $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
      $sql  .=" LEFT JOIN media m ON m.id = p.media_id WHERE p.quantity>0 ";
      $sql  .=" ORDER BY p.id ASC";
      return find_by_sql($sql);
    }
    /**
     * Mostrar productos por nombre
     */
   function join_product_table_name($name){
      global $db;
      $sql  =" SELECT p.id,p.name,p.quantity,p.media_id,p.date,p.description,c.name";
     $sql  .=" AS categorie,m.file_name AS image";
     $sql  .=" FROM products p";
     $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
     $sql  .=" LEFT JOIN media m ON m.id = p.media_id WHERE p.quantity>0 and p.name='$name'";
     $sql  .=" ORDER BY p.id ASC";
     return find_by_sql($sql);

    }
    /**
     * Mostar productos por categoria
     */
    function join_product_table_categorie($id){
       global $db;
       $sql  =" SELECT p.id,p.name,p.quantity,p.media_id,p.date,p.description,c.name";
      $sql  .=" AS categorie,m.file_name AS image";
      $sql  .=" FROM products p";
      $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
      $sql  .=" LEFT JOIN media m ON m.id = p.media_id WHERE p.quantity>0 and  p.categorie_id='$id'";
      $sql  .=" ORDER BY p.id ASC";

      return find_by_sql($sql);

     }




?>
