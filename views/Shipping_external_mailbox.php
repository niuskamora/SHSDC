<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Seguros Horizonte | HorizonLine</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- javascript -->
        <script type='text/javascript' src="../js/jquery-1.9.1.js"></script>
        <script type='text/javascript' src="../js/bootstrap.js"></script>
        <script type='text/javascript' src="../js/bootstrap-transition.js"></script>
        <script type='text/javascript' src="../js/bootstrap-tooltip.js"></script>
        <script type='text/javascript' src="../js/modernizr.min.js"></script>
        <!--<script type='text/javascript' src="../js/togglesidebar.js"></script>-->
        <script type='text/javascript' src="../js/custom.js"></script>
        <script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>

        <!-- styles -->
        <link rel="shortcut icon" href="../images/faviconsh.ico">


        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/bootstrap-combined.min.css" rel="stylesheet">
        <link href="../css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/jquery.fancybox.css" rel="stylesheet">
        <!-- [if IE 7]>
                  <link rel="stylesheet" href="font-awesome/css/font-awesome-ie7.min.css">
                <![endif]-->

        <!--Load fontAwesome css-->
        <link rel="stylesheet" type="text/css" media="all" href="../font-awesome/css/font-awesome.min.css">
        <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- [if IE 7]>
                <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
                <![endif]-->
        <link href="../css/footable-0.1.css" rel="stylesheet" type="text/css" />
        <link href="../css/footable.sortable-0.1.css" rel="stylesheet" type="text/css" />
        <link href="../css/footable.paginate.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="appBg">
        <div id="header">
            <div class="container header-top-top hidden-phone"> <img alt="" src="../images/header-top-top-left.png" class="pull-left"> <img alt="" src="../images/header-top-top-right.png" class="pull-right"> </div>
            <div class="header-top">
                <div class="container"> <img alt="" src="../images/header-top-left.png" class="pull-left">
                    <div class="pull-right"> </div>
                </div>
                <div class="filter-area">
                    <div class="container"> <span lang="es">&nbsp;</span></div>
                </div>
            </div>
        </div>
        <div id="middle">
            <div class="container app-container">
                <?php
                Menu($SedeRol);
                ?>


                <!--Caso pantalla uno-->
                <div class="row-fluid">
                    <div class="span2">

                        <ul class="nav nav-pills nav-stacked">


                            <li> <a href="../pages/inbox.php"> Atrás</a> </li>


                            ?>
                        </ul>
                        </form>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja"><strong>
                                <h2> Bienvenido </h2>
                            </strong> </div>
                    </div>
                </div>

                <!-- /container -->
                <div id="footer" class="container"> </div>
                <script>
                    function Bandeja(idban) {
                        var parametros = {
                            "idban": idban
                        };
                        $.ajax({
                            type: "POST",
                            url: "../ajax/bandejas.php",
                            data: parametros,
                            dataType: "text",
                            success: function(response) {
                                $("#bandeja").html(response);
                            }
                        });
                    }

                    function Confirmar(idpaq) {
                        var parametros = {
                            "idpaq": idpaq
                        };
                        $.ajax({
                            type: "POST",
                            url: "../ajax/packeges_confirm.php",
                            data: parametros,
                            dataType: "text",
                            success: function(response) {
                                $("#footer").html(response);
                            }
                        });
                    }

                </script> 
                <script>
                    window.onload = function() {
                        killerSession();
                    }

                    function killerSession() {
                        setTimeout("window.open('../recursos/cerrarsesion.php','_top');", 300000);
                    }

                </script> 
                <script src="../js/footable.js" type="text/javascript"></script> 
                <script src="../js/footable.paginate.js" type="text/javascript"></script> 
                <script src="../js/footable.sortable.js" type="text/javascript"></script> 
                <script type="text/javascript">
                    $(function() {
                        $('table').footable();
                    });
                </script>
                </body>
                </html>
