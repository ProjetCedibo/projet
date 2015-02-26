
<?php 

include './bibli_bd.php';

ob_start();

isset($_REQUEST['DeviceID']) ? registerToken() : null; 

ob_end_flush();

function registerToken(){
	
	$Token = $_POST['Token'];
	$DeviceID = $_POST['DeviceID'];

	echo $Token," ---- ",$DeviceID;

    bd_Connecter();

    $sql= "INSERT INTO NotifSubscribers (NotifSubscribersToken, UserId) VALUES ('$Token',(SELECT UserId FROM User WHERE UserDevice='$DeviceID'))";
	$r = mysql_query($sql);
    
    mysql_close();

}

?>