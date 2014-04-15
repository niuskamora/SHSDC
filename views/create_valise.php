<?php
if (isset($_POST["guardar"]) && isset($_POST["ide"])) {
    try {
        $registrosAValija = $_POST["ide"];
        $contadorAceptados = 0;
        $datosValija = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sorigen' => $_SESSION["Sede"]->return->idsed, 'sdestino' => $_SESSION["seded"], 'fechaapaq' => date('Y-m-d', strtotime(str_replace('/', '-', "27/03/2014"))));
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $idValija = $client->insertarValija($datosValija);
        $usu = array('idusu' => $_SESSION["Usuario"]->return->idusu);
        $sede = array('idsed' => $_SESSION["Sede"]->return->idsed);
        for ($j = 0; $j < $_SESSION["reg"]; $j++) {
            if (isset($registrosAValija[$j])) {
                $datosAct = array('idpaq' => $registrosAValija[$j], 'idval' => $idValija->return);
                $client->ActualizacionLocalizacionyValijaDelPaquete($datosAct);
                $idPaquete = array('idpaq' => $registrosAValija[$j]);
                $parametros = array('registroPaquete' => $idPaquete, 'registroUsuario' => $usu, 'registroSede' => $sede, 'Caso' => "0");
                $seg = $client->registroSeguimiento($parametros);
            }
        }
        echo"<script>window.open('../pages/proof_pouch.php');</script>";
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../index.php');
    }
    //javaalert("Los registros han sido habilitados");
    //iraURL('inbox.php');
} else if (isset($_POST["guardar"])) {
    javaalert("Debe seleccionar al menos un registro");
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

        <!-- javascript para el funcionamiento del calendario -->
        <link rel="stylesheet" type="text/css" href="../js/ui-lightness/jquery-ui-1.10.3.custom.css" media="all" />
        <script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.js" ></script> 
        <script type="text/javascript" src="../js/calendarioValidado.js" ></script> 
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
                            <li> <a href="inbox.php">Atrás</a> <li>
                            <li> <a href="confirm_valise.php">Confirmar valija</a> <li>
                        </ul>
                    </div>

                    <div class="span10">
                        <div class="tab-content" id="lista">
                            <h2> <strong> Realizar Valija </strong> </h2>
                            <?php if ($reg != 0) { ?>
                                <form class="form-Cvalija">
                                    <div class="span6" >
                                        Elija el destino:  <select onChange="sede();" name="Destinos"> <option value="" style="display:none">Seleccionar:</option> 
                                            <?php
                                            if ($reg > 1) {
                                                $i = 0;
                                                while ($reg > $i) {
                                                    echo '<option value="' . $Sedes->return[$i] . '">' . $Sedes->return[$i] . '</option>';
                                                    $i++;
                                                }
                                            } else {
                                                echo '<option value="' . $Sedes->return . '">' . $Sedes->return . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="span6" >
                                    </div>
                                </form>
                                <br>
                                <?php
                            } else {
                                echo"<div class='alert alert-block' align='center'>
									<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
									<h4 align='center'>No hay Paquetes para realizar Valija</h4>
								</div> ";
                            }
                            ?>
                            <div  id="registro">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /container -->
        <div id="footer" class="container">    	
        </div>
    </div>
    <script>
		function sede() {
			$.ajax({
				type: "POST",
				url: "../ajax/create_valise.php",
				data: {'sed': $("#lista option:selected").text()},
                dataType: "text",
				success: function(response) {
					$("#registro").html(response);
				}
			});
		}

    </script>
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