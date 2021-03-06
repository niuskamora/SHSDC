<?php
if (!isset($SedeRol)) {
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

                <!--Caso pantalla uno-->
                <div class="row-fluid">
                    <div class="span2">      
                        <ul class="nav nav-pills nav-stacked">
                            <li>   
                                <a href="inbox.php">Atrás</a>
                            </li>
                            <li>   
                                <a href="confirmed_user.php">Procesados</a>
                            </li>
                            <?php
                            if ($SedeRol["idrol"]["idrol"] == "1" || $SedeRol["idrol"]["idrol"] == "3") {
                                ?>
                                <li>   
                                    <a href="print_packages_confirmed.php">Imprimir</a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($SedeRol["idrol"]["idrol"] == "1") {
                                ?>
                                <li>   
                                    <a href="package_area.php">Paquetes por buscar</a>
                                </li>
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <form class="form-search" id="formulario">
                                <h2>Recibir paquete</h2>
                                Código de Correspondencia:  <input type="text" placeholder="Ej. 4246" title="Ingrese el código de correspondencia" autocomplete="off" style="width:140px ;height:28px" onkeypress="return isNumberKey(event)" pattern="[0-9]{1,38}" id="idpaq" name="idpaq"  required>
                                <button type="button" class="btn" onClick="Paquete();">Recibir Paquete</button>
                                <div id="data">
                                    <?php
                                    if (isset($PaquetesConfirmados)) {

                                        echo "<br>";
                                        ?>

                                        <h2>Correspondencia que ha sido confirmada</h2>
                                        <table class='footable table table-striped table-bordered'  data-page-size=<?php echo $itemsByPage ?>>    
                                            <thead bgcolor='#FF0000'>
                                                <tr>	
                                                    <th style='width:7%; text-align:center'>Origen</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Destino</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Tipo</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Contenido</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Con Respuesta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!isset($PaquetesConfirmados[0])) {
                                                    if ($PaquetesConfirmados["respaq"] == "0") {
                                                        $rta = "No";
                                                    } else {
                                                        $rta = "Si";
                                                    }
                                                    if (strlen(utf8_encode($PaquetesConfirmados["textopaq"])) > 20) {
                                                        $contenido =utf8_encode( substr($PaquetesConfirmados["textopaq"], 0, 17) ). "...";
                                                    } else {
                                                        $contenido =utf8_encode( $PaquetesConfirmados["textopaq"]);
                                                    }
                                                    if (strlen(utf8_encode($PaquetesConfirmados["asuntopaq"])) > 10) {
                                                        $asunto = utf8_encode(substr($PaquetesConfirmados["asuntopaq"], 0, 10)) . "...";
                                                    } else {
                                                        $asunto = utf8_encode($PaquetesConfirmados["asuntopaq"]);
                                                    }
                                                    if ($PaquetesConfirmados["destinopaq"]["tipobuz"] == 0) {
                                                        $nombrebuz =utf8_encode( $PaquetesConfirmados["destinopaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados["destinopaq"]["idusu"]["apellidousu"]);
                                                    } else {
                                                        $nombrebuz =utf8_encode( $PaquetesConfirmados["destinopaq"]["nombrebuz"]);
                                                    }
                                                    ?>
                                                    <tr>     
                                                        <td  style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados["origenpaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                                                        <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                        <td style='text-align:center'><?php echo $asunto; ?></td>
                                                        <td style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados["iddoc"]["nombredoc"]); ?></td>
                                                        <td style='text-align:center'><?php echo $contenido; ?></td>
                                                        <td style='text-align:center'><?php echo $rta; ?></td>  
                                                    </tr>   
                                                    <?php
                                                } else {
                                                    for ($i = 0; $i < count($PaquetesConfirmados); $i++) {
                                                        if ($PaquetesConfirmados[$i]["respaq"] == "0") {
                                                            $rta = "No";
                                                        } else {
                                                            $rta = "Si";
                                                        }
                                                        if (strlen(utf8_encode($PaquetesConfirmados[$i]["textopaq"])) > 20) {
                                                            $contenido = utf8_encode(substr($PaquetesConfirmados[$i]["textopaq"], 0, 17)) . "...";
                                                        } else {
                                                            $contenido = utf8_encode($PaquetesConfirmados[$i]["textopaq"]);
                                                        }
                                                        if (strlen(utf8_encode($PaquetesConfirmados[$i]["asuntopaq"])) > 10) {
                                                            $asunto = utf8_encode(substr($PaquetesConfirmados[$i]["asuntopaq"], 0, 10)) . "...";
                                                        } else {
                                                            $asunto = utf8_encode($PaquetesConfirmados[$i]["asuntopaq"]);
                                                        }
                                                        if ($PaquetesConfirmados[$i]["destinopaq"]["tipobuz"] == 0) {
                                                            $nombrebuz = utf8_encode($PaquetesConfirmados[$i]["destinopaq"]["idusu"]["nombreusu"] . " " . $PaquetesConfirmados[$i]["destinopaq"]["idusu"]["apellidousu"]);
                                                        } else {
                                                            $nombrebuz =utf8_encode( $PaquetesConfirmados[$i]["destinopaq"]["nombrebuz"]);
                                                        }
                                                        ?>
                                                        <tr>     
                                                            <td  style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados[$i]["origenpaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados[$i]["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                                                            <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                            <td style='text-align:center'><?php echo $asunto; ?></td>
                                                            <td style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados[$i]["iddoc"]["nombredoc"]); ?></td>
                                                            <td style='text-align:center'><?php echo $contenido; ?></td>
                                                            <td style='text-align:center'><?php echo $rta; ?></td>  
                                                        </tr>   
                                                        <?php
                                                    }
                                                }//fin else
                                                ?>  
                                            </tbody>
                                        </table>
                                        <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>					

                                        <?php
                                    }
                                    ?>
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
                                    function isNumberKey(evt)
                                    {
                                        var charCode = (evt.which) ? evt.which : event.keyCode
                                        if (charCode == 13) {
                                            Paquete();
                                        }
                                        if (charCode > 31 && (charCode < 48 || charCode > 57))
                                            return false;

                                        return true;
                                    }
        </script>
        <script>

            function Paquete() {

                if (document.forms.formulario.idpaq.value != "") {
                    var idpaq = document.forms.formulario.idpaq.value;
                    var parametros = {
                        "idpaq": idpaq
                    };
                    $.ajax({
                        type: "POST",
                        url: "../ajax/view_package.php",
                        data: parametros,
                        dataType: "text",
                        success: function(response) {
                            $("#data").html(response);
                        }
                    });
                    document.forms.formulario.idpaq.value = "";
                } else {
                    alert("Por favor agregue el código de correspondencia")
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