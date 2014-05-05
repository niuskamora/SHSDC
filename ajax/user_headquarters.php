<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$aux = utf8_decode($_POST['sed']);
$Sed["sede"] = $aux;
$client = new nusoap_client($wsdl_sdc, 'wsdl');
$_SESSION["sedeb"] = utf8_decode($aux);
$UsuariosR = $client->call("consultarUsuariosXSede", $Sed);

$reg = 0;
if ($UsuariosR != "") {
    $Usuarios = $UsuariosR['return'];
    if (isset($Usuarios[0])) {
        $reg = count($Usuarios);
    } else {
        $reg == 1;
    }


    echo "<option value='' style='display:none'>Seleccionar:</option>";
    if ($reg > 1) {
        $i = 0;
        while ($reg > $i) {
            echo '<option value="' . $Usuarios[$i]['idusu'] . '">' . utf8_encode($Usuarios[$i]['userusu']) . '</option>';
            $i++;
        }
    } else {
        echo '<option value="' . $Usuarios['idusu'] . '">' . utf8_encode($Usuarios['userusu']) . '</option>';
    }
} else {
    javaalert('No posee usuarios esta sede');
    iraURL('../pages/user_role.php');
}
?>