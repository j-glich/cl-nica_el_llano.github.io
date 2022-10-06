<?php
  require_once("global.php");
//mysqli_report(MYSQLI_REPORT_ALL);
global $conexion;
global $mysqli;

try {
  $conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
  $mysqli = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
} catch (Throwable $t) {
  exit($t->getMessage());
}
  //mysqli_query($conexion,'SET NAMES "'.DB_ENCODE.'"');

  if(mysqli_connect_errno()){
    printf("Fallol a conexión con la base de datos: %s\n",mysqli_connect_error());
    exit();
  }else{
    //echo 'conectado satisfactoriamente';
  }


#------------------------------------------
function execProcedurePeek($stmt,$level){
#------------------------------------------
  global $mysqli;
  try{
      if($level==1){
       $resultPeek=$mysqli->query($stmt, MYSQLI_STORE_RESULT);
       return $resultPeek;
      }elseif($level==2){
      clearStoredResults($mysqli);
      
       //echo $stmt;
       $resultData=$mysqli->query($stmt, MYSQLI_USE_RESULT);
       return $resultData;
      }else {
        $mysqli->close();
      }
    }catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  function execQueryIn($sql){
    global $conexion;
    try {    
      $result=$conexion->query($sql);  
      
      if($result == '1'){
        echo '1';
      }else{
        echo '0';
      }
      
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    finally {
      clearStoredResults($conexion);
    }
  }
  function execQuery2($sql){
    global $conexion;
    try {    
      $result=$conexion->query($sql);   
      if($result == '1'){
        echo '1';
      }else{
      if($result!=false){
        while($row = $result->fetch_assoc()){
        $new_array[] = $row; // Inside while loop
      }
        return $new_array; 
      }else{
        echo'0';
      }
      }

    } catch (Exception $e) {
      echo $e->getMessage();
    }
    finally {
      clearStoredResults($conexion);
    }
  }
  function execQuery($sql){
    global $conexion;
    try {    
      $result=$conexion->query($sql);   
      if($result == '1'){
        echo '1';
      }else{
      if($result!=false){
        while($row = $result->fetch_assoc()){
        $new_array[] = $row; // Inside while loop
      }
      if(empty($new_array)){
        return '0'; 
      }else{
        return $new_array; 
      }
      }else{
        echo'0';
      }
      }

    } catch (Exception $e) {
      echo $e->getMessage();
    }
    finally {
      clearStoredResults($conexion);
    }
  }
#------------------------------------------
function clearStoredResults($mysqli_link){
#------------------------------------------
      while($mysqli_link->next_result()){
        if($l_result = $mysqli_link->store_result()){
                $l_result->free();
        }
      }
  }
  
  function execQueryID($sql){
    global $conexion;
     $conexion->query($sql);
    //echo $conexion->insert_id;
    return $conexion->insert_id;
  }

  function multiQuery($sql){
    global $conexion;
    $conexion->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);

    try {
      $conexion->query($sql);
      $conexion->commit();

    } catch (Exception $e) {
        $conexion->rollback();
        echo 'Something fails: '.$e->getMessage();
    }

$conexion->close();
  }

  if (!function_exists('ejecutarConsulta'))
  {
  	function ejecutarConsulta($sql)
  	{
  		global $conexion;
  		$query = $conexion->query($sql);
  		return $query;
  	}


  	/*function ejecutarConsultaSimpleFila($sql)
  	{
  		global $conexion;
  		$query = $conexion->query($sql);
  		$row = $query->fetch_assoc();
  		return $row;
  	}*/

    function ejecutarConsultaSimpleFila($sql)
    {
      global $conexion;
      //echo $sql;
      /*$result=mysqli_query($conexion,$sql) or die('Error al ejecutar la instruccion SQL');
      $row = mysqli_fetch_array($result);*/
      $query = $conexion->query($sql);
    //  $row = $query->fetch_assoc();
      $row = mysqli_fetch_array($query);
      //var_dump($row);
      return $row;
    }

  	function ejecutarConsulta_retornarID($sql)
  	{
  		global $conexion;
  		$query = $conexion->query($sql);
  		return $conexion->insert_id;
  	}
    function consultar($sql){

    }

  	function limpiarCadena($str)
  	{
  		global $conexion;
  		$str = mysqli_real_escape_string($conexion,trim($str));
  		return htmlspecialchars($str);
  	}
  }
 
?>