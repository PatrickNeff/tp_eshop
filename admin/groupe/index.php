<?php
require('./admin/menu.php');
$groupId = '';
$groupName = '';
$groupDesc = '';
$formAction = 'create_group';
$formActionText = 'Créer un groupe';
$formActionTitle = 'Créer un nouveau groupe';
$message = ''; // Contient les messages d'erreur à afficher
// ============== Formulaire Sélection groupe
if (!empty($_POST['action']) AND $_POST['action'] == 'select_group') // Si le formulaire est validé
{
	if (!empty($_POST['id']))
	{
	$selectGroup = $db->query('SELECT id_permission, name, description FROM permission WHERE id_permission = '.$_POST['id'])->fetch(PDO::FETCH_ASSOC);
	$groupId = $selectGroup['id_permission'];
	$groupName = strip_tags($selectGroup['name']);
	$groupDesc = strip_tags($selectGroup['description']);
	$formAction = 'update_group';
	$formActionText = 'Editer le groupe';
	$formActionTitle = 'Editer le groupe';
	}
	else
	{
		$message = '<div class="alert alert-danger" role="alert">Vous devez sélectionner un groupe</div>';
	}	
}
// ============== Formulaire Creation de groupe
if (!empty($_POST['action']) AND $_POST['action'] == 'create_group') // Si le formulaire est validé
{
	if (!empty($_POST['name']) AND !empty($_POST['description'])) // Si les champs requis sont remplis
	{
		// Suppression espaces et balises HTML
		$name = trim($_POST['name']);
		$description = trim($_POST['description']);
		// Sécurité
		$name = $db->quote($name);
		$description = $db->quote($description);
		// INSERT SQL
		$insert = 'INSERT INTO permission (name, description) VALUES ('.$name.','.$description.')';
		$db->exec($insert);
		$_SESSION['message'] = '<div class="alert alert-success" role="alert">Le groupe a été créé avec succès ! <a href="'.$_SERVER['HTTP_REFERER'].'">Revenir à la page précédente</a></div>';
		header('Location: index.php?page=process');
	}
	else
	{
		$message = '<div class="alert alert-danger" role="alert">Tous les champs sont obligatoires pour créer un groupe.</div>';
	}
}
// ============== Formulaire Update de groupe
if (!empty($_POST['action']) AND $_POST['action'] == 'update_group') // Si le formulaire est validé
{
	if (!empty($_POST['name']) AND !empty($_POST['description'])) // Si les champs requis sont remplis (normalement oui)
	{
		// Suppression espaces et balises HTML
		$name = trim($_POST['name']);
		$description = trim($_POST['description']);
		// Sécurité
		$name = $db->quote($name);
		$description = $db->quote($description);
		// UPDATE SQL
		$update = 'UPDATE permission SET name = '.$name.', description = '.$description.' WHERE id_permission = '.$_POST['groupId'];
		$db->exec($update);
		$_SESSION['message'] = '<div class="alert alert-success" role="alert">Le groupe a été mis à jour avec succès ! <a href="'.$_SERVER['HTTP_REFERER'].'">Revenir à la page précédente</a></div>';
		header('Location: index.php?page=process');
	}
	else
	{
		$message = '<div class="alert alert-danger" role="alert">Tous les champs sont obligatoires pour mettre à jour un groupe.</div>';
	}		
}
// Requête pour sélection des groupes et affichage de la liste
$selectList = $db->query('SELECT id_permission, name, description FROM permission ORDER BY name DESC')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop($selectList)
{
	foreach ($selectList as $row)
	{
		$name = strip_tags($row['name']);
		$desc = strip_tags($row['description']);
		require('admin/groupe/displayLoop.phtml');
	}
}
require('./admin/menu.phtml');
require('./admin/groupe/index.phtml');
?>