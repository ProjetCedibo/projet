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