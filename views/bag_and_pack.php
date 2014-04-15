<?php
if (!isset($SedeRol->return)) {
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
                                <a href="../pages/info_reports_valise.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <?php
                            //Verificando que este vacio o sea null
                            if (!isset($resultadoPaquetesPorValija->return)) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No Existen Registros de Paquetes en esta Valija</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro la tabla
                            else {
                                ?>
                                <strong> <h2 align="center">Valija</h2> </strong>
                                <table class='footable table table-striped table-bordered' > 
                                    <thead bgcolor='#FF0000'>
                                        <tr>
                                            <th style='text-align:center' data-sort-ignore="true">Fecha y Hora de Envio</th>
                                            <th style='text-align:center' data-sort-ignore="true">Nro de Valija</th>
                                            <th style='text-align:center' data-sort-ignore="true">Nro de Guía</th>
                                            <th style='text-align:center' data-sort-ignore="true">Origen</th>
                                            <th style='text-align:center' data-sort-ignore="true">Tipo</th>
                                            <th style='text-align:center' data-sort-ignore="true">Destino</th>
                                            <th style='text-align:center' data-sort-ignore="true">Fecha y Hora de Recibido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='text-align:center'><?php echo $fechaEnvio ?></td>
                                            <td style='text-align:center'><?php echo $idVal ?></td>
                                            <td style='text-align:center'><?php echo $guia ?></td>
                                            <td style='text-align:center'><?php echo $origen ?></td>
                                            <td style='text-align:center'><?php echo $tipo ?></td>
                                            <td style='text-align:center'><?php echo $destino ?></td>
                                            <td style='text-align:center'><?php echo $fechaRecibido ?></td>
                                        </tr>
                                    </tbody>
                                </table>                             
                                <br>
                                <div class="span3">
                                </div> 
                                <div class="span6">
                                    <table class='footable table table-striped table-bordered'>
                                        <tr>
                                            <td style='text-align:center'><strong>Número de Paquetes o Correspondencia</strong></td>
                                            <td style='text-align:center' width="100"><?php echo $contadorPaquetes ?></td>
                                        </tr>
                                    </table>
                                </div> 	

                                <br></br><br></br>

                                <strong> <h2 align="center">Detalle de la Valija</h2> </strong>
                                <table class='footable table table-striped table-bordered' data-page-size='5'> 
                                    <thead bgcolor='#FF0000'>
                                        <tr>
                                            <th style="text-align:center" data-sort-ignore="true">Nro de Paquete</th>
                                            <th style="text-align:center">Origen</th>
                                            <th style="text-align:center">De</th>
                                            <th style="text-align:center">Para</th>
                                            <th style="text-align:center">Destino</th>
                                            <th style="text-align:center" data-sort-ignore="true">Ver más</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($contadorPaquetes > 1) {
                                            for ($i = 0; $i < $contadorPaquetes; $i++) {
                                                ?>
                                                <tr>
                                                    <td style='text-align:center'><?php echo $resultadoPaquetesPorValija->return[$i]->idpaq ?></td>
                                                    <td style='text-align:center'><?php echo $resultadoPaquetesPorValija->return[$i]->origenpaq->idatr->idsed->nombresed ?></td>
                                                    <td style='text-align:center'><?php echo $resultadoPaquetesPorValija->return[$i]->origenpaq->idusu->nombreusu . " " . $resultadoPaquetesPorValija->return[$i]->origenpaq->idusu->apellidousu; ?></td>
                                                    <?php
                                                    $paraDestino = "";
                                                    $nomDestino = "";
                                                    if ($resultadoPaquetesPorValija->return[$i]->destinopaq->tipobuz == "0") {
                                                        $paraDestino = $resultadoPaquetesPorValija->return[$i]->destinopaq->idusu->nombreusu . " " . $resultadoPaquetesPorValija->return[$i]->destinopaq->idusu->apellidousu;
                                                        $nomDestino = $resultadoPaquetesPorValija->return[$i]->destinopaq->idatr->idsed->nombresed;
                                                    } else {
                                                        $paraDestino = $resultadoPaquetesPorValija->return[$i]->destinopaq->nombrebuz;
                                                        $nomDestino = $resultadoPaquetesPorValija->return[$i]->destinopaq->direccionbuz;
                                                    }
                                                    ?>                            
                                                    <td style='text-align:center'><?php echo $paraDestino ?></td>
                                                    <td style='text-align:center'><?php echo $nomDestino ?></td>
                                                    <td style='text-align:center'><a href='../pages/package_detail_traking.php?id=<?php echo $resultadoPaquetesPorValija->return[$i]->idpaq; ?>'><button type='button' class='btn btn-info btn-primary'>Ver más</button> </a></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td style='text-align:center'><?php echo $resultadoPaquetesPorValija->return->idpaq ?></td>
                                                <td style='text-align:center'><?php echo $resultadoPaquetesPorValija->return->origenpaq->idatr->idsed->nombresed; ?></td>
                                                <td style='text-align:center'><?php echo $resultadoPaquetesPorValija->return->origenpaq->idusu->nombreusu . " " . $resultadoPaquetesPorValija->return->origenpaq->idusu->apellidousu; ?></td>
                                                <?php
                                                $paraDestino = "";
                                                $nomDestino = "";
                                                if (isset($resultadoPaquetesPorValija->return->destinopaq->tipobuz)) {
                                                    if ($resultadoPaquetesPorValija->return->destinopaq->tipobuz == "0") {
                                                        $paraDestino = $resultadoPaquetesPorValija->return->destinopaq->idusu->nombreusu . " " . $resultadoPaquetesPorValija->return->destinopaq->idusu->apellidousu;
                                                        $nomDestino = $resultadoPaquetesPorValija->return->destinopaq->idatr->idsed->nombresed;
                                                    } else {
                                                        $paraDestino = $resultadoPaquetesPorValija->return->destinopaq->nombrebuz;
                                                        $nomDestino = $resultadoPaquetesPorValija->return->destinopaq->direccionbuz;
                                                    }
                                                }
                                                ?>                            
                                                <td style='text-align:center'><?php echo $paraDestino ?></td>
                                                <td style='text-align:center'><?php echo $nomDestino ?></td>
                                                <td style='text-align:center'><a href='../pages/package_detail_traking.php?id=<?php echo $resultadoPaquetesPorValija->return->idpaq; ?>'><button type='button' class='btn btn-info btn-primary'>Ver más</button> </a></td>

                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                                <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>                         
                                <br>
                                <br>
                                <br>
                                <div align="center">
                                    <a href='../pages/proof_pouch_and_packages.php?id=<?php echo $idVal ?>' target="new"><button type="submit" class="btn" id="imprimirT" name="imprimirT">Imprimir</button></a>
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