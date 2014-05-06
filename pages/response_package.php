<?php
session_start();
try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["cli"]=$client;
	if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
	} elseif (!usuarioCreado()) {
		iraURL("../pages/create_user.php");
	} elseif (!isset($_GET['idpaqr'])) {
		iraURL("../pages/inbox.php");
	}
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
    } else {
        iraURL('../pages/inbox.php');
    }
$idPaquete = array('idPaquete' => $_GET['idpaqr']);
$consumo = $client->call("consultarPaqueteXId",$idPaquete);
	if ($consumo!="") {
	$Paquete = $consumo['return'];   
    }
if (!isset($Paquete)) {
    iraURL('../pages/inbox.php');
} elseif ($Paquete["statuspaq"] != "1" && $Paquete["destinopaq"]["idusu"]["idusu"] != $_SESSION["Usuario"]["idusu"]) {
    iraURL('../pages/inbox.php');
}
$contacto = array('idusu' => $Paquete["origenpaq"]["idusu"]["idusu"]);
$dueno = array('idusu' => $Paquete["destinopaq"]["idusu"]["idusu"]);

$consumo = $client->call("listarDocumentos");
	if ($consumo!="") {
	$rowDocumentos = $consumo['return'];   
    }
$consumo = $client->call("listarPrioridad");
	if ($consumo!="") {
	$rowPrioridad = $consumo['return'];   
    }
if (!isset($rowDocumentos)) {
    javaalert("Lo sentimos no se puede enviar correspondencia porque no hay Tipos de documentos registrados, Consulte con el Administrador");
    iraURL('../pages/inbox.php');
}
if (!isset($rowPrioridad)) {
    javaalert("Lo sentimos no se puede enviar correspondencia porque no hay Prioridades registradas, Consulte con el Administrador");
    iraURL('../pages/inbox.php');
}
if (isset($_POST["enviar"])) {
    if (isset($_POST["asunto"]) && $_POST["asunto"] != "" && isset($_POST["doc"]) && $_POST["doc"] != "" && isset($_POST["prioridad"]) && $_POST["prioridad"] != "" && isset($_POST["elmsg"]) && $_POST["elmsg"] != "") {

			if (isset($_POST["fragil"])) {
                $fra = "1";
            } else {
                $fra = "0";
            }		 
			$origenpaq = array('idbuz' => $Paquete["destinopaq"]["idbuz"]);
            $destinopaq = array('idbuz' => $Paquete["origenpaq"]["idbuz"]);
            $prioridad = array('idpri' => $_POST["prioridad"]);
            $documento = array('iddoc' => $_POST["doc"]);
            $sede = array('idsed' => $_SESSION["Sede"]["idsed"]);
            $idPadre = array('idpaq' => $_GET['idpaqr']);
            $paquete = array('origenpaq' => $origenpaq,
                'destinopaq' => $destinopaq,
                'asuntopaq' => utf8_decode($_POST["asunto"]),
                'textopaq' => utf8_decode($_POST["elmsg"]),
                //'fechapaq' => date("Y-m-d"),
                'statuspaq' => "0",
				'fragilpaq' => $fra,
                'respaq' => "0",
                'localizacionpaq' => utf8_decode($Paquete["destinopaq"]["idusu"]["userusu"]),
                'idpri' => $prioridad,
                'iddoc' => $documento,
                'idsed' => $sede,
                'idpaqres' => $idPadre);
            $registro = array('registroPaquete' => $paquete);
			$consumo = $client->call("crearPaquete",$registro);
           if($consumo !=""){
			$envio = $consumo['return'];
            $paramUltimo = array('idUsuario' => $Paquete["destinopaq"]["idusu"]["idusu"]);
			$consumo = $client->call("ultimoPaqueteXOrigen",$paramUltimo);
				if ($consumo!="") {
				$idPaquete = $consumo['return'];   
				}
		    $paq = array('idpaq' => $idPaquete["idpaq"]);
            $consumo = $client->call("insertarBandejaOrigen",$paq);
				if ($consumo!="") {
				$bandejaorigen = $consumo['return'];   
				}
			$consumo = $client->call("insertarBandejaDestino",$paq);
				if ($consumo!="") {
				$bandejaDestino = $consumo['return'];   
				}	
            $paramPadre = array('idpaq' => $_GET['idpaqr']);
            $consumo = $client->call("editarRespuestaPaquete",$paramPadre);
				if ($consumo!="") {
				$ResPadre = $consumo['return'];   
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
                $direccion2 = "images"; //para guardar
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
				if ($consumo!="") {
				$Rta = $consumo['return'];   
				}	
            }
            if (!isset($envio) || !isset($bandejaorigen) || !isset($bandejaDestino) || !isset($ResPadre)) {
                javaalert("La correspondencia no ha podido ser enviada correctamente , por favor consulte con el administrador");
            } else {
                if ($envio == "1" && $bandejaorigen == "1" && $bandejaDestino == "1" && $ResPadre == "1") {
                    javaalert("La correspondencia ha sido enviada");
					$usuario = array('idusu' => $Paquete["destinopaq"]["idusu"]["idusu"]);
					$parametros = array('registroPaquete' => $paq,
                    'registroUsuario' => $usuario,
                    'registroSede' => $sede,
                    'Caso' => "Envio");
					$consumo = $client->call("registroSeguimiento",$parametros);
                    llenarLog(1, "Envio de Respuesta de Correspondencia", $_SESSION["Usuario"]["idusu"], $_SESSION["Sede"]["idsed"]);
					echo"<script>window.open('../pages/proof_of_correspondence.php');</script>";
					javaalert("La correspondencia ha sido enviada");
					iraURL("../pages/send_correspondence.php");
                }
            }
		   }else{
		      javaalert("La correspondencia no ha podido ser enviada correctamente , por favor consulte con el administrador");

		   }
           iraURL('../pages/inbox.php');
        
    } else {
        javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
    }
}
include("../views/response_package.php");
 } catch (Exception $e) {
  utf8_decode(javaalert('Lo sentimos no hay conexión'));
  iraURL('../pages/inbox.php');
  } 
?>
