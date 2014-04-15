<?php

session_start();

$fechaEnvio = $_SESSION["fechaEnvio"];
$fechaRecibido = $_SESSION["fechaRecibido"];
$resultadoConsultarValijas = $_SESSION["valijas"];
$nombreSede = $_SESSION["nombreSede"];
$valijas = count($resultadoConsultarValijas->return);
$reporte = $_SESSION["Reporte"];

if ($reporte == '1') {
    $nombreReporte = "Valijas Enviadas";
} elseif ($reporte == '2') {
    $nombreReporte = "Valijas Recibidas";
} elseif ($reporte == '3') {
    $nombreReporte = "Valijas con Errores";
} elseif ($reporte == '4') {
    $nombreReporte = "Valijas Anuladas";
}

if ($valijas > 0) {
    ob_start();
    include("../template/proof_of_bags_report.php");

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
    $nom = 'Comprobante de ' . $valijas . ' '.$nombreReporte.'.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>