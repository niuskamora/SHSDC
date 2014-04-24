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
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
        if ($SedeRol["idrol"]["idrol"] != "2" && $SedeRol["idrol"]["idrol"] != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }
    $idPaquete = array('idPaquete' => $_POST['idpaq']);
   // $Paquete = $client->ConsultarPaqueteXId($idPaquete);
	$consumo = $client->call("consultarPaqueteXId",$idPaquete);
	if ($consumo!="") {
	$Paquete = $consumo['return'];   
	}
    $usu = array('idusu' => $_SESSION["Usuario"]["idusu"]);
    if (isset($Paquete)) {
        $idPaquete = array('idpaq' => $_POST['idpaq']);
        $sede = array('idsed' => $_SESSION["Sede"]["idsed"]);
        $parametros = array('registroPaquete' => $idPaquete,
            'registroUsuario' => $usu,
            'registroSede' => $sede,
            'localizacion' => utf8_decode($_POST['localizacion']));
		$consumo = $client->call("seguimientoExterno",$parametros);
		if ($consumo!="") {
		$seg = $consumo['return'];   
		}
       // $seg = $client->seguimientoExterno($parametros);
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
            if ($seg == 0) {
                echo "<br>";
                echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>Paquete con seguimiento errado ,consulte con el administrador </h4>
		</div> ";
            } elseif ($seg== 1) {
                echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>Se ha enviado el paquete exitósamente </h4>
		</div> ";
            }
        } else {
            echo "<br>";
            echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No hay Correspondencia con ese código  </h4>
		</div> ";
        }
        ?>
    </div>

    <script src="../js/footable.js" type="text/javascript"></script>
    <script src="../js/footable.paginate.js" type="text/javascript"></script>
    <script src="../js/footable.sortable.js" type="text/javascript"></script>

    <?php
} catch (Exception $e) {
    utf8_encode(javaalert("Lo sentimos no hay conexión"));
    iraURL('../pages/inbox.php');
}
?>  