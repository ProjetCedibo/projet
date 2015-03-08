<?php

//session_start();
include 'php/bibli_bd.php';
include 'php/bibli_generale.php';
include 'emoji/emoji.php';
$page = 'Administration';
//$err = !empty ($_POST['Notifications']) ; 
if ( (!empty ($_POST['AdminPseudo'])) && (!empty ($_POST['AdminPassWord'])) && (!empty ($_POST['AdminMail'])) ) {
    ajoutAdmin();
}
else {
    NULL;
}



//ob_start();

afficheHeader($page);
afficheBarreHaute();
afficheBarreGauche($page);
afficheMiniBarre($page);

 echo
//Modifications informations d'un admin
                    '<div class="row">',
                            
                        '<div class="formulaireCentre">',

                            '<h2>Modifier les informations d\'administration</h2>',

                            '<form method="post" action="administration.php" role="form">',

                                //Entrer pseudo
                                '<div class="form-group">',
                                    '<label><br>Modifier le nom d\'administrateur : </label>',
                                    '<input name="NewPseudo" class="form-control" placeholder="Tapez ici">',
                                '</div>', 

                                //Entrer l'ancien mot de passe
                                '<div class="form-group">',
                                    '<label><br>Modifier le mot de passe : </label>',
                                    '<input type="password" name="FormerPassWord" class="form-control" placeholder="Tapez ici">',
                                '</div>',

                                //Entrer le nouveau mot de passe
                                 '<div class="form-group">',
                                    '<label><br>Modifier le mot de passe : </label>',
                                    '<input type="password" name="NewPassWord" class="form-control" placeholder="Tapez ici">',
                                '</div>',

                                //Entrer la nouvelle adresse mail
                                '<div class="form-group input-group">',
                                    '<label><br>Modifiez l\'adresse mail : </label>',
                                    //'<p>',
                                    '<div class="formulaireCentre">',
                                    '<span class="input-group-addon">@</span>',
                                    '<input type="mail" name ="NewMail" class="form-control" placeholder="Tapez ici">',
                                    '</div>',
                                '</div>',

                                //Bouton d'envoi
                                '<button type="submit" name = "Envoi" class="btn btn-default">Envoi</button>',
                                
                                //Bouton reset
                                '<button type="reset" class="btn btn-default">Reset</button>',

                            '</form>',

                        '</div>',




                        //Ajout d'un admin
                            
                        '<div class="formulaireCentre">',

                            '<h2>Ajouter un administrateur</h2>',

                            '<form method="post" action="administration.php" role="form">',

                                //Entrer pseudo
                                '<div class="form-group">',
                                    '<label><br>Entrez un nom d\'administrateur : </label>',
                                    '<input name="AdminPseudo" class="form-control" placeholder="Tapez ici">',
                                '</div>', 

                                //Entrer mot de passe
                                 '<div class="form-group">',
                                    '<label><br>Entrez un mot de passe : </label>',
                                    '<input type="password" name="AdminPassWord" class="form-control" placeholder="Tapez ici">',
                                '</div>',

                                //Entrer adresse mail
                                '<div class="form-group input-group">',
                                    '<label><br>Entrez une adresse mail : </label>',
                                    //'<p>',
                                    '<div class="formulaireCentre">',
                                    '<span class="input-group-addon">@</span>',
                                    '<input type="mail" name ="AdminMail" class="form-control" placeholder="Tapez ici">',
                                    '</div>',
                                '</div>',

                                //Bouton d'envoi
                                '<button type="submit" name = "Envoi" class="btn btn-default">Envoi</button>',
                                
                                //Bouton reset
                                '<button type="reset" class="btn btn-default">Reset</button>',

                            '</form>',
                            //'<div>',
                        '</div>',
                '</div>';
                        
                 
                    //<!-- /.row --> 
                    
                   
                    echo 'On affiche : '.$_POST['AdminPseudo'];
                    echo '<br>On affiche : '.$_POST['AdminPassWord'];
                    echo '<br>On affiche : '.$_POST['AdminMail'];

                    echo $err;
                    
                    //Test si on a quelque chose dans le formulaire
                    if (isset($_POST['Envoi']) && empty($_POST['AdminPseudo']) && empty($_POST['AdminPassWord']) && empty($_POST['AdminMail'])) {
                        echo '<br>Vous n\'avez pas entré de données !'; 
                    }

envoiMail();
//ob_end_flush();

footer();

function ajoutAdmin() {
    bd_Connecter();
    $AdminPseudo = $_POST['AdminPseudo']; // '".$AdminPseudo."'
    $AdminPassWord= $_POST['AdminPassWord']; // '".$AdminPassWord."'
    $AdminMail= $_POST['AdminMail']; // '".$AdminMail."'
    //$AdminId = isset($_SESSION['id']) ? $_SESSION['id'] : 1; // '".$AdminId."'
    // concaténation : '".$message."' 
      
    $sql = "INSERT INTO `Admin` (`AdminPseudo`, `AdminPassWord`, `AdminMail`) VALUES ('".$AdminPseudo."','".$AdminPassWord."','".$AdminMail."')";
    
    $res =mysql_query($sql);
    //header('Location: agenda.php');
    mysql_close();
    //send_notif($message);
}

function modifAdmin() {
    bd_Connecter();
    $AdminPseudo = $_POST['AdminPseudo']; // '".$AdminPseudo."'
    $AdminPassWord= $_POST['AdminPassWord']; // '".$AdminPassWord."'
    $AdminMail= $_POST['AdminMail']; // '".$AdminMail."'
    //$AdminId = isset($_SESSION['id']) ? $_SESSION['id'] : 1; // '".$AdminId."'
    // concaténation : '".$message."' 
      
    $sql = "INSERT INTO `Admin` (`AdminPseudo`, `AdminPassWord`, `AdminMail`) VALUES ('".$AdminPseudo."','".$AdminPassWord."','".$AdminMail."')";
    
    $res =mysql_query($sql);
    //header('Location: agenda.php');
    mysql_close();
    //send_notif($message);
}


function envoiMail() {

// To
$to = 'cedibo25@gmail.com';
 
// Subject
$subject = 'Developpez.com - Test Mail';
 
// Message
$msg = 'Developpez.com - Message du mail ...';
 
// Function mail()
mail($to, $subject, $msg);

}







?>