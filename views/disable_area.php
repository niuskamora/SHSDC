<?php
if (!isset($Sedes->return)) {
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
        <script type='text/javascript' src="../js/jquery-1.9.1.js"></script>
        <script type='text/javascript' src="../js/bootstrap.js"></script>
        <script type='text/javascript' src="../js/bootstrap-transition.js"></script>
        <script type='text/javascript' src="../js/bootstrap-tooltip.js"></script>
        <script type='text/javascript' src="../js/modernizr.min.js"></script>
<!--<script type='text/javascript' src="../js/togglesidebar.js"></script>-->	
        <script type='text/javascript' src="../js/custom.js"></script>
        <script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>

        <!-- styles -->
        <link rel="shortcut icon" href="../images/faviconsh.ico">


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
        <script>
            function buscarAreas(idsede) {
                var parametros = {
                    "idsede": idsede
                };
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajaxareas.php",
                    data: parametros,
                    dataType: "text",
                    success: function(response) {
                        $("#contenedor").html(response);
                    }
                });
            }
            function buscarSedes() {
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajaxsedes.php",
                    dataType: "text",
                    success: function(response) {
                        $("#contenedor").html(response);
                    }
                });
            }
            function cambiar(idarea, cp) {
                var parametros = {
                    "idarea": idarea
                };
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajaxcambioestado.php",
                    data: parametros,
                    dataType: "text",
                    success: function(response) {
                        colorear(cp);
                    }
                });
            }

            function colorear(cp)
            {
                if ($(cp).parents('tr').find('td').css('background-color') == "rgb(249, 249, 249)" || $(cp).parents('tr').find('td').css('background-color') == "rgba(0, 0, 0, 0)")
                {
                    $(cp).parents('tr').find('td').css('background-color', "rgb(206, 200, 200)");

                }
                else
                {
                    $(cp).parents('tr').find('td').css('background-color', "rgb(249, 249, 249)");

                }
            }
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

        <div id="middle">
            <div class="container app-container"> 
                <?php
                Menu($SedeRol);
                ?>
                <!--Caso pantalla uno-->
                <div class="row-fluid">
                    <div class="span2">
                        <ul class="nav nav-pills nav-stacked">
                            <li> <a href="../pages/administration.php">Atrás</a> </li>
                        </ul>
                    </div>

                    <div class="span10">
                        <div class="tab-content" id="contenedor">
                            <?php
                            echo "<h2> <strong>Sedes</strong> </h2>";
                            echo "<table class='footable table table-striped table-bordered' align='center'  data-page-size=$itemsByPage>
    	 					<thead bgcolor='#ff0000'>
                            <tr>";
                            echo "<th style='width:10%; text-align:center'>Id</th>";
                            echo "<th data-sort-ignore='true'>Nombre </th>";
                            echo "<th style='width:10%; text-align:center' data-sort-ignore='true'>Area</th>
         					</thead>
        					<tbody>
        					<tr>";
                            if ($reg > 0) {
                                $j = 0;
                                while ($j < $reg) {
                                    echo "<td style='text-align:center'>" . $Sedes->return[$j]->idsed . "</td>";
                                    echo "<td style='text-align:left'>" . $Sedes->return[$j]->nombresed . "</td>";
                                    ?>
                                    <td style="text-align:center"> 
                                        <button class='btn' onClick="buscarAreas('<?php echo $Sedes->return[$j]->idsed; ?>');">
                                            <span class="icon-home" > </span>
                                        </button>
                                    </td>
                                    <?php
                                    echo "</tr>";
                                    $j++;
                                }
                            }
                            echo " </tbody>
                                </table>";
                            echo '<ul id="pagination" class="footable-nav"><span>Pag:</span></ul>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>
<script>
            window.onload = function() {
                killerSession();
            }
            function killerSession() {
                setTimeout("window.open('../recursos/cerrarsesion.php','_top');", 300000);
            }
</script>
<script src="../js/footable.js" type="text/javascript"></script>
<script src="../js/footable.paginate.js" type="text/javascript"></script>
<script src="../js/footable.sortable.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $('table').footable();
    });
</script>
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