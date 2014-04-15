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
<body class="appBg"><tr>

    <td style='text-align:center'>  Seleccionar Área: </td>

    <?php

    session_start();
//    try {
        $reg = 0;
        if (isset($_POST['ed']) && $_POST['ed'] != "" && $_POST['ed'] != NULL) {
            $aux = $_POST['ed'];
            $datosU["sede"] =$aux;
			$client = new nusoap_client($wsdl_sdc, 'wsdl');	
			$consumo = $client->call("consultarAreasXSedeXNombre",$datosU);
            if ($consumo!="") {
			$Sedes = $consumo['return'];
			//echo '<pre>';print_r($Sedes);
			if(!isset($Sedes[0])){
			 $reg = 1;
			}else{
			$reg = count($Sedes);
			}
                
            $_SESSION["sededit"] = $aux;
            } else {
                $reg = 0;
            }
        } else {
            javaalert('Debe selecionar una sede');
            iraURL('../pages/assign_headquarters.php');
        }
  /* } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../index.php');
    }*/ 
    if ($reg != 0) {
        echo "<option value='' style='display:none'> Seleccionar:</option>";
        if ($reg > 1) {
            $i = 0;
            while ($reg > $i) {
                echo "<option value='" . $Sedes[$i]["idatr"]. "' >" . $Sedes[$i]["nombreatr"] . "</option>";
                $i++;
            }
        } else {
            echo "<option value='" . $Sedes["idatr"] . "' >" . $Sedes["nombreatr"] . "</option>";
        }
    } else {
        javaalert('No existen areas de trabajo para esta sede');
        iraURL('../pages/inbox.php');
    }
    ?>