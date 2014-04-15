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
}

$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);

if (isset($SedeRol->return)) {
    if ($SedeRol->return->idrol->idrol != "4" && $SedeRol->return->idrol->idrol != "5") {
        iraURL('../pages/inbox.php');
    }
} else {
    iraURL('../pages/inbox.php');
}

$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$sede = $_SESSION["Sede"]->return->idsed;

$idsede = array('idsed' => $sede);
$sedeP = array('sede' => $idsede);
$resultadoProveedor = $client->consultarProveedorXSede($sedeP);
if (!isset($resultadoProveedor->return)) {
    $proveedor = 0;
} else {
    $proveedor = count($resultadoProveedor->return);
}

if (isset($_POST["confirmar"])) {

    if (isset($_POST["cValija"]) && $_POST["cValija"] != "" && isset($_POST["cProveedor"]) && $_POST["cProveedor"] != "" && isset($_POST["proveedor"]) && $_POST["proveedor"] != "") {

        try {
            $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
            $client = new SOAPClient($wsdl_url);
            $client->decode_utf8 = false;
            $valija = $_POST["cValija"];
            $Val = array('codigo' => $valija);
            $Valijac = $client->consultarValijaXIdOCodigoBarra($Val);
            if (isset($Valijac->return)) {
                $idVal = $Valijac->return->idval;
                $parametros = array('idValija' => $idVal,
                    'proveedor' => $_POST["proveedor"],
                    'codProveedor' => $_POST["cProveedor"]);
                $confirmarValija = $client->confirmarValija($parametros);
                if (isset($confirmarValija->return) == 1) {
                    javaalert('Valija Confirmada');
                    llenarLog(2, "Confirmación de Valija", $usuarioBitacora, $sede);
                    iraURL('../pages/create_valise.php');
                } else {
                    javaalert('Valija No Confirmada');
                    iraURL('../pages/create_valise.php');
                }
            } else {
                javaalert('Valija No Confirmada');
                iraURL('../pages/create_valise.php');
            }
        } catch (Exception $e) {
            javaalert('Lo sentimos no hay conexion');
            iraURL('../pages/administration.php');
        }
    } else {
        javaalert("Debe agregar todos los campos, por favor verifique");
    }
}
include("../views/confirm_valise.php");
?>