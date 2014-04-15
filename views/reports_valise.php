<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Seguros Horizonte | HorizonLine</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- javascript -->
        <script type='text/javascript' src="../js/jquery-2.0.2.js"></script>
        <script type='text/javascript' src="../js/bootstrap.js"></script>
        <script type='text/javascript' src="../js/bootstrap-transition.js"></script>
        <script type='text/javascript' src="../js/bootstrap-tooltip.js"></script>
        <script type='text/javascript' src="../js/modernizr.min.js"></script>
<!--<script type='text/javascript' src="../js/togglesidebar.js"></script>-->	
        <script type='text/javascript' src="../js/custom.js"></script>
        <script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>
        <!-- javascript para el funcionamiento del calendario -->
        <link rel="stylesheet" type="text/css" href="../js/ui-lightness/jquery-ui-1.10.3.custom.css" media="all" />
        <script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.js" ></script> 
        <script type="text/javascript" src="../js/calendarioValidado.js" ></script>

        <!-- styles -->
        <link rel="shortcut icon" href="../images/faviconsh.ico">


        <link rel="shortcut icon" href="../images/faviconsh.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
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
                <div class="row-fluid">
                    <div class="span2">
                        <ul class="nav nav-pills nav-stacked">
                            <li> <a href="../pages/inbox.php">Atrás</a> <li>
                        </ul>
                    </div>

                    <div class="span10" align="center">
                        <div class="tab-content" id="lista" align="center">
                            <h2> <strong>Consultar Valijas</strong> </h2>
                            <br>
                            <form class="form-Dvalija" method="post" id="fval">
                                <div class="span12">
                                    <div class="span6" align="center">
                                        <strong>Seleccionar Reporte</strong>
                                        <br>
                                        <select name='reporte' id='reporte' required  title='Seleccione la Sede'>
                                            <option value='' style='display:none'>Seleccionar:</option>
                                            <option value='1'>Total de Valijas Enviadas</option>
                                            <option value='2'>Total de Valijas Recibidas</option>
                                            <option value='3'>Total de Valijas con Errores</option>
                                            <option value='4'>Total de Valijas Anuladas</option>
                                        </select>
                                        <br>
                                    </div>                                	
                                    <div class="span6" align="center">
                                        <strong>Seleccionar Sede</strong>
                                        <br>
                                        <select name='osede' id='osede' required  title='Seleccione la Sede'>
                                            <option value='' style='display:none'>Seleccionar:</option>
                                            <?php
                                            if ($sedes > 1) {
                                                $i = 0;
                                                while ($sedes > $i) {
                                                    echo "<option value='" . $resultadoSedes->return[$i]->idsed . "' >" . $resultadoSedes->return[$i]->nombresed . "</option>";
                                                    $i++;
                                                }
                                            } else {
                                                echo "<option value='" . $resultadoProveedor->return->idsed . "' >" . $resultadoProveedor->return->nombresed . "</option>";
                                            }
											if ($_SESSION["Usuario"]->return->tipousu == "2") {
                                            ?>
                                            	<option value='0'>Todas las Sedes</option>
                                            <?php } ?>
                                        </select>
                                        <br>
                                    </div>
                                </div>
                                <h4>&nbsp;</h4>
                                <h4 align="center">Rango de Fechas <br>_____________________________________________________________</h4>
                                <br>
                                <div class="span3"></div>
                                <div class="span6" align="center">
                                    <div class="span1"></div>
                                    <div class="span2">
                                        <strong>Día</strong> <input id="opcion" name="opcion" value="dia" type="radio" checked>
                                    </div>
                                    <div class="span1"></div>
                                    <div class="span2">
                                        <strong>Mes</strong> <input id="opcion" name="opcion" value="mes" type="radio">
                                    </div>
                                    <div class="span1"></div>
                                    <div class="span2">
                                        <strong>Año</strong> <input id="opcion" name="opcion" value="ano" type="radio">
                                    </div>
                                </div>
                                <div class="span2"></div>
                                <br>
                                <br>
                                <div class="span2"></div>
                                <div class="span8">
                                    <div class="span5">
                                        <strong>Fecha de Inicio: </strong>
                                        <input type="text" id="datepicker" name="datepicker" autocomplete="off" style="width:100px" title="Seleccione la Fecha de Inicio" required/>
                                    </div>
                                    <div class="span1"></div>
                                    <div class="span5">
                                        <strong>Fecha de Fin: </strong>
                                        <input type="text" id="datepickerf" name="datepickerf" autocomplete="off" style="width:100px" title="Seleccione la Fecha de Fin" required/>
                                    </div>
                                </div>
                                <div class="span2"></div>
                                <br>
                                <div align="center" class="span11">
                                    <button class="btn" type="submit" id="consultar" name="consultar">Consultar</button>
                                </div>
                            </form>                    
                        </div>
                    </div>
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
    </body>
</html>