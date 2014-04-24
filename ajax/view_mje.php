	<?php  
	session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
  try{
 $client = new nusoap_client($wsdl_sdc, 'wsdl');
	 $_SESSION["cli"]=$client;	

    if (!isset($_SESSION["Usuario"])) {
		iraURL("../index.php");
	} elseif (!usuarioCreado()) {
		iraURL("../pages/create_user.php");
	} elseif (!isset($_POST['idpaq'])) {
		iraURL("../pages/inbox.php");
	}
     $UsuarioRol = array('idusu' => $_SESSION["Usuario"]["idusu"], 'sede' => $_SESSION["Sede"]["nombresed"]);
	$consumo = $client->call("consultarSedeRol",$UsuarioRol);
	if ($consumo!="") {
	$SedeRol = $consumo['return'];   
    } else {
        iraURL('../pages/inbox.php');
    }

$id=array('idpaq' => $_POST['idpaq']);
$parametros=array('idpaq' => $id);
$consumo = $client->call("listarMensajesXPaquete",$parametros);
	if ($consumo!="") {
	$mje = $consumo['return'];//echo '<pre>';print_r($confirmo);   
	}

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

<div id="data">
<h2>Mensajes de la Correspondencia Extraviada</h2>
	<?php
     if (isset($mje)) {

                                        echo "<br>";
                                        ?>
                                        <table class='footable table table-striped table-bordered'  data-page-size=<?php echo $itemsByPage ?>>    
                                            <thead bgcolor='#FF0000'>
                                                <tr>	
                                                    <th style=' text-align:center'>Código</th>
                                                    <th style=' text-align:center' data-sort-ignore="true">Nombre</th>
                                                    <th style=' text-align:center' data-sort-ignore="true">Descripción </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!isset($mje[0])) {
                                                    ?>
                                                    <tr>     
                                                        <td  style='text-align:center'><?php echo  $mje["idmen"] ; ?></td>
                                                        <td style='text-align:center'><?php echo utf8_encode($mje["nombremen"] ); ?></td>
                                                        <td style=' text-align:center'><?php echo utf8_encode($mje["descripcionmen"] ); ?></td>
                                                    
                                                    </tr>   
                                                    <?php
                                                } else {
                                                    for ($i = 0; $i < count($mje); $i++) {        
                                                        ?>
                                                        <tr>     
                                                           <td  style='text-align:center'><?php echo  $mje[$i]["idmen"] ; ?></td>
                                                        <td style='text-align:center'><?php echo utf8_encode($mje[$i]["nombremen"] ); ?></td>
                                                        <td style='text-align:center'><?php echo utf8_encode($mje[$i]["descripcionmen"] ); ?></td>
                                                        </tr>   
                                                        <?php
                                                    }
                                                }//fin else
                                                ?>  
                                            </tbody>
                                        </table>
                                        <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>								

                                        <?php
                                    }else{
echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>El paquete extraviado no tiene mensajes en estos momentos </h4>
		</div> ";
}
?>
 	</div>

<script src="../js/footable.js" type="text/javascript"></script>
<script src="../js/footable.paginate.js" type="text/javascript"></script>
<script src="../js/footable.sortable.js" type="text/javascript"></script>
 <script type="text/javascript">
            $(function() {
                $('table').footable();
            });
        </script>
<?php
 } catch (Exception $e) {
					javaalert('Lo sentimos no hay conexión');
					iraURL('../pages/inbox.php');
}
 ?>  
