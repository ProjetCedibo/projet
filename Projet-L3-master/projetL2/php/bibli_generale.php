<?php

/*********************************************************
 *        Bibliothèque de fonctions génériques           *
 *********************************************************/


/**
 *	Fonction affichant le début du code HTML d'une page.
 *  @param 	String	$titre	Titre de la page
 *	@param 	String	$css	Chemin relatif vers la feuille de style CSS.
 */
function fd_html_debut($titre, $css) {
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
function fd_html_fin() {
	echo '</body></html>';
}


?>