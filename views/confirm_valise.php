<?php
if ($usuarioBitacora == "") {
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
                                <a href="../pages/create_valise.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="span10" align="center">
                        <form class="form-signin" method="post">
                            <div class="tab-content">
                                <div class="row-fluid">
                                    <strong> <h2 align="center">Confirmar Valija</h2> </strong>
                                    <div class="span5" align="right"><strong>Código de Valija: </strong></div>
                                    <div class="span3" align="left">
                                        <input type="text" class="input-block-level" name="cValija" id="cValija" placeholder="Ej. 4246" title="Ingrese el código de la Valija" autocomplete="off" pattern="[0-9]{1,38}" autofocus required>
                                    </div>
                                    <div class="span5" align="right"><strong>Proveedor: </strong></div>
                                    <div class="span3" align="left">
                                        <select name='proveedor' id='proveedor' required  title='Seleccione el Proveedor'>
                                            <option value='' style='display:none'>Seleccionar:</option>
                                            <?php
                                            if ($proveedor > 1) {
                                                $i = 0;
                                                while ($proveedor > $i) {
                                                    echo "<option value='" . $resultadoProveedor->return[$i]->idpro . "' >" . $resultadoProveedor->return[$i]->nombrepro . "</option>";
                                                    $i++;
                                                }
                                            } else {
                                                echo "<option value='" . $resultadoProveedor->return->idpro . "' >" . $resultadoProveedor->return->nombrepro . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="span5" align="right"><strong>Código del Proveedor:</strong></div>
                                    <div class="span3" align="left">
                                        <input type="text" class="input-block-level" name="cProveedor" id="cProveedor" placeholder="Ej. 1234" title="Ingrese el código de Guía" autocomplete="off" required>
                                    </div>
                                </div>
                                <button class="btn" type="submit" id="confirmar" name="confirmar" onclick="return confirm('¿Esta seguro que desea confirmar la Valija?')">Confirmar</button>
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