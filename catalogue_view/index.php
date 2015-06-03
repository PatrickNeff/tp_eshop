<?php

$amount = "";
if (isset($_POST['amount'])) { $login = $_POST["amonut"];}

	// si on a choisis un produit, il faudras aller sur la fiche produit
	if (!empty($_GET['id_product'])) 
	{

		$selectsc3 = $db->query("SELECT COUNT(*)            as nbRowsP,
			                            id_product          as myproduct3_idproduct,
										product.name        as myproduct3_name,
										product.description as myproduct3_description,
										sub_category_id     as myproduct3_subcategoryid,
										price               as myproduct3_price,
										image               as myproduct3_image,
										origine             as myproduct3_origine, 
										stock_quantity      as myproduct3_stockquantity,
										note_id             as myproduct3_noteid,
										sub_category.name   as myproduct3_subcategoryname
								FROM    sub_category, product 
								WHERE   id_sub_category = sub_category_id
								AND	    id_product = ".$_GET['id_product'] )->fetch(PDO::FETCH_ASSOC);
								    // id_sub_category = ".$_GET['id_subcategory'])->fetch(PDO::FETCH_ASSOC);

		if ($selectsc3['nbRowsP'] < 1)
		{ 
			$message = "anomalie : aucune produit correspondant";
		}
		else if ($selectsc3['nbRowsP'] > 0)
		{
			require('index.phtml');	
			//echo '<table><tr><td><a href="index.php?page=catalogue_view&amp;id_product='.$selectsc3['myproduct3_idproduct'].'">'.$selectsc3['myproduct3_name'].'</a></td></tr></table>';
		}
			
	} 

?>