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
	$consumo = $client->call("consultarPaqueteXId",$idPaquete);
	if ($consumo!="") {
	 $Paquete =$consumo['return'];
	}
    $usu = array('idusu' => $_SESSION["Usuario"]["idusu"]);
    if (isset($Paquete)) {
        $idPaquete = array('idpaq' => $_POST['idpaq']);
        $sede = array('idsed' => $_SESSION["Sede"]["idsed"]);
        $parametros = array('registroPaquete' => $idPaquete,
            'registroUsuario' => $usu,
            'registroSede' => $sede,
            'Caso' => "Confirmar");
		$consumo = $client->call("registroSeguimiento",$parametros);
		if ($consumo!="") {
		 $seg =$consumo['return'];
		}
        if ($seg == 0) {
            echo "<br>";
            echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>El paquete ya fue confirmado </h4>
		</div> ";
        } elseif ($seg == 2) {
            echo "<br>";
            echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>Paquete con seguimiento errado ,consulte con el administrador </h4>
		</div> ";
        } elseif ($seg == 1) {
            utf8_encode(javaalert("Se ha confirmado el paquete exitósamente"));
        }
    } else {
        echo "<br>";
        echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No hay Correspondencia con ese código  </h4>
		</div> ";
    }
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


    <?php
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
                                                    if (strlen(utf8_encode($PaquetesConfirmados["textopaq"])) > 10) {
                                                        $contenido =substr(utf8_encode( $PaquetesConfirmados["textopaq"]), 0, 10 ). "...";
                                                    } else {
                                                        $contenido =utf8_encode( $PaquetesConfirmados["textopaq"]);
                                                    }
                                                    if (strlen(utf8_encode($PaquetesConfirmados["asuntopaq"])) > 10) {
                                                        $asunto = substr(utf8_encode($PaquetesConfirmados["asuntopaq"]), 0, 10) . "...";
                                                    } else {
                                                        $asunto = utf8_encode($PaquetesConfirmados["asuntopaq"]);
                                                    }
                                                    if ($PaquetesConfirmados["destinopaq"]["tipobuz"] == 0) {
                                                        $nombrebuz =utf8_encode( $PaquetesConfirmados["destinopaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados["destinopaq"]["idusu"]["apellidousu"]);
                                                    } else {
                                                        $nombrebuz =utf8_encode( $PaquetesConfirmados["destinopaq"]["nombrebuz"]);
                                                    }
                                                    ?>
                                                    <tr>     
                                                        <td  style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados["origenpaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                                                        <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                        <td style='text-align:center'><?php echo $asunto; ?></td>
                                                        <td style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados["iddoc"]["nombredoc"]); ?></td>
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
                                                        if (strlen(utf8_encode($PaquetesConfirmados[$i]["textopaq"])) > 25) {
                                                            $contenido = substr(utf8_encode($PaquetesConfirmados[$i]["textopaq"]), 0, 23). "...";
                                                        } else {
                                                            $contenido = utf8_encode($PaquetesConfirmados[$i]["textopaq"]);
                                                        }
                                                        if (strlen(utf8_encode($PaquetesConfirmados[$i]["asuntopaq"])) > 10) {
                                                            $asunto =substr( utf8_encode($PaquetesConfirmados[$i]["asuntopaq"]), 0, 10) . "...";
                                                        } else {
                                                            $asunto = utf8_encode($PaquetesConfirmados[$i]["asuntopaq"]);
                                                        }
                                                        if ($PaquetesConfirmados[$i]["destinopaq"]["tipobuz"] == 0) {
                                                            $nombrebuz = utf8_encode($PaquetesConfirmados[$i]["destinopaq"]["idusu"]["nombreusu"] . " " . $PaquetesConfirmados[$i]["destinopaq"]["idusu"]["apellidousu"]);
                                                        } else {
                                                            $nombrebuz =utf8_encode( $PaquetesConfirmados[$i]["destinopaq"]["nombrebuz"]);
                                                        }
                                                        ?>
                                                        <tr>     
                                                            <td  style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados[$i]["origenpaq"]["idusu"]["nombreusu"]. " " . $PaquetesConfirmados[$i]["origenpaq"]["idusu"]["apellidousu"]); ?></td>
                                                            <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                            <td style='text-align:center'><?php echo $asunto; ?></td>
                                                            <td style='text-align:center'><?php echo utf8_encode($PaquetesConfirmados[$i]["iddoc"]["nombredoc"]); ?></td>
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
    <script src="../js/footable.js" type="text/javascript"></script>
    <script src="../js/footable.paginate.js" type="text/javascript"></script>
    <script src="../js/footable.sortable.js" type="text/javascript"></script>

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