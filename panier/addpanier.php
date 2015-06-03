<?php
// require 'db.class.php';
require 'panier.class.php';
$db = new db();
$panier = new panier($db);
?>
<?php
$json = array('error' => true);
if(isset($_GET['id'])){
	$product = $db->query('SELECT id FROM products WHERE id=:id', array('id' => $_GET['id']));
	if(empty($product)){
		$json['message'] = "Ce produit n'existe pas";
	}else{
		$panier['add($product[0][id])'];
		$json['error']  = false;
		$json['total']  = $panier['total()'];
		$json['count']  = $panier['count()'];
		$json['message'] = 'Le produit a bien été ajouté à votre panier';
	}
}else{
	$json['message'] = "Vous n'avez pas sélectionné de produit à ajouter au panier";
}
echo json_encode($json);
?>