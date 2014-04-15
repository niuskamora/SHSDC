<?php

session_start();

$fechaEnvio = $_SESSION["fechaEnvio"];
$fechaRecibido = $_SESSION["fechaRecibido"];
$resultadoPaquetesPorValija = $_SESSION["paquetesXValija"];
$resultadoOrigen = $_SESSION["origenValija"];
$contadorPaquetes = count($resultadoPaquetesPorValija->return);

//Datos de la Valija
if (isset($resultadoOrigen->return->nombresed)) {
    $origen = $resultadoOrigen->return->nombresed;
} else {
    $origen = "";
}
if ($contadorPaquetes > 1) {
    $idVal = $resultadoPaquetesPorValija->return[0]->idval->idval;
    if (isset($resultadoPaquetesPorValija->return[0]->idval->codproveedorval)) {
        $guia = $resultadoPaquetesPorValija->return[0]->idval->codproveedorval;
    } else {
        $guia = "";
    }
    if (isset($resultadoPaquetesPorValija->return[0]->idval->tipoval)) {
        $tipo = $resultadoPaquetesPorValija->return[0]->idval->tipoval;
    } else {
        $tipo = "";
    }
    if (isset($resultadoPaquetesPorValija->return[0]->idval->destinoval->nombresed)) {
        $destino = $resultadoPaquetesPorValija->return[0]->idval->destinoval->nombresed;
    } else {
        $destino = "";
    }
} elseif($contadorPaquetes==1) {
    $idVal = $resultadoPaquetesPorValija->return->idval->idval;
    if (isset($resultadoPaquetesPorValija->return->idval->codproveedorval)) {
        $guia = $resultadoPaquetesPorValija->return->idval->codproveedorval;
    } else {
        $guia = "";
    }
    if (isset($resultadoPaquetesPorValija->return->idval->tipoval)) {
        $tipo = $resultadoPaquetesPorValija->return->idval->tipoval;
    } else {
        $tipo = "";
    }
    if (isset($resultadoPaquetesPorValija->return->idval->destinoval->nombresed)) {
        $destino = $resultadoPaquetesPorValija->return->idval->destinoval->nombresed;
    } else {
        $destino = "";
    }
}

if ($contadorPaquetes > 0) {
    ob_start();
    include("../template/proof_pouch_and_packages.php");

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
    $nom = 'Comprobante de Detalle de Valija No ' . $idVal . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>