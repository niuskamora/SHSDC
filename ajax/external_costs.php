<?php
session_start();
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
} elseif (!isset($_POST['idpaq'])) {
    iraURL("../pages/inbox.php");
}
try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $idPaquete = array('idPaquete' => $_POST['idpaq']);
    $rowPaquete = $client->ConsultarPaqueteXId($idPaquete);
    $idsede = array('idsed' => $_SESSION["Sede"]->return->idsed);
    $sede = array('sede' => $idsede);

    $resultadoProveedor = $client->consultarProveedorXSede($sede);
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
        if (isset($rowPaquete->return)) {
            if ($rowPaquete->return->respaq == "0") {
                $rta = "No";
            } else {
                $rta = "Si";
            }
            if (strlen($rowPaquete->return->textopaq) > 10) {
                $contenido = substr($rowPaquete->return->textopaq, 0, 10) . "...";
            } else {
                $contenido = $rowPaquete->return->textopaq;
            }
            if (strlen($rowPaquete->return->asuntopaq) > 10) {
                $asunto = substr($rowPaquete->return->asuntopaq, 0, 10) . "...";
            } else {
                $asunto = $rowPaquete->return->asuntopaq;
            }
            echo "<br>";
            ?>  <h2>Correspondencia seleccionada</h2>
            <table class='footable table table-striped table-bordered'>    
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
                    <?php
                    if ($rowPaquete->return->respaq == "0") {
                        $rta = "No";
                    } else {
                        $rta = "Si";
                    }
                    if (strlen($rowPaquete->return->asuntopaq) > 10) {
                        $asunto = substr($rowPaquete->return->asuntopaq, 0, 10) . "...";
                    } else {
                        $asunto = $rowPaquete->return->asuntopaq;
                    }
                    ?>
                    <tr>   
                        <td  style='text-align:center'><?php echo $rowPaquete->return->idpaq; ?></td>	
                        <td  style='text-align:center'><?php echo $rowPaquete->return->origenpaq->idusu->nombreusu . " " . $rowPaquete->return->origenpaq->idusu->apellidousu; ?></td>
                        <td style='text-align:center'><?php echo $rowPaquete->return->destinopaq->nombrebuz; ?></td>
                        <td style='text-align:center'><?php echo $asunto; ?></td>
                        <td style='text-align:center'><?php echo $rta; ?></td>
                        <td style='text-align:center'><?php echo date("d/m/Y", strtotime(substr($rowPaquete->return->fechapaq, 0, 10))); ?></td>
                    </tr>   
                </tbody>
            </table>
            <div class="span4" align="right"><b>Proveedor:</b> </div>
            <div class="span3" align="left">
                <select name='proveedor' id='proveedor' required  title='Seleccione el Proveedor'>
                    <option value='' style='display:none'>Seleccionar:</option>
                    <?php
                    if (count($resultadoProveedor->return) > 1) {
                        $i = 0;
                        while (count($resultadoProveedor->return) > $i) {
                            echo "<option value='" . $resultadoProveedor->return[$i]->nombrepro . "' >" . $resultadoProveedor->return[$i]->nombrepro . "</option>";
                            $i++;
                        }
                    } else {
                        echo "<option value='" . $resultadoProveedor->return->nombrepro . "' >" . $resultadoProveedor->return->nombrepro . "</option>";
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
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>