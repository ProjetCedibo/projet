<?php


/*********************************************************
 *        Bibliothèque de connection a la BD             *
 *********************************************************/

//---------------------------------------------------------------
// Définition des constantes liées à la configuration PHP
//---------------------------------------------------------------
define('FD_QUOTES_GPC', (get_magic_quotes_gpc() == 1) ? TRUE : FALSE);

define('IS_DEV', TRUE);

// Paramètres base de données (Cedric)
define('BD_SERVEUR', 'localhost');
define('BD_USER', 'root');
define('BD_PASS', 'root');
define('BD_NOM', 'bookshop_db');

// Paramètres base de données FAC (Mehdi)
/*define('BD_SERVEUR', 'localhost');
define('BD_USER', 'azizi_user');
define('BD_PASS', 'azizi_pass');
define('BD_NOM', 'azizi_bookshop');*/

/* Paramètres base de données FAC (Cedric)
define('BD_SERVEUR', 'localhost');
define('BD_USER', 'petetin_user');
define('BD_PASS', 'petetin_pass');
define('BD_NOM', 'petetin_bookshop');*/

// Paramètres base de données (Mehdi)
/*define('BD_SERVEUR', 'localhost');
define('BD_USER', 'bookshop_user');
define('BD_PASS', 'bookshop_pass');
define('BD_NOM', 'bookshop_db');*/

/**
 * Connexion à une base de données MySQL.
 * En cas d'erreur de connexion le script est arrêté.
 *
 * @return resource connecteur à la base de données
 */
function bdConnecter() {
    $bd = mysqli_connect(BD_SERVEUR, BD_USER, BD_PASS, BD_NOM) or fd_bd_erreur($conn,'');
        return $bd;
}

//_______________________________________________________________
/**
 * Protection d'une chaine de caractères avant de l'enregistrer dans une base de données
 * @param 	connexion 	$co 	La connexion à la base de données
 * @param 	string 		$str 	La chaîne à protèger
 * @return 	string 				La chaîne protégée
 */
function fd_db_protect($co, $str) {

	// On enlève la protection automatique magic_quote_gpc
	(FD_QUOTES_GPC) && $str = stripslashes($str);
	$str = trim($str);
	return mysqli_real_escape_string($co, $str);
}


/**
 * Arrêt du script si erreur base de données.
 * Affichage d'un message d'erreur si on est en phase de
 * développement, sinon stockage dans un fichier log.
 *
 * @param string	$msg	Message affiché ou stocké.
 */
function fd_bd_erreurExit($msg) {
	ob_end_clean();		// Supression de tout ce qui a pu être déja généré

	echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>',
			'Erreur base de données</title></head><body>',
			$msg,
			'</body></html>';
	exit();
}

/**
 * Gestion d'une erreur de requête à la base de données.
 *
 * @param resource	$bd		Connecteur sur la bd ouverte
 * @param string	$sql	requête SQL provoquant l'erreur
 */
function fd_bd_erreur($bd, $sql) {
	$errNum = mysqli_errno($bd);
	$errTxt = mysqli_error($bd);

	// Collecte des informations facilitant le debugage
	$msg = '<h4>Erreur de requ&ecirc;te</h4>'
			."<pre><b>Erreur mysql :</b> $errNum"
			."<br> $errTxt"
			."<br><br><b>Requ&ecirc;te :</b><br> $sql"
			.'<br><br><b>Pile des appels de fonction</b>';

	// Récupération de la pile des appels de fonction
	$msg .= '<table border="1" cellspacing="0" cellpadding="2">'
			.'<tr><td>Fonction</td><td>Appel&eacute;e ligne</td>'
			.'<td>Fichier</td></tr>';

	$appels = debug_backtrace();
	for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
		$msg .= '<tr align="center"><td>'
				.$appels[$i]['function'].'</td><td>'
				.$appels[$i]['line'].'</td><td>'
				.$appels[$i]['file'].'</td></tr>';
	}

	$msg .= '</table></pre>';

	fd_bd_erreurExit($msg);
}

?>
