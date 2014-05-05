<?php
session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

try {
 $client = new nusoap_client($wsdl_sdc, 'wsdl');
	 $_SESSION["cli"]=$client;	

    if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
	} elseif (!usuarioCreado()) {
		iraURL("../pages/create_user.php");
	} elseif (!isset($_POST['idpaq'])) {
		iraURL("../pages/inbox.php");
	}      
    $idPaquete = array('idPaquete' => $_POST['idpaq']);
   // $rowPaquete = $client->ConsultarPaqueteXId($idPaquete);
   $consumo = $client->call("consultarPaqueteXId",$idPaquete);
	if ($consumo!="") {
	$rowPaquete = $consumo['return'];   
	}
    $idsede = array('idsed' => $_SESSION["Sede"]["idsed"]);
    $sede = array('sede' => $idsede);
	$consumo = $client->call("consultarProveedorXSede",$sede);
	if ($consumo!="") {
	$resultadoProveedor = $consumo['return'];   
	}
   //$resultadoProveedor = $client->consultarProveedorXSede($sede);
    ?>

    <!-- styles -->
    <link rel="shortcut icon" href="../images/faviconsh.ico">

    <link href="../css/bootstrap.css" rel="stylesheet">
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

    <div id="data">
        <?php
        if (isset($rowPaquete)) {
            if ($rowPaquete["respaq"] == "0") {
                $rta = "No";
            } else {
                $rta = "Si";
            }
            if (strlen(utf8_encode($rowPaquete["textopaq"])) > 10) {
                $contenido = substr(utf8_encode($rowPaquete["textopaq"]), 0, 10) . "...";
            } else {
                $contenido = utf8_encode($rowPaquete["textopaq"]);
            }
            if (strlen(utf8_encode($rowPaquete["asuntopaq"])) > 10) {
                $asunto = substr(utf8_encode($rowPaquete["asuntopaq"]), 0, 10) . "...";
            } else {
                $asunto = utf8_encode($rowPaquete["asuntopaq"]);
            }
            echo "<br>";
            ?>  <h2>Correspondencia seleccionada</h2>
            <table class='footable table table-striped table-bordered' >    
                <thead bgcolor='#FF0000'>
                    <tr>	
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Código</th> 
                        <th style='width:7%; text-align:center' data-sort-ignore="true" >Origen</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Destino</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">C/R</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>   
                        <td  style='text-align:center'><?php echo $rowPaquete["idpaq"]; ?></td>	
                        <td  style='text-align:center'><?php echo utf8_encode($rowPaquete["origenpaq"]["idusu"]["nombreusu"] . " " . $rowPaquete["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                        <td style='text-align:center'><?php echo utf8_encode($rowPaquete["destinopaq"]["nombrebuz"]); ?></td>
                        <td style='text-align:center'><?php echo $asunto; ?></td>
                        <td style='text-align:center'><?php echo $rta; ?></td>
                        <td style='text-align:center'><?php echo date("d/m/Y", strtotime(substr($rowPaquete["fechapaq"], 0, 10))); ?></td>
                    </tr>   
                </tbody>
            </table>
            <div class="span4" align="right"><b>Proveedor:</b> </div>
            <div class="span3" align="left">
                <select name='proveedor' id='proveedor' required  title='Seleccione el Proveedor'>
                    <option value='' style='display:none'>Seleccionar:</option>
                    <?php
                    if (isset($resultadoProveedor[0])) {
                        $i = 0;
                        while (count($resultadoProveedor) > $i) {
                            echo "<option value='" . utf8_encode($resultadoProveedor[$i]["nombrepro"]) . "' >" .utf8_encode($resultadoProveedor[$i]["nombrepro"]). "</option>";
                            $i++;
                        }
                    } else {
                        echo "<option value='" . utf8_encode($resultadoProveedor["nombrepro"]) . "' >" . utf8_encode($resultadoProveedor["nombrepro"]) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <br><br><br>
            <div class="span4" align="right"><b>Código del Proveedor:</b></div>
            <div class="span3" align="left">
                <input type="text" class="input-block-level" name="cProveedor" id="cProveedor" placeholder="Ej. 1234" title="Ingrese el código de Guía" autocomplete="off" required>
            </div>

            <br><br><br>

            <div align="center"><button type="button" class="btn" onClick="pregunta();" name="confirma" >Enviar Correspondencia</button></div>

            <?php
        } else {
            echo "<br>";
            echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No existen Paquetes con ese código </h4>
		</div> ";
        }
        ?>
    </div>

    <script src="../js/footable.js" type="text/javascript"></script>
    <script src="../js/footable.paginate.js" type="text/javascript"></script>
    <script src="../js/footable.sortable.js" type="text/javascript"></script>
    <script language="JavaScript" type="text/javascript">
                function pregunta() {
                    confirmar = confirm("¿Esta seguro que desea enviar el paquete?");
                    if (confirmar)
                        Confirma();
                }
    </script>

    <script>
        function Confirma() {
            var idpaq = '<?= $_POST['idpaq'] ?>';
            var parametros = {
                "idpaq": idpaq, "localizacion": $('#proveedor').val() + ':' + $('#cProveedor').val()
            };
            $.ajax({
                type: "POST",
                url: "../ajax/external_final.php",
                data: parametros,
                dataType: "text",
                success: function(response) {
                    $("#data").html(response);
                }

            });
            $.ajax({
                type: "POST",
                url: "verificar.php",
                data: {'usuario': '0', 'pass': $('#password').val()},
                dataType: "text",
                beforeSend: function() {
                    $("#capa4").html("Procesando, espere por favor...").delay(1000);

                },
                success: function(response) {
                    $("#capa4").html(response).delay(1000);
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $('table').footable();
        });
    </script>

    <?php
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
?>