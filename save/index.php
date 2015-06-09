<?php
session_start();
$db = new PDO("mysql:dbname=eshop;host=127.0.0.1", 'root', 'troiswa',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// Sélection des permissions à chaque chargement de page en cas de modification
if (isset($_SESSION['auth']))
{
	$selectPermissions = $db->query("SELECT groupe.permissions FROM groupe JOIN member ON member.id_groupe = groupe.id WHERE member.id = ".$_SESSION['id'])->fetch(PDO::FETCH_ASSOC);
	$_SESSION['permissions'] = $selectPermissions['permissions'];
}
// Déconnexion
if (isset($_GET['session']) && $_GET['session'] == 'logout')
{
	$db->exec("UPDATE member SET time_update = NOW() WHERE id = ".$_SESSION['id']); // Update date dernière visite du membre
	$_SESSION = array(); // Destruction des variables de session
	session_destroy(); // Destruction de la session
	$_SESSION['message'] = '<div class="alert alert-success" role="alert">Vous êtes maintenant déconnecté</div>';
}
// Constantes pour permissions
define ('PUBLIER_CONTENU',         0x01);
define ('MODIFIER_CONTENU',        0x02);
define ('SUPPRIMER_CONTENU',       0x04);
define ('VALIDER_TOUT_CONTENU',    0x08);
define ('MODIFIER_TOUT_CONTENU',   0x10);
define ('SUPPRIMER_TOUT_CONTENU',  0x20);
define ('GERER_MEMBRES',           0x40);
define ('GERER_PERMISSIONS',       0x80);
// Liste des fonctions principales
require('apps/functions.php');
// Page exécutée en...
$displayStart = generation();
// Chemin absolu et configuration serveur
$path = 'http://'.$_SERVER['SERVER_NAME'].'/tp_eshop/';
// Codes HTTP
$httpCode = http_response_code();
// Gestion des pages du site (MVC)
$page = array('home','login','register','admin','catalogue','profile','search','panier','process','error');
if (isset($_GET['page']))
{
	if (in_array($_GET['page'],$page))
	{
		$pageName = $_GET['page'];
	}
	else
	{
		$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Sorry, the page you are looking for does not exist</div>';
		$pageName = 'process';
	}
}
else
{
	if ($httpCode == 400)
	{
		$pageName = 'error';
		$codeErreur = $httpCode;
		$codeTitle = 'Bad Request';
		$codeMessage = 'The server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing)';
	}
	elseif ($httpCode == 403)
	{
		$pageName = 'error';
		$codeErreur = $httpCode;
		$codeTitle = 'Forbidden';
		$codeMessage = 'The request was a valid request, but the server is refusing to respond to it.';
	}
	elseif ($httpCode == 404)
	{
		$pageName = 'error';
		$codeErreur = $httpCode;
		$codeTitle = 'Not found';
		$codeMessage = 'The requested resource could not be found but may be available again in the future.';
	}
	else
	{
		$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Sorry, you are trying to access an invalid URL</div>';
		$pageName = 'process';
	}
}
require('views/index.phtml');
?>