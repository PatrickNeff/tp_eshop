<?php
//  selection des articles de la sous-catégorie à afficher
	$selectsc = $db->query("SELECT sub_category.name, product.id_product, product.name, product.price, product.image, product.origine, product.stock_quantity FROM sub_category, product WHERE id_sub_category = sub_category_id and  id_sub_category = ".$_POST['id_sub_category'])->fetchAll(PDO::FETCH_ASSOC);
	foreach ($selectsc as $row)
	{
		$sub_category_name = $row['sub_category.name'];
		$id_product = $row['product.id_product'];
		$product_name = $row['product.name'];
		$product_price = $row['product.price'];


		/* si non trouvé on mets l'image non trouvé */
		if ($row['product.image'] == "")
		{
			$product_image = "images/missing.jpg";
		}
		else
		{
			$product_image = $row['product.image'];
		}


		$product_origine = $row['product_origine'];
		$product_stock_quantity = $row['product_stock_quantity'];
	}
	require('./views/catalog-view.phtml');
?>