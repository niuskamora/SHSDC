<?php

session_start();
$resultadoConsultarPaquete = $_SESSION["paqueteDos"];
$codigo = $_SESSION["codigoDos"];
$fecha = $_SESSION["fecha"];

if (isset($resultadoConsultarPaquete->return)) {

//Datos del Paquete
    $idPaq = $resultadoConsultarPaquete->return->idpaq;
    if (isset($resultadoConsultarPaquete->return->idpaqres->idpaq)) {
        $idPaqRes = $resultadoConsultarPaquete->return->idpaqres->idpaq;
    } else {
        $idPaqRes = "";
    }
    if (isset($resultadoConsultarPaquete->return->asuntopaq)) {
        $asunto = $resultadoConsultarPaquete->return->asuntopaq;
    } else {
        $asunto = "";
    }
    if (isset($resultadoConsultarPaquete->return->textopaq)) {
        $texto = $resultadoConsultarPaquete->return->textopaq;
    } else {
        $texto = "";
    }
    if (isset($resultadoConsultarPaquete->return->iddoc->nombredoc)) {
        $documento = $resultadoConsultarPaquete->return->iddoc->nombredoc;
    } else {
        $documento = "";
    }
    if (isset($resultadoConsultarPaquete->return->idpri->nombrepri)) {
        $prioridad = $resultadoConsultarPaquete->return->idpri->nombrepri;
    } else {
        $prioridad = "";
    }
    if (isset($resultadoConsultarPaquete->return->idsed->nombresed)) {
        $sede = $resultadoConsultarPaquete->return->idsed->nombresed;
    } else {
        $sede = "";
    }
    if (isset($resultadoConsultarPaquete->return->fragilpaq)) {
        if ($resultadoConsultarPaquete->return->fragilpaq == "0") {
            $fragil = "No";
        } else {
            $fragil = "Si";
        }
    } else {
        $fragil = "";
    }
    if (isset($resultadoConsultarPaquete->return->respaq)) {
        if ($resultadoConsultarPaquete->return->respaq == "0") {
            $resp = "No";
        } else {
            $resp = "Si";
        }
    } else {
        $resp = "";
    }

//Datos del Origen
    if (isset($resultadoConsultarPaquete->return->origenpaq->idusu->nombreusu)) {
        $nombreOrig = $resultadoConsultarPaquete->return->origenpaq->idusu->nombreusu;
    } else {
        $nombreOrig = "";
    }
    if (isset($resultadoConsultarPaquete->return->origenpaq->idusu->direccionusu)) {
        $direccionOrig = $resultadoConsultarPaquete->return->origenpaq->idusu->direccionusu;
    } else {
        $direccionOrig = "";
    }
    if (isset($resultadoConsultarPaquete->return->origenpaq->idusu->telefonousu)) {
        $telefonoOrig = $resultadoConsultarPaquete->return->origenpaq->idusu->telefonousu;
    } else {
        $telefonoOrig = "";
    }

//Datos del Destino
    if (isset($resultadoConsultarPaquete->return->destinopaq->tipobuz)) {
        if ($resultadoConsultarPaquete->return->destinopaq->tipobuz == "0") {
            if (isset($resultadoConsultarPaquete->return->destinopaq->idusu->nombreusu)) {
                $nombreDest = $resultadoConsultarPaquete->return->destinopaq->idusu->nombreusu;
            } else {
                $nombreDest = "";
            }
            if (isset($resultadoConsultarPaquete->return->destinopaq->idusu->direccionusu)) {
                $direccionDest = $resultadoConsultarPaquete->return->destinopaq->idusu->direccionusu;
            } else {
                $direccionDest = "";
            }
            if (isset($resultadoConsultarPaquete->return->destinopaq->idusu->telefonousuz)) {
                $telefonoDest = $resultadoConsultarPaquete->return->destinopaq->idusu->telefonousu;
            } else {
                $telefonoDest = "";
            }
            $buzon = 0;
            $tipoBuzon = "";
        }
        if ($resultadoConsultarPaquete->return->destinopaq->tipobuz == "1") {
            if (isset($resultadoConsultarPaquete->return->destinopaq->nombrebuz)) {
                $nombreDest = $resultadoConsultarPaquete->return->destinopaq->nombrebuz;
            } else {
                $nombreDest = "";
            }
            if (isset($resultadoConsultarPaquete->return->destinopaq->direccionbuz)) {
                $direccionDest = $resultadoConsultarPaquete->return->destinopaq->direccionbuz;
            } else {
                $direccionDest = "";
            }
            if (isset($resultadoConsultarPaquete->return->destinopaq->telefonobuz)) {
                $telefonoDest = $resultadoConsultarPaquete->return->destinopaq->telefonobuz;
            } else {
                $telefonoDest = "";
            }
            if (isset($resultadoConsultarPaquete->return->destinopaq->correobuz)) {
                $correoDest = $resultadoConsultarPaquete->return->destinopaq->correobuz;
            } else {
                $correoDest = "";
            }
            if (isset($resultadoConsultarPaquete->return->destinopaq->identificacionbuz)) {
                $identDest = $resultadoConsultarPaquete->return->destinopaq->identificacionbuz;
            } else {
                $identDest = "";
            }
            $buzon = 1;
            $tipoBuzon = "Externo";
        }
    } else {
        $tipoBuzon = "";
    }
	
    ob_start();
    include("../template/proof_of_correspondence_package.php");

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
    $nom = 'Comprobante de Paquete No ' . $idPaq . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>