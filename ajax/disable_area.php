<?php
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
$idsede = $_POST['idsede'];

try {
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
	$client->decode_utf8 = false;
    $areasede = array('sede' => $idsede);
    $Areass = $client->call("consultarAreasXSede",$areasede);
    if ($Areass=="") {
        javaalert("No existen areas registradas");
        iraURL('../pages/inbox.php');
    }else{
		$Areas = $Areass['return'];
    	$reg = count($Areas);
	}
} catch (Exception $e) {
    javaalert('Error al deshabilitar la Area');
    iraURL('../pages/inbox.php');
}
echo "<h2> <strong>Areas</strong> </h2>";
echo " <a href='../pages/disable_area.php'> <button class='btn primary''>
                                <span class='icon-backward'>Regresar</span>
                 </button> </a>";
echo "<br><br>";
echo "<table class='footable table table-striped table-bordered' align='center'  data-page-size=".$itemsByPage.">
    	 <thead bgcolor='#ff0000'>
                                    <tr>";
echo "<th  style='width:10%; text-align:center' >Id</th>";
echo "<th  text-align:center' data-sort-ignore='true'>Nombre </th>";
echo "<th style='width:10%; text-align:center' data-sort-ignore='true'>Desactivar</th>
         </thead>
        <tbody>		
        	<tr>";
if ($reg > 0) {
    if ($reg > 1) {
        $j = 0;
        while ($j < $reg) {
            //verifico si esta borrada
            if ($Areas[$j]['borradoatr'] == 0) {
                echo "<td style='background-color: rgb(206, 200, 200);	text-align:center' data-sort-ignore='true'>" . $Areas[$j]['idatr'] . "</td>";
                echo "<td style='text-align:left; background-color: rgb(206, 200, 200);'>" . $Areas[$j]['nombreatr'] . "</td>";
                ?>
                <td style='background-color: rgb(206, 200, 200); text-align:center'>
                    <button class='btn' onClick="cambiar('<?php echo $Areas[$j]['idatr']; ?>', this);">
                        <span class="icon-refresh" > </span>
                    </button></td>
                <?php
            } else {
                echo "<td style='text-align:center' data-sort-ignore='true'>" . utf8_encode($Areas[$j]['idatr']) . "</td>";
                echo "<td style='text-align:left;'>" . utf8_encode($Areas[$j]['nombreatr']) . "</td>";
                ?>
                <td style="text-align:center"> 
                    <button class='btn' onClick="cambiar('<?php echo $Areas[$j]['idatr']; ?>', this);">
                        <span class="icon-refresh" > </span>
                    </button></td>
                <?php
            }
            echo "</tr>";
            $j++;
        }
    } else {
        if ($Areas['borradoatr'] == 0) {
            echo "<td style='background-color: rgb(206, 200, 200);	text-align:center' data-sort-ignore='true'>" . $Areas['idatr'] . "</td>";
            echo "<td style='text-align:left; background-color: rgb(206, 200, 200);'>" . $Areas['nombreatr'] . "</td>";
            ?>
            <td style='background-color: rgb(206, 200, 200); text-align:center'> 
                <button class='btn' onClick="cambiar('<?php echo $Areas['idatr']; ?>', this);">
                    <span class="icon-refresh" > </span>
                </button></td>
            <?php
        } else {
            echo "<td style='text-align:center' data-sort-ignore='true'>" . $Areas['idatr'] . "</td>";
            echo "<td style='text-align:left;'>" . $Areas['nombreatr'] . "</td>";
            ?>
            <td style="text-align:center"> 
                <button class='btn' onClick="cambiar('<?php echo $Areas['idatr']; ?>', this);">
                    <span class="icon-refresh" > </span>
                </button></td>
            <?php
        }
    }
}
echo " </tbody>
  	</table>";
echo '<ul id="pagination" class="footable-nav"><span>Pag:</span></ul>';
?>
<script src="../js/footable.js" type="text/javascript"></script>
<script src="../js/footable.paginate.js" type="text/javascript"></script>
<script src="../js/footable.sortable.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $('table').footable();
    });
</script>