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
    try {
     	include("../recursos/funciones.php");
		require_once("../lib/nusoap.php");
		require_once("../config/wsdl.php");
		require_once("../config/definitions.php");
		require_once("../core/Crypt/AES.php");
        $aux = $_POST['idusu'];
		$client = new nusoap_client($wsdl_sdc, 'wsdl');
		$client->decode_utf8 = false;
        $datosU = array('idUsuario' => $aux);
        $Bandej = $client->call("consultarUsuario",$datosU);
        $Role = $client->call("consultarRoles");
        $regs = 0;
        $reg = 0;
        if ($Bandej!="" && $Role!="") {
			
			$Bandeja=$Bandej['return'];
			$Roles=$Role['return'];
			$sede=$_SESSION["sedeb"];
            $dau = array('idusu' => $Bandeja['idusu'], 'sede' => $sede);
            $sedeUs = $client->call("consultarSedeRol",$dau);
			echo 'pre';print_r($sedeUs);
			if($sedeUs!=""){
				$sedeU=$sedeUs['return'];
				$regs = count($sedeU);
			}
			if(isset($Roles[0])){
			$regr = count($Roles);
			}else{
			$regr=1;
			}
            $_SESSION["usuedit"] = $Bandeja['idusu'];
        } else {
            $reg = 0;
        }
    } catch (Exception $e) {
        utf8_decode(javaalert('Lo sentimos no hay conexión'));
        iraURL('../index.php');
    }
  
    if (isset($Bandeja)) {
		echo "<h2> <strong>" . utf8_encode($Bandeja['nombreusu']) . " </strong> </h2>";
        echo "<form method='post'> ";
        echo "<table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style='text-align:center'>Nombre</td>
                                    <td style='text-align:center'>
                                    <label>" . utf8_encode($Bandeja['nombreusu']) . "</label>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Apellido</td>
                                    <td style='text-align:center'>
                                    <label>" .utf8_encode( $Bandeja['apellidousu']) . " </label>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>  Rol en la sede: </td>
                                    <td style='text-align:center'>  <select  name='lis' id='lis'  required  title='Seleccione el tipo de usuario'>
                                    <option value='' style='display:none'> Seleccionar:</option>";
        if ($regr > 1) {
            $i = 0;
            while ($regr > $i) {
                if ($sedeU['idrol']['idrol'] == $Roles[$i]['idrol']) {
                    echo "<option selected='selected' value='" . $Roles[$i]['idrol'] . "' >" .utf8_encode( $Roles[$i]['nombrerol']) . "</option>";
                } else {
                    echo "<option value='" . $Roles[$i]['idrol'] . "' >" .utf8_encode( $Roles[$i]['nombrerol']) . "</option>";
                }
                $i++;
            }
        } else {
            echo "<option value='" . $Roles['idrol'] . "' >" . utf8_encode($Roles['nombrerol']) . "</option>";
        }
        echo "</select>
            </tdt>
            </tr>
            </table>	
	<button class='btn' id='crear' onClick='editar();' name='crear' type='button'>Guardar</button>	  
		</form>		  
   ";
    }
    ?>
    
    <script language="JavaScript">
        function editar() {
            //posicion
            var $selectedOption = $('#lis').find('option:selected');
            var ed = $selectedOption.val();
            $.ajax({
                type: "POST",
                url: "../ajax/user_edit.php",
                data: {'ed': ed},
                dataType: "text",
                success: function(response) {
                    $("#datos").html(response);
                }

            });
        }
    </script>