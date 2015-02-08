<?php 

include 'bibli_generale.php';

session_start();

ob_start();

html_debut("Notification", "");

$payload['aps'] = array('alert' => 'This is the alert text', 'badge' => 1, 'sound' => 'default');
$payload = json_encode($payload);

echo $payload;

html_fin();

ob_end_flush();


?>