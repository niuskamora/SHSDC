<?php

session_start();
$resultadoConsultarUltimaValija = $_SESSION["valija"];
$codigo = $_SESSION["codigo"];
$resultadoOrigen = $_SESSION["origen"];
$fecha = $_SESSION["fecha"];

if (isset($resultadoConsultarUltimaValija->return)) {

//Datos de la Valija
    $idVal = $resultadoConsultarUltimaValija->return->idval;
    if (isset($resultadoConsultarUltimaValija->return->iduse->idsed->nombresed)) {
        $sede = $resultadoConsultarUltimaValija->return->iduse->idsed->nombresed;
    } else {
        $sede = "";
    }
    if (isset($resultadoConsultarUltimaValija->return->tipoval)) {
        $tipo = $resultadoConsultarUltimaValija->return->tipoval;
    } else {
        $tipo = "";
    }

//Datos del Origen
    if (isset($resultadoOrigen->return->nombresed)) {
        $nombreOrig = $resultadoOrigen->return->nombresed;
    } else {
        $nombreOrig = "";
    }
    if (isset($resultadoOrigen->return->direccionsed)) {
        $direccionOrig = $resultadoOrigen->return->direccionsed;
    } else {
        $direccionOrig = "";
    }
    if (isset($resultadoOrigen->return->telefonosed)) {
        $telefonoOrig = $resultadoOrigen->return->telefonosed;
    } else {
        $telefonoOrig = "";
    }

//Datos del Destino
    if (isset($resultadoConsultarUltimaValija->return->destinoval->nombresed)) {
        $nombreDest = $resultadoConsultarUltimaValija->return->destinoval->nombresed;
    } else {
        $nombreDest = "";
    }
    if (isset($resultadoConsultarUltimaValija->return->destinoval->direccionsed)) {
        $direccionDest = $resultadoConsultarUltimaValija->return->destinoval->direccionsed;
    } else {
        $direccionDest = "";
    }
    if (isset($resultadoConsultarUltimaValija->return->destinoval->telefonosed)) {
        $telefonoDest = $resultadoConsultarUltimaValija->return->destinoval->telefonosed;
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