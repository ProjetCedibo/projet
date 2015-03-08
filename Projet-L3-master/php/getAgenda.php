<<<<<<< HEAD
<?php
	//header('Content-Type: application/json');
	include_once 'spdo.class.php';
	$dbh = SPDO::getInstance();

	$week = htmlspecialchars($_POST['Week']);

	$stmt = $dbh->prepare("SELECT * FROM Agenda WHERE AgendaWeek = :week;");
	$stmt->bindParam(":week", $week, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	echo json_encode($rows);
=======
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
<<<<<<< Updated upstream

	$rows = array();
	while($row = mysql_fetch_assoc($r)):
		array_push($rows, $row);
	endwhile;

	$res = json_encode($rows);
=======
	$res = mysql_fetch_assoc($r);
	$res = json_encode($res);
>>>>>>> Stashed changes
	
	echo $res;



    //echo $res;
	//$payload['aps'] = array('alert' => 'This is the alert text', 'badge' => 1, 'sound' => 'default');
//$payload = json_encode($payload);

//echo $payload;
    mysql_close();

}
>>>>>>> origin/master
