<?php

/**
* Fonction permettant de créer la variable de saisson 'Panier'
*/
function creationPanier(){

      $_SESSION['panier']=array();
      $_SESSION['panier']['idProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
      $_SESSION['panier']['idDestinataire'] = array();

}

/**
* Fonction permettant de faire appel a la bonne fonction en fonctionde l'action a effectuer
*/
function what_action(){
	switch ($_GET['action']) {
		case 'ajout':
			ajouterArticle();
			break;
		case 'delete':
			supprimerArticle();
			break;
		case 'qtedown':
			quantite_down();
			break;
	}
	redirection('0', './panier.php');
}

/**
* Fonction permettant l'ajout d'un article au panier, si celui ci est déja dans le panier on augmente la quantiter
*/
function ajouterArticle(){

	$idProduit = isset($_GET['produit']) ? $_GET['produit'] : 0;
	$qteProduit = 1;
	// Si le produit est un cadeau alors idDestinataire est l'id du destinataire du cadeau, sinon 0
	$idDestinataire = isset($_GET['offertto']) ? $_GET['offertto'] : 0;

	//Si on a bien une produit dans le GET alors on l'ajoute
	if($idProduit != 0){

		// Si l'id di destinataire est le meme que celui de l'utilisateur alors on le met a 0, l'utilisateur ne peut pas ce faire de cadeaux
		if(isset($_SESSION['ID'])){
			if($_SESSION['ID']==$idDestinataire){ $idDestinataire=0;}
		}

		$existedeja = false;
		//On compte le nombre d'article.
		$nombreArticle = count($_SESSION['panier']['idProduit']);
		//On parcourt les articles
		for($i = 0; $i < $nombreArticle; $i++){

			//Si l'articles existe deja et qu'il est pour l'utilisateur 
	        if (($_SESSION['panier']['idProduit'][$i] === $idProduit)&&($_SESSION['panier']['idDestinataire'][$i]==0)){
	        	//Alors $existedeja passe a vrai
	        	$existedeja = true;
	        	// On enregistre la position du produit
	        	$positionProduit = $i;
	        }

	    }
	    //Si il existe deja on augente la quantite
	    if ($existedeja==true){
	        $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
	    }
	    //sinon on enregistre le produit
	    else{
	    	//si le produit existe alors on l'ajoute, sinon on ne fait rien
	    	if(if_existe($idProduit)){
	        	//alors on l'ajoute
	       		array_push( $_SESSION['panier']['idProduit'],$idProduit);
	       		array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
	        	array_push( $_SESSION['panier']['idDestinataire'],$idDestinataire);
	    	}
	    }
	}
}

/**
* Fonction vérifiant si l'article a ajouter existe
* @param int 	$livre 	l'id de larticle a vérifier
* @return boolean 	vrai si l'article existe faux sinon
*/
function if_existe($livre){
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	$livre = fd_db_protect($bd, $livre);
	//On cherche le livre dans la base
	$sql = 'SELECT liID FROM livres WHERE liID='.$livre.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_row($r);
	//Si il n'existe pas, on retourne faux
	if($enr<=0){
		return false;
	}
	// Sinon il existe donc on retourne vrai
	else{
		return true;
	}
	mysqli_free_result($r);
	mysqli_close($bd);
}


/**
* Fonction d'affichage du panier
*@param boolean 	$connecter 	permet de savoir si l'utilisateur est connecter ou non
*/
function affichePanier($connecter){
	//On compte le nombre d'articles
	$nombreArticle = count($_SESSION['panier']['idProduit']);
	//Si il y en a au moins 1 alors on affiche le panier.
	if($nombreArticle > 0){
		echo '<h1>Contenu de votre panier </h1><br><br>',
		'<table class="PanierCommande"><tr><th class="tableTaille" style="width:410px;">Article</th><th style="width:75px;"> Quantité </th><th style="width:70px;"> Prix U. </th><th style="width:70px;"> Total </th><th style="width:20px;border:none;"></th></tr>';
		$Total = 0;
		$bd = bdConnecter();
		mysqli_set_charset($bd,"utf8");
		// ON parcourt la liste des articles
		for ($i=0 ;$i < $nombreArticle ; $i++){

			$livre = $_SESSION['panier']['idProduit'][$i];
			$livre = fd_db_protect($bd, $livre);
			$quantite = $_SESSION['panier']['qteProduit'][$i];
			$destinataire = $_SESSION['panier']['idDestinataire'][$i];

			$sql = 'SELECT * FROM livres WHERE liID='.$livre.'';
			$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
			$enr = mysqli_fetch_assoc($r);
			$prix = $enr['liPrix'];
			$titre = $enr['liTitre'];
			$totalprix = $prix * $quantite; //Calcul du total d'un article
			$Total += $totalprix; //calcul du total de la commande
			// Si l'utilisateur est connecter
			if($connecter){
				// On vérifie qu'il ne veut pas ce faire un cadeau, si c'est le cas on modifie l'id du destinataire
				if($_SESSION['ID']==$_SESSION['panier']['idDestinataire'][$i]){ $_SESSION['panier']['idDestinataire'][$i]=0;}
			}
			// Si l'aricle est un cadeaux alors on appel la fonction affiche_if_cadeau 
			$cadeau = $_SESSION['panier']['idDestinataire'][$i]>0 ? affiche_if_cadeau($_SESSION['panier']['idDestinataire'][$i]) : NULL;
			// Si l'article n'est pas un cadeau, alors on propose a l'utilisateur d'augmenter la quantite de l'aricle si il le veut
			$qteUp = $_SESSION['panier']['idDestinataire'][$i]== 0 ? '<a href="panier.php?action=ajout&amp;produit='.$livre.'">+</a>' : NULL;
			// Si la quantite de l'article est supperieur a 1, alors on propose a l'utilisateur le possibilite de diminuer la quantite
			$qteDown = $_SESSION['panier']['qteProduit'][$i]> 1 ? '<a href="panier.php?action=qtedown&amp;produit='.$livre.'">-</a>' : NULL;

			//On affiche une ligne du tableau
			echo '<tr><td class="tableTaille"><a href="details.php?article='.$livre.'">'.$titre.'</a>'.$cadeau.'</td><td class="tableCentre">'.$qteDown.''.$quantite.''.$qteUp.'</td><td class="tableCentre">'.$prix.'€</td><td class="tableCentre">',number_format($totalprix, 2, ',', ' '),'€</td><td style="width:20px;border:none;"><a href="panier.php?action=delete&amp;produit='.$livre.'&amp;destinataire='.$destinataire.'"><img src="../images/btnsupprimer.png" title="Supprimer cet article"/></a></td></tr>';

			mysqli_free_result($r);
			unset($totalprix);

		}
		// On affiche le total de la commande
		echo '<tr><th id="TableTotal" colspan="3">Total  </th> <th>',number_format($Total, 2, ',', ' '),'€</th></tr>',
			'</table>';
		
		// Si l'utilisateur est connecter
		if($connecter){
			
			$ID = $_SESSION['ID'];
			// On recherche les information sur l'utilisateur
			$sql = 'SELECT `cliNomPrenom`,`cliAdresse`,`cliCP`,`cliVille`,`cliPays` FROM clients WHERE cliID ='.$ID.'';
			$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
			$enr = mysqli_fetch_assoc($r);
			//Si l'utilisateur na pas renseigner d'adresse alors on luis demande de le faire
			if((empty($enr['cliAdresse']))&&(empty($enr['cliCP']))&&(empty($enr['cliVille']))&&(empty($enr['cliPays']))){
				echo '<div><p>Vous devez renseigner une adresse complette <form action="panier.php" method="POST"><input class="blocPanier" type="submit" value="Mon Compte" name="btnCompte"></form></p></div>';
			}
			// sinon on affiche l'adresse et la possiblilite de valider la commande
			else{
				echo '<div><p>Tous les produits seront livrés à l\'adresse :</p>',
					 '<p>',$enr['cliNomPrenom'],'<br>'.$enr['cliAdresse'].'<br>'.$enr['cliCP'].''.$enr['cliVille'].'<br>'.$enr['cliPays'].'<form action="panier.php" method="POST"><input class="blocPanier" type="submit" value="Valider" name="btnValide"></form></p>',
					 '<p>à l\'exception des article marqués d\'un <img src="../images/cadeau.png" title="Ceci est un cadeau"/>, qui eront livrés directement à leur bénéficiaire. </p></div>';
			}
		}
		//sinon on lui propose de ce connecter 
		else{
			echo '<p><form action="panier.php" method="POST"><input class="blocPanier" type="submit" value="Se connecter" name="btnconnect"></form></p>';
		}

		mysqli_close($bd);
	}
	//sinon on indique que le panier est vide
	else{
		echo '<h1>Votre panier est vide. </h1>'; 
	}
}

/**
* affichage du paquet cadeau si l'achat est un cadeau
*@param int 	$idDestinataire 	L'id du destinataire du cadeau
*@return String 	l'affichage du cadeau 
*/
function affiche_if_cadeau($idDestinataire){

	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	$idDestinataire = fd_db_protect($bd, $idDestinataire);
	//On recherche le nom et prenom du destinataire
	$sql = 'SELECT cliNomPrenom FROM clients WHERE cliID = '.$idDestinataire.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_row($r);
	mysqli_close($bd);

	//On affiche l'image du cadeau et le destinataire de le title.
	return '<img src="../images/cadeau.png" title="Offert a : '.$enr[0].' "/>';

}

/**
* Fonction permettant de faire diminuer la quantité d'un produit de 1
*/
function quantite_down(){
	//On recupere l'id du produit a diminuer
	$produit = $_GET['produit'];
	// on compte le nombre d'articles et les parcourt
	$nombreArticle = count($_SESSION['panier']['idProduit']);
	for($i = 0; $i < $nombreArticle; $i++){

		//Si c'est le bon produit, et que ce n'est pas un cadeau, et que la quantite est supperieur a 1
	    if (($_SESSION['panier']['idProduit'][$i] === $produit)&&($_SESSION['panier']['idDestinataire'][$i]==0)&&($_SESSION['panier']['qteProduit'][$i]>1)){
	        // Alors on diminue la quantite de 1
	        $_SESSION['panier']['qteProduit'][$i] += -1 ;
	    }

	}

}


/**
* Fonction permettant de supprimer un article
*/
function supprimerArticle(){
	  //On recupere l'id du produit a supprimer et le destinataire
   	  $produitsupp = $_GET['produit'];
   	  $destinataire = $_GET['destinataire'];
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['idProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['idDestinataire'] = array();

      // on compte le nombre d'articles et les parcourt
      $nombreArticle = count($_SESSION['panier']['idProduit']);
      for($i = 0; $i < $nombreArticle; $i++){
      	//Si l'article est different de celui a supprime et son destinataire aussi alors on l'enregistre fans le panier temporaire
         if (($_SESSION['panier']['idProduit'][$i] !== $produitsupp)|| ($_SESSION['panier']['idDestinataire'][$i] != $destinataire)){
            array_push( $tmp['idProduit'],$_SESSION['panier']['idProduit'][$i]);
            array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
            array_push( $tmp['idDestinataire'],$_SESSION['panier']['idDestinataire'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   
}

/**
* Fonction permettant d'enregistrer le panier, dans le cas ou la commande est valider
*/
function Passe_commande(){
	//On recupere l'id de client
	$ID = $_SESSION['ID'];
	//On recupere la date et l'heure courente
	$date = date(Ymd);
	$heure = date(Hi);
	$bd = bdConnecter();
	mysqli_set_charset($bd,"utf8");
	//On ajoute une commande avec l'id du client, la date et l'heure
	$sql = 'INSERT INTO `commandes`(`coIDClient`, `coDate`, `coHeure`) VALUES ('.$ID.','.$date.','.$heure.')';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	mysqli_free_result($r);

	//On récupere l'id de la commande que l'on vient d'ajouter
	$sql = 'SELECT coID FROM commandes WHERE coIDClient='.$ID.' AND coDate='.$date.' AND coHeure='.$heure.'';
	$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
	$enr = mysqli_fetch_assoc($r);
	$idcommade = $enr['coID'];
	mysqli_free_result($r);

	// on compte le nombre d'articles et les parcourt
	$nombreArticle = count($_SESSION['panier']['idProduit']);
	for($i = 0; $i < $nombreArticle; $i++){
		$produit = fd_db_protect($bd, $_SESSION['panier']['idProduit'][$i]);
		$quantite = fd_db_protect($bd, $_SESSION['panier']['qteProduit'][$i]);
		$destinataire = fd_db_protect($bd, $_SESSION['panier']['idDestinataire'][$i]);

		//On ajoute chaque articles dans compo_commande
		$sql = 'INSERT INTO `compo_commande`(`ccIDCommande`, `ccIDLivre`, `ccQuantite`, `ccIDDestinataire`) VALUES ('.$idcommade.','.$produit.','.$quantite.','.$destinataire.')';
		$r = mysqli_query($bd, $sql) or fd_bd_erreur($bd,$sql);
		$enr = mysqli_fetch_assoc($r);

	}
	mysqli_close($bd);
	//On supprime le contenue du panier
	unset($_SESSION['panier']);
	//On redirige l'utilisateur a la page commandes.php
	redirection('0', './commandes.php');
}



?>
