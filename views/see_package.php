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
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <?php
                            //Verificando que este vacio o sea null
                            if (!isset($resultadoPaquete->return)) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No Existen Registros de Traking del Paquete</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro la tabla
                            else {
                                ?>
                                <form class="form-search" id="formulario" method="post">                   
                                    <strong> <h2 align="center">Traking del Paquete</h2> </strong>
                                    <table class='footable table table-striped table-bordered'  data-page-size=$itemsByPage>
                                        <thead bgcolor='#FF0000'>
                                            <tr>
                                                <th style="text-align:center" data-sort-ignore="true">Usuario</th>
                                                <th style="text-align:center" data-sort-ignore="true">Fecha - Hora</th>
                                                <th style="text-align:center" data-sort-ignore="true">Status</th>
                                                <th style="text-align:center" data-sort-ignore="true">Procesado en</th>
                                                <th style="text-align:center" data-sort-ignore="true">Localización</th>                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($segumientoPaquete > 1) {
                                                for ($i = 0; $i < $segumientoPaquete; $i++) {
                                                    ?>
                                                    <tr>
                                                        <?php if (isset($resultadoPaquete->return[$i]->iduse->idusu->apellidousu)) { ?>
                                                            <td><?php echo $resultadoPaquete->return[$i]->iduse->idusu->nombreusu . ' ' . $resultadoPaquete->return[$i]->iduse->idusu->apellidousu ?></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><?php echo $resultadoPaquete->return[$i]->iduse->idusu->nombreusu ?></td>
                                                            <?php
                                                        }
                                                        $fecha[$i] = FechaHora($resultadoPaquete->return[$i]->fechaseg);
                                                        ?>
                                                        <td style="text-align:center"><?php echo $fecha[$i] ?></td>
                                                        <?php
                                                        $status = "";
                                                        if ($resultadoPaquete->return[$i]->statusseg == "0") {
                                                            $status = "En Proceso";
                                                        } elseif ($resultadoPaquete->return[$i]->statusseg == "1") {
                                                            $status = "Entregado";
                                                        } elseif ($resultadoPaquete->return[$i]->statusseg == "2") {
                                                            $status = "Reenviado";
                                                        } elseif ($resultadoPaquete->return[$i]->statusseg == "3") {
                                                            $status = "Extraviado";
                                                        }
                                                        ?>
                                                        <td style="text-align:center"><?php echo $status ?></td>
                                                        <?php
                                                        $tipo = "";
                                                        if ($resultadoPaquete->return[$i]->tiposeg == "0") {
                                                            $tipo = "Origen";
                                                        } elseif ($resultadoPaquete->return[$i]->tiposeg == "1") {
                                                            $tipo = "Destino";
                                                        }
                                                        ?>
                                                        <td style="text-align:center"><?php echo $tipo ?></td>
                                                        <td style="text-align:center"><?php echo $resultadoPaquete->return[$i]->nivelseg ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <?php if (isset($resultadoPaquete->return->iduse->idusu->apellidousu)) { ?>
                                                        <td><?php echo $resultadoPaquete->return->iduse->idusu->nombreusu . ' ' . $resultadoPaquete->return->iduse->idusu->apellidousu ?></td>
                                                    <?php } else {
                                                        ?>
                                                        <td><?php echo $resultadoPaquete->return->iduse->idusu->nombreusu ?></td>
                                                        <?php
                                                    }
                                                    $fecha = FechaHora($resultadoPaquete->return->fechaseg);
                                                    ?>
                                                    <td style="text-align:center"><?php echo $fecha ?></td>
                                                    <?php
                                                    $status = "";
                                                    if ($resultadoPaquete->return->statusseg == "0") {
                                                        $status = "En Proceso";
                                                    } elseif ($resultadoPaquete->return->statusseg == "1") {
                                                        $status = "Entregado";
                                                    } elseif ($resultadoPaquete->return->statusseg == "2") {
                                                        $status = "Reenviado";
                                                    } elseif ($resultadoPaquete->return->statusseg == "3") {
                                                        $status = "Extraviado";
                                                    }
                                                    ?>
                                                    <td style="text-align:center"><?php echo $status ?></td>
                                                    <?php
                                                    $tipo = "";
                                                    if ($resultadoPaquete->return->tiposeg == "0") {
                                                        $tipo = "Origen";
                                                    } elseif ($resultadoPaquete->return->tiposeg == "1") {
                                                        $tipo = "Destino";
                                                    }
                                                    ?>
                                                    <td style="text-align:center"><?php echo $tipo ?></td>
                                                    <td style="text-align:center"><?php echo $resultadoPaquete->return->nivelseg ?></td>
                                                </tr>
                                            <?php } ?>                                    
                                        </tbody>
                                    </table>                            
                                    <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>
                                    <br>
                                </form>
                                <div class="span6" align="center">
                                    <a href='../pages/proof_of_traking_package.php?id=<?php echo $idPaquete ?>' target="new"><button type="submit" class="btn" id="imprimirT" name="imprimirT"> <span class="add-on"><i class="icon-print"></i> </span> Traking del Paquete</button></a>
                                </div>
                                <div class="span5" align="center">
                                    <a href='../pages/proof_of_correspondence_package.php?id=<?php echo $idPaquete ?>' target="new"><button type="submit" class="btn" id="imprimirP" name="imprimirP"> <span class="add-on"><i class="icon-print"></i> </span> Comprobante del Paquete</button></a>
                                </div>
                                <?php
                            }
                            if (!isset($resultadoPaquete->return)) {
                                ?>
                                <div align="right">
                                    <a href='../pages/proof_of_correspondence_package.php?id=<?php echo $idPaquete ?>' target="new"><button type="submit" class="btn" id="imprimirP" name="imprimirP"> <span class="add-on"><i class="icon-print"></i> </span> Comprobante del Paquete</button></a>
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