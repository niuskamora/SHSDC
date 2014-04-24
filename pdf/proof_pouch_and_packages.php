<?php

session_start();

$fechaEnvio = $_SESSION["fechaEnvio"];
$fechaRecibido = $_SESSION["fechaRecibido"];
$resultadoPaquetesPorValija = $_SESSION["paquetesXValija"];
$origen = $_SESSION["origenValija"];

if (isset($resultadoPaquetesPorValija)) {
    if (isset($resultadoPaquetesPorValija[0])) {
        $contadorPaquetes = count($resultadoPaquetesPorValija);
    } else {
        $contadorPaquetes = 1;
    }
} else {
    $contadorPaquetes = 0;
}

//Datos de la Valija
if ($contadorPaquetes > 1) {
    $idVal = $resultadoPaquetesPorValija[0]['idval']['idval'];
    if (isset($resultadoPaquetesPorValija[0]['idval']['codproveedorval'])) {
        $guia = $resultadoPaquetesPorValija[0]['idval']['codproveedorval'];
    } else {
        $guia = "";
    }
    if (isset($resultadoPaquetesPorValija[0]['idval']['tipoval'])) {
        if ($resultadoPaquetesPorValija[0]['idval']['tipoval'] == "1") {
            $tipo = "Documento";
        } elseif ($resultadoPaquetesPorValija[0]['idval']['tipoval'] == "2") {
            $tipo = "Mercancía";
        }
    } else {
        $tipo = "";
    }
    if (isset($resultadoPaquetesPorValija[0]['idval']['destinoval']['nombresed'])) {
        $destino = utf8_encode($resultadoPaquetesPorValija[0]['idval']['destinoval']['nombresed']);
    } else {
        $destino = "";
    }
} elseif ($contadorPaquetes == 1) {
    $idVal = $resultadoPaquetesPorValija['idval']['idval'];
    if (isset($resultadoPaquetesPorValija['idval']['codproveedorval'])) {
        $guia = $resultadoPaquetesPorValija['idval']['codproveedorval'];
    } else {
        $guia = "";
    }
    if (isset($resultadoPaquetesPorValija['idval']['tipoval'])) {
        if ($resultadoPaquetesPorValija['idval']['tipoval'] == "1") {
            $tipo = "Documento";
        } elseif ($resultadoPaquetesPorValija['idval']['tipoval'] == "2") {
            $tipo = "Mercancía";
        }
    } else {
        $tipo = "";
    }
    if (isset($resultadoPaquetesPorValija['idval']['destinoval']['nombresed'])) {
        $destino = utf8_encode($resultadoPaquetesPorValija['idval']['destinoval']['nombresed']);
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