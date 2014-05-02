<?php

session_start();
$resultadoPaquete = $_SESSION["trakingPaquete"];
if (isset($resultadoPaquete)) {
    if (isset($resultadoPaquete[0])) {
        $contadorPaquete = count($resultadoPaquete);
    } else {
        $contadorPaquete = 1;
    }
} else {
    $contadorPaquete = 0;
}
$fecha = $_SESSION["fecha"];

//Datos del Paquete
if ($contadorPaquete > 1) {
    $idPaq = $resultadoPaquete[0]['idpaq']['idpaq'];
    if (isset($resultadoPaquete[0]['idpaq']['origenpaq']['idatr']['idsed']['nombresed'])) {
        $origen = utf8_encode($resultadoPaquete[0]['idpaq']['origenpaq']['idatr']['idsed']['nombresed']);
    } else {
        $origen = "";
    }
    if (isset($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['nombreusu'])) {
        $deNombre = utf8_encode($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['nombreusu']);
    } else {
        $deNombre = "";
    }
    if (isset($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['apellidousu'])) {
        $deApellido = utf8_encode($resultadoPaquete[0]['idpaq']['origenpaq']['idusu']['apellidousu']);
    } else {
        $deApellido = "";
    }
    $paraApellido = "";
    $paraNombre = "";
    $destino = "";
    if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['tipobuz'])) {
        if ($resultadoPaquete[0]['idpaq']['destinopaq']['tipobuz'] == "0") {
            if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['nombreusu'])) {
                $paraNombre = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['nombreusu']);
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['apellidousu'])) {
                $paraApellido = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['idusu']['apellidousu']);
            } else {
                $paraApellido = "";
            }
            if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['idatr']['idsed']['nombresed'])) {
                $destino = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['idatr']['idsed']['nombresed']);
            } else {
                $destino = "";
            }
        }
        if ($resultadoPaquete[0]['idpaq']['destinopaq']['tipobuz'] == "1") {
            if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['nombrebuz'])) {
                $paraNombre = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['nombrebuz']);
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete[0]['idpaq']['destinopaq']['direccionbuz'])) {
                $destino = utf8_encode($resultadoPaquete[0]['idpaq']['destinopaq']['direccionbuz']);
            } else {
                $destino = "";
            }
        }
    }
} elseif ($contadorPaquete == 1) {
    $idPaq = $resultadoPaquete['idpaq']['idpaq'];
    if (isset($resultadoPaquete['idpaq']['origenpaq']['idatr']['idsed']['nombresed'])) {
        $origen = utf8_encode($resultadoPaquete['idpaq']['origenpaq']['idatr']['idsed']['nombresed']);
    } else {
        $origen = "";
    }
    if (isset($resultadoPaquete['idpaq']['origenpaq']['idusu']['nombreusu'])) {
        $deNombre = utf8_encode($resultadoPaquete['idpaq']['origenpaq']['idusu']['nombreusu']);
    } else {
        $deNombre = "";
    }
    if (isset($resultadoPaquete['idpaq']['origenpaq']['idusu']['apellidousu'])) {
        $deApellido = utf8_encode($resultadoPaquete['idpaq']['origenpaq']['idusu']['apellidousu']);
    } else {
        $deApellido = "";
    }
    $paraApellido = "";
    $paraNombre = "";
    $destino = "";
    if (isset($resultadoPaquete['idpaq']['destinopaq']['tipobuz'])) {
        if ($resultadoPaquete['idpaq']['destinopaq']['tipobuz'] == "0") {
            if (isset($resultadoPaquete['idpaq']['destinopaq']['idusu']['nombreusu'])) {
                $paraNombre = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['idusu']['nombreusu']);
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete['idpaq']['destinopaq']['idusu']['apellidousu'])) {
                $paraApellido = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['idusu']['apellidousu']);
            } else {
                $paraApellido = "";
            }
            if (isset($resultadoPaquete['idpaq']['destinopaq']['idatr']['idsed']['nombresed'])) {
                $destino = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['idatr']['idsed']['nombresed']);
            } else {
                $destino = "";
            }
        }
        if ($resultadoPaquete['idpaq']['destinopaq']['tipobuz'] == "1") {
            if (isset($resultadoPaquete['idpaq']['destinopaq']['nombrebuz'])) {
                $paraNombre = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['nombrebuz']);
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete['idpaq']['destinopaq']['direccionbuz'])) {
                $destino = utf8_encode($resultadoPaquete['idpaq']['destinopaq']['direccionbuz']);
            } else {
                $destino = "";
            }
        }
    }
}
if ($contadorPaquete > 0) {
    ob_start();
    include("../template/proof_of_traking_package.php");

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
    $nom = 'Comprobante Tracking de Paquete No ' . $idPaq . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>