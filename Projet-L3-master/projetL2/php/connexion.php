<?php

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';
include 'bibli_formulaire.php';

$err = (isset($_POST['btnConnexion'])) ? fdl_traitement_connexion() : 0;

session_start();
$connecte = ifconnect();

//Si l'utilisateur est deja connecter alors on lui reffuse l'acces et on le redirige vers l'index
if($connecte){
	redirection('0','../index.php');
}

ob_start();

fd_html_debut('BookShop | Connexion', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

fdl_contenu($err);

fd_bookshop_pied('./');

fd_html_fin();

ob_end_flush();


// ----------  Fonctions locales au script ----------- //

/**
 *	Affichage du contenu de la page (formulaire de login + lien vers la page d'inscription).
 *	@param 	int		$err 	erreur de connexion (0 pas d'erreur, -1 erreur)
 */
function fdl_contenu($err) {
	
	$source = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
	
	echo
		'<h1>Connexion à BookShop</h1>', 
		($err != 0) ? '<p class="erreur">Echec de l\'authentification</p>' : '',
		'<form action="connexion.php" method="post" class="bcFormulaireBoite">',			
			'<p class="enteteBloc">Déjà inscrit ?</p>',
			'<input type="hidden" name="source" value="', $source,'">', 
			'<table style="margin: 0px auto;">', 
				fd_form_ligne('Email :', fd_form_input(FD_Z_TEXT,'email','',20)),
				fd_form_ligne('Mot de passe :', fd_form_input(FD_Z_PASSWORD,'password','',20)),
			'</table>',
			'<p class="centered bottomed"><input type="submit" style="margin-top: 0px" value="Se connecter" name="btnConnexion"></p>',
		'</form>',
		
		'<form action="inscription.php" method="post" class="bcFormulaireBoite">',			
			'<p class="enteteBloc">Pas encore inscrit ?</p>',
			'<input type="hidden" name="source" value="', $source,'">', 
			'<p>L\'inscription est gratuite et ne prend que quelques secondes.</p>', // <br>N\'hésitez pas.</p>',
			'<p class="centered bottomed"><input type="submit" value="S\'inscrire" name="btnInscription"></p>',
		'</form>'; 
}


/** 
 *	Traitement de la connexion : 
 *		identification du couple email/password dans la base. Redirection vers la page
 *		d'origine si les identifiants de connexion sont corrects. 
 *	@return		int 	-1 si la connexion a échouée (mauvaise combinaison login/password)
 */
function fdl_traitement_connexion() {

	// connexion à la base de données	
	$co = bdConnecter();

	// sanitization des données postées
	$email = fd_db_protect($co, $_POST['email']);
	$password = fd_db_protect($co, $_POST['password']);

	// requête SQL
	$sql = "SELECT * FROM clients WHERE cliEmail = '$email' AND cliPassword = md5('$password')";
	
	// execution de la requête
	$res = mysqli_query($co, $sql) or fd_bd_erreur($co, $sql);

	// test de l'existence d'un client ayant cette combinaison email/password
	if (mysqli_num_rows($res) != 1) {
		mysqli_free_result($res);
		mysqli_close($co);
		return -1;	
	}
	
	// récupération du numero client 
	$t = mysqli_fetch_assoc($res);
	$id = $t['cliID'];
	
	// ouverture de la session
	session_start();
	$_SESSION['ID'] = $id;

	// fermeture des ressources et de la connexion à la base
	mysqli_free_result($res);
	mysqli_close($co);
	
	// et redirection
	$source = isset($_POST['source']) ? $_POST['source'] : '../index.php';
	redirection('0',$source);
	
	// ne devrait pas arriver
	return 0;
}



?>
