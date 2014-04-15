<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Comprobante de Valijas</title>
        <link rel="stylesheet" href="../recursos/estilosPdf.css" type="text/css" />
    </head>
    <body>
        <div>
            <img style="top:auto" src="../images/header-top-left.png" width="250" height="40">
        </div>
        <div align="center">	
            <h2 align="center">Sistema de Correspondencia</h2>
            <h3 align="center"><?php echo $nombreReporte ?></h3>
            <table align="center" width="500" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Fecha y Hora de Envio</strong></td>
                    <td align="center"><strong>Nro de Valija</strong></td>
                    <td align="center"><strong>Nro de Guía</strong></td>
                    <td align="center"><strong>Origen</strong></td>
                    <td align="center"><strong>Realizado por</strong></td>
                    <td align="center"><strong>Tipo</strong></td>
                    <td align="center"><strong>Destino</strong></td>
                    <td align="center"><strong>Fecha y Hora de Recibido</strong></td>
                </tr>
                <?php
                if ($valijas > 1) {
                    for ($i = 0; $i < $valijas; $i++) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $fechaEnvio[$i] ?></td>
                            <td align="center"><?php echo $resultadoConsultarValijas->return[$i]->idval ?></td>
                            <?php if (isset($resultadoConsultarValijas->return[$i]->codproveedorval)) { ?>
                                <td align="center"><?php echo $resultadoConsultarValijas->return[$i]->codproveedorval ?></td>
                            <?php } else {
                                ?>
                                <td><?php echo "" ?></td>
                            <?php } ?>
                            <td><?php echo $nombreSede[$i] ?></td>
                            <?php if (isset($resultadoConsultarValijas->return[$i]->iduse->idusu->apellidousu)) { ?>
                                <td><?php echo $resultadoConsultarValijas->return[$i]->iduse->idusu->nombreusu . ' ' . $resultadoConsultarValijas->return[$i]->iduse->idusu->apellidousu ?></td>
                            <?php } else {
                                ?>
                                <td><?php echo $resultadoConsultarValijas->return[$i]->iduse->idusu->nombreusu ?></td>                                                    
                                <?php
                            }
                            if (isset($resultadoConsultarValijas->return[$i]->tipoval)) {
                                ?>
                                <td><?php echo $resultadoConsultarValijas->return[$i]->tipoval ?></td>
                            <?php } else {
                                ?>
                                <td><?php echo "" ?></td>
                                <?php
                            }
                            if (isset($resultadoConsultarValijas->return[$i]->destinoval->nombresed)) {
                                ?>
                                <td><?php echo $resultadoConsultarValijas->return[$i]->destinoval->nombresed ?></td>
                            <?php } else {
                                ?>
                                <td><?php echo "" ?></td>
                            <?php } ?>                                                    
                            <td align="center"><?php echo $fechaRecibido[$i] ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center"><?php echo $fechaEnvio ?></td>
                        <td align="center"><?php echo $resultadoConsultarValijas->return->idval ?></td>
                        <?php if (isset($resultadoConsultarValijas->return->codproveedorval)) { ?>
                            <td align="center"><?php echo $resultadoConsultarValijas->return->codproveedorval ?></td>
                        <?php } else {
                            ?>
                            <td><?php echo "" ?></td>
                        <?php } ?>
                        <td><?php echo $nombreSede ?></td>
                        <?php if (isset($resultadoConsultarValijas->return->iduse->idusu->apellidousu)) { ?>
                            <td><?php echo $resultadoConsultarValijas->return->iduse->idusu->nombreusu . ' ' . $resultadoConsultarValijas->return->iduse->idusu->apellidousu ?></td>
                        <?php } else {
                            ?>
                            <td><?php echo $resultadoConsultarValijas->return->iduse->idusu->nombreusu ?></td>                                                    
                            <?php
                        }
                        if (isset($resultadoConsultarValijas->return->tipoval)) {
                            ?>
                            <td><?php echo $resultadoConsultarValijas->return->tipoval ?></td>
                        <?php } else {
                            ?>
                            <td><?php echo "" ?></td>
                            <?php
                        }
                        if (isset($resultadoConsultarValijas->return->destinoval->nombresed)) {
                            ?>
                            <td><?php echo $resultadoConsultarValijas->return->destinoval->nombresed ?></td>
                        <?php } else {
                            ?>
                            <td><?php echo "" ?></td>
                        <?php } ?>                                                  
                        <td align="center"><?php echo $fechaRecibido ?></td>
                    </tr>
                <?php } ?> 
            </table>
            <br>
            <br>
            <br>
            <table align="center" width="300" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Total de <?php echo $nombreReporte ?></strong></td>
                    <td align="center" width="100"><?php echo $valijas ?></td>
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