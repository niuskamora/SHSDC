<?php 
$site = "http://172.19.4.174/piash";
//$ftp = "http://172.19.4.174/ftp";
$ftp = "http://localhost";
$contactPhone = "(0212)-750.10.78";
$production = true;
$maxCurrentUser = 300;
$itemsByPage = 10;
//$phisicalPath = "D:\horidocs";
$phisicalPath = "C:\\Proyectos";
$securityKey = "7A375008784C3C6F178175A539E550FCB340349BDE70BE0C59EDE83211";
$contactEmail = "contacto@seguroshorizonte.com";
$codareacli = "0004";
$aplicacion = "HORICLINICA_WebOper";

$errorPermisionObject = "La solicitud de puede generarse debido a que no esta asignada al usuario activo. Notifique el problema a trav�s de los tel�fonos de contacto del portal.";
$errorInactiveModule = "En estos momentos no se pueden realizar solicitudes. Intente más tarde o contacte al departamento de soporte.";
$errorNoExistObject = "La solicitud no puede generarse debido a que no existe. Notifique el problema a trav�s de los tel�fonos de contacto del portal.";
$errorGenericMessage = "Se ha detectado un error en la solicitud. Notifique el problema a trav�s de los tel�fonos de contacto del portal.";
$sucessNotificationEmailMessage = "La solicitud de medicamentos ha sido enviada satisfactoriamente";
$errorNotificationEmailMessage = "La solicitud de medicamentos no ha podido ser enviada. Por favor intente más tarde o contacte al departamento de soporte.";
$errorAutoNotificationMessage = "La notificación de siniestro de vehículo presenta errores. Notifique el problema al departamento de soporte";
$errorProfileMessage = "Se ha detectado un problema en el perfil del usuario.";
$maintenanceMessage = "Disculpe, en estos momentos nos encontramos en labores de mantenimiento. Por favor intente más tarde";
$errorInclusionCorruptionMessage = "El código del contratante no es válido. Por favor intente más tarde o contacte al departamento de soporte.";
$errorInclusionBlockedMessage = "La solicitud de inclusión no esta habilitada para la póliza contratada";

if ($production != true){
	$message = $maintenanceMessage;
	$urlBack = "javascript:void(0);";
	include("../views/response.php");
	exit;
}

?>