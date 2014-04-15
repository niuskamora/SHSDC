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
        if ($_SESSION["Usuario"]->return->tipousu != "1" && $_SESSION["Usuario"]->return->tipousu != "2") {
            iraURL('../pages/inbox.php');
        }
    }
} else {
    iraURL('../pages/inbox.php');
}

$idPaquete = $_GET["id"];
$usuario = $_SESSION["Usuario"]->return->idusu;

if ($idPaquete == "") {
    iraURL('../pages/reports_valise.php');
} else {
    try {
        $paquete = array('idPaquete' => $idPaquete);
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;
        $resultadoPaquete = $client->consultarSeguimientoXPaquete($paquete);

        if (!isset($resultadoPaquete->return)) {
            $segumientoPaquete = 0;
        } else {
            $segumientoPaquete = count($resultadoPaquete->return);
        }
        if ($segumientoPaquete > 1) {
            $idPaq = $resultadoPaquete->return[0]->idpaq->idpaq;
            if (isset($resultadoPaquete->return[0]->idpaq->origenpaq->idatr->idsed->nombresed)) {
                $origen = $resultadoPaquete->return[0]->idpaq->origenpaq->idatr->idsed->nombresed;
            } else {
                $origen = "";
            }
            if (isset($resultadoPaquete->return[0]->idpaq->origenpaq->idusu->nombreusu)) {
                $deNombre = $resultadoPaquete->return[0]->idpaq->origenpaq->idusu->nombreusu;
            } else {
                $deNombre = "";
            }
            if (isset($resultadoPaquete->return[0]->idpaq->origenpaq->idusu->apellidousu)) {
                $deApellido = $resultadoPaquete->return[0]->idpaq->origenpaq->idusu->apellidousu;
            } else {
                $deApellido = "";
            }
            $paraApellido = "";
            $paraNombre = "";
            $destino = "";
            if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->tipobuz)) {
                if ($resultadoPaquete->return[0]->idpaq->destinopaq->tipobuz == "0") {
                    if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->idusu->nombreusu)) {
                        $paraNombre = $resultadoPaquete->return[0]->idpaq->destinopaq->idusu->nombreusu;
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->idusu->apellidousu)) {
                        $paraApellido = $resultadoPaquete->return[0]->idpaq->destinopaq->idusu->apellidousu;
                    } else {
                        $paraApellido = "";
                    }
                    if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->idatr->idsed->nombresed)) {
                        $destino = $resultadoPaquete->return[0]->idpaq->destinopaq->idatr->idsed->nombresed;
                    } else {
                        $destino = "";
                    }
                }
                if ($resultadoPaquete->return[0]->idpaq->destinopaq->tipobuz == "1") {
                    if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->nombrebuz)) {
                        $paraNombre = $resultadoPaquete->return[0]->idpaq->destinopaq->nombrebuz;
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->direccionbuz)) {
                        $destino = $resultadoPaquete->return[0]->idpaq->destinopaq->direccionbuz;
                    } else {
                        $destino = "";
                    }
                }
            }
        } elseif ($segumientoPaquete == 1) {
            $idPaq = $resultadoPaquete->return->idpaq->idpaq;
            if (isset($resultadoPaquete->return->idpaq->origenpaq->idatr->idsed->nombresed)) {
                $origen = $resultadoPaquete->return->idpaq->origenpaq->idatr->idsed->nombresed;
            } else {
                $origen = "";
            }
            if (isset($resultadoPaquete->return->idpaq->origenpaq->idusu->nombreusu)) {
                $deNombre = $resultadoPaquete->return->idpaq->origenpaq->idusu->nombreusu;
            } else {
                $deNombre = "";
            }
            if (isset($resultadoPaquete->return->idpaq->origenpaq->idusu->apellidousu)) {
                $deApellido = $resultadoPaquete->return->idpaq->origenpaq->idusu->apellidousu;
            } else {
                $deApellido = "";
            }
            $paraApellido = "";
            $paraNombre = "";
            $destino = "";
            if (isset($resultadoPaquete->return->idpaq->destinopaq->tipobuz)) {
                if ($resultadoPaquete->return->idpaq->destinopaq->tipobuz == "0") {
                    if (isset($resultadoPaquete->return->idpaq->destinopaq->idusu->nombreusu)) {
                        $paraNombre = $resultadoPaquete->return->idpaq->destinopaq->idusu->nombreusu;
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete->return->idpaq->destinopaq->idusu->apellidousu)) {
                        $paraApellido = $resultadoPaquete->return->idpaq->destinopaq->idusu->apellidousu;
                    } else {
                        $paraApellido = "";
                    }
                    if (isset($resultadoPaquete->return->idpaq->destinopaq->idatr->idsed->nombresed)) {
                        $destino = $resultadoPaquete->return->idpaq->destinopaq->idatr->idsed->nombresed;
                    } else {
                        $destino = "";
                    }
                }
                if ($resultadoPaquete->return->idpaq->destinopaq->tipobuz == "1") {
                    if (isset($resultadoPaquete->return->idpaq->destinopaq->nombrebuz)) {
                        $paraNombre = $resultadoPaquete->return->idpaq->destinopaq->nombrebuz;
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete->return->idpaq->destinopaq->direccionbuz)) {
                        $destino = $resultadoPaquete->return->idpaq->destinopaq->direccionbuz;
                    } else {
                        $destino = "";
                    }
                }
            }
        }
        include("../views/package_detail_traking.php");
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../pages/reports_valise.php');
    }
}
?>