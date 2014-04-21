<?php

session_start();
$resultadoConsultarUltimaValija = $_SESSION["valija"];
$codigo = $_SESSION["codigo"];
$resultadoOrigen = $_SESSION["origen"];
$fecha = $_SESSION["fecha"];

if (isset($resultadoConsultarUltimaValija)) {

//Datos de la Valija
    $idVal = $resultadoConsultarUltimaValija['idval'];
    if (isset($resultadoConsultarUltimaValija['iduse']['idsed']['nombresed'])) {
        $sede = utf8_encode($resultadoConsultarUltimaValija['iduse']['idsed']['nombresed']);
    } else {
        $sede = "";
    }
    if (isset($resultadoConsultarUltimaValija['tipoval'])) {
        $tipo = utf8_encode($resultadoConsultarUltimaValija['tipoval']);
    } else {
        $tipo = "";
    }

//Datos del Origen
    if (isset($resultadoOrigen['nombresed'])) {
        $nombreOrig = utf8_encode($resultadoOrigen['nombresed']);
    } else {
        $nombreOrig = "";
    }
    if (isset($resultadoOrigen['direccionsed'])) {
        $direccionOrig = utf8_encode($resultadoOrigen['direccionsed']);
    } else {
        $direccionOrig = "";
    }
    if (isset($resultadoOrigen['telefonosed'])) {
        $telefonoOrig = $resultadoOrigen['telefonosed'];
    } else {
        $telefonoOrig = "";
    }

//Datos del Destino
    if (isset($resultadoConsultarUltimaValija['destinoval']['nombresed'])) {
        $nombreDest = utf8_encode($resultadoConsultarUltimaValija['destinoval']['nombresed']);
    } else {
        $nombreDest = "";
    }
    if (isset($resultadoConsultarUltimaValija['destinoval']['direccionsed'])) {
        $direccionDest = utf8_encode($resultadoConsultarUltimaValija['destinoval']['direccionsed']);
    } else {
        $direccionDest = "";
    }
    if (isset($resultadoConsultarUltimaValija['destinoval']['telefonosed'])) {
        $telefonoDest = $resultadoConsultarUltimaValija['destinoval']['telefonosed'];
    } else {
        $telefonoDest = "";
    }

    ob_start();
    include("../template/proof_pouch.php");

    //Almacenar el resultado de la salida en una variable
    $page = ob_get_contents();

    //Limpiar buffer de salida hasta este punto
    ob_end_clean();

    require_once("../dompdf/dompdf_config.inc.php");

    //Obtenemos el código html de la página web que nos interesa
    $dompdf = new DOMPDF();
    //Creamos una instancia a la clase
    $dompdf->load_html($page);
    //Esta línea es para hacer la página del PDF más grande
    $dompdf->set_paper('carta', 'portrait');
    $dompdf->render();
    $nom = 'Comprobante de Valija No ' . $idVal . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>