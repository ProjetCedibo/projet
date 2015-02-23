<?php 

	include './bibli_bd.php';


	ob_start();

	isset($_POST['DeviceID']) ? addUser() : null; 

	ob_end_flush();

	function addUser(){
		
		$DeviceID = $_POST['DeviceID'];
		$DeviceModel = $_POST['DeviceModel'];
		$DeviceOS = $_POST['DeviceOS'];
	    bd_Connecter();

	    $sql= "SELECT UserId FROM User WHERE UserDevice='$DeviceID'";
		$r = mysql_query($sql);
		$res = mysql_fetch_row($r);
		if ($res <= 0){
			$sql=mysql_query("INSERT INTO User (UserDevice, UserModel, UserOs, UserLogin) VALUES ('$DeviceID','$DeviceModel', '$DeviceOS',0)");
			$UserId = mysql_insert_id();
		}else{
			$UserId = $res[0];
		}
		$date = date("Y-m-d");
		$heure = date("H:i:s");
		$sql = "INSERT INTO Connection (ConnectionDate, ConnectionHour, ConnectionUser) VALUES ('$date','$heure','$UserId')";
		$r = mysql_query($sql);
	    
	    mysql_close();

	}


?>