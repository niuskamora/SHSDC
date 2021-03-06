 <?php
    session_start();
	include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
?>	
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
    try {
        $reg = 0;
        if (isset($_POST['usu']) && $_POST['usu'] != "" && $_POST['usu'] != NULL) {
            $aux = $_POST['usu'];
            $datosU = array('user' => $aux);
		    $client = new nusoap_client($wsdl_sdc, 'wsdl');
			$client->decode_utf8 = false;
            $Bandej = $client->call("consultarUsuarioXUser",$datosU);
			if($Bandej!=""){
				$u = array('idusu' => $Bandej['return']['idusu']);
			$usu= array('registroUsuario' => $u);
			$SedeM = $client->call("consultarSedeDeUsuario",$usu);
            $Ses = $client->call("listarSedes");
            $regs = 0;
			}
		
            if (($Bandej!="") && ($Ses!="") && ($SedeM !="")) {
				
			
			$Sedes=$Ses["return"];
			if(isset($Sedes[0])){
				$regr = count($Sedes);
			}
			else{
				$reg = 1;
			}

			$Bandeja=$Bandej["return"];
			if(isset($Bandeja[0])){
				$regr = count($Bandeja);
			}
			else{
				$reg = 1;
			}
			$SedeMia = $SedeM['return'];
			if(isset($SedeMia[0])){
				$Sereg = count($SedeMia);
			}
			else{
				$Sereg = 1;
			}
			
                $_SESSION["usuedit"] = $Bandeja['idusu'];
            } else {
			  javaalert('No se encuentra registrado el usuario, por favor verifique');
                $reg = 0;
				$Sereg = 0;
				$regr=0;
            }
        } else {
            javaalert('Debe ingresar el User del Usuario');
            iraURL('../pages/assign_headquarters.php');
        }
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../index.php');
    } 
    if ($reg != 0) {
        echo "<h2> <strong>" . utf8_encode($Bandeja['nombreusu']) . " </strong> </h2>";
        echo "<form method='post'> ";
        echo "<table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style='text-align:center'>Nombre</td>
                                    <td style='text-align:center'>
                                    <label>" .utf8_encode($Bandeja['nombreusu']) . "</label>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Apellido</td>
                                    <td style='text-align:center'>
                                    <label>" . utf8_encode($Bandeja['apellidousu']) . " </label>
                                    </td> 
                                </tr>";
								if($SedeMia!=""){
								echo" <tr>
                                    <td style='text-align:center'>Sede(s)</td>
                                    <td style='text-align:center'>
                                    <label>"; 
									if($Sereg==1){
									echo utf8_encode( $SedeMia['nombresed']);
									}else{
									echo utf8_encode($SedeMia[0]['nombresed']);
									   for ($i = 1; $i < $Sereg; $i++) {
									  echo ", ".utf8_encode($SedeMia[$i]['nombresed']);
									  }
									}
									echo" </label>
                                    </td> 
                                </tr>";
								}
								echo"
                                <tr>
                                    <td style='text-align:center'>  Seleccionar Sede: </td>
                                    <td style='text-align:center'>  <select  onChange='usuario()'  name='lis' id='lis'  required  title='Seleccione una sede'>
                                    <option value='' style='display:none'> Seleccionar:</option>";
        if ($regr > 1) {
            $i = 0;
            while ($regr > $i) {
                echo "<option value='" . utf8_encode($Sedes[$i]['nombresed']) . "' >" .utf8_encode( $Sedes[$i]['nombresed'] ). "</option>";
                $i++;
            }
        } else {
            echo "<option value='" . utf8_encode($Sedes['nombresed']) . "' >" . utf8_encode($Sedes['nombresed'] ). "</option>";
        }
        echo "</select>
            </tdt>
            </tr>
            <tr>
            <td style='text-align:center'>  Seleccionar Área de Trabajo: </td>
            <td style='text-align:center'>  <select  name='area' id='area'  required  title='Seleccione un Área de Trabajo'>
            <option value='' style='display:none'> Seleccionar:</option>
            </select>
            </tdt>
            </tr>
            </table>	
	<button class='btn' id='crear' onClick='editar();' name='crear' type='button'>Guardar</button>		  
		</form>";
    }
    ?>

    <script language="JavaScript">
        function usuario() {
            //posicion
            var $selectedOption = $('#lis').find('option:selected');
            var ed = $selectedOption.val();
            $.ajax({
                type: "POST",
                url: "../ajax/info_assign_headquarters_area.php",
                data: {'ed': ed},
                dataType: "text",
                success: function(response) {
                    $("#area").html(response);
                }

            });
        }

        function editar() {
            //posicion
            var $selectedOption = $('#area').find('option:selected');
            var ed = $selectedOption.val();
            $.ajax({
                type: "POST",
                url: "../ajax/edit_assign_headquarters.php",
                data: {'ed': ed},
                dataType: "text",
                success: function(response) {
                    $("#datos").html(response);
                }

            });
        }
    </script>