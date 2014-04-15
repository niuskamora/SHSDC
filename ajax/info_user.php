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
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
    $aux = $_POST['idusu'];
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;

    $datosU = array('idUsuario' => $aux);
    $Bandeja = $client->consultarUsuario($datosU);
    $reg = 0;
    if (isset($Bandeja->return)) {
        $reg = count($Bandeja->return);
        $_SESSION["usubox"] = $Bandeja->return->idusu;
    } else {
        $reg = 0;
    }
    echo "<h2> <strong>" . $Bandeja->return->nombreusu . " </strong> </h2>";
    if ($reg != 0) {
        echo "<form method='post'> ";
        echo "<table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style='text-align:center'>Nombre</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->nombreusu . "</label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Apellido</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->apellidousu . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Correo</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->correousu . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Telefono</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->telefonousu . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Telefono auxiliar</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->telefono2usu . " </label> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Direccion</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->direccionusu . " </label> 
                                </tr>
                                
                            </table>
	<button class='btn' id='crear' name='crear' type='submit'>Guardar</button>		  
		</form>
   ";
    }