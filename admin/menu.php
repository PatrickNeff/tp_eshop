<?php
if (!isset($_SESSION['auth']))
{
	header('Location: index.php?page=home');
	die();
}
else
{
	if (!($_SESSION['permissions'] & AJOUTER_PRODUIT)
	 AND !($_SESSION['permissions'] & EDITER_PRODUIT)
	 AND !($_SESSION['permissions'] & SUPPRIMER_PRODUIT)
	 AND !($_SESSION['permissions'] & EDITER_STOCK)
	 AND !($_SESSION['permissions'] & EDITER_PRIX)
	 AND !($_SESSION['permissions'] & EDITER_CLIENT)
	 AND !($_SESSION['permissions'] & EDITER_PERMISSION))
	{
		header('Location: index.php?page=home');
		die();
	}
}
$permissionsLinks = '';
if ($_SESSION['permissions'] & AJOUTER_PRODUIT)
{
	$permissionsLinks .= '<a href="./index.php?page=admin_manage_contact" class="alert-link">Ajouter un produit</a> | ';
}
if ($_SESSION['permissions'] & EDITER_PRODUIT)
{
	$permissionsLinks .= '<a href="./index.php?page=admin_manage_contact" class="alert-link">Editer un produit</a> | ';
}
if ($_SESSION['permissions'] & SUPPRIMER_PRODUIT)
{
	$permissionsLinks .= '<a href="./index.php?page=admin_manage_contact" class="alert-link">Supprimer un produit</a> | ';
}
if ($_SESSION['permissions'] & EDITER_STOCK)
{
	$permissionsLinks .= '<a href="./index.php?page=admin_manage_contact" class="alert-link">Editer les stocks</a> | ';
}
if ($_SESSION['permissions'] & EDITER_PRIX)
{
	$permissionsLinks .= '<a href="./index.php?page=admin_manage_contact" class="alert-link">Editer les prix</a> | ';
}
if ($_SESSION['permissions'] & EDITER_CLIENT)
{
	$permissionsLinks .= '<a href="./index.php?page=admin_manage_contact" class="alert-link">Editer un profil client</a> | ';
}
if ($_SESSION['permissions'] & EDITER_PERMISSION)
{
	$permissionsLinks .= '<a href="./index.php?page=admin&amp;admin=permission" class="alert-link">Editer les permissions</a> | <a href="./index.php?page=admin&amp;admin=groupe" class="alert-link">Editer les groupes</a>';
}
?>