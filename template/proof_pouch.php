<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Comprobante de Valija</title>
        <link rel="stylesheet" href="../recursos/estilosPdf.css" type="text/css" />
    </head>
    <body>
        <?php $ruta = "../images/codigoBarras/" . $codigo . ".png"; ?>
        <div>
            <img style="top:auto" src="../images/header-top-left.png" width="250" height="40">
        </div>
        <div align="right">
            <strong id="titulo">Código de la Valija:  </strong><img style="top:auto" src=<?php echo $ruta ?>>
        </div>
        <div align="center">	
            <h2 align="center">Sistema de Correspondencia</h2>
            <h3 align="center">Comprobante de Valija</h3>
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
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong id="titulo">Datos del Destino:</strong></td>
                </tr>  
                <tr>
                    <td><strong>Nombre: </strong><?php echo $nombreDest ?></td>
                    <td><strong>Télefono: </strong><?php echo $telefonoDest ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Dirección: </strong><?php echo $direccionDest ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong id="titulo">Datos de la Valija:</strong></td>
                </tr>
                <tr>
                    <td><strong>Número de la Valija: </strong><?php echo $idVal ?></td>
                    <td><strong>Fecha y Hora de Envio: </strong><?php echo $fecha ?></td>                    
                </tr>
                <tr>
                    <td><strong>Tipo: </strong><?php echo $tipo ?></td>
                    <td><strong>Sede: </strong><?php echo $sede ?></td>
                </tr>
            </table>
            <br>
            <br>
            <table align="center" width="500" border="0">
                <tr>
                    <td align="center"><strong>________________</strong></td>
                    <td align="center"><strong>________________</strong></td>
                </tr>
                <tr>
                    <td align="center"><strong>Usuario Valija</strong></td>
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