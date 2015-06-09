<?php
// Sélection derniers produits
$displayLastProd = $db->query('SELECT id_product, name, description, origine FROM product ORDER BY id_product DESC LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop1($displayLastProd)
{
	foreach ($displayLastProd as $row)
	{
		$name = strip_tags($row['name']);
		$desc = nl2br(strip_tags($row['description']));
		$origin = strip_tags($row['origine']);
		$id_product = $row['id_product'];
		require('home/displayLastProd.phtml');
	}
}
//Sélection produits stock bas
$displayLowStock = $db->query('SELECT id_product, name, stock_quantity FROM product WHERE stock_quantity <= 10 AND stock_quantity > 0 ORDER BY stock_quantity DESC')->fetchAll(PDO::FETCH_ASSOC);
function displayLoop2($displayLowStock)
{
	foreach ($displayLowStock as $row)
	{
		$name = strip_tags($row['name']);
		$stock = $row['stock_quantity'];
		$id_product = $row['id_product'];
		require('home/displayLowStock.phtml');
	}
}
require('./home/index.phtml');
?>