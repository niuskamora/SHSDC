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
	$idPaquete = array('codigo' => $_POST['idpaq']);
	$consumo = $client->call("consultarPaqueteXIdOCodigoBarras",$idPaquete);
	if ($consumo!="") {
	 $rowPaquete =$consumo['return'];
	}
	//$rowPaquete = $client->consultarPaqueteXIdOCodigoBarras($idPaquete);
	$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
        if ($SedeRol["idrol"]["idrol"] != "1" && $SedeRol["idrol"]["idrol"] != "2" && $SedeRol["idrol"]["idrol"] != "3" && $SedeRol["idrol"]["idrol"] != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

    $usuSede = array('iduse' => $SedeRol["iduse"],
        'idrol' => $SedeRol["idrol"],
        'idsed' => $SedeRol["idsed"]);
    $parametros = array('idUsuarioSede' => $usuSede);
	$consumo = $client->call("consultarPaquetesConfirmadosXRol",$parametros);
	if($consumo!=""){
	$PaquetesConfirmados= $consumo['return'];
	}
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
            if (strlen($rowPaquete["textopaq"]) > 10) {
                $contenido = utf8_decode(substr($rowPaquete["textopaq"], 0, 10)) . "...";
            } else {
                $contenido = utf8_decode($rowPaquete["textopaq"]);
            }
            if (strlen($rowPaquete["asuntopaq"]) > 10) {
                $asunto =utf8_decode( substr($rowPaquete["asuntopaq"], 0, 10)) . "...";
            } else {
                $asunto = utf8_decode($rowPaquete["asuntopaq"]);
            }
            if ($rowPaquete["destinopaq"]["tipobuz"] == 0) {
                $nombrebuz = utf8_decode($rowPaquete["destinopaq"]["idusu"]["nombreusu"] . " " . $rowPaquete["destinopaq"]["idusu"]["apellidousu"]);
            } else {
                $nombrebuz = utf8_decode($rowPaquete["destinopaq"]["nombrebuz"]);
            }
            echo "<br>";
            ?><table class='footable table table-striped table-bordered' align='center' >
                <thead bgcolor='#FF0000'>
                    <tr>	
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Origen</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Destino</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Tipo</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Contenido</th>
                        <th style='width:7%; text-align:center' data-sort-ignore="true">Con Respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>     
                        <td  style='text-align:center'><?php echo utf8_decode($rowPaquete["origenpaq"]["idusu"]["nombreusu"]  . " " . $rowPaquete["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                        <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                        <td style='text-align:center'><?php echo $asunto; ?></td>
                        <td style='text-align:center'><?php echo utf8_decode($rowPaquete["iddoc"]["nombredoc"]); ?></td>
                        <td style='text-align:center'><?php echo $contenido; ?></td>
                        <td style='text-align:center'><?php echo $rta; ?></td>  
                    </tr>
                </tbody>
            </table>
            <h3></h3><h3></h3>
            <div align="center"><button type="button" class="btn" onClick="pregunta();" name="confirma" >Confirmar</button></div>

            <?php
        } else {
            echo "<br>";
            echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No existen Paquetes con ese código </h4>
		</div> ";
        }
        if (isset($PaquetesConfirmados)) {

                                        echo "<br>";
                                        ?>

                                        <h2>Correspondencia que ha sido confirmada</h2>
                                        <table class='footable table table-striped table-bordered'  data-page-size=<?php echo $itemsByPage ?>>    
                                            <thead bgcolor='#FF0000'>
                                                <tr>	
                                                    <th style='width:7%; text-align:center'>Origen</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Destino</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Tipo</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Contenido</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Con Respuesta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!isset($PaquetesConfirmados[0])) {
                                                    if ($PaquetesConfirmados["respaq"] == "0") {
                                                        $rta = "No";
                                                    } else {
                                                        $rta = "Si";
                                                    }
                                                    if (strlen($PaquetesConfirmados["textopaq"]) > 10) {
                                                        $contenido =utf8_decode( substr($PaquetesConfirmados["textopaq"], 0, 10) ). "...";
                                                    } else {
                                                        $contenido =utf8_decode( $PaquetesConfirmados["textopaq"]);
                                                    }
                                                    if (strlen($PaquetesConfirmados["asuntopaq"]) > 10) {
                                                        $asunto = utf8_decode(substr($PaquetesConfirmados["asuntopaq"], 0, 10)) . "...";
                                                    } else {
                                                        $asunto = utf8_decode($PaquetesConfirmados["asuntopaq"]);
                                                    }
                                                    if ($PaquetesConfirmados["destinopaq"]["tipobuz"] == 0) {
                                                        $nombrebuz =utf8_decode( $PaquetesConfirmados["destinopaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados["destinopaq"]["idusu"]["apellidousu"]);
                                                    } else {
                                                        $nombrebuz =utf8_decode( $PaquetesConfirmados["destinopaq"]["nombrebuz"]);
                                                    }
                                                    ?>
                                                    <tr>     
                                                        <td  style='text-align:center'><?php echo utf8_decode($PaquetesConfirmados["origenpaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                                                        <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                        <td style='text-align:center'><?php echo $asunto; ?></td>
                                                        <td style='text-align:center'><?php echo utf8_decode($PaquetesConfirmados["iddoc"]["nombredoc"]); ?></td>
                                                        <td style='text-align:center'><?php echo $contenido; ?></td>
                                                        <td style='text-align:center'><?php echo $rta; ?></td>  
                                                    </tr>   
                                                    <?php
                                                } else {
                                                    for ($i = 0; $i < count($PaquetesConfirmados); $i++) {
                                                        if ($PaquetesConfirmados[$i]["respaq"] == "0") {
                                                            $rta = "No";
                                                        } else {
                                                            $rta = "Si";
                                                        }
                                                        if (strlen($PaquetesConfirmados[$i]["textopaq"]) > 25) {
                                                            $contenido = utf8_decode(substr($PaquetesConfirmados[$i]["textopaq"], 0, 23)) . "...";
                                                        } else {
                                                            $contenido = utf8_decode($PaquetesConfirmados[$i]["textopaq"]);
                                                        }
                                                        if (strlen($PaquetesConfirmados[$i]["asuntopaq"]) > 10) {
                                                            $asunto = utf8_decode(substr($PaquetesConfirmados[$i]["asuntopaq"], 0, 10)) . "...";
                                                        } else {
                                                            $asunto = utf8_decode($PaquetesConfirmados[$i]["asuntopaq"]);
                                                        }
                                                        if ($PaquetesConfirmados[$i]["destinopaq"]["tipobuz"] == 0) {
                                                            $nombrebuz = utf8_decode($PaquetesConfirmados[$i]["destinopaq"]["idusu"]["nombreusu"] . " " . $PaquetesConfirmados[$i]["destinopaq"]["idusu"]["apellidousu"]);
                                                        } else {
                                                            $nombrebuz =utf8_decode( $PaquetesConfirmados[$i]["destinopaq"]["nombrebuz"]);
                                                        }
                                                        ?>
                                                        <tr>     
                                                            <td  style='text-align:center'><?php echo utf8_decode($PaquetesConfirmados[$i]["origenpaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados[$i]["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                                                            <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                            <td style='text-align:center'><?php echo $asunto; ?></td>
                                                            <td style='text-align:center'><?php echo utf8_decode($PaquetesConfirmados[$i]["iddoc"]["nombredoc"]); ?></td>
                                                            <td style='text-align:center'><?php echo $contenido; ?></td>
                                                            <td style='text-align:center'><?php echo $rta; ?></td>  
                                                        </tr>   
                                                        <?php
                                                    }
                                                }//fin else
                                                ?>  
                                            </tbody>
                                        </table>
                                        <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>					

                                        <?php
                                    }
        ?>
    </div>

    <script src="../js/footable.js" type="text/javascript"></script>
    <script src="../js/footable.paginate.js" type="text/javascript"></script>
    <script src="../js/footable.sortable.js" type="text/javascript"></script>
    <script language="JavaScript" type="text/javascript">
                function pregunta() {
                    confirmar = confirm("¿Esta seguro que desea confirmar el paquete?");
                    if (confirmar)
                        Confirma();
                }
    </script>

    <script>
        function Confirma() {
            var idpaq = '<?= $_POST['idpaq'] ?>';
            var parametros = {
                "idpaq": idpaq
            };
            $.ajax({
                type: "POST",
                url: "../ajax/confirmed.php",
                data: parametros,
                dataType: "text",
                success: function(response) {
                    $("#data").html(response);
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