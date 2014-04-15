	<?php  
	session_start();
include("../recursos/funciones.php");
require_once('../lib/class.wsdlcache.php');
require_once('../core/class.inputfilter.php');
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once('../lib/nusoap.php');
if (!isset($_SESSION["Usuario"])) {
    iraURL("../index.php");
} elseif (!usuarioCreado()) {
    iraURL("../pages/create_user.php");
}  elseif (!isset($_POST['idpaq'])) {
    iraURL("../pages/inbox.php");
}
  try{
  $wsdl_url = 'http://localhost:15362/SistemaDeCorrespondencia/CorrespondeciaWS?WSDL';
  $client = new SOAPClient($wsdl_url);
  $client->decode_utf8 = false; 
$UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
$SedeRol = $client->consultarSedeRol($UsuarioRol);
    if (isset($SedeRol->return)) {
        if ($SedeRol->return->idrol->idrol != "2" && $SedeRol->return->idrol->idrol != "5") {
            iraURL('../pages/inbox.php');
        }
    } else {
        iraURL('../pages/inbox.php');
    }

$parametros=array('idpaq' =>  $_POST['idpaq']);
  $confirmo = $client->confirmarCorrespondenciaExterna($parametros);
     if($confirmo->return==0){
	 javaalert("Paquete no confirmado ,consulte con el administrador");
	}elseif($confirmo->return==1){
	javaalert("Se ha confirmado el paquete exitósamente");

	}
	 $sede = array('idsed' => $_SESSION["Sede"]->return->idsed);
    $parametros = array('sede' => $sede);
    $PaquetesConfirmados = $client->consultarPaquetesXConfirmarExternos($parametros);
  //echo '<pre>';
 // print_r($rowPaquete);
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
	<?php
if (isset($PaquetesConfirmados->return)) {

    echo "<br>";
    ?>
                                        <h2>Correspondencia enviada a Externos</h2>
                                        <table class='footable table table-striped table-bordered'  data-page-size=$itemsByPage>    
                                            <thead bgcolor='#FF0000'>
                                                <tr>	
                                                    <th style='width:7%; text-align:center'>Origen</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Destino</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Asunto </th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Tipo</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Contenido</th>
                                                    <th style='width:7%; text-align:center' data-sort-ignore="true">Confirmar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <?php
    if (count($PaquetesConfirmados->return) == 1) {

        if (strlen($PaquetesConfirmados->return->textopaq) > 10) {
            $contenido = substr($PaquetesConfirmados->return->textopaq, 0, 10) . "...";
        } else {
            $contenido = $PaquetesConfirmados->return->textopaq;
        }
        if (strlen($PaquetesConfirmados->return->asuntopaq) > 10) {
            $asunto = substr($PaquetesConfirmados->return->asuntopaq, 0, 10) . "...";
        } else {
            $asunto = $PaquetesConfirmados->return->asuntopaq;
        }
		if($PaquetesConfirmados->return->destinopaq->tipobuz==0){
		$nombrebuz=$PaquetesConfirmados->return->destinopaq->idusu->nombreusu . " " . $PaquetesConfirmados->return->destinopaq->idusu->apellidousu;
		}else{
		$nombrebuz=$PaquetesConfirmados->return->destinopaq->nombrebuz;
		}
        ?>
                                                    <tr>     
                                                        <td  style='text-align:center'><?php echo $PaquetesConfirmados->return->origenpaq->idusu->nombreusu . " " . $PaquetesConfirmados->return->origenpaq->idusu->apellidousu; ?></td>
                                                        <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                        <td style='text-align:center'><?php echo $asunto; ?></td>
                                                        <td style='text-align:center'><?php echo $PaquetesConfirmados->return->iddoc->nombredoc; ?></td>
                                                        <td style='text-align:center'><?php echo $contenido; ?></td>
                                                        <td style='text-align:center'> <button type='button' class='btn btn-info btn-primary' onClick="Paquete(<?php echo $PaquetesConfirmados->return->idpaq; ?>);">  Confirmar </button></td>  
                                                    </tr>   
        <?php
    } else {
        for ($i = 0; $i < count($PaquetesConfirmados->return); $i++) {

            if (strlen($PaquetesConfirmados->return[$i]->textopaq) > 25) {
                $contenido = substr($PaquetesConfirmados->return[$i]->textopaq, 0, 23) . "...";
            } else {
                $contenido = $PaquetesConfirmados->return[$i]->textopaq;
            }
            if (strlen($PaquetesConfirmados->return[$i]->asuntopaq) > 10) {
                $asunto = substr($PaquetesConfirmados->return[$i]->asuntopaq, 0, 10) . "...";
            } else {
                $asunto = $PaquetesConfirmados->return[$i]->asuntopaq;
            }
			if($PaquetesConfirmados->return[$i]->destinopaq->tipobuz==0){
			$nombrebuz=$PaquetesConfirmados->return[$i]->destinopaq->idusu->nombreusu . " " . $PaquetesConfirmados->return[$i]->destinopaq->idusu->apellidousu;
			}else{
			$nombrebuz=$PaquetesConfirmados->return[$i]->destinopaq->nombrebuz;
			}
		
            ?>
                                                        <tr>     
                                                            <td  style='text-align:center'><?php echo $PaquetesConfirmados->return[$i]->origenpaq->idusu->nombreusu . " " . $PaquetesConfirmados->return[$i]->origenpaq->idusu->apellidousu; ?></td>
                                                            <td style='text-align:center'><?php echo $nombrebuz; ?></td>
                                                            <td style='text-align:center'><?php echo $asunto; ?></td>
                                                            <td style='text-align:center'><?php echo $PaquetesConfirmados->return[$i]->iddoc->nombredoc; ?></td>
                                                            <td style='text-align:center'><?php echo $contenido; ?></td>
                                                        <td style='text-align:center'> <button type='button' class='btn btn-info btn-primary' onClick="Paquete(<?php echo $PaquetesConfirmados->return[$i]->idpaq; ?>);">  Confirmar </button></td>  
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
			<h4 align='center'>No hay paquetes Externos por Confirmar en estos momentos </h4>
		</div> ";
}
?>
 	</div>

<script src="../js/footable.js" type="text/javascript"></script>
<script src="../js/footable.paginate.js" type="text/javascript"></script>
<script src="../js/footable.sortable.js" type="text/javascript"></script>

<?php
 } catch (Exception $e) {
					javaalert('Lo sentimos no hay conexión');
					iraURL('../pages/inbox.php');
}
 ?>  
