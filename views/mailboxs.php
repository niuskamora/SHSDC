<?php
if ($usu== "") {
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
                                <a href="../pages/view_user.php">
                                    <?php echo "Atrás" ?>         
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="span10">
                        <div class="tab-content" id="bandeja">
                            <?php
                            //Verificando que este vacio o sea null
                            if (!isset($resultadoLista->return)) {
                                echo '<div class="alert alert-block" align="center">';
                                echo '<h2 style="color:rgb(255,255,255)" align="center">Atención</h2>';
                                echo '<h4 align="center">No hay Buzones por editar</h4>';
                                echo '</div>';
                            }
                            //Si existen registros muestro la tabla
                            else {
                                ?>
                                <form class="form-search" id="formulario" method="post">                   
                                    <strong> <h2 align="center">Buzones</h2> </strong>
                                    <table class='footable table table-striped table-bordered'  data-page-size=$itemsByPage>
                                        <thead bgcolor='#FF0000'>
                                            <tr>
                                                
                                                <th style="text-align:center" data-sort-ignore="true">Nombre</th>
                                                <th style="text-align:center" data-sort-ignore="true">Área</th>
                                                <th style="text-align:center" data-sort-ignore="true">Sede</th>
                                                <th style="text-align:center" data-sort-ignore="true">Editar</th>                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($bitacora > 1) {
                                                for ($i = 0; $i < $bitacora; $i++) {
													 $areaBuzon="Externo";$sedeBuzon="Externo";
													if(isset($resultadoLista->return[$i]->idatr->nombreatr)){
														$areaBuzon=$resultadoLista->return[$i]->idatr->nombreatr;
													}
													if(isset($resultadoLista->return[$i]->idatr->idsed->nombresed)){
														$sedeBuzon=$resultadoLista->return[$i]->idatr->idsed->nombresed;
													}
												?>
                                                    <tr>
                                                        <td style="text-align:center"><?php echo $resultadoLista->return[$i]->nombrebuz; ?></td>
                                                        <td style="text-align:center"><?php echo $areaBuzon; ?></td>                   
                                                        <td style="text-align:center"><?php echo $sedeBuzon; ?></td>                                            	
                                                        <td style="text-align:center"><a href='../pages/edit_mailbox.php?id=<?php echo $resultadoLista->return[$i]->idbuz?>'><button type='button' class='btn btn-info btn-primary' value='Editar'> Editar </button> </a></td>
                                                        
                                                    </tr>
                                                        
                                                    <?php }
                                            } else { 
											        $areaBuzon="Externo";$sedeBuzon="Externo";
													if(isset($resultadoLista->return->idatr->nombreatr)){
														$areaBuzon=$resultadoLista->return[$i]->idatr->nombreatr;
													}
													if(isset($resultadoLista->return->idatr->idsed->nombresed)){
														$sedeBuzon=$resultadoLista->return[$i]->idatr->idsed->nombresed;
													}
?>
                                                    <tr>
                                                        <td style="text-align:center"><?php echo $resultadoLista->return->nombrebuz ?></td>
                                                        <td style="text-align:center"><?php echo $areaBuzon; ?></td>                   
                                                        <td style="text-align:center"><?php echo $sedeBuzon; ?></td>                                            	
                                                  
                                                        <td style="text-align:center"><a href='../pages/edit_mailbox.php?id=<?php echo $resultadoLista->return->idbuz?>'><button type='button' class='btn btn-info btn-primary' value='Editar'> Editar </button> </a></td>
                                                        
                                                    </tr>
                                            <?php } ?>                                    
                                        </tbody>
                                    </table>                            
                                    <ul id="pagination" class="footable-nav"><span>Pag:</span></ul>
                                    <br>
                                   
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /container -->
        <div id="footer" class="container">    	
        </div>
    </div>

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
</body>
</html>