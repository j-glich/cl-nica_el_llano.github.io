<?php
include_once 'includes/load.php';
include_once 'includes/session.php';
session_destroy();
 if(!$session->logout()) {redirect("dist/page-login.php",false);}
 ?>
