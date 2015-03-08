<?php

session_start();

include 'php/bibli_generale.php';

ob_start();
$page = 'Statistiques';
afficheHeader($page);
afficheBarreHaute();
afficheBarreGauche($page);
afficheMiniBarre($page); 

?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> APPLICATION : Connexions par jour </h3>
                            </div>
                            <div class="panel-body">
                                <div id="myfirstchart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> NOTIFICATIONS : Envoi par type </h3>
                            </div>
                            <div class="panel-body">
                                <div id="mysecondchart"></div>
                                <!--<div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>-->
                            </div>
                        </div>
                    </div>
                   
                   <div class="col-lg-4">
                       <!-- <div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Line Graph Example with Tooltips</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-line-chart"></div>
                                <div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div> -->
                    </div> 

                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> AGENDA : Nombre d'entrées par type </h3>
                            </div>
                            <div class="panel-body">
                                <div id="mythirdchart"></div>
                                <!--<div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                 <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> AGENDA : Nombre d'entrées par jour </h3>
                            </div>
                            <div class="panel-body">
                                <div id="myfourthchart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

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

    $.post('php/getNotifications.php', function(response2) {
        new Morris.Donut({
        element: 'mysecondchart',
        data: JSON.parse(response2),
        resize: true
        });
    });

    $.post('php/getAgendaType.php', function(response3) {
       //alert(response3);
       new Morris.Bar({
            element: 'mythirdchart',
            data: JSON.parse(response3),
            xkey: ['label'],
            ykeys: ['DailyAgenda'],
            labels: ['Nombre d\'entrées'],
            barRatio: 0.4,
            xLabelAngle: 35,
            hideHover: 'auto',
            resize: true
        });
    });




    $.post('php/getAgendaInfos.php', function(response4) {
        //alert(response3);
        new Morris.Line({
          element: 'myfourthchart',
          data: JSON.parse(response4),
          xkey: 'AgendaDate',
          ykeys: ['DailyNews'],
          labels: ['Nombre d\'événements'],
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
//footer();
ob_end_flush();

?>