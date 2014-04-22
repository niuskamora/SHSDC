<?php
if ($Usua=="") {
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
    $telefono = "";


    if (isset($Usuario['telefonousu'])) {
        $telefono = $Usuario['telefonousu'];
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

        <div class="container app-container">
            <?php
            Menu($SedeRol);
            ?>
            <!--Caso pantalla uno-->
            <div class="row-fluid">
                <div class="span2">
                    <ul class="nav nav-pills nav-stacked">
                        <li> <a href="mailboxs.php">Atrás</a> </li>
                    </ul>
                </div>

                <div class="span10" align="center">
                    <div class="tab-content" id="lista" align="center"> 
                        <form id="formulario" method="post">      
                            <div class="tab-content" id="lista" align="center"> 
                                <h2> Datos del Buzón </h2> 
                                <table class='footable table table-striped table-bordered'>
                                    <tr>
                                        <td style="text-align:center" >Nombre</td>
                                        <td style="text-align:center"><input type="text" name="nombre" id="nombre" autocomplete="off" value="<?php echo $Usuario['nombrebuz']; ?>" maxlength="150" size="30"  autofocus required></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center">Dirección</td>
                                        <td style="text-align:center"><input type="text" name="direccion" id="direccion" autocomplete="off" value="<?php echo $Usuario['direccionbuz']; ?>" maxlength="150" size="30"  ></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center">Teléfono </td>
                                        <td style="text-align:center"><input type="tel" name="telefono" id="telefono" autocomplete="off" value="<?php echo $telefono; ?>" maxlength="50" size="30"></td>
                                    </tr>
                                    <tr>
                                </table><br>
                                <div class="span11" align="center"><button class="btn" id="guardar" name="guardar" onclick="return confirm('¿Esta seguro que desea guardar los cambios?')" type="submit">Guardar</button></div>
                                <br>
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
            <script type="text/javascript" src="../js/jquery-2.0.3.js" ></script>

    </body>
</html>