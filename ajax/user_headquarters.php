<?php
session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
	$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
$aux = $_POST['sed'];

$Sede = array('sede' => utf8_decode($aux));
$_SESSION["sedeb"] = $aux;
$UsuariosR = $client->call("consultarUsuariosXSede",$Sede);

$reg = 0;
if ($UsuariosR!="") {
	$Usuarios=$UsuariosR['return'];
    $reg = count($Usuarios);
}else{
	 javaalert('no posee usuarios esta sede');
        iraURL('../pages/user_role.php');
}
echo "<option value='' style='display:none'>Seleccionar:</option>";
if ($reg > 1) {
    $i = 0;
    while ($reg > $i) {
        echo '<option value="' . $Usuarios[$i]['idusu'] . '">' . $Usuarios[$i]['userusu'] . '</option>';
        $i++;
    }
} else {
    echo '<option value="' . $Usuarios['idusu'] . '">' . $Usuarios['userusu'] . '</option>';
}
?>