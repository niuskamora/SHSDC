<?php
if ($usuario == "") {
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
                                <a href="../pages/reports_package.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <?php
                            //Verificando que este vacio o sea null
                            if (!isset($resultadoConsultarPaquetes)) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No Existen Registros de Paquetes</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro la tabla
                            else {
                                ?>
                                <strong> <h2 align="center"><?php echo $nombreReporte ?></h2> </strong>
                                <br>
                                <div class="span11">
                                    <div class="span3"></div>
                                    <div class="span6" align="center">
                                        <table align="center" width="300" class='footable table table-striped table-bordered'>
                                            <tr>
                                                <td style="text-align:center"><strong>Total de <?php echo $nombreReporte ?></strong></td>
                                                <td style="text-align:center" width="100"><?php echo $paquetes ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="span3"></div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <table class='footable table table-striped table-bordered' data-page-size=<?php echo $itemsByPage ?>>
                                    <thead bgcolor='#FF0000'>
                                        <tr>
                                            <th style="text-align:center">Fecha y Hora <br> de Envio</th>
                                            <th style="text-align:center">Nro de <br> Paquete</th>
                                            <th style="text-align:center">Origen</th>
                                            <th style="text-align:center" data-sort-ignore="true">De</th>
                                            <th style="text-align:center" data-sort-ignore="true">Para</th>
                                            <th style="text-align:center" data-sort-ignore="true">Prioridad</th>
                                            <th style="text-align:center" data-sort-ignore="true">Tipo</th>
                                            <th style="text-align:center">Destino</th>
                                            <th style="text-align:center" data-sort-ignore="true">Ver más</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($paquetes > 1) {
                                            for ($i = 0; $i < $paquetes; $i++) {
                                                ?>
                                                <tr>
                                                    <?php
                                                    if (isset($resultadoConsultarPaquetes[$i]['fechapaq'])) {
                                                        $fechaEnvio = FechaHora($resultadoConsultarPaquetes[$i]['fechapaq']);
                                                    } else {
                                                        $fechaEnvio = "";
                                                    }
                                                    ?>
                                                    <td style="text-align:center"><?php echo $fechaEnvio ?></td>
                                                    <td style="text-align:center"><?php echo $resultadoConsultarPaquetes[$i]['idpaq'] ?></td>
                                                    <?php
                                                    $nomOrigen = "";
                                                    if (isset($resultadoConsultarPaquetes[$i]['origenpaq']['idatr']['idsed']['nombresed'])) {
                                                        $nomOrigen = utf8_encode($resultadoConsultarPaquetes[$i]['origenpaq']['idatr']['idsed']['nombresed']);
                                                    } else {
                                                        $nomOrigen = "";
                                                    }
                                                    ?>
                                                    <td><?php echo $nomOrigen ?></td>
                                                    <?php
                                                    $deOrigen = "";
                                                    $apellidoOrigen = "";
                                                    if (isset($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['nombreusu'])) {
                                                        $deOrigen = utf8_encode($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['nombreusu']);
                                                    } else {
                                                        $deOrigen = "";
                                                    }
                                                    if (isset($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['apellidousu'])) {
                                                        $apellidoOrigen = utf8_encode($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['apellidousu']);
                                                    } else {
                                                        $apellidoOrigen = "";
                                                    }
                                                    ?>
                                                    <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                                                    <?php
                                                    $paraDestino = "";
                                                    $apellidoDestino = "";
                                                    $nomDestino = "";
                                                    if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['tipobuz'])) {
                                                        if ($resultadoConsultarPaquetes[$i]['destinopaq']['tipobuz'] == "0") {
                                                            if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['nombreusu'])) {
                                                                $paraDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['nombreusu']);
                                                            } else {
                                                                $paraDestino = "";
                                                            }
                                                            if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['apellidousu'])) {
                                                                $apellidoDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['apellidousu']);
                                                            } else {
                                                                $apellidoDestino = "";
                                                            }
                                                            if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['idatr']['idsed']['nombresed'])) {
                                                                $nomDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['idatr']['idsed']['nombresed']);
                                                            } else {
                                                                $nomDestino = "";
                                                            }
                                                        }
                                                        if ($resultadoConsultarPaquetes[$i]['destinopaq']['tipobuz'] == "1") {
                                                            if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['nombrebuz'])) {
                                                                $paraDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['nombrebuz']);
                                                            } else {
                                                                $paraDestino = "";
                                                            }
                                                            if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['direccionbuz'])) {
                                                                $nomDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['direccionbuz']);
                                                            } else {
                                                                $nomDestino = "";
                                                            }
                                                        }
                                                    }
                                                    ?>                            
                                                    <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>                                                    
                                                    <td style="text-align:center"><?php echo utf8_encode($resultadoConsultarPaquetes[$i]['idpri']['nombrepri']) ?></td>
                                                    <td style="text-align:center"><?php echo utf8_encode($resultadoConsultarPaquetes[$i]['iddoc']['nombredoc']) ?></td>
                                                    <td><?php echo $nomDestino ?></td>
                                                    <td style='text-align:center'><a href='../pages/package_detail_traking.php?id=<?php echo $resultadoConsultarPaquetes[$i]['idpaq']; ?>'><button type='button' class='btn btn-info btn-primary'>Ver más</button> </a></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <?php
                                                if (isset($resultadoConsultarPaquetes['fechapaq'])) {
                                                    $fechaEnvio = FechaHora($resultadoConsultarPaquetes['fechapaq']);
                                                } else {
                                                    $fechaEnvio = "";
                                                }
                                                ?>
                                                <td style="text-align:center"><?php echo $fechaEnvio ?></td>
                                                <td style="text-align:center"><?php echo $resultadoConsultarPaquetes['idpaq'] ?></td>
                                                <?php
                                                $nomOrigen = "";
                                                if (isset($resultadoConsultarPaquetes['origenpaq']['idatr']['idsed']['nombresed'])) {
                                                    $nomOrigen = utf8_encode($resultadoConsultarPaquetes['origenpaq']['idatr']['idsed']['nombresed']);
                                                } else {
                                                    $nomOrigen = "";
                                                }
                                                ?>
                                                <td><?php echo $nomOrigen ?></td>
                                                <?php
                                                $deOrigen = "";
                                                $apellidoOrigen = "";
                                                if (isset($resultadoConsultarPaquetes['origenpaq']['idusu']['nombreusu'])) {
                                                    $deOrigen = utf8_encode($resultadoConsultarPaquetes['origenpaq']['idusu']['nombreusu']);
                                                } else {
                                                    $deOrigen = "";
                                                }
                                                if (isset($resultadoConsultarPaquetes['origenpaq']['idusu']['apellidousu'])) {
                                                    $apellidoOrigen = utf8_encode($resultadoConsultarPaquetes['origenpaq']['idusu']['apellidousu']);
                                                } else {
                                                    $apellidoOrigen = "";
                                                }
                                                ?>
                                                <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                                                <?php
                                                $paraDestino = "";
                                                $apellidoDestino = "";
                                                $nomDestino = "";
                                                if (isset($resultadoConsultarPaquetes['destinopaq']['tipobuz'])) {
                                                    if ($resultadoConsultarPaquetes['destinopaq']['tipobuz'] == "0") {
                                                        if (isset($resultadoConsultarPaquetes['destinopaq']['idusu']['nombreusu'])) {
                                                            $paraDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['idusu']['nombreusu']);
                                                        } else {
                                                            $paraDestino = "";
                                                        }
                                                        if (isset($resultadoConsultarPaquetes['destinopaq']['idusu']['apellidousu'])) {
                                                            $apellidoDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['idusu']['apellidousu']);
                                                        } else {
                                                            $apellidoDestino = "";
                                                        }
                                                        if (isset($resultadoConsultarPaquetes['destinopaq']['idatr']['idsed']['nombresed'])) {
                                                            $nomDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['idatr']['idsed']['nombresed']);
                                                        } else {
                                                            $nomDestino = "";
                                                        }
                                                    }
                                                    if ($resultadoConsultarPaquetes['destinopaq']['tipobuz'] == "1") {
                                                        if (isset($resultadoConsultarPaquetes['destinopaq']['nombrebuz'])) {
                                                            $paraDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['nombrebuz']);
                                                        } else {
                                                            $paraDestino = "";
                                                        }
                                                        if (isset($resultadoConsultarPaquetes['destinopaq']['direccionbuz'])) {
                                                            $nomDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['direccionbuz']);
                                                        } else {
                                                            $nomDestino = "";
                                                        }
                                                    }
                                                }
                                                ?>                            
                                                <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>                                                    
                                                <td style="text-align:center"><?php echo utf8_encode($resultadoConsultarPaquetes['idpri']['nombrepri']) ?></td>
                                                <td style="text-align:center"><?php echo utf8_encode($resultadoConsultarPaquetes['iddoc']['nombredoc']) ?></td>
                                                <td><?php echo $nomDestino ?></td>
                                                <td style='text-align:center'><a href='../pages/package_detail_traking.php?id=<?php echo $resultadoConsultarPaquetes['idpaq']; ?>'><button type='button' class='btn btn-info btn-primary'>Ver más</button> </a></td>
                                            </tr>                                                
                                        <?php } ?>                                    
                                    </tbody>
                                </table>
                                <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>                       
                                <br>
                                <br>
                                <br>
                                <div class="span6" align="center">
                                    <a href="../pages/graphics_reports_package.php" target="new"><button type="submit" class="btn" id="graficar" name="graficar"> Graficar </button></a>
                                </div>
                                <div class="span5" align="center">
                                    <a href="../pages/proof_reporting_package.php" target="new"><button type="submit" class="btn" id="imprimir" name="imprimir"> Imprimir </button></a>
                                </div>
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