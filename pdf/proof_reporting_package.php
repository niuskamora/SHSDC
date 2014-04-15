<?php

session_start();

$fechaEnvio = $_SESSION["fechaEnvio"];
$resultadoConsultarPaquetes = $_SESSION["paquetes"];
$contadorPaquetes = count($resultadoConsultarPaquetes->return);
$reporte = $_SESSION["Reporte"];

if ($reporte == '1') {
    $nombreReporte = "Paquetes Enviados";
} elseif ($reporte == '2') {
    $nombreReporte = "Paquetes Recibidos";
} elseif ($reporte == '3') {
    $nombreReporte = "Paquetes por Entregar";
}

if ($contadorPaquetes > 0) {
    ob_start();
    include("../template/proof_reporting_package.php");

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
    $nom = 'Comprobante de ' . $contadorPaquetes . ' ' . $nombreReporte . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>