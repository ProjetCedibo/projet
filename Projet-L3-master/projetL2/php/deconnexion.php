<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

//redirection vers l'index
echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL= ../index.php">';
?>