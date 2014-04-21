<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Comprobante de Detalle de la Valija</title>
        <link rel="stylesheet" href="../recursos/estilosPdf.css" type="text/css" />
    </head>
    <body>
        <div>
            <img style="top:auto" src="../images/header-top-left.png" width="250" height="40">
        </div>
        <div align="center">	
            <h2 align="center">Sistema de Correspondencia</h2>
            <h3 align="center">Valija</h3>
            <table align="center" width="500" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Fecha y Hora de Envio</strong></td>
                    <td align="center"><strong>Nro de Valija</strong></td>
                    <td align="center"><strong>Nro de Guía</strong></td>
                    <td align="center"><strong>Origen</strong></td>
                    <td align="center"><strong>Tipo</strong></td>
                    <td align="center"><strong>Destino</strong></td>
                    <td align="center"><strong>Fecha y Hora de Recibido</strong></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $fechaEnvio ?></td>
                    <td align="center"><?php echo $idVal ?></td>
                    <td align="center"><?php echo $guia ?></td>
                    <td><?php echo $origen ?></td>
                    <td><?php echo $tipo ?></td>
                    <td><?php echo $destino ?></td>
                    <td align="center"><?php echo $fechaRecibido ?></td>
                </tr>
            </table>
            <br>
            <h3 align="center">Detalle de Valija</h3>
            <table align="center" width="450" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Nro de Paquete</strong></td>
                    <td align="center"><strong>Origen</strong></td>
                    <td align="center"><strong>De</strong></td>
                    <td align="center"><strong>Para</strong></td>
                    <td align="center"><strong>Destino</strong></td>
                </tr>
                <?php
                if ($contadorPaquetes > 1) {
                    for ($i = 0; $i < $contadorPaquetes; $i++) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $resultadoPaquetesPorValija[$i]['idpaq'] ?></td>
                            <?php
                            $nomOrigen = "";
                            if (isset($resultadoPaquetesPorValija[$i]['origenpaq']['idatr']['idsed']['nombresed'])) {
                                $nomOrigen = $resultadoPaquetesPorValija[$i]['origenpaq']['idatr']['idsed']['nombresed'];
                            } else {
                                $nomOrigen = "";
                            }
                            ?>
                            <td><?php echo $nomOrigen ?></td>
                            <?php
                            $deOrigen = "";
                            $apellidoOrigen = "";
                            if (isset($resultadoPaquetesPorValija[$i]['origenpaq']['idusu']['nombreusu'])) {
                                $deOrigen = $resultadoPaquetesPorValija[$i]['origenpaq']['idusu']['nombreusu'];
                            } else {
                                $deOrigen = "";
                            }
                            if (isset($resultadoPaquetesPorValija[$i]['origenpaq']['idusu']['apellidousu'])) {
                                $apellidoOrigen = $resultadoPaquetesPorValija[$i]['origenpaq']['idusu']['apellidousu'];
                            } else {
                                $apellidoOrigen = "";
                            }
                            ?>
                            <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                            <?php
                            $paraDestino = "";
                            $apellidoDestino = "";
                            $nomDestino = "";
                            if (isset($resultadoPaquetesPorValija[$i]['destinopaq']['tipobuz'])) {
                                if ($resultadoPaquetesPorValija[$i]['destinopaq']['tipobuz'] == "0") {
                                    if (isset($resultadoPaquetesPorValija[$i]['destinopaq']['idusu']['nombreusu'])) {
                                        $paraDestino = $resultadoPaquetesPorValija[$i]['destinopaq']['idusu']['nombreusu'];
                                    } else {
                                        $paraDestino = "";
                                    }
                                    if (isset($resultadoPaquetesPorValija[$i]['destinopaq']['idusu']['apellidousu'])) {
                                        $apellidoDestino = $resultadoPaquetesPorValija[$i]['destinopaq']['idusu']['apellidousu'];
                                    } else {
                                        $apellidoDestino = "";
                                    }
                                    if (isset($resultadoPaquetesPorValija[$i]['destinopaq']['idatr']['idsed']['nombresed'])) {
                                        $nomDestino = $resultadoPaquetesPorValija[$i]['destinopaq']['idatr']['idsed']['nombresed'];
                                    } else {
                                        $nomDestino = "";
                                    }
                                }
                                if ($resultadoPaquetesPorValija[$i]['destinopaq']['tipobuz'] == "1") {
                                    if (isset($resultadoPaquetesPorValija[$i]['destinopaq']['nombrebuz'])) {
                                        $paraDestino = $resultadoPaquetesPorValija[$i]['destinopaq']['nombrebuz'];
                                    } else {
                                        $paraDestino = "";
                                    }
                                    if (isset($resultadoPaquetesPorValija[$i]['destinopaq']['direccionbuz'])) {
                                        $nomDestino = $resultadoPaquetesPorValija[$i]['destinopaq']['direccionbuz'];
                                    } else {
                                        $nomDestino = "";
                                    }
                                }
                            }
                            ?>                            
                            <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>
                            <td><?php echo $nomDestino ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center"><?php echo $resultadoPaquetesPorValija['idpaq'] ?></td>
                        <?php
                        $nomOrigen = "";
                        if (isset($resultadoPaquetesPorValija['origenpaq']['idatr']['idsed']['nombresed'])) {
                            $nomOrigen = $resultadoPaquetesPorValija['origenpaq']['idatr']['idsed']['nombresed'];
                        } else {
                            $nomOrigen = "";
                        }
                        ?>
                        <td><?php echo $nomOrigen ?></td>
                        <?php
                        $deOrigen = "";
                        $apellidoOrigen = "";
                        if (isset($resultadoPaquetesPorValija['origenpaq']['idusu']['nombreusu'])) {
                            $deOrigen = $resultadoPaquetesPorValija['origenpaq']['idusu']['nombreusu'];
                        } else {
                            $deOrigen = "";
                        }
                        if (isset($resultadoPaquetesPorValija['origenpaq']['idusu']['apellidousu'])) {
                            $apellidoOrigen = $resultadoPaquetesPorValija['origenpaq']['idusu']['apellidousu'];
                        } else {
                            $apellidoOrigen = "";
                        }
                        ?>
                        <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                        <?php
                        $paraDestino = "";
                        $apellidoDestino = "";
                        $nomDestino = "";
                        if (isset($resultadoPaquetesPorValija['destinopaq']['tipobuz'])) {
                            if ($resultadoPaquetesPorValija['destinopaq']['tipobuz'] == "0") {
                                if (isset($resultadoPaquetesPorValija['destinopaq']['idusu']['nombreusu'])) {
                                    $paraDestino = $resultadoPaquetesPorValija['destinopaq']['idusu']['nombreusu'];
                                } else {
                                    $paraDestino = "";
                                }
                                if (isset($resultadoPaquetesPorValija['destinopaq']['idusu']['apellidousu'])) {
                                    $apellidoDestino = $resultadoPaquetesPorValija['destinopaq']['idusu']['apellidousu'];
                                } else {
                                    $apellidoDestino = "";
                                }
                                if (isset($resultadoPaquetesPorValija['destinopaq']['idatr']['idsed']['nombresed'])) {
                                    $nomDestino = $resultadoPaquetesPorValija['destinopaq']['idatr']['idsed']['nombresed'];
                                } else {
                                    $nomDestino = "";
                                }
                            }
                            if ($resultadoPaquetesPorValija['destinopaq']['tipobuz'] == "1") {
                                if (isset($resultadoPaquetesPorValija['destinopaq']['nombrebuz'])) {
                                    $paraDestino = $resultadoPaquetesPorValija['destinopaq']['nombrebuz'];
                                } else {
                                    $paraDestino = "";
                                }
                                if (isset($resultadoPaquetesPorValija['destinopaq']['direccionbuz'])) {
                                    $nomDestino = $resultadoPaquetesPorValija['destinopaq']['direccionbuz'];
                                } else {
                                    $nomDestino = "";
                                }
                            }
                        }
                        ?>                            
                        <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>
                        <td><?php echo $nomDestino ?></td>
                    </tr>
                <?php }
                ?>
            </table>
            <br>
            <br>
            <br>       
            <table align="center" width="300" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Número de Paquetes o Correspondencia</strong></td>
                    <td align="center" width="100"><?php echo $contadorPaquetes ?></td>
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