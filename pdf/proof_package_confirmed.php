<?php

session_start();
$paquetesTotales = $_SESSION["paquetesTotales"];
$codigos = $_SESSION["codigos"];
$contadorPaquetes = count($paquetesTotales);
$rol = $_SESSION["rol"];

if ($contadorPaquetes > 0) {
    ob_start();
    include("../template/proof_package_confirmed.php");

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
    $nom = 'Comprobante de ' . $contadorPaquetes . ' Paquetes Confirmados.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>