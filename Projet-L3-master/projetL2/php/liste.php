<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';

ob_start();

$connecte = ifconnect();

fd_html_debut('BookShop | Liste', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

echo '<h1>Consulter une liste de cadeaux</h1>';

//Affichage du formulaire de recherche
liste_Recherche();

//Affichage des résultats de la recherche,
$err = isset($_GET['listeof']) ? affiche_recherche() : NULL;
			

fd_bookshop_pied('./');

fd_html_fin();

ob_end_flush();

/**
* Affichage du formulaire
*/
function liste_Recherche(){
	$affich = '';
	//Si le formulaire a deja ete envoyer alors on enregistre la recherche dans $affich et on le met dans la barre de recherche
	if(isset($_GET['listeof'])){
		$affich = $_GET['listeof'];
	}

echo '<div id="searchRecherche"><form method="GET">',
			'<label for="listeof">Adresse email de votre ami(e) : </label>',
				'<input type="email" id="listeof" size="30" name="listeof" value="',$affich,'">',
			'<input type="submit" class="boutonSub" value="Voir la liste">',
		'</form></div>';
}

/**
* Affichage des résultats de la recherche
*/
function affiche_recherche(){

			$bd = bdConnecter();
			mysqli_set_charset($bd,"utf8");
			//On protege l'email sur lequel on fait la recherche
			$listede = fd_db_protect($bd, $_GET['listeof']); 
			//On recherche les livres dans la liste du client correspondant a email
			$sql = 'SELECT * FROM livres INNER JOIN editeurs ON liIDEditeur=edID INNER JOIN aut_livre ON liID=al_IDLivre INNER JOIN auteurs ON al_IDAuteur=auID INNER JOIN listes ON liID=listIDLivre INNER JOIN clients ON cliID=listIDClient WHERE cliEmail = "'.$listede.'"';
			$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
			$enr = mysqli_fetch_assoc($r);
			//Si il n'y a pas de resultats alors le client n'a pas de liste
			if($enr<=0){
				echo '<p>Aucune liste correspondante</p> ';
			}
			//Sinon on affiche la liste
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
					$destinataire = $enr['cliID'];
					
					
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
					
					echo '<br>Edité par : <a class="lienExterne" href="http://',$edWeb,'">',$edNom,'</a><br>',
					'Prix : ',$liPrix,'€<br>',
					'Pages : ',$liPages,'<br>',
					'ISBN13 : ',$liISBN13,'<br>','
					<div class="Options">',
						//On recherche si le livre a deja ete offert
						is_already_gift($liID,$destinataire),
					'</div></div>';
					
					
					unset($liAuteur);

				}
			}

			mysqli_free_result($r);
			mysqli_close($bd);
		
}


/**
* Affichage de la possibilité de l'offrir ou non
* @param int 	$liID 	l'id du livre
* @param int 	$destinataire  l'id du destinataire du cadeau
*/
function is_already_gift($liID,$destinataire){
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On cherche si un article correspondant a $liID et dont le destinataire est $destinataire existe dans compo_commande
	$sql = 'SELECT * FROM compo_commande INNER JOIN commandes ON ccIDCommande=coID INNER JOIN clients ON coIDClient=cliID WHERE `ccIDLivre` = '.$liID.' AND `ccIDDestinataire` = '.$destinataire.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);
	//Si l'article n'a pas deja ete offert alors on affiche l'image du cadeau et l'utilisateur peut offrir l'article
	if($enr<=0){
		return '<a class="addgift" href="panier.php?action=ajout&amp;produit='.$liID.'&amp;offertto='.$destinataire.'" title="Offrire cette article"></a>';
	}
	//Sinon on affiche que le cadeau a ete offert et par qui, avec un lien vers la liste de la personne qui a fait le cadeau
	else{
		return '<p>Offert par <a href="liste.php?listeof='.$enr['cliEmail'].'" title="Voir la liste">'.$enr['cliNomPrenom'].'</a></p>';
	}

}



?>