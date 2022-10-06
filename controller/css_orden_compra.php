<?php
require_once("../config/serverside.php");
$table_data->get('vista_orden','OC_ID',array('OC_ID', 'OC_FECHA_COMPRA','OC_FECHA_ENTREGA','FP_NOMBRE','PD_NOMBRE_COMPLETO'));
?>