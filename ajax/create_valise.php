
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

    <?php
    session_start();
include("../recursos/funciones.php");
require_once("../lib/nusoap.php");
require_once("../config/wsdl.php");
require_once("../config/definitions.php");
require_once("../core/Crypt/AES.php");
    
    $aux = $_POST['sed'];
    $client = new nusoap_client($wsdl_sdc, 'wsdl');
    $client->decode_utf8 = false;
    $Sedes = array('sede' =>$_SESSION["Sede"]['nombresed'], 'sedeDestino' =>utf8_decode($aux));
    $Regist = $client->call("ConsultarPaquetesParaValija",$Sedes);
    $reg = 0;
	
	if($Regist != ""){
		
			 $Registro = $Regist['return'];
			if(isset($Registro [0])){
				$reg = count($Registro );
				$_SESSION["reg"] = $reg;
                $_SESSION["seded"] = $aux;
			}
			else{
				$reg = 1;
				$_SESSION["reg"] = $reg;
                $_SESSION["seded"] = $aux;
			}
		}else{
			
			$reg = 0;
		}
	
	
    
    
   
    echo "</div>";
	echo "<br>";
    if ($reg != 0) {
        echo "<form method='post'>		 
       
	    Tipo de Valija:  <select id='tipo' name='tipo'> <option value='0' style='display:none'>Seleccionar:</option> 
                                            
                                 <option value='1'> Mercancia</option>
                                 <option value='2'> Documento</option>
                                
                                          
                                        </select>
	   <br>";
	    echo "<h2> <strong>" . $aux . "</h2> </strong>";
		echo "<br>";
        echo "<table class='footable table table-striped table-bordered' align='center'  data-page-size=".$itemsByPage.">
    	 <thead bgcolor='#FF0000'>		
                                <tr>
                                    <th style='width:20%; text-align:center' >Origen</th>
                                    <th style='width:20%; text-align:center'>Destino</th>
                                    
                                    <th style='width:10%; text-align:center'>C/R</th>
									<th style='width:10%; text-align:center'>Tipo</th>
                                    <th  style='width:10%; text-align:center'>Fecha</th>
                                    <th  data-sort-ignore='true' style='width:30%; text-align:center'>Agregar</th>
                                </tr>
                            </thead>
        <tbody>
        	<tr>";
        if ($reg > 1) {
            $j = 0;
            while ($j < $reg) {
               
                echo "<td  style='text-align:center'>" . utf8_encode($Registro[$j]['origenpaq']['idusu']['nombreusu']) . "</td>";
                echo "<td  style='text-align:center'>" . utf8_encode($Registro[$j]['destinopaq']['idusu']['nombreusu']) . "</td>";
              
                if ($Registro[$j]['respaq'] == 0) {
                    echo "<td style='text-align:center'> No </td>";
                } else {
                    echo "<td style='text-align:center'> Si </td>";
                }
                echo "<td style='text-align:center'>" . date("d/m/Y", strtotime(substr($Registro[$j]['fechapaq'], 0, 10))) . "</td>";
                echo '<td style="text-align:center" width="15%"><input type="checkbox" name="ide[' . $j . ']" id="ide[' . $j . ']" value=' . $Registro[$j]['idpaq'] . '></td>';
                echo "</tr>";
                $j++;
            }
        } else {

            
            echo "<td  style='text-align:center'>" . utf8_encode($Registro['origenpaq']['idusu']['nombreusu']) . "</td>";
            echo "<td  style='text-align:center'>" .utf8_encode($Registro['destinopaq']['idusu']['nombreusu']) . "</td>";
            
            if ($Registro['respaq'] == 0) {
                echo "<td style='text-align:center'> No </td>";
            } else {
                echo "<td style='text-align:center'> Si </td>";
            }
			 if ($Registro['iddoc'] == 1) {
                echo "<td style='text-align:center'> Documento </td>";
            } else {
                echo "<td style='text-align:center'> Mercancia </td>";
            }
		
            echo "<td style='text-align:center'>" . date("d/m/Y", strtotime(substr($Registro['fechapaq'], 0, 10))) . "</td>";
            echo '<td style="text-align:center" width="15%"> <input type="checkbox" name="ide[0]" id="ide[0]" value=' . $Registro['idpaq'] . '></td>';
            echo "</tr>";
        }
        echo " </tbody>	
  	</table>	
	";
        echo '<ul id="pagination" class="footable-nav"><span>Pag:</span></ul>';
        echo "<div align='center'><button  class='btn' id='guardar' name='guardar'>Crear Valija</button></div>
    </form> ";
    } else {
        echo "<br>";
        echo"<div class='alert alert-block' align='center'>
			<h2 style='color:rgb(255,255,255)' align='center'>Atención</h2>
			<h4 align='center'>No hay Paquetes para valija</h4>
		</div> ";
    }
    ?>
    <script src="../js/footable.js" type="text/javascript"></script>
    <script src="../js/footable.paginate.js" type="text/javascript"></script>
    <script src="../js/footable.sortable.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function() {
            $('table').footable();
        });
    </script>