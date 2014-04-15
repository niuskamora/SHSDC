<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Comprobante de Correspondencia</title>
        <link rel="stylesheet" href="../recursos/estilosPdf.css" type="text/css" />
    </head>
    <body>
        <?php $ruta = "../images/codigoBarras/" . $codigo . ".png"; ?>
        <div>
            <img style="top:auto" src="../images/header-top-left.png" width="250" height="40">
        </div>
        <div align="right">
            <strong id="titulo">Código del Paquete:  </strong><img style="top:auto" src=<?php echo $ruta ?>>
        </div>
        <div align="center">	
            <h2 align="center">Sistema de Correspondencia</h2>
            <h3 align="center">Comprobante de Paquete <?php echo $tipoBuzon ?></h3>
            <table align="center" width="500" border="1" rules="all">
                <tr>
                    <td colspan="2"><strong id="titulo">Datos del Origen:</strong></td>
                </tr> 		
                <tr>
                    <td><strong>Nombre: </strong><?php echo $nombreOrig ?></td>
                    <td><strong>Télefono: </strong><?php echo $telefonoOrig ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Dirección: </strong><?php echo $direccionOrig ?></td>
                </tr>

                <tr>
                    <td colspan="2"><strong id="titulo">Datos del Destino:</strong></td>
                </tr>  
                <tr>
                    <td><strong>Nombre: </strong><?php echo $nombreDest ?></td>
                    <td><strong>Télefono: </strong><?php echo $telefonoDest ?></td>
                </tr>
                <?php if ($buzon==1) {?>
                	<tr>
                    	<td><strong>C.I o RIF: </strong><?php echo $identDest ?></td>
                    	<td><strong>Correo: </strong><?php echo $correoDest ?></td>
                	</tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><strong>Dirección: </strong><?php echo $direccionDest ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong id="titulo">Datos del Paquete:</strong></td>
                </tr>
                <tr>
                    <td><strong>Número del Paquete: </strong><?php echo $idPaq ?></td>
                    <td><strong>Asunto: </strong><?php echo $asunto ?></td>
                </tr>
                <tr>
                    <td><strong>Fecha y Hora de Envio: </strong><?php echo $fecha ?></td>
                    <td><strong>Sede: </strong><?php echo $sede ?></td>
                </tr>
                <tr>
                    <td><strong>Prioridad: </strong><?php echo $prioridad ?></td>
                    <td><strong>Documento: </strong><?php echo $documento ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Texto: </strong><?php echo $texto ?></td>
                </tr>                
                <tr>
                    <td><strong>Fragil: </strong><?php echo $fragil ?></td>
                    <td><strong>Con Respuesta: </strong><?php echo $resp ?></td>
                </tr>
                <?php if ($idPaqRes != "") { ?>
                    <tr>
                        <td colspan="2"><strong>Respuesta al Paquete: </strong><?php echo $idPaqRes ?></td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <br>
            <table align="center" width="500" border="0">
                <tr>
                    <td align="center"><strong>________________</strong></td>
                    <td align="center"><strong>________________</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Usuario Paquete</strong></td>
                    <td align="center"><strong>Recepción</strong></td>
                </tr>
            </table>
        </div>
        <br>
        <br>
        <div align="center">
            <img style="top:auto" src="../images/todo.png" width="700" height="40">        	
        </div>
    </body>
</html>