<?php

session_start();

?>
<!-- javascript -->
<script type='text/javascript' src="../js/jquery-1.9.1.js"></script>
<script type='text/javascript' src="../js/bootstrap.js"></script>
<script type='text/javascript' src="../js/bootstrap-transition.js"></script>
<script type='text/javascript' src="../js/bootstrap-tooltip.js"></script>
<script type='text/javascript' src="../js/modernizr.min.js"></script>
<!--<script type='text/javascript' src="../js/togglesidebar.js"></script>-->	
<script type='text/javascript' src="../js/custom.js"></script>
<script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>
<?php

try {
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
    }
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $i = 0;
    $Sede = array('sede' => $_SESSION["Sede"]->return->nombresed);
    $UsuarioRol = array('idusu' => $_SESSION["Usuario"]->return->idusu, 'sede' => $_SESSION["Sede"]->return->nombresed);
    $SedeRol = $client->consultarSedeRol($UsuarioRol);
} catch (Exception $e) {
    javaalert('Lo sentimos no hay conexion');
    iraURL('../pages/inbox.php');
}
include("../views/breakdown_valise.php");
?>