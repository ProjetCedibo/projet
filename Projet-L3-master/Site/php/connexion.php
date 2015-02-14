<?php

include 'bibli_generale.php';
include 'bibli_bd.php';

$err = (isset($_POST['btnConnexion'])) ? traitement_connexion() : 0;

session_start();
ob_start();

$connecte = ifconnect();

html_debut("ADMIN - Connexion", "../style/connect.css");

if($connecte==true){
	redirection('0', '../index.php');
}


?>
<div class="container">

      <div id="login">

        <h2><span class="fontawesome-lock"></span>Administration</h2>

        <form action="connexion.php" method="post">

          <fieldset>

            <p><label for="pseudo">Pseudo</label></p>
            <p><input type="text" id="pseudo" placeholder="pseudo"></p>

            <p><label for="password">Password</label></p>
            <p><input type="password" id="password" placeholder="password"></p>

            <p><input type="submit" value="Connexion" name="btnConnexion"></p>

          </fieldset>

        </form>

      </div> <!-- end login -->

    </div>

<?php



html_fin();

ob_end_flush();


/** 
 *  Traitement de la connexion : 
 *      identification du couple pseudo/password dans la base. Redirection vers l'index
 *  @return     int     -1 si la connexion a échouée (mauvaise combinaison login/password)
 */
function traitement_connexion() {
    echo 'coucou';

    // connexion à la base de données   
    bd_Connecter();

    // sanitization des données postées
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // requête SQL
    //$sql = "SELECT * FROM Admin  WHERE `AdminPseudo` = '$pseudo' AND `AdminPassWord`= sha1('$password')";
    $sql = "SELECT * FROM Admin  WHERE AdminPseudo = 'Admin' AND AdminPassWord = sha5('Admin')";
    
    // execution de la requête
    $res = mysqli_query($sql) or fd_bd_erreur($sql);

    // test de l'existence d'un client ayant cette combinaison email/password
    if (mysqli_num_rows($res) != 1) {
        mysqli_free_result($res);
        mysqli_close($co);
        return -1;  
    }
    
    // récupération du numero client 
    $t = mysqli_fetch_assoc($res);
    $id = $t['AdminId'];
    
    // ouverture de la session
    session_start();
    $_SESSION['ID'] = $id;

    // fermeture des ressources et de la connexion à la base
    mysqli_free_result($res);
    mysqli_close($co);
    
    // et redirection
    redirection('0','../index.html');
    
    // ne devrait pas arriver
    return 0;
}

?>