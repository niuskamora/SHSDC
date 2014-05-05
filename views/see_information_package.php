<?php
if ($idPaquete == "" || $usuario == "") {
    echo '<script language="javascript"> window.location = "../pages/inbox.php"; </script>';
}
?>
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
                            <li>   
                                <a href="../pages/inbox.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="span10" align="center">
                        <div class="tab-content" id="lista" align="center">
                            <?php
                            //Verificando que este vacio o sea null
                            if (!isset($resultadoPaquete)) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No Existen Registros del Paquete</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro la tabla
                            else {
                                ?>               
                                <h2> Datos del Paquete </h2> 
                                <table class='footable table table-striped table-bordered'>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Origen</b></td>
                                        <?php if ($resultadoPaquete['origenpaq']['tipobuz'] != '0') { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['origenpaq']['idusu']['nombreusu'] . ' ' . $resultadoPaquete['origenpaq']['idusu']['apellidousu']) ?></td>
                                        <?php } ?>		
                                    </tr>
                                    <tr>			 
                                        <td style="text-align:center"><b>Destino</b></td>
                                        <?php if ($resultadoPaquete['destinopaq']['tipobuz'] == '0') { ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['destinopaq']['idusu']['nombreusu'] . ' ' . $resultadoPaquete['destinopaq']['idusu']['apellidousu']) ?></td>
                                            <?php
                                        }
                                        if ($resultadoPaquete['destinopaq']['tipobuz'] == '1') {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['destinopaq']['nombrebuz']) ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Asunto</b></td>
                                        <?php if (!isset($resultadoPaquete['asuntopaq'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['asuntopaq']) ?></td>
                                        <?php } ?>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Texto</b></td>
                                        <?php if (!isset($resultadoPaquete['textopaq'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['textopaq']) ?></td>
                                        <?php } ?>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Fecha y Hora de Envio</b></td>
                                        <?php if (!isset($resultadoPaquete['fechapaq'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                            <?php
                                        } else {
                                            $fecha = FechaHora($resultadoPaquete['fechapaq']);
                                            ?>
                                            <td style="text-align:center"><?php echo $fecha ?></td>
                                        <?php } ?>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Status</b></td>
                                        <?php if (!isset($resultadoPaquete['statuspaq'])) { ?>
                                            <td style="text-align:center"><?php echo "" ?></td>
                                            <?php
                                        } else {
                                            if ($resultadoPaquete['statuspaq'] == "0") {
                                                $statusPaquete = "En Proceso";
                                            } elseif ($resultadoPaquete['statuspaq'] == "1") {
                                                $statusPaquete = "Entregado";
                                            } elseif ($resultadoPaquete['statuspaq'] == "2") {
                                                $statusPaquete = "No Permitido";
                                            } elseif ($resultadoPaquete['statuspaq'] == "3") {
                                                $statusPaquete = "Reenviado";
                                            } elseif ($resultadoPaquete['statuspaq'] == "4") {
                                                $statusPaquete = "Ausente";
                                            } elseif ($resultadoPaquete['statuspaq'] == "5") {
                                                $statusPaquete = "Extraviado";
                                            }
                                            ?>
                                            <td style="text-align:center"><?php echo $statusPaquete ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Localización</b></td>
                                        <?php if (!isset($resultadoPaquete['localizacionpaq'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['localizacionpaq']) ?></td>
                                        <?php } ?>
                                    </tr>                                    
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Prioridad</b></td>
                                        <?php if (!isset($resultadoPaquete['idpri'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['idpri']['nombrepri']) ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Documento</b></td>
                                        <?php if (!isset($resultadoPaquete['iddoc'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['iddoc']['nombredoc']) ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Con Respuesta</b></td>
                                        <?php if ($resultadoPaquete['respaq'] == '0') { ?>
                                            <td style="text-align:center"><?php echo "No" ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo "Si" ?></td>
                                        <?php } ?>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Sede</b></td>
                                        <?php if (!isset($resultadoPaquete['idsed'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo utf8_encode($resultadoPaquete['idsed']['nombresed']) ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Respuesta al Paquete</b></td>
                                        <?php if (!isset($resultadoPaquete['idpaqres'])) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo $resultadoPaquete['idpaqres']['idpaq'] ?></td>
                                        <?php } ?>
                                    </tr> 
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Frágil</b></td>
                                        <?php if ($resultadoPaquete['fragilpaq'] == '0') { ?>
                                            <td style="text-align:center"><?php echo "No" ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><?php echo "Si" ?></td>
                                        <?php } ?>		
                                    </tr>

                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Imagen del Paquete</b></td>
                                        <?php if (!isset($resultadoAdjunto)) { ?>
                                            <td style="text-align:center"><?php echo ""; ?></td>
                                        <?php } else {
                                            ?>
                                            <td style="text-align:center"><img src="<?php echo $resultadoAdjunto['urladj'] ?>" height="190" width="270"></td>
                                            <?php } ?>	
                                    </tr>
                                </table>
                            <?php } ?>
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
                setTimeout("window.close();", 300000);
            }
        </script>    
    </body>
</html>