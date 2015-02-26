<?php

//session_start();
include 'php/bibli_bd.php';
include 'php/bibli_generale.php';
include 'emoji/emoji.php';
$page = 'Notifications';
$err = !empty ($_POST['Notifications']) ? getNotif() : NULL; 

//ob_start();

afficheHeader($page);
afficheBarreHaute();
afficheBarreGauche($page);
afficheMiniBarre($page);



//ob_end_flush();

    echo
                    '<div class="row">',
                            
                        '<div class="formulaireCentre">',

                            '<form method="post" action="notifications.php" role="form">',

                                //Zone de texte pour les notifications
                                '<div class="form-group">',
                                    '<label>Envoyer une nouvelle notification</label>',
                                    '<textarea name="Notifications" class="form-control" rows="3" placeholder="Tapez ici">',
                                    '</textarea>', 
                                '</div>',

                            

                                //Bouton d'envoi
                                '<button type="submit" name = "Envoi" class="btn btn-default">Envoi</button>',
                                
                                //Bouton reset
                                '<button type="reset" class="btn btn-default">Reset</button>',

                            '</form>',

                        '</div>',
                        
                        //Formlaires désactivés
                       '<div class="formulaireCentre">';
                              

                        //Tableau sans différence de couleur
                            //La requête SELECT `NotificationID`, `NotifiactionText`, `AdminID` FROM `Notification`

                            historiqueNotif();
                
                   

            echo            '</div>',
                    
                    '</div>';
                    //<!-- /.row --> 
                    
                   
                    echo 'On affiche : '.$_POST['Notifications'];
                    echo $err;
                    
                    //Test si on a quelque chose dans le formulaire
                    if (isset($_POST['Envoi']) && empty($_POST['Notifications'])) {
                        echo 'Vous n\'avez pas entré de notifications !'; 
                    }


/*$lightning = html_entity_decode('&#57661;',ENT_NOQUOTES,'UTF-8');
//add this to the 'alert' portion of your APNS payload:
$message = "You just got the {$lightning}SHOCKER{$lightning}!"; */

//mysql_result($res, 0);

footer();





function historiqueNotif() {
bd_Connecter();
$sql = "SELECT `NotificationID`, `NotifiactionText`, `AdminID` FROM `Notification` ORDER BY `Notification`.`NotificationID` DESC ";
$res =mysql_query($sql);
//$histo = mysql_fetch_assoc($res);


echo                    '<h2>Historique des dernières notifications</h2>',
                        '<div class="table-responsive">',
                            '<table class="table table-bordered table-hover table-striped">',
                                '<thead>',
                                    '<tr>',
                                        '<th>Numéro de la notification</th>',
                                        '<th>Contenu</th>',
                                        '<th>Admin </th>',
                                    '</tr>',
                                '</thead>',
                                '<tbody>'; 

/*if ($histo<=0) {
echo '<br>Pas de résultat';
}
else { */
   $compteur = 0;
    while ($histo=mysql_fetch_array($res)) {
       $compteur+=1;
       $NotificationID = $histo['NotificationID'];
       $NotifiactionText = $histo['NotifiactionText'];
       $AdminID = $histo['AdminID'];
       //echo '<br>Le numéro des notifs :'.$NotificationID.', le message : '.$NotifiactionText.', l\'admin : '.$AdminID;
        echo
                                    '<tr>',
                                        '<td>'.$NotificationID.'</td>',
                                        '<td>'.$NotifiactionText.'</td>',
                                        '<td>'.$AdminID.'</td>',
                                    '</tr>';




       if ($compteur == 10) {
            exit; 
       }
    }
//}

echo                                '</tbody>',
                            '</table>',
                        '</div>',
                    '</div>';




}













//$message = $_POST['Notifications'];

function getNotif() {
    bd_Connecter();
    $message = $_POST['Notifications'];
    $admin = isset($_SESSION['id']) ? $_SESSION['id'] : 1;
    $sql = "INSERT INTO `Notification`(`NotifiactionText`, `NotificationBadge`, `AdminID`) VALUES ('".$message."',0,'".$admin."')";
    $res =mysql_query($sql);
    header('Location: notifications.php');
    mysql_close();
    return sendNotif($message);
}


function sendNotif($message) {
$err2='';
bd_Connecter(); 
$sql = "SELECT `NotifSubscribersToken` FROM `NotifSubscribers`"; 
$res =mysql_query($sql); 
$r=mysql_fetch_row($res);

// Put your device token here (without spaces):
//$deviceToken = 'e943c9e9c0c8a1ab0ca82b62c5dd626920f33f6ec664a02d8ac81b7d852b0dda';

// Put your private key's passphrase here:
$passphrase = 'cedibo';

// Put your alert message here:
//$message = $_POST['Notifications'];

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
    'ssl://gateway.sandbox.push.apple.com:2195', $err,
    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
    exit("Failed to connect: $err $errstr" . PHP_EOL);

//echo 'Connected to APNS' . PHP_EOL;

/*
$lightning = html_entity_decode('&#57661;',ENT_NOQUOTES,'UTF-8');
//add this to the 'alert' portion of your APNS payload:*/
//$test= "You just got the {$lightning}SHOCKER{$lightning}!"; */

// Create the payload body
$body['aps'] = array('badge' => 1, 'alert' => $message,  'sound' => 'default');

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
foreach($r as $deviceToken) {

    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    
    // Send it to the server

    $result = fwrite($fp, $msg, strlen($msg));
}


if (!$result)
    $err2 = $err2 . 'La notification n\'a pas été reçue' . PHP_EOL;
else
    $err2 = $err2 .  '<br> La notification a bien été envoyée !' . PHP_EOL;

// Close the connection to the server
fclose($fp);
return $err2;
}

//sendNotif();

?>