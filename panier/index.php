<?php

if(isset($_GET['order_id'])){

	$request = $db->query("SELECT * FROM orders WHERE id=".$_GET['orders_id'] AND $_GET['orders_id'] = 2);
	

	$order = $db->query($request)->fetch(PDO::FETCH_ASSOC);
	if(empty($order) || $order['status'] == 0 || $order['status'] == 1){
		echo "Il n'y a pas d'article dans le panier";
	}else{
		$panier[add($status[1])];
		echo 'Le produit a bien été ajouté à votre panier';

	}
}else{
	echo "Vous n'avez pas sélectionné de produit à ajouter au panier";
}
require ("panier/index.phtml");
?>