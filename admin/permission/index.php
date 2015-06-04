<?php
require('./admin/menu.php');
$message ='';
// Requête pour sélection des groupes et affichage de la liste
$selectList = $db->query('SELECT id_permission, name, description, perms FROM permission ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop($selectList)
{
	foreach ($selectList as $row)
	{
		$select_c = '';
		$select_ea = '';
		$select_sa = '';
		$select_ap = '';
		$select_ept = '';
		$select_sp = '';
		$select_es = '';
		$select_epx = '';
		$select_ec = '';
		$select_epn = '';
		if (!($row['perms'] & CLIENT))
		{
			$select_c = ' selected';
		}
		if (!($row['perms'] & EDITER_AVIS))
		{
			$select_ea = ' selected';
		}
		if (!($row['perms'] & SUPPRIMER_AVIS))
		{
			$select_sa = ' selected';
		}
		if (!($row['perms'] & AJOUTER_PRODUIT))
		{
			$select_ap = ' selected';
		}
		if (!($row['perms'] & EDITER_PRODUIT))
		{
			$select_ept = ' selected';
		}
		if (!($row['perms'] & SUPPRIMER_PRODUIT))
		{
			$select_sp = ' selected';
		}
		if (!($row['perms'] & EDITER_STOCK))
		{
			$select_es = ' selected';
		}
		if (!($row['perms'] & EDITER_PRIX))
		{
			$select_epx = ' selected';
		}
		if (!($row['perms'] & EDITER_CLIENT))
		{
			$select_ec = ' selected';
		}
		if (!($row['perms'] & EDITER_PERMISSION))
		{
			$select_epn = ' selected';
		}
		require('./admin/permission/displayLoop.phtml');
	}
}
// Formulaire modification des permissions
if (!empty($_POST['action']) AND $_POST['action'] == 'update_permissions') // Si le formulaire est validé
{
	if (!empty($_POST['groupId']))
	{
		$groupId = $_POST['groupId'];
		$permissions = '';
		if ($_POST['c'.$groupId] == 'yes')
		{
			$permissions |= CLIENT;
		}
		else
		{
			$permissions &= ~CLIENT;
		}
		if ($_POST['ea'.$groupId] == 'yes')
		{
			$permissions |= EDITER_AVIS;
		}
		else
		{
			$permissions &= ~EDITER_AVIS;
		}
		if ($_POST['sa'.$groupId] == 'yes')
		{
			$permissions |= SUPPRIMER_AVIS;
		}
		else
		{
			$permissions &= ~SUPPRIMER_AVIS;
		}
		if ($_POST['ap'.$groupId] == 'yes')
		{
			$permissions |= AJOUTER_PRODUIT;
		}
		else
		{
			$permissions &= ~AJOUTER_PRODUIT;
		}
		if ($_POST['ept'.$groupId] == 'yes')
		{
			$permissions |= EDITER_PRODUIT;
		}
		else
		{
			$permissions &= ~EDITER_PRODUIT;
		}
		if ($_POST['sp'.$groupId] == 'yes')
		{
			$permissions |= SUPPRIMER_PRODUIT;
		}
		else
		{
			$permissions &= ~SUPPRIMER_PRODUIT;
		}
		if ($_POST['es'.$groupId] == 'yes')
		{
			$permissions |= EDITER_STOCK;
		}
		else
		{
			$permissions &= ~EDITER_STOCK;
		}
		if ($_POST['epx'.$groupId] == 'yes')
		{
			$permissions |= EDITER_PRIX;
		}
		else
		{
			$permissions &= ~EDITER_PRIX;
		}
		if ($_POST['ec'.$groupId] == 'yes')
		{
			$permissions |= EDITER_CLIENT;
		}
		else
		{
			$permissions &= ~EDITER_CLIENT;
		}
		if ($_POST['epn'.$groupId] == 'yes')
		{
			$permissions |= EDITER_PERMISSION;
		}
		else
		{
			$permissions &= ~EDITER_PERMISSION;
		}
		$update = 'UPDATE permission SET perms = '.$permissions.' WHERE id_permission = '.$groupId;
		$db->exec($update);
		$_SESSION['message'] = '<div class="alert alert-success" role="alert">Les permissions ont été mises à jour. <a href="'.$_SERVER['HTTP_REFERER'].'">Revenir à la page</a>.</div>';
		header('Location: index.php?page=process');
	}
	else
	{
		$message = '<div class="alert alert-danger" role="alert">Vous devez sélectionner un groupe pour mettre à jour les permissions associées.</div>';
	}
}
require('./admin/menu.phtml');
require('./admin/permission/index.phtml');
?>