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
                                <a href="inbox.php">Atrás</a>
                            </li>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <form class="form-search" id="formulario">
                                <h2>Correspondencia Extraviada</h2>
                                <?php
                                if (isset($PaquetesExtraviados->return)) {

                                    echo "<br>";
                                    ?>
                                    <table class='footable table table-striped table-bordered'  data-page-size=$itemsByPage>    
                                        <thead bgcolor='#FF0000'>
                                            <tr>	
                                                <th style='width:7%; text-align:center'>Origen</th>
                                                <th style='width:7%; text-align:center'>Destino</th>
                                                <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                                                <th style='width:7%; text-align:center' data-sort-ignore="true">Localización</th>
                                                <th style='width:7%; text-align:center' data-sort-ignore="true">Fecha Emisión</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($PaquetesExtraviados->return) == 1) {
                                                if (strlen($PaquetesExtraviados->return->asuntopaq) > 10) {
                                                    $asunto = substr($PaquetesExtraviados->return->asuntopaq, 0, 10) . "...";
                                                } else {
                                                    $asunto = $PaquetesExtraviados->return->asuntopaq;
                                                }
                                                if ($PaquetesExtraviados->return->destinopaq->tipobuz == 0) {
                                                    $nombrebuz = $PaquetesExtraviados->return->destinopaq->idusu->nombreusu . " " . $PaquetesExtraviados->return->destinopaq->idusu->apellidousu;
                                                } else {
                                                    $nombrebuz = $PaquetesExtraviados->return->destinopaq->nombrebuz;
                                                }
                                                ?>
                                                <tr>     
                                                    <td  style='text-align:center'><?php echo $PaquetesExtraviados->return->origenpaq->idusu->nombreusu . " " . $PaquetesExtraviados->return->origenpaq->idusu->apellidousu; ?></td>
                                                    <td  style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                    <td style='text-align:center'><?php echo $asunto; ?></td>
                                                    <td style='text-align:center'><?php echo $PaquetesExtraviados->return->localizacionpaq; ?></td>
                                                    <td style='text-align:center'><?php echo date("d/m/Y", strtotime(substr($PaquetesExtraviados->return->fechapaq, 0, 10))); ?></td>
                                                </tr>   
                                                <?php
                                            } else {
                                                for ($i = 0; $i < count($PaquetesExtraviados->return); $i++) {
                                                    if (strlen($PaquetesExtraviados->return[$i]->asuntopaq) > 10) {
                                                        $asunto = substr($PaquetesExtraviados->return[$i]->asuntopaq, 0, 10) . "...";
                                                    } else {
                                                        $asunto = $PaquetesExtraviados->return[$i]->asuntopaq;
                                                    }
                                                    if ($PaquetesExtraviados->return[$i]->destinopaq->tipobuz == 0) {
                                                        $nombrebuz = $PaquetesExtraviados->return[$i]->destinopaq->idusu->nombreusu . " " . $PaquetesExtraviados->return[$i]->destinopaq->idusu->apellidousu;
                                                    } else {
                                                        $nombrebuz = $PaquetesExtraviados->return[$i]->destinopaq->nombrebuz;
                                                    }
                                                    ?>
                                                    <tr>     
                                                        <td  style='text-align:center'><?php echo $PaquetesExtraviados->return[$i]->origenpaq->idusu->nombreusu . " " . $PaquetesExtraviados->return[$i]->origenpaq->idusu->apellidousu; ?></td>
                                                        <td  style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                        <td style='text-align:center'><?php echo $asunto; ?></td>
                                                        <td style='text-align:center'><?php echo $PaquetesExtraviados->return[$i]->localizacionpaq; ?></td>
                                                        <td style='text-align:center'><?php echo date("d/m/Y", strtotime(substr($PaquetesExtraviados->return[$i]->fechapaq, 0, 10))); ?></td>
                                                    </tr>   
                                                    <?php
                                                }
                                            }//fin else
                                            ?>
                                        </tbody>
                                    </table>
                                    <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>			

                                    <?php
                                } else {
                                    echo "<br>";
                                    echo"<div class='alert alert-block' align='center'>
									<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
									<h4 align='center'>No hay Correspondencia Extraviada en estos Momentos  </h4>
									</div> ";
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/footable.js" type="text/javascript"></script>
        <script src="../js/footable.paginate.js" type="text/javascript"></script>
        <script src="../js/footable.sortable.js" type="text/javascript"></script>
        <script>
            window.onload = function() {
                killerSession();
            }
            function killerSession() {
                setTimeout("window.open('../recursos/cerrarsesion.php','_top');", 300000);
            }
        </script>
        <script type="text/javascript">
            $(function() {
                $('table').footable();
            });
        </script>

    </body>
</html>