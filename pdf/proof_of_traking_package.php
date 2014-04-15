<?php

session_start();
$resultadoPaquete = $_SESSION["trakingPaquete"];
$contadorPaquete = count($resultadoPaquete->return);
$fecha = $_SESSION["fecha"];

//Datos del Paquete
if ($contadorPaquete > 1) {
    $idPaq = $resultadoPaquete->return[0]->idpaq->idpaq;
    if (isset($resultadoPaquete->return[0]->idpaq->origenpaq->idatr->idsed->nombresed)) {
        $origen = $resultadoPaquete->return[0]->idpaq->origenpaq->idatr->idsed->nombresed;
    } else {
        $origen = "";
    }
    if (isset($resultadoPaquete->return[0]->idpaq->origenpaq->idusu->nombreusu)) {
        $deNombre = $resultadoPaquete->return[0]->idpaq->origenpaq->idusu->nombreusu;
    } else {
        $deNombre = "";
    }
    if (isset($resultadoPaquete->return[0]->idpaq->origenpaq->idusu->apellidousu)) {
        $deApellido = $resultadoPaquete->return[0]->idpaq->origenpaq->idusu->apellidousu;
    } else {
        $deApellido = "";
    }
    $paraApellido = "";
    $paraNombre = "";
    $destino = "";
    if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->tipobuz)) {
        if ($resultadoPaquete->return[0]->idpaq->destinopaq->tipobuz == "0") {
            if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->idusu->nombreusu)) {
                $paraNombre = $resultadoPaquete->return[0]->idpaq->destinopaq->idusu->nombreusu;
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->idusu->apellidousu)) {
                $paraApellido = $resultadoPaquete->return[0]->idpaq->destinopaq->idusu->apellidousu;
            } else {
                $paraApellido = "";
            }
            if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->idatr->idsed->nombresed)) {
                $destino = $resultadoPaquete->return[0]->idpaq->destinopaq->idatr->idsed->nombresed;
            } else {
                $destino = "";
            }
        }
        if ($resultadoPaquete->return[0]->idpaq->destinopaq->tipobuz == "1") {
            if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->nombrebuz)) {
                $paraNombre = $resultadoPaquete->return[0]->idpaq->destinopaq->nombrebuz;
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete->return[0]->idpaq->destinopaq->direccionbuz)) {
                $destino = $resultadoPaquete->return[0]->idpaq->destinopaq->direccionbuz;
            } else {
                $destino = "";
            }
        }
    }
} elseif($contadorPaquete==1) {
    $idPaq = $resultadoPaquete->return->idpaq->idpaq;
    if (isset($resultadoPaquete->return->idpaq->origenpaq->idatr->idsed->nombresed)) {
        $origen = $resultadoPaquete->return->idpaq->origenpaq->idatr->idsed->nombresed;
    } else {
        $origen = "";
    }
    if (isset($resultadoPaquete->return->idpaq->origenpaq->idusu->nombreusu)) {
        $deNombre = $resultadoPaquete->return->idpaq->origenpaq->idusu->nombreusu;
    } else {
        $deNombre = "";
    }
    if (isset($resultadoPaquete->return->idpaq->origenpaq->idusu->apellidousu)) {
        $deApellido = $resultadoPaquete->return->idpaq->origenpaq->idusu->apellidousu;
    } else {
        $deApellido = "";
    }
    $paraApellido = "";
    $paraNombre = "";
    $destino = "";
    if (isset($resultadoPaquete->return->idpaq->destinopaq->tipobuz)) {
        if ($resultadoPaquete->return->idpaq->destinopaq->tipobuz == "0") {
            if (isset($resultadoPaquete->return->idpaq->destinopaq->idusu->nombreusu)) {
                $paraNombre = $resultadoPaquete->return->idpaq->destinopaq->idusu->nombreusu;
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete->return->idpaq->destinopaq->idusu->apellidousu)) {
                $paraApellido = $resultadoPaquete->return->idpaq->destinopaq->idusu->apellidousu;
            } else {
                $paraApellido = "";
            }
            if (isset($resultadoPaquete->return->idpaq->destinopaq->idatr->idsed->nombresed)) {
                $destino = $resultadoPaquete->return->idpaq->destinopaq->idatr->idsed->nombresed;
            } else {
                $destino = "";
            }
        }
        if ($resultadoPaquete->return->idpaq->destinopaq->tipobuz == "1") {
            if (isset($resultadoPaquete->return->idpaq->destinopaq->nombrebuz)) {
                $paraNombre = $resultadoPaquete->return->idpaq->destinopaq->nombrebuz;
            } else {
                $paraNombre = "";
            }
            if (isset($resultadoPaquete->return->idpaq->destinopaq->direccionbuz)) {
                $destino = $resultadoPaquete->return->idpaq->destinopaq->direccionbuz;
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
    $nom = 'Comprobante Traking de Paquete No ' . $idPaq . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>