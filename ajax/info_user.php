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
    $aux = $_POST['idusu'];
    
	$client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
	$_SESSION["cli"]=$client;

    $datosU = array('idUsuario' => utf8_decode($aux));
    $Bandej = $client->call("consultarUsuario",$datosU);
    $reg = 0;
    if ($Bandej!="") {
		$Bandeja=$Bandej['return'];
        $reg = count($Bandeja);
        $_SESSION["usubox"] = $Bandeja['idusu'];
    } else {
        $reg = 0;
    }
    echo "<h2> <strong>" . utf8_encode($Bandeja['nombreusu'] ). " </strong> </h2>";
    if ($reg != 0) {
        echo "<form method='post'> ";
        echo "<table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style='text-align:center'>Nombre</td>
                                    <td style='text-align:center'>
                                    <label>" . utf8_encode($Bandeja['nombreusu']) . "</label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Apellido</td>
                                    <td style='text-align:center'>
                                    <label>" .utf8_encode( $Bandeja['apellidousu']) . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Correo</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja['correousu'] . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Telefono</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja['telefonousu'] . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Telefono auxiliar</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja['telefono2usu'] . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Direccion</td>
                                    <td style='text-align:center'>
                                    <label>" .utf8_encode( $Bandeja['direccionusu']) . " </label> 
                                </tr>
                                
                            </table>
	<button class='btn' id='crear' name='crear' type='submit'>Guardar</button>		  
		</form>
   ";
    }