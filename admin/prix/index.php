<?php
require('./admin/menu.php');
$message = ''; // Contient les messages d'erreur à afficher
// Sélection et suppression des membres
if (!empty($_POST['action']) AND $_POST['action'] == 'edit_price') // Si on demande de supprimer des membres
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
			if (!empty($_POST['price'][$i]))
			{
				if (is_numeric($_POST['price'][$i]))
				{
					$db->quote($_POST['price'][$i]);		
					$db->exec('UPDATE product SET price='.$_POST['price'][$i].' WHERE id_product = '.$_POST['id'][$i]);
				}
				else
				{
					$selectName = $db->query('SELECT name FROM product WHERE id_product = '.$_POST['id'][$i])->fetch(PDO::FETCH_ASSOC);
					$emptyElem[] = $selectName['name'];
				}
			}
			else
			{
				$selectName = $db->query('SELECT name FROM product WHERE id_product = '.$_POST['id'][$i])->fetch(PDO::FETCH_ASSOC);
				$emptyElem[] = $selectName['name'];
			}
			$i++;
		}
		$_SESSION['message'] = '<div class="alert alert-success" role="alert"><p>Les prix ont été mis à jour avec succès !';
		if (count($emptyElem) > 0)
		{
			$_SESSION['message'] .= '<br>Mais les éléments suivants n\'ont pas été mis à jour (car vide ou pas un nombre) :<br>';
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
		$message = '<div class="alert alert-danger" role="alert">Vous devez sélectionner des éléments pour mettre à jour leur prix.</div>';
	}
}
// Requête pour sélection des groupes et affichage de la liste
$selectList = $db->query('SELECT id_product, name, description, price FROM product ORDER BY name DESC')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop($selectList)
{
	foreach ($selectList as $row)
	{
		$name = strip_tags($row['name']);
		$desc = strip_tags($row['description']);
		$price = strip_tags($row['price']);
		$id_product = $row['id_product'];
		require('admin/prix/displayLoop.phtml');
	}
}
require('./admin/menu.phtml');
require('./admin/prix/index.phtml');
?>