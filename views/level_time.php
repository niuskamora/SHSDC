<?php
if ($usu == "") {
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
                            <li>   
                                <a href="../pages/administration.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <form class="form-signin" method="post">
                                <div class="tab-content">
                                    <div class="row-fluid">
                                        <strong> <h2 align="center">Tiempo en Áreas</h2> </strong>
                                        <div class="span5" align="right"><strong> Prioridad: </strong></div>
                                        <div class="span3" align="left">
                                            <select id="prioridad" name="prioridad" required onChange="areas();" title="Seleccione la prioridad">
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
                                            </select>
                                        </div>
                                        <div class="span5" align="right"><strong>Área:</strong></div>
                                        <div class="span3" align="left">
                                            <select id="area" name="area"  required  title="Seleccione el área">
                                                <option value="" style="display:none">Seleccionar:</option>
                                            </select>
                                        </div>
                                        <div class="span5" align="right"><strong>Tiempo en horas:</strong></div>
                                        <div class="span3" align="left">
                                            <input type="text" class="input-block-level" name="hora" id="hora" placeholder="Ej. 3" title="Ingrese la hora del nivel" autocomplete="off" pattern="[0-9]{1,500}" autofocus required>
                                        </div>
                                        <div class="span5" align="right"><strong></strong></div>
                                        <div class="span3" align="left">
                                            <button class="btn" type="submit" id="Guardar" name="Guardar" onclick="return confirm('¿Esta seguro que desea cambiar la hora del nivel?')">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>
	window.onload = function() {
		killerSession();
	}
	function killerSession() {
		setTimeout("window.open('../recursos/cerrarsesion.php','_top');", 300000);
	}
	
	function areas() {
		//posicion
		var $selectedOption = $('#prioridad').find('option:selected');
		var id = $selectedOption.val();
		$.ajax({
			type: "POST",
			url: "../ajax/areas.php",
			data: {'id': id},
			dataType: "text",
			success: function(response) {
				$("#area").html(response);
			}
		});
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
</body>
</html>