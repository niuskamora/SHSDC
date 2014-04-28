<?php

session_start();



try {
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");    $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$_SESSION["cli"]=$client;

    if (!isset($_SESSION["User"])) {
        iraURL('../index.php');
    }
    $usuario = array('user' => $_SESSION["User"]);
    $usernuevo = $_SESSION["User"];

    /*
      $Usuario= array('user' =>$usernuevo);
      $UsuarioLogIn = $client->consultarUsuarioXUser($Usuario);
      if(isset($UsuarioLogIn->return)){
      javaalert("Lo sentimos no se puede guardar los datos del usuario porque el nombre de usuario ya existe,Consulte con el Administrador");
      iraURL('../index.php');   //ojo necesito el index
      } */    //importante:implementar cuando se tenga el index 

     $consumo = $client->call("listarSedes");
	if ($consumo!="") {
	$Sedes = $consumo['return'];   
	}else{
	javaalert("Lo sentimos no se puede crear el usuario en estos momentos,Consulte con el Administrador");
        iraURL('../index.php');
	}

    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["apellido"]) && $_POST["apellido"] != "" && isset($_POST["correo"]) && $_POST["correo"] != "" && isset($_POST["cargo"]) && $_POST["cargo"] != "" && isset($_POST["sede"]) && $_POST["sede"] != "" && isset($_POST["area"]) && $_POST["area"] != "") {

            if (preg_match('{^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$}', $_POST["correo"])) {
                $correo = $_POST["correo"];
                $telefono1 = "";
                $telefono2 = "";
                $direccion1 = "";
                if (isset($_POST["telefono1"])) {
                    $telefono1 = $_POST["telefono1"];
                }
                if (isset($_POST["cargo"])) {
                    $cargo = $_POST["cargo"];
                }
                if (isset($_POST["telefono2"])) {
                    $telefono2 = $_POST["telefono2"];
                }
                if (isset($_POST["direccion1"])) {
                    $direccion1 = $_POST["direccion1"];
                }
                $Usuario = array(
                    'nombreusu' => utf8_decode($_POST["nombre"]),
                    'apellidousu' => utf8_decode($_POST["apellido"]),
                    'correousu' => utf8_decode($correo),
                    'direccionusu' => utf8_decode($direccion1),
                    'telefonousu' => utf8_decode($telefono1),
                    'telefono2usu' => utf8_decode($telefono2),
                    'tipousu' => "0",
                    'cargousu' => utf8_decode($cargo),
                    'userusu' => utf8_decode($usernuevo),
                    'statususu' => "1",
                    'borradousu' => "0");
                $parametros = array('registroUsuario' => $Usuario);
				$consumo = $client->call("insertarUsuario",$parametros);
                //$client->insertarUsuario($parametros);
                $sede = array('idsed' => $_POST["sede"]);
                $area = array('idatr' => $_POST["area"]);
                $rol = array('idrol' => "6");
                $usuSede = array('idsed' => $sede, 'idrol' => $rol, 'idatr' => $area);
                $RegUsuSede = array('registroUsuSede' => $usuSede,
                    'userUsu' => $usernuevo);
					$consumo = $client->call("insertarUsuarioSedeXDefecto",$RegUsuSede);
					if(isset($consumo)){
					$guardo=$consumo["return"];
					}
              //  $guardo = $client->insertarUsuarioSedeXDefecto($RegUsuSede);

                if ($guardo == 0) {
                    javaalert("No se han Guardado los datos del Usuario, Consulte con el Admininistrador");
                } else {
                    $Usuario = array('user' => $usernuevo);
					$consumo = $client->call("consultarUsuarioXUser",$Usuario);
                    if(isset($consumo)){
					$UsuarioLogIn=$consumo["return"];
					}
					//$UsuarioLogIn = $client->consultarUsuarioXUser($Usuario);
                    $_SESSION["Usuario"] = $UsuarioLogIn;
                    javaalert("Se han Guardado los datos del Usuario");
                    llenarLog(1, "Inserción de Usuario", $_SESSION["Usuario"]["idusu"], $_POST["sede"]);
                }
                iraURL('../index.php');
            } else {
                javaalert("El formato del correo es incorrecto, por favor verifique");
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_user.php");
} catch (Exception $e) {
    javaalert('Error al crear el usuario');
    iraURL('../index.php');
}
?>
