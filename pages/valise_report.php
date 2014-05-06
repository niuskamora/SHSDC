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

$nomUsuario = $_SESSION["Usuario"]["userusu"];
$usuarioBitacora = $_SESSION["Usuario"]["idusu"];
$sede = $_SESSION["Sede"]["idsed"];

$_SESSION['val'] = "";

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

if (isset($_POST["reportarPaqExc"])) {

    if (isset($_POST["cPaquete"]) && $_POST["cPaquete"] != "" && isset($_POST["datosPaquete"]) && $_POST["datosPaquete"] != "") {

        try {
            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $paquete = $_POST["cPaquete"];
            $idPaquete = array('codigo' => $paquete);
            $consumoReportarPaq = $client->call("consultarPaqueteXIdOCodigoBarras", $idPaquete);

            if ($consumoReportarPaq != "") {
                $rowPaquete = $consumoReportarPaq['return'];
                if (isset($rowPaquete)) {
                    $idDestino = $rowPaquete['destinopaq']['idusu']['idusu'];
                    $idUsu = array('idusu' => $idDestino);
                    $registroUsu = array('registroUsuario' => $idUsu);
                    $client = new nusoap_client($wsdl_sdc, 'wsdl');
                    $consumoDestino = $client->call("consultarSedeDeUsuario", $registroUsu);
                    if ($consumoDestino != "") {
                        $resultadoDestino = $consumoDestino['return'];
                        if (isset($resultadoDestino)) {
                            if (isset($resultadoDestino[0])) {
                                $sedeDestino = $resultadoDestino[0]['nombresed'];
                            } else {
                                $sedeDestino = $resultadoDestino['nombresed'];
                            }
                        }
                    }
                    $idPaq = $rowPaquete['idpaq'];
                    $tipoPaq = $rowPaquete['iddoc']['iddoc'];
                    $parametros = array('registroPaquete' => $idPaq,
                        'registroUsuario' => $usuarioBitacora,
                        'registroSede' => $sede,
                        'datosPaquete' => $_POST["datosPaquete"]);
                    $client = new nusoap_client($wsdl_sdc, 'wsdl');
                    $consumoReportar = $client->call("reportarPaqueteExcedente", $parametros);
                    if ($consumoReportar != "") {
                        $reportarPaqExc = $consumoReportar['return'];
                    }

                    if ($reportarPaqExc == 1) {

                        //Creación de Valija
                        $datosValija = array('idusu' => $usuarioBitacora, 'sorigen' => $sede, 'sdestino' => $sedeDestino, 'tipoval' => $tipoPaq);
                        $client = new nusoap_client($wsdl_sdc, 'wsdl');
                        $consumoValija = $client->call("insertarValija", $datosValija);
                        if ($consumoValija != "") {
                            $idValija = $consumoValija['return'];
                        }

                        //Actualización del dato de la valija en paquete
                        $client = new nusoap_client($wsdl_sdc, 'wsdl');
                        $datosAct = array('idpaq' => $idPaq, 'idval' => $idValija);
                        $consumoActualizacion = $client->call("ActualizacionLocalizacionyValijaDelPaquete", $datosAct);

                        $valija = $idValija;
                        $Val = array('codigo' => $valija);
                        $client = new nusoap_client($wsdl_sdc, 'wsdl');
                        $consumoVal = $client->call("consultarValijaXIdOCodigoBarra", $Val);
                        if ($consumoVal != "") {
                            $Valijac = $consumoVal['return'];
                        }
                        if (isset($Valijac)) {
                            $idVal = $Valijac['idval'];
                            $parametros = array('idValija' => $idVal,
                                'proveedor' => $_POST["proveedor"],
                                'codProveedor' => $_POST["cProveedor"]);
                            $consumoConfirmar = $client->call("confirmarValija", $parametros);
                            if ($consumoConfirmar != "") {
                                $confirmarValija = $consumoConfirmar['return'];
                                echo"<script>window.open('../pages/proof_pouch.php');</script>";
                            }
                        }
                        javaalert('Paquete Reportado y Reenviado');
                        llenarLog(7, "Paquete Excedente", $usuarioBitacora, $sede);
                        iraURL('../pages/breakdown_valise.php');
					} elseif ($reportarPaqExc == 2) {
						javaalert('El paquete ya fue entregado, no se puede reportar');
                        iraURL('../pages/breakdown_valise.php');
                    } else {
                        javaalert('Paquete No Reportado y No Reenviado, verifique los datos');
                        iraURL('../pages/breakdown_valise.php');
                    }
                } else {
                    javaalert('Paquete No Reportado y No Reenviado, verifique los datoss');
                    iraURL('../pages/breakdown_valise.php');
                }
            }
        } catch (Exception $e) {
            utf8_decode(javaalert('Lo sentimos no hay conexión'));
            iraURL('../pages/breakdown_valise.php');
        }
    } else {
        javaalert("Debe agregar todos los campos, por favor verifique");
    }
}

if (isset($_POST["reportarValija"])) {

    if (isset($_POST["cValija"]) && $_POST["cValija"] != "" && isset($_POST["datosValija"]) && $_POST["datosValija"] != "") {

        try {
            $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $parametros = array('registroValija' => $_POST["cValija"],
                'registroUsuario' => $usuarioBitacora,
                'registroSede' => $sede,
                'datosValija' => $_POST["datosValija"]);
            $consumoReportar = $client->call("reportarValija", $parametros);
            if ($consumoReportar != "") {
                $reportarValija = $consumoReportar['return'];
            }

            if ($reportarValija == 1) {
                $valija = $_POST["cValija"];
                $Val = array('codigo' => $valija);
                $client = new nusoap_client($wsdl_sdc, 'wsdl');
                $consumoVal = $client->call("consultarValijaXIdOCodigoBarra", $Val);
                if ($consumoVal != "") {
                    $Valijac = $consumoVal['return'];
                }
                if (isset($Valijac)) {
                    $idVal = $Valijac['idval'];
                    $parametros = array('idValija' => $idVal,
                        'proveedor' => $_POST["proveedor"],
                        'codProveedor' => $_POST["cProveedor"]);
                    $consumoConfirmar = $client->call("confirmarValija", $parametros);
                    if ($consumoConfirmar != "") {
                        $confirmarValija = $consumoConfirmar['return'];
                        $_SESSION['val'] = $idVal;
                        echo"<script>window.open('../pages/proof_pouch_report.php');</script>";
                    }
                }
                javaalert('Valija Reportada y Reenviada');
                llenarLog(7, "Valija Erronea", $usuarioBitacora, $sede);
                iraURL('../pages/breakdown_valise.php');
			} elseif ($reportarValija == 2) {
				javaalert('La valija ya fue entregada, no se puede reportar');
                iraURL('../pages/breakdown_valise.php');
            } else {
                javaalert('Valija No Reportada y No Reenviada, verifique los datos');
                iraURL('../pages/breakdown_valise.php');
            }
        } catch (Exception $e) {
            utf8_decode(javaalert('Lo sentimos no hay conexión'));
            iraURL('../pages/breakdown_valise.php');
        }
    } else {
        javaalert("Debe agregar todos los campos, por favor verifique");
    }
}
include("../views/valise_report.php");
?>