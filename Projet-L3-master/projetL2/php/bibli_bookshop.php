<?php

/*********************************************************
 *        Bibliothèque de fonctions spécifiques          *
 *               à l'application BookShop                *
 *********************************************************/


/**
 *	Fonction affichant le canevas général de l'application BookShop 
 *	(bloc page, entête et menu de navigation, ouverture du bloc de contenu).
 *  @param 	boolean		$connecte	Indique si l'utilisateur est connecté ou non.
 *	@param 	String		$prefix		Prefixe des chemins vers les fichiers du menu (usuellement "./" ou "../").
 */
function fd_bookshop_entete($connecte,$prefix) {
	echo 
		'<div id="bcPage">',
	
		'<div id="bcEnseigne">',
			'<a href="http://www.facebook.com" target="_blank" id="lienFacebook"> </a>',
			'<a href="http://www.twitter.com" target="_blank" id="lienTwitter"> </a>',
			'<a href="http://plus.google.com" target="_blank" id="lienGooglePlus"> </a>',
			'<a href="http://www.pinterest.com" target="_blank" id="lienPinterest"> </a>',
		'</div>',
		
		'<div id="bcEntete">';
	
	fd_bookshop_menu($connecte,$prefix);

	echo
		'<div id="soustitre"></div>',
		'</div>', // fin bcEntete
		
		'<div id="bcTexte">';
}


/**
 *	Fonction affichant le menu de navigation de l'application BookShop 
 *  @param 	boolean		$connecte	Indique si l'utilisateur est connecté ou non.
 *	@param 	String		$prefix		Prefixe des chemins vers les fichiers du menu (usuellement "./" ou "../").
 */
function fd_bookshop_menu($connecte, $prefix) {		
	echo 
		'<div id="bcLogo">',	
			'<a id="logo" href="', $prefix, 'index.php"></a>';

	if ($connecte) {
		echo
			'<a id="lienSearch" class="lienMenu position1" href="', $prefix, 'php/recherche.php" title="Effectuer une recherche" ></a>',
			'<a id="lienCart" class="lienMenu position2"  href="', $prefix, 'php/panier.php" title="Voir votre panier"></a>',
			'<a id="lienList" class="lienMenu position3" href="', $prefix, 'php/liste.php" title="Voir une liste de cadeaux"></a>',
			'<a id="lienAccount" class="lienMenu position4" href="', $prefix, 'php/compte.php" title="Consulter votre compte"></a>',
			'<a id="lienDisconnect" class="lienMenu position5" href="', $prefix, 'php/deconnexion.php" title="Se déconnecter"></a>';
	}
	else {
		echo
			'<a id="lienSearchD" class="lienMenu position2" href="', $prefix, 'php/recherche.php" title="Effectuer une recherche" ></a>',
			'<a id="lienCartD" class="lienMenu position3"  href="', $prefix, 'php/panier.php" title="Voir votre panier"></a>',
			'<a id="lienListD" class="lienMenu position4" href="', $prefix, 'php/liste.php" title="Voir une liste de cadeaux"></a>',
			'<a id="lienConnect" class="lienMenu position5" href="', $prefix, 'php/connexion.php" title="Se connecter"></a>';
	}
	echo '</div>';
}

/**
*test si l'on est connecter ou pas.
* @return boolean 	Vrai si l'utilisateur est connecter, faux sinon
*/
function ifconnect(){
	if(isset($_SESSION['ID'])){
		return true;
	}
	else{
		return false;
	}
}


/**
*	Redirection.
* @param int 	$sec 	le nombre de secondes a attendre avant la redirection
* @param string 	$lien 	la pages sur laquel on effectue la redirection
*/
function redirection ($sec, $lien) {
	echo '<META HTTP-EQUIV="Refresh" CONTENT="',$sec,';URL= ',$lien,'">';
}

/**
 *	Fonction affichant le pied de page de l'application BookShop.
 * @param String		$cible	Prefixe des chemins vers les fichiers du pied de page
 */
function fd_bookshop_pied($cible) {
	echo 
		'</div>', // fin bcTexte
		'<p id="pied">', 
			'BookShop &amp; Partners &copy; 2014 - ',
			'<a href="'.$cible.'apropos.php">A propos</a> - ',
			'<a href="'.$cible.'confident.php">Emplois @ BookShop</a> - ',
			'<a href="'.$cible.'conditions.php">Conditions d\'utilisation</a>',
		'</p>',
	'</div>'; // fin bcPage
}


?>