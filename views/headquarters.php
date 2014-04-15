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
        <script type='text/javascript' src="..//modernizr.min.js"></script>
        <script type='text/javascript' src="../js/custom.js"></script>
        <script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>


        <!-- styles -->
        <link rel="shortcut icon" href="../images/faviconsh.ico">


        <link rel="shortcut icon" href="../images/faviconsh.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-combined.min.css" rel="stylesheet">
        <link href="../css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/jquery.fancybox.css" rel="stylesheet">
        <link href="../css/estiloLogin.css" rel="stylesheet">


        <!--Load fontAwesome css-->
        <link rel="stylesheet" type="text/css" media="all" href="font-awesome/css/font-awesome.min.css">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">


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
                <div>
                    <ul class="nav nav-pills">
                        <li class="pull-left">
                            <div class="modal-header">
                                <h3>Correspondencia <span> SH</span> <?php echo "- Bienvenido, " . $_SESSION["Usuario"]->return->nombreusu; ?>
                                </h3>
                            </div>
                        </li>

                    </ul>
                </div>

                <!--Caso pantalla uno-->
                <div class="tab-content">
                    <div id="logueo" align="center">
                        <form class="form-signin" method="post">
                            <h3 class="form-signin-heading">Por favor, escoja la sede</h3>
                            <select name="sede" required  title="Seleccione la Sede a la que pertenece">
                                <option value="" style="display:none">Seleccionar:</option>                                  
                                <?php
                                for ($i = 0; $i < count($Sedes->return); $i++) {
                                    echo '<option value="' . $Sedes->return[$i]->idsed . '">' . $Sedes->return[$i]->nombresed . '</option>';
                                }
                                ?>
                            </select>
                            <button class="btn btn-info" type="submit" name="Biniciar">Ir a Bandejas</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>