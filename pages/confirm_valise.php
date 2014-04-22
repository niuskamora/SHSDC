<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["cli"] = $client;

if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"],
    'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol", $UsuarioRol);

if ($consumo != "") {
    $SedeRol = $consumo['return'];
    if ($SedeRol['idrol']['idrol'] != "4" && $SedeRol['idrol']['idrol'] != "5") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$usuarioBitacora = $_SESSION["Usuario"]["idusu"];
$sede = $_SESSION["Sede"]["idsed"];

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$idsede = array('idsed' => $sede);
$sedeP = array('sede' => $idsede);
$consumoProveedorXSede = $client->call("consultarProveedorXSede", $sedeP);

if ($consumoProveedorXSede != "") {
    $resultadoProveedor = $consumoProveedorXSede['return'];
    if (isset($resultadoProveedor[0])) {
        $proveedor = count($resultadoProveedor);
    } else {
        $proveedor = 1;
    }
} else {
    $proveedor = 0;
}

if (isset($_POST["confirmar"])) {

    if (isset($_POST["cValija"]) && $_POST["cValija"] != "" && isset($_POST["cProveedor"]) && $_POST["cProveedor"] != "" && isset($_POST["proveedor"]) && $_POST["proveedor"] != "") {

        try {
            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $valija = $_POST["cValija"];
            $Val = array('codigo' => $valija);
            $consumoValija = $client->call("consultarValijaXIdOCodigoBarra", $Val);

            if ($consumoValija != "") {
                $Valijac = $consumoValija['return'];
                $idVal = $Valijac['idval'];
                $parametros = array('idValija' => $idVal,
                    'proveedor' => $_POST["proveedor"],
                    'codProveedor' => $_POST["cProveedor"]);
                $consumoConfirmar = $client->call("confirmarValija", $parametros);
                if ($consumoConfirmar != "") {
                    $confirmarValija = $consumoConfirmar['return'];
                    if ($confirmarValija == 1) {
                        javaalert('Valija Confirmada');
                        llenarLog(2, "Confirmación de Valija", $usuarioBitacora, $sede);
                        iraURL('../pages/create_valise.php');
                    } else {
                        javaalert('Valija No Confirmada');
                        iraURL('../pages/create_valise.php');
                    }
                }
            } else {
                javaalert('Valija No Confirmada');
                iraURL('../pages/create_valise.php');
            }
        } catch (Exception $e) {
            javaalert('Lo sentimos no hay conexion');
            iraURL('../pages/create_valise.php');
        }
    } else {
        javaalert("Debe agregar todos los campos, por favor verifique");
    }
}
include("../views/confirm_valise.php");
?>