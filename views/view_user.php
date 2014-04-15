<?php
if (!isset($Usuario->return)) {
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
    <?php
    $apellido = "";
    $correo = "";
    $telefono1 = "";
    $telefono2 = "";
    $direccion1 = "";
    $direccion2 = "";
    if (isset($Usuario->return->apellidousu)) {
        $apellido = $Usuario->return->apellidousu;
    }
    if (isset($Usuario->return->correousu)) {
        $correo = $Usuario->return->correousu;
    }
    if (isset($Usuario->return->telefonousu)) {
        $telefono1 = $Usuario->return->telefonousu;
    }
    if (isset($Usuario->return->telefono2usu)) {
        $telefono2 = $Usuario->return->telefono2usu;
    }
    if (isset($Usuario->return->direccionusu)) {
        $direccion1 = $Usuario->return->direccionusu;
    }
    if (isset($Usuario->return->direccion2usu)) {
        $direccion2 = $Usuario->return->direccion2usu;
    }
    ?>
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
                                <a href="../pages/inbox.php"> Atrás </a>
                            </li> 
                            <li>   
                                <a href="../pages/edit_user.php"> Editar Usuario </a>
                            </li>
                            <li>   
                                <a href="../pages/mailboxs.php"> Editar Buzón </a>
                            </li>
                        </ul>
                    </div>

                    <div class="span10" align="center">
                        <div class="tab-content" id="lista" align="center"> 
                            <div class="tab-content" id="lista" align="center"> 
                                <h2> Datos del Usuario </h2> 
                                <table class='footable table table-striped table-bordered'>
                                    <tr>
                                        <td style="text-align:center" ><b>Nombre</b></td>
                                        <td style="text-align:center"><?php echo $Usuario->return->nombreusu; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><b>Apellido</b></td>
                                        <td style="text-align:center"><?php echo $apellido; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Correo</b></td>
                                        <td style="text-align:center"><?php echo $correo; ?></td>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%"><b>Usuario</b></td>
                                        <td style="text-align:center"><?php echo $Usuario->return->userusu; ?>
                                        </td>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><b>Teléfono 1</b></td>
                                        <td style="text-align:center"><?php echo $telefono1; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><b>Teléfono 2</b></td>
                                        <td style="text-align:center"><?php echo $telefono2; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><b>Dirección 1</b></td>
                                        <td style="text-align:center"><?php echo $direccion1; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center"><b>Dirección 2</b></td>
                                        <td style="text-align:center"><?php echo $direccion2; ?></td>
                                    </tr>
                                </table>
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
                <script type="text/javascript" src="../js/jquery-2.0.3.js" ></script> 


                </body>
                </html>