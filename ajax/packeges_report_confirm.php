<?php

session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
$aux = $_POST['idpaq'];
$_SESSION["confirmar"] = $_SESSION["confirmar"] + 1;
$co = $_SESSION["confirmar"];
$_SESSION["confirmados"][$co] = $aux;
javaalert('este es el codigo  ' . $aux . 'suma' . $_SESSION["confirmar"]);
?>