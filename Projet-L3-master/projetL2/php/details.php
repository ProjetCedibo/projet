<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';

ob_start();

$connecte = ifconnect();

fd_html_debut('BookShop | Details', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

details_livre();

fd_bookshop_pied('./');

fd_html_fin();

ob_end_flush();



// ----------  Fonctions locales au script ----------- //

/**
* Fonction permettant d'afficher les détails du produit
*
*/
function details_livre(){
		if(isset($_GET['article'])){
			$bd = bdConnecter();
			mysqli_set_charset($bd,"utf8");
			//On recupere le livre dans le GET
			$article = mysqli_real_escape_string($bd, $_GET['article']);
			//On cherche les informations sur le livre
			$sql = 'SELECT * FROM livres INNER JOIN editeurs ON liIDEditeur=edID INNER JOIN aut_livre ON liID=al_IDLivre INNER JOIN auteurs ON al_IDAuteur=auID WHERE liID = '.$article.'';
			$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
			$enr = mysqli_fetch_assoc($r);
			//Si le livre n'existe pas on redirige sur erreur 404
			if ($enr<=0){
				redirection('0', './erreur.php?erreur=404');
			}
			//Sinon on affiche les informations du livre
			else{

				$liID = $enr['liID'];
				$liTitre = $enr['liTitre'];
				$edWeb = $enr['edWeb'];
				$edNom = $enr['edNom'];
				$liPrix = $enr['liPrix'];
				$liPages = $enr['liPages'];
				$liISBN13 = $enr['liISBN13'];
				$resume = $enr['liResume'];
				$categorie = $enr['liCat'];
				$liAuteur[$enr['auNom']] = $enr['auPrenom'];

			echo '<h1>'.$liTitre.'</h1>',
				'<p><img src="../images/livres/'.$liID.'.jpg" height=300px width=182px style="float:left; border:1px solid black; margin-right:8px">',
				'<p> Auteur : ';

				$indice = 0;
				while ($liID == $enr['liID']){
					$indice++;
					$liAuteur[$enr['auNom']] = $enr['auPrenom'];
					$enr = mysqli_fetch_assoc($r);
				}
				$i=0;
				foreach ($liAuteur as $nom => $prenom) {  
					if ($i > 0) {
						echo ', ';
					}
					$i++;
					echo '<a title="Rechercher l\'auteur" href="recherche.php?Recherche=', $nom, '&in=auNom">',$prenom, ' ', $nom, '</a>';
				}
				echo '<br><br> '.$liPages.' pages',
					'<br><br> Catégorie : '.$categorie.'',
					'<br><br> ISBN13 : '.$liISBN13.'',
					'<br><br>Prix : '.$liPrix.' €',
					'<br><br>Editeur : <a class="lienExterne" href="http://'.$edWeb.'" target="_blank">'.$edNom.'</a>';
				if(strlen($resume)>0){
					echo '<br><br>Résumé : '.$resume.'</p></p>';
				}
				echo '<div class="detail_add"> <a class="addToCart" href="panier.php?action=ajout&amp;produit='.$liID.'" title="Ajouter au panier"></a>',
					'<a class="addToWishlist" href="maliste.php?action=ajout&amp;produit='.$liID.'" title="Ajouter à la liste de cadeaux"></a>',
					'</div>';
			}
				
			mysqli_free_result($r);
			mysqli_close($bd);
		}
		//Si il n'y a pas de GET alors on redirige vers l'index
		else{
			redirection('0', '../index.php');
		}
}

?>
