
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
                            <li> <a href="../pages/send_correspondence.php">Atrás</a> </li>
                        </ul>
                    </div>

                    <div class="span10" align="center">
                        <div class="tab-content" id="lista" align="center"> 
                            <form id="formulario" method="post">                            
                                <h2> Datos del Buzón Externo </h2> 
                                <table class='footable table table-striped table-bordered'>
                                    <tr>
                                        <td style="text-align:center" >Nombre</td>
                                        <td style="text-align:center"><input type="text" name="nombre" id="nombre" maxlength="19" size="30" title="Ingrese el primer nombre" placeholder="Ej. Jose" autofocus autocomplete="off" required></td>
                                    </tr>

                                    <tr>
                                        <td style="text-align:center" width="50%">Cédula o Rif</td>
                                        <td style="text-align:center"><input type="text" name="cedularif" id="cedularif" maxlength="19" size="30" title="Ingrese el número de cédula o Rif" placeholder="Ej. V-18.876.543 " autocomplete="off" required>
                                        </td>		
                                    </tr>
                                    <tr>
                                        <td style="text-align:center" width="50%">Correo</td>
                                        <td style="text-align:center"><input type="email" name="correo" id="correo" maxlength="100" size="50" title="Ingrese un correo" autocomplete="off" placeholder="Ej. josefuentes@gmail.com">
                                            <div id="Info2" style="float:right"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center">Teléfono</td>
                                        <td style="text-align:center"><input type="tel" name="telefono" id="telefono" maxlength="19" size="30" autocomplete="off" title="Ingrese el número de teléfono" placeholder="Ej. 04269876543"   required></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center">Dirección</td>
                                        <td style="text-align:center"><textarea id="direccion" name="direccion" style="width:500px"></textarea></td>	 
                                    </tr>
                                </table>
                                <br>
                                <div class="span11" align="center"><button class="btn" id="crear" name="crear" type="submit">Guardar</button></div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.onload = function(){killerSession();}
             
             function killerSession(){
             setTimeout("window.open('../recursos/cerrarsesion.php','_top');",300000);
             }
        </script>

    </body>
</html>