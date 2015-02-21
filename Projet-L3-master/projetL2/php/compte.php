<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';
include 'bibli_formulaire.php';

ob_start();

$connecte = ifconnect();

//Si l'utilisateur n'est pas connecter on lui refuse l'acces et le redirige sur l'index
if($connecte==false){
	redirection('0', '../index.php');
}else{

fd_html_debut('BookShop | Compte', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

menutop();

info_perso();

adress_perso();

fd_bookshop_pied('./');

fd_html_fin();
}

ob_end_flush();

/**
* Fonction affichant le menu du compte
*/
function menutop(){

	echo '<div id="menucompte">',
 		'<ul id="onglets">',
  		'<li class="active"><a class="here" href="compte.php"> Mes coordonnées </a></li>',
   		'<li class="liste"><a href="commandes.php"> Mes commandes </a></li>',
    	'<li class="liste"><a href="maliste.php"> Ma liste de cadeaux </a></li>',
     	'</ul>',
      	'</div>';
}


/**
*	bloc d'affichage des informations personnelles
*/
function info_perso(){
	echo '<h2>Informations personnelles</h2>';
	$id = $_SESSION['ID'];

	//si l'utilisateur a renvoyer le formulaire alors on fait appel aux fonction necessaire
	$err = (isset($_POST['nomprenom'])) ? update_infos() : NULL;
	$err2 = (isset($_POST['pass1'])&&$_POST['pass1'] != '') ? update_mdp() : NULL;

	//On affiche les messages des reussite ou non des modifications si il y en a eu
	if(isset($err)){
		echo $err;
	}
	if(isset($err2)){
		echo $err2;
	}

	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On recherche le nom, prenom, email et date de naissance du client
	$sql = 'SELECT cliEmail, cliNomPrenom, cliDateNaissance FROM clients WHERE cliID = '.$id.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_row($r);
	$mail = $enr[0];
	$nomPrenom = $enr[1];
	$datenaiss = $enr[2];
	mysqli_free_result($r);
	mysqli_close($bd);


	//On affiche le formulaire
echo 	
		'<form method="post" action="compte.php">',
			'<table style="width: 500px; margin: 0px auto;">',
				fd_form_ligne('Nom et prenom :', fd_form_input(FD_Z_TEXT, 'nomprenom', $nomPrenom, 25)),
				fd_form_ligne('Date de naissance :', fd_form_date('naiss', substr($datenaiss,-2), substr($datenaiss, -4,2), substr($datenaiss, -8,4))),
				fd_form_ligne('Votre adresse email :', fd_form_input(FD_Z_TEXT, 'email', $mail, 25)),
				fd_form_ligne('Nouveau un mot de passe :', fd_form_input(FD_Z_PASSWORD, 'pass1', NULL, 25)),
				fd_form_ligne('Repetez le mot de passe :', fd_form_input(FD_Z_PASSWORD, 'pass2', NULL, 25)),
				'<tr><td colspan="2" style="padding-top: 10px;" class="centered">', fd_form_input(FD_Z_SUBMIT,'btnEnregistre1','Enregistrer'), '</td></tr>',
			'</table>',
		'</form>';

}

/**
*bloc adresse perso 
*/
function adress_perso(){
	echo '<h2>Coordonnées pour la livraison</h2>';

	$id = $_SESSION['ID'];

	//Si le formulaire a ete renvoyer on appel la fonction update_adresse()
	$err3 = (isset($_POST['CP'])) ? update_adresse() : NULL;

	//Si on a fait appel a update_adresse(), on affiche ce qu'elle retourne
	if(isset($err3)){
		echo $err3;
	}

	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On recherche l'adresse, le code postale, la ville et le pays du client
	$sql = 'SELECT cliAdresse, cliCP, cliVille, cliPays FROM clients WHERE cliID = '.$id.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_row($r);
	$adresse = $enr[0];
	$CP = $enr[1];
	$ville = $enr[2];
	$pays = $enr[3];
	mysqli_free_result($r);
	mysqli_close($bd);

	//On affiche le formulaire
	echo 	
			'<form method="post" action="compte.php">',
				'<table style="width: 500px; margin: 0px auto;">',
					fd_form_ligne('Numero et rue :', fd_form_input(FD_Z_TEXT, 'numrue', $adresse, 25)),
					fd_form_ligne('Code postal :', fd_form_input(FD_Z_TEXT, 'CP', $CP, 10)),
					fd_form_ligne('Ville :', fd_form_input(FD_Z_TEXT, 'ville', $ville, 25)),
					fd_form_ligne('Pays :', fd_form_input(FD_Z_TEXT, 'pays', $pays, 25)),
					'<tr><td colspan="2" style="padding-top: 10px;" class="centered">', fd_form_input(FD_Z_SUBMIT,'btnSEnregistre2','Enregistrer'), '</td></tr>',
				'</table>',
			'</form>';
}

/**
* Modification des infos perso
*/
function update_infos(){
	$err = '<p class="erreur">';
	$ID = $_SESSION['ID'];
	//On recupere les informations du formulaire
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$nomprenom = isset($_POST['nomprenom']) ? $_POST['nomprenom'] : '';
	$naiss_j = isset($_POST['naiss_j']) ? $_POST['naiss_j'] : -1;
	$naiss_m = isset($_POST['naiss_m']) ? $_POST['naiss_m'] : -1;
	$naiss_a = isset($_POST['naiss_a']) ? $_POST['naiss_a'] : -1;
	//$cpt compte les erreurs si il y en a
	$cpt = 0;

	//On teste l'adresse email
	if (! fp_TestMail($email)) {
		$err .= ' - L\'adresse email ne respecte pas le bon format.<br>';
		$cpt = $cpt +1;	
	}
	//On test si $nomprenom est vide 
	if (empty($nomprenom)) {
		$err .= ' - Le nom et le prénom doivent être renseignés.<br>';
		$cpt = $cpt +1;	
	}
	// vérification de la date de naissance
	if (!is_numeric($naiss_j) || !is_numeric($naiss_m) || !is_numeric($naiss_a)) {
		$err .= ' - Une des composantes de la date n\'est pas numérique.<br>';
		$cpt = $cpt +1;
	}
	else if (! checkdate($naiss_m, $naiss_j, $naiss_a)) {
		$err .= ' - La date de naissance est incorrecte.<br>';
		$cpt = $cpt +1;	
	}	
	else {
		//On test que l'utilisateur ne soit pas trop vieux
		$dateDuJour = getDate();
		if ($naiss_a < $dateDuJour['year'] - 100) {
			$err .= ' - Vous êtes trop vieux pour trainer sur BookShop.<br>';
			$cpt = $cpt +1;	
		}
		//On test que l'utilisateur soit majeur
		else if (($naiss_a > $dateDuJour['year'] - 18) || 
				 ($naiss_a == $dateDuJour['year'] - 18 && $naiss_m > $dateDuJour['mon']) || 
				 ($naiss_a == $dateDuJour['year'] - 18 && $naiss_m == $dateDuJour['mon'] && $naiss_j > $dateDuJour['mday'])) {   	
				$err .= ' - Votre date de naissance indique vous n\'êtes pas majeur.<br>';
				$cpt = $cpt +1;
		}
	}
	//Si $cpt est supperieur a 0 alors on retourne les erreur
	if ($cpt > 0) { 	
		$err .= '</p>';
		return $err;	
	}
	//Sinon on fait les modifications
	else{
		
	
		$aaaammjj = $naiss_a . (($naiss_m < 10) ? '0' : '') . $naiss_m . (($naiss_j < 10) ? '0' : '') . $naiss_j;

		$co = bdConnecter();
		//On protege les donneess
		$aaaammjj = fd_db_protect($co,$aaaammjj);
		$nomprenom = fd_db_protect($co,$nomprenom);
		$email = fd_db_protect($co,$email);
		//On modifie les informations
		$sql = 'UPDATE clients SET cliEmail = "'.$email.'", cliNomPrenom = "'.$nomprenom.'", cliDateNaissance = "'.$aaaammjj.'" WHERE cliID = '.$ID.'';
		mysqli_query($co, $sql) or fd_bd_erreur($co, $sql);

		// libération des ressources
		mysqli_close($co);
		//On retourne un message de reussite
		return '<p class="succes"> Vos informations ont été mise a jour</p>';
	}

}

/**
*Modification du mot de passe
*/
function update_mdp(){
	$err = '<p class="erreur">';
	//On recupere les mots de passe renvoyer par les formulaire et on les passe en md5
	$pass1 = md5($_POST['pass1']);
	$pass2 = md5($_POST['pass2']);
	$ID = $_SESSION['ID'];
	//$cpt compte les erreurs si il y en a
	$cpt = 0;

	// vérification des mots de passe
	if (empty($pass1) || empty($pass2)) {
		$err .= ' - Les mots de passe doivent être renseignés.<br>';
		$cpt = $pct +1;
	}
	else {
		//Verification qu'il soit identiques
		if ($pass1 != $pass2) {
			$err .= ' - Les mots de passe doivent être identiques.<br>';
			$cpt = $pct +1;	
		}
		//Si il n'y a pas d'erreur on fait les modifications
		else{
			$co = bdConnecter();
			//On protege les informations
			$pass1 = fd_db_protect($co, $pass1);
			//On les modifies
			$sql = 'UPDATE clients SET cliPassword = "'.$pass1.'" WHERE cliID = '.$ID;
			mysqli_query($co, $sql) or fd_bd_erreur($co, $sql);

			// libération des ressources
			mysqli_close($co);
		}
	}
	//On retourne les erreur
	if ($cpt > 0) { 
		$err .= '</p>';
		return $err;	
	}
	//Ou un message de reussite
	else{
		return '<p class="succes"> Votre mot de passe a été modifier</p>';
	}
}

/**
*Modification de l'adresse
*/
function update_adresse(){
	$err = '<p class="erreur">';
	//On recupere les informations du formulaire
	$numrue = $_POST['numrue'];
	$CP = $_POST['CP'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
	$ID = $_SESSION['ID'];
	//$cpt compte les erreurs si il y en a
	$cpt = 0;

	//On verifie que les informations sont remplie 
	if(empty($CP)){
		$err .= ' - Vous devez enregistrer un code postale <br>';
		$cpt = $cpt +1;
	}
	if(empty($ville)){
		$err .= ' - Vous devez enregistrer une ville <br>';
		$cpt = $cpt +1;
	}
	if(empty($pays)){
		$err .= ' - Vous devez enregistrer un pays <br>';
		$cpt = $cpt +1;
	}
	//Si il y a des erreurs on affiche les messages d'erreur
	if($cpt > 0 ){
		$err .= '</p>';
		return $err;
	}
	//Sinon on fait les modifications
	else{
		$co = bdConnecter();
		//On protege les donnees
		$numrue = fd_db_protect($co,$_POST['numrue']);
		$CP = fd_db_protect($co,$_POST['CP']);
		$ville = fd_db_protect($co,$_POST['ville']);
		$pays = fd_db_protect($co,$_POST['pays']);
		//on fait les modifications
		$sql = 'UPDATE clients SET cliAdresse = "'.$numrue.'", cliCP = "'.$CP.'", cliVille = "'.$ville.'", cliPays = "'.$pays.'" WHERE cliID = '.$ID;

		mysqli_query($co, $sql) or fd_bd_erreur($co, $sql);

		// libération des ressources
		mysqli_close($co);
		//On retourne un message des reussite
		return '<p class="succes">Votre adresse a été mise a jour</p>';
	}
}


?>
