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
    try {
        $reg = 0;
        if (isset($_POST['usu']) && $_POST['usu'] != "" && $_POST['usu'] != NULL) {
            $aux = utf8_encode($_POST['usu']);
           $client = new nusoap_client($wsdl_sdc, 'wsdl');
            $datosU = array('user' => $aux);
            $Bandej = $client->call("consultarUsuarioXUser",$datosU);
			
            $regs = 0;
            if ($Bandej!="") {
				$Bandeja=$Bandej['return'];
                $reg = count($Bandeja);
                $_SESSION["usuedit"] = $aux;
            } else {
                $reg = 0;
            }
        } else {
            javaalert('Debe ingresar el User del Usuario');
            iraURL('../pages/edit_type_user.php');
        }
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../index.php');
    }
    if ($reg != 0) {
        echo "<h2> <strong>" .utf8_encode( $Bandeja['nombreusu']) . " </strong> </h2>";
        echo "<form method='post'> ";
        echo "<table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style='text-align:center'>Nombre</td>
                                    <td style='text-align:center'>
                                    <label>" .utf8_encode( $Bandeja['nombreusu']) . "</label>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Apellido</td>
                                    <td style='text-align:center'>
                                    <label>" . utf8_encode($Bandeja['apellidousu'] ). " </label> 
                                    </td> 
                                </tr>
                                <tr>
                                <td style='text-align:center'>  Tipo de Usuario: </td>
                                <td style='text-align:center'>  <select  name='lis' id='lis'  required  title='Seleccione la Tipo de usuario'>
                                <option value='' style='display:none'> Seleccionar:</option>";
        echo "<option value='0' > Usuario </option>";
        echo "<option value='1' > Administrador </option>";
        echo "<option value='2' > Super Administrador </option>";
        echo "</select>
            </tdt>
            </tr>
            </table>	
	<button class='btn' id='crear' onClick='editar();' name='crear' type='button'>Guardar</button>		  
		</form>";
    }else{
	echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No existen registros con ese nombre de  usuario </h4>
		</div> ";
	}
    ?>

    <script language="JavaScript">
        function editar() {
            //posicion
            var $selectedOption = $('#lis').find('option:selected');
            var ed = $selectedOption.val();
            $.ajax({
                type: "POST",
                url: "../ajax/edit_type.php",
                data: {'ed': ed},
                dataType: "text",
                success: function(response) {
                    $("#datos").html(response);
                }

            });
        }
    </script>