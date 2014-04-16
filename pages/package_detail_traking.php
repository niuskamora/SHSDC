<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

/*if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}*/

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 
					'sede' => $_SESSION["Sede"]["nombresed"]);
$consumo = $client->call("consultarSedeRol",$UsuarioRol);

if($consumo != ""){
	$SedeRol = $consumo['return'];
	if ($SedeRol['idrol']['idrol'] != "4" && $SedeRol['idrol']['idrol'] != "5") {
		if ($SedeRol['idusu']['tipousu'] != "1" && $SedeRol['idusu']['tipousu'] != "2") {
			iraURL('../pages/inbox.php');
		}
	}
} else {
    iraURL('../pages/inbox.php');
}

$idPaquete = $_GET["id"];
$usuario = $_SESSION["Usuario"]['idusu'];

if ($idPaquete == "") {
    iraURL('../pages/reports_valise.php');
} else {
    try {
		$client = new nusoap_client($wsdl_sdc, 'wsdl');
		$paquete = array('idPaquete' => $idPaquete);
		$consumoSeguimiento= $client->call("consultarSeguimientoXPaquete",$paquete);
		if($consumoSeguimiento != ""){
			$resultadoPaquete = $consumoSeguimiento['return'];		
			if(isset($resultadoPaquete[0])){
				$segumientoPaquete = count($resultadoPaquete);
			} else{
				$segumientoPaquete = 1;
			}
		} else{
			$segumientoPaquete = 0;
		}
        if ($segumientoPaquete > 1) {
            $idPaq = $resultadoPaquete[0]['idpaq']['idpaq'];
            if (isset($resultadoPaquete[0]['idpaq']['origenpaq']['idatr']['idsed']['nombresed'])) {
                $origen = utf8_encode($resultadoPaquete[0]['idpaq']['origenpaq']['idatr']['idsed']['nombresed']);
            } else {
                $origen = "";
            }
            if (isset($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['nombreusu'])) {
                $deNombre = utf8_encode($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['nombreusu']);
            } else {
                $deNombre = "";
            }
            if (isset($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['apellidousu'])) {
                $deApellido = utf8_encode($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['apellidousu']);
            } else {
                $deApellido = "";
            }
            $paraApellido = "";
            $paraNombre = "";
            $destino = "";
            if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['tipobuz'])) {
                if ($resultadoPaquete[0]['idpaq']['destinopaq']['tipobuz'] == "0") {
                    if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['nombreusu'])) {
                        $paraNombre = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['nombreusu']);
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['apellidousu'])) {
                        $paraApellido = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['apellidousu']);
                    } else {
                        $paraApellido = "";
                    }
                    if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['idatr']['idsed']['nombresed'])) {
                        $destino = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['idatr']['idsed']['nombresed']);
                    } else {
                        $destino = "";
                    }
                }
                if ($resultadoPaquete[0]['idpaq']['destinopaq']['tipobuz'] == "1") {
                    if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['nombrebuz'])) {
                        $paraNombre = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['nombrebuz']);
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['direccionbuz'])) {
                        $destino = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['direccionbuz']);
                    } else {
                        $destino = "";
                    }
                }
            }
        } elseif ($segumientoPaquete == 1) {
            $idPaq = $resultadoPaquete['idpaq']['idpaq'];
            if (isset($resultadoPaquete['idpaq']['origenpaq']['idatr']['idsed']['nombresed'])) {
                $origen = utf8_encode($resultadoPaquete['idpaq']['origenpaq']['idatr']['idsed']['nombresed']);
            } else {
                $origen = "";
            }
            if (isset($resultadoPaquete['idpaq']['origenpaq']['idusu']['nombreusu'])) {
                $deNombre = utf8_encode($resultadoPaquete['idpaq']['origenpaq']['idusu']['nombreusu']);
            } else {
                $deNombre = "";
            }
            if (isset($resultadoPaquete['idpaq']['origenpaq']['idusu']['apellidousu'])) {
                $deApellido = utf8_encode($resultadoPaquete['idpaq']['origenpaq']['idusu']['apellidousu']);
            } else {
                $deApellido = "";
            }
            $paraApellido = "";
            $paraNombre = "";
            $destino = "";
            if (isset($resultadoPaquete['idpaq']['destinopaq']['tipobuz'])) {
                if ($resultadoPaquete['idpaq']['destinopaq']['tipobuz'] == "0") {
                    if (isset($resultadoPaquete['idpaq']['destinopaq']['idusu']['nombreusu'])) {
                        $paraNombre = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['idusu']['nombreusu']);
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete['idpaq']['destinopaq']['idusu']['apellidousu'])) {
                        $paraApellido = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['idusu']['apellidousu']);
                    } else {
                        $paraApellido = "";
                    }
                    if (isset($resultadoPaquete['idpaq']['destinopaq']['idatr']['idsed']['nombresed'])) {
                        $destino = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['idatr']['idsed']['nombresed']);
                    } else {
                        $destino = "";
                    }
                }
                if ($resultadoPaquete['idpaq']['destinopaq']['tipobuz'] == "1") {
                    if (isset($resultadoPaquete['idpaq']['destinopaq']['nombrebuz'])) {
                        $paraNombre = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['nombrebuz']);
                    } else {
                        $paraNombre = "";
                    }
                    if (isset($resultadoPaquete['idpaq']['destinopaq']['direccionbuz'])) {
                        $destino = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['direccionbuz']);
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