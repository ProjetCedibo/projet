<?php



/**
*test si l'on est connecter ou pas.
* @return boolean 	Vrai si l'utilisateur est connecter, faux sinon
*/
function ifconnect(){
	if(isset($_SESSION['ID'])){
		return true;
	}
	else{
		return false;
	}
}


/**
*	Redirection.
* @param int 	$sec 	le nombre de secondes a attendre avant la redirection
* @param string 	$lien 	la pages sur laquel on effectue la redirection
*/
function redirection ($sec, $lien) {
	echo '<META HTTP-EQUIV="Refresh" CONTENT="',$sec,';URL= ',$lien,'">';
}


// fonctions début + menu 

function afficheHeader($titre) {

echo

'<!DOCTYPE html>', 
'<html lang="fr">',


'<head>',

    '<meta charset="utf-8">',
    '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
    '<meta name="viewport" content="width=device-width, initial-scale=1">',
    '<meta name="description" content="">',
    '<meta name="author" content="">',

    '<title>' .$titre. '</title>',

    '<!-- Bootstrap Core CSS -->',
    '<link href="css/bootstrap.min.css" rel="stylesheet">',

    '<!-- Custom CSS -->',
    '<link href="css/sb-admin.css" rel="stylesheet">',

    '<!-- Morris Charts CSS -->',
    '<link href="css/plugins/morris.css" rel="stylesheet">',

    '<!-- Custom Fonts -->',
    '<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">',

    //'<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->',
    //'<!-- WARNING: Respond.js doesnt work if you view the page via file: -->',
    '<!--[if lt IE 9]>',
        '<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>',
        '<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>',
    '<![endif]-->',

'</head>';
}

function afficheHeaderAgenda($titre) {

echo

'<!DOCTYPE html>', 
'<html lang="fr">',


'<head>',

    '<meta charset="utf-8">',
    '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
    '<meta name="viewport" content="width=device-width, initial-scale=1">',
    '<meta name="description" content="">',
    '<meta name="author" content="">',

    '<title>' .$titre. '</title>',

    '<!-- Bootstrap Core CSS -->',
    '<link href="css/bootstrap.min.css" rel="stylesheet">',

    '<!-- Custom CSS -->',
    '<link href="css/sb-admin.css" rel="stylesheet">',

    '<!-- Morris Charts CSS -->',
    '<link href="css/plugins/morris.css" rel="stylesheet">',

    '<!-- Custom Fonts -->',
    '<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">',

    //'<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->',
    //'<!-- WARNING: Respond.js doesnt work if you view the page via file: -->',
    '<!--[if lt IE 9]>',
        '<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>',
        '<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>',
    '<![endif]-->',

'<style>',

     '.ds_box {',
        'background-color: #FFF;',
        'border: 1px solid #000;',
        'position: absolute;',
        'z-index: 32767;',
    '}', 

     '.ds_tbl {',
        'background-color: #FFF;',
    '}', 

   
     '.ds_head {',
        'background-color: #333;',
        'color: #FFF;',
        'font-family: Arial, Helvetica, sans-serif;',
        'font-size: 13px;',
        'font-weight: bold;',
        'text-align: center;',
        'letter-spacing: 2px;',
    '}', 

    '.ds_subhead {',
        'background-color: #CCC;',
        'color: #000;',
        'font-size: 12px;',
        'font-weight: bold;',
        'text-align: center;',
        'font-family: Arial, Helvetica, sans-serif;',
        'width: 32px;',
    '}', 

    '.ds_cell {',
        'background-color: #EEE;',
        'color: #000;',
        'font-size: 13px;',
        'text-align: center;',
        'font-family: Arial, Helvetica, sans-serif;',
        'padding: 5px;',
        'cursor: pointer;',
    '}', 

    '.ds_cell:hover {',
        'background-color: #F3F3F3;', 
    '}', 

    '</style>',


'</head>';


}






function afficheBarreHaute () {
    echo 
    
    '<body>',

    '<div id="wrapper">',

        '<!-- Navigation -->',
        '<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">',
            //'<!-- Brand and toggle get grouped for better mobile display -->',
            '<div class="navbar-header">',
                '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">',
                    '<span class="sr-only">Toggle navigation</span>',
                    '<span class="icon-bar"></span>',
                    '<span class="icon-bar"></span>',
                    '<span class="icon-bar"></span>',
               '</button>',
                //'<a class="navbar-brand" href="index.php">Retour à l\'index</a>',
            '</div>',
           '<!-- Top Menu Items -->',
            '<ul class="nav navbar-right top-nav">',
               
               /*' <li class="dropdown">',
                   
                   // Affichage de l'enveloppe au cas où un système de mails est mis en place
                   // '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>',
                   '<ul class="dropdown-menu message-dropdown">',
                        '<li class="message-preview">',
                           ' <a href="#">',
                                '<div class="media">',
                                   ' <span class="pull-left">',
                                        '<img class="media-object" src="http://placehold.it/50x50" alt="">',
                                   ' </span>',
                                   ' <div class="media-body">',
                                       '<h5 class="media-heading"><strong>John Smith</strong>',
                                        '</h5>',
                                        '<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>',
                                        '<p>Lorem ipsum dolor sit amet, consectetur...</p>',
                                   ' </div>',
                                '</div>',
                           ' </a>',
                        '</li>',
                        '<li class="message-preview">',
                            '<a href="#">',
                                '<div class="media">',
                                    '<span class="pull-left">',
                                        '<img class="media-object" src="http://placehold.it/50x50" alt="">',
                                    '</span>',
                                    '<div class="media-body">',
                                        '<h5 class="media-heading"><strong>John Smith</strong>',
                                        '</h5>',
                                        '<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>',
                                       ' <p>Lorem ipsum dolor sit amet, consectetur...</p>',
                                   ' </div>',
                                '</div>',
                            '</a>',
                        '</li>',
                        '<li class="message-preview">',
                            '<a href="#">',
                                '<div class="media">',
                                    '<span class="pull-left">',
                                        '<img class="media-object" src="http://placehold.it/50x50" alt="">',
                                   ' </span>',
                                    '<div class="media-body">',
                                        '<h5 class="media-heading"><strong>John Smith</strong>',
                                        '</h5>',
                                        '<p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>',
                                        '<p>Lorem ipsum dolor sit amet, consectetur...</p>',
                                    '</div>',
                                '</div>',
                            '</a>',
                        '</li>',
                        '<li class="message-footer">',
                            '<a href="#">Read All New Messages</a>',
                        '</li>',
                    '</ul>', 
                '</li>',
                
                '<li class="dropdown">',
                   // Affichage de la cloche au cas où un système de notifs est mis en place
                 '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>',
                    '<ul class="dropdown-menu alert-dropdown">',
                        '<li>',
                            '<a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>',
                        '</li>',
                        '<li>',
                            '<a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>',
                        '</li>',
                        '<li>',
                            '<a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>',
                        '</li>',
                        '<li>',
                            '<a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>',
                        '</li>',
                        '<li>',
                            '<a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>',
                        '</li>',
                        '<li>',
                            '<a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>',
                        '</li>',
                        '<li class="divider"></li>',
                        '<li>',
                            '<a href="#">View All</a>',
                        '</li>',
                    '</ul>',
                '</li>', */
                
                //Affichage du nom de l'admin en cours
                '<li class="dropdown">',
                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin actuel <b class="caret"></b></a>',
                    '<ul class="dropdown-menu">',
                        '<li>',
                            '<a href="#"><i class="fa fa-fw fa-user"></i> Profil</a>',
                        '</li>',
                        '<li>',
                            '<a href="#"><i class="fa fa-fw fa-envelope"></i> Ajouter un admin </a>',
                        '</li>',
                        '<li>',
                            '<a href="#"><i class="fa fa-fw fa-gear"></i> Paramètres</a>',
                        '</li>',
                        '<li class="divider"></li>',
                        '<li>',
                            '<a href="#"><i class="fa fa-fw fa-power-off"></i> Déconnexion</a>',
                        '</li>',
                    '</ul>',
                '</li>',
            '</ul>';

}

function afficheBarreGauche($page) {

echo
            '<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->',
            '<div class="collapse navbar-collapse navbar-ex1-collapse">',
                '<ul class="nav navbar-nav side-nav">';

//page index          
if ($page == 'Index') {
    echo 
        '<li class="active">',
        '<a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Tableau de bord </a>',
        '</li>';
}

else {
                    
    echo 
        '<li>',
        '<a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Tableau de bord </a>',
        '</li>';
        }
                    
//page statistiques
if ($page == 'Statistiques') {
        echo 
             '<li class="active">',
             '<a href="statistiques.php"><i class="fa fa-fw fa-bar-chart-o"></i> Statistiques</a>',
            '</li>';
}

else {
        echo 
            '<li>',
            '<a href="statistiques.php"><i class="fa fa-fw fa-bar-chart-o"></i> Statistiques</a>',
            '</li>';
}


//page Agenda
if ($page == 'Agenda') {        
        echo
            '<li class="active">',
                '<a href="agenda.php"><i class="fa fa-fw fa-table"></i> Agenda </a>',
            '</li>';
}

else {
        echo 
             '<li>',
                    ' <a href="agenda.php"><i class="fa fa-fw fa-table"></i> Agenda </a>',
             '</li>';
}


//page notifications
if ($page == 'Notifications') {        
        echo
             '<li class="active">',
                    ' <a href="notifications.php"><i class="fa fa-fw fa-edit"></i> Notifications </a>',
             '</li>';
}

else {
        echo 
             '<li>',
                    ' <a href="notifications.php"><i class="fa fa-fw fa-edit"></i> Notifications </a>',
             '</li>';
}







echo                   
        '</ul>',
   ' </div>',
    '<!-- /.navbar-collapse -->',
'</nav>';

}

function afficheMiniBarre($page) {
    
    //page Index
    if ($page == 'Index') {
       
       echo
            
            '<div id="page-wrapper">',

                '<div class="container-fluid">',

                   '<div class="row">',
                        
                        '<div class="col-lg-12">',

                            '<h1 class="page-header">',
                            
                            'Administration <small> Vue générale </small>',
                            
                            '</h1>',
                   
                            '<ol class="breadcrumb">',

                                '<li class="active">',
                                    '<i class="fa fa-dashboard"></i> En bref',
                                '</li>',
                            
                            '</ol>',
                             //   }
                        '</div>',
                '</div>'; 
                //<!-- /.row -->
    }

    //page Statistiques
    if ($page == 'Statistiques') {
           
           echo
                
                '<div id="page-wrapper">',

                    '<div class="container-fluid">',

                       '<div class="row">',
                            
                            '<div class="col-lg-12">',
                            
                                '<h1 class="page-header">',
                                
                                'Statistiques',
                                
                                '</h1>',
                       
                                '<ol class="breadcrumb">',

                                    '<li class="active">',
                                        '<i class="fa fa-bar-chart"></i> Page de statistiques',
                                    '</li>',
                                
                                '</ol>',
                     
                        '</div>',
                    
                    '</div>'; 
                    //<!-- /.row -->
    }

    //page Agenda
    if ($page == 'Agenda') {
       
       echo
            
            '<div id="page-wrapper">',

                '<div class="container-fluid">',

                   '<div class="row">',
                        
                        '<div class="col-lg-12">',
                        
                            '<h1 class="page-header">',
                            
                            'Agenda',
                            
                            '</h1>',
                   
                            '<ol class="breadcrumb">',

                                '<li class="active">',
                                    '<i class="fa fa-table"></i> Page de création de l\'agenda',
                                '</li>',
                            
                            '</ol>',
                 
                    '</div>',
                
                '</div>'; 
                //<!-- /.row -->
    }





    //page Notifications
    if ($page == 'Notifications') {
       
       echo
            
            '<div id="page-wrapper">',

                '<div class="container-fluid">',

                   '<div class="row">',
                        
                        '<div class="col-lg-12">',
                        
                            '<h1 class="page-header">',
                            
                            'Notifications',
                            
                            '</h1>',
                   
                            '<ol class="breadcrumb">',

                                '<li class="active">',
                                    '<i class="fa fa-edit"></i> Page d\'envoi des notifications',
                                '</li>',
                            
                            '</ol>',
                 
                    '</div>',
                
                '</div>'; 
                //<!-- /.row -->
    }
}










function footer() {
echo
	
    '</div>',
    //'<!-- /.container-fluid -->',

    '</div>',
    //'<!-- /#page-wrapper -->',

    '</div>',
    //'<!-- /#wrapper -->',

    '<!-- jQuery -->',
    '<script src="js/jquery.js"></script>',
    
    '<!-- Bootstrap Core JavaScript -->',
    '<script src="js/bootstrap.min.js"></script>',
    
    '<!-- Morris Charts JavaScript -->',
    '<script src="js/plugins/morris/raphael.min.js"></script>',
    '<script src="js/plugins/morris/morris.min.js"></script>',
    '<script src="js/plugins/morris/morris-data.js"></script>',

    '<!-- Flot Charts JavaScript -->',
    '<!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->',
    '<script src="js/plugins/flot/jquery.flot.js"></script>',
    '<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>',
    '<script src="js/plugins/flot/jquery.flot.resize.js"></script>',
    '<script src="js/plugins/flot/jquery.flot.pie.js"></script>',
    '<script src="js/plugins/flot/flot-data.js"></script>',


	'</body>',

'</html>';

}



















?>