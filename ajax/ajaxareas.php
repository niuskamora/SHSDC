<?php
$idsede = $_POST['idsede'];

try {
        $client = new SOAPClient($wsdl_sdc);
    $client->decode_utf8 = false;
    $areasede = array('sede' => $idsede);
    $Areas = $client->consultarAreasXSede($areasede);
    if (!isset($Areas->return)) {
        javaalert("No existen areas registradas");
        iraURL('../pages/inbox.php');
    }
    $reg = count($Areas->return);
} catch (Exception $e) {
    javaalert('Error al deshabilitar la Area');
    iraURL('../pages/inbox.php');
}
echo "<h2> <strong>Areas</strong> </h2>";
echo " <a href='../pages/disable_area.php'> <button class='btn primary''>
                                <span class='icon-backward'>Regresar</span>
                 </button> </a>";
echo "<br><br>";
echo "<table class='footable table table-striped table-bordered' align='center'  data-page-size=$itemsByPage>
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
            if ($Areas->return[$j]->borradoatr == 0) {
                echo "<td style='background-color: rgb(206, 200, 200);	text-align:center' data-sort-ignore='true'>" . $Areas->return[$j]->idatr . "</td>";
                echo "<td style='text-align:left; background-color: rgb(206, 200, 200);'>" . $Areas->return[$j]->nombreatr . "</td>";
                ?>
                <td style='background-color: rgb(206, 200, 200); text-align:center'>
                    <button class='btn' onClick="cambiar('<?php echo $Areas->return[$j]->idatr; ?>', this);">
                        <span class="icon-refresh" > </span>
                    </button></td>
                <?php
            } else {
                echo "<td style='text-align:center' data-sort-ignore='true'>" . $Areas->return[$j]->idatr . "</td>";
                echo "<td style='text-align:left;'>" . $Areas->return[$j]->nombreatr . "</td>";
                ?>
                <td style="text-align:center"> 
                    <button class='btn' onClick="cambiar('<?php echo $Areas->return[$j]->idatr; ?>', this);">
                        <span class="icon-refresh" > </span>
                    </button></td>
                <?php
            }
            echo "</tr>";
            $j++;
        }
    } else {
        if ($Areas->return->borradoatr == 0) {
            echo "<td style='background-color: rgb(206, 200, 200);	text-align:center' data-sort-ignore='true'>" . $Areas->return->idatr . "</td>";
            echo "<td style='text-align:left; background-color: rgb(206, 200, 200);'>" . $Areas->return->nombreatr . "</td>";
            ?>
            <td style='background-color: rgb(206, 200, 200); text-align:center'> 
                <button class='btn' onClick="cambiar('<?php echo $Areas->return->idatr; ?>', this);">
                    <span class="icon-refresh" > </span>
                </button></td>
            <?php
        } else {
            echo "<td style='text-align:center' data-sort-ignore='true'>" . $Areas->return->idatr . "</td>";
            echo "<td style='text-align:left;'>" . $Areas->return->nombreatr . "</td>";
            ?>
            <td style="text-align:center"> 
                <button class='btn' onClick="cambiar('<?php echo $Areas->return->idatr; ?>', this);">
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