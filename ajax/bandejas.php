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
    $aux = $_POST['idban'];
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $Usuario = array('user' => $_SESSION["Usuario"]->return->idusu, 'ban' => $aux);
    $Bandeja = $client->consultarPaquetesXBandeja($Usuario);
    $reg = 0;
    if (isset($Bandeja->return)) {
        $reg = count($Bandeja->return);
    } else {
        $reg = 0;
    }
    echo "<h2> <strong>" . $aux . "</h2> </strong>";
    if ($reg != 0) {
        echo "</div>";
        echo "<br> <form method='get'>";
        echo "<table class='footable table table-striped table-bordered' align='center'  data-page-size=$itemsByPage>
    	 <thead bgcolor='#ff0000'>
                                    <tr>";
        if ($aux == "Por Recibir" || $aux == "Recibidas") {
            echo"<th style='width:7%; text-align:center'>Origen</th>";
        } else if ($aux == "Por Entregar" || $aux == "Entregadas") {
            echo "<th style='width:7%; text-align:center' >Destino</th>";
        }
        if ($aux != "Por Recibir") {
            echo "<th style='width:7%; text-align:center' data-sort-ignore='true'>Asunto </th>";
        } else {
            echo "<th style='width:7%; text-align:center' data-sort-ignore='true'>Código </th>";
        }
        echo "<th style='width:7%; text-align:center' >Tipo</th>
                                        <th style='width:7%; text-align:center' data-sort-ignore='true'>Con Respuesta</th>
                                        <th style='width:7%; text-align:center' >Fecha</th>";

        if ($aux != "Recibidas") {
            echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>Localización</th>";
        }
        echo "<th style='width:7%; text-align:center' data-sort-ignore='true'>Ver más</th>";
        if ($aux == "Por Recibir") {
			
            echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>Confirmar</th>";
			
        }
        if ($aux == "Recibidas") {
            echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>Status</th>";
        }
        echo "</tr>
         </thead>
        <tbody>		
        	<tr>";
        if ($reg > 1) {
            $j = 0;
            while ($j < $reg) {
                if (strlen($Bandeja->return[$j]->asuntopaq) > 10) {
                    $asunto = substr($Bandeja->return[$j]->asuntopaq, 0, 10) . "...";
                } else {
                    $asunto = $Bandeja->return[$j]->asuntopaq;
                }
                if ($aux == "Por Recibir" || $aux == "Recibidas") {
                    echo "<td  style='text-align:center'>" . $Bandeja->return[$j]->origenpaq->idusu->nombreusu . " ".$Bandeja->return[$j]->origenpaq->idusu->apellidousu. "</td>";
                } else if ($aux == "Por Entregar" || $aux == "Entregadas") {
                    if ($Bandeja->return[$j]->destinopaq->tipobuz == "1") {
                        echo "<td  style='text-align:center'>" . $Bandeja->return[$j]->destinopaq->nombrebuz . "</td>";
                    } else {
                        echo "<td  style='text-align:center'>" . $Bandeja->return[$j]->destinopaq->idusu->nombreusu ." ".$Bandeja->return[$j]->destinopaq->idusu->apellidousu. "</td>";
                    }
                }
                if ($aux != "Por Recibir") {
                    echo "<td  style='text-align:center'>" . $asunto . "</td>";
                } else {
                    echo "<th style='width:7%; text-align:center' data-sort-ignore='true'>" . $Bandeja->return[$j]->idpaq . "</th>";
                }
                echo "<td style='text-align:center'>" . $Bandeja->return[$j]->iddoc->nombredoc . "</td>";
                if ($Bandeja->return[$j]->respaq == 1 || $Bandeja->return[$j]->respaq == 2) {
                    echo "<td style='text-align:center'> Si </td>";
                } else {
                    echo "<td style='text-align:center'> No </td>";
                }
                echo "<td style='text-align:center'>" . date("d/m/Y", strtotime(substr($Bandeja->return[$j]->fechapaq, 0, 10))) . "</td>";
                if ($aux != "Recibidas") {
                    echo "<td style='text-align:center'>" . $Bandeja->return[$j]->localizacionpaq . "</td>";
                }
                echo "<td style='text-align:center'><a href='../pages/see_package.php?id=" . $Bandeja->return[$j]->idpaq . "'><button type='button' class='btn btn-info btn-primary' value='Realizar Valija'>  Ver Más </button> </a></td>";
                if ($aux == "Por Recibir") {
					
                    echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>
			<form> <button type='button' class='btn btn-info btn-primary' onClick='Confirmar(" . $Bandeja->return[$j]->idpaq . ");' value='Realizar Valija'>  Confirmar </button> </form> </th>";
			
                }
                if ($aux == "Recibidas") {
                    if ($Bandeja->return[$j]->respaq == "1") {
                        echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>
			<a href='../pages/response_package.php?idpaqr=" . $Bandeja->return[$j]->idpaq . "'><button type='button' class='btn btn-info btn-primary' value='Responder'>  Responder </button> </a></td>";
                    } else {
                        echo "<td  style='text-align:center'>Recibido </td>";
                    }
                }
                echo "</tr>";
                $j++;
            }
        } else {
            if (strlen($Bandeja->return->asuntopaq) > 10) {
                $asunto = substr($Bandeja->return->asuntopaq, 0, 10) . "...";
            } else {
                $asunto = $Bandeja->return->asuntopaq;
            }
			 if ($aux == "Por Recibir" || $aux == "Recibidas") {
                    echo "<td  style='text-align:center'>" . $Bandeja->return->origenpaq->idusu->nombreusu . " ".$Bandeja->return->origenpaq->idusu->apellidousu ."</td>";
                } else if ($aux == "Por Entregar" || $aux == "Entregadas") {
                    if ($Bandeja->return->destinopaq->tipobuz == "1") {
                        echo "<td  style='text-align:center'>" . $Bandeja->return->destinopaq->nombrebuz . "</td>";
                    } else {
                        echo "<td  style='text-align:center'>" . $Bandeja->return->destinopaq->idusu->nombreusu ." ".$Bandeja->return->destinopaq->idusu->apellidousu ."</td>";
                    }
                }
           // echo "<td  style='text-align:center'>" . $Bandeja->return->destinopaq->idusu->nombreusu ." ".$Bandeja->return->destinopaq->idusu->apellidousu "</td>";
            if ($aux != "Por Recibir") {
                echo "<td  style='text-align:center'>" . $asunto . "</td>";
            } else {
                echo "<th style='width:7%; text-align:center' data-sort-ignore='true'>" . $Bandeja->return->idpaq . "</th>";
            }
            echo "<td style='text-align:center'>" . $Bandeja->return->iddoc->nombredoc . "</td>";
            if ($Bandeja->return->respaq == 1 || $Bandeja->return->respaq == 2) {
                echo "<td style='text-align:center'> Si </td>";
            } else {
                echo "<td style='text-align:center'> No </td>";
            }
            echo "<td style='text-align:center'>" . date("d/m/Y", strtotime(substr($Bandeja->return->fechapaq, 0, 10))) . "</td>";
            if ($aux != "Recibidas") {
                echo "<td style='text-align:center'>" . $Bandeja->return->localizacionpaq . "</td>";
            }echo "<td style='text-align:center'><a href='../pages/see_package.php?id=" . $Bandeja->return->idpaq . "'><button type='button' class='btn btn-info btn-primary' value='Realizar Valija'>  Ver Más </button> </a></td>";
            if ($aux == "Por Recibir") {
                echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>
			 <button type='button' class='btn btn-info btn-primary' onClick='Confirmar(" . $Bandeja->return->idpaq . ");' value='Realizar Valija'>  Confirmar </button>  </th>";
            }
            if ($aux == "Recibidas") {
                if ($Bandeja->return->respaq == "1") {
                    echo"<th style='width:7%; text-align:center' data-sort-ignore='true'>
			<a href='../pages/response_package.php?idpaqr=" . $Bandeja->return->idpaq . "'><button type='button' class='btn btn-info btn-primary' value='Responder'>  Responder </button> </a></td>";
                } else {
                    echo "<td  style='text-align:center'>Recibido </td>";
                }
            }
            echo "</tr>";
        }
        echo " </tbody>
  	</table>	
	</form>";
        echo '<ul id="pagination" class="footable-nav"><span>Pag:</span></ul>';
    } else {
        echo "<br>";
        echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No hay Paquetes en Bandeja </h4>
		</div> ";
    }
    ?>
    <script src="../js/footable.js" type="text/javascript"></script>
    <script src="../js/footable.paginate.js" type="text/javascript"></script>
    <script src="../js/footable.sortable.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function() {
            $('table').footable();
        });
    </script>