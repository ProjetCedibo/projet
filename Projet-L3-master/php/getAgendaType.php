<?php
	//header('Content-Type: application/json');
	include_once 'spdo.class.php';
	$dbh = SPDO::getInstance();

	$stmt = $dbh->prepare("SELECT COUNT( AgendaID ) AS DailyAgenda, AgendaType AS label FROM Agenda GROUP BY AgendaType;");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	echo json_encode($rows);