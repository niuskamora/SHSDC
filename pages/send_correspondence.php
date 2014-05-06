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
	}
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
    $consumo = $client->call("consultarSedeRol",$UsuarioRol);
    $SedeRol = $consumo['return'];
	$sedemia = array('idSede' => $_SESSION["Sede"]["idsed"]);
	$consumo = $client->call("listarSedesParaEnvio",$sedemia);
    $Sedes = $consumo['return'];
    $consumo = $client->call("listarDocumentos");
	if($consumo!=""){
	$rowDocumentos = $consumo['return'];
	}  
	$consumo = $client->call("listarPrioridad");
	if($consumo!=""){
	 $rowPrioridad = $consumo['return'];
	}
    $buzonxUS['idusu'] = $_SESSION["Usuario"]["idusu"];
	$buzonxUS['idsede'] = $_SESSION["Sede"]["idsed"];
	$consumo = $client->call("consultarBuzonXUsuarioSede",$buzonxUS);
	if($consumo!=""){
	 $propioBuzon = $consumo['return'];
	}
   
	if (!isset($propioBuzon)) {
        javaalert("Lo sentimos no se puede enviar correspondencia porque no tiene el buzon creado,Consulte con el Administrador");
        iraURL('../pages/inbox.php');
    }
    if (!isset($rowDocumentos)) {
        javaalert("Lo sentimos no se puede enviar correspondencia porque no hay Tipos de documentos registrados,Consulte con el Administrador");
        iraURL('../pages/inbox.php');
    }
    if (!isset($rowPrioridad)) {
        javaalert("Lo sentimos no se puede enviar correspondencia porque no hay Prioridades registradas,Consulte con el Administrador");
        iraURL('../pages/inbox.php');
    }
    
    if (isset($_POST["enviar"])) {
        if ($_POST["contacto"] != "" && isset($_POST["asunto"]) && $_POST["asunto"] != "" && isset($_POST["doc"]) && $_POST["doc"] != "" && isset($_POST["prioridad"]) && $_POST["prioridad"] != "" && isset($_POST["elmsg"]) && $_POST["elmsg"] != "") {

            $idbuz = $_POST["id"];
            $origenpaq = array('idbuz' => $propioBuzon["idbuz"]);
			$paramBuzonP= array('idbuz' => $idbuz);
			$consumo = $client->call("consultarBuzon",$paramBuzonP);
			$buzonPara = $consumo['return'];
            if ($buzonPara["tipobuz"] == "0") {
                if (!isset($_POST["rta"])) {
                    $rta = "0";
                } else {
                    $rta = "1";
                }
            } else {
                $rta = "0";
            }
            if (isset($_POST["fragil"])) {
                $fra = "1";
            } else {
                $fra = "0";
            }
            $destinopaq = array('idbuz' => $idbuz);
            $prioridad = array('idpri' => $_POST["prioridad"]);
            $documento = array('iddoc' => $_POST["doc"]);
            $sede = array('idsed' => $_SESSION["Sede"]["idsed"]);
            $paquete = array('origenpaq' => $origenpaq,
                'destinopaq' => $destinopaq,
                'asuntopaq' => utf8_decode($_POST["asunto"]),
                'textopaq' => utf8_decode($_POST["elmsg"]),
              //  'fechapaq' => date("Y-m-d"),
                'statuspaq' => "0",
                'localizacionpaq' => utf8_decode($_SESSION["Usuario"]["userusu"]),
                'idpri' => $prioridad,
                'iddoc' => $documento,
                'fragilpaq' => $fra,
                'respaq' => $rta,
                'idsed' => $sede);
				
            $registro = array('registroPaquete' => $paquete);

			$consumo = $client->call("crearPaquete",$registro);
			if($consumo!=""){
				$envio = $consumo['return'];
				$paramUltimo = array('idUsuario' => $_SESSION["Usuario"]["idusu"]);
				$consumo = $client->call("ultimoPaqueteXOrigen",$paramUltimo);
				if($consumo!=""){
					$idPaquete = $consumo['return'];
				}
				$paq = array('idpaq' => $idPaquete["idpaq"]);
				$consumo = $client->call("insertarBandejaOrigen",$paq);
				if($consumo!=""){
				$bandejaorigen = $consumo['return'];
				}		
				
				if ($buzonPara["tipobuz"] == 0) {
				  $consumo = $client->call("insertarBandejaDestino",$paq);
				  if($consumo!=""){	  
				  $bandejaD = $consumo['return'];
				  $bandejaDestino = $bandejaD;
				  }
			
				} else {
					$bandejaDestino = "1";
				}

				if ($_FILES['imagen']['name'] != "") {
					$imagenName = $_FILES['imagen']['name'];
					$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; //posibles caracteres a usar
					$numerodeletras = 5; //numero de letras para generar el texto
					$cadena = ""; //variable para almacenar la cadena generada
					for ($i = 0; $i < $numerodeletras; $i++) {
						$cadena .= substr($caracteres, rand(0, strlen($caracteres)), 1); /* Extraemos 1 caracter de los caracteres 
						  entre el rango 0 a Numero de letras que tiene la cadena */
					}

					$direccion = "../images"; //para cargar
					$direccion2 = "../images"; //para guardar
					$tipo = explode('/', $_FILES['imagen']['type']);
					$uploadfile = $direccion . "/adjunto/" . $cadena . "." . $tipo[1];
					$Ruta = $direccion2 . "/adjunto/" . $cadena . "." . $tipo[1];
					$imagen = $_FILES['imagen']['tmp_name'];
					move_uploaded_file($imagen, $uploadfile);

					$adj = array('nombreadj' => $imagenName,
						'urladj' => $Ruta,
						'idpaq' => $paq);
					$par = array('registroAdj' => $adj);
					$consumo = $client->call("insertarAdjunto",$par);
					$Rta = $consumo['return'];               
				}
				if (isset($envio) || isset($bandejaorigen) || isset($bandejaDestino) ) {
					if ($envio == "1" && $bandejaorigen == "1" && $bandejaDestino == "1") {
						if ($buzonPara["tipobuz"] == "1") {
							
							$usuario = array('idusu' => $_SESSION["Usuario"]["idusu"]);
						$parametros = array('registroPaquete' => $paq,
							'registroUsuario' => $usuario,
							'registroSede' => $sede,
							'Caso' => "Envio");
						$consumo = $client->call("registroSeguimiento",$parametros);
						llenarLog(1, "Envio de Correspondencia", $_SESSION["Usuario"]["idusu"], $_SESSION["Sede"]["idsed"]);
						echo"<script>window.open('../pages/proof_of_correspondence.php');</script>";
						
							javaalert("La correspondencia ha sido enviada, como el buzón es externo no tendra respuesta del paquete");
							iraURL("../pages/send_correspondence.php");
						} else {
							$usuario = array('idusu' => $_SESSION["Usuario"]["idusu"]);
						$parametros = array('registroPaquete' => $paq,
							'registroUsuario' => $usuario,
							'registroSede' => $sede,
							'Caso' => "Envio");
						$consumo = $client->call("registroSeguimiento",$parametros);
						llenarLog(1, "Envio de Correspondencia", $_SESSION["Usuario"]["idusu"], $_SESSION["Sede"]["idsed"]);
						echo"<script>window.open('../pages/proof_of_correspondence.php');</script>";
						
							javaalert("La correspondencia ha sido enviada");
							iraURL("../pages/send_correspondence.php");
							
							
						}
						
					} else {
						javaalert("La correspondencia no ha podido ser enviada correctamente , por favor consulte con el administrador");
					}
				}
			}else{
			javaalert("La correspondencia no ha podido ser enviada correctamente , por favor consulte con el administrador");
			}
			

        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/send_correspondence.php");
} catch (Exception $e) {
    utf8_decode(javaalert('Lo sentimos no hay conexión'));
    iraURL('../pages/inbox.php');
}
?>