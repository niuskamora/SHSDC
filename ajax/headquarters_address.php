<!-- styles -->
<link rel="shortcut icon" href="../images/faviconsh.ico">

<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/bootstrap-combined.min.css" rel="stylesheet">
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link href="../css/jquery.fancybox.css" rel="stylesheet">
<!-- [if IE 7]>
  <link rel="stylesheet" href="font-awesome/css/font-awesome-ie7.min.css">
<![endif]--> 

<!--Load fontAwesome css-->
<link rel="stylesheet" type="text/css" media="all" href="../font-awesome/css/font-awesome.min.css">
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

<!-- [if IE 7]>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="../css/footable-0.1.css" rel="stylesheet" type="text/css" />
<link href="../css/footable.sortable-0.1.css" rel="stylesheet" type="text/css" />
<link href="../css/footable.paginate.css" rel="stylesheet" type="text/css" />
<body class="appBg">
    
    <?php

    session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
    $aux = $_POST['sed'];
    
	$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
	$_SESSION["cli"]=$client;
    $datosU = array('idSede' => $aux);
    $Bandej = $client->call("consultarSedeXId",$datosU);
    $reg = 0;
    if ($Bandej!="") {
		$Bandeja=$Bandej['return'];
        $reg = 1;
    } else {
        $reg = 0;
    }
 
    if ($reg != 0) {
 echo ' <textarea style="width:500px;"  id="direccion1" name="direccion1" maxlength="2000"  style="width:800px" > '.utf8_encode($Bandeja['direccionsed']).' </textarea>  ';
		    }