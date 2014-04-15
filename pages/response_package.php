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
} elseif (!isset($_GET['idpaqr'])) {
    iraURL("../pages/inbox.php");
}
try {
$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);
$idPaquete = array('idPaquete' => $_GET['idpaqr']);
$Paquete = $client->ConsultarPaqueteXId($idPaquete);

if (!isset($Paquete->return)) {
    iraURL('../pages/inbox.php');
} elseif ($Paquete->return->statuspaq != "1" && $Paquete->return->destinopaq->idusu->idusu != $_SESSION["Usuario"]->return->idusu) {
    iraURL('../pages/inbox.php');
}
$contacto = array('idusu' => $Paquete->return->origenpaq->idusu->idusu);
$dueno = array('idusu' => $Paquete->return->destinopaq->idusu->idusu);


$rowDocumentos = $client->listarDocumentos();
$rowPrioridad = $client->listarPrioridad();

if (!isset($rowDocumentos->return)) {
    javaalert("Lo sentimos no se puede enviar correspondencia porque no hay Tipos de documentos registrados, Consulte con el Administrador");
    iraURL('../pages/inbox.php');
}
if (!isset($rowPrioridad->return)) {
    javaalert("Lo sentimos no se puede enviar correspondencia porque no hay Prioridades registradas, Consulte con el Administrador");
    iraURL('../pages/inbox.php');
}
if (isset($_POST["enviar"])) {
    if (isset($_POST["asunto"]) && $_POST["asunto"] != "" && isset($_POST["doc"]) && $_POST["doc"] != "" && isset($_POST["prioridad"]) && $_POST["prioridad"] != "" && isset($_POST["elmsg"]) && $_POST["elmsg"] != "") {

			if (isset($_POST["fragil"])) {
                $fra = "1";
            } else {
                $fra = "0";
            }		 $origenpaq = array('idbuz' => $Paquete->return->destinopaq->idbuz);
            $destinopaq = array('idbuz' => $Paquete->return->origenpaq->idbuz);
            $prioridad = array('idpri' => $_POST["prioridad"]);
            $documento = array('iddoc' => $_POST["doc"]);
            $sede = array('idsed' => $_SESSION["Sede"]->return->idsed);
            $idPadre = array('idpaq' => $_GET['idpaqr']);
            $paquete = array('origenpaq' => $origenpaq,
                'destinopaq' => $destinopaq,
                'asuntopaq' => $_POST["asunto"],
                'textopaq' => $_POST["elmsg"],
                'fechapaq' => date("Y-m-d"),
                'statuspaq' => "0",
				'fragilpaq' => $fra,
                'respaq' => "0",
                'localizacionpaq' => $Paquete->return->destinopaq->idusu->userusu,
                'idpri' => $prioridad,
                'iddoc' => $documento,
                'idsed' => $sede,
                'idpaqres' => $idPadre);
            $registro = array('registroPaquete' => $paquete);

            $envio = $client->crearPaquete($registro);  //pilas ismael
            $paramUltimo = array('idUsuario' => $Paquete->return->destinopaq->idusu->idusu);
            $idPaquete = $client->ultimoPaqueteXOrigen($paramUltimo);
            $paq = array('idpaq' => $idPaquete->return->idpaq);
            $bandejaorigen = $client->insertarBandejaOrigen($paq);
            $bandejaDestino = $client->insertarBandejaDestino($paq);
            $paramPadre = array('idpaq' => $_GET['idpaqr']);
            $ResPadre = $client->editarRespuestaPaquete($paramPadre);
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
                $Rta = $client->insertarAdjunto($par);
            }
            if (!isset($envio->return) || !isset($bandejaorigen->return) || !isset($bandejaDestino->return) || !isset($ResPadre->return)) {
                javaalert("La correspondencia no ha podido ser enviada correctamente , por favor consulte con el administrador");
            } else {
                if ($envio->return == "1" && $bandejaorigen->return == "1" && $bandejaDestino->return == "1" && $ResPadre->return == "1") {
                    javaalert("La correspondencia ha sido enviada");
					$usuario = array('idusu' => $Paquete->return->destinopaq->idusu->idusu);
					$parametros = array('registroPaquete' => $paq,
                    'registroUsuario' => $usuario,
                    'registroSede' => $sede,
                    'Caso' => "Envio");
					$seg = $client->registroSeguimiento($parametros);
                    llenarLog(1, "Envio de Respuesta de Correspondencia", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
                }
            }
            iraURL('../pages/inbox.php');
        
    } else {
        javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
    }
}
include("../views/response_package.php");
 } catch (Exception $e) {
  javaalert('Lo sentimos no hay conexion');
  iraURL('../pages/inbox.php');
  } 
?>
