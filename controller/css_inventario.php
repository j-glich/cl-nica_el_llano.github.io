<?php
require_once("../config/serverside.php");
$table_data->get('vista_inv_medicamento','EI_ID',array('EI_ID','EI_CANTIDAD','EI_NOMBRE_LOTE','PR_NOMBRE','EI_FECHA_CADUCIDAD'));
?>