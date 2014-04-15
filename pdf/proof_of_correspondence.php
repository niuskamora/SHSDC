<?php

session_start();
$resultadoConsultarUltimoPaquete = $_SESSION["paquete"];
$codigo = $_SESSION["codigo"];
$fecha = $_SESSION["fecha"];

if (isset($resultadoConsultarUltimoPaquete->return)) {

//Datos del Paquete
    $idPaq = $resultadoConsultarUltimoPaquete->return->idpaq;
    if (isset($resultadoConsultarUltimoPaquete->return->idpaqres->idpaq)) {
        $idPaqRes = $resultadoConsultarUltimoPaquete->return->idpaqres->idpaq;
    } else {
        $idPaqRes = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->asuntopaq)) {
        $asunto = $resultadoConsultarUltimoPaquete->return->asuntopaq;
    } else {
        $asunto = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->textopaq)) {
        $texto = $resultadoConsultarUltimoPaquete->return->textopaq;
    } else {
        $texto = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->iddoc->nombredoc)) {
        $documento = $resultadoConsultarUltimoPaquete->return->iddoc->nombredoc;
    } else {
        $documento = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->idpri->nombrepri)) {
        $prioridad = $resultadoConsultarUltimoPaquete->return->idpri->nombrepri;
    } else {
        $prioridad = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->idsed->nombresed)) {
        $sede = $resultadoConsultarUltimoPaquete->return->idsed->nombresed;
    } else {
        $sede = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->fragilpaq)) {
        if ($resultadoConsultarUltimoPaquete->return->fragilpaq == "0") {
            $fragil = "No";
        } else {
            $fragil = "Si";
        }
    } else {
        $fragil = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->respaq)) {
        if ($resultadoConsultarUltimoPaquete->return->respaq == "0") {
            $resp = "No";
        } else {
            $resp = "Si";
        }
    } else {
        $resp = "";
    }

//Datos del Origen
    if (isset($resultadoConsultarUltimoPaquete->return->origenpaq->idusu->nombreusu)) {
        $nombreOrig = $resultadoConsultarUltimoPaquete->return->origenpaq->idusu->nombreusu;
    } else {
        $nombreOrig = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->origenpaq->idusu->direccionusu)) {
        $direccionOrig = $resultadoConsultarUltimoPaquete->return->origenpaq->idusu->direccionusu;
    } else {
        $direccionOrig = "";
    }
    if (isset($resultadoConsultarUltimoPaquete->return->origenpaq->idusu->telefonousu)) {
        $telefonoOrig = $resultadoConsultarUltimoPaquete->return->origenpaq->idusu->telefonousu;
    } else {
        $telefonoOrig = "";
    }

//Datos del Destino
    if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->tipobuz)) {
        if ($resultadoConsultarUltimoPaquete->return->destinopaq->tipobuz == "0") {
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->idusu->nombreusu)) {
                $nombreDest = $resultadoConsultarUltimoPaquete->return->destinopaq->idusu->nombreusu;
            } else {
                $nombreDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->idusu->direccionusu)) {
                $direccionDest = $resultadoConsultarUltimoPaquete->return->destinopaq->idusu->direccionusu;
            } else {
                $direccionDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->idusu->telefonousuz)) {
                $telefonoDest = $resultadoConsultarUltimoPaquete->return->destinopaq->idusu->telefonousu;
            } else {
                $telefonoDest = "";
            }
            $buzon = 0;
            $tipoBuzon = "";
        }
        if ($resultadoConsultarUltimoPaquete->return->destinopaq->tipobuz == "1") {
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->nombrebuz)) {
                $nombreDest = $resultadoConsultarUltimoPaquete->return->destinopaq->nombrebuz;
            } else {
                $nombreDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->direccionbuz)) {
                $direccionDest = $resultadoConsultarUltimoPaquete->return->destinopaq->direccionbuz;
            } else {
                $direccionDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->telefonobuz)) {
                $telefonoDest = $resultadoConsultarUltimoPaquete->return->destinopaq->telefonobuz;
            } else {
                $telefonoDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->correobuz)) {
                $correoDest = $resultadoConsultarUltimoPaquete->return->destinopaq->correobuz;
            } else {
                $correoDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete->return->destinopaq->identificacionbuz)) {
                $identDest = $resultadoConsultarUltimoPaquete->return->destinopaq->identificacionbuz;
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
    include("../template/proof_of_correspondence.php");

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
    $nom = 'Comprobante de Correspondencia No ' . $idPaq . '.pdf';
    $dompdf->stream($nom);
}//Fin del IF general
?>