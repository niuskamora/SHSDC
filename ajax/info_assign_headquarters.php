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
        require_once('../lib/nusoap.php');
        $reg = 0;
        if (isset($_POST['usu']) && $_POST['usu'] != "" && $_POST['usu'] != NULL) {
            $aux = $_POST['usu'];
            $datosU = array('user' => $aux);
            $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
            $client = new SOAPClient($wsdl_url);
            $client->decode_utf8 = false;
            $Bandeja = $client->consultarUsuarioXUser($datosU);
			$u = array('idusu' => $Bandeja->return->idusu);
			$usu= array('registroUsuario' => $u);
			 $SedeMia = $client->consultarSedeDeUsuario($usu);
            $Sedes = $client->listarSedes();
            $regs = 0;
            if (isset($Bandeja->return) && isset($Sedes->return)) {
                $reg = count($Bandeja->return);
                $regr = count($Sedes->return);
                $_SESSION["usuedit"] = $Bandeja->return->idusu;
            } else {
                $reg = 0;
            }
        } else {
            javaalert('Debe ingresar el User del Usuario');
            iraURL('../pages/assign_headquarters.php');
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../index.php');
    }
    if ($reg != 0) {
        echo "<h2> <strong>" . $Bandeja->return->nombreusu . " </strong> </h2>";
        echo "<form method='post'> ";
        echo "<table class='footable table table-striped table-bordered'>
                                <tr>
                                    <td style='text-align:center'>Nombre</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->nombreusu . "</label>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style='text-align:center'>Apellido</td>
                                    <td style='text-align:center'>
                                    <label>" . $Bandeja->return->apellidousu . " </label>
                                    </td> 
                                </tr>";
								if(isset( $SedeMia->return)){
								echo" <tr>
                                    <td style='text-align:center'>Sede(s)</td>
                                    <td style='text-align:center'>
                                    <label>"; 
									if(count($SedeMia->return)==1){
									echo $SedeMia->return->nombresed;
									}else{
									echo $SedeMia->return[0]->nombresed;
									   for ($i = 1; $i < count($SedeMia->return); $i++) {
									  echo ",".$SedeMia->return[$i]->nombresed;
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
                echo "<option value='" . $Sedes->return[$i]->nombresed . "' >" . $Sedes->return[$i]->nombresed . "</option>";
                $i++;
            }
        } else {
            echo "<option value='" . $Sedes->return->nombresed . "' >" . $Sedes->return->nombresed . "</option>";
        }
        echo "</select>
            </tdt>
            </tr>
            <tr>
            <td style='text-align:center'>  Seleccionar Area de Trabajo: </td>
            <td style='text-align:center'>  <select  name='area' id='area'  required  title='Seleccione una Area de Trabajo'>
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