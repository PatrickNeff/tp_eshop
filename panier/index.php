<?php

if(isset($_GET['order_id']))
{
	// Chemin de la requète & jointure.

	$request = "SELECT *, oi.id AS my_id
				FROM `order_item` oi
				JOIN `orders` os
				ON os.`id`= oi.`id_order` 
				JOIN `product` po
				ON po.`id_product`=oi.`id_product` WHERE os.status = '2' AND id_order=".$_GET['order_id'];
	//order_id = données transmises lors de l'ajout au panier
	// var_dump($request);
	// Récupération des données dans un tableau.
	$order = $db->query($request)->fetchAll(PDO::FETCH_ASSOC);

	// var_dump($order);

	// Si les données que l'on récupère ont un status qui est égal à deux,...

		$i = 0;
		$super_total =0;
		// Tant que $i est inférieur à la longueur du tableau...
		while($i < sizeof($order))
		{
			// ... On affiche :
			$my_id = $order[$i]["my_id"];
			$id_product = $order[$i]["id_product"];
			$name = $order[$i]["name"];
			$weight = number_format($order[$i]["weight"],3,',',' ');
			$price_per_kilo = number_format($order[$i]["price_per_kilo"],2,',',' ');
			$price_total = number_format($order[$i]["price_total"],2,',',' ');
			$super_total = number_format($super_total + $price_total,2,',',' ');
			$i++;
			require("panier/panier.phtml");
		}

	require ("panier/index.phtml");

}
else{
	echo "Vous n'avez pas sélectionné de produit à ajouter au panier";
}

// On vérifie  que $_GET['action'] (défini dans le formulaire de panier.phtml) existe.
if (isset($_GET['action']))
{
	// Si $_GET['action'] existe, et qu'il a en paramètre 'annuler'...
	if ($_GET['action'] == 'annuler')
	{
		// ... alors on redirige vers panier/annuler.php
		require('panier/annuler.php');
	}
}

?>