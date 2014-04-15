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
try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);
    if (isset($SedeRol->return)) {
        if ($SedeRol->return->idusu->tipousu != "1" && $SedeRol->return->idusu->tipousu != "2") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

    $org = $client->listarSedes();
    if (!isset($org->return)) {
        javaalert("lo sentimos no se pueden crear sedes, no existen organizaciones registradas, Consulte con el administrador");
        iraURL('../pages/inbox.php');
    }

    if (isset($_POST["crear"])) {
        if (isset($_POST["nombre"]) && $_POST["nombre"] != "" && isset($_POST["telefono"]) && $_POST["telefono"] != "" && isset($_POST["sede"]) && $_POST["sede"] != "") {

            // si ya existe ese proveedor en esa sede
            $result = 0;
            try {
                $datos = array('nombre' => $_POST["nombre"]);
                $pro = $client->consultarProveedorXNombre($datos);
                if (isset($pro->return)) {
                    $result = 1;
                }
            } catch (Exception $e) {
                
            }
            if ($result == 0) {
                $codigo = "";
                if (isset($_POST["codigo"])) {
                    $codigo = $_POST["codigo"];
                }
                $Sedenueva = array(
                    'nombrepro' => $_POST["nombre"],
                    'telefonopro' => $_POST["telefono"],
                    'codigopro' => $codigo,
                    'idsed' => $_POST["sede"]);
                $parametros = array('registroProveedor' => $Sedenueva);
                $guardo = $client->insertarProveedor($parametros);
                if ($guardo->return == 0) {
                    javaalert("No se han Guardado los datos del Proveedor, Consulte con el Admininistrador");
                } else {
                    javaalert("Se han Guardado los datos del Proveedor");
                    llenarLog(1, "Inserción de Proveedor", $_SESSION["Usuario"]->return->idusu, $_SESSION["Sede"]->return->idsed);
                }
                iraURL('../pages/inbox.php');
            } else {
                javaalert('Este nombre del proveedor ya ha sido usado');
                iraURL('../pages/inbox.php');
            }
        } else {
            javaalert("Debe agregar todos los campos obligatorios, por favor verifique");
        }
    }
    include("../views/create_provider.php");
} catch (Exception $e) {
    javaalert('Error al crear el Proveedor');
    iraURL('../pages/inbox.php');
}
?>