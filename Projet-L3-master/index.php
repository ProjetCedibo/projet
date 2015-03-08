<?php

session_start();

include_once 'php/bibli_generale.php';
include_once 'php/bibli_bd.php';
 
ob_start();
$page = 'Index';
afficheHeader($page);
afficheBarreHaute();
afficheBarreGauche($page);
afficheMiniBarre($page);
 
date_default_timezone_set("Europe/Paris");

bd_Connecter();
$sql = "SELECT COUNT(*) FROM User";
$res =mysql_query($sql);
$nb_user = mysql_result($res, 0);

$sql = "SELECT count(Distinct`AdminId`) FROM Admin";
$res =mysql_query($sql);
$nb_admin = mysql_result($res, 0);

$date = date("Y-m-d");
$sql = "SELECT count(Distinct `ConnectionUser`) FROM Connection WHERE `ConnectionDate`=\"$date\"";
$res =mysql_query($sql);
$nb_connectJour = mysql_result($res, 0);

$sql = "SELECT count(Distinct `ConnectionId`) FROM Connection";
$res =mysql_query($sql);
$nb_connect = mysql_result($res, 0);

mysql_close();
$zob=25345;
            echo       
                '<div class="row">',
                    
                    //Détails sur les utilisateurs
                    '<div class="col-lg-3 col-md-6">',
                        '<div class="panel panel-primary">',
                            '<div class="panel-heading">',
                                '<div class="row">',
                                    '<div class="col-xs-3">',
                                        '<i class="fa fa-tasks fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">',$nb_user ,'</div>',
                                        '<div>Nombre d\'utilisateurs</div>',
                                    '</div>',
                               ' </div>',
                            '</div>',
                           // '<a href="#">',
                                
                                '<div class="panel-footer">',
                                 //   '<span class="pull-left">Détails sur les utilisateurs</span>',
                                   // '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
                                    '<div class="clearfix"></div>',
                                '</div>',
                            '</a>',
                        '</div>',
                    '</div>',
                    
                    //Nombre d'administrateurs
                    '<div class="col-lg-3 col-md-6">',
                        '<div class="panel panel-green">',
                            '<div class="panel-heading">',
                                '<div class="row">',
                                    '<div class="col-xs-3">',
                                        '<i class="fa fa-tasks fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">',$nb_admin,'</div>',
                                        '<div>Nombre d\'administrateurs </div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                           // '<a href="#">',
                                '<div class="panel-footer">',
                                 //   '<span class="pull-left">Détails sur les administrateurs</span>',
                                   // '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
                                    '<div class="clearfix"></div>',
                                '</div>',
                            '</a>',
                        '</div>',
                    '</div>',
                    
                    //Connexions depuis le premier jour
                    '<div class="col-lg-3 col-md-6">',
                        '<div class="panel panel-yellow">',
                            '<div class="panel-heading">',
                                '<div class="row">',
                                    '<div class="col-xs-3">',
                                        '<i class="fa fa-tasks fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">',$nb_connect,'</div>',
                                        '<div>Connexions depuis le 1er jour</div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                               // '<a href="#">',
                                '<div class="panel-footer">',
                                   // '<span class="pull-left">Détails sur les connexions</span>',
                                   // '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
                                    '<div class="clearfix"></div>',
                                '</div>',
                            '</a>',
                        '</div>',
                    '</div>',
                    
                    //Connexions du jour
                    '<div class="col-lg-3 col-md-6">',
                        '<div class="panel panel-red">',
                            '<div class="panel-heading">',
                               ' <div class="row">',
                                    '<div class="col-xs-3">',
                                        '<i class="fa fa-tasks fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">',$nb_connectJour,'</div>',
                                        '<div>Connexions uniques du jour</div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                            //'<a href="#">',
                                '<div class="panel-footer">',
                                   // '<span class="pull-left">Détails sur les connexions du jour</span>',
                                   // '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
                                    '<div class="clearfix"></div>',
                                '</div>',
                            '</a>',
                        '</div>',
                    '</div>',
                '</div>',
                '<!-- /.row -->',

                //Graphique
                '<div class="row">',
                    '<div class="col-lg-12">',
                        '<div class="panel panel-default">',
                            '<div class="panel-heading">',
                                '<h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Connexions du jour</h3>',
                            '</div>',
                            '<div class="panel-body">',
                                '<div id="myfirstchart"></div>' ,
                            '</div>',
                        '</div>',
                    '</div>',
                '</div>',
                '<!-- /.row -->';
    //footerIndex()
?>
    </div> <!-- /.container-fluid -->

    </div> <!-- /#page-wrapper -->

    </div> <!-- /#wrapper -->


<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>



<script>
    $.post('php/getConnections.php', function(response) {
        new Morris.Area({
          element: 'myfirstchart',
          data: JSON.parse(response),
          xkey: 'ConnectionDate',
          ykeys: ['DailyConnection'],
          labels: ['Connexions du jour'],
          pointSize: 2,
          hideHover: 'auto',
          resize: true
        });
    });
</script>

    <!-- Flot Charts JavaScript -->
    <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/flot-data.js"></script>


    </body>,

</html>;

<?php
    ob_end_flush(); 
?>
