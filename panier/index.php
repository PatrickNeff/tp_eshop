<?php

if(isset($_GET['order_id'])){
	// Chemin de la requète & jointure.
	$request = "SELECT *
				FROM `order_item` oi
				JOIN `orders` os
				ON os.`id`= oi.`id_order` 
				JOIN `product` po
				ON po.`id_product`=oi.`id_product` WHERE id_order=".$_GET['order_id'];
	//order_id = données transmises lors de l'ajout au panier
	// var_dump($request);
	// Récupération des données dans un tableau.
	$order = $db->query($request)->fetchAll(PDO::FETCH_ASSOC);

	// var_dump($order);

	$request = $db->query("SELECT * FROM orders WHERE id=".$_GET['order_id']);
	// ajouter le status de la commande


	// Si les données que l'on récupère ont un status qui est égal à deux,...
	if($order[!NULL]['status'] == 2){
		// ... Alors on récupère tous les tableaux :
		$i = 0;
		$super_total =0;
		// Tant que $i est inférieur à la longueur du tableau...
		while($i < sizeof($order))
		{
			// ... On affiche :
			$id_product = $order[$i]["name"];
			$weight = number_format($order[$i]["weight"],3,',',' ');
			$price_per_kilo = number_format($order[$i]["price_per_kilo"],2,',',' ');
			$price_total = number_format($order[$i]["price_total"],2,',',' ');
			$super_total = number_format($super_total + $price_total,2,',',' ');
			$i++;
			require("panier/panier.phtml");
		}

	require ("panier/index.phtml");
	}
	else
	{
		echo "Il n'y a pas de commande ayant cet ID";
	}
}else{
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