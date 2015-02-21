<?php

session_start();

include './php/bibli_generale.php';
include './php/bibli_bookshop.php';
include './php/bibli_bd.php';

ob_start();

$connecte = ifconnect();

fd_html_debut('BookShop | Bienvenue', './styles/bookshop.css');

fd_bookshop_entete($connecte,'./');

fdl_contenu();

fd_bookshop_pied('./php/');

fd_html_fin();

ob_end_flush();


// ----------  Fonctions locales au script ----------- //

/** 
 *	Affichage du contenu de la page
 */
function fdl_contenu() {
	
	echo 
		'<h1>Bienvenue sur BookShop !</h1>',
		
		'<p>Passez la souris sur le logo et laissez-vous guider pour découvrir les dernières exclusivités de notre site. </p>',
		
		'<p>Nouveau venu sur BookShop ? Consultez notre <a href="./html/presentation.html" target="_blank">page de présentation</a> !',
	
		'<h2>Dernières nouveautés </h2>',
	
		'<p>Voici les 4 derniers articles ajoutés dans notre boutique en ligne :</p>';

		search_dernier_ajout();
		
	
	echo 
		'<h2>Top des ventes</h2>', 
		'<p>Voici les 4 articles les plus vendus :</p>';
	
		search_meilleurs_ventes();

}


/** 
 *	Affichage d'une liste de livres sous la forme de blocs
 *	@param 	int 	l'id du livre
 *	@param  array 	listes des auteurs
 *	@param  string 	titre du livre
 */
function fd_afficher_blocs_livres($liID,$auteurs,$titre) {


		echo 
			'<div class="bcArticle">',
				'<div class="bcOptions">', 
					'<a class="addToCart" href="./php/panier.php?action=ajout&amp;produit='.$liID.'" title="Ajouter au panier"></a>',
					'<a class="addToWishlist" href="./php/maliste.php?action=ajout&amp;produit='.$liID.'" title="Ajouter à la liste de cadeaux"></a>',
				'</div>',
				'<a href="php/details.php?article=', $liID, '" title="Voir détails"><img src="./images/livres/', $liID, '_mini.jpg" height=165px width=100px></a>',
				'<br>';
		
		$i = 0;
		foreach ($auteurs as $cle => $nom) {  
			if ($i > 0) {
				echo ', ';
			}
			$i++;
			echo '<a title="Rechercher l\'auteur" href="./php/recherche.php?Recherche=', $cle, '&in=auNom">', $nom, '</a>';
		}
		echo 
			'<br>', 
			'<strong>', $titre, '</strong>',
		  '</div>';
}



/** 
 *	Fonction permettant de chercher les 4 derniers ajouts a la bd
 */
function search_dernier_ajout(){
	$compteur = 0;
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On recherche les informations nécessaire a l'affichage d'un livre dans la base, on trie les livres de l'id la plus grande a la plus petite (l'id et affecter automatiquement)
	$sql = 'SELECT * FROM `livres` INNER JOIN aut_livre ON liID=al_IDLivre INNER JOIN auteurs ON al_IDAuteur=auID ORDER BY `liID` DESC';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);

	while($enr){
		$compteur += 1;
		$liID = $enr['liID'];
		$nom = $enr['auNom'];
		$liAuteur[$enr['auNom']] = $enr['auPrenom'][0].'.'.$enr['auNom'];
		$titre = $enr['liTitre'];


		while ($liID == $enr['liID']){
			
			$liAuteur[$enr['auNom']] = $enr['auPrenom'][0].'.'.$enr['auNom'];
			$enr = mysqli_fetch_assoc($r);
		}

		//On afiche le livres courant
		fd_afficher_blocs_livres($liID,$liAuteur,$titre);

		unset($liAuteur);

		//Au bout de 4 livres on sort de la boucle car l'on affiche que les 4 derniers livres
		if($compteur == 4){
			break;
		}
	}
	
	mysqli_free_result($r);
	mysqli_close($bd);

}

/** 
*	Fonction permettant de chercher les 4 meilleurs ventes
*/
function search_meilleurs_ventes(){
	//enregistrement des id des 4 meilleurs ventes
	$tlivre[0] = 3;
	$tlivre[1] = 4;
	$tlivre[2] = 5;
	$tlivre[3] = 6;

	//enredistrement du nombres de ventes pour les 4 meilleurs ventes
	$tqte[0] = 0;
	$tqte[1] = 0;
	$tqte[2] = 0;
	$tqte[3] = 0;



	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On recherche toutes les informations sur les ventes
	$sql = 'SELECT * FROM `compo_commande` order by `ccIDLivre`';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);
	//Pour chaque livre on calcul le nombre de ventes dans $quantiteVendu
	while($enr){
		
		$livre = $enr['ccIDLivre'];

		while ($livre == $enr['ccIDLivre']){
			$quantiteVendu = 0;
			$quantiteVendu += $enr['ccQuantite'];
			$enr = mysqli_fetch_assoc($r);
		}

		//On cherche si le livre courent a ete plus vendu que l'un des 4 meilleurs ventes
		$compteur = 0;
		for ($i=0; $i < 4; $i++) { 
			//Si oui alors on l'enregistre
			if($quantiteVendu >= $tqte[$i] ){
				$tqte2[$i] = $quantiteVendu;
				$tlivre2[$i] = $livre;
				$quantiteVendu = -1; 
			}
			//sinon on ne change rien 
			else{
				$tqte2[$i] = $tqte[$compteur];
				$tlivre2[$i] = $tlivre[$compteur];
				$compteur = $compteur +1;
			}

		}
		for ($i=0; $i < 4; $i++) { 
			$tqte[$i] = $tqte2[$i];
			$tlivre[$i] = $tlivre2[$i];
		}

	}

	

	mysqli_free_result($r);

	//On parcourt les 4 livres les plus vendu
	for ($i=0; $i < 4; $i++) { 
			$best = $tlivre[$i];

			// On recherche les informations necessaire a l'affichage du livre 
			$sql = 'SELECT * FROM `livres` INNER JOIN aut_livre ON liID=al_IDLivre INNER JOIN auteurs ON al_IDAuteur=auID WHERE liID='.$best.'';
			$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
			$enr = mysqli_fetch_assoc($r);

			while($enr){
				$liID = $enr['liID'];
				$nom = $enr['auNom'];
				$liAuteur[$enr['auNom']] = $enr['auPrenom'][0].'.'.$enr['auNom'];
				$titre = $enr['liTitre'];


				while ($liID == $enr['liID']){
					$liAuteur[$enr['auNom']] = $enr['auPrenom'][0].'.'.$enr['auNom'];
					$enr = mysqli_fetch_assoc($r);
				}

				//On affiche le livre courent
				fd_afficher_blocs_livres($liID,$liAuteur,$titre);

				unset($liAuteur);
			}
	}

	mysqli_free_result($r);
	mysqli_close($bd);

}

?>
