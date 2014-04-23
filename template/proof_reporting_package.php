<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Comprobante de Paquetes</title>
        <link rel="stylesheet" href="../recursos/estilosPdf.css" type="text/css" />
    </head>
    <body>
        <div>
            <img style="top:auto" src="../images/header-top-left.png" width="250" height="40">
        </div>
        <div align="center">	
            <h2 align="center">Sistema de Correspondencia</h2>
            <h3 align="center"><?php echo $nombreReporte ?></h3>
            <table align="center" width="450" border="1" rules="all">
                <tr>
                    <td align="center"><strong>Fecha y Hora de Envio</strong></td>
                    <td align="center"><strong>Nro de Paquete</strong></td>
                    <td align="center"><strong>Origen</strong></td>
                    <td align="center"><strong>De</strong></td>
                    <td align="center"><strong>Para</strong></td>
                    <td align="center"><strong>Priordad</strong></td>
                    <td align="center"><strong>Tipo</strong></td>
                    <td align="center"><strong>Destino</strong></td>
                </tr>
                <?php
                if ($contadorPaquetes > 1) {
                    for ($i = 0; $i < $contadorPaquetes; $i++) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $fechaEnvio[$i] ?></td>
                            <td align="center"><?php echo $resultadoConsultarPaquetes[$i]['idpaq'] ?></td>
                            <?php
                            $nomOrigen = "";
                            if (isset($resultadoConsultarPaquetes[$i]['origenpaq']['idatr']['idsed']['nombresed'])) {
                                $nomOrigen = utf8_encode($resultadoConsultarPaquetes[$i]['origenpaq']['idatr']['idsed']['nombresed']);
                            } else {
                                $nomOrigen = "";
                            }
                            ?>
                            <td><?php echo $nomOrigen ?></td>
                            <?php
                            $deOrigen = "";
                            $apellidoOrigen = "";
                            if (isset($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['nombreusu'])) {
                                $deOrigen = utf8_encode($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['nombreusu']);
                            } else {
                                $deOrigen = "";
                            }
                            if (isset($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['apellidousu'])) {
                                $apellidoOrigen = utf8_encode($resultadoConsultarPaquetes[$i]['origenpaq']['idusu']['apellidousu']);
                            } else {
                                $apellidoOrigen = "";
                            }
                            ?>
                            <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                            <?php
                            $paraDestino = "";
                            $apellidoDestino = "";
                            $nomDestino = "";
                            if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['tipobuz'])) {
                                if ($resultadoConsultarPaquetes[$i]['destinopaq']['tipobuz'] == "0") {
                                    if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['nombreusu'])) {
                                        $paraDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['nombreusu']);
                                    } else {
                                        $paraDestino = "";
                                    }
                                    if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['apellidousu'])) {
                                        $apellidoDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['idusu']['apellidousu']);
                                    } else {
                                        $apellidoDestino = "";
                                    }
                                    if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['idatr']['idsed']['nombresed'])) {
                                        $nomDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['idatr']['idsed']['nombresed']);
                                    } else {
                                        $nomDestino = "";
                                    }
                                }
                                if ($resultadoConsultarPaquetes[$i]['destinopaq']['tipobuz'] == "1") {
                                    if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['nombrebuz'])) {
                                        $paraDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['nombrebuz']);
                                    } else {
                                        $paraDestino = "";
                                    }
                                    if (isset($resultadoConsultarPaquetes[$i]['destinopaq']['direccionbuz'])) {
                                        $nomDestino = utf8_encode($resultadoConsultarPaquetes[$i]['destinopaq']['direccionbuz']);
                                    } else {
                                        $nomDestino = "";
                                    }
                                }
                            }
                            ?>                            
                            <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>
                            <td align="center"><?php echo utf8_encode($resultadoConsultarPaquetes[$i]['idpri']['nombrepri']) ?></td>
                            <td align="center"><?php echo utf8_encode($resultadoConsultarPaquetes[$i]['iddoc']['nombredoc']) ?></td>
                            <td><?php echo $nomDestino ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center"><?php echo $fechaEnvio ?></td>
                        <td align="center"><?php echo $resultadoConsultarPaquetes['idpaq'] ?></td>
                        <?php
                        $nomOrigen = "";
                        if (isset($resultadoConsultarPaquetes['origenpaq']['idatr']['idsed']['nombresed'])) {
                            $nomOrigen = utf8_encode($resultadoConsultarPaquetes['origenpaq']['idatr']['idsed']['nombresed']);
                        } else {
                            $nomOrigen = "";
                        }
                        ?>
                        <td><?php echo $nomOrigen ?></td>
                        <?php
                        $deOrigen = "";
                        $apellidoOrigen = "";
                        if (isset($resultadoConsultarPaquetes['origenpaq']['idusu']['nombreusu'])) {
                            $deOrigen = utf8_encode($resultadoConsultarPaquetes['origenpaq']['idusu']['nombreusu']);
                        } else {
                            $deOrigen = "";
                        }
                        if (isset($resultadoConsultarPaquetes['origenpaq']['idusu']['apellidousu'])) {
                            $apellidoOrigen = utf8_encode($resultadoConsultarPaquetes['origenpaq']['idusu']['apellidousu']);
                        } else {
                            $apellidoOrigen = "";
                        }
                        ?>
                        <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                        <?php
                        $paraDestino = "";
                        $apellidoDestino = "";
                        $nomDestino = "";
                        if (isset($resultadoConsultarPaquetes['destinopaq']['tipobuz'])) {
                            if ($resultadoConsultarPaquetes['destinopaq']['tipobuz'] == "0") {
                                if (isset($resultadoConsultarPaquetes['destinopaq']['idusu']['nombreusu'])) {
                                    $paraDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['idusu']['nombreusu']);
                                } else {
                                    $paraDestino = "";
                                }
                                if (isset($resultadoConsultarPaquetes['destinopaq']['idusu']['apellidousu'])) {
                                    $apellidoDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['idusu']['apellidousu']);
                                } else {
                                    $apellidoDestino = "";
                                }
                                if (isset($resultadoConsultarPaquetes['destinopaq']['idatr']['idsed']['nombresed'])) {
                                    $nomDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['idatr']['idsed']['nombresed']);
                                } else {
                                    $nomDestino = "";
                                }
                            }
                            if ($resultadoConsultarPaquetes['destinopaq']['tipobuz'] == "1") {
                                if (isset($resultadoConsultarPaquetes['destinopaq']['nombrebuz'])) {
                                    $paraDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['nombrebuz']);
                                } else {
                                    $paraDestino = "";
                                }
                                if (isset($resultadoConsultarPaquetes['destinopaq']['direccionbuz'])) {
                                    $nomDestino = utf8_encode($resultadoConsultarPaquetes['destinopaq']['direccionbuz']);
                                } else {
                                    $nomDestino = "";
                                }
                            }
                        }
                        ?>                            
                        <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>
                        <td align="center"><?php echo utf8_encode($resultadoConsultarPaquetes['idpri']['nombrepri']) ?></td>
                        <td align="center"><?php echo utf8_encode($resultadoConsultarPaquetes['iddoc']['nombredoc']) ?></td>
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
                    <td align="center"><strong>Total de <?php echo $nombreReporte ?></strong></td>
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