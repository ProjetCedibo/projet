<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';
include 'bibli_formulaire.php';

ob_start();

$connecte = ifconnect();

//On reffuse l'access a une personne non connecter, on le redirige vers la page de connexion
if(!$connecte){
	redirection('0', './connexion.php');
}else{

//Si GET action = ajout alors on fait appel a la fonction add_new_in_liste()
isset($_GET['action'])=='ajout' ? add_new_in_liste() : null; 
//Si l'utilisateur revois le formulaire pour supprimer un article de la liste alors on fait appel a delete_of_Liste()
isset($_POST['boutonSupp']) ? delete_of_Liste() : NULL;

fd_html_debut('BookShop | Ma liste', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

menutop();

search_list();

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
   		'<li class="liste"><a href="commandes.php"> Mes commandes </a></li>',
    	'<li class="active"><a href="maliste.php"> Ma liste de cadeaux </a></li>',
     	'</ul>',
      	'</div>';
}

/**
* Fonction affichant le contenu de la liste
*/
function search_list(){
	$ID = $_SESSION['ID'];
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On cherche les informations sur les livres dans la liste de l'utilisateur
	$sql = 'SELECT * FROM listes INNER JOIN livres ON listIDLivre = liID INNER JOIN aut_livre ON al_IDLivre=liID INNER JOIN auteurs ON al_IDAuteur=auID Where listIDClient= '.$ID.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($co,$sql);
	$enr = mysqli_fetch_assoc($r);
	//Si il n'y a pas d'article alors on affiche le message
	if($enr<=0){
		echo '</br><p>Aucun article dans votre liste.</p> ';
	}
	//Sinon on affiche les livres de la liste
	else{
		echo '<form method="post" action="maliste.php">';
		while ($enr) {
			
			$liID = $enr['liID'];
			$liTitre = $enr['liTitre'];
			$liAuteur[$enr['auNom']] = $enr['auPrenom'];
			//On fait appel a if_offert pour savoir si l'article a deja ete offert
			$affiche = if_offert($liID,$ID,$liTitre);
			//Si l'article n'a pas ete offert on peut le selectionner pour la suppression
			if($affiche[0]==0){
				echo '<br><input class="PosCocheInput" type="checkbox" name="livre[]" value="'.$liID.'" /> <label for="livre">';
			}
			//sinon on ne peut pas le selectionner
			else{
				echo '<br><input class="PosCocheInput" type="checkbox" name="livre[]" value="'.$liID.'" disabled/> <label for="livre">';
			}

			while ($liID == $enr['liID']){
				$liAuteur[$enr['auNom']] = $enr['auPrenom'];
				$enr = mysqli_fetch_assoc($r);
			}

			echo '<div class="blocMaListe"><a href="details.php?article='.$liID.'"> <img src="../images/livres/',$liID,'_mini.jpg" height=100px width=70px style="float:left; border:1px solid black; margin-right:8px"></a>',
			'<strong>',$liTitre,'</strong><br>Ecrit par : ';
			
			$i = 0;
			foreach ($liAuteur as $nom => $prenom) {  
				if ($i > 0) {
					echo ', ';
				}
				$i++;
				echo '<a title="Rechercher l\'auteur" href="recherche.php?Recherche=', $nom, '&in=auNom">',$prenom, ' ', $nom, '</a>';
			}

			echo '<div class="blocIsOffert">',
				//On affiche le message en fonction de si il a deja ete offert ou non
				$affiche[1],
			'</div></div></label>';

			unset($liAuteur);


		}
		echo '<p style="text-align: right; margin-right:50px;">Pour la selection : ',fd_form_input(FD_Z_SUBMIT,'boutonSupp','Supprimer'),'</form>';
	}
	mysqli_free_result($r);
	mysqli_close($bd);
}

/**
* Fonction affichant si le livre a été offert (par qui) ou non
* @param int 	$idLivre 	l'id du livre de la liste
* @param int 	$ID 	L'id de l'utilisateur
* @param string 	$liTitre 	le titre du livre
*/
function if_offert($idLivre,$ID,$liTitre){
	$enr = array();
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On protege les donnees
	$idLivre = fd_db_protect($bd, $idLivre);
	//On cherche si le livre a ete offert dans le contenue des commande
	$sql = 'SELECT * FROM clients INNER JOIN commandes ON cliID=coIDClient INNER JOIN compo_commande ON coID = ccIDCommande WHERE ccIDLivre = '.$idLivre.' AND ccIDDestinataire='.$ID.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);
	//Si il n'a pas ete offert on retourne 0 et le message
	if($enr<=0){
		$enr[0] = 0;
		$enr[1]= '<p><br><i>Pas encore offert</i> </p>';
	}
	//Sinon on retourne 1 et le nom du donnateur, on fait un lien avec ouverture d'un mail
	else{
		$enr[0] = 1;
		$message = "Cher(e) ".$enr['cliNomPrenom'].", Je vous remercie beaucoup pour le cadeau que vous m'avez fait, je suis tres heureux d\'avoir eu ce livre : ".$liTitre.", Cela m'a fait très plaisir.";
		$enr[1]= '<p><br><img src="../images/cadeau.png" title="Offert par : '.$enr['cliNomPrenom'].' "/>Offert par : <a href="mailto:'.$enr['cliEmail'].'?subject=Ton cadeau : '.$liTitre.'&amp;body='.$message.'">'.$enr['cliNomPrenom'].'</a></p>';
	}
	mysqli_free_result($r);
	mysqli_close($bd);
	return $enr;
}


/**
* Fonction permettant l'ajout d'un produit dans la liste
*/
function add_new_in_liste(){
	
	$ID = $_SESSION['ID'];
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On protege les donnees
	$produit = fd_db_protect($bd, $_GET['produit']);
	//On verifie que l'article n'est pas deja dans la liste
	$sql = 'SELECT listIDLivre FROM listes WHERE listIDLivre='.$produit.' AND listIDClient='.$ID.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_row($r);

	//Si il n'existe pas alors on l'ajoute
	if($enr<=0){
		$sql = 'INSERT INTO `listes`(`listIDClient`, `listIDLivre`) VALUES ('.$ID.','.$produit.')';
		$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	}
	mysqli_close($bd);

}

/**
* Fonction permettant la suppression de livre
*/
function delete_of_Liste(){
	$ID = $_SESSION['ID'];
	
	if(!empty($_POST['livre'])){
		//On recupere les id des livres a supprimer
		$livres = $_POST['livre'];
		$bd = bdConnecter();
		mysqli_set_charset($bd,"utf8");
		//On parcourt la liste des livres a supprimer
		foreach ($livres as $liID) {
			//On supprime le livre de la liste
			$sql = 'DELETE FROM `listes` WHERE `listIDClient`='.$ID.' AND `listIDLivre`= '.$liID.'';
			$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
		}
		mysqli_close($bd);
	}
}


?>
