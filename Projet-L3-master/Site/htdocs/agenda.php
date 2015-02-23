<?php

//session_start();
include 'php/bibli_bd.php';
include 'php/bibli_generale.php';
$page = 'Agenda';
//!empty ($_POST['typeAgenda']) //? getNotif() : NULL ; 

//ob_start();

afficheHeaderAgenda($page);
afficheBarreHaute();
afficheBarreGauche($page);
afficheMiniBarre($page);



//ob_end_flush();
            
    //echo
                  //  'Nous sommes le '.date('d-m-Y-e à H:i:s').'',
                    
                      /*  $date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
                       echo $date->format('Y-m-d H:i:sP') . "\n";*/

                        /*$date=setTimezone(new DateTimeZone('Pacific/Chatham'));
                        echo $date->format('Y-m-d H:i:sP') . "\n";*/

                        date_default_timezone_set("Europe/Paris");
                  echo      'Nous sommes le '.date('d-m-Y à H:i:s').' et le numéro de la semaine est '.date('W').'  .'; 






echo
                    '<div class="row">',
                            
                        '<div class="col-lg-6">',

                            '<form method="post" action="agenda.php" role="form">',

                                //Petite Zone de texte
                                /*'<div class="form-group">',
                                    '<label>Text Input</label>',
                                    '<input class="form-control">',
                                    '<p class="help-block">Example block-level help text here.</p>',
                                '</div>', */

                                //Zone de texte avec text préécrit
                                /*'<div class="form-group">',
                                    '<label>Text Input with Placeholder</label>',
                                    '<input class="form-control" placeholder="Enter text">',
                                '</div>',*/

                                //Mail 
                                /*'<div class="form-group">',
                                    '<label>Static Control</label>',
                                    '<p class="form-control-static">email@example.com</p>',
                                '</div>',*/

                                //Uploader de fichier
                                /*'<div class="form-group">',
                                    '<label>File input</label>',
                                    '<input type="file">',
                                '</div>', */

                                //Zone de texte pour l'agenda
                                '<div class="form-group">',
                                    '<label>Faire une nouvelle entrée dans l\'agenda </label>',
                                    '<textarea name="AgendaText" class="form-control" rows="3"></textarea>', 
                                '</div>',

                                //Case à cocher sur plusieurs lignes
                                /*'<div class="form-group">',
                                    '<label>Checkboxes</label>',
                                    '<div class="checkbox">',
                                        '<label>',
                                            '<input type="checkbox" value="">Checkbox 1',
                                        '</label>',
                                    '</div>',
                                    '<div class="checkbox">',
                                        '<label>',
                                            '<input type="checkbox" value="">Checkbox 2',
                                        '</label>',
                                    '</div>',
                                    '<div class="checkbox">',
                                        '<label>',
                                            '<input type="checkbox" value="">Checkbox 3',
                                        '</label>',
                                    '</div>',
                                '</div>',*/

                                //Cases à cocher sur une seule ligne
                                /*'<div class="form-group">',
                                    '<label>Inline Checkboxes</label>',
                                    '<label class="checkbox-inline">',
                                        '<input type="checkbox">1',
                                    '</label>',
                                    '<label class="checkbox-inline">',
                                       ' <input type="checkbox">2',
                                    '</label>',
                                    '<label class="checkbox-inline">',
                                        '<input type="checkbox">3',
                                    '</label>',
                                '</div>',*/

                                //Boutons radio sur plusieurs lignes
                               '<div class="form-group">',
                                    '<label> Type d\'informations </label>',
                                    '<div class="radio">',
                                        '<label>',
                                            '<input type="radio" name="typeAgenda" id="GENERAL" value="GENERAL" checked>GENERAL',
                                        '</label>',
                                    '</div>',
                                    '<div class="radio">',
                                        '<label>',
                                            '<input type="radio" name="typeAgenda" id="BU" value="BU">BU',
                                        '</label>',
                                    '</div>',
                                    '<div class="radio">',
                                        '<label>',
                                            '<input type="radio" name="typeAgenda" id="SJEPG" value="SJEPG">SJEPG',
                                        '</label>',
                                    '</div>',
                                '</div>',

                                

                                 //Cases à cocher sur une seule ligne
                                 /*'<div class="form-group">',
                                    '<label>Inline Radio Buttons</label>',
                                    '<label class="radio-inline">',
                                        '<input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>1',
                                    '</label>',
                                    '<label class="radio-inline">',
                                        '<input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">2',
                                    '</label>',
                                    '<label class="radio-inline">',
                                        '<input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">3',
                                    '</label>',
                                '</div>',*/

                                //Liste déroulante
                                /*'<div class="form-group">',
                                    '<label>Selects</label>',
                                    '<select class="form-control">',
                                        '<option>1</option>',
                                        '<option>2</option>',
                                        '<option>3</option>',
                                        '<option>4</option>',
                                        '<option>5</option>',
                                    '</select>',
                                '</div>',*/

                                //Sélections multiples
                                /*'<div class="form-group">',
                                    '<label>Multiple Selects</label>',
                                     '<select multiple class="form-control">',
                                        '<option>1</option>',
                                        '<option>2</option>',
                                        '<option>3</option>',
                                        '<option>4</option>',
                                        '<option>5</option>',
                                    '</select>',
                                '</div>',*/

                                //Bouton d'envoi
                                '<button type="submit" class="btn btn-default">Envoi</button>',
                                
                                //Bouton reset
                                '<button type="reset" class="btn btn-default">Reset</button>',

                            '</form>',

                        '</div>',
                        
                        //Formlaires désactivés
                       '<div class="col-lg-6">',
                                /*'<h1>Formulaires désactivés</h1>',

                                '<form role="form">',

                                    '<fieldset disabled>',

                                        '<div class="form-group">',
                                            '<label for="disabledSelect">Champ texte désactivé</label>',
                                            '<input class="form-control" id="disabledInput" type="text" placeholder="Champ texte désactivé" disabled>',
                                        '</div>',

                                        '<div class="form-group">',
                                            '<label for="disabledSelect">Menu de sélection désactivé</label>',
                                            '<select id="disabledSelect" class="form-control">',
                                                '<option>Sélection désactivée</option>',
                                            '</select>',
                                        '</div>',

                                        '<div class="checkbox">',
                                            '<label>',
                                                '<input type="checkbox">Checkbox désactivée',
                                            '</label>',
                                        '</div>',

                                        '<button type="submit" class="btn btn-primary">Bouton désactivé</button>',

                                    '</fieldset>',

                                '</form>', */

                                //3 couleurs de formulaire
                               /*'<h1>Formulaire avc 3 couleurs</h1>',

                                '<form role="form">',

                                    '<div class="form-group has-success">',
                                        '<label class="control-label" for="inputSuccess">Entrée valide</label>',
                                        '<input type="text" class="form-control" id="inputSuccess">',
                                    '</div>',

                                    '<div class="form-group has-warning">',
                                        '<label class="control-label" for="inputWarning">Entrée avec warning</label>',
                                        '<input type="text" class="form-control" id="inputWarning">',
                                    '</div>',

                                    '<div class="form-group has-error">',
                                        '<label class="control-label" for="inputError">Entrée avec erreur</label>',
                                        '<input type="text" class="form-control" id="inputError">',
                                    '</div>',

                                '</form>', */

                             /* '<h1>Input Groups</h1>',

                                '<form role="form">', 

                                    //Nom d'utilisateur
                                    '<div class="form-group input-group">',
                                        '<span class="input-group-addon">@</span>',
                                        '<input type="text" class="form-control" placeholder="Nom d\'utilisateur">',
                                    '</div>',

                                    //OSEF
                                    '<div class="form-group input-group">',
                                        '<input type="text" class="form-control">',
                                       ' <span class="input-group-addon">.00</span>',
                                    '</div>',

                                    //OSEF
                                    '<div class="form-group input-group">',
                                        '<span class="input-group-addon"><i class="fa fa-eur"></i></span>',
                                        '<input type="text" class="form-control" placeholder="Font Awesome Icon">',
                                    '</div>', 

                                    //OSEF
                                    '<div class="form-group input-group">',
                                        '<span class="input-group-addon">$</span>',
                                        '<input type="text" class="form-control">',
                                       ' <span class="input-group-addon">.00</span>',
                                    '</div>',

                                    //Barre de recherche
                                    '<div class="form-group input-group">',
                                        '<input type="text" class="form-control">',
                                        '<span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>',
                                    '</div>',

                           '</form>', */

                            //Lien d'informations sur les formulaires
                            //'<p>For complete documentation, please visit <a href="http://getbootstrap.com/css/#forms">Bootstraps Form Documentation</a>.</p>',

                        '</div>',
                    
                    '</div>';
                    //<!-- /.row --> 
                    
                   
                    echo 'On affiche : '.$_POST['AgendaText'],
                         '<br>On affiche aussi : ' .$_POST['typeAgenda'];
                  
footer();

/*function getNotif() {
    bd_Connecter();
    $message = $_POST['Agenda'];
    $admin = isset($_SESSION['id']) ? $_SESSION['id'] : 1;
    $sql = "INSERT INTO `Agenda`(`AgendaId`, `AgendaDate`, `AgendaWeek`, `AgendaTitle`, `AgendaMessage`, `AgendaType`, `AgendaAuthor`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])";
    $res =mysql_query($sql);
    mysql_close();
    //send_notif($message);
}*/


/*function sendNotif() {

// Put your device token here (without spaces):
$deviceToken = 'e943c9e9c0c8a1ab0ca82b62c5dd626920f33f6ec664a02d8ac81b7d852b0dda';

// Put your private key's passphrase here:
$passphrase = 'cedibo';

// Put your alert message here:
$message = $_POST['Agenda'];

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

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array('badge' => 1, 'alert' => $message,  'sound' => 'default');

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
    echo 'Message not delivered' . PHP_EOL;
else
    echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);

}

sendNotif();*/

?>