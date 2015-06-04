<?php

$json = array('error' => true);
if(isset($_GET['id'])){
	$product = $db->query('SELECT order.id FROM order WHERE id=3');
	if(empty($product)){
		echo "Il n'y a pas d'article dans le panier";
	}else{
		$panier['add($order[0][id])'];
		echo 'Le produit a bien ete ajoute a votre panier';
	}
}else{
	echo "Vous n'avez pas selectionne de produit a ajouter au panier";
}

?>
