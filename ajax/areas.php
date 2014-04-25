<?php
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");

$idpri = $_POST['id'];
$client = new nusoap_client($wsdl_sdc, 'wsdl');
$client->decode_utf8 = false;
$prioridad = array('prioridad' => $idpri);
$nivell = $client->call("consultarNivel",$prioridad);

 if ($nivell=="") {
        javaalert("lo sentimos no se pueden crear Areas, no existen sedes registradas, Consulte con el administrador");
        iraURL('../pages/inbox.php');
    }else{
		$nivel=$nivell['return'];
			if(isset($nivel[0])){
				$reg = count($nivel);
				for ($i = 0; $i < $reg; $i++) {
       echo '<option value="' . $nivel[$i]['idniv'] . '">' .utf8_encode( $nivel[$i]['operadorniv']) . '</option>';
}
			}
			else{
	   echo '<option value="' . $nivel['idniv'] . '">' .utf8_encode($nivel['operadorniv']) . '</option>';
			}
		
	}


?>