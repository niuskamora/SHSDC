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
        $aux = $_POST['idusu'];
$client = new SOAPClient($wsdl_sdc);
        $client->decode_utf8 = false;

        $datosU = array('idUsuario' => $aux);
        $Bandeja = $client->consultarUsuario($datosU);
        $Roles = $client->consultarRoles();
        $regs = 0;
        $reg = 0;
        if (isset($Bandeja->return) && isset($Roles->return)) {
            $dau = array('idusu' => $Bandeja->return->idusu, 'sede' => $_SESSION["sedeb"]);
            $sedeU = $client->consultarSedeRol($dau);
            $reg = count($Bandeja->return);
            $regs = count($sedeU->return);

            $regr = count($Roles->return);
            $_SESSION["usuedit"] = $Bandeja->return->idusu;
        } else {
            $reg = 0;
        }
    } catch (Exception $e) {
        javaalert('Lo sentimos no hay conexion');
        iraURL('../index.php');
    }
    echo "<h2> <strong>" . $Bandeja->return->nombreusu . " </strong> </h2>";
    if ($reg != 0) {
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
                                </tr>
                                <tr>
                                    <td style='text-align:center'>  Rol en la sede: </td>
                                    <td style='text-align:center'>  <select  name='lis' id='lis'  required  title='Seleccione la Tipo de usuario'>
                                    <option value='' style='display:none'> Seleccionar:</option>";
        if ($regr > 1) {
            $i = 0;
            while ($regr > $i) {
                if ($sedeU->return->idrol->idrol == $Roles->return[$i]->idrol) {
                    echo "<option selected='selected' value='" . $Roles->return[$i]->idrol . "' >" . $Roles->return[$i]->nombrerol . "</option>";
                } else {
                    echo "<option value='" . $Roles->return[$i]->idrol . "' >" . $Roles->return[$i]->nombrerol . "</option>";
                }
                $i++;
            }
        } else {
            echo "<option value='" . $Roles->return->idrol . "' >" . $Roles->return->nombrerol . "</option>";
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