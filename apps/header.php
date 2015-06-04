<?php
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true)
{
	$logLink = '<li class="navbar-login-profile"><a href=index.php?page=profile&amp;id='.$_SESSION['id'].'>Profil</a></li><li class="navbar-logout"><a href=index.php?page=process&amp;session=logout>Logout [ '.$_SESSION['login'].' ]</a></li>';
}
else
{
	$logLink = '<li class="navbar-login-profile"><a href=index.php?page=login>Se connecter</a></li><li class="navbar-register"><a href=index.php?page=register>S\'enregistrer</a></li>';
}
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true)
{
	if (($_SESSION['permissions'] & AJOUTER_PRODUIT)
	 OR ($_SESSION['permissions'] & EDITER_PRODUIT)
	 OR ($_SESSION['permissions'] & SUPPRIMER_PRODUIT)
	 OR ($_SESSION['permissions'] & EDITER_STOCK)
	 OR ($_SESSION['permissions'] & EDITER_PRIX)
	 OR ($_SESSION['permissions'] & EDITER_CLIENT)
	 OR ($_SESSION['permissions'] & EDITER_PERMISSION))
	{
		$logLink .= '<li class="navbar-admin"><a href=index.php?page=admin>Admin</a></li>';
	}
}
require('./views/header.phtml');
?>