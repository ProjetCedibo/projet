<?php

session_start();

include 'bibli_generale.php';
include 'bibli_bookshop.php';
include 'bibli_bd.php';
include 'bibli_panier.php';

ob_start();

//On creer le panier si ce n'est pas deja fait
!isset($_SESSION['panier']) ? creationPanier() : NULL;
//Si le lien contien un GET['action'] alors on fait appel a what_action()
isset($_GET['action']) ? what_action() : NULL;
//Si l'utilisateur a cliquer sur le bouton 'se connecter' on le redirige sur la page de connexion
isset($_POST['btnconnect']) ? redirection('0', './connexion.php') : NULL;
//Si l'utilisateur a cliquer sur le bouton 'mon compte' on le redirige sur la page du compte
isset($_POST['btnCompte']) ? redirection('0', './compte.php') : NULL;
//Si l'utilisateur a cliquer sur le bouton 'Valider' alors on fait appel a Passe_commande()
isset($_POST['btnValide']) ? Passe_commande() : NULL;


$connecte = ifconnect();

fd_html_debut('BookShop | Panier', '../styles/bookshop.css');

fd_bookshop_entete($connecte,'../');

//On affiche le panier
affichePanier($connecte);

fd_bookshop_pied('./');

fd_html_fin();

ob_end_flush();

?>