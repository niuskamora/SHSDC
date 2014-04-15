<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Comprobante de Traking del Paquete</title>
        <link rel="stylesheet" href="../recursos/estilosPdf.css" type="text/css" />
    </head>
    <body>
        <div>
            <img style="top:auto" src="../images/header-top-left.png" width="250" height="40">
        </div>
        <div align="center">	
            <h2 align="center">Sistema de Correspondencia</h2>
            <h3 align="center">Paquete o Correspondencia</h3>
            <table align="center" width="450" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Nro de Paquete</strong></td>
                    <td align="center"><strong>Origen</strong></td>
                    <td align="center"><strong>De</strong></td>
                    <td align="center"><strong>Para</strong></td>
                    <td align="center"><strong>Destino</strong></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $idPaq ?></td>
                    <td><?php echo $origen ?></td>
                    <td><?php echo $deNombre . ' ' . $deApellido ?></td>
                    <td><?php echo $paraNombre . ' ' . $paraApellido ?></td>
                    <td><?php echo $destino ?></td>
                </tr>
            </table>
            <br>
            <h3 align="center">Traking del Paquete</h3>
            <table align="center" width="500" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Usuario</strong></td>
                    <td align="center"><strong>Fecha y Hora</strong></td>
                    <td align="center"><strong>Status</strong></td>
                    <td align="center"><strong>Procesado en</strong></td>
                    <td align="center"><strong>Localización</strong></td>
                </tr>
                <?php
                if ($contadorPaquete > 1) {
                    for ($i = 0; $i < $contadorPaquete; $i++) {
                        ?>
                        <tr>
                            <?php if (isset($resultadoPaquete->return[$i]->iduse->idusu->apellidousu)) { ?>
                                <td><?php echo $resultadoPaquete->return[$i]->iduse->idusu->nombreusu . ' ' . $resultadoPaquete->return[$i]->iduse->idusu->apellidousu ?></td>
                            <?php } else {
                                ?>
                                <td><?php echo $resultadoPaquete->return[$i]->iduse->idusu->nombreusu ?></td>
                            <?php } ?>
                            <td align="center"><?php echo $fecha[$i] ?></td>
                            <?php
                            $status = "";
                            if ($resultadoPaquete->return[$i]->statusseg == "0") {
                                $status = "En Proceso";
                            } elseif ($resultadoPaquete->return[$i]->statusseg == "1") {
                                $status = "Entregado";
                            } elseif ($resultadoPaquete->return[$i]->statusseg == "2") {
                                $status = "Reenviado";
                            } elseif ($resultadoPaquete->return[$i]->statusseg == "3") {
                                $status = "Extraviado";
                            }
                            ?>
                            <td align="center"><?php echo $status ?></td>
                            <?php
                            $tipo = "";
                            if ($resultadoPaquete->return[$i]->tiposeg == "0") {
                                $tipo = "Origen";
                            } elseif ($resultadoPaquete->return[$i]->tiposeg == "1") {
                                $tipo = "Destino";
                            }
                            ?>
                            <td align="center"><?php echo $tipo ?></td>
                            <td align="center"><?php echo $resultadoPaquete->return[$i]->nivelseg ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <?php if (isset($resultadoPaquete->return->iduse->idusu->apellidousu)) { ?>
                            <td><?php echo $resultadoPaquete->return->iduse->idusu->nombreusu . ' ' . $resultadoPaquete->return->iduse->idusu->apellidousu ?></td>
                        <?php } else {
                            ?>
                            <td><?php echo $resultadoPaquete->return->iduse->idusu->nombreusu ?></td>
                        <?php } ?>
                        <td align="center"><?php echo $fecha ?></td>
                        <?php
                        $status = "";
                        if ($resultadoPaquete->return->statusseg == "0") {
                            $status = "En Proceso";
                        } elseif ($resultadoPaquete->return->statusseg == "1") {
                            $status = "Entregado";
                        } elseif ($resultadoPaquete->return->statusseg == "2") {
                            $status = "Reenviado";
                        } elseif ($resultadoPaquete->return->statusseg == "3") {
                            $status = "Extraviado";
                        }
                        ?>
                        <td align="center"><?php echo $status ?></td>
                        <?php
                        $tipo = "";
                        if ($resultadoPaquete->return->tiposeg == "0") {
                            $tipo = "Origen";
                        } elseif ($resultadoPaquete->return->tiposeg == "1") {
                            $tipo = "Destino";
                        }
                        ?>
                        <td align="center"><?php echo $tipo ?></td>
                        <td align="center"><?php echo $resultadoPaquete->return->nivelseg ?></td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
        <br>
        <br>
        <div align="center">
            <img style="top:auto" src="../images/todo.png" width="700" height="40">        	
        </div>
    </body>
</html>