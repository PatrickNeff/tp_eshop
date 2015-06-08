<?php
require('./admin/menu.php');
$message = ''; // Contient les messages d'erreur à afficher
// Sélection et suppression des membres
if (!empty($_POST['action']) AND $_POST['action'] == 'edit_stock') // Si on demande de supprimer des membres
{
	// Vérif variable stock vide ???
	// Début de requête avec condition bidon
	// Listing de la table
	if (isset($_POST['id']) AND !empty($_POST['id'])) // S'il y a bien des éléments sélectionnés is_array($_POST['id']) AND 
	{
		$i = 0;
		$emptyElem = array();
		while ($i < count($_POST['id']))
		{
			if (!empty($_POST['stock'][$i]))
			{
				$db->exec('UPDATE product SET stock_quantity='.$_POST['stock'][$i].' WHERE id_product = '.$_POST['id'][$i]);
			}
			else
			{
				$selectName = $db->query('SELECT name FROM product WHERE id_product = '.$_POST['id'][$i])->fetch(PDO::FETCH_ASSOC);
				$emptyElem[] = $selectName['name'];
			}
			$i++;
		}
		$_SESSION['message'] = '<div class="alert alert-success" role="alert"><p>Les stocks ont été mis à jour avec succès !<br>Mais les éléments suivants n\'ont pas été mis à jour :<br>';
		if (count($emptyElem) > 0)
		{
	        foreach ($emptyElem as $key=>$val)
	        {
	            $_SESSION['message'] .= $emptyElem[$key].'<br>';
	        }
		}
		$_SESSION['message'] .= '</p><p><a href="'.$_SERVER['HTTP_REFERER'].'">Revenir à la page</a></p></div>';
		header('Location: ./index.php?page=process');
		die();
	}
	else
	{
		$message = '<div class="alert alert-danger" role="alert">Vous devez sélectionner des éléments pour mettre à jour leur stock.</div>';
	}
}
// Requête pour sélection des groupes et affichage de la liste
$selectList = $db->query('SELECT id_product, name, description, stock_quantity FROM product ORDER BY name DESC')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop($selectList)
{
	foreach ($selectList as $row)
	{
		$name = strip_tags($row['name']);
		$desc = strip_tags($row['description']);
		$stock = strip_tags($row['stock_quantity']);
		$id_product = $row['id_product'];
		require('admin/stock/displayLoop.phtml');
	}
}
require('./admin/menu.phtml');
require('./admin/stock/index.phtml');
?>