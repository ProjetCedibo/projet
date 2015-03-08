<?php
	//header('Content-Type: application/json');
	include_once 'spdo.class.php';
	$dbh = SPDO::getInstance();

	$stmt = $dbh->prepare("SELECT COUNT( NotificationID ) AS value, NotificationType AS label FROM Notification GROUP BY NotificationType;");
	//$stmt = $dbh->prepare("SELECT COUNT( ConnectionID ) AS DailyConnection, DATE_FORMAT(ConnectionDate, '%d/%m/%Y') AS datefr FROM Connection GROUP BY ConnectionDate;");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	echo json_encode($rows);

