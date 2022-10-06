<?php 
 require_once("../models/mGeneral.php");
 /* Bloque de control para poder realizar la actualización de los registros */

function listar_productos(){
  return listar_producto();
}
function listar_proveedor(){
    return listar_povee();
  }

  function listar_almacen(){
    return listar_alm();
  }

  function listar_ordenC(){
    return listar_orC();
  }
  
  function listar_pagos(){
    return listar_pag();
  }
  
  function listar_inventario(){
    return listar_inv();
  }

  function listar_ventas(){
    return listar_venta();
  }
  

?>