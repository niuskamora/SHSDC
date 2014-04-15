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

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="../css/bootstrap-combined.min.css" rel="stylesheet">
        <link href="../css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/jquery.fancybox.css" rel="stylesheet">

        <!--Load fontAwesome css-->
        <link rel="stylesheet" type="text/css" media="all" href="../font-awesome/css/font-awesome.min.css">
        <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

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
                        <span lang="es">&nbsp;</span>
                    </div>
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
                        <form class="form-signin" method="post" name="formulario" id="formulario">
                            <div class="tab-content">
                                <div class="row-fluid">
                                    <div id="data">
                                        <?php
                                        if (isset($PaquetesExternos->return)) {

                                            echo "<br>";
                                            ?>

                                            <h2>Envio de Correspondencia Externa</h2>
                                            <table class='footable table table-striped table-bordered'  data-page-size=$itemsByPage>    
                                                <thead bgcolor='#FF0000'>
                                                    <tr>	
                                                        <th style='width:7%; text-align:center'>Origen</th>
                                                        <th style='width:7%; text-align:center' data-sort-ignore="true">Destino</th>
                                                        <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                                                        <th style='width:7%; text-align:center' data-sort-ignore="true">C/R</th>
                                                        <th style='width:7%; text-align:center' data-sort-ignore="true">Fecha</th>
                                                        <th style='width:7%; text-align:center' data-sort-ignore="true">Enviar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (count($PaquetesExternos->return) == 1) {
                                                        if ($PaquetesExternos->return->respaq == "0") {
                                                            $rta = "No";
                                                        } else {
                                                            $rta = "Si";
                                                        }
                                                        if (strlen($PaquetesExternos->return->asuntopaq) > 10) {
                                                            $asunto = substr($PaquetesExternos->return->asuntopaq, 0, 10) . "...";
                                                        } else {
                                                            $asunto = $PaquetesExternos->return->asuntopaq;
                                                        }
                                                        ?>
                                                        <tr>     
                                                            <td  style='text-align:center'><?php echo $PaquetesExternos->return->origenpaq->idusu->nombreusu . " " . $PaquetesExternos->return->origenpaq->idusu->apellidousu; ?></td>
                                                            <td style='text-align:center'><?php echo $PaquetesExternos->return->destinopaq->nombrebuz; ?></td>
                                                            <td style='text-align:center'><?php echo $asunto; ?></td>
                                                            <td style='text-align:center'><?php echo $rta; ?></td>
                                                            <td style='text-align:center'><?php echo date("d/m/Y", strtotime(substr($PaquetesExternos->return->fechapaq, 0, 10))); ?></td>
                                                            <td style='text-align:center'><input type="radio" name="ide" id="ide" value="<?php echo $PaquetesExternos->return->idpaq; ?>"></td>  
                                                        </tr>   
                                                        <?php
                                                    } else {
                                                        for ($i = 0; $i < count($PaquetesExternos->return); $i++) {
                                                            if ($PaquetesExternos->return[$i]->respaq == "0") {
                                                                $rta = "No";
                                                            } else {
                                                                $rta = "Si";
                                                            }
                                                            if (strlen($PaquetesExternos->return[$i]->asuntopaq) > 10) {
                                                                $asunto = substr($PaquetesExternos->return[$i]->asuntopaq, 0, 10) . "...";
                                                            } else {
                                                                $asunto = $PaquetesExternos->return[$i]->asuntopaq;
                                                            }
                                                            ?>
                                                            <tr>     
                                                                <td  style='text-align:center'><?php echo $PaquetesExternos->return[$i]->origenpaq->idusu->nombreusu . " " . $PaquetesExternos->return[$i]->origenpaq->idusu->apellidousu; ?></td>
                                                                <td style='text-align:center'><?php echo $PaquetesExternos->return[$i]->destinopaq->nombrebuz; ?></td>
                                                                <td style='text-align:center'><?php echo $asunto; ?></td>
                                                                <td style='text-align:center'><?php echo $rta; ?></td>
                                                                <td style='text-align:center'><?php echo date("d/m/Y", strtotime(substr($PaquetesExternos->return[$i]->fechapaq, 0, 10))); ?></td>
                                                                <td style='text-align:center'><input type="radio" name="ide" id="ide" value="<?php echo $PaquetesExternos->return[$i]->idpaq; ?>"></td>  
                                                            </tr>   
                                                            <?php
                                                        }
                                                    }//fin else
                                                    ?>  
                                                </tbody>
                                            </table>
                                            <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>	
                                            <button class="btn" type="button" id="enviar" name="enviar" onClick="Paquete();">Seleccionar</button>										

                                            <?php
                                        } else {
                                            echo"<div class='alert alert-block' align='center'>
											<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
											<h4 align='center'>No hay Correspondencia Externa por enviar</h4>
											</div> ";
                                        }
                                        ?>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        <script>

            function Paquete() {
                elementos = document.getElementById("formulario").elements;
                longitud = document.getElementById("formulario").length;
                var selecciono = 0;
                for (var i = 0; i < longitud; i++) {
                    if (elementos[i].type == "radio" && elementos[i].checked == true) {
                        var idpaq = elementos[i].value;
                        selecciono = 1;
                        break;
                    }
                }
                if (selecciono == 1) {

                    var parametros = {
                        "idpaq": idpaq
                    };
                    $.ajax({
                        type: "POST",
                        url: "../ajax/external_costs.php",
                        data: parametros,
                        dataType: "text",
                        success: function(response) {
                            $("#data").html(response);
                        }
                    });
                } else {
                    alert("Por favor seleccione un paquete")
                }

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