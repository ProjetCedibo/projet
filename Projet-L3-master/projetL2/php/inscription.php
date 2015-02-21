<?php

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';
include 'bibli_formulaire.php';

ob_start();

session_start();
$connecte = ifconnect();
//Si l'utilisateur est deja connecter alors on lui reffuse l'acces et on le redirige vers l'index
if($connecte){
	redirection('0','../index.php');
}

$err = isset($_POST['btnSInscrire']) ? fdl_inscription() : null; 

fd_html_debut('BookShop | Inscription', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

fdl_contenu($err);

fd_bookshop_pied('./');

fd_html_fin();

ob_end_flush();


// ----------  Fonctions locales au script ----------- //

/**
 *	Affichage du contenu de la page (formulaire d'inscription)
 *	@param 	array	$err	tableau d'erreurs à afficher
 */
function fdl_contenu($err) {

	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$nomprenom = isset($_POST['nomprenom']) ? $_POST['nomprenom'] : '';
	$naiss_j = isset($_POST['naiss_j']) ? $_POST['naiss_j'] : -1;
	$naiss_m = isset($_POST['naiss_m']) ? $_POST['naiss_m'] : -1;
	$naiss_a = isset($_POST['naiss_a']) ? $_POST['naiss_a'] : -1;

	echo 
		'<H1>Inscription à BookShop</H1>';
		
	if (isset($err) && count($err) > 0) {
		echo '<p class="erreur">Votre inscription n\'a pas pu être réalisée à cause des erreurs suivantes : ';
		foreach ($err as $k => $v) {
			echo '<br> - ', $v;
		}
		echo '</p>';	
	}
		
	$source = (isset($_POST['btnInscription'])) ? $_POST['source'] : '../index.php'; 	
		
	echo 	
		'<form method="post" action="inscription.php">',
			fd_form_input(FD_Z_HIDDEN, 'source', $source),
			'<p>Pour vous inscrire, merci de fournir les informations suivantes. </p>',
			'<table style="width: 500px; margin: 0px auto;">',
				fd_form_ligne('Votre adresse email :', fd_form_input(FD_Z_TEXT, 'email', $email, 20)),
				fd_form_ligne('Choisissez un mot de passe :', fd_form_input(FD_Z_PASSWORD, 'pass1', '', 20)),
				fd_form_ligne('Repetez le mot de passe :', fd_form_input(FD_Z_PASSWORD, 'pass2', '', 20)),
				fd_form_ligne('Nom et prenom :', fd_form_input(FD_Z_TEXT, 'nomprenom', $nomprenom, 20)),
				fd_form_ligne('Date de naissance :', fd_form_date('naiss', $naiss_j, $naiss_m, $naiss_a)),
				'<tr><td colspan="2" style="padding-top: 10px;" class="centered">', fd_form_input(FD_Z_SUBMIT,'btnSInscrire','Je m\'inscris !'), '</td></tr>',
			'</table>',
		'</form>';
}	


/**
 *	Traitement de l'inscription : 
 *		Etape 1. vérification de la validité des données
 *					-> terminaison si des erreurs sont trouvées
 *		Etape 2. enregistrement du nouvel inscrit dans la base
 *		Etape 3. ouverture de la session et renvoi à la page appelante. 
 */
function fdl_inscription() {
	$err = array();
	
	$email = trim($_POST['email']);
	$pass1 = trim($_POST['pass1']);
	$pass2 = trim($_POST['pass2']);
	$nomprenom = trim($_POST['nomprenom']);
	$naiss_j = $_POST['naiss_j'];
	$naiss_m = $_POST['naiss_m'];
	$naiss_a = $_POST['naiss_a'];
	
	// vérification email
	if (! fp_TestMail($email)) {
		$err['email'] = 'L\'adresse email ne respecte pas le bon format.';	
	}
	
	// vérification des mots de passe
	if (empty($pass1) || empty($pass2)) {
		$err['pass1'] = 'Les mots de passe doivent être renseignés.';	
	}
	else {
		if ($pass1 != $pass2) {
			$err['pass1'] = 'Les mots de passe doivent être identiques.';	
		}	
	}
	
	// vérification des noms et prenoms
	if (empty($nomprenom)) {
		$err['nomprenom'] = 'Le nom et le prénom doivent être renseignés.';	
	}
	
	// vérification de la date de naissance
	if (!is_numeric($naiss_j) || !is_numeric($naiss_m) || !is_numeric($naiss_a)) {
		$err['date'] = 'Une des composantes de la date n\'est pas numérique.';	
	}
	else if (! checkdate($naiss_m, $naiss_j, $naiss_a)) {
		$err['date'] = 'La date de naissance est incorrecte.';	
	}	
	else {
		$dateDuJour = getDate();
		if ($naiss_a < $dateDuJour['year'] - 100) {
			$err['date'] = 'Vous êtes trop vieux pour trainer sur BookShop.';	
		}
		else if (($naiss_a > $dateDuJour['year'] - 18) || 
				 ($naiss_a == $dateDuJour['year'] - 18 && $naiss_m > $dateDuJour['mon']) || 
				 ($naiss_a == $dateDuJour['year'] - 18 && $naiss_m == $dateDuJour['mon'] && $naiss_j > $dateDuJour['mday'])) {   	
			$err['date'] = 'Votre date de naissance indique vous n\'êtes pas majeur.';
		}
	}

	if (count($err) == 0) {
		// vérification de l'unicité de l'adresse email 
		// (uniquement si pas d'autres erreurs, parce que ça coûte un bras)
		$co = bdConnecter();

		// pas utile, car l'adresse a déjà été vérifiée, mais tellement plus sécurisant...
		$email = fd_db_protect($co, $email);
		$sql = "SELECT * FROM clients WHERE cliEmail = '$email'"; 
	
		$res = mysqli_query($co,$sql) or fd_bd_erreur($co,$sql);
		
		if (mysqli_num_rows($res) != 0) {
			$err['email'] = 'L\'adresse email spécifiée existe déjà.';
		}
	
		// libération des ressources 
		mysqli_free_result($res);		
	}
	
	// s'il y a des erreurs ==> on retourne le tableau d'erreurs	
	if (count($err) > 0) { 	
		return $err;	
	}
	
	// pas d'erreurs ==> enregistrement de l'utilisateur et ouverture de la session
	$nomprenom = fd_db_protect($co, $nomprenom);
	$pass = fd_db_protect($co, $pass1);
	$aaaammjj = $naiss_a . (($naiss_m < 10) ? '0' : '') . $naiss_m . (($naiss_j < 10) ? '0' : '') . $naiss_j;
	
	$sql = "INSERT INTO clients(cliNomPrenom, cliEmail, cliDateNaissance, cliPassword) 
			VALUES ('$nomprenom', '$email', '$aaaammjj', MD5('$pass'))";
	mysqli_query($co, $sql) or fd_bd_erreur($co, $sql);

	$id = mysqli_insert_id($co);

	// libération des ressources
	mysqli_close($co);
	
	// ouverture de la session et redirection vers la page d'origine
	$_SESSION['ID'] = $id;
	$source = isset($_POST['source']) ? $_POST['source'] : '../index.php';
	fd_redirection($source);
}
	


?>