<?php
if (!isset($Sedes->return)) {
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

        <div class="container app-container">
            <div>
                <ul class="nav nav-pills">
                    <li class="pull-left">
                        <div class="modal-header" style="width:1135px;">
                            <h3> Correspondencia    
                                <span>SH</span> Bienvenido
                                <div class="btn-group  pull-right">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"> <span class="icon-cog" style="color:rgb(255,255,255)"> Configuración </span> </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="../recursos/cerrarsesion.php" onClick="">Salir</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Ayuda</a></li>
                                    </ul>
                                </div>                              

                            </h3>
                        </div>
                    </li>
                </ul>
            </div>
            <!--Caso pantalla uno-->
            <div class="row-fluid">
                <div class="span2">
                    <ul class="nav nav-pills nav-stacked">
                        <li> <a href="../index.php">Atrás</a> </li>
                    </ul>
                </div>

                <div class="span10" align="center">
                    <div class="tab-content" id="lista" align="center"> 
                        <form id="formulario" method="post">
                            <h2> Datos del Usuario </h2> 
                            <table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style="text-align:center" >Nombres</td>
                                    <td style="text-align:center"><input type="text" name="nombre" id="nombre" autocomplete="off" maxlength="150" size="30" title="Ingrese el primer nombre" placeholder="Ej. Pedro" autofocus required></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">Apellidos</td>
                                    <td style="text-align:center"><input type="text" name="apellido" id="apellido" autocomplete="off" maxlength="150" size="30" title="Ingrese el  apellido" placeholder="Ej. Perez"  required></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center" width="50%">Correo</td>
                                    <td style="text-align:center"><input type="email" name="correo" id="correo" autocomplete="off" maxlength="50" size="50" title="Ingrese un correo" placeholder="Ej. pedroperez@gmail.com">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">Teléfono 1</td>
                                    <td style="text-align:center"><input type="tel" name="telefono1" id="telefono1" autocomplete="off" maxlength="50" size="30" title="Ingrese el número de teléfono" placeholder="Ej. 04269876543"   ></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">Teléfono Adicional</td>
                                    <td style="text-align:center"><input type="tel" name="telefono2" id="telefono2" autocomplete="off" maxlength="50" size="30" placeholder="Ej. 04168674789"  ></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">Sede</td>
                                    <td style="text-align:center"><select onChange="areas();
                                            direccion();" id="sede" name="sede" required  title="Seleccione la Sede a la que pertenece">
                                            <option value="" style="display:none">Seleccionar:</option>                                  
                                            <?php
                                            if (count($Sedes->return) == 1) {
                                                echo '<option value="' . $Sedes->return->idsed . '">' . $Sedes->return->nombresed . '</option>';
                                            } else {
                                                for ($i = 0; $i < count($Sedes->return); $i++) {
                                                    echo '<option value="' . $Sedes->return[$i]->idsed . '">' . $Sedes->return[$i]->nombresed . '</option>';
                                                }
                                            }
                                            ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">Área de Trabajo</td>
                                    <td style="text-align:center"><select id="area" name="area"  required  title="Seleccione el área de trabajo a la que pertenece">
                                            <option value="" style="display:none">Seleccionar:</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">Cargo</td>
                                    <td style="text-align:center"><input type="text" name="cargo" id="cargo" autocomplete="off" maxlength="150" size="30" title="Ingrese su cargo" placeholder="Ej. Analista"  required></td>
                                </tr>
                                <tr>
                                    <td style="text-align:center" >Dirección</td>
                                    <td style="text-align:center"><textarea  style="width:500px;"   id="direccion1" name="direccion1" maxlength="2000"  style="width:800px" ></textarea></td>
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

        <script>
            window.onload = function() {
                killerSession();
            }
            function killerSession() {
                setTimeout("window.open('../recursos/cerrarsesion.php','_top');", 300000);
            }
        </script>

        <script>
            function areas() {
                //posicion
                var $selectedOption = $('#sede').find('option:selected');
                var id = $selectedOption.val();
                $.ajax({
                    type: "POST",
                    url: "../ajax/user_headquarters_mail.php",
                    data: {'sed': id},
                    dataType: "text",
                    success: function(response) {
                        $("#area").html(response);
                    }

                });


            }
            function direccion() {
                document.forms.formulario.direccion1.value = document.forms.formulario.sede.value;
            }
        </script>
        <script src="../js/footable.js" type="text/javascript"></script>
        <script src="../js/footable.paginate.js" type="text/javascript"></script>
        <script src="../js/footable.sortable.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery-2.0.3.js" ></script> 

    </body>
</html>