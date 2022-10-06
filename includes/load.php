
<?php
// -----------------------------------------------------------------------

// Definicion del separador y directorio ds local
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');
define("DS", DIRECTORY_SEPARATOR);
//
// // -----------------------------------------------------------------------
// // Definicion de los directorios locales y globales del proyecto
// // -----------------------------------------------------------------------
defined('SITE_ROOT')? null: define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);

// echo SITE_ROOT;
// echo LIB_PATH_INC;
//
// require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'functions.php');
require_once(LIB_PATH_INC.'session.php');






// require_once(LIB_PATH_INC.'upload.php');
// require_once(LIB_PATH_INC.'database.php');
// require_once(LIB_PATH_INC.'sql.php');

?>
