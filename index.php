<?php
require('apps/config.php');
session_start();

try
{
	$db = new PDO('mysql:dbname='.$dbname.';host='.$host.';charset='.$charset, $dblogin, $dbpwd);
	$db->exec("SET CHARACTER SET utf8");
}
catch(Exception $get)
{
	print_r($get);
	die();
}

$db = new PDO("mysql:dbname=eshop;host=127.0.0.1", 'root', 'troiswa',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Sélection des permissions à chaque chargement de page en cas de modification
if (isset($_SESSION['auth']))
{
	$selectPermissions = $db->query("SELECT permission.perms FROM permission JOIN client ON client.permission_id = permission.id_permission WHERE client.id = ".$_SESSION['id'])->fetch(PDO::FETCH_ASSOC);
	$_SESSION['permissions'] = $selectPermissions['perms'];
}
// Déconnexion
if (isset($_GET['session']) && $_GET['session'] == 'logout')
{
	$db->exec("UPDATE client SET time_update = NOW() WHERE id = ".$_SESSION['id']); // Update date dernière visite du membre
	$_SESSION = array(); // Destruction des variables de session
	session_destroy(); // Destruction de la session
	$_SESSION['message'] = '<div class="alert alert-success" role="alert">Vous êtes maintenant déconnecté</div>';
}
// Liste des fonctions principales
require('apps/functions.php');
// Page exécutée en...
$displayStart = generation();

// Chemin absolu et configuration serveur
$path = 'http://'.$_SERVER['SERVER_NAME'].'/ecommerce/';
// Codes HTTP
$httpCode = http_response_code();
// Gestion des pages du site (MVC)
$page = array('home','login','register','admin','catalogue','profile','search','panier','process','error','catalogue_view','note','ajout_panier', 'validation_panier', 'validation_panier_view');

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