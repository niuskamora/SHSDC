<?php
if ($nomUsuario == "") {
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
                                <a href="../pages/confirm_package.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <?php
                            //Verificando que este vacio o sea null
                            if (!isset($resultadoPaquetesConfirmados->return)) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No Existen Registros para Imprimir Comprobante</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro la tabla
                            else {
                                ?>
                                <form class="form-search" id="formulario" method="post">                   
                                    <strong> <h2 align="center">Comprobante de Correspondencia Confirmada</h2> </strong>
                                    <table class='footable table table-striped table-bordered'  data-page-size=$itemsByPage>
                                        <thead bgcolor='#FF0000'>
                                            <tr>
                                                <th style="text-align:center">Nro de Paquete</th>
                                                <th style="text-align:center" data-sort-ignore="true">Origen</th>
                                                <th style="text-align:center" data-sort-ignore="true">Destino</th>
                                                <th style="text-align:center" data-sort-ignore="true">Tipo</th>
                                                <th style="text-align:center" data-sort-ignore="true">Con Respuesta</th>
                                                <th style="text-align:center" data-sort-ignore="true">Imprimir</th>                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($paquetes > 1) {
                                                for ($i = 0; $i < $paquetes; $i++) {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align:center"><?php echo $resultadoPaquetesConfirmados->return[$i]->idpaq ?></td>
                                                        <?php if (isset($resultadoPaquetesConfirmados->return[$i]->origenpaq->idusu->apellidousu)) { ?>
                                                            <td><?php echo $resultadoPaquetesConfirmados->return[$i]->origenpaq->idusu->nombreusu . ' ' . $resultadoPaquetesConfirmados->return[$i]->origenpaq->idusu->apellidousu ?></td>
                                                        <?php } else {
                                                            ?>
                                                            <td><?php echo $resultadoPaquetesConfirmados->return[$i]->origenpaq->idusu->nombreusu ?></td>                                                    
                                                            <?php
                                                        }
                                                        if ($resultadoPaquetesConfirmados->return[$i]->destinopaq->tipobuz == '0') {
                                                            if (isset($resultadoPaquetesConfirmados->return[$i]->destinopaq->idusu->apellidousu)) {
                                                                ?>
                                                                <td><?php echo $resultadoPaquetesConfirmados->return[$i]->destinopaq->idusu->nombreusu . ' ' . $resultadoPaquetesConfirmados->return[$i]->destinopaq->idusu->apellidousu ?></td>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <td><?php echo $resultadoPaquetesConfirmados->return[$i]->destinopaq->idusu->nombreusu ?></td>																
                                                                <?php
                                                            }
                                                        }
                                                        if ($resultadoPaquetesConfirmados->return[$i]->destinopaq->tipobuz == '1') {
                                                            ?>
                                                            <td><?php echo $resultadoPaquetesConfirmados->return[$i]->destinopaq->nombrebuz ?></td>
                                                        <?php } ?>                                                        
                                                        <td style="text-align:center"><?php echo $resultadoPaquetesConfirmados->return[$i]->iddoc->nombredoc ?></td>
                                                        <?php if ($resultadoPaquetesConfirmados->return[$i]->respaq == '0') { ?>
                                                            <td style="text-align:center"><?php echo "No" ?></td>
                                                        <?php } else {
                                                            ?>
                                                            <td style="text-align:center"><?php echo "Si" ?></td>
                                                        <?php } ?>
                                                        <?php echo '<td style="text-align:center"><input type="checkbox" name="ide[' . $i . ']" id="ide[' . $i . ']" value=' . $resultadoPaquetesConfirmados->return[$i]->idpaq . '></td>'; ?>			
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td style="text-align:center"><?php echo $resultadoPaquetesConfirmados->return->idpaq ?></td>
                                                    <?php if (isset($resultadoPaquetesConfirmados->return->origenpaq->idusu->apellidousu)) { ?>
                                                        <td><?php echo $resultadoPaquetesConfirmados->return->origenpaq->idusu->nombreusu . ' ' . $resultadoPaquetesConfirmados->return->origenpaq->idusu->apellidousu ?></td>
                                                    <?php } else {
                                                        ?>
                                                        <td><?php echo $resultadoPaquetesConfirmados->return->origenpaq->idusu->nombreusu ?></td>                                                    
                                                        <?php
                                                    }
                                                    if ($resultadoPaquetesConfirmados->return->destinopaq->tipobuz == '0') {
                                                        if (isset($resultadoPaquetesConfirmados->return->destinopaq->idusu->apellidousu)) {
                                                            ?>
                                                            <td><?php echo $resultadoPaquetesConfirmados->return->destinopaq->idusu->nombreusu . ' ' . $resultadoPaquetesConfirmados->return->destinopaq->idusu->apellidousu ?></td>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td><?php echo $resultadoPaquetesConfirmados->return->destinopaq->idusu->nombreusu ?></td>																
                                                            <?php
                                                        }
                                                    }
                                                    if ($resultadoPaquetesConfirmados->return->destinopaq->tipobuz == '1') {
                                                        ?>
                                                        <td><?php echo $resultadoPaquetesConfirmados->return->destinopaq->nombrebuz ?></td>
                                                    <?php } ?>
                                                    <td style="text-align:center"><?php echo $resultadoPaquetesConfirmados->return->iddoc->nombredoc ?></td>
                                                    <?php if ($resultadoPaquetesConfirmados->return->respaq == '0') { ?>
                                                        <td style="text-align:center"><?php echo "No" ?></td>
                                                    <?php } else {
                                                        ?>
                                                        <td style="text-align:center"><?php echo "Si" ?></td>
                                                    <?php } ?>
                                                    <?php echo '<td style="text-align:center"><input type="checkbox" name="ide[0]" id="ide[0]" value=' . $resultadoPaquetesConfirmados->return->idpaq . '></td>'; ?>
                                                </tr>
                                            <?php } ?>                                    
                                        </tbody>
                                    </table>                            
                                    <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>
                                    <br>
                                    <div align="right">
                                        <button type="submit" class="btn" id="imprimir" name="imprimir">Imprimir Comprobante</button>                                
                                    </div>
                                </form>
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