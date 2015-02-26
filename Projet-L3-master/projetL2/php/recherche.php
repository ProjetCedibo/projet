<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';

ob_start();

$connecte = ifconnect();

fd_html_debut('BookShop | Recherche', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

rch_formulaire();

rch_afficher_livres();

fd_bookshop_pied('./');

fd_html_fin();

ob_end_flush();

// ----------  Fonctions locales au script ----------- //


/** 
 *	Affichage du formulaire de recherche
 */
function rch_formulaire(){

	$affich = '';
	//Si le formulaire a deja ete envoyer un recupere la recherche pour l'afficher dans la barre de recherche
	if(isset($_GET['Recherche'])){
		$affich = $_GET['Recherche'];
	}
	
	//Affichage du formulaire de recherche
	echo '<div id="searchRecherche"><form method="GET>',
			'<label for="Recherche">Rechercher : </label>',
				'<input type="text" id="Recherche" name="Recherche" value="',$affich,'">',
			'<label for="in"> Dans : </label>',
			'<select name="in" id="in">',
				'<option value="liTitre">Titre</option>',
				'<option value="auNom">Auteur</option>',
			'</select>',
			'<input type="submit" class="boutonSub" value="Rechercher">',
		'</form></div>';
}

/** 
 *	Affichage de la liste des livres
 */
function rch_afficher_livres() {
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//Si le formulaire a ete envoyer alors on recherche le contenue de la recherche
	if(isset($_GET['Recherche'])){
		$in = fd_db_protect($bd, $_GET['in']);
		$recherche = fd_db_protect($bd, $_GET['Recherche']);

		$sql = 'SELECT * FROM livres INNER JOIN editeurs ON liIDEditeur=edID INNER JOIN aut_livre ON liID=al_IDLivre INNER JOIN auteurs ON al_IDAuteur=auID
			AND '.$in.' LIKE "%'.$recherche.'%"';
	}
	//Sinon on recherche tout les livres
	else{
		$sql = 'SELECT * FROM livres INNER JOIN editeurs ON liIDEditeur=edID INNER JOIN aut_livre ON liID=al_IDLivre INNER JOIN auteurs ON al_IDAuteur=auID';
	}

	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);
	//Si la recherche n'a pas de solution 
	if($enr<=0){
		echo '<p>Aucun article correspondant </p> ';
	}
	//sinon on affiche les livres
	else{
		while ($enr) {

			$liID = $enr['liID'];
			$liTitre = $enr['liTitre'];
			$edWeb = $enr['edWeb'];
			$edNom = $enr['edNom'];
			$liPrix = $enr['liPrix'];
			$liPages = $enr['liPages'];
			$liISBN13 = $enr['liISBN13'];
			$liAuteur[$enr['auNom']] = $enr['auPrenom'];
			
			
			while ($liID == $enr['liID']){
				$liAuteur[$enr['auNom']] = $enr['auPrenom'];
				$enr = mysqli_fetch_assoc($r);
			}
			echo'<br><div class="BookRecherche"><a href="details.php?article='.$liID.'"> <img src="../images/livres/',$liID,'_mini.jpg" height=100px width=70px style="float:left; border:1px solid black; margin-right:8px"></a>',
			'<strong>',$liTitre,'</strong><br>Ecrit par : ';
			
			$i = 0;
			foreach ($liAuteur as $nom => $prenom) {  
				if ($i > 0) {
					echo ', ';
				}
				$i++;
				echo '<a title="Rechercher l\'auteur" href="recherche.php?Recherche=', $nom, '&in=auNom">',$prenom, ' ', $nom, '</a>';
			}
			
			echo '<br>Edité par : <a class="lienExterne" href="http://',$edWeb,'" target="_blank">',$edNom,'</a><br>',
			'Prix : ',$liPrix,'€<br>',
			'Pages : ',$liPages,'<br>',
			'ISBN13 : ',$liISBN13,'<br>','
			<div class="Options">',
				'<a class="addToCart" href="panier.php?action=ajout&amp;produit='.$liID.'" title="Ajouter au panier"></a>',
				'<a class="addToWishlist" href="maliste.php?action=ajout&amp;produit='.$liID.'" title="Ajouter à la liste de cadeaux"></a>',
			'</div></div>';
			
			
			unset($liAuteur);

		}
	}
	

	mysqli_free_result($r);
	mysqli_close($bd);
}
?>