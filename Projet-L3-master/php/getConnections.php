<?php
	//header('Content-Type: application/json');
	include_once 'spdo.class.php';
	$dbh = SPDO::getInstance();

	$stmt = $dbh->prepare("SELECT COUNT( ConnectionID ) AS DailyConnection, ConnectionDate FROM Connection GROUP BY ConnectionDate LIMIT 0 , 30;");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	echo json_encode($rows);

