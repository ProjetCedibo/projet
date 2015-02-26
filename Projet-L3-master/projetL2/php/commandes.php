<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';

ob_start();

$connecte = ifconnect();

//Si l'utilisateur n'est pas connecter alors on lui reffuse l'acces et on le redirige sur l'index
if(!$connecte){
	redirection('0', '../index.php');
}else{

fd_html_debut('BookShop | Commandes', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

menutop();

affiche_commande();

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
  		'<li class="liste"><a class="here" href="compte.php"> Mes coordonnées </a></li>',
   		'<li class="active"><a href="commandes.php"> Mes commandes </a></li>',
    	'<li class="liste"><a href="maliste.php"> Ma liste de cadeaux </a></li>',
     	'</ul>',
      	'</div>';
}


/**
* Fonction permettant l'affichage des commandes
*/
function affiche_commande(){
	$ID = $_SESSION['ID'];

	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");

	//On recherche toute les informations sur les commandes du client
	$sql = 'SELECT * FROM commandes INNER JOIN clients ON coIDClient = cliID INNER JOIN compo_commande ON coID=ccIDCommande INNER JOIN livres ON ccIDLivre=liID WHERE coIDClient = '.$ID.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);
	//Si il n'a pas encore passe de commande on le lui indique
	if($enr<= 0){
		echo '<br><p>Vous n\'avez passé aucune commande.</p>';
	}
	//Sinon on affiche les commandes
	else{
		echo '<br><p>Voici les commandes que vous avez passées. </p>';
		while($enr) {
			$coID = $enr['coID'];
			$date = $enr['coDate'];
			$heure = $enr['coHeure'];
			//On ajoute les 0 manquant a l'heure sinon les 0 en debut de chiffre sont supprime
			while(strlen($heure) < 4)
  				 $heure = "0" . $heure;
			$Total = 0;
			echo '<h2> Commande #'.$coID.' passée le '.substr($date,-2).'/'.substr($date, -4,2).'/'.substr($date, -8,4).' à '.substr($heure,-4,2).':'.substr($heure,-2).'</h2>';
			echo '<table class="PanierCommande"><tr><th class="tableTaille" style="width:410px;">Article</th><th style="width:75px;"> Quantité </th><th style="width:70px;"> Prix U. </th><th style="width:70px;"> Total </th></tr>';
			while($coID == $enr['coID']){
				$livres=$enr['liID'];
				$titre = $enr['liTitre'];
				$quantite = $enr['ccQuantite'];
				$prix = $enr['liPrix'];
				$Total += $quantite * $prix; //Total de la commande
				$totalprix = $quantite * $prix; //total du produit
				//Si le destinataire est differents de 0 alors c'est un cadeau et on fait appel a affiche_if_cadeau
				$cadeau = $enr['ccIDDestinataire']>0 ? affiche_if_cadeau($enr['ccIDDestinataire']) : NULL;
				echo '<tr><td class="tableTaille"><a href="details.php?article='.$livres.'">'.$titre.'</a> '.$cadeau.' </td><td class="tableCentre">'.$quantite.'</td><td class="tableCentre">'.$prix.'€</td><td class="tableCentre">',number_format($totalprix, 2, ',', ' '),'€</td></tr>';
				$enr = mysqli_fetch_assoc($r);
			}
			echo '<tr><th id="TableTotal" colspan="3">Total  </th> <th>',number_format($Total, 2, ',', ' '),'€</th></tr>',
			'</table>';
		}
	}
	mysqli_free_result($r);
	mysqli_close($bd);
}

/**
* affichage du paquet cadeau si l'achat est un cadeau
*@param int 	$idDestinataire 	L'id du destinataire du cadeau
*@return String 	l'affichage du cadeau 
*/
function affiche_if_cadeau($idDestinataire){

	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");

	//On recherche le nom et prenom du destinataire du cadeau
	$sql = 'SELECT cliNomPrenom FROM clients WHERE cliID = '.$idDestinataire.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_row($r);

	//On affiche l'image du cadeau et a qui dans le title
	return '<img src="../images/cadeau.png" title="Offert a : '.$enr[0].' "/>';

}


?>
