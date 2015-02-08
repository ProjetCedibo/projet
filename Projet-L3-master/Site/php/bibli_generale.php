<?php

/**
 *	Fonction affichant le début du code HTML d'une page.
 *  @param 	String	$titre	Titre de la page
 *	@param 	String	$css	Chemin relatif vers la feuille de style CSS.
 */
function html_debut($titre, $css){
	echo 
		'<!doctype html>',
		'<html>',
			'<head>',
				'<title>', $titre, '</title>', 
				'<meta charset="UTF-8">',
			   	'<link rel="stylesheet" type="text/css" href="', $css, '">',	
			'</head>',
			'<body>';
}



/**
 *	Fonction affichant la fin du code HTML d'une page.
 */
function html_fin() {
	echo '</body></html>';
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

?>