<?php
	//header('Content-Type: application/json');
	include_once 'spdo.class.php';
	$dbh = SPDO::getInstance();

	$stmt = $dbh->prepare("SELECT COUNT(AgendaId) AS DailyNews, AgendaDate FROM Agenda GROUP BY AgendaWeek, AgendaDate;");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	echo json_encode($rows);