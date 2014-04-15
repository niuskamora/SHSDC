<?php

$idpri = $_POST['id'];
$client = new SOAPClient($wsdl_sdc);
$client->decode_utf8 = false;
$usu = array('sede' => $idsede);
$prioridad = array('prioridad' => $idpri);
$nivel = $client->consultarNivel($prioridad);
for ($i = 0; $i < count($nivel->return); $i++) {
    echo '<option value="' . $nivel->return[$i]->idniv . '">' . $nivel->return[$i]->operadorniv . '</option>';
}
?>