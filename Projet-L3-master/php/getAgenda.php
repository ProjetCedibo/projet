<?php 

include './bibli_bd.php';


ob_start();

isset($_REQUEST['Week']) ? week() : null; 

ob_end_flush();

function week(){
	header('Content-Type: application/json');
	$week = $_POST['Week'];

    bd_Connecter();

    $sql= "SELECT * FROM Agenda WHERE AgendaWeek = \"$week\"";
	$r = mysql_query($sql);
	$res = mysql_fetch_array($r);
	$res = json_encode($res);
	
	echo $res;



    //echo $res;
	//$payload['aps'] = array('alert' => 'This is the alert text', 'badge' => 1, 'sound' => 'default');
//$payload = json_encode($payload);

//echo $payload;
    mysql_close();

}


?>