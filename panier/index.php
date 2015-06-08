<?php


if(isset($_GET['order_id'])){
	// Chemin de la requète & jointure.
	$request = "SELECT *
				FROM `orders` os
				JOIN `order_item` oi
				ON os.`id`= oi.`id_order` WHERE id_order=".$_GET['order_id'];
	//order_id = données transmises lors de l'ajout au panier

	// Récupération des données dans un tableau.
	$order = $db->query($request)->fetchAll(PDO::FETCH_ASSOC);


	// Si les données que l'on récupère ont un status qui est égal à deux,...
	if($order[!NULL]['status'] == 2){
		// ... Alors on récupère tous les tableaux :
		$i = 0;
		// Tant que $i est inférieur à la longueur du tableau...
		while($i < sizeof($order))
		{
			// ... On affiche :
			$id_product = $order[$i]["id_product"];
			$weight = $order[$i]["weight"];
			$price_per_kilo = $order[$i]["price_per_kilo"];
			$price_total = $order[$i]["price_total"];
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


?>