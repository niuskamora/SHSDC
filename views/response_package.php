<?php
if (!isset($rowDocumentos->return)) {
    echo '<script language="javascript"> window.location = "../pages/inbox.php"; </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Seguros Horizonte | HorizonLine</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- javascript -->
        <script type="text/javascript" src="../js/jquery-1.9.1.js" ></script> 
        <script type='text/javascript' src="../js/bootstrap.js"></script>
        <script type='text/javascript' src="../js/bootstrap-transition.js"></script>
        <script type='text/javascript' src="../js/bootstrap-tooltip.js"></script>
        <script type='text/javascript' src="../js/modernizr.min.js"></script>
        <script type='text/javascript' src="../js/custom.js"></script>
        <script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>
        <!-- javascript para el funcionamiento del calendario -->
        <link rel="stylesheet" type="text/css" href="../js/ui-lightness/jquery-ui-1.10.3.custom.css" media="all" />
        <script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.js" ></script> 
        <script type="text/javascript" src="../js/calendarioValidado.js" ></script> 
        <!-- styles -->
        <link rel="shortcut icon" href="../images/faviconsh.ico">


        <link rel="shortcut icon" href="../images/faviconsh.ico">

        <link href="css/bootstrap.css" rel="stylesheet">
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



    </script>
</head>

<body class="appBg">
    <div id="header">
        <div class="container header-top-top hidden-phone">
            <img alt="" src="../images/header-top-top-left.png" class="pull-left">
            <img alt="" src="../images/header-top-top-right.png" class="pull-right">
        </div>
        <div class="header-top">
            <div class="container">
                <img alt="" src="../images/header-top-left.png" class="pull-left">
                <div class="pull-right">
                </div>
            </div>
            <div class="filter-area">
                <div class="container">
                    <span lang="es">&nbsp;</span></div>
            </div>
        </div>
    </div>

    <div class="container app-container">
        <?php
        Menu($SedeRol);
        ?>
        <!--Caso pantalla uno-->
        <form method="post" ENCTYPE="multipart/form-data">
            <div class="row-fluid">
                <div class="span2">
                    <ul class="nav nav-pills nav-stacked">
                        <li> <a href="inbox.php">Atrás</a> </li>
                    </ul>
                </div>

                <div class="span10">
                    <div class="tab-content" id="Correspondecia">
                        <table> 
                            <tr>
                                <td>Para:</td><td>
                                    <input id="contacto" name="contacto" type="text"  value="<?php echo $Paquete->return->origenpaq->nombrebuz; ?>" maxlength="199" style="width:800px" size="100"  disabled>								
                                </td>
                            </tr>
                            <tr>
                                <td>Asunto:</td><td><input type="text" id="asunto" name="asunto" maxlength="199"  size="100" style="width:800px" title="Ingrese el asunto" autocomplete="off"  required><br></td>
                            </tr>
                            <tr>
                                <td>Tipo Doc:</td><td><select name="doc" required  title="Seleccione el tipo de documento">
                                        <option value="" style="display:none">Seleccionar:</option>

                                        <?php
                                        if (count($rowDocumentos->return) == 1) {
                                            echo '<option value="' . $rowDocumentos->return->iddoc . '">' . $rowDocumentos->return->nombredoc . '</option>';
                                        } else {
                                            for ($i = 0; $i < count($rowDocumentos->return); $i++) {
                                                echo '<option value="' . $rowDocumentos->return[$i]->iddoc . '">' . $rowDocumentos->return[$i]->nombredoc . '</option>';
                                            }
                                        }
                                        ?>

                                    </select><br></td>
                            </tr>
                            <tr>
                                <td>Prioridad:</td><td><select name="prioridad" required  title="Seleccione la prioridad">
                                        <option value="" style="display:none">Seleccionar:</option>                                  
                                        <?php
                                        if (count($rowPrioridad->return) == 1) {
                                            echo '<option value="' . $rowPrioridad->return->idpri . '">' . $rowPrioridad->return->nombrepri . '</option>';
                                        } else {
                                            for ($i = 0; $i < count($rowPrioridad->return); $i++) {
                                                echo '<option value="' . $rowPrioridad->return[$i]->idpri . '">' . $rowPrioridad->return[$i]->nombrepri . '</option>';
                                            }
                                        }
                                        ?>
                                    </select><br></td>
                            </tr>
                            <tr>
                                <td> Frágil: </td><td><input type="checkbox" name="fragil" id="fragil" title="Seleccione si el paquete es frágil"></td>
                            </tr>
                            <tr>
                                <td>Imagen del paquete(opcional):</td><td>
                                    <input id="imagen" name="imagen" type="file" maxlength="199" onBlur='LimitAttach(this);'/>
                                </td>
                            </tr>
                            <tr>
                                <td>Comentario del paquete: </td><td><textarea  rows="10" cols= "23" id="elmsg" name="elmsg" maxlength="1999"  style="width:800px" title="Ingrese un comentario" required>...</textarea><br></td>
                            </tr>

                            <tr>          
                                <td colspan="2" align="right"><input type="submit" id="enviar"  onclick="return confirm('¿Esta seguro que desea enviar la correspondencia? \n Luego de enviado no podrá modificar la correspondencia')" value="Responder Correspondecia" name="enviar"><br>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
                                        function LimitAttach(tField) {
                                            file = imagen.value;

                                            extArray = new Array(".gif", ".jpg", ".png");

                                            allowSubmit = false;
                                            if (!file)
                                                return;
                                            while (file.indexOf("\\") != - 1)
                                                file = file.slice(file.indexOf("\\") + 1);
                                            ext = file.slice(file.indexOf(".")).toLowerCase();
                                            for (var i = 0; i < extArray.length; i++) {
                                                if (extArray[i] == ext) {
                                                    allowSubmit = true;
                                                    break;
                                                }
                                            }
                                            if (allowSubmit) {
                                            } else {
                                                tField.value = "";
                                                alert("Usted sólo puede subir archivos con extensiones " + (extArray.join(" ")) + "\nPor favor seleccione un nuevo archivo");
                                            }
                                        }
    </script>
</body>
</html>