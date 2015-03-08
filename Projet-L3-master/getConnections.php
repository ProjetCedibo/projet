<?php
	header('Content-Type: application/json');

	bd_Connecter();
	$sql = "SELECT `ConnectionId`,`ConnectionDate`  FROM `Connection`"; //
	$res =mysql_query($sql);
	$rows = array();
	while ($row = mysql_fetch_assoc($res)):
	    $rows[] = $row;
	endwhile;
	echo json_encode($rows);
	