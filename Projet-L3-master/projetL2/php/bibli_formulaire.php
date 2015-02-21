<?php

/*********************************************************
 *        Bibliothèque de fonctions génériques           *
 *********************************************************/

//---------------------------------------------------------------
// Définition des constantes liées à la configuration PHP
//---------------------------------------------------------------
//define('FD_QUOTES_GPC', (get_magic_quotes_gpc() == 1) ? TRUE : FALSE);
//---------------------------------------------------------------
// Définition des types de zones de saisies
//---------------------------------------------------------------
define('FD_Z_TEXT', 'text');
define('FD_Z_PASSWORD', 'password');
define('FD_Z_SUBMIT', 'submit');
define('FD_Z_HIDDEN', 'hidden');




/** 
 *  Affichage propre du texte (protection des entités HTML).
 */
function fd_texteOK($text) {
    return htmlentities($text, ENT_COMPAT | ENT_QUOTES, 'ISO-8859-1');
}


//_______________________________________________________________
/**
* Redirection vers une url
*
* @param string     $url    l'url vers laquelle on redirige
*/
function fd_redirection($url) {
    header("Location: {$url}");
    exit();
}

//_______________________________________________________________
/**
* Vérifier une adresse e-mail en conformité avec la norme RFC 2822(ou a peu prés (:-))
* -- Nota : fonction reprise du tutoriel PHP --
*
* @param string     $Mail   L'adresse email à tester
*
* @return boolean   Vrai si l'adresse est valide, faux sinon
*/
function fp_TestMail($Mail) {

    $ExpReg = '/^[^@]{1,64}@[^@]{1,255}$/';
    if (! preg_match($ExpReg, $Mail)) {
        return false;
    }

    $Parties = explode('@', $Mail);

    $ExpReg = '/';
    $ExpReg .= "^[A-Za-z0-9!#$%&'*+-\/=?^_`{|}~][A-Za-z0-9!#$%&'*+-\/=?^_`{|}~\.]{0,62}$";
    $ExpReg .= '|';
    $ExpReg .= '^"[^(\\|")]{1,62}"$';
    $ExpReg .= '/';
    if (! preg_match($ExpReg, $Parties[0])) {
        echo "<hr>$Mail n'est pas une adresse valide (partie locale)";
        return false;
    }

    $Domaines = explode('.', $Parties[1]);

    // Cette v�rification d'adresse IP est un peu faible ...
    if (preg_match('/^\d{1,3}$/', $Domaines[0])) {
        if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/', $Parties[1])) {
            echo "<hr>$Mail est une adress valide";
        } else {
            echo "<hr>$Mail n'est pas une adresse valide (IP)";
        }
        return false;
    }

    if (preg_match('/^\[\d{1,3}$/', $Domaines[0])) {
        if (preg_match('/^\[(\d{1,3}\.){3}\d{1,3}\]$/', $Domaines)) {
            echo "<hr>$Mail est une adress valide";
        } else {
            echo "<hr>$Mail n'est pas une adresse valide (IP [])";
        }
        return false;
    }

    if (count($Domaines) < 2) {
        return false;
    }

    $ExpReg = '/^[A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9]$|^[A-Za-z0-9]+$/';
    foreach ($Domaines as $d) {
        if (! preg_match($ExpReg, $d)) {
            return false;
        }
    }

    return true;
}





//_______________________________________________________________
/**
* Génére le code HTML d'une ligne de tableau d'un formulaire.
*
* Les formulaires sont mis en page avec un tableau : 1 ligne par
* zone de saisie, avec dans la collone de gauche le lable et dans
* la colonne de droite la zone de saisie.
*
* @param string     $gauche     Contenu de la colonne de gauche
* @param string     $droite     Contenu de la colonne de droite
*
* @return string    Le code HTML de la ligne du tableau
*/
function fd_form_ligne($gauche, $droite) {
    $gauche = fd_texteOK($gauche);
    return "<tr><td class='tdGauche'>{$gauche}</td><td>{$droite}</td></tr>";
}

//_______________________________________________________________
/**
* Génére le code d'une zone input de formulaire (type text, password ou button)
*
* @param string     $type   le type de l'input (constante FD_Z_xxx)
* @param string     $name   Le nom de l'input
* @param String     $value  La valeur par défaut
* @param integer    $size   La taille de l'input
*
* @return string    Le code HTML de la zone de formulaire
*/
function fd_form_input($type, $name, $value, $size=0) {
   $value = fd_texteOK($value);
   $size = ($size == 0) ? '' : "size='{$size}'";
   return "<input type='{$type}' name='{$name}' {$size} value=\"{$value}\">";
}

//_______________________________________________________________
/**
* Génére le code pour un ensemble de trois zones de sélection
* représentant uen date : jours, mois et années
*
* @param string     $nom    Préfixe pour les noms des zones
* @param integer    $jour   Le jour sélectionné par défaut
* @param integer    $mois   Le mois sélectionné par défaut
* @param integer    $annee  l'année sélectionnée par défaut
*
* @return string    Le code HTML des 3 zones de liste
*/
function fd_form_date($nom, $jour = 0, $mois = 0, $annee = 0) {
    if ($jour == 0) {
        $jour = date('j');
    }
    if ($mois == 0) {
        $mois = date('n');
    }
    if ($annee == 0) {
        $annee = date('Y');
    }

    $H = "<select name='{$nom}_j'>";
    for ($i = 1; $i < 32; $i++) {
        $selected = ($i == $jour) ? ' selected' : '';
        $H .= "<option value='{$i}'{$selected}>{$i}";
    }
    $H .= '</select>';

    $libMois = array('', 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin',
                'juillet', 'a&ocirc;ut', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');

    $H .= "<select name='{$nom}_m'>";
    for ($i = 1; $i < 13; $i++) {
        $selected = ($i == $mois) ? ' selected' : '';
        $H .= "<option value='{$i}'{$selected}>{$libMois[$i]}";
    }
    $H .= '</select>';

    $i = date('Y');
    $iMin = $i - 99;
    $H .= "<select name='{$nom}_a'>";
    for (; $i >= $iMin; $i--) {
        $selected = ($i == $annee) ? ' selected' : '';
        $H .= "<option value='{$i}'{$selected}>{$i}";
    }
    $H .= '</select>';

       return $H;
}


?>
