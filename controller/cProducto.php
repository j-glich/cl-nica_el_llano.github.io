<?php
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '0';
if($opcion == 1){
  $nombre = strtoupper($_POST['in-nombre']);
  $categoria = $_POST['in-cat'];
  $sustancia = $_POST['sustancia'];
  $contenido =  $_POST['contenido'];
  $descripcion =  $_POST['descripcion'];
  $descuento = $_POST['descuento'];
  $precio =  $_POST['precio'];
  $descripcion2= $_POST['descripcion2'];
  $precio2 = $_POST['precio2'];
}
if($opcion == 2){
  $id = $_POST['id'];
  $nombre = $_POST['in-nombre'];
  $contenido= $_POST['contenido'];
  $sustancia = $_POST['sustancia'];
  $precio = $_POST['precio'];
  $descuento = $_POST['descuento'];
  $descuento = $descuento  / 100;
}
if($opcion == 3){
  $id = $_POST['id']; 
}
if($opcion == 4){
  $id = $_POST['id2'];
  $nombre = $_POST['in-nombre2'];
  $descripcion= $_POST['descripcion2'];
  $precio = $_POST['precio2'];
}
if($opcion == 8){
  $categoria = $_POST['categoria'];
}
if($opcion == 10){
  $nombre = $_POST['id'];
}

 require_once("../models/mProducto.php");
 /* Bloque de control para poder realizar la actualización de los registros */

/**      ******************** */ 

  function listar_ordenCompra(){
    return li_compra();
  }

  
  function listar_producto(){
    return li_productos();
  }
  function listar_cat_indv($id){
    return li_categoria($id);
  }
  function listar_cat_indv2($id){
    return li_categoria_iv($id);
  }

  function listar_presentacion(){
    return lipresentacion();
  }
  function listar_categoria(){
    return licategoria();
  }
  
  function listar_unidad_venta(){
    return li_unidadV();
  }
  function listar_unidad_compra(){
    return li_unidadC();
  }
  function listar_busqueda($elemento,$comparacion,$orden,$existencia){
    return busqueda($elemento,$comparacion,$orden,$existencia);
  }
  function listar_almacen(){
    return almacen();
  }
?>


