<?php

session_start();
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
$aux = $_POST['idpaq'];
$_SESSION["falla"] = $_SESSION["falla"] + 1;
$con = $_SESSION["falla"];
$_SESSION["reportados"][$con] = $aux;
javaalert('este es el codigo  ' . $aux . 'suma' . $_SESSION["falla"]);
?>