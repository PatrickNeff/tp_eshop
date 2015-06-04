<?php
require('./admin/menu.php');
$message = ''; // Contient les messages d'erreur à afficher
// Requête pour sélection des groupes et affichage de la liste
$selectList = $db->query('SELECT id_product, name, description, stock_quantity FROM product ORDER BY name DESC')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop($selectList)
{
	foreach ($selectList as $row)
	{
		$name = strip_tags($row['name']);
		$desc = strip_tags($row['description']);
		$stock = strip_tags($row['stock_quantity']);
		require('admin/stock/displayLoop.phtml');
	}
}
require('./admin/menu.phtml');
require('./admin/stock/index.phtml');
?>