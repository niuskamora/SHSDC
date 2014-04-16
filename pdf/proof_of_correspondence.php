<?php

session_start();
$resultadoConsultarUltimoPaquete = $_SESSION["paquete"];
$codigo = $_SESSION["codigo"];
$fecha = $_SESSION["fecha"];

if (isset($resultadoConsultarUltimoPaquete)) {

//Datos del Paquete
    $idPaq = $resultadoConsultarUltimoPaquete['idpaq'];
    if (isset($resultadoConsultarUltimoPaquete['idpaqres']['idpaq'])) {
        $idPaqRes = $resultadoConsultarUltimoPaquete['idpaqres']['idpaq'];
    } else {
        $idPaqRes = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['asuntopaq'])) {
        $asunto = $resultadoConsultarUltimoPaquete['asuntopaq'];
    } else {
        $asunto = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['textopaq'])) {
        $texto = $resultadoConsultarUltimoPaquete['textopaq'];
    } else {
        $texto = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['iddoc']['nombredoc'])) {
        $documento = $resultadoConsultarUltimoPaquete['iddoc']['nombredoc'];
    } else {
        $documento = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['idpri']['nombrepri'])) {
        $prioridad = $resultadoConsultarUltimoPaquete['idpri']['nombrepri'];
    } else {
        $prioridad = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['idsed']['nombresed'])) {
        $sede = $resultadoConsultarUltimoPaquete['idsed']['nombresed'];
    } else {
        $sede = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['fragilpaq'])) {
        if ($resultadoConsultarUltimoPaquete['fragilpaq'] == "0") {
            $fragil = "No";
        } else {
            $fragil = "Si";
        }
    } else {
        $fragil = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['respaq'])) {
        if ($resultadoConsultarUltimoPaquete['respaq'] == "0") {
            $resp = "No";
        } else {
            $resp = "Si";
        }
    } else {
        $resp = "";
    }

//Datos del Origen
    if (isset($resultadoConsultarUltimoPaquete['origenpaq']['idusu']['nombreusu'])) {
        $nombreOrig = $resultadoConsultarUltimoPaquete['origenpaq']['idusu']['nombreusu'];
    } else {
        $nombreOrig = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['origenpaq']['idusu']['direccionusu'])) {
        $direccionOrig = $resultadoConsultarUltimoPaquete['origenpaq']['idusu']['direccionusu'];
    } else {
        $direccionOrig = "";
    }
    if (isset($resultadoConsultarUltimoPaquete['origenpaq']['idusu']['telefonousu'])) {
        $telefonoOrig = $resultadoConsultarUltimoPaquete['origenpaq']['idusu']['telefonousu'];
    } else {
        $telefonoOrig = "";
    }

//Datos del Destino
    if (isset($resultadoConsultarUltimoPaquete['destinopaq']['tipobuz'])) {
        if ($resultadoConsultarUltimoPaquete['destinopaq']['tipobuz'] == "0") {
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['idusu']['nombreusu'])) {
                $nombreDest = $resultadoConsultarUltimoPaquete['destinopaq']['idusu']['nombreusu'];
            } else {
                $nombreDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['idusu']['direccionusu'])) {
                $direccionDest = $resultadoConsultarUltimoPaquete['destinopaq']['idusu']['direccionusu'];
            } else {
                $direccionDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['idusu']['telefonousuz'])) {
                $telefonoDest = $resultadoConsultarUltimoPaquete['destinopaq']['idusu']['telefonousuz'];
            } else {
                $telefonoDest = "";
            }
            $buzon = 0;
            $tipoBuzon = "";
        }
        if ($resultadoConsultarUltimoPaquete['destinopaq']['tipobuz'] == "1") {
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['nombrebuz'])) {
                $nombreDest = $resultadoConsultarUltimoPaquete['destinopaq']['nombrebuz'];
            } else {
                $nombreDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['direccionbuz'])) {
                $direccionDest = $resultadoConsultarUltimoPaquete['destinopaq']['direccionbuz'];
            } else {
                $direccionDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['telefonobuz'])) {
                $telefonoDest = $resultadoConsultarUltimoPaquete['destinopaq']['telefonobuz'];
            } else {
                $telefonoDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['correobuz'])) {
                $correoDest = $resultadoConsultarUltimoPaquete['destinopaq']['correobuz'];
            } else {
                $correoDest = "";
            }
            if (isset($resultadoConsultarUltimoPaquete['destinopaq']['identificacionbuz'])) {
                $identDest = $resultadoConsultarUltimoPaquete['destinopaq']['identificacionbuz'];
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