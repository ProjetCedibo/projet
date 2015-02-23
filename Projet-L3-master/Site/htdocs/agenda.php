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
?>

<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
<tr><td id="ds_calclass">
</td></tr>
</table>

<script type="text/javascript">
// <!-- <![CDATA[

// Project: Dynamic Date Selector (DtTvB) - 2006-03-16
// Script featured on JavaScript Kit- http://www.javascriptkit.com
// Code begin...
// Set the initial date.
var ds_i_date = new Date();
ds_c_month = ds_i_date.getMonth() + 1;
ds_c_year = ds_i_date.getFullYear();

// Get Element By Id
function ds_getel(id) {
    return document.getElementById(id);
}

// Get the left and the top of the element.
function ds_getleft(el) {
    var tmp = el.offsetLeft;
    el = el.offsetParent
    while(el) {
        tmp += el.offsetLeft;
        el = el.offsetParent;
    }
    return tmp;
}
function ds_gettop(el) {
    var tmp = el.offsetTop;
    el = el.offsetParent
    while(el) {
        tmp += el.offsetTop;
        el = el.offsetParent;
    }
    return tmp;
}

// Output Element
var ds_oe = ds_getel('ds_calclass');
// Container
var ds_ce = ds_getel('ds_conclass');

// Output Buffering
var ds_ob = ''; 
function ds_ob_clean() {
    ds_ob = '';
}
function ds_ob_flush() {
    ds_oe.innerHTML = ds_ob;
    ds_ob_clean();
}
function ds_echo(t) {
    ds_ob += t;
}

var ds_element; // Text Element...

var ds_monthnames = [
'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
]; // You can translate it for your language.

var ds_daynames = [
'Dim', 'Lun', 'Mar', 'Me', 'Jeu', 'Ven', 'Sam'
]; // You can translate it for your language.

// Calendar template
function ds_template_main_above(t) {
    return '<table cellpadding="3" cellspacing="1" class="ds_tbl">'
         + '<tr>'
         + '<td class="ds_head" style="cursor: pointer" onclick="ds_py();">&lt;&lt;</td>'
         + '<td class="ds_head" style="cursor: pointer" onclick="ds_pm();">&lt;</td>'
         + '<td class="ds_head" style="cursor: pointer" onclick="ds_hi();" colspan="3">[Fermer]</td>'
         + '<td class="ds_head" style="cursor: pointer" onclick="ds_nm();">&gt;</td>'
         + '<td class="ds_head" style="cursor: pointer" onclick="ds_ny();">&gt;&gt;</td>'
         + '</tr>'
         + '<tr>'
         + '<td colspan="7" class="ds_head">' + t + '</td>'
         + '</tr>'
         + '<tr>';
}

function ds_template_day_row(t) {
    return '<td class="ds_subhead">' + t + '</td>';
    // Define width in CSS, XHTML 1.0 Strict doesn't have width property for it.
}

function ds_template_new_week() {
    return '</tr><tr>';
}

function ds_template_blank_cell(colspan) {
    return '<td colspan="' + colspan + '"></td>'
}

function ds_template_day(d, m, y) {
    return '<td class="ds_cell" onclick="ds_onclick(' + d + ',' + m + ',' + y + ')">' + d + '</td>';
    // Define width the day row.
}

function ds_template_main_below() {
    return '</tr>'
         + '</table>';
}

// This one draws calendar...
function ds_draw_calendar(m, y) {
    // First clean the output buffer.
    ds_ob_clean();
    // Here we go, do the header
    ds_echo (ds_template_main_above(ds_monthnames[m - 1] + ' ' + y));
    for (i = 0; i < 7; i ++) {
        ds_echo (ds_template_day_row(ds_daynames[i]));
    }
    // Make a date object.
    var ds_dc_date = new Date();
    ds_dc_date.setMonth(m - 1);
    ds_dc_date.setFullYear(y);
    ds_dc_date.setDate(1);
    if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12) {
        days = 31;
    } else if (m == 4 || m == 6 || m == 9 || m == 11) {
        days = 30;
    } else {
        days = (y % 4 == 0) ? 29 : 28;
    }
    var first_day = ds_dc_date.getDay();
    var first_loop = 1;
    // Start the first week
    ds_echo (ds_template_new_week());
    // If sunday is not the first day of the month, make a blank cell...
    if (first_day != 0) {
        ds_echo (ds_template_blank_cell(first_day));
    }
    var j = first_day;
    for (i = 0; i < days; i ++) {
        // Today is sunday, make a new week.
        // If this sunday is the first day of the month,
        // we've made a new row for you already.
        if (j == 0 && !first_loop) {
            // New week!!
            ds_echo (ds_template_new_week());
        }
        // Make a row of that day!
        ds_echo (ds_template_day(i + 1, m, y));
        // This is not first loop anymore...
        first_loop = 0;
        // What is the next day?
        j ++;
        j %= 7;
    }
    // Do the footer
    ds_echo (ds_template_main_below());
    // And let's display..
    ds_ob_flush();
    // Scroll it into view.
    ds_ce.scrollIntoView();
}

// A function to show the calendar.
// When user click on the date, it will set the content of t.
function ds_sh(t) {
    // Set the element to set...
    ds_element = t;
    // Make a new date, and set the current month and year.
    var ds_sh_date = new Date();
    ds_c_month = ds_sh_date.getMonth() + 1;
    ds_c_year = ds_sh_date.getFullYear();
    // Draw the calendar
    ds_draw_calendar(ds_c_month, ds_c_year);
    // To change the position properly, we must show it first.
    ds_ce.style.display = '';
    // Move the calendar container!
    the_left = ds_getleft(t);
    the_top = ds_gettop(t) + t.offsetHeight;
    ds_ce.style.left = the_left + 'px';
    ds_ce.style.top = the_top + 'px';
    // Scroll it into view.
    ds_ce.scrollIntoView();
}

// Hide the calendar.
function ds_hi() {
    ds_ce.style.display = 'none';
}

// Moves to the next month...
function ds_nm() {
    // Increase the current month.
    ds_c_month ++;
    // We have passed December, let's go to the next year.
    // Increase the current year, and set the current month to January.
    if (ds_c_month > 12) {
        ds_c_month = 1; 
        ds_c_year++;
    }
    // Redraw the calendar.
    ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous month...
function ds_pm() {
    ds_c_month = ds_c_month - 1; // Can't use dash-dash here, it will make the page invalid.
    // We have passed January, let's go back to the previous year.
    // Decrease the current year, and set the current month to December.
    if (ds_c_month < 1) {
        ds_c_month = 12; 
        ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
    }
    // Redraw the calendar.
    ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the next year...
function ds_ny() {
    // Increase the current year.
    ds_c_year++;
    // Redraw the calendar.
    ds_draw_calendar(ds_c_month, ds_c_year);
}

// Moves to the previous year...
function ds_py() {
    // Decrease the current year.
    ds_c_year = ds_c_year - 1; // Can't use dash-dash here, it will make the page invalid.
    // Redraw the calendar.
    ds_draw_calendar(ds_c_month, ds_c_year);
}

// Format the date to output.
function ds_format_date(d, m, y) {
    // 2 digits month.
    m2 = '00' + m;
    m2 = m2.substr(m2.length - 2);
    // 2 digits day.
    d2 = '00' + d;
    d2 = d2.substr(d2.length - 2);
    // YYYY-MM-DD
//  return y + '-' + m2 + '-' + d2;
    return d2 + '-' + m2 + '-' + y;
}

// When the user clicks the day.
function ds_onclick(d, m, y) {
    // Hide the calendar.
    ds_hi();
    // Set the value of it, if we can.
    if (typeof(ds_element.value) != 'undefined') {
        ds_element.value = ds_format_date(d, m, y);
    // Maybe we want to set the HTML in it.
    } else if (typeof(ds_element.innerHTML) != 'undefined') {
        ds_element.innerHTML = ds_format_date(d, m, y);
    // I don't know how should we display it, just alert it to user.
    } else {
        alert (ds_format_date(d, m, y));
    }
}

// And here is the end.

// ]]> -->
</script>

<?php


//ob_end_flush();
            
    //echo
                  //  'Nous sommes le '.date('d-m-Y-e à H:i:s').'',
                    
                      /*  $date = new DateTime('2000-01-01', new DateTimeZone('Pacific/Nauru'));
                       echo $date->format('Y-m-d H:i:sP') . "\n";*/

                        /*$date=setTimezone(new DateTimeZone('Pacific/Chatham'));
                        echo $date->format('Y-m-d H:i:sP') . "\n";*/

    date_default_timezone_set("Europe/Paris");
    
    echo      'Nous sommes le '.date('d-m-Y à H:i:s').' et le numéro de la semaine est '.date('W').'  .',
               /* '<form action="" method="post">',
                '<div>',
                '<b>Sélectionner la date qui correspond à la semaine </b><br/>',
                'Veuillez entrez une date : <input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /><br />',
                '<input type="submit" value="Submit" />',
                '</div>',
                '</form>'; */
//<p><font face="verdana" size="1">Powered and Generated by </font><a href="http://www.espacejavascript.com" target="_blank"><font face="verdana,arial,helvetica" size="1" color="black">http://www.<b>espacejavascript</b>.com</font></a></p>





                    '<div class="row">',
                            
                        '<div class="col-lg-6">',

                            '<form method="post" action="agenda.php" role="form">',

                                '<div class="form-group">',
                                    '<br> <b>Sélectionner la date de l\'évènement : </b><br/>',
                                    'Veuillez entrez une date : <input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /><br />',
                                '</div>',
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
                         '<br>On affiche aussi : ' .$_POST['typeAgenda'],
                         '<br>On affiche enfin : ' .$_POST['date']; 
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