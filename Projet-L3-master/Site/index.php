<?php

session_start();

include 'php/bibli_generale.php';
 
ob_start();
$page = 'Index';
afficheHeader($page);
afficheBarreHaute();
afficheBarreGauche($page);
afficheMiniBarre($page);
 
        
            echo   
                '<div class="row">',
                    
                    //Détails sur les utilisateurs
                    '<div class="col-lg-3 col-md-6">',
                        '<div class="panel panel-primary">',
                            '<div class="panel-heading">',
                                '<div class="row">',
                                    '<div class="col-xs-3">',
                                        '<i class="fa fa-comments fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">WW</div>',
                                        '<div>Nombre d\'utilisateurs</div>',
                                    '</div>',
                               ' </div>',
                            '</div>',
                            '<a href="#">',
                                
                                '<div class="panel-footer">',
                                    '<span class="pull-left">Détails sur les utilisateurs</span>',
                                    '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
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
                                        '<div class="huge">XX</div>',
                                        '<div>Nombre d\'administrateurs </div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                            '<a href="#">',
                                '<div class="panel-footer">',
                                    '<span class="pull-left">Détails sur les administrateurs</span>',
                                    '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
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
                                        '<i class="fa fa-shopping-cart fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">YY</div>',
                                        '<div>Connexions depuis le premier jour</div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                                '<a href="#">',
                                '<div class="panel-footer">',
                                    '<span class="pull-left">Détails sur les connexions</span>',
                                    '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
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
                                        '<i class="fa fa-support fa-5x"></i>',
                                    '</div>',
                                    '<div class="col-xs-9 text-right">',
                                        '<div class="huge">ZZ</div>',
                                        '<div>Connexions du jour</div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                            '<a href="#">',
                                '<div class="panel-footer">',
                                    '<span class="pull-left">Détails sur les connexions du jour</span>',
                                    '<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>',
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
                                '<div id="morris-area-chart"></div>',
                            '</div>',
                        '</div>',
                    '</div>',
                '</div>',
                '<!-- /.row -->'; 
?>

<?php
                //Ensemble de tableaux
                /* <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Donut Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                                <div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                  <!-- <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Order Date</th>
                                                <th>Order Time</th>
                                                <th>Amount (USD)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>3326</td>
                                                <td>10/21/2013</td>
                                                <td>3:29 PM</td>
                                                <td>$321.33</td>
                                            </tr>
                                            <tr>
                                                <td>3325</td>
                                                <td>10/21/2013</td>
                                                <td>3:20 PM</td>
                                                <td>$234.34</td>
                                            </tr>
                                            <tr>
                                                <td>3324</td>
                                                <td>10/21/2013</td>
                                                <td>3:03 PM</td>
                                                <td>$724.17</td>
                                            </tr>
                                            <tr>
                                                <td>3323</td>
                                                <td>10/21/2013</td>
                                                <td>3:00 PM</td>
                                                <td>$23.71</td>
                                            </tr>
                                            <tr>
                                                <td>3322</td>
                                                <td>10/21/2013</td>
                                                <td>2:49 PM</td>
                                                <td>$8345.23</td>
                                            </tr>
                                            <tr>
                                                <td>3321</td>
                                                <td>10/21/2013</td>
                                                <td>2:23 PM</td>
                                                <td>$245.12</td>
                                            </tr>
                                            <tr>
                                                <td>3320</td>
                                                <td>10/21/2013</td>
                                                <td>2:15 PM</td>
                                                <td>$5663.54</td>
                                            </tr>
                                            <tr>
                                                <td>3319</td>
                                                <td>10/21/2013</td>
                                                <td>2:13 PM</td>
                                                <td>$943.45</td>
                                            </tr>
                                        </tbody>
                                    </table> -->
                                </div>
                                <div class="text-right">
                                    <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- /.row --> */

            

footer();
ob_end_flush(); 
?>
