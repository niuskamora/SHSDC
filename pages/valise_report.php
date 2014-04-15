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

$nomUsuario = $_SESSION["Usuario"]->return->userusu;
$usuarioBitacora = $_SESSION["Usuario"]->return->idusu;
$sede = $_SESSION["Sede"]->return->idsed;

$_SESSION['val'] = "";

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;

    $usuario = array('user' => $nomUsuario);
    $resultadoConsultarUsuario = $client->consultarUsuarioXUser($usuario);

    if (!isset($resultadoConsultarUsuario->return)) {
        $usua = 0;
    } else {
        $usua = $resultadoConsultarUsuario->return;
    }

    $idUsuario = $resultadoConsultarUsuario->return->idusu;

    $idsede = array('idsed' => $sede);
    $sedeP = array('sede' => $idsede);
    $resultadoProveedor = $client->consultarProveedorXSede($sedeP);
    if (!isset($resultadoProveedor->return)) {
        $proveedor = 0;
    } else {
        $proveedor = count($resultadoProveedor->return);
    }

    if (isset($_POST["reportarPaqExc"])) {

        if (isset($_POST["cPaquete"]) && $_POST["cPaquete"] != "" && isset($_POST["datosPaquete"]) && $_POST["datosPaquete"] != "") {

            try {
                $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
                $client = new SOAPClient($wsdl_url);
                $client->decode_utf8 = false;

                $paquete = $_POST["cPaquete"];
                $idPaquete = array('codigo' => $paquete);
                $rowPaquete = $client->consultarPaqueteXIdOCodigoBarras($idPaquete);

                if (isset($rowPaquete->return)) {

                    $idDestino = $rowPaquete->return->destinopaq->idusu->idusu;
                    $idUsu = array('idusu' => $idDestino);
                    $registroUsu = array('registroUsuario' => $idUsu);
                    $resultadoDestino = $client->consultarSedeDeUsuario($registroUsu);
                    if (isset($resultadoDestino->return)) {
                        if (count($resultadoDestino->return) > 1) {
                            $sedeDestino = $resultadoDestino->return[0]->nombresed;
                        } else {
                            $sedeDestino = $resultadoDestino->return->nombresed;
                        }
                    }

                    $idPaq = $rowPaquete->return->idpaq;
                    $parametros = array('registroPaquete' => $idPaq,
                        'registroUsuario' => $idUsuario,
                        'registroSede' => $sede,
                        'datosPaquete' => $_POST["datosPaquete"]);
                    $reportarPaqExc = $client->reportarPaqueteExcedente($parametros);

                    if ($reportarPaqExc->return == 1) {

                        //Creación de Valija
                        $datosValija = array('idusu' => $usuarioBitacora, 'sorigen' => $sede, 'sdestino' => $sedeDestino, 'fechaapaq' => date('Y-m-d', strtotime(str_replace('/', '-', "27/03/2014"))));
                        $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
                        $client = new SOAPClient($wsdl_url);
                        $client->decode_utf8 = false;
                        $idValija = $client->insertarValija($datosValija);

                        //Actualizacion del dato de la valija en paquete
                        $datosAct = array('idpaq' => $idPaq, 'idval' => $idValija->return);
                        $client->ActualizacionLocalizacionyValijaDelPaquete($datosAct);

                        $valija = $idValija->return;
                        $Val = array('codigo' => $valija);
                        $Valijac = $client->consultarValijaXIdOCodigoBarra($Val);
                        if (isset($Valijac->return)) {
                            $idVal = $Valijac->return->idval;
                            $parametros = array('idValija' => $idVal,
                                'proveedor' => $_POST["proveedor"],
                                'codProveedor' => $_POST["cProveedor"]);
                            $confirmarValija = $client->confirmarValija($parametros);
                            $_SESSION['val'] = $idVal;
                            echo"<script>window.open('../pages/proof_pouch.php');</script>";
                        }

                        javaalert('Paquete Reportado y Reenviado');
                        llenarLog(7, "Paquete Excedente", $usuarioBitacora, $sede);
                        iraURL('../pages/breakdown_valise.php');
                    } else {
                        javaalert('Paquete No Reportado y No Reenviado, verifique los datos');
                        iraURL('../pages/breakdown_valise.php');
                    }
                } else {
                    javaalert('Paquete No Reportado y No Reenviado, verifique los datoss');
                    iraURL('../pages/breakdown_valise.php');
                }
            } catch (Exception $e) {
                javaalert('Lo sentimos no hay conexión');
                iraURL('../pages/breakdown_valise.php');
            }
        } else {
            javaalert("Debe agregar todos los campos, por favor verifique");
        }
    }

    if (isset($_POST["reportarValija"])) {

        if (isset($_POST["cValija"]) && $_POST["cValija"] != "" && isset($_POST["datosValija"]) && $_POST["datosValija"] != "") {

            try {
                $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
                $client = new SOAPClient($wsdl_url);
                $client->decode_utf8 = false;
                $parametros = array('registroValija' => $_POST["cValija"],
                    'registroUsuario' => $idUsuario,
                    'registroSede' => $sede,
                    'datosValija' => $_POST["datosValija"]);
                $reportarValija = $client->reportarValija($parametros);

                if ($reportarValija->return == 1) {
                    $valija = $_POST["cValija"];
                    $Val = array('codigo' => $valija);
                    $Valijac = $client->consultarValijaXIdOCodigoBarra($Val);
                    if (isset($Valijac->return)) {
                        $idVal = $Valijac->return->idval;
                        $parametros = array('idValija' => $idVal,
                            'proveedor' => $_POST["proveedor"],
                            'codProveedor' => $_POST["cProveedor"]);
                        $confirmarValija = $client->confirmarValija($parametros);
                        $_SESSION['val'] = $idVal;
                        echo"<script>window.open('../pages/proof_pouch_report.php');</script>";
                    }

                    javaalert('Valija Reportada y Reenviada');
                    llenarLog(7, "Valija Erronea", $usuarioBitacora, $sede);
                    iraURL('../pages/breakdown_valise.php');
                } else {
                    javaalert('Valija No Reportada y No Reenviada, verifique los datos');
                    iraURL('../pages/breakdown_valise.php');
                }
            } catch (Exception $e) {
                javaalert('Lo sentimos no hay conexion');
                iraURL('../pages/breakdown_valise.php');
            }
        } else {
            javaalert("Debe agregar todos los campos, por favor verifique");
        }
    }
    include("../views/valise_report.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/breakdown_valise.php');
}
?>