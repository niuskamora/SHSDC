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
	require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
	session_start();
    $nom = $_POST['nom'];
    $ape = $_POST['ape'];
    $area = $_POST['area'];
    $reg = 0;
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$idusu["idusu"] = $_SESSION["Usuario"]["idusu"];
	$parametrosBuzon["idUsuario"] = $idusu;
	 $consumo = $client->call("miIdBuzon",$parametrosBuzon);
    $idBuzon = $consumo['return'];
	$idBuz["idbuz"]=$idBuzon;
    $BuzonNA = array('nombre' => $nom, 'apellido' => $ape, 'area' => $area, 'miBuzon' =>$idBuz);
	$consumo = $client->call("consultarBuzonParaEnviar",$BuzonNA);
echo '<pre>';print_r( $consumo);	
  
    if ($consumo!="") {
	  $Buz = $consumo['return'];
	  if(!isset($Buz[0])){
	   $reg = count($Buz);
	  }else
	  $reg=1;
     
    }
    if ($reg != 0) {
        echo "<h2> <strong>Usuarios</strong> </h2>";
        echo "<table class='footable table table-striped table-bordered' align='center' data-page-size=".$itemsByPage.">
    	 <thead bgcolor='#ff0000'>
                                    <tr>";
        echo "<th ; text-align:center' >Nombres y apellidos</th>";
        echo "<th  text-align:center' data-sort-ignore='true'>Area </th>";
        echo "<th style='width:7%; text-align:center' >Sede</th>
            <th style='width:5%; text-align:center' ></th>
         </thead>
        <tbody>		
        	<tr>";

        $j = 0;
        if ($reg > 1) {
            while ($j < $reg) {

                if ($Buz[$j]->tipobuz == "1") {
                    echo "<th text-align:center' data-sort-ignore='true'>" . $Buz[$j]["nombrebuz"] . "</th>";
                    echo "<td style='text-align:center'> Externo</td>";
                    echo "<td style='text-align:center'> Externo</td>";
                } else {
                    echo "<th text-align:center' data-sort-ignore='true'>" . $Buz[$j]["idusu"]["nombreusu"] . " " . $Buz[$j]["idusu"]["apellidousu"] . "</th>";
                    echo "<td style='text-align:center'>" . $Buz[$j]["idatr"]["nombreatr"] . "</td>";
                    echo "<td style='text-align:center'>" . $Buz[$j]["idatr"]["idsed"]["nombresed"] . "</td>";
                }
                ?>
            <th  'text-align:center' >
                <button class='btn' onClick="seleccionar('<?php echo $Buz[$j]["idbuz"]; ?>', '<?php echo $Buz[$j]["nombrebuz"]; ?>');">
                    <span class="icon-hand-up" > </span>
                </button></th>
            <?php
            echo "</tr>";
            $j++;
        }
    } else {
        if ($Buz->tipobuz == "1") {
            echo "<th text-align:center' data-sort-ignore='true'>" . $Buz["nombrebuz"] . "</th>";
            echo "<td style='text-align:center'> Externo</td>";
            echo "<td style='text-align:center'>Externo</td>";
        } else {
            echo "<th text-align:center' data-sort-ignore='true'>" . $Buz["idusu"]["nombreusu"] ." " . $Buz["idusu"]["apellidousu"] . "</th>";
            echo "<td style='text-align:center'>" . $Buz["idusu"]["apellidousu"] . "</td>";
            echo "<td style='text-align:center'>" . $Buz["idusu"]["nombreusu"] . "</td>";
        }
        ?>
        <th  'text-align:center' >
            <button class='btn' onClick="seleccionar('<?php echo $Buz["idbuz"]; ?>', '<?php echo $Buz["nombrebuz"]; ?>');">
                <span class="icon-hand-up" > </span>
            </button></th>
        <?php
    }
    echo " </tbody>
  	</table>";
} else {
    echo " No se encuentran coincidencias en la búsqueda";
}
?>