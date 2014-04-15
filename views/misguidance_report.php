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
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>

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
                                <a href="../pages/administration.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="span10">
                        <form class="form-search" method="post">
                            <div class="tab-content" id="bandeja">
                                <strong> <h2 align="center">Reportar Paquete por extravió</h2> </strong>                
                                <div align="center">
                                    Código de Correspondencia:  
                                    <input type="text" id="cPaquete" name="cPaquete" class="input-medium search-query" placeholder="Ej. 4246" title="Ingrese el código de Correspondencia" autocomplete="off" pattern="[0-9]{1,38}"> 
                                    <br>
                                    <br>                           
                                    Por favor detalle lo sucedido con el Paquete.
                                    <br>
                                    <textarea rows="5" cols="5" id="datosPaquete" name="datosPaquete" style="width:600px"></textarea>
                                    <br>
                                    <br>
                                    <button type="submit" class="btn" id="reportarPaqExc" name="reportarPaqExc" onclick="return confirm('¿Esta seguro que desea reportar por extravió la Correspondencia?')">Reportar</button>
                                    <h6>(se recomienda realizar el acta correspondiente)</h6>
                                </div>               
                            </div>
                            <div class="tab-content" id="bandeja">
                                <strong> <h2 align="center">Reportar Valija por extravió</h2> </strong>                
                                <div align="center">
                                    Código de Valija:  
                                    <input type="text" id="cValija" name="cValija" class="input-medium search-query" placeholder="Ej. 4246" title="Ingrese el código de la Valija" autocomplete="off" pattern="[0-9]{1,38}">
                                    <br>
                                    <br>
                                    Por favor detalle lo sucedido con la Valija.
                                    <br>
                                    <textarea rows="5" cols="5" id="datosValija" name="datosValija" style="width:600px"></textarea>
                                    <br>
                                    <br>
                                    <button type="submit" class="btn" id="reportarValija" name="reportarValija" onclick="return confirm('¿Esta seguro que desea reportar por extravió la Valija?')">Reportar</button>
                                    <h6>(se recomienda realizar el acta correspondiente)</h6>
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