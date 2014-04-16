<?php
if ($usuario == "") {
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
        <script type='text/javascript' src="../js/jquery-2.0.2.js"></script>
        <script type='text/javascript' src="../js/bootstrap.js"></script>
        <script type='text/javascript' src="../js/bootstrap-transition.js"></script>
        <script type='text/javascript' src="../js/bootstrap-tooltip.js"></script>
        <script type='text/javascript' src="../js/modernizr.min.js"></script>
<!--<script type='text/javascript' src="../js/togglesidebar.js"></script>-->	
        <script type='text/javascript' src="../js/custom.js"></script>
        <script type='text/javascript' src="../js/jquery.fancybox.pack.js"></script>
        <!-- Scripts de los graficos -->
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>

        <!-- styles -->
        <link rel="shortcut icon" href="../images/faviconsh.ico">


        <link rel="shortcut icon" href="../images/faviconsh.ico">

        <link href="../views/css/bootstrap.css" rel="stylesheet">
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
                <div class="row-fluid">
                    <div class="span2">
                        <ul class="nav nav-pills nav-stacked">
                            <li>   
                                <a href="../pages/info_reports_package.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="span10" align="center">
                        <div class="tab-content" id="lista" align="center">
                            <?php
                            //Verificando que este vacio o sea null
                            if ($contadorSedes == 0) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No Existen Registros de Paquetes</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro el gráfico
                            else {
                                ?>
                                <h2> <strong>Gráfica de <?php echo $nombreReporte ?></strong> </h2>
                                <br>                            
                                <?php
                                if ($sede == '0') {
                                    if ($contadorSedes <= 10) {
                                        $tama = 300;
                                    } elseif ($contadorSedes > 10 && $contadorSedes <= 20) {
                                        $tama = 400;
                                    } elseif ($contadorSedes > 20 && $contadorSedes <= 30) {
                                        $tama = 500;
                                    } elseif ($contadorSedes > 30 && $contadorSedes <= 40) {
                                        $tama = 600;
                                    }
                                    ?>
                                    <div align="center" id="graficoHorizontal" style="min-width: 100px; max-width: 600px; height: <?php echo $tama ?>px; margin: 0 auto">   	
                                    </div>
                                <?php
                                }
                            }
                            ?>
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
                setTimeout("window.close();", 300000);
            }
        </script>

        <script>
            /*Gráfico horizontal para todas las sedes*/
       	$(function() {
            $('#graficoHorizontal').highcharts({
            chart: {
            	type: 'bar'
            },
			title: {
            	text: 'Estradísticas de Paquetes'
            },
			xAxis: {
            	categories: [<?php if ($contadorSedes > 1) {
                                for ($i = 0; $i < $contadorSedes; $i++) {
                                    if ($i == 0) { ?>
										'<?php echo utf8_encode($nombreSede[$i]); ?>'
									<?php } else { ?>
                        				, '<?php echo utf8_encode($nombreSede[$i]); ?>'
        							<?php }
    							}
							} else { ?>
                				'<?php echo utf8_encode($nombreSede); ?>'
							<?php } ?>],
			title: {
            	text: null
            	}
            },
			yAxis: {
            	min: 0,
			title: {
            	text: 'Cantidad Total de <?php echo $nombreReporte ?>',
                align: 'high'
            },
			labels: {
            	overflow: 'justify'
            	}
            },
			tooltip: {
            	valueSuffix: 'Paquetes'
            },
			plotOptions: {
            	bar: {
            		dataLabels: {
            			enabled: true
            		}
            	}
            },
			legend: {
            	layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 0,
                y: 0,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
			credits: {
            	enabled: false
            },
			series: [{
            	name: '<?php echo $nombreReporte ?>',
                data: [ <?php if ($contadorSedes > 1) {
							for ($i = 0; $i < $contadorSedes; $i++) {
								if ($i == 0) { ?>
									<?php echo $paquetes[$i]; ?>
								<?php } else { ?>
                        			,<?php echo $paquetes[$i]; ?>
        					<?php }
    							}
							} else { ?>
    							<?php echo $paquetes; ?>
							<?php } ?> ]
            		}]
            	});
            });
        </script>
	</body>
</html>