<?php

session_start();
try {
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
    $usuario = array('user' => $_SESSION["Usuario"]->return->userusu);
    $Usuario = $client->consultarUsuarioXUser($usuario);

    if (isset($_POST["guardar"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["apellido"]) && $_POST["apellido"] != "" && isset($_POST["correo"]) && $_POST["correo"] != "") {
            $telefono1 = "";
            $telefono2 = "";
            $direccion1 = "";
            if (isset($_POST["telefono1"])) {
                $telefono1 = $_POST["telefono1"];
            }
            if (isset($_POST["telefono2"])) {
                $telefono2 = $_POST["telefono2"];
            }
            if (isset($_POST["direccion1"])) {
                $direccion1 = $_POST["direccion1"];
            }

            if (preg_match('{^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$}', $_POST["correo"])) {
                $correo = $_POST["correo"];
                $registroUsu =
                        array(
                            'idusu' => $Usuario->return->idusu,
                            'nombreusu' => $_POST["nombre"],
                            'apellidousu' => $_POST["apellido"],
                            'correousu' => $correo,
                            'direccionusu' => $direccion1,
                            'telefonousu' => $telefono1,
                            'telefono2usu' => $telefono2,
                            'userusu' => $Usuario->return->userusu);
                $registroU = array('registroUsuario' => $registroUsu);
                $guardo = $client->editarUsuario($registroU);
                if ($guardo->return == 0) {
                    javaalert("No se han Guardado los datos del Usuario, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos del Usuario");
                    llenarLog(9, "Edición de Usuario", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
                }
                iraURL('../pages/inbox.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/edit_user.php");
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
?>