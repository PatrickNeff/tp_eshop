<?php
require('apps/config.php');
session_start();
try
{
	$db = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset='.DB_CHARSET, DB_USER, DB_PASS);
	$db->exec("SET CHARACTER SET utf8");
}
catch(Exception $get)
{
	print_r($get);
	die();
}
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
// =====>	CODE MOCHE	<=====
//*********************************************
if (isset($_GET['ajax']))
{
	$pageName = $_GET['ajax'];
	require($pageName.'/index.php');
	die();
}
//*********************************************
// Codes HTTP
$httpCode = http_response_code();
// Gestion des pages du site (MVC)
if (isset($_GET['page']))
{
	$page = array('home','login','register','admin','catalogue','profile','search','panier','process','error','catalogue_view','note');
	if (in_array($_GET['page'],$page))
	{
		if (isset($_GET['admin']))
		{
			$admin = array('permission','groupe','stock');
			if (in_array($_GET['admin'],$admin))
			{
				$pageName = $_GET['page'].'/'.$_GET['admin'];
			}
			else
			{
				$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Désolé, la page d\'administration que vous recherché n\'existe pas.</div>';
				$pageName = 'process';
			}
		}
		else
		{
			$pageName = $_GET['page'];
		}
	}
	else
	{
		$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Désolé, la page que vous recherchez n\'existe pas.</div>';
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
		$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Désolé, l\'URL demandée n\'existe pas.</div>';
		$pageName = 'process';
	}
}
require('views/index.phtml');
?>