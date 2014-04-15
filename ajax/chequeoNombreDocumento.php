<?php

sleep(1);
if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
    require_once('../lib/nusoap.php');
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $Nombre = array('doc' => $_POST['nombre']);
    $rowDocumento = $client->consultarDocumentoXNombre($Nombre);

    if (isset($rowDocumento->return->iddoc)) {
        echo '<div id="Error"> Ya existe este documento </div>';
    } else {
        echo '<div> </div>';
    }
} else {
    echo '<div></div>';
}
?>