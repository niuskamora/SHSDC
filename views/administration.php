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
            <div class="container header-top-top hidden-phone">
                <img alt="" src="../images/header-top-top-left.png" class="pull-left">
                <img alt="" src="../images/header-top-top-right.png" class="pull-right">
            </div>
            <div class="header-top">
                <div class="container">
                    <img alt="" src="../images/header-top-left.png" class="pull-left">
                    <div class="pull-right">

                    </div>
                </div>
                <div class="filter-area">
                    <div class="container">
                        <span lang="es">&nbsp;</span></div>
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
                            <li>   
                                <a href="../pages/inbox.php">Atrás</a>
                            </li> 
                            <li>   
                                <a href="../pages/misguidance_report.php">Repotar Extravió</a>
                            </li>
                            <li>   
                                <a href="../pages/assign_headquarters.php">Buzón Adicional</a>
                            </li>
                            <li>   
                                <a href="../pages/create_headquarters.php">Crear Sede</a>
                            </li>
                            <li>   
                                <a href="../pages/create_area.php">Crear Área de Trabajo</a>
                            </li>
                            <li>   
                                <a href="../pages/disable_area.php">Deshabilitar Area</a>
                            </li>
                            <li>   
                                <a href="../pages/user_role.php">Editar Rol</a>
                            </li>
                            <li>   
                                <a href="../pages/create_provider.php">Crear Proveedor</a>
                            </li>                            
                            <li>   
                                <a href="../pages/reports_valise.php">Estadísticas De Valijas</a>
                            </li>                            
                            <li>   
                                <a href="../pages/reports_package.php">Estadísticas Paquetes</a>
                            </li>
                            <li>   
                                <a href="../pages/vacuum_bitacora.php">Bitácora</a>
                            </li>
                            <li>   
                                <a href="../pages/level_time.php">Editar Tiempo en Área</a>
                            </li>
                            <?php
                            $i = 0;
                            if ($_SESSION["Usuario"]->return->tipousu == "2") {
                                ?>   
                                <li>   
                                    <a href="../pages/edit_type_user.php">Editar Tipo De Usuario</a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja"><strong><h2> Bienvenido </h2></strong>
                        </div>
                    </div>	  

                </div>
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
