<?php 

include './bibli_bd.php';


ob_start();

isset($_REQUEST['DeviveID']) ? updatelogin() : null; 

ob_end_flush();

function updatelogin(){
	
	$DeviceID = $_POST['DeviveID'];
	$LogIn = $_POST['LogIn'];

    bd_Connecter();

    $sql= "UPDATE User SET UserLogin ='$LogIn' WHERE UserDevice = '$DeviceID'";
	$r = mysql_query($sql);
    
    mysql_close();

}


?>