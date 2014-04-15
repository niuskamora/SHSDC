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
                            <td align="center"><?php echo $resultadoConsultarPaquetes->return[$i]->idpaq ?></td>
                            <?php
                            $nomOrigen = "";
                            if (isset($resultadoConsultarPaquetes->return[$i]->origenpaq->idatr->idsed->nombresed)) {
                                $nomOrigen = $resultadoConsultarPaquetes->return[$i]->origenpaq->idatr->idsed->nombresed;
                            } else {
                                $nomOrigen = "";
                            }
                            ?>
                            <td><?php echo $nomOrigen ?></td>
                            <?php
                            $deOrigen = "";
                            $apellidoOrigen = "";
                            if (isset($resultadoConsultarPaquetes->return[$i]->origenpaq->idusu->nombreusu)) {
                                $deOrigen = $resultadoConsultarPaquetes->return[$i]->origenpaq->idusu->nombreusu;
                            } else {
                                $deOrigen = "";
                            }
                            if (isset($resultadoConsultarPaquetes->return[$i]->origenpaq->idusu->apellidousu)) {
                                $apellidoOrigen = $resultadoConsultarPaquetes->return[$i]->origenpaq->idusu->apellidousu;
                            } else {
                                $apellidoOrigen = "";
                            }
                            ?>
                            <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                            <?php
                            $paraDestino = "";
                            $apellidoDestino = "";
                            $nomDestino = "";
                            if (isset($resultadoConsultarPaquetes->return[$i]->destinopaq->tipobuz)) {
                                if ($resultadoConsultarPaquetes->return[$i]->destinopaq->tipobuz == "0") {
                                    if (isset($resultadoConsultarPaquetes->return[$i]->destinopaq->idusu->nombreusu)) {
                                        $paraDestino = $resultadoConsultarPaquetes->return[$i]->destinopaq->idusu->nombreusu;
                                    } else {
                                        $paraDestino = "";
                                    }
                                    if (isset($resultadoConsultarPaquetes->return[$i]->destinopaq->idusu->apellidousu)) {
                                        $apellidoDestino = $resultadoConsultarPaquetes->return[$i]->destinopaq->idusu->apellidousu;
                                    } else {
                                        $apellidoDestino = "";
                                    }
                                    if (isset($resultadoConsultarPaquetes->return[$i]->destinopaq->idatr->idsed->nombresed)) {
                                        $nomDestino = $resultadoConsultarPaquetes->return[$i]->destinopaq->idatr->idsed->nombresed;
                                    } else {
                                        $nomDestino = "";
                                    }
                                }
                                if ($resultadoConsultarPaquetes->return[$i]->destinopaq->tipobuz == "1") {
                                    if (isset($resultadoConsultarPaquetes->return[$i]->destinopaq->nombrebuz)) {
                                        $paraDestino = $resultadoConsultarPaquetes->return[$i]->destinopaq->nombrebuz;
                                    } else {
                                        $paraDestino = "";
                                    }
                                    if (isset($resultadoConsultarPaquetes->return[$i]->destinopaq->direccionbuz)) {
                                        $nomDestino = $resultadoConsultarPaquetes->return[$i]->destinopaq->direccionbuz;
                                    } else {
                                        $nomDestino = "";
                                    }
                                }
                            }
                            ?>                            
                            <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>
                            <td align="center"><?php echo $resultadoConsultarPaquetes->return[$i]->idpri->nombrepri ?></td>
                            <td align="center"><?php echo $resultadoConsultarPaquetes->return[$i]->iddoc->nombredoc ?></td>
                            <td><?php echo $nomDestino ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td align="center"><?php echo $fechaEnvio ?></td>
                        <td align="center"><?php echo $resultadoConsultarPaquetes->return->idpaq ?></td>
                        <?php
                        $nomOrigen = "";
                        if (isset($resultadoConsultarPaquetes->return->origenpaq->idatr->idsed->nombresed)) {
                            $nomOrigen = $resultadoConsultarPaquetes->return->origenpaq->idatr->idsed->nombresed;
                        } else {
                            $nomOrigen = "";
                        }
                        ?>
                        <td><?php echo $nomOrigen ?></td>
                        <?php
                        $deOrigen = "";
                        $apellidoOrigen = "";
                        if (isset($resultadoConsultarPaquetes->return->origenpaq->idusu->nombreusu)) {
                            $deOrigen = $resultadoConsultarPaquetes->return->origenpaq->idusu->nombreusu;
                        } else {
                            $deOrigen = "";
                        }
                        if (isset($resultadoConsultarPaquetes->return->origenpaq->idusu->apellidousu)) {
                            $apellidoOrigen = $resultadoConsultarPaquetes->return->origenpaq->idusu->apellidousu;
                        } else {
                            $apellidoOrigen = "";
                        }
                        ?>
                        <td><?php echo $deOrigen . ' ' . $apellidoOrigen ?></td>
                        <?php
                        $paraDestino = "";
                        $apellidoDestino = "";
                        $nomDestino = "";
                        if (isset($resultadoConsultarPaquetes->return->destinopaq->tipobuz)) {
                            if ($resultadoConsultarPaquetes->return->destinopaq->tipobuz == "0") {
                                if (isset($resultadoConsultarPaquetes->return->destinopaq->idusu->nombreusu)) {
                                    $paraDestino = $resultadoConsultarPaquetes->return->destinopaq->idusu->nombreusu;
                                } else {
                                    $paraDestino = "";
                                }
                                if (isset($resultadoConsultarPaquetes->return->destinopaq->idusu->apellidousu)) {
                                    $apellidoDestino = $resultadoConsultarPaquetes->return->destinopaq->idusu->apellidousu;
                                } else {
                                    $apellidoDestino = "";
                                }
                                if (isset($resultadoConsultarPaquetes->return->destinopaq->idatr->idsed->nombresed)) {
                                    $nomDestino = $resultadoConsultarPaquetes->return->destinopaq->idatr->idsed->nombresed;
                                } else {
                                    $nomDestino = "";
                                }
                            }
                            if ($resultadoConsultarPaquetes->return->destinopaq->tipobuz == "1") {
                                if (isset($resultadoConsultarPaquetes->return->destinopaq->nombrebuz)) {
                                    $paraDestino = $resultadoConsultarPaquetes->return->destinopaq->nombrebuz;
                                } else {
                                    $paraDestino = "";
                                }
                                if (isset($resultadoConsultarPaquetes->return->destinopaq->direccionbuz)) {
                                    $nomDestino = $resultadoConsultarPaquetes->return->destinopaq->direccionbuz;
                                } else {
                                    $nomDestino = "";
                                }
                            }
                        }
                        ?>                            
                        <td><?php echo $paraDestino . ' ' . $apellidoDestino ?></td>
                        <td align="center"><?php echo $resultadoConsultarPaquetes->return->idpri->nombrepri ?></td>
                        <td align="center"><?php echo $resultadoConsultarPaquetes->return->iddoc->nombredoc ?></td>
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